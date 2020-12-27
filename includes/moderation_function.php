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

function monOptionclass($val, $var, $class){
 if($val == $var){
   $moClass = $class;
 }
 else {
   $moClass = "stats_menu";
 }
 return($moClass);
}

function send_pm($from, $to, $subject, $message, $date){

 global $Prefix, $connection;

     $send_pm = "INSERT INTO {$mysql->prefix}PM (PM_ID, PM_MID, PM_TO, PM_FROM, PM_OUT, PM_SUBJECT, PM_MESSAGE, PM_DATE) VALUES (NULL, ";
     $send_pm .= " '$from', ";
     $send_pm .= " '$to', ";
     $send_pm .= " '$from', ";
     $send_pm .= " '1', ";
     $send_pm .= " '$subject', ";
     $send_pm .= " '$message', ";
     $send_pm .= " '$date') ";

     $mysql->execute($send_pm, $connection, [], __FILE__, __LINE__);

     $store_pm = "INSERT INTO {$mysql->prefix}PM (PM_ID, PM_MID, PM_TO, PM_FROM, PM_SUBJECT, PM_MESSAGE, PM_DATE) VALUES (NULL, ";
     $store_pm .= " '$to', ";
     $store_pm .= " '$to', ";
     $store_pm .= " '$from', ";
     $store_pm .= " '$subject', ";
     $store_pm .= " '$message', ";
     $store_pm .= " '$date') ";

     $mysql->execute($store_pm, $connection, [], __FILE__, __LINE__);
}

function mon_days($end, $start){
    $m_days=$end-$start;
    $m_days=$m_days/84600;
    $m_days=ceil($m_days);
    return($m_days);
}

function check_administrateurs($m){
    global $Prefix;
    if($m > 0){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$m' AND M_LEVEL = '4' ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
    	if($num > 0){
            $chk_admin = 1;
	}
	else {
	    $chk_admin = 0;
	}
    }
    else {
	$chk_admin = 0;
    }
    return($chk_admin);
}

?>