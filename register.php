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

const _df_script = "register";
const _df_filename = "register.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
if(ulv != 0){
	$DF->goTo();
}
if(register_status == 0){
	$Template->errMsg("تم إيقاف تسجيل عضويات جديدة من قبل إدارة<br>سيتم فتح تسجيل قريباً");
}
if(type == ''){
	echo"
	<table width=\"80%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
		<tr>
			<td class=\"asHeader\">شروط الاستخدام&nbsp;".forum_title."</td>
		</tr>
		<tr>
			<td class=\"asNormalB asS12 asAC5 asCenter\">";
			if( forum_logo != '' ){
				echo"
				<img src=\"".forum_logo."\" alt=\"".forum_title."\" width=\"70\" border=\"0\" style=\"margin: 10px;\">";
			}
			echo"
			<br>اذا توافق على شروط الاستخدام المذكورة أدناه اضغط على &quot;موافق&quot; خلاف ذلك اضغط على &quot;غير موافق&quot;.<br><br>
			<table width=\"80%\" cellspacing=\"3\" cellPadding=\"4\">
				<tr>
					<td vAlign=\"top\">&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"{$DFImage->i['star_blue']}\" border=0>&nbsp;&nbsp;</td>
					<td width=\"100%\" align=\"right\">التسجيل في المنتديات مجاني وفقط نريد أنت تلزم قوانين المنتدى.</td>
				</tr>
				<tr>
					<td vAlign=\"top\">&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"{$DFImage->i['star_blue']}\" border=0>&nbsp;&nbsp;</td>
					<td width=\"100%\" align=\"right\">اذا ترغب بالمشاركة في هذه المنتديات يجب عليك اختيار اسم لتعريف نفسك بالاضافة الى كلمة سرية خاصة بك وأن يكون لديك عنوان بريد الكتروني خاص بك.</td>
				</tr>
				<tr>
					<td vAlign=\"top\">&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"{$DFImage->i['star_blue']}\" border=0>&nbsp;&nbsp;</td>
					<td width=\"100%\" align=\"right\">الموقع ومدير الموقع ومشرفو الموقع غير مسئولون عن أية معلومات توفرها وأية مشاركات تقوم بها.</li></td>
				</tr>
				<tr>
					<td vAlign=\"top\">&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"{$DFImage->i['star_blue']}\" border=0>&nbsp;&nbsp;</td>
					<td width=\"100%\" align=\"right\">أي مشاركات تقوم بها في هذه المنتديات تصبح معلومات عامة فنرجو منك عدم الادلاء بأية معلومات سرية أو خاصة بك في مشاركاتك.</li></td>
				</tr>
				<tr>
					<td vAlign=\"top\">&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"{$DFImage->i['star_blue']}\" border=0>&nbsp;&nbsp;</td>
					<td width=\"100%\" align=\"right\">هذه المنتديات قد تحتوي على وصلات الى مواقع أخرى ومشاركات من أفراد والموقع غير مسئول عن محتويات المشاركات والوصلات. اذا وجدت أي مشاركة أو وصلة تحتوي على كلام بذيء أو غير مقبول الرجاء اخبارنا فورا وسنقوم بحذف هذه المشاركات من المنتدى حالا.</li></td>
				</tr>
				<tr>
					<td vAlign=\"top\">&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"{$DFImage->i['star_blue']}\" border=0>&nbsp;&nbsp;</td>
					<td width=\"100%\" align=\"right\">شروط المشاركات في المنتديات تشمل جميع الشروط التي في الصفحة التالية والتي قد يتم تغييرها من وقت لآخر:</li><a href=\"rules.php\">&nbsp;<nobr>- شروط المشاركة -</nobr></a></td>
				</tr>
				<tr>
					<td vAlign=\"top\">&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"{$DFImage->i['star_blue']}\" border=0>&nbsp;&nbsp;</td>
					<td width=\"100%\" align=\"right\">هذه المنتديات تستخدم ميزة في متصحفك لتخزين آخر زيارة لك واسمك والكلمة السرية. هذه المعلومات تخزن في جهازك فقط. يجب أن تكون هذه الميزة مشغلة في متصفحك اذا أردت أن تشارك في المناقشات. يمكنك تمحية جميع المعلومات المخزنة بهذه الطريقة في أي وقت بالضغط على زر &quot;أخرج&quot; في أي صفحة.</li></td>
				</tr>
				<tr>
					<td vAlign=\"top\">&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"{$DFImage->i['star_blue']}\" border=0>&nbsp;&nbsp;</td>
					<td width=\"100%\" align=\"right\">اذا توافق على الشروط أعلاه اضغط على &quot;موافق&quot; ادناه. أنت كذلك توافق الا تدخل أية مواد محمية بحقوق نشر في مشاركاتك الا بسماح من مالكها وكذلك تقر أنك أكبر من 12 سنة وأنك لن تقوم بادخال أي نص يحتوي على كلام جنسي أو يشجع على الحقد والكراهية أو يسيء لأي شخص آخر أو يتنافي مع أية قوانين.</li></td>
				</tr>
				<tr>
					<td vAlign=\"top\">&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"{$DFImage->i['star_blue']}\" border=0>&nbsp;&nbsp;</td>
					<td width=\"100%\" align=\"right\">لمدير الموقع ومشرفوه الحق في إزالة أي مشاركة أو طرد أي عضو بدون سابق إنذار.</li></td>
				</tr>
			</table>
			<br>اذا كان لديك أي استفسار الرجاء ارسال بريد الكتروني الى :<a href=\"mailto:".forum_email."\">".forum_email."</a><br><br>
			{$Template->button("موافق"," onClick=\"document.location='register.php?type=details';\"")}&nbsp;&nbsp;
			{$Template->button("غير موافق"," onClick=\"document.location='index.php';\"")}
			<br>&nbsp;
			</td>
		</tr>
	</table><br>";
}
elseif(type == 'details'){
	echo"
	<script type=\"text/javascript\" src=\"js/register.js".x."\"></script>
	<table width=\"55%\" cellSpacing=\"0\" cellPadding=\"4\" align=\"center\">
	<form method=\"post\" action=\"register.php?type=doregister\">
	<input name=\"redeclare\" type=\"hidden\" value=\"".md5(ip2.time.ip2)."\">
		<tr>
			<td class=\"asHeader\">تسجيل عضوية جديدة خاصة بك</td>
		</tr>
		<tr>
			<td class=\"asNormal\" style=\"padding:15px\">
			<fieldset class=\"gray\" width=\"98%\">
			<legend>&nbsp;بيانات العضوية (يجب عليك ان تملئها)&nbsp;</legend><br>
			<table id=\"basicTable\" cellpadding=\"1\" cellspacing=\"1\" border=\"0\">
				<tr>
					<td colspan=\"2\">الإسم الذي يعرفك في المنتديات:&nbsp;&nbsp;<a href=\"javascript:DF.checkInfo('basicTable','userName');\" title=\"تعليمات حول اسم العضوية\"><img src=\"{$DFImage->i['info']}\" border=\"0\"></a></td>
				</tr>
				<tr id=\"userNameRow\">
					<td>{$Template->input( 300, array( 'name' => 'regUserName', 'onblur' => 'DF.checkUserName(this)', 'tabindex' => 1 ) )}</td>
					<td id=\"userNameMsg\"></td>
				</tr>
				<tr>
					<td colspan=\"2\">الكلمة السرية:&nbsp;&nbsp;<a href=\"javascript:DF.checkInfo('basicTable','userPass1');\" title=\"تعليمات حول كلمة السرية\"><img src=\"{$DFImage->i['info']}\" border=\"0\"></a></td>
				</tr>
				<tr id=\"userPass1Row\">
					<td>{$Template->input(300,array('type'=>'password','name'=>'regUserPass1','onblur'=>'DF.checkUserPass1(this)', 'tabindex' => 2 ))}</td>
					<td id=\"userPass1Msg\"></td>
				</tr>
				<tr>
					<td colspan=\"2\">إعادة الكلمة السرية للتأكيد:&nbsp;&nbsp;<a href=\"javascript:DF.checkInfo('basicTable','userPass2');\" title=\"تعليمات حول إعادة الكلمة السرية للتأكيد\"><img src=\"{$DFImage->i['info']}\" border=\"0\"></a></td>
				</tr>
				<tr id=\"userPass2Row\">
					<td>{$Template->input(300,array('type'=>'password','name'=>'regUserPass2','onblur'=>'DF.checkUserPass2(this)', 'tabindex' => 3 ))}</td>
					<td id=\"userPass2Msg\"></td>
				</tr>
				<tr>
					<td colspan=\"2\">البريد الإلكتروني:&nbsp;&nbsp;<a href=\"javascript:DF.checkInfo('basicTable','userEmail');\" title=\"تعليمات حول بريد الالكتروني\"><img src=\"{$DFImage->i['info']}\" border=\"0\"></a></td>
				</tr>
				<tr id=\"userEmailRow\">
					<td>{$Template->input(300,array('name'=>'regUserEmail','dir'=>'ltr','onblur'=>'DF.checkUserEmail(this)', 'tabindex' => 4 ))}</td>
					<td id=\"userEmailMsg\"></td>
				</tr>
			</table>
			</fieldset><br>
			<fieldset class=\"gray\" width=\"98%\">
			<legend>&nbsp;بيانات الشخصية (يجب عليك ان تختارها)&nbsp;</legend><br>
			<table id=\"basicTable\" cellpadding=\"1\" cellspacing=\"1\" border=\"0\">
				<tr>
					<td colspan=\"2\">الدولة:</td>
				</tr>
				<tr id=\"userCountryRow\">
					<td>
						<select class=\"white regUserCountry\" style=\"width:202px\" name=\"regUserCountry\" tabindex=\"5\" onchange=\"\$I('#userCountryMsg').innerHTML='';\">
							<option value=\"\">-- اختر دولة --</option>";
						require_once _df_path."countries.php";
						foreach($country as $code=>$val){
							$countries["{$code}"]=$val['name'];
							echo"
							<option value=\"{$code}\">{$val['name']}</option>";
						}
						echo"
						</select>
					</td>
					<td id=\"userCountryMsg\"></td>
				</tr>
				<tr>
					<td colspan=\"2\">تاريخ الولادة:</td>
				</tr>
				<tr id=\"userBrithDayRow\">
					<td>
					<select class=\"white\" style=\"width:50px\" name=\"regUserBrithDayDay\" tabindex=\"6\" onchange=\"\$I('#userBrithDayMsg').innerHTML='';\">
						<option value=\"\">--</option>";
					for( $x = 1; $x <= 31; $x++ ){
						echo"
						<option value=\"$x\">$x</option>";
					}
					echo"
					</select>&nbsp;
					<select class=\"white\" style=\"width:50px\" name=\"regUserBrithDayMonth\" tabindex=\"7\" onchange=\"\$I('#userBrithDayMsg').innerHTML='';\">
						<option value=\"\">--</option>";
					for( $x = 1; $x <= 12; $x++ ){
						echo"
						<option value=\"$x\">$x</option>";
					}
					echo"
					</select>&nbsp;
					<select class=\"white\" style=\"width:85px\" name=\"regUserBrithDayYear\" tabindex=\"8\" onchange=\"\$I('#userBrithDayMsg').innerHTML='';\">
						<option value=\"\">----</option>";
					$first_year =_this_year - 100;
					$last_year = _this_year - 12;
					for( $x = $last_year; $x >= $first_year; $x-- ){
						echo"
						<option value=\"$x\">$x</option>";
					}
					echo"
					</select>
					</td>
					<td id=\"userBrithDayMsg\"></td>
				</tr>
				<tr>
					<td colspan=\"2\">الجنس:</td>
				</tr>
				<tr id=\"userSexRow\">
					<td>&nbsp;&nbsp;&nbsp;
						<input type=\"radio\" class=\"none regUserSex\" value=\"1\" name=\"regUserSex\" tabindex=\"9\" onclick=\"\$I('#userSexMsg').innerHTML='';\">ذكر&nbsp;&nbsp;&nbsp;
						<input type=\"radio\" class=\"none regUserSex\" value=\"2\" name=\"regUserSex\" tabindex=\"9\" onclick=\"\$I('#userSexMsg').innerHTML='';\">أنثى
					</td>
					<td id=\"userSexMsg\"></td>
				</tr>
			</table>
			</fieldset><br>
			<fieldset class=\"gray\" width=\"98%\">
			<legend>&nbsp;بيانات آخرى&nbsp;</legend><br>
			<table id=\"basicTable\" cellpadding=\"1\" cellspacing=\"1\" border=\"0\">
				<tr>
					<td>المدينة:</td>
				</tr>
				<tr>
					<td>{$Template->input(200,array('name'=>'regUserCity', 'tabindex' => 10))}</td>
				</tr>
				<tr>
					<td>المنطقة:</td>
				</tr>
				<tr>
					<td>{$Template->input(200,array('name'=>'regUserState', 'tabindex' => 11))}</td>
				</tr>
				<tr>
					<td>إستقبال رسائل خاصة:</td>
				</tr>
				<tr>
					<td><input type=\"checkbox\" class=\"none\" name=\"receivePM\" tabindex=\"12\" value=\"1\" checked> بإختيار هذا المربع ستستقبل رسائل خاصة من قبل أعضاء.</td>
				</tr>
				<tr>
					<td>إستقبال رسائل بريد الالكتروني:</td>
				</tr>
				<tr>
					<td><input type=\"checkbox\" class=\"none\" name=\"receiveEmail\" tabindex=\"13\" value=\"1\"> بإختيار هذا المربع ستستقبل رسائل بريد الالكتروني من قبل أعضاء.</td>
				</tr>
			</table>
			</fieldset><br>
			<div align=\"center\">{$Template->button("أرسل طلب التسجيل"," onClick=\"DF.doRegister(this.form)\" tabindex=\"14\"")}</div>
			</td>
		</tr>
	</form>
	</table><br><br>";
}
elseif(type == 'doregister'){
	$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في تسجيل العضوية");
	$keyCode=$DF->cleanText($_POST['redeclare']);
	$userName=$DF->cleanText($_POST['regUserName']);
	$userPass1=$DF->cleanText($_POST['regUserPass1']);
	$userPass2=$DF->cleanText($_POST['regUserPass2']);
	$userEmail=$DF->cleanText($_POST['regUserEmail']);
	$userCity=$DF->cleanText($_POST['regUserCity']);
	$userState=$DF->cleanText($_POST['regUserState']);
	$userCountry=$DF->cleanText($_POST['regUserCountry']);
	$regUserBrithDayDay=(int)$_POST['regUserBrithDayDay'];
	$regUserBrithDayMonth=(int)$_POST['regUserBrithDayMonth'];
	$regUserBrithDayYear=(int)$_POST['regUserBrithDayYear'];
	$brithDay="{$regUserBrithDayYear}-{$DF->fullNumber($regUserBrithDayMonth)}-{$DF->fullNumber($regUserBrithDayDay)}";
	$userSex=(int)$_POST['regUserSex'];
	$receivePM=(int)$_POST['receivePM'];
	$receiveEmail=(int)$_POST['receiveEmail'];
	
	$code=substr($keyCode,5,3);
	$activeCode=substr($keyCode,8,8);
	$password=md5($code.$userPass1);
	
	$findUserName=(int)$mysql->get("user","id",$userName,"name");
	$findUserEmail=(int)$mysql->get("userflag","id",$userEmail,"email");
	$findUserKeys=(int)$mysql->get("user","id",$keyCode,"keycode");
	//Clean all Characters
	$userNameClean=$DF->cleanCharacters($userName);
	$userEmailClean=$DF->cleanCharacters($userEmail);
	//Check Bad Words
	$findBadWords = $DF->findBadWords( $userName, unserialize(blocked_names) );
	
	$Y=(int)date("Y",time);
	$fY=$Y-100;
	$lY=$Y-12;
	
	if(empty($userNameClean)){
		$Template->errMsg("يجب عليك أن تكتب اسم العضوية.");
	}
	elseif(strlen($userNameClean)<3){
		$Template->errMsg("يجب أن يكون الإسم مكون من 3 أحرف على الأقل.");
	}
	elseif(strlen($userName)>30){
		$Template->errMsg("يجب أن يكون الإسم لا أكثر من 30 حرفاً.");
	}
	elseif($findBadWords!=1){
		$Template->errMsg("لا يمكن استخدام هذا الرمز أو الاسم $findBadWords في اسم العضوية.");
	}
	elseif($findUserName>0){
		$Template->errMsg("اسم الذي اخترت هو مستخدم من قبل عضو آخر<br>يجب عليك ان تختار اسم آخر.");
	}
	elseif(empty($userPass1)){
		$Template->errMsg("يجب عليك ان تكتب كلمة السرية.");
	}
	elseif(strlen($userPass1)<6){
		$Template->errMsg("لا يمكنك كتابة كلمة السرية اقل من 6 حروف.");
	}
	elseif(strlen($userPass1)>24){
		$Template->errMsg("لا يمكنك كتابة كلمة السرية اكثر من 24 حرف.");
	}
	elseif(empty($userPass2)){
		$Template->errMsg("يجب عليك ان تكتب تأكيد كلمة السرية.");
	}
	elseif($userPass1!=$userPass2){
		$Template->errMsg("كلمة السرية للتأكد غير مطابق لكلمة السرية الجديدة.");
	}
	elseif(empty($userEmail)){
		$Template->errMsg("يجب عليك ان تكتب عنوان بريد الالكتروني.");
	}
	elseif(!preg_match("/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/",$userEmail)){
		$Template->errMsg("عنوان بريد الالكتروني الذي دخلت هو خاطيء.");
	}
	elseif($findUserEmail>0){
		$Template->errMsg("بريد الالكتروني الذي اخترت هو مستخدم من قبل عضو آخر<br>يجب عليك ان تكتب بريد الكتروني آخر.");
	}
	elseif($regUserBrithDayYear<=$fY||$regUserBrithDayYear>$lY){
		$Template->errMsg("نرجوا أن تختار تاريخ ولادتك الصحيحة.");
	}
	elseif($userSex == 0){
		$Template->errMsg("يجب ان تختار الجنس");
	}
	elseif($findUserKeys>0){
		$Template->errMsg("كان هناك خلل أثناء تسجيل العضوية!<br><br>يبدو أنه تم محاولة إدخال تسجيل العضوية عدة مرات لسبب فني أو لخلل في الشبكة.<br><br>الرجاء التأكد من أن العضوية تم تسجيلها بشكل صحيح في المنتدى... نأسف على هذا.");
	}
	else{
		$userActive=(register_status == 2 ? 0 : 1);
		$mysql->insert("user (status,active,name,entername,password,keycode,code,date) VALUES (
			2,
			$userActive,
			'$userName',
			'$userName',
			'$password',
			'$keyCode',
			'$code',
			".time."
		)", __FILE__, __LINE__);
		$rs=$mysql->queryRow("SELECT id FROM ".prefix."user WHERE date = ".time." AND keycode = '$keyCode'", __FILE__, __LINE__);
		$uid=(int)$rs[0];
		$mysql->insert("userperm (id,receivepm,receiveemail) VALUES ($uid,$receivePM,$receiveEmail)", __FILE__, __LINE__);
		$mysql->insert("userflag (id,email,sex,brithday,country,state,city,ip) VALUES (
			$uid,
			'$userEmail',
			$userSex,
			'$brithDay',
			'$userCountry',
			'$userState',
			'$userCity',
			'".ip2."'
		)", __FILE__, __LINE__);
		if(register_status == 2){
			$subject="طلب تفعيل العضوية في ".forum_title;
			$activeUrl="http://".site_address."/register.php?type=active&u=$uid&code=$activeCode";
			$message="مرحباً بك $userName
			شكراً لتسجيلك في ".forum_title."
			
			-------------------------------------------------
			لاستكمال تسجيلك, اضغط على الرابط أدناه:
			<a href=\"$activeUrl\">$activeUrl</a>
			-------------------------------------------------
			
			مع أطيب امنيات إدارة ".forum_title;
			$DF->sendMail($userEmail,$subject,$message);
			$Template->msg("تم تسجيل عضويتك<br>يجب عليك الذهاب الى البريد الالكتروني الذي سجلت عندنا لتفعيل العضوية<br>شكراً لتسجيلك في ".forum_title,'index.php','','',120);
		}
		else{
			$subject="تم تسجيل عضوية في ".forum_title;
			$message="مرحباً بك $userName
			شكراً لتسجيلك في ".forum_title."
			
			مع أطيب امنيات إدارة ".forum_title;
			$DF->sendMail($userEmail,$subject,$message);
			$Template->msg("تم تسجيل عضويتك بنجاح<br>لكن بحاجة الى موافقة الإدارة, وسيتم الموافقة عليها خلال 24 ساعة أو أقل<br>شكراً لتسجيلك في ".forum_title,'index.php','','',120);
		}
	}
}
elseif(type == 'active'){
	$keyCode=$mysql->get("user","keycode",u);
	$activeCode=substr($keyCode,8,8);
	if(u>0&&code!=''&&code == $activeCode){
		$Template->msgBox("تم تفعيل عضويتك بنجاح, لكن بحاجة الى موافقة الإدارة, وسيتم الموافقة عليها خلال 24 ساعة أو أقل.",'green',10,0,true,false);
		$mysql->update("user SET active = 1 WHERE id = ".u."", __FILE__, __LINE__);
	}
	else{
		$Template->msgBox("لم يتم تفعيل العضوية, من المحتمل ان المشكلة موجود في رابط التفعيل, نرجوا منك ان تنقر الرابط مباشرتاً من بريد الالكتروني.",'red',10,0,true,false);
	}
}
else{
	$DF->goTo();
}
$Template->footer();
?>