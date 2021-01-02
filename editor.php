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

const _df_script = "editor";
const _df_filename = "editor.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if(type=='newtopic'){
	$editorTitle=$DF->catch['editorTypeTitle']="إضافة موضوع";
	$editorIcon=$DFImage->f['folder'];
	$errTitle="لا يمكنك إضافة موضوع";
}
elseif(type=='edittopic'){
	$editorTitle=$DF->catch['editorTypeTitle']="تغيير نص الموضوع";
	$editorIcon=$DFImage->f['edit'];
	$errTitle="لا يمكنك تغيير نص الموضوع";
}
elseif(type=='newpost'||type=='quotepost'){
	$editorTitle=$DF->catch['editorTypeTitle']="الرد على هذا الموضوع";
	$editorIcon=$DFImage->i['reply'];
	$errTitle="لا يمكنك الرد على هذا الموضوع";
}
elseif(type=='editpost'){
	$editorTitle=$DF->catch['editorTypeTitle']="تغيير نص الرد";
	$editorIcon=$DFImage->i['post_edit'];
	$errTitle="لا يمكنك تغيير نص الرد";
}
elseif(type=='signature'){
	$editorTitle=$DF->catch['editorTypeTitle']="تعديل التوقيع";
	$editorIcon=$DFImage->i['edit'];
	$errTitle="لا يمكن تعديل التوقيع";
}
elseif(type=='sendpm'){
	$editorTitle=$DF->catch['editorTypeTitle']="إرسال رسالة";
	$editorIcon=(f<0&&$isModerator?$DFImage->i['message_forum']:$DFImage->i['message']);
	$errTitle="لا يمكن إرسال رسالة";
}
elseif(type=='replypm'){
	$editorTitle=$DF->catch['editorTypeTitle']="رد على الرسالة";
	$editorIcon=$DFImage->i['reply'];
	$errTitle="لا يمكنك الرد على الرسالة";
}
elseif(type=='sendpmtousers'){
	$editorTitle=$DF->catch['editorTypeTitle']="إرسال رسالة جماعية";
	$editorIcon=$DFImage->i['reply'];
	$errTitle="لا يمكن إرسال رسالة جماعية";
}
else{
	$DF->goTo();
	exit();
}

$Template->header();

if(ulv==0){
	$Template->errMsg("$errTitle<br>بسبب انت لم قمت بدخول للمنتديات أو انت غير مسجل لدينا<br>فإذا انت مسجل عندنا قم بالدخول للمنتديات<br>واذا لا فيجب عليك تسجيل عضوية بالنقر لرابط الأدناه<br><br><a href=\"register.php\">-- انقر هنا للتسجيل --</a>",0,false);
	exit();
}

/* if(!$DF->browse()){
	$Template->errMsg("لا يمكنك إدخال النص لأنك تستخدم متصفح قديم أو غير ملائم لمعالج النص.<br>الرجاء استخدام متصفح مايكروسوف إنترنت إكسبلورر 5 على الأقل.<br>يمكنك تحميل أحدث نسخة من هذا المتصفح من الوصلة التالية من موقع مايكروسوف:<br><br><a href=\"http://www.microsoft.com/windows/ie/default.asp\" target=\"_blank\">-- صفحة التحميل --</a>");
	exit();
} */

if(type=='newtopic'){
	$f=f;
	
	$checkSqlField="";
	$checkSqlTable="";
	
	if(ulv<4&&!$isModerator){
		$checkSqlField="
			,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id),1,0) AS allowforum
			,ff.totaltopics,f.sex,uf.sex AS usex,COUNT(t.id) AS todaytopics
		";
		$checkSqlTable="
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = '".uid."')
			LEFT JOIN ".prefix."forumflag AS ff ON(ff.id = f.id)
			LEFT JOIN ".prefix."userflag AS uf ON(uf.id = '".uid."')
			LEFT JOIN ".prefix."topic AS t ON(t.forumid = f.id AND t.author = '".uid."' AND t.date > '".(time-86400)."')
		";
	}
	else{
		$checkSqlField=",IF(ISNULL(f.id),0,1) AS allowforum";
	}
	
 	$sql=$mysql->query("SELECT f.status,f.subject $checkSqlField
	FROM ".prefix."forum AS f 
	$checkSqlTable
	WHERE f.id = '$f' GROUP BY f.id", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	
	$findError=true;
	if(!$rs||$rs['allowforum']==0){
		$errmsg="$errTitle<br>قد يكون هناك عدة إسباب لهذا منها:<br><br><table><tr><td>* رقم المنتدى المطلوب غير صحيح. </td></tr><tr><td>* المنتدى المطلوب تم حذفه نهائياً. </td></tr><tr><td>* المنتدى المطلوب لا يسمح لك بالدخول اليه. </td></tr></table>";
	}
	elseif(ustopaddpost==1){
		$errmsg="$errTitle<br>بسبب لقد تم منعك من المشاركة في جميع منتديات.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif($DF->getMonStatus('forbidforum',$f)==1){
		$errmsg="$errTitle<br>بسبب لقد تم منعك من المشاركة في هذا المنتدى.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif(ulv<4&&!$isModerator&&$rs['status']==0){
		$errtype="theforumislocked";
	}
	elseif(ulv<4&&!$isModerator&&$rs['sex']>0&&$rs['sex']!=$rs['usex']){
		$errtype="errorinforumsex{$rs['sex']}";
	}
	elseif(ulv<4&&!$isModerator&&$rs['todaytopics']>=$rs['totaltopics']){
		$errmsg="لا يمكنك المشاركة بأكثر من {$rs['totaltopics']} مواضيع في هذا المنتدى في فترة 24 ساعة.<br>الرجاء المحاولة بعد قليل.";
	}
	else{
		$findError=false;
	}
	
	if(!$findError){
		$editorSubject=$Template->forumLink($f,$rs['subject']);
		$topicSubject="";
		$topicAuthor="";
		$msgContent="";
		$subPostsText="مواضيع المتبقية لك<br>في هذا المنتدى: <font class=\"asC2\">".(isset($rs['todaytopics']) ? ($rs['totaltopics']-$rs['todaytopics']) : 'غير محدد')."</font>";
	}
}
elseif(type=='edittopic'){
	$f=$thisForum;
	$t=t;
	
	$checkSqlField="";
	$checkSqlTable="";
	
	if(ulv<3&&!$isModerator){
		$checkSqlField="
			,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id),1,0) AS allowforum
			,IF(t.trash = 1 OR t.moderate > 0 OR t.author <> ".uid.",0,1) AS allowtopic
			,ff.totaltopics,COUNT(tt.id) AS todaytopics
		";
		$checkSqlTable="
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = '".uid."')
			LEFT JOIN ".prefix."forumflag AS ff ON(ff.id = f.id)
			LEFT JOIN ".prefix."topic AS tt ON(tt.forumid = f.id AND tt.author = '".uid."' AND tt.date > '".(time-86400)."')
		";
	}
	else{
		$checkSqlField=",IF(ISNULL(f.id),0,1) AS allowforum,IF(ISNULL(t.id),0,1) AS allowtopic";
	}
	
 	$sql=$mysql->query("SELECT f.status AS fstatus,f.subject AS fsubject,t.status,t.subject,tm.message
		$checkSqlField
	FROM ".prefix."topic AS t
	LEFT JOIN ".prefix."topicmessage AS tm ON(tm.id = t.id)
	LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
	$checkSqlTable
	WHERE t.id = '$t' GROUP BY t.id", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	
	$findError=true;
	if(!$rs||$rs['allowforum']==0||$rs['allowtopic']==0){
		$errmsg="$errTitle<br>قد يكون هناك عدة إسباب لهذا منها:<br><br><table><tr><td>* رقم الموضوع المطلوب غير صحيح. </td></tr><tr><td>* الموضوع لم تتم الموافقة عليه للآن من قبل طاقم الإشراف. </td></tr><tr><td>* الموضوع تم تجميده أو حذفه أو إخفاؤه. </td></tr><tr><td>* المنتدى الذي فيه الموضوع لا يسمح لك بالدخول اليه. </td></tr></table>";
	}
	elseif(ulv<4&&!$isModerator&&$rs['fstatus']==0){
		$errtype="theforumislocked";
	}
	elseif(ustopaddpost==1){
		$errmsg="$errTitle<br>بسبب لقد تم منعك من المشاركة في جميع منتديات.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif($DF->getMonStatus('forbidforum',$f)==1){
		$errmsg="$errTitle<br>بسبب لقد تم منعك من المشاركة في هذا المنتدى.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif(ulv<4&&!$isModerator&&$rs['status']==0){
		$errmsg="$errTitle<br>لأن الموضوع تم قفله بواسطة المشرف.";
	}
	else{
		$findError=false;
	}
	
	if(!$findError){
		$editorSubject=$Template->forumLink($f,$rs['fsubject']);
		$topicSubject=$rs['subject'];
		$topicAuthor="";
		$msgContent=$rs['message'];
		$subPostsText="مواضيع المتبقية لك<br>في هذا المنتدى: <font class=\"asC2\">".(isset($rs['todaytopics']) ? ($rs['totaltopics']-$rs['todaytopics']) : 'غير محدد')."</font>";
	}
}
elseif(type=='newpost'||type=='quotepost'){
	$f=$thisForum;
	$t=t;
	
	$checkSqlField="";
	$checkSqlTable="";
	
	if(ulv<4&&!$isModerator){
		$checkSqlField="
			,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id),1,0) AS allowforum
			,IF(ISNULL(tu.id),0,1) AS allowtopic
			,ff.totalposts,COUNT(p.id) AS todayposts,f.sex,uf.sex AS usex
		";
		$checkSqlTable="
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = '".uid."')
			LEFT JOIN ".prefix."topicusers AS tu ON(tu.topicid = t.id AND tu.userid = '".uid."')
			LEFT JOIN ".prefix."forumflag AS ff ON(ff.id = f.id)
			LEFT JOIN ".prefix."userflag AS uf ON(uf.id = '".uid."')
			LEFT JOIN ".prefix."post AS p ON(p.forumid = f.id AND p.author = '".uid."' AND p.date > '".(time-86400)."')
		";
	}
	else{
		$checkSqlField=",IF(ISNULL(f.id),0,1) AS allowforum";
	}
	
	if(type=='quotepost'&&p==0){
		$checkSqlField.=",t.date,tm.message";
		$checkSqlTable.="LEFT JOIN ".prefix."topicmessage AS tm ON(tm.id = t.id)";
	}
	
 	$sql=$mysql->query("SELECT f.status AS fstatus,f.subject AS fsubject,t.status,t.subject,t.author,t.trash,t.hidden,
		t.moderate,t.posts,u.name AS aname $checkSqlField
	FROM ".prefix."topic AS t
	LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = t.author)
	$checkSqlTable
	WHERE t.id = '$t' GROUP BY t.id", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	
	$findError=true;
	if(!$rs||$rs['allowforum']==0){
		$errmsg="$errTitle<br>بسبب لا يسمح لك بإضافة ردود في هذا المنتدى";
	}
	elseif(ulv<4&&!$isModerator&&$rs['fstatus']==0){
		$errtype="theforumislocked";
	}
	elseif(ustopaddpost==1){
		$errmsg="$errTitle<br>بسبب لقد تم منعك من المشاركة في جميع منتديات.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif($DF->getMonStatus('forbidforum',$f)==1){
		$errmsg="$errTitle<br>بسبب لقد تم منعك من المشاركة في هذا المنتدى.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif(ulv<4&&!$isModerator&&$rs['trash']==1){
		$errmsg="$errTitle<br>لأن الموضوع تم حذفه بواسطة المشرف.";
	}
	elseif($rs['posts']>=topic_max_posts){
		$errmsg="لا يمكن إضافة ردود لهذا الموضوع لأنه تجاوز الحد الأقصى وهو (".topic_max_posts.") رد";
		if($rs['status']==1){
			$mysql->update("topic SET status = 0 WHERE id = '$t'", __FILE__, __LINE__);
		}
	}
	elseif(ulv<4&&!$isModerator&&$rs['status']==0){
		$errmsg="$errTitle<br>لأن الموضوع تم قفله بواسطة المشرف.";
	}
	elseif(ulv<4&&!$isModerator&&$rs['moderate']==1){
		$errmsg="$errTitle<br>لأن الموضوع لم تتم الموافقة عليه للآن.<br><br>الرجاء المحاولة في وقت لاحق.";
	}
	elseif(ulv<4&&!$isModerator&&$rs['moderate']==2){
		$errmsg="$errTitle<br>لأن الموضوع تم تجميده بواسطة المشرف.";
	}
	elseif(ulv<4&&!$isModerator&&$rs['hidden']==1&&$rs['allowtopic']==0){
		$errmsg="$errTitle<br>لأن الموضوع تم إخفائه بواسطة المشرف.";
	}
	elseif(ulv<4&&!$isModerator&&$rs['sex']>0&&$rs['sex']!=$rs['usex']){
		$errtype="errorinforumsex{$rs['sex']}";
	}
	elseif(ulv<4&&!$isModerator&&$rs['todayposts']>=$rs['totalposts']){
		$errmsg="لا يمكنك المشاركة بأكثر من {$rs['totalposts']} رد في هذا المنتدى في فترة 24 ساعة.<br>الرجاء المحاولة بعد قليل.";
	}
	else{
		$findError=false;
	}
	
	if(!$findError){
		if(type=='quotepost'){
			if(p==0){
				$quote=$rs;
			}
			else{
				$sql=$mysql->query("SELECT p.author,u.name AS aname,p.date,pm.message
				FROM ".prefix."post AS p
				LEFT JOIN ".prefix."postmessage AS pm ON(pm.id = p.id)
				LEFT JOIN ".prefix."user AS u ON(u.id = p.author)
				WHERE p.id = '".p."' AND p.topicid = '$t'", __FILE__, __LINE__);
				$quote=$mysql->fetchAssoc($sql);
			}
			$quotePost="
			<center>
			<table bordercolor=\"gray\" cellspacing=\"0\" cellpadding=\"0\" width=\"95%\" border=\"0\">
				<tr>
					<td width=\"5%\" bgcolor=\"gray\"><font color=\"yellow\" size=\"2\"><nobr>&nbsp;إقتباس لمشاركة:&nbsp;&nbsp;</nobr></font></td>
					<td width=\"5%\" bgcolor=\"gray\"><font size=\"2\"><b><a href=\"profile.php?u={$quote['author']}\"><font color=#ffffff><nobr>{$quote['aname']}</nobr></font></a></b></font></td>
					<td width=\"90%\" bgcolor=\"gray\"><font color=\"yellow\" size=\"2\"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$DF->date($quote['date'],'',true,true)}</nobr></font></td>
				</tr>
				<tr>
					<td colspan=\"3\">
					<table bordercolor=\"gray\" cellpadding=\"4\" width=\"100%\" border=\"1\">
						<tr>
							<td>{$quote['message']}</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
			</center>";
		}
		$editorSubject=$Template->forumLink($f,$rs['fsubject']);
		$topicSubject=$Template->topicLink($t,$rs['subject']);
		$topicAuthor=$Template->userNormalLink($rs['author'],$rs['aname']);
		$msgContent=(type=='quotepost' ? (p>0&&!$quote ? '' : $quotePost) : '');
		$subPostsText="ردود المتبقية لك<br>في هذا المنتدى: <font class=\"asC2\">".(isset($rs['todayposts']) ? ($rs['totalposts']-$rs['todayposts']) : 'غير محدد')."</font>";
	}
}
elseif(type=='editpost'){
	$f=$thisForum;
	$p=p;
	
	$checkSqlField="";
	$checkSqlTable="";
	
	if(ulv<4&&!$isModerator){
		$checkSqlField="
			,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id),1,0) AS allowforum
			,IF(ISNULL(tu.id),0,1) AS allowtopic
			,IF(p.trash = 1 OR p.moderate > 0 OR p.author <> ".uid.",0,1) AS allowpost
			,ff.totalposts,COUNT(pp.id) AS todayposts
		";
		$checkSqlTable="
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = '".uid."')
			LEFT JOIN ".prefix."topicusers AS tu ON(tu.topicid = t.id AND tu.userid = '".uid."')
			LEFT JOIN ".prefix."forumflag AS ff ON(ff.id = f.id)
			LEFT JOIN ".prefix."post AS pp ON(pp.forumid = f.id AND pp.author = '".uid."' AND pp.date > '".(time-86400)."')
		";
	}
	else{
		$checkSqlField=",IF(ISNULL(f.id),0,1) AS allowforum";
	}
	
 	$sql=$mysql->query("SELECT f.status AS fstatus,f.subject AS fsubject,t.status,t.subject,t.author,t.trash,t.hidden,
		t.moderate,u.name AS aname,p.topicid,pm.message AS message $checkSqlField
	FROM ".prefix."post AS p
	LEFT JOIN ".prefix."postmessage AS pm ON(pm.id = p.id)
	LEFT JOIN ".prefix."topic AS t ON(t.id = p.topicid)
	LEFT JOIN ".prefix."forum AS f ON(f.id = p.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = t.author)
	$checkSqlTable
	WHERE p.id = '$p' GROUP BY p.id", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	
	$findError=true;
	if(!$rs||$rs['allowforum']==0){
		$errmsg="$errTitle<br>بسبب لا يسمح لك بإضافة ردود في هذا المنتدى";
	}
	elseif(ustopaddpost==1){
		$errmsg="$errTitle<br>بسبب لقد تم منعك من المشاركة في جميع منتديات.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif($DF->getMonStatus('forbidforum',$f)==1){
		$errmsg="$errTitle<br>بسبب لقد تم منعك من المشاركة في هذا المنتدى.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif(ulv<4&&!$isModerator&&$rs['allowpost']==0){
		$errmsg="$errTitle<br>بسبب لا عندك تصريح بتغيير نص هذا الرد";
	}
	elseif(ulv<4&&!$isModerator&&$rs['fstatus']==0){
		$errtype="theforumislocked";
	}
	elseif(ulv<4&&!$isModerator&&$rs['trash']==1){
		$errmsg="$errTitle<br>لأن الموضوع تم حذفه بواسطة المشرف.";
	}
	elseif(ulv<4&&!$isModerator&&$rs['status']==0){
		$errmsg="$errTitle<br>لأن الموضوع تم قفله بواسطة المشرف.";
	}
	elseif(ulv<4&&!$isModerator&&$rs['moderate']==1){
		$errmsg="$errTitle<br>لأن الموضوع لم تتم الموافقة عليه للآن.<br><br>الرجاء المحاولة في وقت لاحق.";
	}
	elseif(ulv<4&&!$isModerator&&$rs['moderate']==2){
		$errmsg="$errTitle<br>لأن الموضوع تم تجميده بواسطة المشرف.";
	}
	elseif(ulv<4&&!$isModerator&&$rs['hidden']==1&&$rs['allowtopic']==0){
		$errmsg="$errTitle<br>لأن الموضوع تم إخفائه بواسطة المشرف.";
	}
	else{
		$findError=false;
	}
	
	if(!$findError){
		$t=$rs['topicid'];
		$editorSubject=$Template->forumLink($f,$rs['fsubject']);
		$topicSubject=$Template->topicLink($t,$rs['subject']);
		$topicAuthor=$Template->userNormalLink($rs['author'],$rs['aname']);
		$msgContent=$rs['message'];
		$subPostsText="ردود المتبقية لك<br>في هذا المنتدى: <font class=\"asC2\">".(isset($rs['todayposts']) ? ($rs['totalposts']-$rs['todayposts']) : 'غير محدد')."</font>";
	}
}
elseif(type=='signature'){
	$u=(u>0&&ulv>2?u:uid);
	$sql=$mysql->query("SELECT u.name,uf.signature
	FROM ".prefix."user AS u 
	LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
	WHERE u.id = '$u'", __FILE__, __LINE__);
	$rs=$mysql->fetchRow($sql);
	if(!$rs){
		$errmsg="لم يتم تغيير التوقيع لخطأ في البيانات المدخلة أو خلل في النظام.";
	}
	elseif(uuneditsignature==1){
		$errmsg="تم منعك من تغير توقيعك من قبل الإدارة";
	}
	else{
		$signature=$mysql->get("userflag","signature",$u);
		$editorSubject="<a class=\"headerMenu\" href=\"profile.php?u=$u\">{$rs[0]}</a>";
		$topicSubject="";
		$topicAuthor="";
		$msgContent=$rs[1];		
	}
}
elseif(type=='sendpm'){
	$f=f;
	$u=abs(u);
	
	if(f<0&&$isModerator){
		$fromid=f;
		$fromname="إشراف {$mysql->get("forum","subject",abs(f))}";
	}
	else{
		$fromid=uid;
		$fromname=uname;
	}
	
	if(u<0){
		$isModerator2=false;
		$isMonitor2=false;
		if($u>0){
			$showTools2=$DF->showTools($u);
			if($showTools2==2){
				$isModerator2=true;
				$isMonitor2=true;
			}
			elseif($showTools2==1){
				$isModerator2=true;
			}
		}
	}
	
	$checkSqlField="";
	$checkSqlTable="";
	$checkSqlWhere="";
	
	if(u>0&&ulv>1){
		$checkSqlField=",IF(u.id > 0,1,0) AS accept";
	}
	elseif(u>0){
		$checkSqlField=",IF(up.receivepm = 1,1,0) AS accept,IF(NOT ISNULL(b.id),1,0) AS block";
		$checkSqlTable="
			LEFT JOIN ".prefix."userperm AS up ON(up.id = u.id)
			LEFT JOIN ".prefix."blocks AS b ON(b.userid = u.id AND b.blockid = ".uid.")
		";
		$checkSqlWhere="AND u.status = 1";
	}
	elseif(u<0&&$isModerator2){
		$checkSqlField=",IF(f.id = 0,0,1) AS accept";
	}
	elseif(u<0){
		$checkSqlField=",IF(ff.hidepm = 0 AND (f.hidden = 0 AND f.level <= '".ulv."' OR f.hidden = 1 AND fu.id > 0),1,0) AS accept";
		$checkSqlTable="
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = '".uid."')
			LEFT JOIN ".prefix."forumflag AS ff ON(ff.id = f.id)
		";
	}
	
	if(u>0){
		$sql=$mysql->query("SELECT u.name AS toname $checkSqlField
		FROM ".prefix."user AS u
		$checkSqlTable
		WHERE u.id = '$u' $checkSqlWhere GROUP BY u.id", __FILE__, __LINE__);
	}
	elseif(u<0){
		$sql=$mysql->query("SELECT f.subject AS toname $checkSqlField
		FROM ".prefix."forum AS f
		$checkSqlTable
		WHERE f.id = '$u' $checkSqlWhere GROUP BY f.id", __FILE__, __LINE__);
	}
	
	$rs=$mysql->fetchAssoc($sql);
	$findError=true;
	
	$numFor24Hours=0;
	if(ulv<2){
		$yesterday=time-86400;
		$numFor24Hours=$DFOutput->count("pm WHERE author = '$fromid' AND pmout = 1 AND date > '$yesterday'");
	}
	
	if(u>0){
		if(!$rs){
			$errmsg="$errTitle<br>بسبب ان رقم العضوية الذي ترسل له رسالة هو خاطيء";
		}
		elseif(ustopsendpm==1){
			$errmsg="$errTitle<br>بسبب لقد تم منعك من إرسال رسائل خاصة.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
		}
		elseif($rs['accept']==0){
			$errmsg="لا يمكنك إرسال رسالة خاصة لهذا العضو لأنه لا يقبل إستلام الرسائل الخاصة";
		}
		elseif($rs['block']==1){
			$errmsg="لا يمكنك إرسال رسالة خاصة لهذا العضو<br>بسبب ان هذا العضو قمت بمنعك من مراسلته";
		}
		elseif(ulv<2&&new_user_can_send_pm>uposts){
			$errmsg="لا يمكن للأعضاء الجدد إستخدام نظام الرسائل الخاصة إلا الرد على الرسائل.<br><br>سيتم فتح نظام الرسائل الخاصة بالكامل لك أوتوماتيكيا بعد فترة من نشاطك في المنتديات.";
		}
		elseif($numFor24Hours>count_pm_for_24_hour){
			$errmsg="لا يمكنك إرسال رسائل خاصة حاليا لأنك تجاوزت الحد الأقصى للرسائل الخاصة في اليوم";
		}
		else{
			$findError=false;
			$toname=$rs['toname'];
		}
	}
	elseif(u<0){
		if(!$rs){
			$errmsg="$errTitle<br>بسبب ان رقم المنتدى الذي ترسل لها رسالة هو خاطيء";
		}
		elseif(ustopsendpm==1){
			$errmsg="$errTitle<br>بسبب لقد تم منعك من إرسال رسائل خاصة.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
		}
		elseif($rs['accept']==0){
			$errmsg="$errTitle<br>بسبب لا عندك تصريح لإرسال رسالة لهذا المنتدى";
		}
		elseif($numFor24Hours>count_pm_for_24_hour){
			$errmsg="لا يمكنك إرسال رسائل خاصة حاليا لأنك تجاوزت الحد الأقصى للرسائل الخاصة في اليوم";
		}
		else{
			$findError=false;
			$toname="إشراف {$rs['toname']}";
		}
	}
	else{
		$errmsg="$errTitle<br>بسبب هذه العضوية فقط يرسل رسائل إدارية والتنبيهات ولا يقبل رسائل";
	}

	if(!$findError){
		$useTopicSubject=(t>0||p>0 ? "رسالة بخصوص ".(p>0 ? "ردك في موضوع" : "موضوعك").": {$mysql->get("topic","subject",t)}" : "");
		$editorSubject="الرسائل الخاصة";
		$topicSubject=(!empty($useTopicSubject) ? $useTopicSubject : "الرسالة من $fromname الى $toname");
		$topicAuthor="";
		$msgContent="";
		$pmfrom=$fromid;
		$pmto=u;
	}
}
elseif(type=='replypm'){
	if(f<0&&$isModerator){
		$pmfrom=f;
	}
	else{
		$pmfrom=uid;
	}
	
	$sql=$mysql->query("SELECT pmfrom,pmto,subject FROM ".prefix."pm WHERE id = '{$DF->hashToNum(pm)}' AND author = '$pmfrom' AND pmout = 0", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	$findError=true;
	
	if(ulv<2){
		$yesterday=time-86400;
		$numFor24Hours=$DFOutput->count("pm WHERE author = '$pmfrom' AND pmout = 1 AND date > '$yesterday'");
	}
	
	if(!$rs){
		$errmsg="$errTitle<br>قد يكون هناك عدة إسباب لهذا منها:<br><br><table><tr><td>* رقم الرسالة المطلوبة غير صحيحة.</td></tr><tr><td>* الرسالة المطلوبة غير موجود في بريدك الوارد.</td></tr></table>";
	}
	elseif(ustopsendpm==1){
		$errmsg="$errTitle<br>بسبب لقد تم منعك من إرسال رسائل خاصة.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif($numFor24Hours>count_pm_for_24_hour){
		$errmsg="لا يمكنك إرسال رسائل خاصة حاليا لأنك تجاوزت الحد الأقصى للرسائل الخاصة في اليوم";
	}
	elseif($rs['pmfrom']==0){
		$errmsg="$errTitle<br>بسبب هذه العضوية فقط يرسل رسائل إدارية والتنبيهات ولا يقبل رسائل";
	}
	else{
		$findError=false;
	}

	if(!$findError){
		$editorSubject="الرسائل الخاصة";
		$topicSubject=$rs['subject'];
		$topicAuthor="";
		$msgContent="";
		$pmfrom=$pmfrom;
		$pmto=$rs['pmfrom'];
	}
}
elseif(type=='sendpmtousers'){
	if(ulv==4){
		$findError=false;
		if(!$findError){
			$editorSubject="الرسائل الخاصة";
			$topicSubject="";
			$topicAuthor="";
			$msgContent="";
		}
	}
	else{
		$DF->goTo();
	}
}

if(!empty($errmsg)){
	$Template->errMsg($errmsg);
	exit();
}
elseif(!empty($errtype)){
	$errors=array();
	$errors['errorinforumid']="$errTitle<br>بسبب ان رقم المنتدى هو خاطيء<br>مرجوا عدم استخدام روابط يدوياً";
	$errors['errorintopicid']="$errTitle<br>بسبب ان رقم الموضوع هو خاطيء<br>مرجوا عدم استخدام روابط يدوياً";
	$errors['errorinpostid']="$errTitle<br>بسبب ان رقم الرد هو خاطيء<br>مرجوا عدم استخدام روابط يدوياً";
	$errors['thecatislocked']="$errTitle<br>بسبب ان هذه الفئة هي مقفولة";
	$errors['theforumislocked']="$errTitle<br>لأن المنتدى مقفول بواسطة الإدارة.";
	$errors['thetopicislocked']="$errTitle<br>لأن الموضوع تم قفله بواسطة المشرف.";
	$errors['errorinforumsex1']="لا يمكنك المشاركة في هذا المنتدى لأنه مخصص لمشاركة الذكور فقط.";
	$errors['errorinforumsex2']="لا يمكنك المشاركة في هذا المنتدى لأنه مخصص لمشاركة الإناث فقط.";
	$Template->errMsg($errors["{$errtype}"]);
	exit();
}
echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
	<tr>
		<td class=\"asTopHeader\">
		<table cellSpacing=\"3\" cellPadding=\"3\">
			<tr>
				<td width=\"1200\">
				<table cellSpacing=\"0\" cellPadding=\"0\">
					<tr>
						<td><img src=\"{$editorIcon}\" hspace=\"6\" border=\"0\"></td>
						<td class=\"asC1 asS15 asAC1\"><nobr>{$editorSubject}</nobr></td>
					</tr>
				</table>
				</td>";
			if(!empty($subPostsText)){
				echo"
				<td class=\"asText asCenter\"><nobr>$subPostsText</nobr></td>";
			}
				echo"
				<th class=\"asTHLink\"><nobr><a href=\"rules.php\">شروط<br>المشاركة</a></nobr></th>";
				$Template->goToForum();
			echo"
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class=\"asHeader\">
		<table cellSpacing=\"0\" cellPadding=\"0\">
			<tr>
				<td class=\"asC1 asCenter\" width=\"100%\">{$editorTitle}</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class=\"asBody\">
		<script type=\"text/javascript\" src=\"js/dm/editor/editor-1.1.js".x."\"></script>
		<script type=\"text/javascript\" src=\"js/editor.js".x."\"></script>
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"6\">
		<form method=\"post\" action=\"setpost.php\" id=\"editorFrm\" name=\"editorFrm\">
		<input name=\"editor\" type=\"hidden\" value=\"rich\">
		<input name=\"type\" type=\"hidden\" value=\"".type."\">
		<input name=\"src\" type=\"hidden\" value=\"".urldecode(src)."\">
		<input name=\"redeclare\" type=\"hidden\" value=\"".rand."\">
		<input name=\"forumid\" type=\"hidden\" value=\"{$f}\">
		<input name=\"topicid\" type=\"hidden\" value=\"{$t}\">
		<input name=\"postid\" type=\"hidden\" value=\"".p."\">
		<input name=\"userid\" type=\"hidden\" value=\"{$u}\">
		<input name=\"pmfrom\" type=\"hidden\" value=\"{$pmfrom}\">
		<input name=\"pmto\" type=\"hidden\" value=\"{$pmto}\">
		<input name=\"pm\" type=\"hidden\" value=\"".pm."\">{$inputByType}";
if(type!='signature'){
	echo"
	<tr>
		<td class=\"asFixedB\" width=\"10%\"><nobr>العنوان</nobr></td>
		<td class=\"asNormalB\">";
		if(type=='newtopic'||type=='edittopic'||type=='sendpm'||type=='replypm'||type=='sendpmtousers'){
			echo"
			<input type=\"text\" class=\"input\" maxLength=\"100\" name=\"subject\" style=\"width:600px;\" value=\"$topicSubject\">";
		}
		elseif(type=='newpost'||type=='quotepost'||type=='editpost'){
			echo $topicSubject;
		}
		echo"
		</td>
	</tr>";
}
if(type == 'newtopic' && $isModerator){
	echo"
	<tr>
		<td class=\"asFixedB\"><nobr>خيارات الموضوع</nobr></td>
		<td class=\"asNormalB\">
			<input type=\"checkbox\" name=\"hidden\" value=\"1\">&nbsp;مخفي&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type=\"checkbox\" name=\"sticky\" value=\"1\">&nbsp;مثبت&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type=\"checkbox\" name=\"status\" value=\"0\">&nbsp;مقفل&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type=\"checkbox\" name=\"viewforusers\" value=\"1\">&nbsp;عرض موضوع فقط لأعضاء مسجلين&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>";
}
if(!empty($topicAuthor)){
	echo"
	<tr>
		<td class=\"asFixedB\"><nobr>كاتب الموضوع</nobr></td>
		<td class=\"asNormalB\">$topicAuthor</td>
	</tr>";
}
if(type=='sendpmtousers'){
	echo"
	<tr>
		<td class=\"asFixedB\"><nobr>اختيار مجموعة</nobr></td>
		<td class=\"asNormalB\">
			<input type=\"checkbox\" name=\"tousers\" value=\"1\">&nbsp;الأعضاء&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type=\"checkbox\" name=\"tomoderators\" value=\"1\">&nbsp;المشرفين&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type=\"checkbox\" name=\"tomonitors\" value=\"1\">&nbsp;المراقبين&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type=\"checkbox\" name=\"toadmins\" value=\"1\">&nbsp;المدراء
		</td>
	</tr>";
}
	echo"
	<tr>
		<td id=\"editorPlace\" class=\"asNormalB\" align=\"center\" colspan=\"2\">";
				$editorSizes=array(
					'topic'=>102400,
					'pm'=>25600,
					'signature'=>5120
				);
				function editorMaxSize(){
					global $editorSizes;
					$maxSize=0;
					if(type=='newtopic'||type=='edittopic'||type=='newpost'||type=='quotepost'||type=='editpost'||type=='sendpmtousers') $maxSize=$editorSizes['topic'];
					elseif(type=='sendpm'||type=='replypm') $maxSize=$editorSizes['pm'];
					elseif(type=='signature') $maxSize=$editorSizes['signature'];
					return $maxSize;
				}
					echo"
					<input style=\"display:none\" name=\"message\" type=\"hidden\" id=\"message\">
					<textarea id=\"editorOldContent\" style=\"display:none\">{$msgContent}</textarea>";
				$user_style = $Template->getUserStyle(true);
  				?>
				<script type="text/javascript">
				var type='<?=type?>',exitPage=false,maxSize=<?=intval(editorMaxSize())?>;
				DMEditor.run({
					setting:{
						width:'900',
						height:'400',
						previewText:'<?=forum_title?>',
						userCSS:{
							textAlign:'<?=$user_style['align']?>',
							fontWeight:'<?=$user_style['weight']?>',
							fontFamily:'<?=$user_style['family']?>',
							fontSize:'<?=$user_style['size']?>',
							color:'<?=$user_style['color']?>'
						}
					},
					use:{
						editorMode:<?=( ulv==4 ? 'true' : 'false' )?>
					}
				});
				DMEditor.setContent($('#editorOldContent').val());
				</script>
				<?php
				echo"
		</td>
	</tr>
	<tr>
		<td class=\"asNormalB\" align=\"center\" colspan=\"2\">
			{$Template->button("إدخال النص"," onClick=\"setContent(this.form)\"")}&nbsp;&nbsp;
			{$Template->button("إرجاع النص الأصلي"," onClick=\"chkReset('".self."')\"")}&nbsp;&nbsp;&nbsp;&nbsp;
			<nobr>";
			$maxSize = editorMaxSize();
			$textSize = strlen($msgContent);
			$color = ($textSize >= $maxSize && ulv < 4) ? 'red' : 'green';
			$specified = (ulv<4) ? round($maxSize / 1024, 2)." كيلو بايت" : "[غير محدد]";
			echo"حجم نص الحالي: <span id=\"sizeDetailsPlace\" style=\"color:{$color}\">".round($textSize / 1024, 2)." كيلو بايت</span> / حجم المخصص {$specified}
			</nobr>
		</td>
	</tr>
</form>
</table>
</td>
</tr>
</table>";
$Template->footer();
?>