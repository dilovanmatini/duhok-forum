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

function ht_head(){
			echo'
			<table cellSpacing="2" width="100%" border="0">
				<tr>
					<td width="100%" vAlign="center"><a href="index.php?mode=ht"><font size="4" color="red"><b>المواضيع المخفية المفتوحة لك</b></font></a></td>';
					refresh_time();
					go_to_forum();
				echo'
				</tr>
			</table>';
}

function ht_topics($t){
	global $Mlevel, $DBMemberID, $lang, $folder_new_locked, $folder_new, $folder, $icon_reply_topic, $icon_edit;
	
$f = topics("FORUM_ID", $t);
$status = topics("STATUS", $t);
$subject = topics("SUBJECT", $t);
$author = topics("AUTHOR", $t);
$replies = topics("REPLIES", $t);
$views = topics("COUNTS", $t);
$lp_date = topics("LAST_POST_DATE", $t);
$date = topics("DATE", $t);
$lp_author = topics("LAST_POST_AUTHOR", $t);
$hide = topics("HIDDEN", $t);
$f_subject = forums("SUBJECT", $f);

						echo'
						<tr class="normal">
							<td class="list_center"><a href="index.php?mode=f&f='.$f.'"><b>'.$f_subject.'</b></a></td>
							<td class="list_center"><nobr><a href="index.php?mode=f&f='.$f.'">';
							if($status == 0 AND $replies < 20){
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
							echo'</a></nobr></td>
							<td class="list">
							<table cellPadding="0" cellsapcing="0" id="table2">
								<tr>
									<td><a href="index.php?mode=t&t='.$t.'"><b>'.$subject.'</b></a>&nbsp;'; echo topic_paging($t); echo'</td>
								</tr>
							</table>
							</td>
							<td class="list_small2" noWrap><font color="green">'.normal_time($date).'</font><br><b>'.member_color_link($author).'</b></td>
							<td class="list_small2">'.$replies.'</td>
							<td class="list_small2">'.$views.'</td>
							<td class="list_small2" noWrap><font color="red">';
						if($replies > 0){
							echo normal_time($lp_date).'</font><br><b>'.member_color_link($lp_author).'<b>';
						}
							echo'
							</td>';
						if($Mlevel > 0){
							echo'
							<td class="list_small2">';
							if(allowed($f, 2) == 1 OR $status == 1 AND $author == $user_id){
								echo'<a href="index.php?mode=editor&method=edit&t='.$t.'">'.icons($icon_edit, $lang['forum']['edit_topic'], "hspace=\"2\"").'</a>';
							}
							if(allowed($f, 2) == 1 OR $status == 1){
								echo'<a href="index.php?mode=editor&method=reply&t='.$t.'">'.icons($icon_reply_topic, $lang['forum']['reply_to_this_topic'], "hspace=\"2\"").'</a>';
							}
							echo'
							</td>';
						}	
						echo'
						</tr>';
}

function ht_body(){
	global $Mlevel, $DBMemberID, $lang;
			echo'
			<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
				<tr>
					<td>
					<table cellSpacing="1" cellPadding="2" width="100%" border="0">
						<tr>
							<td class="cat" width="15%">المنتدى</td>
							<td class="cat">&nbsp;</td>
							<td class="cat" width="45%">الموضوع</td>
							<td class="cat" width="15%">الكاتب</td>
							<td class="cat">الردود</td>
							<td class="cat">قرأت</td>
							<td class="cat" width="15%">آخر رد</td>
							<td class="cat" width="1%">خيارات</td>
						</tr>';
				$topics = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE T_HIDDEN = '1' ORDER BY T_LAST_POST_DATE DESC ", [], __FILE__, __LINE__);
				$num = mysql_num_rows($topics);
				if($num > 0){
					$i = 0;
					while ($i < $num){
						$t = mysql_result($topics, $i, "TOPIC_ID");
						if(chk_is_topic_in_topic_members($t) == 1){
							ht_topics($t);
							$x = $x + 1;
						}
					++$i;
					}
				}
				if($x == 0 OR $x == ""){
						echo'
						<tr>
							<td class="f1" vAlign="center" align="middle" colspan="20"><br><br>لا توجد أي موضوع مخفي ومفتوح لك<br><br><br></td>
						</tr>';
				}
					echo'
					</table>
					</td>
				</tr>
			</table>';
}

function ht_func(){
	echo'
	<center>
	<table cellSpacing="0" cellPadding="0" width="99%" border="0">
		<tr>
			<td>';
			ht_head();
			ht_body();
			echo'
			</td>
		</tr>
	</table>
	</center>';
}

ht_func();
?>
