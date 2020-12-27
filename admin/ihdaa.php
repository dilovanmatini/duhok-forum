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

 if($type == ""){

echo'
<script type="text/javascript" src="'.$admin_folder.'/colors.js"></script>

<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=special&type=insert">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>تعديل خصائص الإهدائات</nobr></td>
	</tr>
	<tr class="fixed">
		<td class="list">تشغيل شريط الإهدائات</td>
		<td class="userdetails_data"><input type="radio" value="1" name="WHAT_ACTIVE" '.check_radio($WHAT_ACTIVE, "1").'>نعم&nbsp;&nbsp;
        <input type="radio" value="0" name="WHAT_ACTIVE" '.check_radio($WHAT_ACTIVE, "0").'>لا</td>
	 	<tr class="fixed">
		<td class="list"><nobr>الكتابة بالشريط</nobr></td>
		<td class="middle"><input type="text"  name="WHAT_TITLE" size="50" value="'.$WHAT_TITLE.'"></td>
	</tr>
		</tr>
		<tr class="fixed">
		<td class="list">حجم الكتابة</td>
				<td class="middle"><input type="text"  name="WHAT_ADMIN_SHOW" size="50" value="'.$WHAT_ADMIN_SHOW.'"></td>

		</tr>
	<tr class="fixed">
		<td class="list"> عدد مشاركات العضو <br> لإضافة الإهدائات</td>
		<td class="middle"><input type="text"  name="WHAT_LIMIT" size="50" value="'.$WHAT_LIMIT.'"></td>
	</tr>
	<tr class="fixed">
		<td class="list">الفاصلة بين المواضيع</td>
		<td class="middle"><input type="text"  name="WHAT_FASEL" size="50" value="'.$WHAT_FASEL.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>لون الفاصلة</nobr></td>
<td class="middle" align="center">
				<script language="javascript" type="text/javascript">
					document.write(color_palette("'.$WHAT_COLOR.'",0));
				</script>
<input type="hidden" name="g0"  id="g0" value="'.$WHAT_COLOR.'">
	<tr class="fixed">
		<td class="list"><nobr>طريقة العرض</nobr></td>
					<td>
					<select '.$WHAT_DIRECTION.' class="insidetitle" style="WIDTH: 200px" name="WHAT_DIRECTION" type="text">';
                    $selected = $WHAT_DIRECTION;
 echo'
					<option value="right" '.check_select($selected, "right").'>من اليمين إلى اليسار</option>
					<option value="left" '.check_select($selected, "left").'>من اليسار إلى اليمين </option>';
										echo'</select></td>
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

updata_mysql("WHAT_ACTIVE", $_POST['WHAT_ACTIVE']);
updata_mysql("WHAT_TITLE", $_POST['WHAT_TITLE']);
updata_mysql("WHAT_ADMIN_SHOW", $_POST['WHAT_ADMIN_SHOW']);
updata_mysql("WHAT_LIMIT", $_POST['WHAT_LIMIT']);
updata_mysql("WHAT_FASEL", $_POST['WHAT_FASEL']);
updata_mysql("WHAT_COLOR", $_POST['g0']);
updata_mysql("WHAT_DIRECTION", $_POST['WHAT_DIRECTION']);


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
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=special">
                           <a href="cp_home.php?mode=special">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }
 }



else {
    go_to("index.php");
}
?>
