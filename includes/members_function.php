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

require_once("./include/func.df.php");

function order_option(){
	global $order_option;
	echo'
	<form method="post" action="'.$_SERVER[REQUEST_URI].'">
	<td class="optionsbar_menus">خيار ترتيب العرض:<br>';
	echo'	<select name="order_option" onchange="submit();">';
	echo'	<option value="online" '.check_select($order_option, "online").'>في المنتديات الآن</option>';
	echo'	<option value="points" '.check_select($order_option, "points").'>لائحة الشرف</option>';
	echo'	<option value="posts" '.check_select($order_option, "posts").'>عدد المشاركات</option>';
	echo'	<option value="name" '.check_select($order_option, "name").'>الإسم</option>';
	echo'	<option value="country" '.check_select($order_option, "country").'>الدولة</option>';
	echo'	<option value="lastpost" '.check_select($order_option, "lastpost").'>آخر مشاركة</option>';
	echo'	<option value="lastvisit" '.check_select($order_option, "lastvisit").'>آخر زيارة</option>';
	echo'	<option value="register" '.check_select($order_option, "register").'>تاريخ التسجيل</option>';
	echo'	<option value="mods" '.check_select($order_option, "mods").'>المشرفين فقط</option>';
	if(mlv == 4){
	echo'	<option value="mons" '.check_select($order_option, "mons").'>المراقبين فقط</option>';
	echo'	<option value="admin" '.check_select($order_option, "admin").'>الإداريين فقط</option>';
}
	echo'	</select>
	</td>
	</form>';
}

function members_order(){
	global $desc_asc;
			echo'
			<form method="post" action="'.$_SERVER[REQUEST_URI].'">
			<td class="optionsbar_menus"><nobr>الترتيب:</nobr><br>
				<select name="desc_asc" onchange="submit();">
					<option value="DESC" '.check_select($desc_asc, "DESC").'>الأكبر للأصغر</option>
					<option value="ASC" '.check_select($desc_asc, "ASC").'>الأصغر للأكبر</option>
				</select>
			</td>
			</form>';
}

function mods_online($mlv){
	global $Prefix;

	if($mlv == 1){
	$non_online = "لا يوجد أي عضو حاليا في المنتديات";
	}
	else if($mlv == 2){
	$non_online = "لا يوجد أي مشرف حاليا في المنتديات";
	}
	else if($mlv == 3){
	$non_online = "لا يوجد أي مراقب حاليا في المنتديات";
	}
	else if($mlv == 4){
	$non_online = "لا يوجد أي مدير حاليا في المنتديات";
	}

	$rsql = $mysql->execute("SELECT * FROM {$mysql->prefix}ONLINE AS O INNER JOIN {$mysql->prefix}MEMBERS AS M ON (O.O_MEMBER_ID = M.MEMBER_ID)  WHERE O.O_MEMBER_LEVEL = '$mlv' AND M.M_STATUS = '1' AND M.M_BROWSE = '1' AND M.M_LEVEL = '$mlv'   ", [], __FILE__, __LINE__);
	$online = mysql_num_rows($rsql);

if($online <= 0){
echo'
		<tr>
			<td align="center" width="100%" colspan="5"><font size="2">'.$non_online.'</font></td>
		</tr>';
	}

$i_O = 0;
	while ($row = mysql_fetch_array($rsql)){
    $Member_ID = mysql_result($rsql, $i_O, "M.MEMBER_ID");


if($ii == 5){ 
               echo "<tr></tr>"; 
               $ii = 0; 
           } 

echo'<td align="center" width="13%"><font size="2">'.link_profile(member_name($Member_ID), $Member_ID).'</font></td>';
$i_O++;
  $ii++; 
}
}

function mods_list(){
	global $Prefix, $connection, $open_sql, $p_i;

	$query = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE M_STATUS = '1' AND M_POINTS > 0 ";
	$query .= "ORDER BY M_POINTS DESC LIMIT 30 ";
	$result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);
	$num = mysql_num_rows($result);

	if($num <= 0){
			echo'<tr>
				<td align="center" width="13%"><font size="2">'.$non_online.'</font></td>
			</tr>';
	}
	else {
		$i = 0;
		while($i < $num){
			$memberID = mysql_result($result, $i, "MEMBER_ID");
			$memberPoints = mysql_result($result, $i, "M_POINTS");
		$n = $i+1;
		if($n <= 5){
		    $class = "normal";
		}
		else if($n <= 10){
		    $class = "deleted";
		}
		else if($n > 10){
		    $class = "lastposter";
		}
			echo'<tr class="'.$class.'">
				<td><font color="midnightblue" size="2">'.$n.'</font></td>
				<td><font size="2">'.link_profile(member_name($memberID), $memberID).'</font></td>
				<td><font color="midnightblue" size="2">'.$memberPoints.'</font></td>
								<td><font color="midnightblue" size="2">'.$memberPoints.'</font></td>

			</tr>';
		++$i;
		}
	}
}

function member_func(){
	global $Prefix, $connection, $type, $lang, $where, $open_sql, $start, $max_page, $no_member, $Mlevel, 
	$icon_private_message, $icon_lock, $icon_unlock, $icon_edit, $icon_trash, $counr, $count , $icon_online;
echo'
	<table class="grid" cellSpacing="1" cellPadding="2" width="99%" border="0">
		<tr>
			<td class="cat">&nbsp;</td>
			<td class="cat">'.$lang['members']['numbers'].'</td>
			<td class="cat">'.$lang['members']['online'].'</td>
			<td class="cat">'.$lang['members']['members'].'</td>
			<td class="cat">'.$lang['members']['points'].'</td>
			<td class="cat">'.$lang['members']['country'].'</td>
			<td class="cat">'.$lang['members']['posts'].'</td>
			<td class="cat">'.$lang['members']['last_post'].'</td>
			<td class="cat">'.$lang['members']['last_visit'].'</td>
			<td class="cat">'.$lang['members']['rejister_date'].'</td>';
		if($Mlevel == 4){
			echo'
			<td class="cat">'.$lang['members']['email'].'</td>
			<td class="cat">'.$lang['members']['ip'].'</td>
			<td class="cat">'.$lang['members']['options'].'</td>';
		}
		echo'
		</tr>';

	$query = "SELECT * FROM {$mysql->prefix}MEMBERS ".$open_sql." ";
	$query .= "LIMIT $start, $max_page";
	$sql = $mysql->execute($query, $connection, [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
	$i = 0;
	while ($i < $num){
		$MMember_ID = mysql_result($sql, $i, "MEMBER_ID");
		$MMemberStatus = mysql_result($sql, $i, "M_STATUS");
		$MMemberName = mysql_result($sql, $i, "M_NAME");
		$MMemberCountry = mysql_result($sql, $i, "M_COUNTRY");
		$MMemberPosts = mysql_result($sql, $i, "M_POSTS");
		$MMemberLastPostDate = mysql_result($sql, $i, "M_LAST_POST_DATE");
		$MMemberLastHereDate = mysql_result($sql, $i, "M_LAST_HERE_DATE");
		$MMemberDate = mysql_result($sql, $i, "M_DATE");
		$MMemberBrowse = mysql_result($sql, $i, "M_BROWSE");
		$MMemberPoints = mysql_result($sql, $i, "M_Points");
		$MMemberEmail = mysql_result($sql, $i, "M_Email");
		$MMemberLastIP = mysql_result($sql, $i, "M_Last_IP");
		$MMemberBrowse = mysql_result($sql, $i, "M_BROWSE");
		$member_is_online = member_is_online($MMember_ID);

		if($i % 2){
			$bg_color="lastposter";
		}
		else{
			$bg_color="normal";
		}
		
			echo'
			<tr class="'.$bg_color.'">
			<td class="list_small" vAlign="center"><a href="index.php?mode=editor&method=sendmsg&m='.$MMember_ID.'">'.icons($icon_private_message, $lang['topics']['send_message_to_this_member'], "hspace=\"2\"").'</a></td>
			<td class="list_date" vAlign="center">'.$MMember_ID.'</td>
';
if($member_is_online == 0  ){
echo'
<td class="list_date" vAlign="center"></td>';
		}
if($member_is_online == 1 AND  $MMemberBrowse == 1  OR $member_is_online == 1  AND   $MMemberBrowse == 0   AND $Mlevel > 1 ){
echo'
<td class="list_date" vAlign="center"><img src="'.$icon_online.'" hspace="0" border="0" alt="'.$lang['members']['online_y'].'"></td>';
		}
if($member_is_online == 1 AND  $MMemberBrowse == 0   AND $Mlevel < 2){
echo'
<td class="list_date" vAlign="center"></td>';
		}
		echo'

			<td class="list_names"><nobr><a href="index.php?mode=profile&id='.$MMember_ID.'">'.$MMemberName.'</a></nobr><br>'.member_title($MMember_ID).'</td>
			<td class="list_small">';
			if($MMemberPoints > 1 ){ echo'
			
			
			'.$MMemberPoints.' ';} echo'</td>
			<td class="list_small">'.$MMemberCountry.'</td>
			<td class="list_small">'.$MMemberPosts.'<br>'.member_stars($MMember_ID).'</td>
			<td class="list_date">'.members_time($MMemberLastPostDate).'</td>
			<td class="list_small">';
		if($Mlevel > 1){
			echo members_time($MMemberLastHereDate);
		}
		else{
			if($MMemberBrowse == 1){
				echo members_time($MMemberLastHereDate);
			}
			else{
				echo '-';
			}
		}
			echo'
			</td>
			<td class="list_date">'.members_time($MMemberDate).'</td>';

		if($Mlevel == 4){
			echo'
			<td class="list_date">'.$MMemberEmail.'</td>';
			echo'
			<td class="list_date">'.$MMemberLastIP.'</td>';
			echo'
			<td class="list_date">';
			if($MMemberStatus == 1 && $MMember_ID != 1 && $MMember_ID != $DBMemberID){
				echo'
				<a href="index.php?mode=lock&type=m&m='.$MMember_ID.'"  onclick="return confirm(\''.$lang['members']['you_are_sure_to_lock_this_member'].'\');">'.icons($icon_lock, $lang['members']['lock_member'], "hspace=\"2\"").'</a>';
			}
			if($MMemberStatus == 0 && $MMember_ID != 1 && $MMember_ID != $DBMemberID){
				echo'
				<a href="index.php?mode=open&type=m&m='.$MMember_ID.'"  onclick="return confirm(\''.$lang['members']['you_are_sure_to_open_this_member'].'\');">'.icons($icon_unlock, $lang['members']['open_member'], "hspace=\"2\"").'</a>';
			}
			$edit_member = '<a href="index.php?mode=profile&type=edit_user&id='.$MMember_ID.'">'.icons($icon_edit, $lang['members']['edit_member'], "hspace=\"2\"").'</a>';
			if($MMember_ID == 1){
				if($DBMemberID == 1){
					echo $edit_member;
				}
			}
			else {
				echo $edit_member;
			}
			if($MMember_ID != 1 && $MMember_ID != $DBMemberID){
				echo'
				<a href="index.php?mode=delete&type=m&m='.$MMember_ID.'"  onclick="return confirm(\''.$lang['members']['you_are_sure_to_delete_this_member'].'\');">'.icons($icon_trash, $lang['members']['delete_member'], "hspace=\"2\"").'</a>';
			}
			echo'
			</td>';
		}
		echo'
		</tr>';
		$count = $counr + 1;
	++$i;
	}
	if($count == 0){
		if($type == "lock"){
			if($Mlevel > 1){
				$non_text = "لا توجد أي عضوية مقفولة في المنتدى";
			}
			else{
				$non_text = "لا يمكنك مشاهدة عضويات المقفولة";
			}
		}
		else{
			$non_text = "لا يوجد أي عضو بهذه المواصفات";
		}
		echo'
		<tr class="normal">
			<td class="list_center" vAlign="center" colspan="10"><br>'.$non_text.'<br><br></td>
		</tr>';
	}
echo'
</table>
</center>';
}

?>
