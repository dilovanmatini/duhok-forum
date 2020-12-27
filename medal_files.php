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

function Create_Dir($dir){
           global $FTP_SERVER,$FTP_USER,$FTP_PASS;

       // connect to server
       $conn_id = ftp_connect($FTP_SERVER) or die('لا يمكنك الاتصال بالسيرفر , برجاء التأكد من البيانات المدخلة .'); // connection
  
       // login to ftp server
       $login_result = ftp_login($conn_id, $FTP_USER, $FTP_PASS) or die('لا يمكنك الاتصال بالسيرفر , برجاء التأكد من بيانات الحساب المدخلة .');

      if(!is_dir($dir)){

                   if(ftp_mkdir($conn_id, $dir)){
                          ftp_site($conn_id, "CHMOD 777 $dir") or die("FTP SITE CMD failed.");
                   } else {
                          exit("حدث خطأ اثناء محاولة انشاء المجلد : $dir\n");
                   }

}

ftp_close($conn_id);
}


if(allowed($f, 2) == 1){

$max_file_size = 51200;
$medal_folder = $image_folder.'medals/forum'.$f.'/';

if($FTP_ACTIVE == 1){
    Create_Dir($medal_folder);
}else{

if(!is_dir($medal_folder)){
	mkdir($medal_folder, 0777);
	chmod($medal_folder, 0777);
}
}


if($type == ""){

?>
<script language="javascript">
function trash_file(id){
	if(confirm("هل أنت متأكد بأن تريد حذف هذا الملف ؟")){
		document.file_info.file_id.value = id;
		document.file_info.submit();
	}
	else{
		return;
	}
}

function get_file_name(file){
	var x;
	while (file.indexOf("\\") >= 0){
		file = file.slice(file.indexOf("\\")+1);
	}
	return(file);
}

function chk_file(){
	up_file = get_file_name(upload.up.value);
	file = upload.file_name.value;
	if(file == ""){
		confirm("أنت لم اخترت أي ملف من جهازك");
		return;
	}
	if(file.indexOf(".gif") < 0 && file.indexOf(".GIF") < 0){
		confirm("الملف الذي اخترت صيغته ليس gif\nلهذا يجب عليك إختيار ملف صيغته gif");
		return;
	}
	if(up_file != file){
		confirm("مرجو عدم تعديل اسم ملف يدوياً");
		return;
	}
	else{
		upload.submit();
	}
}
</script>
<?php

if(!empty($_POST[file_id])){
	$file_id = $_POST[file_id];
	if(chk_mf_id($file_id) == 1){
		$mf_subject = mf("SUBJECT", $file_id);
		$mysql->execute("DELETE FROM {$mysql->prefix}MEDAL_FILES WHERE MF_ID = '$file_id' ", [], __FILE__, __LINE__);
		if(file_exists($medal_folder.$mf_subject)){
				unlink($medal_folder.$mf_subject);
		}
	}
}

function mf_files($id){
	global $icon_trash, $medal_folder;
	$f = mf("FORUM_ID", $id);
	$added = mf("ADDED", $id);
	$subject = mf("SUBJECT", $id);
	$date = mf("DATE", $id);
	
	if(file_exists($medal_folder.$subject)){
		$file_size = filesize($medal_folder.$subject);
	}
	echo'
	<tr class="normal">
		<td class="list_small"><nobr>'.$id.'</nobr></td>
		<td class="list"><a target="_new" href="'.$medal_folder.$subject.'">'.$subject.'</a></td>
		<td class="list_small"><nobr>'.$file_size.'</nobr></td>
		<td class="list_small"><nobr>'.date_and_time($date, 1).'</nobr></td>
		<td class="list_small"><nobr><a href="index.php?mode=svc&method=add&svc=medals&f='.$f.'&m='.$id.'">-- إضف وسام جديد --</a></nobr></td>
		<td class="list_small"><a href="javascript:trash_file('.$id.')">'.icons($icon_trash, "إحذف هذا الملف من حافظتك").'</a></td>
	</tr>';
}

echo'
<center>
<table width="100%">
	<tr>
		<td class="optionsbar_menus" width="100%"><nobr><font color="red" size="+1">ملفات أوسمة منتدى '.forums("SUBJECT", $f).'</font></nobr></td>
	</tr>
</table>
<br>
<form name="file_info" method="post" action="'.$_SERVER[REQUEST_URI].'">
<input type="hidden" name="file_id">
</form>
<table dir="rtl" cellSpacing="0" cellPadding="0" border="0">
	<tr>
		<td>
		<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
			<tr>
				<td>
				<table cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<td class="cat">الرقم</td>
						<td class="cat">اسم الملف</td>
						<td class="cat">حجم الملف</td>
						<td class="cat">تاريخ التحميل</td>
						<td class="cat" colspan="2">خيارات</td>
					</tr>';
					
			$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEDAL_FILES WHERE FORUM_ID = '$f' ORDER BY MF_ID DESC", [], __FILE__, __LINE__);
			$num = mysql_num_rows($sql);
			$x = 0;
			while ($x < $num){
				$mf_id = mysql_result($sql, $x, "MF_ID");
				mf_files($mf_id);
				$count = $count + 1;
			++$x;	
			}
			if($count == 0){
					echo'
					<tr class="normal">
						<td class="list_options" colspan="7"><br>لا توجد أي ملف لهذا المنتدى<br><br></td>
					</tr>';	
			}
					echo'
					<tr class="normal">
						<td class="list_options" colspan="7"><font color="red">الحد الأقصى لحجم أي ملف يمكن تحميله لهذة الحافظة:</font> '.$max_file_size.'<br><font color="red">الصيغة المدعومة فقط هي: </font>GIF</td>
					</tr>
					<tr class="normal">
						<td class="list_options" colspan="7"><font color="red">الموقع لا يتحمل مسؤولية الملفات التي تقوم بتحميلها وقد يتم ازالتها في أي وقت.</font></td>
					</tr>
					<tr class="deleted">
						<td align="middle" colspan="7"><br>
						<form name="upload" method="post" encType="multipart/form-data" action="index.php?mode=mf&type=upload&f='.$f.'">
							<table>
								<tr>
									<td vAlign="bottom">إختار ملف من جهازك للتحميل الى حافظتك:<br><input type="file" onchange="upload.file_name.value = get_file_name(this.value)" name="up"></td>
									<td>&nbsp;</td>
									<td vAlign="bottom">إسم الملف في حافظتك:<br><input name="file_name"></td>
									<td>&nbsp;</td>
									<td vAlign="bottom"><input onclick="chk_file()" type="button" value="إبدا تحميل الملف"></td>
								</tr>
							</table>
						</form>
						</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</center>';
}

if($type == "upload"){
	if(allowed($f, 2) == 1){
		$file_name = $_FILES['up']['name'];
		$file_size = $_FILES['up']['size'];
		$file_type = $_FILES['up']['type'];
		$file_temp = $_FILES['up']['tmp_name'];
		$img_url = $medal_folder.$file_name;

		if($file_size > $max_file_size){
			$error = "الملف الذي اخترت حجمه أكتر من حجم المسموح بك<br>الحجم الملف الذي اخترت هو ".$file_size." بايت<br>مرجو اختيار ملف حجمه لن يتجاوز حد المسموح بك وهو ".$max_file_size." بايت";
		}
		if($file_type != "image/gif"){
			$error = "الصيغة الذي اخترت ليس gif<br>مرجو أن تختار ملف صيغته gif";
		}
		if(file_exists($folder_img.$file_name)){
			$error = "اسم ملف موجود حالياً بقائمة ملفات المنتدى<br>مرجو أن تقوم بتعديل اسم ملف من جهازك الى اسم آخر";
		}
		if(empty($file_name)){
			$error = "أنت لم اخترت أي ملف من جهازك";
		}
		if($error != ""){
	                echo'<br>
					<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br><b>'.$lang['all']['error'].'<br>'.$error.'..</b></font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
		}
		if($error == ""){
			move_uploaded_file($file_temp, $medal_folder.$file_name);
			$sql = "INSERT INTO {$mysql->prefix}MEDAL_FILES (MF_ID, FORUM_ID, ADDED, SUBJECT, DATE) VALUES (NULL, ";
			$sql .= " '$f', ";
			$sql .= " '$user_id', ";
			$sql .= " '$file_name', ";
			$sql .= " '".time()."') ";
			$mysql->execute($sql, [], __FILE__, __LINE__);
	                echo'
					<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br><b>تم رفع الملف بنجاح</b></font><br><br>
	                       <meta http-equiv="refresh" content="1; URL='.$referer.'">
                           <a href="'.$referer.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
		}
	}
}


}
else{
	go_to(index);
}
?>