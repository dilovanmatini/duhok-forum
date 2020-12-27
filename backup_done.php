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

require("check.php");
$tables = $_POST['check'];
$db = "-- phpMyAdmin SQL Dump
-- http://www.phpmyadmin.net
-- Duhok Frm 0.9
-- Serveur: localhost
-- Generate Date : ".date("l d/m/y H:m",time())."
-- By The Picasso
-- Database : `$dbname`
-- 

-- --------------------------------------------------------
\r\n";
foreach($tables as $table)
{
    $query = @$mysql->execute("SHOW CREATE TABLE ". $table); 
    $t_n = @mysql_fetch_array($query);

$db .="-- 
-- Structure Of Table `$table`
-- 
\r\n";

    $db .= $t_n['Create Table'] . ";\r\n\r\n";// 
    $resData = @$mysql->execute("SELECT * FROM `$t_n[Table]`");

$db .="-- 
-- Content Of Table `$table`
-- 
\r\n";


   while($result = @mysql_fetch_array($resData))
    {

$num_fields = mysql_num_fields($resData);

$row=mysql_fetch_row($resData); 

for($i=0; $i < $num_fields; $i++){
$fields[] .= "`".mysql_field_name($resData,$i)."`";
$values[] .= "'$row[$i]'";
}


$fields = join(", ", $fields);
$values = join(", ", $values);
$insert = "INSERT INTO `$t_n[Table]` ($fields) VALUES ($values);";
$db .= $insert . "\r\n";

        unset($fields);
        unset($values);
}}

header("Content-length: " . strlen($db));
header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=$dbname.sql");
echo $db;
exit;

?> 
