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

const _df_script = "print";
const _df_filename = "print.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header(false);
//************************** Start Page *****************************

$checkSqlTable="";
$checkSqlWhere="";
if(!$is_moderator){
	$checkSqlWhere="
		AND (f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id))
		AND (t.trash = 0 AND (t.moderate = 0 OR t.author = ".uid.") AND (t.hidden = 0 OR t.author = ".uid." OR NOT ISNULL(tu.id)))
	";
	$checkSqlTable="
		LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = t.forumid AND fu.userid = ".uid.")
		LEFT JOIN ".prefix."topicusers AS tu ON(tu.topicid = t.id AND tu.userid = ".uid.")
	";
}
else{
	if(!$is_monitor){
		$checkSqlWhere="AND t.trash = 0";
	}
}

$topic=$mysql->queryAssoc("SELECT t.subject,u.name AS aname,t.author,t.date,tm.message
FROM ".prefix."topic AS t
LEFT JOIN ".prefix."topicmessage AS tm ON(tm.id = t.id)
LEFT JOIN ".prefix."user AS u ON(u.id = t.author)
LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid) $checkSqlTable
WHERE t.id = '".t."' $checkSqlWhere GROUP BY t.id", __FILE__, __LINE__);

if(!$topic){
	$DF->goTo();
}

$DFOutput->setUserActivity('topicprint',$DF->catch['_this_forum'],$topic['author']);

echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\" align=\"center\">
	<tr>
		<td>&nbsp;&nbsp;&nbsp;";
		if( forum_logo != '' ){
			echo"
			<img src=\"".forum_logo."\" alt=\"".forum_title."\" width=\"70\" border=\"0\">";
		}
		echo"
		</td>
		<td width=\"1200\">&nbsp;</td>
		<td class=\"asC1\"><nobr>&nbsp;&nbsp;".site_address."&nbsp;&nbsp;</nobr></td>
	</tr>
	<tr>
		<td width=\"100%\" class=\"asCenter\" colspan=\"3\">{$Template->topicLink(t,$topic['subject'],'','sec')}</td>
	</tr>
	<tr>
		<td><br><br></td>
	</tr>
</table>
<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\">
	<tr>
		<td class=\"asNormalB\" width=\"100%\"><b>{$topic['aname']}</b></td>
		<td class=\"asNormalB\"><nobr><b>{$DF->date($topic['date'])}</b></nobr></td>
	</tr>
	<tr>
		<td bgColor=\"#ffffff\" colspan=\"2\" style=\"table-layout:fixed\">".str_replace("\\\"","",$topic['message'])."</td>
	</tr>";

$checkSqlWhere="";
if(!$is_moderator){
	$checkSqlWhere="AND (p.trash = 0 AND (p.moderate = 0 OR p.author = ".uid.") AND (p.hidden = 0 OR p.author = ".uid."))";
}
else{
	if(!$is_monitor){
		$checkSqlWhere="AND p.trash = 0";
	}
}
$sql=$mysql->query("SELECT u.name AS aname,p.date,pm.message
FROM ".prefix."post AS p
LEFT JOIN ".prefix."postmessage AS pm ON(pm.id = p.id)
LEFT JOIN ".prefix."user AS u ON(u.id = p.author)
WHERE p.topicid = '".t."' $checkSqlWhere GROUP BY p.id ORDER BY p.date ASC LIMIT 15", __FILE__, __LINE__);
while($post=$mysql->fetchAssoc($sql)){
	echo"
	<tr>
		<td class=\"asNormalB\" width=\"100%\"><b>{$post['aname']}</b></td>
		<td class=\"asNormalB\"><nobr><b>{$DF->date($post['date'])}</b></nobr></td>
	</tr>
	<tr>
		<td bgColor=\"#ffffff\" colspan=\"2\" style=\"table-layout:fixed\">".str_replace("\\\"","",$post['message'])."</td>
	</tr>";
}
echo"
</table>
</div>";

//************************** End Page *****************************
$Template->footer(false);
?>