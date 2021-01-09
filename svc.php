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

const _df_script = "svc";
const _df_filename = "svc.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if(ulv > 1){
//********** Start Page **********************
$showTitleBar=false;
if(
	type!='applists'&&type!='insertlists'&&type!='updatelists'&&type!='insertphoto'&&type!='appdistribute'&&
	type!='insertaward'&&type!='insertmoreaward'&&type!='delete'&&type!='insertmon'&&type!='appglobal'&&
	type!='reply'&&type!='insert'&&type!='update'&&type!='secret'&&type!='unsecret'&&type!='lock'&&type!='unlock'
){
	$showTitleBar=true;
	$svcMenuTitle=array(
		'medals'=>array(
			'lists'=>'قائمة أوسمة التميز',
			'addlists'=>'إضافة وسام جديد',
			'editlists'=>'تعديل وسام',
			'upphotos'=>'مركز رفع صور أوسمة',
			'distribute'=>'أوسمة التميز الممنوحة',
			'awardforums'=>'منح شعار التميز للعضو',
			'award'=>'منح شعار التميز للعضو',
			'moreaward'=>'منح وسام لأكثر من عضو'
		),
		'titles'=>array(
			'lists'=>'قائمة أوصاف',
			'addlists'=>'إضافة وصف جديد',
			'editlists'=>'تعديل وصف',
			'awardforums'=>'إضافة وصف للعضو',
			'award'=>'إضافة وصف للعضو',
			'usertitles'=>'تفاصيل أوصاف العضو',
			'history'=>'تاريخ استخدام الوصف',
			'usetitle'=>'إستعمال الوصف',
			'moreaward'=>'إضافة وصف لأكثر من عضو'
		),
		'moderate'=>array(
			''=>'إشرافك'
		),
		'modblock'=>array(
			''=>'إشرافك'
		),
		'mons'=>array(
			'global'=>'عقوبات الأعضاء',
			'addmon'=>'تطبيق العقوبة'
		),
		'complain'=>array(
			''=>'شكاوي',
			'global'=>'شكاوي'
		),
		'surveys'=>array(
			''=>'استفتاءات'
		),
		'forumbrowse'=>array(
			''=>'احصائيات التصفح'
		),
		'modactivity'=>array(
			''=>'نشاط مشرفين'
		)
	);
}

$DF->catch['svcTypeTitle']="خدمات".(($titleStr=$svcMenuTitle[svc][type]) ? " - $titleStr" : "")."";
$Template->header();
require_once _df_path."includes/func.svc.php";

if($showTitleBar){
	echo"
	<script type=\"text/javascript\" src=\"js/svc.js".x."\"></script>
	<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
		<tr>
			<td class=\"asTopHeader2\">
			<table cellSpacing=\"3\" cellPadding=\"3\">
				<tr>
					<td class=\"asC1\" width=\"1200\"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;خدمات".(($titleStr=$svcMenuTitle[svc][type]) ? " - <span class=\"asC2\">$titleStr</span>" : "")."</nobr></td>
					<th class=\"asTHLink\"><nobr><a href=\"svc.php?svc=medals&type=lists\">قائمة<br>أوسمة التميز</a></nobr></th>
					<th class=\"asTHLink\"><nobr><a href=\"svc.php?svc=medals&type=distribute\">أوسمة التميز<br>الممنوحة</a></nobr></th>
					<th class=\"asTHLink\"><nobr><a href=\"svc.php?svc=titles&type=lists\">قائمة<br>الأوصاف</a></nobr></th>
					<th class=\"asTHLink\"><nobr><a href=\"svc.php?svc=mons&type=global&scope=all\">عقوبات<br>الأعضاء</a></nobr></th>
					<th class=\"asTHLink\"><nobr><a href=\"svc.php?svc=complain\">شكاوي</a></nobr></th>
					<th class=\"asTHLink\"><nobr><a href=\"svc.php?svc=surveys\">الإستفتاءات</a></nobr></th>
					<th class=\"asTHLink\"><nobr><a href=\"svc.php?svc=useractivity\">نشاط<br>أعضاء</a></nobr></th>";
				if(ulv > 2){
					echo"
					<th class=\"asTHLink\"><nobr><a href=\"svc.php?svc=modactivity\">نشاط<br>مشرفين</a></nobr></th>
					<th class=\"asTHLink\"><nobr><a href=\"svc.php?svc=modblock&type=list\">المشرفين<br>المجمدين</a></nobr></th>";
				}
					if(svc == 'medals'){
						if(type == 'lists'){
							$Template->basicPaging("medallists AS ml WHERE ml.id > 0 ".checkMedalListsSql()."","ml.id");
						}
						elseif(type == 'distribute'){
							$Template->basicPaging("medal AS m
							LEFT JOIN ".prefix."medallists AS ml ON(ml.id = m.listid)
							WHERE m.id > 0 ".checkMedalDistributeSql()."","m.id");
						}
					}
					if(svc == 'titles'){
						if(type == 'lists'){
							$Template->basicPaging("titlelists AS tl WHERE 1 = 1 ".checkTitleListsSql()."","tl.id");
						}
					}
					if(svc == 'complain'){
						if(type == 'global'){
							$Template->basicPaging("complain AS com
							LEFT JOIN ".prefix."forum AS f ON(f.id = com.forumid)
							LEFT JOIN ".prefix."moderator AS m ON(NOT ISNULL(f.id) AND m.forumid = f.id AND m.userid = ".uid.")
							LEFT JOIN ".prefix."category AS c ON(NOT ISNULL(f.id) AND c.id = f.catid)
							WHERE 1 = 1 ".checkComplainGlobalSql()."","com.id");
						}
					}
					if(svc == 'survey'){
						if(type == ''){
							$Template->basicPaging("survey AS s
							LEFT JOIN ".prefix."forum AS f ON(f.id = s.forumid)
							LEFT JOIN ".prefix."moderator AS m ON(NOT ISNULL(f.id) AND m.forumid = f.id AND m.userid = ".uid.")
							LEFT JOIN ".prefix."category AS c ON(NOT ISNULL(f.id) AND c.id = f.catid)
							WHERE 1 = 1 ".checkSurveyGlobalSql()."","s.id");
						}
					}
					$Template->goToForum();
				echo"
				</tr>
			</table>
			</td>
		</tr>
	</table><br>";
}

if(svc == 'medals'){
	define('this_svc','medals');
	require_once _df_path."medals.php";
}
elseif(svc == 'titles'){
	define('this_svc','titles');
	require_once _df_path."titles.php";
}
elseif(svc == 'moderate'){
	define('this_svc','moderate');
	require_once _df_path."moderate.php";
}
elseif(svc == 'mons'){
	define('this_svc','mons');
	require_once _df_path."mons.php";
}
elseif(svc == 'complain'){
	define('this_svc','complain');
	require_once _df_path."complain.php";
}
elseif(svc == 'surveys'){
	define('this_svc','surveys');
	require_once _df_path."surveys.php";
}
elseif(svc == 'forumbrowse'){
	define('this_svc','forumbrowse');
	require_once _df_path."countries.php";
}
elseif(svc == 'modactivity'){
	define('this_svc','modactivity');
	require_once _df_path."modactivity.php";
}
elseif(svc == 'useractivity'){
	define('this_svc','useractivity');
	require_once _df_path."useractivity.php";
}
elseif(svc == 'modblock'){
	define('this_svc','modblock');
	require_once _df_path."modblock.php";
}
else{
	$DF->goTo();
}

//********** End Page **********************
}
else{
	$DF->goTo();
}
$Template->footer();
?>