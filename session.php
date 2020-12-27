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

//##################  save active type ####################################
if($active == "private"){
	$active_type = "prv";
	$post_active_type = $_POST["active_type"];
	if(!empty($post_active_type)){
	$_SESSION['DF_active_type'] = $post_active_type;
	head($_SERVER['REQUEST_URI']);
	}
	$load_active_type = $_SESSION['DF_active_type'];
	if(!empty($load_active_type)){
	$active_type = $load_active_type;
	}
}
else if($active == "monitored"){
	$active_type = "mon";
	$post_active_type = $_POST["active_type"];
	if(!empty($post_active_type)){
	$_SESSION['DF_active_type'] = $post_active_type;
	head($_SERVER['REQUEST_URI']);
	}
	$load_active_type = $_SESSION['DF_active_type'];
	if(!empty($load_active_type)){
	$active_type = $load_active_type;
	}
}
else if($active == ""){
	$active_type = "active";
	$post_active_type = $_POST["active_type"];
	if(!empty($post_active_type)){
	$_SESSION['DF_active_type'] = $post_active_type;
	head($_SERVER['REQUEST_URI']);
	}
	$load_active_type = $_SESSION['DF_active_type'];
	if(!empty($load_active_type)){
	$active_type = $load_active_type;
	}
else {
	$active_type = $active_type;
     }
}
//##################  save active type ####################################

//##################  save refresh time ###################################
$refresh_time = 0;
$post_refresh_time = $_POST["refresh_time"];
if(!empty($post_refresh_time)){
	$_SESSION['DF_refresh_time'] = $post_refresh_time;
	head($_SERVER['REQUEST_URI']);
}
$load_refresh_time = $_SESSION['DF_refresh_time'];
if(!empty($load_refresh_time)){
	$refresh_time = $load_refresh_time;
}
else {
	$refresh_time = $refresh_time;
}
//##################  save refresh time ###################################

//##################  save order by #######################################
$order_by = "post";
$post_order_by = $_POST["order_by"];
if(!empty($post_order_by)){
	$_SESSION['DF_order_by'] = $post_order_by;
	head($_SERVER['REQUEST_URI']);
}
$load_order_by = $_SESSION['DF_order_by'];
if(!empty($load_order_by)){
	$order_by = $load_order_by;
}
else {
	$order_by = $order_by;
}
//##################  save order by #######################################

//##################  save reply num page #################################
$reply_num_page = 30;
$post_reply_num_page = $_POST["reply_num_page"];
if(!empty($post_reply_num_page)){
	$_SESSION['DF_reply_num_page'] = $post_reply_num_page;
	head($_SERVER['REQUEST_URI']);
}
$load_reply_num_page = $_SESSION['DF_reply_num_page'];
if(!empty($load_reply_num_page)){
	$reply_num_page = $load_reply_num_page;
}
else {
	$reply_num_page = $reply_num_page;
}
//##################  save reply num page #################################

//################## save sig #############################################
$show_sig = "hide";
$post_show_sig = $_POST['show_sig'];
if(!empty($post_show_sig)){
	$_SESSION['DF_show_sig'] = $post_show_sig;
	head($_SERVER['REQUEST_URI']);
}
$load_show_sig = $_SESSION['DF_show_sig'];
if(!empty($load_show_sig)){
	$show_sig = $load_show_sig;
}
else {
	$show_sig = $show_sig;
}
//################## save sig #############################################

//################## save style ###########################################
if(!empty($ch) && $ch == "style"){
 $style_name = $_POST["style_name"];
 $_SESSION['DF_choose_style'] = $style_name;
 head('index.php');
}
$load_choose_style = $_SESSION['DF_choose_style'];

if(!empty($load_choose_style)){
$choose_style = $load_choose_style;
}
else {
$choose_style = $default_style;
}
//################## save style ###########################################

//##################  save lang ###########################################
if(!empty($ch) && $ch == "lang"){
 $lan_name = $_POST["lan_name"];
 $_SESSION['DF_choose_language'] = $lan_name;
 head('index.php');
}
$load_choose_language = $_SESSION['DF_choose_language'];

if(!empty($load_choose_language)){
$choose_language = $load_choose_language;
}
else {
$choose_language = $default_language;
}

//##################  save lang ###########################################

//##################  save order option ###################################
$order_option = "online";
$post_order_option = $_POST["order_option"];
if(!empty($post_order_option)){
	$_SESSION['DF_order_option'] = $post_order_option;
	head($_SERVER['REQUEST_URI']);
}
$load_order_option = $_SESSION['DF_order_option'];
if(!empty($load_order_option)){
	$order_option = $load_order_option;
}
else {
	$order_option = $order_option;
}
//##################  save order option ###################################

//##################  save desc asc #######################################
$desc_asc = "desc";
$post_desc_asc = $_POST["desc_asc"];
if(!empty($post_desc_asc)){
	$_SESSION['DF_desc_asc'] = $post_desc_asc;
	head($_SERVER['REQUEST_URI']);
}
$load_desc_asc = $_SESSION['DF_desc_asc'];
if(!empty($load_desc_asc)){
	$desc_asc = $load_desc_asc;
}
else {
	$desc_asc = $desc_asc;
}
//##################  save desc asc #######################################


//##################  save timezone #######################################
$timezone = $_POST["timezone"];
if($tz != ""){
	$_SESSION['DF_timezone'] = $timezone;
	head("index.php");
}
$load_timezone =$_SESSION['DF_timezone'];
if($load_timezone == ""){
	$load_timezone = $site_timezone;
}
$chk_timezone = $load_timezone * 3600;
//##################  save timezone #######################################


?>