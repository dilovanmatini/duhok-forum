<?php
/**
 * 
 * Duhok Forum 3.0
 * @author		Dilovan Matini (original founder)
 * @copyright	2007 - 2021 Dilovan Matini
 * @see			df.lelav.com
 * @see			https://github.com/dilovanmatini/duhok-forum
 * @license		http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note		This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY;
 * 
 */

const _df_script = "admintools";
const _df_filename = "admintools.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
if(ulv == 4){
//*********** start page ****************************************

if(type == ""){
echo'
	
	<table class="border" width="40%" cellSpacing="1" cellPadding="2" align="center" border="0">
		<tr>
			<td class="menuOptions" colSpan="2">خيارات ادارية</td>
		</tr>
			<td class="cellTitle"><nobr><b>إبحث عن إسم عضوية :</b></nobr></td>
			<form name="details" method="post" action="admintools.php?type=search">
			<input type="hidden" name="type" value="search">
			<td class="cellText">
			<input type="text" name="search" size="18">
			&nbsp;&nbsp;<input class="button" type="submit" value="&nbsp;بحث&nbsp;&nbsp;"></td>
			</form>
		</tr>
			<td class="cellTitle"><nobr><b>تعديل العضوية</b></nobr></td>
			<form name="details" method="get" action="adminsvc.php?type=edit_pass">
			<input type="hidden" name="type" value="edituser">
			<td class="cellText">رقم العضوية
			<input type="text" name="u" size="7">
			&nbsp;&nbsp;<input class="button" type="submit" value="ادخال"></td>
			</form>
		</tr>
	<tr>
			<td class="cellTitle"><nobr><b>تعديل الكلمة السرية</b></nobr></td>
			<form name="details" method="get" action="admintools.php?type=edit_pass">
			<input type="hidden" name="type" value="edit_pass">
			<td class="cellText">رقم العضوية
			<input type="text" name="u" size="7">
			&nbsp;&nbsp;<input class="button" type="submit" value="ادخال"></td>
			</form>
		</tr>
	<tr>
			<td class="cellTitle"><nobr><b>قفل / فتح العضوية</b></nobr></td>
			<form name="details" method="get" action="admintools.php?type=edit_status">
			<input type="hidden" name="type" value="edit_status">
			<td class="cellText">رقم العضوية
			<input type="text" name="u" size="7">
			&nbsp;&nbsp;<input class="button" type="submit" value="ادخال"></td>
			</form>
		</tr>
		
		</table>';
}
elseif(type == "edit_pass"){
	$sql=$mysql->query("SELECT 
	name FROM ".prefix."user  WHERE id = '".u."'", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	if($rs){
echo"
		<table class=\"border\" width=\"60%\" cellSpacing=\"1\" cellPadding=\"6\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admintools.php?type=updatepass&u=".u."\" onSubmit=\"return confirm('هل انت متأكد من تغيير الكلمة السرية لهذه العضوية ؟');\">
			<tr>
				<td class=\"menuOptions\" colspan=\"2\">تغيير الكلمة السرية لـ : {$rs['name']}</td>
			</tr>
			<tr>
				<td class=\"cellTitle\"><nobr>الكلمة السرية</nobr></td>
				<td class=\"cellText\">
				<input size=\"20\" name=\"pass\">
				</td>
			</tr>
			<tr>
				<td class=\"cellText\" align=\"center\" colspan=\"2\"><input class=\"button\" type=\"submit\" value=\"تغيير الكلمة السرية\">&nbsp;&nbsp;<input class=\"button\" type=\"reset\" value=\"ارجاع بيانات الأصلية\"></td>
			</tr>
		</form>
		</table>";
}
	else{
		$Template->errMsg("رقم العضوية الذي اخترت هو خاطيء");
	}
	}
elseif(type == "edit_status"){
	$sql=$mysql->query("SELECT 
	name,status FROM ".prefix."user  WHERE id = '".u."'", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	if($rs){
		echo"
		<table class=\"border\" width=\"60%\" cellSpacing=\"1\" cellPadding=\"6\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admintools.php?type=updateuser&u=".u."\" onSubmit=\"return confirm('هل أنت متأكد بأن تريد تعديل هذه العضوية ؟');\">
			<tr>
				<td class=\"menuOptions\" colspan=\"2\">تغيير وضعية عضوية {$rs['name']}</td>
			</tr>
			<tr>
				<td class=\"cellTitle\"><nobr>الوضعية</nobr></td>
				<td class=\"cellText\">
				<select class=\"dark\" name=\"status\">
					<option value=\"0\"{$DF->choose($rs['status'],0,'s')}>مقفولة</option>
					<option value=\"1\"{$DF->choose($rs['status'],1,'s')}>مفتوحة</option>
					<option value=\"2\"{$DF->choose($rs['status'],2,'s')}>تنتظر الموافقة</option>
				</select>
				</td>
			</tr>
			<tr>
				<td class=\"cellText\" align=\"center\" colspan=\"2\"><input class=\"button\" type=\"submit\" value=\"تغيير وضعية العضوية\">&nbsp;&nbsp;<input class=\"button\" type=\"reset\" value=\"ارجاع بيانات الأصلية\"></td>
			</tr>
		</form>
		</table>";
	}
	else{
		$Template->errMsg("رقم العضوية الذي اخترت هو خاطيء");
	}
}
elseif(type == "updateuser"){
	$status=$_POST['status'];
	$mysql->update("user SET status = '$status' WHERE id = '".u."'", __FILE__, __LINE__);
		$Template->msg("تم حفظ التغيرات بنجاح","profile.php?u=".u);
	}
elseif(type == "updatepass"){
	$pass=$_POST['pass'];
	if(empty($pass)){
		$Template->errMsg("يجب ان تكتب الكلمة السرية");
	}else{
	 $code = rand(000,999);
	$mysql->update("user SET password = '".md5($code.$pass)."' WHERE id = '".u."'", __FILE__, __LINE__);
	$mysql->update("user SET code = '$code' WHERE id = '".u."'", __FILE__, __LINE__);
		$Template->msg("تم حفظ التغيرات بنجاح","profile.php?u=".u);
	}
	}


//*********** end page ****************************************

elseif(type == "search"){
$search=$_POST['search'];
	if(empty($search)){
		$Template->errMsg("لم تقم بكتابة كلمة البحث");
	}else {
	 
    $s=mysql_query("select * from ".prefix."user where name LIKE '%$search%' ")or die(ms_error(__LINE__));
    $n=mysql_num_rows($s);
	if ($n <= 0) {
	$Template->errMsg("لا توجد اي نتائج  لبحثك");
	}
	$y=0;
	echo'<table class="border" width="20%" cellSpacing="1" cellPadding="2" align="center" border="0">
		<tr>
			<td class="menuOptions" colSpan="2">نتائج بحثك</td>
		</tr>';
    for($x=0;$x<$n;++$x){
	$id=mysql_result($s,$x,"id");
	$name=mysql_result($s,$x,"name");
	print '<table class="border" border="0" cellSpacing="1" cellPadding="2" width="20%" align="center"><tr>
			<td class="cellText"><a href="profile.php?u='.$id.'">'.$name.'</a></td>
			</tr></table>
';
		$y++;
    }
	}
}

}
else{
	$DF->goTo();
}
$Template->footer();
?>