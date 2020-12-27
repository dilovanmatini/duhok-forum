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

if($CPMlevel == 4){

$question = icons($icon_question, "انقر هنا لمعرفة معلومات هذا الخيار", "");

if($method == ""){

 if($type == ""){
echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=option&type=insert_data">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>تعديل خيارات منتدى</nobr></td>
	</tr>
	<tr class="fixed">
		<td class="list"><nobr>اسم المنتدى</nobr></td>
		<td class="middle"><input type="text" name="forum_name" size="40" value="'.$forum_title.'"></td>
	</tr>
	<tr class="fixed">
		<td class="list"><nobr>اسم المنتدى الثاني</nobr></td>
		<td class="middle"><input type="text" name="forum_name2" size="40" value="'.$forum_title2.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عنوان الموقع</nobr></td>
		<td class="middle"><input type="text" dir="ltr" name="site_address" size="40" value="'.$site_name.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>بريد المنتدى</nobr></td>
		<td class="middle"><input type="text" dir="ltr" name="admin_email" size="40" value="'.$admin_email.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>حقوق المنتدى</nobr></td>
		<td class="middle"><input type="text" dir="ltr" name="copy_right" size="40" value="'.$copy_right.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>اسم مجلد صور</nobr></td>
		<td class="middle"><input type="text" dir="ltr" name="image_folder" size="40" value="'.$image_folder.'"></td>
	</tr>
<tr class="fixed">
		<td class="list"><nobr>وصف المنتدى</nobr></td>
		<td class="middle"><input type="text" name="meta" size="40" value="'.$Meta.'"></td>
</tr>
<tr class="fixed">
		<td class="list"><nobr>الكلمات المفتاحية</nobr></td>
		<td class="middle"><input type="text" name="key" size="40" value="'.$KeyWords.'"></td>
</tr>
<tr class="fixed">
		<td class="list"><nobr>الكلمات الممنوعة</nobr></td>
		<td class="middle"><input type="text" name="ban_words" size="40" value="'.$BanWords.'"></td>
</tr>
	</tr>
</tr>
<tr class="fixed">
		<td class="list"><nobr>رابط شعار المنتدى</nobr></td>
		<td class="middle"><input type="text" name="logos" size="40" value="'.$logos.'"></td>
</tr>

 	<tr class="fixed">
		<td class="list"><nobr>اسم مجلد الإدارة</nobr></td>
		<td class="middle"><input type="text" dir="ltr" name="admin_folder" size="40" value="'.$admin_folder.'"></td>
	</tr>
<tr class="fixed">
		<td class="list"><nobr>تحويل الروابط aspx</nobr></td>
		<td class="userdetails_data"><input type="radio" value="0" name="seo" '.check_radio($seo, "0").'>غير مفعل&nbsp;&nbsp;
        <input type="radio" value="1" name="seo" '.check_radio($seo, "1").'>مفعل</td>
	</tr>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</form>
</table>
</center>';

 }

 if($type == "insert_data"){

$Admin_ForumTitle = $_POST["forum_name"];
$Admin_ForumTitle2 = $_POST["forum_name2"];
$Admin_SiteAddress = $_POST["site_address"];
$Admin_CopyRight = $_POST["copy_right"];
$Admin_ImageFolder = $_POST["image_folder"];
$Admin_AdminFolder = $_POST["admin_folder"];
$Admin_AdminEmail = $_POST["admin_email"];
$Admin_Seo = $_POST["seo"];
$Admin_Meta = $_POST["meta"];
$Admin_Key = $_POST["key"];
$Admin_Ban_Words = $_POST["ban_words"];
updata_mysql("logos", $_POST['logos']);

$Admin_AdminFolder = $_POST["admin_folder"];

    if($error != ""){
	                echo'<br><center>
	                <table bordercolor="#ffffff" width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){

updata_mysql("FORUM_TITLE", $Admin_ForumTitle);
updata_mysql("FORUM_TITLE2", $Admin_ForumTitle2);
updata_mysql("SITE_ADDRESS", $Admin_SiteAddress);
updata_mysql("COPY_RIGHT", $Admin_CopyRight);
updata_mysql("IMAGE_FOLDER", $Admin_ImageFolder);
updata_mysql("ADMIN_EMAIL", $Admin_AdminEmail);
updata_mysql("FORUM_SEO", $Admin_Seo);
updata_mysql("FORUM_META", $Admin_Meta);
updata_mysql("FORUM_KEY", $Admin_Key);
updata_mysql("FORUM_BANWORDS", $Admin_Ban_Words);
updata_mysql("ADMIN_FOLDER", $Admin_AdminFolder);
rename($admin_folder.".php", $Admin_AdminFolder.".php");

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=option">
                           <a href="cp_home.php?mode=option">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}



if($method == "other"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=option&method=other&type=insert_data">
	<tr class="fixed">
		<td class="cat" colspan="4"><nobr>اعدادات عامة</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>خيارات التسجيل الأعضاء</nobr></td>
		<td class="userdetails_data"><input type="radio" value="1" name="register_waitting" '.check_radio($register_waitting, "1").'>تسجيل بموافقة الإدارة&nbsp;&nbsp;</td>
        <td class="userdetails_data"> <input type="radio" value="2" name="register_waitting" '.check_radio($register_waitting, "2").'>إيقاف التسجيل</td>
		<td class="userdetails_data"><input type="radio" value="0" name="register_waitting" '.check_radio($register_waitting, "0").'>تسجيل مفتوح&nbsp;&nbsp;</td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عرض أوسمة في المشاركات العضو</nobr></td>
		<td class="userdetails_data"><input type="radio" value="1" name="show_medals_in_posts" '.check_radio($show_medals_in_posts, "1").'>يظهر نص عنوان وسام&nbsp;&nbsp;</td>
        <td class="userdetails_data"><input type="radio" value="2" name="show_medals_in_posts" '.check_radio($show_medals_in_posts, "2").'>يظهر صورة الوسام</td>
		<td class="userdetails_data"><input type="radio" value="0" name="show_medals_in_posts" '.check_radio($show_medals_in_posts, "0").'>لا يظهر&nbsp;&nbsp;</td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عرض معلومات المدير</nobr></td>
		<td class="userdetails_data"><input type="radio" value="1" name="show_admin_info" '.check_radio($show_admin_info, "1").'>نعم&nbsp;&nbsp;</td>
        <td class="userdetails_data" colspan="2"><input type="radio" value="0" name="show_admin_info" '.check_radio($show_admin_info, "0").'>لا</td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>يمكن للأعضاء رؤية مواضيع المراقبين والمدراء </nobr></td>
		<td class="userdetails_data"><input type="radio" value="1" name="show_admin_topics" '.check_radio($show_admin_topics, "1").'>نعم&nbsp;&nbsp;</td>
        <td class="userdetails_data" colspan="2"><input type="radio" value="0" name="show_admin_topics" '.check_radio($show_admin_topics, "0").'>لا</td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عرض المشرفين في الصفحة الرئيسية</nobr></td>
		<td class="userdetails_data"><input type="radio" value="1" name="show_moderators" '.check_radio($show_moderators, "1").'>نعم&nbsp;&nbsp;</td>
        <td class="userdetails_data" colspan="2"><input type="radio" value="0" name="show_moderators" '.check_radio($show_moderators, "0").'>لا</td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عرض ترتيب اليكسا لموقعك في خدمات المدير</nobr></td>
		<td class="userdetails_data"><input type="radio" value="1" name="show_alexa_traffic" '.check_radio($show_alexa_traffic, "1").'>نعم&nbsp;&nbsp;</td>
        <td class="userdetails_data" colspan="2"><input type="radio" value="0" name="show_alexa_traffic" '.check_radio($show_alexa_traffic, "0").'>لا</td>
	</tr>
	<tr class="fixed">
		<td class="cat" colspan="4"><nobr>خيارات الاعداد</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>رقم المنتدى الخاص لأيقونة مساعدة</nobr></td>
		<td class="middle" colspan="3"><input type="text" name="help_forum" size="10" value="'.$help_forum.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عدد مرات تغيير اسم المستخدم</nobr></td>
		<td class="middle" colspan="3"><input type="text" name="change_name_max" size="10" value="'.$change_name_max.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عدد الأيام بين كل تغيير لإسم العضوية</nobr></td>
		<td class="middle" colspan="3"><input type="text" name="changename_dayslimit" size="10" value="'.$changename_dayslimit.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عدد صفحات في كل صفحة</nobr></td>
		<td class="middle" colspan="3"><input type="text" name="page_number" size="10" value="'.$max_page.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عدد الردود في الموضوع حتى يقفل</nobr></td>
		<td class="middle" colspan="3"><input type="text" name="total_post_close_topic" size="10" value="'.$total_post_close_topic.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عدد رسائل خاصة لمدة 24 ساعة</nobr></td>
		<td class="middle" colspan="3"><input type="text" name="total_pm_msg" size="10" value="'.$total_pm_message.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عدد عمليات البحث المسموح بها</nobr></td>
		<td class="middle" colspan="3"><input type="text" name="max_search" size="10" value="'.$max_search.'"></td>
	</tr>
	<tr class="fixed">
		<td class="cat" colspan="4"><nobr>خيارات حجم النصوص</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>أقصى حجم النص للمواضيع</nobr></td>
		<td class="middle" colspan="3"><input type="text" name="topic_max_size" size="10" value="'.$topic_max_size.'"><font color="black">&nbsp;بايت&nbsp;&nbsp;/&nbsp;&nbsp;يقابل ('.to_kb($topic_max_size).') كيلوبايت</font></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>أقصى حجم النص للردود</nobr></td>
		<td class="middle" colspan="3"><input type="text" name="reply_max_size" size="10" value="'.$reply_max_size.'"><font color="black">&nbsp;بايت&nbsp;&nbsp;/&nbsp;&nbsp;يقابل ('.to_kb($reply_max_size).') كيلوبايت</font></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>أقصى حجم النص للرسائل الخاصة</nobr></td>
		<td class="middle" colspan="3"><input type="text" name="pm_max_size" size="10" value="'.$pm_max_size.'"><font color="black">&nbsp;بايت&nbsp;&nbsp;/&nbsp;&nbsp;يقابل ('.to_kb($pm_max_size).') كيلوبايت</font></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>أقصى حجم النص للتوقيع</nobr></td>
		<td class="middle" colspan="3"><input type="text" name="sig_max_size" size="10" value="'.$sig_max_size.'"><font color="black">&nbsp;بايت&nbsp;&nbsp;/&nbsp;&nbsp;يقابل ('.to_kb($sig_max_size).') كيلوبايت</font></td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="4"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</form>
</table>
</center>';
 }

 if($type == "insert_data"){


    if($error != ""){
	                echo'<br><center>
	                <table bordercolor="#ffffff" width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){


updata_mysql("PAGE_NUMBER", $_POST["page_number"]);
updata_mysql("TOTAL_POST_CLOSE_TOPIC", $_POST["total_post_close_topic"]);
updata_mysql("TOTAL_PM_MSG", $_POST["total_pm_msg"]);
updata_mysql("TOPIC_MAX_SIZE", $_POST['topic_max_size']);
updata_mysql("REPLY_MAX_SIZE", $_POST['reply_max_size']);
updata_mysql("PM_MAX_SIZE", $_POST['pm_max_size']);
updata_mysql("SIG_MAX_SIZE", $_POST['sig_max_size']);
updata_mysql("SHOW_ADMIN_INFO", $_POST['show_admin_info']);
updata_mysql("HELP_FORUM", $_POST['help_forum']);
updata_mysql("CHANGE_NAME_MAX", $_POST['change_name_max']);
updata_mysql("CHANGENAME_DAYSLIMIT", $_POST['changename_dayslimit']);
updata_mysql("SHOW_MODERATORS", $_POST['show_moderators']);
updata_mysql("SHOW_ALEXA_TRAFFIC", $_POST['show_alexa_traffic']);
updata_mysql("REGISTER_WAITTING", $_POST['register_waitting']);
updata_mysql("SHOW_MEDALS_IN_POSTS", $_POST['show_medals_in_posts']);
updata_mysql("SHOW_ADMIN_TOPICS", $_POST['show_admin_topics']);
updata_mysql("MAX_SEARCH", $_POST['max_search']);
                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=option&method=other">
                           <a href="cp_home.php?mode=option&method=other">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}


if($method == "editor"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="60%">
<form method="post" action="cp_home.php?mode=option&method=editor&type=insert_data">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>خيارات محرر النصوص</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>دعم كامل للــ HTML</nobr></td>
		<td width="60%" class="userdetails_data">
        <input class="radio" type="radio" value="true" name="ed_full_html" '.check_radio($editor_full_html, "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="ed_full_html" '.check_radio($editor_full_html, "false").'>لا
        </td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عرض المحرر</nobr></td>
		<td class="middle"><input type="text" name="ed_width" size="10" value="'.$editor_width.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>ارتفاع المحرر</nobr></td>
		<td class="middle"><input type="text" name="ed_height" size="10" value="'.$editor_height.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>إظهار وإخفاء آيقونات المحرر</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>ايقونة حفظ</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_0" '.check_radio($EditorIcon[0], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_0" '.check_radio($EditorIcon[0], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة الطباعة</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_1" '.check_radio($EditorIcon[1], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_1" '.check_radio($EditorIcon[1], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة تكبير والتصغير</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_2" '.check_radio($EditorIcon[2], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_2" '.check_radio($EditorIcon[2], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة ستايل</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_3" '.check_radio($EditorIcon[3], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_3" '.check_radio($EditorIcon[3], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة نوع الفقرة</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_4" '.check_radio($EditorIcon[4], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_4" '.check_radio($EditorIcon[4], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة نمط الخط</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_5" '.check_radio($EditorIcon[5], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_5" '.check_radio($EditorIcon[5], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة حجم الخط</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_6" '.check_radio($EditorIcon[6], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_6" '.check_radio($EditorIcon[6], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة صندوق النص</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_7" '.check_radio($EditorIcon[7], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_7" '.check_radio($EditorIcon[7], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة تحديد الكل</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_8" '.check_radio($EditorIcon[8], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_8" '.check_radio($EditorIcon[8], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة قص</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_9" '.check_radio($EditorIcon[9], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_9" '.check_radio($EditorIcon[9], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة نسخ</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_10" '.check_radio($EditorIcon[10], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_10" '.check_radio($EditorIcon[10], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة لصق</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_11" '.check_radio($EditorIcon[11], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_11" '.check_radio($EditorIcon[11], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة إلغاء آخر تغير</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_12" '.check_radio($EditorIcon[12], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_12" '.check_radio($EditorIcon[12], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة رجوع الى آخر تغير</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_13" '.check_radio($EditorIcon[13], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_13" '.check_radio($EditorIcon[13], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة خط ثقيل</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_14" '.check_radio($EditorIcon[14], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_14" '.check_radio($EditorIcon[14], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة خط مايل</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_15" '.check_radio($EditorIcon[15], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_15" '.check_radio($EditorIcon[15], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة خط تحت النص</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_16" '.check_radio($EditorIcon[16], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_16" '.check_radio($EditorIcon[16], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة خط على النص</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_17" '.check_radio($EditorIcon[17], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_17" '.check_radio($EditorIcon[17], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة خط للاعلاه</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_18" '.check_radio($EditorIcon[18], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_18" '.check_radio($EditorIcon[18], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة خط للاسفل</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_19" '.check_radio($EditorIcon[19], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_19" '.check_radio($EditorIcon[19], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة إدخال شعار</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_20" '.check_radio($EditorIcon[20], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_20" '.check_radio($EditorIcon[20], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة نص في اليسار</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_21" '.check_radio($EditorIcon[21], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_21" '.check_radio($EditorIcon[21], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة نص في الوسط</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_22" '.check_radio($EditorIcon[22], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_22" '.check_radio($EditorIcon[22], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة نص في اليمين</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_23" '.check_radio($EditorIcon[23], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_23" '.check_radio($EditorIcon[23], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة نص بعرض الصفحة</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_24" '.check_radio($EditorIcon[24], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_24" '.check_radio($EditorIcon[24], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة قائمة مرقمة</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_25" '.check_radio($EditorIcon[25], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_25" '.check_radio($EditorIcon[25], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة قائمة منقوطة</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_26" '.check_radio($EditorIcon[26], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_26" '.check_radio($EditorIcon[26], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة حركة لليسار</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_27" '.check_radio($EditorIcon[27], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_27" '.check_radio($EditorIcon[27], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة حركة لليمين</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_28" '.check_radio($EditorIcon[28], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_28" '.check_radio($EditorIcon[28], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة إدخال الصورة</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_29" '.check_radio($EditorIcon[29], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_29" '.check_radio($EditorIcon[29], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة لون النص</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_30" '.check_radio($EditorIcon[30], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_30" '.check_radio($EditorIcon[30], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة لون خلفية النص</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_31" '.check_radio($EditorIcon[31], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_31" '.check_radio($EditorIcon[31], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة إدخال الرابط</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_32" '.check_radio($EditorIcon[32], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_32" '.check_radio($EditorIcon[32], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة إدخال رابط داخلي</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_33" '.check_radio($EditorIcon[33], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_33" '.check_radio($EditorIcon[33], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة إدخال ملفات الوسائط</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_34" '.check_radio($EditorIcon[34], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_34" '.check_radio($EditorIcon[34], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة إدخال جدول</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_35" '.check_radio($EditorIcon[35], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_35" '.check_radio($EditorIcon[35], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة إظهار إطار</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_36" '.check_radio($EditorIcon[36], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_36" '.check_radio($EditorIcon[36], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة مطلق</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_37" '.check_radio($EditorIcon[37], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_37" '.check_radio($EditorIcon[37], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة مسح</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_38" '.check_radio($EditorIcon[38], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_38" '.check_radio($EditorIcon[38], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة إدخال خط افقي</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_39" '.check_radio($EditorIcon[39], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_39" '.check_radio($EditorIcon[39], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة خصائص العرض</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_40" '.check_radio($EditorIcon[40], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_40" '.check_radio($EditorIcon[40], "false").'>لا
        </td>
	</tr>
    <tr class="fixed">
		<td class="list"><nobr>ايقونة لصق من Word</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="true" name="icon_41" '.check_radio($EditorIcon[41], "true").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="false" name="icon_41" '.check_radio($EditorIcon[41], "false").'>لا
        </td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</form>
</table>
</center>';
 }

 if($type == "insert_data"){

    if($error != ""){
	                echo'<br><center>
	                <table bordercolor="#ffffff" width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){
updata_mysql("EDITOR_FULL_HTML", $_POST['ed_full_html']);
updata_mysql("EDITOR_WIDTH", $_POST['ed_width']);
updata_mysql("EDITOR_HEIGHT", $_POST['ed_height']);

updata_mysql("EDITOR_ICON_SAVE", $_POST['icon_0']);
updata_mysql("EDITOR_ICON_PRINT", $_POST['icon_1']);
updata_mysql("EDITOR_ICON_ZOOM", $_POST['icon_2']);
updata_mysql("EDITOR_ICON_STYLE", $_POST['icon_3']);
updata_mysql("EDITOR_ICON_PARAGRAPH", $_POST['icon_4']);
updata_mysql("EDITOR_ICON_FONT_NAME", $_POST['icon_5']);
updata_mysql("EDITOR_ICON_SIZE", $_POST['icon_6']);
updata_mysql("EDITOR_ICON_TEXT", $_POST['icon_7']);
updata_mysql("EDITOR_ICON_SELECT_ALL", $_POST['icon_8']);
updata_mysql("EDITOR_ICON_CUT", $_POST['icon_9']);
updata_mysql("EDITOR_ICON_COPY", $_POST['icon_10']);
updata_mysql("EDITOR_ICON_PASTE", $_POST['icon_11']);
updata_mysql("EDITOR_ICON_UNDO", $_POST['icon_12']);
updata_mysql("EDITOR_ICON_REDO", $_POST['icon_13']);
updata_mysql("EDITOR_ICON_BOLD", $_POST['icon_14']);
updata_mysql("EDITOR_ICON_ITALIC", $_POST['icon_15']);
updata_mysql("EDITOR_ICON_UNDER_LINE", $_POST['icon_16']);
updata_mysql("EDITOR_ICON_STRIKE", $_POST['icon_17']);
updata_mysql("EDITOR_ICON_SUPER_SCRIPT", $_POST['icon_18']);
updata_mysql("EDITOR_ICON_SUB_SCRIPT", $_POST['icon_19']);
updata_mysql("EDITOR_ICON_SYMBOL", $_POST['icon_20']);
updata_mysql("EDITOR_ICON_LEFT", $_POST['icon_21']);
updata_mysql("EDITOR_ICON_CENTER", $_POST['icon_22']);
updata_mysql("EDITOR_ICON_RIGHT", $_POST['icon_23']);
updata_mysql("EDITOR_ICON_FULL", $_POST['icon_24']);
updata_mysql("EDITOR_ICON_NUBERING", $_POST['icon_25']);
updata_mysql("EDITOR_ICON_BULLETS", $_POST['icon_26']);
updata_mysql("EDITOR_ICON_INDENT", $_POST['icon_27']);
updata_mysql("EDITOR_ICON_OUTDENT", $_POST['icon_28']);
updata_mysql("EDITOR_ICON_IMAGE", $_POST['icon_29']);
updata_mysql("EDITOR_ICON_COLOR", $_POST['icon_30']);
updata_mysql("EDITOR_ICON_BGCOLOR", $_POST['icon_31']);
updata_mysql("EDITOR_ICON_EX_LINK", $_POST['icon_32']);
updata_mysql("EDITOR_ICON_IN_LINK", $_POST['icon_33']);
updata_mysql("EDITOR_ICON_ASSET", $_POST['icon_34']);
updata_mysql("EDITOR_ICON_TABLE", $_POST['icon_35']);
updata_mysql("EDITOR_ICON_SHOW_BORDER", $_POST['icon_36']);
updata_mysql("EDITOR_ICON_ABSOLUTE", $_POST['icon_37']);
updata_mysql("EDITOR_ICON_CLEAN", $_POST['icon_38']);
updata_mysql("EDITOR_ICON_LINE", $_POST['icon_39']);
updata_mysql("EDITOR_ICON_PROPERTIES", $_POST['icon_40']);
updata_mysql("EDITOR_ICON_WORD", $_POST['icon_41']);

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=option&method=editor">
                           <a href="cp_home.php?mode=option&method=other">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}
 
 
//-----------------------------------------------------------------------------------------------------------------
if($method == "files"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="3" width="80%">
<form method="post" action="cp_home.php?mode=option&method=files&type=insert_data">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>اعدادات الحافظة</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>حجم الحافظة</nobr></td>
		<td class="middle"><input type="text" name="files_max_size" size="10" value="'.$Files_Max_Size.'"><font color="black">&nbsp;بايت&nbsp;&nbsp;/&nbsp;&nbsp;يقابل ('.to_kb($Files_Max_Size).') كيلوبايت</font></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>الحجم الأقصى لكل ملف</nobr></td>
		<td class="middle"><input type="text" name="files_max_allowed" size="10" value="'.$Files_Max_Allowed.'"><font color="black">&nbsp;بايت&nbsp;&nbsp;/&nbsp;&nbsp;يقابل ('.to_kb($Files_Max_Allowed).') كيلوبايت</font></td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</form>
</table>
</center>';
 }

 if($type == "insert_data"){


    if($error != ""){
	                echo'<br><center>
	                <table bordercolor="#ffffff" width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){

updata_mysql("FILES_MAX_SIZE", $_POST['files_max_size']);
updata_mysql("FILES_MAX_ALLOWED", $_POST['files_max_allowed']);

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=option&method=files">
                           <a href="cp_home.php?mode=option&method=files">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}
//-----------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------------------
if($method == "site"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="3" width="80%">
<form method="post" action="cp_home.php?mode=option&method=site&type=insert_data">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>اعدادات الموقع</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>وقت الموقع</nobr></td>
		<td class="middle">
			<select class="insidetitle" name="site_timezone">
			<option value="-12" '.check_select($site_timezone, "-12").'>GMT -12 (إينيوتوك، كوجلانيا)</option>
			<option value="-11" '.check_select($site_timezone, "-11").'>GMT -11 (آسلاندا، سيماوا)</option>
			<option value="-10" '.check_select($site_timezone, "-10").'>GMT -10 (هواي)</option>
			<option value="-9" '.check_select($site_timezone, "-9").'>GMT -9 (ألاسكا)</option>
			<option value="-8" '.check_select($site_timezone, "-8").'>GMT -8 (توقيت المحيد الأطلنتي، كندا، الولايات المتحدة الأمريكية)</option>
			<option value="-7" '.check_select($site_timezone, "-7").'>GMT -7 (توقيت جبال كندا، الولايات المتحدة الأمريكية)</option>
			<option value="-6" '.check_select($site_timezone, "-6").'>GMT -6 (مدينة ميكسيكو)</option>
			<option value="-5" '.check_select($site_timezone, "-5").'>GMT -5 (بوغوتا، ليما)</option>
			<option value="-4" '.check_select($site_timezone, "-4").'>GMT -4 (كركاس، لوباس)</option>
			<option value="-3" '.check_select($site_timezone, "-3").'>GMT -3 (البرازيل، بوينوس آيريس، جورج تاون)</option>
			<option value="-2" '.check_select($site_timezone, "-2").'>GMT -2 (توقيت وسط المحيط الأطلنتي)</option>
			<option value="-1" '.check_select($site_timezone, "-1").'>GMT -1 (أزوريس، كاب فيرد آيسلاندا)</option>
			<option value="0" '.check_select($site_timezone, "0").'>GMT (الدار البيضاء، لندن، لشبونة)</option>
			<option value="1" '.check_select($site_timezone, "1").'>GMT +1 (مدريد، باريس، بروكسيل)</option>
			<option value="2" '.check_select($site_timezone, "2").'>GMT +2 (جنوب أفريقيا)</option>
			<option value="3" '.check_select($site_timezone, "3").'>GMT +3 (مكة المكرمة، الرياض، بغداد، موسكو، سان بيترسبورغ)</option>
			<option value="4" '.check_select($site_timezone, "4").'>GMT +4 (أو ظبي، طهران، باكو)</option>
			<option value="5" '.check_select($site_timezone, "5").'>GMT +5 (كابول، كراشي، اسلام أباد)</option>
			<option value="6" '.check_select($site_timezone, "6").'>GMT +6 (الماتي، دهاكا، كولومبو)</option>
			<option value="7" '.check_select($site_timezone, "7").'>GMT +7 (بانكوك، جكارتا)</option>
			<option value="8" '.check_select($site_timezone, "8").'>GMT +8 (بكين، سنغافورة، هونغ كونغ)</option>
			<option value="9" '.check_select($site_timezone, "9").'>GMT +9 (طوكيو، اوساكا)</option>
			<option value="10" '.check_select($site_timezone, "10").'>GMT +10 (كام، غرب أستراليا)</option>
			<option value="11" '.check_select($site_timezone, "11").'>GMT +11 (مغادان، جزر سلومان، كالدونيا)</option>
			<option value="12" '.check_select($site_timezone, "12").'>GMT +12 (فيجي، كامشاتكا)</option>
			</select>
		</td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</form>
</table>
</center>';
 }

 if($type == "insert_data"){


    if($error != ""){
	                echo'<br><center>
	                <table bordercolor="#ffffff" width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){

updata_mysql("SITE_TIMEZONE", $_POST['site_timezone']);

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=option&method=site">
                           <a href="cp_home.php?mode=option&method=site">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}
//----------------------------------------------------------------------------------------------------------------- 

//-----------------------------------------------------------------------------------------------------------------
if($method == "ip"){

 if($type == ""){

echo'
<script type="text/javascript">
function deleteItem(id){
if(confirm("هل انت متأكد من انك تريد حدف هدا الاي بي من قائمة المحظورين , والسماح له بدخول المنتدى ؟")){
window.location = "cp_home.php?mode=option&method=ip&type=del&id="+id;
}else{
return;
}
}
function get_ip(){
var ipsearch = document.getElementById("ipsearch").value;
window.location="cp_home.php?mode=option&method=ip&ip="+ipsearch;
}
</script>
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="1" width="80%">
<form name="fip" method="post" action="cp_home.php?mode=option&method=ip&type=insert_data">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>اعدادات منع الاي بي</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>منع اي بي جديد</nobr></td>
		<td class="middle">
			<input type="text" name="ip">&nbsp;
			<select class="insidetitle" name="date_unban">
			<option value="always">منع دائم</option>
			<option value="1">يوم</option>
			<option value="2">يومين</option>
			<option value="3">3 ايام</option>
			<option value="4">4 ايام</option>
			<option value="5">5 ايام</option>
			<option value="7">اسبوع</option>
			<option value="14">اسبوعين</option>
			<option value="30">شهر</option>
			<option value="60">شهرين</option>
			<option value="360">سنة</option>
			<option value="720">سنتين</option>
			</select>&nbsp;
			<textarea name="why" style="HEIGHT: 60px;WIDTH: 200px;FONT-WEIGHT: bold;FONT-SIZE: 15px;BACKGROUND: darkseagreen;COLOR: white;FONT-FAMILY: arial"></textarea>
		</td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></form></td>
	</tr>
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>البحث عن اي بي</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list" colspan="2"><nobr>ادخل الاي بي للبحث عن العضو : &nbsp;&nbsp;<input type="text" name="ipsearch" id="ipsearch">&nbsp;&nbsp;<input type="button" value="إدخال بيانات" onclick="get_ip()"></nobr></td>
	</tr>';

                   if($_GET['ip']){
                      $ip = $_GET['ip'];
                      $sql = $mysql->execute("select * from {$mysql->prefix}MEMBERS WHERE M_IP = '$ip' OR M_LAST_IP = '$ip' ");
                               if(mysql_num_rows($sql) == 0){
                                 echo '<tr class="fixed"><td align="center" class="list" colspan="2">لم يتم العثور على اي نتيجة</td></tr>';
                               }else{
                               while($r = mysql_fetch_array($sql)){
                                 echo '<tr class="fixed"><td align="center" class="list" colspan="2">'.link_profile($r['M_NAME'], $r['MEMBER_ID']).'</td></tr>';
                               }                  }
                    }

	echo '<tr class="fixed">
		<td class="cat" colspan="2"><nobr>الاي بي هات الممنوعة</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list" colspan="2">
<table  width="100%">
<tr>
		<td class="optionheader_selected">الاي بي</td>
		<td class="optionheader_selected">تاريخ المنع</td>
		<td class="optionheader_selected">بواسطة</td>
		<td class="optionheader_selected">السبب</td>
		<td class="optionheader_selected">تاريخ ازالة المنع</td>
		<td class="optionheader_selected">&nbsp;</td>
</tr>';
$Sql = $mysql->execute("SELECT * FROM {$mysql->prefix}IP_BAN ORDER BY ID ASC ");
$Num = mysql_num_rows($Sql);
if($Num == 0){
echo '<tr class="fixed">
		<td class="list_center" colspan="6">لم يتم حظر اي بي .</td>
</tr>';
}
if($Num != 0){
while($r = mysql_fetch_array($Sql)){

if($r['DATE_UNBAN'] == '0'){
$un_ban = "<font color=\"red\">منع دائم</font>";
}else{
$un_ban = normal_date($r['DATE_UNBAN']);
}

echo '<tr class="fixed">
		<td class="list_center">'.$r['IP'].'</td>
		<td class="list_center">'.normal_date($r['DATE']).'</td>
		<td class="list_center">'.member_name($r['HWO']).'</td>
		<td class="list_center">'.$r['WHY'].'</td>
		<td class="list_center">'.$un_ban.'</td>
		<td class="list_center"><a href="javascript:deleteItem('.$r['ID'].')">'.icons($icon_trash,"أحذف هذا العضو من هذه القائمة").'</a></td>
</tr>';
}
}
echo '</table>
</td></tr></table>
</center>';
 }

 if($type == "insert_data"){
$ip = $_POST['ip'];
$why = $_POST['why'];
$date_unban = $_POST['date_unban'];
if($date_unban == 'always'){
$date_unban = 0;
}else{
$date_unban = time() + (60 * 60 * 24 * $date_unban);
}

$date = time();

if(!$ip){
$error = "لم تقم بكتابة الاي بي";
}

if(!$why){
$error = "لم تقم بكتابة سبب الحظر";
}

    if($error != ""){
	                echo'<br><center>
	                <table bordercolor="#ffffff" width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){
$mysql->execute("INSERT INTO {$mysql->prefix}IP_BAN SET IP = '$ip',DATE = '$date',WHY = '$why',DATE_UNBAN = '$date_unban',HWO = '$CPMemberID' ", [], __FILE__, __LINE__);

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم حظر الاي بي بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=option&method=ip">
                           <a href="cp_home.php?mode=option&method=ip">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

if($type == "del"){
$mysql->execute("DELETE FROM {$mysql->prefix}IP_BAN WHERE ID = '$id' ");

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم حدف الاي بي بنجاح ..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=option&method=ip">
                           <a href="cp_home.php?mode=option&method=ip">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';

}

}
//----------------------------------------------------------------------------------------------------------------- 
  //-----------------------------------------------------------------------------------------------------------------
if($method == "list_m"){

 if($type == ""){

echo '	<script language="JavaScript" type="text/javascript">
		function submitForm(){
			if(list_option.allowed_members_in_list.value.lenght == 0){
				confirm("يجب أن تدخل عدد الأعضاء بكل قائمة");
			return;
			}
			if(list_option.allowed_members_in_list.value > 20){
				confirm("يجب أن يكون الحد الأقصى لعدد الأعضاء بكل قائمة خاصة أصغر أو يساوي 20");
			return;
			}
			if(list_option.allowed_members_in_forum_list.value.lenght == 0){
				confirm("يجب أن تدخل عدد الأعضاء بكل قائمة");
			return;
			}
			if(list_option.allowed_members_in_forum_list.value > 60){
				confirm("يجب أن يكون الحد الأقصى لعدد الأعضاء بكل قائمة إشرافية أصغر أو يساوي 60");
			return;
			}
		list_option.submit();
		}
	</script>
	<center>
	<table class="grid" border="0" cellspacing="1" cellpadding="3" width="80%">
	<form name="list_option" method="post" action="cp_home.php?mode=option&method=list_m&type=insert_data">
		<tr class="fixed">
			<td class="cat" colspan="2"><nobr>اعدادات القوائم الخاصة للأعضاء</nobr></td>
		</tr>
	 	<tr class="fixed">
			<td class="list" width="30%"><nobr>عدد القوائم الخاصة المسموح للأعضاء بإضافتها</nobr></td>
			<td class="list">
				<select class="insidetitle" name="member_allowed_lists">';

                                                                            for($i=3;$i<16;$i++){
					echo '<option value="'.$i.'" '.check_select($max_list_cat_members,$i).'>'.$i.'</option>';
                                                                            }

				echo '</select>
			</td>
		</tr>
	 	<tr class="fixed">
			<td class="list"><nobr>الحد الأقصى لعدد الأعضاء بكل قائمة خاصة</nobr></td>
			<td class="list"><input class="small" type="text" size="1" name="allowed_members_in_list" value="'.$max_list_m_members.'"></td>
		</tr>
		<tr class="fixed">
			<td class="cat" colspan="2"><nobr>اعدادات قوائم الأعضاء للمشرفين</nobr></td>
		</tr>
	 	<tr class="fixed">
			<td class="list" width="30%"><nobr>عدد القوائم المسموح للمشرف بإضافتها</nobr></td>
			<td class="list">
				<select class="insidetitle" name="forum_allowed_lists">';

                                                                            for($i=3;$i<16;$i++){
					echo '<option value="'.$i.'" '.check_select($max_list_cat_moderators,$i).'>'.$i.'</option>';
                                                                            }

				echo '</select>
			</td>
		</tr>
	 	<tr class="fixed">
			<td class="list"><nobr>الحد الأقصى لعدد الأعضاء بكل قائمة خاصة</nobr></td>
			<td class="list"><input class="small" type="text" size="1" name="allowed_members_in_forum_list" value="'.$max_list_m_moderators.'"></td>
		</tr>
	 	<tr class="fixed">
			<td align="middle" colspan="3"><input type="button" value="إدخال بيانات" onclick="submitForm();">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
		</tr>
	</form>
	</table>
	</center>';

}

 if($type == "insert_data"){

updata_mysql("MAX_LIST_CAT_MEMBERS", $_POST['member_allowed_lists']);
updata_mysql("MAX_LIST_M_MEMBERS", $_POST['allowed_members_in_list']);
updata_mysql("MAX_LIST_CAT_MODERATORS", $_POST['forum_allowed_lists']);
updata_mysql("MAX_LIST_M_MODERATORS", $_POST['allowed_members_in_forum_list']);

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل البيانات بنجاح ..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=option&method=list_m">
                           <a href="cp_home.php?mode=option&method=list_m">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';

}

}


  //-----------------------------------------------------------------------------------------------------------------
}
else {
    go_to("index.php");
}
?>
