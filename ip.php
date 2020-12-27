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

if(mlv == 4){
if($type == ""){
echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="1" width="25%">
	<tr class="fixed">
			<td class="cat" colspan="2"><nobr>مطابقة  IP  الأعضاء
	</tr>';

  if($_GET['ip']){
                      $ip = $_GET['ip'];
                      $sql = $mysql->execute("select * from {$mysql->prefix}MEMBERS WHERE M_IP = '$ip' OR M_LAST_IP = '$ip' ");
                               if(mysql_num_rows($sql) == 0){
                                 echo '<tr class="fixed"><td align="center" class="list" colspan="2">لا توجد أي عضوية مشتركة لهذا العضو</td></tr>';
                               }else{
                               while($r = mysql_fetch_array($sql)){
                                 echo '<tr class="fixed"><td align="center" class="list" colspan="2">'.link_profile($r['M_NAME'], $r['MEMBER_ID']).'</td></tr>';
                               }           }
                    }


}
}
else {
echo'
	<table width="99%" border="1">
	<tr class="normal">
	<td class="list_center">
	<p align="center"><font color="red" size="5"><br>
	<b>لا يمكنك الولوج لهذه الخاصية لانها مخصصة للاداريين فقط<br>
	</b><br>
	</font>
<a href="JavaScript:history.go(-1)">-- إنقر هنا للرجوع --</a><br><br></td>
									</tr>
								</table>';
}

?>
