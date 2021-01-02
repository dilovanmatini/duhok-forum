<?php
/**
 * 
 * Duhok Forum 3.0
 * @author		Dilovan Matini (original founder)
 * @copyright	2007 - 2021 Dilovan Matini
 * @see			df.lelav.com
 * @see			https://github.com/dilovanmatini/duhok-forum
 * @license		http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note		This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY;
 * 
 */

const _df_script = "errorpages";
const _df_filename = "errorpages.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$e = intval($_GET['e']);
$errors = array(
	400 => array('خطـــأ 400','السيرفر لم يفهم ما تطلبه'),
	401 => array('خطـــأ 401','الصفحة المطلوبة تتطلب ادخال أسم متسخدم و باسوورد'),
	403 => array('عملية غير مصرحة بها','لم يستطيع فتح صفحة المطلوبة, ربما لا عندك تصريح للدخول.'),
	404 => array('ملف غير موجود','لم يستطع فتح ملف المطلوب, ربما ملف غير موجود.'),
	500 => array('حدث خطأ داخلي غير معروف','المهمة لم تتم بعد ، السيرفر واجه حالة غير معروفة المصدر'),
	503 => array('الخدمة غير متاحة الان','الطلب لم ينتهي بعد ، بسبب ان السيرفر يعاني من ضغط شديد او انه غير متاح')
);
if(in_array($e,array_keys($errors))){
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$//
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="rtl">
<head>
<title><?=forum_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="copyright" content="Duhok Forum: Copyright © 2009-2021 Dilovan Matini" />
<link rel="stylesheet" type="text/css" href="<?=$DF->getSitePath()?>styles/reset.css<?=x?>" />
<link rel="stylesheet" type="text/css" href="<?=$DF->getSitePath()?>styles/blue/style.css<?=x?>" />
<link rel="stylesheet" type="text/css" href="<?=$DF->getSitePath()?>styles/arial.css<?=x?>" />
<link rel="stylesheet" type="text/css" href="<?=$DF->getSitePath()?>styles/globals.css<?=x?>" />
<link rel="stylesheet" type="text/css" href="<?=$DF->getSitePath()?>js/dm/assets/style-1.0.css<?=x?>" />
<script type="text/javascript" src="<?=$DF->getSitePath()?>js/jquery-1.7.1.min.js<?=x?>"></script>
<script type="text/javascript" src="<?=$DF->getSitePath()?>js/jquery.cookie.js<?=x?>"></script>
<script type="text/javascript" src="<?=$DF->getSitePath()?>js/dm/dm-1.0.js<?=x?>"></script>
<script type="text/javascript" src="<?=$DF->getSitePath()?>js/globals.js<?=x?>"></script>
<script type="text/javascript">
function errPage(){
	DM.container.open({
		header: '<?=$errors[$e][0]?>',
		body: '<?="<center><span class=\"asCRed\">{$errors[$e][1]}</span></center>"?>',
		buttons: [
			{
				value: 'اذهب الى الصفحة الرئيسية',
				color: 'dark',
				click: function(){
					$G('<?=$DF->getSitePath()?>');
				}
			}
		]
	});
}
</script>
</head>
<body onload="errPage()">
</body>
</html><?php
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$//
}
else{
	$DF->goTo();
}
$Template->footer(false);
?>