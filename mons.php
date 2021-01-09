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

if(_df_script == 'svc'&&this_svc == 'mons'&&ulv > 1){
// ************ start page ****************

$montype=array(
	1=>'monforum',
	2=>'monallforum',
	3=>'forbidforum',
	4=>'forbidallforum',
	5=>'forbidpm',
	6=>'hidephoto',
	7=>'hidesignature',
	8=>'hidedetails',
	9=>'lockuser'
);
$montypestr=array(
	'monforum'=>'رقابة في منتدى معين',
	'monallforum'=>'رقابة في جميع منتديات',
	'forbidforum'=>'منع في منتدى معين',
	'forbidallforum'=>'منع في جميع منتديات',
	'forbidpm'=>'منع إرسال رسائل خاصة',
	'hidephoto'=>'إخفاء صورة الشخصية',
	'hidesignature'=>'إخفاء توقيع العضوية',
	'hidedetails'=>'إخفاء تفاصيل العضوية',
	'lockuser'=>'قفل العضوية'
);
$monstatusstr=array(
	'<font color="green">تنتظر موافقة</font>',
	'موجود حالياً',
	'<font color="darkorange">تم رفع</font>',
	'<font color="red">تم رفض</font>'
);
$posttype=array(
	'other'=>0,
	'post'=>1,
	'topic'=>2,
	'pm'=>3
);
$userpermnums=array(2,4,5,6,7,8);
$userpermfields=array(
	2=>'postsundermon',
	4=>'stopaddpost',
	5=>'stopsendpm',
	6=>'hidephoto',
	7=>'hidesignature',
	8=>'hideselfprofile'
);

if(type == 'global'||type == 'addmon'){
?>
<script type="text/javascript">
DF.hideMonDetails=function(id){
	var tab=$I('#monTable'),expImg=$I('#expand'+id),conImg=$I('#contract'+id),thisRow=$I('#row'+id);
	tab.deleteRow(thisRow.rowIndex+1);
	conImg.style.top='2px';
	conImg.style.left='2px';
	conImg.style.visibility='hidden';
	conImg.style.position='absolute';
	expImg.style.visibility='visible';
	expImg.style.position='';
};
DF.getMonDetails=function(id){
	var tab=$I('#monTable'),expImg=$I('#expand'+id),conImg=$I('#contract'+id),thisRow=$I('#row'+id);
	DF.ajax.play({
		'send':'type=getMonDetails&id='+id,
		'func':function(){
			var obj=DF.ajax.oName,ac=DF.ajax.ac;
			if(obj.readyState == 1){
				var row=tab.insertRow(thisRow.rowIndex+1),cell=row.insertCell(0);
				cell.id='moncell'+id;
				cell.className='asNormalB asCenter';
				cell.colSpan=11;
				cell.innerHTML='<br><img src="'+progressUrl+'" border="0"><br><br>رجاً انتظر...<br><br>';
				expImg.style.top='2px';
				expImg.style.left='2px';
				expImg.style.visibility='hidden';
				expImg.style.position='absolute';
				conImg.style.visibility='visible';
				conImg.style.position='';
			}
			else if(obj.readyState == 4){
				var get=obj.responseText.split(ac),cell=$I('#moncell'+id),text,targetLink;
				if(get&&get.length>2){
					if(get[1] == 1) targetLink="topics.php?t="+get[4]+"&p="+get[0];
					else if(get[1] == 2) targetLink="topics.php?t="+get[0];
					else if(get[1] == 3) targetLink="pm.php?mail=read&pm="+get[0];
					text="<br><table width=\"95%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">"+
					"<tr>"+
					"<td class=\"asDarkB\">السبب (تم إرسال هذه الرسالة للعضو)</td>"+
					"</tr>"+
					"<tr>"+
					"<td class=\"asFixedB\">"+get[2];
					if(get[1]>0) text+="<br><br><div align=\"center\"><a href=\""+targetLink+"\">** إضغط هنا لمشاهدة المشاركة المعنية **</a></div><br>";
					text+="</td>"+
					"</tr>"+
					"<tr>"+
					"<td class=\"asDarkB\"><b>ملاحظة إشرافية</b></td>"+
					"</tr>"+
					"<tr>"+
					"<td class=\"asFixedB\">"+get[3]+"</td>"+
					"</tr>"+
					"</table><br>";
					cell.innerHTML=text;
				}
				else{
					cell.innerHTML='<br><img src="'+errorUrl+'" border="0"><br><br><font color="red">حدث خطأ أثناء العملية<br>مرجوا إعادتها من جديد</font><br><br>';
				}
			}
		}
	});
};
</script>
<?php
}

if(type == 'global'){
	$app=(app!=''?app:'ok');
	$scope=(scope!=''?scope:'mod');
	$days=(days!=0?days:30);
	$appurl=(app!=''?'&app='.app:'');
	$scopeurl=(scope!=''?'&scope='.scope:'');
	$daysurl=(days!=0?'&days='.days:'');
	$furl=(f>0?'&f='.f:'');
	$uurl=(u>0?'&u='.u:'');
	$murl=(m>0?'&m='.m:'');
	$querystring="$furl$uurl$murl";
	$thisLink="svc.php?svc=mons&type=global$appurl$scopeurl$daysurl$querystring&";
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
			alert("يجب عليك ان تختار على الأقل عقوبة واحدة");
		}
		else{
			msg['app']="موافقة على عقوبات المختارة";
			msg['up']="رفع عقوبات المختارة";
			msg['ref']="رفض عقوبات المختارة";
			if(confirm("هل أنت متأكد بأن تريد "+msg[type]+" وعددها: "+y)){
				frm.type.value=type;
				frm.submit();
			}
		}
	};
	DF.chooseForumId=function(s,app,days){
		fid=s.options[s.selectedIndex].value;
		if(fid == 0) url="svc.php?svc=mons&type=global&app="+app+"&scope=mod&days="+days+"<?=$murl.$uurl?>";
		else url="svc.php?svc=mons&type=global&app="+app+"&scope=forum&days="+days+"&f="+fid+"<?=$murl.$uurl?>";
		document.location=url;
	};
	DF.chooseMonId=function(s,app,days){
		mid=s.options[s.selectedIndex].value;
		if(mid == 0) url="svc.php?svc=mons&type=global&app="+app+"&scope=mod&days="+days+"<?=$furl.$uurl?>";
		else url="svc.php?svc=mons&type=global&app="+app+"&scope=montype&days="+days+"&m="+mid+"<?=$furl.$uurl?>";
		document.location=url;
	};
	</script>
	<?php
	if($app == 'wait'){
		$appTitle="عقوبات تنتظر الموافقة";
	}
	elseif($app == 'ok'){
		$appTitle="عقوبات موجودة حالياً";
	}
	elseif($app == 'up'){
		$appTitle="عقوبات تم رفعها";
	}
	elseif($app == 'ref'){
		$appTitle="عقوبات تم رفضها";
	}
	else{
		$appTitle="جميع عقوبات";
	}
	
	echo"
	<table id=\"monTable\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asTopHeader asCenter\" colspan=\"11\">
	<ul class=\"svcbar asAS12\">
		<li><em class=\"".($scope == 'montype'?'selectedone':'one')."\">
		<select class=\"asGoTo\" style=\"width:145px\" onChange=\"DF.chooseMonId(this,'$app',$days)\">
			<option value=\"0\">&nbsp;&nbsp;-- عرض عقوبة معينة --</option>";
		$arrindex=0;
		foreach($montypestr as $val){
			$arrindex++;
			echo"
			<option value=\"$arrindex\"{$DF->choose(m,$arrindex,'s')}>$val</option>";
		}
		echo"
		</select>
		</em></li>
		<li><em class=\"".($scope == 'forum'?'selectedone':'one')."\">
		<select class=\"asGoTo\" style=\"width:150px\" onChange=\"DF.chooseForumId(this,'$app',$days)\">
			<option value=\"0\">&nbsp;&nbsp;-- عرض عقوبات منتدى --</option>";
		foreach($Template->forumsList as $key=>$val){
			echo"
			<option value=\"$key\"{$DF->choose(f,$key,'s')}>$val</option>";
		}
		echo"
		</select>
		</em></li>
		<li".($scope == 'mod'?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=mod&app=$app&days=$days$querystring\"><em>المنتديات التي تشرف عليها</em></a></li>
		<li".($scope == 'own'?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=own&app=$app&days=$days$querystring\"><em>عقوبات التي طبقتها أنت</em></a></li>
		<li".($scope == 'all'?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=all&app=$app&days=$days$querystring\"><em>جميع عقوبات</em></a></li>
	</ul>
	<ul class=\"svcbar asAS12\">
		<li".($app == 'wait'?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=$scope&app=wait&days=$days$querystring\"><em>عقوبات تنتظر الموافقة</em></a></li>
		<li".($app == 'ok'?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=$scope&app=ok&days=$days$querystring\"><em>عقوبات موجودة حالياً</em></a></li>
		<li".($app == 'up'?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=$scope&app=up&days=$days$querystring\"><em>عقوبات تم رفعها</em></a></li>
		<li".($app == 'ref'?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=$scope&app=ref&days=$days$querystring\"><em>عقوبات تم رفضها</em></a></li>
		<li".($app == 'all'?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=$scope&app=all&days=$days$querystring\"><em>جميع عقوبات</em></a></li>
	</ul>
	<ul class=\"svcbar asAS12\">
		<li".($days == 30?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=$scope&app=$app&days=30$querystring\"><em>آخر 30 يوم</em></a></li>
		<li".($days == 60?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=$scope&app=$app&days=60$querystring\"><em>آخر 60 يوم</em></a></li>
		<li".($days == 180?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=$scope&app=$app&days=180$querystring\"><em>آخر 6 أشهر</em></a></li>
		<li".($days == 365?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=$scope&app=$app&days=365$querystring\"><em>آخر سنة</em></a></li>
		<li".($days == -1?' class="selected"':'')."><a href=\"svc.php?svc=mons&type=global&scope=$scope&app=$app&days=-1$querystring\"><em>جميع عقوبات</em></a></li>
	</ul>
	</tr>
	<form method=\"post\" action=\"svc.php?svc=mons&type=appglobal\">
	<input type='hidden' name='type'>
	<input type='hidden' name='app' value=\"$app\">
	<input type='hidden' name='redeclare' value=\"".rand."\">
		<tr>
			<td class=\"asHeader\" colspan=\"11\">$appTitle</td>
		</tr>";
if(u>0){
	$sql=$mysql->query("SELECT name,status,level FROM ".prefix."user WHERE id = '".u."' AND status IN (0,1)", __FILE__, __LINE__);
	$urs=$mysql->fetchRow($sql);
	if($urs){
		echo"
		<tr>
			<td class=\"asHiddenB asS12 asAS12 asAC5 asCenter\" colspan=\"11\">تعرض حاليا عقوبات عضو معين فقط: {$Template->userColorLink(u,array($urs[0],$urs[1],$urs[2]))}</td>
		</tr>";
	}
}
	if(m>0){
		$singlemon=($choosedmon=$montypestr["{$montype[m]}"]) ? "$choosedmon" : "<font color=\"red\">رقم نوع الرقابة خاطيء, نرجوا عدم تغير عنوان وصلات بشكل يدوي</font>";
		echo"
		<tr>
			<td class=\"asHiddenB asS12 asAS12 asAC5 asCenter\" colspan=\"11\">تعرض حاليا عقوبة معينة فقط ( <span class=\"asC5\">$singlemon</span> ) لعرض جميع عقوبات <a href=\"svc.php?svc=mons&type=global$appurl$scopeurl$daysurl$furl$uurl\">إضغط هنا</a></td>
		</tr>";
	}
		echo"
		<tr>";
		if(ulv > 2&&$app!='all'&&$app!='up'&&$app!='ref'){
			echo"
			<td class=\"asDarkB\"><nobr>&nbsp;</nobr></td>";
		}
			echo"
			<td class=\"asDarkB\"><b>العضو</b></td>
			<td class=\"asDarkB\"><b>العقوبة</b></td>";
		if($app == 'all'){
			echo"
			<td class=\"asDarkB\"><b>حالة<br>العقوبة</b></td>";
		}
			echo"
			<td class=\"asDarkB\"><b>المنتدى</b></td>
			<td class=\"asDarkB\"><b>تقديم الطلب</b></td>
			<td class=\"asDarkB\"><b>تطبيق</b></td>
			<td class=\"asDarkB\"><b>رفع</b></td>
			<td class=\"asDarkB\"><b>رفض</b></td>
			<td class=\"asDarkB\"><b>عدد<br>أيام</b></td>
			<td class=\"asDarkB\">&nbsp;</td>
		</tr>";
		
	$checkSqlField="";
	$checkSqlTable="";
	if(ulv < 4){
		$checkSqlField="
			,IF( NOT ISNULL(f.id) AND (".ulv." > 1 AND NOT ISNULL(mm.id) OR ".ulv." = 3 AND NOT ISNULL(c.id)) ,1,0) AS ismod
			,IF( NOT ISNULL(f.id) AND (".ulv." = 3 AND NOT ISNULL(c.id)) ,1,0) AS ismon
		";
		$checkSqlTable="
			LEFT JOIN ".prefix."moderator AS mm ON(NOT ISNULL(f.id) AND mm.forumid = f.id AND mm.userid = ".uid.")
			LEFT JOIN ".prefix."category AS c ON(NOT ISNULL(f.id) AND c.id = f.catid AND c.monitor = ".uid.")
		";
	}
	else{
		$checkSqlField="
			,IF(NOT ISNULL(m.id),1,0) AS ismod
			,IF(NOT ISNULL(m.id),1,0) AS ismon
		";
	}
	$sql=$mysql->query("SELECT m.*,mf.agreeby,mf.agreedate,mf.upby,mf.upmdate,mf.refby,mf.refdate,
		u.name AS uname,u.status AS ustatus,u.level AS ulevel,u.submonitor AS usubmonitor,added.name AS aname,added.status AS astatus,added.level AS alevel,added.submonitor AS asubmonitor,
		agree.name AS agreename,agree.status AS agreestatus,agree.level AS agreelevel,agree.submonitor AS agreesubmonitor,
		up.name AS upname,up.status AS upstatus,up.level AS uplevel,up.submonitor AS upsubmonitor,ref.name AS rname,ref.status AS rstatus,ref.level AS rlevel,ref.submonitor AS rsubmonitor,
		f.id AS fid,f.subject AS fsubject {$checkSqlField}
	FROM ".prefix."mon AS m
	LEFT JOIN ".prefix."monflag AS mf ON(mf.id = m.id)
	LEFT JOIN ".prefix."forum AS f ON(f.id = m.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = m.userid)
	LEFT JOIN ".prefix."user AS added ON(added.id = m.addedby)
	LEFT JOIN ".prefix."user AS agree ON(mf.agreeby > 0 AND agree.id = mf.agreeby)
	LEFT JOIN ".prefix."user AS up ON(mf.upby > 0 AND up.id = mf.upby)
	LEFT JOIN ".prefix."user AS ref ON(mf.refby > 0 AND ref.id = mf.refby) {$checkSqlTable}
	WHERE 1 = 1 ".checkMonGlobalSql()." GROUP BY m.id ORDER BY m.addeddate DESC LIMIT {$DF->pgLimit(num_pages)},".num_pages, __FILE__, __LINE__);
	$count=0;
	$checkCount=0;
	while($rs=$mysql->fetchAssoc($sql)){
		$mon=array(
			'checkbox'=>' - ',
			'usermontypestr'=>'',
			'forumsubject'=>'',
			'agreeby'=>'',
			'agreedate'=>'',
			'upby'=>'',
			'update'=>'',
			'refby'=>'',
			'refdate'=>'',
			'days'=>''
		);
		if( ($app == 'wait'||$app == 'ok') && (($rs['montype']!=1&&$rs['montype']!=3&&ulv > 2) || $rs['ismon'] == 1) ){
			$mon['checkbox']="<input onClick=\"DF.checkRowClass(this,{$rs['id']},'normal');\" type=\"checkbox\" class=\"none\" name=\"mons[]\" value=\"{$rs['id']}|{$rs['userid']}|{$rs['forumid']}|{$rs['montype']}\">";
			$checkCount++;
		}
		$mon['usermontypestr']=$montypestr["{$montype[$rs['montype']]}"];
		$mon['forumsubject']=($rs['fid']>0 ? $Template->forumLink($rs['fid'],$rs['fsubject']) : '');
		if($rs['agreeby']>0){
			$mon['agreeby']=$Template->userColorLink($rs['agreeby'], array($rs['agreename'], $rs['agreestatus'], $rs['agreelevel'], $rs['agreesubmonitor']));
			$mon['agreedate']=$DF->date($rs['agreedate'],'date',true);
			$limit=time-$rs['agreedate'];
			$mon['days']=ceil($limit/86400);
		}
		if($rs['upby']>0){
			$mon['upby']=$Template->userColorLink($rs['upby'], array($rs['upname'], $rs['upstatus'], $rs['uplevel'], $rs['upsubmonitor']));
			$mon['update']=$DF->date($rs['upmdate'],'date',true);
		}
		if($rs['refby']>0){
			$mon['refby']=$Template->userColorLink($rs['refby'], array($rs['rname'], $rs['rstatus'], $rs['rlevel'], $rs['rsubmonitor']));
			$mon['refdate']=$DF->date($rs['refdate'],'date',true);
		}
		echo"
		<tr id=\"row{$rs['id']}\">";
		if(ulv > 2&&$app!='all'&&$app!='up'&&$app!='ref'){
			echo"
			<td class=\"asNormalB asCenter\">{$mon['checkbox']}</td>";
		}
			echo"
			<td class=\"asNormalB asAS12 asCenter\"><nobr>{$Template->userColorLink($rs['userid'], array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor']))}</nobr></td>
			<td class=\"asNormalB asS12\"><nobr>{$mon['usermontypestr']}</nobr></td>";
		if($app == 'all'){
			echo"
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$monstatusstr[$rs['status']]}</nobr></td>";
		}
			echo"
			<td class=\"asNormalB asAS12 asCenter\"><nobr>{$mon['forumsubject']}</nobr></td>
			<td class=\"asNormalB asS12 asAS12 asDate asCenter\"><nobr>{$DF->date($rs['addeddate'],'date',true)}<br>{$Template->userColorLink($rs['addedby'], array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor']))}</nobr></td>
			<td class=\"asNormalB asS12 asAS12 asDate asCenter\"><nobr>{$mon['agreedate']}<br>{$mon['agreeby']}</nobr></td>
			<td class=\"asNormalB asS12 asAS12 asDate asCenter\"><nobr>{$mon['update']}<br>{$mon['upby']}</nobr></td>
			<td class=\"asNormalB asS12 asAS12 asDate asCenter\"><nobr>{$mon['refdate']}<br>{$mon['refby']}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>".checkMonDays($rs['agreedate'],$rs['upmdate'],$rs['refdate'])."</nobr></td>
			<td class=\"asNormalB asCenter\">
				<nobr>
					<a href=\"javascript:DF.getMonDetails({$rs['id']});\"><img id=\"expand{$rs['id']}\" src=\"{$DFImage->i['expand']}\" alt=\"مشاهدة تفاصيل هذه العقوبة\" border=\"0\"></a>
					<a href=\"javascript:DF.hideMonDetails({$rs['id']});\"><img id=\"contract{$rs['id']}\" src=\"{$DFImage->i['contract']}\" alt=\"إخفاء تفاصيل هذه العقوبة\" style=\"top:2px;left:2px;visibility:hidden;position:absolute\" border=\"0\"></a>
				</nobr>
			</td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"11\"><br>-- لا توجد أي عقوبات بهذه المواصفات --<br><br></td>
		</tr>";
	}
	if($checkCount>0&&($app == 'wait'||$app == 'ok')){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"11\">
			{$Template->button('تحديد الكل',' onClick="DF.checkAllBox(this)"')}&nbsp;&nbsp;";
		if($app == 'wait'){
			echo"
			{$Template->button('موافقة على عقوبات المختارة'," onClick=\"DF.medalCmd(this,'app')\"")}&nbsp;&nbsp;";
		}
		if($app == 'ok'){
			echo"
			{$Template->button('رفع عقوبات المختارة'," onClick=\"DF.medalCmd(this,'up')\"")}&nbsp;&nbsp;";
		}
		if($app == 'wait'||$app == 'ok'){
			echo"
			{$Template->button('رفض عقوبات المختارة'," onClick=\"DF.medalCmd(this,'ref')\"")}";
		}
			echo"
			</td>
		</tr>";
	}
	echo"
	</form>
	</table><br>";
}
elseif(type == 'appglobal'&&ulv > 2){
	$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في موافقة ورفع ورفض عقوبات");
	$app=$_POST['app'];
	$type=$_POST['type'];
	$redeclare=$_POST['redeclare'];
	$mons=$_POST['mons'];
	if(is_array($mons)){
 		$allowforums=$DF->getAllowForumId();
		if($redeclare!=checkredeclare){
			$Template->errMsg("كان هناك خلل أثناء تخزين العملية!<br>يبدو أنه تم محاولة إدخال البيانات عدة مرات لسبب فني أو لخلل في الشبكة.<br>الرجاء التأكد من أن العملية انتهت بنجاح... نأسف على هذا.");
		}
		elseif($type == 'app'){
			for($x=0;$x<count($mons);$x++){
				$exp=explode("|",$mons[$x]);
				$monid=(int)$exp[0];
				$userid=(int)$exp[1];
				$forumid=(int)$exp[2];
				$montype=(int)$exp[3];
				if(ulv == 4||($montype!=1&&$montype!=3)||in_array($forumid,$allowforums)){
					$mysql->update("mon SET status = 1 WHERE id = '$monid'", __FILE__, __LINE__);
					$mysql->update("monflag SET agreeby = '".uid."', agreedate = '".time."' WHERE id = '$monid'", __FILE__, __LINE__);
					if(in_array($montype,$userpermnums)){
						$mysql->update("userperm SET $userpermfields[$montype] = 1 WHERE id = '$userid'", __FILE__, __LINE__);
					}
					if($montype == 9){
						$mysql->update("user SET status = 0 WHERE id = '$userid'", __FILE__, __LINE__);
					}
					if($montype == 1||$montype == 3){
						$from=(-$forumid);
						$subject="الرسالة من {$mysql->get("forum","subject",$forumid)} الى {$mysql->get("user","name",$userid)}";
					}
					else{
						$from=0;
						$subject="الرسالة من إدارة منتديات الى {$mysql->get("user","name",$userid)}";
					}
					$message="<br>تم تطبيق عقوبة التالية عليك بسبب مخالفة موضحة في الأدناه<br><br>---------------------------------------------------------------------<br><br>".nl2br($mysql->get("monflag","usernote",$monid))."<br><br>";
					$Template->sendpm($userid,0,$userid,$subject,$message);
				}
			}
			$Template->msg("تمت موافقة على عقوبات المختارة بنجاح");
		}
		elseif($type == 'up'){
			for($x=0;$x<count($mons);$x++){
				$exp=explode("|",$mons[$x]);
				$monid=(int)$exp[0];
				$userid=(int)$exp[1];
				$forumid=(int)$exp[2];
				$montype=(int)$exp[3];
				if(ulv == 4||($montype!=1&&$montype!=3)||in_array($forumid,$allowforums)){
					$mysql->update("mon SET status = 2 WHERE id = '$monid'", __FILE__, __LINE__);
					$mysql->update("monflag SET upby = '".uid."', upmdate = '".time."' WHERE id = '$monid'", __FILE__, __LINE__);
					if(in_array($montype,$userpermnums)){
						$mysql->update("userperm SET $userpermfields[$montype] = 0 WHERE id = '$userid'", __FILE__, __LINE__);
					}
					if($montype == 9){
						$mysql->update("user SET status = 1 WHERE id = '$userid'", __FILE__, __LINE__);
					}
					if($montype == 1||$montype == 3){
						$from=(-$forumid);
						$subject="الرسالة من {$mysql->get("forum","subject",$forumid)} الى {$mysql->get("user","name",$userid)}";
					}
					else{
						$from=0;
						$subject="الرسالة من إدارة منتديات الى {$mysql->get("user","name",$userid)}";
					}
					$message="<br>تم تطبيق عقوبة التالية عليك بسبب مخالفة موضحة في الأدناه<br><br>---------------------------------------------------------------------<br><br>".nl2br($mysql->get("monflag","usernote",$monid))."<br><br>";
					$Template->sendpm($userid,0,$userid,$subject,$message);
				}
			}
			$Template->msg("تم رفع عقوبات المختارة بنجاح");
		}
		elseif($type == 'ref'){
			for($x=0;$x<count($mons);$x++){
				$exp=explode("|",$mons[$x]);
				$monid=(int)$exp[0];
				$userid=(int)$exp[1];
				$forumid=(int)$exp[2];
				$montype=(int)$exp[3];
				if(ulv == 4||($montype!=1&&$montype!=3)||in_array($forumid,$allowforums)){
					$mysql->update("mon SET status = 3 WHERE id = '$monid'", __FILE__, __LINE__);
					$mysql->update("monflag SET refby = '".uid."', refdate = '".time."' WHERE id = '$monid'", __FILE__, __LINE__);
					if(in_array($montype,$userpermnums)){
						$mysql->update("userperm SET $userpermfields[$montype] = 0 WHERE id = '$userid'", __FILE__, __LINE__);
					}
					if($montype == 9){
						$mysql->update("user SET status = 1 WHERE id = '$userid'", __FILE__, __LINE__);
					}
				}
			}
			$Template->msg("تم رفض عقوبات المختارة بنجاح");
		}
		else{
			$Template->errMsg("لم يتم تخزين العملية لسبب فني.<br><br>الرجاء إخبار الإدارة لتصحيح المشكلة.");
		}
	}
	else{
		$Template->errMsg("لم يتم تخزين العملية لسبب فني.<br><br>الرجاء إخبار الإدارة لتصحيح المشكلة.");
	}
}
elseif(type == 'addmon'){
	?>
	<script type="text/javascript">
	DF.checkSubmit=function(frm){
		if(frm.montype.selectedIndex == 0){
			alert("يجب عليك ان تختار نوع العقوبة من القائمة.");
		}
		else if(frm.usernote.value.length<10){
			alert("يجب عليك ان تكتب سبب العقوبة ولن يكون أقل من 10 حروف ليرسل للعضو.");
		}
		else if(frm.monnote.value.length<10){
			alert("يجب عليك ان تكتب ملاحظتك حول عقوبة هذه العضوية ولن يكون أقل من 10 حروف.");
		}
		else{
			frm.submit();
		}
	};
	</script>
	<?php
	$moninfo=array(
		'findError'=>false,
		'modError'=>false,
		'alloptions'=>false,
		'userinfo'=>'',
		'targettitle'=>'',
		'targetmsg'=>'',
		'forumsubject'=>'',
		'forumid'=>'',
		'posttype'=>'other',
		'postid'=>0
	);
	if(u == uid){
		$moninfo['findError']=true;
	}
	else{
		$user=$mysql->queryRow("SELECT level,name,status,submonitor FROM ".prefix."user WHERE id = '".u."' AND status = 1", __FILE__, __LINE__);
		if(!$user||$user[0]>ulv||$user[0] == 4){
			$moninfo['findError']=true;
		}
		else{
			$moninfo['userinfo']['name'] = $user[1];
			$moninfo['userinfo']['status'] = $user[2];
			$moninfo['userinfo']['level'] = $user[0];
			$moninfo['userinfo']['submonitor'] = $user[3];
			if(method == 'topic'){
				$topic=$mysql->queryRow("SELECT forumid,subject FROM ".prefix."topic WHERE id = '".t."' AND author = '".u."'", __FILE__, __LINE__);
				if(!$topic){
					$moninfo['findError']=true;
				}
				else{
					$allow=$DF->showTools($topic[0]);
					if($allow == 0){
						$moninfo['modError']=true;
					}
					else{
						$moninfo['postid']=t;
						$moninfo['posttype']='topic';
						$moninfo['forumid']=$topic[0];
						$moninfo['alloptions']=true;
						$moninfo['targettitle']="يربط بالموضوع";
						$moninfo['targetmsg']=$Template->topicLink(t,$topic[1]);
					}
				}
			}
			elseif(method == 'post'){
				$post=$mysql->queryRow("SELECT forumid,topicid FROM ".prefix."post WHERE id = '".p."' AND author = '".u."'", __FILE__, __LINE__);
				if(!$post){
					$moninfo['findError']=true;
				}
				else{
					$allow=$DF->showTools($post[0]);
					if($allow == 0){
						$moninfo['modError']=true;
					}
					else{
						$moninfo['postid']=p;
						$moninfo['posttype']='post';
						$moninfo['forumid']=$post[0];
						$moninfo['alloptions']=true;
						$moninfo['targettitle']="يربط بالرد";
						$moninfo['targetmsg']="<a href=\"topics.php?t=$post[1]&p=".p."\">انقر هنا للذهاب الى الرد</a>";
					}
				}
			}
			elseif(method == 'pm'){
				$pmid=$DF->hashToNum(pm);
				$pm=$mysql->queryRow("SELECT id FROM ".prefix."pm WHERE id = '$pmid' AND (author = ".u." OR pmfrom = ".u." OR pmto = ".u.")", __FILE__, __LINE__);
				if(!$pm){
					$moninfo['findError']=true;
				}
				else{
					$moninfo['postid']=$pmid;
					$moninfo['posttype']='pm';
					$moninfo['targetmsg']="الرسالة رقم: ".pm."";
					$moninfo['targettitle']="يربط بالرسالة";
					$moninfo['targetmsg']="<a href=\"pm.php?mail=read&pm=".pm."\">انقر هنا للذهاب الى الرسالة</a>";
				}
			}
			if($moninfo['findError'] == false&&$moninfo['modError'] == false&&(method == 'topic'||method == 'post')){
				$moninfo['forumsubject']=$Template->forumLink($moninfo['forumid'],$mysql->get("forum","subject",$moninfo['forumid']));
			}
		}
	}

	if($moninfo['findError'] == true){
		$Template->errMsg("لا يمكنك عقوبة هذه العضوية<br>قد يكون هناك عدة إسباب لهذا منها:<br><br><table><tr><td>* رقم العضوية التي تقوم بتطبيق عقوبة عليها هو خاطيء.</td></tr><tr><td>* لا عندك تصريح لتطبيق العقوبة على هذه العضوية.</td></tr><tr><td>* عملت تغير عنوان وصلات بشكل يدوي وهذا ممنوع في تطبيق عقوبات.</td></tr></table>");
	}
	if($moninfo['modError'] == true){
		$Template->errMsg("لا يمكنك عقوبة هذه العضوية<br>بسبب انت لست مشرفاً للمنتدى الذي تعاقب العضو فيه");
	}
	
	echo"
	<table id=\"monTable\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader\" colspan=\"13\">عقوبات العضو</td>
		</tr>
		<tr>
			<td class=\"asDarkB\">العضو</td>
			<td class=\"asDarkB\">العقوبة</td>
			<td class=\"asDarkB\">حالة<br>العقوبة</td>
			<td class=\"asDarkB\">المنتدى</td>
			<td class=\"asDarkB\">تقديم الطلب</td>
			<td class=\"asDarkB\">تطبيق</td>
			<td class=\"asDarkB\">رفع</td>
			<td class=\"asDarkB\">رفض</td>
			<td class=\"asDarkB\">عدد<br>أيام</td>
			<td class=\"asDarkB\">&nbsp;</td>
		</tr>";
	$sql=$mysql->query("SELECT m.*,mf.agreeby,mf.agreedate,mf.upby,mf.upmdate,mf.refby,mf.refdate,
		u.name AS uname,u.status AS ustatus,u.level AS ulevel,u.submonitor AS usubmonitor,added.name AS aname,added.status AS astatus,added.level AS alevel,added.submonitor AS asubmonitor,
		agree.name AS agreename,agree.status AS agreestatus,agree.level AS agreelevel,agree.submonitor AS agreesubmonitor,
		up.name AS upname,up.status AS upstatus,up.level AS uplevel,up.submonitor AS upsubmonitorl,ref.name AS rname,ref.status AS rstatus,ref.level AS rlevel,ref.submonitor AS rsubmonitor,
		f.id AS fid,f.subject AS fsubject
	FROM ".prefix."mon AS m
	LEFT JOIN ".prefix."monflag AS mf ON(mf.id = m.id)
	LEFT JOIN ".prefix."forum AS f ON(f.id = m.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = m.userid)
	LEFT JOIN ".prefix."user AS added ON(added.id = m.addedby)
	LEFT JOIN ".prefix."user AS agree ON(agree.id = mf.agreeby)
	LEFT JOIN ".prefix."user AS up ON(up.id = mf.upby)
	LEFT JOIN ".prefix."user AS ref ON(ref.id = mf.refby)
	WHERE userid = '".u."' ORDER BY m.addeddate DESC", __FILE__, __LINE__);
	$count=0;
	$waitmon=0;
	while($rs=$mysql->fetchAssoc($sql)){
		$mon=array(
			'usermontypestr'=>'',
			'forumsubject'=>'',
			'agreeby'=>'',
			'agreedate'=>'',
			'upby'=>'',
			'update'=>'',
			'refby'=>'',
			'refdate'=>'',
			'days'=>''
		);
		$mon['usermontypestr']=$montypestr["{$montype[$rs['montype']]}"];
		$mon['forumsubject']=($rs['fid']>0 ? $Template->forumLink($rs['fid'],$rs['fsubject']) : '');
		if($rs['agreeby']>0){
			$mon['agreeby']=$Template->userColorLink($rs['agreeby'], array($rs['agreename'], $rs['agreestatus'], $rs['agreelevel'], $rs['agreesubmonitor']));
			$mon['agreedate']=$DF->date($rs['agreedate'],'date',true);
			$limit=time-$rs['agreedate'];
			$mon['days']=ceil($limit/86400);
		}
		if($rs['upby']>0){
			$mon['upby']=$Template->userColorLink($rs['upby'], array($rs['upname'], $rs['upstatus'], $rs['uplevel'], $rs['upsubmonitor']));
			$mon['update']=$DF->date($rs['upmdate'],'date',true);
		}
		if($rs['refby']>0){
			$mon['refby']=$Template->userColorLink($rs['refby'], array($rs['rname'], $rs['rstatus'], $rs['rlevel'], $rs['rsubmonitor']));
			$mon['refdate']=$DF->date($rs['refdate'],'date',true);
		}
		$className=($rs['status'] == 0 ? "asFixedB" : "asNormalB");
		echo"
		<tr id=\"row{$rs['id']}\">
			<td class=\"$className asAS12 asCenter\"><nobr>{$Template->userColorLink($rs['userid'], array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor']))}</nobr></td>
			<td class=\"$className asS12\"><nobr>{$mon['usermontypestr']}</nobr></td>
			<td class=\"$className asS12 asCenter\"><nobr>{$monstatusstr[$rs['status']]}</nobr></td>
			<td class=\"$className asAS12 asCenter\"><nobr>{$mon['forumsubject']}</nobr></td>
			<td class=\"$className asS12 asAS12 asDate asCenter\"><nobr>{$DF->date($rs['addeddate'],'date',true)}<br>{$Template->userColorLink($rs['addedby'], array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor']))}</nobr></td>
			<td class=\"$className asS12 asAS12 asDate asCenter\"><nobr>{$mon['agreedate']}<br>{$mon['agreeby']}</nobr></td>
			<td class=\"$className asS12 asAS12 asDate asCenter\"><nobr>{$mon['update']}<br>{$mon['upby']}</nobr></td>
			<td class=\"$className asS12 asAS12 asDate asCenter\"><nobr>{$mon['refdate']}<br>{$mon['refby']}</nobr></td>
			<td class=\"$className asS12 asCenter\"><nobr>".checkMonDays($rs['agreedate'],$rs['upmdate'],$rs['refdate'])."</nobr></td>
			<td class=\"$className asCenter\">
				<nobr>
					<a href=\"javascript:DF.getMonDetails({$rs['id']});\"><img id=\"expand{$rs['id']}\" src=\"{$DFImage->i['expand']}\" alt=\"مشاهدة تفاصيل هذه العقوبة\" border=\"0\"></a>
					<a href=\"javascript:DF.hideMonDetails({$rs['id']});\"><img id=\"contract{$rs['id']}\" src=\"{$DFImage->i['contract']}\" alt=\"إخفاء تفاصيل هذه العقوبة\" style=\"top:2px;left:2px;visibility:hidden;position:absolute\" border=\"0\"></a>
				</nobr>
			</td>
		</tr>";
		if($rs['status'] == 0){
			$waitmon++;
		}
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"13\"><br>-- لا توجد أي عقوبات على العضو --<br><br></td>
		</tr>";
	}
	if($waitmon>0){
		echo"
		<tr>
			<td class=\"asBody asCenter\" colspan=\"13\">
			<table border=\"0\">
				<tr>
					<td class=\"asTitle\">ملاحظة: عقوبات التي تنتظر موافقة مراقب تظهر بلون</td>
					<td class=\"asTitle\"><table border=\"0\"><tr><td class=\"asFixedB\">&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table></td>
				</tr>
			</table>
			<table border=\"0\">
				<tr>
					<td class=\"asTitle asC2 asCenter\" colspan=\"2\">ملاحظة إدارية: يجب عليك أنت تتأكد من أن العقوبة لم تكون مضافة من قبل أحد مشرفين آخرين وتنتظر موافقة مراقب من قائمة أعلاه.</td>
				</tr>
			</table>
			</td>
		</tr>";
	}
	echo"
	</table><br>";
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form method=\"post\" action=\"svc.php?svc=mons&type=insertmon\">
	<input type=\"hidden\" name=\"userid\" value=\"".u."\">
	<input type=\"hidden\" name=\"posttypestr\" value=\"{$moninfo['posttype']}\">
	<input type=\"hidden\" name=\"postid\" value=\"{$moninfo['postid']}\">
	<input type=\"hidden\" name=\"forumid\" value=\"{$moninfo['forumid']}\">
	<input type=\"hidden\" name=\"redeclare\" value=\"".rand."\">
		<tr>
			<td class=\"asHeader\" colspan=\"2\"><nobr>تطبيق عقوبة على العضو</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>العضو</nobr></td>
			<td class=\"asNormalB\"><nobr>{$Template->userColorLink(u, array($moninfo['userinfo']['name'], $moninfo['userinfo']['status'], $moninfo['userinfo']['level'], $moninfo['userinfo']['submonitor']))}</nobr></td>
		</tr>";
	if(!empty($moninfo['forumsubject'])){
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>المنتدى</nobr></td>
			<td class=\"asNormalB\"><nobr>{$moninfo['forumsubject']}</nobr></td>
		</tr>";
	}
	if(!empty($moninfo['targetmsg'])){
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>{$moninfo['targettitle']}</nobr></td>
			<td class=\"asNormalB\">{$moninfo['targetmsg']}</td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>العقوبة</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" style=\"width:300px\" name=\"montype\">
				<option value=\"0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- اختر نوع العقوبة --</option>";
			if($moninfo['alloptions'] == true){
				echo"
				<option value=\"1\">وضع رقابة على مشاركات العضو في منتدى معين</option>";
			}
				echo"
				<option value=\"2\">وضع رقابة على مشاركات العضو في جميع منتديات</option>";
			if($moninfo['alloptions'] == true){
				echo"
				<option value=\"3\">منع العضو من مشاركة في منتدى معين</option>";
			}
				echo"
				<option value=\"4\">منع العضو من المشاركة في جميع منتديات</option>
				<option value=\"5\">طلب منع العضو من إرسال رسائل خاصة للأعضاء</option>
				<option value=\"6\">طلب إخفاء صورة الشخصية العضو عن باقي الأعضاء</option>
				<option value=\"7\">طلب إخفاء توقيع العضو عن باقي الأعضاء</option>
				<option value=\"8\">طلب إخفاء تفاصيل العضو عن باقي الأعضاء</option>
				<option value=\"9\">طلب قفل العضوية</option>
			</select>
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>السبب (يرسل للعضو)</nobr></td>
			<td class=\"asNormalB\"><textarea style=\"width:400px;height:100px\" name=\"usernote\"></textarea></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>ملاحظات إشرافية</nobr></td>
			<td class=\"asNormalB\"><textarea style=\"width:400px;height:100px\" name=\"monnote\"></textarea></td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"2\">{$Template->button("تطبيق العقوبة"," onClick=\"DF.checkSubmit(this.form)\"")}</td>
		</tr>
	</form>
	</table>";
}
elseif(type == 'insertmon'){
	$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في إضافة عقوبة للعضو");
	$redeclare=(int)$_POST['redeclare'];
	$userid=(int)$_POST['userid'];
	$postid=(int)$_POST['postid'];
	$forumid=(int)$_POST['forumid'];
	$montype=(int)$_POST['montype'];
	$posttypestr=(int)$posttype["{$_POST['posttypestr']}"];
	$usernote=$DF->cleanText($_POST['usernote']);
	$monnote=$DF->cleanText($_POST['monnote']);
	
	if($redeclare!=checkredeclare){
		$Template->errMsg("كان هناك خلل أثناء تخزين العملية!<br>يبدو أنه تم محاولة إدخال البيانات عدة مرات لسبب فني أو لخلل في الشبكة.<br>الرجاء التأكد من أن العملية انتهت بنجاح... نأسف على هذا.");
	}
	
	$findError=false;
	if($userid == uid){
		$findError=true;
	}
	else{
		$user=$mysql->queryRow("SELECT level,name FROM ".prefix."user WHERE id = '$userid' AND status = 1", __FILE__, __LINE__);
		if(!$user||$user[0]>ulv||$user[0] == 4){
			$findError=true;
		}
		else{
			$status=0;
			$agreeby=0;
			$agreedate=0;
			$msg="تم إدخال العقوبة بنجاح لكن بحاجة الى موافقة مراقب ليتم تطبيقها.";
			$allow=$DF->showTools($forumid);
			if($allow == 2||$montype!=1&&$montype!=3&&ulv > 2){
				$status=1;
				$agreeby=uid;
				$agreedate=time;
				$msg="تم تطبيق العقوبة بنجاح";
				if(in_array($montype,$userpermnums)){
					$mysql->update("userperm SET $userpermfields[$montype] = 1 WHERE id = '$userid'", __FILE__, __LINE__);
				}
				if($montype == 9){
					$mysql->update("user SET status = 0 WHERE id = '$userid'", __FILE__, __LINE__);
				}
				if($montype == 1||$montype == 3){
					$from=(-$forumid);
					$subject="الرسالة من {$mysql->get("forum","subject",$forumid)} الى {$mysql->get("user","name",$userid)}";
				}
				else{
					$from=0;
					$subject="الرسالة من إدارة منتديات الى {$mysql->get("user","name",$userid)}";
				}
				$message="<br>تم تطبيق عقوبة التالية عليك بسبب مخالفة موضحة في الأدناه<br><br>---------------------------------------------------------------------<br><br>".nl2br($usernote)."<br><br>";
				$Template->sendpm($userid,$from,$userid,$subject,$message);
			}
			$mysql->insert("mon (status,userid,forumid,montype,addedby,addeddate) VALUES ('$status','$userid','$forumid','$montype','".uid."','".time."')", __FILE__, __LINE__);
			if($forumid>0){
				$DFOutput->setModActivity('mon',$forumid,true);
			}
			
			$id=$mysql->queryRow("SELECT id FROM ".prefix."mon WHERE addeddate = '".time."' AND addedby = '".uid."'", __FILE__, __LINE__);
			$id=$id[0];
			
			$mysql->insert("monflag (id,postid,posttype,usernote,monnote,agreeby,agreedate) VALUES ('$id','$postid','$posttypestr','$usernote','$monnote','$agreeby','$agreedate')", __FILE__, __LINE__);
			$Template->msg($msg,"svc.php?svc=mons&type=global&scope=all&app=all&days=-1&u=$userid");
		}
	}
	if($findError){
		$Template->errMsg("حدث خطأ أثناء تطبيق العقوبة<br>مرجوا إعادة محاولة مرة اخرى");
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