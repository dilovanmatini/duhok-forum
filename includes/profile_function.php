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

function profile_member_title($m){
	global $Prefix;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TITLES WHERE MEMBER_ID = '$m' AND STATUS = '1' ORDER BY DATE ASC ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
	$x = 0;
	while ($x < $num){
		$t = mysql_result($sql, $x, "TITLE_ID");
		$gt_id = titles("GT_ID", $t);
		$f = gt("FORUM_ID", $gt_id);
		$subject = gt("SUBJECT", $gt_id);
		if($x > 0){
			$titles .= '<br>';
		}
		$titles .= $subject.' - <font color="red">'.forums("SUBJECT", $f).'</font>';
	++$x;
	}
return($titles);
}

function profile_moderator_title($m){
		$show_profile == forums("SHOW_PROFILE", $f);  

	global $Prefix, $lang;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MODERATOR WHERE MEMBER_ID = '$m'ORDER BY MOD_ID ASC ", [], __FILE__, __LINE__);

	$num = mysql_num_rows($sql);
	$x = 0;
	while ($x < $num){

		$f = mysql_result($sql, $x, "FORUM_ID");

		if($x > 0){
			$forums .= '<font color="red"> + </font>';
		}
					 if(	forums("SHOW_PROFILE", $f) == 0 ){

		$forums .= '<a href="index.php?mode=f&f='.$f.'">'.forums("SUBJECT", $f).'</a>';}
	++$x;
	}
	$titles = '<font color="red">'.$lang['function']['moderator_title'].'&nbsp;</font>'.$forums.'<br>'.member_title($m).'<br>'.profile_member_title($m);
return($titles);
}

function profile_monitor_title($m){
	global $Prefix, $lang;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY WHERE CAT_MONITOR = '$m' AND SHOW_PROFILE = '0' ORDER BY CAT_ID ASC ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
	$x = 0;
	while ($x < $num){
		$c_name = mysql_result($sql, $x, "CAT_NAME");
		if($x > 0){
			$cats .= '<font color="red"> + </font>';
		}
		$cats .= $c_name;
	++$x;
	}
	$titles = '<font color="red">'.$lang['function']['monitor_title'].'&nbsp;</font>'.$cats.'<br>'.member_title($m).'<br>'.profile_member_title($m);
return($titles);
}

?>
