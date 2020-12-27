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
<center>

<table class="grid" border="0" cellspacing="1" cellpadding="2" width="96%">
<form method="post" action="cp_home.php?mode=ads&type=insert_data">
	<tr class="fixed">
		<td class="cat" colspan="8"><nobr>اعدادات الإشهار عـ 01 ــدد</nobr></td>
			</tr>
				<td class="optionheader_selected" colspan="8"><nobr>هذا الإشهار سيظهر بالصفحة الرئيسية للمنتدى فقط</nobr></td>
	</tr>
	    <tr class="fixed">
		<td class="list"><nobr>تفعيل الخاصية</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="ad" '.check_radio($ad, "1").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="0" name="ad" '.check_radio($ad, "0").'>لا
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>رابط صورة الإشهار</nobr></td>
		<td class="list" colspan="5"><input type="text" name="ad3" size="60" value="'.$ad3.'">
	</tr>

 	<tr class="fixed">
		<td class="list"><nobr>وصلة الإعلان</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="ad1" size="60" value="'.$ad1.'"></td>
	</tr>

 	<tr class="fixed">
		<td class="list"><nobr>إسم الوصلة</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="ad2" size="60" value="'.$ad2.'">
	</tr>
	 	<tr class="fixed">
		<td class="list"><nobr>الطول</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="ad4" size="60" value="'.$ad4.'"></td>
	</tr>
	 	<tr class="fixed">
		<td class="list"><nobr>العرض</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="ad5" size="60" value="'.$ad5.'"></td>
	</tr>';
	    echo'
<tr class="fixed">
		<td class="userdetails_data"><nobr>الموقع</nobr></td>
		<td class="userdetails_data"><select class="insidetitle" name="ad6" size="1">
			<option value="left" '.check_select($ad6, "left").'>اليسار</option>
			<option value="center" '.check_select($ad6, "center").'>الوسط</option>
			<option value="right" '.check_select($ad6, "right").'>اليمين</option>
	</select></td>
	</tr>
		<tr class="fixed">
		<td class="cat" colspan="8"><nobr>اعدادات الإشهار عـ 02 ــدد</nobr></td>
					</tr>
				<td class="optionheader_selected" colspan="8"><nobr>هذا الإشهار سيظهر بالمنتديات فقط</nobr></td>

	</tr>
	    <tr class="fixed">
		<td class="list"><nobr>تفعيل الخاصية</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="pb" '.check_radio($pb, "1").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="0" name="pb" '.check_radio($pb, "0").'>لا
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>رابط صورة الإشهار</nobr></td>
		<td class="list" colspan="5"><input type="text" name="pb3" size="60" value="'.$pb3.'">
	</tr>

 	<tr class="fixed">
		<td class="list"><nobr>وصلة الإعلان</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="pb1" size="60" value="'.$pb1.'"></td>
	</tr>

 	<tr class="fixed">
		<td class="list"><nobr>إسم الوصلة</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="pb2" size="60" value="'.$pb2.'">
	</tr>
	 	<tr class="fixed">
		<td class="list"><nobr>الطول</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="pb4" size="60" value="'.$pb4.'"></td>
	</tr>
	 	<tr class="fixed">
		<td class="list"><nobr>العرض</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="pb5" size="60" value="'.$pb5.'"></td>
	</tr>';
	    echo'
<tr class="fixed">
		<td class="userdetails_data"><nobr>الموقع</nobr></td>
		<td class="userdetails_data"><select class="insidetitle" name="pb6" size="1">
			<option value="left" '.check_select($pb6, "left").'>اليسار</option>
			<option value="center" '.check_select($pb6, "center").'>الوسط</option>
			<option value="right" '.check_select($pb6, "right").'>اليمين</option>
	</select></td>
	</tr>
		<td class="cat" colspan="8"><nobr>اعدادات الإشهار عـ 03 ــدد</nobr></td>
					</tr>
				<td class="optionheader_selected" colspan="8"><nobr>هذا الإشهار سيظهر بالمواضيع من أعلى</nobr></td>

	    <tr class="fixed">
		<td class="list"><nobr>تفعيل الخاصية</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="pub" '.check_radio($pub, "1").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="0" name="pub" '.check_radio($pub, "0").'>لا
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>رابط صورة الإشهار</nobr></td>
		<td class="list" colspan="5"><input type="text" name="pub3" size="60" value="'.$pub3.'">
	</tr>

 	<tr class="fixed">
		<td class="list"><nobr>وصلة الإعلان</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="pub1" size="60" value="'.$pub1.'"></td>
	</tr>

 	<tr class="fixed">
		<td class="list"><nobr>إسم الوصلة</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="pub2" size="60" value="'.$pub2.'">
	</tr>
	 	<tr class="fixed">
		<td class="list"><nobr>الطول</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="pub4" size="60" value="'.$pub4.'"></td>
	</tr>
	 	<tr class="fixed">
		<td class="list"><nobr>العرض</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="pub5" size="60" value="'.$pub5.'"></td>
	</tr>';
	    echo'
<tr class="fixed">
		<td class="userdetails_data"><nobr>الموقع</nobr></td>
		<td class="userdetails_data"><select class="insidetitle" name="pub6" size="1">
			<option value="left" '.check_select($pub6, "left").'>اليسار</option>
			<option value="center" '.check_select($pub6, "center").'>الوسط</option>
			<option value="right" '.check_select($pub6, "right").'>اليمين</option>
	</select></td>
	</tr>

		<td class="cat" colspan="8"><nobr>اعدادات الإشهار عـ 04 ــدد</nobr></td>
					</tr>
				<td class="optionheader_selected" colspan="8"><nobr>هذا الإشهار سيظهر بالمواضيع من أسفل</nobr></td>

	    <tr class="fixed">
		<td class="list"><nobr>تفعيل الخاصية</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="pubs" '.check_radio($pubs, "1").'>نعم&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="0" name="pubs" '.check_radio($pubs, "0").'>لا
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>رابط صورة الإشهار</nobr></td>
		<td class="list" colspan="5"><input type="text" name="pubs3" size="60" value="'.$pubs3.'">
	</tr>

 	<tr class="fixed">
		<td class="list"><nobr>وصلة الإعلان</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="pubs1" size="60" value="'.$pubs1.'"></td>
	</tr>

 	<tr class="fixed">
		<td class="list"><nobr>إسم الوصلة</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="pubs2" size="60" value="'.$pubs2.'">
	</tr>
	 	<tr class="fixed">
		<td class="list"><nobr>الطول</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="pubs4" size="60" value="'.$pubs4.'"></td>
	</tr>
	 	<tr class="fixed">
		<td class="list"><nobr>العرض</nobr></td>
		<td class="middle" colspan="5"><input type="text" name="pubs5" size="60" value="'.$pubs5.'"></td>
	</tr>';
	    echo'
<tr class="fixed">
		<td class="userdetails_data"><nobr>الموقع</nobr></td>
		<td class="userdetails_data"><select class="insidetitle" name="pubs6" size="1">
			<option value="left" '.check_select($pubs6, "left").'>اليسار</option>
			<option value="center" '.check_select($pubs6, "center").'>الوسط</option>
			<option value="right" '.check_select($pubs6, "right").'>اليمين</option>
	</select></td>
	</tr>

 	<tr class="fixed">
		<td align="middle" colspan="8"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
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
	                       <td class="list_center" colSpan="60"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){

updata_mysql("ad", $_POST['ad']);
updata_mysql("ad1", $_POST['ad1']);
updata_mysql("ad2", $_POST['ad2']);
updata_mysql("ad3", $_POST['ad3']);
updata_mysql("ad4", $_POST['ad4']);
updata_mysql("ad5", $_POST['ad5']);
updata_mysql("ad6", $_POST['ad6']);
updata_mysql("pb", $_POST['pb']);
updata_mysql("pb1", $_POST['pb1']);
updata_mysql("pb2", $_POST['pb2']);
updata_mysql("pb3", $_POST['pb3']);
updata_mysql("pb4", $_POST['pb4']);
updata_mysql("pb5", $_POST['pb5']);
updata_mysql("pb6", $_POST['pb6']);
updata_mysql("pub", $_POST['pub']);
updata_mysql("pub1", $_POST['pub1']);
updata_mysql("pub2", $_POST['pub2']);
updata_mysql("pub3", $_POST['pub3']);
updata_mysql("pub4", $_POST['pub4']);
updata_mysql("pub5", $_POST['pub5']);
updata_mysql("pub6", $_POST['pub6']);
updata_mysql("pubs", $_POST['pubs']);
updata_mysql("pubs1", $_POST['pubs1']);
updata_mysql("pubs2", $_POST['pubs2']);
updata_mysql("pubs3", $_POST['pubs3']);
updata_mysql("pubs4", $_POST['pubs4']);
updata_mysql("pubs5", $_POST['pubs5']);
updata_mysql("pubs6", $_POST['pubs6']);

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="60"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=ads">
                           <a href="cp_home.php?mode=ads">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}
