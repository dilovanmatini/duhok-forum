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

if($DBMemberID > 0){

if($msg == "1"){

if(members("LEVEL",$m) == 4){

echo'<center>
<table border="1" width="80%">
	<tr class="normal">
		<td class="list_center"><br>'.icons($logo, $forum_title, "").'<br>
<u><b><font color="red" size="5">مراسلة إدارة المنتديات</font></b></u><br><br>
<b><font size="3">شكرا لك على رغبتك في مراسلة إدارة '.$forum_title.'.<br>نظرا للكم الهائل من الرسائل التي تستلمها الإدارة يوميا لا يمكننا الرد على جميع الرسائل.<br><br>التالي أجوبة على إستفسارات عامة تصلنا بشكل دائم :</font></b><br><br>
<table border="0" bodercolor="#FFFFFF" width="100%" dir="rtl" cellSpacing="1" cellPadding="5">
	<tr>
		<td class="stats_h">كيف أصبح مشرفا؟</td>
		<td class="stats_h">كيف أنظم مسابقة؟</td>
		<td class="stats_h">كيف أحصل على أوسمة؟</td>
	</tr>
	<tr>
		<td class="stats_p" Valign="top"><font color="red">الإدارة لا تقبل ترشيح للإشراف من أعضاء سواء تطوعا لأنفسهم أو لغيرهم. اختيار المشرفين يتم على أساس نشاطهم وتميز مشاركاتهم وتفاعلهم مع الاعضاء الآخرين ومع المشرفين. الامر راجع لك ان تثبت نفسك بهذا الاسلوب لدرجة تلفت انتباهنا اليك.</font></td>
		<td class="stats_p" Valign="top"><font color="red">تنظيم المسابقات من إختصاص مشرفي المنتديات و ليس الإدارة. الرجاء بك الإتصال بمشرفي المنتدى الذي تريد أن تقيم مسابقة فيه.</font></td>
		<td class="stats_p" Valign="top"><font color="red">الأوسمة ونقاط التميز وغيرها من إختصاص مشرفي المنتديات و ليس الإدارة.</font></td>
	</tr>
	<tr>
		<td class="stats_h">أريد نسخة من برنامج المنتديات</td>
		<td class="stats_h">كيف أغير أسم عضويتي؟</td>
		<td class="stats_h">كيف أطلب إزالة الرقابة عني؟</td>
	</tr>
	<tr>
		<td class="stats_p" Valign="top"><font color="red">برنامج المنتديات Duhok Forum من تطوير الأخ Dilovan Matini وهو متوفر مجانا لمن يريد استخدامه.</font></td>
		<td class="stats_p" Valign="top"><font color="red">عليك بإدخال طلب تغيير إسم العضوية من صفحة بياناتك. إذا تجاوزت تغييراتك لإسم عضويتك '.$change_name_max.' مرات لن يقبل النظام طلب آخر لتغيير إسمك ولن تقبل أية طلبات لتغيير الاسماء إلا في حالات خاصة.</font></td>
		<td class="stats_p" Valign="top"><font color="red">الرقابة في منتدى معين من إختصاص مشرفي ذلك المنتدى. الرجاء منك مخاطبتهم بالإمر.</font></td>
	</tr>
	<tr>
		<td class="stats_h">أريد نقل مشاركاتي أو نقاط تميزي لعضوية أخرى</td>
		<td class="stats_h">دعوة للإدارة للمشاركة في موضوع معين</td>
		<td class="stats_h">أستفسار بخصوص مسابقة معينة</td>
	</tr>
	<tr>
		<td class="stats_p" Valign="top"><font color="red">لا يمكن نقل أية بيانات أو مشاركات أو نقاط بين العضويات.</font></td>
		<td class="stats_p" Valign="top"><font color="red">نظرا للدعوات الكثيرة التي تصلنا للمشاركة في مواضيع معينة تعتذر الإدارة عن قبول مثل هذه الطلبات.</font></td>
		<td class="stats_p" Valign="top"><font color="red">المسابقات من إختصاص مشرفي المنتديات و ليس الإدارة. الرجاء بك الإتصال بمشرفي المنتدى المعني.</font></td>
	</tr>
</table><br><br><br>
<b><font size="3">إذا لم تجد إجابة على إستفسارك يمكن مراسلة الإدارة بالضغط على الوصلة أدناه.</font></b><br>
<b><font color="red" size="3">الرجاء الملاحظة إذا كان إستفسارك إجابته أعلاه لن يتم الرد على رسالتك.</font></b>

<form method="post" action="index.php?mode=editor&method=sendmsg&m='.$m.'">
<input type="submit" value="اضغط هنا لمراسلة الادارة">
</form>
		</td>
	</tr>
</table>
</center>';

}

}

}

?>