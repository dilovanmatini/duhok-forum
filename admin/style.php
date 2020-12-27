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

if($CPMlevel == 4){

if($method == ""){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=style&type=set">
	<tr class="fixed">
		<td class="cat" colspan="5"><nobr>إعدادات الستايل</nobr></td>
	</tr>';
 
        $ch_style = $mysql->execute("SELECT * FROM {$mysql->prefix}STYLE ", [], __FILE__, __LINE__);
        $style_num = mysql_num_rows($ch_style);

        if($style_num > 0){

            $style_i = 0;
            while ($style_i < $style_num){

                $style_id = mysql_result($ch_style, $style_i, "S_ID");
                $style_file_name = mysql_result($ch_style, $style_i, "S_FILE_NAME");
                $style_name = mysql_result($ch_style, $style_i, "S_NAME");

                echo'
                <input type="hidden" name="style_id[]" value="'.$style_id.'">
	        	<tr class="fixed">
	        		<td class="cat"><nobr>اسم الستايل</nobr></td>
	        		<td class="middle"><input type="text" name="style_name[]" size="15" value="'.$style_name.'"></td>
                    <td class="cat"><nobr>اسم ملف الستايل</nobr></td>
                    <td class="middle"><input type="text" name="style_file[]" size="15" value="'.$style_file_name.'"></td>
                    <td align="middle">
                    <table>
                        <tr>
                            <td class="optionsbar_menus">
                                <font size="3"><nobr><a href="cp_home.php?mode=style&method=delete&id='.$style_id.'">حذف الستايل</a></nobr></font>
                            </td>
                        </tr>
                    </table>
                    </td>
	        	</tr>';

            ++$style_i;
            }
        }
        else {
            echo'
	        <tr class="fixed">
		        <td class="list_center" colspan="5"><br>لا توجد أي ستايل<br><br></td>
	        </tr>';
 
        }
        
    echo'
	<tr class="fixed">
       <td align="middle" colspan="5">
       <table>
           <tr>
               <td class="optionsbar_menus">
                   <font size="3"><a href="cp_home.php?mode=style&method=add">إضافة ستايل جديد</a></font>
               </td>
           </tr>
       </table>
       </td>
	</tr>';
if($style_num > 0){
    echo'
 	<tr class="fixed">
		<td align="middle" colspan="5"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>';
}
echo'
</form>
</table>
</center>';


 }

 if($type == "set"){

    if($error != ""){
	                echo'<br><center>
	                <table bordercolor="#ffffff" width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){

$style_id = $_POST["style_id"];
$style_name = $_POST["style_name"];
$style_file = $_POST["style_file"];


$i_s = 0;
$f_s = 0;
$n_s = 0;
while($i_s < count($style_id)){

		$updatingStyle = $mysql->execute("UPDATE {$mysql->prefix}STYLE SET S_FILE_NAME = '".$style_file[$f_s]."', S_NAME = '".$style_name[$n_s]."' WHERE S_ID = ".$style_id[$i_s]." ");
        $n_s++;
        $f_s++;
        $i_s++;

}

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=style">
                           <a href="cp_home.php?mode=style">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}



if($method == "add"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=style&&method=add&type=set">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>إضافة ستايل جديد</nobr></td>
	</tr>
	<tr class="fixed">
		<td class="list"><nobr>اسم الستايل</nobr></td>
		<td><input type="text" name="style_name" size="20"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>اسم ملف الستايل</nobr></td>
		<td><input type="text" dir="ltr" name="style_file" size="20"></td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="إضافة ستايل">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</form>
</table>
</center>';

 }

 if($type == "set"){

    if($error != ""){
	                echo'<br><center>
	                <table bordercolor="#ffffff" width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){

$style_name = $_POST["style_name"];
$style_file = $_POST["style_file"];

     $query = "INSERT INTO {$mysql->prefix}STYLE (S_ID, S_FILE_NAME, S_NAME) VALUES (NULL, ";
     $query .= " '$style_file', ";
     $query .= " '$style_name') ";

     $mysql->execute($query, $connection, [], __FILE__, __LINE__);


                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم إضافة الستايل بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=style">
                           <a href="cp_home.php?mode=style">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
 }
}

if($method == "style"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=style&method=style&type=insert_data">
	</tr>
 	<tr class="fixed">
 			<td class="cat" colspan="4"><nobr>خيارات الستايل الإفتراضي</nobr></td>
 	<tr class="fixed">

		<td class="list"><nobr>الستايل الإفتراضي</nobr></td>
		<td class="middle" colspan="3">
        <select class="insidetitle" style="WIDTH: 150px" name="style_name">';
        $ch_style = $mysql->execute("SELECT * FROM {$mysql->prefix}STYLE ", [], __FILE__, __LINE__);
        $style_num = mysql_num_rows($ch_style);

        if($style_num > 0){

            $style_i = 0;
            while ($style_i < $style_num){

                $style_id = mysql_result($ch_style, $style_i, "S_ID");
                $style_file_name = mysql_result($ch_style, $style_i, "S_FILE_NAME");
                $style_name = mysql_result($ch_style, $style_i, "S_NAME");

                echo'<option value="'.$style_file_name.'" '.check_select($default_style, $style_file_name).'>'.$style_name.'</option>';

            ++$style_i;
            }
        }
        else {
            echo'<option value="">لا توجد أي ستايل</option>';
        }
        echo'
        </td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="4"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</form>
</table>
</center>';
 }

 if($type == "insert_data"){


    if($error != ""){
	                echo'<br><center>
	                <table bordercolor="#ffffff" width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){

updata_mysql("DEFAULT_STYLE", $_POST["style_name"]);



                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=style&method=style">
                           <a href="cp_home.php?mode=style&method=style">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}


if($method == "delete"){

$mysql->execute("DELETE FROM {$mysql->prefix}STYLE WHERE S_ID = '$id' ", [], __FILE__, __LINE__);

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم حذف الستايل بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=style">
                           <a href="cp_home.php?mode=style">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}
 
 
}
else {
    go_to("index.php");
}
?>
