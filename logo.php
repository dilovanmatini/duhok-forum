<?php
/*//////////////////////////////////////////////////////////
// ######################################################///
// # DuhokForum 0.9                                     # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #   ========= Programming By Dilovan ==============  # //
// # Copyright © 2007-2008 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # If you want any support vist down address:-        # //
// # Email: df@duhoktimes.com                           # //
// # Site: http://df.duhoktimes.com/index.php           # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

if($DBMemberID > 0){

if($Mlevel > 0){

$limit_size=5000000;

$siteurl = "";

$path = "images/logos/".$HTTP_POST_FILES['ufile']['name'];

$UPdata = time();

echo'
	<table class="optionsbar" dir="rtl" cellSpacing="2" width="100%" border="0" id="table11">
				<td class="optionsbar_title" Align="right" vAlign="center" width="100%">

			<p align="center"><font size="4"><b>تغير شعار   '.$forum_title.'
</b></font></td>';


echo'
</center>';

if($type == ""){

echo'<br>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<form action="index.php?mode=logo&type=uploading" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<table width="100%" border="1" cellpadding="3" cellspacing="1" bgcolor="#FFFFCC" height="380" bordercolorlight="#000000">
<tr>
<td class="fts" align="center">&nbsp;			'.icons($logo, $forum_title).'<p>&nbsp;<input class="fixed" name="ufile" type="file" id="ufile" size="35" />
</p>
<input type="submit" name="Submit" value="ارفع الشعار" /><p>
<span style="font-size: 16pt"><font color="#FF0000">ملاحظة هامة :</font> ليتغير 
الشعار ، يجب أن يكون<span lang="fr"> </span>الإسم على الشكل التالي :<span lang="fr">
</span></span></p>
<p><font color="#FF0000"><span style="font-size: 16pt" lang="fr">logo.gif</span></font><p>
<span style="font-size: 16pt">نوع الملفات المسموحة بها هو&nbsp; :&nbsp; <b>
<font color="#660033"><span lang="fr">.gif</span></font>

</table>';

if($Mlevel == 4){

 $query = "SELECT * FROM {$mysql->prefix}UPLOAD ";
 $query .= " ORDER BY UP_ID ASC";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 $num = mysql_num_rows($result);

echo '<br>
<p>';

}

}

if($Mlevel == 4){

if($type == "delete"){

$UploadID = $id;

		$queryD = "DELETE FROM {$mysql->prefix}UPLOAD WHERE UP_ID = '$UploadID' ";
		$mysql->execute($queryD, $connection, [], __FILE__, __LINE__);

	                echo'</p>
<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم حذف&nbsp; 
							الشعار بنجاح</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=index.php?mode=logo">
                           <a href="index.php">-- إنقر هنا للذهاب الى صفحة الرئيسية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';

}
}

if($type == "uploading"){

if($ufile !=none)
{

$file_size=$HTTP_POST_FILES['ufile']['size'];

if($file_size >= $limit_size){

echo'<br>
<center>
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br><b><font size="3" color="#191970">حجم 
			الشعار الذي اخترت كبير جدا</font></b><br>
			<b><font size="3" color="#191970">حجمها هو : Octets  '.$file_size.'</font></b><br>
			<font size="3" color="#191970">الحجم المسموح به هو : 1000000 Octets</font><br>&nbsp;
			</td>
		</tr>
	</table>
</center>';
}
else {
if(copy($HTTP_POST_FILES['ufile']['tmp_name'], $path)){
echo'<br>
<center>
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br><span lang="ar-ma">
			<font color="#191970" size="5"><b>تم رفع الشعار بنجاح</b></font></span><br><br>
			<meta http-equiv="Refresh" content="2; URL=index.php?mode=logo">
			<a href="index.php?mode=logo">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br>&nbsp;
			</td>
		</tr>
	</table>
</center>';

$query = "INSERT INTO {$mysql->prefix}UPLOAD (UP_ID, UP_MODMAKE, UP_FILESIZE, UP_DATE, UP_URL) VALUES (NULL, '$DBUserName', '$file_size', '$UPdata', '$path')";
$mysql->execute($query, $connection, [], __FILE__, __LINE__);

}

else {
	                echo'<br><br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><b>
							<font size="5" color="#FF0000"><br>
							<span lang="ar-tn">خطأ </span>!!!</font></b><p>
							<span lang="ar-tn"><font size="5">يجب عليك أن تحدد الملف ليتم الرفع</font></span><font size="5"><br></font><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a></p>
							<br>
	                       </td>
	                   </tr>
	                </table>
			</center>';}
}
}
}
}
else {
	                echo'<br><br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><b>
							<font size="5" color="#FF0000"><br>
							<span lang="ar-tn">خطأ </span>!!!</font></b><p>
							<span lang="ar-tn"><font size="5">هذه الخاصية 
							للإداريين فقط</font></span><font size="5"><br></font><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a></p>
							<br>
	                       </td>
	                   </tr>
	                </table>
			</center>';
                 

    }
}
else {
	                echo'
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><b>
							<font size="5" color="#FF0000"><br>
							<span lang="ar-tn">خطأ </span>!!!</font></b><p>
							<span lang="ar-tn"><font size="5">هذه الخاصية 
							للإداريين فقط</font></span><font size="5"><br></font><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a></p>
							<br>
	                       </td>
	                   </tr>
	                </table>
			</center>';
}
print $coda;

?>
