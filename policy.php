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

if(mlv < 1){

echo'<font color="red"><b><font color="black" size="-1"><center>
<table dir="rtl" cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<table width="100%" border="1">
			<tr class="normal">
				<td class="list_center" colSpan="10">
				<table id="table3">
					<tr>
						<td>
						<p align="center">'.icons($logo, $forum_title).'</td>
						<td>
					</tr>
				</table>
				<p align="center"><font color="red" size="+2"><u>شروط الاستخدام 
				لمنتديات '.$forum_title.'</u></font><br>
				<br>
				اذا توافق على شروط الاستخدام المذكورة أدناه اضغط على &quot;موافق&quot; 
				خلاف ذلك اضغط على &quot;غير موافق&quot;. </p>
				<p align="center">&nbsp;</p>
				<p dir="rtl" align="center">اذا ترغب بالمشاركة في هذه المنتديات 
				يجب عليك اختيار اسم لتعريف نفسك بالاضافة الى كلمة سرية خاصة بك 
				وأن يكون لديك عنوان بريد الكتروني خاص بك. <br>
				<br>
				الموقع ومدير الموقع ومشرفو الموقع غير مسئولون عن أية معلومات 
				توفرها وأية مشاركات تقوم بها. <br>
				<br>
				أي مشاركات تقوم بها في هذه المنتديات تصبح معلومات عامة فنرجو منك 
				عدم الادلاء بأية معلومات سرية أو خاصة بك في مشاركاتك. <br>
				<br>
				هذه المنتديات قد تحتوي على وصلات الى مواقع أخرى ومشاركات من 
				أفراد والموقع غير مسئول عن محتويات المشاركات والوصلات. اذا وجدت 
				أي مشاركة أو وصلة تحتوي على كلام بذيء أو غير مقبول الرجاء 
				اخبارنا فورا وسنقوم بحذف هذه المشاركات من المنتدى حالا. <br>
				<br>
				شروط المشاركات في المنتديات تشمل جميع الشروط التي في الصفحة 
				التالية والتي قد يتم تغييرها من وقت لآخر:
				<a target="_new" href="index.php?mode=rules">
				- شروط المشاركة -</a> <br>
				<br>
				هذه المنتديات تستخدم ميزة في متصحفك لتخزين آخر زيارة لك واسمك 
				والكلمة السرية. هذه المعلومات تخزن في جهازك فقط. يجب أن تكون هذه 
				الميزة مشغلة في متصفحك اذا أردت أن تشارك في المناقشات. يمكنك 
				تمحية جميع المعلومات المخزنة بهذه الطريقة في أي وقت بالضغط على 
				زر &quot;أخرج&quot; في أي صفحة. <br>
				<br>
				اذا توافق على الشروط أعلاه اضغط على &quot;موافق&quot; ادناه. أنت كذلك 
				توافق الا تدخل أية مواد محمية بحقوق نشر في مشاركاتك الا بسماح من 
				مالكها وكذلك تقر أنك أكبر من 12 سنة وأنك لن تقوم بادخال أي نص 
				يحتوي على كلام جنسي أو يشجع على الحقد والكراهية أو يسيء لأي شخص 
				آخر أو يتنافي مع أية قوانين. <br>
				<br>
				لمدير الموقع ومشرفوه الحق في إزالة أي مشاركة أو طرد أي عضو بدون 
				سابق إنذار. <br>
				<br>
				اذا كان لديك أي استفسار الرجاء ارسال بريد الكتروني الى : <a href="mailto:'.$admin_email.'">'.$admin_email.'</a>
			
				<br>
				<br>
                <form method="post" action="index.php?mode=register&Approval=1">
<input type="submit" value="موافق">
<font color="red"><b><font color="black" size="-1">
<input type="submit" value="غير موافق"></font></b></font></form><form method="post" action="index.php">
&nbsp;</form>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</center></font></b></font>';

} else {
redirect();
}
?>