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

$Approval = trim($_GET[Approval]);

if($register_waitting == 2){
		echo'<br><center>
		<table width="99%" border="1">
			<tr class="normal">
				<td class="list_center" colSpan="10"><font size="5" color="red"><br>ميزة تسجيل أعضاء جدد متوقفة حاليا</font><br><br>
				<a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
				</td>
			</tr>
		</table>
		</center><xml>';
}
else{


if($r == "" AND $Approval == 1){
	echo'
	<script language="javascript" src="./javascript/register.js"></script>
	<center>
	<table cellSpacing="0" cellPadding="0" width="99%" border="0" id="table1">
		<tr>
			<td>
			<center><font color="red" size="+2">'.$lang['register']['register_new_member'].'</font><br>&nbsp;
			<form name="userinfo" method="post" action="index.php?mode=register&r=insert">
			<input type="hidden" value="'.$http_host.'" name="host">
			<input type="hidden" value="1" name="forum_title">
			<input type="hidden" value="1" name="site_address">
			<table cellSpacing="1" cellPadding="4" bgColor="gray" border="0" id="table2">
				<tr class="fixed">
					<td class="optionheader_selected" id="row_user_name"><nobr>'.$lang['register']['user_name'].' </nobr></td>
					<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 300px" name="user_name"></td>
				</tr>
				<tr class="fixed">
					<td><font color="red" size="-1">'.$lang['register']['rules_write_user_name_one'].'<br>&nbsp;</font></td>
					<td><font color="red" size="-1">'.$lang['register']['rules_write_user_name_tow'].'<br>&nbsp;</font></td>
				</tr>
				<tr class="fixed">
					<td class="optionheader_selected" id="row_user_password1"><nobr>'.$lang['register']['the_password'].' </nobr></td>
					<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 300px" type="password" name="user_password1"></td>
				</tr>
				<tr class="fixed">
					<td class="optionheader_selected" id="row_user_password2"><nobr>'.$lang['register']['the_confirm_password'].' </nobr></td>
					<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 300px" type="password" name="user_password2"></td>
				</tr>
				<tr class="fixed">
					<td><font color="red" size="-1">'.$lang['register']['rules_write_password_one'].'<br>&nbsp;</font></td>
					<td><font color="red" size="-1">'.$lang['register']['rules_write_password_tow'].'<br>&nbsp;</font></td>
				</tr>
				<tr class="fixed">
					<td class="optionheader_selected" id="row_user_email"><nobr>'.$lang['register']['the_email'].' </nobr></td>
					<td class="list" colSpan="3"><input class="insidetitle" dir="ltr" style="WIDTH: 300px" name="user_email"></td>
				</tr>
				<tr class="fixed">
					<td><font color="red" size="-1">'.$lang['register']['rules_write_email_one'].'<br>&nbsp;</font></td>
					<td><font color="red" size="-1">'.$lang['register']['rules_write_email_tow'].'<br>&nbsp;</font></td>
				</tr>
					<tr class="fixed">
					<td class="optionheader" id="row_user_city"><nobr>'.$lang['register']['the_city'].'</nobr></td>
					<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 150px" name="user_city"></td>
				</tr>
					<tr class="fixed">
					<td class="optionheader" id="row_user_state"><nobr>'.$lang['register']['the_state'].'</nobr></td>
					<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 150px" name="user_state"></td>
				</tr>
				<tr class="fixed">
					<td class="optionheader" id="row_user_country"><nobr>'.$lang['register']['the_country'].'</nobr></td>
					<td class="list" colSpan="3">
					<select class="insidetitle" style="WIDTH: 200px" name="user_country" type="text">';
					include("country.php");
					echo'
					</select>
					</td>
				</tr>
				<tr class="fixed">
					<td class="optionheader" id="row_user_occupation"><nobr>'.$lang['register']['the_occupation'].' </nobr></td>
					<td class="list" colSpan="3">
					<input class="insidetitle" style="WIDTH: 150px" name="user_occupation"></td>
					
				</tr>
				<tr class="fixed">
					<td class="optionheader" id="row_user_age"><nobr>'.$lang['register']['the_age'].'</nobr></td>
					<td class="list" colSpan="3">
					<select class="insidetitle" style="WIDTH: 50px" name="user_age" type="text">';
					include("age.php");
					echo'
					</select>
					</td>
				</tr>
				<tr class="fixed">
					<td class="optionheader" id="row_user_sex"><nobr>'.$lang['register']['the_sex'].'</nobr></td>
					<td class="list" colSpan="3">&nbsp;&nbsp;&nbsp;<input class="small" type="radio" value="1" name="user_sex">'.$lang['register']['male'].'&nbsp;&nbsp;&nbsp;<input class="small" type="radio" value="2" name="user_sex">'.$lang['register']['famale'].'</td>
				</tr>
				<tr class="fixed">
					<td class="list_center" colSpan="5"><input onclick="submitForm()" type="button" value="'.$lang['register']['send_data'].'"></td>
				</tr>
			</table>
			</form>
			</center>
			</td>
		</tr>
	</table>
	</center>';
} 
if($r == "" AND $Approval == ""){
redirect();
}
if($r == "insert"){
	$user_name = $_POST['user_name'];
	$user_email = $_POST['user_email'];
	$user_pass = md5($_POST['user_password1']);
	$user_city = $_POST['user_city'];
	$user_state = $_POST['user_state'];
	$user_country = $_POST['user_country'];
	$user_occupation = $_POST['user_occupation'];
	$user_age = $_POST['user_age'];
	$user_sex = $_POST['user_sex'];
	$ip = $_SERVER['REMOTE_ADDR'];
	$host = $_POST['host'];

	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE M_NAME = '$user_name' ", [], __FILE__, __LINE__);

	if(mysql_num_rows($sql) > 0){
		$rs = mysql_fetch_array($sql);
		$m_name = $rs['M_NAME'];
	}



	$sql2 = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE M_EMAIL = '$user_email' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($sql2) > 0){
		$rs = mysql_fetch_array($sql2);
		$m_email = $rs['M_EMAIL'];
	}

	$sql3 = $mysql->execute("SELECT * FROM {$mysql->prefix}NAMEFILTER WHERE N_NAME = '$user_name' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($sql3) > 0){
		$rs = mysql_fetch_array($sql3);
		$m_name_filter = $rs['N_NAME'];
	}
	
	if($user_name == "$m_name"){
		$error = $lang['register']['this_name_was_used'];
	}
	if($m_email == $user_email){
		$error = $lang['register']['this_email_was_used'];
	}
	if($user_name == $m_name_filter){
		$error = $lang['register']['this_name_was_bad'];
	}
	if($http_host != $host){
		$error = $lang['register']['not_allowed_to_use_this_away'];
	}
	if($error != ""){
		echo'<br><center>
		<table width="99%" border="1">
			<tr class="normal">
				<td class="list_center" colSpan="10"><font size="5" color="red"><br>'.$lang['all']['error'].'<br>'.$error.'..</font><br><br>
				<a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
				</td>
			</tr>
		</table>
		</center><xml>';
	}
	if($error == ""){
		$sql = "INSERT INTO {$mysql->prefix}MEMBERS (MEMBER_ID, M_STATUS, M_NAME, M_PASSWORD, M_EMAIL, M_CITY, M_STATE, M_IP, M_COUNTRY, M_OCCUPATION, M_AGE, M_SEX, M_DATE, M_LAST_POST_DATE, M_LAST_HERE_DATE) VALUES (NULL, ";
		if($register_waitting == 1){
			$sql .= "'2', ";
		}
		if($register_waitting == 0){
			$sql .= "'1', ";
		}
		$sql .= "'$user_name', ";
		$sql .= "'$user_pass', ";
		$sql .= "'$user_email', ";
		$sql .= "'$user_city', ";
		$sql .= "'$user_state', ";
		$sql .= "'$ip', ";
		$sql .= "'$user_country', ";
		$sql .= "'$user_occupation', ";
		$sql .= "'$user_age', ";
		$sql .= "'$user_sex', ";
		$sql .= "'".time()."', ";
		$sql .= "'".time()."', ";
		$sql .= "'".time()."')";
		$mysql->execute($sql, [], __FILE__, __LINE__);
		if($register_waitting == 1){
			$msg_text = "تم تسجيل عضويتك لكن بحاجة الى موافقة الإدارة";
		}
		if($register_waitting == 0){
			$msg_text = $lang['register']['the_member_was_registered'];
		}
		echo'<center>
		<table width="99%" border="1">
			<tr class="normal">
				<td class="list_center" colSpan="10"><font size="5"><br>'.$msg_text.'</font><br><br>
				<meta http-equiv="Refresh" content="1; URL=index.php">
				<a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
				</td>
			</tr>
		</table>
		</center>';
	}
}

}
?>

