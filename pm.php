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

const _df_script = "pm";
const _df_filename = "pm.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if(ulv > 0){
//***************** start page ***************************

if(mail == 'read' && pm != '' && auth == 0){
	if(f < 0 && $isModerator){
		$readid = f;
	}
	else{
		$readid = uid;
	}
	$mysql->update("pm SET pmread = 1 WHERE id = '{$DF->hashToNum(pm)}' AND author = '$readid'", __FILE__, __LINE__);
}

if(f<0&&$isModerator){
	$uid=f;
	$uid2=abs(f);
	$sql=$mysql->query("SELECT f.subject,ff.pmlists,COUNT(pm.id) AS newpm
	FROM ".prefix."forum AS f
	LEFT JOIN ".prefix."forumflag AS ff ON(ff.id = f.id)
	LEFT JOIN ".prefix."pm AS pm ON(pm.author = '$uid' AND pm.pmto = '$uid' AND pm.status = '1' AND pm.pmout = '0' AND pm.pmread = '0' AND pm.pmlist = 0)
	WHERE f.id = '$uid2' GROUP BY f.id", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	$userType='forum';
	$pageTitle=$rs['subject'];
	$pageTarget="&f=".f;
}
elseif(auth > 0 && ulv > 2){
	$uid = auth;
	$sql=$mysql->query("SELECT u.name,u.level,uf.pmlists,COUNT(pm.id) AS newpm
	FROM ".prefix."userflag AS uf
	LEFT JOIN ".prefix."user AS u ON(u.id = uf.id)
	LEFT JOIN ".prefix."pm AS pm ON(pm.author = '$uid' AND pm.pmto = '$uid' AND pm.status = '1' AND pm.pmout = '0' AND pm.pmread = '0' AND pm.pmlist = 0)
	WHERE uf.id = '$uid' GROUP BY uf.id", __FILE__, __LINE__);
	$rs = $mysql->fetchAssoc($sql);
	$userType = 'user';
	$pageTitle = "الرسائل الخاصة - {$rs['name']}";
	$pageTarget = "&auth=".auth;
	if(!$rs || ($rs['level'] == 4 && ulv < 4) || ulv == 3 && $rs['level'] > 2){
		$DF->goTo();
	}
}
else{
	$uid=uid;
	$pmUserField=(mail=='u'&&u>0?",u.name":"");
	$pmUserTable=(mail=='u'&&u>0?"LEFT JOIN ".prefix."user AS u ON(u.id = '".u."')":"");
	$sql=$mysql->query("SELECT uf.pmlists,COUNT(pm.id) AS newpm $pmUserField
	FROM ".prefix."userflag AS uf
	LEFT JOIN ".prefix."pm AS pm ON(pm.author = '$uid' AND pm.pmto = '$uid' AND pm.status = '1' AND pm.pmout = '0' AND pm.pmread = '0' AND pm.pmlist = 0)
	$pmUserTable
	WHERE uf.id = '$uid' GROUP BY uf.id", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	$userType='user';
	$pageTitle="الرسائل الخاصة";
	$pageTarget=(mail=='u'&&u>0?"&u=".u:"");
}

$userLists=unserialize($rs['pmlists']);
if(!is_array($userLists)){
	$userLists=array(1=>'',2=>'',3=>'',4=>'',5=>'');
	$mysql->update("{$userType}flag SET pmlists = '".serialize($userLists)."' WHERE id = '$uid'", __FILE__, __LINE__);
}
$sqlWhere="";
if(mail=='new'){
	$menuTitle="الرسائل الواردة الجديدة";
	$sqlWhere="WHERE pm.author = '$uid' AND pm.pmto = '$uid' AND pm.status = '1' AND pm.pmout = '0' AND pm.pmread = '0' AND pm.pmlist = 0";
}
elseif(mail=='in'){
	$menuTitle="البريد الوارد";
	$sqlWhere="WHERE pm.author = '$uid' AND pm.pmto = '$uid' AND pm.status = '1' AND pm.pmout = '0' AND pm.pmlist = 0";
}
elseif(mail=='out'){
	$menuTitle="البريد الصادر";
	$sqlWhere="WHERE pm.author = '$uid' AND pm.pmfrom = '$uid' AND pm.status = '1' AND pm.pmout = '1' AND pm.pmlist = 0";
}
elseif(mail=='trash'){
	$menuTitle="مجلد المحذوفات";
	$sqlWhere="WHERE pm.author = '$uid' AND pm.status = '0'";
}
elseif(mail=='read'){
	$menuTitle="قراءة رسالة";
	$sql=$mysql->query("SELECT
		pm.author,pm.sender,pm.status,pm.pmout,pm.date,pm.subject,pm.pmfrom,pm.pmto,pmm.message,
		IF(pm.pmfrom>0,u.name,f.subject) AS fromname,IF(pm.pmfrom>0,u.status,0) AS fromstatus,
		IF(pm.pmfrom>0,u.level,0) AS fromlevel,IF(pm.pmfrom>0,u.submonitor,0) AS fromsubmonitor,IF(pm.pmto>0,uu.name,ff.subject) AS toname,
		IF(pm.pmto>0,uu.status,0) AS tostatus,IF(pm.pmto>0,uu.level,0) AS tolevel,IF(pm.pmto>0,uu.submonitor,0) AS tosubmonitor,
		IF(pm.sender>0,uuu.name,'') AS sname,IF(pm.sender>0,uuu.status,0) AS sstatus,
		IF(pm.sender>0,uuu.level,0) AS slevel,IF(pm.sender>0,uuu.submonitor,0) AS ssubmonitor,IF(NOT ISNULL(up.id),up.hidepm,0) AS uhidepm
	FROM ".prefix."pm AS pm
	LEFT JOIN ".prefix."pmmessage AS pmm ON(pmm.id = pm.id)
	LEFT JOIN ".prefix."user AS u ON(u.id = pm.pmfrom)
	LEFT JOIN ".prefix."user AS uu ON(uu.id = pm.pmto)
	LEFT JOIN ".prefix."user AS uuu ON(uuu.id = pm.sender)
	LEFT JOIN ".prefix."forum AS f ON(f.id = ABS(pm.pmfrom))
	LEFT JOIN ".prefix."forum AS ff ON(ff.id = ABS(pm.pmto))
	LEFT JOIN ".prefix."userperm AS up ON(up.id = pm.pmfrom)
	WHERE pm.id = '{$DF->hashToNum(pm)}' GROUP BY pm.id", __FILE__, __LINE__);
	$pm = $mysql->fetchAssoc($sql);
	if( !$pm || $pm['author'] != $uid && (
		ulv < 3 ||
		ulv == 3 && ($pm['fromlevel'] > 2 || $pm['tolevel'] > 2) ||
		ulv == 4 && (($pm['fromlevel'] == 4 && uid != 1036) || ($pm['tolevel'] == 4 && uid != 1036))
	)){
		$Template->header();
		$Template->errMsg("الرسالة المطلوبة غير متوفرة");
	}
	if(ulv > 2 && auth == 0 && $pm['author'] != uid){
		$pageTarget .= "&auth={$pm['author']}";
	}
	$pmReadTarget = "&pm=".pm;
}
elseif(mail == 'u'){
	$menuTitle = "مراسلات بينك وبين ".$rs['name'];
	$sqlWhere = "WHERE pm.author = '$uid' AND (pm.pmfrom = '".u."' OR pm.pmto = '".u."')";
}
elseif(mail == 'lists'){
	$menuTitle = "مجلداتك البريدية";
}
else{
	$mail=(int)mail;
	if($mail>=1&&$mail<=5&&!empty($userLists["{$mail}"])){
		$menuTitle=$userLists["{$mail}"];
		$sqlWhere="WHERE pm.author = '$uid' AND pm.pmlist = '$mail'";
	}
	else{
		$DF->goTo();
	}
}

$DF->catch['menuTitle'] = $menuTitle;

$Template->header();

$pagingLink="pm.php?mail=".mail."{$pageTarget}&";
echo"
<script type=\"text/javascript\">
var pg=".pg.";
var numPages=".num_pages.";
var link=\"{$pagingLink}\";
</script>
<script type=\"text/javascript\" src=\"js/pm.js".x."\"></script>";
if(auth > 0 && ulv > 2){
	echo"
	<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\" style=\"margin-bottom:6px;\">
		<tr>
			<td class=\"asTopHeader2 asCenter asS15\" style=\"padding:8px;\"><span class=\"asCOrange\">أنت الآن تتصفح رسائل العضو:</span> {$rs['name']}</td>
		</tr>
	</table>";
}
echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\" style=\"margin-bottom:6px;\">
	<tr>
		<td class=\"asTopHeader2\">
		<table cellSpacing=\"3\" cellPadding=\"3\">
			<tr>
				<td><a href=\"pm.php?mail=".mail."$pageTarget{$pmReadTarget}\"><img src=\"{$DFImage->h['messages']}\" border=\"0\"></a></td>
				<td class=\"asC2\" width=\"1200\"><a class=\"sec\" href=\"pm.php?mail=".mail."$pageTarget{$pmReadTarget}\">$pageTitle</a><br>$menuTitle</td>";
			if(mail=='read'){
				if($pm['pmto']==$uid&&$pm['pmout']==0){
					echo"
					<th class=\"asTHLink\"><nobr><a href=\"editor.php?type=replypm&pm=".pm."&src=".urlencode(self)."$pageTarget\"><img src=\"{$DFImage->i['reply']}\" alt=\"رد على الرسالة\" border=\"0\"><br>رد على الرسالة</a></nobr></th>";
				}
				if($pm['status']==1){
					echo"
					<th class=\"asTHLink\"><nobr><a href=\"options.php?type=movepm&pm=".pm."$pageTarget\"><img src=\"{$DFImage->i['post_delete']}\" alt=\"حذف الرسالة\" border=\"0\"><br>حذف الرسالة</a></nobr></th>";
				}
				if($pm['status']==0){
					echo"
					<th class=\"asTHLink\"><nobr><a href=\"options.php?type=restorepm&pm=".pm."$pageTarget\"><img src=\"{$DFImage->i['post_up']}\" alt=\"إسترجاع الرسالة الى مجلدها الأصلي\" hspace=\"3\" border=\"0\"><br>إسترجاع الرسالة</a></nobr></th>";
				}
			}
					echo"
					<th class=\"asTHLink\"><nobr><a href=\"pm.php?mail=lists$pageTarget\">مجلداتك<br>البريدية</a></nobr></th>";
				if(mail!='read'&&mail!='lists'){
					$Template->basicPaging("pm AS pm $sqlWhere","pm.id");
				}
				$Template->goToForum();
			echo"
			</tr>
		</table>
		</td>
	</tr>
</table>
<table width=\"100%\" cellSpacing=\"0\" cellpadding=\"0\">
	<tr>
		<td class=\"asTopHeader\"><br>
		<ul class=\"tabnav asAS12\">&nbsp;";
		if($rs['newpm']>0){
			echo"
			<li".(mail=='new'?' class="selected"':'')."><a href=\"pm.php?mail=new$pageTarget\"><em>الرسائل الواردة الجديدة&nbsp;&nbsp;[{$rs['newpm']}]</em></a></li>";
		}
			echo"
			<li".(mail=='in'?' class="selected"':'')."><a href=\"pm.php?mail=in$pageTarget\"><em>البريد الوارد</em></a></li>
			<li".(mail=='out'?' class="selected"':'')."><a href=\"pm.php?mail=out$pageTarget\"><em>البريد الصادر</em></a></li>
			<li".(mail=='trash'?' class="selected"':'')."><a href=\"pm.php?mail=trash$pageTarget\"><em>مجلد المحذوفات</em></a></li>&nbsp;&nbsp;";
 	foreach($userLists as $frmKey=>$frmVal){
		if(!empty($frmVal)){
			echo"
			<li".(mail==$frmKey?' class="selected"':'')." dir=\"ltr\"><a href=\"pm.php?mail=$frmKey$pageTarget\"><em>$frmVal</em></a></li>";
			$selectLists.="
			<option value=\"$frmKey\">$frmVal</option>";
		}
		$rowsLists.="
		<tr>
			<td class=\"asFixedB asCenter\">$frmKey</td>
			<td class=\"asFixedB\"><input type=\"text\" style=\"width:250px\" maxlength=\"25\" name=\"list$frmKey\" value=\"$frmVal\"></td>
		</tr>";
	}
		echo"
		</ul>";
	if(mail=='read'){
		if($pm['pmfrom']==0){
			$pmFromName="إدارة منتديات";
		}
		else{
			$pmSender=($pm['sender']>0 ? "<td>&nbsp;&nbsp;-&nbsp;&nbsp;</td><td>{$Template->userColorLink($pm['sender'], array($pm['sname'], $pm['sstatus'], $pm['slevel'], $pm['ssubmonitor']))}</td>" : "");
			$pmFromName=($pm['pmfrom']>0 ? $Template->userColorLink($pm['pmfrom'], array($pm['fromname'], $pm['fromstatus'], $pm['fromlevel'], $pm['fromsubmonitor'])) : "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td class=\"asDate asAS12 asS12\">إشراف {$pm['fromname']}</td>$pmSender</tr></table>");
		}
		$pmToName=($pm['pmto']>0 ? $Template->userColorLink($pm['pmto'], array($pm['toname'], $pm['tostatus'], $pm['tolevel'], $pm['tosubmonitor'])) : "<font class=\"small\"><b>إشراف {$pm['toname']}</b></font>");
		echo"
		<table width=\"100%\" cellSpacing=\"0\" cellpadding=\"0\">
			<tr>
				<td class=\"asHeader\">رسالة خاصة</td>
			</tr>
			<tr>
				<td class=\"asBody\">
				<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\">
		<tr>
			<td class=\"asFixedB\"><nobr>تنبيه هام</nobr></td>
			<td class=\"asNormalB asS12 asC4\" width=\"100%\">حفاظا على عضويتك من السرقة الرجاء عدم إعطاء كلمتك السرية في أي حال من الأحوال لأي كان.<br>إذا وصلتك رسالة فيها وصلات لصفحات تطلب منكم كلمتكم السرية الرجاء اعلام إدارة المنتديات فورا.</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>من</nobr></td>
			<td class=\"asNormalB asAS12 asS12 asDate\"><nobr>$pmFromName";
		if($pm['pmfrom']>0&&$pm['pmfrom']!=uid){
			echo"&nbsp;&nbsp;&nbsp;<a href=\"pm.php?mail=u&u={$pm['pmfrom']}\"><img src=\"{$DFImage->i['user_profile']}\" alt=\"مراسلاتك مع هذا العضو\" border=\"0\"></a>
			&nbsp;&nbsp;&nbsp;<a href=\"options.php?type=complain&method=pm&u={$pm['pmfrom']}&pm=".pm."&src=".urlencode(self)."\"><img src=\"{$DFImage->i['complain']}\" alt=\"لفت انتباه المشرف الى هذه الرسالة\" border=\"0\"></a>";
			if($pm['fromlevel']<=ulv&&$pm['fromlevel']<4 and ulv > 1){
				echo"&nbsp;&nbsp;&nbsp;<a href=\"svc.php?svc=mons&type=addmon&method=pm&u={$pm['pmfrom']}&pm=".pm."\"><img src=\"{$DFImage->i['mon']}\" alt=\"تطبيق العقوبة على العضو\" border=\"0\"></a>";
			}
		}
			echo"</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إلى</nobr></td>
			<td class=\"asNormalB asAS12 asS12 asDate\"><nobr>$pmToName";
		if($pm['pmto']>0&&$pm['pmto']!=uid){
			echo"&nbsp;&nbsp;&nbsp;<a href=\"pm.php?mail=u&u={$pm['pmto']}\"><img src=\"{$DFImage->i['user_profile']}\" alt=\"مراسلاتك مع هذا العضو\" border=\"0\"></a>";
			if($pm['tolevel']<=ulv&&$pm['tolevel']<4){
				echo"&nbsp;&nbsp;&nbsp;<a href=\"svc.php?svc=mons&type=addmon&method=pm&u={$pm['pmto']}&pm=".pm."\"><img src=\"{$DFImage->i['mon']}\" alt=\"تطبيق العقوبة على العضو\" border=\"0\"></a>";
			}
		}
			echo"</nobr></td>
		</tr>
		<tr>
			<form method=\"post\" action=\"options.php?type=movepms\">
			<input type=\"hidden\" name=\"pmid[]\" value=\"".pm."\">
			<td class=\"asFixedB\"><nobr>انقل الرسالة الى</nobr></td>
			<td class=\"asNormalB\">
				<select class=\"asGoTo\" name=\"folder\">$selectLists
					<option value=\"trash\">مجلد المحذوفات</option>
				</select>&nbsp;
				{$Template->button('أنقل',' onClick="DF.checkMovePM(this.form)"')}
			</td>
			</form>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>التاريخ</nobr></td>
			<td class=\"asNormalB asS12 asDate\"><nobr>{$DF->date($pm['date'])}</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عنوان الرسالة</nobr></td>
			<td class=\"asNormalB\"><a href=\"pm.php?mail=read&pm=".pm."$pageTarget\"><b>{$pm['subject']}</b></a></td>
		</tr>";
		if($pm['uhidepm']==1){
			echo"
			<tr>
				<td class=\"asErrorB asCenter\" colSpan=\"2\"><nobr>** تم إخفاء نص هذه الرسالة بواسطة الإدارة **</nobr></td>
			</tr>";
		}
		if($pm['uhidepm']==0||ulv>2){
			echo"
			<tr>
				<td class=\"asNormalB\" colSpan=\"2\">{$pm['message']}</td>
			</tr>";
		}
		if($pm['pmto']==$uid&&$pm['pmout']==0){
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
			frm.submit();
		}
		</script>
		<?php
		echo"
		<tr bgColor=\"white\">
			<form method=\"post\" action=\"setpost.php\">
			<input name=\"editor\" type=\"hidden\" value=\"quick\">
			<input name=\"type\" type=\"hidden\" value=\"replypm\">
			<input name=\"src\" type=\"hidden\" value=\"".urldecode(src)."\">
			<input name=\"redeclare\" type=\"hidden\" value=\"".mt_rand(1,1999999999)."\">
			<input name=\"forumid\" type=\"hidden\" value=\"".f."\">
			<input name=\"topicid\" type=\"hidden\" value=\"0\">
			<input name=\"postid\" type=\"hidden\" value=\"0\">
			<input name=\"pmfrom\" type=\"hidden\" value=\"{$pm['pmto']}\">
			<input name=\"pmto\" type=\"hidden\" value=\"{$pm['pmfrom']}\">
			<input name=\"pm\" type=\"hidden\" value=\"".pm."\">
			<input name=\"subject\" type=\"hidden\" value=\"{$pm['subject']}\">
			<td align=\"center\"><br><img src=\"{$DFImage->i['reply']}\" border=\"0\"><br><br><font color=\"red\">أضف<br>رد سريع</font></td>
			<td width=\"100%\" align=\"center\">
				<textarea name=\"message\" style=\"margin:3px;width:100%;height:150px;{$Template->getUserStyle()}\"></textarea><br>
				{$Template->button('أرسل الرد على الرسالة',' onClick="DF.checkQuickPost(this.form)"')}
			</td>
			</form>
		</tr>
		</table>
		</td>
		</tr>
		</table>";
		}
	}
	if(mail!='read'&&mail!='lists'){
		echo"
		<table width=\"100%\" cellSpacing=\"0\" cellpadding=\"0\">
		<form method=\"post\" action=\"options.php?type=movepms\">
			<tr>
				<td class=\"asHeader\">$menuTitle</td>
			</tr>
			<tr>
				<td class=\"asBody\">
				<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"4\">
					<tr>
						<td class=\"asDark asLeftBorder\" width=\"1%\">&nbsp;</td>";
					if(mail!='out'){
						echo"
						<td class=\"asDark asLeftBorder\" width=\"2%\" colspan=\"2\"><nobr><b>من</b></nobr></td>";
					}
					if(mail!='in'&&mail!='new'){
						echo"
						<td class=\"asDark asLeftBorder\" width=\"2%\" colspan=\"2\"><nobr><b>إلى</b></nobr></td>";
					}
						echo"
						<td class=\"asDark asLeftBorder\" width=\"60%\"><nobr><b>عنوان الرسالة</b></nobr></td>
						<td class=\"asDark asLeftBorder\"><nobr><b>التاريخ</b></nobr></td>
						<td class=\"asDark asLeftBorder\"><nobr><b>الحجم</b></nobr></td>";
					if(mail=='trash'||mail=='u'||mail>=1&&mail<=5){
						echo"
						<td class=\"asDark asLeftBorder\"><nobr><b>المجلد</b></nobr></td>";
					}
						echo"
						<td class=\"asDark\">&nbsp;</td>
					</tr>";
		$pgLimit=$DF->pgLimit(num_pages);
		$sql=$mysql->query("SELECT
			pm.id,pm.status,pm.date,pm.subject,pm.pmfrom,pm.pmto,pm.pmout,pm.pmread,pm.reply,LENGTH(pmm.message) AS msgsize,
			IF(pm.pmfrom>0,u.name,f.subject) AS fromname,IF(pm.pmfrom>0,u.status,0) AS fromstatus,
			IF(pm.pmfrom>0,u.level,0) AS fromlevel,IF(pm.pmfrom>0,u.submonitor,0) AS fromsubmonitor,IF(pm.pmto>0,uu.name,ff.subject) AS toname,
			IF(pm.pmto>0,uu.status,0) AS tostatus,IF(pm.pmto>0,uu.level,0) AS tolevel,IF(pm.pmto>0,uu.submonitor,0) AS tosubmonitor,
			IF(pm.pmfrom>0,uf.picture,'none.gif') AS frompicture,IF(pm.pmto>0,uuf.picture,'none.gif') AS topicture
		FROM ".prefix."pm AS pm
		LEFT JOIN ".prefix."pmmessage AS pmm ON(pmm.id = pm.id)
		LEFT JOIN ".prefix."user AS u ON(u.id = pm.pmfrom)
		LEFT JOIN ".prefix."user AS uu ON(uu.id = pm.pmto)
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = pm.pmfrom)
		LEFT JOIN ".prefix."userflag AS uuf ON(uuf.id = pm.pmto)
		LEFT JOIN ".prefix."forum AS f ON(f.id = ABS(pm.pmfrom))
		LEFT JOIN ".prefix."forum AS ff ON(ff.id = ABS(pm.pmto))
		$sqlWhere GROUP BY pm.id ORDER BY pm.date DESC LIMIT $pgLimit,".num_pages, __FILE__, __LINE__);
		$count=0;
		while($pm=$mysql->fetchAssoc($sql)){
			$pmid=$DF->numToHash($pm['id']);
			
			$pmFromName=$DF->catch['pmFromName']["".$pm['pmfrom'].""];
			$pmToName=$DF->catch['pmToName']["".$pm['pmto'].""];
			if(!$pmFromName){
				if($pm['pmfrom']==0){
					$pmFromName="إدارة منتديات";
				}
				else{
					$pmFromName=$DF->catch['pmFromName']["".$pm['pmfrom'].""]=($pm['pmfrom']>0 ? $Template->userColorLink($pm['pmfrom'],array($pm['fromname'], $pm['fromstatus'], $pm['fromlevel'], $pm['fromsubmonitor'])) : "إشراف {$pm['fromname']}");
				}
			}
			if(!$pmToName){
				$pmToName=$DF->catch['pmToName']["".$pm['pmto'].""]=($pm['pmto']>0 ? $Template->userColorLink($pm['pmto'], array($pm['toname'], $pm['tostatus'], $pm['tolevel'], $pm['tosubmonitor'])) : "إشراف {$pm['toname']}");
			}
			
			$pmClass=($pm['pmread']==0 ? 'asFixed' : 'asNormal');
			$replyIcon=($pm['reply']==1 ? "<img src=\"{$DFImage->i['reply']}\" alt=\"هذه الرسالة رد على رسالة السابقة\" align=\"absMiddle\" hspace=\"3\" border=\"0\">&nbsp;" : "");
			
			if(mail=='trash'||mail=='u'||mail>=1&&mail<=5){
				if($pm['pmto']==$uid&&$pm['pmout']==0){
					$pmfolder="بريد الوارد";
				}
				elseif($pm['pmfrom']==$uid&&$pm['pmout']==1){
					$pmfolder="بريد الصادر";
				}
				else{
					$pmfolder="------";
				}
				$mailFolder="
				<td class=\"$pmClass asLeftBorder asS12 asDate asCenter\"><nobr>$pmfolder</nobr></td>";
			}
			$optionsIcon="";
			if($pm['pmto']==$uid&&$pm['pmout']==0){
				$optionsIcon="<a href=\"editor.php?type=replypm&pm=$pmid&src=".urlencode(self)."$pageTarget\"><img src=\"{$DFImage->i['reply']}\" alt=\"رد على الرسالة\" hspace=\"3\" border=\"0\"></a>";
			}
			if($pm['status']==1){
				$optionsIcon.="<a href=\"options.php?type=movepm&pm=$pmid$pageTarget\"><img src=\"{$DFImage->i['post_delete']}\" alt=\"حذف الرسالة\" hspace=\"3\" border=\"0\"></a>";
			}
			if($pm['status']==0){
				$optionsIcon.="<a href=\"options.php?type=restorepm&pm=$pmid$pageTarget\"><img src=\"{$DFImage->i['post_up']}\" alt=\"إسترجاع الرسالة الى مجلدها الأصلي\" hspace=\"3\" border=\"0\"></a>";
			}
			
			echo"
			<tr class=\"$pmClass\" id=\"tr$pmid\">
				<td class=\"$pmClass asLeftBorder\"><input type=\"checkbox\" class=\"none\" onClick=\"DF.chkTrClass(this,'$pmid','$pmClass')\" name=\"pmid[]\" value=\"$pmid\"><input type=\"hidden\" name=\"bg$pmid\" id=\"bg$pmid\" value=\"$pmClass\"></td>";
			if(mail!='out'){
				echo"
				<td class=\"$pmClass asLeftBorder asCenter\"><nobr><img src=\"{$DFPhotos->getsrc($pm['frompicture'], 48)}\"{$DF->picError(32)} width=\"32\" height=\"32\" border=\"0\"></nobr></td>
				<td class=\"$pmClass asLeftBorder asAS12 asS12 asDate asCenter\"><nobr>$pmFromName</nobr></td>";
			}
			if(mail!='in'&&mail!='new'){
				echo"
				<td class=\"$pmClass asLeftBorder asCenter\"><nobr><img src=\"{$DFPhotos->getsrc($pm['topicture'], 48)}\"{$DF->picError(32)} width=\"32\" height=\"32\" border=\"0\"></nobr></td>
				<td class=\"$pmClass asLeftBorder asAS12 asS12 asDate asCenter\"><nobr>$pmToName</nobr></td>";
			}
				echo"
				<td class=\"$pmClass asLeftBorder\">$replyIcon<a href=\"pm.php?mail=read&pm=$pmid$pageTarget\">{$pm['subject']}</a></td>
				<td class=\"$pmClass asLeftBorder asS12 asDate asCenter\"><nobr>{$DF->date($pm['date'])}</nobr></td>
				<td class=\"$pmClass asLeftBorder asS12 asCenter\"><nobr>{$pm['msgsize']}</nobr></td>$mailFolder
				<td class=\"$pmClass asCenter\"><nobr>$optionsIcon</nobr></td>
			</tr>";
			$count++;
		}
		if($count==0){
			echo"
			<tr>
				<td class=\"asNormal asCenter\" colspan=\"10\"><br>لا توجد اي رسالة في هذا المجلد<br><br></td>
			</tr>";
		}
		echo"
		</table>
		</td>
		</tr>
		</table>";
	}
	if(mail=='lists'){
		echo"
		<table width=\"100%\" cellSpacing=\"0\" cellpadding=\"0\">
			<tr>
				<td class=\"asHeader\">$menuTitle</td>
			</tr>
			<tr>
				<td class=\"asBody asP5\">
				<table cellSpacing=\"1\" cellPadding=\"4\" align=\"center\">
				<form method=\"post\" action=\"options.php?type=edituserfolders\">
				<input type=\"hidden\" name=\"auth\" value=\"".auth."\">
				<input type=\"hidden\" name=\"fid\" value=\"".f."\">
					<tr>
						<td class=\"asDarkB asCenter\" colSpan=\"2\">لإضافة مجلدات بريدية خاصة بك لحفظ الرسائل فيها<br>أدخل عنواين للمجلدات في الخانات أدناه</td>
					</tr>
					<tr>
						<td class=\"asDarkB\"><nobr>رقم المجلد</nobr></td>
						<td class=\"asDarkB\"><nobr>عنوان المجلد</nobr></td>
					</tr>$rowsLists
					<tr>
						<td class=\"asFixedB asCenter\" colSpan=\"2\"><br>{$Template->button('أدخل التغييرات على مجلداتك البريدية',' onClick="this.form.submit();"')}<br><br></td>
					</tr>
					<tr>
						<td class=\"asNormalB asS12 asCenter\" colspan=\"2\">ملاحظة: لحذف أي مجلد إترك إسمه فارغا.<br>سيتم نقل اي رسائل في ذلك المجلد الى مجلدها الأصلي</td>
					</tr>
				</form>
				</table>
				</td>
			</tr>
		</table>";
	}
		echo"
		</td>
	</tr>
</table>";
if(mail!='read'&&mail!='lists'){
	echo"
	<table width=\"100%\" cellspacing=\"0\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asBody asCenter\"><br>
			{$Template->button('تحديد الكل',' onClick="DF.chkBox(this.form,this)"')}
			{$Template->button('أنقل الرسائل المختارة الى',' onClick="DF.checkMovePM(this.form)"')}
			<select class=\"asGoTo\" name=\"folder\">$selectLists
				<option value=\"trash\">مجلد المحذوفات</option>";
			if(mail=='trash'||mail>=1&&mail<=5){
				echo"
				<option value=\"restore\">مجلداتهم الأصلية</option>";
			}
			echo"
			</select><br><br>
			</td>
		</tr>
	</form>
	</table>";
}
//************************* end page **********************************
}
else{
	$DF->goTo();
}
$Template->footer();
?>