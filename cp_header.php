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
<body leftMargin="0" topMargin="0" marginheight="0" marginwidth="0">
<table class="header" cellspacing="3" cellpadding="0" height="100%" width="100%" border="0">
  <tr>
    <td class="list" width="100%">لوحة التحكم المدير - <? print $forum_title; ?></td>
    <td class="optionsbar_menus"><nobr><a href="index.php" target="_blank">الصفحة الرئيسية</a></nobr></td>
    <td class="optionsbar_menus"><nobr><a onclick="return confirm('هل أنت متأكد من أنك تريد تسجيل الخروج ؟');" target="_top" href="login.php?method=logout">تسجيل الخروج</a></nobr></td>
  </tr>
</table>
</body>
</html>
