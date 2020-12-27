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

$HTTP_REFERER = $_SERVER['HTTP_REFERER'];
$method = HtmlSpecialchars($_POST['method']);
$quote = intval($_POST['quote']);
$r = intval($_POST['r']);
$t = intval($_POST['t']);
$f = intval($_POST['f']);
$c = intval($_POST['c']);
$m = intval($_POST['m']);
$host = HtmlSpecialchars($_POST['host']);
$type = HtmlSpecialchars($_POST['type']);
$pm_from = $_POST['pm_from'];
$pm_to = intval($_POST['pm_to']);
$msg = intval($_POST['msg']);
$refer = HtmlSpecialchars($_POST['refer']);
$hidden = intval($_POST['hidden']);
$lock = intval($_POST['lock']);
$sticky = intval($_POST['sticky']);
$subject = HtmlSpecialchars($_POST['subject']);
$message = addslashes($_POST['message']);
$moderate_topic  = forums("MODERATE_TOPIC", $f);
$moderate_reply  = forums("MODERATE_REPLY", $f);

if(M_Style_Form){
if($type == "q_reply"){
$message_fix = addslashes(nl2br($_POST['message']));
}else{
$message_fix = addslashes($_POST['message']);
}
$message = '<div style="'.M_Style_Form.'">'.$message_fix.'</div>';
}

else{
if($type == "q_reply"){
$message = addslashes(nl2br($_POST['message']));
}else{
$message = addslashes($_POST['message']);
}
}

$txtPageProperties = $_POST['txtPageProperties'];
if($txtPageProperties){
$query_page = "UPDATE {$mysql->prefix}MEMBERS SET M_Style_Form = '$txtPageProperties' WHERE MEMBER_ID = '$DBMemberID' ";
$mysql->execute($query_page, $connection, [], __FILE__, __LINE__);
}

$ReplyAndLock = HtmlSpecialchars($_POST['ReplyAndLock']);
$ReplyAndUnLock = HtmlSpecialchars($_POST['ReplyAndUnLock']);
$date = time();


if($method == "topic" OR $method == "reply"){ 
$last_date = time() - 4; 
if($rs['M_LAST_POST_DATE'] >= $last_date){ 
go_to("index.php?mode=msg&err=21");
exit();
} 
} 


if($lock == 1){
    $lock = 0;
} else {
    $lock = 1;
}

if($sticky == 1){
    $sticky = 1;
} else {
    $sticky = 0;
}

if($hidden == 1){
    $hidden = 1;
} else {
    $hidden = 0;
}

if($method == "topic" OR $method == "edit"){
    if($message == ""){
    $error = $lang['post_info']['necessary_to_write_topic'];
    }

    if($subject == ""){
    $error = $lang['post_info']['necessary_to_write_title_topic'];
    }
}

if($method == "reply" OR $method == "editreply"){
    if($message == ""){
    $error = $lang['post_info']['necessary_to_write_reply'];
    }
}



if($error != ""){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>'.$lang['all']['error'].'<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
}

if($error == ""){
    if($method == "topic"){

		$chk_member_posts = chk_new_member_posts($DBMemberID);
		$mod_OneForum = mod_OneForum($DBMemberID, $f);
		$mod_AllForum = mod_AllForum($DBMemberID);

		if($mod_OneForum == 1 OR $mod_AllForum == 1 OR $chk_member_posts == 0 OR $moderate_topic  == 0  AND $Mlevel != 4){
		$topic_added_msg = $lang['post_info']['the_topic_is_added_but_it_require_moderation'];
		$t_unmoderated = "1";
		}
		else{
		$topic_added_msg = $lang['post_info']['the_topic_is_added'];
		$t_unmoderated = "0";
		}

	$topics = "INSERT INTO {$mysql->prefix}TOPICS (TOPIC_ID, FORUM_ID, CAT_ID, T_SUBJECT, T_MESSAGE, T_DATE, T_AUTHOR, T_STATUS, T_STICKY, T_HIDDEN, T_UNMODERATED, T_LAST_POST_DATE) VALUES (NULL, ";
	$topics .= " '$f', ";
	$topics .= " '$c', ";
	$topics .= " '$subject', ";
	$topics .= " '$message', ";
	$topics .= " '$date', ";
	$topics .= " '$DBMemberID', ";
	$topics .= " '$lock', ";
	$topics .= " '$sticky', ";
	$topics .= " '$hidden', ";
	$topics .= " '$t_unmoderated', ";
	$topics .= " '$date') ";
		$mysql->execute($topics, $connection, [], __FILE__, __LINE__);
                 
	$forum = "UPDATE {$mysql->prefix}FORUM SET ";
	$forum .= "F_TOPICS = F_TOPICS + 1, ";
	// $forum .= "F_REPLIES = F_REPLIES + 1, ";
	$forum .= "F_LAST_POST_DATE = '$date', ";
	$forum .= "F_LAST_POST_AUTHOR = '$DBMemberID' ";
	$forum .= "WHERE FORUM_ID = '$f' ";
		$mysql->execute($forum, $connection, [], __FILE__, __LINE__);
     
	$members = "UPDATE {$mysql->prefix}MEMBERS SET ";
	$members .= "M_POSTS = M_POSTS + 1, ";
	$members .= "M_LAST_POST_DATE = '$date' ";
	$members .= "WHERE MEMBER_ID = '$DBMemberID' ";
		$mysql->execute($members, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$topic_added_msg.'</font><br><br>
	                       <meta http-equiv="Refresh" content="1; URL='.$refer.'">
	                       <a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
                           <a href="'.$refer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
    if($method == "edit"){

if(mlv == 4){
$DBUserName = member_name(topics("AUTHOR", $t));
}

	$topics = "UPDATE {$mysql->prefix}TOPICS SET ";
	$topics .= "T_SUBJECT = '$subject', ";
	$topics .= "T_MESSAGE = '$message', ";
	$topics .= "T_STATUS = '$lock', ";
	$topics .= "T_STICKY = '$sticky', ";
	$topics .= "T_HIDDEN = '$hidden', ";
	$topics .= "T_LASTEDIT_MAKE = '$DBMemberID', ";
	$topics .= "T_LASTEDIT_DATE = '$date', ";
	$topics .= "T_ENUM = T_ENUM + 1 ";
	$topics .= "WHERE TOPIC_ID = '$t' ";
		$mysql->execute($topics, $connection, [], __FILE__, __LINE__);

	// TOPIC EDITS
	insert_new_topic_data($t, $subject, $message);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['post_info']['the_topic_is_update'].'</font><br><br>
	                       <meta http-equiv="Refresh" content="1; URL='.$refer.'">
                           <a href="index.php?mode=t&t='.$t.'">'.$lang['all']['click_here_to_go_topic'].'</a><br><br>
	                       <a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
                           <a href="'.$refer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
    if($method == "reply"){

	if(mon_OneForum($DBMemberID, $f) == 1){
		go_to("index.php?mode=msg&err=15&f=".$f);
		$error = 1;
	}
	else if(mon_AllForum($DBMemberID) == 1){
		go_to("index.php?mode=msg&err=16&f=".$f);
		$error = 1;
	}
	else if(topics("UNMODERATED", $t) == 1){
		go_to("index.php?mode=msg&err=18&f=".$f);
		$error = 1;
	}

	if($error != 1){
		$chk_member_posts = chk_new_member_posts($DBMemberID);
		$mod_OneForum = mod_OneForum($DBMemberID, $f);
		$mod_AllForum = mod_AllForum($DBMemberID);

		
		if($mod_OneForum == 1 OR $mod_AllForum == 1 OR $chk_member_posts == 0 OR $moderate_reply  == 0  AND $Mlevel != 4){
		$reply_added_msg = $lang['post_info']['the_reply_is_added_but_it_require_moderation'];
		$r_unmoderated = "1";
		}
		else{
		$reply_added_msg = $lang['post_info']['the_reply_is_added'];
		$r_unmoderated = "0";
		}

		$member_replies_today = member_replies_today($DBMemberID, $f);
		$f_total_replies = forums("TOTAL_REPLIES", $f);
		if($Mlevel == 1 AND $member_replies_today >= $f_total_replies OR $Mlevel == 2 AND $Moderator_all == 0 AND $member_replies_today >= $f_total_replies){
			go_to("index.php?mode=msg&err=14&f=".$f);
		}
		else{
			$reply = "INSERT INTO {$mysql->prefix}REPLY (REPLY_ID, TOPIC_ID, FORUM_ID, CAT_ID, R_MESSAGE, R_QUOTE, R_UNMODERATED, R_DATE, R_AUTHOR) VALUES (NULL, ";
			$reply .= " '$t', ";
			$reply .= " '$f', ";
			$reply .= " '$c', ";
			$reply .= " '$message', ";
			$reply .= " '$quote', ";
			$reply .= " '$r_unmoderated', ";
			$reply .= " '$date', ";
			$reply .= " '$DBMemberID') ";
				$mysql->execute($reply, $connection, [], __FILE__, __LINE__);

			$forum = "UPDATE {$mysql->prefix}FORUM SET ";
			$forum .= "F_REPLIES = F_REPLIES + 1, ";
			$forum .= "F_LAST_POST_DATE = '$date', ";
			$forum .= "F_LAST_POST_AUTHOR = '$DBMemberID' ";
			$forum .= "WHERE FORUM_ID = '$f' ";
				$mysql->execute($forum, $connection, [], __FILE__, __LINE__);

			$topics = "UPDATE {$mysql->prefix}TOPICS SET ";
			if($ReplyAndLock != ""){
				$topics .= "T_STATUS = '0', ";
			}
			if($ReplyAndUnLock != ""){
				$topics .= "T_STATUS = '1', ";
			}
			$topics .= "T_REPLIES = T_REPLIES + 1, ";
			$topics .= "T_LAST_POST_DATE = '$date', ";
			$topics .= "T_LAST_POST_AUTHOR = '$DBMemberID' ";
			$topics .= "WHERE TOPIC_ID = '$t' ";
				$mysql->execute($topics, $connection, [], __FILE__, __LINE__);

			$members = "UPDATE {$mysql->prefix}MEMBERS SET ";
			$members .= "M_POSTS = M_POSTS + 1, ";
			$members .= "M_LAST_POST_DATE = '$date' ";
			$members .= "WHERE MEMBER_ID = '$DBMemberID' ";
				$mysql->execute($members, $connection, [], __FILE__, __LINE__);

                                                      // ############ Close Thread after Some Reply #############

                                                      if($total_post_close_topic){
                                                      $mysql->execute("UPDATE {$mysql->prefix}TOPICS SET T_STATUS = ('0') WHERE T_REPLIES >=                                                                                               $total_post_close_topic  AND FORUM_ID = '$f' ");
                                                      }


			echo'
			<center>
			<table width="99%" border="1">
				<tr class="normal">
					<td class="list_center" colSpan="10"><font size="5"><br>'.$reply_added_msg.'</font><br><br>
					<a href="index.php?mode=t&t='.$t.'">'.$lang['all']['click_here_to_go_topic'].'</a><br><br>
					<a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>';
				if($type == "q_reply"){
					echo'
					<meta http-equiv="Refresh" content="1; URL='.referer.'">
					<a href="'.referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>';
				}
				else{
					echo'
					<meta http-equiv="Refresh" content="1; URL='.$refer.'">
					<a href="'.$refer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>';
				}
					echo'
					</td>
				</tr>
			</table>
			</center>';
		}
	}
    }
    if($method == "editreply"){

if(mlv == 4){
$DBUserName = member_name(topics("AUTHOR", $t));
}

	$reply = "UPDATE {$mysql->prefix}REPLY SET ";
	$reply .= "R_MESSAGE = '$message', ";
	$reply .= "R_LASTEDIT_MAKE = '$DBUserName', ";
	$reply .= "R_LASTEDIT_DATE = '$date', ";
	$reply .= "R_ENUM = R_ENUM + 1 ";
	$reply .= "WHERE REPLY_ID = '$r' ";
		$mysql->execute($reply, $connection, [], __FILE__, __LINE__);

	// REPLY EDITS
	insert_new_reply_data($r, $message);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['post_info']['the_reply_is_update'].'</font><br><br>
	                       <meta http-equiv="Refresh" content="1; URL='.$refer.'">
                           <a href="index.php?mode=t&t='.$t.'">'.$lang['all']['click_here_to_go_topic'].'</a><br><br>
	                       <a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
                           <a href="'.$refer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
    if($method == "sig"){

	$members = "UPDATE {$mysql->prefix}MEMBERS SET ";
	$members .= "M_SIG = '$message' ";
	$members .= "WHERE MEMBER_ID = '$DBMemberID' ";
		$mysql->execute($members, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['post_info']['the_sig_is_update'].'</font><br><br>
	                       <meta http-equiv="Refresh" content="1; URL=index.php?mode=profile&type=details">
                           <a href="index.php?mode=profile&id='.$DBMemberID.'">'.$lang['all']['click_here_to_go_yours_details'].'</a><br><br>
	                       <a href="index.php?mode=profile&type=details">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
    
    if($method == "replymsg"){
     if($m != ""){
       $DBMemberID = $m;
     }

use_pm();

	$sendPm = "INSERT INTO {$mysql->prefix}PM (PM_ID, PM_MID, PM_TO, PM_FROM, PM_OUT, PM_REPLY, PM_SUBJECT, PM_MESSAGE, PM_DATE) VALUES (NULL, ";
	$sendPm .= " '$DBMemberID', ";
	$sendPm .= " '$pm_to', ";
	$sendPm .= " '$DBMemberID', ";
	$sendPm .= " '1', ";
	if($msg != ""){
	$sendPm .= " '1', ";
	}
	else {
	$sendPm .= " '0', ";
	}
	$sendPm .= " '$subject', ";
	$sendPm .= " '$message', ";
	$sendPm .= " '$date') ";
		$mysql->execute($sendPm, $connection, [], __FILE__, __LINE__);

	$storePm = "INSERT INTO {$mysql->prefix}PM (PM_ID, PM_MID, PM_TO, PM_FROM, PM_REPLY, PM_SUBJECT, PM_MESSAGE, PM_DATE) VALUES (NULL, ";
	$storePm .= " '$pm_to', ";
	$storePm .= " '$pm_to', ";
	$storePm .= " '$DBMemberID', ";
	$storePm .= " '1', ";
	$storePm .= " '$subject', ";
	$storePm .= " '$message', ";
	$storePm .= " '$date') ";
		$mysql->execute($storePm, $connection, [], __FILE__, __LINE__);
     
	if($msg != ""){
	$pmReply = "UPDATE {$mysql->prefix}PM SET ";
	$pmReply .= "PM_REPLY = '2' ";
	$pmReply .= "WHERE PM_ID = '$msg' ";
		$mysql->execute($pmReply, $connection, [], __FILE__, __LINE__);
	}

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['post_info']['the_pm_is_replied'].'</font><br><br>';
	                    if($type == "q_reply"){
                           $go_to_normal_page = '<meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">';
                           $go_to_normal_page .= '<a href="'.$HTTP_REFERER.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>';
	                    }
						if($type == ""){
                           $go_to_normal_page = '<meta http-equiv="Refresh" content="1; URL='.$refer.'">';
                           $go_to_normal_page .= '<a href="'.$refer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>';
						}   
	                       echo'
                           '.$go_to_normal_page.'
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
    if($method == "sendmsg"){
use_pm();
	$sendPm = "INSERT INTO {$mysql->prefix}PM (PM_ID, PM_MID, PM_TO, PM_FROM, PM_OUT, PM_SUBJECT, PM_MESSAGE, PM_DATE) VALUES (NULL, ";
	$sendPm .= " '$pm_from', ";
	$sendPm .= " '$pm_to', ";
	$sendPm .= " '$pm_from', ";
	$sendPm .= " '1', ";
	$sendPm .= " '$subject', ";
	$sendPm .= " '$message', ";
	$sendPm .= " '$date') ";
		$mysql->execute($sendPm, $connection, [], __FILE__, __LINE__);

	$storePm = "INSERT INTO {$mysql->prefix}PM (PM_ID, PM_MID, PM_TO, PM_FROM, PM_SUBJECT, PM_MESSAGE, PM_DATE) VALUES (NULL, ";
	$storePm .= " '$pm_to', ";
	$storePm .= " '$pm_to', ";
	$storePm .= " '$pm_from', ";
	$storePm .= " '$subject', ";
	$storePm .= " '$message', ";
	$storePm .= " '$date') ";
		$mysql->execute($storePm, $connection, [], __FILE__, __LINE__);
     
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['post_info']['the_pm_is_send'].'</font><br><br>
	                       <meta http-equiv="Refresh" content="1; URL='.$refer.'">
	                       <a href="'.$refer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
}

?>