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

$Name = link_profile(member_name($best_mem), $best_mem);
$Name2 = link_profile(member_name($best_mod), $best_mod);
$best_topic = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE T_HIDDEN = 0 
AND T_UNMODERATED = 0 AND TOPIC_ID = '$best_topic'  ");



 $query = "SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$best_topic'  ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($result) > 0){
 $rs=mysql_fetch_array($result);


 $subject = $rs['SUBJECT'];
 $logos = $rs['F_LOGO'];
 }





$f_name = forums("SUBJECT", $best_frm);
$f_logo = forums("LOGO", $best_frm);



$title = $best_t;
$title1 = $best_mem_t;
$title2 = $best_mod_t;
$title3 = $best_frm_t;
$title4 = $best_topic_t;


?>





<p align="center">





</p>
<table  align="center" class="grid" cellSpacing="1" cellPadding="1" width="90%" border="0">
	<tr>
		<td class="cat">
		<p align="center"><? echo $title ?></td>
	</tr>
	<table align="center" class="grid" cellSpacing="1" cellPadding="0" width="90%" border="0">
	<tr>
		<td class="fixed" align="center"><? echo $Name ?></a></td>
		</td>
		<td class="fixed" align="center"><? echo $Name2 ?></a></td>
		<td class="fixed" align="center">		<? while($r_3 = mysql_fetch_array($best_topic)){ echo ' <a href="index.php?mode=t&t='.$r_3[TOPIC_ID].'" title="'.$r_3[T_SUBJECT].'">'.$r_3[T_SUBJECT].'
 '; } ?>
		<td class="fixed" align="center">

		<? 
  if($best_frm != ""){
  		echo'


<a   alt="'.$f_name.'"  href="index.php?mode=f&f='.$best_frm.'">'.icons($f_logo).' <br>
<font size="3"><a href="index.php?mode=f&f='.$best_frm.'">'.$f_name.' </a></font></td>';
}
else{
echo'
<a href="index.php?mode=f&f='.$best_frm.'"><br>
<font size="3"><a href="index.php?mode=f&f='.$best_frm.'"></a></font></td>';
}
?>

		</td>
	</tr>
	<tr>
		<td class="cat">
		<p align="center"><? echo $title1 ?></td>
		<td class="cat">
		<p align="center"><? echo $title2 ?></td>
		<td class="cat">
		<p align="center"><? echo $title4 ?></td>
		<td class="cat">
		<p align="center"><? echo $title3 ?></td>

	</tr>
</table>
<p align="center">