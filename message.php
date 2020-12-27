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

require_once("./include/pm_func.df.php");


if($Mlevel > 0){

$HTTP_HOST = $_SERVER['HTTP_HOST'];

$forum_new_pm = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}PM WHERE PM_MID = '$m' AND PM_OUT = '0' AND PM_READ = '0' AND PM_STATUS = '1' ", [], __FILE__, __LINE__);
$new_pm_count = mysql_result($forum_new_pm, 0, "count(*)");

if($m != "" AND $m < 0 AND $Mlevel == 4 OR chk_monitor($DBMemberID, $c) OR chk_moderator($DBMemberID, abs($m))){
    $DBMemberID = $m;
    $forum_id = '&m='.$m.'&c='.$c;
    $privat_text = '<font color="green">'.forum_name(abs($m)).'</font>';
    $NewPm = $new_pm_count;
}
else {
    $forum_id = '';
    $privat_text = $lang['message']['private_message'];
}



if(!isset($_GET['pg']))
{
$pag = 1;
}
else
{
$pag = $_GET['pg'];
}

$start = (($pag * $max_page) - $max_page);
if($mail == "new"){
$where = "WHERE PM_MID = '$DBMemberID' AND PM_READ = '0' AND PM_OUT = '0' AND PM_STATUS = '1'";
}
if($mail == "in"){
$where = "WHERE PM_MID = '$DBMemberID' AND PM_OUT = '0' AND PM_STATUS = '1'";
}
if($mail == "out"){
$where = "WHERE PM_MID = '$DBMemberID' AND PM_OUT = '1' AND PM_STATUS = '1'";
}
if($mail == "trash"){
$where = "WHERE PM_MID = '$DBMemberID' AND PM_STATUS = '0'";
}
if($mail == "show"){
$where = "WHERE PM_MID = '$id' AND PM_STATUS = '0' OR PM_FROM = '$id'  AND PM_STATUS = '0'  ";
}
if($mail == "m"){
$where = "WHERE PM_MID = '$DBMemberID' AND PM_STATUS = '0'";
}
$total_res = mysql_result($mysql->execute("SELECT COUNT(PM_ID) FROM {$mysql->prefix}PM ".$where." "),0);
$total_col = ceil($total_res / $max_page);

if($pg == "p"){

$pg = $_POST["numpg"];

echo'<script language="JavaScript" type="text/javascript">
 window.location = "index.php?mode=pm&mail='.$mail.'&pg='.$pg.$forum_id.'";
 </script>';
}

$message_page = $lang['message']['page'];
$message_from = $lang['message']['from'];

function paging($total_col, $pag){

        global $mail, $message_page, $message_from;
		echo '
        <form method="post" action="index.php?mode=pm&mail='.$mail.$forum_id.'&pg=p">
        <td class="optionsbar_menus">

		<b>'.$message_page.' :</b>
        <select name="numpg" size="1" onchange="submit();">';


        for($i = 1; $i <= $total_col; $i++){
            if(($pag) == $i){
		        echo '<option selected value="'.$i.'">'.$i.' '.$message_from.' '.$total_col.'</option>';
            }
            else {
		        echo '<option value="'.$i.'">'.$i.' '.$message_from.' '.$total_col.'</option>';
            }
        }

		echo '
        </select>

		</td>
		</form>';

}
echo'
<script language="javascript">
    function submitQuickReplyForm(){
        var x = quickreply.message.value;

        while ((x.substring(0,1) == " ") || (x.substring(0,1) == "\r") || (x.substring(0,1) == "\n") || (x.substring(0,1) == "\t"))
            x = x.substring(1);
        quickreply.message.value = x;

        if(quickreply.message.value.length < 3) return;
        quickreply.submit();
    }
    function submit_delete(){
        var where_to = confirm("'.$lang['message']['you_are_sure_to_delete_this_message'].'");
	    if(where_to== false){
            return;
	    }
        deletemsg.submit();
    }
</script>';


if($mail == "new"){
 $title_mail = $lang['message']['in_mail_new'];
}
if($mail == "in"){
 $title_mail = $lang['message']['in_mail'];
}
if($mail == "out"){
 $title_mail = $lang['message']['out_mail'];
}
if($mail == "trash"){
 $title_mail = $lang['message']['trash_folder'];
}
if($mail == "show" AND mlv == 4 OR $mail == "show" AND  mlv == 3 AND $CAN_SHOW_PM){
 $title_mail = "مراقبة رسائل العضو : ".member_name($id);
}

 $PM_OUT = $mysql->execute("SELECT * FROM {$mysql->prefix}PM WHERE PM_ID = '$msg' AND PM_MID = '$DBMemberID' ", [], __FILE__, __LINE__);

 if(mysql_num_rows($PM_OUT) > 0){

 $rs_OUT = mysql_fetch_array($PM_OUT);

 $OUT_PmID = $rs_OUT['PM_ID'];
 $OUT_Out = $rs_OUT['PM_OUT'];
 }


echo '
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<table cellSpacing="2" width="100%" border="0">
			<tr>
                <td><a class="menu" href="index.php?mode=pm&mail='.$mail.$forum_id.'">'.icons($monitor, $lang['message']['private_message'], "").'</a></td>
				<td class="main" vAlign="center" width="100%"><a class="menu" href="index.php?mode=pm&mail='.$mail.$forum_id.'"><font color="red" size="+1">'.$privat_text.'</font></a><font color="red" size="+1"><br><font size="-1">'.$title_mail.'</font></font></td>';
if($mail == "msg" AND $OUT_Out != 1){
                echo'
				<td class="optionsbar_menus"><nobr><a href="index.php?mode=editor&method=replymsg&msg='.$msg.$forum_id.'">'.icons($icon_reply_topic, $lang['message']['reply_to_pm'], "").'<br>'.$lang['message']['reply_to_pm'].'</a></nobr></td>';
}
if($mail == "msg"){
                echo'
				<td class="optionsbar_menus"><nobr><a href="index.php?mode=delete&type=pm&msg='.$msg.$forum_id.'">'.icons($icon_trash, $lang['message']['move_pm_to_trash_folder'], "").'<br>'.$lang['message']['delete_pm'].'</a></nobr></td>';
}

                echo'
				<td class="optionsbar_menus"><nobr><a href="index.php?mode=sendmsg'.$forum_id.'">'.icons($folder_new, $lang['message']['new_pm'], "").'<br>'.$lang['message']['new_pm'].'</a></nobr></td>';
if($mail == "new" OR $mail == "in" OR $mail == "out" OR $mail == "trash" OR $mail == "m"){
    if($total_res > 0){
                paging($total_col, $pag);
    }
}
                go_to_forum();
                echo'
			</tr>
		</table>
		<table>
			<tr>';
        if($NewPm > 0){
                echo'
				<td class="'.class_dis("new", $mail).'"><nobr><a href="index.php?mode=pm&mail=new'.$forum_id.'">'.$lang['message']['in_mail_new'].'&nbsp;&nbsp;['.$NewPm.']</a></nobr></td>';
        }
                echo'
				<td class="'.class_dis("in", $mail).'"><nobr><a href="index.php?mode=pm&mail=in'.$forum_id.'">'.$lang['message']['in_mail'].'</a></nobr></td>
				<td class="'.class_dis("out", $mail).'"><nobr><a href="index.php?mode=pm&mail=out'.$forum_id.'">'.$lang['message']['out_mail'].'</a></nobr></td>
				<td class="'.class_dis("trash", $mail).'"><nobr><a href="index.php?mode=pm&mail=trash'.$forum_id.'">'.$lang['message']['trash_folder'].'</a></nobr></td>


			</tr>
		</table>';
//#################### new message #########################
if($mail == "new"){

        echo'
		<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
        <form name="check" method="post" action="index.php?mode=delete&method=remove&type=pm'.$forum_id.'">
			<tr>
				<td>
				<table cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<td class="cat" colSpan="2">&nbsp;</td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['date'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['from'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['to'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['pm_address'].'&nbsp;</nobr></td>
                        <td class="cat"><nobr>&nbsp;'.$lang['message']['pm_size'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;</nobr></td>';


	$NEW_PM = $mysql->execute("SELECT * FROM {$mysql->prefix}PM WHERE PM_MID = '$DBMemberID' AND PM_READ = '0' AND PM_OUT = '0' AND PM_STATUS = '1' ORDER BY PM_DATE DESC LIMIT $start, $max_page ", [], __FILE__, __LINE__);
    $num = mysql_num_rows($NEW_PM);

if($num == 0){
    echo'
    <tr class="normal">
		<td class="list_center" vAlign="center" colspan="10"><br>'.$lang['message']['non_pm'].'<br><br></td>
    </tr>';
}


$i=0;
while ($i < $num){

    $NEW_PmID = mysql_result($NEW_PM, $i, "PM_ID");
    $NEW_Status = mysql_result($NEW_PM, $i, "PM_STATUS");
    $NEW_To = mysql_result($NEW_PM, $i, "PM_TO");
    $NEW_From = mysql_result($NEW_PM, $i, "PM_FROM");
    $NEW_Read = mysql_result($NEW_PM, $i, "PM_READ");
    $NEW_Reply = mysql_result($NEW_PM, $i, "PM_REPLY");
    $NEW_Subject = mysql_result($NEW_PM, $i, "PM_SUBJECT");
    $NEW_Message = mysql_result($NEW_PM, $i, "PM_MESSAGE");
    $NEW_Date = mysql_result($NEW_PM, $i, "PM_DATE");
	if($Mlevel > 1){
		$show_msg = '<br><font color="gray" size="2">'.strip_tags(substr($NEW_Message, 0, 100)).'</font>';


		$show_msg = '';
	}

  if($NEW_From > 0){
    $MEMBER_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$NEW_From' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_FROM) > 0){
    $rsMF=mysql_fetch_array($MEMBER_FROM);
    $MF_MemberID = $rsMF['MEMBER_ID'];
    $MF_MemberName = $rsMF['M_NAME'];
    }
    $FromName = link_profile($MF_MemberName, $MF_MemberID);
  }
  if($NEW_From < 0){
    $f_id = abs($NEW_From);
    $FORUM_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_FROM) > 0){
    $rsFF=mysql_fetch_array($FORUM_FROM);
    $FF_ForumID = $rsFF['FORUM_ID'];
    $FF_ForumSubject = $rsFF['F_SUBJECT'];
    }
    $FromName = $lang['message']['moderate'].' '.$FF_ForumSubject;
  }

  if($NEW_To > 0){
    $MEMBER_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$NEW_To' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_TO) > 0){
    $rsMT=mysql_fetch_array($MEMBER_TO);
    $MT_MemberID = $rsMT['MEMBER_ID'];
    $MT_MemberName = $rsMT['M_NAME'];
    }
    $ToName = link_profile($MT_MemberName, $MT_MemberID);
  }
  if($NEW_To < 0){
    $f_id = abs($NEW_To);
    $FORUM_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_TO) > 0){
    $rsFT=mysql_fetch_array($FORUM_TO);
    $FT_ForumID = $rsFT['FORUM_ID'];
    $FT_ForumSubject = $rsFT['F_SUBJECT'];
    }
    $ToName = $lang['message']['moderate'].' '.$FT_ForumSubject;
  }

 if($NEW_Reply == 0 OR $NEW_Reply == 2){
     $reply_icon = '';
 }
 else {
     $reply_icon = icons($icon_reply_topic, $lang['message']['this_pm_is_reply_to_last_pm'], "").'&nbsp;';
 }
                    echo'
					</tr>
						<tr class="fixed">
						<td class="list_center"><nobr>&nbsp;<input class="small" type="checkbox" name="remove[]" value="'.$NEW_PmID.'"></nobr></td>
						<td class="list_center"><nobr>&nbsp;<a href="index.php?mode=pm&mail=msg&msg='.$NEW_PmID.$forum_id.'">'.icons($icon, $lang['message']['new_pm'], "").'</a>&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;<font color="green">'.normal_time($NEW_Date).'</font>&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;'.$FromName.'&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;'.$ToName.'&nbsp;</nobr></td>
						<td class="list" width="90%"><nobr><a href="index.php?mode=pm&mail=msg&msg='.$NEW_PmID.$forum_id.'">'.$reply_icon.$NEW_Subject.$show_msg.'</a></nobr></td>
                        <td class="list_small">'.strlen($NEW_Message).'</td>
						<td class="list_small"><nobr>&nbsp;<a href="index.php?mode=editor&method=replymsg&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_reply_topic, $lang['message']['reply_to_pm'], "").'</a>&nbsp;&nbsp;<a href="index.php?mode=delete&type=pm&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_trash, $lang['message']['move_pm_to_trash_folder'], "").'</a></nobr></td>
					</tr>';

    ++$i;
}

                echo'
				</table>
				</td>
			</tr>
		</table>';
    if($num > 0){
        echo'
<center><br><table align="center" cellpadding="5" cellspacing="2"><tr><td align="center" valign="middle">
<input class="small" onclick="checkAllpm()" value="اختيار كامل" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="submit" value="'.$lang['message']['click_the_choose_pm_to_move_to_trash_folder'].'"></td></tr></table><br><br>
		</form></center>';
    }
}
//#################### in message #########################
if($mail == "in"){

        echo'
		<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
        <form name="check" method="post" action="index.php?mode=delete&method=remove&type=pm'.$forum_id.'">
			<tr>
				<td>
				<table cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<td class="cat" colSpan="2">&nbsp;</td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['date'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['from'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['to'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['pm_address'].'&nbsp;</nobr></td>
					<td class="cat"><nobr>&nbsp;'.$lang['message']['pm_size'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;</nobr></td>';


	$NEW_PM = $mysql->execute("SELECT * FROM {$mysql->prefix}PM WHERE PM_MID = '$DBMemberID' AND PM_OUT = '0' AND PM_STATUS = '1' ORDER BY PM_DATE DESC LIMIT $start, $max_page", [], __FILE__, __LINE__);
    $num = mysql_num_rows($NEW_PM);

if($num == 0){
    echo'
    <tr class="normal">
		<td class="list_center" vAlign="center" colspan="10"><br>'.$lang['message']['non_pm'].'<br><br></td>
    </tr>';
}


$i=0;
while ($i < $num){

    $NEW_PmID = mysql_result($NEW_PM, $i, "PM_ID");
    $NEW_Status = mysql_result($NEW_PM, $i, "PM_STATUS");
    $NEW_To = mysql_result($NEW_PM, $i, "PM_TO");
    $NEW_From = mysql_result($NEW_PM, $i, "PM_FROM");
    $NEW_Read = mysql_result($NEW_PM, $i, "PM_READ");
    $NEW_Reply = mysql_result($NEW_PM, $i, "PM_REPLY");
    $NEW_Subject = mysql_result($NEW_PM, $i, "PM_SUBJECT");
    $NEW_Message = mysql_result($NEW_PM, $i, "PM_MESSAGE");
    $NEW_Date = mysql_result($NEW_PM, $i, "PM_DATE");

	if(mlv > 1){
		$show_msg = '<br><font color="gray" size="2">'.strip_tags(substr($NEW_Message, 0, 100)).'</font>';
	}
	else{
		$show_msg = '';
	}

  if($NEW_From > 0){
    $MEMBER_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$NEW_From' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_FROM) > 0){
    $rsMF=mysql_fetch_array($MEMBER_FROM);
    $MF_MemberID = $rsMF['MEMBER_ID'];
    $MF_MemberName = $rsMF['M_NAME'];
    }
    $FromName = link_profile($MF_MemberName, $MF_MemberID);
  }
  if($NEW_From < 0){
    $f_id = abs($NEW_From);
    $FORUM_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_FROM) > 0){
    $rsFF=mysql_fetch_array($FORUM_FROM);
    $FF_ForumID = $rsFF['FORUM_ID'];
    $FF_ForumSubject = $rsFF['F_SUBJECT'];
    }
    $FromName = $lang['message']['moderate'].' '.$FF_ForumSubject;
  }

  if($NEW_To > 0){
    $MEMBER_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$NEW_To' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_TO) > 0){
    $rsMT=mysql_fetch_array($MEMBER_TO);
    $MT_MemberID = $rsMT['MEMBER_ID'];
    $MT_MemberName = $rsMT['M_NAME'];
    }
    $ToName = link_profile($MT_MemberName, $MT_MemberID);
  }
  if($NEW_To < 0){
    $f_id = abs($NEW_To);
    $FORUM_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_TO) > 0){
    $rsFT=mysql_fetch_array($FORUM_TO);
    $FT_ForumID = $rsFT['FORUM_ID'];
    $FT_ForumSubject = $rsFT['F_SUBJECT'];
    }
    $ToName = $lang['message']['moderate'].' '.$FT_ForumSubject;
  }



 if($NEW_Read == 0){
     $tr_class = 'fixed';
     $pm_icon = icons($icon, $lang['message']['new_pm']);
 }
 else {
     $tr_class = 'normal';

    if($NEW_Reply == 2){
        $pm_icon = icons($icon_reply_topic, $lang['message']['replied'], "");
    }
    else {
        $pm_icon = icons($icon_private_message, "", "");
    }
 }
 if($NEW_Reply == 0 OR $NEW_Reply == 2){
     $reply_icon = '';
 }
 else {
     $reply_icon = icons($icon_reply_topic, $lang['message']['this_pm_is_reply_to_last_pm'], "").'&nbsp;';
 }

                    echo'
					</tr>
						<tr class="'.$tr_class.'">
						<td class="list_center"><nobr>&nbsp;<input class="small" type="checkbox" name="remove[]" value="'.$NEW_PmID.'"></nobr></td>
						<td class="list_center"><nobr>&nbsp;<a href="index.php?mode=pm&mail=msg&msg='.$NEW_PmID.$forum_id.'">'.$pm_icon.'</a>&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;<font color="green">'.normal_time($NEW_Date).'</font>&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;'.$FromName.'&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;'.$ToName.'&nbsp;</nobr></td>
						<td class="list" width="90%"><nobr><a href="index.php?mode=pm&mail=msg&msg='.$NEW_PmID.$forum_id.'">'.$reply_icon.$NEW_Subject.$show_msg.'</a></nobr></td>
                        <td class="list_small">'.strlen($NEW_Message).'</td>
						<td class="list_small"><nobr>&nbsp;<a href="index.php?mode=editor&method=replymsg&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_reply_topic, $lang['message']['reply_to_pm'], "").'</a>&nbsp;&nbsp;<a href="index.php?mode=delete&type=pm&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_trash, $lang['message']['move_pm_to_trash_folder'], "").'</a></nobr></td>
					</tr>';

    ++$i;
}

                echo'
				</table>
				</td>
			</tr>
		</table>';
    if($num > 0){
        echo'
<center><br><table align="center" cellpadding="5" cellspacing="2"><tr><td align="center" valign="middle">
<input class="small" onclick="checkAllpm()" value="اختيار كامل" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="submit" value="'.$lang['message']['click_the_choose_pm_to_move_to_trash_folder'].'"></td></tr></table><br><br>
		</form></center>';
    }
}
//#################### out message #########################
if($mail == "out"){

        echo'
		<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
        <form name="check" method="post" action="index.php?mode=delete&method=remove&type=pm'.$forum_id.'">
			<tr>
				<td>
				<table cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<td class="cat" colSpan="2">&nbsp;</td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['date'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['from'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['to'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['pm_address'].'&nbsp;</nobr></td>
                        <td class="cat"><nobr>&nbsp;'.$lang['message']['pm_size'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;</nobr></td>';


	$NEW_PM = $mysql->execute("SELECT * FROM {$mysql->prefix}PM WHERE PM_MID = '$DBMemberID' AND PM_OUT = '1' AND PM_STATUS = '1' ORDER BY PM_DATE DESC LIMIT $start, $max_page", [], __FILE__, __LINE__);
    $num = mysql_num_rows($NEW_PM);

if($num == 0){
    echo'
    <tr class="normal">
		<td class="list_center" vAlign="center" colspan="10"><br>'.$lang['message']['non_pm'].'<br><br></td>
    </tr>';
}


$i=0;
while ($i < $num){

    $NEW_PmID = mysql_result($NEW_PM, $i, "PM_ID");
    $NEW_Status = mysql_result($NEW_PM, $i, "PM_STATUS");
    $NEW_To = mysql_result($NEW_PM, $i, "PM_TO");
    $NEW_From = mysql_result($NEW_PM, $i, "PM_FROM");
    $NEW_Read = mysql_result($NEW_PM, $i, "PM_READ");
    $NEW_Reply = mysql_result($NEW_PM, $i, "PM_REPLY");
    $NEW_Subject = mysql_result($NEW_PM, $i, "PM_SUBJECT");
    $NEW_Message = mysql_result($NEW_PM, $i, "PM_MESSAGE");
    $NEW_Date = mysql_result($NEW_PM, $i, "PM_DATE");
	if($Mlevel > 1){
		$show_msg = '<br><font color="gray" size="2">'.strip_tags(substr($NEW_Message, 0, 100)).'</font>';
	}
	else{
		$show_msg = '';
	}

  if($NEW_From > 0){
    $MEMBER_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$NEW_From' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_FROM) > 0){
    $rsMF=mysql_fetch_array($MEMBER_FROM);
    $MF_MemberID = $rsMF['MEMBER_ID'];
    $MF_MemberName = $rsMF['M_NAME'];
    }
    $FromName = link_profile($MF_MemberName, $MF_MemberID);
  }
  if($NEW_From < 0){
    $f_id = abs($NEW_From);
    $FORUM_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_FROM) > 0){
    $rsFF=mysql_fetch_array($FORUM_FROM);
    $FF_ForumID = $rsFF['FORUM_ID'];
    $FF_ForumSubject = $rsFF['F_SUBJECT'];
    }
    $FromName = $lang['message']['moderate'].' '.$FF_ForumSubject;
  }

  if($NEW_To > 0){
    $MEMBER_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$NEW_To' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_TO) > 0){
    $rsMT=mysql_fetch_array($MEMBER_TO);
    $MT_MemberID = $rsMT['MEMBER_ID'];
    $MT_MemberName = $rsMT['M_NAME'];
    }
    $ToName = link_profile($MT_MemberName, $MT_MemberID);
  }
  if($NEW_To < 0){
    $f_id = abs($NEW_To);
    $FORUM_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_TO) > 0){
    $rsFT=mysql_fetch_array($FORUM_TO);
    $FT_ForumID = $rsFT['FORUM_ID'];
    $FT_ForumSubject = $rsFT['F_SUBJECT'];
    }
    $ToName = $lang['message']['moderate'].' '.$FT_ForumSubject;
  }

 if($NEW_Reply == 0 OR $NEW_Reply == 2){
     $reply_icon = '';
 }
 else {
     $reply_icon = icons($icon_reply_topic, $lang['message']['this_pm_is_reply_to_last_pm'], "").'&nbsp;';
 }

                    echo'
					</tr>
						<tr class="normal">
						<td class="list_center"><nobr>&nbsp;<input class="small" type="checkbox" name="remove[]" value="'.$NEW_PmID.'"></nobr></td>
						<td class="list_center"><nobr>&nbsp;<a href="index.php?mode=pm&mail=msg&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_private_message, "", "").'</a>&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;<font color="green">'.normal_time($NEW_Date).'</font>&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;'.$FromName.'&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;'.$ToName.'&nbsp;</nobr></td>
						<td class="list" width="90%"><a href="index.php?mode=pm&mail=msg&msg='.$NEW_PmID.$forum_id.'">'.$reply_icon.$NEW_Subject.$show_msg.'</a></td>
                        <td class="list_small">'.strlen($NEW_Message).'</td>
						<td class="list_small"><nobr>&nbsp;<a href="index.php?mode=delete&type=pm&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_trash, $lang['message']['move_pm_to_trash_folder'], "").'</a></nobr></td>
					</tr>';

    ++$i;
}

                echo'
				</table>
				</td>
			</tr>
		</table>';
    if($num > 0){
        echo'
<center><br><table align="center" cellpadding="5" cellspacing="2"><tr><td align="center" valign="middle">
<input class="small" onclick="checkAllpm()" value="اختيار كامل" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="submit" value="'.$lang['message']['click_the_choose_pm_to_move_to_trash_folder'].'"></td></tr></table><br><br>
		</form></center>';
    }
}
//#################### trash message #########################
if($mail == "trash"){

        echo'
		<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
        <form name="deletemsg" method="post" action="index.php?mode=delete&method=delete&type=pm'.$forum_id.'">
			<tr>
				<td>
				<table cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<td class="cat" colSpan="2">&nbsp;</td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['date'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['from'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['to'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['pm_address'].'&nbsp;</nobr></td>
                        <td class="cat"><nobr>&nbsp;'.$lang['message']['pm_size'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;</nobr></td>';


	$NEW_PM = $mysql->execute("SELECT * FROM {$mysql->prefix}PM WHERE PM_MID = '$DBMemberID' AND PM_STATUS = '0' ORDER BY PM_DATE DESC LIMIT $start, $max_page", [], __FILE__, __LINE__);
    $num = mysql_num_rows($NEW_PM);

if($num == 0){
    echo'
    <tr class="normal">
		<td class="list_center" vAlign="center" colspan="10"><br>'.$lang['message']['non_pm'].'<br><br></td>
    </tr>';
}


$i=0;
while ($i < $num){

    $NEW_PmID = mysql_result($NEW_PM, $i, "PM_ID");
    $NEW_Status = mysql_result($NEW_PM, $i, "PM_STATUS");
    $NEW_To = mysql_result($NEW_PM, $i, "PM_TO");
    $NEW_From = mysql_result($NEW_PM, $i, "PM_FROM");
    $NEW_Read = mysql_result($NEW_PM, $i, "PM_READ");
    $NEW_Reply = mysql_result($NEW_PM, $i, "PM_REPLY");
    $NEW_Subject = mysql_result($NEW_PM, $i, "PM_SUBJECT");
    $NEW_Message = mysql_result($NEW_PM, $i, "PM_MESSAGE");
    $NEW_Date = mysql_result($NEW_PM, $i, "PM_DATE");
	if($Mlevel > 1){
		$show_msg = '<br><font color="gray" size="2">'.strip_tags(substr($NEW_Message, 0, 100)).'</font>';
	}
	else{
		$show_msg = '';
	}

  if($NEW_From > 0){
    $MEMBER_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$NEW_From' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_FROM) > 0){
    $rsMF=mysql_fetch_array($MEMBER_FROM);
    $MF_MemberID = $rsMF['MEMBER_ID'];
    $MF_MemberName = $rsMF['M_NAME'];
    }
    $FromName = link_profile($MF_MemberName, $MF_MemberID);
  }
  if($NEW_From < 0){
    $f_id = abs($NEW_From);
    $FORUM_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_FROM) > 0){
    $rsFF=mysql_fetch_array($FORUM_FROM);
    $FF_ForumID = $rsFF['FORUM_ID'];
    $FF_ForumSubject = $rsFF['F_SUBJECT'];
    }
    $FromName = $lang['message']['moderate'].' '.$FF_ForumSubject;
  }

  if($NEW_To > 0){
    $MEMBER_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$NEW_To' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_TO) > 0){
    $rsMT=mysql_fetch_array($MEMBER_TO);
    $MT_MemberID = $rsMT['MEMBER_ID'];
    $MT_MemberName = $rsMT['M_NAME'];
    }
    $ToName = link_profile($MT_MemberName, $MT_MemberID);
  }
  if($NEW_To < 0){
    $f_id = abs($NEW_To);
    $FORUM_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_TO) > 0){
    $rsFT=mysql_fetch_array($FORUM_TO);
    $FT_ForumID = $rsFT['FORUM_ID'];
    $FT_ForumSubject = $rsFT['F_SUBJECT'];
    }
    $ToName = $lang['message']['moderate'].' '.$FT_ForumSubject;
  }

 if($NEW_Read == 0){
     $tr_class = 'fixed';
     $pm_icon = icons($icon, $lang['message']['new_pm'], "");
 }
 else {
     $tr_class = 'normal';

    if($NEW_Reply == 2){
        $pm_icon = icons($icon_reply_topic, $lang['message']['replied'], "");
    }
    else {
        $pm_icon = icons($icon_private_message, "", "");
    }
 }
 if($NEW_Reply == 0 OR $NEW_Reply == 2){
     $reply_icon = '';
 }
 else {
     $reply_icon = icons($icon_reply_topic, $lang['message']['this_pm_is_reply_to_last_pm'], "").'&nbsp;';
 }

                    echo'
					</tr>
						<tr class="'.$tr_class.'">
						<td class="list_center"><nobr>&nbsp;<input class="small" type="checkbox" name="delete[]" value="'.$NEW_PmID.'"></nobr></td>
						<td class="list_center"><nobr>&nbsp;<a href="index.php?mode=pm&mail=msg&msg='.$NEW_PmID.$forum_id.'">'.$pm_icon.'</a>&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;<font color="green">'.normal_time($NEW_Date).'</font>&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;'.$FromName.'&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;'.$ToName.'&nbsp;</nobr></td>
						<td class="list" width="90%"><a href="index.php?mode=pm&mail=msg&msg='.$NEW_PmID.$forum_id.'">'.$reply_icon.$NEW_Subject.$show_msg.'</a></td>
                        <td class="list_small">'.strlen($NEW_Message).'</td>
						<td class="list_small"><nobr>&nbsp;<a href="index.php?mode=open&type=pm&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_go_up, $lang['message']['back_this_pm_to_normal_folder'], "").'</a>&nbsp;</nobr></td>
					</tr>';

    ++$i;
}

                echo'
				</table>
				</td>
			</tr>
		</table>';
    if($num > 0){
        echo'
<center><br><table align="center" cellpadding="5" cellspacing="2"><tr><td align="center" valign="middle">
<input class="small" onclick="AllpmTrash()" value="اختيار كامل" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input onclick="submit_delete()" type="button" value="'.$lang['message']['delete_choose_pm_finish'].'"></td></tr></table><br><br>
		</form></center>';

    }
}

//#################### me and you message #########################
if($mail == "m"){

        echo'
		<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
        <form method="post" action="index.php?mode=delete&method=remove&type=pm'.$forum_id.'">
			<tr>
				<td>
				<table cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<td class="cat" colSpan="2">&nbsp;</td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['date'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['from'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['to'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['pm_address'].'&nbsp;</nobr></td>
                        <td class="cat"><nobr>&nbsp;'.$lang['message']['pm_size'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['folders'].'&nbsp;</nobr></td>
                        <td class="cat"><nobr>&nbsp;</nobr></td>
                    </tr>';

               echo'<tr><td align="center" bgcolor="yellow" colspan="10"><font color="black">'.$lang['message']['mail_between_yours_and_this_member'].' </font>'.link_profile(member_name($m), $m).'</td></tr>';

 $NEW_PM = $mysql->execute("SELECT * FROM {$mysql->prefix}PM WHERE PM_MID = '$DBMemberID' AND PM_STATUS = '1' AND PM_FROM = '$m' OR  PM_TO = '$m' and PM_STATUS  = '1' AND PM_MID = '$DBMemberID' ORDER BY PM_DATE DESC LIMIT $start, $max_page", [], __FILE__, __LINE__);
    $num = mysql_num_rows($NEW_PM);

if($num == 0){
    echo'
    <tr class="normal">
		<td class="list_center" vAlign="center" colspan="10"><br>'.$lang['message']['non_pm_between_yours_and_this_member'].' ('.member_name($m).')<br><br></td>
    </tr>';
}


$i=0;
while ($i < $num){

    $NEW_PmID = mysql_result($NEW_PM, $i, "PM_ID");
    $NEW_Status = mysql_result($NEW_PM, $i, "PM_STATUS");
    $NEW_To = mysql_result($NEW_PM, $i, "PM_TO");
    $NEW_From = mysql_result($NEW_PM, $i, "PM_FROM");
    $NEW_Read = mysql_result($NEW_PM, $i, "PM_READ");
    $NEW_Out = mysql_result($NEW_PM, $i, "PM_OUT");
    $NEW_Reply = mysql_result($NEW_PM, $i, "PM_REPLY");
    $NEW_Subject = mysql_result($NEW_PM, $i, "PM_SUBJECT");
    $NEW_Message = mysql_result($NEW_PM, $i, "PM_MESSAGE");
    $NEW_Date = mysql_result($NEW_PM, $i, "PM_DATE");
	if($Mlevel > 1){
		$show_msg = '<br><font color="gray" size="2">'.strip_tags(substr($NEW_Message, 0, 100)).'</font>';
	}
	else{
		$show_msg = '';
	}

  if($NEW_From > 0){
    $MEMBER_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$NEW_From' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_FROM) > 0){
    $rsMF=mysql_fetch_array($MEMBER_FROM);
    $MF_MemberID = $rsMF['MEMBER_ID'];
    $MF_MemberName = $rsMF['M_NAME'];
    }
    $FromName = link_profile($MF_MemberName, $MF_MemberID);
  }
  if($NEW_From < 0){
    $f_id = abs($NEW_From);
    $FORUM_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_FROM) > 0){
    $rsFF=mysql_fetch_array($FORUM_FROM);
    $FF_ForumID = $rsFF['FORUM_ID'];
    $FF_ForumSubject = $rsFF['F_SUBJECT'];
    }
    $FromName = $lang['message']['moderate'].' '.$FF_ForumSubject;
  }

  if($NEW_To > 0){
    $MEMBER_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$NEW_To' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_TO) > 0){
    $rsMT=mysql_fetch_array($MEMBER_TO);
    $MT_MemberID = $rsMT['MEMBER_ID'];
    $MT_MemberName = $rsMT['M_NAME'];
    }
    $ToName = link_profile($MT_MemberName, $MT_MemberID);
  }
  if($NEW_To < 0){
    $f_id = abs($NEW_To);
    $FORUM_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_TO) > 0){
    $rsFT=mysql_fetch_array($FORUM_TO);
    $FT_ForumID = $rsFT['FORUM_ID'];
    $FT_ForumSubject = $rsFT['F_SUBJECT'];
    }
    $ToName = $lang['message']['moderate'].' '.$FT_ForumSubject;
  }

 if($NEW_Read == 0){
     $tr_class = 'fixed';
     $pm_icon = icons($icon, $lang['message']['new_pm'], "");
 }
 else {
     $tr_class = 'normal';

    if($NEW_Reply == 2){
        $pm_icon = icons($icon_reply_topic, $lang['message']['replied'], "");
    }
    else {
        $pm_icon = icons($icon_private_message, "", "");
    }
 }
 if($NEW_Reply == 0 OR $NEW_Reply == 2){
     $reply_icon = '';
 }
 else {
     $reply_icon = icons($icon_reply_topic, $lang['message']['this_pm_is_reply_to_last_pm'], "").'&nbsp;';
 }

 if($NEW_Out == 0){
    $mail_folder = '&nbsp;<font color="black">'.$lang['message']['in_mail'].'</font>&nbsp;';
    $mail_icon = '&nbsp;<a href="index.php?mode=editor&method=replymsg&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_reply_topic, $lang['message']['reply_to_pm'], "").'</a>&nbsp;&nbsp;<a href="index.php?mode=delete&type=pm&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_trash, $lang['message']['move_pm_to_trash_folder'], "").'</a>';
 }
 if($NEW_Out == 1){
    $mail_folder = '&nbsp;<font color="green">'.$lang['message']['out_mail'].'</font>&nbsp;';
    $mail_icon = '&nbsp;<a href="index.php?mode=delete&type=pm&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_trash, $lang['message']['move_pm_to_trash_folder'], "").'</a>';
 }
                    echo'
					</tr>
						<tr class="'.$tr_class.'">
						<td class="list_center"><nobr>&nbsp;<input class="small" type="checkbox" name="delete[]" value="'.$NEW_PmID.'"></nobr></td>
						<td class="list_center"><nobr>&nbsp;<a href="index.php?mode=pm&mail=msg&msg='.$NEW_PmID.$forum_id.'">'.$pm_icon.'</a>&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;<font color="green">'.normal_time($NEW_Date).'</font>&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;'.$FromName.'&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;'.$ToName.'&nbsp;</nobr></td>
						<td class="list" width="90%"><a href="index.php?mode=pm&mail=msg&msg='.$NEW_PmID.$forum_id.'">'.$reply_icon.$NEW_Subject.$show_msg.'</a></td>
                        <td class="list_small">'.strlen($NEW_Message).'</td>
                        <td class="list_small"><nobr>'.$mail_folder.'</nobr></td>
						<td class="list_small"><nobr>'.$mail_icon.'</nobr></td>
					</tr>';

    ++$i;
}

                echo'
				</table>
				</td>
			</tr>
		</table>';
    if($num > 0){
        echo'
		<center>
		<table border="0" cellpadding="2" border="0" cellspacing="0" width="100%">
			<tr>
				<td align="center"><br><input type="submit" value="'.$lang['message']['click_the_choose_pm_to_move_to_trash_folder'].'"><br><br></td>
			</tr>
		</form>
		</table>
		</center>';
    }
}

//#################### show  pm of this member #########################
if($mail == "show"){

if(mlv == 4 OR mlv == 3 AND $CAN_SHOW_PM == 1){
// nothin
}else{
redirect();
}

if(members("LEVEL",$id) == 4 AND mlv != 4){
redirect();
}

        echo'
		<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
        <form method="post" action="index.php?mode=delete&method=remove&type=pm'.$forum_id.'">
			<tr>
				<td>
				<table cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<td class="cat" colSpan="2">&nbsp;</td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['date'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['from'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['to'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['pm_address'].'&nbsp;</nobr></td>
                        <td class="cat"><nobr>&nbsp;'.$lang['message']['pm_size'].'&nbsp;</nobr></td>
						<td class="cat"><nobr>&nbsp;'.$lang['message']['folders'].'&nbsp;</nobr></td>
                        <td class="cat"><nobr>&nbsp;</nobr></td>
                    </tr>';

               echo'<tr><td align="center" bgcolor="yellow" colspan="10"><font color="black">مراقبة الرسائل الخاصة : </font>'.link_profile(member_name($id), $id).'</td></tr>';

 $NEW_PM = $mysql->execute("SELECT * FROM {$mysql->prefix}PM WHERE PM_MID = '$id' AND PM_STATUS = '1' OR PM_FROM = '$m'  AND PM_STATUS = '1' ORDER BY PM_DATE DESC LIMIT $start, $max_page", [], __FILE__, __LINE__);
    $num = mysql_num_rows($NEW_PM);

if($num == 0){
    echo'
    <tr class="normal">
		<td class="list_center" vAlign="center" colspan="10"><br>لم يتم العثور على اي رسائل خاصة .<br><br></td>
    </tr>';
}


$i=0;
while ($i < $num){

    $NEW_PmID = mysql_result($NEW_PM, $i, "PM_ID");
    $NEW_Status = mysql_result($NEW_PM, $i, "PM_STATUS");
    $NEW_To = mysql_result($NEW_PM, $i, "PM_TO");
    $NEW_From = mysql_result($NEW_PM, $i, "PM_FROM");
    $NEW_Read = mysql_result($NEW_PM, $i, "PM_READ");
    $NEW_Out = mysql_result($NEW_PM, $i, "PM_OUT");
    $NEW_Reply = mysql_result($NEW_PM, $i, "PM_REPLY");
    $NEW_Subject = mysql_result($NEW_PM, $i, "PM_SUBJECT");
    $NEW_Message = mysql_result($NEW_PM, $i, "PM_MESSAGE");
    $NEW_Date = mysql_result($NEW_PM, $i, "PM_DATE");
	if($Mlevel > 1){
		$show_msg = '<br><font color="gray" size="2">'.strip_tags(substr($NEW_Message, 0, 100)).'</font>';
	}
	else{
		$show_msg = '';
	}

  if($NEW_From > 0){
    $MEMBER_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$NEW_From' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_FROM) > 0){
    $rsMF=mysql_fetch_array($MEMBER_FROM);
    $MF_MemberID = $rsMF['MEMBER_ID'];
    $MF_MemberName = $rsMF['M_NAME'];
    }
    $FromName = link_profile($MF_MemberName, $MF_MemberID);
  }
  if($NEW_From < 0){
    $f_id = abs($NEW_From);
    $FORUM_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_FROM) > 0){
    $rsFF=mysql_fetch_array($FORUM_FROM);
    $FF_ForumID = $rsFF['FORUM_ID'];
    $FF_ForumSubject = $rsFF['F_SUBJECT'];
    }
    $FromName = $lang['message']['moderate'].' '.$FF_ForumSubject;
  }

  if($NEW_To > 0){
    $MEMBER_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$NEW_To' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_TO) > 0){
    $rsMT=mysql_fetch_array($MEMBER_TO);
    $MT_MemberID = $rsMT['MEMBER_ID'];
    $MT_MemberName = $rsMT['M_NAME'];
    }
    $ToName = link_profile($MT_MemberName, $MT_MemberID);
  }
  if($NEW_To < 0){
    $f_id = abs($NEW_To);
    $FORUM_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_TO) > 0){
    $rsFT=mysql_fetch_array($FORUM_TO);
    $FT_ForumID = $rsFT['FORUM_ID'];
    $FT_ForumSubject = $rsFT['F_SUBJECT'];
    }
    $ToName = $lang['message']['moderate'].' '.$FT_ForumSubject;
  }

 if($NEW_Read == 0){
     $tr_class = 'fixed';
     $pm_icon = icons($icon, $lang['message']['new_pm'], "");
 }
 else {
     $tr_class = 'normal';

    if($NEW_Reply == 2){
        $pm_icon = icons($icon_reply_topic, $lang['message']['replied'], "");
    }
    else {
        $pm_icon = icons($icon_private_message, "", "");
    }
 }
 if($NEW_Reply == 0 OR $NEW_Reply == 2){
     $reply_icon = '';
 }
 else {
     $reply_icon = icons($icon_reply_topic, $lang['message']['this_pm_is_reply_to_last_pm'], "").'&nbsp;';
 }

 if($NEW_Out == 0){
    $mail_folder = '&nbsp;<font color="black">'.$lang['message']['in_mail'].'</font>&nbsp;';
    $mail_icon = '&nbsp;<a href="index.php?mode=editor&method=replymsg&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_reply_topic, $lang['message']['reply_to_pm'], "").'</a>&nbsp;&nbsp;<a href="index.php?mode=delete&type=pm&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_trash, $lang['message']['move_pm_to_trash_folder'], "").'</a>';
 }
 if($NEW_Out == 1){
    $mail_folder = '&nbsp;<font color="green">'.$lang['message']['out_mail'].'</font>&nbsp;';
    $mail_icon = '&nbsp;<a href="index.php?mode=delete&type=pm&msg='.$NEW_PmID.$forum_id.'">'.icons($icon_trash, $lang['message']['move_pm_to_trash_folder'], "").'</a>';
 }
                    echo'
					</tr>
						<tr class="'.$tr_class.'">
						<td class="list_center"><nobr>&nbsp;<input class="small" type="checkbox" name="delete[]" value="'.$NEW_PmID.'"></nobr></td>
						<td class="list_center"><nobr>&nbsp;<a href="index.php?mode=pm&mail=msg&msg='.$NEW_PmID.$forum_id.'">'.$pm_icon.'</a>&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;<font color="green">'.normal_time($NEW_Date).'</font>&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;'.$FromName.'&nbsp;</nobr></td>
						<td class="list_small"><nobr>&nbsp;'.$ToName.'&nbsp;</nobr></td>
						<td class="list" width="90%"><a href="index.php?mode=pm&mail=msg&msg='.$NEW_PmID.$forum_id.'">'.$reply_icon.$NEW_Subject.$show_msg.'</a></td>
                        <td class="list_small">'.strlen($NEW_Message).'</td>
                        <td class="list_small"><nobr>'.$mail_folder.'</nobr></td>
						<td class="list_small"><nobr>'.$mail_icon.'</nobr></td>
					</tr>';

    ++$i;
}

                echo'
				</table>
				</td>
			</tr>
		</table>';
    if($num > 0){
        echo'
		<center>
		<table border="0" cellpadding="2" border="0" cellspacing="0" width="100%">
			<tr>
				<td align="center"><br><input type="submit" value="'.$lang['message']['click_the_choose_pm_to_move_to_trash_folder'].'"><br><br></td>
			</tr>
		</form>
		</table>
		</center>';
    }
}
//#################### read msg #########################
if($mail == "msg"){

if($msg == ""){
 redirect();
}
  $mysql->execute("UPDATE {$mysql->prefix}PM SET PM_READ = 1 WHERE PM_ID = '".$msg."' ", [], __FILE__, __LINE__);
    $PM_READ = $mysql->execute("SELECT * FROM {$mysql->prefix}PM WHERE PM_ID = '".$msg."' AND PM_MID = '$DBMemberID' ", [], __FILE__, __LINE__);
if(mlv == 4){
    $PM_READ = $mysql->execute("SELECT * FROM {$mysql->prefix}PM WHERE PM_ID = '".$msg."'", [], __FILE__, __LINE__);
}

    if(mysql_num_rows($PM_READ) > 0){

    $rsPMR=mysql_fetch_array($PM_READ);

    $PMR_PmID = $rsPMR['PM_ID'];
    $PMR_Status = $rsPMR['PM_STATUS'];
    $PMR_To = $rsPMR['PM_TO'];
    $PMR_From = $rsPMR['PM_FROM'];
    $PMR_Read = $rsPMR['PM_READ'];
    $PMR_Out = $rsPMR['PM_OUT'];
    $PMR_Reply = $rsPMR['PM_REPLY'];
    $PMR_Subject = $rsPMR['PM_SUBJECT'];
    $PMR_Message = $rsPMR['PM_MESSAGE'];
    $PMR_Date = $rsPMR['PM_DATE'];

    }

  if($PMR_From > 0){
    $MEMBER_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$PMR_From' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_FROM) > 0){
    $rsMF=mysql_fetch_array($MEMBER_FROM);
    $MF_MemberID = $rsMF['MEMBER_ID'];
    $MF_MemberName = $rsMF['M_NAME'];
    $hide = $rsMT['M_HIDE_PM'];

    }
    $FromName = link_profile($MF_MemberName, $MF_MemberID);
  }
  if($PMR_From < 0){
    $f_id = abs($PMR_From);
    $FORUM_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_FROM) > 0){
    $rsFF=mysql_fetch_array($FORUM_FROM);
    $FF_ForumID = $rsFF['FORUM_ID'];
    $FF_ForumSubject = $rsFF['F_SUBJECT'];

    }
    $FromName = $lang['message']['moderate'].' '.$FF_ForumSubject;
  }

  if($PMR_To > 0){
    $MEMBER_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$PMR_To' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($MEMBER_TO) > 0){
    $rsMT=mysql_fetch_array($MEMBER_TO);
    $MT_MemberID = $rsMT['MEMBER_ID'];
    $MT_MemberName = $rsMT['M_NAME'];

    }
    $ToName = link_profile($MT_MemberName, $MT_MemberID);
  }
  if($PMR_To < 0){
    $f_id = abs($PMR_To);
    $FORUM_TO = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f_id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($FORUM_TO) > 0){
    $rsFT=mysql_fetch_array($FORUM_TO);
    $FT_ForumID = $rsFT['FORUM_ID'];
    $FT_ForumSubject = $rsFT['F_SUBJECT'];
    }
    $ToName = $lang['message']['moderate'].' '.$FT_ForumSubject;
  }
  

 $query = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = ".$PMR_From." ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($result) > 0){
 $rs=mysql_fetch_array($result);

 $ProMemberPmHide = $rs['M_HIDE_PM'];

 }

        echo'
		<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
			<tr>
				<td>
				<table cellSpacing="1" cellPadding="4" width="100%" border="0">
			        <tr class="normal">
				        <td class="cat" colSpan="3"><font size="+1">'.$lang['message']['pm'].'</font></td>
			        </tr>
			        <tr class="normal">
				        <td class="cat"><nobr><font color="yellow">'.$lang['message']['important_warning'].'</font></nobr></td>
			            <td class="list" width="100%">&nbsp;<font color="red" size="-1">'.$lang['message']['warning_to_all_members_one'].'<br>'.$lang['message']['warning_to_all_members_two'].'&nbsp;</font></td>
			        </tr>
			        <tr class="normal">
				        <td class="cat"><nobr>'.$lang['message']['from'].'</nobr></td>
				        <td class="list" width="100%"><nobr>&nbsp;&nbsp;&nbsp;'.$FromName.'&nbsp;&nbsp;&nbsp;';
                        if($PMR_From != $DBMemberID){
                            echo '<a href="index.php?mode=pm&mail=m&m='.$PMR_From.'">'.icons($icon_profile,$lang['message']['your_pm_with_this_member'],"").'</a>';
                           if(mlv == 4){
                           echo ' &nbsp;<a href="index.php?mode=requestmon&aid='.$PMR_From.'&pm='.$msg.'">'.icons($icon_moderation, 'تطبيق رقابة على العضو').'</a>';
}
                        }


                                                      if(mlv > 1 AND !preg_match("/\-/",$PMR_From) AND $PMR_To != $DBMemberID){
                            echo '<a href="index.php?mode=requestmon&aid='.$PMR_From.'&pm='.$msg.'">'.icons($icon_moderation, 'تطبيق رقابة على العضو').'</a>';
                                                             }  

                        echo'
                        </nobr></td>
			        </tr>
			        <tr class="normal">
				        <td class="cat"><nobr>'.$lang['message']['to'].'</nobr></td>
				        <td class="list"><nobr>&nbsp;&nbsp;&nbsp;'.$ToName.'&nbsp;&nbsp;&nbsp;';
                        if($PMR_To != $DBMemberID){
                            echo '<a href="index.php?mode=pm&mail=m&m='.$PMR_To.$forum_id.'">'.icons($icon_profile,$lang['message']['your_pm_with_this_member'],"").'</a>';         
                        }

                        echo'
                        </nobr></td>
			        </tr>
			        <tr class="normal">
				        <td class="cat"><nobr>'.$lang['message']['date'].'</nobr></td>
				        <td class="list"><nobr>&nbsp;&nbsp;&nbsp;<font color="green">'.normal_time($PMR_Date).'</font>&nbsp;&nbsp;&nbsp;</nobr></td>
			        </tr>
			        <tr class="fixed">
				        <td class="cat"><nobr>'.$lang['message']['pm_address'].'</nobr></td>
				        <td class="list">&nbsp;&nbsp;&nbsp;<a href="index.php?mode=pm&mail=msg&msg='.$PMR_PmID.$forum_id.'">'.$PMR_Subject.'</a>&nbsp;&nbsp;&nbsp;</td>
			        </tr>
			        ';
			        if($ProMemberPmHide == 1 AND $Mlevel > 1){
echo'
				        <td class="optionheader_selected" colSpan="3"><font color="yellow">** رسائل هذه العضوية مخفية عن الأعضاء -- الرجاء الحذر في التعامل مع محتوياتها **
				        </font></td>

			        </tr>
			        <tr>';
			        
			        
}

if($ProMemberPmHide == 0){
echo'
				        <td bgColor="#dddddd" colSpan="2">'.text_replace($PMR_Message).'</td>
			        </tr>';
}
if($ProMemberPmHide == 1 AND $Mlevel < 2){
echo'
				        <td bgColor="#dddddd" colSpan="2" class="optionheader_selected" >** رسائل هذه العضوية مخفية بواسطة الإدارة **</td>



	        ';
}
if($ProMemberPmHide == 1 AND $Mlevel > 1){
echo'
				        <td bgColor="#dddddd" colSpan="2">'.text_replace($PMR_Message).'</td>



	        ';
}


if($PMR_Out == 0){
                    echo'
			        <tr>
			            <form name="quickreply" method="post" action="index.php?mode=post_info'.$forum_id.'">
				        <td vAlign="top" align="middle" bgColor="white"><br>'.icons($icon_reply_topic,"","").'<br><br><font color="red">'.$lang['message']['add_quick_reply'].' </font></td>
				        <td vAlign="top" align="middle" width="100%" bgColor="white">
				        <textarea style="WIDTH: 100%;HEIGHT: 150px;'.M_Style_Form.'" name="message" rows="1" cols="20"></textarea>
                        <input name="method" type="hidden" value="replymsg">
                        <input name="type" type="hidden" value="q_reply">
                        <input name="m" type="hidden" value="'.$m.'">
                        <input name="pm_to" type="hidden" value="'.$PMR_From.'">
                        <input name="subject" type="hidden" value="'.$PMR_Subject.'">
				        <input name="host" type="hidden" value="'.$HTTP_HOST.'">
				        <input onclick="submitQuickReplyForm()" type="button" value="'.$lang['message']['send_reply_to_this_pm'].'">
				        </td>
				        </form>
			        </tr>';
}
                echo'
				</table>
				</td>
			</tr>
		</table>';
}

        echo'
		</td>
	</tr>
</table>
</center>';

}
?>
