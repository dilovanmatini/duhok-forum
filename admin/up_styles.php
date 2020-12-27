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
var logo = form1.ufile.value;

if(logo == ""){
confirm("أنت لم اخترت أي استايل من جهازك");
return;
}

if(logo.indexOf(".css") < 0 && logo.indexOf(".CSS") < 0){
confirm("الملف الذي اخترت صيغته ليس css\nلهذا يجب عليك إختيار ملف صيغته css");
return;
}

document.form1.submit();
}
</script>
';

$limit_size=5000000;

$siteurl = "";
$HTTP_POST_FILES['ufile']['name'] = "style_".$HTTP_POST_FILES['ufile']['name'];
$path = "./styles/".$HTTP_POST_FILES['ufile']['name'];

$UPdata = time();

echo'
	<table class="optionsbar" dir="rtl" cellSpacing="2" width="100%" border="0" id="table11">
				<td class="optionheader_selected" Align="right" vAlign="center" width="100%">

			<p align="center"><font size="4"><b>رفع استايل
</b></font></td>';


echo'
</center>';

if($type == ""){

echo'<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<form action="cp_home.php?mode=up_styles&type=uploading" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<table width="100%" border="1" cellpadding="3" cellspacing="1" bgcolor="#FFFFCC" height="380" bordercolorlight="#000000">
<tr>
<td class="fts" align="center">&nbsp;			'.icons($logo, $forum_title).'<p>&nbsp;<input class="fixed" name="ufile" type="file" id="ufile" size="35" />
</p>
<div>
<input type="button" name="Submit" onclick="upload()" value="ارفع الاستايل" />
&nbsp;&nbsp;
<select name="style" class="insidetitle" style="WIDTH: 80px">
<option value="false">رفع فقط</option>
<option value="true">رفع واضافة </option>
</select>
</div>
</form>
<p style="color:red">* رفع فقط : يتم فقط رفع ملف الاستايل </p>

<p style="color:red">* رفع واضافة : يتم فقط رفع ملف الاستايل واضافته الى قاعدة البينات لكي يظهر للاعضاء </p>

</table>';

}


if($type == "uploading"){
$style = $_POST['style'];
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


if(copy($HTTP_POST_FILES['ufile']['tmp_name'], $path)){
echo'<br>
<center>
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br><span lang="ar-ma">
			<font color="#191970" size="5"><b>تم رفع الاستايل بنجاح</b></font></span><br><br>
			<a href="cp_home.php?mode=up_styles">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br>&nbsp;
			</td>
		</tr>
	</table>
</center>';

if($style == "true"){
     $style_file = $_FILES["ufile"]["name"];
     $style_file = str_replace(".css","",$style_file);
     $query = "INSERT INTO {$mysql->prefix}STYLE (S_ID, S_FILE_NAME, S_NAME) VALUES (NULL, ";
     $query .= " '$style_file', ";
     $query .= " '$style_file') ";

     $mysql->execute($query, $connection, [], __FILE__, __LINE__);
}
}


}
?>
