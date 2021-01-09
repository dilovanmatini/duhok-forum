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

const _df_script = "catadmin";
const _df_filename = "catadmin.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if(ulv != 4){
	$DF->quick();
	exit();
}

$Template->header();

if(type == "add"){
	?>
	<script type="text/javascript">
	function checkSubmit(frm){
		if(frm.subject.value == ""){
			alert("يجب عليك كتابة اسم الفئة.");
		}
		else if(isNaN(parseInt(frm.monitor.value))){
			alert("يجب عليك فقط إدخال ارقام في خانة رقم مراقب.");
		}
		else{
			frm.submit();
		}
	}
	</script>
	<?php
	echo"
	<center>
	<table class=\"border\" width=\"60%\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\">
	<form method=\"post\" action=\"catadmin.php?type=insert\">
		<tr>
			<td class=\"asHeader\" colspan=\"2\">إضافة فئة جديدة</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>اسم الفئة</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:350px\" name=\"subject\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>رقم مراقب</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:50px\" name=\"monitor\" value=\"0\"> ملاحظة: فقط إدخل رقم عضو الذي تريد تعينه كمراقب هذه الفئة</td>
		</tr>	
		<tr>
			<td class=\"asFixedB\"><nobr>رقم نائب مراقب</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:50px\" name=\"submonitor\" value=\"0\"> ملاحظة: فقط إدخل رقم عضو الذي تريد تعينه كنائب مراقب لهذه الفئة</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>الأرشفة</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" name=\"archive\">
				<option value=\"0\">غير مؤرشف</option>
				<option value=\"1\">مؤرشف</option>
			</select>
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>مجموعة</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" name=\"level\">";
			for($x=0;$x<=4;$x++){
				echo"
				<option value=\"$x\">{$Template->groups[$x]}</option>";
			}
			echo"
			</select>
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات الفئة</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء فئة</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidden\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidden\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مراقب في صفحة الرئيسية</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemonhome\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemonhome\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مراقب في معلومات منتدى</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemoninfo\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemoninfo\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مراقب في بيانات العضو</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemonprofile\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemonprofile\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asNormalB\" align=\"center\" colspan=\"2\"><input onClick=\"checkSubmit(this.form)\" class=\"button\" type=\"button\" value=\"أضف فئة\"></td>
		</tr>
	</form>
	</table>
	</center>";
}
elseif(type == "edit"){
	$sql=$mysql->query("SELECT * FROM ".prefix."category WHERE id = '".c."'", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	if(!$rs){
		$Template->errMsg('لم يتم العثور على أي فئة');
	}
	$c=$rs['id'];
	?>
	<script type="text/javascript">
	function checkSubmit(frm){
		if(frm.subject.value == ""){
			alert("يجب عليك كتابة اسم الفئة.");
		}
		else if(isNaN(parseInt(frm.monitor.value))){
			alert("يجب عليك فقط إدخال ارقام في خانة رقم مراقب.");
		}
		else{
			frm.submit();
		}
	}
	</script>
	<?php
	echo"
	<center>
	<table class=\"border\" width=\"60%\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\">
	<form method=\"post\" action=\"catadmin.php?type=update&c=$c\">
	<input type=\"hidden\" name=\"lastsubmonitor\"  value=\"{$rs['submonitor']}\">
		<tr>
			<td class=\"asHeader\" colspan=\"2\">تعديل الفئة</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>اسم الفئة</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:350px\" name=\"subject\" value=\"{$rs['subject']}\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>رقم مراقب</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:50px\" name=\"monitor\" value=\"{$rs['monitor']}\"> ملاحظة: فقط إدخل رقم عضو الذي تريد تعينه كمراقب هذه الفئة</td>
		</tr>";
	if($rs['monitor']>0){
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>اسم مراقب</nobr></td>
			<td class=\"asNormalB\">{$Template->userColorLink($rs['monitor'])}</td>
		</tr>";
	}		
	echo"<tr>
			<td class=\"asFixedB\"><nobr>رقم نائب المراقب</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:50px\" name=\"submonitor\" value=\"{$rs['submonitor']}\"> ملاحظة: فقط إدخل رقم عضو الذي تريد تعينه كنائب مراقب لهذه الفئة</td>
		</tr>";
	if($rs['submonitor']>0){
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>اسم نائب المراقب</nobr></td>
			<td class=\"asNormalB\">{$Template->userColorLink($rs['submonitor'])}</td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>الأرشفة</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" name=\"archive\">
				<option value=\"0\" {$DF->choose($rs['archive'],0,'s')}>غير مؤرشف</option>
				<option value=\"1\" {$DF->choose($rs['archive'],1,'s')}>مؤرشف</option>
			</select>
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>مجموعة</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" name=\"level\">";
			for($x=0;$x<=4;$x++){
				echo"
				<option value=\"$x\" {$DF->choose($rs['level'],$x,'s')}>{$Template->groups[$x]}</option>";
			}
			echo"
			</select>
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات الفئة</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء فئة</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidden\" value=\"1\" {$DF->choose($rs['hidden'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidden\" value=\"0\" {$DF->choose($rs['hidden'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مراقب في صفحة الرئيسية</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemonhome\" value=\"1\" {$DF->choose($rs['hidemonhome'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemonhome\" value=\"0\" {$DF->choose($rs['hidemonhome'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مراقب في معلومات منتدى</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemoninfo\" value=\"1\" {$DF->choose($rs['hidemoninfo'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemoninfo\" value=\"0\" {$DF->choose($rs['hidemoninfo'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مراقب في بيانات العضو</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemonprofile\" value=\"1\" {$DF->choose($rs['hidemonprofile'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemonprofile\" value=\"0\" {$DF->choose($rs['hidemonprofile'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asNormalB\" align=\"center\" colspan=\"2\"><input onClick=\"checkSubmit(this.form)\" class=\"button\" type=\"button\" value=\"تعديل فئة\"></td>
		</tr>
	</form>
	</table>
	</center>";
}
elseif(type == "insert"){
	$monitor=(int)$_POST['monitor'];
	$submonitor=(int)$_POST['submonitor'];
	$mysql->insert("category (submonitor,subject,monitor,archive,level,hidden,hidemonhome,hidemoninfo,hidemonprofile) VALUES (
	'$submonitor','{$_POST['subject']}','$monitor','{$_POST['archive']}','{$_POST['level']}','{$_POST['hidden']}','{$_POST['hidemonhome']}','{$_POST['hidemoninfo']}','{$_POST['hidemonprofile']}')", __FILE__, __LINE__);
	$Template->msg('تم إضافة فئة جديدة بنجاح');
}
elseif(type == "update"){
	$c=(int)$mysql->get('category','id',c);
	if($c>0){
		$monitor=(int)$_POST['monitor'];
		$submonitor=(int)$_POST['submonitor'];
		$lastsubmonitor=(int)$_POST['lastsubmonitor'];		
		$mysql->update("category SET
		subject = '{$_POST['subject']}',
		monitor = '$monitor',
		submonitor = '$submonitor',
		archive = '{$_POST['archive']}',
		level = '{$_POST['level']}',
		hidden = '{$_POST['hidden']}',
		hidemonhome = '{$_POST['hidemonhome']}',
		hidemoninfo = '{$_POST['hidemoninfo']}',
		hidemonprofile = '{$_POST['hidemonprofile']}'
		WHERE id = '$c'", __FILE__, __LINE__);
		$Template->msg('تم تعديل الفئة بنجاح');
	}
	else{
		$Template->errMsg('لم يتم العثور على أي فئة');
	}
}
elseif(type == "lock"){
	$c=(int)$mysql->get('category','id',c);
	if($c>0){
		$mysql->update("category SET status = '0' WHERE id = '$c'", __FILE__, __LINE__);
		$Template->msg('تم قفل الفئة بنجاح');
	}
	else{
		$Template->errMsg('لم يتم العثور على أي فئة');
	}
}
elseif(type == "open"){
	$c=(int)$mysql->get('category','id',c);
	if($c>0){
		$mysql->update("category SET status = '1' WHERE id = '$c'", __FILE__, __LINE__);
		$Template->msg('تم فتح الفئة بنجاح');
	}
	else{
		$Template->errMsg('لم يتم العثور على أي فئة');
	}
}
elseif(type == "delete"){
	$c=(int)$mysql->get('category','id',c);
	if($c>0){
		$mysql->delete("category WHERE id = '$c'", __FILE__, __LINE__);
		$Template->msg('تم حذف الفئة بنجاح','index.php');
	}
	else{
		$Template->errMsg('لم يتم العثور على أي فئة');
	}
}
$Template->footer();
?>