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

const _df_script = "options";
const _df_filename = "options.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
if( ulv > 0 ){
//************** start page ********************
if( type == "deleteuserlist" && u > 0 ){
	if( auth > 0 && ulv == 4 ){
		$uid = auth;
	}
	else{
		$uid = uid;
	}
	$sql = $mysql->query("SELECT items FROM ".prefix."listsrows WHERE id = {$uid}", __FILE__, __LINE__);
	$rs = $mysql->fetchRow($sql);
	$items = unserialize($rs[0]);
	$newArray = array();
	foreach( $items as $key => $val ){
		if( $key != u ){
			$newArray[$key] = $val;
		}
	}
	$mysql->update("listsrows SET items = '".serialize($newArray)."' WHERE id = '$uid'", __FILE__, __LINE__);
	$Template->msg("تم حذف العضوية من القائمة بنجاح");
}
elseif(type=="adduserlist"){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في إضافة عضو لقوائم الخاصة");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	$u=(int)$_POST['userid'];
	$auth=(int)$_POST['auth'];
	$list=(int)$_POST['list'];
	if($auth>0&&ulv==4){
		$uid=$auth;
	}
	else{
		$uid=uid;
	}
	$sql=$mysql->query("SELECT items FROM ".prefix."listsrows WHERE id = '$uid'", __FILE__, __LINE__);
	$rs=$mysql->fetchRow($sql);
	$items=unserialize($rs[0]);
	if(!$rs){
		$items=array();
		$mysql->insert("listsrows (id,items) VALUES ('$uid','".serialize($items)."')", __FILE__, __LINE__);
	}
	$keys=array_keys($items);
	if(in_array($u,$keys)&&$items[$u]==$list){
		$Template->errMsg("لا يمكنك إضافة هذا العضو لقوائم خاصة بك<br>بسبب ان هذا العضو هو مضاف لقوائمك مسبقاً");
	}
	else{
		$items[$u]=$list;
		$mysql->update("listsrows SET items = '".serialize($items)."' WHERE id = '$uid'", __FILE__, __LINE__);
		$Template->msg("تم إضافة عضو لقوائم خاصة بك بنجاح","profile.php?type=lists&l=$list".($auth>0?"&auth=$auth":""));
	}
}
elseif(type=="edituserlists"){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في تعديل قوائم خاصة");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	$auth=(int)$_POST['auth'];
	$list1=$DF->cleanText($_POST['list1']);
	$list2=$DF->cleanText($_POST['list2']);
	$list3=$DF->cleanText($_POST['list3']);
	$list4=$DF->cleanText($_POST['list4']);
	$list5=$DF->cleanText($_POST['list5']);
	$lists=array(1=>$list1,2=>$list2,3=>$list3,4=>$list4,5=>$list5);
	if($auth>0&&ulv==4){
		$uid=$auth;
	}
	else{
		$uid=uid;
	}
	$sql = $mysql->query("SELECT items FROM ".prefix."listsrows WHERE id = '$uid'", __FILE__, __LINE__);
	$rs = $mysql->fetchRow($sql);
	$items = unserialize($rs[0]);
	if( !$rs ){
		$new_items = [];
		$mysql->insert("listsrows (id,items) VALUES ('$uid','".serialize($new_items)."')", __FILE__, __LINE__);
	}
	else{
		$new_items = [];
		foreach( $items as $key => $val ){
			if( $val == -1 || $val == -2 || $val >= 1 && $val <= 5 && !empty($lists[$val]) ){
				$new_items[$key]=$val;
			}
		}
		$mysql->update("listsrows SET items = '".serialize($new_items)."' WHERE id = '$uid'", __FILE__, __LINE__);
	}
	$mysql->update("userflag SET lists = '".serialize($lists)."' WHERE id = '$uid'", __FILE__, __LINE__);
	$Template->msg("تم تعديل قوائم خاصة بك بنجاح");
}
elseif(type=="edituserfolders"){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في تعديل مجلدات البريدية");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	$auth=(int)$_POST['auth'];
	$fid=(int)$_POST['fid'];
	$list1=$DF->cleanText($_POST['list1']);
	$list2=$DF->cleanText($_POST['list2']);
	$list3=$DF->cleanText($_POST['list3']);
	$list4=$DF->cleanText($_POST['list4']);
	$list5=$DF->cleanText($_POST['list5']);
	$lists=array(1=>$list1,2=>$list2,3=>$list3,4=>$list4,5=>$list5);
	
	if($fid<0&&$is_moderator){
		$uid=$fid;
	}
	elseif($auth>0&&ulv==4){
		$uid=$auth;
	}
	else{
		$uid=uid;
	}
	
	foreach($lists as $key=>$val){
		if($key>=1&&$key<=5&&empty($val)){
			$mysql->update("pm SET pmlist = '0' WHERE author = '$uid' AND pmlist = '$key'", __FILE__, __LINE__);
		}
	}

	$checkTableName=($uid<0 ? 'forumflag' : 'userflag');
	$mysql->update("$checkTableName SET pmlists = '".serialize($lists)."' WHERE id = '".abs($uid)."'", __FILE__, __LINE__);
	$Template->msg("تم تعديل مجلداتك البريدية بنجاح");
}
elseif(type=="movepms"){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في نقل مجموعة من الرسائل من مجلد الى مجلد آخر");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	$pmid=$_POST['pmid'];
	$folder=$_POST['folder'];
	
	$error=false;
	if(is_array($pmid)){
		$ids="0";
		foreach($pmid as $val){
			$id=$DF->hashToNum($val);
			$ids.=",$id";
		}
		if($folder=='trash'){
			$mysql->update("pm SET status = 0 WHERE id IN ($ids)", __FILE__, __LINE__);
		}
		elseif($folder=='restore'){
			$mysql->update("pm SET status = 1, pmlist = 0 WHERE id IN ($ids)", __FILE__, __LINE__);
		}
		elseif($folder>=1&&$folder<=5){
			$mysql->update("pm SET pmlist = '$folder' WHERE id IN ($ids)", __FILE__, __LINE__);
		}
		else{
			$error=true;
		}
		if($folder=='restore'){
			$Template->msg("تم إسترجاع رسائل المختارة الى مجلداتهم الأصلية بنجاح");
		}
		else{
			$Template->msg("تم نقل الرسائل المختارة الى مجلد المختار بنجاح");
		}
	}
	else{
		$error=true;
	}
	if($error){
		$Template->errMsg("لم يتم نقل رسائل المختارة لسبب فني<br>الرجاء إخبار الإدارة لتصحيح المشكلة");
	}
}
elseif(type=="movepm"){
	if(f<0&&$is_moderator){
		$uid=f;
	}
	elseif(auth>0&&ulv==4){
		$uid=auth;
	}
	else{
		$uid=uid;
	}
	
	$pmid=$DF->hashToNum(pm);
	$sql=$mysql->query("SELECT id FROM ".prefix."pm WHERE id = '$pmid' AND author = '$uid'", __FILE__, __LINE__);
	$rs=$mysql->fetchRow($sql);
	if($rs){
		$mysql->update("pm SET status = 0 WHERE id = '$pmid'", __FILE__, __LINE__);
		$Template->msg("تم حذف الرسالة بنجاح");
	}
	else{
		$Template->errMsg("لا عندك تصريح لحذف هذه الرسالة");
	}
}
elseif(type=="restorepm"){
	if(f<0&&$is_moderator){
		$uid=f;
	}
	elseif(auth>0&&ulv==4){
		$uid=auth;
	}
	else{
		$uid=uid;
	}
	$pmid=$DF->hashToNum(pm);
	$sql=$mysql->query("SELECT id FROM ".prefix."pm WHERE id = '$pmid' AND author = '$uid'", __FILE__, __LINE__);
	$rs=$mysql->fetchRow($sql);
	if($rs){
		$mysql->update("pm SET status = 1 AND pmlist = 0 WHERE id = '$pmid'", __FILE__, __LINE__);
		$Template->msg("تم إسترجاع الرسالة الى مجلدها الأصلي بنجاح");
	}
	else{
		$Template->errMsg("لا عندك تصريح لإسترجاع هذه الرسالة");
	}
}
elseif(type=="topicusers"){
 	if(!$is_moderator){
		$DF->goTo();
		exit();
	}
	$sql=$mysql->query("SELECT t.subject,f.id AS forumid,f.subject AS fsubject
	FROM ".prefix."topic AS t
	LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
	WHERE t.id = '".t."'", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	?>
	<script type="text/javascript">
	var deleteIconUrl="<?=$DFImage->i['delete']?>";
	DF.checkSubmit=function(frm){
		var usersIds=(document.body.usersId?document.body.usersId:'');
		if(parseInt(frm.usersNum.value)>0){
			alert("توجد أرقام عضويات الذي تريد فتح لهم هذا الموضوع في خانة رقم العضوية\nلذا يجب عليك إضافتها الى القائمة حتى لا تخسر منها\nاو امسحها اذا لا تريد فتح لهم هذا الموضوع");
		}
		else if(usersIds.length==0){
			alert("أنت لم أضفت أي رقم للقائمة لفتح لهم هذا الموضوع");
		}
		else{
			frm.users.value=usersIds;
			frm.submit();
		}
	}
	DF.findValueInArray=function(arr,val){
		for(var x=0;x<arr.length;x++){
			if(arr[x]==val){
				return true;
			}
		}
		return false;
	};
	DF.deleteValInArray=function(arr,val){
		var newArr=new Array();
		for(var x=0;x<arr.length;x++){
			if(arr[x]!=val){
				newArr.push(arr[x]);
			}
		}
		return newArr;
	};
	DF.deleteUserIdFromList=function(id,type){
		var tab=$I('#'+type+'Table'),tr=$I('#'+type+'Row'+id),index=tr.rowIndex,dbArr=eval("document.body."+type+"Id");
		tab.deleteRow(index);
		dbArr=this.deleteValInArray(dbArr,id);
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
			if(!isNaN(id)&&id>0&&!DF.findValueInArray(dbArr,id)){
				this.addRowsToList(id);
				dbArr.push(id);
			}
			inp.value=0;
		}
		eval("document.body."+type+"Id=dbArr");
	};
	DF.deleteUserRow=function(id,type){
		var tab=$I('#usersDefTable'),tr=$I('#usersDefRow'+id);
		if(tab.rows.length>1){
			tab.deleteRow(tr.rowIndex);
		}
		if(tab.rows.length==1){
			var row=tab.insertRow(1);
			var cell=row.insertCell(0);
			cell.className='asNormalB asCenter';
			cell.colSpan=4;
			cell.innerHTML="<br>لا توجد أي عضو لرؤية هذا الموضوع<br><br>";
		}
	};
	DF.deleteUsersFromList=function(id){
		this.ajax.play({
			'send':'type=deleteUserFromTopic&forumid=<?=$rs['forumid']?>&id='+id,
			'func':function(){
				var obj=DF.ajax.oName,ac=DF.ajax.ac;
				if(obj.readyState==1||obj.readyState==2||obj.readyState==3){
					DF.loadingBox('<img src="'+progressUrl+'" border="0"><br><br>رجاً انتظر...',true);
				}
				else if(obj.readyState==4){
					var get=obj.responseText.split(ac)[0]||false;
					if(get==1){
						DF.deleteUserRow(id);
						DF.loadingBox('<img src="'+succeedUrl+'" border="0"><br><br>تم حذف العضو بنجاح.',true);
					}
					else{
						DF.loadingBox('<img src="'+errorUrl+'" border="0"><br><br><font color="red">حدث خطأ أثناء العملية.</font>',true);
					}
					setTimeout("DF.loadingBox('',false);",3000);
				}
			}
		});
	};
	</script>
	<?php
	echo"
	<table width=\"50%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader\" colspan=\"2\"><nobr>إضافة وحذف أعضاء مخولين لرؤية هذا الموضوع</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>المنتدى التابع له الموضوع</nobr></td>
			<td class=\"asNormalB\"><nobr>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</nobr></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عنوان الموضوع</nobr></td>
			<td class=\"asNormalB\"><nobr>{$Template->topicLink(t,$rs['subject'])}</nobr></td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\"><nobr>إضافة أعضاء</nobr></td>
		</tr>
		<form method=\"post\" action=\"options.php?type=insertusers\">
		<input type=\"hidden\" name=\"topicid\" value=\"".t."\">
		<input type=\"hidden\" name=\"redeclare\" value=\"".rand."\">
		<tr>
			<td class=\"asNormalB asS12 asCenter\" colspan=\"2\">
				<textarea style=\"display:none\" name=\"users\"></textarea><br>
				<input type=\"text\" style=\"width:150px;text-align:center\" id=\"usersNum\" name=\"usersNum\" value=\"0\" dir=\"ltr\"><br>
				{$Template->button("أضف رقم الى القائمة"," onClick=\"DF.addUserIdToList('users')\"")}
				<br><br><hr width=\"90%\">ملاحظة: اذا تريد ان تضاف اكثر من رقم اكتب ارقام هكذا <span dir=\"ltr\">1,2,3,4</span><hr width=\"90%\"><br>
				<table id=\"usersTable\" cellSpacing=\"1\" cellPadding=\"4\" width=\"50%\">
					<tr>
						<td class=\"asDarkB asCenter\" colspan=\"2\">قائمة أرقام عضويات مخولين لرؤية هذا الموضوع</td>
					</tr>
					<tr>
						<td class=\"asNormalB asS12 asCenter\"><br>لم يتم إضافة أي رقم للقائمة.<br><br></td>
					</tr>
				</table>
				<br>تنبيه: أرقام العضويات التي في قائمة أعلاه هي مؤقتة وبتحديث الصفحة سيتم تصفيرها.<br><br>
			</td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"2\">{$Template->button("إضافة أعضاء"," onClick=\"DF.checkSubmit(this.form)\"")}</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\"><nobr>الأعضاء مخولين لرؤية هذا الموضوع</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"2\"><br>
			<table id=\"usersDefTable\" width=\"30%\" cellpadding=\"4\" cellspacing=\"1\">
				<tr>
					<td class=\"asDarkB\"><nobr>رقم</nobr></td>
					<td class=\"asDarkB\"><nobr>اسم عضوية</nobr></td>
					<td class=\"asDarkB\"><nobr>أضف بواسطة</nobr></td>
					<td class=\"asDarkB\"><nobr>خيارات</nobr></td>
				</tr>";
			$sql=$mysql->query("SELECT tu.id,u.id AS uid,u.name AS uname,u.status AS ustatus,u.level AS ulevel,u.submonitor AS usubmonitor,
				uu.id AS aid,uu.name AS aname,uu.status AS astatus,uu.level AS alevel,uu.submonitor AS asubmonitor
			FROM ".prefix."topicusers AS tu
			LEFT JOIN ".prefix."user AS u ON(u.id = tu.userid)
			LEFT JOIN ".prefix."user AS uu ON(uu.id = tu.addby)
			WHERE tu.topicid = '".t."' ORDER BY tu.adddate DESC", __FILE__, __LINE__);
			$count=0;
			$addedUsers=0;
			while($urs=$mysql->fetchAssoc($sql)){
				echo"
				<tr id=\"usersDefRow{$urs['id']}\">
					<td class=\"asFixedB asS12 asCenter\"><nobr><b>{$urs['uid']}</b></nobr></td>
					<td class=\"asFixedB asAS12 asCenter\"><nobr>{$Template->userColorLink($urs['uid'], array($urs['uname'], $urs['ustatus'], $urs['ulevel'], $urs['usubmonitor']))}</nobr></td>
					<td class=\"asFixedB asAS12 asCenter\"><nobr>{$Template->userColorLink($urs['aid'], array($urs['aname'], $urs['astatus'], $urs['alevel'], $urs['asubmonitor']))}</nobr></td>
					<td class=\"asFixedB asCenter\"><nobr><a href=\"javascript:DF.deleteUsersFromList({$urs['id']})\"><img src=\"{$DFImage->i['delete']}\" border=\"0\"></a></nobr></td>
				</tr>";
				$addedUsers.=",{$urs['uid']}";
				$count++;
			}
			if($count==0){
				echo"
				<tr>
					<td class=\"asFixedB asCenter\" colspan=\"4\"><br>لا توجد أي عضو لرؤية هذا الموضوع<br><br></td>
				</tr>";
			}
			echo"
			</table><br>
			</td>
		</tr>
		<input type=\"hidden\" name=\"addedusers\" value=\"$addedUsers\">
		</form>
	</table>";
}
elseif(type=='insertusers'){
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في إضافة أعضاء لرؤية موضوع");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	
	$redeclare=(int)$_POST['redeclare'];
	$topicid=(int)$_POST['topicid'];
	$users=$DF->cleanText($_POST['users']);
	$addedusers=$DF->cleanText($_POST['addedusers']);
	
	$checkSqlField="";
	$checkSqlTable="";
	if(ulv<4){
		$checkSqlField=",IF(ISNULL(m.id),0,1) AS ismod";
		$checkSqlTable="LEFT JOIN ".prefix."moderator AS m ON(m.forumid = t.forumid AND m.userid = '".uid."')";
		if(ulv==3){
			$checkSqlField.=",IF(ISNULL(cc.id),0,1) AS ismon";
			$checkSqlTable.="LEFT JOIN ".prefix."category AS cc ON(cc.id = t.catid AND cc.monitor = '".uid."')";
		}
	}
	else{
		$checkSqlField="
			,IF(ISNULL(t.id),0,1) AS ismod
			,IF(ISNULL(t.id),0,1) AS ismon
		";
	}
 	$sql=$mysql->query("SELECT t.subject,f.id AS forumid,f.subject AS fsubject,c.id AS catid $checkSqlField
	FROM ".prefix."topic AS t
	LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
	LEFT JOIN ".prefix."category AS c ON(c.id = t.catid) $checkSqlTable
	WHERE t.id = '$topicid'", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	
	if(!$rs||!$rs['ismod']&&!$rs['ismon']){
		$DF->goTo();
		exit();
	}
	elseif($redeclare!=checkredeclare){
		$Template->errMsg("كان هناك خلل أثناء تخزين العملية!<br>يبدو أنه تم محاولة إدخال البيانات عدة مرات لسبب فني أو لخلل في الشبكة.<br>الرجاء التأكد من أن العملية انتهت بنجاح... نأسف على هذا.");
		exit();
	}
	
	$subject="تم فتح هذا الموضوع لك : {$rs['subject']}";
	$message="تم فتح الموضوع المخفي أدناه من قبل إشراف منتدى {$rs['fsubject']}<br>
	للزيارة والمشاركة انقر فوق عنوان الموضوع<br>
	<a href=\"topics.php?t=$topicid\">:: {$rs['subject']} ::</a>";
	if(!empty($users)){
		$sql=$mysql->query("SELECT id FROM ".prefix."user WHERE id IN ($users) AND id NOT IN ($addedusers) AND status = 1", __FILE__, __LINE__);
		while($urs=$mysql->fetchRow($sql)){
			$userid=$urs[0];
			$mysql->insert("topicusers (userid,topicid,forumid,catid,addby,adddate) VALUES ('$userid','$topicid','{$rs['forumid']}','{$rs['catid']}','".uid."','".time."')", __FILE__, __LINE__);
			$mysql->insert("pm (author,redeclare,pmfrom,pmto,subject,date) VALUES (
				'$userid','0','-{$rs['forumid']}','$userid','$subject','".time."'
			)", __FILE__, __LINE__);
			
			$sql2=$mysql->query("SELECT id FROM ".prefix."pm WHERE author = '$userid' AND pmfrom = '-{$rs['forumid']}' AND date = '".time."'", __FILE__, __LINE__);
			$pmrs=$mysql->fetchRow($sql2);
			
			$mysql->insert("pmmessage (id,message) VALUES (
				'$pmrs[0]','$message'
			)", __FILE__, __LINE__);
		}
	}
	$Template->msg("تم إضافة أعضاء لرؤية موضوع بنجاح");

}
elseif(type=='topicstats'){
	function optionLink($num,$url,$title='',$show=true){
		if($num>0&&$show){
			$title=(!empty($title) ? " title=\"$title\"" : "");
			$link="<a href=\"topics.php?t=".t."$url\"$title>$num</a>";
		}
		else{
			$link=$num;
		}
		return $link;
	}
	$checkSql=($is_monitor ? "" : "AND trash = 0");
	$topic=$mysql->queryRow("SELECT subject FROM ".prefix."topic WHERE id = '".t."' $checkSql", __FILE__, __LINE__);
	if($topic&&$is_moderator){
		echo"
		<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
			<tr>
				<td class=\"asTopHeader2\">
				<table cellSpacing=\"3\" cellPadding=\"3\">
					<tr>
						<td class=\"asC1\" width=\"1200\">إحصائيات ردود الأعضاء في الموضوع</td>";
						$Template->goToForum();
					echo"
					</tr>
				</table>
				</td>
			</tr>
		</table><br>
		<table width=\"50%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\" border=\"0\">
			<tr>
				<td class=\"asHeader\" colspan=\"7\">$topic[0]</td>
			</tr>
			<tr class=\"first\">
				<td class=\"asHiddenB asS12 asCenter\" colspan=\"7\">ملاحظة: لتصفح أي خيار إضغط على رقم الخيار</td>
			</tr>
			<tr>
				<td class=\"asDarkB\">العضو</td>
				<td class=\"asDarkB\">الردود<br>العادية</td>
				<td class=\"asDarkB\">محذوفة</td>
				<td class=\"asDarkB\">مخفية</td>
				<td class=\"asDarkB\">مجمدة</td>
				<td class=\"asDarkB\">تنتظر<br>الموافقة</td>
				<td class=\"asDarkB\">الإجمالي</td>
			</tr>";
		$sql=$mysql->query("SELECT p.author,p.trash,p.hidden,p.moderate,u.name AS aname,u.status AS astatus,
			u.level AS alevel,u.submonitor AS asubmonitor
		FROM ".prefix."post AS p
		LEFT JOIN ".prefix."user AS u ON(u.id = p.author)
		WHERE p.topicid = ".t." ORDER BY p.author ASC", __FILE__, __LINE__);
		$arr=array();
		while($rs=$mysql->fetchAssoc($sql)){
			$u=$rs['author'];
			if(!$arr[$u]){
				$arr[$u]['id']=$rs['author'];
				$arr[$u]['name']=$rs['aname'];
				$arr[$u]['status']=$rs['astatus'];
				$arr[$u]['level']=$rs['alevel'];
				$arr[$u]['submonitor']=$rs['submonitor'];
				$arr[$u]['normal']=0;
				$arr[$u]['trash']=0;
				$arr[$u]['hidden']=0;
				$arr[$u]['moderate']=0;
				$arr[$u]['hold']=0;
				$arr[$u]['count']=0;
			}
			if($rs['trash']==0&&$rs['hidden']==0&&$rs['moderate']==0){
				$arr[$u]['normal']++;
			}
			if($rs['trash']==1){
				$arr[$u]['trash']++;
			}
			if($rs['hidden']==1){
				$arr[$u]['hidden']++;
			}
			if($rs['moderate']==1){
				$arr[$u]['moderate']++;
			}
			if($rs['moderate']==2){
				$arr[$u]['hold']++;
			}
			$arr[$u]['count']++;
		}
		$count=0;
		$showTrash=($is_monitor ? true : false);
		$postRows=array('normal'=>0,'trash'=>0,'hidden'=>0,'moderate'=>0,'hold'=>0,'count'=>0);
		$arr=$DF->sort($arr,array(array('count','desc')));
		foreach($arr as $val){
			$u=$val['id'];
			$postRows['normal']+=$val['normal'];
			$postRows['trash']+=$val['trash'];
			$postRows['hidden']+=$val['hidden'];
			$postRows['moderate']+=$val['moderate'];
			$postRows['hold']+=$val['hold'];
			$postRows['count']+=$val['count'];
			echo"
			<tr>
				<td class=\"asFixedB asCenter\">{$Template->userColorLink($u, array($val['name'], $val['status'], $val['level'], $val['submonitor']))}</td>
				<td class=\"asNormalB asCenter\">".optionLink($val['normal'],"&u=$u&option=nr","إذهب الى ردود اعتيادية فقط للعضو {$val['name']}")."</td>
				<td class=\"asNormalB asCenter\">".optionLink($val['trash'],"&u=$u&option=dl","إذهب الى ردود محذوفة فقط للعضو {$val['name']}",$showTrash)."</td>
				<td class=\"asNormalB asCenter\">".optionLink($val['hidden'],"&u=$u&option=hd","إذهب الى ردود مخفية فقط للعضو {$val['name']}")."</td>
				<td class=\"asNormalB asCenter\">".optionLink($val['moderate'],"&u=$u&option=mo","إذهب الى ردود فقط ينتظر موافقة للعضو {$val['name']}")."</td>
				<td class=\"asNormalB asCenter\">".optionLink($val['hold'],"&u=$u&option=ho","إذهب الى ردود مجمدة فقط للعضو {$val['name']}")."</td>
				<td class=\"asFixedB asCenter\">".optionLink($val['count'],"&u=$u","إذهب الى جميع ردود العضو {$val['name']}")."</td>
			</tr>";
			$count++;
		}
		if($count>0){
			echo"
			<tr>
				<td class=\"asDarkB\">المجموع</td>
				<td class=\"asFixedB asCenter\">".optionLink($postRows['normal'],"&option=nr","إذهب الى جميع ردود اعتيادية في الموضوع")."</td>
				<td class=\"asFixedB asCenter\">".optionLink($postRows['trash'],"&option=dl","إذهب الى جميع ردود محذوفة في الموضوع",$showTrash)."</td>
				<td class=\"asFixedB asCenter\">".optionLink($postRows['hidden'],"&option=hd","إذهب الى جميع ردود مخفية في الموضوع")."</td>
				<td class=\"asFixedB asCenter\">".optionLink($postRows['moderate'],"&option=mo","إذهب الى جميع ردود ينتظر الموافقة في الموضوع")."</td>
				<td class=\"asFixedB asCenter\">".optionLink($postRows['hold'],"&option=ho","إذهب الى جميع ردود مجمدة في الموضوع")."</td>
				<td class=\"asFixedB asCenter\">".optionLink($postRows['count'],"","إذهب الى جميع ردود في الموضوع")."</td>
			</tr>";
		}
		else{
			echo"
			<tr>
				<td class=\"asNormalB asCenter\" colspan=\"7\"><br>لا توجد أي رد بالموضوع<br><br></td>
			</td>";
		}
		echo"
		</table><br>
		<div align=\"center\">{$Template->button("انقر هنا للعودة الى الموضوع"," onClick=\"document.location='topics.php?t=".t."';\"")}<div><br>";
	}
	else{
		$DF->goTo();
	}
}
elseif(type=='complain'){
	$cinfo=array(
		'findError'=>true,
		'forumid'=>0,
		'formurl'=>'',
		'post'=>'',
		'postname'=>''
	);
	$posttype=array(
		'topic'=>1,
		'post'=>2,
		'pm'=>3
	);
	$ctype=array(
		1=>'تحتوي على إشهار منتدي',
		2=>'تحتوي على صور غير لائقة',
		3=>'تحتوي على كلام غير لائق',
		4=>'تحتوي على شتم أو تهجم'
	);
	if(usendcomplain==0){
		$Template->errMsg("تم منعك من ارسال شكاوي على الاعضاء من قبل الإدارة");
	}
	if(u!=uid){
		$user=$mysql->queryRow("SELECT name,status,level,submonitor FROM ".prefix."user WHERE id = '".u."' AND status = 1", __FILE__, __LINE__);
		if($user){
			if(method=='topic'){
				$topic=$mysql->queryRow("SELECT subject,forumid FROM ".prefix."topic WHERE id = '".t."' AND author = '".u."'", __FILE__, __LINE__);
				if($topic){
					$allow=$DF->allowTopic(t);
					if($allow){
						$cinfo['post']['id']=t;
						$cinfo['post']['type']='topic';
						$cinfo['subject']=$Template->topicLink(t,$topic[0]);
						$cinfo['formurl']="options.php?type=complain&scope=yes&method=topic&u=".u."&t=".t;
						$cinfo['forumid']=$topic[1];
						$cinfo['postname']="الموضوع";
						$cinfo['findError']=false;
					}
				}
			}
			elseif(method=='post'){
				$post=$mysql->queryRow("SELECT t.id,t.subject,t.forumid FROM ".prefix."post AS p LEFT JOIN ".prefix."topic AS t ON(t.id = p.topicid) WHERE p.id = '".p."' AND p.author = '".u."'", __FILE__, __LINE__);
				if($post){
					$allow=$DF->allowPost(p);
					if($allow){
						$cinfo['post']['id']=p;
						$cinfo['post']['type']='post';
						$cinfo['subject']=$Template->topicLink($post[0],$post[1]);
						$cinfo['formurl']="options.php?type=complain&scope=yes&method=post&u=".u."&p=".p;
						$cinfo['forumid']=$post[2];
						$cinfo['postname']="المشاركة";
						$cinfo['findError']=false;
					}
				}
			}
			elseif(method=='pm'){
				$pmid=$DF->hashToNum(pm);
				$pm=$mysql->queryRow("SELECT subject FROM ".prefix."pm  WHERE id = '$pmid' AND author = '".uid."'", __FILE__, __LINE__);
				if($pm){
					$cinfo['post']['id']=$pmid;
					$cinfo['post']['type']='pm';
					$cinfo['subject']="<a href=\"pm.php?mail=read&pm=".pm."\"><b>$pm[0]</b></a>";
					$cinfo['formurl']="options.php?type=complain&scope=yes&method=pm&u=".u."&pm=".pm;
					$cinfo['forumid']=0;
					$cinfo['postname']="الرسالة";
					$cinfo['findError']=false;
				}
			}
		}
	}
	if($cinfo['findError']==true){
		$Template->errMsg("لا يمكنك انتباه مشرف عن هذه المشاركة<br>قد يكون هناك عدة إسباب لهذا منها:<br><br><table><tr><td>* رقم العضوية او الموضوع او الرد خاطيء.</td></tr><tr><td>* الموضوع او الرد مخفي او محذوف او مجمد او لم يتم موافقة عليه.</td></tr><tr><td>* عملت تغير عنوان وصلات بشكل يدوي وهذا ممنوع في منتدياتنا.</td></tr></table>");
	}
	if(scope=='yes'){
		$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في ارسال شكوى على الاعضاء");
		$forumid=(int)$_POST['forumid'];
		$notetype=(int)$_POST['notetype'];
		$notetext=$DF->cleanText($_POST['notetext']);
		$src=$_POST['src'];
		$redeclare=$_POST['redeclare'];
		if($redeclare!=checkredeclare){
			$Template->errMsg("كان هناك خلل أثناء تخزين العملية!<br>يبدو أنه تم محاولة إدخال البيانات عدة مرات لسبب فني أو لخلل في الشبكة.<br>الرجاء التأكد من أن العملية انتهت بنجاح... نأسف على هذا.");
		}
		elseif($forumid==$cinfo['forumid']&&$notetype>=0){
			$notetext=($notetype>0 ? '' : $notetext);
			$mysql->insert("complain (forumid,userid,postid,posttype,notetype,notetext,sendby,senddate) VALUES (
				'$forumid','".u."','{$cinfo['post']['id']}','{$posttype[$cinfo['post']['type']]}','$notetype','$notetext','".uid."','".time."'
			)", __FILE__, __LINE__);
			$DFOutput->setUserActivity('complain',(int)$forumid);
			$Template->msg("شكرا لك على إبداء ملاحظتك<br>سيتم متابعة الأمر بأسرع وقت ممكن",$src);
		}
		else{
			$Template->errMsg("حدث خطأ اثناء إبداء ملاحظتك<br>مرجوا اعادتها مرة اخرى");
		}
	}
	else{
		?>
		<script type="text/javascript">
		DF.chooseComplain=function(s){
			var frm=s.form,option=frm.notetype.options[frm.notetype.selectedIndex].value;
			if(option==0){
				frm.notetext.style.visibility='visible';
				frm.notetext.style.position='';
			}
			else{
				frm.notetext.style.visibility='hidden';
				frm.notetext.style.position='absolute';
			}
		};
		DF.checkSubmit=function(frm){
			var option = frm.notetype.options[frm.notetype.selectedIndex].value, text = frm.notetext.value.replace(/^\s+/, '').replace(/\s+$/, '');
			if(option==-1){
				alert("يجب عليك اختيار نوع الانتباه");
			}
			else if(option == 0 && text.length < 10){
				alert("يجب عليك كتابة ملاحظتك حول المشاركة في صندوق النص\nوان يكون لا اقل من 10 حروف");
			}
			else{
				frm.submit();
			}
		}
		</script>
		<?php
		echo"<br>
		<table width=\"50%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\">
		<form method=\"post\" action=\"{$cinfo['formurl']}\">
			<input type=\"hidden\" name=\"forumid\" value=\"{$cinfo['forumid']}\">
			<input type=\"hidden\" name=\"src\" value=\"".src."\">
			<input type='hidden' name='redeclare' value=\"".rand."\">
			<tr>
				<td class=\"asHeader\" colspan=\"2\"><nobr>لفت انتباهك للمشرف عن هذه المشاركة وسيتم متابعتها بأسرع وقت ممكن</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\" width=\"1%\"><nobr>عنوان</nobr></td>
				<td class=\"asNormalB\">{$cinfo['subject']}</td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>صاحب المشاركة</nobr></td>
				<td class=\"asNormalB\">{$Template->userColorLink(u,$user)}</td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>نوع الانتباه</nobr></td>
				<td class=\"asNormalB\">
				<select class=\"asGoTo\" style=\"width:350px\" name=\"notetype\" onchange=\"DF.chooseComplain(this);\">
					<option value=\"-1\" selected>-- اختر نوع الانتباه --</option>
					<option value=\"1\">{$cinfo['postname']} $ctype[1]</option>
					<option value=\"2\">{$cinfo['postname']} $ctype[2]</option>
					<option value=\"3\">{$cinfo['postname']} $ctype[3]</option>
					<option value=\"4\">{$cinfo['postname']} $ctype[4]</option>
					<option value=\"0\">ملاحظة آخرى (مرجو الكتابة في صندوق الادناه)</option>
				</select><br>
				<textarea style=\"width:350px;height:200px;visibility:hidden;position:absolute\" name=\"notetext\"></textarea>
				</td>
			</tr>
			<tr>
				<td class=\"asNormalB asCenter\" colspan=\"2\">{$Template->button("أرسل ملاحظتك"," onClick=\"DF.checkSubmit(this.form)\"")}</td>
			</tr>
		</form>
		</table>";
	}
}
elseif(type=='survey'){
	$topic=$mysql->queryAssoc("SELECT t.forumid,f.subject AS fsubject,t.subject,t.survey
	FROM ".prefix."topic AS t
	LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
	WHERE t.id = ".t."", __FILE__, __LINE__);
	$forums=$DF->getAllowForumId();
	if(ulv==4||in_array($topic['forumid'],$forums)){
		echo"<br>
		<table width=\"40%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<form method=\"post\" action=\"options.php?type=setsurvey&t=".t."\">
		<input type=\"hidden\" name=\"topicid\" value=\"".t."\">
			<tr>
				<td class=\"asHeader\" colspan=\"2\">إضافة أو إزالة إستفتاء للموضع</td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>المنتدى</nobr></td>
				<td class=\"asNormalB\"><nobr>{$Template->forumLink($topic['forumid'],$topic['fsubject'])}</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>الموضوع</nobr></td>
				<td class=\"asNormalB\"><nobr>{$Template->topicLink(t,$topic['subject'])}</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>إستفتاءات</nobr></td>
				<td class=\"asNormalB\">
				<select class=\"asGoTo\" name=\"surveyid\">
					<option value=\"0\"> -- لا إستفتاء لهذا الموضوع -- </option>";
				$sql=$mysql->query("SELECT id,question FROM ".prefix."survey WHERE forumid = {$topic['forumid']}", __FILE__, __LINE__);
				while($rs=$mysql->fetchRow($sql)){
					echo"
					<option value=\"$rs[0]\"{$DF->choose($rs[0],$topic['survey'],'s')}>$rs[1]</option>";
				}
				echo"
				</select>
				</td>
			</tr>
			<tr>
				<td class=\"asNormalB asCenter\" colspan=\"2\">{$Template->button("حفظ"," onClick=\"this.form.submit();\"")}</td>
			</tr>
		</form>
		</table>
		</center>";
	}
	else{
		$DF->goTo();
	}
}
elseif(type=='checkedit'){
	$topic=$mysql->queryAssoc("SELECT t.forumid,f.subject AS fsubject,t.subject
	FROM ".prefix."topic AS t
	LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
	WHERE t.id = ".t."", __FILE__, __LINE__);
	$f = $mysql->get("topic","forumid",t);
	$forums=$DF->getAllowForumId();
	if(ulv==4||in_array($f,$forums)){
		echo"<br>
		<table width=\"76%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<form method=\"post\" action=\"options.php?type=setsurvey&t=".t."\">
		<input type=\"hidden\" name=\"topicid\" value=\"".t."\">
			<tr>
				<td class=\"asHeader\" colspan=\"4\">التغيرات على الموضوع</td>
			</tr>
			<tr>
				<td class=\"asFixedB\"><nobr>الموضوع</nobr></td>
				<td class=\"asNormalB\" colspan=\"3\"><nobr>{$Template->topicLink(t,$topic['subject'])}</nobr></td>
			</tr>
			<tr>
				<td class=\"asFixedB asCenter\" colspan=\"4\">إضغط على رقم التغير</td>
							</tr>
							<tr>
				<td class=\"asNormalB asCenter\" width=\"10%\">العضو</td>
				<td class=\"asNormalB asCenter\" width=\"5%\">التغير</td>
				<td class=\"asNormalB asCenter\">العنوان</td>
				<td class=\"asNormalB asCenter\" width=\"20%\">التاريخ</td>
				";
				$sql=$mysql->query("SELECT userid,date,id,subject FROM ".prefix."topicedit WHERE topicid = ".t." ", __FILE__, __LINE__);
				$count = 0;
				$xx = 1;
				while($rs=$mysql->fetchRow($sql)){
					echo"
					<tr>
						<td class=\"asNormalB asCenter\">{$Template->userColorLink($rs[0])}</td>
						<td class=\"asNormalB asCenter\"><a href=\"options.php?type=showedit&id=$rs[2]\">".$xx."</td>
						<td class=\"asNormalB asCenter\">$rs[3]</td>
						<td class=\"asNormalB asCenter\">{$DF->date($rs[1])}</td>
					</tr>";
					$xx++;
					$count++;
				}
				if($count==0){
					echo"
					<tr>
						<td class=\"asNormal asCenter\" colspan=\"4\"><br>لا توجد أي تغيرات على هذا الموضوع<br><br></td>
					</tr>";
				}
				echo"
				</td>
			</tr>
		
		</form>
		</table>
		</center>";
	}
	else{
		$DF->goTo();
	}
}

elseif(type=='showedit'){
	$t = $mysql->get("topicedit","topicid",id);
	$topic=$mysql->queryAssoc("SELECT t.forumid,f.subject AS fsubject
	FROM ".prefix."topic AS t
	LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
	WHERE t.id = ".$t."", __FILE__, __LINE__);
	$forums=$DF->getAllowForumId();
	if(ulv==4||in_array($topic['forumid'],$forums)){
		echo"<br>
		<table width=\"76%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<form method=\"post\" action=\"options.php?type=setsurvey&t=".t."\">
		<input type=\"hidden\" name=\"topicid\" value=\"".t."\">
			<tr>
				<td class=\"asHeader\" colspan=\"4\">التغيرات على الموضوع</td>
			</tr>
			
			<tr>
				<td class=\"asFixedB asCenter\" colspan=\"4\"><a href=\"options.php?type=checkedit&t=$t\">-- الرجوع إلى التغيرات --</td>
							</tr>
		
				";
				$sql=$mysql->query("SELECT userid,date,id,subject,message FROM ".prefix."topicedit WHERE id = ".id." ", __FILE__, __LINE__);
				$x = 1;
				while($rs=$mysql->fetchRow($sql)){
					echo"	
				<tr>
				<td class=\"asFixedB\"><nobr>العضو</nobr></td>
				<td class=\"asNormalB\" colspan=\"3\"><nobr>{$Template->userColorLink($rs[0])}</nobr></td>
				</tr>
				<tr>
				<td class=\"asFixedB\"><nobr>التاريخ</nobr></td>
				<td class=\"asNormalB\" colspan=\"3\"><nobr>{$DF->date($rs[1])}</nobr></td>
				</tr>
				<tr>
				<td class=\"asFixedB\"><nobr>العنوان</nobr></td>
				<td class=\"asNormalB\" colspan=\"3\"><nobr>$rs[3]</nobr></td>
			</tr>
					
					<tr>
		
				<td class=\"asNormalB asCenter\" colspan=\"3\">$rs[4]</td>
			</tr>";
					$x++;
				}
				echo"
				</select>
				</td>
			</tr>
		
		</form>
		</table>
		</center>";
	}
	else{
		$DF->goTo();
	}
}
elseif(type=='setsurvey'){
	$topicid=(int)$_POST['topicid'];
	$surveyid=(int)$_POST['surveyid'];
	$rs=$mysql->queryRow("SELECT forumid FROM ".prefix."topic WHERE id = $topicid", __FILE__, __LINE__);
	$forums=$DF->getAllowForumId();
	if(ulv==4||in_array($rs[0],$forums)){
		$mysql->update("topic SET survey = $surveyid WHERE id = $topicid", __FILE__, __LINE__);
		$Template->msg("تم حفظ التغيرات بنجاح");
	}
	else{
		$DF->goTo();
	}
}
else{
	$DF->goTo();
}
//********* end page **********************
}
else{
	$DF->goTo();
}
$Template->footer();
?>