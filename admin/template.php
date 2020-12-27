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

if(empty($type)) $type = "index";

echo '<script type="text/javascript">
function styles(){
var id = f1.style.value;
var tmp = f1.tmp_choice.value;
 window.location="cp_home.php?mode=template&type=template&id="+id+"&aid="+tmp;
}
function add_tmp(){
 window.location="cp_home.php?mode=template&type=add_template";
}
function download_style(){
var id = f1.style.value;
 window.location="./style_done.php?id="+id;
}
function up_style(){
 window.location="cp_home.php?mode=template&type=up";
}
</script>';
echo'
<table class="optionsbar" dir="rtl" cellSpacing="1" width="100%" border="0"><tr>
<td class="optionheader_selected" align="center" width="100%">
<font size="4"><b>التحكم بالاستايلات - القوالب</b></font></td></tr>';

if($type == "index"){

        $ch_style = $mysql->execute("SELECT * FROM {$mysql->prefix}STYLE ", [], __FILE__, __LINE__);
        $style_num = mysql_num_rows($ch_style);

echo '<tr><td class="f1" align="center" width="100%"><br>';


echo'
            <form name="f1" method="post" action="#">
            <select class="insidetitle" name="style">';


            $style_i = 0;
            while ($style_i < $style_num){

                $style_file_name = mysql_result($ch_style, $style_i, "S_FILE_NAME");
                $style_name = mysql_result($ch_style, $style_i, "S_NAME");

                echo'<option value="'.$style_file_name.'" '.check_select($choose_style, $style_file_name).'>'.$style_name.'</option>';

            ++$style_i;
            }



            echo'
            </select>&nbsp;<select class="insidetitle" name="tmp_choice">';
$tmp = $mysql->execute("SELECT DISTINCT NAME FROM {$mysql->prefix}TEMPLATES ORDER BY NAME ", [], __FILE__, __LINE__);

for($i =0;$i < mysql_num_rows($tmp);$i++){
$tm = mysql_fetch_array($tmp);
$sq = mysql_fetch_array($mysql->execute("SELECT * FROM {$mysql->prefix}TEMPLATES WHERE NAME = '$tm[NAME]' "));
echo '<option value="'.$sq['ID'].'">'.$tm['NAME'].'</option>';
}

echo '
</select>&nbsp;<input type="button" value="ادهب" onclick="styles();">&nbsp;<input type="button" value="اضف قالب" onclick="add_tmp();">
&nbsp;<input type="button" value="رفع استايل" onclick="up_style();">&nbsp;<input type="button" value="تنزيل الاستايل" onclick="download_style();">
            </form>';

echo '</td></tr>';
}

if($type == "template"){
$search = <<<EOD
<script language="JavaScript">

function del_tmp(id){
var are_you_sure = "هل انت متأكد من انك تريد حدف هدا القالب";
var are_you_sure2 = "برجاء التأكد ؟";
if(confirm(are_you_sure)){
if(confirm(are_you_sure2)){
 window.location="cp_home.php?mode=template&type=del&id="+id;
}}
}

var NS4 = (document.layers); // Which browser?
var IE4 = (document.all);

var win = window; // window to search.
var n= 0;

function findInPage(str){

  var txt, i, found;
  if(str == "")
 return false;

  // Find next occurance of the given string on the page, wrap around to the
  // start of the page if necessary.

  if(NS4){

 // Look for match starting at the current point. If not found, rewind
 // back to the first match.

 if(!win.find(str))
while(win.find(str, false, true))
  n++;
 else
n++;

 // If not found in either direction, give message.

 if(n == 0)
alert("لم يتم ايجاد اي نتيجة");
  }

  if(IE4){
 txt = win.document.body.createTextRange();

 // Find the nth match from the top of the page.

 for (i = 0; i <= n && (found = txt.findText(str)) != false; i++){
txt.moveStart("character", 1);
txt.moveEnd("textedit");
 }

 // If found, mark it and scroll it into view.

 if(found){
txt.moveStart("character", -1);
txt.findText(str);
txt.select();
txt.scrollIntoView();
n++;
 }

 // Otherwise, start over at the top of the page and find first match.

 else {
if(n > 0){
  n = 0;
  findInPage(str);
}

// Not found anywhere, give message.

else
alert("لم يتم ايجاد اي نتيجة");
 }
  }

  return false;
}
</script>
<form name="search" onSubmit="return findInPage(this.string.value);">
<font size=3><input name="string" type="text" size=15 onChange="n = 0;"></font>
<input type="submit" value="بحث">
</form>
EOD;

$sql = mysql_fetch_array($mysql->execute("SELECT * FROM {$mysql->prefix}TEMPLATES WHERE ID = '$aid'"));
$template = stripslashes($sql['SOURCE']);
echo '<tr><td class="f2ts">
<table><tr><td>
'.$search.'
</td><td valign="top">
<form name="template" method="post" action="cp_home.php?mode=template&type=save&id='.$sql['STYLE_NAME'].'&aid='.$aid.'"> 
<input type="submit" name="submit" value="حفظ"> 
<input type="button" name="del" value="حدف" onclick="del_tmp('.$sql['ID'].')">   
</td>
<td valign="top" width="50%" align="left"><table><tr><td class="optionheader_selected">'.$sql['NAME'].'</td></tr></table></td>
</tr> 
</table>
<textarea style="width:790px;height:420px;overflow-x:hidden;direction:ltr;font-family:tahoma;font-size:12pt;font-style:bold"  name="tmp">'.$template.'</textarea>
<center><b><font size="2"><br>اضيف هدا القالب بواسطة : '.$sql['MEMBER'].' - بتاريخ <font color="green"> '.date("d/m/y",$sql['DATE']).'</font>
&nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp; اخر تعديل على هدا القالب تم بواسطة : '.$sql['LAST_MEMBER'].' - بتاريخ <font color="red">'.date("d/m/y",$sql['LAST_DATE']).'</font></font></b></center>
</form>
</td></tr>';
}

if($type == "save"){
$content = $_POST['tmp'];
$time = time();
$mysql->execute("UPDATE {$mysql->prefix}TEMPLATES SET SOURCE = '$content',LAST_DATE = '$time',LAST_MEMBER = '$CPUserName' WHERE ID = '$aid'", [], __FILE__, __LINE__);
$msg = "تم حفظ القالب بنجاح";

echo '<tr><td class="f2ts" align="center">
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br>
			<font color="#191970" size="5"><b>'.$msg.'</b></font><br><br>
<meta http-equiv="Refresh" content="3; URL=cp_home.php?mode=template&type=template&id='.$id.'&aid='.$aid.'">
			<a href="cp_home.php?mode=template&type=template&id='.$id.'&aid='.$aid.'">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br>&nbsp;
			</td>
		</tr>
	</table></td></tr>';
}
if($type == "del"){
$mysql->execute("DELETE FROM {$mysql->prefix}TEMPLATES WHERE ID = '$id' ", [], __FILE__, __LINE__);
echo '<meta http-equiv="Refresh" content="3; URL=cp_home.php?mode=template">';
echo '<tr><td class="f2ts" align="center">
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br>
			<font color="#191970" size="5"><b>تم حدف القالب بنجاح</b></font><br><br>
			<a href="cp_home.php?mode=template">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br>&nbsp;
			</td>
		</tr>
	</table></td></tr>';
}


if($type == "up"){
echo '<tr><td class="f2ts" align="center"><br>
<form name="template" method="post" action="cp_home.php?mode=template&type=save_up"> 
<input type="submit" name="submit" value="رفع">&nbsp;<select class="insidetitle" name="style">';
        $ch_style = $mysql->execute("SELECT * FROM {$mysql->prefix}STYLE ", [], __FILE__, __LINE__);
        $style_num = mysql_num_rows($ch_style);

            $style_i = 0;
            while ($style_i < $style_num){
                $style_file_name = mysql_result($ch_style, $style_i, "S_FILE_NAME");
                $style_name = mysql_result($ch_style, $style_i, "S_NAME");
                echo'<option value="'.$style_file_name.'">'.$style_name.'</option>';
            ++$style_i;
            }

echo '  </select><br><br><div align="right"><ul>';

            $style_i = 0;
            while ($style_i < $style_num){
 $style_file_name = mysql_result($ch_style, $style_i, "S_FILE_NAME");
$file = "styles/style_".$style_file_name.".xml";
$file2 = $style_file_name.".xml";
echo '<li>'.$style_file_name.' : ';

if(file_exists($file)){
echo '<font color="green">الملف '.$file2.' موجود</font>';
}else{
echo '<font color="red">الملف '.$file2.' غير موجود</font>';
}

echo '</li>';
++$style_i;
}
echo '</ul></div></form></td></tr>';

}
if($type == "save_up"){
$st = $_POST['style'];
xml_parser("styles/style_".$st.".xml");
$msg = "تم اضافة الاستايل بنجاح";
echo '<tr><td class="f2ts" align="center">
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br>
			<font color="#191970" size="5"><b>'.$msg.'</b></font><br><br>
			<a href="cp_home.php?mode=template&type=up">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br>&nbsp;
			</td>
		</tr>
	</table></td></tr>';
}

if($type == "add_template"){
echo '<tr><td class="f2ts">
<form name="template" method="post" action="cp_home.php?mode=template&type=add_save"> 
<input type="submit" name="submit" value="حفظ">&nbsp;<select class="insidetitle" name="style">
<option value="all">كل الاستايلات</option>';
        $ch_style = $mysql->execute("SELECT * FROM {$mysql->prefix}STYLE ", [], __FILE__, __LINE__);
        $style_num = mysql_num_rows($ch_style);

            $style_i = 0;
            while ($style_i < $style_num){
                $style_file_name = mysql_result($ch_style, $style_i, "S_FILE_NAME");
                $style_name = mysql_result($ch_style, $style_i, "S_NAME");
                echo'<option value="'.$style_file_name.'">'.$style_name.'</option>';
            ++$style_i;
            }

echo '  
</select>&nbsp;&nbsp;اسم القالب : <input type="text" name="title"><br><textarea style="width:790px;height:420px;overflow-x:hidden;direction:ltr;font-family:tahoma;font-size:12pt;font-style:bold"  name="tmp" cols="95" wrap="OFF">'.$template.'</textarea>

</form></td></tr>';
}

if($type == "add_save"){
$content = addslashes($_POST['tmp']);
$s_id = $_POST['style'];
$title = trim($_POST['title']);
$time = time();
if($s_id == "all"){
$ch_style = $mysql->execute("SELECT * FROM {$mysql->prefix}STYLE ", [], __FILE__, __LINE__);
while($r = mysql_fetch_array($ch_style)){
$t_itle = $r['S_FILE_NAME'];
$mysql->execute("INSERT INTO {$mysql->prefix}TEMPLATES SET SOURCE = '$content',OLD_SOURCE = '$content',NAME = '$title',DATE = '$time',MEMBER = '$CPUserName',LAST_DATE = '$time',LAST_MEMBER = '$CPUserName',STYLE_NAME = '$t_itle' ", [], __FILE__, __LINE__);
}
}else{ 
$mysql->execute("INSERT INTO {$mysql->prefix}TEMPLATES SET SOURCE = '$content',OLD_SOURCE = '$content',NAME = '$title',DATE = '$time',MEMBER = '$CPUserName',LAST_DATE = '$time',LAST_MEMBER = '$CPUserName',STYLE_NAME = '$s_id' ", [], __FILE__, __LINE__);
}

$msg = "تم اضافة القالب بنجاح";

echo '<tr><td class="f2ts" align="center">
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br>
			<font color="#191970" size="5"><b>'.$msg.'</b></font><br><br>
			<a href="cp_home.php?mode=template&type=template&id='.$s_id.'&aid='.$title.'">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br>&nbsp;
			</td>
		</tr>
	</table></td></tr>';
}

echo '</table>';
?>