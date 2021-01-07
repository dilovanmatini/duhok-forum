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

const _df_script = "sendtopic";
const _df_filename = "sendtopic.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
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

$rs=$mysql->queryRow("SELECT t.subject,u.name AS aname,t.author,t.date,tm.message
FROM ".prefix."topic AS t
LEFT JOIN ".prefix."topicmessage AS tm ON(tm.id = t.id)
LEFT JOIN ".prefix."user AS u ON(u.id = t.author)
LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid) $checkSqlTable
WHERE t.id = '".t."' $checkSqlWhere GROUP BY t.id", __FILE__, __LINE__);

if(!$rs){
	$DF->goTo();
}

if(type==''){
	?>
	<script type="text/javascript">
	DF.checkSubmit=function(frm){
		if(frm.friendemail.value.length==0){
			alert("يجب عليك ان تكتب عنوان بريد الالكتروني");
		}
		else if(!this.checkEmail(frm.friendemail.value)){
			alert("عنوان بريد الالكتروني الذي دخلت هو خاطيء");
		}
		else{
			frm.submit()
		}
	};
	</script>
	<?php
	echo"
	<table width=\"50%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form method=\"post\" action=\"sendtopic.php?type=send&t=".t."\">
		<tr>
			<td class=\"asHeader\" colspan=\"2\"><nonr>$rs[0]<nobr></td>
		</tr>
		<tr>
			<td class=\"asHiddenB asS12 asCenter\" colspan=\"2\">لإخبار صديق لك عن الموضوع أدخل بريده الإلكتروني وثم إضغط على الزر أدناه</td>
		</tr>
		<tr>
			<td class=\"asFixedB\">بريد الالكتروني</td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:500px\" name=\"friendemail\" dir=\"ltr\"></td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"2\">{$Template->button("ارسل الموضوع"," onClick=\"DF.checkSubmit(this.form)\"")}</td>
		</tr>
	</form>
	</table>";
}
elseif(type=='send'){
	$friendemail=$_POST['friendemail'];
	$subject="رسالة من ".forum_title."";
	$message = "هذه رسالة لك من : ".uname."\nوهو عضو في ".forum_title." ويود ان يلفت انتابهك الى موضوع قد يثير اهتمامك على الوصلة التالية:\nhttp://".site_address."/topics.php?t=".t;
	if(mail($friendemail,$subject,$message,"From: ".forum_title." <".forum_email.">")){
		$DFOutput->setUserActivity('topicsend',$DF->catch['_this_forum'],(int)$mysql->get("topic","author",t));
		$Template->msg("تم إرسال بريد الكتروني الى صديقك حسب العنوان الذي ادخلته.","topics.php?t=".t);
	}
	else{
		$Template->errMsg("لم يتم إرسال الرسالة<br>لخلل في الشبكة او اسباب غير معروفة<br>نأسف لهذا");
	}
}

//************************** End Page *****************************
$Template->footer();
?>