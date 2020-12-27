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

if(members("ARCHIVE", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][archive].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}


function home($f){
	global 
	$lang, $Mlevel, $image_folder, $folder_locked, 
	$folder, $show_moderators, $folder_edit, $folder_unlocked,
	$folder_delete, $cat_monitor;
	
	$f_cat_id = forums("CAT_ID", $f);
	$f_subject = forums("SUBJECT", $f);
	$f_status = forums("STATUS", $f);
	$f_topics = forums("TOPICS", $f);
	$f_archive = mysql_num_rows($mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE T_ARCHIVED = '1' AND FORUM_ID = '$f' "));
							
							echo'
							<tr>
								<td class="f1">
<a href="index.php?mode=f&f='.$f.'&type=archive">'.$f_subject.'</a>
								</td>
								<td class="f2ts" vAlign="center" align="middle">
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
										<td class="f2ts" vAlign="center" align="middle">'.$f_archive.'</td>
									</tr>
								</table>
							</td>
							<td class="f2ts">'.$f_topics.'</td>';
							echo'
							</tr>';             
}



	echo'
	<center>
	<table cellSpacing="0" cellPadding="0" width="50%" border="0">
		<tr>
			<td>
<table class="grid" cellSpacing="1" cellPadding="1" width="100%" border="0"><tr>
<td colspan="3" align="middle" bgcolor="yellow" valign="top"><b><font color="black" size="+2">أرشيف المنتديات</font></b></td>
</tr>
';
			$cat = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY ORDER BY CAT_ORDER ASC", [], __FILE__, __LINE__); // category mysql
			$c_num = mysql_num_rows($cat);
			if($c_num <= 0){
				echo'
				<tr>
					<td class="f1" vAlign="center" align="middle"><br><br>'.$lang['home']['no_cat'].'<br><br><br></td>
				</tr>';
			}
			else{
				$c_i = 0;
				while ($c_i < $c_num){ //category while start
					$cat_id = mysql_result($cat, $c_i, "CAT_ID");
					$cat_name = mysql_result($cat, $c_i, "CAT_NAME");
					$cat_status = mysql_result($cat, $c_i, "CAT_STATUS");
					$cat_level = mysql_result($cat, $c_i, "CAT_LEVEL");
					$cat_hide = cat("HIDE", $cat_id);
					$check_cat_login = check_cat_login($cat_id);

					if($cat_level == 0 OR $cat_level > 0 AND $cat_level <= $Mlevel){
					if($cat_hide == 0 OR $cat_hide == 1 AND $check_cat_login == 1){
					
					echo'
					<tr>
						<td class="cat" width="30%"><nobr> أرشيف '.$cat_name.'</nobr></td>
						<td class="cat"><nobr>المواضيع في الأرشيف</nobr></td>
						<td class="cat"><nobr>إجمالي المواضيع في المنتدى</nobr></td>';

					echo'
					</tr>';
					$forums = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE CAT_ID = '$cat_id' ORDER BY F_ORDER ASC", [], __FILE__, __LINE__); // forum mysql
					$f_num = mysql_num_rows($forums);
					if($f_num <= 0){
						echo'
						<tr>
							<td class="f1" vAlign="center" align="middle" colspan="20"><br><br>'.$lang['home']['no_forums'].'<br><br><br></td>
						</tr>';
					}
					else{
						$f_i = 0;
						while ($f_i < $f_num){ // forum while start
							$forum_id = mysql_result($forums, $f_i, "FORUM_ID");
							$f_level = mysql_result($forums, $f_i, "F_LEVEL");
							$f_hide = forums("HIDE", $forum_id);

							$check_forum_login = check_forum_login($forum_id);
							                                                                                                                           
							if($f_level == 0 OR $f_level > 0 AND $f_level <= mlv){
							if($f_hide == 0 OR $f_hide == 1 AND $check_forum_login == 1){
								home($forum_id);
							}}
							
						++$f_i; // forum while end
						}
					}
					}}
				++$c_i; // category while end
				}
			}
			echo'
			</table>
			</td>
		</tr>
	</table>
	</center>';
print $coda;

?>

