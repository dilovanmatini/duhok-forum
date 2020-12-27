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


if($type == "stars"){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=ranks&type=insert_stars">

	<tr class="fixed">
		<td class="cat" colspan="3"><nobr>أوصاف افتراضي وعدد ردوده</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>المدير</nobr></td>
		<td class="middle" colspan="2"><input type="text" name="title_13" size="10" value="'.$Title[13].'"><br>
<input type="text" name="title_female_13" size="10" value="'.$Title_Female[13].'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>مراقب</nobr></td>
		<td class="middle" colspan="2"><input type="text" name="title_12" size="10" value="'.$Title[12].'"><br>
<input type="text" name="title_female_12" size="10" value="'.$Title_Female[12].'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>مشرف</nobr></td>
		<td class="middle" colspan="2"><input type="text" name="title_11" size="10" value="'.$Title[11].'"><br>
<input type="text" name="title_female_11" size="10" value="'.$Title_Female[11].'"></td>
	</tr>
	<tr class="fixed">
		<td class="list"><nobr>بلا نجوم</nobr></td>
		<td class="middle"><input type="text" name="star_0" size="10" value="'.$StarsNomber[0].'"></td>
        <td class="middle"><input type="text" name="title_0" size="10" value="'.$Title[0].'"><br>
<input type="text" name="title_female_0" size="10" value="'.$Title_Female[0].'"></td>
	</tr>
	<tr class="fixed">
		<td class="list"><nobr>النجمة الاولى</nobr></td>
		<td class="middle"><input type="text" name="star_1" size="10" value="'.$StarsNomber[1].'"></td>
		<td class="middle"><input type="text" name="title_1" size="10" value="'.$Title[1].'"><br>
<input type="text" name="title_female_1" size="10" value="'.$Title_Female[1].'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>النجمة الثانية</nobr></td>
		<td class="middle"><input type="text" name="star_2" size="10" value="'.$StarsNomber[2].'"></td>
		<td class="middle"><input type="text" name="title_2" size="10" value="'.$Title[2].'"><br>
<input type="text" name="title_female_2" size="10" value="'.$Title_Female[2].'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>الثالثة</nobr></td>
		<td class="middle"><input type="text" name="star_3" size="10" value="'.$StarsNomber[3].'"></td>
        <td class="middle"><input type="text" name="title_3" size="10" value="'.$Title[3].'"><br>
<input type="text" name="title_female_3" size="10" value="'.$Title_Female[3].'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>النجمة الرابعة</nobr></td>
		<td class="middle"><input type="text" name="star_4" size="10" value="'.$StarsNomber[4].'"></td>
        <td class="middle"><input type="text" name="title_4" size="10" value="'.$Title[4].'"><br>
<input type="text" name="title_female_4" size="10" value="'.$Title_Female[4].'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>النجمة الخامسة</nobr></td>
		<td class="middle"><input type="text" name="star_5" size="10" value="'.$StarsNomber[5].'"></td>
        <td class="middle"><input type="text" name="title_5" size="10" value="'.$Title[5].'"><br>
<input type="text" name="title_female_5" size="10" value="'.$Title_Female[5].'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>النجمة السادسة</nobr></td>
		<td class="middle"><input type="text" name="star_6" size="10" value="'.$StarsNomber[6].'"></td>
        <td class="middle"><input type="text" name="title_6" size="10" value="'.$Title[6].'"><br>
<input type="text" name="title_female_6" size="10" value="'.$Title_Female[6].'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>النجمة السابعة</nobr></td>
		<td class="middle"><input type="text" name="star_7" size="10" value="'.$StarsNomber[7].'"></td>
        <td class="middle"><input type="text" name="title_7" size="10" value="'.$Title[7].'"><br>
<input type="text" name="title_female_7" size="10" value="'.$Title_Female[7].'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>النجمة الثامنة</nobr></td>
		<td class="middle"><input type="text" name="star_8" size="10" value="'.$StarsNomber[8].'"></td>
        <td class="middle"><input type="text" name="title_8" size="10" value="'.$Title[8].'"><br>
<input type="text" name="title_female_8" size="10" value="'.$Title_Female[8].'"></td>
	</tr>
  	<tr class="fixed">
		<td class="list"><nobr>النجمة التاسعة</nobr></td>
		<td class="middle"><input type="text" name="star_9" size="10" value="'.$StarsNomber[9].'"></td>
        <td class="middle"><input type="text" name="title_9" size="10" value="'.$Title[9].'"><br>
<input type="text" name="title_female_9" size="10" value="'.$Title_Female[9].'"></td>
	</tr>
  	<tr class="fixed">
		<td class="list"><nobr>النجمة العاشرة</nobr></td>
		<td class="middle"><input type="text" name="star_10" size="10" value="'.$StarsNomber[10].'"></td>
        <td class="middle"><input type="text" name="title_10" size="10" value="'.$Title[10].'"><br>
<input type="text" name="title_female_10" size="10" value="'.$Title_Female[10].'"></td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="3"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</form>
</table>
</center><br><br>';
}

if($type == "insert_stars"){

$Stars_Value = Array (
$_POST["star_0"],
$_POST["star_1"],
$_POST["star_2"],
$_POST["star_3"],
$_POST["star_4"],
$_POST["star_5"],
$_POST["star_6"],
$_POST["star_7"],
$_POST["star_8"],
$_POST["star_9"],
$_POST["star_10"]
);

$Title_Value = Array (
$_POST["title_0"],
$_POST["title_1"],
$_POST["title_2"],
$_POST["title_3"],
$_POST["title_4"],
$_POST["title_5"],
$_POST["title_6"],
$_POST["title_7"],
$_POST["title_8"],
$_POST["title_9"],
$_POST["title_10"],
$_POST["title_11"],
$_POST["title_12"],
$_POST["title_13"]
);

$Title_Female_Value = Array (
$_POST["title_female_0"],
$_POST["title_female_1"],
$_POST["title_female_2"],
$_POST["title_female_3"],
$_POST["title_female_4"],
$_POST["title_female_5"],
$_POST["title_female_6"],
$_POST["title_female_7"],
$_POST["title_female_8"],
$_POST["title_female_9"],
$_POST["title_female_10"],
$_POST["title_female_11"],
$_POST["title_female_12"],
$_POST["title_female_13"]
);

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

updata_mysql("STARS_NUMBER_0", $Stars_Value[0]);
updata_mysql("STARS_NUMBER_1", $Stars_Value[1]);
updata_mysql("STARS_NUMBER_2", $Stars_Value[2]);
updata_mysql("STARS_NUMBER_3", $Stars_Value[3]);
updata_mysql("STARS_NUMBER_4", $Stars_Value[4]);
updata_mysql("STARS_NUMBER_5", $Stars_Value[5]);
updata_mysql("STARS_NUMBER_6", $Stars_Value[6]);
updata_mysql("STARS_NUMBER_7", $Stars_Value[7]);
updata_mysql("STARS_NUMBER_8", $Stars_Value[8]);
updata_mysql("STARS_NUMBER_9", $Stars_Value[9]);
updata_mysql("STARS_NUMBER_10", $Stars_Value[10]);

updata_mysql("TITLE_0", $Title_Value[0]);
updata_mysql("TITLE_1", $Title_Value[1]);
updata_mysql("TITLE_2", $Title_Value[2]);
updata_mysql("TITLE_3", $Title_Value[3]);
updata_mysql("TITLE_4", $Title_Value[4]);
updata_mysql("TITLE_5", $Title_Value[5]);
updata_mysql("TITLE_6", $Title_Value[6]);
updata_mysql("TITLE_7", $Title_Value[7]);
updata_mysql("TITLE_8", $Title_Value[8]);
updata_mysql("TITLE_9", $Title_Value[9]);
updata_mysql("TITLE_10", $Title_Value[10]);
updata_mysql("TITLE_11", $Title_Value[11]);
updata_mysql("TITLE_12", $Title_Value[12]);
updata_mysql("TITLE_13", $Title_Value[13]);

updata_mysql("TITLE_0_FEMALE", $Title_Female_Value[0]);
updata_mysql("TITLE_1_FEMALE", $Title_Female_Value[1]);
updata_mysql("TITLE_2_FEMALE", $Title_Female_Value[2]);
updata_mysql("TITLE_3_FEMALE", $Title_Female_Value[3]);
updata_mysql("TITLE_4_FEMALE", $Title_Female_Value[4]);
updata_mysql("TITLE_5_FEMALE", $Title_Female_Value[5]);
updata_mysql("TITLE_6_FEMALE", $Title_Female_Value[6]);
updata_mysql("TITLE_7_FEMALE", $Title_Female_Value[7]);
updata_mysql("TITLE_8_FEMALE", $Title_Female_Value[8]);
updata_mysql("TITLE_9_FEMALE", $Title_Female_Value[9]);
updata_mysql("TITLE_10_FEMALE", $Title_Female_Value[10]);
updata_mysql("TITLE_11_FEMALE", $Title_Female_Value[11]);
updata_mysql("TITLE_12_FEMALE", $Title_Female_Value[12]);
updata_mysql("TITLE_13_FEMALE", $Title_Female_Value[13]);


                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=ranks&type=stars">
                           <a href="cp_home.php?mode=option">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}

}


if($type == "colors"){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=ranks&type=insert_colors">

	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>ألون نجوم حسب رتب</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>المدير</nobr></td>
		<td class="middle">'.
icons("./".$Stars["blue"], "", "").'&nbsp;<input type="radio" name="color_4" value="blue" '.check_radio($StarsColor[4], "blue").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["bronze"], "", "").'&nbsp;<input type="radio" name="color_4" value="bronze" '.check_radio($StarsColor[4], "bronze").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["cyan"], "", "").'&nbsp;<input type="radio" name="color_4" value="cyan" '.check_radio($StarsColor[4], "cyan").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["gold"], "", "").'&nbsp;<input type="radio" name="color_4" value="gold" '.check_radio($StarsColor[4], "gold").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["green"], "", "").'&nbsp;<input type="radio" name="color_4" value="green" '.check_radio($StarsColor[4], "green").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["orange"], "", "").'&nbsp;<input type="radio" name="color_4" value="orange" '.check_radio($StarsColor[4], "orange").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["purple"], "", "").'&nbsp;<input type="radio" name="color_4" value="purple" '.check_radio($StarsColor[4], "purple").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["red"], "", "").'&nbsp;<input type="radio" name="color_4" value="red" '.check_radio($StarsColor[4], "red").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["silver"], "", "").'&nbsp;<input type="radio" name="color_4" value="silver" '.check_radio($StarsColor[4], "silver").'>
        </td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>مراقب</nobr></td>
		<td class="middle">'.
icons("./".$Stars["blue"], "", "").'&nbsp;<input type="radio" name="color_3" value="blue" '.check_radio($StarsColor[3], "blue").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["bronze"], "", "").'&nbsp;<input type="radio" name="color_3" value="bronze" '.check_radio($StarsColor[3], "bronze").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["cyan"], "", "").'&nbsp;<input type="radio" name="color_3" value="cyan" '.check_radio($StarsColor[3], "cyan").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["gold"], "", "").'&nbsp;<input type="radio" name="color_3" value="gold" '.check_radio($StarsColor[3], "gold").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["green"], "", "").'&nbsp;<input type="radio" name="color_3" value="green" '.check_radio($StarsColor[3], "green").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["orange"], "", "").'&nbsp;<input type="radio" name="color_3" value="orange" '.check_radio($StarsColor[3], "orange").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["purple"], "", "").'&nbsp;<input type="radio" name="color_3" value="purple" '.check_radio($StarsColor[3], "purple").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["red"], "", "").'&nbsp;<input type="radio" name="color_3" value="red" '.check_radio($StarsColor[3], "red").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["silver"], "", "").'&nbsp;<input type="radio" name="color_3" value="silver" '.check_radio($StarsColor[3], "silver").'>
        </td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>مشرف</nobr></td>
		<td class="middle">'.
icons("./".$Stars["blue"], "", "").'&nbsp;<input type="radio" name="color_2" value="blue" '.check_radio($StarsColor[2], "blue").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["bronze"], "", "").'&nbsp;<input type="radio" name="color_2" value="bronze" '.check_radio($StarsColor[2], "bronze").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["cyan"], "", "").'&nbsp;<input type="radio" name="color_2" value="cyan" '.check_radio($StarsColor[2], "cyan").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["gold"], "", "").'&nbsp;<input type="radio" name="color_2" value="gold" '.check_radio($StarsColor[2], "gold").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["green"], "", "").'&nbsp;<input type="radio" name="color_2" value="green" '.check_radio($StarsColor[2], "green").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["orange"], "", "").'&nbsp;<input type="radio" name="color_2" value="orange" '.check_radio($StarsColor[2], "orange").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["purple"], "", "").'&nbsp;<input type="radio" name="color_2" value="purple" '.check_radio($StarsColor[2], "purple").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["red"], "", "").'&nbsp;<input type="radio" name="color_2" value="red" '.check_radio($StarsColor[2], "red").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["silver"], "", "").'&nbsp;<input type="radio" name="color_2" value="silver" '.check_radio($StarsColor[2], "silver").'>
        </td>
	</tr>
	<tr class="fixed">
		<td class="list"><nobr>عضو</nobr></td>
		<td class="middle">'.
icons("./".$Stars["blue"], "", "").'&nbsp;<input type="radio" name="color_1" value="blue" '.check_radio($StarsColor[1], "blue").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["bronze"], "", "").'&nbsp;<input type="radio" name="color_1" value="bronze" '.check_radio($StarsColor[1], "bronze").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["cyan"], "", "").'&nbsp;<input type="radio" name="color_1" value="cyan" '.check_radio($StarsColor[1], "cyan").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["gold"], "", "").'&nbsp;<input type="radio" name="color_1" value="gold" '.check_radio($StarsColor[1], "gold").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["green"], "", "").'&nbsp;<input type="radio" name="color_1" value="green" '.check_radio($StarsColor[1], "green").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["orange"], "", "").'&nbsp;<input type="radio" name="color_1" value="orange" '.check_radio($StarsColor[1], "orange").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["purple"], "", "").'&nbsp;<input type="radio" name="color_1" value="purple" '.check_radio($StarsColor[1], "purple").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["red"], "", "").'&nbsp;<input type="radio" name="color_1" value="red" '.check_radio($StarsColor[1], "red").'>&nbsp;&nbsp;|&nbsp;&nbsp;'.
icons("./".$Stars["silver"], "", "").'&nbsp;<input type="radio" name="color_1" value="silver" '.check_radio($StarsColor[1], "silver").'>
        </td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="حفظ الاختيار">&nbsp;&nbsp;&nbsp;<input type="reset" value="رجوع الى اختيار الاصلي"></td>
	</tr>
</form>
</table>
</center><br><br>';
}

if($type == "insert_colors"){


$Colors_1 = $_POST["color_1"];
$Colors_2 = $_POST["color_2"];
$Colors_3 = $_POST["color_3"];
$Colors_4 = $_POST["color_4"];


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

updata_mysql("MLV_STARS_COLOR_1", $Colors_1);
updata_mysql("MLV_STARS_COLOR_2", $Colors_2);
updata_mysql("MLV_STARS_COLOR_3", $Colors_3);
updata_mysql("MLV_STARS_COLOR_4", $Colors_4);


                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=ranks&type=colors">
                           <a href="cp_home.php?mode=option">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}

}

if($type == "group"){



echo'
<script type="text/javascript" src="admin/colors.js"></script>
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="40%">
<form method="post" action="cp_home.php?mode=ranks&type=insert_group">

	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>الوان المجموعات</nobr></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>الادارة</nobr></td>
<td class="middle" align="center">
				<script language="javascript" type="text/javascript">
					document.write(color_palette("'.$color_4.'",4));
				</script>
<input type="hidden" name="g4" id="g4" value="'.$color_4.'">
</td>
	</tr>
 	<tr class="fixed">
		<td  class="list"><nobr>المراقبين</nobr></td>
<td class="middle" align="center">
				<script language="javascript" type="text/javascript">
					document.write(color_palette("'.$color_3.'",3));
				</script>
<input type="hidden" name="g3" id="g3" value="'.$color_3.'">
</td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>المشرفين</nobr></td>
<td class="middle" align="center">
				<script language="javascript" type="text/javascript">
					document.write(color_palette("'.$color_2.'",2));
				</script>
<input type="hidden" name="g2" id="g2" value="'.$color_2.'">
</td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>الاعضاء</nobr></td>
<td class="middle" align="center">
				<script language="javascript" type="text/javascript">
					document.write(color_palette("'.$color_1.'",1));
				</script>
<input type="hidden" name="g1" id="g1" value="'.$color_1.'">
</td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>المحظورين</nobr></td>
<td class="middle" align="center">
				<script language="javascript" type="text/javascript">
					document.write(color_palette("'.$color_0.'",0));
				</script>
<input type="hidden" name="g0" id="g0" value="'.$color_0.'">
</td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="حفظ الاختيار">&nbsp;&nbsp;&nbsp;<input type="reset" value="رجوع الى اختيار الاصلي"></td>
	</tr>
</form>
</table></center>';


}

if($type == "insert_group"){

updata_mysql("COLOR_0", $_POST['g0']);
updata_mysql("COLOR_1", $_POST['g1']);
updata_mysql("COLOR_2", $_POST['g2']);
updata_mysql("COLOR_3", $_POST['g3']);
updata_mysql("COLOR_4", $_POST['g4']);

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=ranks&type=group">
                           <a href="cp_home.php?mode=option">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}


}
else {
    go_to("index.php");
}

?>
