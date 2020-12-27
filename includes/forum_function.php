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


if(members("FORUM", $DBMemberID) == 1  AND $type != "archive"  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][FORUM].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}

if(members("FORUM_ARCHIVE", $DBMemberID) == 1  AND $type == "archive"  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][FORUM_ARCHIVE].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}

?>
<script language="javascript">
	var check_flag = "false";
	function check(checked, alert_msg){
		if(check_flag == "false"){
			var count = 0;
			for (i = 0; i < checked.length; i++){
				checked[i].checked = true;
				if(checked[i].type == "checkbox"){
					count += 1;
				}
			}
			check_flag = "true";
			alert(alert_msg+": "+count);
			return "إلغاء التحديد الكل";
		}
		else {
			for (i = 0; i < checked.length; i++){
				checked[i].checked = false;
			}
			check_flag = "false";
			return "تحديد الكل";
		}
	}
</script>
<?php
if(mlv <2){
echo' <script language="JavaScript" type="text/javascript">
	function moderators_ops(){
		var pg = pg_form.pg_num.value;
		window.location = "index.php?mode=f&f='.$f.'&mod_option=all&pg="+pg;
	}
</script>';
}else{
echo' 
<script language="JavaScript" type="text/javascript">
	function moderators_ops(){
		var mod_option = mod_op.mod_option.value;
		var pg = pg_form.pg_num.value;
		var fo_id = mod_op.f_id.value;
		window.location = "index.php?mode=f&f="+fo_id+"&mod_option="+mod_option+"&pg="+pg;
	}
</script>';
}

if((!isset($pg) OR empty($pg)) OR (!isset($mod_option) OR empty($mod_option))){
	$pg = 1;
	$mod_option = "all";
}
$pg_limit = (($pg * $max_page) - $max_page);
$pg_count = $mysql->execute("SELECT COUNT(TOPIC_ID) FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_ARCHIVED = 0 ")->fetch(PDO::FETCH_NUM);
$pg_count = intval($pg_count[0]);
$pg_col = ceil($pg_count / $max_page);
function paging(){
	global $f, $lang, $pg_col, $pg;
	echo '
	<form name="pg_form">
	<input type="hidden" name="f_id" value="'.$f.'">
	<td class="optionsbar_menus"><b>'.$lang['forum']['page'].'&nbsp;:</b>
		<select class="forumSelect" name="pg_num" size="1" onchange="moderators_ops();">';
        for($i = 1; $i <= $pg_col; $i++){
			echo '<option value="'.$i.'" '.check_select($pg, $i).'>'.$i.'&nbsp;'.$lang['forum']['from'].'&nbsp;'.$pg_col.'</option>';
        }
		echo '
		</select>
	</td>
	</form>';
}

function moderators_options(){
	global $f, $mod_option, $Mlevel;
		$mo_d ='	<input type="hidden" name="f_id" value="'.$f.'">
			<select class="insidetitle" name="mod_option" onchange="moderators_ops();">';
			$mo_d .='	<option value="all" '.check_select($mod_option, "all").'>خيارات الإشراف: التصفح العادي</option>';
			$mo_d .='	<option value="topen" '.check_select($mod_option, "topen").'>خيارات الإشراف: مواضيع غير مقفولة ('.unlocked_topics($f).')</option>';
			$mo_d .='	<option value="tunmoderated" '.check_select($mod_option, "tunmoderated").'>خيارات الإشراف: مواضيع تنتظر الموافقة ('.unmoderated_topics($f).')</option>';
			$mo_d .='	<option value="tholded" '.check_select($mod_option, "tholded").'>خيارات الإشراف: مواضيع مجمدة ('.holded_topics($f).')</option>';
			$mo_d .='	<option value="tlocked" '.check_select($mod_option, "tlocked").'>خيارات الإشراف: مواضيع مقفولة ('.locked_topics($f).')</option>';
			$mo_d .='	<option value="runmoderated" '.check_select($mod_option, "runmoderated").'>خيارات الإشراف: ردود تنتظر الموافقة ('.unmoderated_replies($f).')</option>';
			$mo_d .='	<option value="rholded" '.check_select($mod_option, "rholded").'>خيارات الإشراف: ردود مجمدة('.holded_replies($f).')</option>';
			$mo_d .='	<option value="thidden" '.check_select($mod_option, "thidden").'>خيارات الإشراف: مواضيع مخفية ('.hidden_topics($f).')</option>';
			$mo_d .='	<option value="rhidden" '.check_select($mod_option, "rhidden").'>خيارات الإشراف: ردود مخفية ('.hidden_replies($f).')</option>';
			$mo_d .='	<option value="ttop" '.check_select($mod_option, "ttop").'>خيارات الإشراف: مواضيع مميزة ('.top_topics($f).')</option>';
			$mo_d .='	<option value="tsurvey" '.check_select($mod_option, "tsurvey").'>خيارات الإشراف: مواضيع مربوطة بإستفتاءات ('.survey_topics($f).')</option>';
			$mo_d .='	<option value="tunarchived" '.check_select($mod_option, "tunarchived").'>خيارات الإشراف: مواضيع لا تنتقل للأرشيف ('.unarchived_topics($f).')</option>';
			$mo_d .='	<option value="tmoved" '.check_select($mod_option, "tmoved").'>خيارات الإشراف: مواضيع منقولة ('.moved_topics($f).')</option>';
			$mo_d .='	<option value="tedited" '.check_select($mod_option, "tedited").'>خيارات الإشراف: مواضيع تم تغيير نصها ('.edited_topics($f).')</option>';
			if($Mlevel > 2){
			$mo_d .='	<option value="tdeleted" '.check_select($mod_option, "tdeleted").'>خيارات الإدارة: مواضيع محذوفة ('.deleted_topics($f).')</option>';
			}
		$mo_d .='	</select>';
return $mo_d;
}

function forum_mods($id){
	global $mysql;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MODERATOR WHERE FORUM_ID = '$id' ", [], __FILE__, __LINE__);
	$forum_mods = '<table class="mods" cellspacing="0" cellpadding="0"><tr>';
	if($sql->rowCount() != 0) $forum_mods .= '<td><nobr>&nbsp;بإشراف:</td>';
 	$j = 0;
	$i = 0;
	while ( $result = $sql->fetch()){
		$member_id = $result['"MEMBER_ID'];
		if($j == 3){
			$forum_mods .= '</tr></table><table class="mods" cellspacing="0" cellpadding="0"><tr>';
			$j = 0;
		}
		$forum_mods .= '<td><nobr>&nbsp;';
		if($j){
			$forum_mods .= ' + ';
		}
		$forum_mods .= normal_profile(members("NAME", $member_id), $member_id).'</td>';
		$i++;
		$j++;
	}
	$forum_mods .= '</tr></table>';
	return $forum_mods;
}

function forum_head($f, $c){
	global $f_logo, $f_subject, $folder_new, 
	$lang, $allowed, $pg_sql, $mod_option, $auth, $DBMemberID,$type;
if($mod_option == "runmoderated" OR $mod_option == "rholded" OR $mod_option == "rhidden"){
	$width = "120%";
}
else {
	$width = "99%";
}
if($type == "archive") $archive = "أرشيف : ";
echo'
<center>
<table cellSpacing="0" cellPadding="0" width="'.$width.'" border="0">
    <tr>
	<td>
	<table cellSpacing="2" width="100%" border="0">
		<tr>
			<td><a class="menu" href="index.php?mode=finfo&f='.$f.'">'.icons($f_logo, "معلومات عن المنتدى").'</a></td>
			<td class="main" vAlign="center" width="100%"><a class="menu" href="index.php?mode=f&f='.$f.'"><font color="red" size="+1">'.$archive.''.$f_subject.'</font></a>';
			if(forums("SHOW_FRM", $f) == 0 AND $auth == ""   ){
			echo '<font size="-1">'.forum_mods($f).'</font></td>';
			}
            if(mlv > 0){
          if($auth == $DBMemberID){
            echo '<table class="mods" cellspacing="0" cellpadding="0"><tr><td><font color="red" size="+1">-- مواضيعك فقط --</font></td></tr></table></td>';
          }
          if($auth != $DBMemberID AND $auth != ""){
            echo '<table class="mods" cellspacing="0" cellpadding="0"><tr><td><font color="black" size="+1">مواضيع العضو : </font><font color="red" size="+1">'.members("NAME", $auth).'</font></td></tr></table></td>';
          }
          }

if($type != "archive"){

			echo '<td class="optionsbar_menus"><nobr><a href="index.php?mode=editor&method=topic&f='.$f.'&c='.$c.'">'.icons($folder_new).'<br>'.$lang['forum']['new_topic'].'</a></nobr></td>
			<td class="optionsbar_menus"><nobr><a href="index.php?mode=editor&method=sendmsg&m='.abs2($f).'">'.$lang['forum']['send_message_to_forum'].'</a></nobr></td>';
		if($allowed == 1){
			echo'
			<td class="optionsbar_menus"><nobr><a href="index.php?mode=pm&mail=in&m='.abs2($f).'&c='.$c.'">'.forum_new_mail($f).$lang['forum']['forum_mail'].'</a></nobr></td>';
  }
        $notify = nofity_wait($f, "wait");
        if($notify > 0){
        $new_notify_count = '<font size="1">شكاوي</font><br><font color="red">('.$notify.')</font>';
}
else {
$new_notify_count = '<font size="1">شكاوي</font>';
		}
if(allowed($f, 2) == 1){
        echo'<td class="optionsbar_menus"><a href="index.php?mode=notifylist&f='.$f.'"><nobr>'.$new_notify_count.'</nobr></a></td>';
}

		if(allowed($f, 2) == 1){
			echo'
			<td class="optionsbar_menus"><nobr><a href="index.php?mode=mf&f='.$f.'">ملفات<br>الأوسمة</a></nobr></td>';
		}
}
if($type != "archive"){
        if(mlv > 0){
        if($auth == ""){
        echo'
			<td class="optionsbar_menus"><nobr><a href="index.php?mode=f&f='.$f.'&auth=0">مواضيعك في <br> هذا المنتدى</a></nobr></td>';
    } else {
          echo'
			<td class="optionsbar_menus"><nobr><a href="index.php?mode=f&f='.$f.'">جميع مواضيع<br> هذا المنتدى</a></nobr></td>';
    }
    }}
if($type == "archive"){
        if(mlv > 0){
        if($auth == ""){
        echo'
			<td class="optionsbar_menus"><nobr><a href="index.php?mode=f&f='.$f.'&type=archive&auth=0">مواضيعك في <br> أرشيف هذا المنتدى</a></nobr></td>';
    } else {
          echo'
			<td class="optionsbar_menus"><nobr><a href="index.php?mode=f&f='.$f.'&type=archive">جميع مواضيع<br> أرشيف هذا المنتدى</a></nobr></td>';
    }
    }}

if($type != "archive"){
			order_by();
			refresh_time();
}
			if($pg_sql > 0){
				paging();
			}
			go_to_forum();
		echo'
		</tr>
	</table>';
}

function forum_new_mail($f){
	global $Prefix;
	$f = abs2($f);
	$new_pm = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}PM WHERE PM_MID = '$f' AND PM_OUT = '0' AND PM_READ = '0' AND PM_STATUS = '1' ", [], __FILE__, __LINE__);
	$count = mysql_result($new_pm, 0, "count(*)");
	if($count > 0){
		$forum_pm = '(<font color="red">'.$count.'</font>)<br>';
	}
	else {
		$forum_pm = '';
	}

return($forum_pm);
}

function link_forum($f){
	global $Prefix;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_LINKFORUM > '0' ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
	if($num > 0){
		echo'
		<table>
			<tr>';
			$x = 0;
			while ($x < $num){
				$topic_id = mysql_result($sql, $x, "TOPIC_ID");
				$subject = topics("SUBJECT", $topic_id);
				$link = topics("LINKFORUM", $topic_id);
				
				if($link == 1){
					$td_class = "extras2";
				}
				if($link == 2){
					$td_class = "extras";
				}
				echo'<td class="'.$td_class.'"><nobr><a href="index.php?mode=t&t='.$topic_id.'">'.$subject.'</a></nobr></td>';
						
			++$x;
			}
			echo'
			</tr>
		</table>';
	}
}

function forum_topics($f, $c, $auth){
	global $Prefix, $lang, $Mlevel, $mod_option, $and, $order_by_date, 
	$pg_limit, $max_page, $tr_class, $DBMemberID, $Mlevel,
	$folder_new_locked, $lang, $folder_new, $folder_new_hot, $folder,
	$red_star, $icon_top_topic, $icon_survey, $icon_lock,
	$icon_unlock, $folder_topic_sticky, $folder_topic_unsticky, 
	$icon_unhidden, $icon_hidden, $icon_folder_archive, $allowed,
	$icon_edit, $icon_trash, $icon_reply_topic, $folder_hold, 
	$folder_moderate, $folder_unmoderated, $folder_new_delete;

	if($allowed == 1 && $mod_option == "tunmoderated" OR $mod_option == "tholded" OR $mod_option == "thidden") 
	{ $colSpan = 3; }
	else 
	{ $colSpan = 2; }


if(allowed($f, 2) == 1 AND forums("TOPICS", $f) > 0){
echo '<div align="left"><table border="0" cellPadding="1" cellSpacing="2">
<tr>
<form name="mod_op">
<td class="optionsbar_menus" colspan="3">
'.moderators_options().'
</td>
</form>
<td class="optionsbar_menus2">
<input class="small" type="button" id="check_all" value="تحديد الكل" onclick="check_top()"></td>
<td class="optionsbar_menus2">
<select name="tools_mod" id="tools_mod">
<option value="lock">قفل المواضيع المختارة</option>
<option value="unlock">فتح المواضيع المختارة</option>
<option value="hidden">إخفاء المواضيع المختارة</option>
<option value="unhidden">إظهارء المواضيع المختارة</option>
<option value="del">حذف المواضيع المختارة</option>
</td>
<td class="optionsbar_menus2"><input class="small" type="button" value="تطبيق" onclick="left_tools()"></td>
</tr>
</table></div>';
}

		echo'
		<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
			<tr>
				<td>
				<table cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<td class="cat" width="50%"  colSpan="'.$colSpan.'">';
						echo $lang['forum']['topics'];
						echo'
						</td>
						<td class="cat" width="12%">'.$lang['forum']['author'].'</td>
						<td class="cat" width="8%">'.$lang['forum']['posts'].'</td>
						<td class="cat" width="8%">'.$lang['forum']['reads'].'</td>
						<td class="cat" width="12%">'.$lang['forum']['last_post'].'</td>';
					if($Mlevel > 0){	
						echo'
						<td class="cat" width="4%">'.$lang['forum']['options'].'</td>';
					}	
					echo'
					</tr>';
                 if($auth == ""){
				$topics = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE CAT_ID = '$c' AND FORUM_ID = '$f' AND T_ARCHIVED = 0 ".$and." ORDER BY T_STICKY DESC, ".$order_by_date." LIMIT $pg_limit, $max_page", [], __FILE__, __LINE__);
            }
            if($auth != ""){
                $topics = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE CAT_ID = '$c' AND FORUM_ID = '$f' AND T_AUTHOR = '$auth' ".$and." AND T_ARCHIVED = 0 ORDER BY T_STICKY DESC, ".$order_by_date." LIMIT $pg_limit, $max_page", [], __FILE__, __LINE__);
            }
				$t_num = mysql_num_rows($topics);
				if($t_num <= 0){
				    if($mod_option != "all"){
					$no_topics = '<font size="+1">لاتوجد أية مواضيع بالخيار الذي اخترت<br>الرجاء تغيير الخيار من خيارات الاشراف أعلاه</font>';
				    }
				    else {
					$no_topics = $lang['forum']['not_topics'];
				    }
					echo'
					<tr>
						<td class="f1" vAlign="center" align="middle" colspan="20"><br><br>'.$no_topics.'<br><br><br></td>
					</tr>';
				}
				
				$t_i = 0;
				while ($t_i < $t_num){
					$topic_id = mysql_result($topics, $t_i, "TOPIC_ID");
					$t_hidden = mysql_result($topics, $t_i, "T_HIDDEN");
					$t_unmoderated = mysql_result($topics, $t_i, "T_UNMODERATED");
					$t_hold = mysql_result($topics, $t_i, "T_HOLDED");
					$t_sticky = mysql_result($topics, $t_i, "T_STICKY");
					$t_author = mysql_result($topics, $t_i, "T_AUTHOR");
					$t_cat_id = mysql_result($topics, $t_i, "CAT_ID");
					$t_forum_id = mysql_result($topics, $t_i, "FORUM_ID");
					$status = mysql_result($topics, $t_i, "T_STATUS");
					$subject = mysql_result($topics, $t_i, "T_SUBJECT");
					$author = mysql_result($topics, $t_i, "T_AUTHOR");
					$replies = mysql_result($topics, $t_i, "T_REPLIES");
					$counts = mysql_result($topics, $t_i, "T_COUNTS");
					$lp_date = mysql_result($topics, $t_i, "T_LAST_POST_DATE");
					$date = mysql_result($topics, $t_i, "T_DATE");
					$lp_author = mysql_result($topics, $t_i, "T_LAST_POST_AUTHOR");
					$sticky = mysql_result($topics, $t_i, "T_STICKY");
					$hidden = mysql_result($topics, $t_i, "T_HIDDEN");
					$top = mysql_result($topics, $t_i, "T_TOP");
					$survey = mysql_result($topics, $t_i, "T_SURVEYID");
					$author_name = members("NAME", $author);
					$lp_author_name = members("NAME", $lp_author);
					
					if($t_hidden == 1){
						$tr_class = "deleted";
					}
					else{
						if($t_sticky == 1){
							$tr_class = "fixed";
						}
						else{
							$tr_class = "normal";
						}
					}

			echo'<form name="topics_tools" method="post" action="index.php?mode=moderate&type=topics_tools&f='.$t_forum_id.'&c='.$t_cat_id.'">
<input type="hidden" id="t_forum" name="t_forum" value="'.$t_forum_id.'">
<input type="hidden" id="t_cat" name="t_cat" value="'.$t_cat_id.'">
';

					$checkbox = '<input type="checkbox"   name="topic_id[]" value="'.$topic_id.'">';
				    if((($t_hidden == 0) OR ($t_hidden == 1 AND $allowed == 1) OR ($t_hidden == 1 AND $t_author == $DBMemberID)) AND (($t_unmoderated == 0) OR ($t_unmoderated == 1 AND $allowed == 1) OR ($t_unmoderated == 1 AND $t_author == $DBMemberID)) AND (($t_hold == 0) OR ($t_hold == 1 AND $allowed == 1) OR ($t_hold == 1 AND $t_author == $DBMemberID)) AND ($status != 2 OR allowed($t_forum_id, 1) == 1)){
					echo'
					<tr class="'.$tr_class.'">';
					if($allowed == 1 && $mod_option == "tunmoderated" OR $mod_option == "tholded" OR $mod_option == "thidden"){
					   echo'<td class="first" align="center" width="2%">'.$checkbox.'</td>';
					}

					   echo'<td class="list_center" width="3%">&nbsp;<nobr><a href="index.php?mode=t&t='.$topic_id.'">';
					   											if(allowed($f, 2) == 1){

						echo'
<input type="checkbox"   class="small" name="check[]" value="'.$topic_id.'">';
						}
					if($t_unmoderated == 1){
						echo icons($folder_unmoderated);
					}
					else if($t_hold == 1){
						echo icons($folder_hold);
					}
					else if($status == 2){
						echo icons($folder_new_delete);
					}
					else if($status == 0 AND $replies < 20){
						echo icons($folder_new_locked, $lang['forum']['topic_is_locked']);
					}
					elseif($status == 0 AND $replies >= 20){
						echo icons($folder_new_locked, $lang['forum']['topic_is_hot_and_locked']);
					}
					elseif($status == 1 AND $replies < 20){
						echo icons($folder_new);
					}
					elseif($status == 1 AND $replies >= 20){
						echo icons($folder_new_hot, $lang['forum']['topic_is_hot']);
					}
					else {
						echo icons($folder);
					}
						echo'
						</a></nobr></td>
						<td class="list">
						<table cellPadding="0" cellsapcing="0">
							<tr>';
							if($survey > 0){
								echo'
								<td>'.icons($icon_survey).'</td>';
							}
							if($top == 1){
								echo'
								<td>'.icons($red_star, "هذا الموضوع متميز").'</td>';
							}
							if($top == 2){
								echo'
								<td>'.icons($icon_top_topic, "هذا الموضوع متميز").'</td>';
							}
							
							
								echo'
								<td><a href="index.php?mode=t&t='.$topic_id.'">'.$subject.'</a>&nbsp;'; echo topic_paging($topic_id); echo'</td>
							</tr>
						</table>
						</td>
						<td class="list_small" noWrap><font color="green">'.normal_time($date).'</font><br>'.link_profile($author_name, $author).'</td>
						<td class="list_small">'.$replies.'</td>
						<td class="list_small">'.$counts.'</td>
						<td class="list_small" noWrap><font color="red">';
						if($replies > 0){
							echo normal_time($lp_date).'</font><br>'.link_profile($lp_author_name, $lp_author);
						}
						echo'
						</td>';
					if($Mlevel > 0){	
						echo'
						<td class="list_small" noWrap>';

						if($allowed == 1){
							if($status == 1){
								echo'<a href="index.php?mode=lock&type=t&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'" onclick="return confirm(\''.$lang['forum']['you_are_sure_to_lock_this_topic'].'\');">'.icons($icon_lock, $lang['forum']['lock_topic'], "hspace=\"2\"").'</a>';
							}
							if($status == 0){
								echo'<a href="index.php?mode=open&type=t&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_open_this_topic'].'\');">'.icons($icon_unlock, $lang['forum']['open_topic'], "hspace=\"2\"").'</a>';
							}
							if($sticky == 0){
								echo'<a href="index.php?mode=lock&type=s&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_sticky_this_topic'].'\');">'.icons($folder_topic_sticky, $lang['forum']['sticky_topic'], "hspace=\"2\"").'</a>';
							}
		                    if($sticky == 1){
								echo'<a href="index.php?mode=open&type=s&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_un_sticky_this_topic'].'\');">'.icons($folder_topic_unsticky, $lang['forum']['un_sticky_topic'], "hspace=\"2\"").'</a>';
							}
							if($t_unmoderated == 1 OR $t_hold == 1){
								echo'<a href="index.php?mode=moderate&type=t&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_moderate_this_topic'].'\');">'.icons($folder_moderate, $lang['forum']['moderate_topic'], "hspace=\"2\"").'</a>';
							}
							if($hidden == 1 && $t_unmoderated == 0){
								echo'<a href="index.php?mode=open&type=h&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_show_this_topic'].'\');">'.icons($icon_unhidden, $lang['forum']['show_topic'], "hspace=\"2\"").'</a>';
							}
							if($hidden == 0 && $t_unmoderated == 0){
								echo'<a href="index.php?mode=lock&type=h&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_hide_this_topic'].'\');">'.icons($icon_hidden, $lang['forum']['hide_topic'], "hspace=\"2\"").'</a>';
							}
							echo'<a href="index.php?mode=option&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'">'.icons($icon_folder_archive, $lang['forum']['topic_option'], "hspace=\"2\"").'</a>';
						}
						if($allowed == 1 OR $status == 1 AND $author == $DBMemberID){
							echo'<a href="index.php?mode=editor&method=edit&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'">'.icons($icon_edit, $lang['forum']['edit_topic'], "hspace=\"2\"").'</a>';
						}
						if(allowed($f, 2) == 1){
							echo'<a href="index.php?mode=delete&type=t&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_delete_this_topic'].'\');"">'.icons($icon_trash, $lang['forum']['delete_topic'], "hspace=\"2\"").'</a>';
						}
						if($allowed == 1 OR $status == 1){
							echo'<a href="index.php?mode=editor&method=reply&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'">'.icons($icon_reply_topic, $lang['forum']['reply_to_this_topic'], "hspace=\"2\"").'</a>';
						}


						
						echo'
						</td>';
					}
					echo'
					</tr>';
				    }
				++$t_i;	
				}
			if(($mod_option == "tunmoderated" OR $mod_option == "tholded" OR $mod_option == "thidden") AND $t_num > 0){
			echo'
			<tr>
				<td bgcolor="white" colspan="8">
				<table cellSpacing="1" cellPadding="1" width="100%" border="0">
					<tr>
						<td align="center"><br>
						<input type="button" value="تحديد الكل" onclick="this.value=check(this.form.elements, \'عدد المواضيع التي اخترت هو \')">&nbsp;&nbsp;';
				if($mod_option == "tunmoderated" OR $mod_option == "tholded"){
					echo'	<input type="submit" name="subApprove" value="الموافقة على المواضيع المختارة"  onclick="return confirm(\'هل أنت متأكد من الموافقة على المواضيع المختارة\');">&nbsp;&nbsp;';
				}
				if($mod_option == "tunmoderated"){
					echo'	<input type="submit" name="subHold" value="تجميد المواضيع المختارة" onclick="return confirm(\'هل أنت متأكد من تجميد المواضيع المختارة\');">&nbsp;&nbsp;';
				}
				if($mod_option == "thidden"){
					echo'	<input type="submit" name="subHidden" value="إظهار المواضيع المختارة" onclick="return confirm(\'هل أنت متأكد من اظهار المواضيع المختارة\');">&nbsp;&nbsp;';
				}
					echo'	<input type="submit" name="subDelete" value="حذف المواضيع المختارة" onclick="return confirm(\'هل أنت متأكد من حذف المواضيع المختارة\');">
						</td>
					</tr>
				</table>
				</td>
			</tr>
			</form>';
			}
			if($mod_option == "tdeleted" AND $t_num > 0 AND mlv > 2){
			echo'
			<tr>
				<td bgcolor="white" colspan="8">
				<table cellSpacing="1" cellPadding="1" width="100%" border="0">
					<tr>
						<td align="center"><font size="+1" color="red">لحذف المواضيع نهائيا من قاعدة البيانات انقر على ايقونة الحذف ('.icons($icon_trash).') في الخيارات</font></td>
					</tr>
				</table>
				</td>
			</tr>';
			}
				echo'
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</center>';
}
switch ($mode){
     case "f":
include ("ads2.php");

}
function forum_archive($f, $c, $auth){
	global $Prefix, $lang, $Mlevel, $mod_option, $and, $order_by_date, 
	$pg_limit, $max_page, $tr_class, $DBMemberID, $Mlevel,
	$folder_new_locked, $lang, $folder_new, $folder_new_hot, $folder,
	$red_star, $icon_top_topic, $icon_survey, $icon_lock,
	$icon_unlock, $folder_topic_sticky, $folder_topic_unsticky, 
	$icon_unhidden, $icon_hidden, $icon_folder_archive, $allowed,
	$icon_edit, $icon_trash, $icon_reply_topic, $folder_hold, 
	$folder_moderate, $folder_unmoderated, $folder_new_delete,$auth;


$archive = "AND T_ARCHIVED = 1";

if($auth){
$get_author = "&author=$auth";
}

		echo'
<form name="mod_op"><input type="hidden" name="mod_option" value="all&type=archive'.$get_author.'"><input type="hidden" name="f_id" value="'.$f.'"></form>
		<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
			<tr>
				<td>
				<table cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>';

echo'<td class="cat" width="50%">المواضيع في الأرشيف</td>';
echo'<td class="cat" width="12%">&nbsp;</td>';
echo'<td class="cat" width="12%">'.$lang['forum']['author'].'</td>';
echo'<td class="cat" width="8%">'.$lang['forum']['reads'].'</td>';

					echo'
					</tr>';
                 if($auth == ""){
				$topics = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE CAT_ID = '$c' AND FORUM_ID = '$f' ".$archive." ".$and." ORDER BY T_STICKY DESC, ".$order_by_date." LIMIT $pg_limit, $max_page", [], __FILE__, __LINE__);
            }
            if($auth != ""){
                $topics = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE CAT_ID = '$c' AND FORUM_ID = '$f' AND T_AUTHOR = '$auth' ".$archive." ".$and." ORDER BY T_STICKY DESC, ".$order_by_date." LIMIT $pg_limit, $max_page", [], __FILE__, __LINE__);
            }
				$t_num = mysql_num_rows($topics);
				if($t_num <= 0){
					$no_topics = $lang['forum']['not_topics'];
					echo'
					<tr>
						<td class="f1" vAlign="center" align="middle" colspan="20"><br><br>'.$lang['forum']['not_topics'].'<br><br><br></td>
					</tr>';
				}
				
				$t_i = 0;
				while ($t_i < $t_num){
					$topic_id = mysql_result($topics, $t_i, "TOPIC_ID");
					$t_hidden = topics("HIDDEN", $topic_id);
					$t_unmoderated = topics("UNMODERATED", $topic_id);
					$t_hold = topics("HOLDED", $topic_id);
					$t_sticky = topics("STICKY", $topic_id);
					$t_author = topics("AUTHOR", $topic_id);
					$t_cat_id = topics("CAT_ID", $topic_id);
					$t_forum_id = topics("FORUM_ID", $topic_id);
					$status = topics("STATUS", $topic_id);
					$subject = topics("SUBJECT", $topic_id);
					$author = topics("AUTHOR", $topic_id);
					$replies = topics("REPLIES", $topic_id);
					$counts = topics("COUNTS", $topic_id);
					$lp_date = topics("LAST_POST_DATE", $topic_id);
					$date = topics("DATE", $topic_id);
					$lp_author = topics("LAST_POST_AUTHOR", $topic_id);
					$sticky = topics("STICKY", $topic_id);
					$hidden = topics("HIDDEN", $topic_id);
					$top = topics("TOP", $topic_id);
					$survey = topics("SURVEYID", $topic_id);
					$author_name = members("NAME", $author);
					$lp_author_name = members("NAME", $lp_author);
				                  $tr_class = "normal";
						
				    if((($t_hidden == 0) OR ($t_hidden == 1 AND $allowed == 1) OR ($t_hidden == 1 AND $t_author == $DBMemberID)) AND (($t_unmoderated == 0) OR ($t_unmoderated == 1 AND $allowed == 1) OR ($t_unmoderated == 1 AND $t_author == $DBMemberID)) AND (($t_hold == 0) OR ($t_hold == 1 AND $allowed == 1) OR ($t_hold == 1 AND $t_author == $DBMemberID)) AND ($status != 2 OR allowed($t_forum_id, 1) == 1)){
					echo'
					<tr class="'.$tr_class.'">';
									
echo '
						<td class="list">
						<table cellPadding="0" cellsapcing="0">
							<tr>';
													
								echo'
								<td><a href="index.php?mode=t&t='.$topic_id.'">'.$subject.'</a>&nbsp;'; echo topic_paging($topic_id); echo'</td>
							</tr>
						</table>
						</td>
						<td class="list_small" noWrap><font color="green">'.normal_time($date).'</font></td>
						<td class="list_small">'.link_profile($author_name, $author).'</td>
						<td class="list_small">'.$replies.'</td>';
				
					echo'
					</tr>';
				    }
				++$t_i;	
				}

				echo'
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</center>';
}

function forum_replies($f, $c, $type){
	global $Prefix, $lang, $Mlevel, $mod_option, $order_by_date, 
	$pg_limit, $max_page, $DBMemberID, $Mlevel, 
	$folder_new_locked, $lang, $folder_new, $folder_new_hot, $folder,
	$red_star, $icon_top_topic, $icon_survey, $icon_lock,
	$icon_unlock, $folder_topic_sticky, $folder_topic_unsticky, 
	$icon_unhidden, $icon_hidden, $icon_folder_archive, $allowed,
	$icon_edit, $icon_trash, $icon_reply_topic, $folder_hold, $folder_new_delete,

	$icon_edit, $icon_moderation, $icon_group, 
	$icon_delete_reply, $icon_single, $icon_group, $folder_moderate, 
	$icon_hold, $icon_unhidden;

	if($type == "unmoderated"){
	    $and = "AND R_UNMODERATED = '1'";
	}
	if($type == "hidden"){
	    $and = "AND R_HIDDEN = '1'";
	}
	if($type == "hold"){
	    $and = "AND R_HOLDED = '1'";
	}

		echo'
		<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
			<tr>
				<td>
				<table cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<form name="mod_op">
						<td class="cat" width="65%"  colSpan="2">';
					if($allowed == 1){
						moderators_options();
					}
					else {
						echo $lang['forum']['topics'];
					}
						echo'
						</td>
						</form>
						<td class="cat" width="12%">'.$lang['forum']['author'].'</td>
						<td class="cat" width="8%">'.$lang['forum']['posts'].'</td>
						<td class="cat" width="8%">'.$lang['forum']['reads'].'</td>
						<td class="cat" width="12%">'.$lang['forum']['last_post'].'</td>
						<td class="cat" width="5%">'.$lang['forum']['options'].'</td>
					</tr>';
		$query = $mysql->execute("SELECT * FROM {$mysql->prefix}REPLY WHERE CAT_ID = '$c' AND FORUM_ID = '$f' ".$and." ORDER BY R_DATE DESC LIMIT ".pg_limit($max_page).", $max_page ", [], __FILE__, __LINE__);
		$r_num = mysql_num_rows($query);
		if($r_num <= 0){
		    if($mod_option != "all"){
			$no_topics = '<font size="+1">لاتوجد أية ردود بالخيار الذي اخترت<br>الرجاء تغيير الخيار من خيارات الاشراف أعلاه</font>';
		    }
		    else {
			$no_topics = $lang['forum']['not_topics'];
		    }
					echo'
					<tr>
						<td class="f1" vAlign="center" align="middle" colspan="20"><br><br>'.$no_topics.'<br><br><br></td>
					</tr>';
				}
		$r_i = 0;
		while ($r_i < $r_num){
			$r = mysql_result($query, $r_i, "REPLY_ID");
			$t = replies("TOPIC_ID", $r);
			$message = replies("MESSAGE", $r);
			$r_cat = replies("CAT_ID", $r);
			$r_forum = replies("FORUM_ID", $r);
			$m = replies("AUTHOR", $r);
			$r_unmoderated = replies("UNMODERATED", $r);

				$topics = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE TOPIC_ID = '$t'", [], __FILE__, __LINE__);
				$t_num = mysql_num_rows($topics);
				$rs = mysql_fetch_array($topics);

					$topic_id = $rs['TOPIC_ID'];
					$t_hidden = topics("HIDDEN", $topic_id);
					$t_unmoderated = topics("UNMODERATED", $topic_id);
					$t_hold = topics("HOLDED", $topic_id);
					$t_sticky = topics("STICKY", $topic_id);
					$t_author = topics("AUTHOR", $topic_id);
					$t_cat_id = topics("CAT_ID", $topic_id);
					$t_forum_id = topics("FORUM_ID", $topic_id);
					$status = topics("STATUS", $topic_id);
					$subject = topics("SUBJECT", $topic_id);
					$author = topics("AUTHOR", $topic_id);
					$replies = topics("REPLIES", $topic_id);
					$counts = topics("COUNTS", $topic_id);
					$lp_date = topics("LAST_POST_DATE", $topic_id);
					$date = topics("DATE", $topic_id);
					$lp_author = topics("LAST_POST_AUTHOR", $topic_id);
					$sticky = topics("STICKY", $topic_id);
					$hidden = topics("HIDDEN", $topic_id);
					$top = topics("TOP", $topic_id);
					$survey = topics("SURVEY", $topic_id);
					$author_name = members("NAME", $author);
					$lp_author_name = members("NAME", $lp_author);
					
					if($t_hidden == 1){
						$tr_class = "deleted";
					}
					else{
						if($t_sticky == 1){
							$tr_class = "fixed";
						}
						else{
							$tr_class = "normal";
						}
					}
	if($status != 2){

			echo'<form name="replies_tools" method="post" action="index.php?mode=moderate&type=replies_tools&f='.$r_forum.'&c='.$r_cat.'">';

				if($r_i > 0){
					echo'
					<tr>
						<td class="cat" width="65%"  colSpan="2">'.$lang['forum']['topics'].'</td>
						<td class="cat" width="12%">'.$lang['forum']['author'].'</td>
						<td class="cat" width="8%">'.$lang['forum']['posts'].'</td>
						<td class="cat" width="8%">'.$lang['forum']['reads'].'</td>
						<td class="cat" width="12%">'.$lang['forum']['last_post'].'</td>
						<td class="cat" width="5%">'.$lang['forum']['options'].'</td>
					</tr>';
				}
					echo'
					<tr class="'.$tr_class.'">';
					   echo'<td class="list_center" width="3%">&nbsp;<nobr><a href="index.php?mode=t&t='.$topic_id.'">';
					if($t_unmoderated == 1){
						echo icons($folder_unmoderated);
					}
					else if($t_hold == 1){
						echo icons($folder_hold);
					}
					else if($status == 2){
						echo icons($folder_new_delete);
					}
					else if($status == 0 AND $replies < 20){
						echo icons($folder_new_locked, $lang['forum']['topic_is_locked']);
					}
					elseif($status == 0 AND $replies >= 20){
						echo icons($folder_new_locked, $lang['forum']['topic_is_hot_and_locked']);
					}
					elseif($status == 1 AND $replies < 20){
						echo icons($folder_new);
					}
					elseif($status == 1 AND $replies >= 20){
						echo icons($folder_new_hot, $lang['forum']['topic_is_hot']);
					}
					else {
						echo icons($folder);
					}
						echo'
						</a></nobr></td>
						<td class="list">
						<table cellPadding="0" cellsapcing="0">
							<tr>';
							if($survey > 0){
								echo'
								<td>'.icons($icon_survey).'</td>';
							}
							if($top == 1){
								echo'
								<td>'.icons($red_star, "هذا الموضوع متميز").'</td>';
							}
							if($top == 2){
								echo'
								<td>'.icons($icon_top_topic, "هذا الموضوع متميز").'</td>';
							}							
								echo'
								<td><a href="index.php?mode=t&t='.$topic_id.'">'.$subject.'</a>&nbsp;'; echo topic_paging($topic_id); echo'</td>
							</tr>
						</table>
						</td>
						<td class="list_small" noWrap><font color="green">'.normal_time($date).'</font><br>'.link_profile($author_name, $author).'</td>
						<td class="list_small">'.$replies.'</td>
						<td class="list_small">'.$counts.'</td>
						<td class="list_small" noWrap><font color="red">';
						if($replies > 0){
							echo normal_time($lp_date).'</font><br>'.link_profile($lp_author_name, $lp_author);
						}
						echo'
						</td>';
					if($Mlevel > 0){	
						echo'
						<td class="list_small" noWrap>';

						if($allowed == 1){
							if($status == 1){
								echo'<a href="index.php?mode=lock&type=t&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'" onclick="return confirm(\''.$lang['forum']['you_are_sure_to_lock_this_topic'].'\');">'.icons($icon_lock, $lang['forum']['lock_topic'], "hspace=\"2\"").'</a>';
							}
							if($status == 0){
								echo'<a href="index.php?mode=open&type=t&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_open_this_topic'].'\');">'.icons($icon_unlock, $lang['forum']['open_topic'], "hspace=\"2\"").'</a>';
							}
							if($sticky == 0){
								echo'<a href="index.php?mode=lock&type=s&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_sticky_this_topic'].'\');">'.icons($folder_topic_sticky, $lang['forum']['sticky_topic'], "hspace=\"2\"").'</a>';
							}
		                    if($sticky == 1){
								echo'<a href="index.php?mode=open&type=s&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_un_sticky_this_topic'].'\');">'.icons($folder_topic_unsticky, $lang['forum']['un_sticky_topic'], "hspace=\"2\"").'</a>';
							}
							if($t_unmoderated == 1 OR $t_hold == 1){
								echo'<a href="index.php?mode=moderate&type=t&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_moderate_this_topic'].'\');">'.icons($folder_moderate, $lang['forum']['moderate_topic'], "hspace=\"2\"").'</a>';
							}
							if($hidden == 1 && $t_unmoderated == 0){
								echo'<a href="index.php?mode=open&type=h&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_show_this_topic'].'\');">'.icons($icon_unhidden, $lang['forum']['show_topic'], "hspace=\"2\"").'</a>';
							}
							if($hidden == 0 && $t_unmoderated == 0){
								echo'<a href="index.php?mode=lock&type=h&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_hide_this_topic'].'\');">'.icons($icon_hidden, $lang['forum']['hide_topic'], "hspace=\"2\"").'</a>';
							}
							echo'<a href="index.php?mode=option&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'">'.icons($icon_folder_archive, $lang['forum']['topic_option'], "hspace=\"2\"").'</a>';
						}
						if($allowed == 1 OR $status == 1 AND $author == $DBMemberID){
							echo'<a href="index.php?mode=editor&method=edit&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'">'.icons($icon_edit, $lang['forum']['edit_topic'], "hspace=\"2\"").'</a>';
						}
						if(allowed($f, 2) == 1){
							echo'<a href="index.php?mode=delete&type=t&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'"  onclick="return confirm(\''.$lang['forum']['you_are_sure_to_delete_this_topic'].'\');"">'.icons($icon_trash, $lang['forum']['delete_topic'], "hspace=\"2\"").'</a>';
						}
						if($allowed == 1 OR $status == 1){
							echo'<a href="index.php?mode=editor&method=reply&t='.$topic_id.'&f='.$t_forum_id.'&c='.$t_cat_id.'">'.icons($icon_reply_topic, $lang['forum']['reply_to_this_topic'], "hspace=\"2\"").'</a>';
						}
						
						echo'
						</td>';
					}
					echo'
					</tr>';
					echo'
					<tr>
						<td vAlign="top" bgcolor="white" width="20%">
						<center>
						<table cellSpacing="1" cellPadding="2" width="100%" border="0">
							<tr>';
			if($type == "unmoderated" OR $type == "hold"){
							echo'	<td><nobr><a href="index.php?mode=moderate&type=r&r='.$r.'&t='.$t.'&f='.$r_forum.'&c='.$r_cat.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_moderated_this_reply'].'\');">'.icons($folder_moderate, $lang['topics']['moderate_reply']).'</a></nobr></td>';
			}
			if($mod_option == "rhidden"){	echo'	<td><nobr><a href="index.php?mode=open&type=hr&r='.$r.'&t='.$t.'&f='.$r_forum.'&c='.$r_cat.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_show_this_reply'].'\');">'.icons($icon_unhidden, $lang['topics']['show_reply']).'</a></nobr></td>'; }
			if($mod_option == "runmoderated"){	echo'	<td><nobr><a href="index.php?mode=open&type=holdreply&r='.$r.'&t='.$t.'&f='.$r_forum.'&c='.$r_cat.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_hold_this_reply'].'\');">'.icons($icon_hold, $lang['topics']['hold_reply']).'</a></nobr></td>'; }
			if($mod_option == "runmoderated"){	echo'	<td><nobr><a href="index.php?mode=delete&type=r&r='.$r.'&t='.$t.'&f='.$r_forum.'&c='.$r_cat.'" onclick="return confirm(\''.$lang['topics']['you_are_sure_to_delete_this_reply'].'\');">'.icons($icon_delete_reply, $lang['topics']['delete_reply']).'</a></nobr></td>'; }
							echo'	<td><nobr><a href="index.php?mode=t&t='.$t.'&r='.$r.'">'.icons($icon_single, $lang['topics']['just_this_reply']).'</a></nobr></td>';
							echo'	<td><nobr><a href="index.php?mode=t&t='.$t.'&m='.$m.'">'.icons($icon_group, $lang['topics']['reply_this_member']).'</a></nobr></td>';
							echo'	<td><nobr><a href="index.php?mode=requestmon&aid='.$m.'&r='.$r.'&t='.$t.'&f='.$r_forum.'&c='.$r_cat.'">'.icons($icon_moderation, $lang['topics']['apply_moderation_to_this_member']).'</a></nobr></td>';
							echo'	<td><nobr><a href="index.php?mode=editor&method=editreply&r='.$r.'&t='.$t.'&f='.$r_forum.'&c='.$r_cat.'">'.icons($icon_edit, $lang['topics']['edit_reply']).'</a></nobr></td>
							</tr>';
					if($type == "unmoderated" OR $type == "hold" OR $type == "hidden"){
							echo'
							<tr>
								<td colspan="20">
								<table cellSpacing="1" cellPadding="2" width="99%" border="1">
								<form method="post" action="index.php?mode=moderate&type=replies_tools&f='.$f.'&c='.$cat_id.'">
									<tr class="fixed">
										<td class="optionsbar_menus" colspan="6"><nobr>إختيار جماعي</nobr></td>
									</tr>
									<tr class="fixed">
										<td align="center"><input class="small" type="checkbox" name="reply_id[]" value="'.$r.'"></td>
									</tr>
								</table>
								</td>
							</tr>';
					}
						echo'
						</table>
						</center>
						</td>
						<td bgcolor="white" colspan="20" width="80%">
						<table style="TABLE-LAYOUT: fixed">
							<tr>
								<td>'.text_replace($message).'</td>
							</tr>
						</table>
						</td>
					</tr>';
	}
			++$r_i;
			}
			if(($mod_option == "runmoderated" OR $mod_option == "rholded" OR $mod_option == "rhidden") AND $r_num > 0){
			echo'
			<tr>
				<td bgcolor="white" colspan="8">
				<table cellSpacing="1" cellPadding="1" width="100%" border="0">
					<tr>
						<td align="center"><br>
						<input type="button" value="تحديد الكل" onclick="this.value=check(this.form.elements, \'عدد الردود التي اخترت هو \')">&nbsp;&nbsp;';
				if($mod_option == "runmoderated" OR $mod_option == "rholded"){
					echo'	<input type="submit" name="subApprove" value="الموافقة على الردود المختارة"  onclick="return confirm(\'هل أنت متأكد من الموافقة على الردود المختارة\');">&nbsp;&nbsp;';
				}
				if($mod_option == "runmoderated"){
					echo'	<input type="submit" name="subHold" value="تجميد الردود المختارة" onclick="return confirm(\'هل أنت متأكد من تجميد الردود المختارة\');">&nbsp;&nbsp;';
				}
				if($mod_option == "rhidden"){
					echo'	<input type="submit" name="subHidden" value="إظهار الردود المختارة" onclick="return confirm(\'هل أنت متأكد من اظهار الردود المختارة\');">&nbsp;&nbsp;';
				}
					echo'	<input type="submit" name="subDelete" value="حذف الردود المختارة" onclick="return confirm(\'هل أنت متأكد من حذف الردود المختارة\');">
						</td>
					</tr>
				</table>
				</td>
			</tr>
			</form>';
			}
				echo'
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</center>';
}

//------------------------------------ TOPIC COUNT ------------------------------------

function unlocked_topics($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_STATUS = '1' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function unmoderated_topics($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_UNMODERATED = '1' AND T_STATUS < 2 ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function holded_topics($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_HOLDED = '1' AND T_STATUS < 2 ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function locked_topics($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_STATUS = '0' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function hidden_topics($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_HIDDEN = '1' AND T_STATUS < 2 ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function top_topics($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_TOP = '1' AND T_STATUS < 2 ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function survey_topics($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_SURVEYID != '0' AND T_STATUS < 2 ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function unarchived_topics($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_ARCHIVE_FLAG = '0' AND T_STATUS < 2 ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function moved_topics($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_MOVED = '1' AND T_STATUS < 2 ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function edited_topics($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_LASTEDIT_MAKE != '' AND T_STATUS < 2 ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function deleted_topics($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$f' AND T_STATUS = '2' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

//------------------------------------ TOPIC COUNT ------------------------------------

//------------------------------------ REPLY COUNT ------------------------------------

function unmoderated_replies($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}REPLY WHERE FORUM_ID = '$f' AND R_UNMODERATED = '1' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function holded_replies($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}REPLY WHERE FORUM_ID = '$f' AND R_HOLDED = '1' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function hidden_replies($f){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}REPLY WHERE FORUM_ID = '$f' AND R_HIDDEN = '1' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

//------------------------------------ REPLY COUNT ------------------------------------


?>
