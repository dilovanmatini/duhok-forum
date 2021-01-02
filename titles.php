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

if(_df_script=='svc'&&this_svc=='titles'&&ulv>1){
// ************ start page ****************

if(type=='lists'){
	$thisLink="svc.php?svc=titles&type=lists".(app==''?'':'&app='.app).(scope==''?'':'&scope='.scope)."&";
	?>
	<script type="text/javascript">
	var link="<?=$thisLink?>";
	DF.titleCmd=function(s,type){
		var frm=s.form,el=frm.elements,msg=new Array();
		for(x=0,y=0;x<el.length;x++){
			if(el[x].type=='checkbox'&&el[x].checked){
				y++;
			}
		}
		if(y==0){
			alert("يجب عليك ان تختار على الأقل وصف واحد");
		}
		else{
			msg['app']="موافقة على الأوصاف المختارة";
			msg['close']="قفل أوصاف المختارة";
			msg['open']="فتح أوصاف المختارة";
			if(confirm("هل أنت متأكد بأن تريد "+msg[type]+" وعددها: "+y)){
				frm.type.value=type;
				frm.submit();
			}
		}
	};
	DF.chooseForumId=function(s,app){
		fid=s.options[s.selectedIndex].value;
		if(fid==0) url="svc.php?svc=titles&type=lists&app="+app+"&scope=mod";
		else url="svc.php?svc=titles&type=lists&app="+app+"&scope=forum&f="+fid;
		document.location=url;
	};
	</script>
	<?php
	$app=(app!=''?app:'ok');
	$scope=(scope!=''?scope:'mod');
	$furl=(f>0?"&f=".f:"");
	if($app=='wait'){
		$appTitle="تنتظر الموافقة";
	}
	elseif($app=='ok'){
		$appTitle="مفتوحة";
	}
	elseif($app=='closed'){
		$appTitle="مقفولة";
	}
	else{
		$appTitle="جميع أوصاف";
	}
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asTopHeader asCenter\" colspan=\"10\">
			<ul class=\"svcbar asAS12\">
				<li class=\"selected\"><a href=\"svc.php?svc=titles&type=addlists\"><em>أضف وصف جديد</em></a></li>
			</ul>
			<ul class=\"svcbar asAS12\">
				<li><em class=\"".($scope=='forum'?'selectedone':'one')."\">
				<select class=\"asGoTo\" style=\"width:160px\" onChange=\"DF.chooseForumId(this,'$app')\">
					<option value=\"0\">&nbsp;&nbsp;&nbsp;-- عرض أوصاف منتدى --</option>";
				foreach($Template->forumsList as $key=>$val){
					echo"
					<option value=\"$key\"{$DF->choose(f,$key,'s')}>$val</option>";
				}
				echo"
				</select>
				</em></li>
				<li".($scope=='mod'?' class="selected"':'')."><a href=\"svc.php?svc=titles&type=lists&app=$app&scope=mod\"><em>المنتديات التي تشرف عليها</em></a></li>
				<li".($scope=='own'?' class="selected"':'')."><a href=\"svc.php?svc=titles&type=lists&app=$app&scope=own\"><em>أوصاف التي إضفتها أنت</em></a></li>
				<li".($scope=='all'?' class="selected"':'')."><a href=\"svc.php?svc=titles&type=lists&app=$app&scope=all\"><em>جميع أوصاف</em></a></li>
			</ul>
			<ul class=\"svcbar asAS12\">
				<li".($app=='wait'?' class="selected"':'')."><a href=\"svc.php?svc=titles&type=lists&app=wait&scope=$scope$furl\"><em>أوصاف تنتظر الموافقة</em></a></li>
				<li".($app=='ok'?' class="selected"':'')."><a href=\"svc.php?svc=titles&type=lists&app=ok&scope=$scope$furl\"><em>أوصاف مفتوحة</em></a></li>
				<li".($app=='close'?' class="selected"':'')."><a href=\"svc.php?svc=titles&type=lists&app=close&scope=$scope$furl\"><em>أوصاف مقفولة</em></a></li>
				<li".($app=='all'?' class="selected"':'')."><a href=\"svc.php?svc=titles&type=lists&app=all&scope=$scope$furl\"><em>جميع أوصاف</em></a></li>
			</ul>
			</td>
		</tr>
	<form method=\"post\" action=\"svc.php?svc=titles&type=applists\">
	<input type='hidden' name='type'>
		<tr>
			<td class=\"asHeader\" colspan=\"10\">الأوصاف - <span class=\"asC2\">$appTitle</span></td>
		</tr>
		<tr>";
		if(ulv>2){
			echo"
			<td class=\"asDarkB\"><nobr>&nbsp;</nobr></td>";
		}
			echo"
			<td class=\"asDarkB\"><nobr>الرقم</nobr></td>
			<td class=\"asDarkB\"><nobr>العنوان</nobr></td>
			<td class=\"asDarkB\"><nobr>يعرض في<br>جميع<br>المنتديات</nobr></td>
			<td class=\"asDarkB\"><nobr>الموافقة</nobr></td>
			<td class=\"asDarkB\"><nobr>المنتدى</nobr></td>
			<td class=\"asDarkB\"><nobr>أضاف<br>الوصف</nobr></td>
			<td class=\"asDarkB\">&nbsp;</td>
		</tr>";
		
	$checkSqlField="";
	$checkSqlTable="";
	if(ulv<4){
		$checkSqlField="
			,IF(".ulv." > 1 AND NOT ISNULL(m.id) OR ".ulv." = 3 AND NOT ISNULL(c.id),1,0) AS ismod
			,IF(".ulv." = 3 AND NOT ISNULL(c.id),1,0) AS ismon
		";
		$checkSqlTable="
			LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
			LEFT JOIN ".prefix."category AS c ON(c.id = f.catid AND c.monitor = ".uid.")
		";
	}
	else{
		$checkSqlField="
			,IF(NOT ISNULL(tl.id),1,0) AS ismod
			,IF(NOT ISNULL(tl.id),1,0) AS ismon
		";
	}
	
 	$sql=$mysql->query("SELECT tl.id,tl.status,tl.global,tl.subject,tl.forumid,tl.added,tl.date,
		f.subject AS fsubject,u.name AS aname,u.status AS astatus,u.level AS alevel,u.submonitor AS asubmonitor {$checkSqlField}
	FROM ".prefix."titlelists AS tl
	LEFT JOIN ".prefix."forum AS f ON(f.id = tl.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = tl.added) {$checkSqlTable}
	WHERE 1 = 1 ".checkTitleListsSql()." GROUP BY tl.id ORDER BY tl.subject ASC LIMIT {$DF->pgLimit(num_pages)},".num_pages, __FILE__, __LINE__);
	$count=0;
	$checkCount=0;
	while($rs=$mysql->fetchAssoc($sql)){
		if($rs['ismod']==1){
			$options="
			<a href=\"svc.php?svc=titles&type=editlists&t={$rs['id']}\"><img src=\"{$DFImage->i['edit']}\" alt=\"تعديل الوصف\" hspace=\"2\" border=\"0\"></a>
			<a href=\"svc.php?svc=titles&type=usetitle&t={$rs['id']}\"><img src=\"{$DFImage->i['question']}\" alt=\"استعمال الوصف\" hspace=\"2\" border=\"0\"></a>";
			if($rs['status']==1){
				$options.="
				<a href=\"svc.php?svc=titles&type=moreaward&t={$rs['id']}\"><img src=\"{$DFImage->i['users']}\" alt=\"امنح هذا الوصف لمجموعة من الأعضاء\" hspace=\"2\" border=\"0\"></a>";
			}
		}
		else{
			$options="-";
		}

		if($rs['ismon']==1&&$app!='all'){
			$checkBox="<input onClick=\"DF.checkRowClass(this,{$rs['id']});\" type=\"checkbox\" name=\"titles[]\" value=\"{$rs['id']}\">";
			$checkCount++;
		}
		else{
			$checkBox="-";
		}
		
		if($rs['status']==0){
			$checkStatus="<font color=\"green\">تنتظر</font>";
		}
		elseif($rs['status']==1){
			$checkStatus="نعم";
		}
		elseif($rs['status']==2){
			$checkStatus="<font color=\"red\">مقفل</font>";
		}
		
		$added = $Template->userColorLink($rs['added'], array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor']));
		
		echo"
		<tr id=\"row{$rs['id']}\">";
		if(ulv>2){
			echo"
			<td class=\"asNormalB asCenter\">$checkBox</td>";
		}
			echo"
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['id']}</nobr></td>
			<td class=\"asNormalB asS12\"><nobr>{$rs['subject']}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$DF->iff($rs['global']==1,'نعم','لا')}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>$checkStatus</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr><b>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</b></nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>$added</nobr></td>
			<td class=\"asNormalB asCenter\"><nobr>$options</nobr></td>
		</tr>";
		$count++;
	}
	if($count==0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"10\"><br>-- لا توجد أيه وصف بهذه المواصفات --<br><br></td>
		</tr>";
	}
	if($checkCount>0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"10\">
				{$Template->button('تحديد الكل',' onClick="DF.checkAllBox(this)"')}&nbsp;&nbsp;";
			if($app=='wait'){
				echo"
				{$Template->button('موافقة على الأوصاف المختارة'," onClick=\"DF.titleCmd(this,'app')\"")}&nbsp;&nbsp;";
			}
			if($app=='wait'||$app=='ok'){
				echo"
				{$Template->button('قفل أوصاف المختارة'," onClick=\"DF.titleCmd(this,'close')\"")}";
			}
			if($app=='close'){
				echo"
				{$Template->button('فتح أوصاف المختارة'," onClick=\"DF.titleCmd(this,'open')\"")}";
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
elseif(type=='applists'&&ulv>2){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في موافقة والقفل قوائم الأوصاف");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	$type=$_POST['type'];
	$titles=$_POST['titles'];
	if(is_array($titles)&&count($titles)>0){
		if($type=='app'){
			$checkField=1;
			$msg="تمت موافقة على الأوصاف المختارة بنجاح";
		}
		elseif($type=='close'){
			$checkField=2;
			$msg="تم قفل أوصاف المختارة بنجاح";
		}
		elseif($type=='open'){
			$checkField=1;
			$msg="تم فتح أوصاف المختارة بنجاح";
		}
		else{
			$Template->errMsg("لم يتم تخزين العملية لسبب فني.<br><br>الرجاء إخبار الإدارة لتصحيح المشكلة.");
		}
		$checkForum=(ulv==4 ? "" : "AND forumid IN (".implode(",",$DF->getAllowForumId(true)).")");
		$mysql->update("titlelists SET status = $checkField WHERE id IN (".implode(",",$titles).") $checkForum", __FILE__, __LINE__);
		$Template->msg($msg);
	}
	else{
		$Template->errMsg("لم يتم تخزين العملية لسبب فني.<br><br>الرجاء إخبار الإدارة لتصحيح المشكلة.");
	}
}
elseif(type=='addlists'){
	?>
	<script type="text/javascript">
	DF.checkSubmit=function(frm){
		if(frm.titlesubject.value.length<5){
			alert("يجب إدخال عنوان الوصف وأن يكون أطول من 5 أحرف.");
		}
		else if(frm.titleforumid.selectedIndex==0){
			alert("يجب عليك أن تختار منتدى من القائمة.");
		}
		else{
			frm.submit();
		}
	};
	</script>
	<?php
	echo"
	<table width=\"50%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form name=\"titleInfo\" method=\"post\" action=\"svc.php?svc=titles&type=insertlists\">
	<input type=\"hidden\" name=\"redeclare\" value=\"".rand."\">
		<tr>
			<td class=\"asHeader\" colspan=\"4\"><nobr>أضف وصف جديد</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عنوان</nobr></td>
			<td class=\"asNormalB\" colspan=\"3\"><input type=\"text\" style=\"width:400px;\" name=\"titlesubject\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>المنتدى</nobr></td>
			<td class=\"asNormalB\" colspan=\"3\">
			<select class=\"asGoTo\" name=\"titleforumid\">
				<option value=\"0\">-- اختر منتدى --</option>";
			$forumSql=(ulv==4 ? "" : "WHERE f.id IN (".implode(",",$DF->getAllowForumId(true)).")");
			$sql=$mysql->query("SELECT f.id,f.subject FROM ".prefix."forum AS f LEFT JOIN ".prefix."category AS c ON(c.id = f.catid)
			$forumSql GROUP BY f.id ORDER BY c.sort,f.sort ASC", __FILE__, __LINE__);
			while($rs=$mysql->fetchRow($sql)){
				echo"
				<option value=\"$rs[0]\">$rs[1]</option>";
			}
			echo"
			</select>
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عرض وصف</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"0\" name=\"titleglobal\" checked>يظهر في منتداه فقط</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"2\"><nobr><input type=\"radio\" value=\"1\" name=\"titleglobal\">يظهر في جميع المنتديات</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>وضعية وصف</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"0\" name=\"titlestatus\"".(ulv==2?'checked':'').">الوصف ينتظر موافقة المراقب</nobr></td>
			<td class=\"asNormalB asS12\"".(ulv==2?' colspan=\"2\"':'')."><nobr><input type=\"radio\" value=\"2\" name=\"titlestatus\">الوصف مقفول</nobr></td>";
		if(ulv>2){
			echo"
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"1\" name=\"titlestatus\" checked>الوصف حي</nobr></td>";
		}
		echo"
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
elseif(type=='insertlists'){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في إضافة وصف جديد للمنتدى");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	
	$redeclare=(int)$_POST['redeclare'];
	$subject=$DF->cleanText($_POST['titlesubject']);
	$forumid=(int)$_POST['titleforumid'];
	$global=(int)$_POST['titleglobal'];
	$status=(int)$_POST['titlestatus'];
	
	if($redeclare!=checkredeclare){
		$Template->errMsg("كان هناك خلل أثناء تخزين العملية!<br>يبدو أنه تم محاولة إدخال البيانات عدة مرات لسبب فني أو لخلل في الشبكة.<br>الرجاء التأكد من أن العملية انتهت بنجاح... نأسف على هذا.");
	}

	$forums=$DF->getAllowForumId();
	if(empty($subject)){
		$Template->errMsg("يجب إدخال عنوان الوصف وأن يكون أطول من 5 أحرف.");
	}
	elseif($forumid==0){
		$Template->errMsg("يجب عليك أن تختار منتدى من القائمة.");
	}
	elseif(ulv<4&&!in_array($forumid,$forums)){
		$Template->errMsg("منتدى الذي اخترت لا يسمح لك بإضافة وصف لها.");
	}
	else{
		$mysql->insert("titlelists (forumid,status,subject,global,added,date) VALUES
		('$forumid','$status','$subject','$global','".uid."','".time."')", __FILE__, __LINE__);
		$link=array('wait','ok','close');
		$Template->msg((ulv>2 ? "تم إضافة وصف للمنتدى بنجاح" : "تم إضافة وصف للمنتدى لكن بحاجة لموافقة مراقب"),"svc.php?svc=titles&type=lists&app=$link[$status]&scope=mod");
	}
}
elseif(type=='editlists'){
	$rs=$mysql->queryAssoc("SELECT tl.forumid,tl.status,tl.subject,tl.global,f.subject AS fsubject
	FROM ".prefix."titlelists AS tl
	LEFT JOIN ".prefix."forum AS f ON(f.id = tl.forumid)
	WHERE tl.id = '".t."'", __FILE__, __LINE__);
	$forums=$DF->getAllowForumId();
	if(!$rs||ulv<4&&!in_array($rs['forumid'],$forums)){
		$DF->goTo();
		exit();
	}
	?>
	<script type="text/javascript">
	DF.checkSubmit=function(frm){
		if(frm.titlesubject.value.length<5){
			alert("يجب إدخال عنوان الوصف وأن يكون أطول من 5 أحرف.");
		}
		else{
			frm.submit();
		}
	};
	</script>
	<?php
	echo"
	<table width=\"50%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form method=\"post\" action=\"svc.php?svc=titles&type=updatelists\">
	<input type=\"hidden\" name=\"titleid\" value=\"".t."\">
		<tr>
			<td class=\"asHeader\" colspan=\"4\"><nobr>تعديل الوصف</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عنوان</nobr></td>
			<td class=\"asNormalB\" colspan=\"3\"><input type=\"text\" style=\"width:400px;\" name=\"titlesubject\" value=\"{$rs['subject']}\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>المنتدى</nobr></td>
			<td class=\"asNormalB asAS12\" colspan=\"3\">{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</td>
		</tr>";
	if(ulv>2){
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>عرض وصف</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"0\" name=\"titleglobal\"{$DF->choose($rs['global'],0,'c')}>يظهر في منتداه فقط</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"2\"><nobr><input type=\"radio\" value=\"1\" name=\"titleglobal\"{$DF->choose($rs['global'],1,'c')}>يظهر في جميع المنتديات</nobr></td>
		</tr>";
	}
	if($rs['status']>0){
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>وضعية وصف</nobr></td>
			<td class=\"asNormalB asS12\"><nobr><input type=\"radio\" value=\"2\" name=\"titlestatus\"{$DF->choose($rs['status'],2,'c')}>الوصف مقفول</nobr></td>
			<td class=\"asNormalB asS12\" colspan=\"2\"><nobr><input type=\"radio\" value=\"1\" name=\"titlestatus\"{$DF->choose($rs['status'],1,'c')}>الوصف حي</nobr></td>
		</tr>";
	}
	else{
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>وضعية وصف</nobr></td>
			<td class=\"asNormalB asS12 asCenter\" colspan=\"3\"><nobr><font color=\"green\">تنتظر الموافقة</font></nobr><input type=\"hidden\" name=\"titlestatus\" value=\"{$rs['status']}\"></td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"4\">
				{$Template->button("أدخل التغييرات"," onClick=\"DF.checkSubmit(this.form)\"")}&nbsp;&nbsp;
				{$Template->button("إلغاء التغييرات"," type=\"reset\"")}
			</td>
		</tr>
	</form>
	</table>";
}
elseif(type=='updatelists'){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في تعديل قوائم أوصاف");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	$t=(int)$_POST['titleid'];
	$subject=$DF->cleanText($_POST['titlesubject']);
	$status=(int)$_POST['titlestatus'];
	$global=(int)$_POST['titleglobal'];
	$forumid=$mysql->get("titlelists","forumid",$t);
	$forums=$DF->getAllowForumId();
	if(empty($subject)){
		$Template->errMsg("يجب إدخال عنوان الوصف وأن يكون أطول من 5 أحرف.");
	}
	elseif(ulv<4&&!in_array($forumid,$forums)){
		$Template->errMsg("لا يسمح لك بتعديل هذا الوصف");
	}
	else{
		$mysql->update("titlelists SET
			status = '$status',".(ulv>2 ? "global = '$global'," : "")."subject = '$subject'
		WHERE id = '$t'", __FILE__, __LINE__);
		$Template->msg("تم تعديل الوصف بنجاح");
	}
}
elseif(type=='awardforums'){
	$rs=$mysql->queryRow("SELECT name FROM ".prefix."user WHERE id = '".u."' AND status IN (0,1)", __FILE__, __LINE__);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	echo"
	<table width=\"40%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader asAC2\" colspan=\"3\">إختار المنتدى الذي تريد إضافة وصف منه للعضو: {$Template->userNormalLink(u,$rs[0])}</td>
		</tr>
		<tr>
			<td class=\"asDarkB\">&nbsp;</td>
			<td class=\"asDarkB\"><nobr>اسم المنتدى</nobr></td>
			<td class=\"asDarkB\" width=\"1%\">عدد<br>أوصاف</td>
		</tr>";
	$checkForum=(ulv==4 ? "" : "AND f.id IN (".implode(",",$DF->getAllowForumId(true)).")");
	$sql=$mysql->query("SELECT f.id,f.subject,COUNT(tl.id) AS titles
	FROM ".prefix."forum AS f
	LEFT JOIN ".prefix."titlelists AS tl ON(tl.forumid = f.id AND tl.status = 1)
	LEFT JOIN ".prefix."category AS c ON(c.id = f.catid)
	WHERE f.id > 0 $checkForum GROUP BY f.id ORDER BY c.sort,f.sort ASC", __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\"><nobr>".($count+1)."</nobr></td>
			<td class=\"asNormalB\"><a href=\"svc.php?svc=titles&type=award&u=".u."&f={$rs['id']}\"><nobr>{$rs['subject']}</nobr></a></td>
			<td class=\"asNormalB asCenter\"><nobr>{$rs['titles']}</nobr></td>
		</tr>";
		$count++;
	}
	if($count==0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"3\"><br>لا توجد أي منتدى<br><br></td>
		</tr>";
	}
	echo"
	</table>";
}
elseif(type=='award'){
	$rs=$mysql->queryRow("SELECT name FROM ".prefix."user WHERE id = '".u."' AND status IN (0,1)", __FILE__, __LINE__);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	
	$forums=$DF->getAllowForumId();
	if(ulv<4&&!in_array(f,$forums)){
		$DF->goTo();
		exit();
	}
	
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader asAC2\" colspan=\"7\">إختار وصف من القائمة أدناه لإضافته للعضو: {$Template->userNormalLink(u,$rs[0])}</td>
		</tr>
		<tr>
			<td class=\"asDarkB\"><nobr>الرقم</nobr></td>
			<td class=\"asDarkB\"><nobr>العنوان</nobr></td>
			<td class=\"asDarkB\"><nobr>يعرض في<br>جميع<br>المنتديات</nobr></td>
			<td class=\"asDarkB\"><nobr>المنتدى</nobr></td>
			<td class=\"asDarkB\">الخيارات</td>
		</tr>";
	$sql=$mysql->query("SELECT tl.id,tl.subject,tl.global,f.subject AS fsubject
	FROM ".prefix."titlelists AS tl
	LEFT JOIN ".prefix."forum AS f ON(f.id = tl.forumid)
	WHERE tl.forumid = '".f."' AND tl.status = 1 ORDER BY tl.subject ASC", __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		echo"
		<tr>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['id']}</nobr></td>
			<td class=\"asNormalB asS12\"><nobr>{$rs['subject']}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$DF->iff($rs['global']==1,'نعم','لا')}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>{$Template->forumLink(f,$rs['fsubject'])}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr><a href=\"svc.php?svc=titles&type=insertaward&u=".u."&t={$rs['id']}&defredeclare=".rand."\">- إختار الوصف -</a></nobr></td>
		</tr>";
		$count++;
	}
	if($count==0){
		echo"
		<tr>
			<td class=\"asNormalB asS12 asCenter\" colspan=\"7\"><br>لا توجد أي أوصاف لهذا المنتدى<br><br></td>
		</tr>";
	}
	echo"
	</table>";
}
elseif(type=='insertaward'){
	$rs=$mysql->queryRow("SELECT id FROM ".prefix."user WHERE id = '".u."' AND status IN (0,1)", __FILE__, __LINE__);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	
	$checkForum=(ulv==4 ? "" : "AND forumid IN (".implode(",",$DF->getAllowForumId(true)).")");
	$rs=$mysql->queryRow("SELECT id FROM ".prefix."titlelists WHERE id = '".t."' AND status = 1 $checkForum", __FILE__, __LINE__);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	
	$count=$DFOutput->count("title WHERE listid = '".t."' AND userid = '".u."' AND status = 1");
	if($count>0){
		$Template->errMsg("لا يمكنك إضافة هذا الوصف لهذا العضو<br>بسبب ان الوصف الذي اخترت هو موجود بلائحة أوصاف هذا العضو");
		exit();
	}
	
	if(defredeclare!=checkredeclare){
		$Template->errMsg("كان هناك خلل أثناء تخزين العملية!<br>يبدو أنه تم محاولة إدخال البيانات عدة مرات لسبب فني أو لخلل في الشبكة.<br>الرجاء التأكد من أن العملية انتهت بنجاح... نأسف على هذا.");
	}
	
	$mysql->insert("title (listid,userid) VALUES ('".t."','".u."')", __FILE__, __LINE__);
	$mysql->insert("titleuse (listid,userid,added,date) VALUES ('".t."','".u."','".uid."','".time."')", __FILE__, __LINE__);
	$Template->msg("تم إضافة وصف المختار للعضو بنجاح","profile.php?u=".u);
}
elseif(type=='usertitles'){
	$rs=$mysql->queryRow("SELECT name FROM ".prefix."user WHERE id = '".u."' AND status IN (0,1)", __FILE__, __LINE__);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader asAC2\" colspan=\"5\">الأوصاف الحالية للعضو: {$Template->userNormalLink(u,$rs[0])}</td>
		</tr>
		<tr>
			<td class=\"asDarkB\"><nobr>الرقم</nobr></td>
			<td class=\"asDarkB\"><nobr>العنوان</nobr></td>
			<td class=\"asDarkB\"><nobr>يعرض في<br>جميع<br>المنتديات</nobr></td>
			<td class=\"asDarkB\"><nobr>المنتدى</nobr></td>
			<td class=\"asDarkB\">الخيارات</td>
		</tr>";
	$checkSqlField="";
	$checkSqlTable="";
	if(ulv<4){
		$checkSqlField="
			,IF(".ulv." > 1 AND NOT ISNULL(m.id) OR ".ulv." = 3 AND NOT ISNULL(c.id),1,0) AS ismod
			,IF(".ulv." = 3 AND NOT ISNULL(c.id),1,0) AS ismon
		";
		$checkSqlTable="
			LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
			LEFT JOIN ".prefix."category AS c ON(c.id = f.catid AND c.monitor = ".uid.")
		";
	}
	else{
		$checkSqlField="
			,IF(NOT ISNULL(t.id),1,0) AS ismod
			,IF(NOT ISNULL(t.id),1,0) AS ismon
		";
	}
	$sql=$mysql->query("SELECT t.id,t.listid,tl.forumid,tl.subject,tl.global,f.subject AS fsubject $checkSqlField
	FROM ".prefix."title AS t
	LEFT JOIN ".prefix."titlelists AS tl ON(tl.id = t.listid)
	LEFT JOIN ".prefix."forum AS f ON(f.id = tl.forumid) $checkSqlTable
	WHERE t.userid = '".u."' AND t.status = 1 ORDER BY tl.subject ASC", __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		echo"
		<tr>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['id']}</nobr></td>
			<td class=\"asNormalB asS12\"><nobr>{$rs['subject']}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$DF->iff($rs['global']==1,'نعم','لا')}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</nobr></td>
			<td class=\"asNormalB asCenter\"><nobr>
				<a href=\"svc.php?svc=titles&type=history&u=".u."&t={$rs['listid']}\"><img src=\"{$DFImage->i['question']}\" alt=\"تاريخ استخدام الوصف للعضو\" hspace=\"2\" border=\"0\"></a>";
			if($rs['ismod']==1){
				echo"
				<a href=\"svc.php?svc=titles&type=delete&u=".u."&t={$rs['id']}\"><img src=\"{$DFImage->i['delete']}\" alt=\"إزالة الوصف من العضو\" hspace=\"2\" border=\"0\"></a>";
			}
			echo"
			</nobr></td>
		</tr>";
		$count++;
	}
	if($count==0){
		echo"
		<tr>
			<td class=\"asNormalB asS12 asCenter\" colspan=\"5\"><br>لا توجد أي أوصاف لهذا العضو<br><br></td>
		</tr>";
	}
	echo"
	</table>";
}
elseif(type=='history'){
	$rs=$mysql->queryRow("SELECT tl.subject,u.name
	FROM ".prefix."titlelists AS tl
	LEFT JOIN ".prefix."user AS u ON(u.id = '".u."')
	WHERE tl.id = '".t."' AND u.id = '".u."' AND u.status IN (0,1)", __FILE__, __LINE__);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader asAC2\" colspan=\"3\"><nobr>تاريخ إستخدام الوصف: <span class=\"asC2\">$rs[0]</span> - للعضو: {$Template->userNormalLink(u,$rs[1])}</nobr></td>
		</tr>
		<tr>
			<td class=\"asDark\"><nobr>التاريخ والوقت</nobr></td>
			<td class=\"asDark\"><nobr>العملية</nobr></td>
			<td class=\"asDark\"><nobr>قام بالعملية</nobr></td>
		</tr>";
	$sql=$mysql->query("SELECT tu.status,tu.added,tu.date,u.name AS aname,u.status AS astatus,u.level AS alevel,u.submonitor AS asubmonitor
	FROM ".prefix."titleuse AS tu
	LEFT JOIN ".prefix."user AS u ON(u.id = tu.added)
	WHERE tu.listid = '".t."' AND tu.userid = '".u."' ORDER BY tu.date ASC", __FILE__, __LINE__);
	while($rs=$mysql->fetchAssoc($sql)){
		echo"
		<tr>
			<td class=\"asNormalB asS12 asDate asCenter\"><nobr>{$DF->date($rs['date'],'date',true)}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$DF->iff($rs['status']==1,'منح الوصف','<font color="red">إزالة وصف</font>')}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>{$Template->userColorLink($rs['added'], array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor']))}</nobr></td>
		</tr>";
	}
	echo"
	</table>";
}
elseif(type=='delete'){
	$checkSqlField="";
	$checkSqlTable="";
	if(ulv<4){
		$checkSqlField="
			,IF(".ulv." > 1 AND NOT ISNULL(m.id) OR ".ulv." = 3 AND NOT ISNULL(c.id),1,0) AS ismod
			,IF(".ulv." = 3 AND NOT ISNULL(c.id),1,0) AS ismon
		";
		$checkSqlTable="
			LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
			LEFT JOIN ".prefix."category AS c ON(c.id = f.catid AND c.monitor = ".uid.")
		";
	}
	else{
		$checkSqlField="
			,IF(NOT ISNULL(t.id),1,0) AS ismod
			,IF(NOT ISNULL(t.id),1,0) AS ismon
		";
	}
	$rs=$mysql->queryAssoc("SELECT t.listid,IF(NOT ISNULL(u.id),1,0) AS user $checkSqlField
	FROM ".prefix."title AS t
	LEFT JOIN ".prefix."titlelists AS tl ON(tl.id = t.listid)
	LEFT JOIN ".prefix."forum AS f ON(f.id = tl.forumid)
	LEFT JOIN ".prefix."user AS u ON(t.userid = '".u."' AND u.status IN (0,1)) $checkSqlTable
	WHERE t.id = '".t."'", __FILE__, __LINE__);
	if(!$rs||$rs['user']==0||$rs['ismod']==0){
		$Template->errMsg("لا عندك تصريح لحذف هذا الوصف<br>مرجو عدم تكرار هذه العملية");
		exit();
	}
	$mysql->insert("titleuse (listid,userid,status,added,date) VALUES ('{$rs['listid']}','".u."','0','".uid."','".time."')", __FILE__, __LINE__);
	$mysql->update("title SET status = 0 WHERE id = '".t."'", __FILE__, __LINE__);
	$Template->msg("تم حذف الوصف بنجاح");
}
elseif(type=='usetitle'){
	$titleSubject=$mysql->queryRow("SELECT subject FROM ".prefix."titlelists WHERE id = '".t."'", __FILE__, __LINE__);
	if(!$titleSubject){
		$DF->goTo();
		exit();
	}
	$checkSqlField="";
	$checkSqlTable="";
	if(ulv<4){
		$checkSqlField="
			,IF(".ulv." > 1 AND NOT ISNULL(m.id) OR ".ulv." = 3 AND NOT ISNULL(c.id),1,0) AS ismod
			,IF(".ulv." = 3 AND NOT ISNULL(c.id),1,0) AS ismon
		";
		$checkSqlTable="
			LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
			LEFT JOIN ".prefix."category AS c ON(c.id = f.catid AND c.monitor = ".uid.")
		";
	}
	else{
		$checkSqlField="
			,IF(NOT ISNULL(t.id),1,0) AS ismod
			,IF(NOT ISNULL(t.id),1,0) AS ismon
		";
	}
	$sql=$mysql->query("SELECT t.id,t.status,t.userid,u.name AS uname,u.status AS ustatus,u.level AS ulevel,u.submonitor AS usubmonitor
	FROM ".prefix."title AS t
	LEFT JOIN ".prefix."user AS u ON(u.id = t.userid)
	LEFT JOIN ".prefix."titlelists AS tl ON(tl.id = t.listid)
	LEFT JOIN ".prefix."forum AS f ON(f.id = tl.forumid)
	WHERE t.listid = '".t."' ORDER BY t.id DESC,t.userid DESC", __FILE__, __LINE__);
	while($rs=$mysql->fetchAssoc($sql)){
		if($rs['status']==1){
			$flagTitles.="
			<tr>
				<td class=\"asNormalB asAS12 asCenter\"><nobr>{$Template->userColorLink($rs['userid'], array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor']))}</nobr></td>
				<td class=\"asNormalB asCenter\">
					<nobr>
					<a href=\"svc.php?svc=titles&type=history&u={$rs['userid']}&t=".t."\"><img src=\"{$DFImage->i['question']}\" alt=\"تاريخ استخدام الوصف للعضو\" hspace=\"2\" border=\"0\"></a>";
				if($rs['ismod']==0){
					$flagTitles.="
					<a href=\"svc.php?svc=titles&type=delete&u={$rs['userid']}&t={$rs['id']}\"><img src=\"{$DFImage->i['delete']}\" alt=\"إزالة الوصف من العضو\" hspace=\"2\" border=\"0\"></a>";
				}
					$flagTitles.="
					</nobr>
				</td>
			</tr>";
		}
		else{
			$unflagTitles.="
			<tr>
				<td class=\"asNormalB asAS12 asCenter\"><nobr>{$Template->userColorLink($rs['userid'], array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor']))}</nobr></td>
				<td class=\"asNormalB asCenter\"><nobr><a href=\"svc.php?svc=titles&type=history&u={$rs['userid']}&t=".t."\"><img src=\"{$DFImage->i['question']}\" alt=\"تاريخ استخدام الوصف للعضو\" hspace=\"2\" border=\"0\"></a></nobr></td>
			</tr>";
		}
	}
	
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\" border=\"0\">
		<tr>
			<td class=\"asHeader\" colspan=\"2\"><nobr>إستخدام الوصف: <span class=\"asC2\">$titleSubject[0]</span></nobr><br></td>
		</tr>";
	if(!empty($flagTitles)){
		echo"
		<tr>
			<td class=\"asDarkB\" colspan=\"2\"><nobr>الأعضاء الذين لهم هذا الوصف حاليا</nobr></td>
		</tr>".$flagTitles;
	}
	if(!empty($unflagTitles)){
		echo"
		<tr>
			<td class=\"asDarkB\" colspan=\"2\"><nobr>الأعضاء الذين وضع لهم هذا الوصف سابقا</nobr></td>
		</tr>".$unflagTitles;
	}
	if(empty($flagTitles)&&empty($unflagTitles)){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"2\"><br>لم يتم إستخدام هذا الوصف<br><br></td>
		</tr>";
	}
	echo"
	</table>";
}
elseif(type=='moreaward'){
	$checkForum=(ulv==4 ? "" : "AND tl.forumid IN (".implode(",",$DF->getAllowForumId(true)).")");
	$sql=$mysql->query("SELECT tl.subject,tl.global,tl.forumid,f.subject AS fsubject
	FROM ".prefix."titlelists AS tl
	LEFT JOIN ".prefix."forum AS f ON(f.id = tl.forumid)
	WHERE tl.id = '".t."' AND tl.status = 1 $checkForum", __FILE__, __LINE__);
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
			alert("توجد أرقام عضويات الذي تريد أضف لهم هذا الوصف في خانة رقم العضوية\nلذا يجب عليك إضافتها الى القائمة حتى لا تخسر منها\nاو امسحها اذا لا تريد أضف لهم هذا الوصف");
		}
		else if(usersIds.length==0){
			alert("أنت لم أضفت أي رقم للقائمة ليتم إضافة وصف لهم");
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
		if(tab.rows.length==1){
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
		if(dbArr.length==0){
			tab.deleteRow(1);
		}
		var tr=tab.insertRow(tab.rows.length);
		tr.id=type+'Row'+id;
		var td1=tr.insertCell(0);
		td1.innerHTML=id;
		td1.className='asNormalB asS12 asCenter';
		var td2=tr.insertCell(1);
		td2.innerHTML='<a href="javascript:DF.deleteUserIdFromList('+id+',\''+type+'\');"><img src="'+deleteIconUrl+'" alt="حذف رقم من القائمة" hspace="6" border="0"></a>';
		td2.className='asNormalB asS12 asCenter';
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
			<td class=\"asHeader\" colspan=\"4\">أضف وصف الأدناه لمجموعة من الأعضاء</td>
		</tr>
		<tr>
			<td class=\"asDarkB\"><nobr>الرقم</nobr></td>
			<td class=\"asDarkB\"><nobr>العنوان</nobr></td>
			<td class=\"asDarkB\"><nobr>يعرض في<br>جميع<br>المنتديات</nobr></td>
			<td class=\"asDarkB\"><nobr>المنتدى</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB asS12 asCenter\"><nobr>".t."</nobr></td>
			<td class=\"asNormalB asS12\"><nobr>{$rs['subject']}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\" align=\"center\"><nobr>{$DF->iff($rs['global']==1,'نعم','لا')}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\" align=\"center\"><nobr>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB asS12 asCenter\" colspan=\"4\">ملاحظة: العضويات التي يملك هذا الوصف من قبل, فلا نقوم<br>بإضافة هذا الوصف لهم حتى اذا أرقام عضوياتهم موجودة بالقائمة.</td>
		</tr>
		<form method=\"post\" action=\"svc.php?svc=titles&type=insertmoreaward\">
		<input type=\"hidden\" name=\"titleid\" value=\"".t."\">
		<input type=\"hidden\" name=\"redeclare\" value=\"".rand."\">
		<tr>
			<td class=\"asNormalB asS12 asCenter\" colspan=\"4\">
				<textarea style=\"display:none\" name=\"users\"></textarea><br>
				<input type=\"text\" style=\"width:150px;text-align:center\" id=\"usersNum\" name=\"usersNum\" value=\"0\" dir=\"ltr\"><br>
				{$Template->button('أضف رقم الى القائمة'," onClick=\"DF.addUserIdToList('users')\"")}
				<br><br><hr width=\"90%\">ملاحظة: اذا تريد ان تضاف اكثر من رقم اكتب ارقام هكذا <span dir=\"ltr\">1,2,3,4</span><hr width=\"90%\"><br>
				<table id=\"usersTable\" width=\"40%\" cellpadding=\"4\">
					<tr>
						<td class=\"asDarkB\" colspan=\"2\">قائمة أرقام عضويات التي تريد ان تضاف لهم وصف الأعلاه</td>
					</tr>
					<tr>
						<td class=\"asNormalB asS12 asCenter\"><br>لم يتم إضافة أي رقم للقائمة.<br><br></td>
					</tr>
				</table>
				<br>تنبيه: أرقام العضويات التي في قائمة أعلاه هي مؤقتة وبتحديث الصفحة سيتم تصفيرها.<br><br>
			</td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"4\">{$Template->button('أضف وصف',' onClick="DF.checkSubmit(this.form)"')}</td>
		</tr>
		</form>
	</table>";
}
elseif(type=='insertmoreaward'){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في أضاف الوصف لمجموعة من الأعضاء");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	
	$redeclare=(int)$_POST['redeclare'];
	$titleid=(int)$_POST['titleid'];
	$users=$DF->cleanText($_POST['users']);
	
	$checkForum=(ulv==4 ? "" : "AND forumid IN (".implode(",",$DF->getAllowForumId(true)).")");
	$rs=$mysql->queryRow("SELECT id FROM ".prefix."titlelists WHERE id = '$titleid' AND status = 1 $checkForum", __FILE__, __LINE__);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	
	if($redeclare!=checkredeclare){
		$Template->errMsg("كان هناك خلل أثناء تخزين العملية!<br>يبدو أنه تم محاولة إدخال البيانات عدة مرات لسبب فني أو لخلل في الشبكة.<br>الرجاء التأكد من أن العملية انتهت بنجاح... نأسف على هذا.");
		exit();
	}

	if(!empty($users)){
		$sql=$mysql->query("SELECT u.id,IF(NOT ISNULL(t.id),1,0) AS awarded
		FROM ".prefix."user AS u
		LEFT JOIN ".prefix."title AS t ON(t.userid = u.id AND t.listid = '$titleid' AND t.status = 1)
		WHERE u.id IN ($users) AND u.status = 1 HAVING awarded = 0", __FILE__, __LINE__);
		while($rs=$mysql->fetchRow($sql)){
			$mysql->insert("title (listid,userid) VALUES ('$titleid','$rs[0]')", __FILE__, __LINE__);
			$mysql->insert("titleuse (listid,userid,added,date) VALUES ('$titleid','$rs[0]','".uid."','".time."')", __FILE__, __LINE__);
		}
	}
	
	$Template->msg("تم إضافة وصف للأعضاء المختارة بنجاح","svc.php?svc=titles&type=usetitle&t=$titleid");
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