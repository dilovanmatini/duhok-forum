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

const _df_script = "fpass";
const _df_filename = "fpass.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if( ulv > 0 ) $DF->quick();
$Template->header();

if(type == ''){
	?>
	<script type="text/javascript">
	DF.checkSubmit=function(frm){
		if(frm.username.value.length == 0){
			alert("يجب عليك أن تدخل إسم العضوية");
		}
		else{
			frm.submit();
		}
	};
	</script>
	<?php
	echo"
	<table width=\"50%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form method=\"post\" action=\"fpass.php?type=send\">
		<tr>
			<td class=\"asHeader\" colspan=\"2\"><nonr>إسترجاع كلمة السرية<nobr></td>
		</tr>
		<tr>
			<td class=\"asHiddenB asS12 asAS12 asAC5 asCenter\" colspan=\"2\">ملاحظة: يمكنك التحقق من إسم العضوية من <a href=\"users.php\">قائمة الأعضاء</a></td>
		</tr>
		<tr>
			<td class=\"asFixedB\">إسم العضوية</td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:400px\" name=\"username\"></td>
		</tr>
		
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"2\">{$Template->button("إسترجاع"," onClick=\"DF.checkSubmit(this.form)\"")}</td>
		</tr>
	</form>
	</table>";
}
elseif(type == 'send'){
	$username=$DF->cleanText($_POST['username']);
	$rs=$mysql->queryAssoc("SELECT u.id,u.level,uf.email
	FROM ".prefix."user AS u
	LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
	WHERE name = '{$username}' AND status = 1", __FILE__, __LINE__);
	if(isset($rs['id'])){
		if($rs['level'] == 1){
			$randCode=md5(time.rand.$rs['id']);
			$mysql->insert("fpass (userid,randcode,sendip,date) VALUES ({$rs['id']},'{$randCode}',".ip2.",".time.")", __FILE__, __LINE__);
			$subject="طلب إسترجاع الكلمة السرية";
			$message="هذه رسالة لك من :  ".forum_title."\n عضونا الكريم , لقد طلبت إسترجاع الكلمة السرية أو هنالك شخص أخر\nالرجاء الضغط على الرابط التالي لكي يتم إستكمال العملية\nhttp://".site_address."/fpass.php?type=confirm&code={$randCode}";
			if(mail($rs['email'],$subject,$message,"From: ".forum_title." <".forum_email.">")){
				$Template->msg("تم إرسال رسالة إلكترونية لبريدك الإلكتروني المسجل لدينا<br>يرجى تأكيد الطلب عبر الضغط على الرابط الذي ورد بها<br><span class=\"asC5\">ملاحظة : سيتم إلغاء الطلب اذا تجاوز مدة الـ 24 ساعة.</font>","index.php","انقر هنا للرجوع الى صفحة الرئيسية للمنتدى","",20);
			}
			else{
				$Template->errMsg("لم يتم إرسال الرسالة<br>لخلل في الشبكة او اسباب غير معروفة<br>نرجوا منك ان تعاد المحاولة<br>نأسف لهذا");
			}
		}
		else{
			$Template->errMsg("لا يمكن إسترجاع الكلمة السرية لعضويات الادارية او الاشرافية<br>اذا كنت مشرف او مراقب رجاءً اتصل بالإدارة ليرجع لك كلمة السرية عبر طريقها الخاص");
		}
	}
	else{
		$Template->errMsg("عفوا إسم العضوية المطلوب غير موجود بقائمة الأعضاء<br>للتثبت يرجى البحث عن إسم العضوية من <a href=\"users.php\">قائمة الأعضاء</a>");
	}
}
elseif(type == "confirm"&&strlen(code) == 32){
	$rs=$mysql->queryAssoc("SELECT fp.status,fp.userid,fp.date,uf.email
	FROM ".prefix."fpass AS fp
	LEFT JOIN ".prefix."userflag AS uf ON(uf.id = fp.userid)
	WHERE fp.randcode = '".code."'", __FILE__, __LINE__);
	if(isset($rs['userid'])){
		$expire=($rs['date']+86400);
		if(time>$expire){
			$Template->errMsg("عفوا ، لقد تجاوزت فترة الـ 24 ساعة و تم إلغاء الطلب ، الرجاء إرسال طلب جديد لإسترجاع الكلمة السرية");
		}
		elseif($rs['status'] == 1){
			$Template->errMsg("لقد قمت بالتحقق من الرابط ، ستجد كلمة سرية ارسلت لك عبر البريد الإلكتروني");
		}
		else{
			$code=substr(md5(time.rand.$rs['userid']),2,3);
			$randPass=substr(md5(rand.time.$rs['userid']),2,8);
			$password=md5("{$code}{$randPass}");
			$subject="كلمة سرية جديدة";
			$message="هذه رسالة لك من ".forum_title."\n الكلمة السرية الجديدة لك هي :\n{$randPass}\nيمنك تسجيل الدخول و تعديل الكلمة السرية من هذا الرابط\nhttp://".site_address."/profile.php?type=editpass";
			if(mail($rs['email'],$subject,$message,"From: ".forum_title." <".forum_email.">")){
				$mysql->update("user SET password = '{$password}', code = '{$code}' WHERE id = {$rs['userid']}", __FILE__, __LINE__);
				$mysql->update("fpass SET status = 1, confirmip = ".ip2.", confirmdate = ".time." WHERE randcode = '".code."'", __FILE__, __LINE__);
				$Template->errMsg("تم إرسال كلمة سرية جديدة إلى بريدك الإلكتروني",0,false);
				$Template->msg("تم إرسال كلمة سرية جديدة إلى بريدك الإلكتروني","index.php","انقر هنا للرجوع الى صفحة الرئيسية للمنتدى","",20);
			}
			else{
				$Template->errMsg("لم يتم إرسال الرسالة<br>لخلل في الشبكة او اسباب غير معروفة<br>نرجوا منك ان تعاد المحاولة<br>نأسف لهذا");
			}
		}
	}
	else{
		$Template->errMsg("عفوا الرابط الذي إتبعته غير صحيح");
	}
}
else{
	$DF->goTo();
}
$Template->footer();
?>