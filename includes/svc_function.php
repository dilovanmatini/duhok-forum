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

function chk_global_medals_get(){
	if(app == ""){
		$app = "ok";
	}
	else{
		$app = app;
	}
	if(scope == ""){
		$scope = "mod";
	}
	else{
		$scope = scope;
	}
	if($scope == "mod"){
		$scope_sql = " AND FORUM_ID IN (".chk_allowed_forums_all_id().")";
	}
	if($scope == "own"){
		$scope_sql = " AND ADDED = '".m_id."'";
	}
	if($scope == "all"){
		$scope_sql = " AND FORUM_ID IN (".chk_allowed_forums_all_id().")";
	}
	if($app == "design"){
		$sql = "WHERE STATUS = '2' AND CLOSE = '0'".$scope_sql;
	}
	if($app == "wait"){
		$sql = "WHERE STATUS = '0' AND CLOSE = '0'".$scope_sql;
	}
	if($app == "ok"){
		$sql = "WHERE STATUS = '1' AND CLOSE = '0'".$scope_sql;
	}
	if($app == "closed"){
		$sql = "WHERE CLOSE = '1'".$scope_sql;
	}
return($sql);
}

function chk_global_titles_get(){
	if(app == ""){
		$app = "ok";
	}
	else{
		$app = app;
	}
	if(scope == ""){
		$scope = "mod";
	}
	else{
		$scope = scope;
	}
	if($scope == "mod"){
		$scope_sql = "AND FORUM_ID IN (".chk_allowed_forums_all_id().")";
	}
	if($scope == "own"){
		$scope_sql = "AND ADDED = '".m_id."'";
	}
	if($scope == "all"){
		$scope_sql = "";
	}
	if($app == "design"){
		$sql = "WHERE STATUS = '2' AND CLOSE = '0' ".$scope_sql;
	}
	if($app == "wait"){
		$sql = "WHERE STATUS = '0' AND CLOSE = '0' ".$scope_sql;
	}
	if($app == "ok"){
		$sql = "WHERE STATUS = '1' AND CLOSE = '0' ".$scope_sql;
	}
	if($app == "closed"){
		$sql = "WHERE CLOSE = '1' ".$scope_sql;
	}
	if($app == "all"){
		$sql = "WHERE TITLE_ID > '0' ".$scope_sql;
	}
return($sql);
}

function chk_medals_get(){
/*
	$app = app;
	$scope = scope;
	$days = days;
	$m = m;
	$id = id;
*/
	$app = $_GET['app'];
	$scope = $_GET['scope'];
	$days = $_GET['days'];
	$m = $_GET['m'];
	$id = $_GET['id'];

	if(empty($scope)){
		$scope = "mod";
	}
	else{
		$scope = $scope;
	}
	if(empty($app)){
		$app = "ok";
	}
	else{
		$app = $app;
	}
	if(empty($days)){
		$days = 30;
	}
	else{
		$days = $days;
	}

	if($id > 0){
		$id_sql = "AND GM_ID = '$id'";
	}
	if($m > 0){
		$m_sql = "AND MEMBER_ID = '$m'";
	}

	if($scope == "mod"){
		$scope_sql = "AND FORUM_ID IN (".chk_allowed_forums_all_id().")";
	}
	if($scope == "own"){
		$scope_sql = "AND ADDED = '".m_id."'";
	}
	if($scope == "all"){
		$scope_sql = " AND FORUM_ID IN (".chk_allowed_forums_all_id().")";
	}

	if($days == 30){
		$days_sql = "AND DATE > '".before_days(30)."'";
	}
	if($days == 60){
		$days_sql = "AND DATE > '".before_days(60)."'";
	}
	if($days == 180){
		$days_sql = "AND DATE > '".before_days(180)."'";
	}
	if($days == 365){
		$days_sql = "AND DATE > '".before_days(365)."'";
	}
	if($days == "all"){
		$days_sql = "";
	}

	if($app == "wait"){
		$sql = "WHERE STATUS = '0' ".$scope_sql." ".$days_sql;
	}
	if($app == "ok"){
		$sql = "WHERE STATUS = '1' ".$scope_sql." ".$days_sql;
	}
	if($app == "ref"){
		$sql = "WHERE STATUS = '2' ".$scope_sql." ".$days_sql;
	}
	if($app == "all"){
		if(!empty($scope_sql) OR !empty($days_sql)){
			$sql = "WHERE MEDAL_ID > '0' ".$scope_sql." ".$days_sql." ".$id_sql." ".$m_sql;
		}
		else{
			if(!empty($id) OR !empty($m)){
				$sql = "WHERE MEDAL_ID > '0' ".$id_sql." ".$m_sql;
			}
			else{
				$sql = "";
			}
		}
	}

return($sql);
}

function chk_surveys_get(){
	$app = app;
	if(empty($app)){
		$app = "running";
	}
	else{
		$app = $app;
	}

	if($app == "running"){
		$sql = "WHERE STATUS = '1' AND END > '".time()."' AND FORUM_ID IN (".chk_allowed_forums_all_id().") ";
	}
	if($app == "ended"){
		$sql = "WHERE STATUS = '0' AND END < '".time()."' AND FORUM_ID IN (".chk_allowed_forums_all_id().") ";
	}
	if($app == "closed"){
		$sql = "WHERE STATUS = '0' AND FORUM_ID IN (".chk_allowed_forums_all_id().") ";
	}
	if($app == "all"){
		$sql = "WHERE FORUM_ID IN (".chk_allowed_forums_all_id().") ";
	}
return($sql);
}

function forum_medal_count($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}GLOBAL_MEDALS WHERE FORUM_ID = '$f' AND STATUS = '1' AND CLOSE = '0' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function forum_title_count($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}GLOBAL_TITLES WHERE FORUM_ID = '$f' AND STATUS = '1' AND CLOSE = '0' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function chk_add_titles($t, $m){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TITLES WHERE GT_ID = '$t' AND MEMBER_ID = '$m' AND STATUS = '1' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($sql) > 0){
		$chk = 1;
	}
	else{
		$chk = 0;
	}
return($chk);
}

function chk_member_last_medal($m){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEDALS WHERE MEMBER_ID = '$m' AND STATUS = '1' ORDER BY DATE DESC ", [], __FILE__, __LINE__);
	if(mysql_num_rows($sql) > 0){
		$rs = mysql_fetch_array($sql);
		$chk = $rs['MEDAL_ID'];
	}
	else{
		$chk = 0;
	}
return($chk);
}

function svc_show_global_medals($id){
	global $icon_trash, $icon_folder_archive, $icon_question;
	$f = gm("FORUM_ID", $id);
	$subject = gm("SUBJECT", $id);
	$url = gm("URL", $id);
	$days = gm("DAYS", $id);
	$status = gm("STATUS", $id);
	$close = gm("CLOSE", $id);
	$points = gm("POINTS", $id);
	$added = gm("ADDED", $id);
	$date = gm("DATE", $id);

	if($status == 1){
		$mon_app = "<font color=\"cyan\">نعم</font>";
	}
	else{
		$mon_app = "<font color=\"yellow\">لا</font>";
	}

	if(allowed($f, 2) == 1){
		$medals_icon = '<a href="index.php?mode=svc&method=edit&svc=medals&m='.$id.'">'.icons($icon_folder_archive, "تعديل الوسام", " hspace=\"3\"").'</a>';
		$medals_icon .= '<a href="index.php?mode=svc&svc=medals&app=all&scope=all&days=all&id='.$id.'">'.icons($icon_question, "استعمال الوسام", " hspace=\"3\"").'</a>';
	}
	else{
		$medals_icon = "-";
	}

	if(allowed($f, 1) == 1 AND $status != 1){
		$app_box = '<input class="small" type="checkbox" name="m_app[]" value="'.$id.'">';
	}
	else{
		$app_box = " - ";
	}

		echo'
		<tr>';
		if(mlv > 2){
			echo'
			<td class="stats_p" align="center"><nobr>'.$app_box.'</nobr></td>';
		}
			echo'
			<td class="stats_h"><nobr>'.$id.'</nobr></td>
			<td class="stats_p"><font size="-1" color="red">'.$subject.'</font></td>
			<td class="stats_p"><a target="plaquepreview" href="'.$url.'">'.icons($url, "", " height=\"33\" width=\"33\"").'</a></td>
			<td class="stats_h"><font color="#aaaaff">'.$points.'</font></td>
			<td class="stats_h"><font color="yellow">'.$mon_app.'</font></td>
			<td class="stats_p"><font color="red">'.forums("SUBJECT", $f).'</font></td>
			<td class="stats_h"><font color="#aaaaff">'.$days.'</font></td>
			<td class="stats_g"><nobr><a href="index.php?mode=profile&id='.$added.'"><font color="#ffffff">'.members("NAME", $added).'</font></a></nobr></td>
			<td class="stats_p" align="middle"><nobr>'.$medals_icon.'</nobr></td>
		</tr>';
}

function svc_award_global_medals($id){
	global $m;
	$f = gm("FORUM_ID", $id);
	$subject = gm("SUBJECT", $id);
	$url = gm("URL", $id);
	$days = gm("DAYS", $id);
	$status = gm("STATUS", $id);
	$close = gm("CLOSE", $id);
	$points = gm("POINTS", $id);
	$added = gm("ADDED", $id);
	$date = gm("DATE", $id);

		echo'
		<tr>
			<td class="stats_h"><nobr>'.$id.'</nobr></td>
			<td class="stats_p"><font size="-1">'.$subject.'</font></td>
			<td class="stats_p"><a target="plaquepreview" href="'.$url.'">'.icons($url, "", "height=\"33\" width=\"33\"").'</a></td>
			<td class="stats_h"><font color="#aaaaff">'.$points.'</font></td>
			<td class="stats_p"><font color="red">'.forums("SUBJECT", $f).'</font></td>
			<td class="stats_h"><font color="#aaaaff">'.$days.'</font></td>
			<td class="stats_g"><a href="index.php?mode=profile&id='.$added.'"><font color="#ffffff">'.members("NAME", $added).'</font></a></td>
			<td class="stats_p" align="middle"><nobr><a href="index.php?mode=svc&method=in&svc=medals&f='.$f.'&m='.$m.'&id='.$id.'">- إختار الوسام -</a></nobr></td>
		</tr>';
}

function svc_show_medals($id){
	global $icon_folder_archive, $icon_question, $icon_camera, $app, $scope, $days;
	$f = medals("FORUM_ID", $id);
	$author = medals("MEMBER_ID", $id);
	$gm = medals("GM_ID", $id);
	$subject = gm("SUBJECT", $gm);
	$url = medals("URL", $id);
	$m_days = medals("DAYS", $id);
	$status = medals("STATUS", $id);
	$points = medals("POINTS", $id);
	$added = medals("ADDED", $id);
	$date = medals("DATE", $id);

	if($status == 1){
		$mon_app = "<font color=\"cyan\">نعم</font>";
	}
	else{
		$mon_app = "<font color=\"yellow\">لا</font>";
	}

	if(allowed($f, 2) == 1){
		$medals_icon = '<a href="index.php?mode=svc&svc=medals&app=all&scope=all&days=all&id='.$gm.'">'.icons($icon_question, "استعمال الوسام", " hspace=\"3\"").'</a>';
	}
	else{
		$medals_icon = "-";
	}

	if(allowed($f, 1) == 1 AND $status != 1){
		$app_box = '<input class="small" type="checkbox" name="m_app[]" value="'.$id.'">';
	}
	else{
		$app_box = " - ";
	}

	if(members("LEVEL", $author) == 1){
		$author_link = '<a href="index.php?mode=profile&id='.$author.'"><font color="#ffffff">'.members("NAME", $author).'</font></a>';
	}
	else{
		$author_link = link_profile(members("NAME", $author), $author);
	}
		echo'
		<tr>';
		if(mlv > 2){
			echo'
			<td class="stats_p" align="center"><nobr>'.$app_box.'</nobr></td>';
		}
			echo'
			<td class="stats_g"><nobr>'.$author_link.'</nobr></td>
			<td class="stats_p"><font color="red">'.normal_date($date).'</font></td>
			<td class="stats_p" align="middle"><font color="black">'.days_added($m_days, $date).'</font></td>
			<td class="stats_g"><font size="-1">'.$subject.'</font></td>
			<td class="stats_p"><a target="plaquepreview" href="'.$url.'">'.icons($icon_camera).'</a></td>
			<td class="stats_h">'.$points.'</td>';
		if($app == "all"){
			echo'
			<td class="stats_h">'.$mon_app.'</td>';
		}
			echo'
			<td class="stats_p"><font color="red">'.forums("SUBJECT", $f).'</font></td>
			<td class="stats_g"><nobr><a href="index.php?mode=profile&id='.$added.'"><font color="#ffffff">'.members("NAME", $added).'</font></a></nobr></td>
			<td class="stats_p" align="middle"><nobr>'.$medals_icon.'</nobr></td>
		</tr>';
}

function svc_show_global_titles($t){
	global $icon_folder_archive, $icon_question;
	$f = gt("FORUM_ID", $t);
	$subject = gt("SUBJECT", $t);
	$status = gt("STATUS", $t);
	$close = gt("CLOSE", $t);
	$forum = gt("FORUM", $t);
	$added = gt("ADDED", $t);

	if($forum == 1){
		$mon_app = "<font color=\"cyan\">نعم</font>";
	}
	else{
		$mon_app = "<font color=\"yellow\">لا</font>";
	}

	if(allowed($f, 2) == 1){
		$medals_icon = '<a href="index.php?mode=svc&method=edit&svc=titles&t='.$t.'">'.icons($icon_folder_archive, "تعديل الوصف", " hspace=\"3\"").'</a>';
		$medals_icon .= '<a href="index.php?mode=svc&method=award&svc=titles&type=used&id='.$t.'">'.icons($icon_question, "استعمال الوصف", " hspace=\"3\"").'</a>';
	}
	else{
		$medals_icon = "-";
	}

	if(allowed($f, 1) == 1 AND $status != 1){
		$app_box = '<input class="small" type="checkbox" name="t_app[]" value="'.$t.'">';
	}
	else{
		$app_box = " - ";
	}

		echo'
		<tr>';
		if(mlv > 2){
			echo'
			<td class="stats_p" align="center"><nobr>'.$app_box.'</nobr></td>';
		}
			echo'
			<td class="stats_h"><nobr>'.$t.'</nobr></td>
			<td class="stats_p"><font size="-1" color="red">'.$subject.'</font></td>
			<td class="stats_h">'.$mon_app.'</td>
			<td class="stats_p"><font color="red">'.forums("SUBJECT", $f).'</font></td>
			<td class="stats_g"><nobr><a href="index.php?mode=profile&id='.$added.'"><font color="#ffffff">'.members("NAME", $added).'</font></a></nobr></td>
			<td class="stats_p" align="center"><nobr>'.$medals_icon.'</nobr></td>
		</tr>';
}

function svc_award_global_titles($id){
	global $m;
	$f = gt("FORUM_ID", $id);
	$subject = gt("SUBJECT", $id);
	$forum = gt("FORUM", $id);

	if($forum == 1){
		$mon_app = "<font color=\"cyan\">نعم</font>";
	}
	else{
		$mon_app = "<font color=\"yellow\">لا</font>";
	}

		echo'
		<tr>
			<td class="stats_h"><nobr>'.$id.'</nobr></td>
			<td class="stats_p"><font size="-1" color="red">'.$subject.'</font></td>
			<td class="stats_h">'.$mon_app.'</td>
			<td class="stats_p"><font color="red">'.forums("SUBJECT", $f).'</font></td>
			<td class="stats_p" align="middle"><nobr><a href="index.php?mode=svc&method=in&svc=titles&f='.$f.'&m='.$m.'&id='.$id.'">- إختار الوصف -</a></nobr></td>
		</tr>';
}

function svc_show_titles($t){
	global $icon_trash, $icon_question;
	$gt_id = titles("GT_ID", $t);
	$member_id = titles("MEMBER_ID", $t);
	$subject = gt("SUBJECT", $gt_id);
	$f = gt("FORUM_ID", $gt_id);
	$forum = gt("FORUM", $gt_id);

	if($status == 1){
		$mon_app = "<font color=\"cyan\">نعم</font>";
	}
	else{
		$mon_app = "<font color=\"yellow\">لا</font>";
	}

	if(allowed($f, 2) == 1){
		$titles_icon = '<a href="index.php?mode=svc&method=award&svc=titles&type=history&m='.$member_id.'&t='.$gt_id.'">'.icons($icon_question, "تاريخ إستخدام الوصف لهذا العضو", " hspace=\"3\"").'</a>';
		$titles_icon .= '<a href="index.php?mode=svc&method=trash&svc=titles&t='.$t.'">'.icons($icon_trash, "إزالة الوصف من العضو", " hspace=\"3\"").'</a>';
	}
	else{
		$titles_icon = "-";
	}
			echo'
			<tr>
				<td class="stats_h"><nobr>'.$t.'</nobr></td>
				<td class="stats_p"><font size="-1" color="red">'.$subject.'</font></td>
				<td class="stats_h">'.$mon_app.'</td>
				<td class="stats_p"><font color="red">'.forums("SUBJECT", $f).'</font></td>
				<td class="stats_p" align="center">'.$titles_icon.'</td>
			</tr>';
}

function svc_survey_value($v){
	$count = 0;
	for ($x = 0;$x < count($v); ++$x){
		if($v[$x] != ""){
			$count = $count + 1;
		}
	}
return($count);
}

function svc_chk_survey_id($f, $subject, $question){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}SURVEYS WHERE FORUM_ID = '$f' AND SUBJECT = '$subject' AND QUESTION = '$question' ", [], __FILE__, __LINE__);
	$rs = mysql_fetch_array($sql);
	$id = $rs['SURVEY_ID'];
return($id);
}

function svc_show_surveys($s){
	global $icon_folder_archive, $icon_question, $icon_trash;
	$f = surveys("FORUM_ID", $s);
	$subject = surveys("SUBJECT", $s);
	$status = surveys("STATUS", $s);
	$secret = surveys("SECRET", $s);
	$days = surveys("DAYS", $s);
	$min_days = surveys("MIN_DAYS", $s);
	$min_posts = surveys("MIN_POSTS", $s);
	$added = surveys("ADDED", $id);
	$start = surveys("START", $s);
	$end = surveys("END", $s);
	if($secret == 0){
		$secret_txt = '<font color="white">غير سري</font>';
	}
	if($secret == 1){
		$secret_txt = '<font color="yellow">سري</font>';
	}
	if(allowed($f, 2) == 1){
		$medals_icon = '<a href="index.php?mode=svc&method=edit&svc=surveys&s='.$s.'">'.icons($icon_folder_archive, "تعديل الإستفتاء", " hspace=\"3\"").'</a>';
		$medals_icon .= '<a href="index.php?mode=svc&method=award&svc=surveys&s='.$s.'">'.icons($icon_question, "من قام بالتصويت", " hspace=\"3\"").'</a>';
	}
			echo'
			<tr>
				<td class="stats_h"><nobr>'.$s.'</nobr></td>
				<td class="stats_g"><nobr>'.$subject.'</nobr></td>
				<td class="stats_p"><font color="red">'.forums("SUBJECT", $f).'</font></td>
				<td class="stats_g"><nobr>'.normal_date($start).'</nobr></td>
				<td class="stats_g"><nobr>'.normal_date($end).'</nobr></td>
				<td class="stats_h"><font color="white">'.$secret_txt.'</font></td>
				<td class="stats_h"><font color="#aaaaff">'.$min_posts.'</font></td>
				<td class="stats_h"><font color="#aaaaff">'.$min_days.'</font></td>
				<td class="stats_p"><nobr>'.$medals_icon.'</nobr></td>
			</tr>';
}

function chk_add_member_to_topic($t, $m){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPIC_MEMBERS WHERE TOPIC_ID = '$t' AND MEMBER_ID = '$m' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($sql) > 0){
		$chk = 1;
	}
	else{
		$chk = 0;
	}
return($chk);
}

function svc_requestmon_body(){
	global $aid, $f, $t, $r, $text, $pm;

	echo'
	<script language="javascript">
		function submit_form(){
			if(moderation_info.moderation_raison.value.length <= 10){
				confirm("يجب إدخال السبب وأن يكون أطول من 10 أحرف.");
				return;
			}
			if(moderation_info.moderators_notes.value.length <= 10){
				confirm("يجب إدخال على الأقل ملاحظة اشرافية وأن تكون أطول من 10 أحرف.");
				return;
			}
		moderation_info.submit();
		}
	</script>
	<br>
	<center>
	<table class="grid" border="0" cellspacing="1" cellpadding="4">
	<form name="moderation_info" method="post" action="index.php?mode=requestmon&type=insert">
	<input type="hidden" name="member_id" value="'.$aid.'">
	<input type="hidden" name="forum_id" value="'.$f.'">
	<input type="hidden" name="topic_id" value="'.$t.'">
	<input type="hidden" name="reply_id" value="'.$r.'">
	<input type="hidden" name="pm" value="'.$pm.'">
		<tr class="fixed">
			<td class="optionheader_selected" colspan="2"><nobr>وضع رقابة على مشاركات العضو أو طلب منع أو طرد</nobr></td>
		</tr>
 		<tr class="fixed">
			<td class="cat" width="100"><nobr>العضو:</nobr></td>
			<td class="list">&nbsp;&nbsp;'.member_name($aid).'</td>
		</tr>';
                                   if($_GET['f']){
 		echo '<tr class="fixed">
			<td class="cat"><nobr>المنتدى:</nobr></td>
			<td class="list">&nbsp;&nbsp;<font color="blue">'.forum_name($f).'</font></td>
		</tr>';
                                    }
                                   if($pm != ""){
                                    $option_pm = ' <option value="10">منع من استعمال الرسائل الخاصة</option>';
                                    }
                                   if(mlv  == 4){
                                    $option_ihdaa = ' <option value="12">منع من إضافة إهدائات</option>';
                                    }

  		echo '<tr class="fixed">
			<td class="cat"><nobr>النوع المطلوب:</nobr></td>
			<td class="list">
			<select class="insidetitle" style="WIDTH: 450px" name="moderation_type" type="text">
                                                          '.$option_pm.'
                                                           '.$option_ihdaa.'
			    <option value="1">وضع رقابة على مشاركات العضو في منتدى معين</option>
			    <option value="2">طلب رقابة كاملة على جميع مشاركات العضو</option>
			    <option value="3">طلب منع من المشاركة في منتدى معين</option>
			    <option value="4">طلب منع المشاركة في جميع المنتديات</option>
			    <option value="5">طلب قفل العضوية</option>
			    <option value="6">طلب منع العضو من دخول النقاش الحي</option>
			    <option value="7">طلب اخفاء توقيع العضو وصورته و بياناته الشخصية</option>
			    <option value="8">طلب اخفاء مشاركات العضو عن باقي الأعضاء</option>
			    <option value="9">طلب اخفاء رسائل العضو الخاصة عن باقي الأعضاء</option>
			    <option value="11">منع العضو من مشاهدة منتدى معين</option>
			</select>
        		</td>
		</tr>
 		<tr class="fixed">
			<td class="cat"><nobr>السبب:<br>(يرسل للعضو)</nobr></td>
			<td class="list"><textarea cols="50" rows="5" name="moderation_raison"></textarea></td>
		</tr>
 		<tr class="fixed">
			<td class="cat"><nobr>يربط ب:</nobr></td>
			<td class="list">&nbsp;&nbsp;<font color="orange">'.$text.'</font></td>
		</tr>
 		<tr class="fixed">
			<td class="cat"><nobr>ملاحظات إشرافية:</nobr></td>
			<td class="list"><textarea cols="50" rows="5" name="moderators_notes"></textarea></td>
		</tr>
 		<tr class="fixed">
			<td align="middle" colspan="2"><input onclick="submit_form()" type="button"  value="تطبيق الرقابة أو إدخال الطلب">&nbsp;&nbsp;&nbsp;<input type="reset" value="إلغاء"></td>
		</tr>
	</form>
	</table>
	</center>';
}

function svc_show_mon($m){
	global $Mlevel, $DBMemberID, $icon_question, 
	$icon_trash, $folder_moderate;
	$status = moderation("STATUS", $m);
	$memberID = moderation("MEMBERID", $m);
	$forumID = moderation("FORUMID", $m);
	$added = moderation("ADDED", $m);
	$type = moderation("TYPE", $m);
	$execute = moderation("EXECUTE", $m);
	$date = moderation("DATE", $m);
	$dateapp = moderation("DATEAPP", $m);
	$datefin = moderation("DATEFIN", $m);
	$end = moderation("END", $m);
	$pm = moderation("PM", $m);

	if($Mlevel > 2 OR chk_moderator($DBMemberID,$forumID) == 1 OR $type == 5 OR $type == 4 OR $type == 2){
		$added_name = member_name($added);
	}
	else {
		$added_name = "--";
	}
	if($Mlevel > 2 OR chk_moderator($DBMemberID, $forumID) == 1){
		$execute = member_name($execute);
	}
	else {
		$execute = "--";
	}
	if($Mlevel > 2 OR chk_moderator($DBMemberID, $forumID) == 1){
		$end = member_name($end);
	}
	else {
		$end = "--";
	}
	switch ($type){
	     case "1": $TYPE = "رقابة في منتدى معين"; break;
	     case "2": $TYPE = "طلب رقابة في جميع المنتديات"; $color = "#FF0000"; break;
	     case "3": $TYPE = "طلب منع  في منتدى معين"; $color = "#FF0000"; break;
	     case "4": $TYPE = "طلب منع  في جميع المنتديات"; $color = "#FF0000"; break;
	     case "5": $TYPE = "طلب قفل العضوية"; $color = "#FF0000"; break;
	     case "6": $TYPE = "طلب منع من دخول النقاش الحي"; $color = "#FF0000"; break;
	     case "7": $TYPE = "إخفاء بيانات العضو"; $color = "#00FFFF"; break;
	     case "8": $TYPE = "إخفاء مشاركات العضو"; $color = "#00FFFF"; break;
	     case "9": $TYPE = "إخفاء رسائل العضو الخاصة"; $color = "#00FFFF"; break;
	     case "10": $TYPE = "منع استعمال الرسائل الخاصة"; $color = "#00FFFF"; break;
	     case "11": $TYPE = "منع مشاهدة منتدى معين"; break;
	     case "12": $TYPE = "منع من إستخدام الإهدائات"; break;

	}

                       $forum_name = forum_name($forumID);

	if($pm){
	    $forum_name = '<div align="center">-- </div>';
	}

		echo'
  		<tr>
    			<td class="stats_h" align="center"><a href="index.php?mode=svc&method=app&svc=mon&type=details&id='.$m.'">'.icons($icon_question, "معلومات أخرى حول الرقابة", "").'</a></td>
    			<td class="stats_g"><font color="yellow">'.member_name($memberID).'</font></td>
    			<td class="stats_t"><font color="'.$color.'" size="2">'.$TYPE.'</font></td>';
    		echo'	<td class="stats_p"><font color="red">'.$forum_name.'</font></td>';
    if($status == 0 OR $status == 2 OR $type == 5 OR $type == 4 OR $type == 2 OR $type == 10){
		echo'	<td class="stats_p"><font color="red">'.$added_name.'</font></td>';
		echo'	<td class="stats_g">'.normal_time($date).'</font></td>';
    }
    else {
		echo'	<td class="stats_p"></td>';
		echo'	<td class="stats_g"></td>';
	}
	if($added == $DBMemberID AND $Mlevel == "2" AND $status == 0){
		echo'	<td class="stats_h" align="center"><a href="index.php?mode=svc&method=trash&svc=mon&type=delete&id='.$m.'" onclick="return confirm(\'هل أنت متأكد من حذف الطلب\');">'.icons($icon_trash, "حذف الطلب", "").'</a></td>';
	}
	else if($Mlevel > 2 AND $status == 0){
		echo'	<td class="stats_h" align="center"><a href="index.php?mode=svc&method=trash&svc=mon&type=reject&id='.$m.'" onclick="return confirm(\'هل أنت متأكد من رفض الطلب\');">'.icons($icon_trash, "رفض الطلب", "").'</a></td>';
	}
	else {
		echo'	<td class="stats_h" align="center"></td>';
	}
	if($status == 0){
    		echo'	<td class="stats_g" align="center" colspan="4"><font color="yellow">-- تحت المراجعة --</font></td>';
	}
	else {
	if($status == 1  OR $status == 3){
		echo'	<td class="stats_p" align="center">'.normal_time($dateapp).'</td>';
		echo'	<td class="stats_g" align="center">'.$execute.'</td>';
	}
	else {
		echo'	<td class="stats_p" align="center"></td>';
		echo'	<td class="stats_g" align="center"></td>';
	}
	if($status == 3){
		echo'	<td class="stats_p" align="center">'.normal_time($datefin).'</td>';
		echo'	<td class="stats_g" align="center">'.$end.'</td>';
	}
	else if($status != "2"){
	    if($Mlevel > 2 OR $added == $DBMemberID){
		echo'	<td class="stats_g" align="center" colspan="2"><a href="index.php?mode=svc&method=trash&svc=mon&type=exp&id='.$m.'" onclick="return confirm(\'هل أنت متأكد من إلغاء الرقابة\');">'.icons($icon_trash, "إلغاء الرقابة", "").'</a></td>';
	    }
	    else {
		echo'	<td class="stats_g" align="center" colspan="2"></td>';
	    }
	}
    }
    if($status == 3){
		echo'	<td class="stats_g" align="center">'.mon_days($datefin, $dateapp).'</td>';
    }
    else {
	echo'	<td class="stats_g" align="center"></td>';
    }
    if($Mlevel > 2 AND $status == 0){
		echo'	<td class="stats_h" align="center"><a href="index.php?mode=svc&method=app&svc=mon&type=details&id='.$m.'">'.icons($folder_moderate, "الموافقة على الطلب", "").'</a></td>';
    }
    else {	
		echo'	<td class="stats_h" align="center"></td>';
    }
echo'
	</tr>';
}

function svc_details_mon($m){
	global $Mlevel, $DBMemberID;

	$status = moderation("STATUS", $m);
	$memberID = moderation("MEMBERID", $m);
	$forumID = moderation("FORUMID", $m);
	$topicID = moderation("TOPICID", $m);
	$replyID = moderation("REPLYID", $m);
	$pm = moderation("PM", $m);
	$type = moderation("TYPE", $m);
	$added = moderation("ADDED", $m);
	$date = moderation("DATE", $m);
	$raison = moderation("RAISON", $m);
	$notes = moderation("NOTES", $m);

	switch ($status){
	    case "0": $STATUS = "تنتظر الموافقة"; break;
	    case "1": $STATUS = "سارية حاليا"; break;
	    case "2": $STATUS = "تم رفضها"; break;
	    case "3": $STATUS = "تم إلغاؤها"; break;
	}
	switch ($type){
	    case "1": $TYPE = "رقابة في منتدى معين"; break;
	    case "2": $TYPE = "طلب رقابة في جميع المنتديات"; break;
	    case "3": $TYPE = "طلب منع  في منتدى معين"; break;
	    case "4": $TYPE = "طلب منع  في جميع المنتديات"; break;
	    case "5": $TYPE = "طلب قفل العضوية"; break;
	    case "6": $TYPE = "طلب منع من دخول النقاش الحي"; break;
	    case "7": $TYPE = "إخفاء توقيع و صورة و بيانات العضو"; break;
	    case "8": $TYPE = "إخفاء مشاركات العضو"; break;
	    case "9": $TYPE = "إخفاء رسائل العضو الخاصة"; break;
	    case "10": $TYPE = "منع الرسائل الخاصة"; break;
	    case "11": $TYPE = "منع من مشاهدة منتدى معين"; break;

	}
	if($replyID == "0"){
	    $rid = "";
	}
	else {
	    $rid = "&r=".$replyID;
	}

	echo'
	<center>
	<table cellSpacing="1" cellPadding="1">';
	if($Mlevel > 2 AND $status == 0){
	echo'
	<form method="post" action="index.php?mode=svc&method=app&svc=mon&type=approve&id='.$m.'">';
	}
	echo'
		<tr>
			<td class="optionsbar_menus" colSpan="15"><font color="red" size="4">معلومات حول الرقابة أو المنع رقم: '.$m.'</font></td>
		</tr>
		<tr>
			<td class="stats_h"><nobr>العضو</nobr></td>
			<td class="stats_h"><nobr>النوع</nobr></td>
			<td class="stats_h"><nobr>المنتدى</nobr></td>';
	if($Mlevel > 2 OR chk_moderator($DBMemberID, $forumID) == 1){
	echo'
			<td class="stats_h" colspan="2"><nobr>تقديم الطلب</nobr></td>';
	}
	echo'
			<td class="stats_h"><nobr>الوضعية</nobr></td>
		</tr>
		<tr>
			<td class="stats_g">'.member_name($memberID).'</td>
			<td class="stats_p"><font color="blue">'.$TYPE.'</font></td>
			<td class="stats_p"><font color="red">'.forum_name($forumID).'</font></td>';
	if($Mlevel > 2 OR chk_moderator($DBMemberID, $forumID) == 1){
	echo'
			<td class="stats_g">'.normal_time($date).'</td>
			<td class="stats_g">'.member_name($added).'</td>';
	}
	echo'
			<td class="stats_h"><font color="yellow">'.$STATUS.'</font></td>
		</tr>
		<tr>
			<td class="optionsbar_menus" colSpan="15"><font color="red" size="4">السبب</font></td>
		</tr>
		<tr>
			<td colSpan="6">
			<table cellSpacing="1" cellPadding="1" class="grid" width="100%">
				<tr class="normal">
					<td class="list">'.$raison.'<br><p align="center" style="margin-top: 0; margin-bottom: 0"><font size="1">';
if($type == 10 ){
                               echo ' <a target="_blank" class="menu" href="index.php?mode=pm&mail=msg&msg='.$pm.'">** إضغط هنا لمشاهدة المشاركة المعنية **</a>';
}else{
 echo ' <a target="_blank" class="menu" href="index.php?mode=t&t='.$topicID.$rid.'">** إضغط هنا لمشاهدة المشاركة المعنية **</a>';
}
					echo '</td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td class="optionsbar_menus" colSpan="15"><font color="red" size="4">ملاحظات اشرافية</font></td>
		</tr>
		<tr>
			<td colSpan="6">
			<table cellSpacing="1" cellPadding="1" class="grid" width="100%">
				<tr class="normal">
					<td class="list">'.$notes.'</td>
				</tr>
			</table>
			</td>
		</tr>';
	if($Mlevel > 2 AND $status == 0){
	echo'
		<tr>
			<td class="optionsbar_menus" colSpan="15"><font color="red" size="4">ملاحظات المراقب</font>
			<br><font color="black" size="2">(غير ضرورية)</font>
			</td>
		</tr>
		<tr>
			<td colSpan="6">
			<table cellSpacing="1" cellPadding="1" class="grid" width="100%">
				<tr class="normal">
					<td class="list"><textarea class="insidetitle" style="WIDTH: 100%; HEIGHT: 70px" name="monitor_notes" type="text" rows="1" cols="20"></textarea></td>
				</tr>
			</table>
			</td>
		</tr>';
	}
	if($Mlevel > 2 AND $status == 0 AND $type == 7){
	echo'
		<tr>
			<td class="optionsbar_menus" colSpan="15"><font color="red" size="4">نوع البيانات</font></td>
		</tr>
		<tr>
			<td colSpan="6">
			<table cellSpacing="1" cellPadding="1" class="grid" width="100%">
				<tr class="normal">
					<td class="list" align="center">
					<input class="small" type="radio" value="1" name="details_type">الصورة الشخصية&nbsp;&nbsp;&nbsp;
					<input class="small" type="radio" value="2" name="details_type">التوقيع&nbsp;&nbsp;&nbsp;
					<input class="small" type="radio" value="3" name="details_type">كل البيانات
					</td>
				</tr>
			</table>
			</td>
		</tr>';
	}
	echo'
		<tr>
			<td colSpan="6" align="center"><br>';
	if($Mlevel > 2 AND $status == 0){
	echo'
			<input type="submit" value="تأكيد الموافقة على الطلب" onclick="return confirm(\'هل أنت متأكد من الموافقة على الطلب\');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	echo'
			<input type="button" value="إرجع" onclick="history.go(-1)">
			</td>
		</tr>
	<table>
	</center>';
}

function survey_body($s){
	global $t, $DBMemberID, $DBMemberPosts, $DBMemberDate, $icon_pbw, $icon_pb;
	
	$subject = surveys("SUBJECT", $s);
	$question = surveys("QUESTION", $s);
	$status = surveys("STATUS", $s);
	$secret = surveys("SECRET", $s);
	$days = surveys("DAYS", $s);
	$min_days = surveys("MIN_DAYS", $s);
	$min_posts = surveys("MIN_POSTS", $s);
	$end = surveys("END", $s);

	echo'
	<center>
	<hr noShade SIZE="1">
	<table class="surveyTable" cellSpacing="1" cellPadding="2" border="0">
		<tr>
			<td class="surveyQuestion" colSpan="4">'.$subject.'</td>
		</tr>
		<tr>
			<td class="surveyHeader">الخيار</td>
			<td class="surveyHeader">عدد الأصوات</td>
			<td class="surveyHeader" colSpan="2">النسبة</td>
		</tr>';
	$survey_options = $mysql->execute("SELECT * FROM {$mysql->prefix}SURVEY_OPTIONS WHERE SURVEY_ID = '$s' ORDER BY SURVEY_ID ASC ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($survey_options);
	$x=0;
	while ($x < $num){
	        $so_id = mysql_result($survey_options, $x, "SO_ID");
		//$option = survey_option("OPTION_ID", $so_id);
		$value = survey_option("VALUE", $so_id);
		$other = survey_option("OTHER", $so_id);

		$votes = $mysql->execute("SELECT * FROM {$mysql->prefix}VOTES WHERE MEMBER_ID = '$DBMemberID' AND SURVEY_ID = '$s' ", [], __FILE__, __LINE__);
		$rs=mysql_fetch_array($votes);
		$option_id = $rs['OPTION_ID'];

		if($status == 0){
			$td_class = "surveyResultText";
			$text1 = "تم اغلاق هذا الاستفتاء.";
			$href = "";
		}
		else {
			$href = "<a href='index.php?mode=t&t=".$t."&vote=".$so_id."'>";

			if(member_total_days($DBMemberDate) < $min_days){
			    	$td_class = "surveyResultText";
			   	$text1 = "يجب أن يكون عدد الأيام منذ تسجيلك أكبر من العدد الموضح أسفله.";
				$href = "";
			}
			else if($DBMemberPosts < $min_days){
		    		$td_class = "surveyResultText";
		   		$text1 = "يجب أن يكون عدد مشاركاتك أكبر من العدد الموضح أسفله.";
				$href = "";
			}
			else if($option_id == $so_id){
			    	$td_class = "surveyResultTextVoted";
			   	$text1 = "يمكنك التصويت بالضغط على أحد الخيارات أعلاه.";
				$href = "";
			}
			else if($option_id !== $so_id){
		    		$td_class = "surveyResultText";
			    	$text1 = "يمكنك التصويت بالضغط على أحد الخيارات أعلاه.";
			}
		}
		if($secret == 0){
			$votes_count = votes_count($so_id);
			$percent = option_percentage($so_id, $s)."%";
			$precent_icon = "<img height='12' src='".$icon_pb."' width='".option_percentage($so_id, $s)."'><img height='12' src='".$icon_pbw."' width='".pb_percentage($so_id, $s)."'>";
		}
		else {
			$votes_count = "- سري -";
			$percent = "";
			$precent_icon = "<img height='12' src='".$icon_pb."' width='0'><img height='12' src='".$icon_pbw."' width='100'>";
		}

  		echo'
		<tr>
			<td class="'.$td_class.'">'.$href.$value.'</a><br>'.$other.'</td>
			<td class="surveyResultNumber">'.$votes_count.'</td>
			<td class="surveyResultPercentage" dir="ltr">'.$percent.'</td>
			<td class="surveyResultPercentage">'.$precent_icon.'</td>
		</tr>';
  
	++$x;
	}
		echo'
		<tr>
			<td class="surveyHeader">إجمالي الأصوات:</td>
			<td class="surveyHeader">';
			if($secret == 0){
			echo total_votes($s);
			}
			else {
			echo'0';
			}
			echo'	
			</td>
			<td class="surveyHeader" dir="ltr">100%</td>
			<td class="surveyResultPercentage">&nbsp;</td>
		</tr>
	</table>
	<font color="red">ملاحظة: '.$text1.'<hr noShade SIZE="1">لا يسمح بالتصويت في هذا الاستفتاء<br>إلا للأعضاء المطابقون للمواصفات التالية:<br>
	<table class="surveyTable" cellSpacing="1" cellPadding="2" border="0" id="table5">
		<tr>
			<td class="surveyResultTextVoted">&nbsp;</td>
			<td class="surveyResultTextVoted">العدد الحالي</td>
			<td class="surveyResultTextVoted">العدد الإدنى</td>
		</tr>
		<tr>
			<td class="surveyResultText">المشاركات</td>
			<td class="surveyHeader">'.$DBMemberPosts.'</td>
			<td class="surveyHeader">'.$min_posts.'</td>
		</tr>
		<tr>
			<td class="surveyResultText">الأيام منذ تسجيل العضو</td>
			<td class="surveyHeader">'.member_total_days($DBMemberDate).'</td>
			<td class="surveyHeader">'.$min_days.'</td>
		</tr>
	</table>
	</center>
	</center>';
}

function edits_time($date){
    global $function_to_day, $function_yester_day;
    $DateYear=date("Y",$date);
    $DateMonth=date("m/",$date);
    $DateDay=date("d/",$date);
    $DateTime=date("H:i:s",$date);
        $edits_time=$DateDay.$DateMonth.$DateYear." ".$DateTime;

    return($edits_time);
}

function svc_topic_edits($t){
	$subject = topics("SUBJECT", $t);	
	$author = topics("AUTHOR", $t);
		echo'
		<tr>
			<td class="optionsbar_menus" colSpan="5">
			<font color="red" size="+1">التغييرات على الموضوع رقم : <a href="index.php?mode=t&t='.$t.'">'.$t.'</a></font><br>
			<font size="+1"><a class="menu" href="index.php?mode=t&t='.$t.'">'.$subject.'</a></font><br>
			<font size="+1">الكاتب : '.link_profile(member_name($author), $author).'</a></font>
			</td>
		</tr>
		<tr>
			<td class="stats_h">الرقم</td>
			<td class="stats_h">التاريخ والوقت</td>
			<td class="stats_h">قام بالتغيير</td>
			<td class="stats_h">تغيير العنوان</td>
			<td class="stats_h">تغيير النص</td>
		</tr>';
		$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}EDITS_INFO WHERE TOPIC_ID = '$t' ORDER BY DATE ASC", [], __FILE__, __LINE__);
		$num = mysql_num_rows($sql);
		if($num == 0){
		echo'
		<tr>
			<td class="stats_h" colSpan="5"><br>لم يتم أي تغيير على الموضوع<br><br></td>
		</tr>';
		}
		$x = 0;
		while ($x < $num){
			$n = $x+1;
			$e = mysql_result($sql, $x, "EDIT_ID");
			$e_author = edits("MEMBER_ID", $e);
			$old_subject = edits("OLD_SUBJECT", $e);
			$old_message = edits("OLD_MESSAGE", $e);
			$new_subject = edits("NEW_SUBJECT", $e);
			$new_message = edits("NEW_MESSAGE", $e);
			$date = edits("DATE", $e);
		    if($old_subject !== $new_subject){ $sub_edited = "نعم"; }
		    else { $sub_edited = "لا"; }
		    if($old_message !== $new_message){ $mess_edited = "نعم"; }
		    else { $mess_edited = "لا"; }

		echo'
		<tr>
			<td class="stats_h"><nobr><a href="index.php?mode=svc&method=details&svc=edits&type=t&n='.$n.'&id='.$e.'">'.$n.'</a></nobr></td>
			<td class="stats_g"><nobr>'.edits_time($date).'</nobr></td>
			<td class="stats_p"><nobr><font size="2">'.link_profile(member_name($e_author), $e_author).'</font><nobr></td>
			<td class="stats_g"><nobr><font color="red">'.$sub_edited.'</font></nobr></td>
			<td class="stats_g"><nobr><font color="red">'.$mess_edited.'</font></nobr></td>
		</tr>';
		++$x;
		}
		if($num > 0){
		echo'
		<tr>
			<td class="optionsbar_menus" colSpan="5">إضغط على رقم التغيير لمعرفة تفاصيله</td>
		</tr>';
		}
}

function svc_topic_edits_details($id, $n){
			$old_subject = edits("OLD_SUBJECT", $id);
			$old_message = edits("OLD_MESSAGE", $id);
			$new_subject = edits("NEW_SUBJECT", $id);
			$new_message = edits("NEW_MESSAGE", $id);
			    if($old_subject !== $new_subject){ $sub_edited = 1; }
			    else { $sub_edited = 0; }
			    if($old_message !== $new_message){ $mess_edited = 1; }
			    else { $mess_edited = 0; }
			echo'
			<center>
			<table cellSpacing="1" cellPadding="1" border="1" width="80%">
			<form method="post" action="index.php?mode=svc&method=update&svc=edits&type=t&id='.$id.'"
				<tr>
					<td bgColor="red"><font size="+1" color="white">التغيير رقم: '.$n.'</font></td>
				</tr>';
			if($sub_edited == 1){
				echo'
				<tr>
					<td class="stats_p"><font size="2" color="red">العنوان السابق للتغيير كان:</font></td>
				</tr>
				<tr>
					<td>'.$old_subject.'</td>
				</tr>';
			}
			if($mess_edited == 1){
				echo'
				<tr>
					<td class="stats_p"><font size="2" color="red">النص السابق للتغيير كان:</font></td>
				</tr>
				<tr>
					<td>'.$old_message.'</td>
				</tr>';
			}
				echo'
				<tr>
					<td class="stats_h"><br><input type="submit" value="أرجع نص المشاركة الى هذا النص"><br><br></td>
				</tr>
			</from>
			</table>
			</center>';
}

function svc_reply_edits($r){
	$t = replies("TOPIC_ID", $r);
	$subject = topics("SUBJECT", $t);
	$author = replies("AUTHOR", $r);
		echo'
		<tr>
			<td class="optionsbar_menus" colSpan="5">
			<font color="red" size="+1">التغييرات على الرد رقم : <a href="index.php?mode=t&t='.$t.'&r='.r.'">'.$r.'</a></font><br>
			<font size="+1">الموضوع: <a class="menu" href="index.php?mode=t&t='.$t.'">'.$subject.'</a></font><br>
			<font size="+1">الكاتب : '.link_profile(member_name($author), $author).'</a></font>
			</td>
		</tr>
		<tr>
			<td class="stats_h">الرقم</td>
			<td class="stats_h">التاريخ والوقت</td>
			<td class="stats_h">قام بالتغيير</td>
		</tr>';
		$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}EDITS_INFO WHERE REPLY_ID = '$r' ORDER BY DATE ASC", [], __FILE__, __LINE__);
		$num = mysql_num_rows($sql);
		if($num == 0){
		echo'
		<tr>
			<td class="stats_h" colSpan="5"><br>لم يتم أي تغيير على الرد<br><br></td>
		</tr>';
		}
		$x = 0;
		while ($x < $num){
			$n = $x+1;
			$e = mysql_result($sql, $x, "EDIT_ID");
			$e_author = edits("MEMBER_ID", $e);
			$old_message = edits("OLD_MESSAGE", $e);
			$new_message = edits("NEW_MESSAGE", $e);
			$date = edits("DATE", $e);
		echo'
		<tr>
			<td class="stats_h"><nobr><a href="index.php?mode=svc&method=details&svc=edits&type=r&n='.$n.'&id='.$e.'">'.$n.'</a></nobr></td>
			<td class="stats_g"><nobr>'.edits_time($date).'</nobr></td>
			<td class="stats_p"><nobr><font size="2">'.link_profile(member_name($e_author), $e_author).'</font><nobr></td>
		</tr>';
		++$x;
		}
		if($num > 0){
		echo'
		<tr>
			<td class="optionsbar_menus" colSpan="5">إضغط على رقم التغيير لمعرفة تفاصيله</td>
		</tr>';
		}
}

function svc_reply_edits_details($id, $n){
	$old_message = edits("OLD_MESSAGE", $id);
	echo'
	<center>
	<table cellSpacing="1" cellPadding="1" border="1" width="80%">
	<form method="post" action="index.php?mode=svc&method=update&svc=edits&type=r&id='.$id.'"
		<tr>
			<td bgColor="red"><font size="+1" color="white">التغيير رقم: '.$n.'</font></td>
		</tr>
		<tr>
			<td class="stats_p"><font size="2" color="red">النص السابق للتغيير كان:</font></td>
		</tr>
		<tr>
			<td>'.$old_message.'</td>
		</tr>
		<tr>
			<td class="stats_h"><br><input type="submit" value="أرجع نص المشاركة الى هذا النص"><br><br></td>
		</tr>
	</from>
	</table>
	</center>';
}

?>