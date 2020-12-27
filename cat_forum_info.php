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

if($Mlevel == 4){

$add_subject = $_POST["add_subject"];
$MonitorID = $_POST["mon_memberid"];
$ModeratorID = $_POST["mod_memberid"];
$forum_logo = $_POST["forum_logo"];
$forum_sex = $_POST["f_sex"];
$forum_desc = $_POST["forum_desc"];
$total_topics = intval($_POST["total_topics"]);
$total_replies = intval($_POST["total_replies"]);
$f_hide = $_POST["f_hide"];
$hide_mod = $_POST["hide_mod"];
$hide_photo = intval($_POST["hide_photo"]);
$day_archive = intval($_POST["day_archive"]);
$active_archive = intval($_POST["active_archive"]);
$hide_sig = intval($_POST["hide_sig"]);
$cat_hide = $_POST["cat_hide"];
$hf_member_id = $_POST["hf_member_id"];
$method = $_POST["method"];
$type = $_POST["type"];
$c = $_POST["cat_id"];
$f = $_POST["forum_id"];
$cat_level = $_POST["cat_level"];
$f_level = $_POST["f_level"];
$cat_site = $_POST["site_id"];


$cat_index = $_POST["cat_index"];
$cat_info = $_POST["cat_info"];
$cat_profile = $_POST["cat_profile"];


$moderate_topic = intval($_POST["moderate_topic"]);
$moderate_reply  = intval($_POST["moderate_reply"]);
$show_index  = intval($_POST["show_index"]);
$show_frm  = intval($_POST["show_frm"]);
$show_info  = intval($_POST["show_info"]);
$show_profile = $_POST["show_profile"];



if($forum_desc == ""){
	if($type == "f"){
	$error = $lang['cat_forum_info']['necessary_to_write_one_line_about_forum'];
 	}
}

if($ModeratorID != ""){
 $queryMod = "SELECT * FROM {$mysql->prefix}MODERATOR WHERE MEMBER_ID = '$ModeratorID' AND FORUM_ID = '$f' ";
 $resultMod = $mysql->execute($queryMod, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($resultMod) > 0){

 $rsMod=mysql_fetch_array($resultMod);

 $MODMemberID = $rsMod['MEMBER_ID'];
 }
	if($MODMemberID == $ModeratorID){
	$error = $lang['cat_forum_info']['can_not_add_mod_because_this_member_was_mod'];
 	}
}

if($ModeratorID != ""){
 $queryMem = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$ModeratorID' ";
 $resultMem = $mysql->execute($queryMem, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($resultMem) > 0){

 $rsMem=mysql_fetch_array($resultMem);

 $MEMMemberID = $rsMem['MEMBER_ID'];
 }
	if($MEMMemberID == ""){
	$error = $lang['cat_forum_info']['the_number_of_inserted_is_false'];
 	}
}

if($hf_member_id != ""){
	$hf_check_mem = $mysql->execute("SELECT * FROM {$mysql->prefix}HIDE_FORUM WHERE HF_MEMBER_ID = '$hf_member_id' AND HF_FORUM_ID = '$f' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($hf_check_mem) > 0){
		$error = "هذا العضو موجود بلائحة أعضاء مسموحين لهذا المنتدى";
	}
	
	$hf_check_num = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$hf_member_id' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($hf_check_num) <= 0){
		$error = $lang['cat_forum_info']['the_number_of_inserted_is_false'];
	}
}

if($ModeratorID != ""){
  if(doubleval($ModeratorID) == 0){
	if($type == "f"){
	$error = $lang['cat_forum_info']['necessary_to_insert_just_number'];
 	}
  }
}

if($forum_logo == ""){
	if($type == "f"){
	$error = $lang['cat_forum_info']['necessary_to_insert_logo_of_forum'];
 	}
}

if($add_subject == ""){
	if($type == "c"){
	$error = $lang['cat_forum_info']['necessary_to_insert_title_of_cat'];
	}
	if($type == "f"){
	$error = $lang['cat_forum_info']['necessary_to_insert_title_of_forum'];
 	}
}


if($type == ""){
redirect();
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
	                </center>';
}

if($error == ""){

	if($type == "c"){
        if($method == "add"){
		$query = "INSERT INTO {$mysql->prefix}CATEGORY (CAT_ID, CAT_NAME, CAT_MONITOR, CAT_HIDE, CAT_LEVEL, SITE_ID , SHOW_INDEX , SHOW_INFO , SHOW_PROFILE ) VALUES (NULL, '$add_subject', '$MonitorID', '$cat_hide', '$cat_level', '$cat_site', '$cat_index', '$cat_info', '$cat_profile')";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
        $text = $lang['cat_forum_info']['the_cat_was_added'];
        }
        
        if($method == "edit"){
		$query = "UPDATE {$mysql->prefix}CATEGORY SET CAT_NAME = '$add_subject', CAT_MONITOR = '$MonitorID', CAT_HIDE = '$cat_hide', CAT_LEVEL = '$cat_level', SHOW_INDEX = '$cat_index', SHOW_INFO = '$cat_info', SHOW_PROFILE = '$cat_profile', SITE_ID = '$cat_site' WHERE CAT_ID = '$c' ";

		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
        $text = $lang['cat_forum_info']['the_cat_was_update'];
        }
	}

	if($type == "f"){
	$c = $_POST["cat_choose"];
        if($method == "add"){
		$query = "INSERT INTO {$mysql->prefix}FORUM (FORUM_ID, CAT_ID, F_SUBJECT, F_DESCRIPTION, F_LOGO, F_SEX, F_LAST_POST_AUTHOR, F_TOTAL_TOPICS, F_TOTAL_REPLIES, F_HIDE, F_HIDE_MOD, F_HIDE_PHOTO, F_HIDE_SIG, CAN_ARCHIVE, MODERATE_TOPIC,  MODERATE_REPLY,  SHOW_INDEX ,SHOW_FRM ,SHOW_INFO , SHOW_PROFILE , DAY_ARCHIVE, F_LEVEL ) VALUES (NULL, '$c', '$add_subject', '$forum_desc', '$forum_logo', '$forum_sex', '1', '$total_topics', '$total_replies', '$f_hide', '$hide_mod', $hide_photo, $hide_sig,$active_archive
		,$moderate_topic,$moderate_reply,$show_index,$show_frm,show_info,show_profile
		,$day_archive,$f_level)";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
  
        $add_mod = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM ORDER BY FORUM_ID DESC", [], __FILE__, __LINE__);
        if(mysql_num_rows($add_mod) > 0){
        $rs = mysql_fetch_array($add_mod);
        }

        if($ModeratorID != ""){
        $query = "INSERT INTO {$mysql->prefix}MODERATOR (MOD_ID, FORUM_ID, MEMBER_ID) VALUES (NULL, '$rs[FORUM_ID]', '$ModeratorID')";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
        }
        
		$text = $lang['cat_forum_info']['the_forum_was_added'];
        }
        if($method == "edit"){
		$query = "UPDATE {$mysql->prefix}FORUM SET CAT_ID = ('$c'), F_SUBJECT = ('$add_subject'), F_DESCRIPTION = ('$forum_desc'), F_LOGO = ('$forum_logo'), F_SEX = ('$forum_sex'), F_TOTAL_TOPICS = ('$total_topics'), F_TOTAL_REPLIES = ('$total_replies'), F_HIDE = ('$f_hide'), F_HIDE_MOD = ('$hide_mod'), F_HIDE_PHOTO = ('$hide_photo'), F_HIDE_SIG = ('$hide_sig'), CAN_ARCHIVE  = ('$active_archive'),
		 MODERATE_TOPIC  = ('$moderate_topic'), MODERATE_REPLY = ('$moderate_reply'),	SHOW_INDEX  = ('$show_index'),SHOW_FRM  = ('$show_frm'),SHOW_INFO  = ('$show_info'),SHOW_PROFILE  = ('$show_profile'), DAY_ARCHIVE = ('$day_archive'), F_LEVEL = ('$f_level') WHERE FORUM_ID = '$f' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

        $query = "UPDATE {$mysql->prefix}HIDE_FORUM SET HF_CAT_ID = ('$c') WHERE HF_FORUM_ID = '$f'";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);




        $query = "UPDATE {$mysql->prefix}REPLY SET CAT_ID = ('$c') WHERE FORUM_ID = '$f'";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

        $query = "UPDATE {$mysql->prefix}TOPICS SET CAT_ID = ('$c') WHERE FORUM_ID = '$f'";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);// <i></i>
  
        if($ModeratorID != ""){
        $query = "INSERT INTO {$mysql->prefix}MODERATOR (MOD_ID, FORUM_ID, MEMBER_ID) VALUES (NULL, '$f', '$ModeratorID')";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
        }
		
        if($hf_member_id != ""){
			$mysql->execute("INSERT INTO {$mysql->prefix}HIDE_FORUM (HF_ID, HF_MEMBER_ID, HF_FORUM_ID, HF_CAT_ID) VALUES (NULL, '$hf_member_id', '$f', '$to_hide_cat')", [], __FILE__, __LINE__);
        }
  
        $text = $lang['cat_forum_info']['the_forum_was_update'];
        }
  
	}

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$text.'..</font><br><br>';
                           if($method == "edit"){
                           echo'<meta http-equiv="Refresh" content="1; URL='.$HTTP_REFERER.'">';
                           }
                           else {
                           echo'<meta http-equiv="Refresh" content="1; URL=index.php">';
                           }
	                       echo'<a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>';
                           if($method == "edit"){
                           echo'<a href="'.$HTTP_REFERER.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>';
                           }
                           echo'
	                       </td>
	                   </tr>
	                </table>
	                </center>';
	
}


}
else {
redirect();
}


mysql_close();
?>
