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

$ip2long = ip2long($_SERVER['REMOTE_ADDR']);
$date = time();
$out_date = time() - 60*10;
$member_browse = members("BROWSE", $DBMemberID);

if(empty($f)){
	if(empty($t)){
		$f = 0;	
	}
	else{
		$f = topics("FORUM_ID", $t);
	}
}

$if_online = $mysql->execute("SELECT * FROM {$mysql->prefix}ONLINE WHERE O_IP = '$ip2long' ", [], __FILE__, __LINE__);
if(is_array($if_online)){

	$in_online = "INSERT INTO {$mysql->prefix}ONLINE (ONLINE_ID, O_MEMBER_ID, O_FORUM_ID, O_MEMBER_LEVEL, O_MEMBER_BROWSE, O_IP, O_MODE, O_DATE, O_LAST_DATE) VALUES (NULL, ";
	$in_online .= " '$DBMemberID', ";
	$in_online .= " '$f', ";
	$in_online .= " '$Mlevel', ";
	$in_online .= " '$member_browse', ";
	$in_online .= " '$ip2long', ";
	$in_online .= " '$mode', ";
	$in_online .= " '$date', ";
	$in_online .= " '$date') ";
	$mysql->execute($in_online, $connection, [], __FILE__, __LINE__);
}

$up_online = "UPDATE {$mysql->prefix}ONLINE SET ";
$up_online .= "O_MEMBER_ID = '$DBMemberID', ";
$up_online .= "O_FORUM_ID = '$f', ";
$up_online .= "O_MEMBER_LEVEL = '$Mlevel', ";
$up_online .= "O_MEMBER_BROWSE = '$member_browse', ";
$up_online .= "O_MODE = '$mode', ";
$up_online .= "O_LAST_DATE = '$date' ";
$up_online .= "WHERE O_IP = '$ip2long' ";
$mysql->execute($up_online, $connection, [], __FILE__, __LINE__);

$mysql->execute("DELETE FROM {$mysql->prefix}ONLINE WHERE O_LAST_DATE < '$out_date' ", [], __FILE__, __LINE__);

function schat_delete_online(){
	global $mysql;
	$time_check = time() - (60 * 5);
	//$mysql->execute("DELETE FROM {$mysql->prefix}chat_online WHERE time < $time_check");
}
schat_delete_online();
?>
