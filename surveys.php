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

if(_df_script == 'svc'&&this_svc == 'surveys'&&ulv > 1){
// ************ start page ****************

$secretType=array(
	0=>'غير سري',
	1=>'سري'
);

if(type == ''){
	$thisLink="svc.php?svc=surveys".(app == ''?'':'&app='.app)."&";
	$app=(app!=''?app:'all');
	if($app == 'open'){
		$appTitle="استفتاءات مفتوحة";
	}
	elseif($app == 'close'){
		$appTitle="استفتاءات مغلقة";
	}
	else{
		$appTitle="جميع استفتاءات";
	}
	
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asTopHeader asCenter\" colspan=\"11\">
	<ul class=\"svcbar asAS12\">
		<li class=\"selected\"><a href=\"svc.php?svc=surveys&type=add\"><em>أضف إستفتاء جديد</em></a></li>
	</ul>
	<ul class=\"svcbar asAS12\">
		<li".($app == 'open'?' class="selected"':'')."><a href=\"svc.php?svc=surveys&app=open\"><em>استفتاءات مفتوحة</em></a></li>
		<li".($app == 'close'?' class="selected"':'')."><a href=\"svc.php?svc=surveys&app=close\"><em>استفتاءات مغلقة</em></a></li>
		<li".($app == 'all'?' class="selected"':'')."><a href=\"svc.php?svc=surveys&app=all\"><em>جميع استفتاءات</em></a></li>
	</ul>
	</tr>
	<form method=\"post\" action=\"svc.php?svc=medals&type=appdistribute\">
	<input type='hidden' name='type'>
	<input type='hidden' name='app' value=\"$app\">
	<input type='hidden' name='redeclare' value=\"".rand."\">
		<tr>
			<td class=\"asHeader\" colspan=\"11\">$appTitle</td>
		</tr>
		<tr>
			<td class=\"asDarkB\"><nobr>السؤال</nobr></td>
			<td class=\"asDarkB\"><nobr>المنتدى</nobr></td>
			<td class=\"asDarkB\"><nobr>تاريخ الإبتداء</nobr></td>
			<td class=\"asDarkB\"><nobr>تاريخ القفل</nobr></td>
			<td class=\"asDarkB\"><nobr>السرية</nobr></td>
			<td class=\"asDarkB\"><nobr>مشاركات العضو<br>المطلوبة للتصويت</nobr></td>
			<td class=\"asDarkB\"><nobr>الأيام منذ تسجيل<br>العضو المطلوبة للتصويت</nobr></td>
			<td class=\"asDarkB\"><nobr>أضفت<br>بواسطة</nobr></td>
			<td class=\"asDarkB\">الخيارات</td>
		</tr>";
	$sql=$mysql->query("SELECT s.id,s.forumid,s.question,s.status,s.secret,s.days,s.posts,s.added,s.start,s.end,
		f.subject AS fsubject,
		u.name AS uname,u.status AS ustatus,u.level AS ulevel,u.submonitor AS usubmonitor
	FROM ".prefix."survey AS s
	LEFT JOIN ".prefix."forum AS f ON(f.id = s.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = s.added)
	LEFT JOIN ".prefix."moderator AS m ON(NOT ISNULL(f.id) AND m.forumid = f.id AND m.userid = ".uid.")
	LEFT JOIN ".prefix."category AS c ON(NOT ISNULL(f.id) AND c.id = f.catid)
	WHERE 1 = 1 ".checkSurveyGlobalSql()." GROUP BY s.id ORDER BY s.start DESC LIMIT {$DF->pgLimit(num_pages)},".num_pages, __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		$added = $Template->userColorLink($rs['added'], array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor']));
		$end=($rs['status'] ? "لم ينتهي" : $DF->date($rs['end'],'date',true));
		echo"
		<tr>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['question']}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</nobr></td>
			<td class=\"asNormalB asS12 asDate asCenter\"><nobr>{$DF->date($rs['start'],'date',true)}</nobr></td>
			<td class=\"asNormalB asS12 asDate asCenter\"><nobr>$end</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$secretType[$rs['secret']]}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['posts']}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['days']}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>$added</nobr></td>
			<td class=\"asNormalB asCenter\"><nobr>";
			if($rs['secret'] == 0){
				echo"
				<a href=\"svc.php?svc=surveys&type=secret&id={$rs['id']}\" {$DF->confirm('هل أنت متأكد بأن تريد تغير وضعية هذا الاستفتاء من غير سري الى سري ؟')}><img src=\"{$DFImage->i['hidden']}\" alt=\"جعل هذا الاستفتاء سري\" hspace=\"2\" border=\"0\"></a>";
			}
			else{
				echo"
				<a href=\"svc.php?svc=surveys&type=unsecret&id={$rs['id']}\" {$DF->confirm('هل أنت متأكد بأن تريد تغير وضعية هذا الاستفتاء من سري الى غير سري ؟')}><img src=\"{$DFImage->i['visible']}\" alt=\"جعل هذا الاستفتاء غير سري\" hspace=\"2\" border=\"0\"></a>";
			}
			if($rs['status'] == 1){
				echo"
				<a href=\"svc.php?svc=surveys&type=lock&id={$rs['id']}\" {$DF->confirm('هل أنت متأكد بأن تريد قفل هذا الاستفتاء ؟')}><img src=\"{$DFImage->i['lock']}\" alt=\"قفل استفتاء\" hspace=\"2\" border=\"0\"></a>";
			}
			else{
				echo"
				<a href=\"svc.php?svc=surveys&type=unlock&id={$rs['id']}\" {$DF->confirm('هل أنت متأكد بأن تريد فتح هذا الاستفتاء ؟')}><img src=\"{$DFImage->i['unlock']}\" alt=\"فتح استفتاء\" hspace=\"2\" border=\"0\"></a>";
			}
				echo"
				<a href=\"svc.php?svc=surveys&type=edit&id={$rs['id']}\"><img src=\"{$DFImage->i['edit']}\" alt=\"تعديل إستفتاء\" hspace=\"2\" border=\"0\"></a>
				<a href=\"svc.php?svc=surveys&type=options&id={$rs['id']}\"><img src=\"{$DFImage->i['question']}\" alt=\"معلومات حول التصويتات هذا الإستفتاء\" hspace=\"2\" border=\"0\"></a>
			</nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"11\"><br>-- لا توجد أيه إستفتاءات بهذه المواصفات --<br><br></td>
		</tr>";
	}
	echo"
	</form>
	</table>
	</center><br>";
}
elseif(type == 'add'){
	?>
	<script type="text/javascript">
	DF.checkSubmit=function(frm){
		var regex=/^[0-9]/;
		if(frm.question.value.length<10){
			confirm("يجب إدخال سؤال للإستفتاء وأن يكون أطول من 10 أحرف.");
			return;
		}
		else if(frm.forumid.options[frm.forumid.selectedIndex].value == 0){
			confirm("يجب عليك أن تختار منتدى من القائمة.");
			return;
		}
		else if(!regex.test(frm.days.value)){
			confirm("عدد الأيام يجب ان يكون بالأرقام فقط");
			return;
		}
		else if(!regex.test(frm.posts.value)){
			confirm("عدد المشاركات يجب ان يكون بالأرقام فقط");
			return;
		}
		frm.submit();
	};
	</script>
	<?php
	$allowforums=$DF->getAllowForumId(false,true);
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form method=\"post\" action=\"svc.php?svc=surveys&type=insert\">
	<input type=\"hidden\" name=\"redeclare\" value=\"".rand."\">
		<tr>
			<td class=\"asHeader\" colspan=\"3\"><nobr>إضافة إستفتاء جديد</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>سؤال الإستفتاء</nobr></td>
			<td class=\"asNormalB\" colspan=\"2\"><input type=\"text\" style=\"width:500px\" name=\"question\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>المنتدى</nobr></td>
			<td class=\"asNormalB\" colspan=\"2\">
			<select class=\"asGoTo\" name=\"forumid\">
				<option value=\"0\">&nbsp;&nbsp;-- اختر منتدى --</option>";
			foreach($allowforums as $key){
				echo"
				<option value=\"$key\">{$Template->forumsList[$key]}</option>";
			}
			echo"
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>أدنى عدد الأيام</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"3\"><input type=\"text\" style=\"width:40px\" value=\"0\" name=\"days\">&nbsp;&nbsp;&nbsp;عدد الأيام التي يجب ان يكون العضو قد مضاها منذ تسجيله في المنتدى حتى يتمكن من التصويت</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>أدنى عدد المشاركات</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"3\"><input type=\"text\" style=\"width:40px\" value=\"0\" name=\"posts\">&nbsp;&nbsp;&nbsp;عدد مشاركات العضو المطلوبة حتى يتمكن من التصويت</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>وضعية الإستفتاء</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"1\" name=\"status\" checked>مفتوح</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"0\" name=\"status\"><font class=\"small\">مقفول</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>سرية الإستفتاء</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"0\" name=\"secret\" checked>غير سري</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"1\" name=\"secret\">سري</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"3\">
				{$Template->button("أدخل التغييرات"," onClick=\"DF.checkSubmit(this.form)\"")}&nbsp;&nbsp;
				{$Template->button("إلغاء التغييرات"," onClick=\"this.form.reset();\"")}
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"3\"><nobr>خيارات التصويت</nobr></td>
		</tr>";
	for($x=1;$x<=30;$x++){
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>خيار رقم $x</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"2\">
				<input type=\"text\" style=\"width:500px\" name=\"value[]\"><br>
				<input type=\"text\" style=\"width:400px\" name=\"other[]\">&nbsp;&nbsp;(نص إضافي إو عنوان صورة)
			</td>
		</tr>";
	}
	echo"
	</form>
	</table><br>";
}
elseif(type == 'edit'){
	$rs=$mysql->queryAssoc("SELECT question,forumid,status,secret,days,posts FROM ".prefix."survey WHERE id = ".id."", __FILE__, __LINE__);
	$forums=$DF->getAllowForumId();
	if(ulv == 4||in_array($rs['forumid'],$forums)){
	//**********************************
	?>
	<script type="text/javascript">
	DF.checkSubmit=function(frm){
		var regex=/^[0-9]/;
		if(frm.question.value.length<10){
			confirm("يجب إدخال سؤال للإستفتاء وأن يكون أطول من 10 أحرف.");
			return;
		}
		else if(!regex.test(frm.days.value)){
			confirm("عدد الأيام يجب ان يكون بالأرقام فقط");
			return;
		}
		else if(!regex.test(frm.posts.value)){
			confirm("عدد المشاركات يجب ان يكون بالأرقام فقط");
			return;
		}
		var num=parseInt(frm.fieldNum.value);
		for(var x=1;x<=num;x++){
			var voteCount=eval("frm.voteCount"+x);
			var val=eval("frm.value"+x);
			if(typeof voteCount!="undefined"&&voteCount.value>0&&val.value == ""){
				confirm("لا يمكنك ان تفرغ خيارات التي تملك أكثر من صوت");
				return;
			}
		}
		frm.submit();
	};
	DF.addFields=function(frm){
		if(frm.fieldNum.value<30){
			var field=$I("#newFields"),fieldCode="<tr><td class=\"asFixedB\" width=\"20%\"><nobr>خيار رقم "+(parseInt(frm.fieldNum.value)+1)+"</nobr></td>"+
			"<td class=\"asNormalB asS12\" colspan=\"2\"><input type=\"text\" style=\"width:500px\" name=\"value[]\"><br><input type=\"text\" style=\"width:400px\" name=\"other[]\">&nbsp;&nbsp;(نص إضافي إو عنوان صورة)</td></tr>";
			field.innerHTML=field.innerHTML+"<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">"+fieldCode+"</table><!--delete-->";
			frm.fieldNum.value=parseInt(frm.fieldNum.value)+1;
		}
		else{
			alert("لا تستطيع أن تقوم بإظافة أكثر من 30 خيار لهذا الإستفتاء");
		}
	};
	DF.deleteFields=function(frm){
		var field=$I("#newFields"),arr=field.innerHTML.split("<!--delete-->"),newText="";
		for(var x=0;x<arr.length-2;x++){
			newText+=arr[x]+"<!--delete-->";
		}
		field.innerHTML=newText;
		if(arr.length>1){
			frm.fieldNum.value=parseInt(frm.fieldNum.value)-1;
		}
		return;
	};
	</script>
	<?php
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form method=\"post\" action=\"svc.php?svc=surveys&type=update\">
	<input type=\"hidden\" name=\"id\" value=\"".id."\">
	<input type=\"hidden\" name=\"oldStatus\" value=\"{$rs['status']}\">
		<tr>
			<td class=\"asHeader\" colspan=\"3\"><nobr>إضافة إستفتاء جديد</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>سؤال الإستفتاء</nobr></td>
			<td class=\"asNormalB\" colspan=\"2\"><input type=\"text\" style=\"width:500px\" name=\"question\" value=\"{$rs['question']}\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>المنتدى</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"2\">{$Template->forumsList[$rs['forumid']]}</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>أدنى عدد الأيام</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"3\"><input type=\"text\" style=\"width:40px\" name=\"days\" value=\"{$rs['days']}\">&nbsp;&nbsp;&nbsp;عدد الأيام التي يجب ان يكون العضو قد مضاها منذ تسجيله في المنتدى حتى يتمكن من التصويت</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>أدنى عدد المشاركات</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"3\"><input type=\"text\" style=\"width:40px\" name=\"posts\" value=\"{$rs['posts']}\">&nbsp;&nbsp;&nbsp;عدد مشاركات العضو المطلوبة حتى يتمكن من التصويت</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>وضعية الإستفتاء</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"1\" name=\"status\"{$DF->choose($rs['status'],1,'c')}>مفتوح</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"0\" name=\"status\"{$DF->choose($rs['status'],0,'c')}>مقفول</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>سرية الإستفتاء</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"0\" name=\"secret\"{$DF->choose($rs['secret'],0,'c')}>غير سري</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"1\" name=\"secret\"{$DF->choose($rs['secret'],1,'c')}>سري</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"3\">
				{$Template->button("أدخل التغييرات"," onClick=\"DF.checkSubmit(this.form)\"")}&nbsp;&nbsp;
				{$Template->button("إلغاء التغييرات"," onClick=\"this.form.reset();\"")}
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"3\"><nobr>خيارات التصويت</nobr></td>
		</tr>
		<tr>
			<td class=\"asHiddenB asS12 asCenter\" colspan=\"3\">ملاحظة: إذا تريد حذف أحد خيارات أساسية الأدناه اتركها فارغاً بس بشرط أن لن يملك أي صوت.</td>
		</tr>";
		$sql=$mysql->query("SELECT id,value,other FROM ".prefix."surveyoptions WHERE surveyid = '".id."' ORDER BY id ASC", __FILE__, __LINE__);
		$count=0;
		while($rs=$mysql->fetchAssoc($sql)){
			$voteCount=$DFOutput->count("surveyvotes WHERE surveyid = '".id."' AND optionid = '{$rs['id']}'");
			echo"
			<tr>
				<td class=\"asFixedB\"><nobr>خيار رقم ".($count+1)."</nobr></td>
				<td class=\"asNormalB asS12\" colspan=\"2\"><nobr>
					<input type=\"hidden\" name=\"voteCount".($count+1)."\" value=\"$voteCount\">
					<input type=\"text\" style=\"width:500px\" name=\"value".($count+1)."\" value=\"{$rs['value']}\">&nbsp;(هذا الخيار ".($voteCount>1 ? "يملك <font color=\"red\">$voteCount</font>  أصوات" : ($voteCount == 1 ? "يملك <font color=\"red\">$voteCount</font>  صوت" : "لا يملك أي صوت")).")</nobr><br><nobr>
					<input type=\"text\" style=\"width:400px\" name=\"other".($count+1)."\" value=\"{$rs['other']}\">&nbsp;(نص إضافي إو عنوان صورة)</nobr>
				</td>
			</tr>";
			$count++;
		}
		echo"
		<tr>
			<td class=\"asHeader\" colspan=\"3\"><nobr>إضافة خيارات جديدة لهذا الإستفتاء</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"3\">
				<input type=\"hidden\" name=\"fieldNum\" value=\"$count\">
				{$Template->button("أضف خانة"," onClick=\"DF.addFields(this.form)\"")}&nbsp;&nbsp;
				{$Template->button("حذف خانة"," onClick=\"DF.deleteFields(this.form)\"")}
			</td>
		</tr>
	</table>
	<div id=\"newFields\"></div></form><br>";
	//*****************************************
	}
	else{
		$DF->goTo();
	}
}
elseif(type == 'insert'){
	$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في اضافة استفتاء");
	function checkOptions($arr){
		$count=0;
		for($x=0;$x<count($arr);$x++){
			if($arr[$x]!=""){
				$count++;
			}
			if($count>=2){
				return true;
			}
		}
		return false;
	}
	$redeclare=$_POST['redeclare'];
	$forumid=(int)$_POST['forumid'];
	$question=$DF->cleanText($_POST['question']);
	$status=(int)$_POST['status'];
	$secret=(int)$_POST['secret'];
	$days=(int)$_POST['days'];
	$posts=(int)$_POST['posts'];
	$value=$_POST['value'];
	$other=$_POST['other'];
	$forums=$DF->getAllowForumId();
	if($redeclare!=checkredeclare){
		$Template->errMsg("كان هناك خلل أثناء تخزين العملية!<br>يبدو أنه تم محاولة إدخال البيانات عدة مرات لسبب فني أو لخلل في الشبكة.<br>الرجاء التأكد من أن العملية انتهت بنجاح... نأسف على هذا.");
	}
	if(ulv == 4||in_array($forumid,$forums)){
		if(!checkOptions($value)){
			$Template->errMsg("يجب إدخال على الأقل خيارين للإستفتاء.");
		}
		else{
			$mysql->insert("survey (forumid,question,status,secret,days,posts,added,start) VALUES
			('$forumid','$question','$status','$secret','$days','$posts','".uid."','".time."')", __FILE__, __LINE__);
			$rs=$mysql->queryRow("SELECT id FROM ".prefix."survey WHERE forumid = $forumid AND added = ".uid." AND start = '".time."'", __FILE__, __LINE__);
			for($x=0;$x<count($value);$x++){
				if($value[$x]!=""){
					$mysql->insert("surveyoptions (surveyid,value,other) VALUES ('$rs[0]','{$DF->cleanText($value[$x])}','{$DF->cleanText($other[$x])}')", __FILE__, __LINE__);
				}
			}
			$DFOutput->setModActivity('survey',$forumid,true);
			$Template->msg("تم إضافة إستفتاء بنجاح","svc.php?svc=surveys");
		}
	}
	else{
		$DF->goTo();
	}
}
elseif(type == 'update'){
	$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في تعديل استفتاء");
	$id=(int)$_POST['id'];
	$rs=$mysql->queryRow("SELECT forumid FROM ".prefix."survey WHERE id = $id", __FILE__, __LINE__);
	$forums=$DF->getAllowForumId();
	if(ulv == 4||in_array($rs[0],$forums)){
		function chkOptionsNum($value,$num){
			$y=0;
			for($x=0;$x<count($value);$x++){
				if($value[$x]!=""){
					$y++;
				}
			}
			for($x=1;$x<=$num;$x++){
				if($_POST["value".$x]!=""){
					$y++;
				}
			}
			return $y;
		}
		$question=$DF->cleanText($_POST["question"]);
		$days=(int)$_POST["days"];
		$posts=(int)$_POST["posts"];
		$status=(int)$_POST["status"];
		$oldStatus=(int)$_POST["oldStatus"];
		$secret=(int)$_POST["secret"];
		$value=$_POST["value"];
		$other=$_POST["other"];
		$sql=$mysql->query("SELECT id,value,other FROM ".prefix."surveyoptions WHERE surveyid = $id ORDER BY id ASC", __FILE__, __LINE__);
		$opCount=$mysql->numRows($sql);
		if(chkOptionsNum($value,$opCount)<2){
			$Template->errMsg("يجب إدخال على الأقل خيارين للإستفتاء.");
		}
		else{
			$x=0;
			while($rs=$mysql->fetchAssoc($sql)){
				$value1=$rs['value'];
				$other1=$rs['other'];
				$value2=$DF->cleanText($_POST["value".($x+1)]);
				$other2=$DF->cleanText($_POST["other".($x+1)]);
				if($value2 == ""){
					$mysql->delete("surveyoptions WHERE id = '{$rs['id']}'", __FILE__, __LINE__);
				}
				else{
					if($value2!=$value1||$other2!=$other1){
						$mysql->update("surveyoptions SET value = '$value2', other = '$other2' WHERE id = '{$rs['id']}'", __FILE__, __LINE__);
					}
				}
				$x++;
			}
			for($x=0;$x<count($value);$x++){
				if($value[$x]!=""){
					$mysql->insert("surveyoptions (surveyid,value,other) VALUES ('$id','$value[$x]','$other[$x]')", __FILE__, __LINE__);
				}
			}
			$mysql->update("survey SET
			question = '$question',
			days = '$days',
			posts = '$posts',
			status = '$status',
			{$DF->iff($status == 0&&$status!=$oldStatus,"end = '".time."',","")}
			secret = '$secret'
			WHERE id = $id", __FILE__, __LINE__);
			$Template->msg("تم تعديل الإستفتاء بنجاح","svc.php?svc=surveys");
		}
	}
	else{
		$DF->goTo();
	}
}
elseif(type == 'options'){
	$rs=$mysql->queryRow("SELECT forumid,question FROM ".prefix."survey WHERE id = ".id."", __FILE__, __LINE__);
	$forums=$DF->getAllowForumId();
	if(ulv == 4||in_array($rs[0],$forums)){
		function chkOptionsOther($other){
			if(strstr(strtolower($other),".gif")!=""||strstr(strtolower($other),".jpg")!=""){
				$text="<img src=\"$other\" border=\"0\">";
			}
			else{
				$text="<font color=\"gray\">$other</font>";
			}
			return $text;
		}
		echo"
		<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
			<tr>
				<td class=\"asHeader\" colspan=\"4\">$rs[1]</td>
			</tr>
			<tr>
				<td class=\"asDarkB\"><nobr>الرقم</nobr></td>
				<td class=\"asDarkB\"><nobr>الخيارات</nobr></td>
				<td class=\"asDarkB\"><nobr>عدد أصوات</nobr></td>
				<td class=\"asDarkB\"><nobr>خيارات</nobr></td>
			</tr>";
		$sql=$mysql->query("SELECT so.id,so.value,so.other,COUNT(sv.id) AS count
		FROM ".prefix."surveyoptions AS so
		LEFT JOIN ".prefix."surveyvotes AS sv ON(sv.optionid = so.id)
		WHERE so.surveyid = ".id." GROUP BY so.id ORDER BY so.id ASC", __FILE__, __LINE__);
		$count=0;
		while($rs=$mysql->fetchAssoc($sql)){
			echo"
			<tr>
				<td class=\"asNormalB asCenter\">".($count+1)."</td>
				<td class=\"asNormalB\">{$rs['value']}<br>".chkOptionsOther($rs['other'])."</td>
				<td class=\"asNormalB asCenter\">{$rs['count']}</td>
				<td class=\"asNormalB asCenter\"><a href=\"svc.php?svc=surveys&type=votes&id={$rs['id']}\"><img src=\"{$DFImage->i['question']}\" alt=\"تفاصيل تصويتات هذا الخيار\" border=\"0\"></a></td>
			</tr>";
			$count++;
		}
		if($count == 0){
			echo"
			<tr>
				<td class=\"asNormalB asCenter\" colspan=\"4\"><br>لا توجد أي خيارات لهذا الإستفتاء<br><br></td>
			</tr>";
		}
		echo"
		</table>
		</center>";
	}
	else{
		$DF->goTo();
	}
}
elseif(type == 'votes'){
	$rs=$mysql->queryRow("SELECT s.forumid,s.question,so.value
	FROM ".prefix."surveyoptions AS so
	LEFT JOIN ".prefix."survey AS s ON(s.id = so.surveyid)
	WHERE so.id = ".id." GROUP BY so.id", __FILE__, __LINE__);
	$forums=$DF->getAllowForumId();
	if(ulv == 4||in_array($rs[0],$forums)){
		echo"
		<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
			<tr>
				<td class=\"asHeader\" colspan=\"4\">$rs[1] - <span class=\"asC2\">$rs[2]</span></td>
			</tr>
			<tr>
				<td class=\"asDarkB\"><nobr>الرقم</nobr></td>
				<td class=\"asDarkB\"><nobr>العضو</nobr></td>
				<td class=\"asDarkB\"><nobr>تاريخ</nobr></td>
			</tr>";
		$sql=$mysql->query("SELECT sv.id,sv.userid,sv.date,u.name AS uname,u.status AS ustatus,u.level AS ulevel,u.submonitor AS usubmonitor
		FROM ".prefix."surveyvotes AS sv
		LEFT JOIN ".prefix."user AS u ON(u.id = sv.userid)
		WHERE sv.optionid = ".id." GROUP BY sv.id ORDER BY sv.id ASC", __FILE__, __LINE__);
		$count=0;
		while($rs=$mysql->fetchAssoc($sql)){
			$user = $Template->userColorLink($rs['userid'], array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor']));
			echo"
			<tr>
				<td class=\"asNormalB asCenter\">{$rs['id']}</td>
				<td class=\"asNormalB asCenter\">$user</td>
				<td class=\"asNormalB asDate asCenter\">{$DF->date($rs['date'],'',true)}</td>
			</tr>";
			$count++;
		}
		if($count == 0){
			echo"
			<tr>
				<td class=\"asNormalB asCenter\" colspan=\"4\"><br>لا توجد أي تصويتات على هذا الخيار<br><br></td>
			</tr>";
		}
		echo"
		</table>
		</center>";
	}
	else{
		$DF->goTo();
	}
}
elseif(type == 'secret'){
	$rs=$mysql->queryRow("SELECT forumid FROM ".prefix."survey WHERE id = ".id."", __FILE__, __LINE__);
	$forums=$DF->getAllowForumId();
	if(ulv == 4||in_array($rs[0],$forums)){
		$mysql->update("survey SET secret = 1 WHERE id = ".id."", __FILE__, __LINE__);
		$Template->msg("تم تغير وضعية استفتاء من غير سري الى سري");
	}
	else{
		$DF->goTo();
	}
}
elseif(type == 'unsecret'){
	$rs=$mysql->queryRow("SELECT forumid FROM ".prefix."survey WHERE id = ".id."", __FILE__, __LINE__);
	$forums=$DF->getAllowForumId();
	if(ulv == 4||in_array($rs[0],$forums)){
		$mysql->update("survey SET secret = 0 WHERE id = ".id."", __FILE__, __LINE__);
		$Template->msg("تم تغير وضعية استفتاء من سري الى غير سري");
	}
	else{
		$DF->goTo();
	}
}
elseif(type == 'lock'){
	$rs=$mysql->queryRow("SELECT forumid FROM ".prefix."survey WHERE id = ".id."", __FILE__, __LINE__);
	$forums=$DF->getAllowForumId();
	if(ulv == 4||in_array($rs[0],$forums)){
		$mysql->update("survey SET status = 0, end = '".time."' WHERE id = ".id."", __FILE__, __LINE__);
		$Template->msg("تم قفل استفتاء بنجاح");
	}
	else{
		$DF->goTo();
	}
}
elseif(type == 'unlock'){
	$rs=$mysql->queryRow("SELECT forumid FROM ".prefix."survey WHERE id = ".id."", __FILE__, __LINE__);
	$forums=$DF->getAllowForumId();
	if(ulv == 4||in_array($rs[0],$forums)){
		$mysql->update("survey SET status = 1, end = 0 WHERE id = ".id."", __FILE__, __LINE__);
		$Template->msg("تم فتح استفتاء بنجاح");
	}
	else{
		$DF->goTo();
	}
}
else{
	$DF->goTo();
}

// ************ end page ****************
}
else{
	header("HTTP/1.0 404 Not Found");
}
?>