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

function all_forum($f){
	global $Prefix;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM ORDER BY FORUM_ID ASC ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
	$x = 0;
	while ($x < $num){
		$forum_id = mysql_result($sql, $x, "FORUM_ID");
		$f_subject = mysql_result($sql, $x, "F_SUBJECT");
		$f_hide = forums("HIDE", $forum_id);
		$check_forum_login = check_forum_login($forum_id);

		if($f_hide == 0 OR $f_hide == 1 AND $check_forum_login == 1){
			echo'<option value="'.$forum_id.'" '.check_select($f, $forum_id).'>'.$f_subject.'</option>';
		}

	++$x;
	}
}

if($type == ""){

	
$f = topics("FORUM_ID", $t);

	$t_status = topics("STATUS", $t);
	$t_subject = topics("SUBJECT", $t);
	$t_sticky = topics("STICKY", $t);
	$t_hidden = topics("HIDDEN", $t);
	$t_top = topics("TOP", $t);
	$t_link = topics("LINKFORUM", $t);
	$t_archive = topics("ARCHIVE_FLAG", $t);
	$survey_id = topics("SURVEYID", $t);

	if(allowed($f, 2) == 1){

		echo'
		<script language="javascript">
			function submit_form(){
				if(topic_info.TopicSubject.value.length == 0){
					confirm("يجب عليك إدخال عنوان للموضوع.");
					return;
				}
			topic_info.submit();
			}
		</script>
		<div align="center">
		<form method="POST" name="topic_info" action="index.php?mode=option&type=edit">
		<input type="hidden" name="t" value="'.$t.'">
		<table cellSpacing="1" cellPadding="5" bgColor="gray" border="0">
			<tr class="fixed">
				<td class="optionheader" colspan="1"><nobr>'.$lang['editor']['topic_address'].'</nobr></td>
				<td colspan="4" class="list"><input type="text" size="50" name="TopicSubject" value="'.$t_subject.'">&nbsp;&nbsp;</td>
			</tr>
			<tr class=""fixed"">
				<td class="optionheader" colspan="1">الإستفتاء:</td>
				<td colspan="5" class="userdetails_data"><nobr>
				<select class="insidetitle" style="WIDTH: 310px" name="TopicSurvey">
					<option value="0">** لا إستفتاء لهذا الموضوع **</option>';
					$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}SURVEYS WHERE FORUM_ID = '$f' ORDER BY SURVEY_ID ASC ", [], __FILE__, __LINE__);
					$num = mysql_num_rows($sql);
					$x = 0;
					while ($x < $num){
						$s = mysql_result($sql, $x, "SURVEY_ID");
						$s_subject = surveys("SUBJECT", $s);
						$s_status = surveys("STATUS", $s);
						if($s_status == 0){ $status_txt = "مقفل - "; }
						else { $status_txt = ""; }
						echo'<option value="'.$s.'"';
						if($s == $survey_id){ echo' selected'; }
						echo'>'.$status_txt.$s_subject.'</option>';
					++$x;
					}
				echo'
				</select>
				</nobr></td>
			</tr>
			<tr class=""fixed"">
				<td class="optionheader" colspan="1">'.$lang['all']['forum'].'</td>
				<td colspan="5" class="userdetails_data"><nobr>
				<select class="insidetitle" style="WIDTH: 310px" name="TopicForum">';
				all_forum($f);
				echo'
				</select>
				</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>'.$lang['forum']['sticky_topic'].':</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicSticky" value="0" '.check_radio($t_sticky, "0").'>'.$lang['forum']['unstiky'].'</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicSticky" value="1" '.check_radio($t_sticky, "1").'>'.$lang['forum']['stiky'].'</nobr></td>
				<td class="list"><nobr></nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>'.$lang['forum']['lock_topic'].':</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicStatus" value="1" '.check_radio($t_status, "1").'>'.$lang['forum']['topic_unlock'].'</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicStatus" value="0" '.check_radio($t_status, "0").'>'.$lang['forum']['topic_lock'].'</nobr></td>
				<td class="list"><nobr></nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>'.$lang['forum']['hide_topic'].':</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicHidden" value="0" '.check_radio($t_hidden, "0").'>'.$lang['forum']['topic_unhide'].'</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicHidden" value="1" '.check_radio($t_hidden, "1").'>'.$lang['forum']['topic_hide'].'</nobr></td>
				<td class="list"><nobr></nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>'.$lang['forum']['topic_link'].':</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicLinkForum" value="0" '.check_radio($t_link, "0").'>'.$lang['forum']['topic_unshow'].'</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicLinkForum" value="1" '.check_radio($t_link, "1").'>'.$lang['forum']['topic_normal_link'].'</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicLinkForum" value="2" '.check_radio($t_link, "2").'>'.$lang['forum']['topic_principal_link'].'</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>'.$lang['forum']['topic_top'].':</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicTop" value="0" '.check_radio($t_top, "0").'>'.$lang['forum']['topic_untop'].'</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicTop" value="1" '.check_radio($t_top, "1").'>'.$lang['forum']['topic_top_forum'].'</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicTop" value="2" '.check_radio($t_top, "2").'>'.$lang['forum']['topic_top_all_forum'].'</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>'.$lang['forum']['topic_archive'].':</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicArchive" value="1" '.check_radio($t_archive, "1").'>'.$lang['forum']['topic_archived'].'</nobr></td>
				<td class="list"><nobr><input type="radio" class="radio" name="TopicArchive" value="0" '.check_radio($t_archive, "0").'>'.$lang['forum']['topic_unarchived'].'</nobr></td>
				<td class="list"><nobr></nobr></td>
			</tr>
			<tr class="fixed">
				<td class="list_center" colspan="5"><input type="button" onclick="submit_form();" value="'.$lang['profile']['insert_info'].'">&nbsp;&nbsp;<input type="reset" name="reset" value="'.$lang['profile']['reset_info'].'"></td>
			</tr>
		</table>
		</form>
		</div>';
	}
}

if($type == "edit"){

	$t = intval($_POST['t']);
	$f = intval($_POST["TopicForum"]);
	$c = forums("CAT_ID", $f);
	$t_forum = topics("FORUM_ID", $t);

	$t_status = intval($_POST["TopicStatus"]);
	$t_subject = HtmlSpecialchars($_POST["TopicSubject"]);
	$t_sticky = intval($_POST["TopicSticky"]);
	$t_hidden = intval($_POST["TopicHidden"]);
	$t_top = intval($_POST["TopicTop"]);
	$t_link = intval($_POST["TopicLinkForum"]);
	$t_archive = intval($_POST["TopicArchive"]);
	$t_survey = intval($_POST["TopicSurvey"]);
	$t_author = topics("AUTHOR", $t);
	$t_date = topics("DATE", $t);

	if(allowed($t_forum, 2) == 1){

	    if($t_forum != $f){
		$moved = 1;
		$moved_by = $DBMemberID;
		$moved_date = time();

		$from = "UPDATE {$mysql->prefix}FORUM SET ";
		$from .= "F_TOPICS = F_TOPICS - 1, ";
		$from .= "F_LAST_POST_DATE = '$t_date', ";
		$from .= "F_LAST_POST_AUTHOR = '$t_author' ";
		$from .= "WHERE FORUM_ID = '$t_forum' ";
		$mysql->execute($from, $connection, [], __FILE__, __LINE__);

		$to = "UPDATE {$mysql->prefix}FORUM SET ";
		$to .= "F_TOPICS = F_TOPICS + 1, ";
		$to .= "F_LAST_POST_DATE = '$t_date', ";
		$to .= "F_LAST_POST_AUTHOR = '$t_author' ";
		$to .= "WHERE FORUM_ID = '$f' ";
		$mysql->execute($to, $connection, [], __FILE__, __LINE__);
	    }
	    else {
		$moved = 0;
		$moved_by = 0;
		$moved_date = 0;
	    }
	    if($t_hidden == 1){
		$hidden = 1;
		$hidden_by = $DBMemberID;
		$hidden_date = time();
	    }
	    else {
		$hidden = 0;
		$hidden_by = 0;
		$hidden_date = 0;
	    }

		$sql = "UPDATE {$mysql->prefix}TOPICS SET ";
		$sql .= "CAT_ID = '$c', ";
		$sql .= "FORUM_ID = '$f', ";
		$sql .= "T_SURVEYID = '$t_survey', ";
		$sql .= "T_SUBJECT = '$t_subject', ";
		$sql .= "T_STATUS = '$t_status', ";
		$sql .= "T_STICKY = '$t_sticky', ";
		$sql .= "T_HIDDEN = '$hidden', ";
		$sql .= "T_HIDDEN_BY = '$hidden_by', ";
		$sql .= "T_HIDDEN_DATE = '$hidden_date', ";
		$sql .= "T_MOVED = '$moved', ";
		$sql .= "T_MOVED_BY = '$moved_by', ";
		$sql .= "T_MOVED_DATE = '$moved_date', ";
		$sql .= "T_TOP = '$t_top', ";
		$sql .= "T_LINKFORUM = '$t_link', ";
		$sql .= "T_ARCHIVE_FLAG = '$t_archive' ";
		$sql .= "WHERE TOPIC_ID = '$t' ";
		$mysql->execute($sql, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['all']['info_was_edited'].'</font><br><br>
	                       <meta http-equiv="Refresh" content="1; URL=index.php?mode=f&f='.$t_forum.'">
                           <a href="index.php?mode=t&t='.$t.'">'.$lang['all']['click_here_to_go_topic'].'</a><br><br>
	                       <a href="index.php?mode=f&f='.$t_forum.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
                           <a href="index.php?mode=option&t='.$t.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';

	}
}

?>