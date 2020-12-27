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
?>

<script language="JavaScript"> 
function checkAll(form){
  for (var i = 0; i < form.elements.length; i++){    
    eval("form.elements[" + i + "].checked = form.elements[0].checked");  
  } 
} 
</script> 

<?php
$tables = @$mysql->execute("SHOW TABLE STATUS");
?>

<form name="form1" method="post" action="backup_done.php"/>
<table class="grid" align="center" width="80%" cellpadding="6" cellspacing="1" border="0">
<tr><td class="cat" colspan="5">تحميل نسخة احتياطية من قاعدة البيانات</td></tr>
<tr><td class="optionheader_selected" colspan="5" style="font-size:8pt;">اختر الجداول التي تريد تضمينها في النسخة الاحتياطية ومن ثم اضغط على تحميل</td></tr>
<tr><td class="cat">الجدول</td><td class="cat">المساحة</td><td class="cat"><input type="checkbox" name="check_all" checked="checked" onClick="checkAll(this.form)"/></td></tr>
<?php
$i = 0;
while($table = @mysql_fetch_array($tables))
{
if($i % 2){
$td = "f1";
}else{
$td = "f2ts";
}
    $size = round($table['Data_length']/1024, 2); // ايجاد حجم الجدول بالكيلوبايت
    echo "<tr><td width=\"20%\" class=\"$td\">$table[Name]</td><td width=\"65%\" class=\"$td\">$size كيلوبايت</td><td width=\"5%\" class=\"$td\"><input type=\"checkbox\" name=\"check[]\" value=\"$table[Name]\" checked=\"checked\" /></td></tr>";
$i++;
}
?>
<tr><td colspan="5" class="optionheader_selected"><center><input type="submit" class="button" name="submit" value="تحميل" /></center></td></tr>
</table></form>
