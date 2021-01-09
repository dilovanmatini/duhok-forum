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

const _df_script = "setpost";
const _df_filename = "setpost.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if( ulv == 0 ){
	$DF->quick();
}
$Template->header();

/* if(!$DF->isOurSite()&&type!='sendpmtousers'){
	$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في محرر النصوص");
	$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
	exit();
} */

$editor = $DF->cleanText($_POST['editor']);
$type = $DF->cleanText($_POST['type']);
$redeclare = intval($_POST['redeclare']);
$forumid = intval($_POST['forumid']);
$topicid = intval($_POST['topicid']);
$postid = intval($_POST['postid']);
$userid = intval($_POST['userid']);
$pmfrom = intval($_POST['pmfrom']);
$pmto = intval($_POST['pmto']);
$pm = $DF->cleanText($_POST['pm']);
$src = $DF->cleanText($_POST['src']);
$subject = $DF->cleanText($_POST['subject']);
if($editor == 'quick'){
	$message2 = nl2br($DF->cleanText($_POST['message']));
}
else{
	if( ulv == 1 && ($type == 'sendpm' || $type == 'replypm') ){
		$message2 = $DF->checkHTML($_POST['message'], true);
	}
	else{
		$message2 = $DF->checkHTML($_POST['message']);
	}
}
$message2 = $DF->inlineText($message2);
$message = $Template->setUserStyle($message2);
$message2 = $DF->cleanCharacters($message2);
if( $type == 'newtopic' ){
	$error_title = "لا يمكنك إضافة موضوع";
	
	$sql_feilds = "";
	$sql_join = "";
	
	if(ulv < 4&&!$is_moderator){
		$sql_feilds="
			,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id),1,0) AS allowforum
			,ff.totaltopics,f.sex,uf.sex AS usex,COUNT(t.id) AS todaytopics,ff.moderatetopics
		";
		$sql_join="
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = '".uid."')
			LEFT JOIN ".prefix."forumflag AS ff ON(ff.id = f.id)
			LEFT JOIN ".prefix."userflag AS uf ON(uf.id = '".uid."')
			LEFT JOIN ".prefix."topic AS t ON(t.forumid = f.id AND t.author = '".uid."' AND t.date > '".(time-86400)."')
		";
	}
	else{
		$sql_feilds=",IF(ISNULL(f.id),0,1) AS allowforum";
	}
	
 	$sql=$mysql->query("SELECT f.status,f.subject,f.catid,IF(ISNULL(tt.id),0,1) AS isredeclare $sql_feilds
	FROM ".prefix."forum AS f
	LEFT JOIN ".prefix."topic AS tt ON(tt.forumid = f.id AND tt.author = '".uid."' AND tt.redeclare = '$redeclare')
	$sql_join
	WHERE f.id = '$forumid' GROUP BY f.id", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	$findError=true;
	if(!$rs||$rs['allowforum'] == 0){
		$errmsg="$error_title<br>قد يكون هناك عدة إسباب لهذا منها:<br><br><table><tr><td>* رقم المنتدى المطلوب غير صحيح. </td></tr><tr><td>* المنتدى المطلوب تم حذفه نهائياً. </td></tr><tr><td>* المنتدى المطلوب لا يسمح لك بالدخول اليه. </td></tr></table>";
	}
	elseif(ustopaddpost == 1){
		$errmsg="$error_title<br>بسبب لقد تم منعك من المشاركة في جميع منتديات.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif($DF->getMonStatus('forbidforum',$forumid) == 1){
		$errmsg="$error_title<br>بسبب لقد تم منعك من المشاركة في هذا المنتدى.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif($rs['isredeclare'] == 1){
		$errmsg="كان هناك خلل أثناء تخزين الموضوع!<br><br>يبدو أنه تم محاولة إدخال الموضوع عدة مرات لسبب فني أو لخلل في الشبكة.<br><br>الرجاء التأكد من أن الموضوع قد تم إدخاله بشكل صحيح في المنتدى... نأسف على هذا.";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['status'] == 0){
		$errtype="theforumislocked";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['sex']>0&&$rs['sex']!=$rs['usex']){
		$errtype="errorinforumsex{$rs['sex']}";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['todaytopics']>=$rs['totaltopics']){
		$errmsg="لا يمكنك المشاركة بأكثر من {$rs['totaltopics']} مواضيع في هذا المنتدى في فترة 24 ساعة.<br>الرجاء المحاولة بعد قليل.";
	}
	elseif(empty($subject)){
		$errmsg="يجب عليك كتابة عنوان الموضوع";
	}
	elseif(empty($message2)){
		$errmsg="يجب عليك كتابة محتوي الموضوع";
	}
	else{
		$findError=false;
	}
	
	if(!$findError){
		$setOtherField="";
		$setOtherValue="";
		if(upostsundermon == 1||$DF->getMonStatus('monforum',$forumid) == 1||ulv == 1&&new_user_under_moderate>uposts||ulv < 4&&!$is_moderator&&$rs['moderatetopics'] == 1){
			$setOtherField.=",moderate";
			$setOtherValue.=",1";
			$msg="تم إدخال الموضوع لكنه يحتاج لموافقة المشرف قبل ان يظهر في المنتدى.<br><br>شكرا على مشاركاتك.<br>";
		}
		else{
			$setOtherField.="";
			$setOtherValue.="";
			$msg="تم إضافة الموضوع بنجاح.<br><br>شكرا على مشاركاتك.<br>";
		}
		if(isset($_POST['status'])){
			$setOtherField.=",status";
			$setOtherValue.=",".((int)$_POST['status']);
		}
		if(isset($_POST['sticky'])){
			$setOtherField.=",sticky";
			$setOtherValue.=",".((int)$_POST['sticky']);
		}
		if(isset($_POST['hidden'])){
			$setOtherField.=",hidden";
			$setOtherValue.=",".((int)$_POST['hidden']);
		}
		if(isset($_POST['viewforusers'])){
			$setOtherField.=",viewforusers";
			$setOtherValue.=",".intval($_POST['viewforusers']);
		}
		$mysql->insert("topic (forumid,catid,redeclare,subject,author,lpdate,date $setOtherField) VALUES (
			'$forumid','{$rs['catid']}','$redeclare','$subject','".uid."','".time."','".time."' $setOtherValue
		)", __FILE__, __LINE__);
		
		$DFOutput->setModActivity('topic',$forumid,$is_moderator);
		$DFOutput->setUserActivity('topic',(int)$forumid);

		$sql=$mysql->query("SELECT id FROM ".prefix."topic WHERE redeclare = '$redeclare' AND date = '".time."'", __FILE__, __LINE__);
		$trs=$mysql->fetchRow($sql);
		$t=$trs[0];
		
		$mysql->insert("topicmessage (id,forumid,catid,message) VALUES (
			'$t','$forumid','{$rs['catid']}','$message'
		)", __FILE__, __LINE__);
		$mysql->update("userflag SET posts = posts + 1, lpdate = '".time."', lpid = '$t', lptype = 'topic' WHERE id = '".uid."'", __FILE__, __LINE__);
		$mysql->update("forum SET topics = topics + 1, lpauthor = '".uid."', lpdate = '".time."' WHERE id = '$forumid'", __FILE__, __LINE__);
		$otherLinks=array(
			"topics.php?t=$t","إضغط هنا للرجوع للموضوع",
			"forums.php?f=$forumid","إضغط هنا للرجوع للمنتدى"
		);
		$Template->msg($msg,$src,"",$otherLinks,5);
	}
}
elseif( $type == "edittopic" ){
	$error_title="لا يمكنك تغيير نص الموضوع";
	
	$sql_feilds="";
	$sql_join="";
	
	if(ulv < 4&&!$is_moderator){
		$sql_feilds="
			,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id),1,0) AS allowforum
			,IF(t.trash = 1 OR t.moderate > 0 OR t.author <> ".uid.",0,1) AS allowtopic
		";
		$sql_join="LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = '".uid."')";
	}
	else{
		$sql_feilds=",IF(ISNULL(f.id),0,1) AS allowforum,IF(ISNULL(t.id),0,1) AS allowtopic";
	}
	
 	$sql=$mysql->query("SELECT f.status AS fstatus,f.subject AS fsubject,t.status,t.subject,tm.message
		$sql_feilds
	FROM ".prefix."topic AS t
	LEFT JOIN ".prefix."topicmessage AS tm ON(tm.id = t.id)
	LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
	$sql_join
	WHERE t.id = '$topicid' GROUP BY t.id", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	
	$findError=true;
	if(!$rs||$rs['allowforum'] == 0||$rs['allowtopic'] == 0){
		$errmsg="$error_title<br>قد يكون هناك عدة إسباب لهذا منها:<br><br><table><tr><td>* رقم الموضوع المطلوب غير صحيح. </td></tr><tr><td>* الموضوع لم تتم الموافقة عليه للآن من قبل طاقم الإشراف. </td></tr><tr><td>* الموضوع تم تجميده أو حذفه أو إخفاؤه. </td></tr><tr><td>* المنتدى الذي فيه الموضوع لا يسمح لك بالدخول اليه. </td></tr></table>";
	}
	elseif(ustopaddpost == 1){
		$errmsg="$error_title<br>بسبب لقد تم منعك من المشاركة في جميع منتديات.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif($DF->getMonStatus('forbidforum',$forumid) == 1){
		$errmsg="$error_title<br>بسبب لقد تم منعك من المشاركة في هذا المنتدى.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['fstatus'] == 0){
		$errtype="theforumislocked";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['status'] == 0){
		$errmsg="$error_title<br>لأن الموضوع تم قفله بواسطة المشرف.";
	}
	elseif(empty($subject)){
		$errmsg="يجب عليك كتابة عنوان الموضوع";
	}
	elseif(empty($message2)){
		$errmsg="يجب عليك كتابة محتوي الموضوع";
	}
	else{
		$findError=false;
	}
	
	if(!$findError){
	$mysql->insert("topicedit (topicid,userid,message,subject,date) VALUES (
			'$topicid','".uid."','$message' , '$subject' , '".time."'
		)", __FILE__, __LINE__);
		
		$mysql->update("topic SET subject = '$subject', editby = '".uid."', editdate = '".time."', editnum = editnum + 1 WHERE id = '$topicid'", __FILE__, __LINE__);
		$mysql->update("topicmessage SET message = '$message' WHERE id = '$topicid'", __FILE__, __LINE__);
		$otherLinks=array(
			"topics.php?t=$topicid","إضغط هنا للرجوع للموضوع",
			"forums.php?f=$forumid","إضغط هنا للرجوع للمنتدى"
		);
		$Template->msg("تم تغيير الموضوع بنجاح.<br><br>شكرا على مشاركاتك.<br>",$src,"",$otherLinks,5);
	}
}
elseif( $type == "newpost" || $type == "quotepost" ){
	
	$error_title = "لا يمكنك الرد على هذا الموضوع";
	
	$sql_feilds = "";
	$sql_join = "";
	
	if( ulv < 4 && !$is_moderator ){
		$sql_feilds = "
			, IF( f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id), 1, 0 ) AS allowforum
			, IF( ISNULL(tu.id), 0, 1 ) AS allowtopic
			, ff.totalposts, COUNT(p.id) AS todayposts, f.sex, uf.sex AS usex, ff.moderateposts
		";
		$sql_join = "
			LEFT JOIN ".prefix."forumusers AS fu ON( fu.forumid = f.id AND fu.userid = ".uid." )
			LEFT JOIN ".prefix."topicusers AS tu ON( tu.topicid = t.id AND tu.userid = ".uid." )
			LEFT JOIN ".prefix."forumflag AS ff ON( ff.id = f.id )
			LEFT JOIN ".prefix."userflag AS uf ON( uf.id = ".uid." )
			LEFT JOIN ".prefix."post AS p ON( p.forumid = f.id AND p.author = ".uid." AND p.date > ".(time-86400)." )
		";
	}
	else{
		$sql_feilds = ", IF( ISNULL(f.id), 0, 1 ) AS allowforum";
	}
	
 	$sql=$mysql->query("SELECT f.catid,f.status AS fstatus,f.hidden AS fhidden,f.level AS flevel,t.status,t.author,t.trash,t.hidden,t.moderate,t.posts,t.date,t.allownotify,f.moderateurl,
		IF(ISNULL(pp.id),0,1) AS isredeclare $sql_feilds
	FROM ".prefix."topic AS t
	LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
	LEFT JOIN ".prefix."post AS pp ON(pp.forumid = f.id AND pp.author = ".uid." AND pp.redeclare = '$redeclare')
	$sql_join
	WHERE t.id = $topicid GROUP BY t.id", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	
	$findError=true;
	if(!$rs||$rs['allowforum'] == 0){
		$errmsg="$error_title<br>بسبب لا يسمح لك بإضافة ردود في هذا المنتدى";
	}
	elseif(ustopaddpost == 1){
		$errmsg="$error_title<br>بسبب لقد تم منعك من المشاركة في جميع منتديات.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif($DF->getMonStatus('forbidforum',$forumid) == 1){
		$errmsg="$error_title<br>بسبب لقد تم منعك من المشاركة في هذا المنتدى.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif($rs['isredeclare'] == 1){
		$errmsg="كان هناك خلل أثناء تخزين الرد!<br><br>يبدو أنه تم محاولة إدخال الرد عدة مرات لسبب فني أو لخلل في الشبكة.<br><br>الرجاء التأكد من أن الرد قد تم إدخاله بشكل صحيح في المنتدى... نأسف على هذا.";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['fstatus'] == 0){
		$errtype="theforumislocked";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['trash'] == 1){
		$errmsg="$error_title<br>لأن الموضوع تم حذفه بواسطة المشرف.";
	}
	elseif($rs['posts']>=topic_max_posts){
		$errmsg="لا يمكن إضافة ردود لهذا الموضوع لأنه تجاوز الحد الأقصى وهو (".topic_max_posts.") رد";
		if($rs['status'] == 1){
			$mysql->update("topic SET status = 0 WHERE id = '$topicid'", __FILE__, __LINE__);
		}
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['status'] == 0){
		$errmsg="$error_title<br>لأن الموضوع تم قفله بواسطة المشرف.";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['moderate'] == 1){
		$errmsg="$error_title<br>لأن الموضوع لم تتم الموافقة عليه للآن.<br><br>الرجاء المحاولة في وقت لاحق.";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['moderate'] == 2){
		$errmsg="$error_title<br>لأن الموضوع تم تجميده بواسطة المشرف.";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['hidden'] == 1&&$rs['allowtopic'] == 0){
		$errmsg="$error_title<br>لأن الموضوع تم إخفائه بواسطة المشرف.";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['sex']>0&&$rs['sex']!=$rs['usex']){
		$errtype="errorinforumsex{$rs['sex']}";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['todayposts']>=$rs['totalposts']){
		$errmsg="لا يمكنك المشاركة بأكثر من {$rs['totalposts']} رد في هذا المنتدى في فترة 24 ساعة.<br>الرجاء المحاولة بعد قليل.";
	}
	elseif(empty($message2)){
		$errmsg="يجب عليك كتابة محتوي المشاركة";
	}
	else{
		$findError=false;
	}
	
	if(!$findError){
		$setOtherField="";
		$setOtherValue="";
		if(upostsundermon == 1||$DF->getMonStatus('monforum',$forumid) == 1||ulv == 1&&new_user_under_moderate>uposts||ulv < 4&&!$is_moderator&&$rs['moderateposts'] == 1){
			$setOtherField=",moderate";
			$setOtherValue=",1";
			$msg="تم إدخال الرد لكنه يحتاج لموافقة المشرف قبل ان يظهر في المنتدى.<br><br>شكرا على مشاركاتك.<br>";
		}
		elseif($rs['moderateurl'] == 1&&!$is_moderator&&$DF->findUrl($message)){
			$msg="تم إدخال الرد لكنه يحتاج لموافقة المشرف قبل ان يظهر في المنتدى.<br>لأنه يحتوي على رابط<br><br>شكرا على مشاركاتك.<br>";
			$setOtherField=",moderate";
			$setOtherValue=",1";
		}
		else{
			$msg="تم إضافة الرد بنجاح.<br><br>شكرا على مشاركاتك.<br>";
		} 
	
		$mysql->insert("post (topicid,forumid,catid,redeclare,author,date $setOtherField) VALUES (
			$topicid,$forumid,{$rs['catid']},'$redeclare',".uid.",".time." $setOtherValue
		)", __FILE__, __LINE__);
		$sql=$mysql->query("SELECT id FROM ".prefix."post WHERE redeclare = '$redeclare' AND date = '".time."'", __FILE__, __LINE__);
		$prs=$mysql->fetchRow($sql);
		$p=$prs[0];
		$mysql->insert("postmessage (id,topicid,forumid,catid,message) VALUES (
			$p,$topicid,$forumid,{$rs['catid']},'$message'
		)", __FILE__, __LINE__);
		
		// set notification
		$allownotify = explode(",", $rs['allownotify']);
		if( in_array(-($rs['author']), $allownotify) ){
			$allownotify = $DF->arrayDeleteValue($allownotify, -($rs['author']));
		}
		else{
			$allownotify[] = $rs['author'];
		}
		foreach($allownotify as $val){
			$userid = intval($val);
			if($userid > 0 && $userid != uid){
				$DFOutput->setNotification('ret', $userid, $p, $topicid);
			}
		}

		$DFOutput->setModActivity('post',$forumid,$is_moderator);
		if($rs['author']!=uid) $DFOutput->setUserActivity('topicpost',(int)$forumid,(int)$rs['author']);
		$DFOutput->setUserActivity('post',(int)$forumid);
		
		$mysql->update("topic SET posts = posts + 1, lpauthor = ".uid.", lpdate = ".time." WHERE id = $topicid", __FILE__, __LINE__);
		$mysql->update("userflag SET posts = posts + 1, lpdate = ".time.", lpid = $p WHERE id = ".uid."", __FILE__, __LINE__);
		$mysql->update("forum SET posts = posts + 1, lpauthor = ".uid.", lpdate = ".time." WHERE id = $forumid", __FILE__, __LINE__);
		$otheroptions=trim($_POST['otheroptions']);
		$fid=(int)trim($_POST['definedForumList']);
		if($editor == 'quick'&&!empty($otheroptions)&&$is_moderator){
			$otheroptions=trim($_POST['otheroptions']);
			$options=array(
				'mo'=>array('field'=>'moderate','value'=>0,'type'=>'mo'),
				'ho'=>array('field'=>'moderate','value'=>2,'type'=>'mo'),
				'hd'=>array('field'=>'hidden','value'=>1,'type'=>'hd'),
				'vs'=>array('field'=>'hidden','value'=>0,'type'=>'hd'),
				'lk'=>array('field'=>'status','value'=>0,'type'=>'lk'),
				'op'=>array('field'=>'status','value'=>1,'type'=>'lk'),
				'st'=>array('field'=>'sticky','value'=>1,'type'=>'st'),
				'us'=>array('field'=>'sticky','value'=>0,'type'=>'st'),
				't0'=>array('field'=>'top','value'=>0,'type'=>''),
				't1'=>array('field'=>'top','value'=>1,'type'=>''),
				't2'=>array('field'=>'top','value'=>2,'type'=>''),
				'mv'=>array('field'=>'sticky','value'=>0,'type'=>'mv'),
				'dl'=>array('field'=>'trash','value'=>1,'type'=>'dl'),
				're'=>array('field'=>'trash','value'=>0,'type'=>'dl')
			);
			if( is_array( $oprs = $options[$otheroptions] ) && ( $otheroptions != 'dl' && $otheroptions != 're' || $is_monitor ) ){
				$mysql->update("topic SET {$oprs['field']} = '{$oprs['value']}' WHERE id = '$topicid'", __FILE__, __LINE__);
				$type = $otheroptions;
				if( $type == 'mo' ) $ntype = 'apt';
				elseif( $type == 'ho' ) $ntype = 'hot';
				elseif( $type == 'hd' ) $ntype = 'hit';
				elseif( $type == 'vs' ) $ntype = 'sht';
				elseif( $type == 'lk' ) $ntype = 'lot';
				elseif( $type == 'op' ) $ntype = 'opt';
				elseif( $type == 'st' ) $ntype = 'stt';
				elseif( $type == 'us' ) $ntype = 'ust';
				elseif( $type == 't1' ) $ntype = 'srt';
				elseif( $type == 't2' ) $ntype = 'met';
				elseif( $type == 'mv' ) $ntype = 'mot';
				else $ntype = '';
				if( !empty($ntype) ) $DFOutput->setNotification( $ntype, $rs['author'], 0, $topicid );
				if( $oprs['type'] != '' && $oprs['type'] != 'mv' || $fid > 0 && $fid != $forumid ){
					$operations = unserialize($mysql->get("topicmessage", "operations", $topicid));
					if( !is_array($operations) ) $operations = [];
					$operations[] = time."::{$oprs['type']}::{$oprs['value']}::".uid."::".uname;
					$mysql->update("topicmessage SET operations = '".serialize($operations)."' WHERE id = $topicid", __FILE__, __LINE__);
				}
				if( $otheroptions == 'mv' && $fid > 0 && $fid != $forumid ){
					$cid = $mysql->get( "forum", "catid", $fid );
					$mysql->update("post SET catid = $cid, forumid = $fid WHERE topicid = $topicid", __FILE__, __LINE__);
					$mysql->update("postmessage SET catid = $cid, forumid = $fid WHERE topicid = $topicid", __FILE__, __LINE__);
					$mysql->update("topic SET catid = $cid, forumid = $fid WHERE id = $topicid", __FILE__, __LINE__);
					$mysql->update("topicmessage SET catid = $cid, forumid = $fid WHERE id = $topicid", __FILE__, __LINE__);
					$mysql->update("topicusers SET catid = $cid, forumid = $fid WHERE topicid = $topicid", __FILE__, __LINE__);
					$mysql->update("forum SET topics = topics - 1, posts = posts - {$rs['posts']} WHERE id = $forumid", __FILE__, __LINE__);
					$mysql->update("forum SET topics = topics + 1, posts = posts + {$rs['posts']} WHERE id = $fid", __FILE__, __LINE__);
				}
			}
		}
	
		// End Users Account
		$otherLinks = array(
			"topics.php?t={$topicid}","إضغط هنا للرجوع للموضوع",
			"forums.php?f={$forumid}","إضغط هنا للرجوع للمنتدى"
		);
		$Template->msg( $msg, $src, "", $otherLinks, 5 );
	}
}
elseif($type == "editpost"){
	$error_title="لا يمكنك تغيير نص الرد";
	
	$sql_feilds="";
	$sql_join="";
	
	if(ulv < 4&&!$is_moderator){
		$sql_feilds="
			,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id),1,0) AS allowforum
			,IF(ISNULL(tu.id),0,1) AS allowtopic
			,IF(p.trash = 1 OR p.moderate > 0 OR p.author <> ".uid.",0,1) AS allowpost
		";
		$sql_join="
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")
			LEFT JOIN ".prefix."topicusers AS tu ON(tu.topicid = t.id AND tu.userid = ".uid.")
		";
	}
	else{
		$sql_feilds=",IF(ISNULL(f.id),0,1) AS allowforum";
	}
	
 	$sql=$mysql->query("SELECT f.status AS fstatus,t.status,t.trash,t.hidden,f.moderateurl,
		t.moderate,p.author AS pauthor $sql_feilds
	FROM ".prefix."post AS p
	LEFT JOIN ".prefix."topic AS t ON(t.id = p.topicid)
	LEFT JOIN ".prefix."forum AS f ON(f.id = p.forumid)
	$sql_join
	WHERE p.id = $postid GROUP BY p.id", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	
	$findError=true;
	if(!$rs||$rs['allowforum'] == 0){
		$errmsg="$error_title<br>بسبب لا يسمح لك بإضافة ردود في هذا المنتدى";
	}
	elseif(ustopaddpost == 1){
		$errmsg="$error_title<br>بسبب لقد تم منعك من المشاركة في جميع منتديات.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif($DF->getMonStatus('forbidforum',$forumid) == 1){
		$errmsg="$error_title<br>بسبب لقد تم منعك من المشاركة في هذا المنتدى.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['allowpost'] == 0){
		$errmsg="$error_title<br>بسبب لا عندك تصريح بتغيير نص هذا الرد";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['fstatus'] == 0){
		$errtype="theforumislocked";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['trash'] == 1){
		$errmsg="$error_title<br>لأن الموضوع تم حذفه بواسطة المشرف.";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['status'] == 0){
		$errmsg="$error_title<br>لأن الموضوع تم قفله بواسطة المشرف.";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['moderate'] == 1){
		$errmsg="$error_title<br>لأن الموضوع لم تتم الموافقة عليه للآن.<br><br>الرجاء المحاولة في وقت لاحق.";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['moderate'] == 2){
		$errmsg="$error_title<br>لأن الموضوع تم تجميده بواسطة المشرف.";
	}
	elseif(ulv < 4&&!$is_moderator&&$rs['hidden'] == 1&&$rs['allowtopic'] == 0){
		$errmsg="$error_title<br>لأن الموضوع تم إخفائه بواسطة المشرف.";
	}
	elseif(empty($message2)){
		$errmsg="يجب عليك كتابة محتوي المشاركة";
	}
	else{
		$findError=false;
	}
	
	if(!$findError){
		$setOtherField="";
		if($rs['moderateurl'] == 1&&!$is_moderator&&$DF->findUrl($message)){
			$msg="تم إدخال الرد لكنه يحتاج لموافقة المشرف قبل ان يظهر في المنتدى.<br>لأنه يحتوي على رابط<br><br>شكرا على مشاركاتك.<br>";
			$setOtherField=",moderate = 1";
		}
		else{
			$msg="تم تغيير الرد بنجاح.<br><br>شكرا على مشاركاتك.<br>";
		}
		$mysql->update("post SET editby = ".uid.", editdate = ".time.", editnum = editnum + 1 $setOtherField WHERE id = $postid", __FILE__, __LINE__);
		$mysql->update("postmessage SET message = '$message' WHERE id = $postid", __FILE__, __LINE__);
		$otherLinks=array(
			"topics.php?t=$topicid","إضغط هنا للرجوع للموضوع",
			"forums.php?f=$forumid","إضغط هنا للرجوع للمنتدى"
		);
		$Template->msg($msg,$src,"",$otherLinks,5);
	}
}
elseif($type == 'signature'){
	$u = ($userid > 0 && ulv > 2) ? $userid : uid;
	$findError = true;
	if($u == 0){
		$errmsg = "لم يتم تغيير التوقيع لخطأ في البيانات المدخلة أو خلل في النظام.";
	}
	elseif(uuneditsignature == 1){
		$errmsg = "تم منعك من تغير توقيعك من قبل الإدارة";
	}
	else{
		$findError = false;
	}
	if(!$findError){
		$mysql->update("userflag SET signature = '{$message}' WHERE id = {$u}", __FILE__, __LINE__);
		// start for signature details
		$userid_edit = ($userid > 0) ? $userid : uid;
		$other_message = "<center>
		<table cellpadding=\"4\" border=\"1\">
			<tr>
				<td>صاحب المحاولة</td>
				<td>{$Template->userColorLink(uid)}</td>
			</tr>
			<tr>
				<td>حاول تعديل توقيع عضوية</td>
				<td>{$Template->userColorLink($userid_edit)}</td>
			</tr>
			<tr>
				<td>رقم الاي بي لصاحب المحاولة</td>
				<td><a href=\"admincp.php?type=ip&method=ipchecking&id=".uip."\">".long2ip(uip)."</a></td>
			</tr>
		</table><br>-- نص التوقيع --</center><hr><br>";
		$topicid = 181007;
		$forumid = 56;
		$catid = 15;
		$mysql->insert("post (topicid, forumid, catid, redeclare, author, date) VALUES ({$topicid}, {$forumid}, {$catid}, ".rand.", 1036, ".time.")", __FILE__, __LINE__);
		$prs = $mysql->queryRow("SELECT id FROM ".prefix."post WHERE redeclare = ".rand." AND date = ".time."", __FILE__, __LINE__);
		$pid = intval($prs[0]);
		if($pid > 0){
			$mysql->insert("postmessage (id, topicid, forumid, catid, message) VALUES ({$pid}, {$topicid}, {$forumid}, {$catid}, '{$other_message}{$message}')", __FILE__, __LINE__);
			$mysql->update("topic SET posts = posts + 1, lpauthor = 1036, lpdate = ".time." WHERE id = {$topicid}", __FILE__, __LINE__);
			$mysql->update("forum SET posts = posts + 1 WHERE id = {$forumid}", __FILE__, __LINE__);
			$DFOutput->setNotification('ret', 1036, $pid, $topicid);
		}
		// end for signature details
		$Template->msg("تم تغيير التوقيع بنجاح.", $src);
	}
}
elseif($type == "sendpm"){
	$error_title = "لا يمكن إرسال رسالة";
	$u = abs($pmto);
	if($pmto < 0){
		$is_moderator2 = false;
		$is_monitor2 = false;
		if($u > 0){
			$show_tools2 = $DF->showTools($u);
			if($show_tools2 == 2){
				$is_moderator2 = true;
				$is_monitor2 = true;
			}
			elseif($show_tools2 == 1){
				$is_moderator2 = true;
			}
		}
	}
	
	$sql_feilds="";
	$sql_join="";
	$checkSqlWhere="";
	
	if($pmto > 0 && ulv > 1){
		$sql_feilds=",IF(u.id > 0,1,0) AS accept";
	}
	elseif($pmto > 0){
		$sql_feilds = ",IF(up.receivepm = 1,1,0) AS accept,IF(NOT ISNULL(b.id),1,0) AS block";
		$sql_join = "
			LEFT JOIN ".prefix."userperm AS up ON(up.id = u.id)
			LEFT JOIN ".prefix."blocks AS b ON(b.userid = u.id AND b.blockid = ".uid.")
		";
		$checkSqlWhere = "AND u.status = 1";
	}
	elseif($pmto < 0 && $is_moderator2){
		$sql_feilds=",IF(f.id = 0,0,1) AS accept";
	}
	elseif($pmto<0){
		$sql_feilds=",IF(ff.hidepm = 0 AND (f.hidden = 0 AND f.level <= '".ulv."' OR f.hidden = 1 AND fu.id > 0),1,0) AS accept";
		$sql_join="
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = '".uid."')
			LEFT JOIN ".prefix."forumflag AS ff ON(ff.id = f.id)
		";
	}
	
	if($pmto>0){
		$sql=$mysql->query("SELECT IF(pm.id>0,1,0) AS isredeclare $sql_feilds
		FROM ".prefix."user AS u
		LEFT JOIN ".prefix."pm AS pm ON(pm.redeclare = '$redeclare')
		$sql_join
		WHERE u.id = '$u' $checkSqlWhere GROUP BY u.id", __FILE__, __LINE__);
	}
	elseif($pmto<0){
		$sql=$mysql->query("SELECT IF(pm.id>0,1,0) AS isredeclare $sql_feilds
		FROM ".prefix."forum AS f
		LEFT JOIN ".prefix."pm AS pm ON(pm.redeclare = '$redeclare')
		$sql_join
		WHERE f.id = '$u' $checkSqlWhere GROUP BY f.id", __FILE__, __LINE__);
	}
	
	$rs=$mysql->fetchAssoc($sql);
	$findError=true;
	
	if($pmto>0){
		if(!$rs){
			$errmsg="$error_title<br>بسبب ان رقم العضوية الذي ترسل له رسالة هو خاطيء";
		}
		elseif(ustopsendpm == 1){
			$errmsg="$error_title<br>بسبب لقد تم منعك من إرسال رسائل خاصة.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
		}
		elseif($rs['accept'] == 0){
			$errmsg="لا يمكنك إرسال رسالة خاصة لهذا العضو لأنه لا يقبل إستلام الرسائل الخاصة";
		}
		elseif($rs['block'] == 1){
			$errmsg="لا يمكنك إرسال رسالة خاصة لهذا العضو<br>بسبب ان هذا العضو قمت بمنعك من مراسلته";
		}
		elseif($rs['isredeclare']){
			$errtype="errorinsendpm";
		}
		else{
			$findError=false;
		}
	}
	elseif($pmto<0){
		if(!$rs){
			$errmsg="$error_title<br>بسبب ان رقم المنتدى الذي ترسل لها رسالة هو خاطيء";
		}
		elseif(ustopsendpm == 1){
			$errmsg="$error_title<br>بسبب لقد تم منعك من إرسال رسائل خاصة.<br>تفاصيل السبب ستجدها في رسالة خاصة أرسلت لك بهذا الخصوص.";
		}
		elseif($rs['accept'] == 0){
			$errmsg="$error_title<br>بسبب لا عندك تصريح لإرسال رسالة لهذا المنتدى";
		}
		elseif($rs['isredeclare']){
			$errtype="errorinsendpm";
		}
		else{
			$findError=false;
		}
	}
	elseif(empty($message2)){
		$errmsg="يجب عليك كتابة محتوي الرسالة";
	}
	else{
		$errmsg="$error_title<br>بسبب هذه العضوية فقط يرسل رسائل إدارية والتنبيهات ولا يقبل رسائل";
	}
	
	if($pmfrom < 0 && ($is_moderator || $is_monitor)){
		$pmfrom = $pmfrom;
	}
	else{
		$pmfrom = uid;
	}

	if(!$findError){
		$mysql->insert("pm (author,sender,redeclare,pmfrom,pmto,pmread,pmout,subject,date) VALUES (
			'{$pmfrom}','".($pmfrom < 0 ? uid : 0)."','{$redeclare}','{$pmfrom}','{$pmto}','1','1','{$subject}','".time."'
		)", __FILE__, __LINE__);
		
		$sql=$mysql->query("SELECT id FROM ".prefix."pm WHERE author = '$pmfrom' AND redeclare = '{$redeclare}'", __FILE__, __LINE__);
		$rs=$mysql->fetchRow($sql);
		
		$mysql->insert("pmmessage (id,message) VALUES (
			'{$rs[0]}','{$message}'
		)", __FILE__, __LINE__);
		
		$mysql->insert("pm (author,sender,redeclare,pmfrom,pmto,subject,date) VALUES (
			'{$pmto}','".($pmfrom < 0 ? uid : 0)."','{$redeclare}','{$pmfrom}','{$pmto}','{$subject}','".time."'
		)", __FILE__, __LINE__);
		
		$sql=$mysql->query("SELECT id FROM ".prefix."pm WHERE author = '{$pmto}' AND redeclare = '{$redeclare}' AND pmout = 0", __FILE__, __LINE__);
		$rs=$mysql->fetchRow($sql);
		
		$mysql->insert("pmmessage (id,message) VALUES (
			'{$rs[0]}','{$message}'
		)", __FILE__, __LINE__);
		
		$Template->msg("تم إرسال رسالة بنجاح",$src,"اذهب الى الصفحة الاصلية","",5);
	}
}
elseif($type == "replypm"){
	$error_title="لا يمكنك الرد على الرسالة";
	$sql=$mysql->query("SELECT IF(pm.id>0,1,0) AS isredeclare FROM ".prefix."pm AS pm
	WHERE pm.author = '$pmfrom' AND pm.redeclare = '$redeclare' GROUP BY pm.id", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	$findError = true;
	
	if($rs['isredeclare']){
		$errtype="errorinsendpm";
	}
	elseif($pmto == 0){
		$errmsg="$error_title<br>بسبب هذه العضوية فقط يرسل رسائل إدارية والتنبيهات ولا يقبل رسائل";
	}
	elseif(empty($message2)){
		$errmsg="يجب عليك كتابة محتوي الرسالة";
	}
	else{
		$findError=false;
	}
	
	if($pmfrom < 0 && ($is_moderator || $is_monitor)){
		$pmfrom = $pmfrom;
	}
	else{
		$pmfrom = uid;
	}

	if(!$findError){
		$mysql->insert("pm (author,sender,redeclare,pmfrom,pmto,pmread,pmout,reply,subject,date) VALUES (
			'$pmfrom','".($pmfrom<0?uid:0)."','$redeclare','$pmfrom','$pmto','1','1','1','$subject','".time."'
		)", __FILE__, __LINE__);
		if($pmfrom<0){
			$DFOutput->setModActivity('pm',abs($pmfrom),true);
		}
		
		$sql=$mysql->query("SELECT id FROM ".prefix."pm WHERE author = '$pmfrom' AND redeclare = '$redeclare'", __FILE__, __LINE__);
		$rs=$mysql->fetchRow($sql);
		
		$mysql->insert("pmmessage (id,message) VALUES (
			'$rs[0]','$message'
		)", __FILE__, __LINE__);
		
		$mysql->insert("pm (author,sender,redeclare,pmfrom,pmto,reply,subject,date) VALUES (
			'$pmto','".($pmfrom<0?uid:0)."','$redeclare','$pmfrom','$pmto','1','$subject','".time."'
		)", __FILE__, __LINE__);
		
		$sql=$mysql->query("SELECT id FROM ".prefix."pm WHERE author = '$pmto' AND redeclare = '$redeclare' AND pmout = 0", __FILE__, __LINE__);
		$rs=$mysql->fetchRow($sql);
		
		$mysql->insert("pmmessage (id,message) VALUES (
			'$rs[0]','$message'
		)", __FILE__, __LINE__);
		
		$Template->msg("تم رد على الرسالة بنجاح",$src,"اذهب الى الصفحة الاصلية","",5);
	}
}
elseif($type == 'sendpmtousers'&&ulv == 4){
	$error_title="لا يمكنك إرسال رسالة جماعية";
	$findError=true;
	$length=50;
	$tousers=(int)$_POST['tousers'];
	$tomoderators=(int)$_POST['tomoderators'];
	$tomonitors=(int)$_POST['tomonitors'];
	$toadmins=(int)$_POST['toadmins'];
	if($tousers == 0&&$tomoderators == 0&&$tomonitors == 0&&$toadmins == 0){
		$errmsg="لا يمكنك إرسال رسالة جماعية<br>بسبب ان انت لم اخترت أي مجموعة ليتم إرسال الرسالة اليهم";
	}
	elseif(empty($subject)){
		$errmsg="يجب عليك كتابة عنوان الرسالة";
	}
	elseif(empty($message2)){
		$errmsg="يجب عليك كتابة محتوي الرسالة";
	}
	else{
		$findError=false;
	}

	if(!$findError){
		$tousersstatus=array();
		if($tousers == 1) $tousersstatus[]=1;
		if($tomoderators == 1) $tousersstatus[]=2;
		if($tomonitors == 1) $tousersstatus[]=3;
		if($toadmins == 1) $tousersstatus[]=4;
		$levels=implode(",",$tousersstatus);
		$count=$DFOutput->count("user WHERE status = 1 AND level IN ({$levels})");
		echo"<br>
		<table class=\"grid\" width=\"60%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
			<tr>
				<td class=\"asHeader\">جاري إرسال رسالة</td>
			</tr>
			<tr>
				<td class=\"asNormalB\" align=\"center\"><br><br>
				<table cellspacing=\"4\" cellpadding=\"0\" align=\"center\" border=\"0\">
					<tr>
						<td><nobr>حالة إرسال</nobr></td>
						<td width=\"300\" style=\"border:gray 1px solid\"><nobr><img id=\"perDark\" src=\"styles/".choosed_style."/survey.png\" width=\"0\" height=\"16\" border=\"0\"><img id=\"perLight\" src=\"{$DFImage->i['survey_light']}\" width=\"300\" height=\"16\" border=\"0\"></nobr></td>
						<td width=\"40\" id=\"per100\"><nobr>0%</nobr></td>
					</tr>
				</table>
				<div id=\"messageBar\"><br>انتظر ليتم إتمام العملية<br><img src=\"images/icons/loading2.gif\" border=\"0\"><div><br>
				</td>
			</tr>
		</table><br>
		<form id=\"sendGroupMessage\" method=\"post\" action=\"\" target=\"groupMessagePlace\" style=\"display:none\">
			<input type=\"hidden\" name=\"type\" value=\"sendGroupMessage\">
			<input type=\"hidden\" name=\"page\" value=\"1\">
			<input type=\"hidden\" name=\"length\" value=\"{$length}\">
			<input type=\"hidden\" name=\"levels\" value=\"{$levels}\">
			<input type=\"hidden\" name=\"subject\" value=\"{$subject}\">
			<textarea style=\"display:none\" name=\"message\">{$message}</textarea>
			<iframe id=\"groupMessagePlace\" name=\"groupMessagePlace\" style=\"display:none\"></iframe>
		</form>";
		?>
		<script type="text/javascript">
		var count=<?=$count?>,length=<?=$length?>;
		DF.doSendGroupMessage=function(pg,stop){
			var frm=$I('#sendGroupMessage'),per100=$I('#per100'),perDark=$I('#perDark'),perLight=$I('#perLight'),messageBar=$I('#messageBar');
			if(!stop){
				var limit=(count/length);
				var perBar=Math.ceil((300/limit)*pg);
				var percent=Math.ceil((100/limit)*pg);
				perDark.style.width=(perBar>300 ? 300 : perBar)+"px";
				perLight.style.width=((300-perBar)<0 ? 0 : (300-perBar))+"px";
				per100.innerHTML="<nobr>"+(percent>100 ? 100 : percent)+"%</nobr>";
				frm.page.value=pg;
				frm.action="ajax_admin.php";
				frm.submit();
			}
			else{
				perDark.style.width="300px";
				perLight.style.width="0px";
				per100.innerHTML="<nobr>100%</nobr>";
				messageBar.innerHTML="<br>تم إرسال رسالة جماعية بنجاح<br><br><a href=\"<?=$src?>\">-- انقر هنا للرجوع --</a><br><br>";
			}
		};
		DF.doSendGroupMessage(1,false);
		</script>
		<?php
	}
}
else{
	$DF->goTo();
}

if(!empty($errmsg)){
	$Template->errMsg($errmsg);
	exit();
}
elseif(!empty($errtype)){
	$errors=array();
	$errors['errorinforumid']="$error_title<br>بسبب ان رقم المنتدى هو خاطيء<br>مرجوا عدم استخدام روابط يدوياً";
	$errors['errorintopicid']="$error_title<br>بسبب ان رقم الموضوع هو خاطيء<br>مرجوا عدم استخدام روابط يدوياً";
	$errors['errorinpostid']="$error_title<br>بسبب ان رقم الرد هو خاطيء<br>مرجوا عدم استخدام روابط يدوياً";
	$errors['errorinsendpm']="كان هناك خلل أثناء تخزين الرسالة!<br><br>يبدو أنه تم محاولة إدخال الرسالة عدة مرات لسبب فني أو لخلل في الشبكة.<br><br>الرجاء التأكد من أن الرسالة قد تم إرسالها بشكل صحيح في ملف البريد الصادر ... نأسف على هذا.";
	$errors['thecatislocked']="$error_title<br>بسبب ان هذه الفئة هي مقفولة";
	$errors['theforumislocked']="$error_title<br>لأن المنتدى مقفول بواسطة الإدارة.";
	$errors['thetopicislocked']="$error_title<br>لأن الموضوع تم قفله بواسطة المشرف.";
	$errors['errorinforumsex1']="لا يمكنك المشاركة في هذا المنتدى لأنه مخصص لمشاركة الذكور فقط.";
	$errors['errorinforumsex2']="لا يمكنك المشاركة في هذا المنتدى لأنه مخصص لمشاركة الإناث فقط.";
	$Template->errMsg($errors["{$errtype}"]);
	exit();
}

$Template->footer();
?>