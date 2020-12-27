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
 $cat_level =  $rs['CAT_LEVEL'];
 $site_id =  $rs['SITE_ID'];
 $cat_index =  $rs['SHOW_INDEX'];
 $cat_info =  $rs['SHOW_INFO'];
 $cat_profile =  $rs['SHOW_PROFILE'];

 }
 
 $title = $lang['add_cat_forum']['edit_cat'];
 $title2 = $lang['add_cat_forum']['cat_address'];
 $info = info_icon(1);
	}
	else {
 $title = $lang['add_cat_forum']['add_new_cat'];
 $title2 = $lang['add_cat_forum']['cat_address'];
 $info = info_icon(1);
 		$cat_index  = 0;
		$cat_info  = 0;
		$cat_profile  = 0;

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
        $f_level = forums("F_LEVEL", $f);


		$moderate_topic  = forums("MODERATE_TOPIC", $f);
		$moderate_reply  = forums("MODERATE_REPLY", $f);
		$moderate_post = forums("MODERATE_POSTS", $f);
		$moderate_date = forums("MODERATE_DAYS", $f);


		$show_index = forums("SHOW_INDEX", $f);
		$show_frm = forums("SHOW_FRM", $f);
		$show_info = forums("SHOW_INFO", $f);  
		$show_profile = forums("SHOW_PROFILE", $f);  



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

		$moderate_topic  = 1;
		$moderate_reply  = 1;
		$moderate_post  = 35;
		$moderate_date = 15;

		$show_index  = 0;
		$show_frm  = 0;
		$show_info  = 0;
		$show_profile = 0 ;
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
	
	<tr>
		<td class="cat" colspan="2" align="middle">'.$title.'</td>
	</tr>
	<tr class="fixed">
		<td class="userdetails_data" id="row_title2" ><nobr>'.$title2.'</nobr></td>
		<td class="middle"><input  onchange="check_changes(row_title2, \''.$Subject.'\', this.value)"  type="text" name="add_subject" size="50" value="'.$Subject.'">'.$info.'</td>
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
<tr class="fixed">
		<td class="userdetails_data" id="row_site_id" ><nobr>الموقع</nobr></td>
		<td class="userdetails_data"><select onchange="check_changes(row_site_id, \''.$site_id.'\', this.value)"  class="insidetitle" name="site_id" size="1">
			<option value="1" '.check_select($site_id, "1").'>1</option>
			<option value="2" '.check_select($site_id, "2").'>2</option>
			<option value="3" '.check_select($site_id, "3").'>مشترك</option>
	</select></td>
	</tr>
<tr class="fixed">
		<td class="userdetails_data" id="row_cat_level"><nobr>المجموعة</nobr></td>
		<td class="userdetails_data"><select  onchange="check_changes(row_cat_level, \''.$cat_level.'\', this.value)"  class="insidetitle" name="cat_level" size="1">
			<option value="0" '.check_select($cat_level, "0").'>للكل</option>
			<option value="1" '.check_select($cat_level, "1").'>الاعضاء</option>
			<option value="2" '.check_select($cat_level, "2").'>المشرفين</option>
			<option value="3" '.check_select($cat_level, "3").'>المراقبين</option>
			<option value="4" '.check_select($cat_level, "4").'>الاداريين</option>
	</select>
		'.info_icon(6).'</td>
	</tr>
'.info_text(6, "قم بتحديد المجموعة التي تريد ان تظهر الفئة لها", "المجموعة").'
	<tr class="fixed">
		<td class="userdetails_data" id="row_MonitorID"><nobr>'.$lang['add_cat_forum']['add_mon_to_this_cat'].'</nobr></td>
		<td class="userdetails_data"><input onchange="check_changes(row_MonitorID, \''.$MonitorID.'\', this.value)" type="text" name="mon_memberid" size="1" value="'.$MonitorID.'">&nbsp;'.$lang['add_cat_forum']['note_just_insert_nuber_of_member'].'</td>
	</tr>
	<tr class="fixed">
		<td class="userdetails_data"><nobr>'.$lang['add_cat_forum']['mon_name'].'</nobr></td>
		<td class="userdetails_data">'.$Name.'</td>
	</tr>
			<td class="userdetails_data"><nobr>عرض  المراقب بالصفحة الرئيسية </nobr></td>
		<td class="userdetails_data">
		<input class="small" type="radio" name="cat_index" value="0" '.check_radio($cat_index, "0").'>نعم
		<input class="small" type="radio" name="cat_index" value="1" '.check_radio($cat_index, "1").'>لا
			</tr>
	</tr>
			<td class="userdetails_data"><nobr>عرض  المراقب بصفحة معلومات حول المنتدى </nobr></td>
		<td class="userdetails_data">
		<input class="small" type="radio" name="cat_info" value="0" '.check_radio($cat_info, "0").'>نعم
		<input class="small" type="radio" name="cat_info" value="1" '.check_radio($cat_info, "1").'>لا
			</tr>
	</tr>
			<td class="userdetails_data"><nobr>عرض وصف الفئة بصفحة المراقب </nobr></td>
		<td class="userdetails_data">
		<input class="small" type="radio" name="cat_profile" value="0" '.check_radio($cat_profile, "0").'>نعم
		<input class="small" type="radio" name="cat_profile" value="1" '.check_radio($cat_profile, "1").'>لا
			</tr>
	</tr>
	<tr>
		<td class="cat" colspan="2" align="middle">خيارات أخفاء الفئة</td>
	</tr>
 	<tr class="fixed">
		<td class="userdetails_data" id="row_cat_hide" ><nobr>إخفاء الفئة</nobr></td>
		<td class="userdetails_data">
		<select   onchange="check_changes(row_cat_hide, \''.$cat_hide.'\', this.value)" class="insidetitle" name="cat_hide" size="1">
			<option value="0" '.check_select($cat_hide, "0").'>لا</option>
			<option value="1" '.check_select($cat_hide, "1").'>نعم</option>
	</select>
		'.info_icon(5).'
		</td>
	</tr>
	'.info_text(5, "إذا تم أخفاء الفئة تظهر فقط لمن يشاهد منتدى معين بها", "أخفاء الفئة").'

	<tr class="fixed">
		<td colspan="2" align="middle"><input type="submit" value="'.$lang['add_cat_forum']['ok'].'">&nbsp;&nbsp;<input type="reset" value="'.$lang['add_cat_forum']['reset'].'"></td>
	</tr>
 ';
}

if($type == "f"){

	echo'
	<tr class="fixed">
		<td class="userdetails_data" id="row_cat_choose" ><nobr>الفئة</nobr></td>
		<td class="userdetails_data">
			<select  onchange="check_changes(row_cat_choose, \''.$cat_choose.'\', this.value)"  class="insidetitle" name="cat_choose" size="1">';
		$cat = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY ORDER BY CAT_ORDER ASC") or die     (mysql_error());
		$c_num = mysql_num_rows($cat);
		$c_i = 0;
		while ($c_i < $c_num){
		$cat_id = mysql_result($cat, $c_i, "CAT_ID");
    	$cat_subject = mysql_result($cat, $c_i, "CAT_NAME");
		echo '<option value="'.$cat_id.'" '.check_select($cat_check, $cat_id).'>'.$cat_subject.'</option>';
			$c_i++;
			}
	echo'</select>
	'.info_icon(10).'
	</tr>
	'.info_text(10,"هنا يمكنك أختيار الفئة وحتى لو تم وضع المنتدى يمكنك نقل المنتدى","الفئة").'
	<tr class="fixed">
		<td class="userdetails_data" id="row_forum_logo" ><nobr>'.$lang['add_cat_forum']['forum_logo'].'</nobr></td>
		<td class="middle"><input onchange="check_changes(row_forum_logo, \''.$forum_logo.'\', this.value)" dir="ltr" type="text" name="forum_logo" size="50" value="'.$F_Logo.'">'.info_icon(4).'</td>
	</tr>
    '.info_text(4,$lang['info']['info_insert_forum_logo'],$lang['add_cat_forum']['forum_logo']).'

<tr class="fixed">
		<td class="userdetails_data" id="row_f_level" ><nobr>المجموعة</nobr></td>
		<td class="userdetails_data"><select onchange="check_changes(row_f_level, \''.$f_level.'\', this.value)" class="insidetitle" name="f_level" size="1">
			<option value="0" '.check_select($f_level, "0").'>للكل</option>
			<option value="1" '.check_select($f_level, "1").'>الاعضاء</option>
			<option value="2" '.check_select($f_level, "2").'>المشرفين</option>
			<option value="3" '.check_select($f_level, "3").'>المراقبين</option>
			<option value="4" '.check_select($f_level, "4").'>الاداريين</option>
	</select>
		'.info_icon(110).'</td>
	</tr>
'.info_text(110, "قم بتحديد المجموعة التي تريد ان تظهر المنتدى لها", "المجموعة").'
<tr class="fixed">
		<td class="userdetails_data" id="row_F_sex"><nobr>المنتدى خاص لجنس</nobr></td>
		<td class="userdetails_data">
		<select onchange="check_changes(row_F_sex, \''.$F_sex.'\', this.value)" class="insidetitle" name="f_sex" size="1">
			<option value="0" '.check_select($F_sex, "0").'>للكل</option>
			<option value="1" '.check_select($F_sex, "1").'>ذكر</option>
            <option value="2" '.check_select($F_sex, "2").'>أنثى</option>
		</select>
		'.info_icon(30).'
		</td>
	</tr>
	'.info_text(30, "هنا يمكنك أختيار جنس المنتدى أي الجنس الذين يستطيعون المشاركة به", "نوع جنس المنتدى");

	echo '<tr class="fixed">
		<td class="userdetails_data" id="row_forum_desc" ><nobr>'.$lang['add_cat_forum']['about_forum'].'</nobr></td>
		<td><textarea onchange="check_changes(row_forum_desc, \''.$forum_desc.'\', this.value)" cols="50" rows="10" name="forum_desc">'.$F_Desc.'</textarea></td>
	</tr>
	<tr>
		<td class="cat" colspan="2" align="middle">خيارات عدد مواضيع والردود للعضو</td>
	</tr>
 	<tr class="fixed">
		<td class="userdetails_data" id="row_total_topics" ><nobr>عدد المواضيع العضو</nobr></td>
		<td class="userdetails_data"><input  onchange="check_changes(row_total_topics, \''.$total_topics.'\', this.value)"  type="text" name="total_topics" value="'.$F_total_topics.'" size="1">'.info_icon(6).'</td>
	</tr>
	'.info_text(6, "حدد أقصى عدد المواضيع للعضو خلال 24 ساعة في هذا المنتدى", "عدد المواضيع العضو").'
 	<tr class="fixed"> 
		<td class="userdetails_data" id="row_total_replies" ><nobr>عدد الردود العضو</nobr></td>
		<td class="userdetails_data"><input  onchange="check_changes(row_total_replies, \''.$total_replies.'\', this.value)" type="text" name="total_replies" value="'.$F_total_replies.'" size="1">'.info_icon(7).'</td>
	</tr>
	'.info_text(7, "أقصى عدد الردود للعضو خلال 24 ساعة في هذا المنتدى", "عدد الردود العضو");


echo '<tr>
		<td class="cat" colspan="2" align="middle">خيارات الارشيف</td>
	</tr>
 	<tr class="fixed">
		<td class="userdetails_data" id="row_day_archive" ><nobr>عدد الايام </nobr></td>
		<td class="userdetails_data"><input  onchange="check_changes(row_day_archive, \''.$day_archive.'\', this.value)" type="text" name="day_archive" value="'.$day_archive.'" size="1">'.info_icon(102).'</td>
	</tr>
	'.info_text(102, "حدد عدد الايام المطلوبة حتى يتم ترحيل المواضيع التي مرت عليها الى الارشيف في هذا المنتدى", "عدد الايام").'
 	<tr class="fixed"> 
		<td class="userdetails_data" id="row_active_archive"><nobr>تفعيل الارشيف</nobr></td>
		<td class="userdetails_data">
		<input  onchange="check_changes(row_active_archive, \''.$active_archive.'\', this.value)" class="small" type="radio" name="active_archive" value="0" '.check_radio($active_archive, "0").'>نعم
		<input  onchange="check_changes(row_active_archive, \''.$active_archive.'\', this.value)" class="small" type="radio" name="active_archive" value="1" '.check_radio($active_archive, "1").'>لا
		</td>
	</tr>';


//################### MODERATE TOOLS BY ملك المستقبل /  AYOUB ######################


echo '<tr>
		<td class="cat" colspan="2" align="middle">خيارات المراقبة'.info_icon(1111).'</td>
</td>
	</tr>
	'.info_text(1111, "لن تظهر مواضيع الأعضاء و المشرفين و المراقبين إلا بعد الموافقة عليها .", "خيارات المراقبة").'
	</tr>

	</tr>
	 	<tr class="fixed"> 
		<td class="userdetails_data" id="row_moderate_topic"><nobr>مراقبة المواضيع</nobr></td>
		<td class="userdetails_data">
		<input  onchange="check_changes(row_moderate_topic, \''.$moderate_topic.'\', this.value)" class="small" type="radio" name="moderate_topic" value="0" '.check_radio($moderate_topic, "0").'>نعم
		<input  onchange="check_changes(row_moderate_topic, \''.$moderate_topic.'\', this.value)" class="small" type="radio" name="moderate_topic" value="1" '.check_radio($moderate_topic, "1").'>لا
		</td>
 	<tr class="fixed"> 
		<td class="userdetails_data" id="row_moderate_reply"><nobr>مراقبة الردود</nobr></td>
		<td class="userdetails_data">
		<input  onchange="check_changes(row_moderate_reply, \''.$moderate_reply.'\', this.value)" class="small" type="radio" name="moderate_reply" value="0" '.check_radio($moderate_reply, "0").'>نعم
		<input  onchange="check_changes(row_moderate_reply, \''.$moderate_reply.'\', this.value)" class="small" type="radio" name="moderate_reply" value="1" '.check_radio($moderate_reply, "1").'>لا
		</td>
		 
';





//################### MEMBERS DETAILS ######################
	echo'
	<tr>
		<td class="cat" colspan="2" align="middle">خيارات عرض تواقيع وصور الأعضاء الشخصية</td>
	</tr>
 	<tr class="fixed">
		<td class="userdetails_data"  id="row_hide_photo" ><nobr>عرض الصور الشخصية للأعضاء</nobr></td>
		<td class="userdetails_data">
		<input onchange="check_changes(row_hide_photo, \''.$hide_photo.'\', this.value)"  class="small" type="radio" name="hide_photo" value="0" '.check_radio($hide_photo, "0").'>نعم
		<input onchange="check_changes(row_hide_photo, \''.$hide_photo.'\', this.value)"  class="small" type="radio" name="hide_photo" value="1" '.check_radio($hide_photo, "1").'>لا
		</td>
	</tr>
		<td class="userdetails_data"  id="row_hide_sig" ><nobr>عرض تواقيع الأعضاء</nobr></td>
		<td class="userdetails_data">
		<input onchange="check_changes(row_hide_sig, \''.$hide_photo.'\', this.value)"  class="small" type="radio" name="hide_sig" value="0" '.check_radio($hide_sig, "0").'>نعم
		<input onchange="check_changes(row_hide_sig, \''.$hide_photo.'\', this.value)"  class="small" type="radio" name="hide_sig" value="1" '.check_radio($hide_sig, "1").'>لا
		</td>
	</tr>';
//################### By AYOUB ######################
	echo'
	<tr>
		<td class="cat" colspan="2" align="middle">خيارات مشرفين المنتدى</td>
	</tr>
	</tr>
		<td class="userdetails_data"><nobr>عرض المشرفين بالصفحة الرئيسية </nobr></td>
		<td class="userdetails_data">
		<input class="small" type="radio" name="show_index" value="0" '.check_radio($show_index, "0").'>نعم
		<input class="small" type="radio" name="show_index" value="1" '.check_radio($show_index, "1").'>لا
			</tr>
	</tr>
		<td class="userdetails_data"><nobr>عرض المشرفين بصفحة المنتدى </nobr></td>
		<td class="userdetails_data">
		<input class="small" type="radio" name="show_frm" value="0" '.check_radio($show_frm, "0").'>نعم
		<input class="small" type="radio" name="show_frm" value="1" '.check_radio($show_frm, "1").'>لا
			</tr>
	</tr>
		<td class="userdetails_data"><nobr>عرض وصف المنتدى بصفحة المشرفين </nobr></td>
		<td class="userdetails_data">
		<input class="small" type="radio" name="show_profile" value="0" '.check_radio($show_profile , "0").'>نعم
		<input class="small" type="radio" name="show_profile" value="1" '.check_radio($show_profile , "1").'>لا
			</tr>
	</tr>
		<td class="userdetails_data"><nobr>عرض المشرفين بصفحة معلومات عن المنتدى </nobr></td>
		<td class="userdetails_data">
		<input class="small" type="radio" name="show_info" value="0" '.check_radio($show_info, "0").'>نعم
		<input class="small" type="radio" name="show_info" value="1" '.check_radio($show_info, "1").'>لا
 	<tr class="fixed">
		<td class="userdetails_data" id="row_mod_memberid" ><nobr>'.$lang['add_cat_forum']['add_mod_to_this_forum'].'</nobr></td>
		<td class="userdetails_data"><input onchange="check_changes(row_mod_memberid, \''.$mod_memberid.'\', this.value)" type="text" name="mod_memberid" size="1">'.info_icon(9).'</td>
	</tr>
	'.info_text(9,"ادخل رقم العضو لإضافته لقائمة مشرفين هذا المنتدى{n}ملاحضة: لازم فقط تدخل رقم دون حروف أو رموز أو رقم صفر{n}وأيظاً لازم رقم عضوية يكون صحيح والعضو ليس موجود بالقائمة مشرفين هذا المنتدى", $lang['add_cat_forum']['add_mod_to_this_forum']).'
  	<tr class="fixed">
		<td class="userdetails_data"><nobr>'.$lang['add_cat_forum']['forum_modetaror_list'].'</nobr></td>
		<td class="userdetails_data">';

        echo'<center>
        <table width="50%" cellSpacing="1" cellPadding="2" border="0">
            <tr>
                <td class="stats_h" align="middle">'.$lang['add_cat_forum']['number_mod'].'</td>
                <td class="stats_h" align="middle">'.$lang['add_cat_forum']['number_id'].'</td>
                <td class="stats_h" align="middle">'.$lang['add_cat_forum']['mod_name'].'</td>
                <td class="stats_h" align="middle">'.$lang['add_cat_forum']['options'].'</td>
            </tr>';


 	$query = "SELECT * FROM {$mysql->prefix}MODERATOR ";
    $query .= " WHERE FORUM_ID = '$f' ";
	$query .= " ORDER BY MOD_ID ASC";
	$result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

	$num = mysql_num_rows($result);


	if($num <= 0){
            echo'
            <tr>
                <td class="stats_p" align="middle" colspan="4"><br><font color="black">'.$lang['add_cat_forum']['non_moderator'].'</font><br><br></td>
            </tr>';
    }

$i=0;
while ($i < $num){

    $ModModerator_ID = mysql_result($result, $i, "MOD_ID");
    $ModForum_ID = mysql_result($result, $i, "FORUM_ID");
    $ModMember_ID = mysql_result($result, $i, "MEMBER_ID");
            
            echo'
            <tr>
                <td class="stats_h" align="middle"><font color="yellow" size="-1">'.$ModModerator_ID.'</td>
                <td class="stats_g" align="middle"><font color="blue" size="-1">'.$ModMember_ID.'</td>
                <td class="stats_p" align="middle"><nobr>'.link_profile(member_name($ModMember_ID), $ModMember_ID).'</nobr></td>
                <td class="stats_h" align="middle"><a href="index.php?mode=delete&type=del_mod&m='.$ModModerator_ID.'&f='.$f.'"  onclick="return confirm(\''.$lang['add_cat_forum']['you_are_sure_to_delete_this_mod'].'\');">'.icons($icon_trash, $lang['add_cat_forum']['delete_mod'], "").'</a></td>
            </tr>';
            
            
    ++$i;
}
            
//################### MEMBERS DETAILS ######################
if($type == "liste"){

	echo'
	<tr>
		<td class="cat" colspan="2" align="middle">خيارات مشرفين المنتدى</td>
	</tr>
 	<tr class="fixed">
		<td class="userdetails_data" ><nobr>'.$lang['add_cat_forum']['add_mod_to_this_forum'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="mod_memberid" size="1">'.info_icon(9).'</td>
	</tr>
	'.info_text(9,"ادخل رقم العضو لإضافته لقائمة مشرفين هذا المنتدى{n}ملاحضة: لازم فقط تدخل رقم دون حروف أو رموز أو رقم صفر{n}وأيظاً لازم رقم عضوية يكون صحيح والعضو ليس موجود بالقائمة مشرفين هذا المنتدى", $lang['add_cat_forum']['add_mod_to_this_forum']).'
  	<tr class="fixed">
		<td class="userdetails_data"><nobr>'.$lang['add_cat_forum']['forum_modetaror_list'].'</nobr></td>
		<td class="userdetails_data">';

        echo'<center>
        <table width="50%" cellSpacing="1" cellPadding="2" border="0">
            <tr>
                <td class="stats_h" align="middle">'.$lang['add_cat_forum']['number_mod'].'</td>
                <td class="stats_h" align="middle">'.$lang['add_cat_forum']['number_id'].'</td>
                <td class="stats_h" align="middle">'.$lang['add_cat_forum']['mod_name'].'</td>
                <td class="stats_h" align="middle">'.$lang['add_cat_forum']['options'].'</td>
            </tr>';
}
            
        echo'
        </table>
        </center>';


        echo'</td>
	</tr>';
 
	echo'
	<tr>
		<td class="cat" colspan="2" align="middle">خيارات إخفاء المنتدى</td>
	</tr>
 	<tr class="fixed">
		<td class="userdetails_data" id="row_f_hide" ><nobr>إخفاء المنتدى</nobr></td>
		<td class="userdetails_data">
		<select onchange="check_changes(row_f_hide, \''.$f_hide.'\', this.value)"   class="insidetitle" name="f_hide" size="1">
		<option  value="0" '.check_select($f_hide, "0").'>لا</option>
		<option  value="1" '.check_select($f_hide, "1").'>نعم</option>
		</select>
		'.info_icon(5).'
		</td>
	</tr>
	'.info_text(5, "بهذا الخيار تستطيع اخفاء المنتدى للأعضاء وفتحه فقط للأعضاء معينين{n}ويمكنك إضافة اعضاء لقائمة اعضاء مسموحين بالدخول الى هذا المنتدى في خيار أدناه", "إخفاء المنتدى");

	echo'
 	<tr class="fixed">
		<td class="userdetails_data" id="row_hide_mod" ><nobr>إخفاء مشرفي المنتدى</nobr></td>
		<td class="userdetails_data">
		<select onchange="check_changes(row_hide_mod, \''.$hide_mod.'\', this.value)" class="insidetitle" name="hide_mod" size="1">
			<option value="0" '.check_select($hide_mod, "0").'>لا</option>
			<option value="1" '.check_select($hide_mod, "1").'>نعم</option>
		</select>
		'.info_icon(20).'
		</td>
	</tr>
	'.info_text(20, "هنا يمكنك أخفاء مشرفي المنتدى داخل المنتدى حيث لا يظهر المشرفين ", "إخفاء مشرفي المنتدى");
if($f_hide == 1){
	echo'
 	<tr class="fixed">
		<td class="userdetails_data" id="row_hf_member_id" ><nobr>أضف عضو لهذا المنتدى</nobr></td>
		<td class="userdetails_data"><input  onchange="check_changes(row_hf_member_id, \''.$hf_member_id.'\', this.value)"  type="text" name="hf_member_id" size="1">'.info_icon(8).'</td>
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
				<td class="stats_p" align="middle" colspan="3"><br><font color="black">لا توجد أي عضو مسموح للدخول الى هذا المنتدي</font><br><br></td>
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
	<tr>
		<td class="cat" colspan="2" align="middle">احصائيات المنتدى</td>
	</tr>
 	<tr class="fixed">
		<td class="userdetails_data"><nobr>اعضاء</nobr></td>
		<td class="userdetails_data">
<input type="button" value="الاحصائيات" onclick="window.location=\'index.php?mode=admin_svc&type=m_stat&method=member&f='.$f.'\'">
		</td>
	</tr>
 	<tr class="fixed">
		<td class="userdetails_data"><nobr>مشرفين</nobr></td>
		<td class="userdetails_data">
<input type="button" value="الاحصائيات" onclick="window.location=\'index.php?mode=admin_svc&type=m_stat&method=modo&f='.$f.'\'">
		</td></tr>';
	echo'
	<tr class="fixed">
		<td colspan="2" align="middle"><input type="submit" value="'.$lang['add_cat_forum']['ok'].'">&nbsp;&nbsp;<input type="reset" value="'.$lang['add_cat_forum']['reset'].'"></td>
	</tr>
	</table>
    </form>
</center><br>';

}


}
else {
redirect();
}
mysql_close();
?>
