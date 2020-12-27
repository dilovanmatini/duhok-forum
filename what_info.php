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

//------------------------------------------ OTHERS CAT --------------------------------------------

$query = "SELECT * FROM {$mysql->prefix}CEP_CAT ";
$result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

if(mysql_num_rows($result) > 0){
$rs=mysql_fetch_array($result);

$Cat_Namea = $rs['O_CAT_NAMEA'];
$Cat_Urla = $rs['O_CAT_URLA'];
}

$cep_cat = "<a href='http://".$Cat_Urla."'><font>".$Cat_Namea."</font></a></nobr>";

//------------------------------------------ OTHERS CAT --------------------------------------------

//----------------------------------------- OTHERS FORUM -------------------------------------------

 $queryOF = "SELECT * FROM {$mysql->prefix}CEP_FORUM ";
 $queryOF .= " ORDER BY O_FORUMIDA ASC";
 $resultOF = $mysql->execute($queryOF, $connection, [], __FILE__, __LINE__);

 $numOF = mysql_num_rows($resultOF);

$iOF=0;
while ($iOF < $numOF){

    $cep_Namea = mysql_result($resultOF, $iOF, "O_FORUM_Namea");
    $Forum_Urla = mysql_result($resultOF, $iOF, "O_FORUM_URLA");
    $Name = link_profile(member_name($cep_Namea), $cep_Namea);


 if($numOF == 1){
       $cep_foruma .="<nobr><a class='menu2'>".$Name."<nobr><a class='menfu'> : ".$Forum_Urla."</a></nobr>"; 

 }
 else {
     $cep_foruma = $cep_foruma;
     if($cep_foruma != ""){
        $cep_foruma .= "<nobr>  <font size='2' color='$WHAT_COLOR'> ".$WHAT_FASEL." </font>  ";
     }
     $cep_foruma .= "<a class='menu2' >".$Name." <nobr> <a class='menfu' >: ".$Forum_Urla."  </a></nobr>";
 }
    ++$iOF;
}

//----------------------------------------- OTHERS FORUM -------------------------------------------

if($cep_Namea != ""){

echo'
';

echo'<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
	<table class="grid" cellSpacing="1" cellPadding="0" width="100%" border="0">
	<tr class="normal">
		<td dir="'.$lang['global']['dir'].'" class="cat" vAlign="middle" style="FONT-SIZE: '.$WHAT_ADMIN_SHOW.'" width="87">
		<span lang="ar-tn">'.$WHAT_TITLE.'</span></td>
		<td dir="'.$lang['global']['dir'].'" class="list" vAlign="middle" style="FONT-SIZE: '.$WHAT_ADMIN_SHOW.'" width="913">
		<b><marquee onmouseover="this.stop()" onmouseout="this.start()" direction="'.$WHAT_DIRECTION.'" height="15"  >'.$cep_foruma.'</td>';
			if(mlv > 0){
	echo'	<td class="list" vAlign="middle" align="middle" width="1%">';
		echo'<a href="index.php?mode=ihdaa_add&method=forum">'.icons($folder_other_forum, $lang['other_cat_forum']['add_forum1'], "hspace=\"3\"").'</a>';
		 }
                      if($Mlevel == 4){
	echo'	<td class="list" vAlign="middle" align="middle" width="1%">';
	echo'<a href="index.php?mode=what_add&method=forum&type=options">'.icons($folder_edit, $lang['home']['edit_forum1'], "hspace=\"3\"").'</a>
		</td>';
                      }
echo'	</tr>
	</table>
		</td>
	</tr><tr><tr>
<tr>
<tr>
<tr>
<tr>
<tr>
<tr>
<tr>

</table>';

}

?>