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
if($method == "close"){
 if($type == ""){
echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=close&method=close&type=insert_data">
		<td class="cat" colspan="2"><nobr>وضعية المنتدى</nobr></td>	
		    <tr class="fixed">
		<td class="list"><nobr>وضيعة المنتدى</nobr></td>
		<td class="userdetails_data"><input type="radio" value="1" name="forum_status" '.check_radio($forum_status, "1").'>مقفل&nbsp;&nbsp;
        <input type="radio" value="0" name="forum_status" '.check_radio($forum_status, "0").'>مفتوح</td>
	</tr>
	 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</form>
</table>
</center>';
 }

 if($type == "insert_data"){

$Admin_ForumStatus = $_POST["forum_status"];
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
updata_mysql("FORUM_STATUS", $Admin_ForumStatus);


                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=close&method=close">
                           <a href="cp_home.php?mode=close&method=close">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }
 }
if($method == "msg"){
 if($type == ""){
echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="1" width="80%">
<form method="post" action="cp_home.php?mode=close&method=msg&type=insert_data">
		<td class="cat" colspan="2"><nobr>رسالة قفل المنتدى</nobr></td>	
	</tr>

<tr class="fixed">
<td class="list"><nobr>الرسالة</nobr></td>
			<td class="middle">
<textarea name="close" style="HEIGHT:169;WIDTH: 646;FONT-WEIGHT: bold;FONT-SIZE: 15px;BACKGROUND: darkseagreen;COLOR: #000000;FONT-FAMILY: Times New Roman" cols="1" rows="999">'.$close.'</textarea></td>
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
updata_mysql("close", $_POST['close']);

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=close&method=msg">
                           <a href="cp_home.php?mode=close&method=msg">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }
 }
 }
?>