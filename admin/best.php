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
<table class="grid" border="0" cellspacing="1" cellpadding="3" width="98%">
<form method="post" action="cp_home.php?mode=best&type=insert_data">
		<td class="cat" colspan="4"><nobr>اعدادات التميز</nobr></td>
	</tr>
	 <tr class="fixed">
	 </td><td class="list"><nobr>وصف الخاصية</nobr>
	  <td class="userdetails_data"><input type="text" name="best_t" size="40" value="'.$best_t.'">
	  <td class="list"><nobr>تشغيل الخاصية</nobr></td>
	  <td class="userdetails_data"><input type="radio" value="1" name="best" '.check_radio($best, "1").'>لا&nbsp;&nbsp;
    	<input type="radio" value="0" name="best" '.check_radio($best, "0").'>نعم</td>
	</tr>
	 	<tr class="fixed">
		<td class="list"><nobr>وصف العضو المميز</nobr>
		<td class="list"><input type="text" name="best_mem_t" size="40" value="'.$best_mem_t.'">
		<td class="list"><nobr>رقم عضوية العضو المميز</nobr>
		<td class="list"><input type="text" name="best_mem" size="10" value="'.$best_mem.'">

	</tr>
	 	<tr class="fixed">
		<td class="list"><nobr>وصف الموضوع المميز</nobr></td>
		<td class="middle"><input type="text" name="best_topic_t" size="40" value="'.$best_topic_t.'">
				<td class="list"><nobr>رقم الموضوع المميز</nobr></td>
		<td class="middle"><input type="text" name="best_topic" size="10" value="'.$best_topic.'">
	</tr>
	 	<tr class="fixed">
		<td class="list"><nobr>وصف المشرف المميز</nobr></td>
		<td class="middle"><input type="text" name="best_mod_t" size="40" value="'.$best_mod_t.'">
				<td class="list"><nobr>رقم المشرف المميز</nobr></td>
		<td class="middle"><input type="text" name="best_mod" size="10" value="'.$best_mod.'">
	</tr>
	 	<tr class="fixed">
		<td class="list"><nobr>وصف المنتدى المميز</nobr></td>
		<td class="middle"><input type="text" name="best_frm_t" size="40" value="'.$best_frm_t.'">
			<td class="list"><nobr>رقم المنتدى المميز</nobr></td>
		<td class="middle"><input type="text" name="best_frm" size="10" value="'.$best_frm.'">
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
updata_mysql("BEST", $_POST['best']);
updata_mysql("BEST_MEM", $_POST['best_mem']);
updata_mysql("BEST_TOPIC", $_POST['best_topic']);
updata_mysql("BEST_MOD", $_POST['best_mod']);
updata_mysql("BEST_FRM", $_POST['best_frm']);

updata_mysql("BEST_T", $_POST['best_t']);
updata_mysql("BEST_MEM_T", $_POST['best_mem_t']);
updata_mysql("BEST_TOPIC_T", $_POST['best_topic_t']);
updata_mysql("BEST_MOD_T", $_POST['best_mod_t']);
updata_mysql("BEST_FRM_T", $_POST['best_frm_t']);


                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=cp_home.php?mode=best">
                           <a href="cp_home.php?mode=best">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
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
