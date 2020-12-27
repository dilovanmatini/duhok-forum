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

if($DBMemberID > 0){
if(members("CHANGE_NAME", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][change_name].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}

if($mlv == 1 AND $DBMemberPosts < $new_member_change_name){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
	                       
'.$lang[sorry][noo].'
'.$lang[sorry][change].'
'.$lang[sorry][will].'
	                       </font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}
if($type == ""){

$queryM = "SELECT * FROM {$mysql->prefix}MEMBERS ";
$queryM .= "WHERE MEMBER_ID = '$DBMemberID' ";
$resultM = $mysql->execute($queryM, $connection, [], __FILE__, __LINE__);

if(mysql_num_rows($resultM) > 0){
$rsM = mysql_fetch_array($resultM);

$ChCount = $rsM['M_CHANGENAME'];
}

$queryCH = "SELECT * FROM {$mysql->prefix}CHANGENAME_PENDING ";
$queryCH .= "WHERE MEMBERID = '$DBMemberID' AND UNDERDEMANDE = '1' ";
$resultCH = $mysql->execute($queryCH, $connection, [], __FILE__, __LINE__);

if(mysql_num_rows($resultCH) > 0){
$rsCH = mysql_fetch_array($resultCH);

$ChName_ID = $rsCH['CHNAME_ID'];
$ChNewName = $rsCH['NEW_NAME'];
}

$max = "SELECT MAX(CH_DATE) FROM {$mysql->prefix}CHANGENAME_PENDING WHERE MEMBERID = '$DBMemberID' ";
$rmax = $mysql->execute($max, $connection, [], __FILE__, __LINE__);
$ChDate = mysql_result($rmax, "CH_DATE");

if($ChCount == $change_name_max){
echo'
<center>
		<table cellSpacing="0" cellPadding="0" width="99%" border="0">
			<tr>
				<td align="center"><font color="red" size="+1">لا يمكنك تغيير إسم عضويتك أكثر من '.$change_name_max.' مرات.<br><br></font></td>
			</tr>
		</table>
</center>';
}

elseif($ChNewName != ""){

echo '		
<center>
<table cellpadding="1" border="0">
	<tr>
		<td><font color=red size=+2>طلب تغيير إسم العضوية</font><br><br></td>
	</tr>
<table cellpadding="10" border="1">
		<form action="index.php?mode=changename&type=false" method="post">
		<input type="hidden" name="changename_id" value="'.$ChName_ID.'">
		<tr class="fixed">
		<td align="center"><br><font color="black" size="3">
		هناك حاليا طلب تغيير لك ينتظر موافقة الإدارة للإسم التالي:
		</font><br><br>
		<font color="red">'.$ChNewName.'</font><br><br>
		<input type="submit" value="-- لإلغاء هذا الطلب إضغط هنا --">
		<br><br>
		</td>
	</tr>
</table>
</form>';

}

elseif(member_total_days($ChDate) <= $changename_dayslimit){
echo'
<center>
		<table cellSpacing="0" cellPadding="0" width="99%" border="0">
			<tr>
				<td align="center"><font color="red" size="+1">لا يمكنك تغيير إسم عضويتك أكثر من مرة في فترة  '.$changename_dayslimit.' يوم.<br><br></font>الرجاء منك المحاولة لاحقا.<br></td>
			</tr>
		</table>
</center>';
}

else {

echo'
<script language="javascript" src="./javascript/change_name.js"></script>
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0" id="table1">
	<tr>
		<td><center><font color="red" size="+2">'.$lang['changename']['demande_change_username'].'</font><br>
			<form name="userinfo" method="post" action="index.php?mode=changename&type=true">
	<table cellSpacing="1" cellPadding="4" bgColor="gray" border="0" id="table2">
				<tr class="fixed">
					<td class="optionheader_selected" id="row_user_name"><nobr>'.$lang['changename']['new_username'].'</nobr></td>
					<td class="list" colSpan="3"><input class="insidetitle" style="WIDTH: 300px" name="user_name" value="'.$DBUserName.'">'.$info.'</td>
				</tr>
				<tr class="fixed">
					<td><font color="red" size="-1">'.$lang['register']['rules_write_user_name_one'].'<br>&nbsp;</font></td>
					<td><font color="red" size="-1">'.$lang['register']['rules_write_user_name_tow'].'<br>&nbsp;</font></td>
				</tr>
				<tr class="fixed">
					<td class="list_center" colSpan="5"><input onclick="submitForm()" type="button" value="'.$lang['changename']['send_demande'].'"></td>
				</tr>
			</form>
	</table>
		</td>
	</tr>
	<tr>
		<td align="center"><br>
		'.$lang['changename']['count'].'
		<font color="red">'.$ChCount.'</font><br>
		'.$lang['changename']['change_username_max'].'</font>
		<font color="red">'.$change_name_max.'</font>';
	if($ChCount + 1 >= $change_name_max){
		echo' <br><br>** <b><font color="red"> ملاحظة هامة: هذا هو التغيير الأخير الذي سيمكنك طلبه </font> **';
	}
	echo'	</td>
	</tr>
</table>
</center>';

}
}

if($type == "true"){

$user_name = HtmlSpecialchars($_POST["user_name"]);
$CH_Date = time();

 $query2 = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE M_NAME = '" . $user_name . "' ";
 $result2 = $mysql->execute($query2, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($result2) > 0){
 $rs2=mysql_fetch_array($result2);

 $UserName = $rs2['M_NAME'];
 }

if($user_name == $DBUserName){
$text = '<font color="red" size="+1">يجب أن تدخل إسم جديد.</font>';
}
elseif($user_name == $UserName){
$text = '<font color="red" size="+1">الاسم المختار مسجل لعضو آخر.</font>';
}
else {

$query1 = "INSERT INTO {$mysql->prefix}CHANGENAME_PENDING (CHNAME_ID, MEMBERID, NEW_NAME, LAST_NAME, UNDERDEMANDE, CH_DATE) VALUES (NULL, '$DBMemberID', '$user_name', '$DBUserName', '1', '$CH_Date')";
$mysql->execute($query1, $connection, [], __FILE__, __LINE__);

$text = '<font color="red" size="+1">تم تسجيل طلب تغيير الاسم بنجاح.<br><br></font>سيتم مراجعة الطلب من قبل الإدارة في خلال 7 أيام.<br>';
}

	echo '	<center>
		<table cellSpacing="0" cellPadding="0" width="99%" border="0">
			<tr>
				<td align="center">
				'.$text.'</td>
			</tr>
		</table>
		</center>';

}

if($type == "false"){

$ChName_ID = $_POST["changename_id"];

     	$query3 = "UPDATE {$mysql->prefix}CHANGENAME_PENDING SET UNDERDEMANDE = ('0') ";
     	$query3 .= "WHERE CHNAME_ID = '$ChName_ID' AND MEMBERID = '$DBMemberID' ";

     	$mysql->execute($query3, $connection, [], __FILE__, __LINE__);

	$query4 = "DELETE FROM {$mysql->prefix}CHANGENAME_PENDING WHERE CHNAME_ID = '$ChName_ID' ";
	$mysql->execute($query4, $connection, [], __FILE__, __LINE__);

	echo '	<center>
		<table cellSpacing="0" cellPadding="0" width="99%" border="0">
			<tr>
				<td align="center"><font color="red" size="+1">تم الغاء طلب تغيير اسم عضويتك.</td>
			</tr>
		</table>
		</center>';

}

}

mysql_close();

?>