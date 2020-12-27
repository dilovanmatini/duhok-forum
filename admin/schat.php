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

function save($msg,$link,$timeout = 1){
                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$msg.'</font><br><br>
                           <meta http-equiv="Refresh" content="'.$timeout.'; URL=cp_home.php?mode='.$link.'">
                           <a href="cp_home.php?mode='.$link.'">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}
function add_smile($smile,$code){
$check = mysql_fetch_array($mysql->execute("select * from {$mysql->prefix}chat_smile where url = '$url' "));
$check2 = mysql_fetch_array($mysql->execute("select * from {$mysql->prefix}chat_smile where code = '$code' "));
if($check OR $check2){
return false;
}else{
$mysql->execute("insert into {$mysql->prefix}chat_smile set url = '$smile',code = '$code' ");
return true;
}
}

if($type == "index"){
if(empty($method)) $method = "index";

if($method == "index"){
$mon_schat = explode("||",$forumid_mon_schat);
echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="85%">
<form method="post" action="cp_home.php?mode=schat&type=index&method=save_data">
	<tr class="fixed">
		<td class="cat" colspan="4"><nobr>اعدادات النقاش الحي</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>تفعيل النقاش الحي</nobr></td>
		<td class="userdetails_data"><input type="radio" value="1" name="active_schat" '.check_radio($active_schat, "1").'>نعم&nbsp;&nbsp;</td>
        <td class="userdetails_data"> <input type="radio" value="0" name="active_schat" '.check_radio($active_schat, "0").'>لا</td>
		<td class="userdetails_data" style="color:red"><nobr>اذا قمت بالضغط على لا سيتم اخفاء الايقونة الخاصة بالهيدر </nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عرض المتواجدون بالنقاش</nobr></td>
		<td class="userdetails_data"><input type="radio" value="1" name="num_schat" '.check_radio($num_schat, "1").'>نعم&nbsp;&nbsp;</td>
        <td class="userdetails_data"> <input type="radio" value="0" name="num_schat" '.check_radio($num_schat, "0").'>لا</td>
		<td class="userdetails_data" style="color:red"><nobr>اذا اخترت نعم سوف تظهر خانة في المنتدى <br> توضح عدد المتواجدون الان بالنقاش </nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>ظهور الايقونة للزوار</nobr></td>
		<td class="userdetails_data"><input type="radio" value="1" name="visitor_schat" '.check_radio($visitor_schat, "1").'>نعم&nbsp;&nbsp;</td>
        <td class="userdetails_data"> <input type="radio" value="0" name="visitor_schat" '.check_radio($visitor_schat, "0").'>لا</td>
		<td class="userdetails_data" style="color:red"><nobr>سيتم اخفاء الايقونة من الهيدر اذا ضغطت على لا </nobr></td>
	</tr>
<tr class="fixed">
		<td class="list"><nobr>تفعيل انشاء الصالات</nobr></td>
		<td class="userdetails_data"><input type="radio" value="1" name="active_room" '.check_radio($active_room, "1").'>نعم&nbsp;&nbsp;</td>
        <td class="userdetails_data"> <input type="radio" value="0" name="active_room" '.check_radio($active_room, "0").'>لا</td>
		<td class="userdetails_data" style="color:red"><nobr>اذا اخترت لا سوف يظهر عند الطلب ان الميزة معطلة حاليا </nobr></td>
	</tr>
<tr class="fixed">
		<td class="list" colspan="1">العدد الادنى من المشاركات للدخول الى النقاش</td>
<td class="list" colspan="3"><input type="text" value="'.$nbr_max_post_schat.'" name="nbr_max"> <font color="red">ضع الرقم صفر لتمجد الخدمة</font> </td>
	</tr>
<tr class="fixed">
		<td class="list" colspan="1">اضافة مسؤولين عن النقاش الحي <br><font color="red">امكانية حدف الصالات وطرد الاعضاء</font></td>
<td class="list" colspan="1"><input dir="ltr" type="text" value="'.$boss_schat.'" name="boss_schat"></td>
<td class="list" colspan="2" valign="top"> <nobr><font color="red">لاضافة اكثر من عضو قم بالفصل بينهم بفاصلة <font color="green">,</font><br> بين كل رقم عضوية واخر </nobr>|| سيحمل العضو بالنقاش الحي وصف : <font color="blue">مسؤول النقاش</font></font> </td>
	</tr>
<tr class="fixed">
		<td class="list" colspan="1">رابط النقاش الحي</td>
<td class="list" colspan="3"><input type="text" value="'.$schat_url.'" dir="ltr" name="schat_url"> <font color="red">ضع هنا رابط النقاش الحي حتى يتم تتبعه في الروابط</font> </td>
	</tr>
<tr class="fixed">
		<td class="list" colspan="1">رقم الرقابة</td>
<td class="list" colspan="1"><nobr>رقم المنتدى </nobr><input type="text" value="'.$mon_schat[0].'" size="3" dir="ltr" name="forumid_mon_schat"> </td>
<td class="list" colspan="1"><nobr>رقم الموضوع </nobr><input type="text" value="'.$mon_schat[1].'" size="3" dir="ltr" name="topicid_mon_schat"> </td>
<td class="list" colspan="1"><nobr>رقم الرد </nobr><input type="text" value="'.$mon_schat[2].'" size="3" dir="ltr" name="replyid_mon_schat"> </td>
	</tr>
<tr class="fixed">
<td class="list" colspan="4" align="center">جميع الحقوق محفوظة لمطوري النسخة  - ستارتايمز - تطوير المواقع و المنتديات</td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="4"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</table>';
}

if($method == "save_data"){
$Mon_1 = intval($_POST['forumid_mon_schat']);
$Mon_2 = intval($_POST['topicid_mon_schat']);
$Mon_3 = intval($_POST['replyid_mon_schat']);
$mon_schat = "$Mon_1||$Mon_2||$Mon_3";
updata_mysql("ACTIVE_SCHAT", $_POST['active_schat']);
updata_mysql("VISITOR_SCHAT", $_POST['visitor_schat']);
updata_mysql("NUM_SCHAT", $_POST['num_schat']);
updata_mysql("ACTIVE_ROOM", $_POST['active_room']);
updata_mysql("NBR_MAX_POST_SCHAT", $_POST['nbr_max']);
updata_mysql("BOSS_SCHAT", $_POST['boss_schat']);
updata_mysql("SCHAT_URL", $_POST['schat_url']);
updata_mysql("FORUMID_MON_SCHAT", $mon_schat);

save("تم تعديل البيانات بنجاح","schat&type=index&method=index");
}

}

if($type == "icon"){
if(empty($method)) $method = "index";

if($method == "index"){

echo'
<script type="text/javascript" src="./javascript/javascript.js"></script>
<script type="text/javascript">
function del_smile(id){
if(confirm("هل انت متاكد من انك تريد حدف هده الابتسامة ؟")){
 window.location="cp_home.php?mode=schat&type=icon&method=del_smile&id="+id;
}
}
</script>
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="85%">
<form method="post" action="cp_home.php?mode=schat&type=icon&method=save_data">
	<tr class="fixed">
		<td class="cat" colspan="4"><nobr>اعدادات ايقونات النقاش الحي</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>ظهور الايقونات</nobr></td>
		<td class="userdetails_data"><input type="radio" value="1" name="active_schat_smile" '.check_radio($active_schat_smile, "1").'>نعم&nbsp;&nbsp;</td>
        <td class="userdetails_data"> <input type="radio" value="0" name="active_schat_smile" '.check_radio($active_schat_smile, "0").'>لا</td>
		<td class="userdetails_data" style="color:red"><nobr>اذا قمت بالضغط على لا سيتم اخفاء الايقونات في النقاش </nobr></td>
	</tr>
<tr class="fixed">
		<td class="cat" colspan="4"><nobr>اضافة ايقونات</nobr></td>
	</tr>
<tr class="fixed">
		<td class="list">رابط الايقونة</td>
<td class="list" ><input type="text"  dir="ltr" name="smile_url"> </td>
<td class="list"><nobr>كود الايقونة</nobr></td>
<td class="list" ><input type="text" dir="ltr" name="smile_code">'.info_icon(1).'</td>
	</tr>
'.info_text(1, "كود الايقونة هو عبارة عن شيفرة , يمكنك وضع اي اسم او رمز تريد طالما انك متيقين من انه لن يستخدم في النقاش الحي كمثال يمكنك وضع الرمز : ::) . او my_smile", "كود الايقونة").'
<tr class="fixed">
		<td class="cat" colspan="4"><nobr>الايقونات الحالية</nobr></td>
	</tr>
<tr class="fixed">
		<td class="optionheader_selected" colspan="2">الابتسامة</td>
		<td class="optionheader_selected" colspan="1">الكود</td>
		<td class="optionheader_selected" colspan="1">&nbsp;</td>
	</tr>
';

$sql = $mysql->execute("SELECT * from {$mysql->prefix}chat_smile order by id asc ");
while($r = mysql_fetch_array($sql)){
$code = $r['code'];
$url = $r['url'];
echo '<tr class="fixed">
		<td class="f1" colspan="2" align="center"><nobr><img src="'.$url.'"></nobr></td>
		<td class="f1" colspan="1" width="100%"><nobr>'.$code.'</nobr></td>
		<td class="f1" colspan="1" align="center" width="5%"><nobr><a href="javascript:del_smile('.$r['id'].')"><img src="images/icons/icon_trash.gif" border="0"></a></nobr></td>
	</tr>';
}

echo '
 	<tr class="fixed">
		<td align="middle" colspan="4"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</table>';
}

if($method == "save_data"){
updata_mysql("ACTIVE_SCHAT_SMILE", $_POST['active_schat_smile']);
if($_POST['smile_url'] AND $_POST['smile_code']){
add_smile($_POST['smile_url'],$_POST['smile_code']);
}
save("تم تعديل البيانات بنجاح","schat&type=icon&method=index");
}
if($method == "del_smile"){
$mysql->execute("delete from {$mysql->prefix}chat_smile where id = '$id' ");
save("تم حدف الايقونة بنجاح","schat&type=icon&method=index");
}

}

?>