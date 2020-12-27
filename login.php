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

session_start();

require_once("./include/func.df.php");
require_once("./include/config.php");
require_once("icons.php");
require_once("converts.php");

if($method == "logout"){
 session_unset($_SESSION['ADFName']);
 session_unset($_SESSION['ADFPass']);
 head('login.php');
}

$auto_user = $_SESSION['ADFName'];
$auto_pass = $_SESSION['ADFPass'];
if($auto_user != "" AND $auto_pass != ""){
 // head('check.php?type=auto');
}

$user_name = $_POST["user_name"];
$user_pass = $_POST["user_pass"];

if($method == "login"){
 $_SESSION['ADFName'] = $user_name;
 $_SESSION['ADFPass'] = $user_pass;
 head('check.php?type=login');
}

echo'
<html dir="rtl">
<head>
<title>'.$forum_title.' - دخول لوحة التحكم</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256">
<meta content="DUHOK FORUM 1.0: Copyright (C) 2007-2008 Dilovan." name="copyright">
<link href="'.$admin_folder.'/cp_styles/cp_style_green.css" type="text/css" rel="stylesheet">
</head>
<body bgcolor="#659867" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0">
<br><br><br><br>';


if($method == "logout"){
                    echo'<center>
	                <table bordercolor="#ffffff" width="60%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تسجيل خروجك بنجاح</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=login.php">
                           <a href="login.php">-- إذا متصفحك لا ينتقل تلقائياً إنقر هنا --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}
if($method == "error"){
	                echo'<center>
	                <table bordercolor="#ffffff" width="60%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>اسم مستخدم أو كلمة مرور خاطئة<br>أو لا تملك تصريح لدخول لوحة التحكم المنتدى</font><br><br>
                           <a href="login.php">-- انقر هنا لمحاولة مرة اخرى --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}
$load_user_name = $_SESSION['DFName'];
if($method == ""){
?>
<form method="post" action="login.php?method=login">
<center>
<table class="grid" cellspacing="1" cellpadding="2" border="0" width="45%">
	<tr>
		<td class="cat" colspan="2" height="25">تسجيل دخول لوحة التحكم</td>
	</tr>
	<tr>
		<td background="<? print $admin_folder; ?>/cp_styles/bg_green.jpg" colspan="2" height="65">
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td><img border="0" src="<? print $admin_folder; ?>/images/cp_logo.gif"></td>
                <td align="middle"><font face="tahoma" color="black" size="2">DUHOK FORUM <? print $forum_version; ?><br><font style="FONT-WEIGHT: normal; FONT-SIZE: 11px">Programming By  Matini</font></font></td>
            </tr>
        </table>
        </td>
	</tr>
	<tr>
		<td class="cat" width="30%">اسم مستخدم</td>
		<td class="userdetails_data" width="70%">&nbsp;<input style="WIDTH: 300px" type="text" name="user_name" value="<? print $load_user_name; ?>"></td>
	</tr>
	<tr>
		<td class="cat" width="30%">كلمة مرور</td>
		<td class="userdetails_data" width="70%">&nbsp;<input style="WIDTH: 300px" type="password" name="user_pass"></td>
	</tr>
	<tr>
		<td class="userdetails_data" colspan="2"><div align="center"><input type="submit" value="دخول">&nbsp;&nbsp;<input type="reset" value="إفراغ خانات"></div></td>
	</tr>
</table>
</center>
</form>

<?php
}
?>
</body>
</html>
