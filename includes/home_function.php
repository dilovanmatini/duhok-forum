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

function home_timezone(){
	global $load_timezone;
		echo'
			<option value="-12" '.check_select($load_timezone, "-12").'>GMT -12</option>
			<option value="-11" '.check_select($load_timezone, "-11").'>GMT -11</option>
			<option value="-10" '.check_select($load_timezone, "-10").'>GMT -10</option>
			<option value="-9" '.check_select($load_timezone, "-9").'>GMT -9</option>
			<option value="-8" '.check_select($load_timezone, "-8").'>GMT -8</option>
			<option value="-7" '.check_select($load_timezone, "-7").'>GMT -7</option>
			<option value="-6" '.check_select($load_timezone, "-6").'>GMT -6</option>
			<option value="-5" '.check_select($load_timezone, "-5").'>GMT -5</option>
			<option value="-4" '.check_select($load_timezone, "-4").'>GMT -4</option>
			<option value="-3" '.check_select($load_timezone, "-3").'>GMT -3</option>
			<option value="-2" '.check_select($load_timezone, "-2").'>GMT -2</option>
			<option value="-1" '.check_select($load_timezone, "-1").'>GMT -1</option>
			<option value="0" '.check_select($load_timezone, "0").'>GMT</option>
			<option value="1" '.check_select($load_timezone, "1").'>GMT +1</option>
			<option value="2" '.check_select($load_timezone, "2").'>GMT +2</option>
			<option value="3" '.check_select($load_timezone, "3").'>GMT +3</option>
			<option value="4" '.check_select($load_timezone, "4").'>GMT +4</option>
			<option value="5" '.check_select($load_timezone, "5").'>GMT +5</option>
			<option value="6" '.check_select($load_timezone, "6").'>GMT +6</option>
			<option value="7" '.check_select($load_timezone, "7").'>GMT +7</option>
			<option value="8" '.check_select($load_timezone, "8").'>GMT +8</option>
			<option value="9" '.check_select($load_timezone, "9").'>GMT +9</option>
			<option value="10" '.check_select($load_timezone, "10").'>GMT +10</option>
			<option value="11" '.check_select($load_timezone, "11").'>GMT +11</option>
			<option value="12" '.check_select($load_timezone, "12").'>GMT +12</option>';
}

function home_online(){
	global $mysql, $lang, $Mlevel;
	$visitors_sql = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}ONLINE WHERE O_MEMBER_LEVEL = '0' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$visitors_online = intval($visitors_sql[0]);
	
	$members_sql = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}ONLINE WHERE O_MEMBER_LEVEL = '1' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$members_online = intval($members_sql[0]);
	
	$moderators_sql = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}ONLINE WHERE O_MEMBER_LEVEL = '2' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$moderators_online = intval($moderators_sql[0]);

	$monitors_sql = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}ONLINE WHERE O_MEMBER_LEVEL = '3' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$monitors_online = intval($monitors_sql[0]);
			echo'
			<td vAlign="center"><nobr><font color="red">'.$lang['home']['online_now'].'</font>&nbsp;&nbsp;&nbsp;';
				echo $lang['home']['members'].'<font class="online">'.$members_online.'</font>&nbsp;&nbsp;&nbsp;';
				echo $lang['home']['the_moderator'].'<font class="online">'.$moderators_online.'</font>&nbsp;&nbsp;&nbsp;';
			if($Mlevel > 2){	
				echo $lang['home']['the_monitor'].'<font class="online">'.$monitors_online.'</font>&nbsp;&nbsp;&nbsp;';
			}	
				echo $lang['home']['visitor'].'<font class="online">'.$visitors_online.'</font>';
			echo'
			<nobr></td>';
}

function home_add(){
	global $lang, $folder_new, $folder_new_order, $folder_other_cat, $folder_other_forum;
	echo'
	<center>
	<table cellSpacing="0" cellPadding="0" width="99%" border="0">
		<tr>
			<td>
			<table class="grid" cellSpacing="1" cellPadding="0" width="100%" border="0">
				<tr>
					<td class="cat" align="middle">
						<a href="index.php?mode=add_cat_forum&method=add&type=c">'.icons($folder_new, $lang['home']['add_new_cat'], "hspace=\"3\"").'</a>
						<a href="index.php?mode=order">'.icons($folder_new_order, $lang['home']['order_cat_and_forum'], "hspace=\"3\"").'</a>
						<a href="index.php?mode=other_cat_add&method=cat">'.icons($folder_other_cat, $lang['other_cat_forum']['add_cat'], "hspace=\"3\"").'</a>
						<a href="index.php?mode=ihdaa_add&method=forum">'.icons($folder_other_forum, $lang['ihdaa']['active'], "hspace=\"3\"").'</a>
					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	</center>';
}

function home_forum_mods($id){
	global $mysql;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MODERATOR WHERE FORUM_ID = '$id' ", [], __FILE__, __LINE__);
	$forum_mods = '<table class="mods" cellspacing="0" cellpadding="0"><tr>';
 	$j = 0;
	$i = 0;
	while ( $result = $sql->fetch() ){
		$member_id = $result["MEMBER_ID"];
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
	return($forum_mods);
}

function home($f,$f_array){
	global 
	$lang, $Mlevel, $image_folder, $folder_locked, $icon_group, 
	$folder, $show_moderators, $folder_edit, $folder_unlocked,
	$folder_delete, $cat_monitor;
	
	$f_cat_id = $f_array['CAT_ID'];
	$f_subject = $f_array['F_SUBJECT'];
	$f_status = $f_array['F_STATUS'];
	$f_desc = $f_array['F_DESCRIPTION'];
	$f_topics = $f_array['F_TOPICS'];
	$f_replies = $f_array['F_REPLIES'];
	$f_last_post_date = $f_array['F_LAST_POST_DATE'];
	$f_last_post_author = $f_array['F_LAST_POST_AUTHOR'];
	$f_logo = $f_array['F_LOGO'];
	$author_name = members("NAME", $f_last_post_author);
    $f_order = forum_order($f);
    $show = $f_array['SHOW_INDEX'];
	$show_index = cat("SHOW_INDEX", $f_cat_id);

							
							echo'
							<tr>
								<td class="f1">
								<table width="100%">
									<tr>
										<td class="logo" align="middle" width="55">'.icons($f_logo).'</td>
										<td class="f1"><a href="index.php?mode=f&f='.$f.'">'.$f_subject.'</a><br><font size="1">'.$f_desc.'</font></td>
									</tr>
								</table>
								</td>';
            if($Mlevel == 4)   { echo'<td class="f2ts">'.$f_order.'</td>'; }
							   echo	'<td class="f2ts" vAlign="center" align="middle">
								<table width="100%">

									<tr>

										<td>';
										if($f_status == 0){
											echo icons($folder_locked, $lang['home']['forum_locked'], "");
										}
										else {
											echo icons($folder, $lang['home']['forum_opened'], "");
										}
										echo'
										</td>
										<td class="f2ts" vAlign="center" align="middle">'.$f_topics.'</td>
									</tr>
								</table>
							</td>
							<td class="f2ts">'.$f_replies.'</td>
							<td class="f2ts" width="25">'.forum_online_num($f).'</td>
							<td class="f2ts">';
							if($author_name != ""){
									echo'
									<nobr><font color="red">'.normal_time($f_last_post_date).'</font><br>'.link_profile($author_name, $f_last_post_author);
								
							}
							echo'
							</td>
							<td class="f1" align="center">
							<table class="mods" cellSpacing="0" cellPadding="0">
								<tr>
									<td><nobr>';
									 if($show_index == 0){
										echo 
										member_normal_link($cat_monitor);
									    }
									echo'
									</nobr></td>
								</tr>
								
							</table>
							</td>
							<td class="f1">';
	if($show == 0  ){
							
								echo home_forum_mods($f); // forum moderator
							}
							if($show == 1  ){
								echo '&nbsp;';
							}
							if($show == 1 AND $Mlevel == 4 ){
								echo home_forum_mods($f); // forum moderator
							}

							echo'
							</td>';
							if($Mlevel == 4){
								echo'
								<td class="f2ts"><nobr>
									<a href="index.php?mode=show&method=edit&type=f&f='.$f.'">'.icons($icon_group, $lang['home']['show_forum'], "hspace=\"3\"").'</a>
									<a href="index.php?mode=editor&method=topic&f='.$f.'&c='.$f_cat_id.'">'.icons($folder, $lang['home']['add_new_topic'], "hspace=\"3\"").'</a>
									<a href="index.php?mode=add_cat_forum&method=edit&type=f&f='.$f.'">'.icons($folder_edit, $lang['home']['edit_forum'], "hspace=\"3\"").'</a>';
								if($f_status == 1){
									echo'
									<a href="index.php?mode=lock&type=f&f='.$f.'&c='.$f_cat_id.'" onclick="return confirm(\''.$lang['home']['you_are_sure_to_lock_this_forum'].'\');">'.icons($folder_locked, $lang['home']['lock_forum'], "hspace=\"3\"").'</a>';
								}
								if($f_status == 0){
									echo'<a href="index.php?mode=open&type=f&f='.$f.'&c='.$f_cat_id.'" onclick="return confirm(\''.$lang['home']['you_are_sure_to_open_this_forum'].'\');">'.icons($folder_unlocked, $lang['home']['open_forum'], "hspace=\"3\"").'</a>';
								}
									echo'
									<a href="index.php?mode=delete&type=f&f='.$f.'&c='.$f_cat_id.'" onclick="return confirm(\''.$lang['home']['you_are_sure_to_delete_this_forum'].'\');">'.icons($folder_delete, $lang['home']['delete_forum'], "hspace=\"3\"").'</a>
								</nobr></td>';
								}
							echo'
							</tr>';             
}

?>
