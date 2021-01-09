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

const _df_script = "yourtopics";
const _df_filename = "yourtopics.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
if( ulv > 0 ){
//********************** Start Page *************************
$uid=uid;
$ulv=ulv;
$uname=uname;
if(auth>0){
	$checkSql=(ulv > 1 ? "IN (0,1)" : "= 1");
	$urs=$mysql->queryRow("SELECT u.level,u.name,up.hideselftopics
	FROM ".prefix."user AS u
	LEFT JOIN ".prefix."userperm AS up ON(up.id = u.id)
	WHERE u.id = '".auth."' AND u.status $checkSql", __FILE__, __LINE__);
	if($urs){
		$uid=auth;
		$ulv=$urs[0];
		$uname=$urs[1];
		$uhideselftopics=$urs[2];
	}
}

if($uid!=uid&&$uhideselftopics == 1&&ulv < 2){
	$Template->errMsg("لا يمكنك مشاهدة مواضيع هذا العضو لأسباب أمنية");
	exit();
}
if($uid!=uid&&uhideuserstopics == 1&&ulv < 2){
	$Template->errMsg("تم منعك من مشاهدة مواضيع الأعضاء من قبل الإدارة");
	exit();
}

if($uid == uid){
	$menuText="جميع مواضيعك";
}
else{
	$menuText="جميع مواضيع العضو: <span class=\"asC2\">$uname</span>";
}

echo"
<table width=\"50%\" cellSpacing=\"0\" cellPadding=\"0\" align=\"center\">
	<tr>
		<td class=\"asHeader\">$menuText</td>
	</tr>
	<tr>
		<td class=\"asBody asCenter\">
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\">";
if($uid == uid&&uhideselftopics == 1||$uid!=uid&&$uhideselftopics == 1){
	echo"
	<tr>
		<td class=\"asErrorB asCenter\" colSpan=\"3\">لا يمكن للأعضاء بمشاهدة هذه الصفحة بسبب تم إخفائها من قبل الإدارة</td>
	</tr>";
}
$checkSqlField="";
$checkSqlTable="";
if(ulv == 4){
	$checkSqlField="
		,IF(ISNULL(c.id),0,1) AS allowcat
		,IF(ISNULL(f.id),0,1) AS allowforum
	";
}
elseif(ulv == 3){
	$checkSqlField.="
		,IF(c.hidden = 0 AND ".ulv." >= c.level OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id) OR c.monitor = ".uid.",1,0) AS allowcat
		,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id) OR c.monitor = ".uid.",1,0) AS allowforum
	";
	$checkSqlTable.="
		LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")
		LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
	";
}
elseif(ulv == 2){
	$checkSqlField.="
		,IF(c.hidden = 0 AND ".ulv." >= c.level OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id),1,0) AS allowcat
		,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id),1,0) AS allowforum
	";
	$checkSqlTable.="
		LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")
		LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
	";
}
elseif(ulv == 1){
	$checkSqlField.="
		,IF(c.hidden = 0 AND ".ulv." >= c.level OR NOT ISNULL(fu.id),1,0) AS allowcat
		,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id),1,0) AS allowforum
	";
	$checkSqlTable.="LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")";
}

$sql=$mysql->query("SELECT c.id AS catid,c.subject AS csubject,f.id AS forumid,f.subject,COUNT(DISTINCT t.id) AS ftopics
	$checkSqlField
FROM ".prefix."category AS c
LEFT JOIN ".prefix."forum AS f ON(f.catid = c.id)
LEFT JOIN ".prefix."topic AS t ON(t.author = '$uid' AND t.forumid = f.id) $checkSqlTable
WHERE NOT ISNULL(t.id)
GROUP BY f.id,c.id
HAVING (ftopics > 0)
ORDER BY c.sort,f.sort ASC", __FILE__, __LINE__);
$count=0;
$lastcatid=0;

while($rs=$mysql->fetchAssoc($sql)){
	if($rs['catid']!=$lastcatid){
		if($rs['allowcat'] == 1){
			echo"
			<tr>
				<td class=\"asDarkB\">{$rs['csubject']}</td>
				<td class=\"asDarkB\">المواضيع الحالية</td>
				<td class=\"asDarkB\">المواضيع في الأرشيف</td>
			</tr>";
		}
		$lastcatid=$rs['catid'];
	}
	if($rs['allowforum'] == 1){
		echo"
		<tr>
			<td class=\"asFixedB\">{$Template->forumLink($rs['forumid'],$rs['subject'])}</td>
			<td class=\"asNormalB asCenter\">{$Template->forumLink($rs['forumid'],$rs['ftopics'],'','',"&auth=$uid")}</td>
			<td class=\"asNormalB asCenter\"><a href=\"forumsarchive.php?f={$rs['forumid']}&auth=$uid\">0</a></td>
		</tr>";
	}
	$count++;
}
if($count == 0){
	echo"
	<tr>
		<td class=\"asNormalB asCenter\" colspan=\"3\"><br>لا توجد أي مواضيع<br><br></td>
	</tr>";
}
echo"
</table>
</td>
	</tr>
	<tr>
		<td class=\"asBody\">
		<table cellSpacing=\"2\" cellPadding=\"3\">
			<tr>
				<td class=\"asTitle\">ملاحظة</td>
				<td class=\"asText2\">لتصفح المواضيع في منتدى معين إضغط على عددها</td>
			</tr>
		</table>
		</td>
	</tr>
</table>";
//********************** End Page *************************
}
else{
	$DF->goTo();
}
$Template->footer();
?>