<?php
/*//////////////////////////////////////////////////////////
// ######################################################///
// # DuhokForum 1.1                                     # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #   ========= Programming By Dilovan ==============  # //
// # Copyright © 2007-2009 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # If you want any support vist down address:-        # //
// # Email: df@duhoktimes.com                           # //
// # Site: http://df.duhoktimes.com/index.php           # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

if(mlv == 0){
redirect();
exit();
}

if(members("LIST", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][your_lists].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}


if(empty($type)) $type = "friends";


// ######################################### Some Setup ##########################################
function p_name($id){
$sql = mysql_fetch_array($mysql->execute("SELECT * FROM {$mysql->prefix}LIST WHERE ID = '$id' "));
$name = $sql['NAME'];
return $name;
}

if($type == "friends") $page_n = "قائمة الاصدقاء";
if($type == "bans") $page_n = "قائمة الممنوعين";
if($type == "show" AND $id) $page_n = p_name($id);

if($type == "friends") $page_id = "-1";
if($type == "bans") $page_id = "-2";
if($type == "show" AND $id) $page_id = $id;

// ########################################## Box Nav ################################################

function check_box($v1,$v2){
if($v1 == $v2){
$snow = "extras2";
}else{
$snow = "extras";
}
return $snow;
}

$c_id = $type;
$fr = "friends";
$bn = "bans";

if($type == "add" AND $c AND $aid){
$c_id = $c;
if($c_id == "-1") $fr = "-1";
if($c_id == "-2") $bn = "-2";
}


$s_nav = $mysql->execute("SELECT * FROM {$mysql->prefix}LIST WHERE M_ID = '".m_id."' AND NAME != '' ORDER BY ID ASC");
/*
while($nav = mysql_fetch_array($s_nav)){
$list_nav_bit .= $tmp->G_TMP("list_nav_bit");
}
*/
$tmp->display("list_nav");





// ############################################### Friends List #################################################"


if($type == "friends"){
$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}LIST_M WHERE M_ID = '".m_id."' AND CAT_ID = '-1' ");
$T_Page = '<font
 color="red" size="+1">قائمة الأصدقاء</font>';
$Desc = "<br>
هذه القائمة تحتوي على أعضاء تعتبرهم أصدقاء لك وتهتم بمشاركاتكم.<br>
لإضافة صديق لهذه القائمة إذهب الى صفحة بياناته وإضغط على وصلة إضافته
لقوائمك الخاصة.";
}
if($type == "bans"){
$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}LIST_M WHERE M_ID = '".m_id."' AND CAT_ID = '-2' ");
$T_Page = '<font
 color="red" size="+1">قائمة الممنوعين</font>';
$Desc = "<br>
لمنع عضو من إرسال رسائل خاصة لك أضفه لهذه القائمة بالذهاب لصفحة <br>
بياناته وإضغط على وصلة منعه من إرسال رسائل خاصة لك";
}
if($type == "show" AND $id){
$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}LIST_M WHERE M_ID = '".m_id."' AND CAT_ID = '$id' ");
$T_Page = '<font
 color="green" size="+1">'.p_name($id).'</font>';
$Desc = "<br>
هذه القائمة تحتوي على أعضاء تعتبرهم أصدقاء لك وتهتم بمشاركاتكم.<br>
لإضافة صديق لهذه القائمة إذهب الى صفحة بياناته وإضغط على وصلة إضافته
لقوائمك الخاصة.";
}

if($method == "index"){
if($type == "show" AND !p_name($id)) redirect();
       $m_list = $sql; 
$num = mysql_num_rows($sql);
function m_online($r_id){
global $Mlevel,$icon_online;
$online = member_is_online($r_id);
$browse = members("BROWSE",$r_id);

if($online == 1 AND $browse == 1 OR $online == 1  AND $Mlevel > 1){
$is_online = icons($icon_online);
}else{
$is_online = "&nbsp;";
}
return $is_online;
}

$tmp->display("list_index");
}


// ############################################### My Box Page #################################################

if($type == "my_box"){
$n_box = 10;

if(mlv == 1){
$max = $max_list_cat_members;
$n_box = $max;
}elseif(mlv == 2){
$max = $max_list_cat_moderators;
$n_box = $max;
}

echo '
<form action="index.php?mode=list&type=insert_box" method="post">
  <table class="grid" border="0" cellpadding="0" cellspacing="0" dir="rtl" width="300">
  
      <tr>
        <td>
        <table border="0" cellpadding="2"
 cellspacing="1" dir="rtl" width="100%">
            <tr class="normal">
              <td class="list_small" colspan="2"><font
color="red" size="+1">قوائم الأعضاء الخاصة بك</font><br>
لإضافة قوائم أعضاء خاصة بك<br>
أدخل عنواين لكل قائمة في الخانات أدناه</td>
            </tr>
            <tr>
              <td class="optionheader">رقم القائمة</td>
              <td class="optionheader"><nobr>&nbsp;عنوان
القائمة</nobr></td>
            </tr>';


$i=1;
while($i <= $n_box){
$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}LIST WHERE M_ID = '".m_id."' AND EDITFOLDER = '$i' ");
$r = mysql_fetch_array($sql);
           echo ' <tr class="fixed">
              <td class="optionheader">'.$i.'</td>
              <td class="list_small"><input
 value="'.$r['NAME'].'" name="editfolder'.$i.'"></td>
            </tr>';
$i++;
}
echo '
            <tr class="fixed">
              <td class="list_small" colspan="2"><br>
              <input value="أدخل التغييرات على قوائمك"
 type="submit"></td>
            </tr>
          <tr class="normal">
            <td class="list_small" colspan="2"><font
 color="red" size="+1">ملاحظة:</font><br>
لحذف أي قائمة أترك إسمها فارغا.</td>
          </tr>
        </table>
        </td>
      </tr>
  </table>
</form>';

}


// ############################################### My Box Page #################################################

if($type == "insert_box"){
$n_box = 10;

if(mlv == 1){
$max = $max_list_cat_members;
$n_box = $max;
}elseif(mlv == 2){
$max = $max_list_cat_moderators;
$n_box = $max;
}

$query_c = mysql_num_rows($mysql->execute("SELECT * FROM {$mysql->prefix}LIST WHERE M_ID = '".m_id."'"));

if($query_c > $max AND (mlv == 1 OR mlv == 2)){
go_to("index.php?mode=list&type=max&method=list");

exit();
}

for($i=1;$i<=$n_box;$i++){
$first = "editfolder".$i."";
$string = $_POST[$first];


if($string){

$sql_check = $mysql->execute("SELECT * FROM {$mysql->prefix}LIST WHERE M_ID = '".m_id."' AND EDITFOLDER = '$i' ");
// Sql
if(mysql_num_rows($sql_check) == 0){
$mysql->execute("INSERT INTO {$mysql->prefix}LIST SET M_ID = '".m_id."',EDITFOLDER = '$i',NAME = '$string' ");
}else{
$mysql->execute("UPDATE {$mysql->prefix}LIST SET NAME = '$string' WHERE EDITFOLDER = '$i' AND M_ID = '".m_id."' ");
}

}else{
$sql_check = mysql_num_rows($mysql->execute("SELECT * FROM {$mysql->prefix}LIST WHERE M_ID = '".m_id."' AND EDITFOLDER = '$i' "));
if($sql_check != 0){
$mysql->execute("UPDATE {$mysql->prefix}LIST SET NAME = '$string' WHERE EDITFOLDER = '$i' AND M_ID = '".m_id."' ");
}
}

// Bye Bye
}

go_to("index.php?mode=list&type=my_box");
}

// ############################################### Delete Member #################################################

if($type == "del"){

$sql_check = $mysql->execute("SELECT * FROM {$mysql->prefix}LIST_M WHERE M_ID = '".m_id."' AND USER = '$id' AND CAT_ID = '$c' ");
$r = mysql_fetch_array($sql_check);
$n = mysql_num_rows($sql_check);
if($n == 0){
redirect();
}else{
$ID = $r['ID'];
$mysql->execute("DELETE FROM {$mysql->prefix}LIST_M WHERE ID = '$ID' ", [], __FILE__, __LINE__);
go_to("index.php?mode=list&method=index");
}

}

// ############################################### Add Member #################################################

if($type == "add"){
if(!$aid OR !member_name($aid)) redirect();

echo '<form name="optionsForm" action="#" method="post">
  <table class="grid" border="0" cellpadding="0" cellspacing="0" dir="rtl" width="300">
      <tr>
        <td>
        <table border="0" cellpadding="2" cellspacing="1" dir="rtl" width="100%">
            <tr class="normal">
              <td class="list_small" colspan="2"><font
 color="red" size="+1">إضافة عضو لقوائمك الخاصة</font><br>
              </td>
            </tr>
            <tr class="fixed">
              <td class="h"><nobr>العضو الذي سيتم
إضافته</nobr></td>
              <td class="list_small"><font size="+1">'.member_name($aid).'</font></td>
            </tr>
            <tr class="fixed">
              <td class="h"><nobr>القائمة التي تريد
إضافة العضو لها</nobr></td>
              <td class="list_small">
              <select style="width: 200px;" size="1"
 name="list">
              <option value="-1" '.check_select($c,"-1").'>قائمةالأصدقاء</option>
              <option value="-2" '.check_select($c,"-2").'>قائمة الممنوعين</option>';
$nav = $mysql->execute("SELECT * FROM {$mysql->prefix}LIST WHERE M_ID = '".m_id."' AND NAME != '' ORDER BY ID ASC");
while($row = mysql_fetch_array($nav)){
$cat_id = $row['ID'];
$cat_n = $row['NAME'];
echo '<option value="'.$cat_id.'" '.check_select($c,"$cat_id").'>'.$cat_n.'</option>';
}
              
             echo ' </select>
              </td>
            </tr>
            <tr class="fixed">
              <td class="list_small" colspan="2"><br>
<input type="hidden" name="user" value="'.$aid.'">
<input value="أضف العضو للقائمة المختارة" type="submit" name="sub"></td>
            </tr>
        </table>
        </td>
      </tr>
  </table>
</form>';

if($_POST['sub']){
$user = intval(trim($_POST['user']));
$cat = $_POST['list'];

$s=mysql_num_rows($mysql->execute("SELECT * FROM {$mysql->prefix}LIST_M WHERE M_ID = '".m_id."' AND USER = '$user' AND CAT_ID = '$cat' "));
if($s != 0){
go_to("index.php?mode=list&type=error");

exit();
}

if(mlv == 1){
$max = $max_list_m_members;
}elseif(mlv == 2){
$max = $max_list_m_moderators;
}


$query_c = mysql_num_rows($mysql->execute("SELECT * FROM {$mysql->prefix}LIST_M WHERE M_ID = '".m_id."' AND CAT_ID = '$cat' "));

if($query_c > $max AND (mlv == 1 OR mlv == 2)){
go_to("index.php?mode=list&type=max&method=m");

exit();
}


$mysql->execute("INSERT INTO {$mysql->prefix}LIST_M SET M_ID = '".m_id."', USER = '$user', CAT_ID = '$cat' ");
go_to("index.php?mode=profile&id=$aid");
}


}



// ############################################### Error Add Member #################################################

if($type == "error"){

echo ' <br><table border="0" cellpadding="0" cellspacing="0" width="99%">
    <tr>
      <td>
      <form name="optionsForm" action="index.php?mode=list&">
        <table class="grid" border="0" cellpadding="0"cellspacing="0"  width="300">

            <tr>
              <td>
              <table border="0" cellpadding="2" cellspacing="1" width="100%">
                <tbody>
                  <tr class="normal">
                    <td class="list_small" colspan="5"><font
 color="green" size="+1">خطأ</font><br>
العضو الدي قمت باختياره لاضافته للقائمة لديك <br>
موجود مسبقا بها .
</td>
                  </tr>';

             echo ' </table></td></tr></table></form>
      </td>
    </tr></table>';

}


if($type == "max"){
if(method == "list"){
$msg= "لقد تجازوزت الحد المسموح لك من القوائم";
}
if(method == "m"){
$msg= "لقد تجازوزت الحد المسموح لك من الاعضاء في هده القائمة";
}
echo ' <br><table border="0" cellpadding="0" cellspacing="0" width="99%">
    <tr>
      <td>
        <table class="grid" border="0" cellpadding="0"cellspacing="0"  width="300">

            <tr>
              <td>
              <table border="0" cellpadding="2" cellspacing="1" width="100%">
                <tbody>
                  <tr class="normal">
                    <td class="list_small" colspan="5"><font
 color="green" size="+1">خطأ</font><br>
'.$msg.'
</td>
                  </tr>';

             echo ' </table></td></tr></table></form>
      </td>
    </tr></table>';

}

?>