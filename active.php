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

const _df_script = "active";
const _df_filename = "active.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
	<tr>
		<td class=\"asTopHeader\">
		<table cellSpacing=\"3\" cellPadding=\"3\">
			<tr>
				<td><img src=\"{$DFImage->h['active']}\" border=\"0\"></td>
				<td width=\"1200\"><a class=\"sec\" href=\"active.php\">مواضيع نشطة</a></td>
				<form method=\"post\" action=\"".self."\">
				<td class=\"asText asCenter\"><nobr>خيار عرض المواضيع:</nobr>
				<select class=\"asGoTo\" style=\"width:180px\" name=\"activeType\" onchange=\"submit();\">
					<option value=\"active\"{$DF->choose(active_type,'active','s')}>آخر مشاركة في جميع المواضيع</option>
					<option value=\"hot\"{$DF->choose(active_type,'hot','s')}>آخر المواضيع نشطة بعدد الردود</option>
					<option value=\"read\"{$DF->choose(active_type,'read','s')}>آخر المواضيع نشطة بعدد القراءة</option>
					<option value=\"top\"{$DF->choose(active_type,'top','s')}>مواضيع متميزة على المنتديات</option>
				</select>
				</td>
				</form>";
				$Template->refreshPage();
				$Template->goToForum();
			echo"
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class=\"asHeader\">مواضيع نشطة</td>
	</tr>
	<tr>
		<td class=\"asBody\">
		<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"4\">
	<tr>
		<td class=\"asDark\" width=\"18%\">منتدى</td>
		<td class=\"asDark\">&nbsp;</td>
		<td class=\"asDark\" width=\"45%\">المواضيع</td>
		<td class=\"asDark\" width=\"15%\">الكاتب</td>
		<td class=\"asDark\">الردود</td>
		<td class=\"asDark\">قرأت</td>
		<td class=\"asDark\" width=\"15%\">آخر رد</td>";
	if( ulv > 0 ){
		echo"
		<td class=\"asDark\" width=\"1%\">الخيارات</td>";
	}
	echo"
	</tr>";
	
if(active_type == 'hot'){
	$activeSql="AND t.posts >= 10";
}
elseif(active_type == 'read'){
	$activeSql="AND t.views >= 50";
}
elseif(active_type == 'top'){
	$activeSql="AND t.top = 2";
}
else{
	$activeSql="AND t.posts > 0";
}

$topicFolderSql=",
IF(
	t.moderate = 1,'{$DFImage->f['moderate']}|موضوع تنتظر الموافقة',
	IF(
		t.moderate = 2,'{$DFImage->f['held']}|موضوع مجمد',
		IF(
			t.trash = 1,'{$DFImage->f['delete']}|موضوع محذوف',
			IF(
				t.status = 0,'{$DFImage->f['lock']}|موضوع مقفل','{$DFImage->f['folder']}|موضوع مفتوح'
			)
		)
	)
) AS topicfolder";

$checkSqlField="";
$checkSqlTable="";
$checkSqlWhere="";
if(ulv < 4){
	$checkSqlField=",IF(ISNULL(m.id),0,1) AS ismod";
	$checkSqlTable="
		LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = '".uid."')
		LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = '".uid."')
	";
	$checkSqlWhere="AND (f.hidden = 0 AND f.level <= '".ulv."' OR fu.id IS NOT NULL)";
	if(ulv == 3){
		$checkSqlField.=",IF(ISNULL(c.id),0,1) AS ismon";
		$checkSqlTable.="LEFT JOIN ".prefix."category AS c ON(c.id = f.catid AND c.monitor = '".uid."')";
	}
}
else{
	$checkSqlField="
		,IF(ISNULL(t.id),0,1) AS ismod
		,IF(ISNULL(t.id),0,1) AS ismon
	";
}
	
$sql=$mysql->query("SELECT t.id, t.subject, t.status, t.author, t.lpauthor, t.posts, t.views, t.lpdate, t.date,
	f.id AS forumid,f.subject AS fsubject,u.name AS aname,u.status AS astatus,u.level AS alevel,u.submonitor AS asubmonitor,
	uu.name AS lpname,uu.status AS lpstatus,uu.level AS lplevel,uu.submonitor AS lpsubmonitor $topicFolderSql $checkSqlField
FROM ".prefix."topic AS t
LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
LEFT JOIN ".prefix."user AS u ON(u.id = t.author)
LEFT JOIN ".prefix."user AS uu ON(uu.id = t.lpauthor) $checkSqlTable 
WHERE t.hidden = 0 AND t.trash = 0 AND t.moderate = 0 $activeSql $checkSqlWhere ORDER BY t.lpdate DESC LIMIT 50", __FILE__, __LINE__);
while($rs=$mysql->fetchAssoc($sql)){
	$topicFolder = explode("|",$rs['topicfolder']);
	$author=($authorName=$DF->catch['authorName'][$rs['author']]) ? $authorName : ($DF->catch['authorName'][$rs['author']]=$Template->userColorLink($rs['author'],array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor'])));
	$lpauthor=($lpauthorName=$DF->catch['lpauthorName'][$rs['lpauthor']]) ? $lpauthorName : ($DF->catch['lpauthorName'][$rs['lpauthor']]=$Template->userColorLink($rs['lpauthor'],array($rs['lpname'], $rs['lpstatus'], $rs['lplevel'], $rs['lpsubmonitor'])));
	echo"
	<tr>
		<td class=\"asNormal asAS12 asCenter\">{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</td>
		<td class=\"asNormal asCenter\"><img src=\"$topicFolder[0]\" alt=\"$topicFolder[1]\" border=\"0\"></td>
		<td class=\"asNormal\">
		<table cellPadding=\"0\" cellsapcing=\"0\">
			<tr>
				<td>{$Template->topicLink($rs['id'],$rs['subject'])}".($rs['posts']>0?$Template->topicPaging($rs['id'],$rs['posts']):"")."</td>
			</tr>
		</table>
		</td>
		<td class=\"asNormal asS12 asAS12 asDate asCenter\">{$DF->date($rs['date'])}<br>{$author}</td>
		<td class=\"asNormal asS12 asCenter\">{$rs['posts']}</td>
		<td class=\"asNormal asS12 asCenter\">{$rs['views']}</td>
		<td class=\"asNormal asS12 asAS12 asDate asCenter\">";
		if($rs['posts']>0){
			echo"{$DF->date($rs['lpdate'])}<br>$lpauthor";
		}
		else{echo"&nbsp;";}
		echo"</td>";
	if( ulv > 0 ){
		echo"
		<td class=\"asNormal asCenter\">";
		if($rs['status'] == 1||$rs['ismod'] == 1||$rs['ismon'] == 1){
			echo"<a href=\"editor.php?type=newpost&t={$rs['id']}&src=".urlencode(self)."\"><img src=\"{$DFImage->i['reply']}\" alt=\"رد على الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		echo"</td>";
	}
	echo"
	</tr>";
}
echo"
</table>
</td>
</tr>
</table>";
$Template->footer();
?>