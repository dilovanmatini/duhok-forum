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

if($err == 1){
    $error = $lang['msg']['erorr_one'];
}
if($err == 2){
    $error = $lang['msg']['erorr_two'];
}
if($err == 3){
    $error = $lang['msg']['erorr_three'];
}
if($err == 4){
    $error = $lang['msg']['erorr_four'];
}
if($err == 5){
    $error = $lang['msg']['erorr_five'];
}
if($err == 6){
    $error = $lang['msg']['erorr_six'];
}
if($err == 7){
    $error = $lang['msg']['erorr_seven'];
}
if($err == 8){
    $error = $lang['msg']['erorr_eight'];
}
if($err == 9){
    $error = $lang['msg']['erorr_nine'];
}
if($err == 10){
    $error = $lang['msg']['erorr_ten'];
}
if($err == 11){
    $error = $lang['msg']['erorr_eleventh'];
}
if($err == 12){
    $error = $lang['msg']['erorr_twelve'];
}
if($err == 13){
    $error = "لا يمكنك المشاركة بأكثر من ".forums("TOTAL_TOPICS", $f)." مواضيع في هذا المنتدى في فترة 24 ساعة.<br>الرجاء المحاولة بعد قليل.";
}
if($err == 14){
    $error = "لا يمكنك المشاركة بأكثر من ".forums("TOTAL_REPLIES", $f)." رد في هذا المنتدى في فترة 24 ساعة.<br>الرجاء المحاولة بعد قليل.";
}
if($err == 15){
    $error = "لقد تم منعك من المشاركة في هذا المنتدى.";
}
if($err == 16){
    $error = "لقد تم منعك من المشاركة في جميع المنتديات.";
}
if($err == 17){
    $error = "لا يمكنك التعديل على هذا الموضوع حاليا<br>لأن الموضوع لم تتم الموفقة عليه للآن.<br><br>الرجاء المحاولة في وقت لاحق.";
}
if($err == 18){
    $error = "لا يمكنك الرد على هذا الموضوع حاليا<br>لأن الموضوع لم تتم الموفقة عليه للآن.<br><br>الرجاء المحاولة في وقت لاحق.";
}
if($err == 19){
    $error = "لا يمكنك الرد على هذا الموضوع حاليا<br>لأن الموضوع تم نقله للارشيف..";
}
if($err == 20){
    $error = "لا يمكن للأعضاء الجدد إستخدام نظام الرسائل الخاصة إلا لإرسال رسائل للمشرفين أو الرد على الرسائل.
<br>سيتم فتح نظام الرسائل الخاصة بالكامل لك أوتوماتيكيا بعد فترة من نشاطك في المنتديات .";
}
if($err == 21){
    $error = "كان هناك خلل أثناء تخزين الرد! <br>
يبدو أنه تم محاولة إدخال الرد عدة مرات لسبب فني أو لخلل في الشبكة. <br>
الرجاء التأكد من أن الرد قد تم إدخاله بشكل صحيح في المنتدى... نأسف على هذا. ";
}
if($err == 22){
    $error = "لا يمكنك ارسال رسالة خاصة لهدا العضو ! <br>
يبدو أنه قد قام بوضعك في قائمة الممنوعين لديه .";
}

if($err == 23){
    $error = "لا يمكنك استعمال ميزة الرسائل الخاصة ! <br>
لانه قد تم منعك من استعمال الخاصية .";
}

if($err == 25){
    $error = $lang['msg']['erorr_25'];
}
if($err == 26){
    $error = $lang['msg']['erorr_26'];
}
if($err == 27){
    $error = $lang['msg']['erorr_27'];
}

if($err == 28){
    $error = "عفوا ، لا يمكنك المشاركة في ".forums("SUBJECT", $f)." لانه قد تم منعك من مشاهدته.";
}


if($error != "" AND $err != "t"){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-2)">'.$lang['all']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
}

if($err == "t"){
	echo'<br>
	<center>
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><font size="3"><br><b>الموضوع المطلوب غير متوفر.<br><br>قد يكون هناك عدة إسباب لهذا منها:<br><br><table><tr><td>* رقم الموضوع المطلوب غير صحيح. </td></tr><tr><td>* الموضوع لم تتم الموافقة عليه للآن من قبل طاقم الإشراف. </td></tr><tr><td>* الموضوع تم تجميده أو حذفه أو إخفاؤه. </td></tr><tr><td>* المنتدى الذي فيه الموضوع لا يسمح لك بالدخول اليه. </td></tr></table></b></font><br><br>
				<a href="JavaScript:history.go(-2)">'.$lang['all']['click_here_to_back'].'</a><br><br>
			</td>
		</tr>
	</table>
	</center>';
}

?>
