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
if(_df_script == 'svc'&&this_svc == 'complain'&&ulv > 1){
// ************ start page ****************

$notetype=array(
	1=>'تحتوي على إشهار منتدي',
	2=>'تحتوي على صور غير لائقة',
	3=>'تحتوي على كلام غير لائق',
	4=>'تحتوي على شتم أو تهجم'
);

$posttype=array(
	1=>'الموضوع',
	2=>'الرد',
	3=>'الرسالة'
);

$complainstatus=array(
	0=>'<font color="gray">مقفلة</font>',
	1=>'تم رد عليها',
	2=>'<font color="blue">مرسلة للمدير</font>',
	3=>'<font color="red">جديدة</font>'
);

if(type == ''){
	function optionLink($num,$url){
		if($num){
			$link="<a href=\"$url\">$num</a>";
		}
		else{
			$link="0";
		}
		return $link;
	}
	function setClass($num){
		if($num){
			return "asFirstB";
		}
		else{
			return "asNormalB";
		}
	}
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader\" colspan=\"5\">شكاوي</td>
		</tr>
		<tr>
			<td class=\"asDarkB\">عنوان المنتدى</td>
			<td class=\"asDarkB\">شكاوي جديدة</td>
			<td class=\"asDarkB\">شكاوي تم رد عليها</td>
			<td class=\"asDarkB\">شكاوي المرسلة للمدير</td>
			<td class=\"asDarkB\">شكاوي مقفولة</td>
		</tr>";
	$checkSqlTable="";
	$checkSqlWhere="";
	if(ulv < 4){
		$checkSqlWhere=" AND (".ulv." > 1 AND NOT ISNULL(m.id) OR ".ulv." = 3 AND c.monitor = ".uid.")";
		$checkSqlTable="LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")";
	}
	$sql=$mysql->query("SELECT f.id,f.subject
	FROM ".prefix."forum AS f
	LEFT JOIN ".prefix."category AS c ON(c.id = f.catid) $checkSqlTable
	WHERE 1 = 1 $checkSqlWhere GROUP BY f.id ORDER BY c.sort,f.sort", __FILE__, __LINE__);
	$count=0;
	$frms=array(0);
	$forums=array();
	while($rs=$mysql->fetchRow($sql)){
		$frms[]=$rs[0];
		$forums[$count][0]=$rs[0];
		$forums[$count][1]=$rs[1];
		$count++;
	}
	
	if(sizeof($forums)>0){
		echo"
		<tr>
			<td class=\"asHiddenB asS12 asCenter\" colspan=\"5\">ملاحظة: لتصفح أي خيار إضغط على رقم الخيار</td>
		</tr>";
	}
	else{
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"5\"><br>لا توجد أي منتدى تحت إشرافك<br><br></td>
		</td>";
	}

	$complain=array();
	$sql=$mysql->query("SELECT forumid,status FROM ".prefix."complain WHERE forumid IN (".implode(",",$frms).")", __FILE__, __LINE__);
	while($rs=$mysql->fetchRow($sql)){
		if(!$complain[$rs[0]]){
			$complain[$rs[0]]['lock']=0;
			$complain[$rs[0]]['ok']=0;
			$complain[$rs[0]]['send']=0;
			$complain[$rs[0]]['new']=0;
		}
		if($rs[1] == 3){
			$complain[$rs[0]]['new']++;
		}
		if($rs[1] == 1){
			$complain[$rs[0]]['ok']++;
		}
		if($rs[1] == 2){
			$complain[$rs[0]]['send']++;
		}
		if($rs[1] == 0){
			$complain[$rs[0]]['lock']++;
		}
	}
	$total=array(
		'new'=>0,
		'ok'=>0,
		'send'=>0,
		'lock'=>0
	);
	foreach($forums as $frm){
		$f=$frm[0];
		$new=$complain[$f]['new'];
		$ok=$complain[$f]['ok'];
		$send=$complain[$f]['send'];
		$lock=$complain[$f]['lock'];
		$total['new']+=$new;
		$total['ok']+=$ok;
		$total['send']+=$send;
		$total['lock']+=$lock;
		echo"
		<tr>
			<td class=\"asHiddenB\"><nobr><b><a href=\"svc.php?svc=complain&type=global&scope=forum&f=$f\">$frm[1]</a></b></nobr></td>
			<td class=\"".setClass($new)." asCenter\">".optionLink($new,"svc.php?svc=complain&type=global&scope=forum&app=new&f=$f")."</td>
			<td class=\"".setClass($ok)." asCenter\">".optionLink($ok,"svc.php?svc=complain&type=global&scope=forum&app=ok&f=$f")."</td>
			<td class=\"".setClass($send)." asCenter\">".optionLink($send,"svc.php?svc=complain&type=global&scope=forum&app=send&f=$f")."</td>
			<td class=\"".setClass($lock)." asCenter\">".optionLink($lock,"svc.php?svc=complain&type=global&scope=forum&app=lock&f=$f")."</td>
		</tr>";
	}
	if(sizeof($forums)>1){
		echo"
		<tr>
			<td class=\"asHiddenB\"><nobr><b>المجموع</b></nobr></td>
			<td class=\"".setClass($total['new'])." asCenter\">".optionLink($total['new'],"svc.php?svc=complain&type=global&app=new")."</td>
			<td class=\"".setClass($total['ok'])." asCenter\">".optionLink($total['ok'],"svc.php?svc=complain&type=global&app=ok")."</td>
			<td class=\"".setClass($total['send'])." asCenter\">".optionLink($total['send'],"svc.php?svc=complain&type=global&app=send")."</td>
			<td class=\"".setClass($total['lock'])." asCenter\">".optionLink($total['lock'],"svc.php?svc=complain&type=global&app=lock")."</td>
		</tr>";
	}
	echo"
	</table>";
}
elseif(type == 'global'){
	$app=(app!=''?app:'ok');
	$scope=(scope!=''?scope:'all');
	$days=(days!=0?days:30);
	$appurl=(app!=''?'&app='.app:'');
	$scopeurl=(scope!=''?'&scope='.scope:'');
	$daysurl=(days!=0?'&days='.days:'');
	$furl=(f>0?'&f='.f:'');
	$thisLink="svc.php?svc=complain&type=global$appurl$scopeurl$daysurl$furl&";
	$allowforums=$DF->getAllowForumId(false,true);
	?>
	<script type="text/javascript">
	var link="<?=$thisLink?>";
	DF.chooseForumId=function(s,app,days){
		fid=s.options[s.selectedIndex].value;
		if(fid == 0) url="svc.php?svc=complain&type=global&app="+app+"&scope=mod&days="+days;
		else url="svc.php?svc=complain&type=global&app="+app+"&scope=forum&days="+days+"&f="+fid;
		document.location=url;
	};
	</script>
	<?php
	if($app == 'new'){
		$appTitle="شكاوي جديدة";
	}
	elseif($app == 'ok'){
		$appTitle="شكاوي تم رد عليها";
	}
	elseif($app == 'send'){
		$appTitle="شكاوي المرسلة للمدير";
	}
	elseif($app == 'lock'){
		$appTitle="شكاوي مقفولة";
	}
	else{
		$appTitle="جميع شكاوي";
	}
	
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asTopHeader asCenter\" colspan=\"11\">
	<ul class=\"svcbar asAS12\">
		<li><em class=\"".($scope == 'forum'?'selectedone':'one')."\">
		<select class=\"asGoTo\" style=\"width:150px\" onChange=\"DF.chooseForumId(this,'$app',$days)\">
			<option value=\"0\">&nbsp;&nbsp;-- عرض شكاوي منتدى --</option>";
		foreach($allowforums as $key){
			echo"
			<option value=\"$key\"{$DF->choose(f,$key,'s')}>{$Template->forumsList[$key]}</option>";
		}
		echo"
		</select>
		</em></li>
		<li".($scope == 'all'?' class="selected"':'')."><a href=\"svc.php?svc=complain&type=global&scope=all&app=$app&days=$days\"><em>جميع شكاوي</em></a></li>
	</ul>
	<ul class=\"svcbar asAS12\">
		<li".($app == 'new'?' class="selected"':'')."><a href=\"svc.php?svc=complain&type=global&scope=$scope&app=new&days=$days$furl\"><em>شكاوي جديدة</em></a></li>
		<li".($app == 'ok'?' class="selected"':'')."><a href=\"svc.php?svc=complain&type=global&scope=$scope&app=ok&days=$days$furl\"><em>شكاوي تم رد عليها</em></a></li>
		<li".($app == 'send'?' class="selected"':'')."><a href=\"svc.php?svc=complain&type=global&scope=$scope&app=send&days=$days$furl\"><em>شكاوي المرسلة للمدير</em></a></li>
		<li".($app == 'lock'?' class="selected"':'')."><a href=\"svc.php?svc=complain&type=global&scope=$scope&app=lock&days=$days$furl\"><em>شكاوي مقفولة</em></a></li>
		<li".($app == 'all'?' class="selected"':'')."><a href=\"svc.php?svc=complain&type=global&scope=$scope&app=all&days=$days$furl\"><em>جميع شكاوي</em></a></li>
	</ul>
	<ul class=\"svcbar asAS12\">
		<li".($days == 30?' class="selected"':'')."><a href=\"svc.php?svc=complain&type=global&scope=$scope&app=$app&days=30$furl\"><em>آخر 30 يوم</em></a></li>
		<li".($days == 60?' class="selected"':'')."><a href=\"svc.php?svc=complain&type=global&scope=$scope&app=$app&days=60$furl\"><em>آخر 60 يوم</em></a></li>
		<li".($days == 180?' class="selected"':'')."><a href=\"svc.php?svc=complain&type=global&scope=$scope&app=$app&days=180$furl\"><em>آخر 6 أشهر</em></a></li>
		<li".($days == 365?' class="selected"':'')."><a href=\"svc.php?svc=complain&type=global&scope=$scope&app=$app&days=365$furl\"><em>آخر سنة</em></a></li>
		<li".($days == -1?' class="selected"':'')."><a href=\"svc.php?svc=complain&type=global&scope=$scope&app=$app&days=-1$furl\"><em>جميع شكاوي</em></a></li>
	</ul>
	</tr>
	<form method=\"post\" action=\"svc.php?svc=mons&type=appglobal\">
	<input type='hidden' name='type'>
	<input type='hidden' name='app' value=\"$app\">
	<input type='hidden' name='redeclare' value=\"".rand."\">
		<tr>
			<td class=\"asHeader\" colspan=\"7\">$appTitle</td>
		</tr>";
	if($scope == 'forum'){
		echo"
		<tr>
			<td class=\"asHiddenB asS12 asAS12 asAC5 asCenter\" colspan=\"11\">تعرض حاليا شكاوي منتدى ( {$Template->forumLink(f,$Template->forumsList[f])} ) لعرض جميع شكاوي المنتديات التي تحت إشرافك <a href=\"svc.php?svc=complain&type=global&scope=all&app=$app&days=$days\">إضغط هنا</a></td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asDarkB\"><b>عنوان الشكوى</b></td>
			<td class=\"asDarkB\"><b>نوع<br>المشاركة</b></td>";
		if($scope == 'all'){
			echo"
			<td class=\"asDarkB\"><b>المنتدى</b></td>
			<td class=\"asDarkB\"><b>حالة<br>الشكوى</b></td>";
		}
			echo"
			<td class=\"asDarkB\"><b>الشكوى<br>على</b></td>
			<td class=\"asDarkB\"><b>مرسل<br>الشكوى</b></td>
			<td class=\"asDarkB\"><b>رد على<br>الشكوى</b></td>
		</tr>";
	$sql=$mysql->query("SELECT com.id,com.status,com.forumid,com.userid,com.postid,com.posttype,com.notetype,com.sendby,
		com.senddate,com.replyby,com.replydate,com.adminread,f.subject AS fsubject,post.topicid AS topicid,
		u.name AS uname,u.status AS ustatus,u.level AS ulevel,u.submonitor AS usubmonitor,
		send.name AS sendname,send.status AS sendstatus,send.level AS sendlevel,send.submonitor AS sendsubmonitor,
		reply.name AS replyname,reply.status AS replystatus,reply.level AS replylevel,reply.submonitor AS replysubmonitor
	FROM ".prefix."complain AS com
	LEFT JOIN ".prefix."forum AS f ON(f.id = com.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = com.userid)
	LEFT JOIN ".prefix."user AS send ON(send.id = com.sendby)
	LEFT JOIN ".prefix."user AS reply ON(reply.id = com.replyby)
	LEFT JOIN ".prefix."post AS post ON(com.posttype = 2 AND post.id = com.postid)
	LEFT JOIN ".prefix."moderator AS m ON(NOT ISNULL(f.id) AND m.forumid = f.id AND m.userid = ".uid.")
	LEFT JOIN ".prefix."category AS c ON(NOT ISNULL(f.id) AND c.id = f.catid)
	WHERE 1 = 1 ".checkComplainGlobalSql()." GROUP BY com.id ORDER BY com.senddate DESC LIMIT {$DF->pgLimit(num_pages)},".num_pages, __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		$com=array(
			'notetype'=>'-- شكوى بدون عنوان --',
			'forumsubject'=>'----',
			'posttype'=>'',
			'posturl'=>'',
			'classname'=>'asNormalB',
			'sendby'=>'',
			'senddate'=>'',
			'replyby'=>'',
			'replydate'=>''
		);
		if($rs['status'] == 2&&$rs['adminread'] == 0){
			$com['classname']='asFixedB';
		}
		$com['posttype']=$posttype[$rs['posttype']];
		if($rs['notetype']>0){
			$com['notetype']=$com['posttype']." ".$notetype[$rs['notetype']];
		}
		if($rs['forumid']>0){
			$com['forumsubject']=$Template->forumLink($rs['forumid'],$rs['fsubject']);
		}
		if($rs['posttype'] == 1){
			$com['posturl']="topics.php?t={$rs['postid']}";
		}
		elseif($rs['posttype'] == 2){
			$com['posturl']="topics.php?t={$rs['topicid']}&p={$rs['postid']}";
		}
		elseif($rs['posttype'] == 3){
			$com['posturl']="pm.php?mail=read&pm={$DF->numToHash($rs['postid'])}";
		}
		$com['sendby']=$Template->userColorLink($rs['sendby'], array($rs['sendname'], $rs['sendstatus'], $rs['sendlevel'], $rs['sendsubmonitor']));
		$com['senddate']=$DF->date($rs['senddate'],'date',true);
		if($rs['replyby']>0){
			$com['replyby']=$Template->userColorLink($rs['replyby'], array($rs['replyname'], $rs['replystatus'], $rs['replylevel'], $rs['replysubmonitor']));
			$com['replydate']=$DF->date($rs['replydate'],'date',true);
		}

		echo"
		<tr>
			<td class=\"{$com['classname']} asAS12 asCenter\"><nobr><a href=\"svc.php?svc=complain&type=read&c={$rs['id']}\">{$com['notetype']}</a></nobr></td>
			<td class=\"{$com['classname']} asAS12 asCenter\"><nobr><a href=\"{$com['posturl']}\" title=\"انقر هنا للذهاب الى المشاركة\">{$com['posttype']}</a></nobr></td>";
		if($scope == 'all'){
			echo"
			<td class=\"{$com['classname']} asAS12 asCenter\"><nobr>{$com['forumsubject']}</nobr></td>
			<td class=\"{$com['classname']} asS12 asCenter\"><nobr>{$complainstatus[$rs['status']]}</nobr></td>";
		}
			echo"
			<td class=\"{$com['classname']} asAS12 asCenter\"><nobr>{$Template->userColorLink($rs['userid'], array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor']))}</nobr></td>
			<td class=\"{$com['classname']} asAS12 asS12 asDate asCenter\"><nobr>{$com['senddate']}<br>{$com['sendby']}</nobr></td>
			<td class=\"{$com['classname']} asAS12 asS12 asDate asCenter\"><nobr>{$com['replydate']}<br>{$com['replyby']}</nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"7\"><br>-- لا توجد أي شكاوي بهذه المواصفات --<br><br></td>
		</tr>";
	}
	if($app == 'all'||$app == 'send'){
		echo"
		<tr>
			<td class=\"asBody asCenter\" colspan=\"13\">
			<table border=\"0\">
				<tr>
					<td class=\"asTitle\">الشكاوي التي تظهر باللون التالي</td>
					<td class=\"asTitle\"><table border=\"0\"><tr><td class=\"asFixedB\">&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table></td>
					<td class=\"asTitle\">تعني أن المدير لم قرأة الشكوى بعد ارساله من قبل طاقم الإشراف.</td>
				</tr>
			</table>
			</td>
		</tr>";
	}
	echo"
	</table>
	</form><br>";
}
elseif(type == 'read'){
	$allow=(ulv == 4 ? "" : "AND (".ulv." > 1 AND NOT ISNULL(m.id) OR ".ulv." = 3 AND c.monitor = ".uid.")");
	$rs=$mysql->queryAssoc("SELECT com.id,com.status,com.forumid,com.userid,com.postid,com.posttype,com.notetype,
		com.sendby,com.senddate,com.replyby,com.replydate,com.adminread,com.admintext,f.subject AS fsubject,
		com.notetext,com.replytext,post.topicid AS topicid,
		u.name AS uname,u.status AS ustatus,u.level AS ulevel,u.submonitor AS usubmonitor,
		send.name AS sendname,send.status AS sendstatus,send.level AS sendlevel,send.submonitor AS sendsubmonitor,
		reply.name AS replyname,reply.status AS replystatus,reply.level AS replylevel,reply.submonitor AS replysubmonitor
	FROM ".prefix."complain AS com
	LEFT JOIN ".prefix."forum AS f ON(f.id = com.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = com.userid)
	LEFT JOIN ".prefix."user AS send ON(send.id = com.sendby)
	LEFT JOIN ".prefix."user AS reply ON(reply.id = com.replyby)
	LEFT JOIN ".prefix."post AS post ON(com.posttype = 2 AND post.id = com.postid)
	LEFT JOIN ".prefix."moderator AS m ON(NOT ISNULL(f.id) AND m.forumid = f.id AND m.userid = ".uid.")
	LEFT JOIN ".prefix."category AS c ON(NOT ISNULL(f.id) AND c.id = f.catid)
	WHERE com.id = ".c." $allow GROUP BY com.id", __FILE__, __LINE__);
	if($rs){
		$com=array(
			'notetype'=>'شكوى بدون عنوان',
			'forumsubject'=>'----',
			'posttype'=>'',
			'posturl'=>'',
			'classname'=>'normal',
			'sendby'=>'',
			'senddate'=>'',
			'replyby'=>'',
			'replydate'=>''
		);
		$com['posttype']=$posttype[$rs['posttype']];
		if($rs['notetype']>0){
			$com['notetype']=$com['posttype']." ".$notetype[$rs['notetype']];
		}
		if($rs['posttype'] == 1){
			$com['posturl']="topics.php?t={$rs['postid']}";
		}
		elseif($rs['posttype'] == 2){
			$com['posturl']="topics.php?t={$rs['topicid']}&p={$rs['postid']}";
		}
		elseif($rs['posttype'] == 3){
			$com['posturl']="pm.php?mail=read&pm={$DF->numToHash($rs['postid'])}";
		}
		$com['sendby']=$Template->userColorLink($rs['sendby'], array($rs['sendname'], $rs['sendstatus'], $rs['sendlevel'], $rs['sendsubmonitor']));
		$com['senddate']=$DF->date($rs['senddate'],'date',true);
		if($rs['replyby']>0){
			$com['replyby']=$Template->userColorLink($rs['replyby'],array($rs['replyname'], $rs['replystatus'], $rs['replylevel'], $rs['replysubmonitor']));
			$com['replydate']=$DF->date($rs['replydate'],'date',true);
		}
		
		?>
		<script type="text/javascript">
		DF.checkSubmit=function(frm){
			if(frm.replytext.value.length<10){
				alert("يجب عليك ان تكتب الرد لصاحب الشكوى");
			}
			else{
				frm.submit();
			}
		}
		DF.checkLock=function(frm){
			if(confirm("هل أنت متأكد بأن تريد قفل هذه الشكوى")){
				frm.action='svc.php?svc=complain&type=lock';
				frm.submit();
			}
		}
		</script>
		<?php
	
		echo"<br>
		<table cellSpacing=\"1\" cellPadding=\"4\" width=\"50%\" align=\"center\">
		<form method=\"post\" action=\"svc.php?svc=complain&type=reply\">
			<input type=\"hidden\" name=\"cid\" value=\"".c."\">
			<input type='hidden' name='redeclare' value=\"".rand."\">
			<tr>
				<td class=\"asHeader\" colspan=\"2\"><nobr>رد على الشكوى</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\" width=\"1%\"><nobr>عنوان الشكوى</nobr></td>
				<td class=\"asNormalB asAS12\"><nobr><a href=\"svc.php?svc=complain&type=read&c={$rs['id']}\">{$com['notetype']}</a></nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\" width=\"1%\"><nobr>نوع المشاركة</nobr></td>
				<td class=\"asNormalB asAS12\"><nobr><a href=\"{$com['posturl']}\" title=\"انقر هنا للذهاب الى المشاركة\">{$com['posttype']}</a></nobr></td>
			</tr>";
		if($rs['forumid']>0){
			echo"
			<tr>
				<td class=\"asFixedB\" width=\"1%\"><nobr>المنتدى</nobr></td>
				<td class=\"asNormalB asAS12\"><nobr>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</nobr></td>
			</tr>";
		}
			echo"
			<tr>
				<td class=\"asFixedB\"><nobr>حالة الشكوى</nobr></td>
				<td class=\"asNormalB asS12\"><nobr>{$complainstatus[$rs['status']]}</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>الشكوى على</nobr></td>
				<td class=\"asNormalB asAS12\"><nobr>{$Template->userColorLink($rs['userid'], array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor']))}</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>مرسل الشكوى</nobr></td>
				<td class=\"asNormalB asAS12 asS12 asDate\"><nobr>{$com['sendby']} - {$com['senddate']}</nobr></td>
			</tr>";
		if($rs['notetype'] == 0){
			echo"
			<tr>
				<td class=\"asFixedB\"><nobr>نص الشكوى</nobr></td>
				<td class=\"asNormalB asAS12 asS12\">".nl2br($rs['notetext'])."</td>
			</tr>";
		}
		if($rs['replyby']>0){
			echo"
			<tr>
				<td class=\"asFixedB\"><nobr>رد على الشكوى</nobr></td>
				<td class=\"asNormalB asAS12 asS12 asDate\"><nobr>{$com['replyby']} - {$com['replydate']}</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>نص الرد على الشكوى</nobr></td>
				<td class=\"asNormalB asAS12 asS12\">".nl2br($rs['replytext'])."</td>
			</tr>";
			if(trim($rs['admintext'])!=""){
				echo"
				<tr>
					<td class=\"asFixedB\"><nobr>نص الموجه للمدير</nobr></td>
					<td class=\"asNormalB asAS12 asS12\">".nl2br($rs['admintext'])."</td>
				</tr>";
			}
		}
		else{
			echo"
			<tr>
				<td class=\"asDarkB asCenter\" colspan=\"2\"><nobr>رد على صاحب الشكوى</nobr></td>
			</tr>
			<tr>
				<td class=\"asNormalB asCenter\" colspan=\"2\"><textarea style=\"width:400px;height:100px;\" name=\"replytext\"></textarea></td>
			</tr>
			<tr>
				<td class=\"asDarkB asCenter\" colspan=\"2\"><nobr>نص للمدير</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB asS12 asCenter\" colspan=\"2\"><nobr>ملاحظة: اذا تكتب نص للمدير, الشكوى سترسل للمدير بشكل تلقائي.</nobr></td>
			</tr>
			<tr>
				<td class=\"asNormalB asCenter\" colspan=\"2\"><textarea style=\"width:400px;height:100px;\" name=\"admintext\"></textarea></td>
			</tr>
			<tr>
				<td class=\"asNormalB asCenter\" colspan=\"2\">
					{$Template->button("رد على الشكوى"," onClick=\"DF.checkSubmit(this.form)\"")}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					{$Template->button("قفل الشكوى"," onClick=\"DF.checkLock(this.form)\"")}
				</td>
			</tr>";
		}
		echo"
		</form>
		</table>";
		if(ulv == 4){
			$mysql->update("complain SET adminread = 1 WHERE id = ".c."", __FILE__, __LINE__);
		}
	}
	else{
		$DF->goTo();
	}
}
elseif(type == 'reply'){
	$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في الرد على الشكوى");
	$c=(int)$_POST['cid'];
	$redeclare=$_POST['redeclare'];
	$replytext=$DF->cleanText($_POST['replytext']);
	$admintext=$DF->cleanText($_POST['admintext']);
	
	if($redeclare!=checkredeclare){
		$Template->errMsg("كان هناك خلل أثناء تخزين العملية!<br>يبدو أنه تم محاولة إدخال البيانات عدة مرات لسبب فني أو لخلل في الشبكة.<br>الرجاء التأكد من أن العملية انتهت بنجاح... نأسف على هذا.");
	}
	$allow=(ulv == 4 ? "" : "AND (".ulv." > 1 AND NOT ISNULL(m.id) OR ".ulv." = 3 AND c.monitor = ".uid.")");
	$rs=$mysql->queryAssoc("SELECT com.id,com.forumid,com.sendby,com.posttype,com.notetype,com.notetext,f.subject AS fsubject
	FROM ".prefix."complain AS com
	LEFT JOIN ".prefix."forum AS f ON(f.id = com.forumid)
	LEFT JOIN ".prefix."moderator AS m ON(NOT ISNULL(f.id) AND m.forumid = f.id AND m.userid = ".uid.")
	LEFT JOIN ".prefix."category AS c ON(NOT ISNULL(f.id) AND c.id = f.catid)
	WHERE com.id = $c $allow GROUP BY com.id", __FILE__, __LINE__);
	if($rs){
		$status=(!empty($admintext) ? 2 : 1);
		$mysql->update("complain SET status = $status, replyby = ".uid.", replytext = '$replytext', replydate = ".time.", admintext = '$admintext' WHERE id = $c", __FILE__, __LINE__);
		$notetext=($rs['notetype']>0 ? $posttype["{$rs['posttype']}"]." ".$notetype["{$rs['notetype']}"] : nl2br($rs['notetext']));
		$to=$rs['sendby'];
		$from="-{$rs['forumid']}";
		$subject="رد على ملاحظتك لإشراف منتدى {$rs['fsubject']}";
		$message="بخصوص ملاحظتك التالية الى إشراف منتدى {$rs['fsubject']}<br>==========================================<br>$notetext
		<br>----------------------------------------------------------------<br><br>
		لقد تم متابعة الملاحظة بواسطة فريق الاشراف والتالي نص الرد عليك<br>==========================================<br>".nl2br($replytext)."";
		$Template->sendpm($to,$from,$to,$subject,$message,uid);
		$Template->sendpm($from,$from,$to,$subject,$message,uid,1);
		$Template->msg("تم رد على الشكوى بنجاح");
	}
	else{
		$DF->goTo();
	}
}
elseif(type == 'lock'){
	$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في الرد على الشكوى");
	$c=(int)$_POST['cid'];
	$allow=(ulv == 4 ? "" : "AND (".ulv." > 1 AND NOT ISNULL(m.id) OR ".ulv." = 3 AND c.monitor = ".uid.")");
	$rs=$mysql->queryAssoc("SELECT com.id
	FROM ".prefix."complain AS com
	LEFT JOIN ".prefix."forum AS f ON(f.id = com.forumid)
	LEFT JOIN ".prefix."moderator AS m ON(NOT ISNULL(f.id) AND m.forumid = f.id AND m.userid = ".uid.")
	LEFT JOIN ".prefix."category AS c ON(NOT ISNULL(f.id) AND c.id = f.catid)
	WHERE com.id = $c $allow GROUP BY com.id", __FILE__, __LINE__);
	if($rs){
		$mysql->update("complain SET status = 0 WHERE id = $c", __FILE__, __LINE__);
		$Template->msg("تم قفل الشكوى بنجاح");
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