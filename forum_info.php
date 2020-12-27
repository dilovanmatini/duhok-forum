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

if($Mlevel > 0){

function forum_info_mods($id){
	global $Prefix;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MODERATOR WHERE FORUM_ID = '$id' ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
	$forum_mods = '<table class="mods" cellspacing="0" cellpadding="0"><tr>';
 	$j = 0;
	$i = 0;
	while ($i < $num){
		$member_id = mysql_result($sql, $i, "MEMBER_ID");
		if($j == 5){
			$forum_mods .= '</tr></table><table class="mods" cellspacing="0" cellpadding="0"><tr>';
			$j = 0;
		}
		$forum_mods .= '<td><nobr>&nbsp;';
		if($j){
			$forum_mods .= ' + ';
		}
		$forum_mods .= normal_profile(members("NAME", $member_id), $member_id).'</td>';
	$i++;
	$j++;
	}
	$forum_mods .= '</tr></table>';
return($forum_mods);
}

echo'
<center>
<table dir="rtl" cellSpacing="2" width="99%" border="0" id="table11">
	<tr>
		<td width="100%"></td>';
		go_to_forum();
	echo'
	</tr>
</table>
</center>';

$f_name = forums("SUBJECT", $f);
$f_desc = forums("DESCRIPTION", $f);
$f_topics = forums("TOPICS", $f);
$f_replies = forums("REPLIES", $f);
$f_logo = forums("LOGO", $f);
$f_moderators = forum_info_mods($f);
$f_total_topics = forums("TOTAL_TOPICS", $f);
$f_total_replies = forums("TOTAL_REPLIES", $f);

$cat_id = forums("CAT_ID", $f);
$cat_name = cat("NAME", $cat_id);
$cat_monitor = normal_profile(members("NAME", cat("MONITOR", $cat_id)), cat("MONITOR", $cat_id));
$show_info = cat("SHOW_INFO", $f_cat_id);

echo'
<center>
	<table class="grid" width="60%" cellSpacing="1" cellPadding="4" border="0">
		<tr class="fixed">
			<td class="optionheader" colspan="4"><nobr>بيانات و احصائيات منتدى:&nbsp;<font color="yellow">'.$f_name.'</nobr></td>
		</tr>					
		<tr class="fixed">
			<td class="optionheader"><nobr><font size="-1">إسم المنتدى:</font></nobr></td>
			<td class="list" colSpan="3">
			<table cellSpacing="0" cellPadding="0">
				<tr>
					<td>'.icons($f_logo).'&nbsp;&nbsp;</td>
					<td><font size="4"><a href="index.php?mode=f&f='.$f.'">'.$f_name.'</a></font></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr class="fixed">
			<td class="optionheader"><nobr><font size="-1">القسم التابع له المنتدى:</font></nobr></td>
			<td class="list" colspan="3"><nobr><font color="red">'.$forum_title.':</font>&nbsp;'.$cat_name.'</nobr></td>
		</tr>
		<tr class="fixed">
			<td class="optionheader"><nobr><font size="-1">وصف المنتدى:</font></nobr></td>
			<td class="list" colspan="3"><nobr><font size="2" color="black">'.$f_desc.'</font></nobr></td>
		</tr>';
			if($show_info == 0 AND $Mlevel < 4){
echo'
		<tr class="fixed">
			<td class="optionheader"><nobr><font size="-1">مراقب المنتدى:</font></nobr></td>
			<td class="list" colspan="3"><nobr>'.$cat_monitor.'</nobr></td>
		</tr>';}
			if($show_info == 0 AND $Mlevel == 4){
echo'
		<tr class="fixed">
			<td class="optionheader"><nobr><font size="-1">مراقب المنتدى:</font></nobr></td>
			<td class="list" colspan="3"><nobr>'.$cat_monitor.'</nobr></td>
		</tr>';}
		
	if(forums("SHOW_INFO", $f) == 0 AND $Mlevel < 4){
		echo'
		<tr class="fixed">
			<td class="optionheader"><nobr><font size="-1">مشرفي المنتدى:</font></nobr></td>
			<td class="list" colspan="3"><nobr>';
			if($f_moderators != ""){
				echo $f_moderators;
			}
			else{
				echo 'لا يوجد أي مشرف لهذا المنتدى';
			}
			echo'
			</nobr></td>
		</tr>';
	}else if($Mlevel == 4 ){
		echo'
		<tr class="fixed">
			<td class="optionheader"><nobr><font size="-1">مشرفي المنتدى:</font></nobr></td>
			<td class="list" colspan="3"><nobr>';
			if($f_moderators != ""){
				echo $f_moderators;
			}
			else{
				echo 'لا يوجد أي مشرف لهذا المنتدى';
			}
			echo'
			</nobr></td>
		</tr>';
	}
		echo'
		<tr class="fixed">
			<td class="optionheader"><nobr><font size="-1">عدد مواضيعك اليوم في المنتدى:</font></nobr></td>
			<td class="list" width="60%"><nobr>'.member_topics_today($DBMemberID, $f).'</nobr></td>
			<td class="optionheader"><nobr><font size="-1">الحد الأقصى لكل عضو في 24 ساعة:</font></nobr></td>
			<td class="list" width="10%"><nobr><font color="red">'.$f_total_topics.'</font></nobr></td>
		</tr>
		<tr class="fixed">
			<td class="optionheader"><nobr><font size="-1">عدد ردودك اليوم في المنتدى:</font></nobr></td>
			<td class="list" width="60%"><nobr>'.member_replies_today($DBMemberID, $f).'</nobr></td>
			<td class="optionheader"><nobr><font size="-1">الحد الأقصى لكل عضو في 24 ساعة:</font></nobr></td>
			<td class="list" width="10%"><nobr><font color="red">'.$f_total_replies.'</font></nobr></td>
		</tr>
		<tr class="fixed">
			<td class="optionheader"><nobr><font size="-1">احصائيات المنتدى:</font></nobr></td>
			<td class="list" colspan="3"><nobr>المواضيع:&nbsp;<font color="red">'.$f_topics.'</font>&nbsp;&nbsp;&nbsp;&nbsp;الردود:&nbsp;<font color="red">'.$f_replies.'</font>&nbsp;&nbsp;&nbsp;&nbsp;المواضيع في الأرشيف:&nbsp;<font color="red">0</font></nobr></td>
		</tr>
		<tr class="fixed">
			<td class="optionheader"><nobr><font size="-1">الأعضاء في المنتدى حاليا:</font></nobr></td>
			<td class="list" colspan="3" style="FONT-SIZE: 75%;">';
		if($Mlevel == 1){
			forum_online_name("WHERE O_FORUM_ID = '$f' AND O_MEMBER_LEVEL = '1' AND O_MEMBER_BROWSE = '1' OR O_FORUM_ID = '$f' AND O_MEMBER_LEVEL = '2' AND O_MEMBER_BROWSE = '1' ");
			echo'<font color="red">&nbsp;+&nbsp;أعضاء متخفين:&nbsp;</font>';
			$online_sql = $mysql->execute("SELECT * FROM {$mysql->prefix}ONLINE WHERE O_FORUM_ID = '$f' AND O_MEMBER_LEVEL = '1' AND O_MEMBER_BROWSE = '0' OR O_FORUM_ID = '$f' AND O_MEMBER_LEVEL = '2' AND O_MEMBER_BROWSE = '0' ", [], __FILE__, __LINE__);
			$online_num = mysql_num_rows($online_sql);
			echo $online_num;	
		}
		if($Mlevel > 1){
			forum_online_name("WHERE O_FORUM_ID = '$f' AND O_MEMBER_LEVEL = '1' OR O_FORUM_ID = '$f' AND O_MEMBER_LEVEL = '2'");
		}
			echo'
			</td>
		</tr>
	</table>
</center>';

}else{
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>يجب عليك تسجيل الدخول لتستطيع مشاهدة معلومات المنتدى</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
}
?>