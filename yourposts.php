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

const _df_script = "yourposts";
const _df_filename = "yourposts.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
if( ulv > 0 ){
//********** Start Page **********************

$uid=uid;
$ulv=ulv;
$uname=uname;
if(auth>0){
	$urs=$mysql->queryRow("SELECT u.level,u.name,up.hideselfposts
	FROM ".prefix."user AS u
	LEFT JOIN ".prefix."userperm AS up ON(up.id = u.id)
	WHERE u.id = '".auth."' AND status IN ({$DF->iff(ulv > 1,"0,1","1")})", __FILE__, __LINE__);
	if($urs){
		$uid=auth;
		$uname=$urs[1];
		$uhideselfposts=$urs[2];
	}
}

if($uid!=uid&&$uhideselfposts == 1&&ulv < 2){
	$Template->errMsg("لا يمكنك مشاهدة مشاركات هذا العضو لأسباب أمنية");
	exit();
}
if($uid!=uid&&uhideusersposts == 1&&ulv < 2){
	$Template->errMsg("تم منعك من مشاهدة مشاركات الأعضاء من قبل الإدارة");
	exit();
}

if($uid == uid){
	$menuTitle=(posts_sort_type == 'topics' ? "المواضيع التي كتبتها مؤخرا" : "المواضيع التي شاركت فيها مؤخرا");
}
else{
	$menuTitle=(posts_sort_type == 'topics' ? "المواضيع التي كتبها مؤخرا" : "المواضيع التي شارك فيها مؤخرا");
}
$authStr=($uid!=uid ? ": <span class=\"asC2\">$uname</span>" : "");
$goToForum=$Template->goToForum(true);

echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
	<tr>
		<td class=\"asTopHeader\">
		<table cellSpacing=\"3\" cellPadding=\"3\">
			<tr>
				<td><img src=\"{$DFImage->h['yourposts']}\" border=\"0\"></td>
				<td class=\"asC1\" width=\"1200\">$menuTitle{$authStr}</td>
				<form method=\"post\" action=\"".self."\">
				<td class=\"asText asCenter\"><nobr>الترتيب بتاريخ:</nobr>
				<select class=\"asGoTo\" style=\"width:75px\" name=\"postsSortLast\" onChange=\"submit();\">
					<option value=\"topic\"{$DF->choose(posts_sort_last,'topic','s')}>الموضوع</option>
					<option value=\"post\"{$DF->choose(posts_sort_last,'post','s')}>آخر رد</option>
				</select>
				</td>
				</form>
				<form method=\"post\" action=\"".self."\">
				<td class=\"asText asCenter\"><nobr>خيار التصفح:</nobr>
				<select class=\"asGoTo\" style=\"width:95px\" name=\"postsSortType\" onChange=\"submit();\">
					<option value=\"topics\"{$DF->choose(posts_sort_type,'topics','s')}>المواضيع فقط</option>
					<option value=\"posts\"{$DF->choose(posts_sort_type,'posts','s')}>كل مشاركات</option>
				</select>
				</td>
				</form>
				<form method=\"post\" action=\"".self."\">
				<td class=\"asText asCenter\"><nobr>عرض المواضيع من:</nobr>
				<select class=\"asGoTo\" style=\"width:170px\" name=\"postsSortForum\" onChange=\"submit();\">
					<option value=\"00\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- جميع المنتديات --</option>";
				foreach($Template->forumsList as $key=>$val){
					echo"
					<option value=\"$key\"{$DF->choose(posts_sort_forum,$key,'s')}>$val</option>";
				}
				echo"
				</select>
				</td>
				</form>";
				$Template->refreshPage();
				echo $goToForum;
			echo"
			<tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class=\"asHeader\">&nbsp;</td>
	</tr>
	<tr>
		<td class=\"asBody\">
		<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"4\">
			<tr>
				<td class=\"asDark\" width=\"15%\">المنتدى</td>
				<td class=\"asDark\" width=\"1%\">&nbsp;</td>
				<td class=\"asDark\" width=\"45%\">الموضوع</td>
				<td class=\"asDark\" width=\"10%\">الكاتب</td>
				<td class=\"asDark\" width=\"5%\">الردود</td>
				<td class=\"asDark\" width=\"5%\">قرأت</td>
				<td class=\"asDark\" width=\"10%\"><nobr>آخر رد</nobr></td>
				<td class=\"asDark\" width=\"1%\">الخيارات</td>
			</tr>";
if($uid == uid&&uhideselfposts == 1||$uid!=uid&&$uhideselfposts == 1){
	echo"
	<tr>
		<td class=\"asError asCenter\" colspan=\"8\">لا يمكن للأعضاء بمشاهدة {$DF->iff($uid == uid,'مشاركاتك','مشاركات هذا العضو')} بسبب تم إخفائها من قبل الإدارة</td>
	</tr>";
}
$topicFolderSql="
,IF(
	t.moderate = 1,'{$DFImage->f['moderate']}|موضوع تنتظر الموافقة',
	IF(
		t.moderate = 2,'{$DFImage->f['held']}|موضوع مجمد',
		IF(
			t.trash = 1,'{$DFImage->f['delete']}|موضوع محذوف',
			IF(
				t.status = 0,'{$DFImage->f['lock']}|موضوع مقفل','{$DFImage->f['folder']}|'
			)
		)
	)
) AS topicfolder";
$checkSqlField="";
$checkSqlTable="";
$checkSqlOrder="";
$checkSqlWhere="";
if(ulv == 4){
	$checkSqlField="
		,IF(NOT ISNULL(t.id),1,0) AS ismod
		,IF(NOT ISNULL(t.id),1,0) AS ismon
	";
}
else{
	$checkSqlWhere="
		AND (f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id) OR (".ulv." > 1 AND NOT ISNULL(m.id)) OR (".ulv." = 3 AND NOT ISNULL(c.id)))
		AND (t.hidden = 0 OR t.author = ".uid.")
	";
	$checkSqlField="
		,IF(".ulv." > 1 AND NOT ISNULL(m.id) OR ".ulv." = 3 AND NOT ISNULL(c.id),1,0) AS ismod
		,IF(".ulv." = 3 AND NOT ISNULL(c.id),1,0) AS ismon
	";
	$checkSqlTable="
		LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
		LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")
		LEFT JOIN ".prefix."category AS c ON(c.id = f.catid AND c.monitor = ".uid.")
	";
}

$postsSortForum=(int)posts_sort_forum;
if($postsSortForum>0){
	$checkSqlWhere.="AND t.forumid = $postsSortForum ";
}
if(posts_sort_type == 'topics'){
	$checkSqlFromTable="topic AS t";
	$checkSqlWhere.="AND t.author = $uid ";
}
else{
	$checkSqlFromTable="post AS p
	LEFT JOIN ".prefix."topic AS t ON(t.id = p.topicid)";
	$checkSqlWhere.="AND (p.author = {$uid} OR t.author = {$uid})";
}
$sql=$mysql->query("SELECT t.id,t.subject,t.status,t.author,t.lpauthor,t.posts,t.views,t.lpdate,t.date,
	f.id AS forumid,f.subject AS fsubject,u.name AS aname,u.status AS astatus,u.level AS alevel,u.submonitor AS asubmonitor,
	uu.name AS lpname,uu.status AS lpstatus,uu.level AS lplevel,uu.submonitor AS lpsubmonitor {$topicFolderSql} {$checkSqlField}
FROM ".prefix."$checkSqlFromTable
LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
LEFT JOIN ".prefix."user AS u ON(u.id = t.author)
LEFT JOIN ".prefix."user AS uu ON(uu.id = t.lpauthor) {$checkSqlTable}
WHERE t.trash = 0 AND t.moderate = 0 {$checkSqlWhere} GROUP BY t.id
ORDER BY {$DF->iff(posts_sort_last == 'topics','t.date','t.lpdate')} DESC LIMIT 50", __FILE__, __LINE__);
$count=0;
while($rs=$mysql->fetchAssoc($sql)){
	$topicFolder=explode("|",$rs['topicfolder']);
	$author = $Template->userColorLink($rs['author'], array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor']));
	$lpauthor = $Template->userColorLink($rs['lpauthor'], array($rs['lpname'], $rs['lpstatus'], $rs['lplevel'], $rs['lpsubmonitor']));
	$cellClass=($rs['lpauthor'] == $uid||$rs['posts'] == 0 ? 'asNormal':'asFixed');
	echo"
	<tr>
		<td class=\"$cellClass asAS12 asCenter\"><b>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</b></td>
		<td class=\"$cellClass asCenter\"><img src=\"$topicFolder[0]\" alt=\"$topicFolder[1]\" border=\"0\"></td>
		<td class=\"$cellClass\">
		<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
			<tr>
				<td>{$Template->topicLink($rs['id'],$rs['subject'])}{$DF->iff($rs['posts']>0,$Template->topicPaging($rs['id'],$rs['posts']))}</td>
			</tr>
		</table>
		</td>
		<td class=\"$cellClass asS12 asAS12 asDate asCenter\">{$DF->date($rs['date'])}<br>$author</td>
		<td class=\"$cellClass asS12 asCenter\">{$rs['posts']}</td>
		<td class=\"$cellClass asS12 asCenter\">{$rs['views']}</td>
		<td class=\"$cellClass asS12 asAS12 asDate asCenter\">";
		if($rs['posts']>0){
			echo"{$DF->date($rs['lpdate'])}<br>$lpauthor";
		}
		else{echo"&nbsp;";}
		echo"</td>
		<td class=\"$cellClass asCenter\"><nobr>";
		if($rs['ismod'] == 1||$rs['status'] == 1&&$rs['author'] == uid){
			echo"
			<a href=\"editor.php?type=edittopic&t={$rs['id']}&src=".urlencode(self)."\"><img src=\"{$DFImage->f['edit']}\" alt=\"تعديل الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		if($rs['status'] == 1||$rs['ismod'] == 1){
			echo"
			<a href=\"editor.php?type=newpost&t={$rs['id']}&src=".urlencode(self)."\"><img src=\"{$DFImage->i['reply']}\" alt=\"رد على الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		echo"</nobr>
		</td>
	</tr>";
	$count++;
}
if($count == 0){
	$sortTypeStr=(posts_sort_type == 'topics' ? "مواضيع" : "مشاركات");
	$authorStr=($uid == uid ? "لك" : "لهذا العضو");
	$forumStr=(posts_sort_forum>0 ? "في المنتدى المختار أعلاه." : "في جميع منتديات.");
	$notFoundText="لا توجد أي $sortTypeStr $authorStr $forumStr";
	echo"
	<tr>
		<td class=\"asNormal asCenter\" colspan=\"8\"><br>$notFoundText<br><br></td>
	</tr>";
}
echo"
</table>
</td>
</tr>";
if($count>0){
	echo"
	<tr>
		<td class=\"asBody\">
		<table cellSpacing=\"2\" cellPadding=\"3\">
			<tr>
				<td class=\"asTitle\">المواضيع التي تظهر باللون التالي</td>
				<td class=\"asFixedB\"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></td>
				<td class=\"asTitle\"><nobr>تحتوي على مشاركات جديد بعد آخر مشاركة {$DF->iff($uid == uid,'لك','للعضو')} فيها.</nobr></td>
			</tr>
		</table>
		</td>
	</tr>";
}
echo"
</table>";
//********** End Page **********************
}
else{
	$DF->goTo();
}
$Template->footer();
?>