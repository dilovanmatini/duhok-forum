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

if($CPMlevel == 4){
// function send pm 

function send_pm($from, $to, $subject, $message, $date){

 global $Prefix, $connection;

     $send_pm = "INSERT INTO {$mysql->prefix}PM (PM_ID, PM_MID, PM_TO, PM_FROM, PM_OUT, PM_SUBJECT, PM_MESSAGE, PM_DATE) VALUES (NULL, ";
     $send_pm .= " '$from', ";
     $send_pm .= " '$to', ";
     $send_pm .= " '$from', ";
     $send_pm .= " '1', ";
     $send_pm .= " '$subject', ";
     $send_pm .= " '$message', ";
     $send_pm .= " '$date') ";

     $mysql->execute($send_pm, $connection, [], __FILE__, __LINE__);

     $store_pm = "INSERT INTO {$mysql->prefix}PM (PM_ID, PM_MID, PM_TO, PM_FROM, PM_SUBJECT, PM_MESSAGE, PM_DATE) VALUES (NULL, ";
     $store_pm .= " '$to', ";
     $store_pm .= " '$to', ";
     $store_pm .= " '$from', ";
     $store_pm .= " '$subject', ";
     $store_pm .= " '$message', ";
     $store_pm .= " '$date') ";

     $mysql->execute($store_pm, $connection, [], __FILE__, __LINE__);
}



 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="1" width="80%">
<form method="post" action="cp_home.php?mode=pm&type=insert_data">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>ارسال رسالة جماعية</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عنوان الرسالة</nobr></td>
		<td class="middle">
			<input type="text" name="subject">
		</td>
</tr>
<tr class="fixed">
<td class="list"><nobr>محتوى الرسالة</nobr></td>
			<td class="middle"><textarea name="message" style="HEIGHT: 80px;WIDTH: 300px;FONT-WEIGHT: bold;FONT-SIZE: 15px;BACKGROUND: darkseagreen;COLOR: white;FONT-FAMILY: tahoma"></textarea></td>
</td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>المجموعة</nobr></td>
		<td class="middle">
			<select class="insidetitle" name="level">
			<option value="all">الكل</option>
			<option value="1">الاعضاء</option>
			<option value="2">المشرفين</option>
			<option value="3">المراقبين</option>
			</select>
		</td>
</tr>
 	<tr class="fixed">
		<td class="list"><nobr>اعضاء محددين</nobr></td>
		<td class="middle">
			<input type="text" name="array_m"><nobr>&nbsp;<font color="red">بعد تحديد المجموعة يمكنك ارسال الرسالة الى اعضاء محددين داخل هده المجموعة <br> يكفي وضع اسم العضوية والفصل بين كل اسم واخر بالرمز ; </nobr></font>
		</td>
</tr>
 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="أرسل">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></form></td>
	</tr></table>
</center>';
 }



if($type == "insert_data"){
$subject = trim($_POST['subject']);
$message = $_POST['message'];
$message = str_replace("\n","<br>",$message);
$level = $_POST['level'];
$array_m = $_POST['array_m'];
$date = time();


// ########## If it isnt array ########

if(!$array_m){
// ########## To All Member ########
if($level == "all"){
$sql = $mysql->execute("select * from {$mysql->prefix}MEMBERS WHERE M_LEVEL NOT IN(4) ORDER BY MEMBER_ID ", [], __FILE__, __LINE__);
while($r = mysql_fetch_array($sql)){
send_pm($CPMemberID, $r['MEMBER_ID'], $subject, $message, $date);
}
}
// ########## To All Member ########
if($level != "all"){
$sql = $mysql->execute("select * from {$mysql->prefix}MEMBERS WHERE M_LEVEL = '$level' ORDER BY MEMBER_ID ", [], __FILE__, __LINE__);
while($r = mysql_fetch_array($sql)){
send_pm($CPMemberID, $r['MEMBER_ID'], $subject, $message, $date);
}
}

}

// ########## If it array ########
if($array_m){
$m = explode(";",$array_m);
if($level == "all"){
$and = "";
}else{
$and = " AND M_LEVEL = '$level' ";
}
for($i=0;$i<count($m);$i++){
$m_name = $m[$i];
$r = mysql_fetch_array($mysql->execute("select * from {$mysql->prefix}MEMBERS WHERE M_NAME = '$m_name' $and "));
send_pm($CPMemberID, $r['MEMBER_ID'], $subject, $message, $date);
}
}


                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم ارسال الرسالة الجماعية بنجاح ..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=pm&method=send_pm">
                           <a href="cp_home.php?mode=pm&method=send_pm">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';

}}


?>