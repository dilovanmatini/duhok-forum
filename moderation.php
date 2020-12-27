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
$date = time();

if($type == "th"){
	$f = topics("FORUM_ID", $t);
	if(allowed($f, 2) == 1){
		$query = "UPDATE {$mysql->prefix}TOPICS SET ";
		$query .= "T_UNMODERATED = '0', T_HOLDED = '1', ";
		$query .= "T_HOLDED_BY = '$DBMemberID',T_HOLDED_DATE = '$date' ";
		$query .= "WHERE TOPIC_ID = '$t' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
  
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تجميد الموضوع بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL='.$HTTP_REFERER.'">
                           <a href="index.php?mode=t&t='.$t.'">'.$lang['all']['click_here_to_go_topic'].'</a><br><br>
                           <a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
                           <a href="'.$HTTP_REFERER.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
	}
	else {
	redirect();
	}
}
if($type == "rh"){
	$f = replies("FORUM_ID", $r);
	if(allowed($f, 2) == 1){
		$query = "UPDATE {$mysql->prefix}REPLY SET ";
		$query .= "R_UNMODERATED = '0', R_HOLDED = '1', ";
		$query .= "R_HOLDED_BY = '$DBMemberID', R_HOLDED_DATE = '$date' ";
		$query .= "WHERE REPLY_ID = '$r' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
  
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تجميد الرد بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL='.$HTTP_REFERER.'">
                           <a href="index.php?mode=t&t='.$t.'">'.$lang['all']['click_here_to_go_topic'].'</a><br><br>
                           <a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
                           <a href="'.$HTTP_REFERER.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
	}
	else {
	redirect();
	}
}

if($type == "t"){
	$f = topics("FORUM_ID", $t);
	if(allowed($f, 2) == 1){
		$query = "UPDATE {$mysql->prefix}TOPICS SET ";
		$query .= "T_UNMODERATED = '0', T_HOLDED = '0', ";
		$query .= "T_MODERATED_BY = '$DBMemberID',T_MODERATED_DATE = '$date' ";
		$query .= "WHERE TOPIC_ID = '$t' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
  
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تمت الموافقة على الموضوع بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL='.$HTTP_REFERER.'">
                           <a href="index.php?mode=t&t='.$t.'">'.$lang['all']['click_here_to_go_topic'].'</a><br><br>
                           <a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
                           <a href="'.$HTTP_REFERER.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
	}
	else {
	redirect();
	}
}

if($type == "r"){
	$f = replies("FORUM_ID", $r);
	if(allowed($f, 2) == 1){
		$query = "UPDATE {$mysql->prefix}REPLY SET ";
		$query .= "R_UNMODERATED = '0', R_HOLDED = '0', ";
		$query .= "R_MODERATED_BY = '$DBMemberID', R_MODERATED_DATE = '$date' ";
		$query .= "WHERE REPLY_ID = '$r' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
  
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تمت الموافقة على الرد بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL='.$HTTP_REFERER.'">
                           <a href="index.php?mode=t&t='.$t.'">'.$lang['all']['click_here_to_go_topic'].'</a><br><br>
                           <a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
                           <a href="'.$HTTP_REFERER.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
	}
	else {
	redirect();
	}
}

if($type == "topics_tools"){
$topic_id = $_POST[topic_id];
$subApprove = $_POST[subApprove];
$subHold = $_POST[subHold];
$subDelete = $_POST[subDelete];
    if(allowed($f, 2) == 1){
		if($subApprove != ""){
			$update = "T_UNMODERATED = ('0'), T_MODERATED_BY = ('$DBMemberID'), T_MODERATED_DATE = ('$date'), T_HOLDED = ('0'), T_STATUS = ('1') ";
			$text = "تمت الموافقة على المواضيع المختارة بنجاح..";
		}
		if($subHold != ""){
			$update = "T_HOLDED = ('1'), T_HOLDED_BY = ('$DBMemberID'), T_HOLDED_DATE = ('$date'), T_UNMODERATED = ('0'), T_STATUS = ('1') ";
			$text = "تم تجميد المواضيع المختارة بنجاح..";
		}
		if($subHidden != ""){
			$update = "T_HIDDEN = ('0'), T_HIDDEN_BY = ('0'), T_HOLDED_DATE = ('$date'), T_HOLDED = ('0'), T_UNMODERATED = ('0'), T_STATUS = ('1') ";
			$text = "تم اظهار المواضيع المختارة بنجاح..";
		}
		if($subDelete != ""){
			$update = "T_STATUS = ('2'), T_DELETED_BY = ('$DBMemberID'), T_DELETED_DATE = ('$date'), T_UNMODERATED = ('0'), T_HOLDED = ('0') ";
			$text = "تم حذف المواضيع المختارة بنجاح..";
		}
			$x = 0;
			while($x < count($topic_id)){
				$query = "UPDATE {$mysql->prefix}TOPICS SET ";
				$query .= $update;
				$query .= "WHERE TOPIC_ID = '$topic_id[$x]' ";
				$mysql->execute($query, $connection, [], __FILE__, __LINE__);
			    if($subHidden != ""){
				hideTopic_info($DBMemberID, $topic_id[$x], "OPEN");
			    }
			++$x;
			}
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$text.'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
                           <a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
                           <a href="'.$HTTP_REFERER.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
    else {
    redirect();
    }
}

if($type == "replies_tools"){
$reply_id = $_POST[reply_id];
$subApprove = $_POST[subApprove];
$subHold = $_POST[subHold];
$subDelete = $_POST[subDelete];
    if(allowed($f, 2) == 1){
		if($subApprove != ""){
			$update = "R_UNMODERATED = ('0'), R_MODERATED_BY = ('$DBMemberID'), R_MODERATED_DATE = ('$date'), R_HOLDED = ('0'), R_STATUS = ('1') ";
			$text = "تمت الموافقة على الردود المختارة بنجاح..";
		}
		if($subHold != ""){
			$update = "R_HOLDED = ('1'), R_HOLDED_BY = ('$DBMemberID'), R_HOLDED_DATE = ('$date'), R_UNMODERATED = ('0'), R_STATUS = ('1') ";
			$text = "تم تجميد الردود المختارة بنجاح..";
		}
		if($subHidden != ""){
			$update = "R_HIDDEN = ('0'), R_HIDDEN_BY = ('0'), R_HIDDEN_DATE = ('$date'), R_HOLDED = ('0'), R_UNMODERATED = ('0'), R_STATUS = ('1') ";
			$text = "تم اظهار الردود المختارة بنجاح..";
		}
		if($subDelete != ""){
			$update = "R_STATUS = ('2'), R_DELETED_BY = ('$DBMemberID'), R_DELETED_DATE = ('$date'), R_UNMODERATED = ('0'), R_HOLDED = ('0') ";
			$text = "تم حذف المواضيع المختارة بنجاح..";
		}
			$x = 0;
			while($x < count($reply_id)){
				$query = "UPDATE {$mysql->prefix}REPLY SET ";
				$query .= $update;
				$query .= "WHERE REPLY_ID = '$reply_id[$x]' ";
				$mysql->execute($query, $connection, [], __FILE__, __LINE__);
			    if($subHidden != ""){
				hideReply_info($DBMemberID, $reply_id[$x], "OPEN");
			    }
			++$x;
			}
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$text.'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
                           <a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
                           <a href="'.$HTTP_REFERER.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
    else {
    redirect();
    }
}

if($type == "tools_left"){
$check = $_POST['check'];

    if(allowed($f, 2) == 1){

		if($method == "hidden"){
			$update = "T_HIDDEN = ('1'), T_HIDDEN_BY = ('$DBMemberID'), T_HIDDEN_DATE = ('$date')";
			$text = "تمت اخفاء المواضيع المختارة بنجاح..";
		}


		if($method == "unhidden"){
			$update = "T_HIDDEN = ('0'), T_HIDDEN_BY = ('0')";
			$text = "تمت اظهار المواضيع المختارة بنجاح..";
		}

		if($method == "lock"){
			$update = "T_STATUS = ('0'), T_LOCK_MAKE = ('$DBUserName'), T_LOCK_DATE = ('$date')";
			$text = "تم قفل المواضيع المختارة بنجاح..";
		}

		if($method == "unlock"){
			$update = "T_STATUS = ('1'), T_OPEN_MAKE = ('$DBUserName'), T_OPEN_DATE = ('$date')";
			$text = "تم فتح المواضيع المختارة بنجاح..";
		}

		if($method == "del"){
			$update = "T_STATUS = '2', T_DELETED_BY = '$DBMemberID', T_DELETED_DATE = '$date' ";		
			$text = "تم حدف المواضيع المختارة بنجاح..";
		}
	
			$x = 0;
			while($x < count($check)){
				$query = "UPDATE {$mysql->prefix}TOPICS SET ";
				$query .= $update;
				$query .= "WHERE TOPIC_ID= '$check[$x]' ";
				$mysql->execute($query, $connection, [], __FILE__, __LINE__);
			    if($method == "unhidden"){
				hideReply_info($DBMemberID, $check[$x], "OPEN");
			    }
			    if($method == "hidden"){
				hideReply_info($DBMemberID, $check[$x], "HIDE");
			    }
			++$x;
			}
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$text.'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
                           <a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
                           <a href="'.$HTTP_REFERER.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
    else {
    redirect();
    }
}

mysql_close();
?>
