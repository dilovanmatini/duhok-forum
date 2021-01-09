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

const _df_script = "favorite";
const _df_filename = "favorite.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
if( ulv > 0 ){
	if(uhidefavorite == 1){
		$Template->errMsg("تم أغلاق خاصية مواضيعك المفضلة لك من قبل الإدارة<br>لمعرفة سبب أغلاق هذه الميزة لك, اتصل بالإدارة");
		exit();
	}
//*********************** Start Page **********************
if(u>0&&ulv == 4){
	$uid=u;
}
else{
	$uid=uid;
}
if(type == ""){
echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
	<tr>
		<td class=\"asTopHeader\">
		<table cellSpacing=\"3\" cellPadding=\"3\">
			<tr>
				<td><img src=\"{$DFImage->h['favorite']}\" border=\"0\"></td>
				<td width=\"1200\"><a class=\"sec\" href=\"favorite.php\">المفضلة</a></td>";
				$Template->refreshPage();
				$Template->goToForum();
			echo"
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class=\"asHeader\">المفضلة</td>
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
	if(ulv < 4){
		$checkSqlField=",IF(ISNULL(m.id),0,1) AS ismod";
		$checkSqlTable="LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = '".uid."')";
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
		
	$sql=$mysql->query("SELECT fv.id AS fvid,t.id,t.subject,t.status,t.author,t.lpauthor,t.posts,t.views,t.lpdate,t.date,
		f.id AS forumid,f.subject AS fsubject,u.name AS aname,u.status AS astatus,u.level AS alevel,u.submonitor AS asubmonitor,
		uu.name AS lpname,uu.status AS lpstatus,uu.level AS lplevel,uu.submonitor AS lpsubmonitor {$topicFolderSql} {$checkSqlField}
	FROM ".prefix."favorite AS fv
	LEFT JOIN ".prefix."topic AS t ON(t.id = fv.topicid)
	LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = t.author)
	LEFT JOIN ".prefix."user AS uu ON(uu.id = t.lpauthor) $checkSqlTable
	WHERE fv.userid = '$uid' AND t.hidden = 0 AND t.trash = 0 AND t.moderate = 0 ORDER BY t.lpdate DESC", __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		$topicFolder=explode("|",$rs['topicfolder']);
		$author = $Template->userColorLink($rs['author'], array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor']));
		$lpauthor = $Template->userColorLink($rs['lpauthor'], array($rs['lpname'], $rs['lpstatus'], $rs['lplevel'], $rs['lpsubmonitor']));
		echo"
		<tr>
			<td class=\"asNormal asAS12 asCenter\"><b>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</b></td>
			<td class=\"asNormal asCenter\"><img src=\"$topicFolder[0]\" alt=\"$topicFolder[1]\" border=\"0\"></td>
			<td class=\"asNormal\">
			<table cellPadding=\"0\" cellsapcing=\"0\">
				<tr>
					<td><b>{$Template->topicLink($rs['id'],$rs['subject'])}</b>".($rs['posts']>0?$Template->topicPaging($rs['id'],$rs['posts']):"")."</td>
				</tr>
			</table>
			</td>
			<td class=\"asNormal asS12 asAS12 asDate asCenter\">{$DF->date($rs['date'])}<br>$author</td>
			<td class=\"asNormal asS12 asCenter\">{$rs['posts']}</td>
			<td class=\"asNormal asS12 asCenter\">{$rs['views']}</td>
			<td class=\"asNormal asS12 asAS12 asDate asCenter\">";
			if($rs['posts']>0){
				echo"{$DF->date($rs['lpdate'])}<br>$lpauthor";
			}
			else{echo"&nbsp;";}
			echo"</td>
			<td class=\"asNormal asCenter\"><nobr>";
			if($rs['status'] == 1||$rs['ismod'] == 1||$rs['ismon'] == 1){
				echo"
				<a href=\"editor.php?type=newpost&t={$rs['id']}&src=".urlencode(self)."\"><img src=\"{$DFImage->i['reply']}\" alt=\"رد على الموضوع\" hspace=\"2\" border=\"0\"></a>";
			}
				echo"
				<a href=\"favorite.php?type=delete&id={$rs['fvid']}\"><img src=\"{$DFImage->i['favorite_delete']}\" alt=\"حذف هذا موضوع من قائمة مواضيعك المفضلة\" hspace=\"2\" border=\"0\"></a>
			</nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormal asCenter\" colspan=\"8\"><br>لا توجد أي مواضيع في المفضلة<br><br></td>
		</tr>";
	}
	echo"
	</table>
	</td>
	</tr>
	</table>";
}
elseif(type == 'add'){
	$sql=$mysql->query("SELECT IF(ISNULL(f.id),0,1) AS isfound
	FROM ".prefix."topic AS t
	LEFT JOIN ".prefix."favorite AS f ON(f.topicid = t.id AND f.userid = '".uid."')
	WHERE t.id = '".t."' AND t.hidden = 0 AND t.trash = 0 AND t.moderate = 0", __FILE__, __LINE__);
	$isfound=$mysql->fetchRow($sql);
	
	$sql=$mysql->query("SELECT COUNT(f.id)
	FROM ".prefix."favorite AS f
	LEFT JOIN ".prefix."topic AS t ON(t.id = f.topicid)
	WHERE f.userid = '".uid."' AND t.hidden = 0 AND t.trash = 0 AND t.moderate = 0", __FILE__, __LINE__);
	$count=$mysql->fetchRow($sql);
	
	if(!$isfound){
		$Template->errMsg("لا تستطيع إضافة هذا الموضوع لأسباب أمنية");
	}
	elseif($isfound[0] == 1){
		$Template->errMsg("لا تستطيع إضافة هذا الموضوع بسبب هو موجود حالياً في قائمة مواضيعك المفضلة");
	}
	elseif($count[0]>=50&&ulv < 4){
		$Template->errMsg("لا تستطيع إضافة موضوع لقائمة مواضيعك المفضلة<br>بسبب انك تجاوزت حد المسموح بك وهو 50 موضوع<br>لهذا يجب عليك ان تقوم بحذف بعض مواضيع من قائمة مواضيعك المفضلة<br>لتستطيع إضافة هذا الموضوع");
	}
	else{
		$mysql->insert("favorite (userid,topicid) VALUES ('".uid."','".t."')", __FILE__, __LINE__);
		$DFOutput->setUserActivity('topicfav',0,(int)$mysql->get("topic","author",t));
		$Template->msg("تم إضافة موضوع الى قائمة مواضيعك المفضلة بنجاح‌");
	}
}
elseif(type == 'delete'){
	$sql=$mysql->query("SELECT id FROM ".prefix."favorite WHERE id = '".id."' AND userid = '$uid'", __FILE__, __LINE__);
	$rs=$mysql->fetchRow($sql);
	if(!$rs){
		$Template->errMsg("لا تستطيع حذف موضوع من قائمة مواضيعك المفضلة لأسباب أمنية");
	}
	else{
		$mysql->delete("favorite WHERE id = '".id."'", __FILE__, __LINE__);
		$Template->msg("تم حذف موضوع من قائمة مواضيعك المفضلة بنجاح‌");
	}
}
else{
	$DF->goTo();
}
//*********************** End Page **********************
}
else{
	$DF->goTo();
}
$Template->footer();
?>