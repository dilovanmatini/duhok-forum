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

include("CrackerTracker.php");

$dbhost = "localhost";	// insert data base host or server to this line.
$dbuser = "root";	// insert data base user name to this line.
$dbpass = "0000";	// insert data base passowrd to this line.
$dbname = "df";	// insert data base name to this line.

//هنا تستطيع تغير طريقة اتصال بقاعدة بيانات
$connection = @mysql_connect($dbhost, $dbuser, $dbpass) or die("
<center><table cellPadding='4' bgcolor='#ffffcc' dir='rtl' border='1'><tr><td align='middle'><font face='arial' size='4'>
لا يمكن إتصال بسيرفر<br>
تأكد من دخول اسم مستخدم قاعدة بيانات وكلمة مرور قاعدة بيانات<br>
من ملف connect.php
</font></td></tr></table></center>
");
@mysql_select_db($dbname) or die("
<center><table cellPadding='4' bgcolor='#ffffcc' dir='rtl' border='1'><tr><td align='middle'><font face='arial' size='4'>
لا يمكن إتصال بقاعدة بيانات<br>
تأكد من دخول اسم قاعدة بيانات <br>
من ملف connect.php
</font></td></tr></table></center>
");

$Prefix = "FORUM_";    // اختصار جداول قاعدة بيانات
define(prefix, $Prefix);

?>
