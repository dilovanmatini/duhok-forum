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

const _df_script = "forums";
const _df_filename = "forums.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$checkSqlField="";
$checkSqlTable="";
$checkSqlWhere="";
if(ulv<4&&!$is_moderator){
	$checkSqlWhere.="AND (f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id))";
	$checkSqlTable.="LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")";
}
$f=f;
$sql=$mysql->query("SELECT f.subject,f.logo,f.level,f.status,f.hidden,f.topics,f.posts,f.hidemodforum,ff.hidepm,
	IF(".ulv." > 0,COUNT(DISTINCT uo.ip)+COUNT(DISTINCT v.ip),0) AS fonline $checkSqlField
FROM ".prefix."forum AS f
LEFT JOIN ".prefix."forumflag AS ff ON(f.id = ff.id)
LEFT JOIN ".prefix."useronline AS uo ON(f.id = uo.forumid AND uo.level < 4)
LEFT JOIN ".prefix."visitors AS v ON(f.id = v.forumid) $checkSqlTable
WHERE f.id = $f $checkSqlWhere GROUP BY f.id", __FILE__, __LINE__);
$rs=$mysql->fetchAssoc($sql);

$checkLoginForum=false;
if($rs){
	$checkLoginForum=true;
}

$DF->catch['checkLoginForum'] = $checkLoginForum;
$DF->catch['forumSubject'] = $rs['subject'];
$DF->catch['forumOnlines'] = $rs['fonline'];

if($checkLoginForum&&$is_moderator){
	require_once _df_path."forumsoperations.php";
}
//<td class=\"asTitle\">متواجدون الآن في المنتدى</td><td class=\"asText2 asAC2 asAS12\"><a href=\"foruminfo.php?f=$f\">{$rs['fonline']}</a></td>
$Template->header();

if(!$checkLoginForum){
	$Template->errMsg("المنتدى المطلوب غير متوفر.<br><br>قد يكون هناك عدة إسباب لهذا منها:<br><br><table><tr><td>* رقم المنتدى المطلوب غير صحيح. </td></tr><tr><td>* المنتدى المطلوب تم حذفه نهائياً. </td></tr><tr><td>* المنتدى المطلوب لا يسمح لك بالدخول اليه. </td></tr></table>");
	exit();
}

//$DFOutput->setForumBrowse($f);

$authUrl=(auth>0 ? "&auth=".auth : "");
$optionUrl=(option!='' ? "&option=".option : "");
$pagingLink="forums.php?f={$f}{$authUrl}{$optionUrl}&";
?>
<?php if($is_moderator){ ?>
<script type="text/javascript" src="js/forums_mod.js<?=x?>"></script>
<?php } ?>
<script type="text/javascript">
$(function(){
	$.ajax({
		type: 'POST',
		url: 'ajax.php?x='+Math.floor(Math.random() * 999999999),
		data: 'type=set_data_to_database&method=forumsdotphp&f=<?=$f?>'
	});
});
var forumid=<?=$f?>;
var authURL="<?=$authUrl?>";
var numPages=<?=num_pages?>;
var pg=<?=pg?>;
var link="<?=$pagingLink?>";
</script>
<?php

$checkTopicSqlField="";
$checkTopicSqlTable="";
$checkTopicSqlWhere="";

if($is_moderator){
	switch(option){
		case'mo':
			$sqlOptions="AND t.moderate = 1";
			$optionsMessage="مواضيع تنتظر الموافقة";
		break;
		case'ho':
			$sqlOptions="AND t.moderate = 2";
			$optionsMessage="مواضيع مجمدة";
		break;
		case'rmo':
			$sqlOptions="AND NOT ISNULL(p.id)";
			$optionsMessage="ردود تنتظر الموافقة";
			$checkTopicSqlTable="LEFT JOIN ".prefix."post AS p ON(p.moderate = 1 AND p.topicid = t.id)";
			$checkTopicSqlField=",COUNT(p.id) AS postwait";
		break;
		case'rho':
			$sqlOptions="AND NOT ISNULL(p.id)";
			$optionsMessage="ردود مجمدة";
			$checkTopicSqlTable="LEFT JOIN ".prefix."post AS p ON(p.moderate = 2 AND p.topicid = t.id)";
			$checkTopicSqlField=",COUNT(p.id) AS posthold";
		break;
		case'hd':
			$sqlOptions="AND t.hidden = 1";
			$optionsMessage="مواضيع مخفية";
		break;
		case'vs':
			$sqlOptions="AND t.hidden = 0";
			$optionsMessage="مواضيع غير مخفية";
		break;
		case'lk':
			$sqlOptions="AND t.status = 0";
			$optionsMessage="مواضيع مقفولة";
		break;
		case'op':
			$sqlOptions="AND t.status = 1";
			$optionsMessage="مواضيع غير مقفولة";
		break;
		case't1':
			$sqlOptions="AND t.top = 1";
			$optionsMessage="مواضيع متميز بالنجمة";
		break;
		case't2':
			$sqlOptions="AND t.top = 2";
			$optionsMessage="مواضيع متميز بالميدالية";
		break;
		case'ua':
			$sqlOptions="AND t.archive = 1";
			$optionsMessage="مواضيع لا تنتقل للأرشيف";
		break;
		case'dl':
			$sqlOptions=($is_monitor ? "AND t.trash = 1" : "");
			$optionsMessage="مواضيع محذوفة";
		break;
		default:
			$sqlOptions="";
			$optionsMessage="";
	}
}
if(ulv>0){
	$sqlAuth=(auth>0 ? "AND t.author = ".auth."" : "");
	$sqlDelete=($is_monitor ? "" : "AND t.trash = 0");
	$sqlModerate=($is_moderator ? "" : "AND t.moderate < IF(t.author = ".uid.",3,1)");
	$sqlHidden=($is_moderator ? "" : "AND (t.hidden = 0 OR t.author = ".uid.")");
	$sqlApprove="$sqlOptions $sqlAuth $sqlDelete $sqlModerate $sqlHidden";
}
else{
	$sqlApprove="AND t.trash = 0 AND t.moderate = 0 AND t.hidden = 0";
}

$pagingQuery="topic AS t $checkTopicSqlTable WHERE t.forumid = $f $sqlOptions $sqlApprove";

echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
	<tr>
		<td class=\"asTopHeader\">
		<table cellSpacing=\"3\" cellPadding=\"3\">
			<tr>
				<td width=\"1000\">
				<table cellSpacing=\"0\" cellPadding=\"0\">
					<tr>
						<td rowspan=\"2\"><a href=\"foruminfo.php?f=$f\"><img class=\"asWDot\" src=\"{$rs['logo']}\" onError=\"this.src='{$DFImage->i['errorlogo']}';\" alt=\"معلومات عن المنتدى\" width=\"30\" height=\"30\" hspace=\"6\" border=\"0\"></a></td>
						<td class=\"asAS18\"><nobr>{$Template->forumLink($f,$rs['subject'],'','sec')}</nobr></td>
					</tr>
					<tr>";
					if(auth==0){
						if(!empty($optionsMessage)){
							echo"<td class=\"asS12 asC2\">-- $optionsMessage --</td>";
						}
						else{
							if($rs['hidemodforum']==0){
								echo"<td class=\"asAS12 asAC2 asC1\">{$Template->forumModerators()}</td>";
							}
						}
					}
					if(ulv>0&&auth>0&&auth==uid){
						echo"<td class=\"asS12 asC2\">-- مواضيعك فقط --</td>";
					}
					elseif(ulv>0&&auth>0&&auth!=uid){
						echo"<td class=\"asS12 asC2\">مواضيع العضو : {$mysql->get("user","name",auth)}</td>";
					}
					echo"
					</tr>
				</table>
				</td>
				<th class=\"asTHLink\"><nobr><a href=\"foruminfo.php?f={$f}\">متواجدون الآن<br>في هذا المنتدى<br>عدد أعضاء: <span class=\"asC2\">{$rs['fonline']}</span></a></nobr></td>
				<th class=\"asTHLink\"><nobr><a href=\"editor.php?type=newtopic&f={$f}&src=".urlencode(self)."\"><img src=\"{$DFImage->f['folder']}\" border=\"0\"><br>موضوع جديد</a></nobr></td>";
			if(ulv>0&&$rs['hidepm']==0||$is_moderator){	
				echo"
				<th class=\"asTHLink\"><nobr><a href=\"editor.php?type=sendpm&u=-{$f}&src=".urlencode(self)."\">أرسل رسالة<br>لمشرفي<br>هذا المنتدى</a></nobr></td>";
			}
			if(ulv>0&&auth==0){
				echo"
				<th class=\"asTHLink\"><nobr><a href=\"forums.php?f={$f}&auth=".uid."\">مواضيعك في<br>هذا المنتدى</a></nobr></td>";
			}
			elseif(ulv>0&&auth>0){
				echo"
				<th class=\"asTHLink\"><nobr><a href=\"forums.php?f={$f}\">جميع مواضيع<br>هذا المنتدى</a></nobr></td>";
			}
				$Template->topicsOrderBy();
				$Template->refreshPage();
				$Template->basicPaging($pagingQuery,"t.id");
				$Template->goToForum();
			echo"
			</tr>
		</table>
		</td>
	</tr>
</table>";
$sql=$mysql->query("SELECT id,subject FROM ".prefix."topic WHERE forumid = '$f' AND link = 1", __FILE__, __LINE__);
if($mysql->numRows($sql)>0){
	echo"
	<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
		<tr>
			<td class=\"asTopHeader\">
			<table cellSpacing=\"3\" cellPadding=\"3\">
				<tr>";
				while($lrs=$mysql->fetchRow($sql)){
					if($is_moderator){
						$fLinkTools="<td><a href=\"javascript:DF.command($lrs[0],'ul');\"><img src=\"{$DFImage->i['close']}\" alt=\"إزالة هذا الموضوع من وصلات منتدى\" hspace=\"2\" border=\"0\"></a></td>";
					}
					echo"
					<th class=\"asTHLink\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr>$fLinkTools<td><nobr>{$Template->topicLink($lrs[0],$lrs[1])}</nobr></td></tr></table></td>";
				}
					echo"
					<td width=\"100%\"></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>";
}
echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">";
if($is_moderator){
	echo"
	<tr>
		<td class=\"asHeader\">
		<form name=\"info\" method=\"post\" action=\"".self."\" style=\"margin:0px\"><input type=\"hidden\" name=\"type\"><input type=\"hidden\" name=\"id\"><input type=\"hidden\" name=\"cmd\"><input type=\"hidden\" name=\"other\"></form>
		<table width=\"96%\" cellSpacing=\"0\" cellPadding=\"0\" align=\"center\" border=\"0\">
			<form method=\"post\" action=\"".self."\">
			<input type=\"hidden\" name=\"id\">
			<input type=\"hidden\" name=\"cmd\">
			<input type=\"hidden\" name=\"other\">
			<tr>
				<td>
				<select class=\"asGoTo asS12\" style=\"width:250px\" name=\"type\" onChange=\"DF.chkChange(this.form, true)\">
					<option value=\"0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- خيارات المواضيع --</option>
					<option value=\"mo\">موافقة على المواضيع المختارة</option>
					<option value=\"ho\">تجميد مواضيع المختارة</option>
					<option value=\"hd\">إخفاء مواضيع المختارة</option>
					<option value=\"vs\">إظهار مواضيع المختارة</option>
					<option value=\"lk\">قفل مواضيع المختارة</option>
					<option value=\"op\">فتح مواضيع المختارة</option>
					<option value=\"st\">تثبيت مواضيع المختارة</option>
					<option value=\"us\">إلغاء تثبيت مواضيع المختارة</option>
					<option value=\"yv\">عرض موضوع للجميع</option>
					<option value=\"nv\">عرض موضوع فقط لأعضاء مسجلين</option>
					<option value=\"t0\">إلغاء شعار التميز لمواضيع المختارة</option>
					<option value=\"t1\">منح نجمة لمواضيع المختارة</option>
					<option value=\"t2\">منح ميدالية لمواضيع المختارة</option>
					<option value=\"ln\">يجعل مواضيع المختارة كوصلات منتدى</option>
					<option value=\"mv\">نقل مواضيع المختارة</option>";
				if($is_monitor){
					echo"
					<option value=\"dl\">حذف مواضيع المختارة</option>
					<option value=\"re\">إرجاع مواضيع المختارة</option>
					<option value=\"ar\">يمكن نقل مواضيع المختارة للأرشيف</option>
					<option value=\"ua\">لا يمكن نقل مواضيع المختارة للأرشيف</option>";
				}
				echo"
				</select>
				</td>
				<td>&nbsp;</td>
				<td id=\"moveForumList\"></td>
				<td>&nbsp;</td>
				<td>{$Template->button("تطـبيق"," onclick=\"DF.chkClick(this.form)\" name=\"ok\"")}</td>
				<td width=\"50%\">&nbsp;</td>
				<td>
				<select class=\"asGoTo asS12\" style=\"width:250px\" name=\"option\" onChange=\"DF.chkOptions(this);\">
					<option value=\"\" {$DF->choose(option,'','s')}>خيارات الإشراف: التصفح العادي</option>
					<option value=\"mo\" {$DF->choose(option,'mo','s')}>خيارات الإشراف: مواضيع تنتظر الموافقة</option>
					<option value=\"ho\" {$DF->choose(option,'ho','s')}>خيارات الإشراف: مواضيع مجمدة</option>
					<option value=\"rmo\" {$DF->choose(option,'rmo','s')}>خيارات الإشراف: ردود تنتظر الموافقة</option>
					<option value=\"rho\" {$DF->choose(option,'rho','s')}>خيارات الإشراف: ردود مجمدة</option>
					<option value=\"hd\" {$DF->choose(option,'hd','s')}>خيارات الإشراف: مواضيع مخفية</option>
					<option value=\"vs\" {$DF->choose(option,'vs','s')}>خيارات الإشراف: مواضيع غير مخفية</option>
					<option value=\"lk\" {$DF->choose(option,'lk','s')}>خيارات الإشراف: مواضيع مقفولة</option>
					<option value=\"op\" {$DF->choose(option,'op','s')}>خيارات الإشراف: مواضيع غير مقفولة</option>
					<option value=\"t1\" {$DF->choose(option,'t1','s')}>خيارات الإشراف: مواضيع متميز بالنجمة</option>
					<option value=\"t2\" {$DF->choose(option,'t2','s')}>خيارات الإشراف: مواضيع متميز بالميدالية</option>
					<option value=\"ua\" {$DF->choose(option,'ua','s')}>خيارات الإشراف: مواضيع لا تنتقل للأرشيف</option>";
				if($is_monitor){
					echo"
					<option value=\"dl\" {$DF->choose(option,'d','s')}>خيارات الإشراف: مواضيع محذوفة</option>";
				}
				echo"
				</select>
				</td>
			</tr>
		</table>
		</td>
	</tr>";
}
else{
	echo"
	<tr>
		<td class=\"asHeader\">{$rs['subject']}</td>
	</tr>";
}
	echo"
	<tr>
		<td class=\"asBody\">
		<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"4\">
			<tr>";
	if($is_moderator){
		echo"
		<td class=\"asDark asLeftBorder\" width=\"1%\"><input type=\"checkbox\" class=\"none\" name=\"chkAll\" title=\"تحديد الكل\" onClick=\"DF.chkBox(this.form,this);\"></td>";
	}
		echo"
		<td class=\"asDark asLeftBorder\" width=\"60%\" colSpan=\"2\">الموضوع</td>
		<td class=\"asDark asLeftBorder\" width=\"10%\">الكاتب</td>
		<td class=\"asDark asLeftBorder\" width=\"5%\">الردود</td>
		<td class=\"asDark asLeftBorder\" width=\"5%\">قرأت</td>
		<td class=\"asDark\" width=\"10%\"><nobr>آخر رد</nobr></td>";
	if(ulv>0){
		echo"
		<td class=\"asDark asRightBorder\" width=\"10%\">الخيارات</td>";
	}
	echo"
	</tr>";
$sqlOrderBy=(topics_order_by=="topics" ? ",t.date DESC,t.lpdate DESC" : ",t.lpdate DESC,t.date DESC");
$pgLimit=$DF->pgLimit(num_pages);
$sql=$mysql->query("SELECT t.id,t.hidden,t.sticky,t.moderate,t.status,t.trash,t.survey,t.archive,t.top,t.link,t.subject,t.author,
	t.lpauthor,t.date,t.lpdate,t.posts,t.views,t.viewforusers,
	u.name AS authorname,u.status AS authorstatus,u.level AS authorlevel,u.submonitor AS authorsubmonitor,uu.name AS lpauthorname,
	uu.status AS lpauthorstatus,uu.level AS lpauthorlevel,uu.submonitor AS lpauthorsubmonitor {$checkTopicSqlField}
FROM ".prefix."topic AS t
LEFT JOIN ".prefix."user AS u ON(u.id = t.author)
LEFT JOIN ".prefix."user AS uu ON(uu.id = t.lpauthor) {$checkTopicSqlTable}
WHERE t.forumid = {$f} {$sqlApprove} GROUP BY t.id ORDER BY t.sticky DESC {$sqlOrderBy} LIMIT {$pgLimit},".num_pages, __FILE__, __LINE__);
$count=0;
while($topics=$mysql->fetchAssoc($sql)){
	$t=$topics['id'];
	$authorTools = array($topics['authorname'], $topics['authorstatus'], $topics['authorlevel'], $topics['authorsubmonitor']);
	$lpAuthorTools = array($topics['lpauthorname'], $topics['lpauthorstatus'], $topics['lpauthorlevel'], $topics['lpauthorsubmonitor']);
	
	if($topics['trash']==1){
		$trClass="asDelete";
	}
	else{
		if($topics['hidden']==1){
			$trClass="asHidden";
		}
		else{
			if($topics['sticky']==1){
				$trClass="asFixed";
			}
			else{
				$trClass="asNormal";
			}
		}
	}
	
	if($topics['moderate']==1){
		$imgSrc=$DFImage->f['moderate'];
		$imgAlt="موضوع تنتظر الموافقة";
	}
	elseif($topics['moderate']==2){
		$imgSrc=$DFImage->f['held'];
		$imgAlt="موضوع مجمد";
	}
	elseif($topics['trash']==1){
		$imgSrc=$DFImage->f['delete'];
		$imgAlt="موضوع محذوف";
	}
	elseif($topics['status']==0){
		$imgSrc=$DFImage->f['lock'];
		$imgAlt="موضوع مقفل";
	}
	elseif($topics['status']==1&&$topics['posts']>14){
		$imgSrc=$DFImage->f['hot'];
		$imgAlt="موضوع نشط";
	}	
	else{
		$imgSrc=$DFImage->f['folder'];
		$imgAlt="موضوع مفتوح";
	}
	$surveyLogo=array('src'=>'','alt'=>'');
	if($topics['survey']>0){
		$surveyLogo['src']=$DFImage->i['survey'];
		$surveyLogo['alt']="موضوع يحتوي على استفتاء";
	}
	$topLogo=array('src'=>'','alt'=>'');
	if($topics['top']==1){
		$topLogo['src']=$DFImage->i['star_red'];
		$topLogo['alt']="هذا الموضوع متميز";
	}
	elseif($topics['top']==2){
		$topLogo['src']=$DFImage->i['top'];
		$topLogo['alt']="هذا الموضوع متميز";
	}
	
	if($is_moderator){
		$jsTopics.="topics[$t]=[{$topics['status']},{$topics['sticky']},{$topics['hidden']},{$topics['moderate']},{$topics['trash']},{$topics['archive']},{$topics['top']},0,{$topics['link']},{$topics['author']},{$topics['viewforusers']}];";
	}
	echo"
	<tr id=\"tr$t\">";
	if($is_moderator){
		echo"
		<td class=\"$trClass asLeftBorder asCenter\"><nobr><input type=\"checkbox\" onClick=\"DF.chkFrmTrClass(this,$t);\" class=\"none\" name=\"topics[]\" value=\"$t\"></nobr></td>";
	}
		echo"
		<td class=\"$trClass asCenter\" width=\"1%\"><img src=\"$imgSrc\" alt=\"$imgAlt\"></td>
		<td class=\"$trClass asLeftBorder\">
		<table cellpadding=\"1\" cellsapcing=\"0\">
			<tr>";
			if(!empty($surveyLogo['src'])){
				echo"
				<td><img src=\"{$surveyLogo['src']}\" alt=\"{$surveyLogo['alt']}\"></td>";
			}
			if(!empty($topLogo['src'])){
				echo"
				<td><img src=\"{$topLogo['src']}\" alt=\"{$topLogo['alt']}\"></td>";
			}
			if($topics['viewforusers'] == 1){
				echo"
				<td><a class=\"asTooltip\"><img src=\"styles/folders/no_visitor.png\">{$Template->tooltip('الموضوع حالياً يعرض فقط لأعضاء مسجلين')}</a></td>";
			}
				echo"
				<td class=\"asAddress\">{$Template->topicLink($t,$topics['subject'])}".($topics['posts']>0?$Template->topicPaging($t,$topics['posts']):"")."</td>
			</tr>
		</table>
		</td>
		<td class=\"$trClass asLeftBorder asCenter asAS12 asS12 asDate\"><nobr>{$DF->date($topics['date'])}<br>{$Template->userColorLink($topics['author'],$authorTools)}</td>
		<td class=\"$trClass asLeftBorder asCenter asS12\">{$topics['posts']}</td>
		<td class=\"$trClass asLeftBorder asCenter asS12\">{$topics['views']}</td>
		<td class=\"$trClass asCenter asAS12 asS12 asDate\">";
		if($topics['posts']>0){
			echo"<nobr>{$DF->date($topics['lpdate'])}</nobr><br>{$Template->userColorLink($topics['lpauthor'],$lpAuthorTools)}";
		}else{echo"&nbsp;";}
		echo"</td>";
	if(ulv>0){
		echo"
		<td class=\"$trClass asRightBorder asCenter\"><nobr>";
	if($is_moderator){
		if(option=='rmo'){
			echo"
			<a href=\"topics.php?t=$t&option=mo\"><img src=\"{$DFImage->i['approve']}\" alt=\"إذهب الى ردود ينتظر الموافقة وعددها {$topics['postwait']}\" hspace=\"2\" border=\"0\"></a>";
		}
		if(option=='rho'){
			echo"
			<a href=\"topics.php?t=$t&option=ho\"><img src=\"{$DFImage->i['hold']}\" alt=\"إذهب الى ردود مجمدة وعددها {$topics['posthold']}\" hspace=\"2\" border=\"0\"></a>";
		}
		if($topics['moderate']>0){
			echo"
			<a href=\"javascript:DF.command($t,'mo');\"><img src=\"{$DFImage->f['approve']}\" alt=\"موافقة على الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		if($topics['moderate']==1){
			echo"
			<a href=\"javascript:DF.command($t,'ho');\"><img src=\"{$DFImage->f['hold']}\" alt=\"تجميد الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		if($topics['status']==1){
			echo"
			<a href=\"javascript:DF.command($t,'lk');\"><img src=\"{$DFImage->f['lock']}\" alt=\"قفل الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		if($topics['status']==0){
			echo"
			<a href=\"javascript:DF.command($t,'op');\"><img src=\"{$DFImage->f['unlock']}\" alt=\"فتح الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		if($topics['sticky']==0){
			echo"
			<a href=\"javascript:DF.command($t,'st');\"><img src=\"{$DFImage->f['sticky']}\" alt=\"تثبيت الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		if($topics['sticky']==1){
			echo"
			<a href=\"javascript:DF.command($t,'us');\"><img src=\"{$DFImage->f['unsticky']}\" alt=\"إلغاء تثبيت الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		if($topics['hidden']==0){
			echo"
			<a href=\"javascript:DF.command($t,'hd');\"><img src=\"{$DFImage->f['hidden']}\" alt=\"إخفاء الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		if($topics['hidden']==1){
			echo"
			<a href=\"javascript:DF.command($t,'vs');\"><img src=\"{$DFImage->f['visible']}\" alt=\"إظهار الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
	}
		if($is_moderator||$topics['status']==1&&$topics['author']==uid){
			echo"
			<a href=\"editor.php?type=edittopic&t=$t&src=".urlencode(self)."\"><img src=\"{$DFImage->f['edit']}\" alt=\"تعديل الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		if($is_monitor&&$topics['trash']==0){
			echo"
			<a href=\"javascript:DF.command($t,'dl');\"><img src=\"{$DFImage->f['delete']}\" alt=\"حذف الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		if($is_monitor&&$topics['trash']==1){
			echo"
			<a href=\"javascript:DF.command($t,'re');\"><img src=\"{$DFImage->f['restore_delete']}\" alt=\"إرجاع الموضوع من الحذف\" hspace=\"2\" border=\"0\"></a>";
		}
		if(ulv>0&&$topics['status']==1||$is_moderator){
			echo"
			<a href=\"editor.php?type=newpost&t=$t&src=".urlencode(self)."\"><img src=\"{$DFImage->i['reply']}\" alt=\"رد على الموضوع\" hspace=\"2\" border=\"0\"></a>";
		}
		if(auth>0){
			echo"
			<a href=\"topics.php?t=$t&u=".auth."\"><img src=\"{$DFImage->i['users']}\" alt=\"".(auth==uid?"مشاركاتك فقط في هذا الموضوع":"مشاركات هذا العضو فقط في هذا الموضوع")."\" hspace=\"2\" border=\"0\"></a>";
		}
		echo"&nbsp;
		</td>";
	}
	echo"
	</tr>";
	$count++;
}
if($count==0){
	$msg=(option!=''?'لا توجد أي موضوع يطابق خيارات الذي انت اخترت':'لا توجد أي موضوع في هذا المنتدى');
	echo"
	<tr>
		<td class=\"asNormal asCenter\" colspan=\"8\"><br>$msg<br><br></td>
	</tr>";
}
		echo"
		</table>
		</td>
	</tr>
	<tr>
		<td class=\"asBody\">
		<table cellSpacing=\"2\" cellPadding=\"3\">
			<tr>";
		if($is_moderator){
				echo"
				<td class=\"asNormal asCenter asS12\">موضوع<br>عادي</td>
				<td class=\"asFixed asCenter asS12\">موضوع<br>مثبت</td>
				<td class=\"asHidden asCenter asS12\">موضوع<br>مخفي</td>";
			if($is_monitor){
				echo"
				<td class=\"asDelete asCenter asS12\">موضوع<br>محذوف</td>";
			}
				echo"
				<td class=\"asSelect asCenter asS12\">موضوع<br>مختار</td>";
		}
				echo"
				<td class=\"asTitle\">عدد مواضيع</td><td class=\"asText2 asAC2 asAS12\">{$rs['topics']}</td>
				<td class=\"asTitle\">عدد ردود</td><td class=\"asText2 asAC2 asAS12\">{$rs['posts']}</td>
			</tr>
		</table>
		</td>
	</tr>
</form>
</table>";
if($is_moderator){
	echo"<script type=\"text/javascript\">var topics=new Array();$jsTopics</script>";
}
$Template->footer();
?>