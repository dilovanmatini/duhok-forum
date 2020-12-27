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

if($Mlevel > 0){

echo'
<center>
<table cellSpacing="0" cellPadding="4" width="99%" border="0">
	<tr>
		<td>
		<table cellSpacing="2" width="100%" border="0">
			<tr>
				<td width="100%"><nobr></nobr></td>';
				go_to_forum();
			echo'
			</tr>
		</table>
		</td>
	</tr>
</table>
</center>';

 $favT = " SELECT * FROM {$mysql->prefix}FAVOURITE_TOPICS ";
 $favT .= " WHERE F_TOPICID = '$t' AND F_MEMBERID = '$DBMemberID' ";
 $rfavT = $mysql->execute($favT, $connection, [], __FILE__, __LINE__);
    if(mysql_num_rows($rfavT)>0){
        $rsfav=mysql_fetch_array($rfavT);
        $ftopic_id=$rsfav['F_TOPICID'];
    }

if($ftopic_id != ""){
$error = 'الموضوع المختار في قائمة مفضلتك حاليا';
}

if($error != ""){
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><br><br><font size="5" color="red">'.$error.'.</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع الى الصفحة الاصلية --</a><br><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}

if($error == ""){

     $favInsert = "INSERT INTO {$mysql->prefix}FAVOURITE_TOPICS (FAVT_ID, F_MEMBERID, F_CATID, F_FORUMID, F_TOPICID) VALUES (NULL, ";
     $favInsert .= " '$DBMemberID', ";
     $favInsert .= " '$c', ";
     $favInsert .= " '$f', ";
     $favInsert .= " '$t') ";

     $mysql->execute($favInsert, $connection, [], __FILE__, __LINE__);

                    echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><br><br><font size="5" color="red">تم اضافة الموضوع لقائمة مواضيعك المفضلة.</font><br><br>
                           <a href="index.php?mode=t&t='.$t.'">-- إضغط هنا للرجوع الى الصفحة الاصلية --</a><br><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}

}
?>