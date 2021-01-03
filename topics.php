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

const _df_script = "topics";
const _df_filename = "topics.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$checkSqlField="";
$checkSqlTable="";
$checkSqlWhere="";
if(ulv < 4 && !$isModerator){
	$checkSqlWhere = "
		AND (f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id))
		AND (t.trash = 0 AND (t.moderate = 0 OR t.author = ".uid.") AND (t.hidden = 0 OR NOT ISNULL(tu.id) OR t.author = ".uid."))
	";
	$checkSqlTable = "
		LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = t.forumid AND fu.userid = ".uid.")
		LEFT JOIN ".prefix."topicusers AS tu ON(tu.topicid = t.id AND tu.userid = ".uid.")
	";
}
$f = $thisForum;
$t = t;
$sql = $mysql->query("SELECT f.subject AS fsubject,f.logo,ff.hidesignature,ff.hideprofile,ff.hidephoto,f.hidden AS fhidden,f.level AS flevel,
	t.status,t.hidden,t.subject,t.moderate,t.trash,t.survey,t.sticky,t.top,t.subject,t.author,t.posts,t.editby,t.editdate,t.editnum,t.date,t.viewforusers,
	t.allownotify,u.name AS aname,u.status AS astatus,u.level AS alevel,u.submonitor AS asubmonitor,uf.posts AS aposts,uf.points AS apoints,uf.sex AS asex,
	uf.oldlevel AS aoldlevel,uf.title AS atitle,uf.picture AS apicture,up.hidesignature AS ahidesignature,
	up.hidephoto AS ahidephoto,up.hidetopics AS ahidetopics,ic.name AS acountry,u.date AS adate,
	uu.name AS editbyname,".((topics_signature == 'visible') ? "uf.signature," : "")." tm.message,
	tm.operations,IF(uo.userid > 0,1,0) AS isonline
FROM ".prefix."topic AS t
LEFT JOIN ".prefix."topicmessage AS tm ON(tm.id = t.id)
LEFT JOIN ".prefix."user AS u ON(u.id = t.author)
LEFT JOIN ".prefix."user AS uu ON(uu.id = t.editby)
LEFT JOIN ".prefix."userflag AS uf ON(uf.id = t.author)
LEFT JOIN ".prefix."userperm AS up ON(up.id = t.author)
LEFT JOIN ".prefix."country AS ic ON(ic.code = uf.country)
LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
LEFT JOIN ".prefix."forumflag AS ff ON(ff.id = t.forumid)
LEFT JOIN ".prefix."useronline AS uo ON(uo.userid = t.author AND (up.hidebrowse = 0 OR ".ulv." > 1 AND u.level < 3 OR ".ulv." > 2 AND u.level < 4 OR ".ulv." = 4)) $checkSqlTable
WHERE t.id = '{$t}' {$checkSqlWhere} GROUP BY t.id", __FILE__, __LINE__);
$topic = $mysql->fetchAssoc($sql);

$checkLoginTopic=false;
if($topic){
	$checkLoginTopic=true;
}

if($checkLoginTopic){
	require_once _df_path."includes/func.topics.php";
	if(ulv>1){
		require_once _df_path."topicsoperations.php";
	}
}

$DF->catch['forumSubject']=$topic['fsubject'];
$DF->catch['topicSubject']=$topic['subject'];

$theUserName = (u > 0) ? $mysql->get("user", "name", u) : '';
$pagingLink = "topics.php?t={$t}&".(!empty($theUserName) ? "u=".u."&" : "").(option!='' ? "option=".option."&" : "");

if($checkLoginTopic && ulv > 0){
	$allownotify = explode(",", $topic['allownotify']);
	if(isset($_GET['receivenotify'])){
		$receivenotify = intval($_GET['receivenotify']);
		if($receivenotify == 1){
			if($topic['author'] == uid){
				$allownotify = $DF->arrayDeleteValue($allownotify, -(uid));
			}
			else{
				if(!in_array(uid, $allownotify)){
					$allownotify[] = uid;
				}
			}
			$alertnotify_status = 1;
		}
		else{
			if($topic['author'] == uid){
				if(!in_array(-(uid), $allownotify)){
					$allownotify[] = -(uid);
				}
			}
			else{
				$allownotify = $DF->arrayDeleteValue($allownotify, uid);
			}
			$alertnotify_status = 0;
		}
		$mysql->update("topic SET allownotify = '".implode(",", $allownotify)."' WHERE id = {$t}", __FILE__, __LINE__);
		$DF->quick("{$pagingLink}alertnotify={$alertnotify_status}");
	}
	if($topic['author'] == uid && !in_array(-(uid), $allownotify)){
		$receive_notify = (!in_array(-(uid), $allownotify)) ? true : false;
	}
	else{
		$receive_notify = (in_array(uid, $allownotify)) ? true : false;
	}
	if(isset($_GET['alertnotify'])){
		$alertnotify = intval($_GET['alertnotify']);
		$alertnotify_text = ($alertnotify == 1) ? 'تم تفعيل إستقبال إشعارات من هذا الموضوع' : 'تم إلغاء إستقبال إشعارات من هذا الموضوع';
	}
}

$Template->header();

if(!$checkLoginTopic){
	$Template->errMsg("الموضوع المطلوب غير متوفر.<br><br>قد يكون هناك عدة إسباب لهذا منها:<br><br><table><tr><td>* رقم الموضوع المطلوب غير صحيح.</td></tr><tr><td>* الموضوع لم تتم الموافقة عليه للآن من قبل طاقم الإشراف.</td></tr><tr><td>* الموضوع تم تجميده أو حذفه أو إخفاؤه.</td></tr><tr><td>* المنتدى الذي فيه الموضوع لا يسمح لك بالدخول اليه.</td></tr></table>");
	exit();
}


if(ulv == 0 and intval($topic['viewforusers']) == 1){
	$Template->errMsg("لا يمكنك مشاهدة محتوي الموضوع الا أن تقوم بتسجيل الدخول<br>إذا أنت غير مسجل عندنا انقر فوق أيقونة أدناه للتسجيل<br><a href=\"register.php\"><img src=\"images/large-icons/changename.gif\" border=\"0\"></a>", 1, false);
	exit();
}

//$DFOutput->setForumBrowse($f);

if($topic['status']==1&&$topic['posts']>=topic_max_posts){
	$lockTopicByMaxPosts=",status = 0";
	$topic['status']=0;
}
$mysql->update("topic SET views = views + 1 $lockTopicByMaxPosts WHERE id = '$t'", __FILE__, __LINE__);
//$DFOutput->setUserActivity('topicview', $f, $topic['author']);


?>
<?php if($isModerator){ ?>
<script type="text/javascript" src="js/topics_mod.js<?=x?>"></script>
<?php } ?>
<script type="text/javascript" src="js/share.js<?=x?>"></script>
<script type="text/javascript">
$(function(){
	$.ajax({
		type: 'POST',
		url: 'ajax.php?x='+Math.floor(Math.random() * 999999999),
		data: 'type=set_data_to_database&method=topicdotphp&f=<?=$f?>&author=<?=$topic['author']?>'
	});
	var closeMsg = function(){
		$('#alertnotify').animate({
			opacity: 0,
			height: 'toggle'
		}, 1000);
	};
	setTimeout(closeMsg, 3000);
});
var forumid=<?=$f?>,topicid=<?=$t?>,tauthor=<?=$topic['author']?>,numPages=<?=post_num_page?>,pg=<?=pg?>,link="<?=$pagingLink?>";
</script>
<?php

$checkPostWhereSql="";
if(p>0){
	$checkPostWhereSql.="AND p.id = '".p."' ";
}
elseif(option=='nr'&&$isModerator){
	$checkPostWhereSql.="AND p.trash = 0 AND p.moderate = 0 AND p.hidden = 0 ";
}
elseif(option=='dl'&&$isMonitor){
	$checkPostWhereSql.="AND p.trash = 1 ";
}
elseif(option=='hd'&&$isModerator){
	$checkPostWhereSql.="AND p.hidden = 1 ";
}
elseif(option=='mo'&&$isModerator){
	$checkPostWhereSql.="AND p.moderate = 1 ";
}
elseif(option=='ho'&&$isModerator){
	$checkPostWhereSql.="AND p.moderate = 2 ";
}

if(p==0&&!empty($theUserName)){
	$checkPostWhereSql.="AND p.author = '".u."' ";
}

if(ulv<4&&!$isModerator){
	$checkPostWhereSql.="AND p.trash <> 1 AND (p.moderate = 0 OR p.author = '".uid."') AND (p.hidden = 0 OR p.author = '".uid."') ";
}
$pagingQuery="post AS p WHERE p.topicid = '$t' $checkPostWhereSql";

if(!empty($alertnotify_text)){
	echo"<div id=\"alertnotify\">";
	$Template->msgBox($alertnotify_text, 'green', 10, 0, true, false);
	echo"</div>";
}

echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
	<tr>
		<td class=\"asTopHeader\">
		<table cellSpacing=\"3\" cellPadding=\"3\">
			<tr>
				<td width=\"1000\">
				<table cellSpacing=\"0\" cellPadding=\"0\">
					<tr>
						<td rowspan=\"2\"><a href=\"foruminfo.php?f=$f\"><img class=\"asWDot\" src=\"{$topic['logo']}\" onError=\"this.src='{$DFImage->i['errorlogo']}';\" alt=\"معلومات عن المنتدى\" width=\"30\" height=\"30\" hspace=\"6\" border=\"0\"></a></td>
						<td class=\"asAS18\"><nobr>{$Template->forumLink($f,$topic['fsubject'],'','sec')}</nobr></td>
					</tr>
				</table>
				</td>
				<th class=\"asTHLink\"><nobr><a href=\"editor.php?type=newpost&t=$t&src=".urlencode(self)."\"><img src=\"{$DFImage->i['reply']}\" alt=\"رد على الموضوع\" border=\"0\"><br>أضف رد</a></nobr></th>
				<th class=\"asTHLink\"><nobr><a href=\"editor.php?type=newtopic&f=$f&src=".urlencode(self)."\"><img src=\"{$DFImage->f['folder']}\" alt=\"أضف موضوع جديد\" border=\"0\"><br>موضوع جديد</a></nobr></th>";
			if(ulv > 0){
				$receive_notify_link = ($receive_notify) ? 0 : 1;
				$receive_notify_text = ($receive_notify) ? 'لا استقبل<br>إشعارات' : 'إستقبال<br>إشعارات';
				echo"
				<th class=\"asTHLink\"><nobr><a href=\"{$pagingLink}receivenotify={$receive_notify_link}\">{$receive_notify_text}</a></nobr></th>";
			}
				echo"
				<th class=\"asTHLink\"><nobr><a href=\"sendtopic.php?t=$t\"><img src=\"{$DFImage->i['send']}\" alt=\"أرسل هدا الموضوع الى صديق\" border=\"0\"><br>أرسل</a></nobr></th>";
			if(ulv>0){
				echo"
				<th class=\"asTHLink\"><nobr><a href=\"favorite.php?type=add&t=$t\"><img src=\"{$DFImage->i['favorite']}\" alt=\"أضف الى المفضلة\" border=\"0\"><br>المفضلة</a></nobr></th>";
			}
				echo"
				<th class=\"asTHLink\"><nobr><a href=\"print.php?t=$t\"><img src=\"{$DFImage->i['print']}\" alt=\"طباعة موضوع\" border=\"0\"><br>طباعة</a></nobr></th>";
				echo ($signatureMenu=signatureMenu());
				echo ($postNumPageMenu=postNumPageMenu());
				echo ($basicPaging=$Template->basicPaging($pagingQuery,"p.id",true,post_num_page));
				echo ($goToForum=$Template->goToForum(true));
			echo"
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class=\"asHeader\">
		<table cellSpacing=\"0\" cellPadding=\"0\">
			<tr>
				<td>".($topicFolder=topicFolder($topic['trash'],$topic['moderate'],$topic['status']))."</td>
				<td class=\"asC1 asAddress asCenter\" width=\"100%\"><nobr>{$topic['subject']}</nobr></td>
				<td class=\"asHP2\"><a href=\"javascript:DF.share.gotoSharingList(1);\"><img src=\"images/share/share.gif\" border=\"0\"></a></td>
				<td class=\"asHP2\"><a href=\"javascript:DF.share.gotoShare('yahoo');\"><img src=\"images/share/yahoo2.gif\" border=\"0\"></a></td>
				<td class=\"asHP2\"><a href=\"javascript:DF.share.gotoShare('twitter');\"><img src=\"images/share/twitter2.gif\" border=\"0\"></a></td>
				<td class=\"asHP2\"><a href=\"javascript:DF.share.gotoShare('facebook');\"><img src=\"images/share/facebook2.gif\" border=\"0\"></a></td>";
				modOptions(1);
			echo"
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class=\"asBody\">
		<div id=\"sharePanel1\" style=\"margin:2px;border:gray 1px solid;background-color:#f0f0f0;text-align:center;visibility:hidden;position:absolute;top:2px;left:2px\"></div>
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\">";
if($isModerator){
	echo"
	<form id=\"optionsFrm\" name=\"optionsFrm\" method=\"post\" action=\"".self."\" style=\"margin:0\">
	<input type=\"hidden\" name=\"type\">
	<input type=\"hidden\" name=\"other\">
	<input type=\"hidden\" name=\"posttype\">
	<input type=\"hidden\" name=\"id\">
	<input type=\"hidden\" name=\"cmd\">";
}
if(p>0){
	$useToolsMsg="رد معين من الموضوع";
}
elseif(option=='nr'&&$isModerator){
	$optionMsg=" اعتيادية";
}
elseif(option=='dl'&&$isMonitor){
	$optionMsg=" محذوفة";
}
elseif(option=='hd'&&$isModerator){
	$optionMsg=" مخفية";
}
elseif(option=='mo'&&$isModerator){
	$optionMsg=" تنتظر الموافقة";
}
elseif(option=='ho'&&$isModerator){
	$optionMsg=" مجمدة";
}

if(p==0&&!empty($theUserName)){
	$optionMsg.=" للعضو $theUserName";
}

if(!empty($optionMsg)){
	$useToolsMsg="جميع ردود{$optionMsg}";
}

if(!empty($useToolsMsg)){
	echo"
	<tr>
		<td class=\"asText asAC2 asAS12 asCenter asP5\" colspan=\"2\"><b>يعرض حالياً $useToolsMsg - لمشاهدة الموضوع بالكامل <a href=\"topics.php?t=".t."\">إضغط هنا</a></b></td>
	</tr>";
}

if(pg<=1&&p==0&&option==''&&(u==0||$topic['author']==u)){
//************** start topic *****************
	if($topic['trash']==1){
		$rowClass="asDelete";
		$postErrorMsg="** هذا الموضوع محذوف **";
	}
	elseif($topic['ahidetopics']==1){
		$rowClass="asFirst";
		$postErrorMsg="** تم إخفاء نص هذه المشاركة بواسطة الإدارة **";
	}
	elseif($topic['moderate']==1){
		$rowClass="asFirst";
		$postErrorMsg="** هذا الموضوع لم يتم مراجعته والموافقة عليه بواسطة مشرف المنتدى حتى الآن **";
	}
	elseif($topic['moderate']==2){
		$rowClass="asFirst";
		$postErrorMsg="** هذا الموضوع مجمد حتى إشعار آخر -- للإستفسار عن سبب الرجاء الإتصال بمشرف المنتدى **";
	}
	elseif($topic['hidden']==1){
		$rowClass="asHidden";
		$postErrorMsg="** تم اخفاء هذا الموضوع -- للإستفسار عن السبب الرجاء الإتصال بمشرف المنتدى **";
	}
	else{
		$rowClass="asFirst";
		$postErrorMsg="";
	}
	
	echo"
	<tr>
		<td class=\"{$rowClass}\" width=\"17%\" align=\"center\" vAlign=\"top\">";
if($topic['alevel'] == 4){
	echo"
	<table width=\"100%\" cellspacing=\"0\" cellpadding=\"4\">
		<tr>
			<td class=\"asHeader\">{$Template->userNormalLink($topic['author'],$topic['aname'],'white')}</td>
		</tr>";
	if(!empty($topic['atitle'])){
		echo"
		<tr>
			<td class=\"asNormalDot asS12 asCenter\">{$topic['atitle']}</td>
		</tr>";
	}
	echo"
	</table>";
}
else{
	echo"
	<table width=\"100%\" cellspacing=\"1\" cellpadding=\"4\">
		<tr>
			<td class=\"asDarkDot asAC1\" colspan=\"2\">{$Template->userNormalLink($topic['author'],$topic['aname'])}</td>
		</tr>";
	if(ulv>0&&$topic['astatus']==0){
		echo"
		<tr>
			<td class=\"asNormalDot asS12 asCenter\" colspan=\"2\"><font color=\"red\">عضوية مقفولة</font></td>
		</tr>";
	}
	if(ulv>0&&($topic['astatus']==1||$isModerator)&&($topic['hideprofile']==0||$isModerator)){
	/******************* Start user details ********************/
	if($topic['ahidephoto']==0||$isModerator){
		echo"
		<tr>
			<td class=\"asNormalDot asCenter\" colspan=\"2\"><img src=\"{$DFPhotos->getsrc($topic['apicture'], 200)}\"{$DF->picError(100)} width=\"100\" height=\"100\" class=\"asBGray\" border=\"0\"></td>
		</tr>";
	}
	$userStars = $DF->userStars($topic['aposts'], $topic['alevel'], $topic['asubmonitor']);
	$userAllTitles = userAllTitles($topic['author'], $topic['alevel'], $topic['aposts'], $topic['atitle'], $topic['asex'], $topic['aoldlevel'], $topic['asubmonitor']);
	$topic_stars_titles = array();
	if(!empty($userStars)){
		$topic_stars_titles[] = $userStars;
	}
	if(!empty($userAllTitles)){
		$topic_stars_titles[] = $userAllTitles;
	}
	if(count($topic_stars_titles) > 0){
		echo"
		<tr>
			<td class=\"asNormalDot asS12 asCenter\" colspan=\"2\">".implode("<br>", $topic_stars_titles)."</td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asNormalDot asS12\"><nobr>المشاركات</nobr></td>
			<td class=\"asNormalDot asS12 asCenter\"><nobr>{$topic['aposts']}</nobr></td>
		</tr>";
	if($topic['alevel']==1&&$topic['apoints']>0){
		echo"
		<tr>
			<td class=\"asNormalDot asS12\"><nobr><font color=\"red\">نقاط التميز</font></nobr></td>
			<td class=\"asNormalDot asS12 asCenter\"><nobr><font color=\"red\">{$topic['apoints']}</font></nobr></td>
		</tr>";
	}
	if(!empty($topic['acountry'])){
		echo"
		<tr>
			<td class=\"asNormalDot asS12\"><nobr>الدولة</nobr></td>
			<td class=\"asNormalDot asS12 asCenter\">{$topic['acountry']}</td>
		</tr>";
	}
	echo"
		<tr>
			<td class=\"asNormalDot asS12\"><nobr>عدد الأيام</nobr></td>
			<td class=\"asNormalDot asS12 asCenter\"><nobr>".($DF->catch['userTotalDays'][$topic['author']]=userTotalDays($topic['adate']))."</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalDot asS12\"><nobr>معدل مشاركات</nobr></td>
			<td class=\"asNormalDot asS12 asCenter\"><nobr>".($DF->catch['userMiddlePosts'][$topic['author']]=userMiddlePosts($topic['aposts'],$topic['adate']))."</nobr></td>
		</tr>";
	if($topic['isonline']==1){
		echo"
		<tr>
			<td class=\"asNormalDot asS12 asCenter\" colspan=\"2\"><img src=\"{$DFImage->i['online']}\" border=\"0\"><br>متصل الآن</td>
		</tr>";
	}
	/******************* End user details ********************/
	}
	echo"
	</table>";
}
		echo"</td>
		<td class=\"{$rowClass}\" width=\"100%\" vAlign=\"top\">
		<table cellSpacing=\"0\" cellPadding=\"0\" width=\"100%\">
			<tr>
				<td class=\"asPostIcon\">
				<table cellSpacing=\"2\" width=\"100%\">
					<tr>
						<td class=\"asPostIcon\"><nobr>{$DF->date($topic['date'])}</nobr></td>
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"profile.php?u={$topic['author']}\"><img src=\"{$DFImage->i['user_profile']}\">{$Template->tooltip('معلومات عن العضو')}</a></td>";
			if(ulv>0){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"editor.php?type=sendpm&u={$topic['author']}&t=$t&src=".urlencode(self)."\"><img src=\"{$DFImage->i['message']}\">{$Template->tooltip('أرسل رسالة خاصة لهذا العضو')}</a></td>";
					if($isModerator){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"editor.php?type=sendpm&u={$topic['author']}&f=-$f&t=$t&src=".urlencode(self)."\"><img src=\"{$DFImage->i['message_forum']}\">{$Template->tooltip('أرسل رسالة خاصة من الأشراف إلى هذا العضو')}</a></td>";
					}
					if($topic['status']==1||$isModerator){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"editor.php?type=quotepost&t=$t&src=".urlencode(self)."\"><img src=\"{$DFImage->i['reply']}\">{$Template->tooltip('رد على الموضوع بإضافة نص هذه المشاركة')}</a></td>";
					}
					if($topic['status']==1&&$topic['author']==uid||$isModerator){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"editor.php?type=edittopic&t=$t&src=".urlencode(self)."\"><img src=\"{$DFImage->f['edit']}\">{$Template->tooltip('تعديل الموضوع')}</a></td>";
					}
					if(uid!=$topic['author']){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"options.php?type=complain&method=topic&u={$topic['author']}&t=$t&src=".urlencode(self)."\"><img src=\"{$DFImage->i['complain']}\">{$Template->tooltip('لفت انتباه المشرف الى هذه المشاركة')}</a></td>";
					}
				if($isModerator){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"options.php?type=topicstats&t=$t\"><img src=\"{$DFImage->i['stats']}\">{$Template->tooltip('إحصائيات ردود الأعضاء في الموضوع')}</a></td>
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"options.php?type=survey&t=$t\"><img src=\"{$DFImage->i['poll']}\">{$Template->tooltip('إضافة أو إزالة استفتاء للموضوع')}</a></td>
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"options.php?type=checkedit&t=$t\"><img src=\"{$DFImage->i['question']}\">{$Template->tooltip('التغيرات على نص الموضوع')}</a></td>";
						if(type=="url"){
						echo"
						<td class=\"postIcon\"><a class=\"asTooltip\" href=\"topics.php?t=$t\"><img src=\"images/icons/xhidden.gif\">{$Template->tooltip('تصفح الموضوع عادي')}</a></td>";
						}else{
						echo"
						<td class=\"postIcon\"><a class=\"asTooltip\" href=\"topics.php?t=$t&type=url\"><img src=\"images/icons/xshow.gif\">{$Template->tooltip('تفحص الروابط بالموضوع')}</a></td>";

					}
					if($topic['author']!=uid&&$topic['alevel']<=ulv&&$topic['alevel']<4){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"svc.php?svc=mons&type=addmon&method=topic&u={$topic['author']}&t=$t\"><img src=\"{$DFImage->i['mon']}\">{$Template->tooltip('تطبيق العقوبة على العضو')}</a></td>";
					}
					if($topic['moderate']>=1){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"javascript:DF.command($t,'mo');\"><img src=\"{$DFImage->f['approve']}\">{$Template->tooltip('موافقة على الموضوع')}</a></td>";
					}
					if($topic['moderate']==1){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"javascript:DF.command($t,'ho');\"><img src=\"{$DFImage->f['hold']}\">{$Template->tooltip('تجميد الموضوع')}</a></td>";
					}
					if($topic['status']==1){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"javascript:DF.command($t,'lk');\"><img src=\"{$DFImage->f['lock']}\">{$Template->tooltip('قفل الموضوع')}</a></td>";
					}
					else{
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"javascript:DF.command($t,'op');\"><img src=\"{$DFImage->f['unlock']}\">{$Template->tooltip('فتح الموضوع')}</a></td>";
					}
					if($topic['hidden']==0){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"javascript:DF.command($t,'hd');\"><img src=\"{$DFImage->f['hidden']}\">{$Template->tooltip('إخفاء الموضوع')}</a></td>";
					}
					else{
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"javascript:DF.command($t,'vs');\"><img src=\"{$DFImage->f['visible']}\">{$Template->tooltip('إظهار الموضوع')}</a></td>";
					}
					if($topic['trash']==0&&$isMonitor){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"javascript:DF.command($t,'dl');\"><img src=\"{$DFImage->f['delete']}\">{$Template->tooltip('حذف الموضوع')}</a></td>";
					}
					elseif($topic['trash']==1&&$isMonitor){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"javascript:DF.command($t,'re');\"><img src=\"{$DFImage->f['restore_delete']}\">{$Template->tooltip('إرجاع الموضوع')}</a></td>";
					}
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"options.php?type=topicusers&t=$t\"><img src=\"{$DFImage->f['add_user']}\">{$Template->tooltip('قائمة الأعضاء المخولون برؤية هذا الموضوع')}</a></td>";
					if($topic['viewforusers'] == 1){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"javascript:DF.command({$t},'yv');\"><img src=\"styles/folders/yes_visitor.png\">{$Template->tooltip('عرض موضوع للجميع')}</a></td>";
					}
					else{
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"javascript:DF.command({$t},'nv');\"><img src=\"styles/folders/no_visitor.png\">{$Template->tooltip('عرض موضوع فقط لأعضاء مسجلين')}</a></td>";
					}
				}
			}
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"topics.php?t=$t&u={$topic['author']}\"><img src=\"{$DFImage->i['users']}\">{$Template->tooltip('ردود هذا العضو فقط')}</a></td>
						<td width=\"90%\">&nbsp;</td>";
					if($topic['fhidden'] == 0 && $topic['flevel'] == 0 && $topic['hidden'] == 0 && $topic['trash'] == 0 && $topic['moderate'] == 0){
						echo"<td>{$Template->FBLike("topics.php?t=".$t)}</td>";
					}
					if($topic['fhidden'] == 0 && $topic['flevel' ]== 0 && $topic['hidden'] == 0 && $topic['trash'] == 0 && $topic['moderate'] == 0){
						echo"<td><g:plusone href=\"\"></g:plusone></td>";
					}
					if($isModerator){
						echo"
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"topics.php?t=$t&option=mo\"><img src=\"{$DFImage->i['approve']}\">{$Template->tooltip('عرض ردود ينتظر الموافقة فقط')}</a></td>
						<td class=\"asPostIcon\"><a class=\"asTooltip\" href=\"topics.php?t=$t&option=ho\"><img src=\"{$DFImage->i['hold']}\">{$Template->tooltip('عرض ردود مجمدة فقط')}</a></td>";
					}
					echo"
					</tr>
				</table>
				</td>
			</tr>
		</table>";
	if(!empty($postErrorMsg)){
		echo"
		<table width=\"100%\">
			<tr>
				<td class=\"asTitle asCenter asWDot asP5\"><nobr>$postErrorMsg</nobr></td>
			</tr>
		</table>";
	}
		echo"
		<table style=\"table-layout:fixed\" align=\"center\">
			<tr>
				<td>";
				if($topic['ahidetopics']==0||$topic['author']==uid||$isModerator){
				$message = $topic['message'];
				if(type=="url" && $isModerator ){
				$message = str_replace("<a","<img src='images/icons/link.gif'><a",$message);
				$message = str_replace("<A","<img src='images/icons/link.gif'><A",$message);
				$message = str_replace("</A>","</A><img src='images/icons/link.gif'>",$message);
				$message = str_replace("</a>","</a><img src='images/icons/link.gif'>",$message);
				}
				echo str_replace("\\\"","",$message)."<br>";
				}
				if($topic['survey']>0){
					function chkOptionsOther($other){
						if(strstr(strtolower($other),".gif")!=""||strstr(strtolower($other),".jpg")!=""){
							$text="<img src=\"$other\" border=\"0\">";
						}
						else{
							$text="<font color=\"gray\">$other</font>";
						}
						return $text;
					}
					$survey=$mysql->queryAssoc("SELECT question,status,secret,days,posts FROM ".prefix."survey WHERE id = '{$topic['survey']}'", __FILE__, __LINE__);
					echo"
					<hr size=\"1\" noshade>
					<table cellspacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
						<tr>
							<td class=\"asHeader\" colspan=\"5\">{$survey['question']}</td>
						</tr>
						<tr>
							<td class=\"asDarkB\">الخيار</td>
							<td class=\"asDarkB\">عدد الأصوات</td>
							<td class=\"asDarkB\" colspan=\"".($isModerator ? 2 : 3)."\">النسبة</td>";
						if($isModerator){
							echo"
							<td class=\"asDarkB\">تصويتات</td>";
						}
						echo"
						</tr>";
					$udays=userTotalDays(udate);
					$canVote=($udays>=$survey['days']&&uposts>=$survey['posts'] ? 1 : 0);
					$allVotes=$DFOutput->count("surveyvotes WHERE surveyid = '{$topic['survey']}'");
					$sql=$mysql->query("SELECT so.id,so.value,so.other,IF(NOT ISNULL(svfind.id),1,0) AS findvote,COUNT(sv.id) AS count
					FROM ".prefix."surveyoptions AS so
					LEFT JOIN ".prefix."surveyvotes AS sv ON(sv.optionid = so.id)
					LEFT JOIN ".prefix."surveyvotes AS svfind ON(svfind.optionid = so.id AND svfind.userid = ".uid.")
					WHERE so.surveyid = '{$topic['survey']}' GROUP BY so.id ORDER BY ".($survey['secret']==0||$isModerator ? "so.votes DESC" : "so.id ASC")."", __FILE__, __LINE__);
					while($option=$mysql->fetchAssoc($sql)){
						$doVote=($option['findvote']==0&&$survey['status']==1&&ulv>0&&$canVote==1 ? 1 : 0);
						if($allVotes>0){
							$percent=($option['count']*100)/$allVotes;
						}
						else{
							$percent=0;
						}
						$surClass=($option['findvote']==1 ? "asFixedB" : "asNormalB");
						echo"
						<tr>
							<td class=\"$surClass\">".($doVote==1 ? "<a href=\"topics.php?t=$t&vote={$option['id']}\"><b>{$option['value']}</b></a>" : "<b>{$option['value']}</b>")."<br>".chkOptionsOther($option['other'])."</td>
							<td class=\"$surClass\" align=\"center\" dir=\"ltr\">".($survey['secret']==0||$isModerator ? $option['count'] : "- سرّي -")."</td>
							<td class=\"$surClass\" align=\"center\" dir=\"ltr\">".($survey['secret']==0||$isModerator ? round($percent,1)."%" : "")."</td>
							<td class=\"$surClass\" align=\"center\" colspan=\"".($isModerator ? 1 : 2)."\">";
							if($survey['secret']==0||$isModerator){
								echo"
								<img src=\"styles/".choosed_style."/survey.png\" height=\"12\" width=\"".round($percent,0)."\"><img src=\"{$DFImage->i['survey_light']}\" height=\"12\" width=\"".(100-round($percent,0))."\">";
							}
							else{
								echo"
								<img src=\"{$DFImage->i['survey_light']}\" height=\"12\" width=\"100\">";
							}
							echo"
							</td>";
						if($isModerator){
							echo"
							<td class=\"$surClass asCenter\"><a href=\"svc.php?svc=surveys&type=votes&id={$option['id']}\"><img src=\"{$DFImage->i['question']}\" alt=\"تفاصيل تصويتات هذا الخيار\" border=\"0\"></a></td>";
						}
						echo"
						</tr>";
					}
						echo"
						<tr>
							<td class=\"asFixedB\">إجمالي الأصوات:</td>
							<td class=\"asFixedB asCenter\" dir=\"ltr\">".($survey['secret']==0||$isModerator ? $allVotes : 0)."</td>
							<td class=\"asFixedB asCenter\" dir=\"ltr\">100%</td>
							<td class=\"asFixedB asCenter\" colspan=\"".($isModerator ? 3 : 2)."\">";
						if($isModerator){
								echo"
								<nobr>";
							if($survey['secret']==0){
								echo"
								<a href=\"svc.php?svc=surveys&type=secret&id={$topic['survey']}\" {$DF->confirm('هل أنت متأكد بأن تريد تغير وضعية هذا الاستفتاء من غير سري الى سري ؟')}><img src=\"{$DFImage->i['hidden']}\" alt=\"جعل هذا الاستفتاء سري\" hspace=\"2\" border=\"0\"></a>";
							}
							else{
								echo"
								<a href=\"svc.php?svc=surveys&type=unsecret&id={$topic['survey']}\" {$DF->confirm('هل أنت متأكد بأن تريد تغير وضعية هذا الاستفتاء من سري الى غير سري ؟')}><img src=\"{$DFImage->i['visible']}\" alt=\"جعل هذا الاستفتاء غير سري\" hspace=\"2\" border=\"0\"></a>";
							}
							if($survey['status']==1){
								echo"
								<a href=\"svc.php?svc=surveys&type=lock&id={$topic['survey']}\" {$DF->confirm('هل أنت متأكد بأن تريد قفل هذا الاستفتاء ؟')}><img src=\"{$DFImage->i['lock']}\" alt=\"قفل استفتاء\" hspace=\"2\" border=\"0\"></a>";
							}
							else{
								echo"
								<a href=\"svc.php?svc=surveys&type=unlock&id={$topic['survey']}\" {$DF->confirm('هل أنت متأكد بأن تريد فتح هذا الاستفتاء ؟')}><img src=\"{$DFImage->i['unlock']}\" alt=\"فتح استفتاء\" hspace=\"2\" border=\"0\"></a>";
							}
								echo"
								<a href=\"svc.php?svc=surveys&type=edit&id={$topic['survey']}\"><img src=\"{$DFImage->i['edit']}\" alt=\"تعديل إستفتاء\" hspace=\"2\" border=\"0\"></a>
								<a href=\"svc.php?svc=surveys&type=options&id={$topic['survey']}\"><img src=\"{$DFImage->i['question']}\" alt=\"معلومات حول التصويتات هذا الإستفتاء\" hspace=\"2\" border=\"0\"></a>
								</nobr>";
						}
						else{
							echo"&nbsp;";
						}
							echo"
							</td>
						</tr>
					</table>";
					if(ulv>0){
						if($survey['status']==1){
							echo"<div class=\"asTitle asCenter asWDot asP4 asM4\">ملاحظة: للتصويت إضغط على أحد الخيارات أعلاه.</div>";
						}
						else{
							echo"<div class=\"asTitle asCenter asWDot asP4 asM4\">ملاحظة: تم إغلاق هذا الاستفتاء.</div>";
						}
						echo"
						<div class=\"asTitle asCenter asWDot asP4 asM4\">لا يسمح للتصويت في هذا الاستفتاء إلا للأعضاء المطابقون للمواصفات التالية:</div>
						<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
							<tr>
								<td class=\"asDarkB\">المطلوب</td>
								<td class=\"asDarkB\">العدد الحالي</td>
								<td class=\"asDarkB\">العدد الإدنى</td>
							</tr>
							<tr>
								<td class=\"asNormalB\">المشاركات</td>
								<td class=\"asNormalB asCenter\">".uposts."</td>
								<td class=\"asNormalB asCenter\">{$survey['posts']}</td>
							</tr>
							<tr>
								<td class=\"asNormalB\">الأيام منذ تسجيل العضو</td>
								<td class=\"asNormalB asCenter\">$udays</td>
								<td class=\"asNormalB asCenter\">{$survey['days']}</td>
							</tr>
						</table>";
					}
				}
				if(topics_signature=='visible'&&!empty($topic['signature'])){
					echo"
					<fieldset class=\"gray\">
						<legend>&nbsp;التوقيع</legend>";
					if($topic['ahidesignature']==1) echo"<br><div class=\"asTitle asCenter asWDot asP5\">** تم إخفاء توقيع هذه العضوية بواسطة الإدارة **</div><br>";
					if($topic['ahidesignature']==0||$topic['author']==uid||$isModerator) echo $topic['signature'];
					echo"
					</fieldset><br><br>";
				}
				echo"
				</td>
			</tr>
		</table>";
if(ulv>0){
		$operMsg=array();
		$operMsg['lk'][0]="تم قفل الموضوع بواسطة";
		$operMsg['lk'][1]="تم إعادة فتح الموضوع بواسطة";
		$operMsg['st'][1]="تم تثبيت الموضوع بواسطة";
		$operMsg['st'][0]="تم إزالة تثبيت الموضوع بواسطة";
		$operMsg['hd'][1]="تم إخفاء الموضوع بواسطة";
		$operMsg['hd'][0]="تم إظهار الموضوع بواسطة";
		$operMsg['mo'][2]="تم تجميد الموضوع بواسطة";
		$operMsg['mo'][0]="تمت موافقة على الموضوع بواسطة";
		$operMsg['dl'][1]="تم حذف الموضوع بواسطة";
		$operMsg['dl'][0]="تم إسترجاع الموضوع بواسطة";
		$operMsg['mv'][0]="تم نقل الموضوع بواسطة";
		$operations=unserialize($topic['operations']);
	if(is_array($operations)||$topic['editnum']>0){
			echo"
			<table cellspacing=\"2\" cellpadding=\"2\" border=\"0\" align=\"{$Template->align}\">";
		if(is_array($operations)){
			$operations=array_reverse($operations);
			foreach($operations as $val){
				$exp=explode("::",$val);
				if($exp[1]!='st'||$isModerator){
					$opMessage=$operMsg["{$exp[1]}"][$exp[1]=='mv'?0:$exp[2]];
					echo"
					<tr>
						<td class=\"asTitle asWDot asAC2 asAS12\"><nobr>{$DF->date($exp[0],'',true)} - $opMessage {$Template->userNormalLink($exp[3],$exp[4])}</nobr></td>
					</tr>";
				}
			}
		}
		if($topic['editnum']>0){
			if($topic['editnum']>1){
				$editNumIsMore="<br><center>عدد مرات تغيير النص {$topic['editnum']}</center>";
			}
				echo"
				<tr>
					<td class=\"asTitle asWDot asAC2 asAS12\"><nobr>{$DF->date($topic['editdate'],'',true)} - آخر تغيير للنص بواسطة {$Template->userNormalLink($topic['editby'],$topic['editbyname'])}$editNumIsMore</nobr></td>
				</tr>";
		}
			echo"
			</table>";
	}
}
		echo"
		</td>
	</tr>";
//******** end topic ***********
}

$pgLimit=$DF->pgLimit(post_num_page);
$sql=$mysql->query("SELECT p.id,p.hidden,p.moderate,p.trash,p.author,p.editby,p.editdate,p.editnum,p.date,
	u.name AS aname,u.status AS astatus,u.level AS alevel,u.submonitor AS asubmonitor,uf.posts AS aposts,uf.points AS apoints,uf.sex AS asex,
	uf.title AS atitle,uf.oldlevel AS aoldlevel,uf.picture AS apicture,up.hidesignature AS ahidesignature,
	up.hidephoto AS ahidephoto,up.hideposts AS ahideposts,ic.name AS acountry,
	u.date AS adate,uu.name AS editbyname,".(topics_signature=='visible'?"uf.signature,":"")." pm.message,
	pm.operations,IF(NOT ISNULL(uo.userid),1,0) AS isonline
FROM ".prefix."post AS p
LEFT JOIN ".prefix."postmessage AS pm ON(pm.id = p.id)
LEFT JOIN ".prefix."user AS u ON(u.id = p.author)
LEFT JOIN ".prefix."user AS uu ON(uu.id = p.editby)
LEFT JOIN ".prefix."userflag AS uf ON(uf.id = p.author)
LEFT JOIN ".prefix."userperm AS up ON(up.id = p.author)
LEFT JOIN ".prefix."country AS ic ON(ic.code = uf.country)
LEFT JOIN ".prefix."useronline AS uo ON(uo.userid = p.author AND (up.hidebrowse = 0 OR ".ulv." > 1 AND u.level < 3 OR ".ulv." > 2 AND u.level < 4 OR ".ulv." = 4))
WHERE p.topicid = '$t' $checkPostWhereSql GROUP BY p.id ORDER BY p.date ASC LIMIT $pgLimit,".post_num_page, __FILE__, __LINE__);
$count=0;
while($post=$mysql->fetchAssoc($sql)){
	//******* start post *************
	$p=$post['id'];
	if($post['trash']==1){
		$rowClass="asDelete";
		$postErrorMsg="** هذه المشاركة محذوفة **";
	}
	elseif($post['ahideposts']==1){
		$rowClass="asFirst";
		$postErrorMsg="** تم إخفاء نص هذه المشاركة بواسطة الإدارة **";
	}
	elseif($post['moderate']==1){
		$rowClass="asFirst";
		$postErrorMsg="** هذه المشاركة لم يتم مراجعتها والموافقة عليها بواسطة مشرف المنتدى حتى الآن **";
	}
	elseif($post['moderate']==2){
		$rowClass="asFirst";
		$postErrorMsg="** هذه المشاركة مجمدة حتى إشعار آخر -- للإستفسار عن سبب الرجاء الإتصال بمشرف المنتدى **";
	}
	elseif($post['hidden']==1){
		$rowClass="asHidden";
		$postErrorMsg="** تم اخفاء هذه المشاركة -- للإستفسار عن السبب الرجاء الإتصال بمشرف المنتدى **";
	}
	else{
		$rowClass=($count%2 ? "asFixed" : "asNormal");
		$postErrorMsg="";
	}
	
	if($isModerator){
		$jsPosts.="posts[{$p}]=[{$post['hidden']},{$post['moderate']},{$post['trash']},{$post['author']}];";
	}

	echo"
	<tr>
		<td id=\"p1Cell{$p}\" class=\"{$rowClass}\" width=\"17%\" align=\"center\" vAlign=\"top\">";
		
	if($post['alevel']==4){
		echo"
		<table width=\"100%\" cellspacing=\"0\" cellpadding=\"4\">
			<tr>
				<td class=\"asHeader\">{$Template->userNormalLink($post['author'],$post['aname'],'white')}</td>
			</tr>";
		if(!empty($post['atitle'])){
			echo"
			<tr>
				<td class=\"asNormalDot asS12 asCenter\">{$post['atitle']}</td>
			</tr>";
		}
		echo"
		</table>";
	}
	else{
		echo"
		<table width=\"100%\" cellspacing=\"1\" cellpadding=\"4\">
			<tr>
				<td class=\"asDarkDot asAC1\" colspan=\"2\">{$Template->userNormalLink($post['author'],$post['aname'])}</td>
			</tr>";
		if(ulv>0&&$post['astatus']==0){
			echo"
			<tr>
				<td class=\"asNormalDot asS12 asCenter\" colspan=\"2\"><font color=\"red\">عضوية مقفولة</font></td>
			</tr>";
		}
		if(ulv>0&&($post['astatus']==1||$isModerator)&&($topic['hideprofile']==0||$isModerator)){
		/******************* Start user details ********************/
		if($post['ahidephoto']==0||$isModerator){
			echo"
			<tr>
				<td class=\"asNormalDot asCenter\" colspan=\"2\"><img src=\"{$DFPhotos->getsrc($post['apicture'], 200)}\"{$DF->picError(100)} width=\"100\" height=\"100\" class=\"asBGray\" border=\"0\"></td>
			</tr>";
		}
		$userStars = $DF->userStars($post['aposts'], $post['alevel'], $post['asubmonitor']);
		$userAllTitles = userAllTitles($post['author'], $post['alevel'], $post['aposts'], $post['atitle'], $post['asex'], $post['aoldlevel'], $post['asubmonitor']);
		$post_stars_titles = array();
		if(!empty($userStars)){
			$post_stars_titles[] = $userStars;
		}
		if(!empty($userAllTitles)){
			$post_stars_titles[] = $userAllTitles;
		}
		if(count($post_stars_titles) > 0){
			echo"
			<tr>
				<td class=\"asNormalDot asS12 asCenter\" colspan=\"2\">".implode("<br>", $post_stars_titles)."</td>
			</tr>";
		}
			echo"
			<tr>
				<td class=\"asNormalDot asS12\"><nobr>المشاركات</nobr></td>
				<td class=\"asNormalDot asS12 asCenter\"><nobr>{$post['aposts']}</nobr></td>
			</tr>";
		if($post['alevel']==1&&$post['apoints']>0){
			echo"
			<tr>
				<td class=\"asNormalDot asS12\"><nobr><font color=\"red\">نقاط التميز</font></nobr></td>
				<td class=\"asNormalDot asS12 asCenter\"><nobr><font color=\"red\">{$post['apoints']}</font></nobr></td>
			</tr>";
		}
		if(!empty($post['acountry'])){
			echo"
			<tr>
				<td class=\"asNormalDot asS12\"><nobr>الدولة</nobr></td>
				<td class=\"asNormalDot asS12 asCenter\">{$post['acountry']}</td>
			</tr>";
		}
			echo"
			<tr>
				<td class=\"asNormalDot asS12\"><nobr>عدد الأيام</nobr></td>
				<td class=\"asNormalDot asS12 asCenter\"><nobr>".(($userTotalDays=$DF->catch['userTotalDays'][$post['author']]) ? $userTotalDays : ($DF->catch['userTotalDays'][$post['author']]=userTotalDays($post['adate'])))."</nobr></td>
			</tr>
			<tr>
				<td class=\"asNormalDot asS12\"><nobr>معدل مشاركات</nobr></td>
				<td class=\"asNormalDot asS12 asCenter\"><nobr>".(($userMiddlePosts=$DF->catch['userMiddlePosts'][$post['author']]) ? $userMiddlePosts : ($DF->catch['userMiddlePosts'][$post['author']]=userMiddlePosts($post['aposts'],$post['adate'])))."</nobr></td>
			</tr>";
		if($post['isonline']==1){
			echo"
			<tr>
				<td class=\"asNormalDot asS12 asCenter\" colspan=\"2\"><img src=\"{$DFImage->i['online']}\" border=\"0\"><br>متصل الآن</td>
			</tr>";
		}
		/******************* End user details ********************/
		}
		echo"
		</table>";
	}
		echo"</td>
		<td id=\"p2Cell{$p}\" class=\"{$rowClass}\" width=\"100%\" vAlign=\"top\">
		<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
			<tr>
				<td class=\"asPostIcon\">
				<table width=\"100%\" cellSpacing=\"2\">
					<tr>
						<td class=\"asPostIcon\"><nobr>{$DF->date($post['date'])}</nobr></td>
						<td class=\"asPostIcon\"><a href=\"profile.php?u={$post['author']}\"><img src=\"{$DFImage->i['user_profile']}\" alt=\"معلومات عن العضو\" border=\"0\"></a></td>";
			if(ulv>0){
						echo"
						<td class=\"asPostIcon\"><a href=\"editor.php?type=sendpm&u={$post['author']}&t=$t&p=$p&src=".urlencode(self)."\"><img src=\"{$DFImage->i['message']}\" alt=\"أرسل رسالة خاصة لهذا العضو\" border=\"0\"></a></td>";
					if($isModerator){
						echo"
						<td class=\"asPostIcon\"><a href=\"editor.php?type=sendpm&u={$post['author']}&f=-$f&t=$t&p=$p&src=".urlencode(self)."\"><img src=\"{$DFImage->i['message_forum']}\" alt=\"أرسل رسالة خاصة من الأشراف إلى هذا العضو\" border=\"0\"></a></td>";
					}
					if($topic['status']==1||$isModerator){
						echo"
						<td class=\"asPostIcon\"><a href=\"editor.php?type=quotepost&t=$t&p=$p&src=".urlencode(self)."\"><img src=\"{$DFImage->i['reply']}\" alt=\"رد على المشاركة بإضافة نص هذه المشاركة\" border=\"0\"></a></td>";
					}
					if($topic['status']==1&&$post['author']==uid||$isModerator){
						echo"
						<td class=\"asPostIcon\"><a href=\"editor.php?type=editpost&p=$p&src=".urlencode(self)."\"><img src=\"{$DFImage->i['post_edit']}\" alt=\"تعديل المشاركة\" border=\"0\"></a></td>";
					}
					if(uid!=$post['author']){
						echo"
						<td class=\"asPostIcon\"><a href=\"options.php?type=complain&method=post&u={$post['author']}&p=$p&src=".urlencode(self)."\"><img src=\"{$DFImage->i['complain']}\" alt=\"لفت انتباه المشرف الى هذه المشاركة\" border=\"0\"></a></td>";
					}
				if($isModerator){
					if($post['moderate']>=1){
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.command($p,'mo',1);\"><img src=\"{$DFImage->i['approve']}\" alt=\"موافقة على المشاركة\" border=\"0\"></a></td>";
					}
					if($post['moderate']==1){
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.command($p,'ho',1);\"><img src=\"{$DFImage->i['hold']}\" alt=\"تجميد المشاركة\" border=\"0\"></a></td>";
					}
					if($post['hidden']==0){
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.command($p,'hd',1);\"><img src=\"{$DFImage->i['hidden']}\" alt=\"إخفاء المشاركة\" border=\"0\"></a></td>";
					}
					else{
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.command($p,'vs',1);\"><img src=\"{$DFImage->i['visible']}\" alt=\"إظهار المشاركة\" border=\"0\"></a></td>";
					}
					if($post['trash']==0&&$isMonitor){
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.command($p,'dl',1);\"><img src=\"{$DFImage->i['post_delete']}\" alt=\"حذف المشاركة\" border=\"0\"></a></td>";
					}
					elseif($post['trash']==1&&$isMonitor){
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.command($p,'re',1);\"><img src=\"{$DFImage->i['post_up']}\" alt=\"إرجاع المشاركة\" border=\"0\"></a></td>";
					}
					if($post['author']!=uid&&$post['alevel']<=ulv&&$post['alevel']<4){
						echo"
						<td class=\"asPostIcon\"><a href=\"svc.php?svc=mons&type=addmon&method=post&u={$post['author']}&p=$p\"><img src=\"{$DFImage->i['mon']}\" alt=\"تطبيق العقوبة على العضو\" border=\"0\"></a></td>";
					}
				}
				else{
					if(ulv>1&&$topic['hidden']==0&&$topic['moderate']==0&&$topic['trash']==0&&$topic['status']==1&&$post['trash']==0&&$post['hidden']==0&&$post['moderate']==0){
						echo"
						<td class=\"asPostIcon\"><a href=\"topics.php?t=$t&method=hidepost&id=$p&src=".urlencode(self)."\"{$DF->confirm('هل أنت متأكد بأن تريد إخفاء هذه المشاركة')}><img src=\"{$DFImage->i['hidden']}\" alt=\"إخفاء المشاركة\" border=\"0\"></a></td>";
					}
				}
			}
						echo"
						<td class=\"asPostIcon\"><a href=\"topics.php?t=$t&p=$p\"><img src=\"{$DFImage->i['single']}\" alt=\"هذا الرد فقط\" border=\"0\"></a></td>
						<td class=\"asPostIcon\"><a href=\"topics.php?t=$t&u={$post['author']}\"><img src=\"{$DFImage->i['users']}\" alt=\"ردود هذا العضو فقط\" border=\"0\"></a></td>
						<td class=\"asPostIcon\" width=\"90%\">&nbsp;</td>";
					if($isModerator){
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.selectUserPosts({$post['author']},'{$post['aname']}');\"><img src=\"{$DFImage->i['user_posts']}\" alt=\"وضع علامة الإختيار على جميع مشاركات هذا العضو في هذه الصفحة\" border=\"0\"></a></td>
						<td class=\"asPostIcon\"><input type=\"checkbox\" class=\"none\" name=\"posts\" value=\"$p\" onClick=\"DF.doSelectRow(this,{$p},'{$rowClass}');DF.checkChoose(false);\" author=\"{$post['author']}\" defclass=\"$rowClass\"></td>";
					}
					echo"
					</tr>
				</table>
				</td>
			</tr>
		</table>";
	if(!empty($postErrorMsg)){
		echo"
		<table width=\"100%\">
			<tr>
				<td class=\"asTitle asCenter asWDot asP5\"><nobr>$postErrorMsg</nobr></td>
			</tr>
		</table>";
	}
		echo"
		<table style=\"table-layout:fixed\" align=\"center\">
			<tr>
				<td>";
				if($post['ahideposts']==0||$post['author']==uid||$isModerator){
					echo str_replace("\\\"","",$post['message'])."<br>";
				}
				if(topics_signature=='visible'&&!empty($post['signature'])){
					echo"
					<fieldset class=\"gray\">
						<legend>&nbsp;التوقيع</legend>";
					if($post['ahidesignature']==1) echo"<br><div class=\"asTitle asCenter asWDot asP5\">** تم إخفاء توقيع هذه العضوية بواسطة الإدارة **</div><br>";
					if($post['ahidesignature']==0||$post['author']==uid||$isModerator) echo $post['signature'];
					echo"
					</fieldset><br><br>";
				}
				echo"
				</td>
			</tr>
		</table>";
if(ulv>0){
		$operMsg=array();
		$operMsg['hd'][1]="تم إخفاء المشاركة بواسطة";
		$operMsg['hd'][0]="تم إظهار المشاركة بواسطة";
		$operMsg['mo'][2]="تم تجميد المشاركة بواسطة";
		$operMsg['mo'][0]="تمت موافقة على المشاركة بواسطة";
		$operMsg['dl'][1]="تم حذف المشاركة بواسطة";
		$operMsg['dl'][0]="تم إسترجاع المشاركة بواسطة";
		$operations=unserialize($post['operations']);
	if(is_array($operations)||$post['editnum']>0){
			echo"
			<table cellspacing=\"2\" cellpadding=\"2\" align=\"{$Template->align}\" border=\"0\">";
		if(is_array($operations)){
			$operations=array_reverse($operations);
			foreach($operations as $val){
				$exp=explode("::",$val);
				$opMessage=$operMsg["{$exp[1]}"][$exp[1]=='mv'?0:$exp[2]];
				echo"
				<tr>
					<td class=\"asTitle asWDot asAC2 asAS12\"><nobr>{$DF->date($exp[0],'',true)} - $opMessage {$Template->userNormalLink($exp[3],$exp[4])}</nobr></td>
				</tr>";
			}
		}
		if($post['editnum']>0){
			$editNumIsMore="";
			if($post['editnum']>1){
				$editNumIsMore="<br><center>عدد مرات تغيير النص {$post['editnum']}</center>";
			}
				echo"
				<tr>
					<td class=\"asTitle asWDot asAC2 asAS12\"><nobr>{$DF->date($post['editdate'],'',true)} - آخر تغيير للنص بواسطة {$Template->userNormalLink($post['editby'],$post['editbyname'])}$editNumIsMore</nobr></td>
				</tr>";
		}
			echo"
			</table>";
	}
}
		echo"
		</td>
	</tr>";
	$count++;
	//********* end post ************
}

if($isModerator){
	echo"
	</form>
	<script type=\"text/javascript\">var posts=new Array();{$jsPosts}</script>";
}

if($topic['posts']>=topic_max_posts){
	echo"
	<tr>
		<td class=\"asError asP5\" colspan=\"2\">لا يمكن إضافة ردود لهذا الموضوع لأنه تجاوز الحد الأقصى وهو (".topic_max_posts.") رد</td>
	</tr>";	
}

	//********** start quick post *************
if($topic['posts'] < topic_max_posts && (ulv > 0 && $topic['status'] == 1 || $isModerator)){
	?>
	<script type="text/javascript">
	DF.checkQuickPost=function(frm){
		var post=frm.message.value;
		while((post.substring(0,1)==' ') || (post.substring(0,1)=='\r') || (post.substring(0,1)=='\n') || (post.substring(0,1)=='\t')){
			post=post.substring(1);
		}
		frm.message.value=post;
		if(frm.message.value.length<3){
			return;
		}
		if(isModerator){
			var otheroptions=frm.otheroptions.options[frm.otheroptions.selectedIndex].value,fid=$I('#definedForumList');
			if(otheroptions=='mv'&&fid&&fid.selectedIndex==0){
				alert("يجب عليك ان تختار منتدى من القائمة ليتم نقل الموضوع الى ذلك المنتدى");
				return;
			}
		}
		frm.submit();
	}
	</script>
	<?php

	echo"
	<tr bgColor=\"white\">
		<td align=\"center\"><br><img src=\"{$DFImage->i['reply']}\" border=\"0\"><br><br><font color=\"red\">أضف<br>رد سريع</font></td>
		<td width=\"100%\" align=\"center\">
		<form method=\"post\" action=\"setpost.php\" style=\"margin:0;\">
		<input name=\"editor\" type=\"hidden\" value=\"quick\">
		<input name=\"type\" type=\"hidden\" value=\"newpost\">
		<input name=\"src\" type=\"hidden\" value=\"".urldecode(src)."\">
		<input name=\"redeclare\" type=\"hidden\" value=\"".mt_rand(1,1999999999)."\">
		<input name=\"forumid\" type=\"hidden\" value=\"$f\">
		<input name=\"topicid\" type=\"hidden\" value=\"$t\">
		<input name=\"postid\" type=\"hidden\" value=\"0\">
		<textarea name=\"message\" style=\"margin:3px;width:98%;height:150px;{$Template->getUserStyle()}\"></textarea>";

		echo"<br>
		<table width=\"10%\" cellspacing=\"0\" cellpadding=\"2\" align=\"center\" border=\"0\">
			<tr>
				<td>{$Template->button('أضف الرد للموضوع',' onClick="DF.checkQuickPost(this.form)"')}</td>";
 			if($isModerator){
				echo"
				<td>&nbsp;<b>+</b>&nbsp;</td>
				<td>
				<select class=\"asGoTo asS12\" style=\"width:135px\" name=\"otheroptions\" onChange=\"DF.checkChooseMove(this.form)\">
					<option value=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- اختر خيار --</option>";
				if($topic['status']==1){
					echo"
					<option value=\"lk\">قفل الموضوع</option>";
				}
				else{
					echo"
					<option value=\"op\">فتح الموضوع</option>";
				}
				if($topic['hidden']==0){
					echo"
					<option value=\"hd\">إخفاء الموضوع</option>";
				}
				else{
					echo"
					<option value=\"vs\">إظهار الموضوع</option>";
				}
				if($topic['moderate']==1||$topic['moderate']==2){
					echo"
					<option value=\"mo\">موافقة على الموضوع</option>";
				}
				if($topic['moderate']==2){
					echo"
					<option value=\"ho\">تجميد الموضوع</option>";
				}
				if($topic['sticky']==0){
					echo"
					<option value=\"st\">تثبيت الموضوع</option>";
				}
				else{
					echo"
					<option value=\"us\">إلغاء تثبيت الموضوع</option>";
				}
				if($topic['top']>0){
					echo"
					<option value=\"t0\">إلغاء شعار التميز</option>";
				}
				if($topic['top']!=1){
					echo"
					<option value=\"t1\">منح نجمة</option>";
				}
				if($topic['top']!=2){
					echo"
					<option value=\"t2\">منح ميدالية</option>";
				}
					echo"
					<option value=\"mv\">نقل موضوع</option>";
				if($topic['trash']==0&&$isMonitor){
					echo"
					<option value=\"dl\">حذف الموضوع</option>";
				}
				if($topic['trash']==1&&$isMonitor){
					echo"
					<option value=\"re\">إرجاع الموضوع</option>";
				}
				echo"
				</select>
				</td>
				<td id=\"moveForumList\"></td>";
			}
			echo"
			</tr>
		</table>
		</form>
		</td>
	</tr>";
}
	//*********** end quick post *************
		echo"
		</table>
		<div id=\"sharePanel2\" style=\"margin:2px;border:gray 1px solid;background-color:#f0f0f0;text-align:center;visibility:hidden;position:absolute;top:2px;left:2px\"></div>
		</td>
	</tr>
	<tr>
		<td class=\"asHeader\">
		<table cellSpacing=\"0\" cellPadding=\"0\">
			<tr>
				<td>$topicFolder</td>
				<td class=\"asC1 asCenter\" width=\"100%\">{$topic['subject']}</td>
				<td class=\"asHP2\"><a href=\"javascript:DF.share.gotoSharingList(2);\"><img src=\"images/share/share.gif\" border=\"0\"></a></td>
				<td class=\"asHP2\"><a href=\"javascript:DF.share.gotoShare('yahoo');\"><img src=\"images/share/yahoo2.gif\" border=\"0\"></a></td>
				<td class=\"asHP2\"><a href=\"javascript:DF.share.gotoShare('twitter');\"><img src=\"images/share/twitter2.gif\" border=\"0\"></a></td>
				<td class=\"asHP2\"><a href=\"javascript:DF.share.gotoShare('facebook');\"><img src=\"images/share/facebook2.gif\" border=\"0\"></a></td>";
				modOptions(2);
			echo"
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class=\"asBody\">
		<table cellSpacing=\"3\" cellPadding=\"3\">
			<tr>
				<td width=\"1000\">
				<table cellSpacing=\"0\" cellPadding=\"0\">
					<tr>
						<td rowspan=\"2\"><a href=\"foruminfo.php?f=$f\"><img class=\"asWDot\" src=\"{$topic['logo']}\" onError=\"this.src='{$DFImage->i['errorlogo']}';\" alt=\"معلومات عن المنتدى\" width=\"30\" height=\"30\" hspace=\"6\" border=\"0\"></a></td>
						<td class=\"asAS18\"><nobr>{$Template->forumLink($f,$topic['fsubject'],'','sec')}</nobr></td>
					</tr>
				</table>
				</td>
				<th class=\"asTHLink\"><nobr><a href=\"editor.php?type=newpost&t=$t&src=".urlencode(self)."\"><img src=\"{$DFImage->i['reply']}\" alt=\"رد على الموضوع\" border=\"0\"><br>أضف رد</a></nobr></th>
				<th class=\"asTHLink\"><nobr><a href=\"editor.php?type=newtopic&f=$f&src=".urlencode(self)."\"><img src=\"{$DFImage->f['folder']}\" alt=\"أضف موضوع جديد\" border=\"0\"><br>موضوع جديد</a></nobr></th>
				<th class=\"asTHLink\"><nobr><a href=\"sendtopic.php?t=$t\"><img src=\"{$DFImage->i['send']}\" alt=\"أرسل هدا الموضوع الى صديق\" border=\"0\"><br>أرسل</a></nobr></th>";
			if(ulv>0){
				echo"
				<th class=\"asTHLink\"><nobr><a href=\"favorite.php?type=add&t=$t\"><img src=\"{$DFImage->i['favorite']}\" alt=\"أضف الى المفضلة\" border=\"0\"><br>المفضلة</a></nobr></th>";
			}
				echo"
				<th class=\"asTHLink\"><nobr><a href=\"print.php?t=$t\"><img src=\"{$DFImage->i['print']}\" alt=\"طباعة موضوع\" border=\"0\"><br>طباعة</a></nobr></th>";
				echo $signatureMenu;
				echo $postNumPageMenu;
				echo $basicPaging;
				echo $goToForum;
			echo"
			</tr>
		</table>
		</td>
	</tr>
</table>";
$Template->footer();
?>