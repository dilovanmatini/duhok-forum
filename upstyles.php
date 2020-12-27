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

if($Mlevel == 4){




echo'<center>

<table dir="rtl" cellSpacing="0" width="99%" border="0" id="table11">
	<tr>
	</tr>
</table>
<TABLE class=grid id=table_nav style="BORDER-COLLAPSE: collapse" 
      cellSpacing=1 cellPadding=0 width="100%" border=0>
        <TBODY>
        <TR>
          <TD class=f2ts width="100%">
<TABLE class=optionsbar cellSpacing=2 width="100%" border=0>
  <TBODY>
  <TR>
  <TD class=f1 vAlign=top width="100%">     
  <p align="center">     
  <br>'.icons($logo, $forum_title, "").'<br> رفع الستايلات الخاص بمنتديات :</A><b><font size="3" color="#FF0000">&nbsp;'.$forum_title.'<br>
	</font></b>
	<html>
<body>
<br>
<br>
<form name="upload0" enctype="multipart/form-data" method="post" action="index.php?mode=up_style1">
  <p align="center">
  <input type="file" name="file"></p>
	<p align="center">

	<p align="center"><b><span lang="ar-tn">الملفات المسموح بها</span></b></p>
	<p align="center"><font color="#FF0000"><span lang="ar-tn"><b>
	<span style="font-size: 14pt">( &quot;png&quot;, &quot;gif&quot;, &quot;jpeg&quot;, &quot;jpe&quot;, &quot;jpg&quot;, &quot;zip&quot;, 
	&quot;mp3&quot;,&quot;css&quot; )</span></b></span><b><span style="font-size: 14pt"><br>
  	</span></b></font><br>
  <input type="submit" name="bouton_submit0" value="تحميل">
  <select name="folder" size="1">
    <option value="styles/">ستايلات</option>
	</p>
	</tr>';
	}
	else {
	                echo'<br><br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10">
							<p align="center"><b><font size="5" color="#FF0000"><br>
							خطأ <span lang="fr">!!!</span></font></b></p>
							<p align="center"><font size="5">هذه الخاصية <span lang="ar-ma">
							متوفرة فقط للإداريين</span><br></font><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
			</center>';
}
?>