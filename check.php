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

 $load_user_name = $_SESSION['ADFName'];
 $load_user_pass = $_SESSION['ADFPass'];
 $load_user_pass = MD5($load_user_pass);

 $CP = $mysql->execute("SELECT * FROM FORUM_MEMBERS WHERE M_NAME = '$load_user_name' AND M_PASSWORD = '$load_user_pass' AND M_STATUS = 1 AND M_LEVEL = 4 AND M_ADMIN = 1 ", [], __FILE__, __LINE__);

 if(mysql_num_rows($CP) > 0){
 $rsCP = mysql_fetch_array($CP);

 $CPMemberID = $rsCP['MEMBER_ID'];
 $CPUserName = $rsCP['M_NAME'];
 $CPPassword = $rsCP['M_PASSWORD'];
 $CPMemberPosts = $rsCP['M_POSTS'];
 $CPMlevel = $rsCP['M_LEVEL'];
 }
 else {
 $CPMemberID = "0";
 $CPUserName = "0";
 $CPPassword = "0";
 $CPMemberPosts = "0";
 $CPMlevel = "0";
 }
 
 if($CPUserName == $load_user_name && $CPPassword == $load_user_pass){
   $Adminlogin = 1;

   if($type == "login"){

                    echo '
                    <html dir="rtl"><head><title></title>
                    <link href="'.$admin_folder.'/cp_styles/cp_style_green.css" type="text/css" rel="stylesheet">
                    </head>
                    <body bgcolor="#659867" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0">
                    <br><br><br>
                    <center>
	                <table bordercolor="#ffffff" width="60%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تسجيل دخول بنجاح</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL='.$admin_folder.'.php">
                           <a href="'.$admin_folder.'.php">-- إذا متصفحك لا ينتقل تلقائياً إنقر هنا --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center></body></html>';
   }
   if($type == "auto"){
       print '<meta http-equiv="Refresh" content="0; URL='.$admin_folder.'.php">';
   }

 }
 else {
   $Adminlogin = 0;
   if($type == "login"){
     go_to("login.php?method=error");
   }
   else {
     go_to("login.php");
   }
 }
 
?>
