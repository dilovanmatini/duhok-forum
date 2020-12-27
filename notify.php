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

if(members("NOTIFY", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][notify].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}


$queryM = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$m' ";
$resultM = $mysql->execute($queryM, $connection, [], __FILE__, __LINE__);

if(mysql_num_rows($resultM) > 0){
$rsM=mysql_fetch_array($resultM);

$PostAuthor_ID = $rsM['MEMBER_ID'];
$PostAuthor_Name = $rsM['M_NAME'];
}

$queryT = "SELECT * FROM {$mysql->prefix}TOPICS WHERE TOPIC_ID = '$t' ";
$resultT = $mysql->execute($queryT, $connection, [], __FILE__, __LINE__);

if(mysql_num_rows($resultT) > 0){
$rsT=mysql_fetch_array($resultT);

$Topic_ID = $rsT['TOPIC_ID'];
$Topic_Subject = $rsT['T_SUBJECT'];
}

if($method == "" && $Mlevel > 0){

echo'
<center>
<table cellSpacing="0" cellPadding="0" width="100%" border="0">
	<tr>
		<td align="center">لفت انتباه المشرف عن مشاركة العضو :
		<br><font color="red" size="+2">'.$PostAuthor_Name.'</font>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center">في موضوع :
		<br><font color="red" size="+2">'.$Topic_Subject.'</font>
	</tr>
</table><br>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="40%">
	<form method="post" action="index.php?mode=notify&method=send">
    <input type="hidden" name="forum_id" value="'.$f.'">
    <input type="hidden" name="topic_id" value="'.$t.'">
    <input type="hidden" name="reply_id" value="'.$r.'">
    <input type="hidden" name="postauthor_id" value="'.$PostAuthor_ID.'">
    <input type="hidden" name="postauthor_name" value="'.$PostAuthor_Name.'">
	<tr>
		<td class="cat" colspan="2" align="middle">الرجاء ادخال ملاحظاتك بخصوص هذه المشاركة<br>للمشرف و سيتم متابعتها بأسرع وقت ممكن:<br><br>
			<select class="insidetitle" name="type">
				<option value="" '.check_select($selected, "").'>لتسهيل مهمة المشرف الرجاء تحديد نوع البلاغ من هذه القائمة:</option>
				<option value="المشاركة تحتوي على صور غير لائقة" '.check_select($selected, "المشاركة تحتوي على صور غير لائقة").'>المشاركة تحتوي على صور غير لائقة</option>
				<option value="المشاركة تحتوي على كلام غير لائق" '.check_select($selected, "المشاركة تحتوي على كلام غير لائق").'>المشاركة تحتوي على كلام غير لائق</option>
				<option value="المشاركة تحتوي على شتم أو تهجم" '.check_select($selected, "المشاركة تحتوي على شتم أو تهجم").'>المشاركة تحتوي على شتم أو تهجم</option>
				<option value="ملاحظات أخرى" '.check_select($selected, "ملاحظات أخرى").'>ملاحظات أخرى (الرجاء التوضيح أدناه)</option>
			</select>
			<textarea cols="47" rows="10" name="subject"></textarea>
		</td>
	</tr>
	<tr class="fixed">
		<td align="middle"><input type="submit" value="أرسل ملاحظاتك"></td>
	</tr>
</table><br>
<table cellSpacing="0" cellPadding="0" width="100%" border="0">
	<tr>
		<td align="center">
		<font color="red" size="+2">الرجاء منكم عدم استخدام هذه الخاصية الا للملاحظات<br>و عدم إساءة استخدامها و الا سيتم ازالة هذه الخاصية عنكم.</font>
		</td>
	</tr>
</table>
</center>';

}

if($method == "send" && $Mlevel > 0){

$f = $_POST['forum_id'];
$t = $_POST['topic_id'];
$r = $_POST['reply_id'];
$PostAuthor_ID = $_POST['postauthor_id'];
$PostAuthor_Name = $_POST['postauthor_name'];
$Type = $_POST['type'];
$Subject = HtmlSpecialchars($_POST['subject']);
$notify_date = time();

if($Type == ""){
    $error = 'انت لم تحدد نوع البلاغ.';
}
if($Subject == ""){
    $error = 'انت لم تحدد ملاحظتك.';
}

if($error != ""){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}
if($error == ""){

 $query = "INSERT INTO {$mysql->prefix}NOTIFY (NOTIFY_ID, FORUM_ID, TOPIC_ID, REPLY_ID, AUTHOR_ID, AUTHOR_NAME, POSTAUTHOR_ID, POSTAUTHOR_NAME, TYPE, SUBJECT, DATE) VALUES (NULL, ";
     $query .= " '$f', ";
     $query .= " '$t', ";
     $query .= " '$r', ";
     $query .= " '$DBMemberID', ";
     $query .= " '$DBUserName', ";
     $query .= " '$PostAuthor_ID', ";
     $query .= " '$PostAuthor_Name', ";
     $query .= " '$Type', ";
     $query .= " '$Subject', ";
     $query .= " '$notify_date') ";

     $mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>شكرا لك على ابداء ملاحظتك.<br><br>سيتم متابعة الأمر بأسرع وقت ممكن.</font><br><br>
	                       <meta http-equiv="Refresh" content="2; URL=index.php?mode=t&t='.$t.'">
	                       <a href="index.php?mode=t&t='.$t.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}

}

mysql_close();

?>