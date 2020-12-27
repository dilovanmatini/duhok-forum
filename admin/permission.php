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



if($method == "mon"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=permission&method=mon&type=insert">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>تعديل تراخيص مراقبين</nobr></td>
	</tr>
	<tr class="fixed">
		<td class="list">مراقبة الرسائل</td>
		<td class="userdetails_data"><input type="radio" value="1" name="CAN_SHOW_PM" '.check_radio($CAN_SHOW_PM, "1").'>نعم&nbsp;&nbsp;
        <input type="radio" value="0" name="CAN_SHOW_PM" '.check_radio($CAN_SHOW_PM, "0").'>لا</td>
	<tr class="fixed">
		<td class="list">قفل العضويات</td>
		<td class="userdetails_data"><input type="radio" value="1" name="CAN_CLOSE_M" '.check_radio($CAN_CLOSE_M, "1").'>نعم&nbsp;&nbsp;
        <input type="radio" value="0" name="CAN_CLOSE_M" '.check_radio($CAN_CLOSE_M, "0").'>لا</td>
	</tr>
	<tr class="fixed">
		<td class="list">فتح العضويات</td>
		<td class="userdetails_data"><input type="radio" value="1" name="CAN_OPEN_M" '.check_radio($CAN_OPEN_M, "1").'>نعم&nbsp;&nbsp;
        <input type="radio" value="0" name="CAN_OPEN_M" '.check_radio($CAN_OPEN_M, "0").'>لا</td>
	</tr>
	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
';
echo'
</form>
</table>
</center>';
 }

 if($type == "insert"){

updata_mysql("CAN_SHOW_PM", $_POST['CAN_SHOW_PM']);
updata_mysql("CAN_CLOSE_M", $_POST['CAN_CLOSE_M']);
updata_mysql("CAN_OPEN_M", $_POST['CAN_OPEN_M']);
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

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=permission&method=mon">
                           <a href="cp_home.php?mode=permission&method=mon">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}


if($method == "mod"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=permission&method=mod&type=insert">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>تعديل تراخيص المشرفين</nobr></td>
	</tr>
	<tr class="fixed">
		<td class="list"><nobr>إضافة أوصاف للمنتدى</nobr></td>
		<td class="userdetails_data">
        <input type="radio" value="1" name="mod_add_titles" '.check_radio($mod_add_titles, "1").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" value="0" name="mod_add_titles" '.check_radio($mod_add_titles, "0").'>لا
        </td>
	</tr>
	<tr class="fixed">
		<td class="list"><nobr>إضافة أوسمة للمنتدى</nobr></td>
		<td class="userdetails_data">
        <input type="radio" value="1" name="mod_add_medals" '.check_radio($mod_add_medals, "1").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" value="0" name="mod_add_medals" '.check_radio($mod_add_medals, "0").'>لا
        </td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</form>
</table>
</center>';
 }

 if($type == "insert"){

$mod_add_titles = $_POST["mod_add_titles"];
$mod_add_medals = $_POST["mod_add_medals"];

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

updata_mysql("MOD_ADD_TITLES", $mod_add_titles);
updata_mysql("MOD_ADD_MEDALS", $mod_add_medals);

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=permission&method=mod">
                           <a href="cp_home.php?mode=permission&method=mod">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}

if($method == "mem"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=permission&method=mem&type=insert">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>تعديل تراخيص أعضاء</nobr></td>
	</tr>
	<tr class="fixed">
		<td class="list_center" colspan="2"><br>لا يوجد تراخيص حالياً<br><br></td>
	</tr>';
// 	<tr class="fixed">
//		<td align="middle" colspan="2"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
//	</tr>
echo'
</form>
</table>
</center>';
 }

 if($type == "insert"){

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

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=permission&method=mem">
                           <a href="cp_home.php?mode=permission&method=mem">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}


if($method == "bad"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=permission&method=bad&type=insert">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>تعديل تراخيص أعضاء ممنوعين</nobr></td>
	</tr>
	<tr class="fixed">
		<td class="list_center" colspan="2"><br>لا يوجد تراخيص حالياً<br><br></td>
	</tr>';
// 	<tr class="fixed">
//		<td align="middle" colspan="2"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
//	</tr>
echo'
</form>
</table>
</center>';
 }

 if($type == "insert"){

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

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=permission&method=bad">
                           <a href="cp_home.php?mode=permission&method=bad">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}
 
 
 if($method == "visitor"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=permission&method=visitor&type=insert">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>تعديل تراخيص الزوار</nobr></td>
	</tr>
	<tr class="fixed">
		<td class="list">مشاهدة المنتدى</td>
		<td class="userdetails_data"><input type="radio" value="0" name="CAN_SHOW_FORUM" '.check_radio($CAN_SHOW_FORUM, "0").'>نعم&nbsp;&nbsp;
        <input type="radio" value="1" name="CAN_SHOW_FORUM" '.check_radio($CAN_SHOW_FORUM, "1").'>لا</td>
	</tr>
	<tr class="fixed">
		<td class="list">مشاهدة المواضيع</td>
		<td class="userdetails_data"><input type="radio" value="0" name="CAN_SHOW_TOPIC" '.check_radio($CAN_SHOW_TOPIC, "0").'>نعم&nbsp;&nbsp;
        <input type="radio" value="1" name="CAN_SHOW_TOPIC" '.check_radio($CAN_SHOW_TOPIC, "1").'>لا
&nbsp;&nbsp;
        <input type="radio" value="2" name="CAN_SHOW_TOPIC" '.check_radio($CAN_SHOW_TOPIC, "2").'>جزء من الموضوع
</td>
	</tr>
	<tr class="fixed">
		<td class="list">مشاهدة العضويات</td>
		<td class="userdetails_data"><input type="radio" value="0" name="CAN_SHOW_PROFILE" '.check_radio($CAN_SHOW_PROFILE, "0").'>نعم&nbsp;&nbsp;
        <input type="radio" value="1" name="CAN_SHOW_PROFILE" '.check_radio($CAN_SHOW_PROFILE, "1").'>لا</td>
	</tr>
	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
';
echo'
</form>
</table>
</center>';
 }

 if($type == "insert"){


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

updata_mysql("CAN_SHOW_FORUM", $_POST['CAN_SHOW_FORUM']);
updata_mysql("CAN_SHOW_TOPIC", $_POST['CAN_SHOW_TOPIC']);
updata_mysql("CAN_SHOW_PROFILE", $_POST['CAN_SHOW_PROFILE']);

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=permission&method=visitor">
                           <a href="cp_home.php?mode=permission&method=visitor">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}
 if($method == "new"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=permission&method=new&type=insert">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>تعديل تراخيص الأعضاء الجدد</nobr></td>
	</tr>
	<tr class="fixed">
		<td class="list"><nobr>عدد مشاركات الأعضاء الجدد حتى يشاهدوا مواضيع الأخرين</nobr></td>
		<td class="middle"><input type="text" name="new_member_show_topic" size="10" value="'.$new_member_show_topic.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>عدد مشاركات الأعضاء الجدد حتى يتم رفع الرقابة عنهم</nobr></td>
		<td class="middle"><input type="text" name="new_member_min_posts" size="10" value="'.$new_member_min_posts.'"></td>
	</tr>
	<tr class="fixed">
		<td class="list"><nobr>عدد مشاركات الأعضاء الجدد حتى يسمح لهم بتغير اسمائهم</nobr></td>
		<td class="middle"><input type="text" name="new_member_change_name" size="10" value="'.$new_member_change_name.'">
	</tr>
<tr class="fixed">
		<td class="list"><nobr>عدد مشاركات الأعضاء الجدد حتى يتم رفع رقابة الرسائل عنهم</nobr></td>
		<td class="middle"><input type="text" name="new_member_min_posts_pm" size="10" value="'.$new_member_min_posts_pm.'"></td>
		</tr>
<tr class="fixed">
		<td class="list"><nobr>عدد مشاركات الأعضاء الجدد حتى يتم رفع رقابة البحث عنهم</nobr></td>
		<td class="middle"><input type="text" name="new_member_min_search" size="10" value="'.$new_member_min_search.'"></td>
	</tr>
	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
';
echo'
</form>
</table>
</center>';
 }

 if($type == "insert"){

updata_mysql("NEW_MEMBER_MIN_SEARCH", $_POST['new_member_min_search']);
updata_mysql("NEW_MEMBER_SHOW_TOPIC", $_POST['new_member_show_topic']);
updata_mysql("NEW_MEMBER_CHANGE_NAME", $_POST['new_member_change_name']);
updata_mysql("NEW_MEMBER_MIN_POSTS_PM", $_POST['new_member_min_posts_pm']);
updata_mysql("NEW_MEMBER_MIN_POSTS", $_POST['new_member_min_posts']);
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

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=permission&method=new">
                           <a href="cp_home.php?mode=permission&method=new">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}

 
}
else {
    go_to("index.php");
}
?>
