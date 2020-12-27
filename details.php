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

if($Mlevel == 4){

	  
	 
														
$ppMemberID = $id;
$Name = link_profile(member_name($id), $id);

//------------------------------------------ CHANGES NAMES BY MR TAZI / F -------------------------------------------

    $TOTAL_OUT = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}PM WHERE PM_MID = '$ppMemberID' AND PM_OUT = '1'", [], __FILE__, __LINE__);
    $TotalPM_OUT = mysql_result($TOTAL_OUT , 0, "count(*)");

//------------------------------------------  Topics BY ملك المستقبل  / Ayoub -------------------------------------------

    $TOTAL_TOP = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE T_AUTHOR = '$ppMemberID' ", [], __FILE__, __LINE__);
    $TotalTOP = mysql_result($TOTAL_TOP , 0, "count(*)");

    $TOTAL_TOPH = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE T_AUTHOR = '$ppMemberID' AND T_HIDDEN = 1  ", [], __FILE__, __LINE__);
    $TotalTOPH = mysql_result($TOTAL_TOPH , 0, "count(*)");

    $TOTAL_TOPUN = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE T_AUTHOR = '$ppMemberID' AND T_HOLDED= 1  ", [], __FILE__, __LINE__);
    $TotalTOPUN = mysql_result($TOTAL_TOPUN , 0, "count(*)");

    $TOTAL_TOP2 = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE T_AUTHOR = '$ppMemberID' AND T_TOP = 2  ", [], __FILE__, __LINE__);
    $TotalTOP2 = mysql_result($TOTAL_TOP2 , 0, "count(*)");

//------------------------------------------  REPLY BY ملك المستقبل  / Ayoub -------------------------------------------

    $TOTAL_RP = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}REPLY WHERE R_AUTHOR = '$ppMemberID' ", [], __FILE__, __LINE__);
    $TotalRP = mysql_result($TOTAL_RP , 0, "count(*)");

    $TOTAL_RPH = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}REPLY WHERE R_AUTHOR = '$ppMemberID' AND R_HIDDEN = 1  ", [], __FILE__, __LINE__);
    $TotalRPH = mysql_result($TOTAL_RPH , 0, "count(*)");


    $TOTAL_RUN = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}REPLY WHERE R_AUTHOR = '$ppMemberID' AND R_HOLDED = 1  ", [], __FILE__, __LINE__);
    $TotalRPUN = mysql_result($TOTAL_RUN , 0, "count(*)");

    $TOTAL_N = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}NOTIFY WHERE AUTHOR_ID = '$ppMemberID'  ", [], __FILE__, __LINE__);
    $TotalN = mysql_result($TOTAL_N , 0, "count(*)");




echo '
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr  align="center">
		<td>
		<table class="optionsbar" cellSpacing="2" width="100%" border="0">
			<tr>
				<td vAlign="center"></td>
				<td class="optionsbar_title" vAlign="center" width="100%"><img hspace="7" border="0" src="'.$icon_profile.'">إحصائيات العضو :  '.$Name.'</td>
';
refresh_time();
            go_to_forum();
echo'
				<div align="center">

				<table   class="grid" cellSpacing="1" cellPadding="1" width="100%" border="0" >
				 	</td>
					</tr>


 	<td class="fixed" align="middle" colSpan="2"><b><font size="3">'.$lang['profile']['member_details_g'].'</font></b></td>
                    <tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['member_details_pm_out'].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$TotalPM_OUT.'</font></td>
                    <tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['member_details_notify'].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$TotalN.'</font></td>
					</tr>
					
<td class="fixed" align="middle" colSpan="2"><b><font size="3">'.$lang['profile']['member_details_top'].'</font></b></td>
					</tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['member_details_topic'].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$TotalTOP.'</font></td>
                    <tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['member_details_topic_hide'].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$TotalTOPH.'</font></td>
                    <tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['member_details_topic_un'].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$TotalTOPUN.'</font></td>
                    <tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['member_details_topic_2'].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$TotalTOP2.'</font></td>
                    <tr>


<td class="fixed" align="middle" colSpan="2"><b><font size="3">'.$lang['profile']['member_details_rp'].'</font></b></td>
					</tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['member_details_all_rp'].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$TotalRP.'</font></td>
                    <tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['member_details_rp_hide'].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$TotalRPH.'</font></td>
                    <tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['member_details_rp_un'].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$TotalRPUN.'</font></td>
						';
}
	else {
		redirect();
	}
?>
