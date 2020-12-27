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

if($type == "c"){
    if($Mlevel == 4){
		$query = "UPDATE {$mysql->prefix}CATEGORY SET CAT_STATUS = ('1') WHERE CAT_ID = '$c' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['open']['the_cat_is_opened'].'</font><br><br>
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
		$query = "UPDATE {$mysql->prefix}FORUM SET F_STATUS = ('1') WHERE FORUM_ID = '$f' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['open']['the_forum_is_opened'].'</font><br><br>
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
		$query = "UPDATE {$mysql->prefix}TOPICS SET T_STATUS = ('1'), T_OPEN_MAKE = ('$DBMemberID'), T_OPEN_DATE = ('$date') WHERE TOPIC_ID = '$t' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['open']['the_topic_is_opened'].'</font><br><br>
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
elseif($type == "tt"){
    if($Mlevel == 4 OR $Monitor == 1){
		$query = "UPDATE {$mysql->prefix}TOPICS SET T_STATUS = ('1') WHERE TOPIC_ID = '$t' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['topics']['return_topic_has_been'].'</font><br><br>
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
		$query = "UPDATE {$mysql->prefix}TOPICS SET T_STICKY = ('0') , T_UNSTICKY_BY = ('$DBMemberID'), T_UNSTICKY_DATE = ('$date')  WHERE TOPIC_ID = '$t' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['open']['the_topic_is_unsticky'].'</font><br><br>
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
    if($Mlevel == 4 OR $Monitor == 1 OR $Moderator == 1){
		$query = "UPDATE {$mysql->prefix}TOPICS SET T_HIDDEN = ('0'), T_UNHIDDEN_BY = ('$DBMemberID'), T_UNHIDDEN_DATE = ('$date') WHERE TOPIC_ID = '$t' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
		hideTopic_info($DBMemberID, $t, "OPEN");

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['open']['the_topic_is_unhide'].'</font><br><br>
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
elseif($type == "ar"){
    if($Mlevel == 4){
		$query = "UPDATE {$mysql->prefix}TOPICS SET T_ARCHIVED= ('1') WHERE TOPIC_ID = '$t' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
		hideTopic_info($DBMemberID, $t, "OPEN");

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['open']['the_topic_is_archived'].'</font><br><br>
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
elseif($type == "uar"){
    if($Mlevel == 4){
		$query = "UPDATE {$mysql->prefix}TOPICS SET T_ARCHIVED= ('0') WHERE TOPIC_ID = '$t' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
		hideTopic_info($DBMemberID, $t, "OPEN");

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['open']['the_topic_is_unarchived'].'</font><br><br>
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
    if($Mlevel == 4 OR $Monitor == 1 OR $Moderator == 1){
		$query = "UPDATE {$mysql->prefix}REPLY SET R_HIDDEN = '0', R_HIDDEN_BY = '0' WHERE REPLY_ID = '$r' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
		hideReply_info($DBMemberID, $r, "OPEN");

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['open']['the_reply_is_unhide'].'</font><br><br>
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
} elseif($type == "rr"){
    if($Mlevel == 4 OR $Monitor == 1 OR $Moderator == 1){
		$query = "UPDATE {$mysql->prefix}REPLY SET R_STATUS = '1' WHERE REPLY_ID = '$r' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['topics']['return_reply_has_been'].'</font><br><br>
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
elseif($type == "pm"){

 $PM = $mysql->execute("SELECT * FROM {$mysql->prefix}PM WHERE PM_ID = '$msg' ", [], __FILE__, __LINE__);

 if(mysql_num_rows($PM) > 0){

 $rs_PM = mysql_fetch_array($PM);

 $PM_PmID = $rs_PM['PM_ID'];
 $PM_MID = $rs_PM['PM_MID'];
 }
    if($Mlevel == 4 OR $DBMemberID == $PM_MID){

        $query = "UPDATE {$mysql->prefix}PM SET ";
        $query .= "PM_STATUS = 1 ";
        $query .= "WHERE PM_ID = '$msg' ";

        $mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['open']['the_pm_is_moved'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
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
