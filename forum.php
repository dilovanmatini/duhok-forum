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

if( $f == "" ){
	redirect();
}

$forum_hide = forums("HIDE", $f);
$check_forum_login = check_forum_login($f);
if($forum_hide == 1){
	if($check_forum_login == 0){
		redirect();
	}
}

$f_level = forums("F_LEVEL", $f);
if($f_level > 0 AND mlv < $f_level){
	redirect();
}


$allowed = 1;

if(mlv > 0){
	if($auth == "0"){
		$auth = $DBMemberID;
	}
	if(members("LEVEL", $auth) > "2" && $Mlevel > "1"){
		$allowed = 1;
	}
	if(members("LEVEL", $auth) > "2" && $show_admin_topics == "1"){
		$allowed = 1;
	}
	if(members("LEVEL", $auth) > "2" && $show_admin_topics == "0" && $Mlevel < "2"){
		$allowed = 0;
	}
}

if($allowed == 1){

require_once _df_path."includes/forum_function.php";

// ############ ARCHIVE #############

if( forums("CAN_ARCHIVE", $f) == 0 ){
	$nbr_day = forums("DAY_ARCHIVE", $f);
	$time_close = time() - (60 * 60 * 24 * $nbr_day);
	$mysql->execute("UPDATE {$mysql->prefix}TOPICS SET T_ARCHIVED = ('1') WHERE T_DATE < $time_close AND T_ARCHIVE_FLAG = 1  AND T_MODERATED_BY = 0 AND T_STICKY = 0 AND T_LINKFORUM = 0 AND FORUM_ID = $f ", [], __FILE__, __LINE__);
}

// ############ Close Thread after Some Reply #############

if($total_post_close_topic){
	$mysql->execute("UPDATE {$mysql->prefix}TOPICS SET T_STATUS = ('0') WHERE T_REPLIES >= $total_post_close_topic  AND FORUM_ID = $f ", [], __FILE__, __LINE__);
}


$cat_id = forums("CAT_ID", $f);
$f_subject = forums("SUBJECT", $f);
$f_logo = forums("LOGO", $f);

$allowed = allowed($f, 2);

forum_head($f, $cat_id);
link_forum($f);

if($order_by == "post"){
	$order_by_date = "T_LAST_POST_DATE DESC, T_DATE DESC";
}
else if($order_by == "topic"){
	$order_by_date = "T_DATE DESC, T_LAST_POST_DATE DESC";
}
else{
	$order_by_date = "T_LAST_POST_DATE DESC, T_DATE DESC";
}

if($type != "archive"){

	if($mod_option == "all"){
		$and = "AND T_STATUS < '2'";
		forum_topics($f, $cat_id, $auth);
	}
	else if($mod_option == "topen" AND $allowed == 1){
		$and = "AND T_STATUS = '1'";
		forum_topics($f, $cat_id, $auth);
	}
	else if($mod_option == "tunmoderated" AND $allowed == 1){
		$and = "AND T_UNMODERATED = '1' AND T_STATUS < '2'";
		forum_topics($f, $cat_id, $auth);
	}
	else if($mod_option == "tholded" AND $allowed == 1){
		$and = "AND T_HOLDED = '1' AND T_STATUS < '2'";
		forum_topics($f, $cat_id, $auth);
	}
	else if($mod_option == "tlocked" AND $allowed == 1){
		$and = "AND T_STATUS = '0'";
		forum_topics($f, $cat_id, $auth);
	}
	else if($mod_option == "runmoderated" AND $allowed == 1){
		forum_replies($f, $cat_id, "unmoderated");
	}
	else if($mod_option == "rholded" AND $allowed == 1){
		forum_replies($f, $cat_id, "hold");
	}
	else if($mod_option == "thidden" AND $allowed == 1){
		$and = "AND T_HIDDEN = '1' AND T_STATUS < '2'";
		forum_topics($f, $cat_id, $auth);
	}
	else if($mod_option == "rhidden" AND $allowed == 1){
		forum_replies($f, $cat_id, "hidden");
	}
	else if($mod_option == "ttop" AND $allowed == 1){
		$and = "AND T_TOP = '1' AND T_STATUS < '2'";
		forum_topics($f, $cat_id, $auth);
	}
	else if($mod_option == "tsurvey" AND $allowed == 1){
		$and = "AND T_SURVEYID > '0' AND T_STATUS < '2'";
		forum_topics($f, $cat_id, $auth);
	}
	else if($mod_option == "tunarchived" AND $allowed == 1){
		$and = "AND T_ARCHIVE_FLAG = '0' AND T_STATUS < '2'";
		forum_topics($f, $cat_id, $auth);
	}
	else if($mod_option == "tmoved" AND $allowed == 1){
		$and = "AND T_MOVED = '1' AND T_STATUS < '2'";
		forum_topics($f, $cat_id, $auth);
	}
	else if($mod_option == "tedited" AND $allowed == 1){
		$and = "AND T_LASTEDIT_MAKE > '0' AND T_STATUS < '2'";
		forum_topics($f, $cat_id, $auth);
	}
	else if($mod_option == "tdeleted" AND allowed($f, 1) == 1){
		$and = "AND T_STATUS = '2'";
		forum_topics($f, $cat_id, $auth);
	}
	else {
		$and = " AND T_STATUS < '2'";
		forum_topics($f, $cat_id, $auth);
	}
}else{
forum_archive($f, $cat_id, $auth);
}

    } else {
    redirect();
    }

?>
