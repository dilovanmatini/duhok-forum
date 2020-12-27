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

function active($t){
	global $folder_new_locked, $folder_new, $folder_new_hot, $folder,
		$Mlevel, $DBMemberID, $icon_reply_topic, $icon_edit,
		$lang;

$cat_id = topics("CAT_ID", $t);
$forum_id = topics("FORUM_ID", $t);
$status = topics("STATUS", $t);
$subject = topics("SUBJECT", $t);
$author = topics("AUTHOR", $t);
$replies = topics("REPLIES", $t);
$counts = topics("COUNTS", $t);
$lp_date = topics("LAST_POST_DATE", $t);
$date = topics("DATE", $t);
$lp_author = topics("LAST_POST_AUTHOR", $t);
$hidden = topics("HIDDEN", $t);
$author_name = members("NAME", $author);
$lp_author_name = members("NAME", $lp_author);
$f_subject = forums("SUBJECT", $forum_id);

$allowed = allowed($forum_id, 2);

	echo'
	<tr class="normal">
		<td class="list_small"><a href="index.php?mode=f&f='.$forum_id.'">'.$f_subject.'</a></td>
		<td class="list_center"><nobr><a href="index.php?mode=f&f='.$forum_id.'">';
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
		echo'
		</a></nobr></td>
		<td class="list">
		<table cellPadding="0" cellsapcing="0" id="table2">
			<tr>
				<td><a href="index.php?mode=t&t='.$t.'">'.$subject.'</a>&nbsp;'; echo topic_paging($t); echo'</td>
			</tr>
		</table>
		</td>
		<td class="list_small2" noWrap><font color="green">'.normal_time($date).'</font><br>'.member_color_link($author).'</td>
		<td class="list_small2">'.$replies.'</td>
		<td class="list_small2">'.$counts.'</td>
		<td class="list_small2" noWrap><font color="red">';
	if($replies > 0){
		echo normal_time($lp_date).'</font><br>'.member_color_link($lp_author);
	}
		echo'
		</td>';
	if($Mlevel > 0){
		echo'
		<td class="list_small2">';
		if($allowed == 1 OR $status == 1){
			echo'<a href="index.php?mode=editor&method=reply&t='.$t.'&f='.$forum_id.'&c='.$cat_id.'">'.icons($icon_reply_topic, "رد على الموضوع", "hspace=\"2\"").'</a>';
		}
		if($allowed == 1 OR $status == 1 AND $DBMemberID == $author){
			echo'<a href="index.php?mode=editor&method=edit&t='.$t.'&f='.$forum_id.'&c='.$cat_id.'">'.icons($icon_edit, "تعديل الموضوع", "hspace=\"2\"").'</a>';
		}
		
		echo'
		</td>';
	}	
	echo'
	</tr>';
	
}

function active_private($t){
	global $folder_new_locked, $folder_new, $folder_new_hot, $folder,
		$Mlevel, $DBMemberID, $icon_reply_topic, $icon_edit,
		$lang;

$cat_id = topics("CAT_ID", $t);
$forum_id = topics("FORUM_ID", $t);
$status = topics("STATUS", $t);
$subject = topics("SUBJECT", $t);
$author = topics("AUTHOR", $t);
$replies = topics("REPLIES", $t);
$counts = topics("COUNTS", $t);
$lp_date = topics("LAST_POST_DATE", $t);
$date = topics("DATE", $t);
$lp_author = topics("LAST_POST_AUTHOR", $t);
$hidden = topics("HIDDEN", $t);
$author_name = members("NAME", $author);
$lp_author_name = members("NAME", $lp_author);
$f_subject = forums("SUBJECT", $forum_id);

$allowed = allowed($forum_id, 2);

	echo'
	<tr class="normal">
		<td class="list_small"><a href="index.php?mode=f&f='.$forum_id.'">'.$f_subject.'</a></td>
		<td class="list_center"><nobr><a href="index.php?mode=f&f='.$forum_id.'">';
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
		echo'
		</a></nobr></td>
		<td class="list">
		<table cellPadding="0" cellsapcing="0" id="table2">
			<tr>
				<td><a href="index.php?mode=t&t='.$t.'">'.$subject.'</a>&nbsp;'; echo topic_paging($t); echo'</td>
			</tr>
		</table>
		</td>
		<td class="list_small2" noWrap><font color="green">'.normal_time($date).'</font><br>'.member_color_link($author).'</td>
		<td class="list_small2">'.$replies.'</td>
		<td class="list_small2">'.$counts.'</td>
		<td class="list_small2" noWrap><font color="red">';
	if($replies > 0){
		echo normal_time($lp_date).'</font><br>'.member_color_link($lp_author);
	}
		echo'
		</td>';
	if($Mlevel > 0){
		echo'
		<td class="list_small2">';
		if($allowed == 1 OR $status == 1){
			echo'<a href="index.php?mode=editor&method=reply&t='.$t.'&f='.$forum_id.'&c='.$cat_id.'">'.icons($icon_reply_topic, "رد على الموضوع", "hspace=\"2\"").'</a>';
		}
		if($allowed == 1 OR $status == 1 AND $DBMemberID == $author){
			echo'<a href="index.php?mode=editor&method=edit&t='.$t.'&f='.$forum_id.'&c='.$cat_id.'">'.icons($icon_edit, "تعديل الموضوع", "hspace=\"2\"").'</a>';
		}
		
		echo'
		</td>';
	}	
	echo'
	</tr>';
	
}

function active_monitored($t){

	global $folder_new_locked, $folder_new, $folder_new_hot, $folder,
		$Mlevel, $DBMemberID, $icon_reply_topic, $icon_subscribe,
		$lang;

$cat_id = topics("CAT_ID", $t);
$forum_id = topics("FORUM_ID", $t);
$status = topics("STATUS", $t);
$subject = topics("SUBJECT", $t);
$author = topics("AUTHOR", $t);
$replies = topics("REPLIES", $t);
$counts = topics("COUNTS", $t);
$lp_date = topics("LAST_POST_DATE", $t);
$date = topics("DATE", $t);
$lp_author = topics("LAST_POST_AUTHOR", $t);
$hidden = topics("HIDDEN", $t);
$memder_id = fav_topic("MEMBERID", $t);
$author_name = members("NAME", $author);
$lp_author_name = members("NAME", $lp_author);
$f_subject = forums("SUBJECT", $forum_id);

// $favT = " SELECT * FROM {$mysql->prefix}FAVOURITE_TOPICS ";
// $favT .= " WHERE F_TOPICID = '$t' AND F_MEMBERID = '$DBMemberID' ";
// $rfavT = $mysql->execute($favT, $connection, [], __FILE__, __LINE__);
//    if(mysql_num_rows($rfavT)>0){
//        $rsfav=mysql_fetch_array($rfavT);
//        $fmember_id=$rsfav['F_MEMBERID'];
//    }

$allowed = allowed($forum_id, 2);

	echo'
	<tr class="lastposter">
		<td class="list_small"><a href="index.php?mode=f&f='.$forum_id.'">'.$f_subject.'</a></td>
		<td class="list_center"><nobr><a href="index.php?mode=f&f='.$forum_id.'">';
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
		echo'
		</a></nobr></td>
		<td class="list">
		<table cellPadding="0" cellsapcing="0" id="table2">
			<tr>
				<td><a href="index.php?mode=t&t='.$t.'">'.$subject.'</a>&nbsp;'; echo topic_paging($t); echo'</td>
			</tr>
		</table>
		</td>
		<td class="list_small2" noWrap><font color="green">'.normal_time($date).'</font><br>'.member_color_link($author).'</td>
		<td class="list_small2">'.$replies.'</td>
		<td class="list_small2">'.$counts.'</td>
		<td class="list_small2" noWrap><font color="red">';
	if($replies > 0){
		echo normal_time($lp_date).'</font><br>'.member_color_link($lp_author);
	}
		echo'
		</td>';
	if($Mlevel > 0){


		echo'
		<td class="list_small2">';
		if($allowed == 1 OR $status == 1){
			echo'<a href="index.php?mode=editor&method=reply&t='.$t.'&f='.$forum_id.'&c='.$cat_id.'">'.icons($icon_reply_topic, "رد على الموضوع", "hspace=\"2\"").'</a>';
		}
			echo'<a href="index.php?mode=delete&type=monitored&t='.$t.'">'.icons($icon_subscribe, "أزل هذا الموضوع من قائمة مواضيعك المفضلة", "hspace=\"2\"").'</a>';
		echo'
		</td>';
	}	
	echo'
	</tr>';
	
}

?>
