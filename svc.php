<?php
/*//////////////////////////////////////////////////////////
// ######################################################///
// # DuhokForum 1.1                                     # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #   ========= Programming By Dilovan ==============  # //
// # Copyright © 2007-2009 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # If you want any support vist down address:-        # //
// # Email: df@duhoktimes.com                           # //
// # Site: http://df.duhoktimes.com/index.php           # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

if(mlv > 1){ // just mod or up
require_once("./include/svc_func.df.php");
require_once("./include/moderation_func.df.php");
?>
<script language="javascript">
	var check_flag = "false";
	function check(checked, alert_msg){
		if(check_flag == "false"){
			var count = 0;
			for (i = 0; i < checked.length; i++){
				checked[i].checked = true;
				if(checked[i].type == "checkbox"){
					count += 1;
				}
			}
			check_flag = "true";
			alert(alert_msg+": "+count);
			return "إلغاء التحديد الكل";
		}
		else {
			for (i = 0; i < checked.length; i++){
				checked[i].checked = false;
			}
			check_flag = "false";
			return "تحديد الكل";
		}
	}
</script>
<?php

if(method != "insert" AND method != "update" AND method != "app" AND method != "in" AND method != "trash"){
	echo'
	<center>
	<table cellSpacing="1" cellPadding="2" width="99%" border="0">
		<tr>
			<td class="optionsbar_menus" width="100%">&nbsp;<nobr><font color="red" size="+1">خدمات الإشراف</font></nobr></td>
			<td class="optionsbar_menus" vAlign="top"><nobr><a href="index.php?mode=svc&method=svc&svc=medals">قائمة<br>أوسمة التميز</a></nobr></td>
			<td class="optionsbar_menus" vAlign="top"><nobr><a href="index.php?mode=svc&svc=medals">أوسمة التميز<br>الممنوحة</a></nobr></td>
			<td class="optionsbar_menus" vAlign="top"><nobr><a href="index.php?mode=svc&method=svc&svc=titles">قائمة<br>الأوصاف</a></nobr></td>
			<td class="optionsbar_menus" vAlign="top"><nobr><a href="index.php?mode=svc&method=svc&svc=surveys">الإستفتاءات</a></nobr></td>
			<td class="optionsbar_menus" vAlign="top"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel=1&show=cur">الرقابة<br>والمنع</a></nobr></td>
			<td class="optionsbar_menus" vAlign="top"><nobr><a href="index.php?mode=members&type=lock">عضويات<br>مقفولة</a></nobr></td>';
		if(method == "svc" AND svc == "medals"){
			echo multi_page("GLOBAL_MEDALS ".chk_global_medals_get(), $max_page);
		}
		if(method == "svc" AND svc == "titles"){
			echo multi_page("GLOBAL_TITLES ".chk_global_titles_get(), $max_page);
		}
		if(method == "" AND svc == "medals"){
			echo multi_page("MEDALS ".chk_medals_get(), $max_page);
		}
		go_to_forum();
		echo'
		</tr>
	</table>
	</center><br>';
}

if(method == ""){
	if(svc == "medals"){
?>
<script language="javascript">
	function on_app(obj){
		var box = obj.form.elements;
		var count = 0;
		for (i = 0; i < box.length; i++){
			if(box[i].type == "checkbox" && box[i].checked == true){
				count += 1;
			}
		}
		if(count > 0){
			obj.form.status.value = "app";
			obj.form.submit();
		}
		else{
			confirm("يجب عليك أن تختار على الأقل وسام واحد ليتم موافقة عليه.");
			return;
		}
	}
	function on_ref(obj){
		var box = obj.form.elements;
		var count = 0;
		for (i = 0; i < box.length; i++){
			if(box[i].type == "checkbox" && box[i].checked == true){
				count += 1;
			}
		}
		if(count > 0){
			obj.form.status.value = "ref";
			obj.form.submit();
		}
		else{
			confirm("يجب عليك أن تختار على الأقل وسام واحد ليتم رفضه.");
			return;
		}
	}
</script>
<?php
		if(empty($app)){
			$app = "ok";
		}
		else{
			$app = $app;
		}
		if(empty($scope)){
			$scope = "mod";
		}
		else{
			$scope = $scope;
		}
		if(empty($days)){
			$days = 30;
		}
		else{
			$days = $days;
		}
		if(empty($id)){
			define(chk_id, "");
		}
		else{
			define(chk_id, "&id=".$id);
		}
		if(empty($m)){
			define(chk_m, "");
		}
		else{
			define(chk_m, "&m=".$m);
		}

		echo'
		<center>
		<table>
			<tr>
				<td class="stats_menu'.chk_cmd($scope, "mod", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&svc=medals&app='.$app.'&scope=mod&days='.$days.chk_id.chk_m.'">المنتديات التي تشرف عليها</a></td>
				<td class="stats_menu'.chk_cmd($scope, "own", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&svc=medals&app='.$app.'&scope=own&days='.$days.chk_id.chk_m.'">الأوسمة التي منحتها أنت</a></td>
				<td class="stats_menu'.chk_cmd($scope, "all", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&svc=medals&app='.$app.'&scope=all&days='.$days.chk_id.chk_m.'">جميع الأوسمة</a></td>
			</tr>
		</table>
		<table>
			<tr>
				<td class="stats_menu'.chk_cmd($app, "wait", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&svc=medals&app=wait&scope='.$scope.'&days='.$days.chk_id.chk_m.'">أوسمة تنتظر الموافقة</a></td>
				<td class="stats_menu'.chk_cmd($app, "ok", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&svc=medals&app=ok&scope='.$scope.'&days='.$days.chk_id.chk_m.'">أوسمة تمت الموافقة عليها</a></td>
				<td class="stats_menu'.chk_cmd($app, "ref", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&svc=medals&app=ref&scope='.$scope.'&days='.$days.chk_id.chk_m.'">أوسمة تم رفضها</a></td>
				<td class="stats_menu'.chk_cmd($app, "all", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&svc=medals&app=all&scope='.$scope.'&days='.$days.chk_id.chk_m.'">جميع الأوسمة</a></td>
			</tr>
		</table>
		<table>
			<tr>
				<td class="stats_menu'.chk_cmd($days, 30, "Sel").'"><a class="stats_menu" href="index.php?mode=svc&svc=medals&app='.$app.'&scope='.$scope.'&days=30'.chk_id.chk_m.'">آخر 30 يوم</a></td>
				<td class="stats_menu'.chk_cmd($days, 60, "Sel").'"><a class="stats_menu" href="index.php?mode=svc&svc=medals&app='.$app.'&scope='.$scope.'&days=60'.chk_id.chk_m.'">آخر 60 يوم</a></td>
				<td class="stats_menu'.chk_cmd($days, 180, "Sel").'"><a class="stats_menu" href="index.php?mode=svc&svc=medals&app='.$app.'&scope='.$scope.'&days=180'.chk_id.chk_m.'">آخر 6 أشهر</a></td>
				<td class="stats_menu'.chk_cmd($days, 365, "Sel").'"><a class="stats_menu" href="index.php?mode=svc&svc=medals&app='.$app.'&scope='.$scope.'&days=365'.chk_id.chk_m.'">آخر سنة</a></td>
				<td class="stats_menu'.chk_cmd($days, "all", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&svc=medals&app='.$app.'&scope='.$scope.'&days=all'.chk_id.chk_m.'">جميع الأوسمة</a></td>
			</tr>
		</table>
		</center><br>';

		if($app == "wait"){
			$get_title = "أوسمة تميز - تنتظر الموافقة";
		}
		if($app == "ok"){
			$get_title = "أوسمة تميز - تمت الموافقة عليها";
		}
		if($app == "ref"){
			$get_title = "أوسمة تميز - تم رفضها";
		}
		if($app == "all"){
			$get_title = "أوسمة تميز - جميع الأوسمة";
		}

		if(chk_member_id($m) == 1){
			echo'
			<p align="center">
			<b>
			<font color="red" size="-1">تعرض حاليا أوسمة عضو معين فقط:<br></font>
			<font size="+1"><a href="index.php?mode=profile&id='.$m.'">'.members("NAME", $m).'</a></font>
			</b>
			</p>';
		}
		if(chk_gm_id($id) == 1){
			echo'
			<p align="center">
			<b>
			<font color="red" size="-1">تعرض حاليا وسام معين فقط:<br>الرقم الوسام:</font>
			<font size="+1" color="black">'.$id.'</font>
			</b>
			</p>';
		}

		echo'
		<center>
		<table cellSpacing="1" cellPadding="2">
		<form name="app_medals" method="post" action="index.php?mode=svc&method=app&svc=medals&type=awarded">
		<input type="hidden" name="status">
			<tr>
				<td class="optionsbar_menus" colSpan="15"><font color="red" size="+1">'.$get_title.'</font></td>
			</tr>
			<tr>';
			if(mlv > 2){
				echo'
				<td class="stats_h">&nbsp;</td>';
			}
				echo'
				<td class="stats_h"><nobr>العضو</nobr></td>
				<td class="stats_h"><nobr>التاريخ</nobr></td>
				<td class="stats_h"><nobr>يعرض حتى</nobr></td>
				<td class="stats_h"><nobr>الشعار الممنوح</nobr></td>
				<td class="stats_h">&nbsp;</td>
				<td class="stats_h"><nobr>النقاط</nobr></td>';
			if($app == "all"){
				echo'
				<td class="stats_h"><nobr>الموافقة</nobr></td>';
			}
				echo'
				<td class="stats_h"><nobr>المنتدى</nobr></td>
				<td class="stats_h"><nobr>منح الشعار</nobr></td>
				<td class="stats_h" colspan="2"><nobr>&nbsp;</nobr></td>
			</tr>';
		$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEDALS ".chk_medals_get()." ORDER BY MEDAL_ID DESC LIMIT ".pg_limit($max_page).", $max_page", [], __FILE__, __LINE__);
		$num = mysql_num_rows($sql);
		$x = 0;
		while ($x < $num){
			$m_id = mysql_result($sql, $x, "MEDAL_ID");
			$f = medals("FORUM_ID", $m_id);
			$status = medals("STATUS", $m_id);
			svc_show_medals($m_id);
			$count = $count + 1;
			if(allowed($f, 1) == 1 AND $status != 1){
				$count_chk = $count_chk + 1;
			}
		++$x;
		}
		if($count_chk > 0){
			echo'
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="optionsbar_menus" colspan="15">
					<input type="button" value="تحديد الكل" onclick="this.value=check(this.form.elements, \'عدد أوسمة الذي اخترت\')">&nbsp;&nbsp;
					<input onclick="on_app(this)" type="button" value="موافقة على الأوسمة المختارة">&nbsp;&nbsp;';
				if($app != "ref"){
					echo'
					<input onclick="on_ref(this)" type="button" value="رفض الأوسمة المختارة">';
				}
					echo'
					</td>
			</tr>';
		}
		if($count == 0){
			echo'
			<tr>
				<td class="stats_p" align="center" colspan="15"><br><font color="red">-- لا توجد أيه أوسمة بهذه المواصفات --</font><br><br></td>
			</tr>';
		}
		echo'
		</form>
		</table>
		</center><br>';
	}
	if(svc == "titles"){
		echo'
		<center>
		<table cellSpacing="1" cellPadding="2">
			<tr>
				<td class="optionsbar_menus" colSpan="15"><font size="+1">الأوصاف الحالية للعضو : <font color="red">'.members("NAME", $m).'</font></font></td>
			</tr>
			<tr>
				<td class="stats_h"><nobr>الرقم</nobr></td>
				<td class="stats_h"><nobr>الوصف</nobr></td>
				<td class="stats_h"><nobr>يعرض في<br>جميع<br>المنتديات</nobr></td>
				<td class="stats_h"><nobr>المنتدى</nobr></td>
				<td class="stats_h">الخيارات</td>
			</tr>';
		$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TITLES WHERE MEMBER_ID = '$m' AND STATUS = '1' ORDER BY TITLE_ID DESC", [], __FILE__, __LINE__);
		$num = mysql_num_rows($sql);
		$x = 0;
		while ($x < $num){
			$t_id = mysql_result($sql, $x, "TITLE_ID");
			svc_show_titles($t_id);
			$count = $count + 1;
		++$x;
		}
		if($count == 0){
			echo'
			<tr>
				<td class="stats_p" align="center" colspan="15"><br><font color="red">-- لا توجد أي وصف لهذا العضو --</font><br><br></td>
			</tr>';
		}
		echo'
		</table>
		</center><br>';
	}
	if(svc == "prv"){
		$f = topics("FORUM_ID", $t);
		$t_hide = topics("HIDDEN", $t);
		if(allowed($f, 2) == 1){
			if($t_hide == 1){
				$f_subject = forums("SUBJECT", $f);
				$t_subject = topics("SUBJECT", $t);
				echo'
				<script language="javascript">
					function submit_form(){
						if(tm_info.m.value == ""){
							confirm("أنت لم دخلت أي رقم في خانة رقم العضوية");
							return;
						}
						var regex = /^[0-9]/;
						if(!regex.test(tm_info.m.value)){
							confirm("يجب عليك إدخال رقم فقط في خانة رقم العضوية");
							return;
						}
						tm_info.submit();
					}
				</script>
				<center>
				<table width="70%" cellSpacing="1" cellPadding="1" border="0">
				<form name="tm_info" method="post" action="index.php?mode=svc&method=insert&svc=prv">
				<input type="hidden" name="f" value="'.$f.'">
				<input type="hidden" name="t" value="'.$t.'">
					<tr>
						<td align="center" class="stats_t" style="FONT-WEIGHT: bold; BACKGROUND: #008000" colspan="5">
							<font size="4" color="yellow">قوائم الأعضاء المخولون برؤية مواضيع مخفية</font><br>
							<font size="4" color="white">'.$f_subject.'</font><br>
							<font size="4" color="white">الموضوع رقم: '.$t.'</font>
						</td>
					</tr>
					<tr>
						<td align="center" class="stats_h" align="middle" width="25%"><font size="3">رقم الموضوع: '.$t.'</font></td>
						<td align="center" class="stats_t" align="middle" width="25%"></td>
						<td align="center" class="stats_h" align="middle" width="50%"><nobr>لإضافة عضو لهذا الموضوع أدخل رقم العضو هنا: 
							<input class="submit" type="text" name="m" size="10">
							<input onclick="submit_form()" type="button" class="submit" value="أضف">
						</nobr></td>
					</tr>
					<tr>
						<td class="stats_g" width="100%" colspan="5">عنوان الموضوع: '.$t_subject.'</td>
					</tr>
					<tr>
						<td align="center" class="stats_p" width="100%" colspan="5"><br>
						<table width="40%" cellSpacing="1" cellPadding="1" border="1">
							<tr>
								<td class="stats_h" align="center">العضو</td>
								<td class="stats_h" align="center">أضيف بواسطة</td>
								<td class="stats_h" align="center">تاريخ الاضافة</td>
								<td class="stats_h" align="center">خيارات</td>
							</tr>';
						$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPIC_MEMBERS WHERE TOPIC_ID = '$t' ORDER BY DATE ASC", [], __FILE__, __LINE__);
						$num = mysql_num_rows($sql);
						if($num == 0){
							echo'
							<tr>
								<td vAlign="center" align="middle" colspan="20"><br>لا يوجد أي عضو حاليا في القائمة<br><br></td>
							</tr>';
						}
						$x = 0;
						while ($x < $num){
							$tm = mysql_result($sql, $x, "TM_ID");
							$m = topic_members("MEMBER_ID", $tm);
							$added = topic_members("ADDED", $tm);
							$date = topic_members("DATE", $tm);
							echo'
							<tr>
								<td align="center"><font size="2"><nobr>'.member_color_link($m).'</nobr></font></td>
								<td align="center"><font size="2"><nobr>'.member_color_link($added).'</nobr></font></td>
								<td align="center"><font size="2"><nobr>'.normal_date($date).'</nobr></font></td>
								<td align="center"><font size="2"><a href="index.php?mode=svc&method=trash&svc=prv&id='.$tm.'">'.icons($icon_trash, "حذف العضو من القائمة", "hspace=\"2\"").'</a></font></td>
							</tr>';
						++$x;
						}
						echo'
						</table>
						</td>
					</tr>
				</form>
				</table>
				</center>';
			}
			else{
				error_message("يجب عليك إخفاء الموضوع أولاً");
			}
		}
	}
	if(svc == "edits"){
		if($t != ""){
		$f = topics("FORUM_ID", $t);
		}
		else if($r != ""){
		$f = replies("FORUM_ID", $r);
		}

		if(allowed($f, 2) == 1){	
			echo'
			<center>
			<table cellSpacing="1" cellPadding="1" border="0">';
			if($t != ""){
			svc_topic_edits($t);
			}
			else if($r != ""){
			svc_reply_edits($r);
			}
			echo'
			</table>
			</center>';
		}
	}
	if(svc == "tstats"){
		$f = topics("FORUM_ID", $t);
		if(allowed($f, 2) == 1){	
			echo'
			<center>
			<table cellSpacing="1" cellPadding="2" border="0">
				<tr>
					<td bgColor="green" Align="center" colSpan="7"><font size="+1" color="yellow">إحصائيا ردود الأعضاء في الموضوع رقم: '.$t.'</font></td>
				</tr>
				<tr>
					<td class="stats_h">العضو</td>
					<td class="stats_h"><font color="yellow">الردود<br>العادية</font></td>
					<td class="stats_h"><font color="#AAFFAA">محذوفة</font></td>
					<td class="stats_h"><font color="#AAFFAA">مخفية</font></td>
					<td class="stats_h"><font color="#AAFFAA">مجمدة</font></td>
					<td class="stats_h"><font color="#AAFFAA">تنتظر<br>الموافقة</font></td>
					<td class="stats_h">الإجمالي</td>
				</tr>';
			$sql = $mysql->execute("SELECT DISTINCT R_AUTHOR FROM {$mysql->prefix}REPLY WHERE TOPIC_ID = '$t'", [], __FILE__, __LINE__);
			$num = mysql_num_rows($sql);
			if($num <= 0){
				echo'
				<tr>
					<td class="stats_h" colSpan="7">لا يوجد اي ردود في هذا الموضوع</td>
				</tr>';
			}
			$x = 0;
			while ($x < $num){
				$author = mysql_result($sql, $x, "R_AUTHOR");
				echo'
				<tr>
					<td class="stats_p">'.link_profile(member_name($author), $author).'</td>
					<td class="stats_g" align="center">'.member_replies_in_topic($author, $t, "NORMAL").'</td>
					<td class="stats_t" align="center"><font color="white">'.member_replies_in_topic($author, $t, "DELETED").'</font></td>
					<td class="stats_t" align="center"><font color="white">'.member_replies_in_topic($author, $t, "HIDDEN").'</font></td>
					<td class="stats_t" align="center"><font color="white">'.member_replies_in_topic($author, $t, "HOLDED").'</font></td>
					<td class="stats_t" align="center"><font color="white">'.member_replies_in_topic($author, $t, "UNMODERATED").'</font></td>
					<td class="stats_p" align="center"><font color="black">'.member_replies_in_topic($author, $t, "TOTAL").'</font></td>
				</tr>';
			++$x;
			}
			echo'
				<tr>
					<td colSpan="7" Align="center"><br><input class="small" type="button" onclick="JavaScript:history.go(-1)" value="اضغط هنا للعودة الى الموضوع">
				</tr>
			</table>
			</center>';
		}
	}
}

if(method == "details"){
	if(svc == "edits"){
		if(type == "t"){
			$t = edits("TOPIC_ID", $id);
			$f = topics("FORUM_ID", $t);
			if(allowed($f, 2) == 1){
			svc_topic_edits_details($id, $n);
			}
		}
		if(type == "r"){
			$r = edits("REPLY_ID", $id);
			$f = replies("FORUM_ID", $r);
			if(allowed($f, 2) == 1){
			svc_reply_edits_details($id, $n);
			}
		}		
	}
}

if(method == "svc"){
	if(svc == "medals"){

?>
<script language="javascript">
	function on_submit(obj){
		var box = obj.form.elements;
		var count = 0;
		for (i = 0; i < box.length; i++){
			if(box[i].type == "checkbox" && box[i].checked == true){
				count += 1;
			}
		}
		if(count > 0){
			obj.form.submit();
		}
		else{
			confirm("يجب عليك أن تختار على الأقل وسام واحد ليتم موافقة عليه");
			return;
		}
	}
</script>
<?php

		if(empty($app)){
			$app = "ok";
		}
		else{
			$app = $app;
		}
		if(empty($scope)){
			$scope = "mod";
		}
		else{
			$scope = $scope;
		}

		if($app == "design"){
			$the_title = "تحت التصميم";
		}
		if($app == "wait"){
			$the_title = "تنتظر الموافقة";
		}
		if($app == "ok"){
			$the_title = "مفتوحة";
		}
		if($app == "closed"){
			$the_title = "مقفولة";
		}
			echo'
			<center>
			<table>
				<tr>
					<td class="stats_menu'.chk_cmd($scope, "mod", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=medals&app='.$app.'&scope=mod">المنتديات التي تشرف عليها</a></td>
					<td class="stats_menu'.chk_cmd($scope, "own", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=medals&app='.$app.'&scope=own">الأوسمة التي إضفتها أنت</a></td>
					<td class="stats_menu'.chk_cmd($scope, "all", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=medals&app='.$app.'&scope=all">جميع الأوسمة</a></td>
				</tr>
			</table>
			<table>
				<tr>
					<td class="stats_menu'.chk_cmd($app, "design", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=medals&app=design&scope='.$scope.'">أوسمة تحت التصميم</a></td>
					<td class="stats_menu'.chk_cmd($app, "wait", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=medals&app=wait&scope='.$scope.'">أوسمة تنتظر الموافقة</a></td>
					<td class="stats_menu'.chk_cmd($app, "ok", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=medals&app=ok&scope='.$scope.'">أوسمة مفتوحة</a></td>
					<td class="stats_menu'.chk_cmd($app, "closed", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=medals&app=closed&scope='.$scope.'">أوسمة مقفولة</a></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td class="stats_menuCmd"><a class="stats_menu" href="index.php?mode=svc&method=add&svc=medals">أضف وسام جديد</a></td>
				</tr>
			</table><br>';
			echo'
			<table dir="rtl" cellSpacing="1" cellPadding="4">
			<form name="app_medals" method="post" action="index.php?mode=svc&method=app&svc=medals&type=global">
				<tr>
					<td class="optionsbar_menus" colSpan="10"><font color="red" size="+1">أوسمة التميز - '.$the_title.'</font></td>
				</tr>
				<tr>';
				if(mlv > 2){
					echo'
					<td class="stats_h"><nobr>&nbsp;</nobr></td>';
				}
					echo'
					<td class="stats_h"><nobr>الرقم</nobr></td>
					<td class="stats_h"><nobr>الوصف</nobr></td>
					<td class="stats_h">&nbsp;</td>
					<td class="stats_h"><nobr>نقاط<br>التميز</nobr></td>
					<td class="stats_h"><nobr>موافقة<br>عليه</nobr></td>
					<td class="stats_h"><nobr>المنتدى</nobr></td>
					<td class="stats_h"><nobr>يعرض<br>لمدة<br>(أيام)</nobr></td>
					<td class="stats_h"><nobr>أضاف <br>الوسام</nobr></td>
					<td class="stats_h">&nbsp;</td>
				</tr>';
			$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}GLOBAL_MEDALS ".chk_global_medals_get()." ORDER BY SUBJECT ASC LIMIT ".pg_limit($max_page).", $max_page", [], __FILE__, __LINE__);
			$num = mysql_num_rows($sql);
			$x = 0;
			while ($x < $num){
				$m = mysql_result($sql, $x, "MEDAL_ID");
				$f = gm("FORUM_ID", $m);
				$status = gm("STATUS", $m);
				svc_show_global_medals($m);
				$count = $count + 1;
				if(allowed($f, 1) == 1 AND $status != 1){
					$count_chk = $count_chk + 1;
				}
			++$x;
			}
			if($count_chk > 0){
				echo'
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td class="optionsbar_menus" colspan="10"><input type="button" value="تحديد الكل" onclick="this.value=check(this.form.elements, \'عدد أوسمة الذي اخترت\')">&nbsp;&nbsp;<input onclick="on_submit(this)" type="button" value="موافقة على الأوسمة المختارة"></td>
				</tr>';
			}
			if($count == 0){
				echo'
				<tr>
					<td class="stats_p" align="center" colspan="10"><br><font color="red">-- لا توجد أيه أوسمة بهذه المواصفات --</font><br><br></td>
				</tr>';
			}
			echo'
			</form>
			</table>
			</center><br>';

	}
	if(svc == "titles"){
		?>
		<script language="javascript">
			function on_submit(obj){
				var box = obj.form.elements;
				var count = 0;
				for (i = 0; i < box.length; i++){
					if(box[i].type == "checkbox" && box[i].checked == true){
						count += 1;
					}
				}
				if(count > 0){
					obj.form.submit();
				}
				else{
					confirm("يجب عليك أن تختار على الأقل وصف واحد ليتم موافقة عليه");
					return;
				}
			}
		</script>
		<?
		if(empty($app)){
			$app = "ok";
		}
		else{
			$app = $app;
		}
		if(empty($scope)){
			$scope = "mod";
		}
		else{
			$scope = $scope;
		}

		if($app == "design"){
			$the_title = "تحت التصميم";
		}
		if($app == "wait"){
			$the_title = "تنتظر الموافقة";
		}
		if($app == "ok"){
			$the_title = "مفتوحة";
		}
		if($app == "closed"){
			$the_title = "مقفولة";
		}
		if($app == "all"){
			$the_title = "جميع أوصاف";
		}
		echo'
		<center>
		<table>
			<tr>
				<td class="stats_menuCmd"><a class="stats_menu" href="index.php?mode=svc&method=add&svc=titles">أضف وصف جديد</a></td>
			</tr>
		</table>
		<table>
			<tr>
				<td class="stats_menu'.chk_cmd($scope, "mod", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=titles&app='.$app.'&scope=mod">المنتديات التي تشرف عليها</a></td>
				<td class="stats_menu'.chk_cmd($scope, "own", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=titles&app='.$app.'&scope=own">الأوصاف التي إضفتها أنت</a></td>
				<td class="stats_menu'.chk_cmd($scope, "all", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=titles&app='.$app.'&scope=all">جميع الأوصاف</a></td>
			</tr>
		</table>
		<table>
			<tr>
				<td class="stats_menu'.chk_cmd($app, "design", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=titles&app=design&scope='.$scope.'">أوصاف تحت التصميم</a></td>
				<td class="stats_menu'.chk_cmd($app, "wait", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=titles&app=wait&scope='.$scope.'">أوصاف تنتظر الموافقة</a></td>
				<td class="stats_menu'.chk_cmd($app, "ok", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=titles&app=ok&scope='.$scope.'">أوصاف مفتوحة</a></td>
				<td class="stats_menu'.chk_cmd($app, "closed", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=titles&app=closed&scope='.$scope.'">أوصاف مقفولة</a></td>
				<td class="stats_menu'.chk_cmd($app, "all", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=titles&app=all&scope='.$scope.'">جميع الأوصاف</a></td>
			</tr>
		</table><br>';

		echo'
		<table cellSpacing="1" cellPadding="2">
		<form name="app_medals" method="post" action="index.php?mode=svc&method=app&svc=titles&type=global">
			<tr>
				<td class="optionsbar_menus" colSpan="15"><font color="red" size="+1">قائمة الأوصاف - '.$the_title.'</font></td>
			</tr>
			<tr>';
			if(mlv > 2){
				echo'
				<td class="stats_h"><nobr>&nbsp;</nobr></td>';
			}
				echo'
				<td class="stats_h"><nobr>الرقم</nobr></td>
				<td class="stats_h"><nobr>الوصف</nobr></td>
				<td class="stats_h"><nobr>يعرض في<br>جميع<br>المنتديات</nobr></td>
				<td class="stats_h"><nobr>المنتدى</nobr></td>
				<td class="stats_h"><nobr>أضاف<br>الوصف</nobr></td>
				<td class="stats_h" colspan="2">خيارات</td>
			</tr>';

			$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}GLOBAL_TITLES ".chk_global_titles_get()." ORDER BY SUBJECT ASC LIMIT ".pg_limit($max_page).", $max_page", [], __FILE__, __LINE__);
			$num = mysql_num_rows($sql);
			$x = 0;
			while ($x < $num){
				$t = mysql_result($sql, $x, "TITLE_ID");
				$f = gt("FORUM_ID", $t);
				$status = gt("STATUS", $t);
				svc_show_global_titles($t);
				$count = $count + 1;
				if(allowed($f, 1) == 1 AND $status != 1){
					$count_chk = $count_chk + 1;
				}
			++$x;
			}
			if($count_chk > 0){
				echo'
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td class="optionsbar_menus" colspan="15"><input type="button" value="تحديد الكل" onclick="this.value=check(this.form.elements, \'عدد أوصاف الذي اخترت\')">&nbsp;&nbsp;<input onclick="on_submit(this)" type="button" value="موافقة على الأوصاف المختارة"></td>
				</tr>';
			}
			if($count == 0){
				echo'
				<tr>
					<td class="stats_p" align="center" colspan="15"><br><font color="red">-- لا توجد أي أوصاف بهذه المواصفات --</font><br><br></td>
				</tr>';
			}

		echo'
		</form>
		</table>
		</center><br>';
	}
	if(svc == "surveys"){
		if(empty($app)){
			$app = "running";
		}
		else{
			$app = $app;
		}
		echo'
		<center>
		<table>
			<tr>
				<td class="stats_menu'.chk_cmd($app, "running", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=surveys&app=running">إستفتاءات جارية الآن</a></td>
				<td class="stats_menu'.chk_cmd($app, "ended", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=surveys&app=ended">إستفتاءات إنتهت</a></td>
				<td class="stats_menu'.chk_cmd($app, "closed", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=surveys&app=closed">إستفتاءات مغلقة</a></td>
				<td class="stats_menu'.chk_cmd($app, "all", "Sel").'"><a class="stats_menu" href="index.php?mode=svc&method=svc&svc=surveys&app=all">جميع لإستفتاءات</a></td>
				<td></td><td></td><td></td><td></td>
				<td class="stats_menuCmd"><a class="stats_menu" href="index.php?mode=svc&method=add&svc=surveys">أضف إستفتاء جديد</a></td>
			</tr>
		</table>
		<table cellSpacing="1" cellPadding="0">
			<tr>
				<td class="optionsbar_menus" colSpan="15"><font color="red" size="+1">الإستفتاءات</font></td>
			</tr>
			<tr>
				<td class="stats_h"><nobr>الرقم</nobr></td>
				<td class="stats_h"><nobr>العنوان</nobr></td>
				<td class="stats_h"><nobr>المنتدى</nobr></td>
				<td class="stats_h"><nobr>تاريخ البداية</nobr></td>
				<td class="stats_h"><nobr>تاريخ الإنتهاء</nobr></td>
				<td class="stats_h">السرية</td>
				<td class="stats_h"><nobr>مشاركات العضو<br>المطلوبة للتصويت</nobr></td>
				<td class="stats_h"><nobr>الأيام منذ تسجيل<br>العضو المطلوبة للتصويت</nobr></td>
				<td class="stats_h">خيارات</td>
			</tr>';
		$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}SURVEYS ".chk_surveys_get($_GET)." ORDER BY SUBJECT ASC LIMIT ".pg_limit($max_page).", $max_page", [], __FILE__, __LINE__);
		$num = mysql_num_rows($sql);
		$x = 0;
		while ($x < $num){
			$s = mysql_result($sql, $x, "SURVEY_ID");
			svc_show_surveys($s);
			$count = $count + 1;
		++$x;
		}
		if($count == 0){
			echo'
			<tr>
				<td class="stats_p" align="center" colspan="15"><br><font color="red">-- لا توجد أي إستفتاء بهذه المواصفات --</font><br><br></td>
			</tr>';
		}
		echo'
		</table>
		</center>';
	}

	if(svc == "mon"){
		switch ($sel){
		     case "1": $where_type = "WHERE M_TYPE = '1'"; $text = "رقابة في منتدى معين"; break;
		     case "2": $where_type = "WHERE M_TYPE = '2'"; $text = "رقابة في كل المنتديات"; break;
		     case "3": $where_type = "WHERE M_TYPE = '3'"; $text = "منع في منتدى معين"; break;
		     case "4": $where_type = "WHERE M_TYPE = '4'"; $text = "منع على جميع المنتديات"; break;
		     case "5": $where_type = "WHERE M_TYPE = '5'"; $text = "طلب قفل العضوية"; break;
		     case "6": $where_type = "WHERE M_TYPE = '6'"; $text = "منع النقاش الحي"; break;
		     case "7": $where_type = "WHERE M_TYPE = '7'"; $text = "إخفاء البيانات الشخصية"; break;
		     case "8": $where_type = "WHERE M_TYPE = '8'"; $text = "إخفاء المشاركات"; break;
		     case "9": $where_type = "WHERE M_TYPE = '9'"; $text = "إخفاء الرسائل الخاصة"; break;
		     case "10": $where_type = "WHERE M_TYPE = '10'"; $text = "منع الرسائل الخاصة"; break;
		}
		switch ($show){
		     case "mon_pending": $where_status = "WHERE M_STATUS = '0' AND"; $text = "طلبات تنتظر الموافقة"; $text2 = "من المراقب"; break;
		     case "all": $where_status = "WHERE"; $text = "عرض كل الرقابات"; break;
		     case "cur": $where_status = "AND M_STATUS = '1'  AND"; $text2 = "سارية حاليا"; break;
		     case "own": $where_status = "AND M_STATUS = '1' AND M_EXECUTE = '$DBMemberID' AND"; $text2 = "سارية من قبلك"; break;
		     case "exp": $where_status = "AND M_STATUS = '3' AND"; $text2 = "تم إلغاؤها"; break;
		     case "pending": $where_status = "AND M_STATUS = '0'  AND"; $text2 = "طلبات تنتظر المراجعة"; break;
		     case "approved": $where_status = "AND M_STATUS = '1'  AND"; $text2 = "طلبات مقبولة"; break;
		     case "rejected": $where_status = "AND M_STATUS = '2'  AND"; $text2 = "طلبات مرفوضة"; break;
		}
		if($sel == "" AND $show != "all" AND $show != "mon_pending"){
		    $empty_sel = "WHERE MODERATION_ID";
		}
		if($sel != "" AND $show != ""){
    		    $texte = $text." - ".$text2;
		}
		else {
    		    $texte = $text." ".$text2;
		}
		echo'
		<center>
		<table width="100%" cellSpacing="0" cellPadding="0">
			<tr>
				<td>
				<table cellSpacing="2" cellPadding="3" align="center">
					<tr>';
					if($Mlevel > 2){
						echo'<td class="'.monOptionclass("mon_pending", $show, "stats_menuCmd").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&show=mon_pending">طلبات تنتظر الموافقة</a></nobr></td>';
					}
						echo'<td class="'.monOptionclass("all", $show, "stats_menuCmd").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&show=all">عرض كل الرقابات</a></nobr></td>
					</tr>
				</table>
				<table cellSpacing="2" cellPadding="3" align="center">
					<tr>
						<td class="'.monOptionclass("1", $sel, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel=1&show=cur">رقابة في منتدى معين</a></nobr></td>
						<td class="'.monOptionclass("2", $sel, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel=2&show=cur">رقابة في كل المنتديات</a></nobr></td>
						<td class="'.monOptionclass("3", $sel, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel=3&show=cur">منع في منتدى معين</a></nobr></td>
						<td class="'.monOptionclass("4", $sel, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel=4&show=cur">منع على جميع المنتديات</a></nobr></td>
						<td class="'.monOptionclass("6", $sel, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel=6&show=cur">منع النقاش الحي</a></nobr></td>
						<td class="'.monOptionclass("7", $sel, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel=7&show=cur">إخفاء البيانات الشخصية</a></nobr></td>
						<td class="'.monOptionclass("8", $sel, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel=8&show=cur">إخفاء المشاركات</a></nobr></td>
						<td class="'.monOptionclass("9", $sel, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel=9&show=cur">إخفاء الرسائل الخاصة</a></nobr></td>
						<td class="'.monOptionclass("10", $sel, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel=10&show=cur">منع الرسائل الخاصة</a></nobr></td>
						<td></td>
						<td class="'.monOptionclass("5", $sel, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel=5&show=cur">طلب قفل العضوية</a></nobr></td>
					</tr>
				</table>
				<table cellSpacing="2" cellPadding="3" align="center">
					<tr>
						<td class="'.monOptionclass("cur", $show, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel='.$sel.'&show=cur">سارية حاليا</a></nobr></td>
						<td class="'.monOptionclass("own", $show, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel='.$sel.'&show=own">سارية من قبلك</a></nobr></td>
						<td class="'.monOptionclass("exp", $show, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel='.$sel.'&show=exp">تم إلغاؤها</a></nobr></td>
						<td class="'.monOptionclass("pending", $show, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel='.$sel.'&show=pending">طلبات تنتظر المراجعة</a></nobr></td>
						<td class="'.monOptionclass("approved", $show, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel='.$sel.'&show=approved">طلبات مقبولة</a></nobr></td>
						<td class="'.monOptionclass("rejected", $show, "stats_menuSel").'"><nobr><a href="index.php?mode=svc&method=svc&svc=mon&sel='.$sel.'&show=rejected">طلبات مرفوضة</a></nobr></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		<table cellSpacing="1" cellPadding="1">
			<tr>
				<td class="optionsbar_menus" colSpan="20"><font color="red" size="4">'.$texte.'</font></td>
			</tr>
			<tr>
				<td class="stats_h"><nobr></nobr></td>
				<td class="stats_h"><nobr>العضو</nobr></td>
				<td class="stats_h"><nobr>النوع</nobr></td>
				<td class="stats_h"><nobr>المنتدى</nobr></td>
				<td class="stats_h" colspan="2"><nobr>تقديم<br>الطلب</nobr></td>
				<td class="stats_h"><nobr>رفض<br>الطلب</nobr></td>
				<td class="stats_h" colspan="2"><nobr>تطبيق</nobr></td>
				<td class="stats_h" colspan="2"><nobr>إالغاء</nobr></td>
				<td class="stats_h"><nobr></nobr>الأيام</td>
				<td class="stats_h"><nobr></nobr></td>
			</tr>';
		$sql = " SELECT * FROM {$mysql->prefix}MODERATION ";
		$sql .= " ".$empty_sel." ".$where_type." ".$where_status." M_FORUMID IN (".chk_allowed_forums_all_id().") ";
		$sql .= " ORDER BY M_DATE DESC ";

		if($sel == 10){
		$sql = " SELECT * FROM {$mysql->prefix}MODERATION ";
		$sql .= " ".$empty_sel." ".$where_type." ".$where_status." M_PM > 0 ";
		$sql .= " ORDER BY M_DATE DESC ";
		}

		$result = $mysql->execute($sql, $connection, [], __FILE__, __LINE__);
		$num = mysql_num_rows($result);
		if($num == 0){
			echo'
			<tr>
				<td class="stats_h" align="center" colspan="13"><br><font size="3">لا يوجد رقابات مطابقة للخيارات التي إخترت</font><br><br></td>
			</tr>';
		}
		else {
		$x=0;
		while ($x < $num){
		$m = mysql_result($result, $x, "MODERATION_ID");
		svc_show_mon($m);
		++$x;
		}
		}
		echo'
		</table>
		</center>';
	}
}

if(method == "award"){
	if(svc == "medals"){
		if($type == ""){
			echo'
			<center>
			<table cellSpacing="1" cellPadding="2">
				<tr>
					<td class="optionsbar_menus"><font size="+1">إختار المنتدى الذي تريد منح شعار تميز منه للعضو:<br><font color="red">'.members("NAME", $m).'</font></font></td>
				</tr>';
			$all_forums = chk_allowed_forums();
			for($x = 0; $x < count($all_forums); $x++){
				$f_id = $all_forums[$x];
				echo'
				<tr>
					<td class="stats_p"><a href="index.php?mode=svc&method=award&svc=medals&type=award&f='.$f_id.'&m='.$m.'">'.forums("SUBJECT", $f_id).'</a>&nbsp;&nbsp;<font color="red">('.forum_medal_count($f_id).')</font></td>
				</tr>';
			}
			echo'
			</table>
			</center><br>';
		}
		if($type == "award"){
			if(allowed($f, 2) == 1){
				echo'
				<center>
				<table cellSpacing="1" cellPadding="0">
					<tr>
						<td class="optionsbar_menus" colSpan="15"><font size="+1">إختار شعار تميز من القائمة أدناه لمنحه للعضو: <font color="red">'.members("NAME", $m).'</font></font></td>
					</tr>
					<tr>
						<td class="stats_h"><nobr>الرقم</nobr></td>
						<td class="stats_h"><nobr>الوصف</nobr></td>
						<td class="stats_h">صورة<br>الوسام</td>
						<td class="stats_h"><nobr>نقاط<br>التميز</nobr></td>
						<td class="stats_h"><nobr>المنتدى</nobr></td>
						<td class="stats_h"><nobr>يعرض <br>لمدة<br>(أيام)</nobr></td>
						<td class="stats_h"><nobr>أضاف <br>الوسام</nobr></td>
						<td class="stats_h">خيارات</td>
					</tr>';
				$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}GLOBAL_MEDALS WHERE FORUM_ID = '$f' AND STATUS = '1' AND CLOSE = '0' ORDER BY SUBJECT ASC", [], __FILE__, __LINE__);
				$num = mysql_num_rows($sql);
				$x = 0;
				while ($x < $num){
					$m_id = mysql_result($sql, $x, "MEDAL_ID");
					svc_award_global_medals($m_id);
					$count = $count + 1;
				++$x;
				}
				if($count == 0){
					echo'
					<tr>
						<td class="stats_p" align="center" colspan="15"><br><font color="red">-- لا توجد أي شعار التميز الجاهز لهذا المنتدى --</font><br><br></td>
					</tr>';
				}
				echo'
				</table>
				</center><br>';
			}
		}
	}
	if(svc == "titles"){
		if($type == ""){
			echo'
			<center>
			<table cellSpacing="1" cellPadding="2">
				<tr>
					<td class="optionsbar_menus"><font size="+1">إختار المنتدى الذي تريد إضافة وصف منه للعضو:<br><font color="red">'.members("NAME", $m).'</font></font></td>
				</tr>';
			$all_forums = chk_allowed_forums();
			for($x = 0; $x < count($all_forums); $x++){
				$f_id = $all_forums[$x];
				echo'
				<tr>
					<td class="stats_p"><a href="index.php?mode=svc&method=award&svc=titles&type=award&f='.$f_id.'&m='.$m.'">'.forums("SUBJECT", $f_id).'</a>&nbsp;&nbsp;<font color="red">('.forum_title_count($f_id).')</font></td>
				</tr>';
			}
			echo'
			</table>
			</center><br>';
		}
		if($type == "award"){
			if(allowed($f, 2) == 1){
				echo'
				<center>
				<table cellSpacing="1" cellPadding="2">
					<tr>
						<td class="optionsbar_menus" colSpan="15"><font size="+1">إختار وصف من القائمة أدناه لإضافته للعضو: <font color="red">'.members("NAME", $m).'</font></font></td>
					</tr>
					<tr>
						<td class="stats_h"><nobr>الرقم</nobr></td>
						<td class="stats_h"><nobr>الوصف</nobr></td>
						<td class="stats_h">يعرض في<br>جميع<br>المنتديات</td>
						<td class="stats_h"><nobr>المنتدى</nobr></td>
						<td class="stats_h">خيارات</td>
					</tr>';
				$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}GLOBAL_TITLES WHERE FORUM_ID = '$f' AND STATUS = '1' AND CLOSE = '0' ORDER BY SUBJECT ASC", [], __FILE__, __LINE__);
				$num = mysql_num_rows($sql);
				$x = 0;
				while ($x < $num){
					$t_id = mysql_result($sql, $x, "TITLE_ID");
					svc_award_global_titles($t_id);
					$count = $count + 1;
				++$x;
				}
				if($count == 0){
					echo'
					<tr>
						<td class="stats_p" align="center" colspan="15"><br><font color="red">-- لا توجد أي وصف جاهز لهذا المنتدى --</font><br><br></td>
					</tr>';
				}
				echo'
				</table>
				</center><br>';
			}
		}
		if($type == "used"){
			$f = gt("FORUM_ID", $id);
			if(allowed($f, 2) == 1){
				echo'
				<center>
				<table cellSpacing="1" cellPadding="0">
					<tr>
						<td class="optionsbar_menus" colSpan="10"><font size="+1">إستخدام الوصف رقم : '.$id.'<br><font color="red">'.gt("SUBJECT", $id).'</font></font></td>
					</tr>';
			$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TITLES WHERE GT_ID = '$id' AND STATUS = '1' ORDER BY TITLE_ID DESC", [], __FILE__, __LINE__);
			$num = mysql_num_rows($sql);
			if($num > 0){
					echo'
					<tr>
						<td colSpan="10">&nbsp;</td>
					</tr>
					<tr>
						<td class="optionsbar_menus" colSpan="10"><font size="+1">الأعضاء الذين لهم هذا الوصف حاليا</font></td>
					</tr>';
				$x = 0;
				while ($x < $num){
					$t = mysql_result($sql, $x, "TITLE_ID");
					$m = titles("MEMBER_ID", $t);
					echo'
					<tr>
						<td class="stats_p">'.link_profile(members("NAME", $m), $m).'</td>
						<td class="stats_g" align="center">
							<a href="index.php?mode=svc&method=award&svc=titles&type=history&m='.$m.'&t='.$id.'">'.icons($icon_question, "تاريخ إستخدام الوصف لهذا العضو", " hspace=\"3\"").'</a>
							<a href="index.php?mode=svc&method=trash&svc=titles&t='.$t.'">'.icons($icon_trash, "إزالة الوصف من العضو", " hspace=\"3\"").'</a>
						</td>
					</tr>';
				++$x;
				}
			}
			$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TITLES WHERE GT_ID = '$id' AND STATUS = '0' ORDER BY TITLE_ID DESC", [], __FILE__, __LINE__);
			$num = mysql_num_rows($sql);
			if($num > 0){
					echo'
					<tr>
						<td colSpan="10">&nbsp;</td>
					</tr>
					<tr>
						<td class="optionsbar_menus" colSpan="10"><font color="red" size="+1">الأعضاء الذين وضع لهم هذا الوصف سابقا</font></td>
					</tr>';
				$x = 0;
				while ($x < $num){
					$t = mysql_result($sql, $x, "TITLE_ID");
					$m = titles("MEMBER_ID", $t);
					echo'
					<tr>
						<td class="stats_p">'.link_profile(members("NAME", $m), $m).'</td>
						<td class="stats_g" align="center">
							<a href="index.php?mode=svc&method=award&svc=titles&type=history&m='.$m.'&t='.$id.'">'.icons($icon_question, "تاريخ إستخدام الوصف لهذا العضو", " hspace=\"3\"").'</a>
						</td>
					</tr>';
				++$x;
				}
			}
				echo'
				</table>
				</center><br>';
			}
		}
		if($type == "history"){
			$f = gt("FORUM_ID", $t);
			if(allowed($f, 2) == 1){
				echo'
				<center>
				<table cellSpacing="1" cellPadding="0">
					<tr>
						<td class="optionsbar_menus" colSpan="10">
							<font size="+1">
								تاريخ إستخدام الوصف رقم : '.$t.'<br>
								<font color="red">'.gt("SUBJECT", $t).'</font><br>
								للعضو رقم: '.$m.'<br>
								'.link_profile(members("NAME", $m), $m).'
							</font>
						</td>
					</tr>';
			$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}USED_TITLES WHERE MEMBER_ID = '$m' AND TITLE_ID = '$t' ORDER BY DATE ASC", [], __FILE__, __LINE__);
			$num = mysql_num_rows($sql);
			if($num > 0){
					echo'
					<tr>
						<td class="stats_h">التاريخ والوقت</td>
						<td class="stats_h">النوع</td>
						<td class="stats_h">قام بالعملية</td>
					</tr>';
				$x = 0;
				while ($x < $num){
					$id = mysql_result($sql, $x, "ID");
					$status = ut("STATUS", $id);
					$added = ut("ADDED", $id);
					$date = ut("DATE", $id);
					if($status == 1){
						$add_status = '<font color="yellow">منح الوصف</font>';
					}
					if($status == 0){
						$add_status = '<font color="white">إزالة الوصف</font>';
					}
					echo'
					<tr>
						<td class="stats_g"><nobr>'.date_and_time($date, 1).'</nobr></td>
						<td class="stats_t">'.$add_status.'</td>
						<td class="stats_p">'.link_profile(members("NAME", $added), $added).'</td>
					</tr>';
				++$x;
				}
			}
			else{
					echo'
					<tr>
						<td class="stats_h" colSpan="10" align="center"><br>لم يتم إستخدام هذا الوصف<br><br></td>
					</tr>';
			}
				echo'
				</table>
				</center><br>';
			}
		}
	}
	if(svc == "surveys"){
		$subject = surveys("SUBJECT", $s);
		$f = surveys("FORUM_ID", $s);
		if(allowed($f, 2) == 1){
			echo'
			<center>
			<table cellSpacing="1" cellPadding="2">
				<tr>
					<td class="optionsbar_menus" colSpan="11"><font size="+1">الأعضاء الذين قامو بالتصويت في الاستفتاء رقم: '.$s.'</font><br><font color="red" size="+1">'.$subject.'</font></td>
				</tr>
				<tr>
					<td class="stats_h"><nobr>رقم العضو</nobr></td>
					<td class="stats_h"><nobr>اسم العضو</nobr></td>
					<td class="stats_h"><nobr>الخيار الذي صوت له</nobr></td>
					<td class="stats_h"><nobr>تاريخ التصويت</nobr></td>
				</tr>';
			$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}VOTES WHERE SURVEY_ID = '$s' ORDER BY VOTE_ID ASC ", [], __FILE__, __LINE__);
			$num = mysql_num_rows($sql);
			if($num <= 0){
				echo'
				<tr>
					<td class="stats_p" align="middle" colSpan="11"><font color="black" size="3"><br>لم يصوت أي عضو في هذا الاستفتاء حاليا<br><br></font></td>
				</tr>';
			}
			$x=0;
			while ($x < $num){
				$v = mysql_result($sql, $x, "VOTE_ID");
				$option_id = votes("OPTION_ID", $v);
				$m_id = votes("MEMBER_ID", $v);
				$value = option_value($option_id);
				$date = votes("DATE", $v); 
				echo'
				<tr>
					<td class="stats_h" align="middle"><font color="white" size="-1">'.$m_id.'</font></td>
					<td class="stats_g"><font color="white" size="-1"><a href="index.php?mode=profile&id='.$m_id.'">'.member_name($m_id).'</a></font></td>
					<td class="stats_p" align="middle"><font color="red" size="-1">'.$value.'</font></td>
					<td class="stats_g" align="middle"><font color="white" size="-1">'.normal_time($date).'</font></td>
				</tr>';
			++$x;
			}
			echo'
			</table>
			<center>';
		}
	}
}

if(method == "add"){
	if(svc == "medals"){
		$medal_folder = $image_folder.'medals/forum'.$f.'/';
		?>
		<script language="javascript">
			var f = "<? echo $f; ?>";
			var m = "<? echo $m; ?>";
			function load_medal_url(){
				if(f > 0){
					document.getElementById("click_url").style.display = "none";
					document.getElementById("load_url").style.display = "block";
				}
				else{
					alert("أنت لم اخترت أي منتدى\nالرجاء اختر منتدى من القائمة.");
					return;
				}
			}

			function choose_img(url){
				var unknown = "<? echo $unknown; ?>";
				document.getElementById("click_url").style.display = "block";
				document.getElementById("load_url").style.display = "none";
				document.getElementById("un_url").style.display = "none";
				document.getElementById("img_url").style.display = "block";
				document.medal_info.m_url.value = url;
				div_img.innerHTML = "<img src="+url+" onerror=\"this.src='"+unknown+"';\">";
			}

			function chk_forum_id(f_id){
				f_id = f_id.options[f_id.selectedIndex].value;
				if(f_id > 0){
					document.location = "index.php?mode=svc&method=add&svc=medals&f="+f_id;
				}
				else{
					return;
				}
			}

			function replace_title(new_text){
				if(medal_info.m_forum_id.value <= 0){
					confirm("يجب عليك أولاً تختار منتدى من القائمة ثم إدخال عنوان الوسام.");
					return;
				}
				else{
					document.medal_info.m_subject.value = new_text;
				}
			}

			function app_title(new_text){
				if(medal_info.m_forum_id.value <= 0){
					confirm("يجب عليك أولاً تختار منتدى من القائمة ثم إدخال عنوان الوسام.");
					return;
				}
				else{
					document.medal_info.m_subject.value += new_text;
				}
			}

			function submit_form(){
				if(medal_info.m_subject.value.length < 10){
					confirm("يجب إدخال عنوان للوسام وأن يكون أطول من 10 أحرف.");
					return;
				}
				if(medal_info.m_subject.value.indexOf("[") >= 0){
					confirm("يجب إدخال عنوان للوسام وأن يكون أطول من 10 أحرف.");
					return;
				}
				if(medal_info.m_subject.value.indexOf("]") >= 0){
					confirm("يجب إدخال عنوان للوسام وأن يكون أطول من 10 أحرف.");
					return;
				}
				if(medal_info.m_forum_id.value <= 0){
					confirm("يجب عليك أن تختار منتدى من القائمة.");
					return;
				}
				if(m > 0){
					medal_info.m_url.value = "<? echo $medal_folder.mf("SUBJECT", $m); ?>";
				}
				if(medal_info.m_url.value.length <= 3){
					confirm("يجب عليك أن تختار ملف للوسام.");
					return;
				}
			medal_info.submit();
			}
		</script>
		<?
		echo'
		<center>
		<table cellSpacing="1" cellPadding="4" width="400" bgColor="gray" border="0">
		<form name="medal_info" method="post" action="index.php?mode=svc&method=insert&svc=medals">
		<input type="hidden" name="m_url">
			<tr class="fixed">
				<td class="cat" colSpan="4"><nobr>إضافة وسام للمنتدى '.forums("SUBJECT", $f).'</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>عنوان الوسام: </nobr></td>
				<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 400px" name="m_subject">&nbsp;&nbsp;
				<input class="insidetitle" onclick="replace_title(\'وسام [أدخل التفاصيل هنا] بمنتدى '.forums("SUBJECT", $f).'\');" type="button" value="+">&nbsp;&nbsp;
				<input class="insidetitle" onclick="replace_title(\'\');" type="button" value="X">';
			if(mlv > 2){
				echo'
				&nbsp;<hr>&nbsp;&nbsp;
				<input class="insidetitle" onclick="replace_title(\'-- للحذف --\');" type="button" value="للحذف">&nbsp;&nbsp;
				<input class="insidetitle" onclick="replace_title(\'** أوسمة التهنئة بالمناسبات لا تقبل **\');" type="button" value="لا تهاني">&nbsp;&nbsp;
				<input class="insidetitle" onclick="app_title(\'** صورة الوسام لا تظهر - الرجاء التصحيح **\');" type="button" value="لا صورة">&nbsp;&nbsp;
				<input class="insidetitle" onclick="app_title(\'** حجم صورة الوسام غير صحيح - الرجاء التعديل **\');" type="button" value="الحجم">';
			}
				echo'
				</td>
			</tr>';
		if($m <= 0 AND $m == ""){
			echo'
			<tr class="fixed">
				<td class="optionheader"><nobr>المنتدى: </nobr></td>
				<td class="list" colSpan="3">
				<select class="insidetitle" size="1" name="m_forum_id" onchange="chk_forum_id(this)">
				<option value="0">-- اختر منتدى --</option>';
				$all_forums = chk_allowed_forums();
				for($x = 0; $x < count($all_forums); $x++){
					$f_id = $all_forums[$x];
					echo'
					<option value="'.$f_id.'" '.check_select($f, $f_id).'>'.forums("SUBJECT", $f_id).'</option>';
				}
				echo'
				</select>
				</td>
			</tr>
			<tr class="fixed" style="display: block;" id="click_url">
				<td class="optionheader"><nobr>ملف الوسام: </nobr></td>
				<td class="list_center" colspan="3"><a href="javascript:load_medal_url()">-- انقر هنا لإختيار ملف للوسام --</a></td>
			</tr>
			<tr class="fixed" style="display: none;" id="load_url">
				<td class="optionheader"><nobr>ملف الوسام: </nobr></td>
				<td class="list_center" colspan="3">
				<table border="0" cellSpacing="4" cellPadding="4">
					<tr class="fixed">';
					$mf = $mysql->execute("SELECT * FROM {$mysql->prefix}MEDAL_FILES WHERE FORUM_ID = '$f' ", [], __FILE__, __LINE__);
					$num = mysql_num_rows($mf);
					$x = 0;
					while($x < $num){
						$mf_id = mysql_result($mf, $x, "MF_ID");
						$m_subject = mf("SUBJECT", $mf_id);
						$m_url = $medal_folder.$m_subject;
						echo'
						<td align="center" valign="top"><a href="javascript:choose_img(\''.$m_url.'\');">'.icons($m_url, "انقر هنا لإختيار الملف", " height=\"60\" width=\"60\"").'</a></td>';
						$count = $count + 1;
						$num_img = $num_img + 1;
						if($num_img == 6){
							echo'</tr><tr class="fixed">';
							$num_img = 0;
						}
					++$x;
					}
					if($count == 0){
						echo'
						<td class="list" align="middle" colSpan="6"><nobr>لا توجد أي ملف للمنتدى '.forums("SUBJECT", $f).'<br>لإضافة ملفات أوسمة لهذا المنتدى<br><a href="index.php?mode=mf&f='.$f.'">-- انقر هنا --</a></nobr></td>';
					}
					echo'
					</tr>';
				if($count > 0){
					echo'
					<tr class="fixed">
						<td align="center" valign="top" colSpan="6"><nobr>لإضافة ملف جديد لهذا المنتدى<br><a href="index.php?mode=mf&f='.$f.'">-- انقر هنا --</a></nobr></td>
					</tr>';
				}
				echo'
				</table>
				</td>
			</tr>
			<tr class="fixed" style="display: none;" id="img_url">
				<td class="optionheader"><nobr>صورة الوسام: </nobr></td>
				<td class="list" align="middle" colSpan="3"><nobr><div id="div_img"></div></nobr></td>
			</tr>';
			$medal_url = icons($unknown);
		}
		else{
			echo'
			<input type="hidden" name="m_forum_id" value="'.mf("FORUM_ID", $m).'">';
			$medal_url = '<img onerror="this.src=\''.$unknown.'\';" src="'.$medal_folder.mf("SUBJECT", $m).'">';
		}
			echo'
			<tr class="fixed" style="display: block;" id="un_url">
				<td class="optionheader"><nobr>صورة الوسام: </nobr></td>
				<td class="list" align="middle" colSpan="3"><nobr>'.$medal_url.'</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>عدد الأيام: </nobr></td>
				<td class="list" colSpan="3">
				<select class="insidetitle" name="m_days">';
				for($x = 1; $x <= 30; ++$x){
					echo'
					<option value="'.$x.'"';
					if($x == 7){
						echo" selected";
					}
					echo'>'.$x.'</option>';
				}
				echo'
				</select>&nbsp;&nbsp;&nbsp;<font color="red" size="-1">عدد إيام ظهور الوسام تحت إسم العضو في مشاركاته</font>
				</td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>نقاط التميز: </nobr></td>
				<td class="list" colSpan="3">
				<select class="insidetitle" name="m_points">';
				for($x = 0; $x <= 40; ++$x){
					echo'
					<option value="'.$x.'">'.$x.'</option>';
				}
				echo'
				</select>&nbsp;&nbsp;&nbsp;<font color="red" size="-1">عدد نقاط التميز التي تضاف للعضو عند منحه الوسام</font>
				</td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>وضعية الوسام: </nobr></td>';
			if(mlv > 2){
				echo'
				<td class="list"><nobr><input class="small" type="radio" value="0" name="m_status">الوسام ينتظر موافقة المراقب</nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="2" name="m_status">الوسام تحت التصميم</nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="1" name="m_status" CHECKED>الوسام حي</nobr></td>';
			}
			else{
				echo'
				<td class="list"><nobr><input class="small" type="radio" value="0" name="m_status" CHECKED>الوسام ينتظر موافقة المراقب</nobr></td>
				<td class="list" colSpan="2"><nobr><input class="small" type="radio" value="2" name="m_status">الوسام تحت التصميم</nobr></td>';
			}
			echo'
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>قفل الوسام: </nobr></td>
				<td class="list"><nobr><input class="small" type="radio" CHECKED value="0" name="m_close">الوسام مفتوح للإستخدام</nobr></td>
				<td class="list" colSpan="2"><nobr><input class="small" type="radio" value="1" name="m_close">الوسام مقفول ولا يظهر عند الترشيح</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="list_center" colSpan="5"><input onclick="submit_form()" type="button" value="أدخل التغييرات">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="إلغاء التغييرات"></td>
			</tr>
		</form>
		</table>
		</center><br>';
	}
	if(svc == "titles"){
		?>
		<script language="javascript">
			function submit_form(){
				if(title_info.subject.value.length < 5){
					confirm("يجب إدخال عنوان الوصف وأن يكون أطول من 5 أحرف.");
					return;
				}
				if(title_info.forum_id.value <= 0){
					confirm("يجب عليك أن تختار منتدى من القائمة.");
					return;
				}
				title_info.submit();
			}
		</script>
		<?
		echo'
		<center>
		<table cellSpacing="1" cellPadding="4" width="400" bgColor="gray" border="0">
		<form name="title_info" method="post" action="index.php?mode=svc&method=insert&svc=titles">
			<tr class="fixed">
				<td class="optionheader"><nobr>نص الوصف: </nobr></td>
				<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 400px" name="subject"></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>المنتدى: </nobr></td>
				<td class="list" colSpan="3">
				<select class="insidetitle" size="1" name="forum_id">
					<option value="0">-- اختر منتدى --</option>';
					$all_forums = chk_allowed_forums();
					for($x = 0; $x < count($all_forums); $x++){
						$f_id = $all_forums[$x];
						echo'
						<option value="'.$f_id.'" '.check_select($f, $f_id).'>'.forums("SUBJECT", $f_id).'</option>';
					}
				echo'
				</select>
				</td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>قفل الوصف: </nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="0" name="close" CHECKED>الوصف مفتوح للإستخدام</nobr></td>
				<td class="list" colSpan="2"><nobr><input class="small" type="radio" value="1" name="close">الوصف مقفول ولا يظهر ضمن الخيارات</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>عرض الوصف: </nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="0" name="forum" CHECKED>يظهر في منتداه فقط</nobr></td>
				<td class="list" colSpan="2"><nobr><input class="small" type="radio" value="1" name="forum">يظهر في جميع المنتديات</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>وضعية الوصف: </nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="0" name="status" CHECKED>ينتظر موافقة المدير أو المراقب</nobr></td>';
			if(mlv > 2){
				echo'
				<td class="list"><nobr><input class="small" type="radio" value="2" name="status">الوصف تحت التصميم</nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="1" name="status">الوصف حي</nobr></td>';
			}
			else{
				echo'
				<td class="list" colSpan="2"><nobr><input class="small" type="radio" value="2" name="status">الوصف تحت التصميم</nobr></td>';
			}
			echo'
			</tr>
			<tr class="fixed">
				<td class="list_center" colSpan="4"><input onclick="submit_form()" type="button" value="أدخل التغييرات">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="إلغاء التغييرات"></td>
			</tr>
		</table>
		</center><br>';
	}
	if(svc == "surveys"){
		?>
		<script language="javascript">
			function submit_form(){
				if(survey_info.subject.value.length < 10){
					confirm("يجب إدخال عنوان للإستفتاء وأن يكون أطول من 10 أحرف.");
					return;
				}
				if(survey_info.question.value.length < 10){
					confirm("يجب إدخال سؤال للإستفتاء وأن يكون أطول من 10 أحرف.");
					return;
				}
				if(survey_info.forum_id.value <= 0){
					confirm("يجب عليك أن تختار منتدى من القائمة.");
					return;
				}
				var regex = /^[0-9]/;
				if(!regex.test(survey_info.min_days.value)){
					confirm("عدد الأيام يجب ان يكون بالأرقام فقط");
					return;
				f}
				if(!regex.test(survey_info.min_posts.value)){
					confirm("عدد المشاركات يجب ان يكون بالأرقام فقط");
					return;
				}
				survey_info.submit();
			}
		</script>
		<?
		echo'
		<center>
		<table cellSpacing="1" cellPadding="4" width="400" bgColor="gray" border="0">
		<form name="survey_info" method="post" action="index.php?mode=svc&method=insert&svc=surveys">
		<input type="hidden" name="refer" value="'.$referer.'">
			<tr class="fixed">
				<td class="optionheader" colSpan="3"><nobr>إضافة إستفتاء جديد</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>عنوان الإستفتاء: </nobr></td>
				<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 600px" name="subject"></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>سؤال الإستفتاء: </nobr></td>
				<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 600px" name="question"></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>عدد الأيام: </nobr></td>
				<td class="list" colSpan="3">
				<select class="insidetitle" name="days">';
				for($x = 1; $x <= 30; ++$x){
					echo'
					<option value="'.$x.'"';
					if($x == 5){
						echo" selected";
					}
					echo'>'.$x.'</option>';
				}
				echo'
				</select>&nbsp;&nbsp;&nbsp;<font color="red" size="-1">عدد أيام ظهور إستفتاء وبعدها سيتم قفله تلقائياً</font>
				</td>			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>المنتدى: </nobr></td>
				<td class="list" colSpan="3">
				<select class="insidetitle" size="1" name="forum_id">
					<option value="0">-- اختر منتدى --</option>';
					$all_forums = chk_allowed_forums();
					for($x = 0; $x < count($all_forums); $x++){
						$f_id = $all_forums[$x];
						echo'
						<option value="'.$f_id.'" '.check_select($f, $f_id).'>'.forums("SUBJECT", $f_id).'</option>';
					}
				echo'
				</select>
				</td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>أدنى عدد الأيام: </nobr></td>
				<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 40px" value="0" name="min_days">&nbsp;&nbsp;&nbsp;<font color="red" size="-1">عدد الأيام التي يجب ان يكون العضو قد مضاها منذ تسجيله في المنتدى حتى يتمكن من التصويت</font></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>أدنى عدد المشاركات: </nobr></td>
				<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 40px" value="0" name="min_posts">&nbsp;&nbsp;&nbsp;<font color="red" size="-1">عدد مشاركات العضو المطلوبة حتى يتمكن من التصويت</font></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>وضعية الإستفتاء: </nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="1" name="status" CHECKED>مفتوح</nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="0" name="status">مقفول</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>سرية الإستفتاء: </nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="0" name="secret" CHECKED>مفتوح</nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="1" name="secret">سري</nobr></td>
			</tr>

			<tr class="fixed">
				<td class="list_center" colSpan="5"><input onclick="submit_form()" type="button" value="أدخل التغييرات">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="إلغاء التغييرات">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="JavaScript:history.go(-1);" value="إرجع"></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader" colSpan="3"><nobr>خيارات التصويت</nobr></td>
			</tr>';
		for($x = 1; $x <= 30; ++$x){
			echo'
			<tr class="fixed">
				<td class="optionheader"><nobr>الخيار '.$x.': </nobr></td>
				<td class="list" colSpan="3">
					<input class="insidetitle" style="WIDTH: 600px" name="value[]"><br>
					<input class="insidetitle" style="WIDTH: 450px" name="other[]"><font color="green" size="-1">(نص إضافي إو عنوان صورة)</font>
				</td>
			</tr>';
		}
		echo'
		</form>
		</table>
		</center><br>';
	}
}

if(method == "insert"){
	if(svc == "medals"){
		$f = $_POST['m_forum_id'];
		if(allowed($f, 2) == 1){
			$subject = $_POST['m_subject'];
			$url = $_POST['m_url'];
			$days = $_POST['m_days'];
			$points = $_POST['m_points'];
			$status = $_POST['m_status'];
			$close = $_POST['m_close'];
			if(strlen($subject) < 10){
				$error = "يجب إدخال عنوان للوسام وأن يكون أطول من 10 أحرف.";
			}
			else if(strlen($url) < 3){
				$error = "يجب عليك أن تختار ملف للوسام.";
			}
			else if($f <= 0){
				$error = "يجب عليك أن تختار منتدى من القائمة.";
			}
			else{
				$error = "";
			}
			if($error != ""){
	                echo'<br>
					<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br><b>'.$lang['all']['error'].'<br>'.$error.'..</b></font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
			}
			if($error == ""){
				$query = "INSERT INTO {$mysql->prefix}GLOBAL_MEDALS (MEDAL_ID, FORUM_ID, STATUS, SUBJECT, POINTS, DAYS, URL, CLOSE, ADDED, DATE) VALUES (NULL, ";
				$query .= " '$f', ";
				$query .= " '$status', ";
				$query .= " '$subject', ";
				$query .= " '$points', ";
				$query .= " '$days', ";
				$query .= " '$url', ";
				$query .= " '$close', ";
				$query .= " '$DBMemberID', ";
				$query .= " '".time()."') ";
				$mysql->execute($query, [], __FILE__, __LINE__);
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br><b>تم إضافة الوسام بنجاح</b></font><br><br>
	                       <meta http-equiv="Refresh" content="1; URL= index.php?mode=svc&method=svc&svc=medals">
                           <a href="index.php?mode=svc&method=svc&svc=medals">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
			}

		}
	}
	if(svc == "titles"){
		$f = $_POST['forum_id'];
		$subject = $_POST['subject'];
		$close = $_POST['close'];
		$forum = $_POST['forum'];
		$status = $_POST['status'];
		if(strlen($subject) < 5){
			$error = "يجب إدخال عنوان الوصف وأن يكون أطول من 5 أحرف.";
		}
		else if($f <= 0){
			$error = "يجب عليك أن تختار منتدى من القائمة.";
		}
		else{
			$error = "";
		}
		if($error != ""){
			echo'<br>
			<center>
			<table width="99%" border="1">
			   <tr class="normal">
				   <td class="list_center" colSpan="10"><font size="5" color="red"><br><b>'.$lang['all']['error'].'<br>'.$error.'..</b></font><br><br>
				   <a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
				   </td>
			   </tr>
			</table>
			</center><xml>';
		}
		if($error == ""){
			if(allowed($f, 2) == 1){
				$sql = "INSERT INTO {$mysql->prefix}GLOBAL_TITLES (TITLE_ID, FORUM_ID, STATUS, CLOSE, FORUM, ADDED, SUBJECT, DATE) VALUES (NULL, ";
				$sql = $sql." '$f', ";
				$sql = $sql." '$status', ";
				$sql = $sql." '$close', ";
				$sql = $sql." '$forum', ";
				$sql = $sql." '$DBMemberID', ";
				$sql = $sql." '$subject', ";
				$sql = $sql." '".time()."') ";
				$mysql->execute($sql, [], __FILE__, __LINE__);
				echo'<br>
				<center>
				<table width="99%" border="1">
				   <tr class="normal">
					   <td class="list_center" colSpan="10"><font size="5"><br><b>تم إضافة الوصف بنجاح</b></font><br><br>
					   <meta http-equiv="Refresh" content="1; URL= index.php?mode=svc&method=svc&svc=titles">
					   <a href="index.php?mode=svc&method=svc&svc=titles">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
					   </td>
				   </tr>
				</table>
				</center>';
			}
		}
	}
	if(svc == "surveys"){
		$f = $_POST['forum_id'];
		$subject = $_POST['subject'];
		$question = $_POST['question'];
		$days = $_POST['days'];
		$min_days = $_POST['min_days'];
		$min_posts = $_POST['min_posts'];
		$status = $_POST['status'];
		$secret = $_POST['secret'];
		$value = $_POST['value'];
		$other = $_POST['other'];
		$refer = $_POST['refer'];
		$start = time();
		$all_days = $days*60*60*24;
		$end = time() + $all_days;
		if(svc_survey_value($value) < 2){
			$error = "يجب إدخال على الأقل خيارين للإستفتاء.";
		}
		else{
			$error = "";
		}

		if($error != ""){
			echo'<br>
			<center>
			<table width="99%" border="1">
			   <tr class="normal">
				   <td class="list_center" colSpan="10"><font size="5" color="red"><br>'.$error.'..</font><br><br>
				   <a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
				   </td>
			   </tr>
			</table>
			</center><xml>';
		}
		if($error == ""){
			if(allowed($f, 2) == 1){
				$sql = "INSERT INTO {$mysql->prefix}SURVEYS (SURVEY_ID, FORUM_ID, SUBJECT, QUESTION, STATUS, SECRET, DAYS, MIN_DAYS, MIN_POSTS, ADDED, START, END) VALUES (NULL, ";
				$sql = $sql." '$f', ";
				$sql = $sql." '$subject', ";
				$sql = $sql." '$question', ";
				$sql = $sql." '$status', ";
				$sql = $sql." '$secret', ";
				$sql = $sql." '$days', ";
				$sql = $sql." '$min_days', ";
				$sql = $sql." '$min_posts', ";
				$sql = $sql." '$DBMemberID', ";
				$sql = $sql." '$start', ";
				$sql = $sql." '$end') ";
				$mysql->execute($sql, [], __FILE__, __LINE__);
				$surv_id = svc_chk_survey_id($f, $subject, $question);
				$i = 1;
				for ($x = 0;$x < count($value); ++$x){
					if($value[$x] != ""){
						$sql = "INSERT INTO {$mysql->prefix}SURVEY_OPTIONS (SO_ID, SURVEY_ID, OPTION_ID, VALUE, OTHER) VALUES (NULL, ";
						$sql = $sql." '$surv_id', ";
						$sql = $sql." '$i', ";
						$sql = $sql." '$value[$x]', ";
						$sql = $sql." '$other[$x]') ";
						$mysql->execute($sql, [], __FILE__, __LINE__);
						$i = $i + 1;
					}
				}
				echo'<br>
				<center>
				<table width="99%" border="1">
				   <tr class="normal">
					   <td class="list_center" colSpan="10"><font size="5"><br><b>تم إضافة الإستفتاء بنجاح</b></font><br><br>
					   <meta http-equiv="Refresh" content="1; URL='.$refer.'">
					   <a href="'.$refer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
					   </td>
				   </tr>
				</table>
				</center>';
			}
		}
	}
	if(svc == "prv"){
		$f = $_POST['f'];
		if(allowed($f, 2) == 1){
			$t = $_POST['t'];
			$m = $_POST['m'];

			if(empty($m)){
				$error = "أنت لم دخلت أي رقم في خانة رقم العضوية.";
			}
			else if(chk_id("MEMBERS", "MEMBER_ID", $m) != 1){
				$error = "رقم العضوية الذي دخل ليس صحيح.";
			}
			else if(chk_add_member_to_topic($t, $m) == 1){
				$error = "العضو موجود في لائحة أعضاء مخولون لرؤية هذا الموضوع.";
			}
			else{
				$error = "";
			}
			if($error != ""){
				echo'<br>
				<center>
				<table width="99%" border="1">
				   <tr class="normal">
					   <td class="list_center" colSpan="10"><font size="5" color="red"><br><b>'.$lang['all']['error'].'<br>'.$error.'..</b></font><br><br>
					   <a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
					   </td>
				   </tr>
				</table>
				</center><xml>';
			}
			if($error == ""){
				$sql = "INSERT INTO {$mysql->prefix}TOPIC_MEMBERS (TM_ID, MEMBER_ID, TOPIC_ID, ADDED, DATE) VALUES (NULL, ";
				$sql = $sql." '$m', ";
				$sql = $sql." '$t', ";
				$sql = $sql." '$DBMemberID', ";
				$sql = $sql." '".time()."') ";
				$mysql->execute($sql, [], __FILE__, __LINE__);

				$t_subject = topics("SUBJECT", $t);
				$subject = 'إشعار بفتح موضوع مخفي لك: '.$t_subject;
				$message = '<font color="black" size="3">لقد تم فتح الموضوع المخفي التالي لك من قبل فريق الإشراف:<br><br><a href="index.php?mode=t&t='.$t.'">الموضوع رقم'.$t.': '.$t_subject.'</a><br><br>يمكنك الآن الدخول و المشاركة في الموضوع المخفي باستخدام الوصلة أعلاه.</font>';

				$sql = "INSERT INTO {$mysql->prefix}PM (PM_ID, PM_MID, PM_TO, PM_FROM, PM_OUT, PM_SUBJECT, PM_MESSAGE, PM_DATE) VALUES (NULL, ";
				$sql .= " '$m', ";
				$sql .= " '$m', ";
				$sql .= " '".abs2($f)."', ";
				$sql .= " '0', ";
				$sql .= " '$subject', ";
				$sql .= " '$message', ";
				$sql .= " '".time()."') ";
				$mysql->execute($sql, [], __FILE__, __LINE__);
				echo'<br>
				<center>
				<table width="99%" border="1">
				   <tr class="normal">
					   <td class="list_center" colSpan="10"><font size="5"><br><b>تم إضافة العضو للقائمة بنجاح</b></font><br><br>
					   <meta http-equiv="Refresh" content="1; URL='.$referer.'">
					   <a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
					   </td>
				   </tr>
				</table>
				</center>';
			}
		}
	}
}

if(method == "in"){
	if(svc == "medals"){
		if(allowed($f, 2) == 1){
			$days = gm("DAYS", $id);
			$points = gm("POINTS", $id);
			$url = gm("URL", $id);
			$sql = "INSERT INTO {$mysql->prefix}MEDALS (MEDAL_ID, GM_ID, MEMBER_ID, FORUM_ID, STATUS, ADDED, DAYS, POINTS, URL, DATE) VALUES (NULL, ";
			$sql .= " '$id', ";
			$sql .= " '$m', ";
			$sql .= " '$f', ";
			if(allowed($f, 1) == 1){
				$sql .= " '1', ";
			}
			else{
				$sql .= " '0', ";
			}
			$sql .= " '$DBMemberID', ";
			$sql .= " '$days', ";
			$sql .= " '$points', ";
			$sql .= " '$url', ";
			$sql .= " '".time()."') ";
			$mysql->execute($sql, [], __FILE__, __LINE__);
			if(allowed($f, 1) == 1){
				$msg_text = "تم رشح الوسام للعضو بنجاح";
				$mysql->execute("UPDATE {$mysql->prefix}MEMBERS SET M_MEDAL = '".chk_member_last_medal($m)."', M_POINTS = '".member_all_points($m)."' WHERE MEMBER_ID = '$m' ", [], __FILE__, __LINE__);
			}
			else{
				$msg_text = "تم رشح الوسام للعضو لكن بحاجة الى موافقة المراقب";
			}
				echo'<br><center>
				<table width="99%" border="1">
				   <tr class="normal">
					   <td class="list_center" colSpan="10"><font size="5"><br><b>'.$msg_text.'</b></font><br><br>
					   <meta http-equiv="Refresh" content="1; URL=index.php?mode=profile&id='.$m.'">
					   <a href="index.php?mode=profile&id='.$m.'">انقر هنا للذهاب الى بيانات العضو</a><br><br>
					   </td>
				   </tr>
				</table>
				</center>';
		}
	}
	if(svc == "titles"){
		if(allowed($f, 2) == 1){
			if(chk_add_titles($id, $m) == 1){
				$error = "الوصف الذي اخترت هو موجود بلائحة أوصاف هذا العضو";
			}
			else{
				$error = "";
			}

			if($error != ""){
				echo'<br>
				<center>
				<table width="99%" border="1">
				   <tr class="normal">
					   <td class="list_center" colSpan="10"><font size="5" color="red"><br><b>'.$lang['all']['error'].'<br>'.$error.'..</b></font><br><br>
					   <a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
					   </td>
				   </tr>
				</table>
				</center><xml>';
			}
			if($error == ""){
				$sql = "INSERT INTO {$mysql->prefix}TITLES (TITLE_ID, GT_ID, MEMBER_ID, DATE) VALUES (NULL, ";
				$sql .= " '$id', ";
				$sql .= " '$m', ";
				$sql .= " '".time()."') ";
				$mysql->execute($sql, [], __FILE__, __LINE__);

				$sql = "INSERT INTO {$mysql->prefix}USED_TITLES (ID, TITLE_ID, MEMBER_ID, STATUS, ADDED, DATE) VALUES (NULL, ";
				$sql .= " '$id', ";
				$sql .= " '$m', ";
				$sql .= " '1', ";
				$sql .= " '$DBMemberID', ";
				$sql .= " '".time()."') ";
				$mysql->execute($sql, [], __FILE__, __LINE__);
				echo'<br><center>
				<table width="99%" border="1">
				   <tr class="normal">
					   <td class="list_center" colSpan="10"><font size="5"><br><b>تم أضف الوصف للعضو بنجاح</b></font><br><br>
					   <meta http-equiv="Refresh" content="1; URL=index.php?mode=profile&id='.$m.'">
					   <a href="index.php?mode=profile&id='.$m.'">انقر هنا للذهاب الى بيانات العضو</a><br><br>
					   </td>
				   </tr>
				</table>
				</center>';
			}
		}
	}
}

if(method == "edit"){
	if(svc == "medals"){
		$f = gm("FORUM_ID", $m);
		if(allowed($f, 2) == 1){
			$medal_folder = $image_folder.'medals/forum'.$f.'/';
			$subject = gm("SUBJECT", $m);
			$url = gm("URL", $m);
			$close = gm("CLOSE", $m);
?>
<script language="javascript">
	function load_medal_url(){
		document.getElementById("click_url").style.display = "none";
		document.getElementById("load_url").style.display = "block";
	}

	function choose_img(url){
		var unknown = "<? echo $unknown; ?>";
		document.getElementById("click_url").style.display = "block";
		document.getElementById("load_url").style.display = "none";
		document.getElementById("un_url").style.display = "none";
		document.getElementById("img_url").style.display = "block";
		document.medal_info.m_url.value = url;
		div_img.innerHTML = "<img src="+url+" onerror=\"this.src='"+unknown+"';\">";
	}

	function replace_title(new_text){
		document.medal_info.m_subject.value = new_text;
	}

	function app_title(new_text){
		document.medal_info.m_subject.value += new_text;
	}

	function submit_form(){
		if(medal_info.m_subject.value.length < 10){
			confirm("يجب إدخال عنوان للوسام وأن يكون أطول من 10 أحرف.");
			return;
		}
		if(medal_info.m_subject.value.indexOf("[") >= 0){
			confirm("يجب إدخال عنوان للوسام وأن يكون أطول من 10 أحرف.");
			return;
		}
		if(medal_info.m_subject.value.indexOf("]") >= 0){
			confirm("يجب إدخال عنوان للوسام وأن يكون أطول من 10 أحرف.");
			return;
		}
		if(medal_info.m_url.value.length <= 3){
			confirm("يجب عليك أن تختار ملف للوسام.");
			return;
		}
	medal_info.submit();
	}
</script>
<?php
		echo'
		<center>
		<table cellSpacing="0" cellPadding="0" width="99%" border="0">
			<tr>
				<td>
				<center>
				<form name="medal_info" method="post" action="index.php?mode=svc&method=update&svc=medals">
				<input type="hidden" name="m_url" value="'.$url.'">
				<input type="hidden" name="m" value="'.$m.'">
				<input type="hidden" name="f" value="'.$f.'">
					<table cellSpacing="1" cellPadding="4" width="400" bgColor="gray" border="0">
						<tr class="fixed">
							<td class="cat" colSpan="4"><nobr>إضافة وسام للمنتدى '.forums("SUBJECT", $f).'</nobr></td>
						</tr>
						<tr class="fixed">
							<td class="optionheader"><nobr>عنوان الوسام: </nobr></td>
							<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 400px" name="m_subject" value="'.$subject.'">&nbsp;&nbsp;
							<input class="insidetitle" onclick="replace_title(\'وسام [أدخل التفاصيل هنا] بمنتدى '.forums("SUBJECT", $f).'\');" type="button" value="+">&nbsp;&nbsp;
							<input class="insidetitle" onclick="replace_title(\'\');" type="button" value="X">';
						if(mlv > 2){
							echo'
							&nbsp;<hr>&nbsp;&nbsp;
							<input class="insidetitle" onclick="replace_title(\'-- للحذف --\');" type="button" value="للحذف">&nbsp;&nbsp;
							<input class="insidetitle" onclick="replace_title(\'** أوسمة التهنئة بالمناسبات لا تقبل **\');" type="button" value="لا تهاني">&nbsp;&nbsp;
							<input class="insidetitle" onclick="app_title(\'** صورة الوسام لا تظهر - الرجاء التصحيح **\');" type="button" value="لا صورة">&nbsp;&nbsp;
							<input class="insidetitle" onclick="app_title(\'** حجم صورة الوسام غير صحيح - الرجاء التعديل **\');" type="button" value="الحجم">';
						}
							echo'
							</td>
						</tr>
						<tr class="fixed" style="display: block;" id="click_url">
							<td class="optionheader"><nobr>ملف الوسام: </nobr></td>
							<td class="list_center" colspan="3"><a href="javascript:load_medal_url()">-- انقر هنا لإختيار ملف للوسام --</a></td>
						</tr>
						<tr class="fixed" style="display: none;" id="load_url">
							<td class="optionheader"><nobr>ملف الوسام: </nobr></td>
							<td class="list_center" colspan="3">
							<table border="0" cellSpacing="4" cellPadding="4">
								<tr class="fixed">';
								$mf = $mysql->execute("SELECT * FROM {$mysql->prefix}MEDAL_FILES WHERE FORUM_ID = '$f' ", [], __FILE__, __LINE__);
								$num = mysql_num_rows($mf);
								$x = 0;
								while($x < $num){
									$mf_id = mysql_result($mf, $x, "MF_ID");
									$m_subject = mf("SUBJECT", $mf_id);
									$m_url = $medal_folder.$m_subject;
									echo'
									<td align="center" valign="top"><a href="javascript:choose_img(\''.$m_url.'\');">'.icons($m_url, "انقر هنا لإختيار الملف", " height=\"60\" width=\"60\"").'</a></td>';
									$count = $count + 1;
									$num_img = $num_img + 1;
									if($num_img == 6){
										echo'</tr><tr class="fixed">';
										$num_img = 0;
									}
								++$x;
								}
								if($count == 0){
									echo'
									<td class="list" align="middle" colSpan="6"><nobr>لا توجد أي ملف للمنتدى '.forums("SUBJECT", $f).'<br>لإضافة ملفات أوسمة لهذا المنتدى<br><a href="index.php?mode=mf&f='.$f.'">-- انقر هنا --</a></nobr></td>';
								}
								echo'
								</tr>';
							if($count > 1){
								echo'
								<tr class="fixed">
									<td align="center" valign="top" colSpan="6"><nobr>لإضافة ملف جديد لهذا المنتدى<br><a href="index.php?mode=mf&f='.$f.'">-- انقر هنا --</a></nobr></td>
								</tr>';
							}
							echo'
							</table>
							</td>
						</tr>
						<tr class="fixed" style="display: none;" id="img_url">
							<td class="optionheader"><nobr>صورة الوسام: </nobr></td>
							<td class="list" align="middle" colSpan="3"><nobr><div id="div_img"></div></nobr></td>
						</tr>
						<tr class="fixed" style="display: block;" id="un_url">
							<td class="optionheader"><nobr>صورة الوسام: </nobr></td>
							<td class="list" align="middle" colSpan="3"><nobr><img onerror="this.src=\''.$unknown.'\';" src="'.$url.'"></nobr></td>
						</tr>
						<tr class="fixed">
							<td class="optionheader"><nobr>قفل الوسام: </nobr></td>
							<td class="list"><nobr><input class="small" type="radio" value="0" name="m_close" '.check_radio($close, 0).'>الوسام مفتوح للإستخدام</nobr></td>
							<td class="list" colSpan="2"><nobr><input class="small" type="radio" value="1" name="m_close" '.check_radio($close, 1).'>الوسام مقفول ولا يظهر عند الترشيح</nobr></td>
						</tr>
						<tr class="fixed">
							<td class="list_center" colSpan="5"><input onclick="submit_form()" type="button" value="أدخل التغييرات">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="إلغاء التغييرات"></td>
						</tr>
					</table>
				</form>
				</center>
				</td>
			</tr>
		</table>
		</center><br>';
		}
	}
	if(svc == "titles"){
		$f = gt("FORUM_ID", $t);
		if(allowed($f, 2) == 1){
			$subject = gt("SUBJECT", $t);
			$status = gt("STATUS", $t);
			$close = gt("CLOSE", $t);
			$forum = gt("FORUM", $t);
			echo'
			<script language="javascript">
				function submit_form(){
					if(title_info.subject.value.length < 5){
						confirm("يجب إدخال عنوان الوصف وأن يكون أطول من 5 أحرف.");
						return;
					}
					if(title_info.forum_id.value <= 0){
						confirm("يجب عليك أن تختار منتدى من القائمة.");
						return;
					}
					title_info.submit();
				}
			</script>
			<center>
			<table cellSpacing="1" cellPadding="4" width="400" bgColor="gray" border="0">
			<form name="title_info" method="post" action="index.php?mode=svc&method=update&svc=titles">
			<input type="hidden" name="t" value="'.$t.'">
			<input type="hidden" name="refer" value="'.referer.'">
				<tr class="fixed">
					<td class="optionheader"><nobr>نص الوصف: </nobr></td>
					<td class="list" colSpan="3">';
					if(allowed($f, 1) == 1){
						echo'
						<input class="insidetitle" style="WIDTH: 400px" name="subject" value="'.$subject.'">';
					}
					else{
						echo $subject;
					}
					echo'
					</td>
				</tr>';
			if(allowed($f, 1) == 1){
				echo'
				<tr class="fixed">
					<td class="optionheader"><nobr>المنتدى: </nobr></td>
					<td class="list" colSpan="3">
					<select class="insidetitle" size="1" name="forum_id">
						<option value="0">-- اختر منتدى --</option>';
						$all_forums = chk_allowed_forums();
						for($x = 0; $x < count($all_forums); $x++){
							$f_id = $all_forums[$x];
							echo'
							<option value="'.$f_id.'" '.check_select($f, $f_id).'>'.forums("SUBJECT", $f_id).'</option>';
						}
					echo'
					</select>
					</td>
				</tr>';
			}
			else{
				echo'
				<input type="hidden" name="forum_id" value="'.$f.'">';
			}
				echo'
				<tr class="fixed">
					<td class="optionheader"><nobr>قفل الوصف: </nobr></td>
					<td class="list"><nobr><input class="small" type="radio" value="0" name="close" '.check_radio($close, 0).'>الوصف مفتوح للإستخدام</nobr></td>
					<td class="list" colSpan="2"><nobr><input class="small" type="radio" value="1" name="close" '.check_radio($close, 1).'>الوصف مقفول ولا يظهر ضمن الخيارات</nobr></td>
				</tr>';
			if(allowed($f, 1) == 1){
				echo'
				<tr class="fixed">
					<td class="optionheader"><nobr>عرض الوصف: </nobr></td>
					<td class="list"><nobr><input class="small" type="radio" value="0" name="forum" '.check_radio($forum, 0).'>يظهر في منتداه فقط</nobr></td>
					<td class="list" colSpan="2"><nobr><input class="small" type="radio" value="1" name="forum" '.check_radio($forum, 1).'>يظهر في جميع المنتديات</nobr></td>
				</tr>
				<tr class="fixed">
					<td class="optionheader"><nobr>وضعية الوصف: </nobr></td>
					<td class="list"><nobr><input class="small" type="radio" value="0" name="status" '.check_radio($status, 0).'>ينتظر موافقة المدير أو المراقب</nobr></td>
					<td class="list"><nobr><input class="small" type="radio" value="2" name="status" '.check_radio($status, 2).'>الوصف تحت التصميم</nobr></td>
					<td class="list"><nobr><input class="small" type="radio" value="1" name="status" '.check_radio($status, 1).'>الوصف حي</nobr></td>
				</tr>';
			}
				echo'
				<tr class="fixed">
					<td class="list_center" colSpan="4"><input onclick="submit_form()" type="button" value="أدخل التغييرات">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="إلغاء التغييرات"></td>
				</tr>
			</table>
			</center><br>';
		}
	}
	if(svc == "surveys"){
		$s = intval(trim($_GET['s']));
		$f = surveys("FORUM_ID", $s);
		if(allowed($f, 2) == 1){
			$subject = surveys("SUBJECT", $s);
			$question = surveys("QUESTION", $s);
			$status = surveys("STATUS", $s);
			$secret = surveys("SECRET", $s);
			$days = surveys("DAYS", $s);
			$min_days = surveys("MIN_DAYS", $s);
			$min_posts = surveys("MIN_POSTS", $s);
			$added = surveys("ADDED", $s);
			$start = surveys("START", $s);
			$end = surveys("END", $s);
		?>
		<script language="javascript">
			function submit_form(){
				if(survey_info.subject.value.length < 10){
					confirm("يجب إدخال عنوان للإستفتاء وأن يكون أطول من 10 أحرف.");
					return;
				}
				if(survey_info.question.value.length < 10){
					confirm("يجب إدخال سؤال للإستفتاء وأن يكون أطول من 10 أحرف.");
					return;
				}
				if(survey_info.forum_id.value <= 0){
					confirm("يجب عليك أن تختار منتدى من القائمة.");
					return;
				}
				var regex = /^[0-9]/;
				if(!regex.test(survey_info.min_days.value)){
					confirm("عدد الأيام يجب ان يكون بالأرقام فقط");
					return;
				}
				if(!regex.test(survey_info.min_posts.value)){
					confirm("عدد المشاركات يجب ان يكون بالأرقام فقط");
					return;
				}
				survey_info.submit();
			}
		</script>
		<?
		echo'
		<center>
		<table cellSpacing="1" cellPadding="4" width="400" bgColor="gray" border="0">
		<form name="survey_info" method="post" action="index.php?mode=svc&method=update&svc=surveys&type=data">
		<input type="hidden" name="s" value="'.$s.'">
		<input type="hidden" name="days" value="'.$days.'">
		<input type="hidden" name="refer" value="'.$referer.'">
			<tr class="fixed">
				<td class="optionheader" colSpan="3"><nobr>تعديل استفتاء</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>عنوان الإستفتاء: </nobr></td>
				<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 600px" name="subject" value="'.$subject.'"></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>سؤال الإستفتاء: </nobr></td>
				<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 600px" name="question" value="'.$question.'"></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>عدد الأيام: </nobr></td>
				<td class="list" colSpan="3">'.$days.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;<font color="red" size="-1">عدد أيام ظهور إستفتاء وبعدها سيتم قفله تلقائياً</font>
				</td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>عدد الأيام الإضافية: </nobr></td>
				<td class="list" colSpan="3">
				<select class="insidetitle" name="days_added">';
				for($x = 0; $x <= 30; ++$x){
					echo'
					<option value="'.$x.'">'.$x.'</option>';
				}
				echo'
				</select>&nbsp;&nbsp;&nbsp;<font color="red" size="-1">عدد الأيام التي تريد اضافتها للإستفتاء وبعدها سيتم قفله تلقائياً</font>
				</td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>المنتدى: </nobr></td>
				<td class="list" colSpan="3">
				<select class="insidetitle" size="1" name="forum_id">
					<option value="0">-- اختر منتدى --</option>';
					$all_forums = chk_allowed_forums();
					for($x = 0; $x < count($all_forums); $x++){
						$f_id = $all_forums[$x];
						echo'
						<option value="'.$f_id.'" '.check_select($f, $f_id).'';
						echo'>'.forums("SUBJECT", $f_id).'</option>';
					}
				echo'
				</select>
				</td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>أدنى عدد الأيام: </nobr></td>
				<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 40px" value="0" name="min_days" value="'.$min_days.'">&nbsp;&nbsp;&nbsp;<font color="red" size="-1">عدد الأيام التي يجب ان يكون العضو قد مضاها منذ تسجيله في المنتدى حتى يتمكن من التصويت</font></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>أدنى عدد المشاركات: </nobr></td>
				<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 40px" value="0" name="min_posts" value="'.$min_posts.'">&nbsp;&nbsp;&nbsp;<font color="red" size="-1">عدد مشاركات العضو المطلوبة حتى يتمكن من التصويت</font></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>وضعية الإستفتاء: </nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="1" name="status" '.check_radio($status, "1").'>مفتوح</nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="0" name="status" '.check_radio($status, "0").'>مقفول</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="optionheader"><nobr>سرية الإستفتاء: </nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="0" name="secret" '.check_radio($secret, "0").'>مفتوح</nobr></td>
				<td class="list"><nobr><input class="small" type="radio" value="1" name="secret" '.check_radio($secret, "1").'>سري</nobr></td>
			</tr>
			<tr class="fixed">
				<td class="list_center" colSpan="5"><input onclick="submit_form()" type="button" value="أدخل التغييرات">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="إلغاء التغييرات">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="JavaScript:history.go(-1);" value="إرجع"></td>
			</tr>			<tr class="fixed">
				<td class="optionheader" colSpan="3"><nobr>خيارات التصويت</nobr></td>
			</tr>';

		for($x = 1; $x <= 30; ++$x){
$OoO = mysql_fetch_array($mysql->execute("SELECT * FROM {$mysql->prefix}SURVEY_OPTIONS WHERE SURVEY_ID = '$s' AND OPTION_ID = '$x' "));
			echo'
			<tr class="fixed">
				<td class="optionheader"><nobr>الخيار '.$x.': </nobr></td>
				<td class="list" colSpan="3">
					<input class="insidetitle" style="WIDTH: 600px" name="value[]" value="'.$OoO['VALUE'].'"><br>
					<input class="insidetitle" style="WIDTH: 450px" name="other[]" value="'.$OoO['OTHER'].'"><font color="green" size="-1">(نص إضافي إو عنوان صورة)</font>
				</td>
			</tr>';
		}
		echo '</form>
		</table>
		</center><br>';
		}
	}
}


if(method == "update"){
	if(svc == "medals"){
		$f = $_POST['f'];
		if(allowed($f, 2) == 1){
			$m = $_POST['m'];
			$subject = $_POST['m_subject'];
			$url = $_POST['m_url'];
			$close = $_POST['m_close'];
			if($error == ""){
				$mysql->execute("UPDATE {$mysql->prefix}GLOBAL_MEDALS SET SUBJECT = '$subject', URL = '$url', CLOSE = '$close' WHERE MEDAL_ID = '$m' ", [], __FILE__, __LINE__);
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br><b>تم تعديل الوسام بنجاح</b></font><br><br>
	                       <meta http-equiv="Refresh" content="1; URL= index.php?mode=svc&method=svc&svc=medals">
                           <a href="index.php?mode=svc&method=svc&svc=medals">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
			}

		}
	}
	if(svc == "titles"){
		$f = $_POST['forum_id'];
		if(allowed($f, 2) == 1){
			$t = $_POST['t'];
			$subject = $_POST['subject'];
			$close = $_POST['close'];
			$forum = $_POST['forum'];
			$status = $_POST['status'];
			$refer = $_POST['refer'];
			echo $t;
			if($error == ""){
				$sql = "UPDATE {$mysql->prefix}GLOBAL_TITLES SET ";
				//if(allowed($f, 1) == 1 AND mlv > 2){
					$sql = $sql."CLOSE = '$close', ";
					$sql = $sql."SUBJECT = '$subject', ";
					$sql = $sql."FORUM = '$forum', ";
					$sql = $sql."STATUS = '$status', ";
					$sql = $sql."FORUM_ID = '$f' ";
				//}
				//else{
				//	$sql = $sql."CLOSE = '$close' ";
				//}
				$sql = $sql."WHERE TITLE_ID = '$t' ";
				$mysql->execute($sql, [], __FILE__, __LINE__);
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br><b>تم تعديل الوصف بنجاح</b></font><br><br>
	                       <meta http-equiv="Refresh" content="1; URL='.$refer.'">
                           <a href="'.$refer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
			}

		}
	}
	if(svc == "surveys"){
	    if($type == "data"){
		$f = $_POST['forum_id'];
		if(allowed($f, 2) == 1){
			$s = $_POST['s'];
			$subject = $_POST['subject'];
			$question = $_POST['question'];
			$status = $_POST['status'];
			$secret = $_POST['secret'];
			$days = $_POST['days'];
			$days_added = $_POST['days_added'];
			$min_days = $_POST['min_days'];
			$min_posts = $_POST['min_posts'];
			$refer = $_POST['refer'];
			$total_days = $days+$days_added;
			$all_days = $total_days*60*60*24;
			$start = surveys("START", $s);
			$end = $start + $all_days;
		                  $value = $_POST['value'];
		                  $other = $_POST['other'];
			if($error == ""){
				$sql = "UPDATE {$mysql->prefix}SURVEYS SET ";
				$sql .= "FORUM_ID = '$f', ";
				$sql .= "SUBJECT = '$subject', ";
				$sql .= "QUESTION = '$question', ";
				$sql .= "STATUS = '$status', ";
				$sql .= "SECRET = '$secret', ";
				$sql .= "DAYS = '$total_days', ";
				$sql .= "MIN_DAYS = '$min_days', ";
				$sql .= "MIN_POSTS = '$min_posts', ";
				$sql .= "END = '$end' ";
				$sql .= "WHERE SURVEY_ID = '$s' ";
				$mysql->execute($sql, [], __FILE__, __LINE__);

	$i = 0;
				for ($x = 1;$x < 30; ++$x){
$check = mysql_fetch_array($mysql->execute("select * from {$mysql->prefix}SURVEY_OPTIONS where OPTION_ID = '$x' AND SURVEY_ID = '$s' "));

if($check){
$mysql->execute("UPDATE {$mysql->prefix}SURVEY_OPTIONS SET VALUE = '$value[$i]',OTHER = '$other[$i]' WHERE SURVEY_ID = '$s' AND OPTION_ID = '$x' ");
}else{
if($value[$i] != ""){
$mysql->execute("INSERT INTO {$mysql->prefix}SURVEY_OPTIONS SET VALUE = '$value[$i]',OTHER = '$other[$i]',OPTION_ID = '$x',SURVEY_ID = '$s' ");
}
}

$i++;
				}


	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br><b>تم تعديل الإستفتاء بنجاح</b></font><br><br>
	                       <meta http-equiv="Refresh" content="1; URL='.$refer.'">
                           <a href="'.$refer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';

			}

		}
	    }
	}
	if(svc == "edits"){
		if($type == "t"){
			$t = edits("TOPIC_ID", $id);
			$f = topics("FORUM_ID", $t);
			if(allowed($f, 2) == 1){
				$old_subject = edits("OLD_SUBJECT", $id);
				$old_message = edits("OLD_MESSAGE", $id);
					$sql = "UPDATE {$mysql->prefix}TOPICS SET ";
					$sql .= "T_SUBJECT = '$old_subject', ";
					$sql .= "T_MESSAGE = '$old_message' ";
					$sql .= "WHERE TOPIC_ID = '$t' ";
					$mysql->execute($sql, $connection, [], __FILE__, __LINE__);
				echo'<br>
				<center>
				<table width="99%" border="1">
					<tr class="normal">
						<td class="list_center" colSpan="10"><font size="5"><br><b>تم إرجاع نص المشاركة بنجاح</b></font><br><br>
							<meta http-equiv="Refresh" content="1; URL=index.php?mode=svc&svc=edits&t='.$t.'">
							<a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
						</td>
					</tr>
				</table>
				</center>';
			}
		}
		if($type == "r"){
			$r = edits("REPLY_ID", $id);
			$f = replies("FORUM_ID", $r);
			if(allowed($f, 2) == 1){
				$old_message = edits("OLD_MESSAGE", $id);
					$sql = "UPDATE {$mysql->prefix}REPLY SET ";
					$sql .= "R_MESSAGE = '$old_message' ";
					$sql .= "WHERE REPLY_ID = '$r' ";
					$mysql->execute($sql, $connection, [], __FILE__, __LINE__);
				echo'<br>
				<center>
				<table width="99%" border="1">
					<tr class="normal">
						<td class="list_center" colSpan="10"><font size="5"><br><b>تم إرجاع نص المشاركة بنجاح</b></font><br><br>
							<meta http-equiv="Refresh" content="1; URL=index.php?mode=svc&svc=edits&r='.$r.'">
							<a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
						</td>
					</tr>
				</table>
				</center>';
			}
		}
	}
}

if(method == "app"){
	if(svc == "medals"){
		if($type == "global"){
			$app = $_POST['m_app'];
			$x = 0;
			while($x < count($app)){
				$f = gm("FORUM_ID", $app[$x]);
				if(allowed($f, 1) == 1){
					$mysql->execute("UPDATE {$mysql->prefix}GLOBAL_MEDALS SET STATUS = '1' WHERE MEDAL_ID = '$app[$x]' ", [], __FILE__, __LINE__);
				}
			++$x;
			}
			echo'<br>
			<center>
			<table width="99%" border="1">
				<tr class="normal">
					<td class="list_center" colSpan="10"><font size="5"><br><b>تمت موافقة على الأوسمة المختارة بنجاح</b></font><br><br>
						<meta http-equiv="Refresh" content="0; URL='.$referer.'">
						<a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
					</td>
				</tr>
			</table>
			</center>';
		}
		if($type == "awarded"){
			$m_app = $_POST['m_app'];
			$status = $_POST['status'];
			if($status == "app"){
				$num = 1;
				$msg_text = "تمت موافقة على الأوسمة المختارة بنجاح";
			}
			if($status == "ref"){
				$num = 2;
				$msg_text = "تم رفض الأوسمة المختارة بنجاح";
			}
			$x = 0;
			while($x < count($m_app)){
				$f = medals("FORUM_ID", $m_app[$x]);
				$m = medals("MEMBER_ID", $m_app[$x]);
				if(allowed($f, 1) == 1){
					$mysql->execute("UPDATE {$mysql->prefix}MEDALS SET STATUS = '$num' WHERE MEDAL_ID = '$m_app[$x]' ", [], __FILE__, __LINE__);
					if($num == 1){
						$mysql->execute("UPDATE {$mysql->prefix}MEMBERS SET M_MEDAL = '".chk_member_last_medal($m)."', M_POINTS = '".member_all_points($m)."' WHERE MEMBER_ID = '$m' ", [], __FILE__, __LINE__);
					}
				}
			++$x;
			}
			echo'<br>
			<center>
			<table width="99%" border="1">
				<tr class="normal">
					<td class="list_center" colSpan="10"><font size="5"><br><b>'.$msg_text.'</b></font><br><br>
						<meta http-equiv="Refresh" content="1; URL='.$referer.'">
						<a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
					</td>
				</tr>
			</table>
			</center>';
		}
	}
	if(svc == "titles"){
		if($type == "global"){
			$app = $_POST['t_app'];
			$x = 0;
			while($x < count($app)){
				$f = gt("FORUM_ID", $app[$x]);
				if(allowed($f, 1) == 1){
					$mysql->execute("UPDATE {$mysql->prefix}GLOBAL_TITLES SET STATUS = '1' WHERE TITLE_ID = '$app[$x]' ", [], __FILE__, __LINE__);
				}
			++$x;
			}
			echo'<br>
			<center>
			<table width="99%" border="1">
				<tr class="normal">
					<td class="list_center" colSpan="10"><font size="5"><br><b>تمت موافقة على الأوصاف المختارة بنجاح</b></font><br><br>
						<meta http-equiv="Refresh" content="1; URL='.$referer.'">
						<a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
					</td>
				</tr>
			</table>
			</center>';
		}
	}
	if(svc == "mon"){
		if($type == "details"){
			svc_details_mon($id);
		}
		if($type == "approve"){

		$monitor_notes = $_POST["monitor_notes"];
		$details_type = $_POST["details_type"];

		$member_id = moderation("MEMBERID", $id);
		$forum_id = moderation("FORUMID", $id);
		$topic_id = moderation("TOPICID", $id);
		$reply_id = moderation("REPLYID", $id);
		$pm = moderation("PM", $id);
		$added = moderation("ADDED", $id);
		$type = moderation("TYPE", $id);
		$raison = moderation("RAISON", $id);
		$pm_mid = "-".$forum_id;
		$date = time();

		$text = "تمت الموافقة على الطلب بنجاح";

		if($type == "7" AND $details_type == ""){
		    $error = "أنت لم تحدد نوع البيانات المراد اخفاؤها";
		}
		if($reply_id == "0"){
		    $rid = "";
		}
		else {
		    $rid = "&r=".$reply_id;
		}

		switch ($type){
		     case "2":
		          $txtSubject = "إشعار بوضع رقابة كاملة على جميع مشاركاتك";
			  $txtMessage = '<font color="red" size="3">نظرا لمخالفتك لشروط المشاركات في المنتديات فقد تم وضع رقابة على جميع مشاركاتك<br><br>والسبب هو : </front><br><font color="green" size="3">'.$raison.'</font><font color="black" size="3"><br><br>سنقوم بإعادة النظر في هذه الرقابة إذا لم تتكرر منك هذه المخالفات مستقبلا.<br>واذا تكرر الأمر سنضطر لرفع الأمر لإدارة المنتديات لإتخاذ أية خطوات أخرى تراها مناسبة.<br><a href="index.php?mode=t&t='.$topic_id.$rid.'">** إضغط هنا لمشاهدة المشاركة المعنية **</a><br></front>';
			  $TYPE = "طلب رقابة في جميع المنتديات";
		     break;
		     case "3":
		          $txtSubject = "إشعار بمنعك من المشاركة في منتدى ".forum_name($forum_id);
			  $txtMessage = '<font color="red" size="3">نظرا لمخالفتك لشروط المشاركات في المنتديات فقد تم منعك من المشاركة في منتدى '.forum_name($forum_id).'<br><br>والسبب هو : </front><br><font color="green" size="3">'.$raison.'</font><font color="black" size="3"><br><br>سنقوم بإعادة النظر في هذه الرقابة إذا لم تتكرر منك هذه المخالفات مستقبلا.<br>واذا تكرر الأمر سنضطر لرفع الأمر لإدارة المنتديات لإتخاذ أية خطوات أخرى تراها مناسبة.<br><a href="index.php?mode=t&t='.$topic_id.$rid.'">** إضغط هنا لمشاهدة المشاركة المعنية **</a><br></front>';
			  $TYPE = "طلب منع  في منتدى معين";
		     break;
		     case "4":
		          $txtSubject = "إشعار بمنعك من المشاركة في جميع المنتديات";
			  $txtMessage = '<font color="red" size="3">نظرا لمخالفتك لشروط المشاركات في المنتديات فقد تم منعك من الشاركة في جميع المنتديات<br><br>والسبب هو : </front><br><font color="green" size="3">'.$raison.'</font><font color="black" size="3"><br><br>سنقوم بإعادة النظر في هذه الرقابة إذا لم تتكرر منك هذه المخالفات مستقبلا.<br>واذا تكرر الأمر سنضطر لرفع الأمر لإدارة المنتديات لإتخاذ أية خطوات أخرى تراها مناسبة.<br><a href="index.php?mode=t&t='.$topic_id.$rid.'">** إضغط هنا لمشاهدة المشاركة المعنية **</a><br></front>';
			  $TYPE = "طلب منع  في جميع المنتديات";
		     break;
		     case "5":
			  $TYPE = "طلب قفل العضوية";
		     break;
		     case "6":
		          $txtSubject = "إشعار بمنعك من دخول النقاش الحي";
			  $txtMessage = '<font color="red" size="3">نظرا لمخالفتك لشروط المشاركات في المنتديات فقد تم منعك من دخول النقاش الحي<br><br>والسبب هو : </front><br><font color="green" size="3">'.$raison.'</font><font color="black" size="3"><br><br>سنقوم بإعادة النظر في هذه الرقابة إذا لم تتكرر منك هذه المخالفات مستقبلا.<br>واذا تكرر الأمر سنضطر لرفع الأمر لإدارة المنتديات لإتخاذ أية خطوات أخرى تراها مناسبة.<br><a href="index.php?mode=t&t='.$topic_id.$rid.'">** إضغط هنا لمشاهدة المشاركة المعنية **</a><br></front>';
			  $TYPE = "طلب منع من دخول النقاش الحي";
		     break;
		     case "7":
		          $txtSubject = "إشعار بإخفاء توقيعك وصورتك و بياناتك الشخصية";
			  $txtMessage = '<font color="red" size="3">نظرا لمخالفتك لشروط المشاركات في المنتديات فقد تم إخفاء توقيعك وصورتك و بياناتك الشخصية<br><br>والسبب هو : </front><br><font color="green" size="3">'.$raison.'</font><font color="black" size="3"><br><br>سنقوم بإعادة النظر في هذه الرقابة إذا لم تتكرر منك هذه المخالفات مستقبلا.<br>واذا تكرر الأمر سنضطر لرفع الأمر لإدارة المنتديات لإتخاذ أية خطوات أخرى تراها مناسبة.<br><a href="index.php?mode=t&t='.$topic_id.$rid.'">** إضغط هنا لمشاهدة المشاركة المعنية **</a><br></front>';
			  $TYPE = "إخفاء توقيع و صورة و بيانات العضو";
		     break;
		     case "8":
		          $txtSubject = "إشعار بإخفاء مشاركاتك عن باقي الأعضاء";
			  $txtMessage = '<font color="red" size="3">نظرا لمخالفتك لشروط المشاركات في المنتديات فقد تم إخفاء مشاركاتك عن باقي الأعضاء<br><br>والسبب هو : </front><br><font color="green" size="3">'.$raison.'</font><font color="black" size="3"><br><br>سنقوم بإعادة النظر في هذه الرقابة إذا لم تتكرر منك هذه المخالفات مستقبلا.<br>واذا تكرر الأمر سنضطر لرفع الأمر لإدارة المنتديات لإتخاذ أية خطوات أخرى تراها مناسبة.<br><a href="index.php?mode=t&t='.$topic_id.$rid.'">** إضغط هنا لمشاهدة المشاركة المعنية **</a><br></front>';
			  $TYPE = "إخفاء مشاركات العضو";
		     break;
		     case "9":
		          $txtSubject = "إشعار بإخفاء رسائلك الخاصة عن باقي الأعضاء";
			  $txtMessage = '<font color="red" size="3">نظرا لمخالفتك لشروط المشاركات في المنتديات فقد تم إخفاء رسائلك الخاصة عن باقي الأعضاء<br><br>والسبب هو : </front><br><font color="green" size="3">'.$raison.'</font><font color="black" size="3"><br><br>سنقوم بإعادة النظر في هذه الرقابة إذا لم تتكرر منك هذه المخالفات مستقبلا.<br>واذا تكرر الأمر سنضطر لرفع الأمر لإدارة المنتديات لإتخاذ أية خطوات أخرى تراها مناسبة.<br><a href="index.php?mode=t&t='.$topic_id.$rid.'">** إضغط هنا لمشاهدة المشاركة المعنية **</a><br></front>';
			  $TYPE = "إخفاء رسائل العضو الخاصة";
		     break;
		     case "10":
		          $txtSubject = "إشعار بمنعك من إستعمال الرسائل الخاصة";
			  $txtMessage = '<font color="red" size="3">نظرا لمخالفتك لشروط استعمال ميزة الرسائل الخاصة في المنتديات فقد تم منعك من استعمال هده الخاصية <br><br>والسبب هو : </font><br><font size="3">'.$raison.'</front><font color="black" size="3"><br><br>سنقوم بإعادة النظر في هذه الرقابة إذا لم تتكرر منك هذه المخالفات مستقبلا.<br>واذا تكرر الأمر سنضطر لرفع الأمر لإدارة المنتديات لإتخاذ أية خطوات أخرى تراها مناسبة.<br><a href="index.php?mode=pm&mail=msg&msg='.$pm.'">** إضغط هنا لمشاهدة المشاركة المعنية **</a><br></front>';
			  $TYPE = "منع من استعمال الرسائل الخاصة";
		     break;
		   case "11":
		          $txtSubject = "إشعار بمنعك من الدخول الى ".forum_name($forum_id);
			  $txtMessage = '<font color="red" size="3">نظرا لمخالفتك لشروط المشاركات في المنتديات فقد تم منعك من مشاهدة منتدى '.forum_name($forum_id).'<br><br>والسبب هو : </front><br><font color="green" size="3">'.$raison.'</font><font color="black" size="3"><br><br>سنقوم بإعادة النظر في هذه الرقابة إذا لم تتكرر منك هذه المخالفات مستقبلا.<br>واذا تكرر الأمر سنضطر لرفع الأمر لإدارة المنتديات لإتخاذ أية خطوات أخرى تراها مناسبة.<br><a href="index.php?mode=t&t='.$topic_id.$rid.'">** إضغط هنا لمشاهدة المشاركة المعنية **</a><br></front>';
			  $TYPE = "طلب منع من مشاهدة منتدى معين";
		     break;
		   case "12":
		   $txtSubject = "إشعار بمنعك من إضافة الإهدائات ";
			  $txtMessage = '<font color="red" size="3">نظرا لمخالفتك لشروط استعمال الإهدائات في المنتديات فقد تم منعك من استعمال هذه الخاصية <br><br>والسبب هو : </font><br><font size="3">'.$raison.'</front><font color="black" size="3"><br><br>سنقوم بإعادة النظر في هذه الرقابة إذا لم تتكرر منك هذه المخالفات مستقبلا.<br>واذا تكرر الأمر سنضطر لرفع الأمر لإدارة المنتديات لإتخاذ أية خطوات أخرى تراها مناسبة.<br><br></front>';
			  $TYPE = "طلب منع من إضافة الإهدائات";
		     break;

		}

		$moderatorPM_subject = "قبول طلب - ".$TYPE." - العضو: ".member_name($member_id);
		$moderatorPM_message = '
		<table cellSpacing="1" cellPadding="1" width="50%">
			<tr>
				<td class="stats_t" colspan="2"><font size="+2" color="yellow">قبول طلب: '.$TYPE.'</font></td>
			</tr>
			<tr>
				<td class="stats_g" width="50%">العضو</td>
				<td class="stats_p">'.link_profile(member_name($member_id), $member_id).'</td>
			</tr>
			<tr>
				<td class="stats_g">النوع المطلوب</td>
				<td class="stats_p"><font color="red">'.$TYPE.'</font></td>
			</tr>
			<tr>
				<td class="stats_g">سبب الطلب</td>
				<td class="stats_p"><font color="red">'.$raison.'</font></td>
			</tr>
			<tr>
				<td class="stats_g">ملاحظات المراقب</td>
				<td class="stats_p"><font color="red">'.$monitor_notes.'</font></td>
			</tr>
		</table>';

		if($error != ""){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
		}

		if($error == ""){
	
		// SEND PM TO MODERATOR WHO ADDED THE MODERATION
		send_pm($DBMemberID, $added, $moderatorPM_subject, $moderatorPM_message, $date);

		if($type != 5){
		// SEND PM TO MEMBER ABOUT THE RAISON OF THE MODERATION
		send_pm($pm_mid, $member_id, $txtSubject, $txtMessage, $date);
		}
	
		if($type == 5){
		     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
		     $update .= "M_STATUS = '0' ";
		     $update .= "WHERE MEMBER_ID = '$member_id' ";
		     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
		}
		else if($type == 6){
		     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
		     $update .= "M_ALLOWCHAT = '0' ";
		     $update .= "WHERE MEMBER_ID = '$member_id' ";
		     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
		}
		else if($type == 7){

		  if($details_type == 1){
			$hide = "M_HIDE_PHOTO = '1' ";
		  }
		  else if($details_type == 2){
			$hide = "M_HIDE_SIG = '1' ";
		  }
		  else if($details_type == 3){
			$hide = "M_HIDE_DETAILS = '1' ";
		  }

		     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
		     $update .= $hide;
		     $update .= "WHERE MEMBER_ID = '$member_id' ";
		     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
		}
		else if($type == 8){
		     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
		     $update .= "M_HIDE_POSTS = '1' ";
		     $update .= "WHERE MEMBER_ID = '$member_id' ";
		     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
		}
		else if($type == 9){
		     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
		     $update .= "M_HIDE_PM = '1' ";
		     $update .= "WHERE MEMBER_ID = '$member_id' ";
		     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
		}

		else if($type == 10){
		     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
		     $update .= "M_USE_PM = '1' ";
		     $update .= "WHERE MEMBER_ID = '$member_id' ";
		     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
		}
		else if($type == 12){
		     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
		     $update .= "M_IHDAA = '1' ";
		     $update .= "WHERE MEMBER_ID = '$member_id' ";
		     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
		}
		     $up = "UPDATE {$mysql->prefix}MODERATION SET ";
		     $up .= "M_STATUS = '1', ";
		     $up .= "M_EXECUTE = '$added', ";
		     $up .= "M_DATEAPP = '$date' ";
		     $up .= "WHERE MODERATION_ID = '$id' ";
		     $mysql->execute($up, $connection, [], __FILE__, __LINE__);

			echo'<br>
			<center>
			<table width="99%" border="1">
				<tr class="normal">
					<td class="list_center" colSpan="10"><font size="5"><br>'.$text.'</font><br><br>
						<meta http-equiv="Refresh" content="2; URL=index.php?mode=svc&method=svc&svc=mon&show=mon_pending">
						<a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
					</td>
				</tr>
			</table>
			</center>';
		} // FOR ERROR
		}
	}
}

if(method == "trash"){
	if(svc == "titles"){
		$gt_id = titles("GT_ID", $t);
		$m = titles("MEMBER_ID", $t);
		$f = gt("FORUM_ID", $gt_id);
		if(allowed($f, 2) == 1){
			$mysql->execute("UPDATE {$mysql->prefix}TITLES SET STATUS = '0' WHERE TITLE_ID = '$t' ", [], __FILE__, __LINE__);
			$sql = "INSERT INTO {$mysql->prefix}USED_TITLES (ID, TITLE_ID, MEMBER_ID, STATUS, ADDED, DATE) VALUES (NULL, ";
			$sql .= " '$gt_id', ";
			$sql .= " '$m', ";
			$sql .= " '0', ";
			$sql .= " '$DBMemberID', ";
			$sql .= " '".time()."') ";
			$mysql->execute($sql, [], __FILE__, __LINE__);
			echo'<br>
			<center>
			<table width="99%" border="1">
				<tr class="normal">
					<td class="list_center" colSpan="10"><font size="5"><br><b>تم حذف الوصف بنجاح</b></font><br><br>
						<meta http-equiv="Refresh" content="1; URL='.$referer.'">
						<a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
					</td>
				</tr>
			</table>
			</center>';
		}
	}
	if(svc == "prv"){
		$t = topic_members("TOPIC_ID", $id);
		$f = topics("FORUM_ID", $t);
		if(allowed($f, 2) == 1){
			$mysql->execute("DELETE FROM {$mysql->prefix}TOPIC_MEMBERS WHERE TM_ID = '$id' ", [], __FILE__, __LINE__);
			echo'<br>
			<center>
			<table width="99%" border="1">
				<tr class="normal">
					<td class="list_center" colSpan="10"><font size="5"><br><b>تم حذف العضو من القائمة بنجاح</b></font><br><br>
						<meta http-equiv="Refresh" content="1; URL='.$referer.'">
						<a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
					</td>
				</tr>
			</table>
			</center>';
		}
	}
	if(svc == "mon"){
		$f = moderation("FORUMID", $id);
		if(allowed($f, 2) == 1){
		    if($type == "delete"){
			$mysql->execute("DELETE FROM {$mysql->prefix}MODERATION WHERE MODERATION_ID = '$id' ", [], __FILE__, __LINE__);
			$text = "تم حذف الطلب بنجاح";
		    }
		    else if($type == "reject"){
			$mysql->execute("UPDATE {$mysql->prefix}MODERATION SET M_STATUS = '2' WHERE MODERATION_ID = '$id' ", [], __FILE__, __LINE__);
			$text = "تم رفض الطلب بنجاح";
		    }
		    else if($type == "exp"){
			$dateExp = time();
			$text = "تم إلغاء الرقابة أو المنع بنجاح";
			$member_id = moderation("MEMBERID", $id);
			$forum_id = moderation("FORUMID", $id);
			$type = moderation("TYPE", $id);
			$pm_mid = "-".$forum_id;

			switch ($type){
			     case "1":
			          $txtSubject = "إشعار بإزلة الرقابة عن مشاركاتك في منتدى ".forum_name($forum_id);
				  $txtMessage = '<font color="blue" size="3">يسرنا أن نعلمك بأنه قد تم ازالة الرقابة عن مشاركاتك '.forum_name($forum_id).'<br><br>نتمنى ألا تتكرر مخالفاتك لشروط المنتديات</front>';
			     break;
			     case "2":
			          $txtSubject = "إشعار بإزلة الرقابة عن جميع مشاركاتك";
				  $txtMessage = '<font color="blue" size="3">يسرنا أن نعلمك بأنه قد تم ازالة الرقابة عن جميع مشاركاتك<br><br>نتمنى ألا تتكرر مخالفاتك لشروط المنتديات</front>';
			     break;
			     case "3":
			          $txtSubject = "إشعار بإزالة المنع عن مشاركاتك في منتدى ".forum_name($forum_id);
				  $txtMessage = '<font color="blue" size="3">يسرنا أن نعلمك بأنه قد تم ازالة المنع عن مشاركاتك في منتدى '.forum_name($forum_id).'<br><br>نتمنى ألا تتكرر مخالفاتك لشروط المنتديات</front>';
			     break;
			     case "4":
			          $txtSubject = "إشعار بإزالة المنع عن مشاركاتك في جميع المنتديات";
				  $txtMessage = '<font color="blue" size="3">يسرنا أن نعلمك بأنه قد تم ازالة المنع عن جميع مشاركاتك<br><br>نتمنى ألا تتكرر مخالفاتك لشروط المنتديات</front>';
			     break;
			     case "6":
			          $txtSubject = "إشعار بإزالة المنع من دخول النقاش الحي";
				  $txtMessage = '<font color="blue" size="3">يسرنا أن نعلمك بأنه قد تم ازالة المنع من دخول النقاش الحي<br><br>نتمنى ألا تتكرر مخالفاتك لشروط المنتديات</front>';
			     break;
			     case "7":
			          $txtSubject = "إشعار بإظهار توقيعك أوصورتك أو بياناتك الشخصية";
				  $txtMessage = '<font color="blue" size="3">يسرنا أن نعلمك بأنه قد تم اظهار توقيك أو صورتك أو بياناتك الشخصية<br><br>نتمنى ألا تتكرر مخالفاتك لشروط المنتديات</front>';
			     break;
			     case "8":
			          $txtSubject = "إشعار بإظهار مشاركاتك لباقي الأعضاء";
				  $txtMessage = '<font color="blue" size="3">يسرنا أن نعلمك بأنه قد تم إظهار مشاركاتك لباقي الأعضاء<br><br>نتمنى ألا تتكرر مخالفاتك لشروط المنتديات</front>';
			     break;
			     case "9":
			          $txtSubject = "إشعار بإظهار رسائلك الخاصة لباقي الأعضاء";
				  $txtMessage = '<font color="blue" size="3">يسرنا أن نعلمك بأنه قد تم اظهار رسائلك الخاصة لباقي الأعضاء<br><br>نتمنى ألا تتكرر مخالفاتك لشروط المنتديات</front>';
			     break;
			     case "10":
			          $txtSubject = "إشعار بإزالة المنع عن ميزة الرسائل الخاصة";
				  $txtMessage = '<font color="blue" size="3">يسرنا أن نعلمك بأنه قد تم إزالة المنع عن ميزة الرسائل الخاصة <br><br>نتمنى ألا تتكرر مخالفاتك لشروط المنتديات</front>';
			$pm_mid = moderation("ADDED", $id);
			     break;
			     case "11":
			          $txtSubject = "إشعار بإزالة المنع عن مشاهدة ".forum_name($forum_id);
				  $txtMessage = '<font color="blue" size="3">يسرنا أن نعلمك بأنه قد تم ازالة المنع عن مشاهدة '.forum_name($forum_id).'<br><br>نتمنى ألا تتكرر مخالفاتك لشروط المنتديات</front>';
			     break;
			     case "12":
			          $txtSubject = "إشعار بإزالة المنع عن ميزة الإهدائات";
				  $txtMessage = '<font color="blue" size="3">يسرنا أن نعلمك بأنه قد تم إزالة المنع عن ميزة الإهدائات <br><br>نتمنى ألا تتكرر مخالفاتك لشروط المنتديات</front>';
			     break;

			}

			if($type != 5){
			// SEND PM TO MEMBER ABOUT CANCEL THE MODERATION
			send_pm($pm_mid, $member_id, $txtSubject, $txtMessage, $date);
			}

			if($type == 5){
			     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
			     $update .= "M_STATUS = '1' ";
			     $update .= "WHERE MEMBER_ID = '$member_id' ";
			     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
			}
			else if($type == 6){
			     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
			     $update .= "M_ALLOWCHAT = '1' ";
			     $update .= "WHERE MEMBER_ID = '$member_id' ";
			     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
			}
			else if($type == 7){
			     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
			     $update .= "M_HIDE_PHOTO = '0', ";
			     $update .= "M_HIDE_SIG = '0', ";
			     $update .= "M_HIDE_DETAILS = '0' ";
			     $update .= "WHERE MEMBER_ID = '$member_id' ";
			     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
			}
			else if($type == 8){
			     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
			     $update .= "M_HIDE_POSTS = '0' ";
			     $update .= "WHERE MEMBER_ID = '$member_id' ";
			     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
			}
			else if($type == 9){
			     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
			     $update .= "M_HIDE_PM = '0' ";
			     $update .= "WHERE MEMBER_ID = '$member_id' ";
			     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
			}
			else if($type == 10){
			     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
			     $update .= "M_USE_PM = '0' ";
			     $update .= "WHERE MEMBER_ID = '$member_id' ";
			     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
			}
			else if($type == 12){
			     $update = "UPDATE {$mysql->prefix}MEMBERS SET ";
			     $update .= "M_IHDAA = '0' ";
			     $update .= "WHERE MEMBER_ID = '$member_id' ";
			     $mysql->execute($update, $connection, [], __FILE__, __LINE__);
			}
			     $up = "UPDATE {$mysql->prefix}MODERATION SET ";
			     $up .= "M_STATUS = '3', ";
			     $up .= "M_END = '$DBMemberID', ";
			     $up .= "M_DATEFIN = '$dateExp' ";
			     $up .= "WHERE MODERATION_ID = '$id' ";
			     $mysql->execute($up, $connection, [], __FILE__, __LINE__);
		    }
			echo'<br>
			<center>
			<table width="99%" border="1">
				<tr class="normal">
					<td class="list_center" colSpan="10"><font size="5"><br>'.$text.'</font><br><br>
						<meta http-equiv="Refresh" content="1; URL='.$referer.'">
						<a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
					</td>
				</tr>
			</table>
			</center>';
		}
	}
}

// ################################################### IP SECTION ########################################

if(svc == "ip"){
if(mlv < 2){
redirect();
}
if($id AND mlv == 4) $DBMemberID = $id;
$titl_e = "الدولة";
$titl_b = "اخر بيانات الاتصال";
if($type == "info"){ 
$titl_e = "النوع"; 
$titl_b = "سجل محاولات الدخول";
}
echo'
	<center>
	<table cellSpacing="1" cellPadding="2" width="40%" border="0">
		<tr>
			<td class="optionsbar_menus" width="100%" colspan="3">&nbsp;<nobr><font color="red" size="+1">
'.$titl_b.' للعضوية رقم : '.$DBMemberID.' <br> </font></nobr></td></tr><tr><td class="stats_h">التاريخ و الوقت</td><td class="stats_h">'.$titl_e.'</td><td class="stats_h">IP</td></tr>';

$sql = $mysql->execute("select * from {$mysql->prefix}IP where m_id = '".$DBMemberID."' order by ID desc ");

if(mysql_num_rows($sql) != 0){
for($i=0;$i<mysql_num_rows($sql);$i++){
$row = mysql_fetch_array($sql);
if($type == "info"){
$enter = '<font color="green">دخول طبيعي</font>';
if($row['TYPE'] == 1) $enter = '<font color="red">كلمة سرية خاطئة</font>';
echo '<tr><td class="stats_g">'.date("d/m/Y h:m:s",$row[DATE]).'</td><td class="stats_p">'.$enter.'</td><td class="stats_p"><a target="_blank" href="http://api.hostip.info/?ip='.$row[IP].'">'.$row[IP].'</a></td></tr>';
}else{
echo '<tr><td class="stats_g">'.date("d/m/Y h:m:s",$row[DATE]).'</td><td class="stats_p">'.$row[COUNTRY].'</td><td class="stats_p"><a target="_blank" href="http://api.hostip.info/?ip='.$row[IP].'">'.$row[IP].'</a></td></tr>';
}
}
}else{
echo '<tr><td colspan="3" class="stats_p" align="center">لا يوجد لديك اي سجل حاليا</td></tr>';
}
echo '</table>';
}

// ################################################### SEARCH SHOW SECTION ########################################

if(svc == "search"){
if(mlv != 4){
redirect();
}
if(empty($id)) $id = m_id;

echo '<center>
	<table class="grid" cellSpacing="1" cellPadding="0"  width="55%">
<tr><td colspan="7" class="optionheader_selected">اخر عمليات بحث قام بها العضو '.member_name($id).' في اخر 24 ساعة</td></tr>
<tr><td class="cat">كلمة البحث</td><td class="cat">التاريخ</td><td class="cat">نوع العملية</td><td class="cat">المنتدى</td><td class="cat">عن العضو</td><td class="cat">بشهر</td><td class="cat">بسنة</td></tr>';


$Hour = time() - (24 * 3600);

$sql = $mysql->execute("select * from {$mysql->prefix}SEARCH where MEMBER_ID = '$id' AND DATE >= $Hour", [], __FILE__, __LINE__);

while($r = mysql_fetch_array($sql)){
if($r['TYPE'] == 0){
$type = "بحث في العناوين والمواضيع";
}else{
$type = "بحث في الردود";
}
if(forums("SUBJECT",$r['FORUM'])){
$forum = forums("SUBJECT",$r['FORUM']);
}else{
$forum = "--";
}
if($r['IN_USER']){
$m = member_name($r['IN_USER']);
$in_user = link_profile($m,$r['IN_USER']);
}else{
$in_user = "--";
}


if($r['MONTH']){
$month = $r['MONTH'];
}else{
$month = "--";
}

if($r['YEAR']){
$year = $r['YEAR'];
}else{
$year = "--";
}

echo '<tr>
<td class="f1" align="center"><nobr>'.trim(htmlspecialchars($r['QUERY'])).'</nobr></td>
<td class="f2ts" style="color:red"><nobr>'.normal_date($r['DATE']).'</nobr></td>
<td class="f1" align="center"><nobr>'.$type.'</nobr></td>
<td class="f1" align="center"><nobr>'.$forum.'</nobr></td>
<td class="f1" align="center"><nobr>'.$in_user.'</nobr></td>
<td class="f1" align="center">'.$month.'</td>
<td class="f1" align="center">'.$year.'</td>
</tr>';
}

}


// ######################################################### Bye Bye !! ##########################################
}// if mlv > 1 {
?>