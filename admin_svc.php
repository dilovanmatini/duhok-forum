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

function title_tr($title){
	echo'
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>'.$title.'</nobr></td>
	</tr>';
}

function value_tr($title, $value){
	echo'
	<tr class="fixed">
		<td class="list" width="1%"><nobr><b>&nbsp;'.$title.'&nbsp;&nbsp;</b></nobr></td>
		<td class="list">(&nbsp;<font color="red">'.$value.'</font>&nbsp;)</td>
	</tr>';
}

function admin_body(){
	global $lang, $_SERVER, $show_alexa_traffic; 
	echo'
	<center>
	<table class="grid" border="0" cellspacing="1" cellpadding="4" width="50%">';

		title_tr("إحصائيات العضويات والأسماء");
		value_tr('<a href="index.php?mode=admin_svc&type=change_name">الأسماء التي تنتظر الموافقة</a>', changename_count (1));
		value_tr('<a href="index.php?mode=admin_svc&type=approve">العضويات التي تنتظر الموافقة</a>', num_user_wait());
		value_tr('<a href="index.php?mode=admin_svc&type=hold">العضويات التي تم رفضها</a>', num_user_not_agree());
		value_tr('<a href="index.php?mode=members&type=lock">'.$lang[body][lock_users].'</a>', users_number(0, 0));
		
		title_tr($lang[body][users_num]);
		value_tr($lang[body][users], users_number(1, 1));
		value_tr($lang[body][mods], users_number(2, 1));
		value_tr($lang[body][mons], users_number(3, 1));
		value_tr($lang[body][admins], users_number(4, 1));
		
		title_tr($lang[body][onlines]);
		value_tr($lang[body][visitors], online_numbers(0));
		value_tr($lang[body][users], online_numbers(1));
		value_tr($lang[body][mods], online_numbers(2));
		value_tr($lang[body][mons], online_numbers(3));
		value_tr($lang[body][admins],online_numbers(4));
		
		title_tr($lang[body][topics_num]);
		value_tr($lang[body][all_topics_in_24_h], topics_numbers_for_24_h(1));
		value_tr($lang[body][all_topics_in_30_d], topics_numbers_for_24_h(30));
		value_tr($lang[body][middle_topics_in_day], topics_numbers_middle());
		value_tr($lang[body][all_topics], topics_numbers());
		
		title_tr($lang[body][replies_num]);
		value_tr($lang[body][all_replies_in_24_h], replies_numbers_for_24_h(1));
		value_tr($lang[body][all_replies_in_30_d], replies_numbers_for_24_h(30));
		value_tr($lang[body][middle_replies_in_day], replies_numbers_middle());
		value_tr($lang[body][all_replies], replies_numbers());
		
		
		
				title_tr($lang[body][pm_num]);
		value_tr($lang[body][all_pm_in_24_h], msg_numbers_for_24_h(1));
		value_tr($lang[body][all_pm_in_30_d], msg_numbers_for_24_h(30));
		value_tr($lang[body][middle_pm_in_day], msg_numbers_middle());
		value_tr($lang[body][all_pm], msg_numbers());



	if($show_alexa_traffic == 1){
		title_tr("ترتيب موقعك في اليكسا");
		echo'
		<tr class="fixed">
			<td class="list_center" colspan="2"><nobr><script type="text/javascript" language="javascript" src="http://xslt.alexa.com/site_stats/js/t/a?amzn_id=555777-20&url='.$site_name.'"></script></nobr></td>
		</tr>';
	}
		echo'
		<tr class="fixed">
			<td align="middle" colspan="2"><br><font face="Tahoma" color="black" style="FONT-SIZE: 11px">Copyright &copy; Dilovan Matini 2007 - '._this_year.'. All rights reserved</font></td>
		</tr>
	</table>
	</center><br><br>';
}

function admin_approve(){
	global $lang, $user_id, $ulv, $max_page, $img;
	echo'
	<script language="javascript">
		function chk_app_user(obj){
			if(obj.name == "approve"){
				var go_to = confirm("هل أنت متأكد بأن تريد موافقة على العضويات المختارة");
				if(go_to){
					obj.form.method.value = "approve";
					obj.form.submit();
				}
				else{
					return;
				}
			}
			if(obj.name == "hold"){
				var go_to = confirm("هل أنت متأكد بأن تريد رفض العضويات المختارة");
				if(go_to){
					obj.form.method.value = "hold";
					obj.form.submit();
				}
				else{
					return;
				}
			}
			if(obj.name == "delete"){
				var go_to = confirm("هل أنت متأكد بأن تريد حذف العضويات المختارة");
				if(go_to){
					obj.form.method.value = "delete";
					obj.form.submit();
				}
				else{
					return;
				}
			}
		}
	</script>
	<center>
	<table cellSpacing="1" cellPadding="5">
	<form name="app_user" method="post" action="index.php?mode=admin_svc&type=set_approve">
	<input type="hidden" name="method">
		<tr>
			<td class="optionsbar_menus" colSpan="20"><font color="red" size="+1"><b>العضويات التي تنتظر الموافقة</b></font></td>
		</tr>
		<tr>
			<td class="stats_h">&nbsp;</td>
			<td class="stats_h"><nobr>الرقم</nobr></td>
			<td class="stats_h"><nobr>اسم العضوية</nobr></td>
			<td class="stats_h"><nobr>البريد الالكتروني</nobr></td>
			<td class="stats_h"><nobr>عنوان IP</nobr></td>
			<td class="stats_h"><nobr>الدولة</nobr></td>
			<td class="stats_h"><nobr>تاريخ التسجيل</nobr></td>
		</tr>';
	$limit = pg_limit($max_page);
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE M_STATUS = '2' ORDER BY M_DATE DESC LIMIT $limit, $max_page", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
	$i = 0;
	while ($i < $num){
		$u = mysql_result($sql, $i, "MEMBER_ID");
		$name = members("NAME", $u);
		$email = members("EMAIL", $u);
		$ip = members("IP", $u);
		$country = members("COUNTRY", $u);
		$date = members("DATE", $u);
		$name = members("NAME", $u);
		if($country == ""){
			$cont = '-';
		}
		else{
			$cont = $country;
		}
		echo'
		<tr>
			<td class="stats_p"><nobr>&nbsp;<input class="small" type="checkbox" name="app[]" value="'.$u.'"></nobr></td>
			<td class="stats_h">'.$u.'</td>
			<td class="stats_g" align="center"><font color="#ffffff"><b>'.$name.'</b></font></td>
			<td class="stats_p"><font color="#000000">'.$email.'</font></td>
			<td class="stats_h"><a href="http://www.ipchecking.com/?ip='.$ip.'" title="انقر هنا للمزيد من المعلومات حول هذا الاي بي"><font color="#ffffff">'.$ip.'</font></a></td>
			<td class="stats_p" align="center"><font color="#000000">'.$cont.'</font></td>
			<td class="stats_p"><font color="red">'.date_and_time($date, 1).'</font></td>
		</tr>';
		$x = $x + 1;
	++$i;
	}
	if($x > 0){
		echo'
		<tr>
			<td height="30" colspan="20">&nbsp;</td>
		</tr>
		<tr>
			<td class="optionsbar_menus" colspan="20">
				<input type="button" value="تحديد الكل" onclick="this.value=check(this.form.elements, \'عدد العضويات الذي تم اختيارها\')">&nbsp;&nbsp;&nbsp;&nbsp;
				<input name="approve" type="button" onclick="chk_app_user(this)" value="الموافقة على العضويات المختارة">&nbsp;
				<input name="hold" type="button" onclick="chk_app_user(this)" value="رفض العضويات المختارة">&nbsp;
				<input name="delete" type="button" onclick="chk_app_user(this)" value="حذف العضويات المختارة">
			</td>
		</tr>';
	}
	else{
		echo'
		<tr>
			<td class="stats_p" align="middle" colSpan="20"><font color="black"><br>لا يوجد أي عضوية تنتظر الموافقة<br><br></font></td>
		</tr>';
	}
	echo'
	</form>
	</table>
	<center>';
}

function admin_approve_set(){
	global $lang, $_POST, $referer;
	$method = $_POST['method'];
	$app = $_POST['app'];
	
	if($app == ""){
		$error = "أنت لم تختر أي عضوية";
	}
	if($error != ""){
		error_message($error);
	}
	if($error == ""){
		if($method == "approve"){
			$i = 0;
			while($i  < count($app)){
				$mysql->execute("UPDATE {$mysql->prefix}MEMBERS SET M_STATUS = '1' WHERE MEMBER_ID = '$app[$i]' ", [], __FILE__, __LINE__);
			$i++;
			}
			$msg_txt = "تمت الموافقة على العضويات المختارة بنجاح";
		}
		if($method == "hold"){
			$i = 0;
			while($i  < count($app)){
				$mysql->execute("UPDATE {$mysql->prefix}MEMBERS SET M_STATUS = '3' WHERE MEMBER_ID = '$app[$i]' ", [], __FILE__, __LINE__);
			$i++;
			}
			$msg_txt = "تم رفض العضويات المختارة بنجاح";
		}
		if($method == "delete"){
			$i = 0;
			while($i  < count($app)){
				$mysql->execute("DELETE FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$app[$i]' ", [], __FILE__, __LINE__);
			$i++;
			}
			$msg_txt = "تم حذف العضويات المختارة بنجاح";
		}
		echo'
		<center>
		<table width="99%" border="1">
			<tr class="normal">
				<td class="list_center" colSpan="10"><font size="5"><br><b>'.$msg_txt.'</b></font><br><br>
					<meta http-equiv="refresh" content="1; URL='.$referer.'">
					<a href="'.$referer.'">'.$lang['profile']['click_here_to_go_normal_page'].'</a><br><br>
				</td>
			</tr>
		</table>
		</center>';
	}
}

function admin_hold(){
	global $lang, $user_id, $ulv, $max_page, $img;
	echo'
	<script language="javascript">
		function chk_app_user(obj){
			if(obj.name == "approve"){
				var go_to = confirm("هل أنت متأكد من الموافقة على العضويات المختارة");
				if(go_to){
					obj.form.method.value = "approve";
					obj.form.submit();
				}
				else{
					return;
				}
			}
			if(obj.name == "delete"){
				var go_to = confirm("هل أنت متأكد من حذف العضويات المختارة");
				if(go_to){
					obj.form.method.value = "delete";
					obj.form.submit();
				}
				else{
					return;
				}
			}
		}
	</script>
	<center>
	<table cellSpacing="1" cellPadding="5">
	<form name="app_user" method="post" action="index.php?mode=admin_svc&type=set_approve">
	<input type="hidden" name="method">
		<tr>
			<td class="optionsbar_menus" colSpan="20"><font color="red" size="+1"><b>العضويات التي تم رفضها</b></font></td>
		</tr>
		<tr>
			<td class="stats_h">&nbsp;</td>
			<td class="stats_h"><nobr>الرقم</nobr></td>
			<td class="stats_h"><nobr>اسم العضوية</nobr></td>
			<td class="stats_h"><nobr>البريد الالكتروني</nobr></td>
			<td class="stats_h"><nobr>عنوان IP</nobr></td>
			<td class="stats_h"><nobr>الدولة</nobr></td>
			<td class="stats_h"><nobr>تاريخ التسجيل</nobr></td>
		</tr>';
	$limit = pg_limit($max_page);
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE M_STATUS = '3' ORDER BY M_DATE DESC LIMIT $limit, $max_page", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
	$i = 0;
	while ($i < $num){
		$u = mysql_result($sql, $i, "MEMBER_ID");
		$name = members("NAME", $u);
		$email = members("EMAIL", $u);
		$ip = members("IP", $u);
		$country = members("COUNTRY", $u);
		$date = members("DATE", $u);
		$name = members("NAME", $u);
		if($country == ""){
			$cont = '-';
		}
		else{
			$cont = $country;
		}
		echo'
		<tr>
			<td class="stats_p"><nobr>&nbsp;<input class="small" type="checkbox" name="app[]" value="'.$u.'"></nobr></td>
			<td class="stats_h">'.$u.'</td>
			<td class="stats_g" align="center"><font color="#ffffff"><b>'.$name.'</b></font></td>
			<td class="stats_p"><font color="#000000">'.$email.'</font></td>
			<td class="stats_h"><a href="http://www.ipchecking.com/?ip='.$ip.'" title="انقر هنا للمزيد من المعلومات حول هذا الاي بي"><font color="#ffffff">'.$ip.'</font></a></td>
			<td class="stats_p" align="center"><font color="#000000">'.$cont.'</font></td>
			<td class="stats_p"><font color="red">'.date_and_time($date, 1).'</font></td>
		</tr>';
		$x = $x + 1;
	++$i;
	}
	if($x > 0){
		echo'
		<tr>
			<td height="30" colspan="20">&nbsp;</td>
		</tr>
		<tr>
			<td class="optionsbar_menus" colspan="20">
				<input type="button" value="تحديد الكل" onclick="this.value=check(this.form.elements, \'عدد العضويات الذي تم اختيارها\')">&nbsp;&nbsp;&nbsp;&nbsp;
				<input name="approve" type="button" onclick="chk_app_user(this)" value="الموافقة على العضويات المختارة">&nbsp;
				<input name="delete" type="button" onclick="chk_app_user(this)" value="حذف العضويات المختارة">
			</td>
		</tr>';
	}
	else{
		echo'
		<tr>
			<td class="stats_p" align="middle" colSpan="20"><font color="black"><br>لا يوجد أي عضوية قمت برفضها<br><br></font></td>
		</tr>';
	}
	echo'
	</form>
	</table>
	<center>';
}

function admin_hold_set(){
	global $lang, $_POST, $referer;
	$method = $_POST['method'];
	$app = $_POST['app'];
	
	if($app == ""){
		$error = "أنت لم تختر أي عضوية";
	}
	if($error != ""){
		error_message($error);
	}
	if($error == ""){
		if($method == "approve"){
			$i = 0;
			while($i  < count($app)){
				$mysql->execute("UPDATE {$mysql->prefix}MEMBERS SET M_STATUS = '1' WHERE MEMBER_ID = '$app[$i]' ", [], __FILE__, __LINE__);
			$i++;
			}
			$msg_txt = "تمت الموافقة على عضويات المختارة بنجاح";
		}
		if($method == "delete"){
			$i = 0;
			while($i  < count($app)){
				$mysql->execute("DELETE FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$app[$i]' ", [], __FILE__, __LINE__);
			$i++;
			}
			$msg_txt = "تم حذف العضويات المختارة بنجاح";
		}
		echo'
		<center>
		<table width="99%" border="1">
			<tr class="normal">
				<td class="list_center" colSpan="10"><font size="5"><br><b>'.$msg_txt.'</b></font><br><br>
					<meta http-equiv="refresh" content="1; URL='.$referer.'">
					<a href="'.$referer.'">'.$lang['profile']['click_here_to_go_normal_page'].'</a><br><br>
				</td>
			</tr>
		</table>
		</center>';
	}
}

function admin_change_name(){
		echo'
		<center>
		<table cellSpacing="1" cellPadding="3" width="60%" border="0">
			<tr>
				<td class="stats_h">الرقم</td>
				<td class="stats_h">التاريخ</td>
				<td class="stats_h">من</td>
				<td class="stats_h">الى</td>
				<td class="stats_h">خيارات</td>
			</tr>';
		$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}CHANGENAME_PENDING WHERE CH_DONE = '0' AND UNDERDEMANDE = '1' ORDER BY CH_DATE ASC ", [], __FILE__, __LINE__);
		$num = mysql_num_rows($sql);
		if($num == 0){
			echo'
			<tr>
				<td class="stats_p" align="middle" colSpan="11"><font color="black" size="3"><br>لا توجد أية طلبات حاليا..<br><br></font></td>
			</tr>';
		}
		$i=0;
		while ($i < $num){
			$ch = mysql_result($sql, $i, "CHNAME_ID");
			$m = mysql_result($sql, $i, "MEMBERID");
			$new_name = mysql_result($sql, $i, "NEW_NAME");
			$last_name = mysql_result($sql, $i, "LAST_NAME");
			$date = mysql_result($sql, $i, "CH_DATE");
			echo '
			<tr class="normal">
				<td class="stats_h">'.$ch.'</td>
				<td class="stats_g">'.date_and_time($date, 1).'</td>
				<td class="stats_p">'.$last_name.'</td>
				<td class="stats_p">'.$new_name.'</td>
				<td class="stats_g" align="center">
					<a href="index.php?mode=admin_svc&type=set_change_name&app=accept&m='.$m.'&id='.$ch.'">موافق</a>&nbsp;-
					<a href="index.php?mode=admin_svc&type=set_change_name&app=refuse&m='.$m.'&id='.$ch.'">غير موافق</a>
				</td>
			</tr>';
		++$i;
		}
		echo'
		</table>
		</center>';
}

function admin_change_name_set(){
	global $id, $m, $app, $lang, $referer;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}CHANGENAME_PENDING WHERE CHNAME_ID = '$id' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($sql) > 0){
		$rs = mysql_fetch_array($sql);
		$new_name = $rs['NEW_NAME'];
	}
	if($app == "accept"){
		$sql = "UPDATE {$mysql->prefix}CHANGENAME_PENDING SET ";
		$sql .= "CH_DONE = '1', ";
		$sql .= "UNDERDEMANDE = '0', ";
		$sql .= "CH_DATE = '".time()."' ";
		$sql .= "WHERE CHNAME_ID = '$id' ";
		$mysql->execute($sql, [], __FILE__, __LINE__);
		
		$sql = "UPDATE {$mysql->prefix}MEMBERS SET ";
		$sql .= "M_NAME = '$new_name', ";
		$sql .= "M_CHANGENAME = M_CHANGENAME + 1 ";
		$sql .= "WHERE MEMBER_ID = '$m' ";
		$mysql->execute($sql, [], __FILE__, __LINE__);

		echo'<center>
		<table width="99%" border="1">
			<tr class="normal">
				<td class="list_center" colSpan="10"><font size="5"><br>تم تغيير اسم العضو بنجاح..</font><br><br>
					<meta http-equiv="Refresh" content="1; URL='.$referer.'">
					<a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
				</td>
			</tr>
		</table>
		</center>';
	}
	if($app == "refuse"){
		$mysql->execute("DELETE FROM {$mysql->prefix}CHANGENAME_PENDING WHERE CHNAME_ID = '$id' ", [], __FILE__, __LINE__);
		echo'<center>
		<table width="99%" border="1">
			<tr class="normal">
			<td class="list_center" colSpan="10"><font size="5"><br>تم رفض الطلب و حذفه من قاعدة البيانات</font><br><br>
				<meta http-equiv="Refresh" content="1; URL='.$referer.'">
				<a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
			</td>
			</tr>
		</table>
		</center>';
	}
}

function paging(){
	global $lang, $pg, $max_page, $type;
	if($type == "approve"){
		$num = 2;
	}
	if($type == "hold"){
		$num = 3;
	}

	$users = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}MEMBERS WHERE M_STATUS = '$num' ", [], __FILE__, __LINE__);
	$users = mysql_result($users, 0, "COUNT(*)");
	$all_pg = ceil($users / $max_page);
	if($all_pg == 0){
		$all_pg = 1;
	}
	echo'
	<script language="javascript" type="text/javascript">
		function app_paging(){
			var pg = paging.id.value;
			window.location = "index.php?mode=admin_svc&type='.$type.'&pg="+pg;
		}
	</script>
	<form name="paging">
	<td class="optionsbar_menus">'.$lang['forum']['page'].'&nbsp;:
	<select name="id" size="1" onchange="app_paging()">';
	for($i = 1; $i <= $all_pg; $i++){
		echo'
		<option value="'.$i.'" '.check_select($pg, $i).'>'.$i.'&nbsp;'.$lang['forum']['from'].'&nbsp;'.$all_pg.'</option>';
	}
	echo'
	</select>
	</td>
	</form>';
}

function admin_func(){
	global $lang, $id, $type, $forum_title, $icon_arrowup, $icon_arrowdown;
	
	echo'
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
				return "إلغاء تحديد الكل";
			}
			else {
				for (i = 0; i < checked.length; i++){
					checked[i].checked = false;
				}
				check_flag = "false";
				return "تحديد الكل";
			}
		}
	</script>';
	
	if($type != "set_details" AND $type != "set_lock" AND $type != "set_open" AND $type != "set_approve" AND $type != "set_hold" AND $type != "set_change_name"){
		echo'
		<center>
		<table cellSpacing="0" cellPadding="0" width="99%" border="0">
			<tr>
				<td>
				<table cellSpacing="2" width="100%" border="0">
					<tr>
						<td class="optionsbar_menus" vAlign="center" width="100%"><nobr><font color="red" size="+1"><b>خدمات المدير</b></font></nobr></td>
                        <td class="optionsbar_menus"><a href="index.php?mode=admin_svc&type=forumsorder"><nobr>ترتيب<br>المنتديات</nobr></a></td>
						<td class="optionsbar_menus"><a href="index.php?mode=admin_svc&type=approve"><nobr>عضويات تنتظر<br>الموافقة</nobr></a></td>
						<td class="optionsbar_menus"><a href="index.php?mode=admin_svc&type=hold"><nobr>عضويات<br>مرفوضة</nobr></a></td>
						<td class="optionsbar_menus"><a href="index.php?mode=admin_svc&type=change_name"><nobr>أسماء تنتظر<br>الموافقة</nobr></a></td>
						<td class="optionsbar_menus"><a href="index.php?mode=members&type=lock"><nobr>عضويات<br>مقفولة</nobr></a></td>';
					if($type == "approve" OR $type == "hold"){
						paging();
					}
					if($type == ""){
						refresh_time();
					}
					go_to_forum();
					echo'
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</center>
		<br>';
	}
	if($type == ""){
		admin_body();
	}


    if($type == "forumsorder"){

	if(method == ""){
     echo '<center>
		<table>
			<tr>
				<td class="stats_menu"><a class="stats_menu" href="index.php?mode=admin_svc&type=forumsorder&method=do_order">اضغط هنا لعمل ترتيب جديد للشهر السابق</a></td>
			</tr>
		</table>
        </center><br>';
        echo '<center>
        <table cellspacing="1" cellpadding="2">
        <tr>
					<td bgColor="green" Align="center" colSpan="10"><font color="white">مراكز '.$forum_title.'</font><br><font color="yellow">للشهر السابق</font></td>
				</tr>
                <tr>
					<td class="stats_h" colspan="2">المركز</td>
                    <td class="stats_h">المنتدى</td>
                    <td class="stats_h" colspan="3">النقاط</td>
                </tr>';
    $forum_order = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM_ORDER ORDER BY FO_ORDER", [], __FILE__, __LINE__);
$forum_order_num = mysql_num_rows($forum_order);
$x = 0;
 while ($x < $forum_order_num){
$order = mysql_result($forum_order, $x, "FO_ORDER");
$old_order = mysql_result($forum_order, $x, "FO_OLD_ORDER");
$points = mysql_result($forum_order, $x, "FO_POINTS");
$old_points = mysql_result($forum_order, $x, "FO_OLD_POINTS");
$forum_id = mysql_result($forum_order, $x, "FORUM_ID");
$forum_name = forums("SUBJECT", $forum_id);
$num_order = $order - $old_order;
$num_points = $points - $old_points;
$dif_points =  $num_points/$old_points * 100;
 if($num_order == 0){
$order_word = "  ";
$color_orde = "";
}
if($num_order > 0){
$order_word = "".$num_order."".icons($icon_arrowdown)."";
$color_order = "red";
}
if($num_order < 0){
$num_order = abs($num_order);
$order_word = "".$num_order."".icons($icon_arrowup)."";
$color_order = "green";
}
if($num_points == 0){
$points_word = "   ";
$color_points = "";
}
if($num_points > 0){
$points_word = "".$num_points."".icons($icon_arrowup)."";
$color_points = "green";
}
if($num_points < 0){
$num_points = abs($num_points);
$points_word = "".$num_points."".icons($icon_arrowdown)."";
$color_points = "red";
}
if($dif_points == 0){
$dif_word = "   ";
$color_dif = "";
}
if($dif_points > 0){
$dif_word = "".$dif_points."%".icons($icon_arrowup)."";
$color_dif = "green";
}
if($dif_points < 0){
$dif_points = abs($dif_points);
$dif_word = "".$dif_points."%".icons($icon_arrowdown)."";
$color_dif = "red";
}
echo '<tr>
<font style="FONT-SIZE: 16px; COLOR: #006600; FONT-FAMILY: verdana" color="black" size="-1">
<td class="stats_h"><font color="yellow">'.$order.'</font></td>
<td class="stats_p"><font color="'.$color_order.'">'.$order_word.'</font></td>
<td class="stats_g">'.$forum_name.'</td>
<td class="stats_p"><font color="blue">'.$points.'</font></td>
<td class="stats_p"><font color="'.$color_points.'">'.$points_word.'</font></td>
<td class="stats_p"><font color="'.$color_dif.'">'.$dif_word.'</font></td>
</font>
</tr>';
$x++;
 }
 echo '</table>
        </center>';
    }
    if(method == "do_order"){
    forums_order();
    echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="4"><br>
                           <a href="index.php?mode=admin_svc&type=forumsorder">--- اضغط هنا للرجوع ---</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
	}

    if($type == "m_stat"){
$f = trim(intval($_GET['f']));
$svc = trim($_GET['svc']);
if(empty($svc)) $svc = "t";

echo '<div align="left"><table>
			<tr>
	<td class="stats_menu'.chk_cmd(method, "member", "Sel").'"><a class="stats_menu" href="index.php?mode=admin_svc&type=m_stat&method=member&f='.$f.'&svc='.$svc.'">احصائيات الاعضاء</a></td>
				<td class="stats_menu'.chk_cmd(method, "modo", "Sel").'"><a class="stats_menu" href="index.php?mode=admin_svc&type=m_stat&method=modo&f='.$f.'&svc='.$svc.'">احصائيات المشرفين</a></td>

				<td class="stats_menu'.chk_cmd($svc, "t", "Sel").'"><a class="stats_menu" href="index.php?mode=admin_svc&type=m_stat&method='.method.'&f='.$f.'&svc=t">حسب المواضيع</a></td>
				<td class="stats_menu'.chk_cmd($svc, "p", "Sel").'"><a class="stats_menu" href="index.php?mode=admin_svc&type=m_stat&method='.method.'&f='.$f.'&svc=p">حسب المشاركات</a></td>
			</tr>
		</table></div>';

if(method == "member"){
if($svc == "t"){
$sql =  $mysql->execute("SELECT COUNT(post.TOPIC_ID) AS count, member.M_NAME,member.MEMBER_ID FROM {$mysql->prefix}MEMBERS AS member LEFT JOIN {$mysql->prefix}TOPICS  AS post ON (post.T_AUTHOR = member.MEMBER_ID)  WHERE post.FORUM_ID = '$f' AND member.M_LEVEL = 1 GROUP BY post.T_AUTHOR ORDER BY count DESC LIMIT 10")or die (mysql_error());
}
if($svc == "p"){
$sql =  $mysql->execute("SELECT COUNT(post.REPLY_ID) AS count, member.M_NAME,member.MEMBER_ID FROM {$mysql->prefix}MEMBERS AS member LEFT JOIN {$mysql->prefix}REPLY  AS post ON (post.R_AUTHOR = member.MEMBER_ID)  WHERE post.FORUM_ID = '$f' AND member.M_LEVEL = 1 GROUP BY post.R_AUTHOR ORDER BY count DESC LIMIT 10")or die (mysql_error());
}

echo '<table align="center" class="grid" cellSpacing="1" cellPadding="0" width="30%" border="0">
				<tr><td class="cat" width="10%">&nbsp;</td><td class="cat" width="40%">الاسم</td><td class="cat" width="20%">عدد المشاركات</td></tr>';

if(mysql_num_rows($sql) == 0){
echo '<tr><td class="f1" colspan="3" align="center">لم يتم العثور على اي نتيجة</td></tr>';
}

$i=1;					
while($r = mysql_fetch_array($sql)){
echo '<tr><td class="f2ts">'.$i.'</td><td class="f1"><a href="index.php?mode=profile&id='.$r[MEMBER_ID].'">'.$r[M_NAME].'</a></td><td class="f1">'.$r[count].'</td></tr>';
$i++;
}
echo'</tr></table>';
}
if(method == "modo"){
if($svc == "t"){
$sql =  $mysql->execute("SELECT COUNT(post.TOPIC_ID) AS count, member.M_NAME,member.MEMBER_ID FROM {$mysql->prefix}MEMBERS AS member LEFT JOIN {$mysql->prefix}TOPICS  AS post ON (post.T_AUTHOR = member.MEMBER_ID) LEFT JOIN {$mysql->prefix}MODERATOR  AS modo ON (post.T_AUTHOR = modo.MEMBER_ID)  WHERE post.FORUM_ID = '$f' AND modo.FORUM_ID = '$f' AND member.M_LEVEL = 2  GROUP BY post.T_AUTHOR ORDER BY count DESC LIMIT 10")or die (mysql_error());
}
if($svc == "p"){
$sql =  $mysql->execute("SELECT COUNT(post.REPLY_ID) AS count, member.M_NAME,member.MEMBER_ID FROM {$mysql->prefix}MEMBERS AS member LEFT JOIN {$mysql->prefix}REPLY  AS post ON (post.R_AUTHOR = member.MEMBER_ID) LEFT JOIN {$mysql->prefix}MODERATOR  AS modo ON (post.R_AUTHOR = modo.MEMBER_ID)  WHERE post.FORUM_ID = '$f' AND modo.FORUM_ID = '$f' AND member.M_LEVEL = 2  GROUP BY post.R_AUTHOR ORDER BY count DESC LIMIT 10")or die (mysql_error());
}
echo '<table align="center" class="grid" cellSpacing="1" cellPadding="0" width="30%" border="0">
				<tr><td class="cat" width="10%">&nbsp;</td><td class="cat" width="40%">الاسم</td><td class="cat" width="20%">عدد المشاركات</td></tr>';

if(mysql_num_rows($sql) == 0){
echo '<tr><td class="f1" colspan="3" align="center">لم يتم العثور على اي نتيجة</td></tr>';
}

$i=1;					
while($r = mysql_fetch_array($sql)){
echo '<tr><td class="f2ts">'.$i.'</td><td class="f1"><a href="index.php?mode=profile&id='.$r[MEMBER_ID].'">'.$r[M_NAME].'</a></td><td class="f1">'.$r[count].'</td></tr>';
$i++;
}
echo'</tr></table>';
}

}


	if($type == "approve"){
		admin_approve();
	}
	if($type == "set_approve"){
		admin_approve_set();
	}
	if($type == "hold"){
		admin_hold();
	}
	if($type == "set_hold"){
		admin_hold_set();
	}
	if($type == "change_name"){
		admin_change_name();
	}
	if($type == "set_change_name"){
		admin_change_name_set();
	}
}


if($Mlevel == 4){
	admin_func();
}
else{
	go_to("index.php");
}
?>