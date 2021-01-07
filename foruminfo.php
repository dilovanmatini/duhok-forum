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

const _df_script = "foruminfo";
const _df_filename = "foruminfo.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
if(ulv>0){
//*********************  Start Page  ****************************

function forumModerators($f){
	global $mysql, $Template;
 	$sql=$mysql->query("SELECT m.userid,u.name FROM ".prefix."moderator AS m LEFT JOIN ".prefix."user AS u ON(u.id = m.userid) WHERE m.forumid = '$f'", __FILE__, __LINE__);
	if($mysql->numRows($sql)>0){
		$text="<nobr>";
		$x=0;
		while($rs=$mysql->fetchRow($sql)){
			$text.=($x==1||$x==2?"&nbsp;+&nbsp;":"").$Template->userNormalLink($rs[0],$rs[1]);
			$x++;
			if($x==3){
				$text.="<br />";
				$x=0;
			}
		}
		$text.="</nobr>";
	}
	return $text;
}

$checkSqlField="";
$checkSqlTable="";
if(ulv<4&&!$is_moderator){
	$checkSqlField=",IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id),1,0) AS allowforum";
	$checkSqlTable="LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = '".uid."')";
}
else{
	$checkSqlField=",IF(ISNULL(f.id),0,1) AS allowforum";
}

$sql=$mysql->query("SELECT f.subject,f.logo,f.description,f.topics,f.posts,ff.totaltopics,ff.totalposts,
	c.subject AS csubject,c.submonitor AS csubmonitor,c.monitor,IF(c.monitor > 0,u.name,'') AS monitorname $checkSqlField
FROM ".prefix."forum AS f
LEFT JOIN ".prefix."forumflag AS ff ON(ff.id = f.id)
LEFT JOIN ".prefix."category AS c ON(c.id = f.catid)
LEFT JOIN ".prefix."user AS u ON(u.id = c.monitor) $checkSqlTable
WHERE f.id = '".f."' GROUP BY f.id", __FILE__, __LINE__);
$rs=$mysql->fetchAssoc($sql);
if(!$rs||$rs['allowforum']==0){
	$DF->goTo();
	exit();
}

$todayTopics=$DFOutput->count("topic WHERE forumid = '".f."' AND author = '".uid."' AND date > '".(time-86400)."'");
$todayPosts=$DFOutput->count("post WHERE forumid = '".f."' AND author = '".uid."' AND date > '".(time-86400)."'");

$sql=$mysql->query("SELECT uo.userid,uo.hidebrowse,uo.level,u.name AS uoname
FROM ".prefix."useronline AS uo
LEFT JOIN ".prefix."user AS u ON(u.id = uo.userid)
WHERE uo.level IN(1,2,3) AND uo.forumid = '".f."' GROUP BY uo.userid ORDER BY uo.date DESC", __FILE__, __LINE__);
$count=0;
$shownOnline=0;
$hiddenOnline=0;
while($uors=$mysql->fetchAssoc($sql)){
	if($uors['hidebrowse']==0||ulv>1&&$uors['level']<3||ulv>2&&$uors['level']<4||ulv==4){
		$onlineNames.=($shownOnline==0?"":" + ")."<nobr>{$Template->userNormalLink($uors['userid'],$uors['uoname'])}</nobr>";
		$shownOnline++;
	}
	else{
		$hiddenOnline++;
	}
	$count++;
}

if($count==0){
	$onlineNames=0;
}

if($hiddenOnline>0){
	$hiddenOnlineNumbers="<br>أعضاء متخفين: <font color=\"black\">$hiddenOnline</font>";
}

$visitorsOnline=$DFOutput->count("visitors WHERE forumid = '".f."'","forumid");

$totalOnlines=$count+$visitorsOnline;

echo"<br>
<table width=\"60%\" cellSpacing=\"0\" cellPadding=\"0\" align=\"center\">
	<tr>
		<td class=\"asHeader\" colspan=\"4\"><nobr>معلومات واحصائيات عن منتديات</nobr></td>
	</tr>
	<tr>
		<td class=\"asBody asCenter\">
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\">
			<tr>
				<td class=\"asFixedB\"><nobr>إسم المنتدى</nobr></td>
				<td class=\"asNormalB\" colSpan=\"3\">
				<table>
					<tr>
						<td><img src=\"{$rs['logo']}\" onError=\"this.src='{$DFImage->i['errorlogo']}';\" width=\"30\" height=\"30\" hspace=\"2\" border=0\"></td>
						<td>{$Template->forumLink(f,$rs['subject'])}</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>القسم التابع له المنتدى</nobr></td>
				<td class=\"asNormalB\" colspan=\"3\"><nobr>{$rs['csubject']}</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>وصف المنتدى</nobr></td>
				<td class=\"asNormalB\" colspan=\"3\"><nobr>{$rs['description']}</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>مراقب المنتدى</nobr></td>
				<td class=\"asNormalB\" colspan=\"3\"><nobr>".($rs['monitor']>0 ? $Template->userNormalLink($rs['monitor'],$rs['monitorname']) : '')."</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>نائب مراقب المنتدى</nobr></td>
				<td class=\"asNormalB\" colspan=\"3\"><nobr>".($rs['csubmonitor']>0 ? $Template->userNormalLink($rs['csubmonitor'],$mysql->get("user","name",$rs['csubmonitor'])) : '')."</nobr></td>

			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>مشرفي المنتدى</nobr></td>
				<td class=\"asNormalB\" colspan=\"3\"><nobr>".forumModerators(f)."</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>عدد مواضيعك اليوم في المنتدى</nobr></td>
				<td class=\"asNormalB\" width=\"40%\"><nobr>$todayTopics</nobr></td>
				<td class=\"asFixedB\"><nobr>الحد الأقصى في 24 ساعة</nobr></td>
				<td class=\"asNormalB\" width=\"40%\"><nobr>{$rs['totaltopics']}</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>عدد ردودك اليوم في المنتدى</nobr></td>
				<td class=\"asNormalB\" width=\"40%\"><nobr>$todayPosts</nobr></td>
				<td class=\"asFixedB\"><nobr>الحد الأقصى في 24 ساعة</nobr></td>
				<td class=\"asNormalB\" width=\"40%\"><nobr>{$rs['totalposts']}</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>عدد مواضيع في المنتدى</nobr></td>
				<td class=\"asNormalB\" width=\"40%\"><nobr>{$rs['topics']}</nobr></td>
				<td class=\"asFixedB\"><nobr>عدد مواضيع في الأرشيف</nobr></td>
				<td class=\"asNormalB\" width=\"40%\"><nobr>0</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>عدد ردود في المنتدى</nobr></td>
				<td class=\"asNormalB\" width=\"40%\"><nobr>{$rs['posts']}</nobr></td>
				<td class=\"asFixedB\"><nobr>عدد ردود في الأرشيف</nobr></td>
				<td class=\"asNormalB\" width=\"40%\"><nobr>0</nobr></td>
			</tr>
			<tr>
				<td class=\"asDarkB\" colspan=\"4\"><nobr>في المنتدى حالياً ($totalOnlines)</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>الأعضاء</nobr></td>
				<td class=\"asNormalB\" colspan=\"3\">$onlineNames{$hiddenOnlineNumbers}</td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>الزوار</nobr></td>
				<td class=\"asNormalB\" colspan=\"3\">$visitorsOnline</td>
			</tr>
		</table>
		</td>
	</tr>
</table>";

//*********************  End Page  ****************************
}
else{
	$DF->goTo();
}
$Template->footer();
?>