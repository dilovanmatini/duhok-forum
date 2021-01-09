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

const _df_script = "forumadmin";
const _df_filename = "forumadmin.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if(ulv != 4){
	$DF->quick();
	exit();
}
$Template->header();

if(type == "add"||type == "edit"){
	?>
	<script type="text/javascript">
	var deleteIconUrl="<?=$DFImage->i['delete']?>";
	var allowImgType=new Array('gif','png','jpg');
	function checkSubmit(frm){
		var logoType=DF.getChoosedRadio(frm.logoType);
		if(frm.subject.value == ""){
			alert("يجب عليك كتابة اسم المنتدى.");
		}
		else if(logoType == "url"&&frm.urlLogo.value == ""){
			alert("يجب عليك ان تكتب عنوان شعار منتدى في خانة وصلية خارجية.");
		}
		else if(logoType == "up"&&frm.upLogo.value == ""){
			alert("يجب عليك ان تقوم بإختيار شعار منتدى من جهازك.");
		}
		else if(logoType == "up"&&!checkMime(frm.upLogo.value)){
			alert("نوع الملف الذي اخترت غير مصرح بها\nيجب عليك ان تختار احد امتداد الآتية:- gif,jpg,png");
		}
		else if(frm.description.value == ""){
			alert("يجب عليك كتابة وصف المنتدى.");
		}
		else if(parseInt(frm.modsNum.value)>0){
			alert("توجد أرقام عضويات الذي تريد تعينهم كمشرفين لهذا المنتدى في خانة رقم العضوية\nلذا يجب عليك إضافتها الى القائمة حتى لا تخسر منها\nاو امسحها اذا لا تريد تعينهم كمشرفين لهذا المنتدى");
		}
		else if(parseInt(frm.usersNum.value)>0){
			alert("توجد أرقام عضويات الذي تريد فتح لهم هذا المنتدى في خانة رقم العضوية\nلذا يجب عليك إضافتها الى القائمة حتى لا تخسر منها\nاو امسحها اذا لا تريد فتح هذا المنتدى لهم");
		}
		else{
			frm.mods.value=(document.body.modsId?document.body.modsId:'');
			frm.users.value=(document.body.usersId?document.body.usersId:'');
			frm.submit();
		}
	}
	function checkMime(val){
		var allowImgType=new Array('gif','png','jpg'),str=val.toLowerCase();
		for(var x=0;x<allowImgType.length;x++){
			if(str.indexOf(allowImgType[x])>=0){
				return true;
			}
		}
		return false;
	}
	function checkLogoType(frm){
		var type=DF.getChoosedRadio(frm.logoType);
		frm.urlLogo.disabled=(type == "url"?false:true);
		frm.upLogo.disabled=(type == "url"?true:false);
	}
	function findValueInArray(arr,val){
		for(var x=0;x<arr.length;x++){
			if(arr[x] == val){
				return true;
			}
		}
		return false;
	}
	function deleteValInArray(arr,val){
		var newArr=new Array();
		for(var x=0;x<arr.length;x++){
			if(arr[x]!=val){
				newArr.push(arr[x]);
			}
		}
		return newArr;
	}
	function deleteUserIdFromList(id,type){
		var tab=$I('#'+type+'Table'),tr=$I('#'+type+'Row'+id),index=tr.rowIndex,dbArr=eval("document.body."+type+"Id");
		tab.deleteRow(index);
		dbArr=deleteValInArray(dbArr,id);
		if(tab.rows.length == 1){
			var tr=tab.insertRow(1);
			var td=tr.insertCell(0);
			td.innerHTML='<br><small>لم يتم إضافة أي رقم للقائمة.</small><br><br>';
			td.className='asNormalB';
			td.style.textAlign='center';
			td.colSpan=2;
		}
		eval("document.body."+type+"Id=dbArr");
	}
	function addRowsToList(id){
		var type=document.body.opType,tab=$I('#'+type+'Table'),dbArr=eval("document.body."+type+"Id");
		if(dbArr.length == 0){
			tab.deleteRow(1);
		}
		var tr=tab.insertRow(tab.rows.length);
		tr.id=type+'Row'+id;
		var td1=tr.insertCell(0);
		td1.innerHTML=id;
		td1.className='asNormalB';
		td1.style.textAlign='center';
		var td2=tr.insertCell(1);
		td2.innerHTML='<a href="javascript:deleteUserIdFromList('+id+',\''+type+'\');"><img src="'+deleteIconUrl+'" alt="حذف رقم من القائمة" hspace="6" border="0"></a>';
		td2.className='asNormalB';
		td2.style.textAlign='center';
		td2.style.width='1%';
		eval("document.body."+type+"Id=dbArr");
	}
	function addUserIdToList(type){
		var tab=$I('#'+type+'Table'),inp=$I('#'+type+"Num"),inpStr=inp.value,listArr=new Array();
		document.body.opType=type;
		if(!eval("document.body."+type+"Id")){
			eval("document.body."+type+"Id=new Array()");
		}
		var dbArr=eval("document.body."+type+"Id");
		if(inpStr.indexOf(',')>=0){
			listArr=inpStr.split(',');
		}
		else{
			listArr[0]=parseInt(inpStr);
		}
		for(var x=0;x<listArr.length;x++){
			var id=parseInt(listArr[x]);
			if(!isNaN(id)&&id>0&&!findValueInArray(dbArr,id)){
				addRowsToList(id);
				dbArr.push(id);
			}
			inp.value=0;
		}
		eval("document.body."+type+"Id=dbArr");
	}
	</script>
	<?php
}
if(type == "add"){
	$c=(int)$mysql->get('category','id',c);
	if($c == 0){
		$Template->errMsg('لم يتم العثور على أي فئة ليتم إضافة منتدى اليه');
	}
	echo"
	<center>
	<table class=\"border\" width=\"70%\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\">
	<form method=\"post\" action=\"forumadmin.php?type=insert\" enctype=\"multipart/form-data\">
		<tr>
			<td class=\"asHeader\" colspan=\"2\">إضف منتدى جديد</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>اسم منتدى</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:350px\" name=\"subject\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>وصف منتدى</nobr></td>
			<td class=\"asNormalB\"><textarea style=\"width:350px;height:100px\" name=\"description\"></textarea></td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات شعار منتدى</td>
		</tr>
		<tr>
			<td class=\"asDarkB\" colspan=\"2\">ملاحظة: سيتم عرض شعار منتدى على حجم 30 * 30 لهذا يجب عليك ان تصممها على هذا الحجم.</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>شعار منتدى</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"logoType\" value=\"url\" onClick=\"checkLogoType(this.form)\" checked>&nbsp;وصلة خارجية&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"logoType\" value=\"up\" onClick=\"checkLogoType(this.form)\">&nbsp;رفع شعار
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>وصلة خاجية</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:350px\" name=\"urlLogo\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>رفع شعار</nobr></td>
			<td class=\"asNormalB\"><input type=\"file\" style=\"width:350px\" name=\"upLogo\" disabled></td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات إضافية</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>فئة</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" name=\"catid\">";
			$sql=$mysql->query("SELECT id,subject FROM ".prefix."category ORDER BY sort ASC", __FILE__, __LINE__);
			while($cat=$mysql->fetchArray($sql)){
				echo"
				<option value=\"{$cat['id']}\" {$DF->choose($c,$cat['id'],'s')}>{$cat['subject']}</option>";
			}
			echo"
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
			<td class=\"asFixedB\"><nobr>منتدى فقط للجنس</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" name=\"sex\">";
			$sex=array('للكل','للذكور','للإناث');
			for($x=0;$x<count($sex);$x++){
				echo"
				<option value=\"$x\">$sex[$x]</option>";
			}
			echo"
			</select>
			</td>
		</tr>
				<tr>
			<td class=\"asFixedB\"><nobr>خيارات الموضوع للزوار</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" name=\"show\">";
			$show=array('ظاهر','الروابط','الروابط و الصور','مخفي بكله');
			for($x=0;$x<count($show);$x++){
				echo"
				<option value=\"$x\">$show[$x]</option>";
			}
			echo"
			</select>
			</td>
		</tr>
			<tr>
			<td class=\"asFixedB\"><nobr>إظهار الموضوع للأعضاء</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" name=\"topic_appearance\">";
			$topic_appearance_list=array('عادي','يظهر بعد إضافة رد');
			for($x=0;$x<count($topic_appearance_list);$x++){
				echo"
				<option value=\"$x\">$topic_appearance_list[$x]</option>";
			}
			echo"
			</select>
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات المراقبة</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>مراقبة على مواضيع</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"moderatetopics\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"moderatetopics\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>مراقبة على ردود</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"moderateposts\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"moderateposts\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>	
		<tr>
			<td class=\"asFixedB\"><nobr>مراقبة الروابط</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"moderateurl\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"moderateurl\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات عدد مشاركات</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عدد مواضيع العضو خلال 24 ساعة</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:50px\" name=\"totaltopics\" value=\"5\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عدد ردود العضو خلال 24 ساعة</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:50px\" name=\"totalposts\" value=\"200\"></td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات أرشفة مواضيع</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>تفعيل الارشيف</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"archive\" value=\"1\" checked>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"archive\" value=\"0\">&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عدد الايام لأرشفة مواضيع</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:50px\" name=\"archivedays\" value=\"60\"></td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات الإخفاء</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مشرفين في صفحة الرئيسية</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemodhome\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemodhome\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مشرفين في داخل منتديات</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemodforum\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemodforum\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مشرفين في معلومات منتدى</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemodinfo\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemodinfo\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مشرفين في بيانات العضو</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemodeprofile\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemodeprofile\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء تواقيع</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidesignature\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidesignature\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء بيانات العضو</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hideprofile\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hideprofile\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء صورة الشخصية</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidephoto\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidephoto\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء بريد المنتدى</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidepm\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidepm\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">إضافة وإزالة مشرفين</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>رقم العضوية</nobr></td>
			<td class=\"asNormalB\" align=\"center\">
				<textarea style=\"display:none\" name=\"mods\"></textarea><br>
				<input type=\"text\" style=\"width:150px;text-align:center\" id=\"modsNum\" name=\"modsNum\" value=\"0\" dir=\"ltr\"><br>
				<input onClick=\"addUserIdToList('mods')\" class=\"button\" type=\"button\" value=\"أضف رقم الى القائمة\">
				<br><br><hr width=\"90%\"><small>ملاحظة: اذا تريد ان تضاف اكثر من عضوية اكتب ارقام عضوياتهم هكذا <span dir=\"ltr\">1,2,3,4</span></small><hr width=\"90%\"><br>
				<table id=\"modsTable\" width=\"50%\" border=\"1\">
					<tr>
						<td class=\"cellHeader\" align=\"center\" colspan=\"2\">قائمة أرقام عضويات التي تريد تعينهم كمشرفون</td>
					</tr>
					<tr>
						<td class=\"asNormalB\" align=\"center\"><br><small>لم يتم إضافة أي رقم للقائمة.</small><br><br></td>
					</tr>
				</table>
				<br><font color=\"red\"><small>تنبيه: أرقام العضويات التي في قائمة أعلاه هي مؤقتة وبتحديث الصفحة سيتم تصفيرها.</small></font><br><br>
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">إخفاء منتدى وإضافة وإزالة أعضاء لمشاهدته</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء منتدى</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidden\" value=\"1\">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidden\" value=\"0\" checked>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>رقم العضوية</nobr></td>
			<td class=\"asNormalB\" align=\"center\">
				<textarea style=\"display:none\" name=\"users\"></textarea><br>
				<input type=\"text\" style=\"width:150px;text-align:center\" id=\"usersNum\" name=\"usersNum\" value=\"0\" dir=\"ltr\"><br>
				<input onClick=\"addUserIdToList('users')\" class=\"button\" type=\"button\" value=\"أضف رقم الى القائمة\">
				<br><br><hr width=\"90%\"><small>ملاحظة: اذا تريد ان تضاف اكثر من عضوية اكتب ارقام عضوياتهم هكذا <span dir=\"ltr\">1,2,3,4</span></small><hr width=\"90%\"><br>
				<table id=\"usersTable\" width=\"50%\" border=\"1\">
					<tr>
						<td class=\"cellHeader\" align=\"center\" colspan=\"2\">قائمة أرقام عضويات التي تريد فتح لهم هذا المنتدى</td>
					</tr>
					<tr>
						<td class=\"asNormalB\" align=\"center\"><br><small>لم يتم إضافة أي رقم للقائمة.</small><br><br></td>
					</tr>
				</table>
				<br><font color=\"red\"><small>تنبيه: أرقام العضويات التي في قائمة أعلاه هي مؤقتة وبتحديث الصفحة سيتم تصفيرها.</small></font><br><br>
			</td>
		</tr>
		<tr>
			<td class=\"asNormalB\" align=\"center\" colspan=\"2\"><input onClick=\"checkSubmit(this.form)\" class=\"button\" type=\"button\" value=\"أضف منتدى\"></td>
		</tr>
	</form>
	</table>
	</center>";
}
elseif(type == "edit"){
	$sql=$mysql->query("SELECT f.*,ff.* FROM ".prefix."forum AS f, ".prefix."forumflag AS ff WHERE f.id = '".f."' AND ff.id = f.id", __FILE__, __LINE__);
 	if($mysql->numRows($sql) == 0){
		$Template->errMsg('لم يتم العثور على أي منتدى');
	}
	$rs=$mysql->fetchArray($sql);
	$f=$rs['id'];
	?>
	<script type="text/javascript">
	DF.deleteUserRow=function(id,type){
		var tab=$I('#'+type+'DefTable'),tr=$I('#'+type+'DefRow'+id);
		if(tab.rows.length>1){
			tab.deleteRow(tr.rowIndex);
		}
		if(tab.rows.length == 1){
			var text=new Array();
			text['mods']='لا توجد أي مشرف لهذا المنتدى';
			text['users']='لا توجد أي عضو له سماح لمشاهدة هذا المنتدى';
			var row=tab.insertRow(1);
			var cell=row.insertCell(0);
			cell.className='statsText';
			cell.style.textAlign='center';
			cell.colSpan=3;
			cell.innerHTML="<br>"+text[type]+"<br><br>";
		}
	};
	DF.deleteUsersFromList=function(id,type){
		this.ajax.play({
			'url':adAjaxFile,
			'send':'type='+type+'DeleteUser&id='+id,
			'func':function(){
				var obj=DF.ajax.oName,ac=DF.ajax.ac;
				if(obj.readyState == 1||obj.readyState == 2||obj.readyState == 3){
					DF.loadingBox('<img src="'+progressUrl+'" border="0"><br><br>رجاً انتظر...',true);
				}
				else if(obj.readyState == 4){
					var get=obj.responseText.split(ac)[0]||false;
					if(get == 1){
						DF.deleteUserRow(id,type);
						DF.loadingBox('<img src="'+succeedUrl+'" border="0"><br><br>تم حذف العضو بنجاح.',true);
					}
					else{
						DF.loadingBox('<img src="'+errorUrl+'" border="0"><br><br><font color="red">حدث خطأ أثناء العملية</font><br><br><a href="javascript:DF.insertDeleteCode();" onClick=\"\">-- انقر هنا لمحاولة مرة اخرى --</a>',true);
					}
					setTimeout("DF.loadingBox('',false);",3000);
				}
			}
		});
	};
	</script>
	<?php
	echo"
	<center>
	<table class=\"border\" width=\"70%\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\">
	<form method=\"post\" action=\"forumadmin.php?type=update\" enctype=\"multipart/form-data\">
	<input type=\"hidden\" name=\"forumid\" value=\"$f\">
		<tr>
			<td class=\"asHeader\" colspan=\"2\">تعديل منتدى</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>اسم منتدى</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:350px\" name=\"subject\" value=\"{$rs['subject']}\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>وصف منتدى</nobr></td>
			<td class=\"asNormalB\"><textarea style=\"width:350px;height:100px\" name=\"description\">{$rs['description']}</textarea></td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات شعار منتدى</td>
		</tr>
		<tr>
			<td class=\"asDarkB\" colspan=\"2\">ملاحظة: سيتم عرض شعار منتدى على حجم 30 * 30 لهذا يجب عليك ان تصممها على هذا الحجم.</td>
		</tr>";
	if($rs['logo']!=""){
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>شعار الحالي للمنتدى</nobr></td>
			<td class=\"asNormalB\" align=\"center\">
				<img src=\"{$rs['logo']}\" width=\"30\" height=\"30\" border=\"0\"><br>
				<input type=\"checkbox\" class=\"none\" name=\"deletelogo\" value=\"1\">
				&nbsp;حذف شعار من سيرفر منتدى بعد نقر حفظ تعديلات
				<input type=\"hidden\" name=\"oldlogo\" value=\"{$rs['logo']}\">
			</td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>شعار منتدى</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"logoType\" value=\"url\" onClick=\"checkLogoType(this.form)\" checked>&nbsp;وصلة خارجية&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"logoType\" value=\"up\" onClick=\"checkLogoType(this.form)\">&nbsp;رفع شعار
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>وصلة خاجية</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:350px\" name=\"urlLogo\" value=\"{$rs['logo']}\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>رفع شعار</nobr></td>
			<td class=\"asNormalB\"><input type=\"file\" style=\"width:350px\" name=\"upLogo\" disabled></td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات إضافية</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>فئة</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" name=\"catid\">";
			$sql=$mysql->query("SELECT id,subject FROM ".prefix."category ORDER BY sort ASC", __FILE__, __LINE__);
			while($cat=$mysql->fetchArray($sql)){
				echo"
				<option value=\"{$cat['id']}\" {$DF->choose($rs['catid'],$cat['id'],'s')}>{$cat['subject']}</option>";
			}
			echo"
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
			<td class=\"asFixedB\"><nobr>منتدى فقط للجنس</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" name=\"sex\">";
			$sex=array('للكل','للذكور','للإناث');
			for($x=0;$x<count($sex);$x++){
				echo"
				<option value=\"$x\" {$DF->choose($rs['sex'],$x,'s')}>$sex[$x]</option>";
			}
			echo"
			</select>
			</td>
		</tr>
				<tr>
			<td class=\"asFixedB\"><nobr>خيارات الموضوع للزوار</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" name=\"show\">";
			$show=array('ظاهر','الروابط','الروابط و الصور','مخفي بكله');
			for($x=0;$x<count($show);$x++){
				echo"
				<option value=\"$x\" {$DF->choose($rs['topic_show'],$x,'s')}>$show[$x]</option>";
			}
			echo"
			</select>
			</td>
		</tr>
			<tr>
			<td class=\"asFixedB\"><nobr>إظهار الموضوع للأعضاء</nobr></td>
			<td class=\"asNormalB\">
			<select class=\"asGoTo\" name=\"topic_appearance\">";
			$topic_appearance_list = ['عادي' ,'يظهر بعد إضافة رد'];
			for( $x = 0; $x < count($topic_appearance_list); $x++ ){
				echo"
				<option value=\"$x\" {$DF->choose($rs['topic_appearance'],$x,'s')}>$topic_appearance_list[$x]</option>";
			}
			echo"
			</select>
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات المراقبة</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>مراقبة على مواضيع</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"moderatetopics\" value=\"1\" {$DF->choose($rs['moderatetopics'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"moderatetopics\" value=\"0\" {$DF->choose($rs['moderatetopics'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>مراقبة على ردود</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"moderateposts\" value=\"1\" {$DF->choose($rs['moderateposts'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"moderateposts\" value=\"0\" {$DF->choose($rs['moderateposts'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>مراقبة على الروابط</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"moderateurl\" value=\"1\" {$DF->choose($rs['moderateurl'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"moderateurl\" value=\"0\" {$DF->choose($rs['moderateurl'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات عدد مشاركات</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عدد مواضيع العضو خلال 24 ساعة</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:50px\" name=\"totaltopics\" value=\"{$rs['totaltopics']}\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عدد ردود العضو خلال 24 ساعة</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:50px\" name=\"totalposts\" value=\"{$rs['totalposts']}\"></td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات أرشفة مواضيع</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>تفعيل الارشيف</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"archive\" value=\"1\" {$DF->choose($rs['archive'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"archive\" value=\"0\" {$DF->choose($rs['archive'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عدد الايام لأرشفة مواضيع</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:50px\" name=\"archivedays\" value=\"{$rs['archivedays']}\"></td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">خيارات الإخفاء</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مشرفين في صفحة الرئيسية</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemodhome\" value=\"1\" {$DF->choose($rs['hidemodhome'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemodhome\" value=\"0\" {$DF->choose($rs['hidemodhome'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مشرفين في داخل منتديات</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemodforum\" value=\"1\" {$DF->choose($rs['hidemodforum'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemodforum\" value=\"0\" {$DF->choose($rs['hidemodforum'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مشرفين في معلومات منتدى</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemodinfo\" value=\"1\" {$DF->choose($rs['hidemodinfo'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemodinfo\" value=\"0\" {$DF->choose($rs['hidemodinfo'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء مشرفين في بيانات العضو</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidemodeprofile\" value=\"1\" {$DF->choose($rs['hidemodeprofile'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidemodeprofile\" value=\"0\" {$DF->choose($rs['hidemodeprofile'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء تواقيع</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidesignature\" value=\"1\" {$DF->choose($rs['hidesignature'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidesignature\" value=\"0\" {$DF->choose($rs['hidesignature'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء بيانات العضو</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hideprofile\" value=\"1\" {$DF->choose($rs['hideprofile'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hideprofile\" value=\"0\" {$DF->choose($rs['hideprofile'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء صورة الشخصية</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidephoto\" value=\"1\" {$DF->choose($rs['hidephoto'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidephoto\" value=\"0\" {$DF->choose($rs['hidephoto'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء بريد المنتدى</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidepm\" value=\"1\" {$DF->choose($rs['hidepm'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidepm\" value=\"0\" {$DF->choose($rs['hidepm'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">إضافة وإزالة مشرفين</td>
		</tr>
		<tr>
			<td class=\"asFixedB\" align=\"center\" colspan=\"2\"><nobr>رقم العضوية</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB\" align=\"center\" colspan=\"2\">
				<textarea style=\"display:none\" name=\"mods\"></textarea><br>
				<input type=\"text\" style=\"width:150px;text-align:center\" id=\"modsNum\" name=\"modsNum\" value=\"0\" dir=\"ltr\"><br>
				<input onClick=\"addUserIdToList('mods')\" class=\"button\" type=\"button\" value=\"أضف رقم الى القائمة\">
				<br><br><hr width=\"90%\"><small>ملاحظة: اذا تريد ان تضاف اكثر من عضوية اكتب ارقام عضوياتهم هكذا <span dir=\"ltr\">1,2,3,4</span></small><hr width=\"90%\"><br>
				<table id=\"modsTable\" width=\"30%\" border=\"1\">
					<tr>
						<td class=\"cellHeader\" align=\"center\" colspan=\"2\">قائمة أرقام عضويات التي تريد تعينهم كمشرفون</td>
					</tr>
					<tr>
						<td class=\"asNormalB\" align=\"center\"><br><small>لم يتم إضافة أي رقم للقائمة.</small><br><br></td>
					</tr>
				</table>
				<br><font color=\"red\"><small>تنبيه: أرقام العضويات التي في قائمة أعلاه هي مؤقتة وبتحديث الصفحة سيتم تصفيرها.</small></font><br><br>
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\" align=\"center\" colspan=\"2\"><nobr>قائمة مشرفين المنتدى</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB\" align=\"center\" colspan=\"2\"><br>
			<table id=\"modsDefTable\" width=\"30%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">
				<tr>
					<td class=\"asDarkB\"><nobr>رقم</nobr></td>
					<td class=\"asDarkB\"><nobr>اسم عضوية</nobr></td>
					<td class=\"asDarkB\"><nobr>خيارات</nobr></td>
				</tr>";
		$sql=$mysql->query("SELECT id,userid FROM ".prefix."moderator WHERE forumid = '$f'", __FILE__, __LINE__);
		if($mysql->numRows($sql)>0){
			while($mrs=$mysql->fetchArray($sql)){
				echo"
				<tr id=\"modsDefRow{$mrs['id']}\">
					<td class=\"statsTitle\"><nobr>{$mrs['userid']}</nobr></td>
					<td class=\"statsText\"><nobr>{$Template->userColorLink($mrs['userid'])}</nobr></td>
					<td class=\"statsTitle\"><nobr><a href=\"javascript:DF.deleteUsersFromList({$mrs['id']},'mods')\"><img src=\"{$DFImage->i['delete']}\" border=\"0\"></a></nobr></td>
				</tr>";
			}
		}
		else{
				echo"
				<tr>
					<td class=\"statsText\" align=\"center\" colspan=\"3\"><br>لا توجد أي مشرف لهذا المنتدى<br><br></td>
				</tr>";
		}
			echo"
			</table><br>
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">إخفاء منتدى وإضافة وإزالة أعضاء لمشاهدته</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>إخفاء منتدى</nobr></td>
			<td class=\"asNormalB\">
				<input type=\"radio\" class=\"none\" name=\"hidden\" value=\"1\" {$DF->choose($rs['hidden'],1,'c')}>&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type=\"radio\" class=\"none\" name=\"hidden\" value=\"0\" {$DF->choose($rs['hidden'],0,'c')}>&nbsp;لا
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\" align=\"center\" colspan=\"2\"><nobr>رقم العضوية</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB\" align=\"center\" colspan=\"2\">
				<textarea style=\"display:none\" name=\"users\"></textarea><br>
				<input type=\"text\" style=\"width:150px;text-align:center\" id=\"usersNum\" name=\"usersNum\" value=\"0\" dir=\"ltr\"><br>
				<input onClick=\"addUserIdToList('users')\" class=\"button\" type=\"button\" value=\"أضف رقم الى القائمة\">
				<br><br><hr width=\"90%\"><small>ملاحظة: اذا تريد ان تضاف اكثر من عضوية اكتب ارقام عضوياتهم هكذا <span dir=\"ltr\">1,2,3,4</span></small><hr width=\"90%\"><br>
				<table id=\"usersTable\" width=\"30%\" border=\"1\">
					<tr>
						<td class=\"cellHeader\" align=\"center\" colspan=\"2\">قائمة أرقام عضويات التي تريد فتح لهم هذا المنتدى</td>
					</tr>
					<tr>
						<td class=\"asNormalB\" align=\"center\"><br><small>لم يتم إضافة أي رقم للقائمة.</small><br><br></td>
					</tr>
				</table>
				<br><font color=\"red\"><small>تنبيه: أرقام العضويات التي في قائمة أعلاه هي مؤقتة وبتحديث الصفحة سيتم تصفيرها.</small></font><br><br>
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\" align=\"center\" colspan=\"2\"><nobr>قائمة أعضاء مسموحين لرؤية هذا المنتدى</nobr></td>
		</tr>
		<tr>
			<td class=\"asNormalB\" align=\"center\" colspan=\"2\"><br>
			<table id=\"usersDefTable\" width=\"30%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">
				<tr>
					<td class=\"asDarkB\"><nobr>رقم</nobr></td>
					<td class=\"asDarkB\"><nobr>اسم عضوية</nobr></td>
					<td class=\"asDarkB\"><nobr>خيارات</nobr></td>
				</tr>";
		$sql=$mysql->query("SELECT id,userid FROM ".prefix."forumusers WHERE forumid = '$f'", __FILE__, __LINE__);
		if($mysql->numRows($sql)>0){
			while($mrs=$mysql->fetchArray($sql)){
				echo"
				<tr id=\"usersDefRow{$mrs['id']}\">
					<td class=\"statsTitle\"><nobr>{$mrs['userid']}</nobr></td>
					<td class=\"statsText\"><nobr>{$Template->userColorLink($mrs['userid'])}</nobr></td>
					<td class=\"statsTitle\"><nobr><a href=\"javascript:DF.deleteUsersFromList({$mrs['id']},'users')\"><img src=\"{$DFImage->i['delete']}\" border=\"0\"></a></nobr></td>
				</tr>";
			}
		}
		else{
				echo"
				<tr>
					<td class=\"statsText\" align=\"center\" colspan=\"3\"><br>لا توجد أي عضو له سماح لمشاهدة هذا المنتدى<br><br></td>
				</tr>";
		}
			echo"
			</table><br>
			</td>
		</tr>
		<tr>
			<td class=\"asNormalB\" align=\"center\" colspan=\"2\"><input onClick=\"checkSubmit(this.form)\" class=\"button\" type=\"button\" value=\"حفظ التغيرات\"></td>
		</tr>
	</form>
	</table>
	</center>";
}
elseif(type == "insert"){
	$allowTypes=array('image/gif','image/x-png','image/pjpeg');
	$subject=trim($_POST['subject']);
	$logoType=$_POST['logoType'];
	$urlLogo=trim($_POST['urlLogo']);
	$catid=(int)$_POST['catid'];
	$level=(int)$_POST['level'];
	$sex=(int)$_POST['sex'];
	$show=$_POST['show'];
	$topic_appearance=$_POST['topic_appearance'];
	$description=trim($_POST['description']);
	$moderatetopics=(int)$_POST['moderatetopics'];
	$moderateurl=(int)$_POST['moderateurl'];
	$moderateposts=(int)$_POST['moderateposts'];
	$totaltopics=(int)$_POST['totaltopics'];
	$totalposts=(int)$_POST['totalposts'];
	$archive=(int)$_POST['archive'];
	$archivedays=(int)$_POST['archivedays'];
	$hidemodhome=(int)$_POST['hidemodhome'];
	$hidemodforum=(int)$_POST['hidemodforum'];
	$hidemodinfo=(int)$_POST['hidemodinfo'];
	$hidemodeprofile=(int)$_POST['hidemodeprofile'];
	$hidesignature=(int)$_POST['hidesignature'];
	$hideprofile=(int)$_POST['hideprofile'];
	$hidephoto=(int)$_POST['hidephoto'];
	$hidepm=(int)$_POST['hidepm'];
	$hidden=(int)$_POST['hidden'];
	$users=$_POST['users'];
	$mods=$_POST['mods'];
	if($logoType == "up"){
		$errType=true;
		for($x=0;$x<count($allowTypes);$x++){
			if($_FILES['upLogo']['type'] == $allowTypes[$x]){
				$errType=false;
			}
		}
		$name=strtolower($_FILES['upLogo']['name']);
		$name=str_replace(" ","_",$name);
		$logoPath='images/forums-logo/'.$name;
	}
	elseif($logoType == "url"){
		$logoPath=$urlLogo;
	}
	if($logoType == "up"&&$errType){
		$Template->errMsg('نوع الملف الذي اخترت غير مصرح بها<br>يجب عليك ان تختار ملف من احد انواع الآتية:- gif,png,jpg');
	}
	elseif($logoType == "up"&&file_exists($logoPath)){
		$Template->errMsg('ملف الذي اخترت موجود حالياً في مجلد شعارات<br>لذا يجب عليك ان تقوم بإعادة تسمية ملف ثم رفعها مرة اخرى.');
	}
	else{
		if($logoType == "up"&&!move_uploaded_file($_FILES['upLogo']['tmp_name'],$logoPath)){
			$Template->errMsg('لم يتم اتمام العملية لأسباب فنية<br>نعتذر لهذا.');
		}
		$mysql->insert("forum (catid,subject,description,logo,level,hidden,sex,archive,hidemodhome,hidemodforum,topic_show,topic_appearance,moderateurl) VALUES (
		'$catid','$subject','$description','$logoPath','$level','$hidden','$sex','$archive','$hidemodhome','$hidemodforum','$show','$topic_appearance',$moderateurl)", __FILE__, __LINE__);
		$sql=$mysql->query("SELECT id FROM ".prefix."forum WHERE catid = '$catid' ORDER BY id DESC", __FILE__, __LINE__);
		$rs=$mysql->fetchArray($sql);
		$f=$rs['id'];
		$mysql->insert("forumflag (id,catid,archivedays,totaltopics,totalposts,moderatetopics,moderateposts,hidemodinfo,hidemodeprofile,hidesignature,hideprofile,hidephoto,hidepm) VALUES (
		'$f','$catid','$archivedays','$totaltopics','$totalposts','$moderatetopics','$moderateposts','$hidemodinfo','$hidemodeprofile','$hidesignature','$hideprofile','$hidephoto','$hidepm')", __FILE__, __LINE__);
		if(!empty($mods)){
			$mods=explode(",",$mods);
			for($x=0;$x<count($mods);$x++){
				$modId=(int)$mods[$x];
				if($modId>0&&$mysql->get('user','id',$modId)>0){
					$sql=$mysql->query("SELECT id FROM ".prefix."moderator WHERE catid = '$catid' AND forumid = '$f' AND userid = '$modId'", __FILE__, __LINE__);
					if($mysql->numRows($sql) == 0){
						$mysql->insert("moderator (userid,forumid,catid) VALUES ('$modId','$f','$catid')", __FILE__, __LINE__);
					}
				}
			}
		}
		if(!empty($users)){
			$users=explode(",",$users);
			for($x=0;$x<count($users);$x++){
				$userId=(int)$users[$x];
				if($userId>0&&$mysql->get('user','id',$userId)>0){
					$sql=$mysql->query("SELECT id FROM ".prefix."forumusers WHERE catid = '$catid' AND forumid = '$f' AND userid = '$userId'", __FILE__, __LINE__);
					if($mysql->numRows($sql) == 0){
						$mysql->insert("forumusers (userid,forumid,catid) VALUES ('$userId','$f','$catid')", __FILE__, __LINE__);
					}
				}
			}
		}
		$Template->msg('تم إضافة منتدى جديد بنجاح');
	}
}
elseif(type == "update"){
	$allowTypes=array('image/gif','image/x-png','image/pjpeg');
	$f=(int)$_POST['forumid'];
	$subject=trim($_POST['subject']);
	$logoType=$_POST['logoType'];
	$urlLogo=trim($_POST['urlLogo']);
	$catid=(int)$_POST['catid'];
	$level=(int)$_POST['level'];
	$sex=(int)$_POST['sex'];
	$show=$_POST['show'];
	$topic_appearance=$_POST['topic_appearance'];
	$description=trim($_POST['description']);
	$moderatetopics=(int)$_POST['moderatetopics'];
	$moderateurl=(int)$_POST['moderateurl'];
	$moderateposts=(int)$_POST['moderateposts'];
	$totaltopics=(int)$_POST['totaltopics'];
	$totalposts=(int)$_POST['totalposts'];
	$archive=(int)$_POST['archive'];
	$archivedays=(int)$_POST['archivedays'];
	$hidemodhome=(int)$_POST['hidemodhome'];
	$hidemodforum=(int)$_POST['hidemodforum'];
	$hidemodinfo=(int)$_POST['hidemodinfo'];
	$hidemodeprofile=(int)$_POST['hidemodeprofile'];
	$hidesignature=(int)$_POST['hidesignature'];
	$hideprofile=(int)$_POST['hideprofile'];
	$hidephoto=(int)$_POST['hidephoto'];
	$hidepm=(int)$_POST['hidepm'];
	$hidden=(int)$_POST['hidden'];
	$users=$_POST['users'];
	$mods=$_POST['mods'];
	$deletelogo=(int)$_POST['deletelogo'];
	$oldlogo=trim($_POST['oldlogo']);
	if($logoType == "up"){
		$errType=true;
		for($x=0;$x<count($allowTypes);$x++){
			if($_FILES['upLogo']['type'] == $allowTypes[$x]){
				$errType=false;
			}
		}
		$name=strtolower($_FILES['upLogo']['name']);
		$name=str_replace(" ","_",$name);
		$logoPath='images/forums-logo/'.$name;
	}
	elseif($logoType == "url"){
		$logoPath=$urlLogo;
	}
	if($logoType == "up"&&$errType){
		$Template->errMsg('نوع الملف الذي اخترت غير مصرح بها<br>يجب عليك ان تختار ملف من احد انواع الآتية:- gif,png,jpg');
	}
	elseif($logoType == "up"&&file_exists($logoPath)){
		$Template->errMsg('ملف الذي اخترت موجود حالياً في مجلد شعارات<br>لذا يجب عليك ان تقوم بإعادة تسمية ملف ثم رفعها مرة اخرى.');
	}
	else{
		if( $logoType == "up" && !move_uploaded_file( $_FILES['upLogo']['tmp_name'], $logoPath ) ){
			$Template->errMsg('لم يتم اتمام العملية لأسباب فنية<br>نعتذر لهذا.');
		}
		$mysql->update("forum SET
			catid = '$catid',
			subject = '$subject',
			description = '$description',
			logo = '$logoPath',
			level = '$level',
			hidden = '$hidden',
			sex = '$sex',
			archive = '$archive',
			hidemodhome = '$hidemodhome',
			hidemodforum = '$hidemodforum',
			topic_appearance = '$topic_appearance',
			moderateurl = '$moderateurl',
			topic_show = '$show'
		WHERE id = '$f'", __FILE__, __LINE__);
		$mysql->update("forumflag SET
			catid = '$catid',
			archivedays = '$archivedays',
			totaltopics = '$totaltopics',
			totalposts = '$totalposts',
			moderatetopics = '$moderatetopics',
			moderateposts = '$moderateposts',
			hidemodinfo = '$hidemodinfo',
			hidemodeprofile = '$hidemodeprofile',
			hidesignature = '$hidesignature',
			hideprofile = '$hideprofile',
			hidephoto = '$hidephoto',
			hidepm = '$hidepm'
		WHERE id = '$f'", __FILE__, __LINE__);

		
		if($deletelogo == 1&&!empty($oldlogo)){
			@unlink($oldlogo);
		}
		if(!empty($mods)){
			$mods=explode(",",$mods);
			for($x=0;$x<count($mods);$x++){
				$modId=(int)$mods[$x];
				if($modId>0&&$mysql->get('user','id',$modId)>0){
					$sql=$mysql->query("SELECT id FROM ".prefix."moderator WHERE catid = '$catid' AND forumid = '$f' AND userid = '$modId'", __FILE__, __LINE__);
					if($mysql->numRows($sql) == 0){
						$mysql->insert("moderator (userid,forumid,catid) VALUES ('$modId','$f','$catid')", __FILE__, __LINE__);
					}
				}
			}
		}
		if(!empty($users)){
			$users=explode(",",$users);
			for($x=0;$x<count($users);$x++){
				$userId=(int)$users[$x];
				if($userId>0&&$mysql->get('user','id',$userId)>0){
					$sql=$mysql->query("SELECT id FROM ".prefix."forumusers WHERE catid = '$catid' AND forumid = '$f' AND userid = '$userId'", __FILE__, __LINE__);
					if($mysql->numRows($sql) == 0){
						$mysql->insert("forumusers (userid,forumid,catid) VALUES ('$userId','$f','$catid')", __FILE__, __LINE__);
					}
				}
			}
		}
		$Template->msg('تم تعديل المنتدى بنجاح');
	}
}
elseif(type == "hidden"){
	$f=(int)$mysql->get('forum','id',f);
	if($f>0){
		$mysql->update("forum SET hidden = '1' WHERE id = '$f'", __FILE__, __LINE__);
		$Template->msg('تم إخفاء المنتدى بنجاح');
	}
	else{
		$Template->errMsg('لم يتم العثور على أي منتدى');
	}
}
elseif(type == "visible"){
	$f=(int)$mysql->get('forum','id',f);
	if($f>0){
		$mysql->update("forum SET hidden = '0' WHERE id = '$f'", __FILE__, __LINE__);
		$Template->msg('تم إظهار المنتدى بنجاح');
	}
	else{
		$Template->errMsg('لم يتم العثور على أي منتدى');
	}
}
elseif(type == "lock"){
	$f=(int)$mysql->get('forum','id',f);
	if($f>0){
		$mysql->update("forum SET status = '0' WHERE id = '$f'", __FILE__, __LINE__);
		$Template->msg('تم قفل المنتدى بنجاح');
	}
	else{
		$Template->errMsg('لم يتم العثور على أي منتدى');
	}
}
elseif(type == "open"){
	$f=(int)$mysql->get('forum','id',f);
	if($f>0){
		$mysql->update("forum SET status = '1' WHERE id = '$f'", __FILE__, __LINE__);
		$Template->msg('تم فتح المنتدى بنجاح');
	}
	else{
		$Template->errMsg('لم يتم العثور على أي منتدى');
	}
}
elseif(type == "delete"){
	$f=(int)$mysql->get('forum','id',f);
	if($f>0){
		$mysql->delete("forum WHERE id = '$f'", __FILE__, __LINE__);
		$mysql->delete("forumflag WHERE id = '$f'", __FILE__, __LINE__);
		$mysql->delete("forumusers WHERE forumid = '$f'", __FILE__, __LINE__);
		$mysql->delete("moderator WHERE forumid = '$f'", __FILE__, __LINE__);
		$Template->msg('تم حذف المنتدى بنجاح','index.php');
	}
	else{
		$Template->errMsg('لم يتم العثور على أي منتدى');
	}
}

$Template->footer();
?>