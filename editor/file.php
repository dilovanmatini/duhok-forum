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

$offset = 60 * 60 * 24 * 3; 
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
$file = $_GET['file'];   
if($file == "box_Symbol.htm"){
$filename = "box_Symbol.htm";
} 
if($file == "box_Page.htm"){
$filename = "box_Page.htm";
} 
if($file == "box_Table.htm"){
$filename = "box_Table.htm";
} 
header('Content-type: text/html');    
header('Content-transfer-encoding: binary');    
header("Cache-Control: must-revalidate");    
header($ExpStr);    
readfile($filename);
?>