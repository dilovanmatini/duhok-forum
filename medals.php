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

if(_df_script == 'svc'&&this_svc == 'medals'&&ulv > 1){
// ************ start page ****************

if(type == 'distribute'){
	$thisLink="svc.php?svc=medals&type=distribute".(app == ''?'':'&app='.app).(scope == ''?'':'&scope='.scope).(days == 0?'':'&days='.days)."&";
	?>
	<script type="text/javascript">
	var link="<?=$thisLink?>";
	DF.medalCmd=function(s,type){
		var frm=s.form,el=frm.elements,msg=new Array();
		for(x=0,y=0;x<el.length;x++){
			if(el[x].type == 'checkbox'&&el[x].checked){
				y++;
			}
		}
		if(y == 0){
			alert("يجب عليك ان تختار على الأقل وسام واحد");
		}
		else{
			msg['app']="موافقة على الأوسمة المختارة";
			msg['ref']="رفض أوسمة المختارة";
			if(confirm("هل أنت متأكد بأن تريد "+msg[type]+" وعددها: "+y)){
				frm.type.value=type;
				frm.submit();
			}
		}
	};
	DF.chooseForumId=function(s,app,days){
		fid=s.options[s.selectedIndex].value;
		if(fid == 0) url="svc.php?svc=medals&type=distribute&app="+app+"&scope=mod&days="+days;
		else url="svc.php?svc=medals&type=distribute&app="+app+"&scope=forum&days="+days+"&f="+fid;
		document.location=url;
	};
	</script>
	<?php
	$app=(app!=''?app:'ok');
	$scope=(scope!=''?scope:'mod');
	$days=(days!=0?days:30);
	$furl=(f>0?"&f=".f:"");
	if($app == 'wait'){
		$appTitle="أوسمة تنتظر الموافقة";
	}
	elseif($app == 'ok'){
		$appTitle="أوسمة تمت الموافقة عليها";
	}
	elseif($app == 'ref'){
		$appTitle="أوسمة تم رفضها";
	}
	else{
		$appTitle="جميع الأوسمة";
	}
	
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asTopHeader asCenter\" colspan=\"11\">
	<ul class=\"svcbar asAS12\">
		<li><em class=\"".($scope == 'forum'?'selectedone':'one')."\">
		<select class=\"asGoTo\" style=\"width:160px\" onChange=\"DF.chooseForumId(this,'$app',$days)\">
			<option value=\"0\">&nbsp;&nbsp;&nbsp;-- عرض أوسمة منتدى --</option>";
		foreach($Template->forumsList as $key=>$val){
			echo"
			<option value=\"$key\"{$DF->choose(f,$key,'s')}>$val</option>";
		}
		echo"
		</select>
		</em></li>
		<li".($scope == 'mod'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=distribute&scope=mod&app=$app&days=$days\"><em>المنتديات التي تشرف عليها</em></a></li>
		<li".($scope == 'own'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=distribute&scope=own&app=$app&days=$days\"><em>الأوسمة التي منحتها أنت</em></a></li>
		<li".($scope == 'all'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=distribute&scope=all&app=$app&days=$days\"><em>جميع الأوسمة</em></a></li>
	</ul>
	<ul class=\"svcbar asAS12\">
		<li".($app == 'wait'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=distribute&scope=$scope&app=wait&days=$days$furl\"><em>أوسمة تنتظر الموافقة</em></a></li>
		<li".($app == 'ok'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=distribute&scope=$scope&app=ok&days=$days$furl\"><em>أوسمة تمت الموافقة عليها</em></a></li>
		<li".($app == 'ref'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=distribute&scope=$scope&app=ref&days=$days$furl\"><em>أوسمة تم رفضها</em></a></li>
		<li".($app == 'all'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=distribute&scope=$scope&app=all&days=$days$furl\"><em>جميع الأوسمة</em></a></li>
	</ul>
	<ul class=\"svcbar asAS12\">
		<li".($days == 30?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=distribute&scope=$scope&app=$app&days=30$furl\"><em>آخر 30 يوم</em></a></li>
		<li".($days == 60?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=distribute&scope=$scope&app=$app&days=60$furl\"><em>آخر 60 يوم</em></a></li>
		<li".($days == 180?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=distribute&scope=$scope&app=$app&days=180$furl\"><em>آخر 6 أشهر</em></a></li>
		<li".($days == 365?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=distribute&scope=$scope&app=$app&days=365$furl\"><em>آخر سنة</em></a></li>
		<li".($days == -1?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=distribute&scope=$scope&app=$app&days=-1$furl\"><em>جميع الأوسمة</em></a></li>
	</ul>
	</tr>
	<form method=\"post\" action=\"svc.php?svc=medals&type=appdistribute\">
	<input type='hidden' name='type'>
	<input type='hidden' name='app' value=\"$app\">
	<input type='hidden' name='redeclare' value=\"".rand."\">
		<tr>
			<td class=\"asHeader\" colspan=\"11\">أوسمة التميز - <span class=\"asC2\">$appTitle</span></td>
		</tr>";
if(u>0){
	$sql=$mysql->query("SELECT name FROM ".prefix."user WHERE id = '".u."' AND status IN (0,1)", __FILE__, __LINE__);
	$urs=$mysql->fetchRow($sql);
	if($urs){
		echo"
		<tr>
			<td class=\"asHiddenB asS12 asAS12 asAC5 asCenter\" colspan=\"11\">تعرض حاليا أوسمة عضو معين فقط: <a href=\"profile.php?u=".u."\">$urs[0]</a></td>
		</tr>";
	}
}
	if(m>0){
		echo"
		<tr>
			<td class=\"asHiddenB asS12 asCenter\" colspan=\"11\">تعرض حاليا وسام معين فقط: <span class=\"asC5\">الرقم الوسام: ".m."</span></td>
		</tr>";
	}
		echo"
		<tr>";
		if(ulv > 2){
			echo"
			<td class=\"asDarkB\"><nobr>&nbsp;</nobr></td>";
		}
			echo"
			<td class=\"asDarkB\"><nobr>العضو</nobr></td>
			<td class=\"asDarkB\"><nobr>التاريخ</nobr></td>
			<td class=\"asDarkB\"><nobr>يعرض حتى</nobr></td>
			<td class=\"asDarkB\"><nobr>الشعار الممنوح</nobr></td>
			<td class=\"asDarkB\"><nobr>&nbsp;</nobr></td>
			<td class=\"asDarkB\"><nobr>النقاط</nobr></td>
			<td class=\"asDarkB\"><nobr>الموافقة</nobr></td>
			<td class=\"asDarkB\"><nobr>المنتدى</nobr></td>
			<td class=\"asDarkB\"><nobr>منح الشعار</nobr></td>
			<td class=\"asDarkB\">&nbsp;</td>
		</tr>";
		
	$checkSqlField="";
	$checkSqlTable="";
	if(ulv < 4){
		$checkSqlField=",IF(ISNULL(mm.id),0,1) AS ismod";
		$checkSqlTable="LEFT JOIN ".prefix."moderator AS mm ON(mm.forumid = ml.forumid AND mm.userid = '".uid."')";
		if(ulv == 3){
			$checkSqlField.=",IF(ISNULL(c.id),0,1) AS ismon";
			$checkSqlTable.="LEFT JOIN ".prefix."category AS c ON(c.id = f.catid AND c.monitor = '".uid."')";
		}
	}
	else{
		$checkSqlField="
			,IF(ISNULL(m.id),0,1) AS ismod
			,IF(ISNULL(m.id),0,1) AS ismon
		";
	}
	
	$pgLimit=$DF->pgLimit(num_pages);
 	$sql=$mysql->query("SELECT m.id,m.listid,m.userid,m.status,m.added,m.date,ml.forumid,ml.subject,ml.days,ml.points,
		ml.filename,f.subject AS fsubject,u.name AS uname,u.status AS ustatus,u.level AS ulevel,u.submonitor AS usubmonitor,
		uu.name AS aname,uu.status AS astatus,uu.level AS alevel,uu.submonitor AS asubmonitor {$checkSqlField}
	FROM ".prefix."medal AS m
	LEFT JOIN ".prefix."medallists AS ml ON(ml.id = m.listid)
	LEFT JOIN ".prefix."forum AS f ON(f.id = ml.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = m.userid)
	LEFT JOIN ".prefix."user AS uu ON(uu.id = m.added) {$checkSqlTable}
	WHERE ml.id > 0 ".checkMedalDistributeSql()." GROUP BY m.id ORDER BY m.date DESC LIMIT {$pgLimit},".num_pages, __FILE__, __LINE__);
	$count=0;
	$checkCount=0;
	while($rs=$mysql->fetchAssoc($sql)){
		if($rs['ismod'] == 1||$rs['ismon'] == 1){
			$options="<a href=\"svc.php?svc=medals&type=distribute&app=all&scope=all&days=-1&m={$rs['listid']}\"><img src=\"{$DFImage->i['question']}\" alt=\"استعمال الوسام\" hspace=\"3\" border=\"0\"></a>";
		}
		else{
			$options=" - ";
		}
		
		if($rs['ismon'] == 1&&$app!='all'){
			$checkBox="<input onClick=\"DF.checkRowClass(this,{$rs['id']});\" type=\"checkbox\" class=\"none\" name=\"medals[]\" value=\"{$rs['id']}|{$rs['points']}|{$rs['userid']}|{$rs['forumid']}\">";
			$checkCount++;
		}
		else{
			$checkBox=" - ";
		}
		
		$user = $Template->userColorLink($rs['userid'], array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor']));
		$added = $Template->userColorLink($rs['added'], array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor']));
		
		if($rs['status'] == 0){
			$medalApprove="<font color=\"blue\">تنتظر</font>";
		}
		elseif($rs['status'] == 1){
			$medalApprove="نعم";
		}
		elseif($rs['status'] == 2){
			$medalApprove="<font color=\"red\">رفض</font>";
		}
		
		$expireDate=$rs['date']+($rs['days']*86400);
		$expire=($expireDate>time ? $DF->date($expireDate,'date',true) : 'إنتهى');
		
		echo"
		<tr id=\"row{$rs['id']}\">";
		if(ulv > 2){
			echo"
			<td class=\"asNormalB asCenter\" style=\"padding:1px\">$checkBox</td>";
		}
			echo"
			<td class=\"asNormalB asAS12 asCenter\"><nobr>$user</nobr></td>
			<td class=\"asNormalB asS12 asDate asCenter\"><nobr>{$DF->date($rs['date'],'date',true)}</nobr></td>
			<td class=\"asNormalB asS12 asDate asCenter\"><nobr>$expire</nobr></td>
			<td class=\"asNormalB asS12\">{$rs['subject']}</td>
			<td class=\"asNormalB asCenter\"><img src=\"{$DFImage->i['camera']}\" onclick=\"DF.doPreviewImage('{$rs['filename']}');\" border=\"0\"></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['points']}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>$medalApprove</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>$added</nobr></td>
			<td class=\"asNormalB asCenter\"><nobr>$options</nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"11\"><br>-- لا توجد أيه أوسمة بهذه المواصفات --<br><br></td>
		</tr>";
	}
	if($checkCount>0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"11\">
				{$Template->button('تحديد الكل',' onClick="DF.checkAllBox(this)"')}&nbsp;&nbsp;";
			if($app!='ok'&&$app!='all'){
				echo"
				{$Template->button('موافقة على الأوسمة المختارة'," onClick=\"DF.medalCmd(this,'app')\"")}&nbsp;&nbsp;";
			}
			if($app!='ref'&&$app!='all'){
				echo"
				{$Template->button('رفض أوسمة المختارة'," onClick=\"DF.medalCmd(this,'ref')\"")}";
			}
			echo"
			</td>
		</tr>";
	}
	echo"
	</form>
	</table><br>";
}
elseif(type == 'appdistribute'&&ulv > 2){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في موافقة ورفض الأوسمة");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	$app=$_POST['app'];
	$type=$_POST['type'];
	$redeclare=$_POST['redeclare'];
	$medals=$_POST['medals'];
	if(is_array($medals)){
 		$allowforums=$DF->getAllowForumId();
		if($redeclare!=checkredeclare){
			$Template->errMsg("كان هناك خلل أثناء تخزين العملية!<br>يبدو أنه تم محاولة إدخال البيانات عدة مرات لسبب فني أو لخلل في الشبكة.<br>الرجاء التأكد من أن العملية انتهت بنجاح... نأسف على هذا.");
		}
		elseif($type == 'app'){
			for($x=0;$x<count($medals);$x++){
				$exp=explode("|",$medals[$x]);
				$medalid=(int)$exp[0];
				$points=(int)$exp[1];
				$userid=(int)$exp[2];
				$forumid=(int)$exp[3];
				if(ulv == 4||in_array($forumid,$allowforums)){
					$mysql->update("medal SET status = 1 WHERE id = '$medalid'", __FILE__, __LINE__);
					$mysql->update("userflag SET points = points + $points WHERE id = '$userid'", __FILE__, __LINE__);
				}
			}
			$Template->msg("تمت موافقة على الأوسمة المختارة بنجاح");
		}
		elseif($type == 'ref'){
			for($x=0;$x<count($medals);$x++){
				$exp=explode("|",$medals[$x]);
				$medalid=(int)$exp[0];
				$points=(int)$exp[1];
				$userid=(int)$exp[2];
				$forumid=(int)$exp[3];
				if(ulv == 4||in_array($forumid,$allowforums)){
					$mysql->update("medal SET status = 2 WHERE id = '$medalid'", __FILE__, __LINE__);
					if($app == 'ok'){
						$mysql->update("userflag SET points = points - $points WHERE id = '$userid'", __FILE__, __LINE__);
					}
				}
			}
			$Template->msg("تم رفض اوسمة المختارة بنجاح");
		}
		else{
			$Template->errMsg("لم يتم تخزين العملية لسبب فني.<br><br>الرجاء إخبار الإدارة لتصحيح المشكلة.");
		}
	}
	else{
		$Template->errMsg("لم يتم تخزين العملية لسبب فني.<br><br>الرجاء إخبار الإدارة لتصحيح المشكلة.");
	}
}
elseif(type == 'lists'){
	$thisLink="svc.php?svc=medals&type=lists".(app == ''?'':'&app='.app).(scope == ''?'':'&scope='.scope)."&";
	?>
	<script type="text/javascript">
	var link="<?=$thisLink?>";
	DF.medalCmd=function(s,type){
		var frm=s.form,el=frm.elements,msg=new Array();
		for(x=0,y=0;x<el.length;x++){
			if(el[x].type == 'checkbox'&&el[x].checked){
				y++;
			}
		}
		if(y == 0){
			alert("يجب عليك ان تختار على الأقل وسام واحد");
		}
		else{
			msg['app']="موافقة على الأوسمة المختارة";
			msg['close']="قفل أوسمة المختارة";
			msg['open']="فتح أوسمة المختارة";
			if(confirm("هل أنت متأكد بأن تريد "+msg[type]+" وعددها: "+y)){
				frm.type.value=type;
				frm.submit();
			}
		}
	};
	DF.chooseForumId=function(s,app){
		fid=s.options[s.selectedIndex].value;
		if(fid == 0) url="svc.php?svc=medals&type=lists&app="+app+"&scope=mod";
		else url="svc.php?svc=medals&type=lists&app="+app+"&scope=forum&f="+fid;
		document.location=url;
	};
	</script>
	<?php
	$app=(app!=''?app:'ok');
	$scope=(scope!=''?scope:'mod');
	$furl=(f>0?"&f=".f:"");
	if($app == 'design'){
		$appTitle="تحت التصميم";
	}
	elseif($app == 'wait'){
		$appTitle="تنتظر الموافقة";
	}
	elseif($app == 'ok'){
		$appTitle="مفتوحة";
	}
	elseif($app == 'closed'){
		$appTitle="مقفولة";
	}
	else{
		$appTitle="جميع الأوسمة";
	}
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asTopHeader asCenter\" colspan=\"10\">
	<ul class=\"svcbar asAS12\">
		<li class=\"selected\"><a href=\"svc.php?svc=medals&type=addlists\"><em>أضف وسام جديد</em></a></li>
	</ul>
	<ul class=\"svcbar asAS12\">
		<li><em class=\"".($scope == 'forum'?'selectedone':'one')."\">
		<select class=\"asGoTo\" style=\"width:160px\" onChange=\"DF.chooseForumId(this,'$app')\">
			<option value=\"0\">&nbsp;&nbsp;&nbsp;-- عرض أوسمة منتدى --</option>";
		foreach($Template->forumsList as $key=>$val){
			echo"
			<option value=\"$key\"{$DF->choose(f,$key,'s')}>$val</option>";
		}
		echo"
		</select>
		</em></li>
		<li".($scope == 'mod'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=lists&app=$app&scope=mod\"><em>المنتديات التي تشرف عليها</em></a></li>
		<li".($scope == 'own'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=lists&app=$app&scope=own\"><em>الأوسمة التي إضفتها أنت</em></a></li>
		<li".($scope == 'all'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=lists&app=$app&scope=all\"><em>جميع الأوسمة</em></a></li>
	</ul>
	<ul class=\"svcbar asAS12\">
		<li".($app == 'design'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=lists&app=design&scope=$scope$furl\"><em>أوسمة تحت التصميم</em></a></li>
		<li".($app == 'wait'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=lists&app=wait&scope=$scope$furl\"><em>أوسمة تنتظر الموافقة</em></a></li>
		<li".($app == 'ok'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=lists&app=ok&scope=$scope$furl\"><em>أوسمة مفتوحة</em></a></li>
		<li".($app == 'closed'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=lists&app=closed&scope=$scope$furl\"><em>أوسمة مقفولة</em></a></li>
		<li".($app == 'all'?' class="selected"':'')."><a href=\"svc.php?svc=medals&type=lists&app=all&scope=$scope$furl\"><em>جميع الأوسمة</em></a></li>
	</ul>
	</tr>
	<form method=\"post\" action=\"svc.php?svc=medals&type=applists\">
	<input type='hidden' name='type'>
		<tr>
			<td class=\"asHeader\" colspan=\"10\">أوسمة التميز - <span class=\"asC2\">$appTitle</span></td>
		</tr>
		<tr>";
		if(ulv > 2){
			echo"
			<td class=\"asDarkB\"><nobr>&nbsp;</nobr></td>";
		}
			echo"
			<td class=\"asDarkB\"><nobr>الرقم</nobr></td>
			<td class=\"asDarkB\"><nobr>الوصف</nobr></td>
			<td class=\"asDarkB\"><nobr>مشاهدة<br>الصورة</nobr></td>
			<td class=\"asDarkB\"><nobr>نقاط<br>التميز</nobr></td>
			<td class=\"asDarkB\"><nobr>موافقة<br>عليه</nobr></td>
			<td class=\"asDarkB\"><nobr>المنتدى</nobr></td>
			<td class=\"asDarkB\"><nobr>يعرض<br>لمدة<br>(أيام)</nobr></td>
			<td class=\"asDarkB\"><nobr>أضاف<br>الوسام</nobr></td>
			<td class=\"asDarkB\">الخيارات</td>
		</tr>";
		
	$checkSqlField="";
	$checkSqlTable="";
	if(ulv < 4){
		$checkSqlField=",IF(ISNULL(m.id),0,1) AS ismod";
		$checkSqlTable="LEFT JOIN ".prefix."moderator AS m ON(m.forumid = ml.forumid AND m.userid = '".uid."')";
		if(ulv == 3){
			$checkSqlField.=",IF(ISNULL(c.id),0,1) AS ismon";
			$checkSqlTable.="LEFT JOIN ".prefix."category AS c ON(c.id = f.catid AND c.monitor = '".uid."')";
		}
	}
	else{
		$checkSqlField="
			,IF(ISNULL(ml.id),0,1) AS ismod
			,IF(ISNULL(ml.id),0,1) AS ismon
		";
	}
	
	$pgLimit=$DF->pgLimit(num_pages);
 	$sql=$mysql->query("SELECT ml.id,ml.forumid,ml.status,ml.subject,ml.days,ml.points,ml.filename,ml.added,ml.close,
		f.subject AS fsubject,u.name AS aname,u.status AS astatus,u.level AS alevel,u.submonitor AS asubmonitor {$checkSqlField}
	FROM ".prefix."medallists AS ml
	LEFT JOIN ".prefix."forum AS f ON(f.id = ml.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = ml.added) {$checkSqlTable}
	WHERE ml.id > 0 ".checkMedalListsSql()." GROUP BY ml.id ORDER BY ml.subject ASC LIMIT {$pgLimit},".num_pages, __FILE__, __LINE__);
	$count=0;
	$checkCount=0;
	while($rs=$mysql->fetchAssoc($sql)){
		if($rs['ismod'] == 1||$rs['ismon'] == 1){
			$options="
			<a href=\"svc.php?svc=medals&type=editlists&m={$rs['id']}\"><img src=\"{$DFImage->i['edit']}\" alt=\"تعديل الوسام\" hspace=\"2\" border=\"0\"></a>
			<a href=\"svc.php?svc=medals&type=distribute&app=all&scope=all&days=-1&m={$rs['id']}\"><img src=\"{$DFImage->i['question']}\" alt=\"استعمال الوسام\" hspace=\"2\" border=\"0\"></a>";
			if($rs['status'] == 1&&$rs['close'] == 0){
				$options.="
				<a href=\"svc.php?svc=medals&type=moreaward&m={$rs['id']}\"><img src=\"{$DFImage->i['users']}\" alt=\"امنح هذا الوسام لمجموعة من الأعضاء\" hspace=\"2\" border=\"0\"></a>";
			}
		}
		else{
			$options="-";
		}

		if($rs['ismon'] == 1&&$app!='all'){
			$checkBox="<input onClick=\"DF.checkRowClass(this,{$rs['id']});\" type=\"checkbox\" class=\"none\" name=\"medals[]\" value=\"{$rs['id']}\">";
			$checkCount++;
		}
		else{
			$checkBox="-";
		}
		
		$added = $Template->userColorLink($rs['added'], array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor']));
		
		echo"
		<tr id=\"row{$rs['id']}\">";
		if(ulv > 2){
			echo"
			<td class=\"asNormalB asCenter\">$checkBox</td>";
		}
			echo"
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['id']}</nobr></td>
			<td class=\"asNormalB asS12\"><nobr>{$rs['subject']}</nobr></td>
			<td class=\"asNormalB asCenter\"><img src=\"{$DFPhotos->getsrc($rs['filename'])}\" onError=\"this.src='{$DFImage->i['nophoto']}';\" onclick=\"DF.doPreviewImage('{$DFPhotos->getsrc($rs['filename'])}');\" width=\"33\" height=\"33\" border=\"0\"></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['points']}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>".($rs['status'] == 1 ? "نعم" : "<font color=\"red\">لا</font>")."</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr><b>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</b></nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['days']}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>$added</nobr></td>
			<td class=\"asNormalB asCenter\"><nobr>$options</nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"10\"><br>-- لا توجد أيه أوسمة بهذه المواصفات --<br><br></td>
		</tr>";
	}
	if($checkCount>0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"10\">
				{$Template->button('تحديد الكل',' onClick="DF.checkAllBox(this)"')}&nbsp;&nbsp;";
			if($app!='ok'&&$app!='all'){
				echo"
				{$Template->button('موافقة على الأوسمة المختارة'," onClick=\"DF.medalCmd(this,'app')\"")}&nbsp;&nbsp;";
			}
			if($app!='closed'&&$app!='all'){
				echo"
				{$Template->button('قفل أوسمة المختارة'," onClick=\"DF.medalCmd(this,'close')\"")}";
			}
			if($app == 'closed'){
				echo"
				{$Template->button('فتح أوسمة المختارة'," onClick=\"DF.medalCmd(this,'open')\"")}";
			}
			echo"
			</td>
		</tr>";
	}
	echo"
	</form>
	</table>
	</center><br>";
}
elseif(type == 'applists'&&ulv > 2){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في موافقة والقفل قوائم الأوسمة");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	$type=$_POST['type'];
	$medals=$_POST['medals'];
	if(is_array($medals)){
		if($type == 'app'){
			$checkField="status = 1";
			$msg="تمت موافقة على الأوسمة المختارة بنجاح";
		}
		elseif($type == 'close'){
			$checkField="close = 1";
			$msg="تم قفل اوسمة المختارة بنجاح";
		}
		elseif($type == 'open'){
			$checkField="close = 0";
			$msg="تم فتح اوسمة المختارة بنجاح";
		}
		else{
			$Template->errMsg("لم يتم تخزين العملية لسبب فني.<br><br>الرجاء إخبار الإدارة لتصحيح المشكلة.");
		}
		$checkForum=(ulv == 4 ? "" : "AND forumid IN (".implode(",",$DF->getAllowForumId(true)).")");
		$mysql->update("medallists SET $checkField WHERE id IN (0,".implode(",",$medals).") $checkForum", __FILE__, __LINE__);
		$Template->msg($msg);
	}
	else{
		$Template->errMsg("لم يتم تخزين العملية لسبب فني.<br><br>الرجاء إخبار الإدارة لتصحيح المشكلة.");
	}
}
elseif(type == 'awardforums'){
	$sql=$mysql->query("SELECT name FROM ".prefix."user WHERE id = '".u."' AND status IN (0,1)", __FILE__, __LINE__);
	$rs=$mysql->fetchRow($sql);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	echo"
	<table width=\"40%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader asAC2\" colspan=\"3\">إختار المنتدى الذي تريد منح شعار تميز منه للعضو: {$Template->userNormalLink(u,$rs[0])}</td>
		</tr>
		<tr>
			<td class=\"asDarkB\">&nbsp;</td>
			<td class=\"asDarkB\"><nobr>اسم المنتدى</nobr></td>
			<td class=\"asDarkB\" width=\"1%\">عدد<br>اللأوسمة</td>
		</tr>";
	$checkForum=(ulv == 4 ? "" : "AND f.id IN (".implode(",",$DF->getAllowForumId(true)).")");
	$sql=$mysql->query("SELECT f.id,f.subject,COUNT(ml.id) AS medals 
	FROM ".prefix."forum AS f
	LEFT JOIN ".prefix."medallists AS ml ON(ml.forumid = f.id AND ml.status = 1 AND ml.close = 0)
	LEFT JOIN ".prefix."category AS c ON(c.id = f.catid)
	WHERE f.id > 0 $checkForum GROUP BY f.id ORDER BY c.sort,f.sort ASC", __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\"><nobr>".($count+1)."</nobr></td>
			<td class=\"asNormalB\"><a href=\"svc.php?svc=medals&type=award&u=".u."&f={$rs['id']}\"><nobr>{$rs['subject']}</nobr></a></td>
			<td class=\"asNormalB asCenter\"><nobr>{$rs['medals']}</nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"3\"><br>لا توجد أي منتدى<br><br></td>
		</tr>";
	}
	echo"
	</table>";
}
elseif(type == 'award'){
	$sql=$mysql->query("SELECT name FROM ".prefix."user WHERE id = '".u."' AND status IN (0,1)", __FILE__, __LINE__);
	$rs=$mysql->fetchRow($sql);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	
	$forums=$DF->getAllowForumId();
	if(ulv < 4&&!in_array(f,$forums)){
		$DF->goTo();
		exit();
	}
	
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader asAC2\" colspan=\"7\">إختار شعار التميز من قائمة أدناه لمنحه للعضو: {$Template->userNormalLink(u,$rs[0])}</td>
		</tr>
		<tr>
			<td class=\"asDarkB\"><nobr>الرقم</nobr></td>
			<td class=\"asDarkB\"><nobr>العنوان</nobr></td>
			<td class=\"asDarkB\">صورة<br>الوسام</td>
			<td class=\"asDarkB\"><nobr>نقاط<br>التميز</nobr></td>
			<td class=\"asDarkB\"><nobr>المنتدى</nobr></td>
			<td class=\"asDarkB\"><nobr>يعرض<br>لمدة<br>(أيام)</nobr></td>
			<td class=\"asDarkB\">الخيارات</td>
		</tr>";
	$sql=$mysql->query("SELECT ml.id,ml.subject,ml.days,ml.points,ml.filename,f.subject AS fsubject
	FROM ".prefix."medallists AS ml
	LEFT JOIN ".prefix."forum AS f ON(f.id = ml.forumid)
	WHERE ml.forumid = '".f."' AND ml.status = 1 AND ml.close = 0 ORDER BY ml.subject ASC", __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		echo"
		<tr>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['id']}</nobr></td>
			<td class=\"asNormalB asS12\"><nobr>{$rs['subject']}</nobr></td>
			<td class=\"asNormalB asCenter\"><img src=\"{$DFPhotos->getsrc($rs['filename'])}\" onError=\"this.src='{$DFImage->i['nophoto']}';\" onclick=\"DF.doPreviewImage('{$DFPhotos->getsrc($rs['filename'])}');\" width=\"33\" height=\"33\" border=\"0\"></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['points']}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>{$Template->forumLink(f,$rs['fsubject'])}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['days']}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr><a href=\"svc.php?svc=medals&type=insertaward&u=".u."&f=".f."&m={$rs['id']}&defredeclare=".rand."\">- إختار الوسام -</a></nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asS12 asCenter\" colspan=\"7\"><br>لا توجد أي أوسمة لهذا المنتدى<br><br></td>
		</tr>";
	}
	echo"
	</table>";
}
elseif(type == 'insertaward'){
	$sql=$mysql->query("SELECT id FROM ".prefix."user WHERE id = '".u."' AND status IN (0,1)", __FILE__, __LINE__);
	$rs=$mysql->fetchRow($sql);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	
	if(defredeclare!=checkredeclare){
		$Template->errMsg("كان هناك خلل أثناء تخزين العملية!<br>يبدو أنه تم محاولة إدخال البيانات عدة مرات لسبب فني أو لخلل في الشبكة.<br>الرجاء التأكد من أن العملية انتهت بنجاح... نأسف على هذا.");
	}

	$sql=$mysql->query("SELECT points FROM ".prefix."medallists WHERE id = '".m."' AND forumid = '".f."' AND status = 1 AND close = 0", __FILE__, __LINE__);
	$rs=$mysql->fetchRow($sql);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	$points=(int)$rs[0];
	$gotoUrl="svc.php?svc=medals&type=distribute&app=all&scope=all&days=-1&u=".u;

	$forums=$DF->getAllowForumId();
	if(ulv < 4&&!in_array(f,$forums)){
		$DF->goTo();
		exit();
	}
	
	$mysql->insert("medal (listid,userid,status,added,date) VALUES ('".m."','".u."','".(ulv > 2?1:0)."','".uid."','".time."')", __FILE__, __LINE__);
	$DFOutput->setModActivity('medal',f,true);
	$DFOutput->setUserActivity('medal',f,u,ceil($points/2));
	
	if(ulv > 2){
		$mysql->update("userflag SET points = points + $points WHERE id = '".u."'", __FILE__, __LINE__);
		$Template->msg("تم منح وسام التميز للعضو بنجاح",$gotoUrl);
	}
	else{
		$Template->msg("تم منح وسام التميز للعضو لكن بحاجة الى موافقة مراقب",$gotoUrl);
	}
}
elseif(type == 'moreaward'){
	$checkForum=(ulv == 4 ? "" : "AND ml.forumid IN (".implode(",",$DF->getAllowForumId(true)).")");
	$sql=$mysql->query("SELECT ml.subject,ml.filename,ml.points,ml.forumid,ml.days,f.subject AS fsubject
	FROM ".prefix."medallists AS ml
	LEFT JOIN ".prefix."forum AS f ON(f.id = ml.forumid)
	WHERE ml.id = '".m."' AND ml.status = 1 AND ml.close = 0 $checkForum", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	?>
	<script type="text/javascript">
	var deleteIconUrl="<?=$DFImage->i['delete']?>";
	DF.checkSubmit=function(frm){
		var usersIds=(document.body.usersId?document.body.usersId:'');
		if(parseInt(frm.usersNum.value)>0){
			alert("توجد أرقام عضويات الذي تريد منح لهم هذا الوسام في خانة رقم العضوية\nلذا يجب عليك إضافتها الى القائمة حتى لا تخسر منها\nاو امسحها اذا لا تريد منح لهم هذا الوسام");
		}
		else if(usersIds.length == 0){
			alert("أنت لم أضفت أي رقم للقائمة ليتم منح لهم وسام التميز");
		}
		else{
			frm.users.value=usersIds;
			frm.submit();
		}
	}
	DF.deleteUserIdFromList=function(id,type){
		var tab=$I('#'+type+'Table'),tr=$I('#'+type+'Row'+id),index=tr.rowIndex,dbArr=eval("document.body."+type+"Id");
		tab.deleteRow(index);
		dbArr.deleteVal(id);
		if(tab.rows.length == 1){
			var tr=tab.insertRow(1);
			var td=tr.insertCell(0);
			td.innerHTML='<br>لم يتم إضافة أي رقم للقائمة.<br><br>';
			td.className='asNormalB asS12 asCenter';
			td.colSpan=2;
		}
		eval("document.body."+type+"Id=dbArr");
	};
	DF.addRowsToList=function(id){
		var type=document.body.opType,tab=$I('#'+type+'Table'),dbArr=eval("document.body."+type+"Id");
		if(dbArr.length == 0){
			tab.deleteRow(1);
		}
		var tr=tab.insertRow(tab.rows.length);
		tr.id=type+'Row'+id;
		var td1=tr.insertCell(0);
		td1.innerHTML=id;
		td1.className='asNormalB asCenter';
		var td2=tr.insertCell(1);
		td2.innerHTML='<a href="javascript:DF.deleteUserIdFromList('+id+',\''+type+'\');"><img src="'+deleteIconUrl+'" alt="حذف رقم من القائمة" hspace="6" border="0"></a>';
		td2.className='asNormalB asCenter';
		td2.style.width='1%';
		eval("document.body."+type+"Id=dbArr");
	};
	DF.addUserIdToList=function(type){
		var tab=$I('#'+type+'Table'),inp=$I('#'+type+"Num"),inpStr=inp.value,listArr=new Array();
		document.body.opType=type;
		if(!eval("document.body."+type+"Id")){
			eval("document.body."+type+"Id=new Array()");
		}
		var dbArr=eval("document.body."+type+"Id");
		if(inpStr.indexOf(',')>=0){
			listArr=inpStr.split(',');
		}
		else{
			listArr[0]=parseInt(inpStr);
		}
		for(var x=0;x<listArr.length;x++){
			var id=parseInt(listArr[x]);
			if(!isNaN(id)&&id>0&&!dbArr.inArray(id)){
				this.addRowsToList(id);
				dbArr.push(id);
			}
			inp.value=0;
		}
		eval("document.body."+type+"Id=dbArr");
	};
	</script>
	<?php
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader\" colspan=\"7\">منح وسام الأدناه لمجموعة من الأعضاء</td>
		</tr>
		<tr>
			<td class=\"asDarkB\"><nobr>الرقم</nobr></td>
			<td class=\"asDarkB\"><nobr>العنوان</nobr></td>
			<td class=\"asDarkB\">صورة<br>الوسام</td>
			<td class=\"asDarkB\"><nobr>نقاط<br>التميز</nobr></td>
			<td class=\"asDarkB\"><nobr>المنتدى</nobr></td>
			<td class=\"asDarkB\"><nobr>يعرض<br>لمدة<br>(أيام)</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB asS12 asCenter\"><nobr>".m."</nobr></td>
			<td class=\"asNormalB asS12\"><nobr>{$rs['subject']}</nobr></td>
			<td class=\"asNormalB asCenter\"><img src=\"{$DFPhotos->getsrc($rs['filename'])}\" onError=\"this.src='{$DFImage->i['nophoto']}';\" onclick=\"DF.doPreviewImage('{$DFPhotos->getsrc($rs['filename'])}');\" width=\"25\" height=\"25\" border=\"0\"></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['points']}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['days']}</nobr></td>
		</tr>
		<form method=\"post\" action=\"svc.php?svc=medals&type=insertmoreaward\">
		<input type=\"hidden\" name=\"medalid\" value=\"".m."\">
		<input type=\"hidden\" name=\"redeclare\" value=\"".rand."\">
		<tr>
			<td class=\"asNormalB asS12 asCenter\" colspan=\"6\">
				<textarea style=\"display:none\" name=\"users\"></textarea><br>
				<input type=\"text\" style=\"width:150px;text-align:center\" id=\"usersNum\" name=\"usersNum\" value=\"0\" dir=\"ltr\"><br>
				{$Template->button('أضف رقم الى القائمة'," onClick=\"DF.addUserIdToList('users')\"")}
				<br><br><hr width=\"90%\">ملاحظة: اذا تريد ان تضاف اكثر من رقم اكتب ارقام هكذا <span dir=\"ltr\">1,2,3,4</span><hr width=\"90%\"><br>
				<table id=\"usersTable\" width=\"40%\" cellspacing=\"1\" cellpadding=\"3\">
					<tr>
						<td class=\"asDarkB\" colspan=\"2\">قائمة أرقام عضويات التي تريد ان تمنح لهم وسام الأعلاه</td>
					</tr>
					<tr>
						<td class=\"asNormalB asS12 asCenter\"><br>لم يتم إضافة أي رقم للقائمة.<br><br></td>
					</tr>
				</table>
				<br>تنبيه: أرقام العضويات التي في قائمة أعلاه هي مؤقتة وبتحديث الصفحة سيتم تصفيرها.<br><br>
			</td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"6\">{$Template->button('منح وسام',' onClick="DF.checkSubmit(this.form)"')}</td>
		</tr>
		</form>
	</table>";
}
elseif(type == 'insertmoreaward'){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في منح وسام التميز لمجموعة من الأعضاء");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	
	$redeclare=(int)$_POST['redeclare'];
	$medalid=(int)$_POST['medalid'];
	$users=$DF->cleanText($_POST['users']);
	
	$mrs=$mysql->queryRow("SELECT forumid,points FROM ".prefix."medallists WHERE id = $medalid", __FILE__, __LINE__);
	$points=$mrs[1];
	$forumid=$mrs[0];
	
	$forums=$DF->getAllowForumId();
	if(ulv < 4&&!in_array($forumid,$forums)){
		$DF->goTo();
		exit();
	}
	
	if($redeclare!=checkredeclare){
		$Template->errMsg("كان هناك خلل أثناء تخزين العملية!<br>يبدو أنه تم محاولة إدخال البيانات عدة مرات لسبب فني أو لخلل في الشبكة.<br>الرجاء التأكد من أن العملية انتهت بنجاح... نأسف على هذا.");
	}
	
	if(!empty($users)){
		$sql=$mysql->query("SELECT id FROM ".prefix."user WHERE id IN ($users) AND status = 1", __FILE__, __LINE__);
		while($rs=$mysql->fetchRow($sql)){
			$mysql->insert("medal (listid,userid,status,added,date) VALUES ('$medalid','$rs[0]','".(ulv > 2?1:0)."','".uid."','".time."')", __FILE__, __LINE__);
			$DFOutput->setModActivity('medal',$forumid,true);
			$DFOutput->setUserActivity('medal',(int)$forumid,(int)$rs[0],ceil($points/2));
			if(ulv > 2){
				$mysql->update("userflag SET points = points + $points WHERE id = '$rs[0]'", __FILE__, __LINE__);
			}
		}
	}
	
	$gotoUrl="svc.php?svc=medals&type=distribute&app=all&scope=all&days=-1&m=$medalid";
	
	if(ulv > 2){
		$Template->msg("تم منح وسام التميز للأعضاء المختارة بنجاح",$gotoUrl);
	}
	else{
		$Template->msg("تم منح وسام التميز للأعضاء المختارة لكن بحاجة الى موافقة مراقب",$gotoUrl);
	}
}
elseif(type == 'addlists'){
	?>
	<script type="text/javascript">
	var f=<?=f?>;
	DF.chooseForumId=function(s){
		fid=s.options[s.selectedIndex].value;
		document.location="svc.php?svc=medals&type=addlists&f="+fid;
	};
	DF.addSubject=function(frm,type){
		if(type == 'delete'){
			frm.medalsubject.value='';
		}
		else{
			if(frm.medalforumid.selectedIndex == 0){
				alert("يجب عليك أن تختار منتدى من القائمة ثم إدخال عنوان الوسام.");
			}
			else{
				frm.medalsubject.value="وسام [ادخل المعلومات هنا] للمنتدى "+frm.medalforumid.options[frm.medalforumid.selectedIndex].text;
			}
		}
	};
	DF.choosePhoto=function(src){
		var cellPlace=$I('#cellMedalLists'),testImg=$I('#testImg'),medal_filename=$I('#medal_filename');
		if(cellPlace&&testImg&&medal_filename){
			src=unescape(src);
			medal_filename.value=src
			testImg.src=src;
			cellPlace.innerHTML="<br><a href='javascript:DF.loadMedalList();'>-- اضغط هنا لفتح قائمة صور الأوسمة --</a><br><br>";
		}
	};
	DF.loadMedalList=function(){
		if(f == 0){
			alert("يجب عليك أن تختار منتدى من القائمة ثم تختار ثم فتح قائمة الصور.");
		}
		else{
			var cellPlace=$I('#cellMedalLists');
			DF.ajax.play({
				'send':'type=getForumMedalsPhoto&id='+f,
				'func':function(){
					var obj=DF.ajax.oName,ac=DF.ajax.ac,text;
					if(obj.readyState == 1||obj.readyState == 2||obj.readyState == 3){
						cellPlace.innerHTML='<br><img src="'+progressUrl+'" border="0"><br><br>رجاءاً أنتظر ليتم تحميل الصور...<br><br>';
					}
					else if(obj.readyState == 4){
						var get=obj.responseText.split(ac);
						if(get[1]&&get[1]!=''){
							var photos=get[1].split('[>:r:<]');
							text="<table width='100%' cellspacing='5' cellpadding='5' border='0'><tr>";
							for(var x=0,y=1;x<photos.length-1;x++){
								text+="<td align='center'><a href=\"javascript:DF.choosePhoto('"+escape(photos[x])+"');\" id=\""+photos[x]+"\"><img src=\""+photos[x]+"\" onError=\"this.src='"+nophotoUrl+"';\" alt=\"اضغط هنا لإختيار الصورة\" width=\"50\" height=\"50\" border=\"0\"></a></td>";
								if(y == 8){
									text+="</tr><tr>";
									y=0;
								}
								y++;
							}
							if(photos.length<=1){
								text+="<td align='center'><br>لا توجد أي صورة لهذا المنتدى<br></td>";
							}
							text+="</tr></table><br>"+
							"<a href='javascript:DF.loadMedalList();'>-- اضغط هنا لتحميل قائمة الصور من جديد --</a><br><br>"+
							"<a href='svc.php?svc=medals&type=upphotos&f="+f+"'>-- اضغط هنا لرفع صورة جديدة لقائمة صورة هذا المنتدى --</a><br><br>";
							cellPlace.innerHTML=text;
						}
						else{
							text="<br><img src='"+errorUrl+"' border='0'><br><br><font color='red'>كان هناك خلل أثناء تحميل الصور<br>مرجوا ان تقوم بإعادة تحميل قائمة الصور من جديد</font><br><br>"+
							"<a href='javascript:DF.loadMedalList();'>-- اضغط هنا لتحميل قائمة الصور من جديد --</a><br><br>";
							cellPlace.innerHTML=text;
						}
					}
				}
			});
		}
	};
	DF.checkSubmit=function(frm){
		if(frm.medalsubject.value.length<10||frm.medalsubject.value.indexOf("[")>=0||frm.medalsubject.value.indexOf("]")>=0){
			alert("يجب إدخال عنوان للوسام وأن يكون أطول من 10 أحرف.");
		}
		else if(frm.medalforumid.selectedIndex == 0){
			alert("يجب عليك أن تختار منتدى من القائمة.");
		}
		else if(frm.medal_filename.value.length == 0){
			alert("يجب عليك أن تختار صورة للوسام.");
		}
		else{
			frm.submit();
		}
	};
	</script>
	<?php
	$medal_filename = m > 0 ? $mysql->get("medalphotos", "filename", m) : '';
	echo"
	<table width=\"50%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form name=\"medalInfo\" method=\"post\" action=\"svc.php?svc=medals&type=insertlists\">
	<input type=\"hidden\" name=\"medal_filename\" id=\"medal_filename\" value=\"{$medal_filename}\">
		<tr>
			<td class=\"asHeader\" colspan=\"4\"><nobr>إضافة وسام للمنتدى</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عنوان الوسام</nobr></td>
			<td class=\"asNormalB\" colspan=\"3\"><nobr>
				<input type=\"text\" style=\"width:400px;\" name=\"medalsubject\">&nbsp;&nbsp;
				{$Template->button("+"," onClick=\"DF.addSubject(this.form,'add')\"")}
				{$Template->button("X"," onClick=\"DF.addSubject(this.form,'delete')\"")}</nobr>
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>المنتدى</nobr></td>
			<td class=\"asNormalB\" colspan=\"3\">
			<select class=\"asGoTo\" name=\"medalforumid\" onChange=\"DF.chooseForumId(this)\">
				<option value=\"0\">-- اختر منتدى --</option>";
			$forumSql=(ulv == 4 ? "" : "WHERE f.id IN (".implode(",",$DF->getAllowForumId(true)).")");
			$sql=$mysql->query("SELECT f.id,f.subject FROM ".prefix."forum AS f LEFT JOIN ".prefix."category AS c ON(c.id = f.catid)
			$forumSql GROUP BY f.id ORDER BY c.sort,f.sort ASC", __FILE__, __LINE__);
			while($rs=$mysql->fetchRow($sql)){
				echo"
				<option value=\"$rs[0]\"{$DF->choose(f,$rs[0],'s')}>$rs[1]</option>";
			}
			echo"
			</select>
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>قائمة الصور الأوسمة</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\" colspan=\"3\" id=\"cellMedalLists\"><br><a href=\"javascript:DF.loadMedalList();\">-- اضغط هنا لفتح قائمة صور الأوسمة --</a><br><br></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>صورة الوسام</nobr></td>
			<td class=\"asNormalB\" align=\"center\" colspan=\"3\"><img id=\"testImg\" src=\"{$DFPhotos->getsrc($medal_filename)}\" onError=\"this.src='{$DFImage->i['nophoto']}';\" width=\"100\" height=\"100\" border=\"0\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عدد الأيام</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"3\">
			<select class=\"asGoTo\" name=\"medaldays\">";
			for($x=1;$x<=30;$x++){
				echo"
				<option value=\"$x\"{$DF->choose($x,7,'s')}>$x</option>";
			}
			echo"
			</select>&nbsp;&nbsp;&nbsp;عدد إيام ظهور الوسام تحت إسم العضو في مشاركاته
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>نقاط التميز</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"3\">
			<select class=\"asGoTo\" name=\"medalpoints\">";
			for($x=1;$x<=20;$x++){
				echo"
				<option value=\"$x\"{$DF->choose($x,5,'s')}>$x</option>";
			}
			echo"
			</select>&nbsp;&nbsp;&nbsp;عدد نقاط التميز التي تضاف للعضو عند منحه الوسام
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>وضعية الوسام</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"0\" name=\"medalstatus\"".(ulv == 2?'checked':'').">الوسام ينتظر موافقة المراقب</nobr></td>
			<td class=\"asNormalB asS12\"".(ulv == 2?' colspan=\"2\"':'')."><nobr><input type=\"radio\" value=\"2\" name=\"medalstatus\">الوسام تحت التصميم</nobr></td>";
		if(ulv > 2){
			echo"
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"1\" name=\"medalstatus\" checked>الوسام حي</nobr></td>";
		}
		echo"
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>قفل الوسام</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"0\" name=\"medalclose\" checked>الوسام مفتوح للإستخدام</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"2\"><nobr><input type=\"radio\" value=\"1\" name=\"medalclose\">الوسام مقفول ولا يظهر عند الترشيح</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"4\">
				{$Template->button("أدخل التغييرات"," onClick=\"DF.checkSubmit(this.form)\"")}&nbsp;&nbsp;
				{$Template->button("إلغاء التغييرات"," onClick=\"this.form.reset();\"")}
			</td>
		</tr>
	</form>
	</table>";
}
elseif(type == 'insertlists'){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في إضافة وسام جديد للمنتدى");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	$subject=$DF->cleanText($_POST['medalsubject']);
	$medal_filename=$DF->cleanText($_POST['medal_filename']);
	$forumid=(int)$_POST['medalforumid'];
	$days=(int)$_POST['medaldays'];
	$points=(int)$_POST['medalpoints'];
	$status=(int)$_POST['medalstatus'];
	$close=(int)$_POST['medalclose'];
	$forums=$DF->getAllowForumId();
	if(empty($subject)){
		$Template->errMsg("يجب إدخال عنوان للوسام وأن يكون أطول من 10 أحرف.");
	}
	elseif($forumid == 0){
		$Template->errMsg("يجب عليك أن تختار منتدى من القائمة.");
	}
	elseif(empty($medal_filename)){
		$Template->errMsg("يجب عليك أن تختار صورة للوسام.");
	}
	elseif(ulv < 4&&!in_array($forumid,$forums)){
		$Template->errMsg("منتدى الذي اخترت لا يسمح لك بإضافة وسام لها.");
	}
	else{
		$mysql->insert("medallists (forumid,status,subject,days,points,filename,close,added,date) VALUES
		('$forumid','$status','$subject','$days','$points','".$DFPhotos->getname($medal_filename)."','$close','".uid."','".time."')", __FILE__, __LINE__);
		$DFOutput->setModActivity('medal',$forumid,true);
		$link=array('wait','ok','design');
		$Template->msg((ulv > 2 ? "تم إضافة وسام للمنتدى بنجاح" : "تم إضافة وسام للمنتدى لكن بحاجة لموافقة مراقب"),"svc.php?svc=medals&type=lists&app=$link[$status]&scope=mod");
	}
}
elseif(type == 'editlists'){
	$sql=$mysql->query("SELECT ml.forumid,ml.status,ml.subject,ml.days,ml.points,ml.filename,ml.close,f.subject AS fsubject
	FROM ".prefix."medallists AS ml
	LEFT JOIN ".prefix."forum AS f ON(f.id = ml.forumid)
	WHERE ml.id = '".m."'", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	$forums=$DF->getAllowForumId();
	if(!$rs||ulv < 4&&!in_array($rs['forumid'],$forums)){
		$DF->goTo();
		exit();
	}
	?>
	<script type="text/javascript">
	var f=<?=$rs['forumid']?>;
	DF.choosePhoto=function(src){
		var cellPlace=$I('#cellMedalLists'),testImg=$I('#testImg'),medal_filename=$I('#medal_filename');
		if(cellPlace&&testImg&&medal_filename){
			src=unescape(src);
			medal_filename.value=src
			testImg.src=src;
			cellPlace.innerHTML="<br><a href='javascript:DF.loadMedalList();'>-- اضغط هنا لفتح قائمة صور الأوسمة --</a><br><br>";
		}
	};
	DF.loadMedalList=function(){
		if(f == 0){
			alert("يجب عليك أن تختار منتدى من القائمة ثم تختار ثم فتح قائمة الصور.");
		}
		else{
			var cellPlace=$I('#cellMedalLists');
			DF.ajax.play({
				'send':'type=getForumMedalsPhoto&id='+f,
				'func':function(){
					var obj=DF.ajax.oName,ac=DF.ajax.ac,text;
					if(obj.readyState == 1||obj.readyState == 2||obj.readyState == 3){
						cellPlace.innerHTML='<br><img src="'+progressUrl+'" border="0"><br><br>رجاءاً أنتظر ليتم تحميل الصور...<br><br>';
					}
					else if(obj.readyState == 4){
						var get=obj.responseText.split(ac);
						if(get[1]&&get[1]!=''){
							var photos=get[1].split('[>:r:<]');
							text="<table width='100%' cellspacing='5' cellpadding='5' border='0'><tr>";
							for(var x=0,y=1;x<photos.length-1;x++){
								text+="<td align='center'><a href=\"javascript:DF.choosePhoto('"+escape(photos[x])+"');\" id=\""+photos[x]+"\"><img src='"+photos[x]+"' onError='this.src=\""+nophotoUrl+"\";' alt='اضغط هنا لإختيار الصورة' width='50' height='50' border='0'></a></td>";
								if(y == 8){
									text+="</tr><tr>";
									y=0;
								}
								y++;
							}
							if(photos.length<=1){
								text+="<td align='center'><br>لا توجد أي صورة لهذا المنتدى<br></td>";
							}
							text+="</tr></table><br>"+
							"<a href='javascript:DF.loadMedalList();'>-- اضغط هنا لتحميل قائمة الصور من جديد --</a><br><br>"+
							"<a href='svc.php?svc=medals&type=upphotos&f="+f+"'>-- اضغط هنا لرفع صورة جديدة لقائمة صورة هذا المنتدى --</a><br><br>";
							cellPlace.innerHTML=text;
						}
						else{
							text="<br><img src='"+errorUrl+"' border='0'><br><br><font color='red'>كان هناك خلل أثناء تحميل الصور<br>مرجوا ان تقوم بإعادة تحميل قائمة الصور من جديد</font><br><br>"+
							"<a href='javascript:DF.loadMedalList();'>-- اضغط هنا لتحميل قائمة الصور من جديد --</a><br><br>";
							cellPlace.innerHTML=text;
						}
					}
				}
			});
		}
	};
	DF.checkSubmit=function(frm){
		if(frm.medalsubject.value.length<10||frm.medalsubject.value.indexOf("[")>=0||frm.medalsubject.value.indexOf("]")>=0){
			alert("يجب إدخال عنوان للوسام وأن يكون أطول من 10 أحرف.");
		}
		else if(frm.medal_filename.value.length == 0){
			alert("يجب عليك أن تختار صورة للوسام.");
		}
		else{
			frm.submit();
		}
	};
	</script>
	<?php
	echo"
	<table width=\"50%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form name=\"medalInfo\" method=\"post\" action=\"svc.php?svc=medals&type=updatelists\">
	<input type=\"hidden\" name=\"medal_filename\" id=\"medal_filename\" value=\"{$DFPhotos->getsrc($rs['filename'])}\">
	<input type=\"hidden\" name=\"medalid\" value=\"".m."\">
		<tr>
			<td class=\"asHeader\" colspan=\"4\"><nobr>إضافة وسام للمنتدى</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عنوان الوسام</nobr></td>
			<td class=\"asNormalB\" colspan=\"3\"><input type=\"text\" style=\"width:400px;\" name=\"medalsubject\" value=\"{$rs['subject']}\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>المنتدى</nobr></td>
			<td class=\"asNormalB asAS12\" colspan=\"3\"><b>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</b></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>قائمة الصور الأوسمة</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\" colspan=\"3\" id=\"cellMedalLists\"><br><a href=\"javascript:DF.loadMedalList();\">-- اضغط هنا لفتح قائمة صور الأوسمة --</a><br><br></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>صورة الوسام</nobr></td>
			<td class=\"asNormalB\" align=\"center\" colspan=\"3\"><img id=\"testImg\" src=\"{$DFPhotos->getsrc($rs['filename'])}\" onError=\"this.src='{$DFImage->i['nophoto']}';\" width=\"100\" height=\"100\" border=\"0\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عدد الأيام</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"3\">";
		if(ulv > 2){
			echo"
			<select class=\"asGoTo\" name=\"medaldays\">";
			for($x=1;$x<=30;$x++){
				echo"
				<option value=\"$x\"{$DF->choose($x,$rs['days'],'s')}>$x</option>";
			}
			echo"
			</select>";
		}
		else{
			echo"<b>( {$rs['days']} )</b>";
		}
			echo"
			&nbsp;&nbsp;&nbsp;عدد إيام ظهور الوسام تحت إسم العضو في مشاركاته
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>نقاط التميز</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"3\">";
		if(ulv > 2){
			echo"
			<select class=\"asGoTo\" name=\"medalpoints\">";
			for($x=1;$x<=20;$x++){
				echo"
				<option value=\"$x\"{$DF->choose($x,$rs['points'],'s')}>$x</option>";
			}
			echo"
			</select>";
		}
		else{
			echo"<b>( {$rs['points']} )</b>";
		}
			echo"
			&nbsp;&nbsp;&nbsp;عدد نقاط التميز التي تضاف للعضو عند منحه الوسام
			</td>
		</tr>";
	if(ulv > 2){
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>وضعية الوسام</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"2\" name=\"medalstatus\"{$DF->choose($rs['status'],2,'c')}>الوسام تحت التصميم</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"2\"><nobr><input type=\"radio\" value=\"1\" name=\"medalstatus\"{$DF->choose($rs['status'],1,'c')}>الوسام حي</nobr></td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>قفل الوسام</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"0\" name=\"medalclose\"{$DF->choose($rs['close'],0,'c')}>الوسام مفتوح للإستخدام</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"2\"><nobr><input type=\"radio\" value=\"1\" name=\"medalclose\"{$DF->choose($rs['close'],1,'c')}>الوسام مقفول ولا يظهر عند الترشيح</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"4\">
				{$Template->button("أدخل التغييرات"," onClick=\"DF.checkSubmit(this.form)\"")}&nbsp;&nbsp;
				{$Template->button("إلغاء التغييرات"," type=\"reset\"")}
			</td>
		</tr>
	</form>
	</table>";
}
elseif(type == 'updatelists'){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في إضافة وسام جديد للمنتدى");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	
	$m=(int)$_POST['medalid'];
	$subject=$DF->cleanText($_POST['medalsubject']);
	$medal_filename=$DF->cleanText($_POST['medal_filename']);
	$days=(int)$_POST['medaldays'];
	$points=(int)$_POST['medalpoints'];
	$status=(int)$_POST['medalstatus'];
	$close=(int)$_POST['medalclose'];
	$forumid=$mysql->get("medallists","forumid",$m);
	$forums=$DF->getAllowForumId();
	if(empty($subject)){
		$Template->errMsg("يجب إدخال عنوان للوسام وأن يكون أطول من 10 أحرف.");
	}
	elseif(empty($medal_filename)){
		$Template->errMsg("يجب عليك أن تختار صورة للوسام.");
	}
	elseif(ulv < 4&&!in_array($forumid,$forums)){
		$Template->errMsg("لا يسمح لك بتعديل هذا الوسام");
	}
	else{
		$mysql->update("medallists SET
			".(ulv > 2 ? "status = '$status',days = '$days',points = '$points'," : "")."
			subject = '$subject',filename = '".$DFPhotos->getname($medal_filename)."',close = '$close'
		WHERE id = '$m'", __FILE__, __LINE__);
		$Template->msg("تم تعديل الوسام بنجاح");
	}
}
elseif(type == 'upphotos'){
	$forums=$DF->getAllowForumId();
	if(ulv < 4&&!in_array(f,$forums)){
		$DF->goTo();
		exit();
	}
	
	$filesPath="/images/medals/forum".f."/";
	if(!is_dir($filesPath)){
		@mkdir($filesPath,0777);
		@chmod($filesPath,0777);
	}
	?>
	<script type="text/javascript">
	DF.deleteFile=function(id){
		if(confirm("هل أنت متأكد بأن تريد حذف هذه الصورة ؟")){
			var frm=$I('#deleteFiles');
			frm.photoid.value=id;
			frm.submit();
		}
	}
	DF.checkFile=function(frm){
		if(frm.upfile.value == ""){
			alert("يجب عليك أن تختار صورة من جهازك");
		}
		else if(frm.upfile.value.toLowerCase().indexOf(".gif")<0){
			alert("ملف الذي اخترت ليس بصيغة GIF\nنرجوا ان تختار ملف يطابق قوانين رفع الملف");
		}
		else{
			frm.submit();
		}
	}
	DF.previewPhoto=function(url){
		var place=$I('#previewPlace');
		place.innerHTML="<img src='"+url+"' onError='$I(\"#previewPlace\").innerHTML=\"\";' border='0'>";
	}
	DF.upFileOverThisFile=function(id){
		var place=$I('#reUploadPlace'),frm=$I('#upFiles');
		frm.photoid.value=(id?id:0);
		place.innerHTML=(id?"اختر ملف ليتم رفعه على ملف رقم "+id+"<br><a href=\"javascript:DF.upFileOverThisFile();\">-- انقر هنا لإلغاء رفع الملف عليها --</a><br>":"");
		if(id){
			document.location="#reupload";
		}
	}
	</script>
	<?php
	$photoid=(int)$_POST['photoid'];
	if($photoid>0){
		$filename=$mysql->get("medalphotos","filename",$photoid);
		$mysql->delete("medalphotos WHERE id = '$photoid'", __FILE__, __LINE__);
		@unlink( $DFPhotos->filename2path($filename) );
		$DF->quick(self);
	}
	echo"
	<a name=\"reupload\"></a>
	<form name=\"deleteFiles\" id=\"deleteFiles\" method=\"post\" action=\"".self."\">
	<input type=\"hidden\" name=\"photoid\" value=\"0\">
	</form>
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader\" colspan=\"8\">مركز رفع صور أوسمة</td>
		</tr>
		<tr>
			<td class=\"asNormalB asS12 asCenter\" colspan=\"8\">الحد الأقصى لحجم صورة <span class=\"asC5\">76800</span> بايت<br>يقابل <span class=\"asC5\">".round(76800/1024,2)."</span> كيلو بايت<br>الصيغة المدعومة فقط هي <span class=\"asC5\">GIF</span><br>حجم المسموح <span class=\"asC5\">100 * 100</span></td>
		</tr>
		<tr>
			<td class=\"asNormalB asS12 asCenter\" colspan=\"8\"><br><span id=\"reUploadPlace\"></span><span id=\"previewPlace\"></span>
			<form name=\"upFiles\" id=\"upFiles\" method=\"post\" action=\"svc.php?svc=medals&type=insertphoto\" enctype=\"multipart/form-data\">
			<input type=\"hidden\" name=\"forumid\" value=\"".f."\">
			<input type=\"hidden\" name=\"photoid\" value=\"0\">
				<table>
					<tr>
						<td class=\"asS12\">إختار صورة من جهازك:</td>
						<td><input type=\"file\" size=\"40\" name=\"upfile\" onChange=\"DF.previewPhoto(this.value);\" dir=\"ltr\"></td>
						<td>&nbsp;</td>
						<td>{$Template->button("إبدا رفع الصورة"," onClick=\"DF.checkFile(this.form)\"")}</td>
					</tr>
				</table>
			</form>
			</td>
		</tr>
		<tr>
			<td class=\"asDarkB\">الرقم</td>
			<td class=\"asDarkB\">اسم الصورة</td>
			<td class=\"asDarkB\">حجم‌</td>
			<td class=\"asDarkB\">استعمال</td>
			<td class=\"asDarkB\">أضف بواسطة</td>
			<td class=\"asDarkB\">تاريخ الرفع</td>
			<td class=\"asDarkB\" colspan=\"2\">الخيارات</td>
		</tr>";
	$sql=$mysql->query("SELECT mp.id,mp.added,mp.filename,mp.date,u.name AS aname,u.status AS astatus,u.level AS alevel,u.submonitor AS asubmonitor,
		IF(ISNULL(ml.id),0,1) AS isuse
	FROM ".prefix."medalphotos AS mp
	LEFT JOIN ".prefix."user AS u ON(u.id = mp.added)
	LEFT JOIN ".prefix."medallists AS ml ON(ml.filename = mp.filename)
	WHERE mp.forumid = ".f." GROUP BY mp.id ORDER BY date DESC", __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){

		$medal_file = $DFPhotos->filename2path( $rs['filename'] );

		$fileSize = file_exists($medal_file) ? filesize($medal_file) : 0;
		$addedName = (($aname = $Template->userColorLink($rs['added'], array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor']))) ? $aname : '--');
		$usePhoto = $rs['isuse'] == 1 ? "نعم" : "<font color=\"red\">لا</font>";
		$photoTools="";
		if($rs['isuse'] == 0||ulv == 4){
			$photoTools="<a href=\"javascript:DF.deleteFile({$rs['id']});\"><img src=\"{$DFImage->i['delete']}\" alt=\"إحذف هذه الصورة من قائمة صور الاوسمة هذا المنتدى\" hspace=\"2\" border=\"0\"></a>";
		}
		if($fileSize == 0){
			$photoTools.="<a href=\"javascript:DF.upFileOverThisFile({$rs['id']});\"><img src=\"{$DFImage->i['reupload']}\" alt=\"رفع ملف جديد على هذا الملف المعطل\" hspace=\"2\" border=\"0\"></a>";
		}
		echo"
		<tr>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['id']}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\" dir=\"ltr\"><a href=\"#\" onclick=\"DF.doPreviewImage('{$DFPhotos->getsrc($rs['filename'])}');return false\">{$rs['filename']}</a></td>
			<td class=\"asNormalB asS12 asCenter\" dir=\"ltr\"><nobr>".($fileSize == 0 ? "--" : round($fileSize/1024,2)." kb")."</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>$usePhoto</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>$addedName</nobr></td>
			<td class=\"asNormalB asS12 asDate asCenter\"><nobr>{$DF->date($rs['date'])}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr><a href=\"svc.php?svc=medals&type=addlists&f=".f."&m={$rs['id']}\">-- إضف وسام جديد --</a></nobr></td>
			<td class=\"asNormalB asCenter\">$photoTools</td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"8\"><br>لا توجد أي صورة لهذا المنتدى<br><br></td>
		</tr>";
	}
		echo"
	</table>";
}
elseif( type == 'insertphoto' ){
	if( !$DF->isOurSite() ){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في رفع صورة الوسام");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	
	$forumid = (int)$_POST['forumid'];
	$photoid = (int)$_POST['photoid'];
	$file = $_FILES['upfile'];

	$forums = $DF->getAllowForumId();
	if( ulv < 4 && !in_array( $forumid, $forums ) ){
		$DF->goTo();
		exit();
	}

	if( count($file) == 0 || !isset($file['name']) || intval($file['error']) > 0 ){
		$Template->errMsg("يجب عليك أن تختار صورة من جهازك");
	}
	else{
		$file_name = $file['name'];
		$file_source = $file['tmp_name'];
		$file_size = intval($file['size']);
		if( $file_size <= 0 ) $file_size = 1;
		$allow_size = intval($DF->config['photos']['medals']['allow_size']);

		$sizes = (array)$DF->config['photos']['medals']['sizes'];
		$result = $DFPhotos->create($file_name, $file_source, array(
			'phototype' => 'services',
			'targetid' => uid,
			'targettype' => 'medals',
			'allow_types' => $DF->config['photos']['medals']['extension'],
			'allow_size' => $DF->config['photos']['medals']['allow_size'],
			'getsize' => 100,
			'sizes' => $sizes,
			'delete_source' => 1
		));

		if( $result['error'] == 1 ){
			if( $result['errorname'] == 'not_allowed_type' ){
				$Template->errMsg("ملف الذي اخترت ليس بصيغة GIF\nنرجوا ان تختار ملف يطابق قوانين رفع الملف");
			}
			elseif( $result['errorname'] == 'not_allowed_size' ){
				$Template->errMsg("الصورة الذي اخترت حجمها أكتر من حجم المسموح<br>الحجم الصورة الذي اخترت هو ".floatval( round( $file_size / 1024 / 1024, 2 ) )." بايت<br>مرجو اختيار صورة حجمها لن يتجاوز حد المسموح وهو ".floatval( round( $allow_size / 1024 / 1024, 2 ) )." بايت");
			}
			else{
				$Template->errMsg("حدث خطأ أثناء رفع الصورة<br>نرجوا ان تقوم بإعادة عملية الرفع من جديد<br>نتأسف لهذا");
			}
		}
		else{
			$mysql->execute_insert("medalphotos", [
				'forumid' => $forumid,
				'added' => uid,
				'filename' => $result['filename'],
				'date' => time
			], __FILE__, __LINE__);
			$Template->msg("تم رفع الصورة بنجاح");
		}
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