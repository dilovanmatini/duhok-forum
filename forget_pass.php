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

if($type == ""){
echo'
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<center>
		<br>&nbsp;<form method="post" action="index.php?mode=forget_pass&type=insert">
			<table cellSpacing="1" cellPadding="4" bgColor="gray" border="0">
				<tr class="fixed">
					    <td class="optionheader" id="row_subject">لإسترجاع كلمة السر المفقودة <br>أدخل إسمك المسجل في المنتديات<br>وثم إضغط على الزر أدناه: <br>
					<input class="insidetitle" style="WIDTH: 250px" type="text" name="member_name"><br>
					<font size="-1">ملاحظة: يجب ان يكون الاسم مطابقا لسجلاتنا تماما</font></td>
				</tr>
				<tr class="fixed">
					<td class="list_center">
					<input type="submit" value="إطلب كلمة السر"></td>
				</tr>
			</table>
		</form>
		</center>
		</td>
	</tr>
</table>
</center>';

}
if($type == "insert"){

 $member_name = $_POST["member_name"];

 $FP = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE M_NAME = '".$member_name."' ", [], __FILE__, __LINE__);
 $fp_n = mysql_num_rows($FP);
 $fp_r = mysql_fetch_array($FP);
 
 if($fp_n > 0){
 
 $pf_to = $fp_r[M_EMAIL];
 $pf_sub = 'الرسالة من  منتديات '.$forum_title.' - بخصوص نسيان كلمة مرور';
 $pf_msg = 'مرحباً بك :'.$fp_r[M_NAME].'\n';
 $pf_msg .= 'هذه هي كلمة مرور خاصة بك : '.$fp_r[M_PASSWORD].'      md5(M_PASSWORD);  \n';
 $pf_msg .= 'مع تحيات منتديات '.$forum_title;
 $pf_from = $admin_email;
 
 mail($pf_to, $pf_sub, $pf_msg, "From: ".$pf_from);
 
	                echo'
                    <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font color="red"><b><font size="+2" color="red"><br>تم إرسال بريد الكتروني الى عنوانك المسجل لدينا بكلمتك السرية.</font></b></font><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';

 }
 else {

	                echo'
                    <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font color="red"><b><font size="+2" color="red"><br>الإسم الذي أدخلته ليس مسجلا لدينا.<br><br>الرجاء التأكد من الإسم الصحيح من قائمة الأعضاء.</font></b></font><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';

 }
 
 
 
 

}


?>


