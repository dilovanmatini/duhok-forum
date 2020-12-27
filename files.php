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

if($Mlevel > 1){

//-------- VARIABLE NAME ---------

$repertoire = 'images/files/';

$FData = time();

$size_fichier = $_FILES['fichier']['size'];

$type_fichier = $_FILES['fichier']['type'];


//-------- VARIABLE NAME ---------


if($type == ""){

echo'<center>
<table dir="rtl" cellSpacing="2" width="99%" border="0" id="table11">
	<tr>
		<td class="optionsbar_menus" Align="middle" vAlign="center" width="100%"><font size="4" color="red">حافظة ملفاتك</font></td>
	</tr>
</table>
</center>';

 $query = "SELECT * FROM {$mysql->prefix}FILES WHERE MEMBER_ID = '$DBMemberID' ";
 $query .= " ORDER BY FILES_ID ASC";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 $num = mysql_num_rows($result);

	echo'	<table class="grid" dir="rtl" cellSpacing="0" cellPadding="0" width="60%" align="center" border="0">
			<tr>
				<td>
				<table dir="rtl" cellSpacing="1" cellPadding="2" width="100%" border="0">
		<tr>
                	<td class="cat"><nobr>&nbsp;</nobr></td>
                	<td class="cat"><nobr>اسم الملف</nobr></td>
                	<td class="cat"><nobr>حجم الملف</nobr></td>
                	<td class="cat"><nobr>تاريخ التحميل</nobr></td>
		</tr>';

if($num == 0){

echo'		<tr>
			<td class="f1" align="center" colSpan="8"><br><br><font size="4">لا توجد أية ملفات في حافظتك.<br><br>لتحميل ملفات الى حافظتك استخدم ميزة التحميل أدناه.<br><br>&nbsp;</font></td>
		</tr>';
}

$i=0;
while ($i < $num){

    $Files_ID = mysql_result($result, $i, "FILES_ID");
    $Files_Name = mysql_result($result, $i, "FILES_NAME");
    $Files_Size = mysql_result($result, $i, "FILES_SIZE");
    $Files_Url = mysql_result($result, $i, "FILES_URL");
    $Files_Date = mysql_result($result, $i, "FILES_DATE");

echo'	 <tr class="normal">
		<td class="list_small" width="2%" vAlign="center"><a href="index.php?mode=files&type=delete&id='.$Files_ID.'"  onclick="return confirm(\'هل أنت متأكد من أنك تريد حذف هذا الملف ؟\');">'.icons($icon_trash, "حذف الملف", "hspace=\"2\"").'</a></td>
		<td class="list_small" width="28%" vAlign="center"><a target="_blank" href="'.$Files_Url.'"><font size="3">'.$Files_Name.'</font></a></td>
		<td class="list_small" width="10%" dir="ltr"><font size="2">'.$Files_Size.'</font></td>
		<td class="list_small" width="20%"><font size="2">'.normal_time_files($Files_Date).'</font></td>
	</tr>';
    ++$i;
}

 $query = "SELECT SUM(FILES_SIZE) FROM {$mysql->prefix}FILES WHERE MEMBER_ID = '$DBMemberID' ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);
 $Sum_Size = mysql_result($result, "FILES_SIZE");

$MemberSize = $Files_Max_Size-$Sum_Size;

echo'		<tr class="fixed">
			<td class="list_small" colSpan="8"><b><font color="red" size="3">المساحة المتبقية لك للتخزين:</font><font size="3">';
			if($Sum_Size < $Files_Max_Size){
			echo $MemberSize;
			}
			else {
			echo '0';
			}
		echo'	</font><br><font color="red" size="3">الحد الأقصى لحجم أي ملف يمكن تحميله لهذه الحافظة:</font><font size="3">'.$Files_Max_Allowed.'</font></b></td>
		</tr>
		<tr class="fixed">
			<td class="list_small" colSpan="8"><b><font color="red" size="3">الموقع لا يتحمل مسؤولية الملفات التي تقوم بتحميلها وقد يتم ازالتها في أي وقت.</font></b></td>
		</tr>
		<tr>
			<td class="userdetails_header" valign="right" colSpan="8"><br>
<form action="index.php?mode=files&type=uploading" method="post" enctype="multipart/form-data" name="MAX_FILE_SIZE">
<table cellSpacing="4" cellPadding="4" align="center" border="0">
		<tr>
			<td>اختار ملف من جهازك للتحميل الى حافظتك:<br><input name="fichier" type="file" size="20" /></td>
			<td>إسم الملف في حافظتك:<br><input name="new_name" size="20"></td>
			<td>&nbsp;<br><input type="submit" name="Submit" value="إبدأ تحميل الملف" /></td>
		</tr>
</table>
</form>
			</td>
		</tr>';

}

if($type == "uploading"){

 $query1 = "SELECT SUM(FILES_SIZE) FROM {$mysql->prefix}FILES WHERE MEMBER_ID = '$DBMemberID' ";
 $result1 = $mysql->execute($query1, $connection, [], __FILE__, __LINE__);
 $Full_Size = mysql_result($result1, "FILES_SIZE");

if($_FILES['fichier']['type'] == 'image/gif'){ $extention = '.gif'; }

$New_Name = $_POST["new_name"].$extention;

$New_Name_error = $_POST["new_name"];

if(isset($_FILES['fichier'])){

   if($_FILES['fichier']['size'] > $Files_Max_Allowed)
   {
      $erreur = 'لا يسمح بتحميل ملفات في هذه الحافظة بحجم أكبر من '.$Files_Max_Allowed.'';
   }

   elseif($Full_Size > $Files_Max_Size){
    $erreur = 'لقد تجاوزت الحجم المسموح به لحافظتك.';
   }

   elseif($New_Name_error == ""){
    $erreur = 'يجب عليك ادخال اسم الملف';
   }

   elseif($type_fichier != 'image/gif'){
      $erreur = 'لا يسمح بتحميل ملفات في هذه الحافظة إلا من نوع .gif';
   }
   
   elseif(!file_exists($repertoire))
   {
      $erreur = 'أنت لم تحدد الملف الذي سترفع فيه الملفات<br/>أو لم تعطه التصريح 777';     
   }
   
   if(isset($erreur))
   {

echo'<br>
<center>
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br><b><font size="3" color="#191970">خطأ<br><br>'.$erreur.'</font></b><br><br>
						<a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br>&nbsp;
			</td>
		</tr>
	</table>
</center>';

   }
   else
   {
             
      if(move_uploaded_file($_FILES['fichier']['tmp_name'], $repertoire.$New_Name))
      {
         $url = ''.$repertoire.''.$New_Name.'';
echo'<br>
<center>
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br><b><font size="3" color="#191970">تم رفع الملف بنجاح</font></b><br><br>
			<img src="'.$url.'" width="100" height="100"><br><br>
			<font size="3" color="#191970"><a href="'.$url.'">'.$url.'</a></font><br><br>
			<a href="index.php?mode=files">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br>&nbsp;
			</td>
		</tr>
	</table>
</center>';

$query = "INSERT INTO {$mysql->prefix}FILES (FILES_ID, FILES_NAME, MEMBER_ID, FILES_SIZE, FILES_URL, FILES_DATE) VALUES (NULL, '$New_Name', '$DBMemberID', '$size_fichier', '$url', '$FData')";
$mysql->execute($query, $connection, [], __FILE__, __LINE__);

      }
      else
      {
         echo'<br>
<center>
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br><b><font size="3" color="#191970">آسف<br><br>لم يتم رفع الملف<br>أعد المحاولة</font></b><br><br>
						<a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br>&nbsp;
			</td>
		</tr>
	</table>
</center>';
      }
			}
		}
	}

if($type == "delete"){

$files_ID = $id;

		$queryD = "DELETE FROM {$mysql->prefix}FILES WHERE FILES_ID = '$files_ID' ";
		$mysql->execute($queryD, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم حذف الملف بنجاح</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=index.php?mode=files">
                           <a href="index.php?mode=files">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';

}

}
else {
//---------------- NOT NECESSARY - JUST TO BE LIKE STARTIMES HHH --------------------
echo'<center>
<table dir="rtl" cellSpacing="2" width="99%" border="0" id="table11">
	<tr>
		<td class="optionsbar_menus" Align="middle" vAlign="center" width="100%"><font size="4" color="red">حافظة ملفاتك</font></td>
	</tr>
</table>
</center>
<center>
	<table width="60%" class="grid" dir="rtl" cellSpacing="1" cellPadding="1">
		<tr class="fixed">
                	<td class="cat"><nobr>&nbsp;</nobr></td>
                	<td class="cat"><nobr>اسم الملف</nobr></td>
                	<td class="cat"><nobr>حجم الملف</nobr></td>
                	<td class="cat"><nobr>تاريخ التحميل</nobr></td>
		</tr>';
//---------------- NOT NECESSARY - JUST TO BE LIKE STARTIMES HHH --------------------
}

mysql_close();
?>