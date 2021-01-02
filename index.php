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

const _df_script = "index";
const _df_filename = "index.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();

?>
<script type="text/javascript">
var homeView = '<?=home_view?>';
<?php if(ulv==4){ ?>
var catAdminName = 'catadmin.php', forumAdminName = 'forumadmin.php';
<?php } ?>
</script>
<?php

$onlines = [ 0, 0, 0, 0, 0 ];
$sql = $mysql->query("SELECT COUNT(ip), level FROM ".prefix."useronline GROUP BY level ORDER BY level ASC", __FILE__, __LINE__);
while( $rs = $mysql->fetchRow($sql) ){
	$onlines[$rs[1]] = $rs[0];
}
$onlines[0] = $DFOutput->count('visitors', 'ip');
echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
	<tr>
		<td class=\"asTopHeader\">
		<table cellSpacing=\"2\" cellPadding=\"3\" width=\"100%\">
			<tr>
				<td class=\"asTitle\"><nobr>في الموقع الآن:</nobr></td>
				<td class=\"asTitle\"><nobr>الأعضاء</nobr></td>
				<td class=\"asText2\"><nobr>{$onlines[1]}</nobr></td>
				<td class=\"asTitle\"><nobr>المشرفون</nobr></td>
				<td class=\"asText2\"><nobr>{$onlines[2]}</nobr></td>
				<td class=\"asTitle\"><nobr>المراقبون</nobr></td>
				<td class=\"asText2\"><nobr>{$onlines[3]}</nobr></td>
				<td class=\"asTitle\"><nobr>الزوار</nobr></td>
				<td class=\"asText2\"><nobr>".($onlines[0])."</nobr></td>
				<td width=\"100%\">&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			if(ulv > 0){
				echo"
				<th class=\"asTHLink\"><nobr><a href=\"javascript:DF.trashCookie();\" title=\"بالنقر هنا سيتم حذف كوكيز تابعة لدخولك للمنتدى وسيتم خروجك من المنتدى\">حذف كوكيز</a></nobr></th>";
			}
				echo"
				<td class=\"asTitle\"><nobr>العرض</nobr></td>
				<td class=\"asText2\" style=\"padding:2px 2px 0px 2px;\"><nobr>
					<a href=\"index.php?home_view=details\" title=\"عرض منتديات على شكل تفاصيل\"><img src=\"{$DFImage->i['blank']}\" class=\"viewDetails".(home_view == 'details' ? 'In' : '')."\" border=\"0\"></a>
					<a href=\"index.php?home_view=grid\" title=\"عرض منتديات على شكل شبكة\"><img src=\"{$DFImage->i['blank']}\" class=\"viewGrid".(home_view == 'grid' ? 'In' : '')."\" border=\"0\"></a><nobr>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>";

$checkSqlField = "";
$checkSqlTable = "";
if(ulv == 4){
	$checkSqlField = "
		,IF(ISNULL(c.id),0,1) AS allowcat
		,IF(ISNULL(f.id),0,1) AS allowforum
	";
}
else{
	$allowcat = "c.hidden = 0 AND ".ulv." >= c.level";
	$allowforum = "f.hidden = 0 AND ".ulv." >= f.level";
	$allowglobal = "";
	if(ulv == 3){
		$allowglobal = "OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id) OR ".ulv." > 2 AND c.monitor = ".uid."";
		$checkSqlTable .= "
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")
			LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
		";
	}
	elseif(ulv == 2){
		$allowglobal = "OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id)";
		$checkSqlTable .= "
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")
			LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
		";
	}
	elseif(ulv == 1){
		$allowglobal = "OR NOT ISNULL(fu.id)";
		$checkSqlTable .= "LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")";
	}
	$checkSqlField .= "
		,IF(({$allowcat}) {$allowglobal},1,0) AS allowcat
		,IF(({$allowcat} AND {$allowforum}) {$allowglobal},1,0) AS allowforum
	";
}

$sql = $mysql->query("SELECT c.id AS cid, c.subject AS csubject, c.status AS cstatus, c.monitor, c.submonitor, c.hidemonhome, f.id AS fid, f.hidden,f.status,f.logo,f.subject,
	f.description,f.topics,f.posts,f.lpauthor,f.lpdate,f.hidemodhome,uu.name AS monitorname,u.name AS lpname,u.status AS lpstatus,u.level AS lplevel,u.submonitor AS lpsubmonitor
	$checkSqlField
FROM ".prefix."category AS c
LEFT JOIN ".prefix."forum AS f ON(f.catid = c.id)
LEFT JOIN ".prefix."user AS u ON(u.id = f.lpauthor)
LEFT JOIN ".prefix."user AS uu ON(uu.id = c.monitor) {$checkSqlTable} 
WHERE c.archive = 0 GROUP BY f.id, c.id ORDER BY c.sort, f.sort ASC", __FILE__, __LINE__);
$catList = array();
$forumList = array();
$toggle = '';
$lastcatid = 0;
while($rs = $mysql->fetchAssoc($sql)){
	if($rs['cid'] != $lastcatid && $rs['allowcat'] == 1){
		$catList[$rs['cid']] = array(
			'subject'		=> $rs['csubject'],
			'status'		=> $rs['cstatus'],
			'monitor'		=> $rs['monitor'],
			'submonitor'	=> $rs['submonitor'],
			'hidemonhome'	=> $rs['hidemonhome'],
			'monitorname'	=> $rs['monitorname']
		);
		$lastcatid = $rs['cid'];
	}
	if($rs['allowforum'] == 1){
		$forumList[$rs['fid']] = array(
			'cid' 			=> $rs['cid'],
			'subject' 		=> $rs['subject'],
			'status' 		=> $rs['status'],
			'hidden' 		=> $rs['hidden'],
			'logo' 			=> $rs['logo'],
			'description' 	=> $rs['description'],
			'topics' 		=> $rs['topics'],
			'posts' 		=> $rs['posts'],
			'lpauthor' 		=> $rs['lpauthor'],
			'lpdate' 		=> $rs['lpdate'],
			'lpTools' 		=> array($rs['lpname'], $rs['lpstatus'], $rs['lplevel'], $rs['lpsubmonitor']),
			'hidemodhome' 	=> $rs['hidemodhome']
		);
	}
}
$onlineForums = array();
foreach($catList as $cid => $c){
	if(home_view == 'grid'){
		echo"
		<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
			<tr>
				<td class=\"asHeader\">";
			if(ulv == 4){
				echo"
				<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
					<tr>
						<td class=\"asC1\">{$c['subject']}</td>
						<td><div class=\"forums-admenu\" tools=\"c|{$cid}|{$c['status']}\"><img src=\"images/icons/downopen.gif\"></div></td>
					</tr>
				</table>";
			}
			else{
				echo"{$c['subject']}";
			}
				echo"
				</td>
			</tr>
			<tr>
				<td class=\"asBody\" align=\"center\">
				<table cellSpacing=\"6\" cellPadding=\"0\">
					<tr>";
				$fsplit = 0;
				$fcount = 0;
				$cDetails = array(
					'topics' 	=> 0,
					'posts' 	=> 0,
					'atopics' 	=> 0,
					'aposts' 	=> 0
				);
				foreach($forumList as $fid => $f){
					if($f['cid'] == $cid){
						if($fsplit == 4){
							echo"</tr><tr>";
							$fsplit = 0;
						}
						echo"
						<td class=\"asText2\">
						<table width=\"230\" cellSpacing=\"1\" cellPadding=\"4\">
							<tr>
								<td class=\"asDarkB\" align=\"center\"><img src=\"{$f['logo']}\" onError=\"this.src='{$DFImage->i['errorlogo']}';\" class=\"asWDot\" width=\"30\" height=\"30\" border=\"0\"><div class=\"forums-admenu\" tools=\"f|{$fid}|{$f['status']}|{$f['hidden']}\"><img src=\"images/icons/downopen.gif\"></div></td>
								<td class=\"asDarkB asAC1\" width=\"100%\" height=\"50\" valign=\"top\" colspan=\"3\"><nobr>{$Template->forumLink($fid,$f['subject'])}</nobr><div class=\"asCOrange asS12\">{$f['description']}</div></td>
							</tr>
							<tr>
								<td class=\"asNormalB asS12\" align=\"center\">مواضيع</td>
								<td class=\"asNormalB asS12 asDate\" align=\"center\"><nobr>{$f['topics']}</nobr></td>
								<td class=\"asNormalB asS12\" align=\"center\">ردود</td>
								<td class=\"asNormalB asS12 asDate\" align=\"center\"><nobr>{$f['posts']}</nobr></td>
							</tr>
							<tr>
								<td class=\"asNormalB asS12\" align=\"center\"><nobr>أخر<br>مشاركة</nobr></td>
								<td class=\"asNormalB asAS12 asS12 asDate\" align=\"center\" colspan=\"3\"><nobr>";
								if($f['lpauthor'] > 0 && $f['lpdate'] > 0){
									echo"<nobr>{$DF->date($f['lpdate'])}<br>{$Template->userColorLink($f['lpauthor'], $f['lpTools'])}<nobr>";
								}
								else{
									echo"&nbsp;";
								}
								echo"
								</nobr></td>
							</tr>
							<tr>
								<td class=\"asNormalB asS12\" align=\"center\"><nobr>المتواجدون</td>
								<td class=\"asNormalB asAS12 asDate\" height=\"60\" align=\"center\" colspan=\"3\" rowspan=\"2\">{$Template->nbsp($f['hidemodhome']==0 ? (($homeMods=$Template->forumModerators($fid,2)) ? $homeMods : "<span class=\"asC3 asS12\">لا توجد أي مشرف لهذا المنتدى</span>") : "<span class=\"asC3 asS12\">تم إخفاء مشرفي هذا المنتدى</span>")}</td>
							</tr>
							<tr>
								<td class=\"asNormalB asS12\" align=\"center\" id=\"onlinef{$fid}\"><nobr>--</nobr></td>
							</tr>
						</table>
						</td>";
						$onlineForums[] = $fid;
						$cDetails['topics'] += $f['topics'];
						$cDetails['posts'] += $f['posts'];
						$fcount++;
						$fsplit++;
					}
				}
					echo"
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td class=\"asBody\" align=\"center\">
				<table cellSpacing=\"2\" cellPadding=\"3\">
					<tr>
						<td class=\"asTitle\">مجموع مواضيع</td><td class=\"asText2\">{$cDetails['topics']}</td>
						<td class=\"asTitle\">مجموع ردود</td><td class=\"asText2\">{$cDetails['posts']}</td>
						<td class=\"asTitle\">مجموع مواضيع في الأرشيف</td><td class=\"asText2\">{$cDetails['atopics']}</td>
						<td class=\"asTitle\">مجموع ردود في الأرشيف</td><td class=\"asText2\">{$cDetails['aposts']}</td>
						<td class=\"asTitle\">المراقب</td><td class=\"asText2 asAS12 asAC2\">".($c['hidemonhome']==0&&$c['monitor']>0 ? $Template->userNormalLink($c['monitor'],$c['monitorname']) : "<i>&nbsp;&nbsp;لا توجد&nbsp;&nbsp;</i>")."</td>
						<td class=\"asTitle\">نائب المراقب</td><td class=\"asText2 asAS12 asAC2\">".($c['hidemonhome']==0&&$c['submonitor']>0 ? $Template->userNormalLink($c['submonitor']) : "<i>&nbsp;&nbsp;لا توجد&nbsp;&nbsp;</i>")."</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>";
	}
	else{
		echo"
		<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
			<tr>
				<td class=\"asHeader\">{$c['subject']}</td>
			</tr>
			<tr>
				<td class=\"asBody\">
				<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"4\">
					<tr>
						<td class=\"asDark asLeftBorder\" colspan=\"2\" width=\"40%\"><nobr>اسم منتدى</nobr></td>
						<td class=\"asDark asLeftBorder\" width=\"5%\"><nobr>المواضيع</nobr></td>
						<td class=\"asDark asLeftBorder\" width=\"5%\"><nobr>الردود</nobr></td>
						<td class=\"asDark asLeftBorder\" width=\"3%\"><nobr>المتواجدون</nobr></td>
						<td class=\"asDark asLeftBorder\" width=\"10%\"><nobr>آخر مشاركة</nobr></td>
						<td class=\"asDark\" width=\"37%\">";
					if(ulv == 4){
						echo"
						<table width=\"100%\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">
							<tr>
								<td class=\"asC1\" align=\"center\"><nobr>المشرفون</nobr></td>
								<td width=\"30\" align=\"center\"><div class=\"forums-admenu\" tools=\"c|{$cid}|{$c['status']}\"><img src=\"images/icons/downopen.gif\"></div></td>
							</tr>
						</table>";
					}
					else{
						echo"<nobr>المشرفون</nobr>";
					}
						echo"</td>
					</tr>";
			$fcount = 0;
			$cDetails = array(
				'topics' 	=> 0,
				'posts' 	=> 0,
				'atopics' 	=> 0,
				'aposts' 	=> 0
			);
			foreach($forumList as $fid => $f){
				if($f['cid'] == $cid){
					echo"
					<tr>
						<td class=\"asNormal\" width=\"1%\"><img src=\"{$f['logo']}\" onError=\"this.src='{$DFImage->i['errorlogo']}';\" width=\"30\" height=\"30\" border=\"0\"></td>
						<td class=\"asNormal asLeftBorder asAddress\">
							<div>{$Template->forumLink($fid,$f['subject'])}</div>
							<div class=\"asDesc\">{$f['description']}</div>
						</td>
						<td class=\"asNormal asLeftBorder asCenter asS12\"><nobr>{$f['topics']}</nobr></td>
						<td class=\"asNormal asLeftBorder asCenter asS12\"><nobr>{$f['posts']}</nobr></td>
						<td class=\"asNormal asLeftBorder asCenter asS12\" id=\"onlinef{$fid}\"><nobr>--</nobr></td>
						<td class=\"asNormal asLeftBorder asCenter asAS12 asS12 asDate\">";
						if($f['lpauthor'] > 0 && $f['lpdate'] > 0){
							echo"<nobr>{$DF->date($f['lpdate'])}<br>{$Template->userColorLink($f['lpauthor'], $f['lpTools'])}<nobr>";
						}
						else{echo"&nbsp;";}
						echo"</td>
						<td class=\"asNormal asAS12\">";
						$moderators = ($f['hidemodhome'] == 0 ? (($homeMods = $Template->forumModerators($fid)) ? $homeMods : "&nbsp;") : "&nbsp;");
					if(ulv == 4){
						echo"
						<table width=\"100%\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">
							<tr>
								<td class=\"asS12\" align=\"center\">{$moderators}</td>
								<td width=\"30\" align=\"center\"><div class=\"forums-admenu\" tools=\"f|{$fid}|{$f['status']}|{$f['hidden']}\"><img src=\"images/icons/downopen.gif\"></div></td>
							</tr>
						</table>";
					}
					else{
						echo $Template->nbsp($moderators);
					}
					echo"</td>
					</tr>";
					$onlineForums[] = $fid;
					$cDetails['topics'] += $f['topics'];
					$cDetails['posts'] += $f['posts'];
					$fcount++;
				}
			}
				if($fcount == 0){
					echo"
					<tr>
						<td class=\"asNormal asCenter\" colspan=\"7\"><br>لا توجد أيه منتدى لهذه الفئة<br><br></td>
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
						<td class=\"asTitle\">مجموع مواضيع</td><td class=\"asText2\">{$cDetails['topics']}</td>
						<td class=\"asTitle\">مجموع ردود</td><td class=\"asText2\">{$cDetails['posts']}</td>
						<td class=\"asTitle\">مجموع مواضيع في الأرشيف</td><td class=\"asText2\">{$cDetails['atopics']}</td>
						<td class=\"asTitle\">مجموع ردود في الأرشيف</td><td class=\"asText2\">{$cDetails['aposts']}</td>
						<td class=\"asTitle\">المراقب</td><td class=\"asText2 asAS12 asAC2\">".($c['hidemonhome']==0&&$c['monitor']>0 ? $Template->userNormalLink($c['monitor'],$c['monitorname']) : "<i>&nbsp;&nbsp;لا توجد&nbsp;&nbsp;</i>")."</td>
						<td class=\"asTitle\">نائب المراقب</td><td class=\"asText2 asAS12 asAC2\">".($c['hidemonhome']==0&&$c['submonitor']>0 ? $Template->userNormalLink($c['submonitor']) : "<i>&nbsp;&nbsp;لا توجد&nbsp;&nbsp;</i>")."</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>";
	}
}
echo"<div onf=\"".implode("|", $onlineForums)."\"></div>";
$Template->footer();
?>