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

$HTTP_REFERER = $_SERVER['HTTP_REFERER'];
$HTTP_HOST = $_SERVER['HTTP_HOST'];

$Monitor_all = chk_monitor($DBMemberID, $c);
$Moderator_all = chk_moderator($DBMemberID, $f);
$mod_ShowForum = mod_ShowForum($DBMemberID, $f);

$allowed = 1;

if(members("SEX", $DBMemberID) == 1 AND forums("SEX", $f) == 2){
$allowed = 0;
}
if(members("SEX", $DBMemberID) == 2 AND forums("SEX", $f) == 1){
$allowed = 0;
}


if(allowed($f, 2) == 1){
$allowed = 1;
}

if($allowed == 1){

if($quote != ""){
    $quote = "1";
}
else {
    $quote = "0";
}


if($method == "edit"){
	$subject = topics("SUBJECT", $t);
                  $fix_er = mysql_fetch_array($mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE TOPIC_ID = '$t' "), [], __FILE__, __LINE__); 
	$message = $fix_er['T_MESSAGE'];
	insert_old_topic_data($t, $subject, $message);
}

if($method == "editreply"){
	$message = replies("MESSAGE", $r);
	insert_old_reply_data($r, $message);
}

if($method == "topic"){
    $txt = $lang['editor']['add_topic'];
}
if($method == "edit"){
    $txt = $lang['editor']['edit_topic'];
}
if($method == "reply"){
    $txt = $lang['editor']['add_reply'];
}
if($method == "editreply"){
    $txt = $lang['editor']['edit_reply'];
}

 $cat = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY WHERE CAT_ID = '$c' ", [], __FILE__, __LINE__);

 if(mysql_num_rows($cat) > 0){

 $rsc = mysql_fetch_array($cat);

 $C_CatID = $rsc['CAT_ID'];
 $C_CatStatus = $rsc['CAT_STATUS'];

 }

 $forum = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$f' ", [], __FILE__, __LINE__);

 if(mysql_num_rows($forum) > 0){

 $rsf = mysql_fetch_array($forum);

 $F_CatID = $rsf['CAT_ID'];
 $F_ForumID = $rsf['FORUM_ID'];
 $F_ForumStatus = $rsf['F_STATUS'];
 $F_ForumSubject = $rsf['F_SUBJECT'];
 $F_ForumLogo = $rsf['F_LOGO'];

 }


	$topic = "SELECT * FROM {$mysql->prefix}TOPICS ";
    $topic .= " WHERE TOPIC_ID = '$t' ";
	$Rtopic = $mysql->execute($topic, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($Rtopic) > 0){

 $rst = mysql_fetch_array($Rtopic);

 $T_TopicID = $rst['TOPIC_ID'];
 $T_TopicSubject = $rst['T_SUBJECT'];
 $T_TopicMessage = $rst['T_MESSAGE'];
 $T_TopicAuthor = $rst['T_AUTHOR'];
 $T_TopicStatus = $rst['T_STATUS'];
 $T_TopicSticky = $rst['T_STICKY'];
 $T_TopicHidden = $rst['T_HIDDEN'];

 }


 	$Tmember = "SELECT * FROM {$mysql->prefix}MEMBERS ";
    $Tmember .= " WHERE MEMBER_ID = '$T_TopicAuthor' ";
	$RTmember = $mysql->execute($Tmember, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($RTmember) > 0){

 $rstm = mysql_fetch_array($RTmember);

 $T_MemberID = $rstm['MEMBER_ID'];
 $T_MemberName = $rstm['M_NAME'];

 }

 	$Reply = "SELECT * FROM {$mysql->prefix}REPLY ";
    $Reply .= " WHERE REPLY_ID = '$r' ";
	$RReplyr = $mysql->execute($Reply, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($RReplyr) > 0){

 $rsR = mysql_fetch_array($RReplyr);

 $R_ReplyID = $rsR['REPLY_ID'];
 $R_ReplyMessage = $rsR['R_MESSAGE'];

 }


 $SIG = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$DBMemberID' ", [], __FILE__, __LINE__);

 if(mysql_num_rows($SIG) > 0){

 $rsSIG = mysql_fetch_array($SIG);

 $SIG_MemberID = $rsSIG['MEMBER_ID'];
 $SIG_MemberName = $rsSIG['M_NAME'];
 $SIG_MemberSig = $rsSIG['M_SIG'];

 }

 $ReplyMsg = $mysql->execute("SELECT * FROM {$mysql->prefix}PM WHERE PM_ID = '$msg' ", [], __FILE__, __LINE__);

 if(mysql_num_rows($ReplyMsg) > 0){

 $rsRM = mysql_fetch_array($ReplyMsg);

 $RM_PmID = $rsRM['PM_ID'];
 $RM_To = $rsRM['PM_TO'];
 $RM_From = $rsRM['PM_FROM'];
 $RM_Subject = $rsRM['PM_SUBJECT'];

 }

if($method == "replymsg"){
  if($RM_From > 0){

    $MEMBER_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$RM_From' ", [], __FILE__, __LINE__);

    if(mysql_num_rows($MEMBER_FROM) > 0){

    $rsMF=mysql_fetch_array($MEMBER_FROM);

    $MF_MemberID = $rsMF['MEMBER_ID'];
    $MF_MemberName = $rsMF['M_NAME'];
    }
  }
  if($RM_From < 0){

    $id = abs($RM_From);

    $FORUM_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$id' ", [], __FILE__, __LINE__);

    if(mysql_num_rows($FORUM_FROM) > 0){

    $rsFF=mysql_fetch_array($FORUM_FROM);

    $FF_ForumID = $rsFF['FORUM_ID'];
    $FF_ForumSubject = $rsFF['F_SUBJECT'];

    $MF_MemberID = '-'.$FF_ForumID;
    $MF_MemberName = $lang['editor']['moderate'].' '.$FF_ForumSubject;

    }
  }
}



if($method == "sendmsg"){
  if($m > 0){

    $MEMBER_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$m' ", [], __FILE__, __LINE__);

    if(mysql_num_rows($MEMBER_FROM) > 0){

    $rsMF=mysql_fetch_array($MEMBER_FROM);

    $MF_MemberID = $rsMF['MEMBER_ID'];
    $MF_MemberName = $rsMF['M_NAME'];
    }
  }
  if($m < 0){

    $id = abs($m);

    $FORUM_FROM = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$id' ", [], __FILE__, __LINE__);

    if(mysql_num_rows($FORUM_FROM) > 0){

    $rsFF=mysql_fetch_array($FORUM_FROM);

    $FF_ForumID = $rsFF['FORUM_ID'];
    $FF_ForumSubject = $rsFF['F_SUBJECT'];

    $MF_MemberID = '-'.$FF_ForumID;
    $MF_MemberName = $lang['editor']['moderate'].' '.$FF_ForumSubject;

    }
  }

}


if($Mlevel > 0){



if($method == "topic"){
    if($Mlevel != 4 AND $C_CatStatus == 0){
		go_to("index.php?mode=msg&err=1");
    }
    if($Mlevel != 4 AND $F_ForumStatus == 0){
		go_to("index.php?mode=msg&err=2");
    }
if(members("TOPICS_ADD", $DBMemberID) == 1){
		go_to("index.php?mode=msg&err=24");
}

if($mod_ShowForum == 1 ){
		go_to("index.php?mode=msg&err=28&f=".$f);
    }

	$member_topics_today = member_topics_today($DBMemberID, $f);
	$f_total_topics = forums("TOTAL_TOPICS", $f);
    if($Mlevel == 1 AND $member_topics_today >= $f_total_topics){
		go_to("index.php?mode=msg&err=13&f=".$f);
    }
    if(mon_OneForum($DBMemberID, $f) == 1){
		go_to("index.php?mode=msg&err=15&f=".$f);
    }
    if(mon_AllForum($DBMemberID) == 1){
		go_to("index.php?mode=msg&err=16&f=".$f);
    }
    $f_level = forums("F_LEVEL", $f);
    if($f_level > 0 AND mlv < $f_level){
                                    redirect();
    }
}
if($method == "edit"){
if(members("TOPICS_EDIT", $DBMemberID) == 1){
		go_to("index.php?mode=msg&err=26");
}

if($mod_ShowForum == 1 ){
go_to("index.php?mode=msg&err=28&f=".$f);}

    if($Mlevel != 4 AND $C_CatStatus == 0){
		go_to("index.php?mode=msg&err=3");
    }
    if($Mlevel  != 4  AND $F_ForumStatus == 0){
		go_to("index.php?mode=msg&err=4");
    }
    if($Mlevel == 1 AND $T_TopicStatus == 0){
		go_to("index.php?mode=msg&err=5");
    }
    if($Mlevel == 1 AND $T_TopicAuthor != $DBMemberID){
		go_to("index.php?mode=msg&err=6");
    }
    if(mon_OneForum($DBMemberID, $f) == 1){
		go_to("index.php?mode=msg&err=15&f=".$f);
    }
    if(mon_AllForum($DBMemberID) == 1){
		go_to("index.php?mode=msg&err=16&f=".$f);
    }
    if(topics("UNMODERATED", $t) == 1){
		go_to("index.php?mode=msg&err=17&f=".$f);
    }

}
if($method == "reply"){
if(members("POSTS_ADD", $DBMemberID) == 1){
		go_to("index.php?mode=msg&err=25");
}

$mod_ShowForum = mod_ShowForum($DBMemberID, $f);

if($mod_ShowForum == 1 ){
go_to("index.php?mode=msg&err=28&f=".$f);}


    if($Mlevel != 4 AND $C_CatStatus == 0){
		go_to("index.php?mode=msg&err=7");
    }
    if($Mlevel != 4 AND $F_ForumStatus == 0){
		go_to("index.php?mode=msg&err=8");
    }
    if($Mlevel == 1 AND $T_TopicStatus == 0){
		go_to("index.php?mode=msg&err=9");
    }
   if($Mlevel == 1 AND $T_TopicHidden == 1 AND  chk_load_topic($t) OR $Mlevel == 1 AND $T_TopicHidden == 1 AND $T_TopicAuthor == $DBMemberID){
		go_to("index.php?mode=msg&err=10");
    }
	$member_replies_today = member_replies_today($DBMemberID, $f);
	$f_total_replies = forums("TOTAL_REPLIES", $f);
    if($Mlevel == 1 AND $member_replies_today >= $f_total_replies){
		go_to("index.php?mode=msg&err=14&f=".$f);
    }
    if(mon_OneForum($DBMemberID, $f) == 1){
		go_to("index.php?mode=msg&err=15&f=".$f);
    }
    if(mon_AllForum($DBMemberID) == 1){
		go_to("index.php?mode=msg&err=16&f=".$f);
    }
    if(topics("UNMODERATED", $t) == 1){
		go_to("index.php?mode=msg&err=18&f=".$f);
    }
    if(topics("ARCHIVED", $t) == 1 AND mlv != 4){
    go_to("index.php?mode=msg&err=19");
    }

    $f_level = forums("F_LEVEL", $f);
    if($f_level > 0 AND mlv < $f_level){
                                    redirect();
    }
}
if($method == "editreply"){
if(members("POSTS_EDIT", $DBMemberID) == 1){
		go_to("index.php?mode=msg&err=27");
}

    if($Mlevel != 4 AND $C_CatStatus == 0){
		go_to("index.php?mode=msg&err=11");
    }
    if($Mlevel != 4 AND $F_ForumStatus == 0){
		go_to("index.php?mode=msg&err=12");
    }
    if(mon_OneForum($DBMemberID, $f) == 1){
		go_to("index.php?mode=msg&err=15&f=".$f);
    }
    if(mon_AllForum($DBMemberID) == 1){
		go_to("index.php?mode=msg&err=16&f=".$f);
    }
}
if($method == "sendmsg"){
if(mlv == 1 AND member_name($m) AND $DBMemberPosts < $new_member_min_posts_pm AND members("LEVEL", $m) == 1){
		go_to("index.php?mode=msg&err=20");
}
use_pm();

$n_list = mysql_num_rows($mysql->execute("SELECT * FROM {$mysql->prefix}LIST_M WHERE M_ID = '$m' AND USER = '$DBMemberID' AND CAT_ID = '-2' "));
if(mlv == 1 AND member_name($m) AND $n_list != 0  AND members("LEVEL", $m) == 1){
		go_to("index.php?mode=msg&err=22");
}

}
if($method == "replymsg"){
use_pm();
$PM_TO = $RM_From;
}
if($method == "sendmsg"){
$PM_TO = $MF_MemberID;
if($pm_from > 0){
if($pm_from == $DBMemberID){
$from_name = $DBUserName;
} else {
redirect();
}
}
if($pm_from < 0){
$forum_num = abs($pm_from);
if(allowed($forum_num, 2) == 1){
$from_name = "إشراف ".forums("SUBJECT", $forum_num)."";
} else {
redirect();
}
}
if($pm_from == 0){
$pm_from = $DBMemberID;
$from_name = $DBUserName;
}
}

echo'
<script language="javascript" src="editor/func.js?v=200308170900"></script>
<script language="javascript" src="editor/editor.js?v=200308170900"></script>
<script language="javascript" src="editor/box_color.js?v=200308170900"></script>
<table class="topholder" height="100%" cellSpacing="0" cellPadding="0" width="100%" border="0">
	<tr>
		<td>
		<table dir="'.$lang['global']['dir'].'" class="topholder" cellSpacing="2" width="100%" border="0">
        <form method="post" action="index.php?mode=post_info" name="save_form" id="editor_form">

		<input name="method" type="hidden" value="'.method.'">
		<input name="quote" type="hidden" value="'.quote.'">
		<input name="r" type="hidden" value="'.r.'">
		<input name="t" type="hidden" value="'.t.'">
		<input name="f" type="hidden" value="'.f.'">
		<input name="c" type="hidden" value="'.c.'">
        <input name="m" type="hidden" value="'.m.'">
        <input type="hidden" name="txtPageProperties"  value="" ID="txtPageProperties">
        <input name="pm_from" type="hidden" value="'.$pm_from.'">
        <input name="pm_to" type="hidden" value="'.$PM_TO.'">
        <input name="msg" type="hidden" value="'.$RM_PmID.'">
		<input name="refer" type="hidden" value="'.referer.'">
        <input name="host" type="hidden" value="'.http_host.'">';


if($method == "topic" OR $method == "edit" OR $method == "editreply" OR $method == "reply"){

$Photo =  '<a class="menu" href="index.php?mode=f&f='.$F_ForumID.'">'.icons($F_ForumLogo).'</a>';
$Subject = '<a href="index.php?mode=f&f='.$F_ForumID.'">'.$F_ForumSubject.'</a></font>&nbsp;&nbsp;-&nbsp;'.$txt.'&nbsp;&nbsp;&nbsp;';
}
if($method == "sig"){
if(members("EDIT_SIG", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][edit_sig].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();

}

$Photo =  '<a class="menu" href="index.php?mode=profile&type=details">'.icons($details, "", "").'</a>';
$Subject = '<a class="menu" href="index.php?mode=profile&type=details">'.$lang['editor']['edit_sig'].'</a></font>';
}
if($method == "replymsg"){
  if($PM_TO > 0){
    $Photo =  '<a class="menu" href="index.php?mode=pm&mail=msg&msg='.$msg.'">'.icons($monitor, "", "").'</a>';
    $Subject = '<a class="menu" href="index.php?mode=pm&mail=msg&msg='.$msg.'">'.$lang['editor']['pm_to'].'</a></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?mode=profile&id='.$MF_MemberID.'"><font color="red" size="+1">'.$MF_MemberName.'</font></a>';
    $Subject .= '<br><nobr>'.$lang['editor']['pm_address'].' <input maxLength="100" name="subject" value="'.$RM_Subject.'" style="WIDTH: 400px"></nobr>';
  }
  if($PM_TO < 0){

  $MF_MemberID = abs($PM_TO);

    $Photo =  '<a class="menu" href="index.php?mode=pm&mail=msg&msg='.$msg.'">'.icons($monitor, "", "").'</a>';
    $Subject = '<a class="menu" href="index.php?mode=pm&mail=msg&msg='.$msg.'">'.$lang['editor']['pm_to'].'</a></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?mode=f&f='.$MF_MemberID.'"><font color="red" size="+1">'.$MF_MemberName.'</font></a>';
    $Subject .= '<br><nobr>'.$lang['editor']['pm_address'].' <input maxLength="100" name="subject" value="'.$RM_Subject.'" style="WIDTH: 400px"></nobr>';
  }
}

if($method == "sendmsg"){
  if($m > 0){
   $subject = ''.$lang['editor']['pm_from'].' '.$from_name.' '.$lang['editor']['to'].' '.$MF_MemberName.'';

if($svc == "t"){
$subject = 'رسالة بخصوص موضوعك : '.topics("SUBJECT",$id).'';
$T_TopicMessage = reply_quote(topics("AUTHOR",$id), topics("MESSAGE",$id), base64_decode($tdate));
}

if($svc == "r"){
$subject = 'رسالة بخصوص ردك في موضوع : '.topics("SUBJECT",$id).'';
$reply_send = mysql_fetch_array($mysql->execute("SELECT * FROM {$mysql->prefix}REPLY WHERE REPLY_ID = '$id' "));
$T_TopicMessage = reply_quote($reply_send['R_AUTHOR'], $reply_send['R_MESSAGE'], base64_decode($rdate));
}


    $Photo =  '<a href="index.php?mode=profile&id='.$MF_MemberID.'">'.icons($monitor, "", "").'</a>';
    $Subject = '<a class="menu" href="index.php?mode=profile&id='.$MF_MemberID.'">'.$lang['editor']['pm_to'].'</a></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?mode=profile&id='.$MF_MemberID.'"><font color="red" size="+1">'.$MF_MemberName.'</font></a>';
    $Subject .= '<br><nobr>'.$lang['editor']['pm_address'].' <input maxLength="100" name="subject" value="'.$subject.'" style="WIDTH: 400px"></nobr>';
  }
  if($m < 0){

  $MF_MemberID = abs($m);

    $Photo =  '<a href="index.php?mode=f&f='.$MF_MemberID.'">'.icons($monitor, "", "").'</a>';
    $Subject = '<a class="menu" href="index.php?mode=f&f='.$MF_MemberID.'">'.$lang['editor']['pm_to'].'</a></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?mode=f&f='.$MF_MemberID.'"><font color="red" size="+1">'.$MF_MemberName.'</font></a>';
    $Subject .= '<br><nobr>'.$lang['editor']['pm_address'].' <input maxLength="100" name="subject" value="'.$lang['editor']['pm_from'].' '.$DBUserName.' '.$lang['editor']['to'].' '.$MF_MemberName.'" style="WIDTH: 400px"></nobr>';
  }
}

            echo'
            <tr>
                <td>'.$Photo.'</td>

                <td class="main" vAlign="center" width="100%"><font size="+1">'.$Subject;

if($Mlevel == 4 OR $Monitor_all == 1 OR $Moderator_all == 1){

if($method == "edit"){
    if($T_TopicHidden == 1){
           echo'<input name="hidden" class="small" type="checkbox" value="1" checked><font color="black" size="2">&nbsp;'.$lang['editor']['hide'].'&nbsp;&nbsp;</font>';
    }
    if($T_TopicHidden == 0){
           echo'<input name="hidden" class="small" type="checkbox" value="1"><font color="black" size="2">&nbsp;'.$lang['editor']['hide'].'&nbsp;&nbsp;</font>';
    }
    if($T_TopicStatus == 0){
           echo'<input name="lock" class="small" type="checkbox" value="1" checked><font color="black" size="2">&nbsp;'.$lang['editor']['lock'].'&nbsp;&nbsp;</font>';
    }
    if($T_TopicStatus == 1){
           echo'<input name="lock" class="small" type="checkbox" value="1"><font color="black" size="2">&nbsp;'.$lang['editor']['lock'].'&nbsp;&nbsp;</font>';
    }
    if($T_TopicSticky == 1){
           echo'<input name="sticky" class="small" type="checkbox" value="1" checked><font color="black" size="2">&nbsp;'.$lang['editor']['sticky'].'</font>';
    }
    if($T_TopicSticky == 0){
           echo'<input name="sticky" class="small" type="checkbox" value="1"><font color="black" size="2">&nbsp;'.$lang['editor']['sticky'].'</font>';
    }
}
if($method == "topic"){

           echo'<input name="hidden" class="small" type="checkbox" value="1"><font color="black" size="2">&nbsp;'.$lang['editor']['hide'].'&nbsp;&nbsp;</font>';
           echo'<input name="lock" class="small" type="checkbox" value="1"><font color="black" size="2">&nbsp;'.$lang['editor']['lock'].'&nbsp;&nbsp;</font>';
           echo'<input name="sticky" class="small" type="checkbox" value="1"><font color="black" size="2">&nbsp;'.$lang['editor']['sticky'].'</font>';
}

}
                echo'
                </td>';
if($method == "topic" OR $method == "edit" OR $method == "editreply" OR $method == "reply"){
                echo'
                <td class="menu" align="middle"><nobr><a target="_new" href="index.php?mode=rules">'.$lang['editor']['click_here_to_read_reply_rules'].'</a></nobr></td>';
}
if($method == "topic" OR $method == "edit"){
				$limit_topics = $f_total_topics - $member_topics_today;
				echo'
				<td class="menu" align="middle"><nobr><font color="red">حد المواضيع الجديدة<br>المتبقية لك حاليا<br>في هذا المنتدى:</font>&nbsp;'.$limit_topics.'</nobr></td>';
}
if($method == "editreply" OR $method == "reply"){
				$limit_replies = $f_total_replies - $member_replies_today;
				echo'
				<td class="menu" valign="center" align="middle"><nobr><font color="red">حد الردود الجديدة<br>المتبقية لك حاليا<br>في هذا المنتدى:</font>&nbsp;'.$limit_replies.'</nobr></td>';
}
            echo'
            </tr>';
if($method == "sig"){
$T_TopicMessage = $SIG_MemberSig;
}
if($method == "reply" OR $method == "editreply"){
            echo'
            <tr>
                <td class="main" colSpan="2"><font size="3"><a href="index.php?mode=t&t='.$T_TopicID.'">'.$lang['editor']['the_topic'].' '.$T_TopicSubject.'</a></font> - '.$lang['editor']['the_author'].' '.$T_MemberName.'</td>
            </tr>';

	if($quote == 0){
$T_TopicMessage = $R_ReplyMessage;
	}
	if($quote == 1 && $rdate != ""){
$T_TopicMessage = reply_quote($author, $R_ReplyMessage, base64_decode($rdate));
	}
	if($quote == 1 && $tdate != ""){
$T_TopicMessage = reply_quote($author, $T_TopicMessage, base64_decode($tdate));
	}
//$T_TopicMessage = $R_ReplyMessage;
}
if($method == "topic" OR $method == "edit"){

            echo'
            <tr>
                <td colSpan="2">'.$lang['editor']['topic_address'].' <input maxLength="100" name="subject" value="'.$T_TopicSubject.'" style="WIDTH: 400px"></td>
            </tr>';
}
echo'
        </table>
        </td>
    </tr>
	<tr>
		<td>
		    <table style="display: block; border-left: 1px solid #d9d9d9; border-right: 1px solid #e0e0e0; border-top: 1px solid #d9d9d9; background: #f2f2f6" cellSpacing="0" cellPadding="1" width="100%" border="0" valign="center">
			<tr>
                <td width="100%"></td>
			</tr>
		</table>
		</td>
	</tr>
    <tr>
		<td height="100%">
		<table height="100%" cellSpacing="0" cellPadding="0" width="100%">
			<tr>
				<td>
				<table height="100%" cellSpacing="0" cellPadding="0" width="100%" border="0">
					<tr>
                        <td vAlign="top">
                        <input type="hidden" name="message" id="message">
                        <script>
                          var obj1 = new ACEditor("obj1")

                          obj1.width = "'.$editor_width.'"
                          obj1.height = "'.$editor_height.'"

                          obj1.useSave = '.$EditorIcon[0].'
                          obj1.usePrint = '.$EditorIcon[1].'
                          obj1.useZoom = '.$EditorIcon[2].'
                          obj1.useStyle = '.$EditorIcon[3].'
                          obj1.useParagraph = '.$EditorIcon[4].'
                          obj1.useFontName = '.$EditorIcon[5].'
                          obj1.useSize = '.$EditorIcon[6].'
                          obj1.useText = '.$EditorIcon[7].'
                          obj1.useSelectAll = '.$EditorIcon[8].'
                          obj1.useCut = '.$EditorIcon[9].'
                          obj1.useCopy = '.$EditorIcon[10].'
                          obj1.usePaste = '.$EditorIcon[11].'
                          obj1.useUndo = '.$EditorIcon[12].'
                          obj1.useRedo = '.$EditorIcon[13].'
                          obj1.useBold = '.$EditorIcon[14].'
                          obj1.useItalic = '.$EditorIcon[15].'
                          obj1.useUnderline = '.$EditorIcon[16].'
                          obj1.useStrikethrough = '.$EditorIcon[17].'
                          obj1.useSuperscript = '.$EditorIcon[18].'
                          obj1.useSubscript = '.$EditorIcon[19].'
                          obj1.useSymbol = '.$EditorIcon[20].'
                          obj1.useJustifyLeft = '.$EditorIcon[21].'
                          obj1.useJustifyCenter = '.$EditorIcon[22].'
                          obj1.useJustifyRight = '.$EditorIcon[23].'
                          obj1.useJustifyFull = '.$EditorIcon[24].'
                          obj1.useNumbering = '.$EditorIcon[25].'
                          obj1.useBullets = '.$EditorIcon[26].'
                          obj1.useIndent = '.$EditorIcon[27].'
                          obj1.useOutdent = '.$EditorIcon[28].'
                          obj1.useImage = '.$EditorIcon[29].'
                          obj1.useForeColor = '.$EditorIcon[30].'
                          obj1.useBackColor = '.$EditorIcon[31].'
                          obj1.useExternalLink = '.$EditorIcon[32].'
                          obj1.useInternalLink = '.$EditorIcon[33].'
                          obj1.useAsset = '.$EditorIcon[34].'
                          obj1.useTable = '.$EditorIcon[35].'
                          obj1.useShowBorder = '.$EditorIcon[36].'
                          obj1.useAbsolute = '.$EditorIcon[37].'
                          obj1.useClean = '.$EditorIcon[38].'
                          obj1.useLine = '.$EditorIcon[39].'
                          obj1.usePageProperties = '.$EditorIcon[40].'
                          obj1.useWord = '.$EditorIcon[41].'
                          obj1.ImagePageURL = "editor/box_Image.html"; 
                          obj1.isFullHTML = '.$editor_full_html.'
                          obj1.RUN()
                        </script>
                        </td>
					</tr>
				</table>
				</td>
			</tr>
			<tr height="22">
				<td vAlign="top" noWrap width="100%">
					<table dir="'.$lang['global']['dir'].'" style="border-left: 1px solid #d9d9d9; border-right: 1px solid #e0e0e0; border-top: 1px solid #d9d9d9; background: #f2f2f6" cellSpacing="0" cellPadding="3" width="100%" border="0">
					<tr>';
                        if($Mlevel > 1){
                        echo'
                        <td><nobr><input class="small" type="checkbox" onclick="obj1.setDisplayMode()" id=chkDisplayMode name=chkDisplayMode><font color="gray"><b>'.$lang['editor']['show_html_code'].' &nbsp;&nbsp;&nbsp;</b></font></nobr></td>';
                        }
                        echo'
		                <td><nobr><input class="small" id="chkBreakModeobj1" type="checkbox" name="chkBreakModeobj1"><font color="gray"><b>'.$lang['editor']['new_line'].' &nbsp;&nbsp;&nbsp;</b></font></nobr></td>
		                <td><input id="status" style="font-size: 10px; width: 100px; color: brown; text-align: center; background: #ffff99" onclick="show_text_count()" type="button" value="'.$lang['editor']['ed_cur_size'].'"></td>
                        <td><input style="font-size: 10px; width: 50px; color: brown; text-align: center; background: #ffff99" onclick="copy_right()" type="button" value="'.$lang['editor']['copy_right'].'"></td>
                        <td width="100%">&nbsp;</td>
						<td>
      	                <input type="button" value="'.$lang['editor']['insert_text'].'" onclick="submit_form()" id="Button1" NAME="Button1">&nbsp;&nbsp;
	                    <input type="button" value="'.$lang['editor']['back_normal_text'].'" onclick="return confirm(ed_confirm_reset);">&nbsp;&nbsp;
                        <input type="button" value="'.$lang['editor']['cancel'].'" onclick="window.close();"></td>
					</tr>
				</table>
				</td>
			</tr>
        </form>
		</table>
		</td>
	</tr>
</table>';

echo '<textarea rows="30" cols="100" id="idtextarea" name="idtextarea" style="display:none">'.stripslashes($T_TopicMessage).'</textarea>';

}
else {
redirect();
}
} else {
go_to("index.php?mode=error&type=editor&f=".$f."");
}

mysql_close();
?>
