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

$Monitor = chk_monitor($DBMemberID, cat_id($f));
$Moderator = chk_moderator($DBMemberID, $f);

if($method == "admin"){
$status = "AND STATUS = '2'";
}

if($type == ""){
if($Mlevel == 4 OR $Monitor == 1 OR $Moderator == 1){

echo'
<center>
<table cellSpacing="0" cellPadding="0" width="99%" height="8%" border="0">
	<tr>
		<td width=100% class=optionsbar_menus><font color=red size=+1>شكاوي منتدى '.forum_name($f).'</font></td>';
                go_to_forum();
echo'
	</tr>
</table><br>

<table class="grid" dir="rtl" cellSpacing="0" cellPadding="0" width="99%" align="center" border="0">
			<tr>
				<td>
				<table dir="rtl" cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<td class="cat" width="45%">المنتدى و الموضوع</td>
						<td class="cat">شكوى على</td>
						<td class="cat"">كاتب الشكوى</td>
						<td class="cat">آخر ملاحظة</td>
						<td class="cat">رد عليها</td>
						<td class="cat">حوّلها للمدير</td>';

 $query = "SELECT * FROM {$mysql->prefix}NOTIFY AS N WHERE FORUM_ID = '" .$f."' ".$status."";
 $query .= " ORDER BY DATE DESC";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 $num = mysql_num_rows($result);

	if($num <= 0){


                      echo'
                      <tr>
                          <td class="f1" vAlign="center" align="middle" colspan="20"><br><br>لا  توجد شكاوي للمنتدى<br><br><br></td>
                      </tr>';
	}
	
	$i=0;
	while ($i < $num){

    $Notify_ID = mysql_result($result, $i, "N.NOTIFY_ID");
    $Notify['Status'] = mysql_result($result, $i, "N.STATUS");
    $Notify['ForumID'] = mysql_result($result, $i, "N.FORUM_ID");
    $Notify['TopicID'] = mysql_result($result, $i, "N.TOPIC_ID");
    $Notify['ReplyID'] = mysql_result($result, $i, "N.REPLY_ID");
    $Notify['AuthorID'] = mysql_result($result, $i, "N.AUTHOR_ID");
    $Notify['AuthorName'] = mysql_result($result, $i, "N.AUTHOR_NAME");
    $Notify['PostAuthorID'] = mysql_result($result, $i, "N.POSTAUTHOR_ID");
    $Notify['PostAuthorName'] = mysql_result($result, $i, "N.POSTAUTHOR_NAME");
    $Notify['Date'] = mysql_result($result, $i, "N.DATE");
    $Notify['Type'] = mysql_result($result, $i, "N.TYPE");
    $Notify['Subject'] = mysql_result($result, $i, "N.SUBJECT");
    $Notify['r_ID'] = mysql_result($result, $i, "N.R_ID");
    $Notify['r_msg'] = mysql_result($result, $i, "N.R_MSG");
    $Notify['r_date'] = mysql_result($result, $i, "N.R_DATE");
    $Notify['Note_by'] = mysql_result($result, $i, "N.NOTE_BY");
    $Notify['Notes'] = mysql_result($result, $i, "N.NOTES");
    $Notify['Note_Date'] = mysql_result($result, $i, "N.NOTE_DATE");
    $Notify['Tr_by'] = mysql_result($result, $i, "N.TRANSFER_BY");
    $Notify['Tr_Date'] = mysql_result($result, $i, "N.TRANSFER_DATE");
    $Notify['Done'] = mysql_result($result, $i, "N.N_DONE");

 $queryT = "SELECT * FROM {$mysql->prefix}TOPICS WHERE TOPIC_ID = '" .$Notify['TopicID']. "' ";
 $resultT = $mysql->execute($queryT, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($resultT) > 0){
 $rsT=mysql_fetch_array($resultT);

 $Topic_ID = $rsT['TOPIC_ID'];
 $Topic_Subject = $rsT['T_SUBJECT'];
 }

 $AuthorID .= "WHERE MEMBER_ID = '" .$Notify['AuthorID']. "' OR MEMBER_ID = '" .$Notify['PostAuthorID']. "' OR MEMBER_ID = '" .$Notify['r_ID']. "' OR MEMBER_ID = '" .$Notify['Note_by']. "' OR MEMBER_ID = '" .$Notify['Tr_by']. "' ";

 $PostAuthorID = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$Notify['PostAuthorID']. "' ";
 $resultPoAuID = $mysql->execute($PostAuthorID, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($resultPoAuID) > 0){
 $rsPoAuID=mysql_fetch_array($resultPoAuID);

 $PoAuIDMemID = $rsPoAuID['MEMBER_ID'];
 $PoAuIDMemName = $rsPoAuID['M_NAME'];
 }

 $AuthorID = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$Notify['AuthorID']. "' ";
 $resultAuID = $mysql->execute($AuthorID, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($resultAuID) > 0){
 $rsAuID=mysql_fetch_array($resultAuID);

 $AuIDMemID = $rsAuID['MEMBER_ID'];
 $AuIDMemName = $rsAuID['M_NAME'];
 }

 $r_ID = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$Notify['r_ID']. "' ";
 $resultr_ID = $mysql->execute($r_ID, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($resultr_ID) > 0){
 $rsr_ID=mysql_fetch_array($resultr_ID);

 $r_IDMemID = $rsr_ID['MEMBER_ID'];
 $r_IDMemName = $rsr_ID['M_NAME'];
 }

 $Note_by = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$Notify['Note_by']. "' ";
 $resultNo = $mysql->execute($Note_by, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($resultNo) > 0){
 $rsNo=mysql_fetch_array($resultNo);

 $NoMemID = $rsNo['MEMBER_ID'];
 $NoMemName = $rsNo['M_NAME'];
 }

 $Tr_by = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$Notify['Tr_by']. "' ";
 $resultTr = $mysql->execute($Tr_by, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($resultTr) > 0){
 $rsTr=mysql_fetch_array($resultTr);

 $TrMemID = $rsTr['MEMBER_ID'];
 $TrMemName = $rsTr['M_NAME'];
 }

if($Notify['Status'] == 0){
	$cl = "deleted";
}
elseif($Notify['Status'] == 1){
	$cl = "normal";
}
elseif($Notify['Status'] == 2){
	$cl = "fixed";
}

echo '
		<tr class="'.$cl.'">
			<td class=list nowrap><a href="index.php?mode=notifylist&f='.$Notify['ForumID'].'&type=reply&n='.$Notify_ID.'"><font size=-1>'.forum_name($Notify['ForumID']).':<br>'.$Topic_Subject.'</a></td>
			<td class=list_small2 nowrap>'.link_profile($PoAuIDMemName, $PoAuIDMemID, $Prefix).'<br>'.$Notify['Type'].'</td>
			<td class=list_small2 nowrap><font color=green>'.normal_time($Notify['Date']).'</font><br>'.link_profile($AuIDMemName, $AuIDMemID, $Prefix).'</td>
			<td class=list_small2 nowrap><font color=green>';if($NoMemName){echo normal_time($Notify['Note_Date']);}echo'</font><br>'.link_profile($NoMemName, $NoMemID, $Prefix).'</td>
			<td class=list_small2 nowrap><font color=green>';if($r_IDMemName){echo normal_time($Notify['r_date']);}echo'</font><br>'.link_profile($r_IDMemName, $r_IDMemID, $Prefix).'</td>
			<td class=list_small2 nowrap><font color=green>';if($TrMemName){echo normal_time($Notify['Tr_Date']);}echo'</font><br>'.link_profile($TrMemName, $TrMemID, $Prefix).'</td>
		</tr>';

	    ++$i;
	}
echo '</td></tr></table>
</td></tr></table></center>';

echo'		<table bgcolor="#FFFFFF" width="35%">
		<td>
		<tr>
			<td><table border=1 cellspacing=1><tr class="normal">
			<td>&nbsp;&nbsp;&nbsp;</td></tr></table></td><td>شكاوي جديدة</td>
			<td><table border=1 cellspacing=1><tr class="fixed">
			<td>&nbsp;&nbsp;&nbsp;</td></tr></table></td><td>شكاوي رحلت للمدير</td>
			<td><table border=1 cellspacing=1><tr class="deleted">
			<td>&nbsp;&nbsp;&nbsp;</td></tr></table></td><td>شكاوي مغلقة</td>
		</tr>
		</td>
		</table>';
}
    else {
    redirect();
    }
}

if($type == "reply"){
if($Mlevel == 4 OR $Monitor == 1 OR $Moderator == 1){

 $queryR = "SELECT * FROM {$mysql->prefix}NOTIFY WHERE NOTIFY_ID = '" .$n. "' ";
 $resultR = $mysql->execute($queryR, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($resultR) > 0){
 $rsR=mysql_fetch_array($resultR);

 $Notify_ID = $rsR['NOTIFY_ID'];
 $N_ForumID = $rsR['FORUM_ID'];
 $N_TopicID = $rsR['TOPIC_ID'];
 $N_ReplyID = $rsR['REPLY_ID'];
 $N_AuthorID = $rsR['AUTHOR_ID'];
 $N_AuthorName = $rsR['AUTHOR_NAME'];
 $N_PostAuthorID = $rsR['POSTAUTHOR_ID'];
 $N_PostAuthorName = $rsR['POSTAUTHOR_NAME'];
 $N_Date = $rsR['DATE'];
 $N_Type = $rsR['TYPE'];
 $N_Subject = $rsR['SUBJECT'];
 $N_r_ID = $rsR['R_ID'];
 $N_r_msg = $rsR['R_MSG'];
 $N_r_date = $rsR['R_DATE'];
 $N_Note_by = $rsR['NOTE_BY'];
 $N_Notes = $rsR['NOTES'];
 $N_Note_Date = $rsR['NOTE_DATE'];
 }

 $reply_ID = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$N_r_ID. "' ";
 $resultreply_ID = $mysql->execute($reply_ID, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($resultreply_ID) > 0){
 $rsreply_ID=mysql_fetch_array($resultreply_ID);

 $replyMemID = $rsreply_ID['MEMBER_ID'];
 $replyMemName = $rsreply_ID['M_NAME'];
 }

 $note_by = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$N_Note_by. "' ";
 $resultnote_by = $mysql->execute($note_by, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($resultnote_by) > 0){
 $rsnote_by=mysql_fetch_array($resultnote_by);

 $NoteMemID = $rsnote_by['MEMBER_ID'];
 $NoteIDMemName = $rsnote_by['M_NAME'];
 }

echo '
<table class="grid" dir="rtl" cellSpacing="0" cellPadding="0" width="60%" align="center" border="0">
	<tr>
		<td>
		<table dir="rtl" cellSpacing="1" cellPadding="1" width="100%" border="0">
			<tr>
				<td class="cat" colspan="2">شكوى رقم: '.$Notify_ID.'</td>
			</tr>
			<tr class="fixed">
				<td class="list_small2" width="20%">المنتدى و الموضوع</td>
				<td class="list_small">
				<table cellspacing="0" cellpadding="0" align="right">
				<tr>
				<td>&nbsp;'.forum_name($N_ForumID).':<br><a href="index.php?mode=t&t='.$N_TopicID.'';
				if($N_ReplyID > 0){
				echo '&r='.$N_ReplyID.'';
				}
			echo'	">&nbsp;'.topics("SUBJECT", $N_TopicID).'</a></td></tr>
				</table></td>
			</tr>
			<tr class="fixed">
				<td class="list_small2" width="20%">شكوى على</td>
				<td class="list_small">
				<table cellspacing="0" cellpadding="0" align="right">
				<tr>
				<td>&nbsp;'.link_profile($N_PostAuthorName, $N_PostAuthorID, $Prefix).'<br><font color="darkblue">&nbsp;'.$N_Type.'</font></td></tr>
				</table></td>
			</tr>
			<tr class="fixed">
				<td class="list_small2" width="20%">كاتب الشكوى</td>
				<td class="list_small">
				<table cellspacing="0" cellpadding="0" align="right">
				<tr>
				<td>&nbsp;'.normal_time($N_Date).'<br>&nbsp;'.link_profile($N_AuthorName, $N_AuthorID, $Prefix).'</td></tr>
				</table></td>
			</tr>
			<tr class="fixed">
				<td class="list_small2" width="20%">نص الشكوى</td>
				<td class="list_small">
				<table cellspacing="0" cellpadding="0" align="right">
				<tr>
				<td><font color="red">&nbsp;'.$N_Subject.'</font></td></tr>
				</table></td>
			</tr>';
		if($replyMemName != ""){
		echo'	<tr class="fixed">
				<td class=list_small2>رد عليها</td>
				<td class=list nowrap><font color="darkgreen">&nbsp;'.normal_time($N_r_date).'</font><br>&nbsp;'.link_profile($replyMemName, $replyMemID, $Prefix).'</td>
			</tr>
			<tr class = "fixed">
				<td class=list_small2>نص الرد</td>
				<td class=list>'.$N_r_msg.'</td>
			</tr>';
		}
		if($N_Notes != ""){
		echo'	<tr class="fixed">
				<td class=list_small2>ملاحظات</td>
				<td class=list><font size=-1 color=red>'.$N_Notes.'</td>
			</tr>';
		}
	echo'	
		<table border=0 cellpadding=4 cellspacing=1 width="100%" bgcolor="gray">
		<form method="POST" action="index.php?mode=notifylist&f='.$N_ForumID.'&type=send_reply" name="NotifyReply">
		<input type="hidden" name="notify_id" value="'.$Notify_ID.'">
		<input type="hidden" name="author_id" value="'.$N_AuthorID.'">
		<input type="hidden" name="forum_id" value="'.$N_ForumID.'">
		<input type="hidden" name="subject" value="'.$N_Subject.'">
			<tr class=fixed>
				<td class=optionheader colspan="4">
				نص الرد على العضو:<br>
				<textarea class=insidetitle type=text style="width:500;height:150" name=notifyreply>'.$N_r_msg.'</textarea><br>
				ملاحظات للمشرفين و الإدارة فقط<br>(&nbsp;يتم اضافتها للملاحظات الحالية&nbsp;):<br>
				<textarea class=insidetitle type=text style="width:500;height:150" name=notifynotes>'.$N_Notes.'</textarea><br>
				</td>
			</tr>
			<tr class=fixed>
				<td class=list_center>
				<input name="store_notes" type=submit value="ادخال الملاحظات فقط">
				&nbsp;&nbsp;&nbsp;<input name="send_admin" type=submit value="حوّل الشكوى للمدير">
				&nbsp;&nbsp;&nbsp;<input name="close_notify" type=submit value="أقفل الشكوى">
				&nbsp;&nbsp;&nbsp;<input name="send_reply" type=submit value="أرسل الرد للعضو">
				</td>
			</tr>
		</form>
		</table>
		</td>
	</tr>
</table>';
echo'
<center>
<table cellSpacing="0" cellPadding="0" width="60%"  height="8%" border="0">
	<tr>
		<td width=100% class=optionsbar_menus><a class="menu" href="index.php?mode=notifylist&f='.$N_ForumID.'"><font size=+1>العودة الى شكاوي منتدى '.forum_name($N_ForumID).'</font></td>';
                go_to_forum();
echo'
	</tr>
</table>';
}
    else {
    redirect();
    }
}

if($type == "send_reply"){
if($Mlevel == 4 OR $Monitor == 1 OR $Moderator == 1){

$Notify_ID = $_POST['notify_id'];
$Author_ID = $_POST['author_id'];
$store_notes = $_POST['store_notes'];
$send_admin = $_POST['send_admin'];
$close_notify = $_POST['close_notify'];
$send_reply = $_POST['send_reply'];
$Forum_ID = $_POST['forum_id'];
$N_Subject = $_POST['subject'];
$NotifyReply = $_POST['notifyreply'];
$NotifyNotes = $_POST['notifynotes'];
$notify_date = time();
$moderator_forum = forum_name($Forum_ID);
$pm_mid = '-'.$Forum_ID;
$pm_subject = 'رد على ملاحظتك لاشراف منتدى '.$moderator_forum.'';
$pm_message = '
		بخصوص ملاحظتك التالية الى اشراف منتدى '.$moderator_forum.':<br>
		<font color="red">____________________________________________________________________</font><br>
		<br>'.$N_Subject.'<br>
		<font color="red">____________________________________________________________________</font><br>
		<br><br>
		لقد تم متابعة الملاحظة بواسطة فريق الاشراف و التالي نص الرد عليك:<br>
		<font color="red">____________________________________________________________________</font><br>
		'.$NotifyReply.'';

if($send_reply != ""){
if($NotifyReply == ""){
    $error = 'انت لم تدخل نص الرد.';
}
}
if($store_notes != ""){
if($NotifyNotes == ""){
    $error = 'انت لم تدخل نص الملاحظة.';
}
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
     
	$query = "UPDATE {$mysql->prefix}NOTIFY SET ";
    if($send_reply != ""){
	$query .= "R_ID = '$DBMemberID', ";
	$query .= "R_MSG = '$NotifyReply', ";
	$query .= "R_DATE = '$notify_date', ";
	$query .= "N_DONE = '1', ";
	$query .= "STATUS = '1' ";
    }
    if($store_notes != ""){
	$query .= "NOTE_BY = '$DBMemberID', ";
	$query .= "NOTES = '$NotifyNotes', ";
	$query .= "NOTE_DATE = '$notify_date' ";
    }
    if($send_admin){
	$query .= "TRANSFER_BY = '$DBMemberID', ";
	$query .= "TRANSFER_DATE = '$notify_date', ";
	$query .= "STATUS = '2' ";
    }
    if($close_notify){
	$query .= "STATUS = '0' ";
    }
	$query .= "WHERE NOTIFY_ID = '$Notify_ID' ";

	$mysql->execute($query, $connection, [], __FILE__, __LINE__);

if($send_reply){

     $query1 = "INSERT INTO {$mysql->prefix}PM (PM_ID, PM_MID, PM_TO, PM_FROM, PM_OUT, PM_SUBJECT, PM_MESSAGE, PM_DATE) VALUES (NULL, ";
     $query1 .= " '$pm_mid', ";
     $query1 .= " '$Author_ID', ";
     $query1 .= " '$pm_mid', ";
     $query1 .= " '1', ";
     $query1 .= " '$pm_subject', ";
     $query1 .= " '$pm_message', ";
     $query1 .= " '$notify_date') ";

     $mysql->execute($query1, $connection, [], __FILE__, __LINE__);

     $query2 = "INSERT INTO {$mysql->prefix}PM (PM_ID, PM_MID, PM_TO, PM_FROM, PM_SUBJECT, PM_MESSAGE, PM_DATE) VALUES (NULL, ";
     $query2 .= " '$Author_ID', ";
     $query2 .= " '$Author_ID', ";
     $query2 .= " '$pm_mid', ";
     $query2 .= " '$pm_subject', ";
     $query2 .= " '$pm_message', ";
     $query2 .= " '$notify_date') ";

     $mysql->execute($query2, $connection, [], __FILE__, __LINE__);

}

if($send_reply){
$text = '<br>شكرا لك<br>تم ارسال الرد للعضو.';
}
if($store_notes){
$text = '<br>شكرا لك<br>تم اضافة الملاحظة.';
}
if($send_admin){
$text = '<br>شكرا لك<br>تم تحويل الشكوى للمدير.';
}
if($close_notify){
$text = '<br>شكرا لك<br>تم اقفال الشكوى.';
}

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5">'.$text.'</font><br><br>
	                       <meta http-equiv="Refresh" content="2; URL=index.php?mode=notifylist&f='.$Forum_ID.'&type=reply&n='.$Notify_ID.'">
	                       <a href="index.php?mode=notifylist&f='.$Forum_ID.'&type=reply&n='.$Notify_ID.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}

}
    else {
    redirect();
    }
}

mysql_close();

?>