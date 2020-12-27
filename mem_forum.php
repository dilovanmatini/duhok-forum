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

if($type == "c"){

	if($method == "edit"){
 $query = "SELECT * FROM {$mysql->prefix}CATEGORY WHERE CAT_ID = '" . $c . "' ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

$cat_hide = cat("HIDE", $c);

 if(mysql_num_rows($result) > 0){

 $rs=mysql_fetch_array($result);

 $Subject = $rs['CAT_NAME'];
 $MonitorID = $rs['CAT_MONITOR'];

 }
 
 $title = $lang['add_cat_forum']['edit_cat'];
 $title2 = $lang['add_cat_forum']['cat_address'];
 $info = info_icon(1);
	}
	else {
 $title = $lang['add_cat_forum']['add_new_cat'];
 $title2 = $lang['add_cat_forum']['cat_address'];
 $info = info_icon(1);
	}	
}

if($type == "f"){

if($c == ""){
$cat_check = forums("CAT_ID", $f);
} else {
$cat_check = $c;
}

	if($method == "edit"){
		$Subject = forums("SUBJECT", $f);
		$F_Desc = forums("DESCRIPTION", $f);
		$F_Logo = forums("LOGO", $f);
        $F_sex = forums("SEX", $f);
		$F_total_topics = forums("TOTAL_TOPICS", $f);
		$F_total_replies = forums("TOTAL_REPLIES", $f);
		$f_hide = forums("HIDE", $f);
		$hide_mod = forums("HIDE_MOD", $f);
		$hide_photo = forums("HIDE_PHOTO", $f);
		$hide_sig = forums("HIDE_SIG", $f);
		$title = $lang['add_cat_forum']['edit_forum'];
		$title2 = $lang['add_cat_forum']['forum_address'];
		$day_archive = forums("DAY_ARCHIVE", $f);
		$active_archive = forums("CAN_ARCHIVE", $f);
		$info = info_icon(2);
	}
	else {
		$F_total_topics = 5;
		$F_total_replies = 200;
		$f_hide = 0;
		$hide_photo = 0;
		$hide_sig = 0;
		$title = $lang['add_cat_forum']['add_new_forum'];
		$title2 = $lang['add_cat_forum']['forum_address'];
		$day_archive = 30;
		$active_archive = 0;
		$info = info_icon(2);
	}
}


echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="50%">
	<form method="post" action="index.php?mode=cat_forum_info">
	<input type="hidden" name="method" value="'.$method.'">
    <input type="hidden" name="type" value="'.$type.'">
    <input type="hidden" name="cat_id" value="'.$c.'">
    <input type="hidden" name="forum_id" value="'.$f.'">
	
	</tr>';
    echo info_text(1,$lang['info']['write_subject_of_cat'],$title2);
    echo info_text(2,$lang['info']['write_subject_of_forum'],$title2);
if($type == "c"){

if($MonitorID == 0 OR $MonitorID == ""){
$Name = $lang['add_cat_forum']['non_monitor'];
}
else {
$Name = link_profile(member_name($MonitorID), $MonitorID);
}

    echo'

 ';
}
	echo'
	<tr>

		<td class="userdetails_data" colspan="2" align="middle">قائمة الأعضاء المخولين بمشاهدة منتدى<b><font color="#FF0000"> <nobr>  '.$Subject.' </nobr></td>
		</font></b>
		 		</tr>
		<td class="userdetails_data"><nobr>قائمة الأعضاء المخولين لمشاهدة المنتدى</nobr></td>
		<td class="userdetails_data">

		</select>
		'.info_icon(5).'
		</td>
	</tr>
	'.info_text(5, "يمكنك معرفة قائمة الاعضاء المخولين بمشاهدة هذا المنتدى{n}عبر هذا الخيار", "قائمة الأعضاء المخولين لمشاهدة المنتدى");

if($f_hide == 0){
echo'
		</font></b>
		 		</tr>
		<td class="userdetails_data " align="middle"  ><nobr>المنتدى غير مخفي</nobr></td>
		<td class="userdetails_data">

		</select>
		'.info_icon(6).'
		</td>
	</tr>
	'.info_text(6, "يجب أن يكون المنتدى مخفي لتستطيع معرفة الأعضاء  المسموح لهم بمشاهدته{n}يمكنك إخفاء المنتدى عبر تعديله", "المنتدى غير مخفي");

	}
if($f_hide == 1){
	echo'
	</tr>
	'.info_text(8,"ادخل رقم العضو لإضافته لقائمة أعضاء مسموحين بالدخول الى هذا المنتدى{n}ملاحضة: لازم فقط تدخل رقم دون حروف أو رموز أو رقم صفر{n}وأيظاً لازم رقم عضوية يكون صحيح والعضو ليس موجود بالقائمة أعضاء مسموحين بالدخول الى المنتدى","أضف عضو لهذا المنتدى").'
  	<tr class="fixed">
		<td class="userdetails_data"><nobr>لائحة أعضاء مسموحين</nobr></td>
		<td class="userdetails_data">
		<center>
		<table width="40%" cellSpacing="1" cellPadding="2" border="0">
			<tr>
				<td class="stats_h" align="middle">رقم<br>العضوية</td>
				<td class="stats_h" align="middle">اسم العضو</td>
				<td class="stats_h" align="middle">خيارات</td>
			</tr>';
	$forum_hide = $mysql->execute("SELECT * FROM {$mysql->prefix}HIDE_FORUM WHERE HF_FORUM_ID = '$f' ", [], __FILE__, __LINE__);
	$hf_num = mysql_num_rows($forum_hide);
	if($hf_num <= 0){
			echo'
			<tr>
				<td class="stats_p" align="middle" colspan="3"><br><font color="black">حاليا لا يوجد اي عضو مخول لمشاهدة هذا المنتدى</font><br><br></td>
			</tr>';
	}
	$hf_i = 0;
	while ($hf_i < $hf_num){
		$hf_id = mysql_result($forum_hide, $hf_i, "HF_ID");
		$hf_member_id = mysql_result($forum_hide, $hf_i, "HF_MEMBER_ID");
            echo'
            <tr>
                <td class="stats_h" align="middle"><font color="yellow" size="-1">'.$hf_member_id.'</td>
                <td class="stats_p" align="middle"><nobr>'.link_profile(members("NAME", $hf_member_id), $hf_member_id).'</nobr></td>
                <td class="stats_h" align="middle"><a href="index.php?mode=delete&type=del_mem&m='.$hf_id.'&f='.$f.'"  onclick="return confirm(\'هل أنت متأكد بأن تريد حذف هذا العضو من لائحة أعضاء مسموحين\');">'.icons($icon_trash, "انقر هنا لحذف هذا العضو من اللائحة").'</a></td>
            </tr>';
	++$hf_i;
	} 
		echo'
        </table>
		</center>
		</td>
	</tr>';
}

	echo'
    </form>
</center><br>';

}



else {
redirect();
}
mysql_close();
?>
