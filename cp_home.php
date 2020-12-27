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

include("check.php");
?>
<html dir="rtl">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256">
<meta content="Duhok Forum 2.0: Copyright (C) 2007-<?=_this_year?> Dilovan Matini." name="copyright">
<link href="<? print $admin_folder; ?>/cp_styles/cp_style_green.css" type="text/css" rel="stylesheet">
</head>
<body bgcolor="#659867" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0">
<br>
<?php
switch ($mode){
     case "":
          include ("./$admin_folder/body.php");
     break;
     case "option":
          include ("./$admin_folder/option.php");
     break;
     case "ranks":
          include ("./$admin_folder/ranks.php");
     break;
     case "permission":
          include ("./$admin_folder/permission.php");
     break;
     case "lang":
          include ("./$admin_folder/lang.php");
     break;
     case "style":
          include ("./$admin_folder/style.php");
     break;
     case "backup":
          include ("./$admin_folder/backup.php");
     break;
     case "logo":
          include ("./$admin_folder/logo.php");
     break;
     case "up_styles":
          include ("./$admin_folder/up_styles.php");
     break;
     case "template":
          include ("./$admin_folder/template.php");
     break;
     case "schat":
          include ("./$admin_folder/schat.php");
     break;
     case "pm":
          include ("./$admin_folder/pm.php");
               break;
     case "best":
          include ("./$admin_folder/best.php");
          break;
     case "close":
          include ("./$admin_folder/close.php");
           break;
     case "uplang":
          include ("./$admin_folder/uplang.php");
    break;
	case "upxml":
          include ("./$admin_folder/upxml.php");
    break;
    case "special":
          include ("./$admin_folder/ihdaa.php");
    break;
    case "ads":
          include ("./$admin_folder/ads.php");
      break;
    case "msg":
          include ("./$admin_folder/msg.php");

  break;
     case "phpinfo":
          print '<table width="100%" border="0" cellpadding="0" cellspacing="0" dir="ltr"><tr><td dir="ltr">';
          phpinfo();
          print '</td></tr></table>';
     break;
}
?>
</body>
</html>
