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
$date = time();

if($type == "c"){
    if($Mlevel == 4){
		$query = "DELETE FROM {$mysql->prefix}CATEGORY WHERE CAT_ID = '$c' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
  
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['delete']['the_cat_is_deleted'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=index.php">
                           <a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
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
		$query = "DELETE FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['delete']['the_forum_is_deleted'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=index.php">
                           <a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
    else {
    redirect();
    }
}
elseif($type == "m"){
    if($Mlevel == 4){
if(members("LEVEL", $m) == 4){
redirect();
exit();
}
if(members("THE_ID", $m) == 1 ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[lock][member_is_admin].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}

		$query = "DELETE FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$m' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['delete']['the_member_is_deleted'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
                           <a href="index.php?mode=members">'.$lang['all']['click_here_to_go_member_page'].'</a><br><br>
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
elseif($type == "del_mod"){
    if($Mlevel == 4){
		$query = "DELETE FROM {$mysql->prefix}MODERATOR WHERE MOD_ID = '$m' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
  
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['delete']['the_mod_is_deleted'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
                           <a href="index.php?mode=add_cat_forum&method=edit&type=f&f='.$f.'">'.$lang['all']['click_here_to_go_moderator_list'].'</a><br><br>
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
elseif($type == "del_mem"){
    if($Mlevel == 4){
		$mysql->execute("DELETE FROM {$mysql->prefix}HIDE_FORUM WHERE HF_ID = '$m' ", [], __FILE__, __LINE__);
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم حذف العضو من اللائحة بنجاح</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
                           <a href="index.php?mode=add_cat_forum&method=edit&type=f&f='.$f.'">-- إنقر هنا للذهاب الى لائحة أعضاء مسموحين --</a><br><br>
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
    if(allowed($f, 2) == 1){
	if(allowed($f, 1) == 1){
		$query = "DELETE FROM {$mysql->prefix}TOPICS WHERE TOPIC_ID = '$t' ";
	}
	else {
		$query = "UPDATE {$mysql->prefix}TOPICS SET T_STATUS = '2', T_DELETED_BY = '$DBMemberID', T_DELETED_DATE = '$date' WHERE TOPIC_ID = '$t' ";
	}
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
  
	$query2 = "UPDATE {$mysql->prefix}FORUM SET ";
	$query2 .= "F_TOPICS = F_TOPICS - 1, ";
	$query2 .= "F_REPLIES = F_REPLIES - 1 ";
	$query2 .= "WHERE FORUM_ID = '$f.' ";
	$mysql->execute($query2, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['delete']['the_topic_is_deleted'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=index.php?mode=f&f='.$f.'">
                           <a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_go_forum'].'</a><br><br>
                           <a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
    else {
    redirect();
    }
}
elseif($type == "monitored"){
    if($Mlevel > 0){
		$query = "DELETE FROM {$mysql->prefix}FAVOURITE_TOPICS WHERE F_TOPICID = '$t' AND F_MEMBERID = '$DBMemberID' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font color="red" size="5"><br>تم ازالة الموضوع من قائمة مواضيعك المفضلة.</font><br><br>
                           <a href="index.php?mode=active&active=monitored">-- إضغط هنا للرجوع الى الصفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
    else {
    redirect();
    }
}
elseif($type == "r"){
	$author = replies("AUTHOR", $r);
	$hidden = replies("HIDDEN", $r);
    if(allowed($f, 2) == 1 OR $hidden != 1 AND $DBMemberID == $author){
	if(allowed($f, 1) == 1){
		$query = "DELETE FROM {$mysql->prefix}REPLY WHERE REPLY_ID = '$r' ";
	}
	else {
		$query = "UPDATE {$mysql->prefix}REPLY SET R_STATUS = '2', R_DELETED_BY = '$DBMemberID', R_DELETED_DATE = '$date' WHERE REPLY_ID = '$r' ";
	}
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	$query2 = "UPDATE {$mysql->prefix}FORUM SET ";
	$query2 .= "F_REPLIES = F_REPLIES - 1 ";
	$query2 .= "WHERE FORUM_ID = '$f' ";     
	$mysql->execute($query2, $connection, [], __FILE__, __LINE__);
     
	$query3 = "UPDATE {$mysql->prefix}TOPICS SET ";
	$query3 .= "T_REPLIES = T_REPLIES - 1 ";
	$query3 .= "WHERE TOPIC_ID = '$t' ";
	$mysql->execute($query3, $connection, [], __FILE__, __LINE__);

	$query4 = "UPDATE {$mysql->prefix}MEMBERS SET ";
	$query4 .= "M_POSTS = M_POSTS - 1 ";
	$query4 .= "WHERE MEMBER_ID = '$DBMemberID' ";
	$mysql->execute($query4, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['delete']['the_reply_is_deleted'].'</font><br><br>
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

 $remove = $_POST['remove'];
 
 $delete = $_POST['delete'];
 
 $PM = $mysql->execute("SELECT * FROM {$mysql->prefix}PM WHERE PM_ID = '$msg' ", [], __FILE__, __LINE__);

 if(mysql_num_rows($PM) > 0){

 $rs_PM = mysql_fetch_array($PM);

 $PM_PmID = $rs_PM['PM_ID'];
 $PM_MID = $rs_PM['PM_MID'];
 }
    if($$DBMemberID == $PM_MID ){
        if($method == ""){

        $query = "UPDATE {$mysql->prefix}PM SET ";
        $query .= "PM_STATUS = 0 ";
        $query .= "WHERE PM_ID = '$msg' ";

        $mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['delete']['the_pm_is_moved'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
                           <a href="'.$HTTP_REFERER.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
        }
        if($method == "remove"){
             if($remove == ""){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>'.$lang['all']['error'].'<br>'.$lang['delete']['you_are_non_selected_any_pm'].'</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
            }
            else {

            $i_pm = 0;
            while($i_pm  < count($remove)){

                $mysql->execute("UPDATE {$mysql->prefix}PM SET PM_STATUS = '0' WHERE PM_ID = ".$remove[$i_pm]." ", [], __FILE__, __LINE__);
                $i_pm++;

            }

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['delete']['the_pm_is_moved'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
                           <a href="'.$HTTP_REFERER.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
            }
        }
        if($method == "delete"){
             if($delete == ""){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>'.$lang['all']['error'].'<br>'.$lang['delete']['you_are_non_selected_any_pm'].'</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
            }
            else {

            $i_pm = 0;
            while($i_pm  < count($delete)){

                $mysql->execute("DELETE FROM {$mysql->prefix}PM WHERE PM_ID = ".$delete[$i_pm]." ", [], __FILE__, __LINE__);
                $i_pm++;

            }

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['delete']['the_pm_is_normal_deleted'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">
                           <a href="'.$HTTP_REFERER.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
            }
        }
    }
    else{
    redirect();
    }
}
else {
redirect();
}


mysql_close();
?>
