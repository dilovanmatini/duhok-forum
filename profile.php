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

if(!member_view($id)) redirect();
require_once("./include/profile_func.df.php");

if($CAN_SHOW_PROFILE == 1 AND mlv == 0){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>'.$lang['profile']['you_must_login_to_view'].'</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}

if(members("STATUS", $id) == 1 OR $Mlevel > 1 AND members("NAME", $id) != "" OR $type != ""){

if($id != ""){

$ppMemberID = $id;


 $query = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$ppMemberID."' ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($result) > 0){
 $rs=mysql_fetch_array($result);

 $ProMemberID = $rs['MEMBER_ID'];
 $ProMemberStatus = $rs['M_STATUS'];
 $ProMemberName = $rs['M_NAME'];
 $ProMemberEmail = $rs['M_EMAIL'];
 $ProMemberLevel = $rs['M_LEVEL'];
 $ProMemberCountry = $rs['M_COUNTRY'];
 $ProMemberCity = $rs['M_CITY'];
 $ProMemberPosts = $rs['M_POSTS'];
 $ProMemberState = $rs['M_STATE'];
 $ProMemberOccupation = $rs['M_OCCUPATION'];
 $ProMemberAge = $rs['M_AGE'];
 $ProMemberSex = $rs['M_SEX'];
 $ProMemberDate = $rs['M_DATE'];
 $ProMemberLastPostDate = $rs['M_LAST_POST_DATE'];
 $ProMemberLastHereDate = $rs['M_LAST_HERE_DATE'];
 $ProMemberPhotoURL = $rs['M_PHOTO_URL'];
 $ProMemberMarStatus = $rs['M_MARSTATUS'];
 $ProMemberBio = $rs['M_BIO'];
 $ProMemberTitle = $rs['M_TITLE'];
 $ProMemberOldMod = $rs['M_OLD_MOD'];
 $ProMemberSig = $rs['M_SIG'];
 $ProMemberPmHide = $rs['M_PMHIDE'];
 $ProMemberLogin = $rs['M_LOGIN'];
 $ProMemberBrowse = $rs['M_BROWSE'];
 $ProMemberHidePhoto = $rs['M_HIDE_PHOTO'];
 $ProMemberHideSig = $rs['M_HIDE_SIG'];
 $ProMemberPass = $rs['M_PASSWORD'];
 $ProMemberIP = $rs['M_IP'];
 $ProMemberCloser = $rs['LOCK_BY'];
 $ProMemberDate = $rs['LOCK_DATE'];
 $ProMemberCause = $rs['LOCK_CAUSE'];
 $ProMemberPm = $rs['M_HIDE_PM'];
 $ProMemberTopics = $rs['LOCK_TOPICS'];
 $ProMemberPosts = $rs['LOCK_POSTS'];
 $closer = link_profile(member_name($ProMemberCloser), $ProMemberCloser);
 }

 $queryCH = "SELECT * FROM {$mysql->prefix}CHANGENAME_PENDING WHERE MEMBERID = '" .$ppMemberID."'";
 $resultCH = $mysql->execute($queryCH, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($resultCH) > 0){
 $rsCH=mysql_fetch_array($resultCH);

 $CHMemberID = $rsCH['MEMBERID'];
 }

if($type == ""){
echo '
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<table class="optionsbar" cellSpacing="2" width="100%" border="0">
			<tr>
				<td vAlign="center"></td>
				<td class="optionsbar_title" vAlign="center" width="100%"><img hspace="7" border="0" src="'.$icon_profile.'">'.$lang['profile']['member_info'].' '.$ProMemberName.'</td>';
if($Mlevel > 0 AND $ppMemberID != $DBMemberID){
				echo'
				<td class="optionsbar_menus"><a href="index.php?mode=pm&mail=m&m='.$ppMemberID.'"><nobr>'.$lang['profile']['your_pm_with_this_member'].'</nobr></a></td>';
}
if($DBMemberID > 0){
				echo'
				<td class="optionsbar_menus"><a href="index.php?mode=posts&m='.$ppMemberID.'"><nobr>'.$lang['profile']['posts_member'].'</nobr></a></td>';
if($mlv >1  OR $mlv == 1   AND $DBMemberPosts >=  $new_member_show_topic){
                echo'
				<td class="optionsbar_menus"><a href="index.php?mode=topics&m='.$ppMemberID.'"><nobr>'.$lang['profile']['topics_member'].'</nobr></a></td>';
}
				echo'
				<td class="optionsbar_menus"><a href="index.php?mode=list&type=add&c=-1&aid='.$ppMemberID.'"><nobr>'.$lang['profile']['list_y'].'</nobr></a></td>';
                echo'
				<td class="optionsbar_menus"><a href="index.php?mode=list&type=add&c=-2&aid='.$ppMemberID.'"><nobr>'.$lang['profile']['list_n'].'</nobr></a></td>';
}

if($Mlevel > 1){
				echo'
				<td>&nbsp;</td>
				<td class="optionsbar_menus"><nobr><a href="index.php?mode=svc&method=award&svc=medals&m='.$ppMemberID.'">رشح العضو<br>لوسام تميز</a></nobr></td>
				<td class="optionsbar_menus"><nobr><a href="index.php?mode=svc&method=award&svc=titles&m='.$ppMemberID.'">أضف وصف<br>للعضو</a></nobr></td>
				<td>&nbsp;</td>
				<td class="optionsbar_menus"><nobr><a href="index.php?mode=svc&svc=medals&app=all&scope=all&days=all&m='.$ppMemberID.'">تفاصيل<br>أوسمة العضو</a></nobr></td>
				<td class="optionsbar_menus"><nobr><a href="index.php?mode=svc&svc=titles&m='.$ppMemberID.'">أوصاف<br>العضو</a></nobr></td>
				<td class="optionsbar_menus"><nobr><a href="index.php?mode=requestmon&aid='.$ppMemberID.'">تاريخ<br>الرقابة</a></nobr></td>';
}
if($Mlevel == 4){
echo '
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<table class="optionsbar" cellSpacing="2" width="100%" border="0">
			<tr>
				<td vAlign="center"></td>
				<td class="optionsbar_title" vAlign="center" width="100%"><img hspace="7" border="0" src="'.$icon_edit.'">'.$lang['profile']['member_info_edit'].' '.$ProMemberName.'</td>';

				echo'
				<td>&nbsp;</td>';
			if($ProMemberStatus == 1){
				echo'
				<td class="optionsbar_menus"><a href="index.php?mode=lockm&m='.$ppMemberID.'"><nobr>قفل<br>العضوية</nobr></a></td>';
			}
			if($ProMemberStatus == 0){
				echo'
				<td class="optionsbar_menus"><a href="index.php?mode=openm&m='.$ppMemberID.'" ><nobr>فتح<br>العضوية</nobr></a></td>';
			}
								echo'
			    <td class="optionsbar_menus">	<a href="index.php?mode=delete&type=m&m='.$ppMemberID.'"  onclick="return confirm(\''.$lang['members']['you_are_sure_to_delete_this_member'].'\');">'.$lang['members']['delete_member'].'</a>';

}
if($Mlevel == 4 ){
echo'<td class="optionsbar_menus"><a href="index.php?mode=details&&id='.$ppMemberID.'"><nobr>إحصائيات<br> العضو </nobr></a></td>';
echo'<td class="optionsbar_menus"><a href="index.php?mode=ip&ip='.$ProMemberIP.'"><nobr>الـ IP المشترك <br> لهذه العضوبة</nobr></a></td>';
echo'<td class="optionsbar_menus"><a href="index.php?mode=permission&id='.$ppMemberID.'"><nobr>تعديل تصاريح<br>هذه العضوبة</nobr></a></td>';
echo'<td class="optionsbar_menus"><a href="index.php?mode=quick&m='.$ppMemberID.'"><nobr>خيارات<br>سريعة</nobr></a></td>';

}

if($Mlevel == 4 OR $Mlevel == 3){
			echo'
	<td class="optionsbar_menus">خيارات العضوية : <br><select name="mod" onchange="profile_mod(this.value)">
<option value="index.php">-- خيارات --</option>';
if($Mlevel == 4){
echo '<option value="index.php?mode=profile&type=edit_user&id='.$ppMemberID.'">تعديل العضو</option>
<option value="index.php?mode=svc&svc=ip&id='.$ppMemberID.'">سجل الدخول</option>
<option value="index.php?mode=svc&svc=ip&type=info&id='.$ppMemberID.'">محاولات الدخول</option>
<option value="index.php?mode=svc&svc=search&id='.$ppMemberID.'">عمليات البحث</option>';
}
if($Mlevel == 4 OR $Mlevel == 3 AND $CAN_SHOW_PM == 1){
echo '<option value="index.php?mode=pm&mail=show&id='.$ppMemberID.'">مراقبة الرسائل</option>';
}
if($Mlevel == 3 AND $CAN_CLOSE_M == 1 AND $ProMemberStatus == 1){
echo '<option value="index.php?mode=lockm&m='.$ppMemberID.'">قفل العضوية</option>';
}
if($Mlevel == 3 AND $CAN_OPEN_M == 1 AND $ProMemberStatus == 0){
echo '<option value="index.php?mode=openm&m='.$ppMemberID.'">فتح العضوية</option>';
}
echo '</select></td>';

}
            go_to_forum();
            echo'
            </tr>
		</table>
		</td>
	</tr>
</table>
</center>
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<table cellSpacing="1" cellPadding="1" width="888" align="center" border="0">
			<tr>
				<td vAlign="top" width="307">
				<table cellSpacing="2" cellPadding="3" width="100%" border="0">
							';
if($ProMemberStatus == 0){

 

if($ProMemberTopics == 0){
		$txt = "نعم";
	}
	else{
		$txt = "لا";
	}
if($ProMemberPosts == 0){
		$txts = "نعم";
	}
	else{
		$txts = "لا";
	}
	
if($ProMemberPm == 1){
		$pm = "نعم";
	}
	else{
		$pm = "لا";
	}

echo'
<td class="cat" align="middle" colSpan="2"><b><font size="3" >'.$lang[lock][close].'</font></b></td>
<tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang[lock][closer].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$closer.'</font></td>
</tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang[lock][date].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.normal_time($ProMemberDate).'</font></td>
</tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang[lock][topics].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$txt.' </font></td>
</tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang[lock][posts].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$txts.' </font></td>
</tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang[lock][pm].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$pm.' </font></td>
</tr>
<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang[lock][why].'</font></b></td>
<td class="userdetails_data" width="100%"><font size="3">'.$ProMemberCause.' </font></td>
<tr>


					</tr>';
				}
echo'

					<tr>
						<td class="userdetails_header" align="middle" colSpan="2"><b><font size="3">'.$lang['profile']['single_photo'].'</font></b></td>
					</tr>
					<tr>
						<td class="userdetails_data" vAlign="top" noWrap align="middle" colSpan="2">';
				if($ProMemberPhotoURL != "" AND ($ProMemberHidePhoto == 0 OR $Mlevel > 1)){
      						echo'<a href="'.$ProMemberPhotoURL.'">
      						<img onerror="this.src=\''.$icon_photo_none.'\';" alt="'.$ProMemberName.'" src="'.$ProMemberPhotoURL.'" border="0" width="120"></a>';
				}
				else {
						echo'<a href="'.$icon_photo_none.'">
						<img alt="'.$ProMemberName.'" src="'.$icon_photo_none.'" border="0"></a>';
				}
						echo'<br><b><font size="3">'.$lang['profile']['click_here_to_zoom_in_this_photo'].'</font></b>';
						echo'</td>
					</tr>';
					echo'<tr>
						<td class="userdetails_header" align="middle" colSpan="2"><b><font size="3">'.$lang['profile']['way_to_call_me'].'</font></b></td>
					</tr>';
if($ProMemberPmHide == 1){

	if($ProMemberLevel == 4){
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['private_message'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3"><a href="index.php?mode=sendpm&msg=1&m='.$ppMemberID.'">'.$lang['profile']['send_pm_to_this_admin'].'</a></font></td>
					</tr>';
	}
	else {
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['private_message'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3"><a href="index.php?mode=editor&method=sendmsg&m='.$ppMemberID.'">'.$lang['profile']['send_pm_to_this_member'].'</a></font></td>
					</tr>';
	}
}
else {
$list = mysql_num_rows($mysql->execute("select * from {$mysql->prefix}LIST_M where M_ID = '$ppMemberID' AND USER = '$DBMemberID' AND CAT_ID = '-1' "));

    if($Mlevel > 1 OR $list != 0){
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['private_message'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3"><a href="index.php?mode=editor&method=sendmsg&m='.$ppMemberID.'">'.$lang['profile']['send_pm_to_this_member'].'</a></font></td>
					</tr>';
    }
}
if($Mlevel > 1){
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['the_email'].'</font></b></td>
						<td class="userdetails_data" width="100%"><b><font size="3"><a href="index.php?mode=email_to_m&id='.$ppMemberID.'">'.$lang['profile']['send_email_to_this_member'].'</a></font></b></td>
					</tr>';
}

					echo'
					<tr>
						<td class="userdetails_header" align="middle" colSpan="2"><b><font size="3">'.$lang['profile']['statistics'].'</font></b></td>
					</tr>';
				if($ProMemberStatus == 0){
					echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">وضع العضوية:</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3" color="red">العضوية مقفولة</font></td>
					</tr>';
				}
				if(member_all_points($ppMemberID) > 0){
					echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">نقاط التميز:</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.member_all_points($ppMemberID).'</font></td>
					</tr>';
				}
					echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['number_posts'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.$ProMemberPosts.'</font></td>
					</tr>
                  
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['rejister_date'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.normal_time($ProMemberDate).'</font></td>
					</tr>';
			if($ProMemberLastPostDate != ""){
                if($ppMemberID == 1){
                    echo'';
                }
				else {
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['last_post'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.normal_time($ProMemberLastPostDate).'</font></td>
					</tr>';
                }
			}
			if($Mlevel > 1){
				if(!empty($ProMemberLastHereDate)){
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['last_visit'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.normal_time($ProMemberLastHereDate).'</font></td>
					</tr>';
				}
			}
			else{
				if(!empty($ProMemberLastHereDate) AND $ProMemberBrowse == 1){
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['last_visit'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.normal_time($ProMemberLastHereDate).'</font></td>
					</tr>';
				}
			}
			$member_is_online = member_is_online($ppMemberID);
			if($Mlevel > 1){
				if($member_is_online == 1){
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['status'].'</font></b></td>
						<td class="userdetails_data" width="100%">
						<table border="0">
							<tr>
								<td class="optionsbar_menus2">'.icons($icon_online).'<br><font size="1">'.$lang['profile']['status_online'].'</font></td>
							</tr>
						</table>
						</td>
					</tr>';
				}
			}
			else{
				if($member_is_online == 1 AND $ProMemberBrowse == 1){
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['status'].'</font></b></td>
						<td class="userdetails_data" width="100%">
						<table border="0">
							<tr>
								<td class="optionsbar_menus2" align="center"><img src="'.$icon_online.'" hspace="0" border="0"><br><font size="1">'.$lang['profile']['status_online'].'</font></td>
							</tr>
						</table>
						</td>
					</tr>';
				}
			}
//------------------------------------------ CHANGES NAMES BY MR TAZI / H -------------------------------------------

if($CHMemberID != ""){
					echo'<tr>
						<td class="userdetails_header" align="middle" colSpan="2"><b><font size="3">'.$lang['profile']['member_last_name'].'</font></b></td>
					</tr>';
 $query = "SELECT * FROM {$mysql->prefix}CHANGENAME_PENDING WHERE MEMBERID = '" .$ppMemberID."' AND UNDERDEMANDE = '0' ";
 $query .= " ORDER BY CH_DATE DESC";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 $num = mysql_num_rows($result);
	
 $i=0;
 while ($i < $num){

    $CH_NameID = mysql_result($result, $i, "CHNAME_ID");
    $CH_OriginalName = mysql_result($result, $i, "LAST_NAME");
    $CH_Date = mysql_result($result, $i, "CH_DATE");

                    echo'
                    			<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="center"><b><font size="3">'.normal_date($CH_Date).':</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.$CH_OriginalName.'</font></td>
					</tr>';
    ++$i;
 }
}

//------------------------------------------ CHANGES NAMES BY MR TAZI / F -------------------------------------------


                echo'		</table>
				</td>
				<td vAlign="top" width="33">&nbsp;</td>
				<td vAlign="top">';
echo'

				<table cellSpacing="2" cellPadding="3" width="560" border="0" valign="top">
					<tr>
						<td class="userdetails_header" align="middle" colSpan="2"><b><font size="3">'.$lang['profile']['total_details'].'</font></b></td>
					</tr>';

if($Mlevel == 4){
$ADD = mysql_fetch_array($mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$ppMemberID."' "
), [], __FILE__, __LINE__);
;
  echo'
                    <tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['member_show'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.$ADD['view'].'</font></td>
					</tr>';
}
if($Mlevel > 1){
                    echo'
                    <tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['member_id'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.$ProMemberID.'</font></td>

											</font></td>

					</tr>';

}

if($ProMemberLevel == 1 AND profile_member_title($ppMemberID) != "" OR $ProMemberOldMod > 0){
                    echo'
                    <tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['the_title'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.old_mod($ppMemberID, "3", "").''.profile_member_title($ppMemberID).'</font></td>
					</tr>';
}
if($ProMemberLevel == 2 AND profile_moderator_title($ppMemberID) != ""){
                    echo'
                    <tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['the_title'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.profile_moderator_title($ppMemberID).'</font></td>
					</tr>';
}
if($ProMemberLevel == 3 AND profile_monitor_title($ppMemberID) != ""){
                    echo'
                    <tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['the_title'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.profile_monitor_title($ppMemberID).'</font></td>
					</tr>';
}
if($ProMemberLevel == 4 AND member_title($ppMemberID) != ""){
                    echo'
                    <tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['the_title'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.member_title($ppMemberID).'</font></td>
					</tr>';
}


if($ProMemberCity != "" || $ProMemberState != "" || $ProMemberCountry != ""){

    if($ProMemberCity != ""){
        $ProMemberCity = $ProMemberCity."<br>";
    }
    if($ProMemberState != ""){
        $ProMemberState = $ProMemberState."<br>";
    }
                    echo'
                    <tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['address'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.$ProMemberCity.$ProMemberState.$ProMemberCountry.'</font></td>
					</tr>';
}
if($ProMemberAge != ""){
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['the_age'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.$ProMemberAge.'</font></td>
					</tr>';
}
if($ProMemberMarStatus != ""){
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['the_sociability_status'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.$ProMemberMarStatus.'</font></td>
					</tr>';
}
if($ProMemberSex != "" && $ProMemberSex != 0){
    if($ProMemberSex == "1"){
        $MemberSex = $lang['profile']['male'];
    }
    if($ProMemberSex == "2"){
        $MemberSex = $lang['profile']['female'];
    }
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['the_sex'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.$MemberSex.'</font></td>
					</tr>';
}
if($ProMemberOccupation != ""){
                    echo'
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['the_occupation'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.$ProMemberOccupation.'</font></td>
					</tr>';
}

//###########################  medals ##############################
	if($app == "all"){
		$sql_open_all = '';
	}
	else{
		$sql_open_all = 'LIMIT 9';
	}
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEDALS WHERE MEMBER_ID = '$ppMemberID' AND STATUS = '1' ORDER BY DATE DESC ".$sql_open_all." ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
	if($num > 0){
		echo'
		<tr>
			<td class="userdetails_header" align="middle" colSpan="2"><b><font size="3">أوسمة التميز الممنوحة للعضو</font></b></td>
		</tr>
		<tr>
			<td class="userdetails_data" width="100%" colspan="2">
			<table border="0" width="100%" cellpadding="6">
				<tr>';
		$count = 0;
		$x = 0;
		while($x < $num){
			$m = mysql_result($sql, $x, "MEDAL_ID");
			$gm_id = medals("GM_ID", $m);
			$url = medals("URL", $m);
			$f = medals("FORUM_ID", $m);
			$subject = gm("SUBJECT", $gm_id);
			$date = medals("DATE", $m);
					echo'
					<td align="center">'.icons($url).'<br><font color="red" size="-2">'.forums("SUBJECT", $f).'<br></font><font color="black" size="-2">'.$subject.'<br><font color="orange" size="-2">'.normal_date($date).'</font></font></td>';
			$three_medals = $three_medals + 1;
			if($three_medals == 3){
				echo'
				</tr>
				<tr>';
				$three_medals = 0;
			}
			$count += 1;
		++$x;
		}
				echo'
				</tr>
			</table>';
		if($count > 8 AND $app != "all"){
			echo'
			<br><div align="center"><font size="1"><a class="menu" href="index.php?mode=profile&id='.$ppMemberID.'&app=all">-- هناك أوسمة أخرى لهذا العضو -- إضغط هنا لمشاهدتها بالكامل --</a></font></div>';
		}
		if($count > 8 AND $app == "all"){
			echo'
			<br><div align="center"><font size="1"><a class="menu" href="index.php?mode=profile&id='.$ppMemberID.'">-- انقر هنا للرجوع الى ترتيب الافتراضي --</a></font></div>';
		}
			echo'
			</td>
		</tr>';
	}
//###########################  medals ##############################
if($ProMemberBio != ""){
                    echo'
					<tr>
						<td class="userdetails_header" align="middle" colSpan="2"><b><font size="3">'.$lang['profile']['additional_info'].'</font></b></td>
					</tr>
					<tr>
						<td class="userdetails_title" vAlign="top" noWrap align="left"><b><font size="3">'.$lang['profile']['the_biography'].'</font></b></td>
						<td class="userdetails_data" width="100%"><font size="3">'.$ProMemberBio.'</font></td>
					</tr>';
}
                echo'
				</table>
				</td>
			</tr>
            <tr>
                <td>&nbsp;</td>
            </tr>';
   
if($ProMemberSig != "" AND ($ProMemberHideSig == 0 OR $Mlevel > 1)){
            echo'<tr>
				<td vAlign="top" width="99%" colSpan="3">
				<table cellSpacing="2" cellPadding="3" width="100%" border="0">
					<tr>
						<td class="userdetails_header" align="middle"><b><font size="3">'.$lang['profile']['the_signature'].'</font></b></td>
					</tr>
					<tr>
						<td class="userdetails_data" width="100%"><font size="3">'.text_replace($ProMemberSig).'</font></td>
					</tr>
                </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>';
}
            echo'
		</table>
		</td>
	</tr>
</table>
</center>
';

}


}
if($type == "style"){
    if($DBMemberID > 0){

 $query = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = ".$DBMemberID." ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($result) > 0){
 $rs=mysql_fetch_array($result);

 $ProMemberID = $rs['MEMBER_ID'];
 $ProMemberColor = $rs['M_COLOR'];
 $ProMemberSize = $rs['M_SIZE'];
 $ProMemberFonts = $rs['M_FONTS_T'];
 $ProMemberAlign = $rs['M_ALIGN'];
 $ProMemberWeight = $rs['M_WEIGHT'];

 }

if(editor_type == 0){
                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang['profile']['style'].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}


echo'
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>

            <form method="post" action="index.php?mode=profile&type=style&type=insert_style">
			<table cellSpacing="1" cellPadding="4" bgColor="gray" border="0">

		<td class="optionheader"  colspan="2"> <nobr>تغيير خيارات نمط كتابة النصوص </tr>
		<tr class="fixed">
		<td class="optionheader" id="row_user_weight" > <nobr>وزن الخط :</tr>
		<td class="list">
			<select   onchange="check_changes(row_user_weight, \''.$ProMemberWeight.'\', this.value)" class="insidetitle" style="WIDTH: 60px" name="user_weight" type="text">';
        $selected = $ProMemberWeight;
		echo'
		<option value="normal" '.check_select($selected, "normal").'>خفيف</option>
		<option value="bold" '.check_select($selected, "bold").'>ثقيل</option>';
		echo'</select>
        </td>
        </tr>
		<tr class="fixed">
		<td class="optionheader" id="row_user_align" > <nobr>إتجاه النص :</tr>
		<td class="list">
			<select   onchange="check_changes(row_user_align, \''.$ProMemberAlign.'\', this.value)" class="insidetitle" style="WIDTH: 60px" name="user_align" type="text">';
        $selected = $ProMemberAlign ;
		echo'
		<option value="right" '.check_select($selected, "right").'>يمين</option>
		<option value="center" '.check_select($selected, "center").'>وسط</option>
		<option value="left" '.check_select($selected, "left").'>يسار</option>';
		echo'</select>
        </td>
        </tr>

		<tr class="fixed">
		<td class="optionheader" id="row_user_size"> <nobr>حجم النص :</tr>
		<td class="list">
			<select   onchange="check_changes(row_user_size, \''.$ProMemberSize.'\', this.value)" class="insidetitle" style="WIDTH: 60px" name="user_size" type="text">';
        $selected = $ProMemberSize ;
		echo'
                    <option value="10" '.check_select($selected, "10").'>10</option>
                    <option value="11" '.check_select($selected, "11").'>11</option>
					<option value="12" '.check_select($selected, "12").'>12</option>
					<option value="13" '.check_select($selected, "13").'>13</option>
					<option value="14" '.check_select($selected, "14").'>14</option>
					<option value="16" '.check_select($selected, "16").'>16</option>
					<option value="18" '.check_select($selected, "18").'>18</option>
					<option value="20" '.check_select($selected, "20").'>20</option>
					<option value="22" '.check_select($selected, "22").'>22</option>
					<option value="24" '.check_select($selected, "24").'>24</option>
					<option value="28" '.check_select($selected, "28").'>28</option>
					<option value="32" '.check_select($selected, "32").'>32</option>
					<option value="40" '.check_select($selected, "40").'>40</option>
					<option value="48" '.check_select($selected, "48").'>48</option>
					<option value="60" '.check_select($selected, "60").'>60</option>
					<option value="72" '.check_select($selected, "72").'>72</option>
					<option value="80" '.check_select($selected, "80").'>80</option>
					';		echo'</select>
        </td>
        </tr>
        				<tr class="fixed">
		<td class="cat" id="row_user_f" colSpan="1" >نمط الخط :</tr>
			<td class="list" id="row_user_font" >
			<select   onchange="check_changes(row_user_f, \''.$ProMemberFonts.'\', this.value)" class="insidetitle" style="WIDTH: 150 px" name="user_font" type="text">';


        $selected = $ProMemberFonts ;
		echo'
                    <option value="arabic transparent" '.check_select($selected, "arabic transparent").'>بسيط</option>
                    <option value="arial" '.check_select($selected, "arial").'>آريال</option>
                    <option value="akhbar mt" '.check_select($selected, "akhbar mt").'>أخبار</option>
                    <option value="andalus" '.check_select($selected, "andalus").'>أندلس</option>
                    <option value="bold italic art" '.check_select($selected, "bold italic art").'>فني ثقيل</option>
                    <option value="decotype naskh" '.check_select($selected, "decotype naskh").'>نسخ</option>
                    <option value="diwani letter" '.check_select($selected, "diwani letter").'>ديواني</option>
                    <option value="diwani outline shaded" '.check_select($selected, "diwani outline shaded").'>ديواني مظلل</option>
                    <option value="diwani simple striped" '.check_select($selected, "diwani simple striped").'>ديواني مخطط</option>
                    <option value="monotype kufi" '.check_select($selected, "monotype kufi").'>كوفي</option>
                    <option value="kufi extended outline" '.check_select($selected, "kufi extended outline").'>كوفي كبير</option>
                    <option value="mudir mt" '.check_select($selected, "mudir mt").'>مدير</option>
                    <option value="old antic bold" '.check_select($selected, "old antic bold").'>أنتيك</option>
                    <option value="simple indust shaded" '.check_select($selected, "simple indust shaded").'>صناعي</option>
                    <option value="decotype thuluth" '.check_select($selected, "decotype thuluth").'>ثلث</option>
                    <option value="arial black" '.check_select($selected, "arial black").'>Arial</option>
                    <option value="arial narrow" '.check_select($selected, "arial narrow").'>Arial Narrow</option>
                    <option value="comic sans ms" '.check_select($selected, "comic sans ms").'>Comic</option>
                    <option value="courier new" '.check_select($selected, "courier new").'>Courier</option>
                    <option value="tahoma" '.check_select($selected, "tahoma").'>Tahoma</option>
                    <option value="Times New Roman" '.check_select($selected, "Times New Roman").'>Times</option>
                    <option value="verdana" '.check_select($selected, "verdana").'>Verdana</option>
					';		echo'</select>
        </td>
<script type="text/javascript" src="javascript/colors.js"></script>
</tr>
<tr class="fixed">
<td class="cat" id="row_user_ff" colSpan="1" >لون الخط :</tr>
<td class="middle" align="center">
<script language="javascript" type="text/javascript" >
document.write(color_palette("'.$ProMemberColor.'",1));
</script>
<input  name="g1" onchange="check_changes(row_user_ff, \''.$ProMemberColor.'\', this.value)" id="g1"  value="'.$ProMemberColor.'"  ></td>

 	<tr class="fixed">

		<td align="middle" colspan="5">
		<input type="submit" value="'.$lang['profile']['insert_info'].'">&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['profile']['reset_info'].'"></td>

				</tr>
			</table>
			</form>
		</center></td>
	</tr>
</table>
</center>

<div style="color:red;text-align:center;font-size:10pt;font-family:tahoma">ملاحظة: الخيارات التي تم تغييرها تظهر باللون الأحمر <br>سيتم تخزين هذه البيانات كخياراتك   الأساسية عند إضافة أية مشاركة جديدة </div>';

    } 	
 }

if($type == "insert_style"){

    if($DBMemberID > 0){

$user_size = $_POST["user_size"];
$user_align= $_POST["user_align"];
$user_font = $_POST["user_font"];
$user_colors = $_POST["g1"];
$user_weight = $_POST["user_weight"];

$user_fonts = HtmlSpecialchars($_POST["user_fonts"]);


if($error == ""){
		$query = "UPDATE {$mysql->prefix}MEMBERS SET ";
        $query .= "M_SIZE = ('$user_size'),  ";
        $query .= "M_ALIGN= ('$user_align'),  ";
        $query .= "M_FONTS_T = ('$user_font'),  ";
        $query .= "M_COLOR = ('$user_colors'),  ";
        $query .= "M_WEIGHT = ('$user_weight')  ";
        $query .= "WHERE MEMBER_ID = ".$DBMemberID." ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);


  echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['profile']['your_details_has_edited'].'</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=index.php?mode=profile&type=style">
                           <a href="index.php?mode=profile&type=style">'.$lang['profile']['click_here_to_go_normal_page'].'</a><br>
	                       <br></td>
	                   </tr>
	                </table>
	                </center>';
}
}

}
if($type == "notes"){
    if($DBMemberID > 0){

 $query = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$DBMemberID."' ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($result) > 0){
 $rs=mysql_fetch_array($result);

 $ProMemberID = $rs['MEMBER_ID'];
 $ProMemberNotes = $rs['M_NOTES'];
 }

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="2" width="80%">
<form method="post" action="index.php?mode=profile&type=notes&type=add">
	<tr class="fixed">
	<td class="cat" colspan="2"><nobr>'.$lang['profile']['note'].'  </td>
	<tr class="fixed">
	<td class="userdetails_data"  colspan="2">
		<textarea  class="insidetitle" style="WIDTH: 800; HEIGHT: 300; '.M_Style_Form.'" name="user_notes" type="text" rows="1" cols="20">'.$ProMemberNotes.'</textarea></td>

 	<tr class="fixed">


		<td align="middle" colspan="2"><input type="submit" value="'.$lang['profile']['insert_info'].'">&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['profile']['reset_info'].'"></td>
	</tr>		

';
 }
 else {
 redirect();
 }
}
if($type == "add"){
    if($DBMemberID > 0){

$user_text = HtmlSpecialchars($_POST["user_notes"]);

if($error == ""){

		$query = "UPDATE {$mysql->prefix}MEMBERS SET ";
        $query .= " M_NOTES = ('$user_text') ";
        $query .= "WHERE MEMBER_ID = '$DBMemberID' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['profile']['your_notes_has_edited'].'</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=index.php?mode=profile&type=details">
                           <a href="index.php?mode=profile&type=details">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}


    }
    else {
    redirect();
    }

}




if($type == "details"){
if(members("DETAILS", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][your_details].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}
echo'
<center>
<table cellSpacing="1" cellPadding="4" bgColor="gray" border="0" id="table1">
	<tr class="fixed">
		<td class="list"><img src="'.$details.'"></td>
		<td class="optionheader">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="yellow" size="+2">'.$lang['profile']['your_options_and_details'].'</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>'.$lang['profile']['please_choose_one'].'</td>
	</tr>
	<tr class="fixed">
		<td class="list" colSpan="2">
		<a href="index.php?mode=profile&type=edit_pass">'.$lang['profile']['edit_your_password_and_email'].'</a></td>
	</tr>
	<tr class="fixed">
		<td class="list" colSpan="2">
		<a href="index.php?mode=profile&type=edit_details">'.$lang['profile']['edit_your_details_and_options'].'</a></td>
	</tr>	';
	if(editor_type == 1){
echo'
	<tr class="fixed">
		<td class="list" colSpan="2">
		<a href="index.php?mode=profile&type=style">'.$lang['profile']['edit_your_style'].'</a></td>
	</tr>';
}

echo'	<tr class="fixed">
		<td class="list" colSpan="2">
		<a href="index.php?mode=profile&type=notes">'.$lang['profile']['edit_your_note'].'</a></td>
	</tr>

	<tr class="fixed">
		<td class="list" colSpan="2">
		<a href="index.php?mode=editor&method=sig">'.$lang['profile']['edit_your_signature'].'</a></td>
	</tr>
	<tr class="fixed">
		<td class="list" colSpan="2">
		<a href="index.php?mode=profile&type=medals">'.$lang['profile']['your_medals_info'].'</a></td>
	</tr>
	<tr class="fixed">
		<td class="list" colSpan="2">
		<a href="index.php?mode=list&method=index">'.$lang['profile']['edit_your_lists'].'</a></td>
	<tr class="fixed">
		<td class="list" colSpan="2">
		<a href="index.php?mode=hide_topics">'.$lang['profile']['private'].'</a></td>
	</tr>
	<tr class="fixed">
		<td class="list" colSpan="2">
		<a href="index.php?mode=changename">'.$lang['profile']['change_username'].'</a></td>
	</tr>';
	if($Mlevel > 1){
                echo'
                <tr class="fixed">
		<td class="list" colSpan="2">
		<a href="index.php?mode=svc&svc=ip">سجل الاتصال لعضويتك</a></td>
	</tr>
<tr class="fixed">
		<td class="list" colSpan="2">
		<a href="index.php?mode=svc&svc=ip&type=info">سجل محاولات الدخول لعضويتك</a></td>
	</tr>';}
	}
if($type == "edit_details"){
if(members("DETAILS_EDIT", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][edit_details].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}
    if($DBMemberID > 0){

 $query = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = ".$DBMemberID." ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($result) > 0){
 $rs=mysql_fetch_array($result);

 $ProMemberID = $rs['MEMBER_ID'];
 $ProMemberName = $rs['M_NAME'];
 $ProMemberCountry = $rs['M_COUNTRY'];
 $ProMemberCity = $rs['M_CITY'];
 $ProMemberPosts = $rs['M_POSTS'];
 $ProMemberState = $rs['M_STATE'];
 $ProMemberOccupation = $rs['M_OCCUPATION'];
 $ProMemberAge = $rs['M_AGE'];
 $ProMemberSex = $rs['M_SEX'];
 $ProMemberDate = $rs['M_DATE'];
 $ProMemberLastPostDate = $rs['M_LASTPOSTDATE'];
 $ProMemberPhotoURL = $rs['M_PHOTO_URL'];
 $ProMemberMarStatus = $rs['M_MARSTATUS'];
 $ProMemberReceiveEmail = $rs['M_RECEIVE_EMAIL'];
 $ProMemberBio = $rs['M_BIO'];
 $ProMemberTitle = $rs['M_TITLE'];
 $ProMemberPmHide = $rs['M_PMHIDE'];
 $ProMemberBrowse = $rs['M_BROWSE'];
 $ProMemberEditor = $rs['M_SP_EDITOR'];

 }

echo'
<script>
 function submitdetails()
{

if(detailsinfo.user_age.value.length == 1)
	{
	confirm("'.$lang['profile']['ecessary_to_insert_more_twelve_years'].'");
	return;
	}

if(detailsinfo.user_age.value.length > 2)
	{
	confirm("'.$lang['profile']['necessary_to_insert_less_ninety_nine_years'].'");
	return;
	}


detailsinfo.submit();
}
</script>';

echo'<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td><center><font color="red" size="+2">'.$lang['profile']['edit_your_details'].'</font><br>'.$lang['profile']['please_update_your_details'].'<br>&nbsp;
            <form name="detailsinfo" method="post" action="index.php?mode=profile&type=insert_details">
			<table cellSpacing="1" cellPadding="4" bgColor="gray" border="0">
				<tr class="fixed">
					<td class="optionheader" id="row_user_city"><nobr>'.$lang['profile']['the_city'].'</nobr></td>
					<td class="list"><input onchange="check_changes(row_user_city, \''.$ProMemberCity.'\', this.value)" class="insidetitle" style="WIDTH: 200px" value="'.$ProMemberCity.'" name="user_city"></td>
					<td class="optionheader" id="row_user_state"><nobr>'.$lang['profile']['the_state'].'</nobr></td>
					<td class="list"><input onchange="check_changes(row_user_state, \''.$ProMemberState.'\', this.value)" class="insidetitle" style="WIDTH: 200px" value="'.$ProMemberState.'" name="user_state"></td>				</tr>
				<tr class="fixed">
					<td class="optionheader" id="row_user_country">'.$lang['profile']['the_country'].' </td>
					<td>
					<select onchange="check_changes(row_user_country, \''.$ProMemberCountry.'\', this.value)" class="insidetitle" style="WIDTH: 200px" name="user_country" type="text">';
                    $selected = $ProMemberCountry;
                    include("country.php");
					echo'</select></td>
					<td class="optionheader" id="row_user_occupation"><nobr>'.$lang['profile']['the_occupation'].'</nobr></td>
					<td class="list"><input onchange="check_changes(row_user_occupation, \''.$ProMemberOccupation.'\', this.value)" class="insidetitle" style="WIDTH: 200px" value="'.$ProMemberOccupation.'" name="user_occupation"></td>
				</tr>
				<tr class="fixed">
					<td class="optionheader" id="row_user_marstatus"><nobr>'.$lang['profile']['the_sociability_status'].' </nobr></td>
					<td class="list"><input onchange="check_changes(row_user_marstatus, \''.$ProMemberMarStatus.'\', this.value)" class="insidetitle" style="WIDTH: 200px" value="'.$ProMemberMarStatus.'" name="user_marstatus"></td>
					<td class="optionheader" id="row_user_age"><nobr>'.$lang['profile']['the_age'].'</nobr></td>

		</td>';
					echo'
					<td>
					<select onchange="check_changes(row_user_age, \''.$ProMemberAge.'\', this.value)" class="insidetitle" style="WIDTH: 200px" name="user_age" type="text">';
                    $selected = $ProMemberAge;
                    include("age.php");
					echo'</select></td>

				
				<tr class="fixed">
					<td class="optionheader" id="row_user_gender">'.$lang['profile']['the_sex'].' </td>
					<td class="list" colSpan="3">
					<input onchange="check_changes(row_user_gender, \''.$ProMemberSex.'\', this.value)" class="small" type="radio" value="0" name="user_gender" '.check_radio($ProMemberSex, "0").'>'.$lang['profile']['no_selected'].'&nbsp;&nbsp;&nbsp;
					<input onchange="check_changes(row_user_gender, \''.$ProMemberSex.'\', this.value)" class="small" type="radio" value="1" name="user_gender" '.check_radio($ProMemberSex, "1").'>'.$lang['profile']['male'].'&nbsp;&nbsp;&nbsp;
					<input onchange="check_changes(row_user_gender, \''.$ProMemberSex.'\', this.value)" class="small" type="radio" value="2" name="user_gender" '.check_radio($ProMemberSex, "2").'>'.$lang['profile']['female'].'
					</td>
				</tr>
    				<tr class="fixed">
					<td class="optionheader" id="row_user_editor">نوع المحرر المستخدم : </td>
					<td class="list"><input onchange="check_changes(row_user_editor, \''.$ProMemberEditor.'\', this.value)" class="small" type="radio" value="1" name="user_editor" '.check_radio($ProMemberEditor, "1").'>المحرر البسيط</td>
					<td class="list" colSpan="2"><input onchange="check_changes(row_user_editor, \''.$ProMemberEditor.'\', this.value)" class="small" type="radio" value="0" name="user_editor" '.check_radio($ProMemberEditor, "0").'>المحرر المتقدم</td>
					</td>
				</tr>

				<tr class="fixed">
					<td class="optionheader" id="row_user_hideemail">'.$lang['profile']['the_email'].' </td>
					<td class="list"><input onchange="check_changes(row_user_hideemail, \''.$ProMemberReceiveEmail.'\', this.value)" class="small" type="radio" value="0" name="user_hideemail" '.check_radio($ProMemberReceiveEmail, "0").'>'.$lang['profile']['the_member_not_allowed_to_send_email'].'</td>
					<td class="list" colSpan="2"><input onchange="check_changes(row_user_hideemail, \''.$ProMemberReceiveEmail.'\', this.value)" class="small" type="radio" value="1" name="user_hideemail" '.check_radio($ProMemberReceiveEmail, "1").'>'.$lang['profile']['the_member_allowed_to_send_email'].'</td>
				</tr>
				<tr class="fixed">
					<td class="optionheader" id="row_user_allowmsgs">'.$lang['profile']['private_message'].' </td>
					<td class="list"><input onchange="check_changes(row_user_allowmsgs, \''.$ProMemberPmHide.'\', this.value)" class="small" type="radio" value="0" name="user_pmhide" '.check_radio($ProMemberPmHide, "0").'>'.$lang['profile']['the_member_not_allowed_to_send_pm'].'</td>
					<td class="list" colSpan="2"><input onchange="check_changes(row_user_allowmsgs, \''.$ProMemberPmHide.'\', this.value)" class="small" type="radio" value="1" name="user_pmhide" '.check_radio($ProMemberPmHide, "1").'>'.$lang['profile']['the_member_allowed_to_send_pm'].'</td>
				</tr>
				<tr class="fixed">
					<td class="optionheader" id="row_user_hideactivity">'.$lang['profile']['your_browse'].' </td>
					<td class="list"><input onchange="check_changes(row_user_hideactivity, \''.$ProMemberBrowse.'\', this.value)" class="small" type="radio" value="1" name="user_hideactivity" '.check_radio($ProMemberBrowse, "1").'>'.$lang['profile']['your_browse_show'].'</td>
					<td class="list" colSpan="2"><input onchange="check_changes(row_user_hideactivity, \''.$ProMemberBrowse.'\', this.value)" class="small" type="radio" value="0" name="user_hideactivity" '.check_radio($ProMemberBrowse, "0").'>'.$lang['profile']['your_browse_hide'].'</td>
				</tr>';

            if($Mlevel > 1){
                echo'
				<tr class="fixed">
					<td class="optionheader" id="row_user_title"><nobr>'.$lang['profile']['your_title'].' </nobr></td>
					<td class="list" align="right" colSpan="3"><input onchange="check_changes(row_user_title, \''.$ProMemberTitle.'\', this.value)" class="insidetitle" style="WIDTH: 100%" value="'.$ProMemberTitle.'" name="user_title"></td>
				</tr>';
            }
                echo'
				<tr class="fixed">
					<td class="optionheader" id="row_user_photo_url"><nobr>'.$lang['profile']['your_single_photo'].' </nobr></td>
					<td class="list" dir="ltr" align="right" colSpan="3"><input onchange="check_changes(row_user_photo_url, \''.$ProMemberPhotoURL.'\', this.value)"  class="insidetitle" style="WIDTH: 100%" value="'.$ProMemberPhotoURL.'" name="user_photo_url"></td>
				</tr>
				<tr class="fixed">
					<td class="optionheader" id="row_user_bio">'.$lang['profile']['your_biography'].' </td>
					<td class="list" colSpan="3"><textarea onchange="check_changes(row_user_bio, \''.$ProMemberBio.'\', this.value)" class="insidetitle" style="WIDTH: 100%; HEIGHT: 70px" name="user_bio" type="text" rows="1" cols="20">'.$ProMemberBio.'</textarea></td>
				</tr>
				<tr class="fixed">
					<td class="list_center" colSpan="5"><input onclick="submitdetails()" type="button" value="'.$lang['profile']['insert_info'].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['profile']['reset_info'].'"></td>
				</tr>
			</table>
			</form>
		</center></td>
	</tr>
</table>
</center><div style="color:red;text-align:center;font-size:10pt;font-family:tahoma">ملاحظة: الخيارات التي تم تغييرها تظهر باللون الأحمر</div>';

    }
    else {
    redirect();
    }

}



if($type == "insert_details"){

    if($DBMemberID > 0){


$user_country = HtmlSpecialchars($_POST["user_country"]);
$user_city = HtmlSpecialchars($_POST["user_city"]);
$user_state = HtmlSpecialchars($_POST["user_state"]);
$user_age = HtmlSpecialchars($_POST["user_age"]);
$user_gender = HtmlSpecialchars($_POST["user_gender"]);
$user_photo_url = HtmlSpecialchars($_POST["user_photo_url"]);
$user_marstatus = HtmlSpecialchars($_POST["user_marstatus"]);
$user_hideemail = HtmlSpecialchars($_POST["user_hideemail"]);
$user_bio = HtmlSpecialchars($_POST["user_bio"]);
$user_occupation = HtmlSpecialchars($_POST["user_occupation"]);
$user_title = $_POST["user_title"];
$user_pmhide = HtmlSpecialchars($_POST["user_pmhide"]);
$user_browse = HtmlSpecialchars($_POST["user_hideactivity"]);
$user_editor = HtmlSpecialchars($_POST["user_editor"]);



if($error == ""){
		$query = "UPDATE {$mysql->prefix}MEMBERS SET ";
        $query .= "M_COUNTRY = ('$user_country'), ";
        $query .= "M_CITY = ('$user_city'), ";
        $query .= "M_STATE = ('$user_state'), ";
        $query .= "M_AGE = ('$user_age'), ";
        $query .= "M_SEX = ('$user_gender'), ";
        $query .= "M_SP_EDITOR= ('$user_editor'), ";
        $query .= "M_PHOTO_URL = ('$user_photo_url'), ";
        $query .= "M_MARSTATUS = ('$user_marstatus'), ";
        $query .= "M_RECEIVE_EMAIL = ('$user_hideemail'), ";
        $query .= "M_BIO = ('$user_bio'), ";
        $query .= "M_OCCUPATION = ('$user_occupation'), ";
        $query .= "M_PMHIDE = ('$user_pmhide'), ";
        $query .= "M_BROWSE = ('$user_browse'), ";
        $query .= "M_TITLE = ('$user_title') ";
        $query .= "WHERE MEMBER_ID = ".$DBMemberID." ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
  
                    echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['profile']['your_details_has_edited'].'</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=index.php?mode=profile&type=details">
                           <a href="index.php?mode=profile&type=details">'.$lang['profile']['click_here_to_go_normal_page'].'</a><br>
	                       <br></td>
	                   </tr>
	                </table>
	                </center>';
}


    }
    else {
    redirect();
    }

}
if($type == "ihsaa"){
if($Mlevel ==  4){
					 require_once("details.php");

}
}


if($type == "edit_pass"){

if(members("PASS", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][pass].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}

    if($DBMemberID > 0){
 $query = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = ".$DBMemberID." ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($result) > 0){
 $rs=mysql_fetch_array($result);

 $ProMemberID = $rs['MEMBER_ID'];
 $ProMemberName = $rs['M_NAME'];
 $ProMemberEmail = $rs['M_EMAIL'];
 $ProMemberPassword = $rs['M_PASSWORD'];

 }


echo'
<script>

 function submitpass()
{


if(passinfo.user_password0.value.length != 0)
{

if(passinfo.user_password1.value.length == 0)
    {
	confirm("'.$lang['register_js']['necessary_to_insert_password'].'");
	return;
    }

if(passinfo.user_password1.value.length != 0)
{
    if(passinfo.user_password1.value.length < 6)
	{
	confirm("'.$lang['register_js']['necessary_to_insert_more_five_letter_to_password'].'");
	return;
	}
}

if(passinfo.user_password1.value.length > 24)
	{
	confirm("'.$lang['register_js']['necessary_to_insert_less_twenty_four_letter_to_password'].'");
	return;
	}

if(passinfo.user_password1.value.length != 0)
{
    if(passinfo.user_password2.value.length < 6)
	{
	confirm("'.$lang['register_js']['necessary_to_insert_confirm_password'].'");
	return;
	}
}

if(passinfo.user_password1.value  != passinfo.user_password2.value)
	{
	confirm("'.$lang['register_js']['necessary_to_insert_true_confirm_password'].'");
	return;
	}

if(passinfo.user_password1.value  == passinfo.user_name.value)
	{
	confirm("'.$lang['register_js']['necessary_to_password_reversal_to_user_name'].'");
	return;
	}

if(passinfo.user_password1.value.toLowerCase()  == passinfo.user_name.value.toLowerCase())
	{
	confirm("'.$lang['register_js']['necessary_to_password_reversal_to_user_name'].'");
	return;
	}

if(passinfo.user_password1.value.toLowerCase()  == passinfo.user_email.value.toLowerCase())
	{
	confirm("'.$lang['register_js']['necessary_to_password_reversal_to_email'].'");
	return;
	}
}

if(passinfo.user_email.value.length == 0)
	{
	confirm("'.$lang['register_js']['necessary_to_insert_email'].'");
	return;
	}

if(!/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/.test(passinfo.user_email.value))
	{
	confirm("'.$lang['register_js']['necessary_to_insert_true_email'].'");
	return;
	}

passinfo.submit();
}
</script>';


echo'
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td><center><font color="red" size="+2">'.$lang['profile']['edit_your_details'].'</font><br>'.$lang['profile']['please_update_your_details'].'<br>&nbsp;
            <form name="passinfo" method="post" action="index.php?mode=profile&type=insert_pass">
            <input value="'.$ProMemberName.'" type="hidden" name="user_name">
            <input value="'.$ProMemberPassword.'" type="hidden" name="user_password">
			<table cellSpacing="1" cellPadding="4" bgColor="gray" border="0">
				<tr class="fixed">
					<td class="optionheader" id="row_user_password0"><nobr>'.$lang['profile']['your_password_to_use_now'].' </nobr></td>
					<td class="list" dir="ltr" align="right" colSpan="3"><input onchange="check_changes(row_user_password0, \'\', this.value)" class="insidetitle" style="WIDTH: 100%" type="password" name="user_password0"></td>
				</tr>
				<tr class="fixed">
					<td class="optionheader" id="row_user_email"><nobr>'.$lang['profile']['the_email'].' </nobr></td>
					<td class="list" dir="ltr" align="right" colSpan="3"><input onchange="check_changes(row_user_email, \''.$ProMemberEmail.'\', this.value)" class="insidetitle" style="WIDTH: 100%" value="'.$ProMemberEmail.'" name="user_email"></td>
				</tr>
				<tr class="fixed">
					<td class="optionheader" id="row_user_password1"><nobr>'.$lang['profile']['the_new_password'].' </nobr></td>
					<td class="list"><input onchange="check_changes(row_user_password1, \'\', this.value)" class="insidetitle" style="WIDTH: 200px" type="password" name="user_password1"></td>
					<td class="optionheader" id="row_user_password2"><nobr>'.$lang['profile']['the_confirm_new_password'].' </nobr></td>
					<td class="list"><input onchange="check_changes(row_user_password2, \'\', this.value)" class="insidetitle" style="WIDTH: 200px" type="password" name="user_password2"></td>
				</tr>
				<tr class="fixed">
					<td class="list_center" colSpan="5"><input onclick="submitpass()" type="button" value="'.$lang['profile']['insert_info'].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['profile']['reset_info'].'"></td>
				</tr>
			</table>
		</form>
		</center></td>
	</tr>
</table>
</center><div style="color:red;text-align:center;font-size:10pt;font-family:tahoma">ملاحظة: الخيارات التي تم تغييرها تظهر باللون الأحمر</div>';

    }
    else {
    redirect();
    }

}


if($type == "insert_pass"){

    if($DBMemberID > 0){


$user_password = HtmlSpecialchars($_POST["user_password"]);
$user_password0 = HtmlSpecialchars($_POST["user_password0"]);
$user_password1 = HtmlSpecialchars($_POST["user_password1"]);
$user_password2 = HtmlSpecialchars($_POST["user_password2"]);
$user_email = HtmlSpecialchars($_POST["user_email"]);


$md_password0 = MD5($user_password0);

if($user_password0 != ""){
    if($user_password != $md_password0){
        $error = $lang['profile']['the_password_not_identical_to_the_confirm_password'];
    }
}

if($error != ""){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}


if($error == ""){
		$query = "UPDATE {$mysql->prefix}MEMBERS SET ";
  
    if($user_password0 != ""){
        $user_password1 = MD5($user_password1);
        $query .= "M_PASSWORD = ('$user_password1'), ";
    }
        
        $query .= "M_EMAIL = ('$user_email') ";
        $query .= "WHERE MEMBER_ID = ".$DBMemberID." ";
        $mysql->execute($query, $connection, [], __FILE__, __LINE__);

         $_SESSION['new_pass'] = true;

                    echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['profile']['your_details_has_edited'].'</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=index.php?mode=profile&type=details">
                           <a href="index.php?mode=profile&type=details">'.$lang['profile']['click_here_to_go_normal_page'].'</a><br>
                           <a href="index.php">'.$lang['profile']['click_here_to_go_home'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}


    }
    else {
    redirect();
    }

}


if($type == "edit_user"){
 if($Mlevel == 4){

 $query = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$ppMemberID."' ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($result) > 0){
 $rs=mysql_fetch_array($result);

 $ProMemberID = $rs['MEMBER_ID'];
 $ProMemberName = $rs['M_NAME'];
 $ProMemberLevel = $rs['M_LEVEL'];
 $ProMemberEmail = $rs['M_EMAIL'];
 $ProMemberReceiveEmail = $rs['M_RECEIVE_EMAIL'];
 $ProMemberIP = $rs['M_IP'];
 $ProMemberLastIP = $rs['M_LAST_IP'];
 $ProMemberCountry = $rs['M_COUNTRY'];
 $ProMemberCity = $rs['M_CITY'];
 $ProMemberPosts = $rs['M_POSTS'];
 $ProMemberState = $rs['M_STATE'];
 $ProMemberOccupation = $rs['M_OCCUPATION'];
 $ProMemberAge = $rs['M_AGE'];
 $ProMemberSex = $rs['M_SEX'];
 $ProMemberPhotoURL = $rs['M_PHOTO_URL'];
 $ProMemberMarStatus = $rs['M_MARSTATUS'];
 $ProMemberBio = $rs['M_BIO'];
 $ProMemberTitle = $rs['M_TITLE'];
 $ProMemberOldMod = $rs['M_OLD_MOD'];
 $ProMemberLastApp = $rs['M_LAST_APP'];
 $ProMemberSig = $rs['M_SIG'];
 $ProMemberPmHide = $rs['M_PMHIDE'];
 $ProMemberLogin = $rs['M_ADMIN'];

 }

echo '
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<table class="optionsbar" cellSpacing="2" width="100%" border="0">
			<tr>
				<td vAlign="center"></td>
				<td class="optionsbar_title" vAlign="center" width="100%">'.$lang['profile']['edit_member_details'].' '.$ProMemberName.'</td>';
            go_to_forum();
            echo'
            </tr>
		</table>
		</td>
	</tr>
</table>
</center>
<br>';


echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="60%">
<form method="post" action="index.php?mode=profile&type=edit_user_add">
<input type="hidden" name="user_id" value="'.$ppMemberID.'">
<input type="hidden" name="user_old_level" value="'.$ProMemberLevel.'">
<input type="hidden" name="user_old_mod" value="'.$ProMemberOldMod.'">

	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['member_name'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="user_name" size="40" value="'.$ProMemberName.'"></td>
	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['member_password'].'</nobr></td>
		<td class="userdetails_data"><input type="password" name="user_password" size="40"></td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_email'].'</nobr></td>
		<td class="userdetails_data"><input type="text" dir="ltr" name="user_email" size="40" value="'.$ProMemberEmail.'"></td>
	</tr>';
if($ppMemberID > 1){
echo'	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_rank'].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_level" '.check_radio($ProMemberLevel, "1").'>'.$lang['profile']['member'].'&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="2" name="user_level" '.check_radio($ProMemberLevel, "2").'>'.$lang['profile']['moderator'].'&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="3" name="user_level" '.check_radio($ProMemberLevel, "3").'>'.$lang['profile']['monitor'].'&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="4" name="user_level" '.check_radio($ProMemberLevel, "4").'>'.$lang['profile']['admin'].'
        </td>
	</tr>';
}
if($DBMemberID == 1 AND $ppMemberID > 1 AND $ProMemberLevel == 4){
echo'	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['login_admin'].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_login" '.check_radio($ProMemberLogin , "1").'>'.$lang['profile']['login_admin_yes'].'&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="0" name="user_login" '.check_radio($ProMemberLogin , "0").'>'.$lang['profile']['login_admin_no'].'&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
	</tr>';
}
echo'	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_sex'].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_sex" '.check_radio($ProMemberSex, "0").'>'.$lang['profile']['no_selected'].'&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="1" name="user_sex" '.check_radio($ProMemberSex, "1").'>'.$lang['profile']['male'].'&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="radio" type="radio" value="2" name="user_sex" '.check_radio($ProMemberSex, "2").'>'.$lang['profile']['female'].'
        </td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['private_message'].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_pmhide" '.check_radio($ProMemberPmHide, "1").'>'.$lang['profile']['the_member_allowed_to_send_pm'].'&nbsp;&nbsp;&nbsp;&nbsp;<br>
        <input class="radio" type="radio" value="0" name="user_pmhide" '.check_radio($ProMemberPmHide, "0").'>'.$lang['profile']['the_member_not_allowed_to_send_pm'].'
        </td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_email'].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_receive_email" '.check_radio($ProMemberReceiveEmail, "1").'>'.$lang['profile']['the_member_allowed_to_send_email'].'&nbsp;&nbsp;&nbsp;&nbsp;<br>
        <input class="radio" type="radio" value="0" name="user_receive_email" '.check_radio($ProMemberReceiveEmail, "0").'>'.$lang['profile']['the_member_not_allowed_to_send_email'].'
        </td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['ip_address'].'</nobr></td>
		<td class="userdetails_data">'.$ProMemberIP.'</td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['last_ip_address'].'</nobr></td>
		<td class="userdetails_data">'.$ProMemberLastIP.'</td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['number_posts'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="user_posts" size="10" value="'.$ProMemberPosts.'"></td>
	</tr>
  	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_age'].'</nobr></td>
		<td class="userdetails_data">
		<select class="insidetitle" style="WIDTH: 50px" name="user_age" type="text">';
        $selected = $ProMemberAge;
        include("age.php");
		echo'</select>
        </td>
    </tr>
  	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_country'].'</nobr></td>
		<td class="userdetails_data">
		<select class="insidetitle" style="WIDTH: 200px" name="user_country" type="text">';
        $selected = $ProMemberCountry;
        include("country.php");
		echo'</select>
        </td>
    </tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_title'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="user_title" size="40" value="'.$ProMemberTitle.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['url_in_singe_photo'].'</nobr></td>
		<td class="userdetails_data"><input type="text" dir="ltr" name="user_photo_url" size="40" value="'.$ProMemberPhotoURL.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_city'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="user_city" size="40" value="'.$ProMemberCity.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_state'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="user_state" size="40" value="'.$ProMemberState.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_sociability_status'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="user_mar_status" size="40" value="'.$ProMemberMarStatus.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_occupation'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="user_occupation" size="40" value="'.$ProMemberOccupation.'"></td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_biography'].'</nobr></td>
		<td class="userdetails_data"><textarea cols="50" rows="5" name="user_bio">'.$ProMemberBio.'</textarea></td>
	</tr>
 	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['profile']['the_signature'].'</nobr></td>
		<td class="userdetails_data"><textarea cols="50" rows="5" name="user_sig">'.$ProMemberSig.'</textarea></td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="'.$lang['profile']['insert_info'].'">&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['profile']['reset_info'].'"></td>
	</tr>
</form>
</table>
</center>';
 }
 else {
 redirect();
 }
}

if($type == "edit_user_add"){

 if($Mlevel == 4){

$ppMemberID = HtmlSpecialchars($_POST["user_id"]);
$user_name = HtmlSpecialchars($_POST["user_name"]);
if($_POST["user_password"] != ""){
$user_password = md5($_POST["user_password"]);
}
$user_email = HtmlSpecialchars($_POST["user_email"]);
if($ppMemberID > 1){
$user_level = HtmlSpecialchars($_POST["user_level"]);
$user_login = HtmlSpecialchars($_POST["user_login"]);

}
$ProMemberLevel = $_POST["user_old_level"];
$ProMemberOldMod = $_POST["user_old_mod"];
$user_sex = HtmlSpecialchars($_POST["user_sex"]);
$user_receive_email = HtmlSpecialchars($_POST["user_receive_email"]);
$user_posts = HtmlSpecialchars($_POST["user_posts"]);
$user_age = HtmlSpecialchars($_POST["user_age"]);
$user_photo_url = HtmlSpecialchars($_POST["user_photo_url"]);
$user_country = HtmlSpecialchars($_POST["user_country"]);
$user_state = HtmlSpecialchars($_POST["user_state"]);
$user_sity = HtmlSpecialchars($_POST["user_sity"]);
$user_mar_status = HtmlSpecialchars($_POST["user_mar_status"]);
$user_occupation = HtmlSpecialchars($_POST["user_occupation"]);
$user_bio = HtmlSpecialchars($_POST["user_bio"]);
$user_title = HtmlSpecialchars($_POST["user_title"]);
$user_sig = $_POST["user_sig"];
$user_pmhide = $_POST["user_pmhide"];

if($ProMemberLevel == 3 AND $user_level == 1){
$user_old_mod = 2;
}

if($ProMemberLevel == 2 AND $user_level == 1){
$user_old_mod = 1;
}

if($user_level == 2 OR $user_level == 3 AND $ProMemberOldMod == 1 OR $ProMemberOldMod == 2){
$user_old_mod = 0;
}

if($user_name == ""){
    $error = $lang['register_js']['necessary_to_insert_user_name'];
}
if($user_email == ""){
    $error = $lang['register_js']['necessary_to_insert_email'];
}

if($error != ""){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}

if($error == ""){
		$query = "UPDATE {$mysql->prefix}MEMBERS SET ";
        $query .= "M_NAME = '$user_name', ";
        if($user_password != ""){
        $query .= "M_PASSWORD = '$user_password', ";
        }
        $query .= "M_EMAIL = '$user_email', ";
if($ppMemberID > 1){
        $query .= "M_LEVEL = '$user_level', ";
}
if($ppMemberID > 1){
        $query .= "M_ADMIN= '$user_login', ";
}
        $query .= "M_SEX = '$user_sex', ";
        $query .= "M_RECEIVE_EMAIL = '$user_receive_email', ";
        $query .= "M_POSTS = '$user_posts', ";
        $query .= "M_AGE = '$user_age', ";
        $query .= "M_PHOTO_URL = '$user_photo_url', ";
        $query .= "M_COUNTRY = '$user_country', ";
        $query .= "M_STATE = '$user_state', ";
        $query .= "M_CITY = '$user_city', ";
        $query .= "M_MARSTATUS = '$user_mar_status', ";
        $query .= "M_OCCUPATION = '$user_occupation', ";
        $query .= "M_SIG = '$user_sig', ";
        $query .= "M_BIO = '$user_bio', ";
        $query .= "M_PMHIDE = '$user_pmhide', ";
        if($user_level == 1){
        $query .= "M_TITLE = '', ";
        }
        else {
        $query .= "M_TITLE = '$user_title', ";
        }
        $query .= "M_OLD_MOD = '$user_old_mod' ";
        $query .= "WHERE MEMBER_ID = '$ppMemberID' ";
        
        $mysql->execute($query, $connection, [], __FILE__, __LINE__);
        
                    echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['profile']['your_details_has_edited'].'</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=index.php?mode=profile&id='.$ppMemberID.'">
                           <a href="index.php?mode=profile&id='.$ppMemberID.'">'.$lang['profile']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}


    }
    else {
    redirect();
    }

}

}	// (members("STATUS", $id) == 1 OR $Mlevel > 1 OR members("NAME", $id) != "")
else {
echo'
<center>
<table width="99%" border="1">
	<tr class="normal">
		<td class="list_center" colspan="10">
		<br><br><font size="+2">العضو المطلوب غير متوفر.</font>
		<br><br>قد يكون هناك عدة أسباب لهذا منها:<br><br>
		<table>
			<tr>
				<td>* رقم العضو المطلوب غير صحيح. </td>
			</tr>
			<tr>
				<td>* العضو لم يتم تشغيل عضويته للآن. </td>
			</tr>
			<tr>
				<td>* العضو قد تم إخفاء بياناته الشخصية. </td>
			</tr>
			<tr>
				<td>* العضو قد تم ازالته من المنتديات. </td>
			</tr>
		</table>
		<br></td>
	</tr>
</table>
</center>';
}

if($type == "medals"){
if(members("MEDALS", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][medals].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();

}
	if($Mlevel > 0){
		echo'
		<script language="javascript">
			function choose_medal(id){
				document.m_info.mem_id.value = id;
				document.m_info.submit();
			}
			function remove_medal(){
				document.m_info.mem_id.value = "remove";
				document.m_info.submit();
			}
		</script>
		<form name="m_info" method="post" action="index.php?mode=profile&type=medals">
		<input type="hidden" name="mem_id">
		</form>
		<center>
		<table cellSpacing="2" width="100%" border="0">
			<tr>
				<td class="optionsbar_menus" width="99%">&nbsp;<nobr><font color="red" size="+1">خدمات العضوية</font></nobr></td>';
				echo multi_page("MEDALS WHERE MEMBER_ID = '$DBMemberID' AND STATUS = '1' ", $max_page);
				go_to_forum();
			echo'
			</tr>
		</table><br>';
		$mem_id = $_POST[mem_id];
		if(!empty($mem_id)){
			if($mem_id == "remove"){
				$mysql->execute("UPDATE {$mysql->prefix}MEMBERS SET M_MEDAL = '0' WHERE MEMBER_ID = '$DBMemberID' ", [], __FILE__, __LINE__);
				echo'<p align="center"><font size="+1" color="red">تم إزالة وسامك الحالي بنجاح.</font></p>';
			}
			else{
				$mysql->execute("UPDATE {$mysql->prefix}MEMBERS SET M_MEDAL = '$mem_id' WHERE MEMBER_ID = '$DBMemberID' ", [], __FILE__, __LINE__);
				echo'<p align="center"><font size="+1" color="red">تم تغيير وسامك الحالي بنجاح.</font></p>';
			}
		}
		echo'
		<table cellSpacing="1" cellPadding="2">
			<tr>
				<td class="optionsbar_menus" colSpan="10"><font color="red" size="+1">أوسمة التميز الممنوحة لك</font></td>
			</tr>
			<tr>
				<td class="stats_h"><nobr>التاريخ</nobr></td>
				<td class="stats_h"><nobr>يعرض حتى</nobr></td>
				<td class="stats_h"><nobr>الوسام الممنوح</nobr></td>
				<td class="stats_h">مشاهدة<br>الصورة</td>
				<td class="stats_h"><nobr>المنتدى</nobr></td>';
			if(mlv > 1){
				echo'
				<td class="stats_h"><nobr>منح الوسام</nobr></td>';
			}
				echo'
				<td class="stats_h"><nobr>خيارات</nobr></td>
			</tr>';
		$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEDALS WHERE MEMBER_ID = '$DBMemberID' AND STATUS = '1' ORDER BY DATE DESC LIMIT ".pg_limit($max_page).", $max_page", [], __FILE__, __LINE__);
		$num = mysql_num_rows($sql);
		$x = 0;
		while ($x < $num){
			$m = mysql_result($sql, $x, "MEDAL_ID");
			$gm_id = medals("GM_ID", $m);
			$subject = gm("SUBJECT", $gm_id);
			$date = medals("DATE", $m);
			$days = medals("DAYS", $m);
			$url = medals("URL", $m);
			$f = medals("FORUM_ID", $m);
			$added = medals("ADDED", $m);
			$add_days = $days*60*60*24;
			$add_days = $add_days + $date;
			echo'
			<tr>
				<td class="stats_p" align="middle"><font color="red">'.normal_date($date).'</font></td>
				<td class="stats_p" align="middle"><font color="black">'.days_added($days, $date).'</font></td>
				<td class="stats_g"><font size="-1">'.$subject.'</font></td>
				<td class="stats_p" align="middle"><a target="plaquepreview" href="'.$url.'">'.icons($icon_camera).'</a></td>
				<td class="stats_p"><font color="red">'.forums("SUBJECT", $f).'</font></td>';
			if($Mlevel > 1){
				echo'
				<td class="stats_g"><nobr><a href="index.php?mode=profile&id='.$added.'"><font color="#ffffff">'.members("NAME", $added).'</font></a></nobr></td>';
			}
				echo'
				<td class="stats_h" align="middle">';
				if($add_days > time()){
					echo'
					<a href="javascript:choose_medal('.$m.')">'.icons($icon_profile, "إستخدم هذا الوسام كوسامك الحالي", " hspace=\"3\"").'</a>';
				}
				echo'
				</td>
			</tr>';
			$count = $count + 1;
		++$x;
		}
		if($count == 0){
			echo'
			<tr>
				<td class="stats_h" colSpan="10" align="center"><br><font size="3">أنت لا تملك أي وسام</font><br><br></td>
			</tr>';
		}
		else{
			echo'
			<tr>
				<td class="optionsbar_menus" colSpan="10"><font size="3"><a href="javascript:remove_medal()">- إضغط هنا لإزالة وسامك الحالي من العرض تحت إسمك في مشاركاتك - </a></font></td>
			</tr>';
		}
		echo'
		</table>
		</center><br>';
	}
	else {
		redirect();
	}
}
?>