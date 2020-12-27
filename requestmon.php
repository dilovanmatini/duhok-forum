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

require_once("./include/moderation_func.df.php");
require_once("./include/svc_func.df.php");
$referer = $_SERVER['HTTP_REFERER'];

if($type == ""){
if(mlv > 1 AND (members("LEVEL", $aid) == 1 || mlv > 2) AND (check_administrateurs($aid) == 0 || mlv == 4)){

	echo'
	<center>
	<table dir="rtl" cellSpacing="1" cellPadding="1">
		<tr>
			<td class="optionsbar_menus" colSpan="15"><font color="red" size="4">تاريخ الرقابة و المنع للعضو:<br>'.member_name($aid).'</font></td>
		</tr>
		<tr>
			<td class="stats_h"><nobr></nobr></td>
			<td class="stats_h"><nobr>العضو</nobr></td>
			<td class="stats_h"><nobr>النوع</nobr></td>
			<td class="stats_h"><nobr>المنتدى</nobr></td>
			<td class="stats_h" colspan="2"><nobr>تقديم الطلب</nobr></td>
			<td class="stats_h"><nobr>رفض الطلب</nobr></td>
			<td class="stats_h" colspan="2"><nobr>تطبيق</nobr></td>
			<td class="stats_h" colspan="2"><nobr>إالغاء</nobr></td>
			<td class="stats_h"><nobr></nobr>الأيام</td>
			<td class="stats_h"><nobr></nobr></td>
		</tr>';

	$sql = " SELECT * FROM {$mysql->prefix}MODERATION ";
	$sql .= " WHERE M_MEMBERID = '$aid' AND M_STATUS != '2' ";
	$sql .= " ORDER BY M_DATE DESC ";
	$result = $mysql->execute($sql, $connection, [], __FILE__, __LINE__);
	$num = mysql_num_rows($result);
	if($num == 0){
	echo'
		<tr>
			<td class="stats_h" colspan="13"><nobr><br>لا توجد رقابات مفروضة على هذا العضو<br><br></nobr></td>
		</tr>';
	}
	else {
	$x=0;
	while ($x < $num){
	$m = mysql_result($result, $x, "MODERATION_ID");
	svc_show_mon($m);
	++$x;
	}
	}

	echo'
	</table>
	</center>';

	if($r != ""){
	    $text = "الموضوع رقم: ".$t."&nbsp;&nbsp;الرد رقم: ".$r;
	}
	elseif($pm != ""){
	    $text = "الرسالة الخاصة رقم: ".$pm;
	}
	else{
	    $text = "الموضوع رقم: ".$t;
	}

		if(allowed($f, 2) == 1){
		svc_requestmon_body();
		}


} // (mlv > 1 AND (members("LEVEL", $aid) == 1 || mlv > 2) AND (check_administrateurs($aid) == 0 || mlv == 4))
else {
                    echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>لا يمكن تصفح هذه العضوية</font><br><br>
	                       	<meta http-equiv="Refresh" content="2; URL=JavaScript:history.go(-1)">
				<a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}
} // ($type == "")

if($type == "insert"){

	$member_id = $_POST['member_id'];
	$forum_id = $_POST['forum_id'];
	$pm_mid = "-".$forum_id;
	$topic_id = $_POST['topic_id'];
	$reply_id = $_POST['reply_id'];
	$pm = intval($_POST['pm']);
	$moderation_type = $_POST['moderation_type'];
	$moderation_raison = $_POST['moderation_raison'];
	$moderators_notes = $_POST['moderators_notes'];
	$m_date = time();

	if($moderation_type == 1){
	    $m_dateApp = time();
	}
	else {
	    $m_dateApp = "0";
	}

	if($reply_id == ""){
	    $reply_id = 0;
	    $rid = "";
	}
	else {
	    $rid = "&r=".$reply_id;
	}

	switch ($moderation_type){
	     case "1":
	          $txtSubject = "إشعار بوضع رقابة على مشاركاتك  في منتدى ".forum_name($forum_id);
		  $txtMessage = '<font color="red" size="3">نظرا لمخالفتك لشروط المشاركات في المنتديات فقد تم وضع رقابة على مشاركاتك في منتدى '.forum_name($forum_id).'<br><br>والسبب هو : </font><br><font size="3">'.$moderation_raison.'</front><font color="black" size="3"><br><br>سنقوم بإعادة النظر في هذه الرقابة إذا لم تتكرر منك هذه المخالفات مستقبلا.<br>واذا تكرر الأمر سنضطر لرفع الأمر لإدارة المنتديات لإتخاذ أية خطوات أخرى تراها مناسبة.<br><a href="index.php?mode=t&t='.$topic_id.$rid.'">** إضغط هنا لمشاهدة المشاركة المعنية **</a><br></front>';
		  $STATUS = "1";
	     break;
	}

	if($error == ""){

		if($moderation_type == "1"){

		// SEND PM TO MEMBER ABOUT THE RAISON OF THE MODERATION
		send_pm($pm_mid, $member_id, $txtSubject, $txtMessage, $m_date);

		}

		$query = "INSERT INTO {$mysql->prefix}MODERATION (MODERATION_ID, M_MEMBERID, M_STATUS, M_FORUMID, M_TOPICID, M_REPLYID, M_PM , M_ADDED, M_EXECUTE, M_MODERATOR_NOTES, M_TYPE, M_RAISON, M_DATE, M_DATEAPP) VALUES (NULL, ";
		$query .= " '$member_id', ";
		$query .= " '$STATUS', ";
		$query .= " '$forum_id', ";
		$query .= " '$topic_id', ";
		$query .= " '$reply_id', ";
		$query .= " '$pm', ";
		$query .= " '$DBMemberID', ";
		$query .= " '$DBMemberID', ";
		$query .= " '$moderators_notes', ";
		$query .= " '$moderation_type', ";
		$query .= " '$moderation_raison', ";
		$query .= " '$m_date', ";
		$query .= " '$m_dateApp') ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تطبيق الرقابة أو ارسال الطلب للمراقب</font><br><br>
	                       	<meta http-equiv="Refresh" content="2; URL='.$referer.'">
	                       	<a href="index.php?mode=f&f='.$forum_id.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
				<a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
	}
}

?>