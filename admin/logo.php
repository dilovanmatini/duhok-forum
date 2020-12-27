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

echo '<script type="text/javascript">
function upload(){
var logo = form1.ufile.value;

if(logo == ""){
confirm("أنت لم اخترت أي صورة من جهازك");
return;
}

if(logo.indexOf(".gif") < 0 && logo.indexOf(".GIF") < 0){
confirm("الملف الذي اخترت صيغته ليس gif\nلهذا يجب عليك إختيار ملف صيغته gif");
return;
}

if(logo.indexOf("logo.gif") < 0 && logo.indexOf("logo.GIF") < 0){
confirm("عليك ان تختار الشعار باسم logo.gif");
return;
}


document.form1.submit();
}
</script>
';

$limit_size=5000000;

$siteurl = "";
$path = "./images/logos/".$HTTP_POST_FILES['ufile']['name'];

$UPdata = time();

echo'
	<table class="optionsbar" dir="rtl" cellSpacing="2" width="100%" border="0" id="table11">
				<td class="optionheader_selected" Align="right" vAlign="center" width="100%">

			<p align="center"><font size="4"><b>تغير شعار   '.$forum_title.'
</b></font></td>';


echo'
</center>';

if($type == ""){

echo'<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<form action="cp_home.php?mode=logo&type=uploading" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<table width="100%" border="1" cellpadding="3" cellspacing="1" bgcolor="#FFFFCC" height="380" bordercolorlight="#000000">
<tr>
<td class="fts" align="center">&nbsp;			'.icons($logo, $forum_title).'<p>&nbsp;<input class="fixed" name="ufile" type="file" id="ufile" size="35" />
</p>
<input type="button" name="Submit" onclick="upload()" value="ارفع الشعار" /><p>
<span style="font-size: 16pt"><font color="#FF0000">ملاحظة هامة :</font> ليتغير 
الشعار ، يجب أن يكون<span lang="fr"> </span>الإسم على الشكل التالي :<span lang="fr">
</span></span></p>
<p><font color="#FF0000"><span style="font-size: 16pt" lang="fr">logo.gif</span></font><p>
<span style="font-size: 16pt">نوع الملفات المسموحة بها هو&nbsp; :&nbsp; <b>
<font color="#660033"><span lang="fr">.gif</span></font>

</table>';

}


if($type == "uploading"){

if(!$HTTP_POST_FILES['ufile']['tmp_name']){
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
			</center>';
exit();
}



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
exit();
}

if(copy($HTTP_POST_FILES['ufile']['tmp_name'], $path)){
echo'<br>
<center>
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br><span lang="ar-ma">
			<font color="#191970" size="5"><b>تم رفع الشعار بنجاح</b></font></span><br><br>
			<a href="cp_home.php?mode=logo">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br>&nbsp;
			</td>
		</tr>
	</table>
</center>';

}


}
?>
