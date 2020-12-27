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

require_once("./include/members_func.df.php");
if(members("MEMBERS", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][members].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}
//############################################## PAGING ##############################################
if(empty($pg)){
	$pag = 1;
}
else{
	$pag = $pg;
}
if($Mlevel == 4){
$no_mlv4 = "";
}else{
$no_mlv4 = "AND M_LEVEL != 4";
}

if($Mlevel > 2){
$no_mlv3 = "";
}else{
$no_mlv3 = "AND M_LEVEL != 3";
}

if($type == "lock"){
	if($Mlevel > 1){
		$open_sql = "WHERE M_STATUS = '0'";
	}
	else{
		$open_sql = "WHERE M_STATUS = '1' AND M_LEVEL != 4";
	}
}
else{
	$open_sql = "WHERE M_STATUS = '1' AND M_LEVEL != 4";
}
$start = (($pag * $max_page) - $max_page);
$pg_sql = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}MEMBERS ".$open_sql." ", [], __FILE__, __LINE__);
$total_res = mysql_result($pg_sql, 0, "COUNT(*)");
$total_col = ceil($total_res / $max_page);

?>
<script language="JavaScript" type="text/javascript">
	function paging(obj){
		var pg = obj.options[obj.selectedIndex].value;
		window.location = "index.php?mode=members&pg="+pg;
	}
</script>
<?php

function paging($total_col, $pag){
	global $lang;
	echo '
	<form name="members">
	<td class="optionsbar_menus"><b>'.$lang['members']['page'].' :</b><br>
	<select name="pg" size="1" onchange="paging(this);">';
	for($i = 1; $i <= $total_col; $i++){
		if(($pag) == $i){
			echo'
			<option selected value="'.$i.'">'.$i.' '.$lang['members']['from'].' '.$total_col.'</option>';
		}
		else {
			echo'
			<option value="'.$i.'">'.$i.' '.$lang['members']['from'].' '.$total_col.'</option>';
		}
	}
	echo '
	</select>
	</td>
	</form>';
}
//############################################## PAGING ##############################################

if($order_option == "online"){
          $text = "الأعضاء في المنتديات حاليا";
}
else if($order_option == "points"){
          $text = "لائحة الشرف<br><font color='black' size='1'>ترتيب الأعضاء حسب نقاط التميز</font>";
}
else if($order_option == "mods"){
          $text = "قائمة المشرفين";
}
else if($order_option == "mons"){
          $text = "قائمة المراقبين";
}
else if($order_option == "admin"){
          $text = "قائمة الإداريين";
}
else if($type == "lock"){
          $text = "العضويات المقفولة";
}

else {
          $text = "قائمة الأعضاء";
}

echo'
<center>
<table cellSpacing="2" cellPadding="1" width="99%" border="0">
	<tr>
		<td class="optionsbar_menus" width="38%"><font color="red" size="+1">'.$text.'</font></td>
		<form method="post" action="index.php?mode=members&type=true">
		<td class="optionsbar_menus">إبحث عن عضو:<br>
			<input style="width: 100px" name="search_member">
			&nbsp;<input class="submit" type="submit" value="إبحث">
		</td>
		</form>';

		order_option();
		members_order();
  
paging($total_col, $pag);
go_to_forum();
echo'
	</tr>
</table>';


if($type == "true"){
$search_member = trim(HtmlSpecialchars($_POST[search_member]));
	$open_sql = "WHERE M_NAME LIKE '%$search_member%' AND M_STATUS = '1'  $no_mlv3 $no_mlv4 ";
	$no_member = "لا يوجد أي عضو مسجل بهذا الاسم";
	member_func();
}
elseif($type == "lock"){
	if($Mlevel > 1){
		$open_sql = "WHERE M_STATUS = '0'";
	}
	else{
		$open_sql = "WHERE M_STATUS = '1'";
	}
	$no_member = "لا يوجد أي عضويات مقفولة";
	member_func();
}
elseif($order_option == "" OR $order_option == "online"){

	echo'
	<center><br>
	<table cellSpacing="1" cellPadding="2" border="1" width="65%">';
	if(mlv == 4){
		echo'
		<tr>
			<td class="cat" colspan="5">مدراء</td>
		</tr>
		<tr>';
		mods_online(4);
		echo'
		</tr>

		<tr>
			<td class="cat" colspan="5">مراقبون</td>
		</tr>
		<tr>';
		mods_online(3);
		echo'
		</tr>';
	}
		echo'
		<tr>
			<td class="cat" colspan="5">مشرفون</td>
		</tr>
		<tr>';
		mods_online(2);
		echo'
		</tr>

		<tr>
			<td class="cat" colspan="5">أعضاء</td>
		</tr>
		<tr>';
		mods_online(1);
		echo'
		</tr>
	</table>
	</center>';
	

}

// Dont Show Director Group To Members


elseif($order_option == "points"){

echo'
<table cellSpacing="1" cellPadding="2">
	<tr>
		<td align="center"><img onerror="this.src=\''.$icon_blank.'\';" src="'.$winner_ribbon.'" border="0"></td>
	</tr>
</table>
<table cellSpacing="1" cellPadding="2" border="1" width="410">';
	mods_list();
echo'
</table>';

}

elseif($order_option == "posts"){

	$open_sql = "WHERE M_STATUS = '1'  $no_mlv4  $no_mlv3 ORDER BY M_POSTS ".$desc_asc." ";
	member_func();

}

elseif($order_option == "name"){

	$open_sql = "WHERE M_STATUS = '1' $no_mlv4  $no_mlv3 ORDER BY M_NAME ".$desc_asc." ";
	member_func();

}

elseif($order_option == "country"){

	$open_sql = "WHERE M_STATUS = '1' $no_mlv4  $no_mlv3 ORDER BY M_COUNTRY ".$desc_asc." ";
	member_func();

}

elseif($order_option == "lastpost"){

	$open_sql = "WHERE M_STATUS = '1' $no_mlv4 $no_mlv3  ORDER BY M_LAST_POST_DATE ".$desc_asc." ";
	member_func();

}

elseif($order_option == "lastvisit"){

	$open_sql = "WHERE M_STATUS = '1' $no_mlv4  $no_mlv3 ORDER BY M_LAST_HERE_DATE ".$desc_asc." ";
	member_func();

}

elseif($order_option == "register"){

	$open_sql = "WHERE M_STATUS = '1' $no_mlv4  $no_mlv3 ORDER BY M_DATE ".$desc_asc." ";
	member_func();

}

elseif($order_option == "mods"){
	$open_sql = "WHERE M_STATUS = '1' $no_mlv4  $no_mlv3 AND M_LEVEL = '2' ORDER BY M_NAME ".$desc_asc." ";
	member_func();

}

echo'
</table>
</center>';

?>
