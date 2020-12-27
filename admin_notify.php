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

if($Mlevel == 4){
require_once("./include/forum_func.df.php");


function nofity_administrator_info(){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
		$x = 0;
		while ($x < $num){
		$f = mysql_result($sql, $x, "FORUM_ID");
		$subject = forums("SUBJECT", $f);
        $nofity_admin = nofity_wait($f, "admin");
		$href = '<a href="index.php?mode=f&f='.$f.'">'.$subject.'</a>';
		if($nofity_admin > 0){ $tr_class = "fixed"; }
		else { $tr_class = "normal"; }
		echo'
		<tr class="'.$tr_class.'">
			<td class="list_small">'.$href.'</td>
				<td class="list_center"><a href="index.php?mode=notifylist&f='.$f.'&method=admin">'.$nofity_admin.'</a></td>
		</tr>';
		++$x;
		}
}


function nofity_forums_info(){
	if(mlv == 4){
		$txt = "الشكاوي المحولة  للإدارة";
	}
	echo'
	<center>
	<table cellSpacing="1" cellPadding="2" width="99%" border="0">
		<tr>
			<td class="optionsbar_menus" width="100%">&nbsp;<nobr><font color="red" size="+1">'.$txt.'</font></nobr></td>';
			refresh_time();
			go_to_forum();
		echo'
		</tr>
	</table>
	<br>
	<table class="grid" cellSpacing="1" cellPadding="2" width="60%" border="0">
		<tr>
			<td class="cat">المنتدى</td>
			<td class="cat">الشكاوي</td>
		</tr>';
	if(mlv == 4){
			nofity_administrator_info();
	}
	echo'
	</table>
	<br>
	<table cellSpacing="1" cellPadding="2" border="0">
		<tr>
			<td align="center">المنتديات التي تظهر باللون التالي</td>
			<td align="center"><table border="1"><tr class="fixed"><td>&nbsp;&nbsp;&nbsp;</td></tr></table></td>
			<td align="center">تحتوي على شكاوي تنتظر المراجعة</td>
		</tr>
		<tr>
			</font></td>
		</tr>
	</table>
	</center>';
}

if(mlv == 4){
	nofity_forums_info();
}
}
else{
	go_to("index.php");
}
?>