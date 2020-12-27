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

echo '<script type="text/javascript">
function upload(){
var upxml = form1.ufile.value;

if(upxml == ""){
confirm("عفوا ، لم تختر اي ملف من جهازك ن الرجاء التاكد");
return;
}

if(upxml.indexOf(".xml") < 0 && upxml.indexOf(".XML") < 0){
confirm("xml عذرا ، الملف الذي حددته ليس");
return;
}


document.form1.submit();
}
</script>
';

$limit_size=5000000;

$siteurl = "";
$path = "./styles/".$HTTP_POST_FILES['ufile']['name'];

$UPdata = time();

echo'
	<table class="optionsbar" dir="rtl" cellSpacing="2" width="100%" border="0" id="table11">
				<td class="optionheader_selected" Align="right" vAlign="center" width="100%">

			<p align="center"><font size="4"><b>رفع ملف ستايل بصيغة xml للمنتدى</b></font></td>';


echo'
</center>';

if($type == ""){

echo'<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<form action="cp_home.php?mode=upxml&type=uploading" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<table width="100%" border="1" cellpadding="3" cellspacing="1" bgcolor="#FFFFCC" height="380" bordercolorlight="#000000">
<tr>
<td class="fts" align="center">&nbsp;	'.icons($logo, $forum_title).'<p>&nbsp;<input class="fixed" name="ufile" type="file" id="ufile" size="35" />
</p>
<input type="button" name="Submit" onclick="upload()" value="ارفع الملف" /><p>
<span style="font-size: 16pt">نوع الملفات المسموحة بها هو&nbsp; :&nbsp; <b>
<font color="#660033"><span lang="fr">.xml</span></font>

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
			<font size="3" color="#191970">الحجم المسموح به هو : 100000000000000000 Octets</font><br>&nbsp;
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
			<font color="#191970" size="5"><b>تم رفع الملف بنجاح</b></font></span><br><br>
			<a href="cp_home.php?mode=upxml">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br>&nbsp;
			</td>
		</tr>
	</table>
</center>';

}


}
?>
