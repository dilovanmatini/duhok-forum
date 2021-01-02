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

const _df_script = "archive";
const _df_filename = "archive.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();

?>
<script type="text/javascript" src="js/index.js<?=x?>"></script>
<script type="text/javascript">
var homeView = '<?=home_view?>';
<?php if(ulv==4){ ?>
var catAdminName="catadmin.php";
var forumAdminName="forumadmin.php";
<?php } ?>
</script>
<?php

echo"
<table cellSpacing=\"0\" cellPadding=\"0\" align=\"center\">
	<tr>
		<td class=\"asHeader\">منتديات مؤرشفة</td>
	</tr>
	<tr>
		<td class=\"asBody asCenter\">
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\">";
$checkSqlField="";
$checkSqlTable="";
if(ulv==4){
	$checkSqlField="
		,IF(ISNULL(c.id),0,1) AS allowcat
		,IF(ISNULL(f.id),0,1) AS allowforum
	";
}
elseif(ulv==3){
	$checkSqlField.="
		,IF(c.hidden = 0 AND ".ulv." >= c.level OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id) OR c.monitor = ".uid.",1,0) AS allowcat
		,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id) OR c.monitor = ".uid.",1,0) AS allowforum
	";
	$checkSqlTable.="
		LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")
		LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
	";
}
elseif(ulv==2){
	$checkSqlField.="
		,IF(c.hidden = 0 AND ".ulv." >= c.level OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id),1,0) AS allowcat
		,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id),1,0) AS allowforum
	";
	$checkSqlTable.="
		LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")
		LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
	";
}
elseif(ulv==1){
	$checkSqlField.="
		,IF(c.hidden = 0 AND ".ulv." >= c.level OR NOT ISNULL(fu.id),1,0) AS allowcat
		,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id),1,0) AS allowforum
	";
	$checkSqlTable.="LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")";
}
elseif(ulv==0){
	$checkSqlField.="
		,IF(c.hidden = 0 AND ".ulv." >= c.level,1,0) AS allowcat
		,IF(f.hidden = 0 AND ".ulv." >= f.level,1,0) AS allowforum
	";
}
$sql=$mysql->query("SELECT c.id AS catid,c.status AS cstatus,c.subject AS csubject,f.id,f.subject,f.logo,f.status,f.hidden,f.description,f.topics,f.posts $checkSqlField
FROM ".prefix."category AS c
LEFT JOIN ".prefix."forum AS f ON(f.catid = c.id) $checkSqlTable
WHERE c.archive = 1 GROUP BY f.id,c.id ORDER BY f.sort ASC", __FILE__, __LINE__);
$count=0;
$catid=0;
while($rs=$mysql->fetchAssoc($sql)){
	if($rs['catid']!=$catid){
		if($rs['allowcat']==1){
			echo"
			<tr>
				<td class=\"asDarkB\" colspan=\"3\">{$rs['csubject']}</td>
				<td class=\"asDarkB\">المواضيع</td>
				<td class=\"asDarkB\">الردود</td>";
			if(ulv==4){
				echo"
				<td class=\"asDarkB\">
					<div class=\"forums-admenu\" tools=\"c|{$rs['catid']}|{$rs['cstatus']}\"><img src=\"images/icons/downopen.gif\"></div>
				</td>";
			}
			echo"
			</tr>";
		}
		$catid=$rs['catid'];
	}
	if($rs['allowforum']==1){
		$folder=($rs['status']==0 ? "lock" : "folder");
		$cname=($rs['hidden']==1 ? "asHiddenB" : "asNormalB");
		echo"
		<tr>
			<td class=\"{$cname} asCenter\" width=\"20\"><img src=\"{$DFImage->f[$folder]}\" border=\"0\"></td>
			<td class=\"{$cname}\" width=\"30\"><img src=\"{$rs['logo']}\" onError=\"this.src='{$DFImage->i['errorlogo']}';\" class=\"asWDot\" width=\"30\" height=\"30\" border=\"0\"></td>
			<td class=\"{$cname}\"><nobr>{$Template->forumLink($rs['id'],$rs['subject'])}</nobr><div class=\"asDesc\">{$rs['description']}</div></td>
			<td class=\"{$cname} asCenter\"><nobr>{$rs['topics']}</nobr></td>
			<td class=\"{$cname} asCenter\"><nobr>{$rs['posts']}</nobr></td>";
		if( ulv == 4 ){
			echo"
			<td class=\"{$cname} asCenter\" width=\"20\">
				<div class=\"forums-admenu\" tools=\"f|{$rs['id']}|{$rs['status']}|{$rs['hidden']}\">
					<img src=\"images/icons/downopen.gif\">
				</div>
			</td>";
		}
		echo"
		</tr>";
	}
	$count++;
}
if($count==0){
	echo"
	<tr>
		<td class=\"asNormalB asCenter\" colspan=\"6\"><br>لا توجد أي منتدى مؤرشف<br><br></td>
	</tr>";
}
		echo"
		</table>
		</td>
	</tr>
</table>";

$Template->footer();
?>