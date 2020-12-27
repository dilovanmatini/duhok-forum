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

require_once("./include/svc_func.df.php");
include ("ads3.php");

// ########################################### Permission ##################################

if($CAN_SHOW_TOPIC == 1 AND mlv == 0){
die('<br><center>
		<table width="99%" border="1">
			<tr class="normal">
				<td class="list_center" colSpan="10"><font size="5" color="red"><br>لا يمكنك مشاهدة المواضيع لانك لست عضوا بالمنتدى  </font><br>ان كنت عضوا معنا فبرجاء تسجيل الدخول الى حسابك من الخيار اعلاه<br>وان لم تكن مسجلا , اضغط على الرابط اسفله للتسجيل .<br><br><a href="index.php?mode=policy">'.icons($details).'<br>'.$lang['header']['register'].'</a><br><br>
				</td>
			</tr>
		</table>
		</center>');
}

$mod_ShowForum = mod_ShowForum($DBMemberID, $f);

if($mod_ShowForum == 1 ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[forum][out].'
'.$lang[forum][go_out].'<br>
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}

// ########################################### Permission ##################################

function nav_sup($t){
	global $reply_num_page,$pg,$icon_go_right,$icon_go_up,$icon_go_left,$icon_go_down,$icon_blank,$icon_contract,$icon_expand;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}REPLY WHERE TOPIC_ID = '$t' ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
	$cols = ceil($num / $reply_num_page);


	if($cols > 1){

if($pg != 0 AND $pg != 1){
$pg_to = $pg - 1;
 echo '<td class="optionsbar_menus"><a href="index.php?mode=t&amp;t='.$t.'&amp;pg='.$pg_to.'">'.icons($icon_go_right,"الصفحة السابقة").'</a></td>';
}else{
echo ' <td class="optionsbar_menus">'.icons($icon_blank,"").'</td>';
}

if($pg != $cols){
$pg_to = $pg + 1;
 echo '<td class="optionsbar_menus"><a href="index.php?mode=t&amp;t='.$t.'&amp;pg='.$pg_to.'">'.icons($icon_go_left,"الصفحة التالية").'</a></td>';
}else{
echo ' <td class="optionsbar_menus">'.icons($icon_blank,"").'</td>';
}

if($pg != 0 AND $pg != 1){
 echo '<td class="optionsbar_menus"><a href="index.php?mode=t&amp;t='.$t.'&amp;pg=1">'.icons($icon_go_up,"الصفحة الأولى").'</a></td>';
}else{
echo ' <td class="optionsbar_menus">'.icons($icon_blank,"").'</td>';
}

if($pg != $cols){
 echo '<td class="optionsbar_menus"><a href="index.php?mode=t&amp;t='.$t.'&amp;pg='.$cols.'">'.icons($icon_go_down,"الصفحة الاخيرة").'</a></td>';
}else{
 echo '<td class="optionsbar_menus">'.icons($icon_blank,"").'</td>';
}
}

 echo '<td class="optionsbar_menus"><img onclick="expand_all()" alt="عرض جميع المشاركات بالكامل" src="'.$icon_expand.'" height="15"width="15"></td>';

 echo '<td class="optionsbar_menus"><img onclick="contract_all()" alt="تصغير عرض جميع المشاركات "
 src="'.$icon_contract.'" height="15" width="15"></td>';

}

//######################################### SURVEY TOOLS BY MR TAZI #########################################
$f = topics("FORUM_ID", $t);
$survey_id = topics("SURVEYID", $t);

if($survey_id > 0){
	$days = surveys("DAYS", $survey_id);
	$min_days = surveys("MIN_DAYS", $survey_id);
	$min_posts = surveys("MIN_POSTS", $survey_id);
	$end = surveys("END", $survey_id);
	$date = time();

	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}VOTES WHERE TOPIC_ID = '$t' AND MEMBER_ID = '$DBMemberID' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($sql) > 0){
	$rs = mysql_fetch_array($sql);
	$OptionID = $rs['OPTION_ID'];
	}

	if($date > $end){
		close_survey($survey_id);
	}

	if($Mlevel > 0){
		if($OptionID != "" AND $vote != "" AND member_total_days($DBMemberDate) > $min_days AND $DBMemberPosts > $min_posts){
			update_vote($vote, $survey_id, $DBMemberID, $date);
		}
		else if($vote != "" AND member_total_days($DBMemberDate) > $min_days AND $DBMemberPosts > $min_posts){
			vote($survey_id, $vote, $f, $t, $DBMemberID, $date);
		}
	}
}
//######################################### SURVEY TOOLS BY MR TAZI #########################################

function close_survey($id){
   global $Prefix;
   $mysql->execute("UPDATE {$mysql->prefix}SURVEYS SET SECRET = '0', STATUS = '0' WHERE SURVEY_ID = '$id' ", [], __FILE__, __LINE__);
}

function topic_show_medals($id){
	global $show_medals_in_posts, $unknown;
	$m = members("MEDAL", $id);
	$gm_id = medals("GM_ID", $m);
	$subject = gm("SUBJECT", $gm_id);
	$url = medals("URL", $m);
	$days = medals("DAYS", $m);
	$date = medals("DATE", $m);
	$add_days = $days*60*60*24;
	$add_days = $add_days + $date;
	
	if($show_medals_in_posts == 2 AND $add_days > time()){
		$show_medal = '<table border="0" cellSpacing="1"><tr><td><img onerror="this.src=\''.$unknown.'\';" src="'.$url.'" border="0" height="100" width="100"></td></tr></table>';
	}
	else if($show_medals_in_posts == 1 AND $add_days > time()){
		$show_medal = '
		<table cellSpacing="4" cellPadding="3" width="100" border="0">
			<tr>
				<td bgColor="gray" align="middle"><font color="yellow" size="-2">آخر وسام للعضو:</font><br><font color="white" size="-2">'.$subject.'</font></td>
			</tr>
		</table>';
	}
	else{
		$show_medal = '';
	}
return($show_medal);
}

function topic_show_titles($m, $f){
	$member_title = members("TITLE", $m);
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TITLES WHERE MEMBER_ID = '$m' AND STATUS = '1' ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
	$x= 0;
	while($x < $num){
		$t = mysql_result($sql, $x, "TITLE_ID");
		$gt = titles("GT_ID", $t);
		$f_id = gt("FORUM_ID", $gt);
		$forum = gt("FORUM", $gt);
		$subject = gt("SUBJECT", $gt);
		if($forum == 0 AND $f_id == $f){
			$show_title .= $subject.'<br>';
		}
		if($forum == 1){
			$show_title .= '<font color="blue">'.$subject.'</font><br>';
		}
	++$x;
	}
	if(!empty($member_title)){
		$member_title = $member_title.'<br>';
	}
	else{
		$member_title = '';
	}
	if(!empty($show_title) OR members("OLD_MOD", $m) > 0){
		$show_title = ''.old_mod($m, "-1", "small").'<font size="-1"><small>'.$member_title.$show_title.'</small></font>';
	}
	else{
		$show_title = '';
	}
return($show_title);
}

function member_show_photo($m, $f){
	global $icon_blank;
	$photo_url = members("PHOTO_URL", $m);
	$member_hide_photo = members("HIDE_PHOTO", $m);
	$forum_hide_photo = forums("HIDE_PHOTO", $f);
		if($member_hide_photo == 0 AND $forum_hide_photo == 0){
		    $photo = '<img onerror="this.src=\''.$icon_blank.'\';this.width=0;" src="'.$photo_url.'" width="100"><br>';
		}
		else {
		    $photo = "";
		}
return($photo);
}

function member_hide_details($m){
	$hide_details  = members("HIDE_DETAILS", $m);
		if($hide_details == 1){
		    $hide = 1;
		}
		else {
		    $hide = 0;
		}
return($hide);
}

function show_sig(){
	global $f, $m, $show_sig, $_SERVER;
	$forum_hide_sig = forums("HIDE_SIG", $f);
	if($forum_hide_sig == 0){
	echo'
	<form method="post" action="'.$_SERVER[REQUEST_URI].'">
	<td class="optionsbar_menus" vAlign="top"><nobr>التواقيع<br>
		<select style="WIDTH: 70px" name="show_sig" onchange="submit();">
			<option value="hide" '.check_select($show_sig, "hide").'>مخفيّة</option>
			<option value="show" '.check_select($show_sig, "show").'>ظاهرة</option>
		</select></nobr>
	</td>
	</form>';
	}
}

function chk_member_hide_posts($m){
    global $Prefix;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$m' AND M_HIDE_POSTS = '1' ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
    	if($num > 0){
            $chk_mhps = 1;
	}
	else {
	    $chk_mhps = 0;
	}
    return($chk_mhps);
}

function message_sig($f, $m, $message, $show_sig, $sig){
    global $lang;
	$forum_hide_sig = forums("HIDE_SIG", $f);
	$member_hide_sig = members("HIDE_SIG", $m);	
			echo'
			<table style="TABLE-LAYOUT: fixed">
				<tr>
					<td><div id="to_hidd">';
					echo text_replace($message);
					if($show_sig == "show" AND !empty($sig) AND $forum_hide_sig == 0 AND $member_hide_sig == 0){
						echo'<br><br>
						<FIELDSET style="width: 100%; text-align: center">
							<legend>&nbsp;<font color="black">'.$lang['topics']['the_signature'].'</font></legend>
							'.text_replace($sig).'
						</FIELDSET>
						';
					}
					echo'
					</div></td>
				</tr>';
}

function topic_head($t){
	global $icon_print, $icon_reply_topic, $lang, $folder_new, $icon_subscribe, $max_page, $reply_num_page, $Mlevel,$icon_send_topic;
	$c = topics("CAT_ID", $t);
	$f = topics("FORUM_ID", $t);
	$f_subject = forums("SUBJECT", $f);
	$f_logo = forums("LOGO", $f);

                  $f_level = forums("F_LEVEL", $f);
                   if($f_level > 0 AND mlv < $f_level){
                           redirect();
                  }

	echo'
	<table cellSpacing="2" width="100%" border="0">
		<tr>
			<td><a class="menu" href="index.php?mode=f&f='.$f.'">'.icons($f_logo).'</a></td>
			<td class="main" vAlign="center" width="100%"><a class="menu" href="index.php?mode=f&f='.$f.'"><font color="red" size="+1">'.$f_subject.'</font></a></td>';
		if($Mlevel > 0){
			echo'
			<td class="optionsbar_menus" vAlign="top"><nobr><a href="index.php?mode=editor&method=reply&t='.$t.'&f='.$f.'&c='.$c.'">'.icons($icon_reply_topic, $lang['topics']['reply_to_this_topic']).'<br>'.$lang['topics']['add_reply'].'</a></nobr></td>
			<td class="optionsbar_menus" vAlign="top"><nobr><a href="index.php?mode=editor&method=topic&f='.$f.'&c='.$c.'">'.icons($folder_new, $lang['topics']['add_new_topic']).'<br>'.$lang['topics']['new_topic'].'</a></nobr></td>
<td class="optionsbar_menus" vAlign="top"><nobr><a href="index.php?mode=tellfriend&t='.$t.'">'.icons($icon_send_topic, "أرسل هدا الموضوع الى صديق").'<br>أرسل</a></nobr></td>
			<td class="optionsbar_menus" vAlign="top"><nobr><a href="index.php?mode=topicmonitor&t='.$t.'&f='.$f.'&c='.$c.'">'.icons($icon_subscribe, $lang['topics']['add_monitor'], "").'<br>'.$lang['topics']['monitor'].'</a></nobr></td>
<td class="optionsbar_menus" vAlign="top"><nobr><a href="index.php?mode=p&t='.$t.'&f='.$f.'&c='.$c.'"">'.icons($icon_print, $lang['topics']['reply_to_this_topic']).'<br>طباعة</a></nobr></td>
';
		}
			show_sig();
			reply_num_page();
			echo multi_page("REPLY WHERE TOPIC_ID = '$t'", $reply_num_page);
			go_to_forum();
		echo'
		</tr>
	</table>';
}



function topic_title($t,$show){
	global $lang, $folder, $folder_locked,$total_post_close_topic,$pg;
	$status = topics("STATUS", $t);
	$subject = topics("SUBJECT", $t);
                  $f_hidden = topics("FORUM_ID", $t);
                  $c_hidden = topics("CAT_ID", $t);
                  $t_reply = mysql_num_rows($mysql->execute("select * from {$mysql->prefix}REPLY where TOPIC_ID = '$t' "));
                  $r_reply = topics("REPLIES",$t);

if($show == 0 AND $r_reply >= $total_post_close_topic AND !$pg OR $show == 0 AND $r_reply >= $total_post_close_topic AND $pg == 1){
echo '<table border="0" cellpadding="4" cellspacing="1"
 dir="rtl" width="100%">
  <tbody>
    <tr>
      <td align="middle" bgcolor="white" valign="top">'.icons($folder_locked,"").'</td>
      <td colspan="3" align="middle" bgcolor="white"
 valign="top" width="100%"><font color="red">لا
يمكن إضافة مشاركات لهذا الموضوع لأنه تجاوز الحد الأقصى للمشاركات في هذا
المنتدى. <font color="gray">('.$total_post_close_topic.' رد) </font></font></td>
    </tr>
  </tbody>
</table>
';
}

		echo'
		<table class="optionsbar" cellSpacing="2" width="100%" border="0">
			<tr>
				<td vAlign="center">&nbsp;';
				if($status == 1){
				    echo icons($folder, $lang['topics']['topic_is_opened']);
				}
				if($status == 0){
				    echo icons($folder_locked, $lang['topics']['topic_is_locked']);
				}
				echo'</td>';
if($show == 1 AND allowed($f_hidden, 2) == 1 AND $t_reply != 0){
echo'
<form name="check" method="post" action="index.php?mode=lock&type=check">
<input type="hidden" name="typehiddel" value="0">
<input type="hidden" name="hidden_f" value="'.$f_hidden.'">
<input type="hidden" name="hidden_t" value="'.$t.'">
<input type="hidden" name="hidden_c" value="'.$c_hidden.'">
<td class="optionsbar_title" vAlign="center" align="middle" width="100%">&nbsp;'.$subject.'
<td class="optionsbar_menus2"><input class="small" onclick="checkAll()" value="اختيار كامل" type="button"></td>
<td class="optionsbar_menus2"><input class="small" onclick="delAll()" value="مسح الاختيار" type="button"></td>
<td class="optionsbar_menus2"><a href="javascript:hid_el();"><img border="0" src="images/icons/icon_hidden.gif" alt="اخفاء المشاركات المختارة" onclick="return confirm(\' هل أنت متأكد من أنك تريد إخفاء الردود المختارة ؟\');"  ></a></td>
<td class="optionsbar_menus2"><a href="javascript:del_el();"><img border="0" src="images/icons/icon_delete_reply.gif" alt="حدف المشاركات المختارة"onclick="return confirm(\' هل أنت متأكد من أنك تريد حذف الردود المختارة ؟\');"  ></a></td>
</td>
';
echo'<td class="optionsbar_title" vAlign="center" align="middle" width="100%">&nbsp;'.nav_sup($t).'</td>';

}else{
echo'<td class="optionsbar_title" vAlign="center" align="middle" width="100%">&nbsp;'.$subject.'</td>';
echo'<td class="optionsbar_title" vAlign="center" align="middle" width="100%">&nbsp;'.nav_sup($t).'</td>';

}
echo'</tr></table>';
}

function topic_quick_reply($t){
	global $lang, $icon_reply_topic, $http_host, $DBMemberID;

echo '</form>';

$allowed = 1;
$f = topics("FORUM_ID", $t);
if(members("SEX", $DBMemberID) == 0 AND forums("SEX", $f) == 2 OR forums("SEX", $f) == 1){
$allowed = 0;
}

if(forums("STATUS", $f) == 0 AND mlv != 4){
$allowed = 0;
}

if(topics("ARCHIVED", $t) == 1 AND mlv != 4){
$allowed = 0;
}

if(members("SEX", $DBMemberID) == 1 AND forums("SEX", $f) == 2){
$allowed = 0;
}
if(members("SEX", $DBMemberID) == 2 AND forums("SEX", $f) == 1){
$allowed = 0;
}


if(members("QUICK_POSTS", $DBMemberID) == 1){
$allowed = 0;
}

if(allowed($f, 2) == 1){
$allowed = 1;
}

if($allowed == 1){
	$status = topics("STATUS", $t);
	$f = topics("FORUM_ID", $t);
	$c = topics("CAT_ID", $t);
		echo'
		<script language="javascript">
			function submitQuickReplyForm(){
				var x = quickreply.message.value;
				while ((x.substring(0,1) == \' \') || (x.substring(0,1) == \'\r\') || (x.substring(0,1) == \'\n\') || (x.substring(0,1) == \'\t\'))
					x = x.substring(1);
					quickreply.message.value = x;
				if(quickreply.message.value.length < 3) return;
					quickreply.submit();
			}
		</script>
		<tr>
			<form name="quickreply" method="post" action="index.php?mode=post_info">
			<td vAlign="top" align="middle" bgColor="white"><br>'.icons($icon_reply_topic).'<br><br><font color="red">'.$lang['topics']['add_quick_reply'].'</font></td>
			<td vAlign="top" align="middle" width="100%" bgColor="white" colSpan="3">';
if(editor_type == 0){
echo'
	 					<script language="JavaScript" type="text/javascript" src="wysiwyg.js">
</script>
<body>			<textarea id="textarea1" name="message" style="'.$editor_style.'">
</textarea>

<script language="javascript1.2">
  generate_wysiwyg ("textarea1");
</script>'

;}



else { echo'
<textarea style="WIDTH: 100%;HEIGHT: 150px;'.M_Style_Form.'" name="message" rows="1" cols="20"></textarea>';
}
echo'			<input name="method" type="hidden" value="reply">
			<input name="t" type="hidden" value="'.$t.'">
			<input name="f" type="hidden" value="'.$f.'">
			<input name="c" type="hidden" value="'.$c.'">
			<input name="host" type="hidden" value="'.$http_host.'">
			<input name="type" type="hidden" value="q_reply">';
if(editor_type == 0){
echo'
<input type="submit" id="button" value="'.$lang['topics']['add_reply_to_this_topic'].'" />'
;} 

else { echo'
<input onclick="submitQuickReplyForm()" type="button" value="'.$lang['topics']['add_reply_to_this_topic'].'">';
}


		if(allowed($f, 2) == 1){
			if($status == 1){
				echo'&nbsp;&nbsp;<input name="ReplyAndLock" type="submit" value="'.$lang['topics']['add_reply_and_lock_topic'].'">';
			}
		}
		if(allowed($f, 2) == 1){
			if($status == 0){
				echo'&nbsp;&nbsp;<input name="ReplyAndUnLock" type="submit" value="'.$lang['topics']['add_reply_and_open_topic'].'">';
			}
		}
			echo'
			</td>
		</form>
		</tr>';
}
}

function footer_infos ($date, $info, $mid){
   if($mid > 0){
   $Name = link_profile(member_name($mid), $mid);
	echo normal_time_last($date).'&nbsp;:&nbsp;<font color="black">'.$info.'&nbsp; '.$Name.' </font><br>';
   }
}


function topic_first($t){
	global
		$show_admin_info, $lang, $icon_blank, $Mlevel, $icon_online, $icon_private_message,
		$icon_profile, $show_sig, $DBMemberID, $icon_edit, $icon_poll, $icon_who_poll,
		$icon_trash_poll, $icon_lock, $icon_unlock, $icon_delete_reply, $icon_unhidden,
		$icon_hidden, $icon_group, $icon_moderation, $folder_moderate, $icon_folder_archive,
		$icon_question, $icon_stats, $icon_reply_topic, $icon_msg_red, $icon_go_up,
		$icon_complain,$icon_contract,$CAN_SHOW_TOPIC,$icon_posticon_hold , $icon_archived ,$icon_unarchived;

	$c = topics("CAT_ID", $t);
	$f = topics("FORUM_ID", $t);
	$m = topics("AUTHOR", $t);
	$message = topics("MESSAGE", $t);
	$date = topics("DATE", $t);
	$status = topics("STATUS", $t);
	$hidden = topics("HIDDEN", $t);
	$hidden_by = topics("HIDDEN_BY", $t);
	$hidden_date = topics("HIDDEN_DATE", $t);
	$last_edit_date = topics("LASTEDIT_DATE", $t);
	$last_edit_make = topics("LASTEDIT_MAKE", $t);
	$lock_date = topics("LOCK_DATE", $t);
	$lock_make = topics("LOCK_MAKE", $t);
	$open_date = topics("OPEN_DATE", $t);
	$open_make = topics("OPEN_MAKE", $t);
	$edit_num = topics("ENUM", $t);
	$survey_id = topics("SURVEYID", $t);
	$unmoderated = topics("UNMODERATED", $t);
	$moderated_by = topics("MODERATED_BY", $t);
	$moderated_date = topics("MODERATED_DATE", $t);
	$holded = topics("HOLDED", $t);
	$holded_by = topics("HOLDED_BY", $t);
	$holded_date = topics("HOLDED_DATE", $t);
	$moved = topics("MOVED", $t);
	$moved_by = topics("MOVED_BY", $t);
	$moved_date = topics("MOVED_DATE", $t);
	$deleted_by = topics("DELETED_BY", $t);
	$deleted_date = topics("DELETED_DATE", $t);
	$unhidden = topics("UNHIDDEN", $t);
	$unhidden_by = topics("UNHIDDEN_BY", $t);
	$unhidden_date = topics("UNHIDDEN_DATE", $t);
	$sticky = topics("STICKY", $t);
	$sticky_by = topics("STICKY_BY", $t);
	$sticky_date = topics("STICKY_DATE", $t);
	$unsticky_by = topics("UNSTICKY_BY", $t);
	$unsticky_date = topics("UNSTICKY_DATE", $t);
	$archived = topics("ARCHIVED", $t);


	$level = members("LEVEL", $m);
	$m_status = members("STATUS", $m);
	$posts = members("POSTS", $m);
	$photo_url = members("PHOTO_URL", $m);
	$country = members("COUNTRY", $m);
	$m_date = members("DATE", $m);
	$sig = members("SIG", $m);
	$points = member_all_points($m);
	$stars = member_stars($m);
	$online = member_is_online($m);
	$browse = members("BROWSE", $m);
	$Name = link_profile(member_name($m), $m);
	if($hidden == 1){
		$td_class = "deleted";
	}
	else if($unmoderated == 1){
		$td_class = "unmoderated";
	}
	else if($holded == 1){
		$td_class = "deleted";
	}
	else if($hidden == 0 && $unmoderated == 0){
		$td_class = "first";
	}

                                if($CAN_SHOW_TOPIC == 2 AND mlv == 0){
	                       $message = substr($message, 0, 500 - 3).'...<span style="color: rgb(255, 0, 0)">يتوجب عليك التسجيل لمشاهدة الموضوع كاملا</span>';
                                }
                                if(members("TOPICS_SHOW", $DBMemberID) == 1  ){
	                       $message = substr($message, 0, 0).'<span style="color: rgb(255, 0, 0)">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
							'.$lang[permission][sorry].' 
							'.$lang[permission][TOPICS_SHOW].'<br>
							'.$lang[permission][contact].'
</font><br><br><br> </span>';}
 if(members("LOCK_TOPICS", $m ) == 0 AND allowed($f, 2) == 0 ){
	                       $message = substr($message, 0, 0).'<span style="color: rgb(255, 0, 0)">
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus"><font color="red">** مواضيع هذه العضوية مخفية بواسطة الإدارة **</font></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>

</font><br><br><br> </span>'
;}
		echo'
		<tr>
			<td width="12%" vAlign="top" class="'.$td_class.'">';
			if($level == 4 AND $show_admin_info == 0){
				echo admin_link($m);
echo '<div id="first_info">';
}
			else{
								echo ''.$Name.' <div id="first_info">';
												if($m_status == 0){
					echo'
					<font size="1"><nobr>'.$lang['topics']['member_is_locked'].'</nobr></font>';
				}
				else if($Mlevel > 0 AND (member_hide_details($m) == 0 OR allowed($f, 2) == 1)){
					echo'
					<font size="-1"><nobr><small>'.$lang['topics']['posts'].'&nbsp;'.$posts.'</small></nobr></font><br>';
					if($points > 0 AND $level == 1){
						echo'
						<font color="red" size="-1"><nobr><small>'.$lang['topics']['points'].'&nbsp;'.$points.'</small></nobr></font><br>';
					}
					if($stars != ""){
						echo'<font size="-1"><nobr><small>'.$stars.'</small></nobr></font><br>';
					}
					if(topic_show_titles($m, $f) != ""){
						echo topic_show_titles($m, $f);
					}
					else{
                      if(members("SEX", $m) == 2){
						echo '<font size="-1" color="purple"><small>'.member_title($m).'</small></font><br>';
                        } else {
                        echo '<font size="-1"><small>'.member_title($m).'</small></font><br>';
                        }
					}
echo '<div id="first_user_info">';
					if(topic_show_medals($m) != ""){
						echo topic_show_medals($m);
					}
					if(member_show_photo($m, $f) != ""){
						echo member_show_photo($m, $f);
					}
					if($country != ""){
						echo'<font size="-1"><nobr><small>'.$country.'</small></nobr><br>';
					}
					echo'
					<font size="-1"><nobr><small>'.$lang['topics']['number_days_of_register'].'&nbsp;'.member_total_days($m_date).'</small></nobr><br>';
					echo'
					<font size="-1"><nobr><small>'.$lang['topics']['member_middle_posts'].'&nbsp;'.member_middle_posts($posts, $m_date).'</small></nobr><br>';
					if($online == 1 AND $browse == 1 OR $online == 1 AND $Mlevel > 1){
						echo'
						<table border="0">
							<tr>
								<td class="optionsbar_menus2">'.icons($icon_online).'<br><font size="1">'.$lang['profile']['status_online'].'</font></td>
							</tr>
						</table>';
					}
				}
			}
			echo'</div></div>
			</td>
			<td vAlign="top" width="100%" class="'.$td_class.'" colSpan="3">
			<table cellSpacing="0" cellPadding="0" width="100%">
				<tr>
					<td class="posticon" bgColor="red">
					<table cellSpacing="2" width="100%">
						<tr>
							<td class="posticon"><nobr>'.normal_time($date).'</nobr></td>
							<td class="posticon"><nobr><a href="index.php?mode=profile&id='.$m.'">'.icons($icon_profile, $lang['topics']['member_info']).'</a></nobr></td>';
				if($Mlevel > 0){
						if(allowed($f, 2) == 1 OR $status == 1 AND $DBMemberID == $m){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=editor&method=edit&t='.$t.'&f='.$f.'&c='.$c.'">'.icons($icon_edit, $lang['topics']['edit_topic']).'</a></nobr></td>';
						}
						if(allowed($f, 2) == 1){
				echo'
							<td class="posticon"><nobr><a href="index.php?mode=editor&method=sendmsg&m='.$m.'&from='.abs2($f).'">'.icons($icon_msg_red, $lang['topics']['send_message_from_mod_to_this_member']).'</a></nobr></td>';
				}
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=editor&method=sendmsg&m='.$m.'&svc=t&id='.$t.'&tdate='.base64_encode($date).'">'.icons($icon_private_message, $lang['topics']['send_message_to_this_member']).'</a></nobr></td>';
                           if($m != $DBMemberID){
                            echo'
							<td class="posticon"><nobr><a href="index.php?mode=notify&m='.$m.'&t='.$t.'">'.icons($icon_complain, $lang['topics']['complain']).'</a></nobr></td>';
                 }
                 						if($hidden == 0 AND mlv > 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=lock&type=h&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_hide_this_topic'].'\');">'.icons($icon_hidden, $lang['topics']['hide_topic']).'</a></nobr></td>';
						}
                 
						/*
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=editor&method=sendmsg&quote='.abs2($t).'&m='.$m.'&author='.$m.'&tdate='.base64_encode($date).'">'.icons($icon_msg_red, "رد على الموضوع بإضافة نص هذه المشاركة", "").'</a></nobr></td>';
						*/
					if(allowed($f, 2) == 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=option&t='.$t.'" >'.icons($icon_folder_archive, "تغيير خصائص الموضوع").'</a></nobr></td>';
						if($status == 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=lock&type=t&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_lock_this_topic'].'\');">'.icons($icon_lock, $lang['topics']['lock_topic']).'</a></nobr></td>';
						}
						if($status == 0){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=open&type=t&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_open_this_topic'].'\');">'.icons($icon_unlock, $lang['topics']['open_topic']).'</a></nobr></td>';
						}
						if(allowed($f, 2) == 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=delete&type=t&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_delete_this_topic'].'\');">'.icons($icon_delete_reply, $lang['topics']['delete_topic']).'</a></nobr></td>';
						}
                        if(allowed($f, 1) == 1 AND $status == 2){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=open&type=tt&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_return_this_topic'].'\');">'.icons($icon_go_up, $lang['topics']['return_topic']).'</a></nobr></td>';
						}
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=svc&svc=prv&t='.$t.'">'.icons($icon_group, 'قائمة الأعضاء المخولون برؤية هذا الموضوع المخفي', "").'</a></nobr></td>';
						if(allowed($f, 2) == 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=requestmon&aid='.$m.'&t='.$t.'&f='.$f.'&c='.$c.'" >'.icons($icon_moderation, 'تطبيق رقابة على العضو').'</a></nobr></td>';
						}
						if($unmoderated == 1 OR $holded == 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=moderate&type=t&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_moderated_this_topic'].'\');">'.icons($folder_moderate, $lang['topics']['moderate_topic']).'</a></nobr></td>';
						}
				if($holded != 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=moderate&type=th&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_hold_this_topic'].'\');">'.icons($icon_posticon_hold, $lang['topics']['hold_topic']).'</a></nobr></td>';
}
						if($hidden == 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=open&type=h&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_show_this_topic'].'\');">'.icons($icon_unhidden, $lang['topics']['show_topic']).'</a></nobr></td>';
						}
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=svc&svc=tstats&t='.$t.'" >'.icons($icon_stats, "").'</a></nobr></td>';
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=svc&svc=edits&t='.$t.'" >'.icons($icon_question, "").'</a></nobr></td>';
						if($archived == 0 AND $Mlevel == 4){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=open&type=ar&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_archive_this_topic'].'\');">'.icons($icon_archived, $lang['topics']['archive_topic']).'</a></nobr></td>';
						}
						if($archived == 1 AND $Mlevel == 4){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=open&type=uar&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_unarchive_this_topic'].'\');">'.icons($icon_unarchived, $lang['topics']['unarchive_topic']).'</a></nobr></td>';
						}
					}
				}
							echo'
							<td class="posticon" width="90%">&nbsp;</td>';
if(allowed($f, 2) == 1){
echo '<td class="posticon"><img onclick="document.getElementById(\'first_info\').style.display = \'block\';document.getElementById(\'msg_first\').style.display = \'block\'" alt="تكبير عرض المشاركة" src="'.$icon_group.'"></td>';
echo '<td class="posticon"><img onclick="document.getElementById(\'first_info\').style.display = \'none\';document.getElementById(\'msg_first\').style.display = \'none\'" alt="تصغير عرض المشاركة" src="'.$icon_contract.'">';
}

						echo '</tr>
					</table>
					</td>
				</tr>
			</table>';
echo '<div id="msg_first">';
							 if(members("LOCK_TOPICS", $m ) == 0 AND allowed($f, 2) == 1 ){
							 echo'
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus"><font color="red">'.$lang[lock][topics_is_hidden].'</font></td>
							</font>											</tr>
					</table>
					</td>
				</tr>
			</table>';

		}
		if(chk_member_hide_posts($m) == 1){
			echo'
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus"><font color="red">** مشاركات هذه العضوية مخفية بواسطة الإدارة **</font></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>';
			if(allowed($f, 2) == 1){
			message_sig($f, $m, $message, $show_sig, $sig);
			}
			else {
			message_sig("", "", "", "", "");
			}
		}
		else if($hidden == 1){
			echo'
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus">'.$lang['topics']['hide_reply_info'].'</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>';
			message_sig($f, $m, $message, $show_sig, $sig);
		}
		else if($unmoderated == 1){
			echo'
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus">'.$lang['topics']['unmoderated_reply_info'].'</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>';
			message_sig($f, $m, $message, $show_sig, $sig);
		}
        	else if($status == 2){
             $name = members("NAME", $deleted_by);
			echo'
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus">** هذا المواضوع محذوف بواسطة '.$name.'**</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>';
            message_sig($f, $m, $message, $show_sig, $sig);
            }
		else if($holded == 1){
			echo'
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus">'.$lang['topics']['holded_reply_info'].'</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>';
			message_sig($f, $m, $message, $show_sig, $sig);
		}

		else {
			message_sig($f, $m, $message, $show_sig, $sig);
		}

			if($survey_id > 0){
				echo'
				<tr>
					<td align="left" valign="bottom">';
					survey_body($survey_id);
					echo'
					</td>
				</tr>';
			}

echo '</div>';

		if(($Mlevel > 0 && chk_member_hide_posts($m) == 0) || allowed($f, 2) == 1){
			if($last_edit_make != "" OR $lock_make != "" OR $open_make != "" OR $deleted_by > 0 OR $hidden_by > 0 OR $unhidden_by > 0 OR $moderated_by > 0 OR $sticky_by > 0 OR  $holded_by > 0 OR $moved_by > 0){
				echo'
				<tr>
					<td align="left" valign="bottom">
					<table dir="rtl" cellSpacing="1" cellPadding="0" bgColor="red">
						<tr>
							<td class="editedby">';
						if($status == 2 && allowed($f, 1) == 1){
						footer_infos ($deleted_date, "تم حذف الموضوع بواسطة", $deleted_by);
						}
						if(allowed($f, 2) == 1){
						footer_infos ($hidden_date, "تم اخفاء الموضوع بواسطة", $hidden_by);
						}
						if($unhidden == 0 && allowed($f, 2) == 1){
						footer_infos ($unhidden_date, "تم ازالة اخفاء الموضوع بواسطة", $unhidden_by);
						}
						if($moved == 1 && allowed($f, 2) == 1){
						footer_infos ($moved_date, "تم نقل الموضوع بواسطة", $moved_by);
						}
						if($sticky == 1 && allowed($f, 2) == 1){
						footer_infos ($sticky_date, "تم تثبيت الموضوع بواسطة", $sticky_by);
						}
						if($sticky == 0 && allowed($f, 2) == 1){
						footer_infos ($unsticky_date, "تم ازالة تثبيت الموضوع بواسطة", $unsticky_by);
						}
						if($moved == 1 && allowed($f, 2) == 1){
						footer_infos ($moved_date, "تم نقل الموضوع بواسطة", $moved_by);
						}
						if(allowed($f, 2) == 1){
						footer_infos ($holded_date, "تم تجميد الموضوع بواسطة", $holded_by);
						}
						if($moderated_by > 0){
						footer_infos ($moderated_date, "تمت الموافقة على الموضوع بواسطة", $moderated_by);
						}
						if($lock_make != "" ){
						$Name = link_profile(member_name($lock_make), $lock_make);
							echo normal_time_last($lock_date).'&nbsp;:&nbsp;<font color="black">'.$lang['open']['the_topic_is_locked_by'].'&nbsp;'.$Name.' </font><br>';
						}
						
							if($open_make != ""){
							$Name = link_profile(member_name($open_make), $open_make);
								echo normal_time_last($open_date).'&nbsp;:&nbsp;<font color="black">'.$lang['open']['the_topic_is_re_opened_by'].'&nbsp;'.$Name.'</font><br>';
							}
						
						if($last_edit_make != ""){
						$Name = link_profile(member_name($last_edit_make), $last_edit_make);
							echo normal_time_last($last_edit_date).'&nbsp;:&nbsp;<font color="black">'.$lang['last_edit']['text_last_edit_by'].'&nbsp;'.$Name.'</font><br>';
							if($edit_num > 1){
								echo'<font color="gray">'.$lang['last_edit']['number_edit_text'].':&nbsp;'.$edit_num.'';
							}
						}
							echo'
							</td>
						</tr>
					</table>
					</td>
				</tr>';
			}
		}	
			echo'
			</table>
			</td>
		</tr>';

}

function topic_replies($r, $td_class, $m_get, $r_get){
	global
		$show_admin_info, $lang, $icon_blank, $Mlevel, $icon_online, $icon_private_message,
		$icon_profile, $show_sig, $DBMemberID, $icon_edit, $icon_unhidden, $icon_hidden, $icon_group,
		$x, $icon_delete_reply, $icon_single, $icon_group, $icon_moderation, $folder_moderate,
		$icon_question, $icon_reply_topic, $icon_msg_red, $icon_go_up, $icon_complain,$icon_contract ,$icon_posticon_hold
	;

	$message = replies("MESSAGE", $r);
	$date = replies("DATE", $r);
	$r_status = replies("STATUS", $r);
	$deleted_by  = replies("DELETED_BY", $r);
	$deleted_date  = replies("DELETED_DATE", $r);
	$hidden = replies("HIDDEN", $r);
	$hidden_by = replies("HIDDEN_BY", $r);
	$hidden_date = replies("HIDDEN_DATE", $r);
	$unmoderated = replies("UNMODERATED", $r);
	$moderated_by = replies("MODERATED_BY", $r);
	$moderated_date = replies("MODERATED_DATE", $r);
	$holded = replies("HOLDED", $r);
	$holded_by = replies("HOLDED_BY", $r);
	$holded_date = replies("HOLDED_DATE", $r);
	$le_date = replies("LE_DATE", $r);
	$le_make = replies("LE_MAKE", $r);
	$edit_num = replies("EDIT_NUM", $r);
	
	$c = replies("CAT_ID", $r);
	$f = replies("FORUM_ID", $r);
	$t = replies("TOPIC_ID", $r);
	$m = replies("AUTHOR", $r);
	$level = members("LEVEL", $m);
	$status = members("STATUS", $m);
	$posts = members("POSTS", $m);
	$photo_url = members("PHOTO_URL", $m);
	$country = members("COUNTRY", $m);
	$m_date = members("DATE", $m);
	$sig = members("SIG", $m);
	$points = member_all_points($m);
	$stars = member_stars($m);
	$online = member_is_online($m);
	$browse = members("BROWSE", $m);
	$Name = link_profile(member_name($m), $m);

                                if(members("POSTS_SHOW", $DBMemberID) == 1  ){
	                       $message = substr($message, 0, 0).'<span style="color: rgb(255, 0, 0)">
	                       
	                       

	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
							'.$lang[permission][sorry].' 
							'.$lang[permission][POSTS_SHOW].'<br>
							'.$lang[permission][contact].'
</font><br><br><br>
	                       </span>';}

 if(members("LOCK_POSTS", $m ) == 0 AND allowed($f, 2) == 0  ){
	                       $message = substr($message, 0, 0).'<span style="color: rgb(255, 0, 0)">
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus"><font color="red">** ردود هذه العضوية مخفية بواسطة الإدارة **</font></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>

</font><br><br><br> </span>'
;}

	if($m_get > 0){
		echo'
		<tr>
			<td align="center" bgcolor="red" colspan="5"><font color="white">'.$lang['topics']['show_sigle_member_reply'].' <a href="index.php?mode=t&t='.$t.'"><font color="yellow">'.$lang['topics']['click_here'].'</font></a></font></td>
		</tr>';
	}
	if($r_get > 0){
		$open_sql = "AND REPLY_ID = '$r'";
		echo'
		<tr>
			<td align="center" bgcolor="red" colspan="5"><font color="white">'.$lang['topics']['show_sigle_reply'].' <a href="index.php?mode=t&t='.$t.'"><font color="yellow">'.$lang['topics']['click_here'].'</font></a></font></td>
		</tr>';
	}
		echo'
		<tr>
			<td width="12%" vAlign="top" class="'.$td_class.'">';
			if($level == 4 AND $show_admin_info == 0){
				echo admin_link($m);
echo '<div id="reply'.$r.'"></div>';
			}
			else{
echo ''.$Name.' <div id="reply'.$r.'">';
				if($status == 0){
					echo'
					<font size="1"><nobr>'.$lang['topics']['member_is_locked'].'</nobr></font>';
				}
				else if($Mlevel > 0 AND (member_hide_details($m) == 0 OR allowed($f, 2) == 1)){
					echo'
					<font size="-1"><nobr><small>'.$lang['topics']['posts'].'&nbsp;'.$posts.'</small></nobr></font><br>';
					if($points > 0 AND $level == 1){
						echo'
						<font color="red" size="-1"><nobr><small>'.$lang['topics']['points'].'&nbsp;'.$points.'</small></nobr></font><br>';
					}
					if($stars != ""){
						echo'<font size="-1"><nobr><small>'.$stars.'</small></nobr></font><br>';
					}
					if(topic_show_titles($m, $f) != ""){
						echo topic_show_titles($m, $f);
					}
					else{
                        if(members("SEX", $m) == 2){
						echo '<font size="-1" color="purple"><small>'.member_title($m).'</small></font><br>';
                        } else {
                        echo '<font size="-1"><small>'.member_title($m).'</small></font><br>';
                        }
					}
echo '<div id="user_info">';
					if(topic_show_medals($m) != ""){
						echo topic_show_medals($m);
					}
					if(member_show_photo($m, $f) != ""){
						echo member_show_photo($m, $f);
					}
					if($country != ""){
						echo'<font size="-1"><nobr><small>'.$country.'</small></nobr><br>';
					}
					echo'
					<font size="-1"><nobr><small>'.$lang['topics']['number_days_of_register'].'&nbsp;'.member_total_days($m_date).'</small></nobr><br>';
					echo'
					<font size="-1"><nobr><small>'.$lang['topics']['member_middle_posts'].'&nbsp;'.member_middle_posts($posts, $m_date).'</small></nobr><br>';
					if($online == 1 AND $browse == 1 OR $online == 1 AND $Mlevel > 1){
						echo'
						<table border="0">
							<tr>
								<td class="optionsbar_menus2">'.icons($icon_online).'<br><font size="1">'.$lang['profile']['status_online'].'</font></td>
							</tr>
						</table>';
					}
				}
			}
			echo'</div></div>
			</td>
			<td vAlign="top" width="100%" class="'.$td_class.'" colSpan="3">
			<table cellSpacing="0" cellPadding="0" width="100%">
				<tr>
					<td class="posticon" bgColor="red">
					<table cellSpacing="2" width="100%">
						<tr>
							<td class="posticon"><nobr>'.normal_time($date).'</nobr></td>
							<td class="posticon"><nobr><a href="index.php?mode=profile&id='.$m.'">'.icons($icon_profile, $lang['topics']['member_info']).'</a></nobr></td>';
				if($Mlevel > 0){
				if(allowed($f, 2) == 1){
				echo'
							<td class="posticon"><nobr><a href="index.php?mode=editor&method=sendmsg&m='.$m.'&from='.abs2($f).'">'.icons($icon_msg_red, $lang['topics']['send_message_from_mod_to_this_member']).'</a></nobr></td>';
				}
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=editor&method=sendmsg&m='.$m.'&svc=r&id='.$r.'&rdate='.base64_encode($date).'">'.icons($icon_private_message, $lang['topics']['send_message_to_this_member']).'</a></nobr></td>';

                           if($m != $DBMemberID){
                            echo'
							<td class="posticon"><nobr><a href="index.php?mode=notify&m='.$m.'&t='.$t.'">'.icons($icon_complain, $lang['topics']['complain']).'</a></nobr></td>';
                 }

							echo'<td class="posticon"><nobr><a href="index.php?mode=editor&method=reply&quote='.abs2($r).'&r='.$r.'&t='.$t.'&f='.$f.'&c='.$c.'&author='.$m.'&rdate='.base64_encode($date).'">'.icons($icon_reply_topic, "رد على الموضوع بإضافة نص هذه المشاركة", "").'</a></nobr></td>';
						if(allowed($f, 2) == 1 OR $DBMemberID == $m){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=editor&method=editreply&r='.$r.'&t='.$t.'&f='.$f.'&c='.$c.'">'.icons($icon_edit, $lang['topics']['edit_reply']).'</a></nobr></td>';
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=delete&type=r&r='.$r.'&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_delete_this_reply'].'\');">'.icons($icon_delete_reply, $lang['topics']['delete_reply']).'</a></nobr></td>';
						}
					if(allowed($f, 2) == 1){
						if(allowed($f, 2) == 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=requestmon&aid='.$m.'&r='.$r.'&t='.$t.'&f='.$f.'&c='.$c.'" >'.icons($icon_moderation, 'تطبيق رقابة على العضو').'</a></nobr></td>';
						}
						if($unmoderated == 1 OR $holded == 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=moderate&type=r&r='.$r.'&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_moderated_this_reply'].'\');">'.icons($folder_moderate, $lang['topics']['moderate_reply']).'</a></nobr></td>';
						}
												if($holded != 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=moderate&type=rh&r='.$r.'&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_hold_this_reply'].'\');">'.icons($icon_posticon_hold, $lang['topics']['hold_reply']).'</a></nobr></td>';
}

						if($r_status == 2){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=open&type=rr&r='.$r.'&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_return_this_reply'].'\');">'.icons($icon_go_up,  $lang['topics']['return_reply']).'</a></nobr></td>';
							}
						if($hidden == 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=open&type=hr&r='.$r.'&t='.$t.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_show_this_reply'].'\');">'.icons($icon_unhidden, $lang['topics']['show_reply']).'</a></nobr></td>';
						}
}
						if($hidden == 0 AND mlv > 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=lock&type=hr&r='.$r.'&f='.$f.'&c='.$c.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_hide_this_reply'].'\');">'.icons($icon_hidden, $lang['topics']['hide_reply']).'</a></nobr></td>';
						}
if(allowed($f, 2) == 1){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=svc&svc=edits&r='.$r.'">'.icons($icon_question, "").'</a></nobr></td>';
					}
						if($Mlevel > 0){
							echo'
							<td class="posticon"><nobr><a href="index.php?mode=t&t='.$t.'&r='.$r.'">'.icons($icon_single, $lang['topics']['just_this_reply']).'</a></nobr></td>
							<td class="posticon"><nobr><a href="index.php?mode=t&t='.$t.'&m='.$m.'">'.icons($icon_group, $lang['topics']['reply_this_member']).'</a></nobr></td>';
						}
				}
					echo'<td class="posticon" width="90%">&nbsp;</td>';
if(allowed($f, 2) == 1){
echo '<td class="posticon"><img onclick="document.getElementById(\'reply'.$r.'\').style.display = \'block\';document.getElementById(\'msg'.$r.'\').style.display = \'block\'" alt="تكبير عرض المشاركة" src="'.$icon_group.'"></td>';
echo'<td class="posticon"><nobr><input type="checkbox" name="check[]" value="'.$r.'"></nobr></td>';
echo '<td class="posticon"><img onclick="document.getElementById(\'reply'.$r.'\').style.display = \'none\';document.getElementById(\'msg'.$r.'\').style.display = \'none\'" alt="تصغير عرض المشاركة" src="'.$icon_contract.'"></td>';
}
						echo'</tr></table></td></tr></table>';

echo '<div id="msg'.$r.'">';
							 if(members("LOCK_POSTS", $m ) == 0 AND allowed($f, 2) == 1 ){
							 echo'
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus"><font color="red">'.$lang[lock][posts_is_hidden].'</font></td>
							</font>											</tr>
					</table>
					</td>
				</tr>
			</table>';

		}


		if(chk_member_hide_posts($m) == 1){
			echo'
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus"><font color="red">** مشاركات هذه العضوية مخفية بواسطة الإدارة **</font></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>';
			if(allowed($f, 2) == 1){
			message_sig($f, $m, $message, $show_sig, $sig);
			}
			else {
			message_sig("", "", "", "", "");
			}
		}
		else if($r_status == 2){
		$delete_name = members("NAME", $deleted_by);
			echo'
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus"><font color="blue">** هذه المشاركة محذوفة بواسطة '.$delete_name.'**</font></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>';
			message_sig($f, $m, $message, $show_sig, $sig);
		}
		else if($hidden == 1){
			echo'
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus">'.$lang['topics']['hide_reply_info'].'</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>';
			message_sig($f, $m, $message, $show_sig, $sig);
		}
		else if($unmoderated == 1){
			echo'
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus">'.$lang['topics']['unmoderated_reply_info'].'</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>';
			message_sig($f, $m, $message, $show_sig, $sig);
		}
		else if($holded == 1){
			echo'
			<table cellSpacing="1" cellPadding="4" width="100%" border="0">
				<tr>
					<td vAlign="top" width="100%" colSpan="3">
					<table class="optionsbar" width="100%">
						<tr>
							<td class="optionsbar_menus">'.$lang['topics']['holded_reply_info'].'</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>';
			message_sig($f, $m, $message, $show_sig, $sig);
		}
		else {
			message_sig($f, $m, $message, $show_sig, $sig);
		}
echo '</div>';
		if(($Mlevel > 0 && chk_member_hide_posts($m) == 0) || allowed($f, 2) == 1){
			if($le_make != "" OR ($deleted_by > 0 && allowed($f, 2) == 1) OR ($hidden_by > 0 && allowed($f, 2) == 1) OR $moderated_by > 0 OR $holded_by > 0){
				echo'
				<tr>
					<td align="left" valign="bottom">
					<table dir="rtl" cellSpacing="1" cellPadding="0" bgColor="red">
						<tr>
							<td class="editedby">';
						if($r_status == 2 && allowed($f, 2) == 1){
						footer_infos ($deleted_date, "تم حذف الرد بواسطة", $deleted_by);
						}
						if($hidden == 1 && allowed($f, 2) == 1){
						footer_infos ($hidden_date, "تم اخفاء الرد بواسطة", $hidden_by);
						}
						if($holded == 1 && $holded_by > 0 && allowed($f, 2) == 1){
						footer_infos ($holded_date, "تم تجميد الرد بواسطة", $holded_by);
						}
						if($moderated_by > 0){
						footer_infos ($moderated_date, "تمت الموافقة على الرد بواسطة", $moderated_by);
						}
						if($le_make != ""){
							echo normal_time_last($le_date).'&nbsp;:&nbsp;<font color="black">'.$lang['last_edit']['text_last_edit_by'].'&nbsp;'.$le_make.'</font><br>';
							if($edit_num > 1){
								echo'<font color="gray">'.$lang['last_edit']['number_edit_text'].':&nbsp;'.$edit_num.'';
							}
						}
							echo'
							</td>
						</tr>
					</table>
					</td>
				</tr>';
			}
		}	
			echo'
			</table>
			</td>
		</tr>';
}

function topic_func($t){
	global $lang, $Mlevel, $reply_num_page, $r, $m, $pg,$total_post_close_topic;
	$f = topics("FORUM_ID", $t);
	$status = topics("STATUS", $t);

if($total_post_close_topic){
$mysql->execute("UPDATE {$mysql->prefix}TOPICS SET T_STATUS = ('0') WHERE T_REPLIES >= $total_post_close_topic  AND FORUM_ID = '$f' ", [], __FILE__, __LINE__);
}

	echo'
	<center>
	<table cellSpacing="0" cellPadding="0" width="99%" border="0">
		<tr>
			<td>';
			topic_head($t);
			topic_title($t,1);
			echo'
			<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
				<tr>
					<td>
					<table cellSpacing="1" cellPadding="4" width="100%" border="0">';
					if(empty($r)){
						if(empty($pg) OR $pg <= 1){
						topic_first($t);
						}
					}
					if($r > 0){
						$open_sql = "AND REPLY_ID = '$r'";
					}
					if($m > 0){
						$open_sql = "AND R_AUTHOR = '$m'";
					}
					$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}REPLY WHERE TOPIC_ID = '$t' ".$open_sql." ORDER BY R_DATE ASC LIMIT ".pg_limit($reply_num_page).", $reply_num_page", [], __FILE__, __LINE__);
					$num = mysql_num_rows($sql);
					$x = 0;
					while ($x < $num){
						$r_id = mysql_result($sql, $x, "REPLY_ID");
						$hidden = replies("HIDDEN", $r_id);
						$unmoderated = replies("UNMODERATED", $r_id);
						$holded = replies("HOLDED", $r_id);
						$r_status = replies("STATUS", $r_id);
						if($r_status == 2){
							$td_class = "deleted";
						}
						else if($hidden == 1){
							$td_class = "deleted";
						}
						else if($unmoderated == 1){
							$td_class = "unmoderated";
						}
						else if($holded == 1){
							$td_class = "freezed";
						}
						else {

							if($x % 2){
								$td_class = "fixed";
							}
							else{
								$td_class = "normal";
							}
						}
						if(chk_load_reply($r_id) == 1 AND ($r_status == 1 OR allowed($f, 1) == 1)){
							topic_replies($r_id, $td_class, $m, $r);
						}
					++$x;
					}
                    $allowed = 1;

					if(allowed($f, 2) == 1 OR $status == 1 AND $Mlevel > 0){
						topic_quick_reply($t);
					}

					echo'	
					</table>
					</td>
				</tr>
			</table>';
			topic_title($t,0);
			topic_head($t);
			echo'
			</td>
		</tr>
	</table>
	</center>';
}
if(chk_load_topic($t) == 1){
	$mysql->execute("UPDATE {$mysql->prefix}TOPICS SET T_COUNTS = T_COUNTS + 1 WHERE TOPIC_ID = '$t' ", [], __FILE__, __LINE__);
	topic_func($t);
}
else{
	go_to("index.php?mode=msg&err=t");
}
	include ("ads4.php");
?>