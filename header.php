<?php

/*//////////////////////////////////////////////////////////
// ######################################################///
// # Duhok Forum 2.0                                    # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #  === Programmed & developed by Dilovan Matini ===  # //
// # Copyright © 2007-2020 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # Website: github.com/dilovanmatini/duhok-forum      # //
// # Email: df@lelav.com                                # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

// denying calling this file without landing files.
defined('_df_script') or exit();

if(_method=="login"&&trim($_POST['userName'])!=""&&trim($_POST['userPass'])!=""){
	$expire=($save_password?time()+(60*60*24*30):0);
	setcookie("userName",trim($_POST['userName']),$expire);
	setcookie("userPass",md5(trim($_POST['userPass'])),($_POST['savePass']=="save"?$expire:0));
	setcookie("savePass",$_POST['savePass'],$expire);
	head('index.php?method=login');
}
if(_method=="logout"){
	setcookie("userName","");
	setcookie("userPass","");
	setcookie("savePass","");
	head('index.php');
}
$userName=$_COOKIE['userName'];
$userPass=$_COOKIE['userPass'];
$savePass=$_COOKIE['savePass'];
$rs=$mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE M_NAME = :username AND M_PASSWORD = :password AND M_STATUS = '1' ", [
	'username' => $userName,
	'password' => $userPass
], __FILE__, __LINE__)->fetch();
if( is_array($rs) ){
	$user_info=$rs;
	$DBMemberID=$rs['MEMBER_ID'];
	$DBUserName=$rs['M_NAME'];
	$DBPassword=$rs['M_PASSWORD'];
	$Mlevel=$rs['M_LEVEL'];
	$M_Editor_Type=$rs['M_SP_EDITOR'];
	$DBMemberPosts=$rs['M_POSTS'];
	$DBMemberDate=$rs['M_DATE'];
	$font=$rs['M_FONTS_T'];
	$size=$rs['M_SIZE'];
	$weight=$rs['M_WEIGHT'];
	$align=$rs['M_ALIGN'];
	$color=$rs['M_COLOR'];
	$M_Style_Form='FONT-WEIGHT:'.$weight.';FONT-FAMILY:'.$font.';FONT-SIZE:'.$size.';TEXT-ALIGN:'.$align.';COLOR:'.$color.'';
	define('M_Style_Form',$M_Style_Form);
	define('m_id',$DBMemberID);
	define('m_name',$DBUserName);
	define('mlv',$Mlevel);
	define('editor_type',$M_Editor_Type);
	chk_update_login_members();
	if($savePass=="temp"){
		$DonT_Save="";
	}
	else{
		$DonT_Save=" * دخول مؤقت";
	}
}
else{
	$DBMemberID=0;
	$DBUserName=0;
	$DBPassword=0;
	$Mlevel=0;
	$DBMemberPosts=0;
	$DBMemberDate=0;
	define('m_id',$DBMemberID);
	define('m_name',$DBUserName);
	define('mlv',$Mlevel);
	$DonT_Save="";
}
update_ip(0,$DBMemberID);
chk_login_ip($userName,$userPass);
if(_method=="login"&&mlv>0){
	head('index.php');
}
require_once("session.php");
require_once("language/arabic.php");
require_once("online.php");
require_once("Title_Page.php");

if(!empty($ch)&&$ch=="lang"){
	$lan_name=$_POST["lan_name"];
	$_SESSION['DF_choose_language']=$lan_name;
	head('index.php');
}
$load_choose_language=$_SESSION['DF_choose_language'];
if(!empty($load_choose_language)){
	$choose_language=$load_choose_language;
}
else{
	$choose_language=$default_language;
}
require_once("./language/".$choose_language.".php");
$coda=codding($forum_title, $site_name, $copy_right);
if(mode=="editor"){
	$html_dir='';
	$body_content=' onload="load_content()" style="font:10pt verdana,arial,sans-serif" scroll="no"';
}
else{
	$html_dir=' dir="'.$lang['global']['dir'].'"';
	$body_content = '';
}
echo'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html'.$html_dir.'>
	<head>
		<title>'.$forum_title.''.$Page_Name.'</title>
		<meta http-equiv=Content-Type content="'.$lang['global']['charset'].'">
		<meta http-equiv="Content-Language" content="'.$lang['global']['lang_code'].'">
                                    <meta name="description" content="'.$Meta.'">
		<meta content="DUHOK FORUM 1.9: Copyright (C) 2007-'._this_year.' Dilovan Matini." name="copyright">
		<link rel="stylesheet" href="styles/style_'.$choose_style.'.css">
		<script language="javascript" src="javascript/javascript.js?v=200308170900"></script>
		<script language="javascript" src="language/'.$choose_language.'.js?v=200308170900"></script>
		<script language="javascript">
			var dir = "'.$lang['global']['dir'].'";
			var topic_max_size = "'.$topic_max_size.'";
			var reply_max_size = "'.$reply_max_size.'";
			var pm_max_size = "'.$pm_max_size.'";
			var sig_max_size = "'.$sig_max_size.'";
			var editor_method = "'._method.'";
			var fileURL = "'.$forum_url.'";
			var image_folder = "'.$image_folder.'";
			var editor_style = "'.$M_Style_Form.'";

		</script>
	</head>
<body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0"'.$body_content.'>';
if($forum_status == 1 && mlv != 4){
die('
                    <br>
                    <p align="center">
'.icons($logo, $forum_title).'</p>
<p align="center">&nbsp;</p>
<p align="center">
<font color="red" size="+2"><b>'.$close.'<br>
</p>

<p dir="rtl" align="center"><br>
<a href="'.$_SERVER['REQUEST_URI'].'">-- إضغط هنا للمحاولة مرة أخرى 
--</a><u><br>
</u>
');
}

if(mode != "editor" && mode != "p"){
	echo'
	<table class="topholder" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
	<tr>';

	if($forum_status == 1 && mlv == 4){
 header_alert();
 }
	echo'
			<td>
			<table class="menubar" cellSpacing="1" cellPadding="0" width="100%">
				<tr>
					<td width="100%"><a href="index.php">'.icons($logo, $forum_title).'</td>';
			if(mlv > 0){
if($mode){
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php">'.icons($Home).'<br>'.$lang['header']['home'].'</a></nobr></td>';
}


echo '<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=archive">'.icons($archive).'<br>'.$lang['forum']['topic_archive'].'</a></nobr></td>';
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=posts&m=0">'.icons($yourposts).'<br>'.$lang['header']['your_posts'].'</a></nobr></td>';
                    echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=topics&m=0">'.icons($yourtopics).'<br>'.$lang['header']['your_topics'].'</a></nobr></td>';
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=members">'.icons($members).'<br>'.$lang['header']['members'].'</a></nobr></td>';
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=active&active=monitored">'.icons($monitor).'<br>'.$lang['header']['monitors'].'</a></nobr></td>';
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=pm&mail=in">'.icons($messages).'<br>'.$lang['header']['messages'].'</a></nobr></td>';
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=active">'.icons($actives).'<br>'.$lang['header']['active_topics'].'</a></nobr></td>';
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=search">'.icons($search).'<br>'.$lang['header']['search'].'</a></nobr></td>';
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=f&f='.$help_forum.'">'.icons($help).'<br>'.$lang['header']['help'].'</a></nobr></td>';
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=profile&type=details">'.icons($details).'<br>'.$lang['header']['your_details'].'</a></nobr></td>';
				if(mlv == 4){
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a   target="_blank" href=login.php>'.icons($admin).'<br>'.$lang['header']['administration'].'</a></nobr></td>';
				}
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?method=logout" onclick="return confirm(\''.$lang['header']['you_are_sure_to_logout'].'\');">'.icons($exit).'<br>'.$lang['header']['exit'].'</a></nobr></td>';
			}
			else {
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php">'.icons($Home).'<br>'.$lang['header']['home'].'</a></nobr></td>';
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=members">'.icons($members).'<br>'.$lang['header']['members'].'</a></nobr></td>';
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=active">'.icons($actives).'<br>'.$lang['header']['active_topics'].'</a></nobr></td>';
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=f&f='.$help_forum.'">'.icons($help).'<br>'.$lang['header']['help'].'</a></nobr></td>';
					echo'
					<td class="optionsbar_menus2" vAlign="top"><nobr><a href="index.php?mode=policy">'.icons($details).'<br>'.$lang['header']['register'].'</a></nobr></td>';
			}
				echo'
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td>';
		if(mlv > 0){
			echo'
			<table class="userbar" cellSpacing="0" cellPadding="0" width="100%" border="0">
				<tr>
					<td vAlign="center">
					<table cellSpacing="0" cellPadding="0">
						<tr>
							<td class="user" align="left"><nobr><a href="index.php?mode=profile&type=details">'.$lang['header']['name'].'</a></nobr></td>
							<td class="user"><nobr><a href="index.php?mode=profile&type=details">&nbsp;<font color="red">'.m_name.'</font></a>'.$DonT_Save.'</nobr></td>
						</tr>
						<tr>
							<td class="user" align="left"><nobr><a href="index.php?mode=posts&m=0">'.$lang['header']['posts'].'</a></nobr></td>
							<td class="user"><nobr><a href="index.php?mode=posts&m=0">&nbsp;<font color="red">'.members("POSTS", m_id).'</font></a></nobr></td>
						</tr>';
					if(members_new_pm(m_id) > 0){
						echo'
						<tr>
							<td class="user" align="left"><nobr><a href="index.php?mode=pm&mail=new">'.$lang['header']['new_pm'].'</a></nobr></td>
							<td class="user"><nobr><a href="index.php?mode=pm&mail=new">&nbsp;<font color="red">'.members_new_pm(m_id).'</font></a></nobr></td>
						</tr>';
					}
															if($Mlevel > 1){
											my_ip();
								}
					if(num_user_wait() > 0 && mlv == 4){
						echo'
						<tr>
							<td class="user" align="left"><nobr><a href="index.php?mode=admin_svc&type=approve">عضويات تنتظر:</a></nobr></td>
							<td class="user"><nobr><a href="index.php?mode=admin_svc&type=approve">&nbsp;<font color="red">'.num_user_wait().'</font></a></nobr></td>
						</tr>';
					}
					if(changename_count (1) > 0 && mlv == 4){
						echo'
						<tr>
							<td class="user" align="left"><nobr><a href="index.php?mode=admin_svc&type=change_name">أسماء تنتظر:</a></nobr></td>
							<td class="user"><nobr><a href="index.php?mode=admin_svc&type=change_name">&nbsp;<font color="red">'.changename_count (1).'</font></a></nobr></td>
						</tr>';
					}
				
					echo'
					</table>
					</td>
					<td width="10%"></td>
					<td vAlign="center">';
				if(mode == "f"){
					echo'
					<table class="chatusers">
						<tr>
							<td class="forumusers" vAlign="top">
								<a href="index.php?mode=finfo&f='.$f.'">في هذا المنتدى حاليا:</a><br>
								<a class="tiny" href="index.php?mode=finfo&f='.$f.'"><font color="red">عدد الأعضاء:</font>'.forum_online_num($f).'</a>
							</td>
						</tr>
					</table>';
				}
					echo'
					</td>
					<td align="left" width="30%">
					<table border="0" cellPadding="1" cellSpacing="2">';
					if(mlv > 1){
						echo'
						<tr>';
						if(mlv == 4){
						admin_list();
							echo'
		 <td class="optionsbar_menus" rowspan="2"><nobr><a href="index.php?mode=admin_notify">شكاوي<br>الإدارة</a></nobr></td>
         <td class="'.chk_admin_svc_class().'" rowspan="2"><nobr><a href="index.php?mode=admin_svc">خدمات<br>المدير</a></nobr></td>';
						}
							echo'
							<td class="optionsbar_menus"><nobr><a href="index.php?mode=mods">إشرافك</a></nobr></td>
							<td class="optionsbar_menus"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel=1&show=cur">رقابة ومنع</a></nobr></td>
						</tr>
						<tr>
							<td class="optionsbar_menus"><nobr><a href="index.php?mode=files">'.$lang['header']['files'].'</a></nobr></td>
							<td class="optionsbar_menus"><nobr><a href="index.php?mode=svc&svc=medals">'.$lang['header']['services'].'</a></nobr></td>
						</tr>';
					}

					echo'
					</table>
					</td>
				</tr>
			</table>';

		}
		else{
			echo'
			<table class="grid" height="100%" cellSpacing="0" cellPadding="0" border="0">
			<form method="post" action="index.php?method=login">
				<tr>
					<td class="cat" align="middle" colSpan="4">'.$lang['header']['members_login'].'</td>
				</tr>
				<tr>
					<td class="f2ts" align="left"><font color="red"><b>'.$lang['header']['name'].'</b></font></td>
					<td class="f2ts"><input type="text" class="small" style="WIDTH: 100px" name="userName"></td>
					<td class="f2ts" align="left"><font color="red"><nobr><b>'.$lang['header']['password'].'</b></nobr></font></td>
					<td class="f2ts"><input type="password" class="small" style="WIDTH: 100px" name="userPass"></td>
				</tr>
				<tr>
					<td colspan="3" class="f2ts" align="right">
					<select name="savePass">
						<option value="save">'.$lang['header']['save_pass_and_user_name'].'</option>
						<option value="temp">'.$lang['header']['temporarily_login'].'</option>
					</select>
					<td class="f2ts" vAlign="top" align="left"><input class="small" src="'.$login.'" type="image" border="0" value="'.$lang['header']['login'].'"></td>
				</tr>
				<tr>
					<td colspan="3" class="f2ts" align="right"><a class="menu" href="index.php?mode=forget_pass">'.$lang['header']['forget_password'].'</a></td>
					<td class="f2ts" align="right"></td>
				</tr>
			</form>
			</table>';
		}
			echo'
			<br></td>
		</tr>
	</table>';
}

require_once _df_path."includes/template_engine.php";
$tmp = new Template();
$tmp->assign_array("lang",$lang);
$userinfo = $rs;
$m_id = m_id;
$m_name = m_name;
$mlv = mlv;
$log_oout = $lang['header']['you_are_sure_to_logout'];



$chkLoginName=chk_login_name($userName,$userPass);
if(_method=="login"&&mlv==0&&!empty($chkLoginName)){
	login_error_msg($chkLoginName);
}

// Ban Ip , If True Dont show forum , if false , welcome 

is_baned();

// if true sont show forum to visitor
visitor_show_forum();


if(mode == "error" && $type == "editor")  {
if(forums("SEX", $f) == 2){
$word = 'هذا المنتدى خاص للأناث';
}
if(forums("SEX", $f) == 1){
$word = 'هذا المنتدى خاص للذكور';
}
die('<br><center>
		<table width="99%" border="1">
			<tr class="normal">
				<td class="list_center" colSpan="10"><font size="5" color="red"><br>'.$lang['all']['error'].'<br>'.$word.'..</font><br><br>
				<a href="index.php?mode=f&f='.$f.'">'.$lang['all']['click_here_to_back'].'</a><br><br>
				</td>
			</tr>
		</table>
		</center>');
}
?>