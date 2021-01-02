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

if( _df_script == 'svc' && this_svc == 'modblock' && ulv > 2 ){

// ************ start page ****************
if( type=='user' ){
	$mod_bloc = $mysql->get("moderator", "block", u, "userid");
	print $mod_bloc;
	if($mod_bloc == 0){
		$step=1;
		?>
		<script type="text/javascript">
		DF.checkSubmit=function(frm){
			if(frm.cause.value.length<5){
				alert("يجب أن يكون السبب أطول من 5 حروف");
			}
			else{
				frm.submit();
			}
		};
		</script>
		<?php
		$button_title ="تجميد الإشراف";
	}
	elseif($mod_bloc==1){
		$step=0;
		?>
		<script type="text/javascript">
		DF.checkSubmit=function(frm){
			frm.submit();
		};
		</script>
		<?php
		$button_title ="إلغاء تجميد الإشراف";
	}
	$rs=$mysql->queryRow("SELECT name FROM ".prefix."user WHERE id = '".u."' AND status IN (0,1)", __FILE__, __LINE__);
	if(!$rs){
		$DF->goTo();
		exit();
	}
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<tr>
		<td class=\"asHeader asAC2\" colspan=\"5\">تفاصيل إشراف : {$Template->userNormalLink(u,$rs[0])}</td>
	</tr>
	<tr>
		<td class=\"asDarkB\"><nobr>الرقم</nobr></td>
		<td class=\"asDarkB\"><nobr>العملية</nobr></td>
		<td class=\"asDarkB\"><nobr>السبب</nobr></td>
		<td class=\"asDarkB\"><nobr>المستخدم</nobr></td>
		<td class=\"asDarkB\">التاريخ</td>
	</tr>";
	$sql=$mysql->query("SELECT * FROM ".prefix."moderator_block where userid = ".u." ", __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		echo"
		<tr>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['id']}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$DF->iff($rs['type']==0,'<font color="green">إلغاء التجميد</font>','<font color="red">تجميد الإشراف </font>')}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>{$DF->iff($rs['cause']=='','--',$rs['cause'])}</nobr></td>
			<td class=\"asNormalB asCenter\"><nobr>{$Template->userColorLink($rs['block_id'])}</nobr></td>
			<td class=\"asNormalB asCenter\"><nobr>{$DF->date($rs['date'])}</nobr></td>
		</tr>";
		$count++;
	}
	if($count==0){
		echo"
		<tr>
			<td class=\"asNormalB asS12 asCenter\" colspan=\"5\"><br>لا توجد بيانات في سجل هذا العضو<br><br></td>
		</tr>";
	}
	echo"
	</table>";
}
$user_level = $mysql->get( "user", "level", u );
if( $user_level == 2 ){
	echo"<br>
	<table width=\"50%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form name=\"titleInfo\" method=\"post\" action=\"svc.php?svc=modblock&type=update\">
	<input type=\"hidden\" name=\"redeclare\" value=\"".rand."\">
	<input type=\"hidden\" name=\"userid\" value=\"".u."\">
	<input type=\"hidden\" name=\"step\" value=\"$step\">
		<tr>
			<td class=\"asHeader\" colspan=\"4\"><nobr>خيارات</nobr></td>
		</tr>";
		if($mod_bloc==0){
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>السبب</nobr></td>
			<td class=\"asNormalB\" colspan=\"3\"><input type=\"text\" style=\"width:400px;\" name=\"cause\"></td>
		</tr>";
		}
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"4\">
				{$Template->button($button_title," onClick=\"DF.checkSubmit(this.form)\"")}&nbsp;&nbsp;
			</td>
		</tr>
	</form>
	</table>";
}
if(type=='update'){
	$userid = (int)$_POST['userid'];
	$type = $_POST['step'];
	$cause = $DF->cleanText($_POST['cause']);
	$mysql->insert("moderator_block (userid,type,block_id,cause,date) VALUES ('".$userid."','".$type."','".uid."','".$cause."','".time."')", __FILE__, __LINE__);
	$mysql->update("moderator SET block = '$type' WHERE userid = '".$userid."'", __FILE__, __LINE__);
	if($type==0){
	$mysql->update("moderator_block SET step = '0' WHERE userid = '".$userid."'", __FILE__, __LINE__);
	}
	$Template->msg("تم تحديث البيانات بنجاح");
}


if(type=='list'){
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader asAC2\" colspan=\"4\">قائمة المشرفين المجمدين</td>
		</tr>
		<tr>
			<td class=\"asDarkB\"><nobr>المشرف</nobr></td>
			<td class=\"asDarkB\"><nobr>السبب</nobr></td>
			<td class=\"asDarkB\"><nobr>المستخدم</nobr></td>
			<td class=\"asDarkB\">خيارات</td>
		</tr>";
	$sql=$mysql->query("SELECT * FROM ".prefix."moderator_block AS b
	LEFT JOIN ".prefix."user AS u ON( u.id = b.userid )
	WHERE b.type = 1 AND b.step = 1 AND u.level = 2", __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\"><nobr>{$Template->userColorLink($rs['userid'])}</nobr></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>{$DF->iff($rs['cause']=='','--',$rs['cause'])}</nobr></td>
			<td class=\"asNormalB asCenter\"><nobr>{$Template->userColorLink($rs['block_id'])}</nobr></td>
			<td class=\"asNormalB asCenter\"><nobr><a href=\"svc.php?svc=modblock&type=user&u={$rs['userid']}\" title=\"التفاصيل\"><img src=\"{$DFImage->i['post']}\" alt=\"التفاصيل\" hspace=\"2\" border=\"0\"></a></nobr></td>
		</tr>";
		$count++;
	}
	if($count==0){
		echo"
		<tr>
			<td class=\"asNormalB asS12 asCenter\" colspan=\"5\"><br>لا يوجد حاليا أي مشرف مجمد<br><br></td>
		</tr>";
	}
	echo"
	</table>";
}
// ************ end page ****************
}
else{
	header("HTTP/1.0 404 Not Found");
}
?>