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
$Monitor = chk_monitor($DBMemberID, $c);
$Moderator = chk_moderator($DBMemberID, $f);
$date = time();
 
if($type == "c"){
    if($Mlevel == 4){
		$query = "UPDATE {$mysql->prefix}CATEGORY SET CAT_STATUS = ('0') WHERE CAT_ID = '$c' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['lock']['the_cat_is_locked'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
                           <a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
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
elseif($type == "f"){
    if($Mlevel == 4){
		$query = "UPDATE {$mysql->prefix}FORUM SET F_STATUS = ('0') WHERE FORUM_ID = '$f' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['lock']['the_forum_is_locked'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
                           <a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
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
elseif($type == "t"){
    if($Mlevel == 4 OR $Monitor == 1 OR $Moderator == 1){
		$query = "UPDATE {$mysql->prefix}TOPICS SET T_STATUS = ('0'), T_LOCK_MAKE = ('$DBMemberID'), T_LOCK_DATE = ('$date') WHERE TOPIC_ID = '$t' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
  
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['lock']['the_topic_is_locked'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
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
elseif($type == "s"){
    if($Mlevel == 4 OR $Monitor == 1 OR $Moderator == 1){
		$query = "UPDATE {$mysql->prefix}TOPICS SET T_STICKY = ('1')  , T_STICKY_BY = ('$DBMemberID'), T_STICKY_DATE = ('$date') WHERE TOPIC_ID = '$t' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['lock']['the_topic_is_sticky'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
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
elseif($type == "h"){
    if($Mlevel > 1){
		$query = "UPDATE {$mysql->prefix}TOPICS SET T_HIDDEN = ('1'), T_HIDDEN_BY = ('$DBMemberID'), T_HIDDEN_DATE = ('$date') WHERE TOPIC_ID = '$t' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
		hideTopic_info($DBMemberID, $t, "HIDE");

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['lock']['the_topic_is_hide'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
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
elseif($type == "hr"){
    if($Mlevel > 1){
		$query = "UPDATE {$mysql->prefix}REPLY SET R_HIDDEN = '1', R_HIDDEN_BY = '$DBMemberID', R_HIDDEN_DATE = '$date' WHERE REPLY_ID = '$r' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
		hideReply_info($DBMemberID, $r, "HIDE");

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['lock']['the_reply_is_hide'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
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

elseif($type == "check"){
$ps = $_POST['check'];
$f = $_POST['hidden_f'];
$t = $_POST['hidden_t'];
$c = $_POST['hidden_c'];

$Monitor = chk_monitor($DBMemberID, $c);
$Moderator = chk_moderator($DBMemberID, $f);

if($Mlevel == 4 OR $Monitor == 1 OR $Moderator == 1){

if($_POST['typehiddel'] == "hidden"){
$msg = "تم اخفاء الردود المختارة";
foreach ($ps as $value){
$query = "UPDATE {$mysql->prefix}REPLY SET R_HIDDEN = '1', R_HIDDEN_BY = '$DBMemberID', R_HIDDEN_DATE = '$date' WHERE REPLY_ID = '$value' ";
$mysql->execute($query, $connection, [], __FILE__, __LINE__);
hideReply_info($DBMemberID, $r, "HIDE");
}
}

if($_POST['typehiddel'] == "delete"){
$msg = "تم حدف الردود المختارة";
foreach ($ps as $value){
$query = "UPDATE {$mysql->prefix}REPLY SET R_STATUS = '2', R_DELETED_BY = '$DBMemberID', R_DELETED_DATE = '$date' WHERE REPLY_ID = '$value' ";
$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	$query2 = "UPDATE {$mysql->prefix}FORUM SET ";
	$query2 .= "F_REPLIES = F_REPLIES - 1 ";
	$query2 .= "WHERE FORUM_ID = '$f' ";     
	$mysql->execute($query2, $connection, [], __FILE__, __LINE__);
     
	$query3 = "UPDATE {$mysql->prefix}TOPICS SET ";
	$query3 .= "T_REPLIES = T_REPLIES - 1 ";
	$query3 .= "WHERE TOPIC_ID = '$t' ";
	$mysql->execute($query3, $connection, [], __FILE__, __LINE__);

}
}



	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$msg.'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
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
else {
redirect();
}

mysql_close();
?>
