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

require_once _df_path."includes/home_function.php";

$time = mktime(gmdate("H"), gmdate("i"), gmdate("s"));
$time = gmt_time($time);
define('time', $time);
include("ads.php");
if($best == 0){
include("best.php");
} 
if($WHAT_ACTIVE == 1){
include("what_info.php");
} 

if(members("INDEX", $DBMemberID) == 1 AND mlv > 0 ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang['permission']['sorry'].'
'.$lang['permission']['index'].'<br>
'.$lang['permission']['contact'].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}


	echo'
	<center>
	<table class="mainheader" cellSpacing="0" cellPadding="0" width="99%" border="0">
		<tr>
			<td width="99%">&nbsp;</td>
			<td vAlign="center"><font size="3" color="red">'.time.'</font></td>
			<td>&nbsp;</td>

			<form method="post" action="index.php?tz=1">
			<td vAlign="center">
			<select class="timezoneSelect" style="WIDTH: 70px" name="timezone" onchange="submit();">';
			home_timezone();
			echo'
			</select>
			</td>
			</form>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<form method="post" action="index.php?ch=lang">
			<td vAlign="center">
			<select class="styleSelect" name="lan_name" onchange="submit();">';

        $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}LANGUAGE ", [], __FILE__, __LINE__);
        if($sql->rowCount() > 0){
            while ($ch_lang = $sql->fetch()){

                $lang_id = $ch_lang["L_ID"];
                $lang_file_name = $ch_lang["L_FILE_NAME"];
                $lang_name = $ch_lang["L_NAME"];
            
                echo'<option value="'.$lang_file_name.'" '.check_select($choose_language, $lang_file_name).'>'.$lang_name.'</option>';
            }
        }
        else {
            echo'<option value="">'.$lang['home']['choose_language'].'</option>';
        }
            echo'
            </select>
            </td>
            </form>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
            <form method="post" action="index.php?ch=style">
            <td vAlign="center">
            <select class="styleSelect" name="style_name" onchange="submit();">';

        $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}STYLE ", [], __FILE__, __LINE__);
        if($sql->rowCount() > 0){

            while ($r_style = $sql->fetch()){

                $style_id = $r_style['S_ID'];
                $style_file_name = $r_style['S_FILE_NAME'];
                $style_name = $r_style['S_NAME'];

                echo'<option value="'.$style_file_name.'" '.check_select($choose_style, $style_file_name).'>'.$style_name.'</option>';
            }
        }
        else {
            echo'<option value="">'.$lang['home']['choose_style'].'</option>';
        }
            echo'
            </select>
            </td>
            </form>
	</tr>
	<tr>';
		home_online();
	echo'
	</tr>
</table>
</center>
';

	if($Mlevel == 4){
		home_add();
	}
	
	echo'
	<center>
	<table cellSpacing="0" cellPadding="0" width="99%" border="0">
		<tr>
			<td>
			<table class="grid" cellSpacing="1" cellPadding="1" width="100%" border="0">';
			$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY WHERE SITE_ID = '$Site_ID' OR SITE_ID = '3' ORDER BY CAT_ORDER ASC", [], __FILE__, __LINE__); // category mysql
			if( $sql->rowCount() <= 0 ){
				echo'
				<tr>
					<td class="f1" vAlign="center" align="middle"><br><br>'.$lang['home']['no_cat'].'<br><br><br></td>
				</tr>';
			}
			else{

				while ($r_cat = $sql->fetch()){ //category while start
					$cat_id = $r_cat['CAT_ID'];
					$cat_name = $r_cat['CAT_NAME'];
					$cat_status = $r_cat['CAT_STATUS'];
					$cat_monitor = $r_cat['CAT_MONITOR'];
					$cat_index = $r_cat['SHOW_INDEX'];
					$cat_hide = cat("HIDE", $cat_id);
					$check_cat_login = check_cat_login($cat_id);
					$cat_level = $r_cat['CAT_LEVEL'];

					if($cat_level == 0 OR $cat_level > 0 AND $cat_level <= $Mlevel){

					if($cat_hide == 0 OR $cat_hide == 1 AND $check_cat_login == 1){
					
					echo'
					<tr>
						<td class="cat" width="30%"><nobr>'.$cat_name.'</nobr></td>';
                        if($Mlevel == 4){
                       echo '<td class="cat"><nobr><a href="index.php?mode=admin_svc&type=forumsorder">'.icons($icon_arrowup).icons($icon_arrowdown).'</a></nobr></td>';
}
						echo'<td class="cat"><nobr>'.$lang['home']['topics'].'</nobr></td>
						<td class="cat"><nobr>'.$lang['home']['posts'].'</nobr></td>
						<td class="cat"><nobr>'.icons($icon_group).'</nobr></td>
						<td class="cat"><nobr>'.$lang['home']['last_post'].'</nobr></td>
						<td class="cat"><nobr>'.$lang['home']['monitors'].'</nobr></td>
						<td class="cat" width="30%"><nobr>'.$lang['home']['moderators'].'</nobr></td>';
						if($Mlevel == 4){
							echo'
							<td class="cat" vAlign="middle" align="middle"><nobr>
								<a href="index.php?mode=add_cat_forum&method=add&type=f&c='.$cat_id.'">'.icons($folder_new, $lang['home']['add_new_forum'], "hspace=\"3\"").'</a>
								<a href="index.php?mode=add_cat_forum&method=edit&type=c&c='.$cat_id.'">'.icons($folder_new_edit, $lang['home']['edit_cat'], "hspace=\"3\"").'</a>';
							if($cat_status == 1){
								echo'
								<a href="index.php?mode=lock&type=c&c='.$cat_id.'"  onclick="return confirm(\''.$lang['home']['you_are_sure_to_lock_this_cat'].'\');">'.icons($folder_new_locked, $lang['home']['lock_cat'], "hspace=\"3\"").'</a>';
							}
							if($cat_status == 0){
								echo'
								<a href="index.php?mode=open&type=c&c='.$cat_id.'"  onclick="return confirm(\''.$lang['home']['you_are_sure_to_open_this_cat'].'\');">'.icons($folder_new_unlocked, $lang['home']['open_cat'], "hspace=\"3\"").'</a>';
							}
							echo'<a href="index.php?mode=delete&type=c&c='.$cat_id.'"  onclick="return confirm(\''.$lang['home']['you_are_sure_to_delete_this_cat'].'\');">'.icons($folder_new_delete, $lang['home']['delete_cat'], "hspace=\"3\"").'</a>
							</nobr></td>';
						}
					echo'
					</tr>';
					$forums_sql = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE CAT_ID = '$cat_id' ORDER BY F_ORDER ASC", [], __FILE__, __LINE__); // forum mysql
					if($forums_sql->rowCount() <= 0){
						echo'
						<tr>
							<td class="f1" vAlign="center" align="middle" colspan="20"><br><br>'.$lang['home']['no_forums'].'<br><br><br></td>
						</tr>';
					}
					else{
						while ($r_forum = $forums_sql->fetch()){ // forum while start
							$forum_id = $r_forum['FORUM_ID'];
							$f_level = $r_forum['F_LEVEL'];
							$f_hide = forums("HIDE", $forum_id);
							$check_forum_login = check_forum_login($forum_id);

           					if($f_level == 0 OR $f_level > 0 AND $f_level <= mlv){
								if($f_hide == 0 OR $f_hide == 1 AND $check_forum_login == 1){
									home($forum_id,$r_forum);
								}
							}
							
						// forum while end
						}
					}
					}}
				 // category while end
				}
			}

			echo'
			</table>
			</td>
		</tr>
	</table>
	</center>';

include("other_cat_info.php");
print $coda;

?>

