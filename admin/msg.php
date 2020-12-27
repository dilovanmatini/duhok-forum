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
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=msg&type=insert">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>إعدادات رسالة الترحيب</nobr></td>
	</tr>
	<tr class="fixed">
		<td class="list">تشغيل رسالة الترحيب</td>
		<td class="userdetails_data"><input type="radio" value="1" name="MSG" '.check_radio($MSG, "1").'>نعم&nbsp;&nbsp;
        <input type="radio" value="0" name="MSG" '.check_radio($MSG, "0").'>لا</td>
	 	<tr class="fixed">
		<td class="list"><nobr>الجزء الأول :</nobr></td>
		<td class="middle"><input type="text"  name="FORUM_MSG" size="50" value="'.$FORUM_MSG.'"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;'.$forum_title.'</nobr></td>
		
	</tr>
		</tr>
		<tr class="fixed">
		<td class="list"><nobr>الجزء الثاني :</nobr></td>
				<td class="middle"><input type="text"  name="FORUM_MSG1" size="50" value="'.$FORUM_MSG1.'"></td>

		</tr>
	<tr class="fixed">
		<td class="list"> عدد مشاركات العضو <br> لإضافة الإهدائات</td>
		<td class="middle"><input type="text"  name="FORUM_MSG2" size="50" value="'.$FORUM_MSG2.'"></td>
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
updata_mysql("FORUM_MSG", $_POST['FORUM_MSG']);
updata_mysql("FORUM_MSG1", $_POST['FORUM_MSG1']);
updata_mysql("FORUM_MSG2", $_POST['FORUM_MSG2']);
updata_mysql("MSG", $_POST['MSG']);

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
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=msg">
                           <a href="cp_home.php?mode=msg">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
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
