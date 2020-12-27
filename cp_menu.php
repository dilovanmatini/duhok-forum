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
<script type="text/javascript">
	function set_cp_title()
	{
		parent.document.title = ("DUHOK FORUM - "+parent.document.title);
	}
</script>
</head>
<body bgcolor="#ddffdd" onload="set_cp_title();" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0">


<table background="<? print $admin_folder; ?>/cp_styles/bg_green.jpg" cellspacing="0" cellpadding="0" width="100%" border="0">
  <tr>
    <td height="80" valign="top"><img title="لوحة التحكم المدير" alt="" hspace=0 src="<? print $admin_folder; ?>/images/cp_logo.gif" vspace=0 border=0></td>
  </tr>
  <tr>
    <td valign="top" align="middle" height="50"><font face="tahoma" color="black" size="2">DUHOK FORUM <? print $forum_version; ?><br><font style="FONT-WEIGHT: normal; FONT-SIZE: 11px">Programming By Dilovan Matini</font></font></td>
  </tr>
</table>

<table cellspacing="0" cellpadding="0" width="100%" border="0">
  <tr>
    <td>
    <div class="menu">
    <script src="<? print $admin_folder; ?>/javascript.js" type="text/javascript"></script>

    <script type="text/javascript">
    	function open_close_group(group, doOpen)
	{
		var curdiv = fetch_object("group_" + group);
		var curbtn = fetch_object("button_" + group);

		if(doOpen)
		{
			curdiv.style.display = "";
			curbtn.src = "<? print $admin_folder; ?>/images/cp_collapse.gif";
			curbtn.title = "إغلاق القائمة";
		}
		else
		{
			curdiv.style.display = "none";
			curbtn.src = "<? print $admin_folder; ?>/images/cp_expand.gif";
			curbtn.title = "فتح القائمة";
		}

	}
    </script>
    
      <a name="GroupDuhokForum_0"></a>
      <table class="navtitle" ondblclick="toggle_group('DuhokForum_0'); return false;" cellSpacing="0" cellPadding="0" width="100%" border="0">
        <tr>
          <td><font color="#ffffff"><strong>إعدادات المنتدى</strong></font></td>
          <td align="left">
    	  <a oncontextmenu="toggle_group('DuhokForum_0'); save_group_prefs('DuhokForum_0'); return false" onclick="toggle_group('DuhokForum_0'); return false;" href="index.php?id=DuhokForum_0#GroupDuhokForum_0" target="_self">
	      <img id="button_DuhokForum_0" title="فتح القائمة" alt="" src="<? print $admin_folder; ?>/images/cp_expand.gif" border="0"></a>
	      </td>
        </tr>
      </table>
      <div class="navgroup" id="group_DuhokForum_0" style="DISPLAY: none">
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=option');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=option');">إعدادات الأساسية</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=option&method=other');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=option&method=other');">إعدادات اخرى</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=option&method=editor');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=option&method=editor');">إعدادات المحرر</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=option&method=files');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=option&method=files');">إعدادات الحافظة</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=option&method=site');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=option&method=site');">إعدادات الموقع</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=option&method=ip');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=option&method=ip');">إعدادات منع الاي بي</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=option&method=list_m');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=option&method=list_m');">إعدادات قوائم الأعضاء</a>
        </div>
      </div>

                  <a name="GroupDuhokForum_close"></a>
      </font></b>
      <table class="navtitle" ondblclick="toggle_group('DuhokForum_close'); return false;" cellSpacing="0" cellPadding="0" width="100%" border="0">
        <tr>
          <td><font color="#ffffff"><strong>قفل / فتح المنتدى</strong></font></td>

          <td align="left">
    	  <b><font face="Tahoma" style="font-size: 9pt">
    	  <a oncontextmenu="toggle_group('DuhokForum_close'); save_group_prefs('DuhokForum_close'); return false" onclick="toggle_group('DuhokForum_close'); return false;" href="../j/index.php?id=DuhokForum_close#GroupDuhokForum_close" target="_self">
	      <img id="button_DuhokForum_close" title="فتح القائمة" alt="" src="<? print $admin_folder; ?>/images/cp_expand.gif" border="0"></a>
	      </font></b>
	      </td>
        </tr>
      </table>
      <div class="navgroup" id="group_DuhokForum_close" style="DISPLAY: none">
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=close&method=close');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=close&method=close');">وضعية المنتدى</a>
        </font></b>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=close&method=msg');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=close&method=msg');">رسالة القفل</a>
        </div>
      </div>
      

            <a name="GroupDuhokForum_001"></a>
      </font></b>
      <table class="navtitle" ondblclick="toggle_group('DuhokForum_001'); return false;" cellSpacing="0" cellPadding="0" width="100%" border="0">
        <tr>
          <td><font color="#ffffff"><strong>إعدادات اللغة</strong></font></td>
          <td align="left">
    	  <a oncontextmenu="toggle_group('DuhokForum_001'); save_group_prefs('DuhokForum_001'); return false" onclick="toggle_group('DuhokForum_001'); return false;" href="index.php?id=DuhokForum_001#GroupDuhokForum_001" target="_self">
	      <img id="button_DuhokForum_001" title="فتح القائمة" alt="" src="<? print $admin_folder; ?>/images/cp_expand.gif" border="0"></a>
	      </font></b>
	      </td>
        </tr>
      </table>
      <div class="navgroup" id="group_DuhokForum_001" style="DISPLAY: none">
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=uplang');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=uplang');">رفع ملف لغة</a>
        </font></b>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=lang&method=add');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=lang&method=add');">إضافة لغة جديدة</a>
        </font></b>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=lang');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=lang');">خيارات لغة</a>
        </font></b>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=lang&method=lang');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=lang&method=lang');">اللغة الإفتراضية</a>
        </div>
      </div>
      
      <a name="GroupDuhokForum_1"></a>
      <table class="navtitle" ondblclick="toggle_group('DuhokForum_1'); return false;" cellSpacing="0" cellPadding="0" width="100%" border="0">
        <tr>
          <td><font color="#ffffff"><strong>إعدادات الستايل</strong></font></td>
          <td align="left">
    	  <a oncontextmenu="toggle_group('DuhokForum_1'); save_group_prefs('DuhokForum_1'); return false" onclick="toggle_group('DuhokForum_1'); return false;" href="index.php?id=DuhokForum_1#GroupDuhokForum_1" target="_self">
	      <img id="button_DuhokForum_1" title="فتح القائمة" alt="" src="<? print $admin_folder; ?>/images/cp_expand.gif" border="0"></a>
	      </td>
        </tr>
      </table>
<div class="navgroup" id="group_DuhokForum_1" style="DISPLAY: none">
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=style');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=style');">خيارات ستايل</a>
        </font></b>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=template');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=template');">قوالب الاستايل</a>
        </font></b>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=up_styles');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=up_styles');">رفع الاستايل</a>
        </font></b>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=upxml');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=upxml');">رفع ملف قالب</a>
        </font></b>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=style&method=style');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=style&method=style');">الستايل الإفتراضي</a>
        </div>
      </div>      
      <a name="GroupDuhokForum_4"></a>
      <table class="navtitle" ondblclick="toggle_group('DuhokForum_4'); return false;" cellSpacing="0" cellPadding="0" width="100%" border="0">
        <tr>
          <td><font color="#ffffff"><strong>تراخيص المجموعات</strong></font></td>
          <td align="left">
    	  <a oncontextmenu="toggle_group('DuhokForum_4'); save_group_prefs('DuhokForum_4'); return false" onclick="toggle_group('DuhokForum_4'); return false;" href="index.php?id=DuhokForum_4#GroupDuhokForum_4" target="_self">
	      <img id="button_DuhokForum_4" title="فتح القائمة" alt="" src="<? print $admin_folder; ?>/images/cp_expand.gif" border="0"></a>
	      </td>
        </tr>
      </table>
      <div class="navgroup" id="group_DuhokForum_4" style="DISPLAY: none">
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=permission&method=mon');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=permission&method=mon');">المراقب</a>
        </font></b>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=permission&method=mod');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=permission&method=mod');">المشرف</a>
        </font></b>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=permission&method=mem');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=permission&method=mem');">الأعضاء</a>
        </font></b>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=permission&method=new');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=permission&method=new');"> الأعضاء الجدد</a>
        </font></b>
        </div>        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=permission&method=bad');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=permission&method=bad');">الممنوعين</a>
        </font></b>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=permission&method=visitor');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=permission&method=visitor');">الزوار</a>
        </div>
      </div>

      <a name="GroupDuhokForum_2"></a>
      <table class="navtitle" ondblclick="toggle_group('DuhokForum_2'); return false;" cellSpacing="0" cellPadding="0" width="100%" border="0">
        <tr>
          <td><font color="#ffffff"><strong>الرتب والأوصاف</strong></font></td>
          <td align="left">
    	  <a oncontextmenu="toggle_group('DuhokForum_2'); save_group_prefs('DuhokForum_2'); return false" onclick="toggle_group('DuhokForum_2'); return false;" href="index.php?id=DuhokForum_2#GroupDuhokForum_2" target="_self">
	      <img id="button_DuhokForum_2" title="فتح القائمة" alt="" src="<? print $admin_folder; ?>/images/cp_expand.gif" border="0"></a>
	      </td>
        </tr>
      </table>
      <div class="navgroup" id="group_DuhokForum_2" style="DISPLAY: none">
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=ranks&type=stars');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=ranks&type=stars');">أوصاف افتراضي</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=ranks&type=colors');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=ranks&type=colors');">الوان نجوم</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=ranks&type=group');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=ranks&type=group');">الوان المجموعات</a>
        </div>
      </div>
      

<?php
if(isset($active_schat)){
?>

         <a name="GroupDuhokForum_6"></a>
      <table class="navtitle" ondblclick="toggle_group('DuhokForum_6'); return false;" cellSpacing="0" cellPadding="0" width="100%" border="0">
        <tr>
          <td><font color="#ffffff"><strong>النقاش الحي</strong></font></td>
          <td align="left">
    	  <a oncontextmenu="toggle_group('DuhokForum_6'); save_group_prefs('DuhokForum_6'); return false" onclick="toggle_group('DuhokForum_6'); return false;" href="index.php?id=DuhokForum_6#GroupDuhokForum_6" target="_self">
	      <img id="button_DuhokForum_6" title="فتح القائمة" alt="" src="<? print $admin_folder; ?>/images/cp_expand.gif" border="0"></a>
	      </td>
        </tr>
      </table>

      <div class="navgroup" id="group_DuhokForum_6" style="DISPLAY: none">
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=schat');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=schat');">اعدادات اساسية</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=schat&type=icon');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=schat&type=icon');">اعدادات الايقونات</a>
        </div>
      </div>
<?php
}
?>

<a name="GroupDuhokForum_7"></a>
      <table class="navtitle" ondblclick="toggle_group('DuhokForum_7'); return false;" cellSpacing="0" cellPadding="0" width="100%" border="0">
        <tr>
          <td><font color="#ffffff"><strong>خيارات اضافية</strong></font></td>
          <td align="left">
    	  <a oncontextmenu="toggle_group('DuhokForum_7'); save_group_prefs('DuhokForum_7'); return false" onclick="toggle_group('DuhokForum_7'); return false;" href="index.php?id=DuhokForum_7#GroupDuhokForum_7" target="_self">
	      <img id="button_DuhokForum_7" title="فتح القائمة" alt="" src="<? print $admin_folder; ?>/images/cp_expand.gif" border="0"></a>
	      </td>
        </tr>
      </table>
      <div class="navgroup" id="group_DuhokForum_7" style="DISPLAY: none">
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=pm');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=pm');">ارسل رسالة جماعية</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=special');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=special');">الإهدائات</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=best');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=best');">لوحة التميز</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=msg');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=msg');">إعدادات رسالة الترحيب</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=ads');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=ads');">إعداد الإشهارات</a>
        </div>
              </div>


<a name="GroupDuhokForum_3"></a>
      <table class="navtitle" ondblclick="toggle_group('DuhokForum_3'); return false;" cellSpacing="0" cellPadding="0" width="100%" border="0">
        <tr>
          <td><font color="#ffffff"><strong>الصيانة</strong></font></td>
          <td align="left">
    	  <a oncontextmenu="toggle_group('DuhokForum_3'); save_group_prefs('DuhokForum_3'); return false" onclick="toggle_group('DuhokForum_3'); return false;" href="index.php?id=DuhokForum_3#GroupDuhokForum_3" target="_self">
	      <img id="button_DuhokForum_3" title="فتح القائمة" alt="" src="<? print $admin_folder; ?>/images/cp_expand.gif" border="0"></a>
	      </td>
        </tr>
      </table>
      <div class="navgroup" id="group_DuhokForum_3" style="DISPLAY: none">
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=backup');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=backup');">النسخ الاحتياطي</a>
        </div>
        <div class="navlink-normal" onmouseover="this.className='navlink-hover';" onclick="nav_goto('cp_home.php?mode=phpinfo');" onmouseout="this.className='navlink-normal'">
        <a class="menu" href="javascript:nav_goto('cp_home.php?mode=phpinfo');">معلومات PHP</a>
        </div>
      </div>


    </div>
    </td>
  </tr>
</table>
</body>
</html>
