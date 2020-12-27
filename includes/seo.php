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

if($seo == 1) ob_start();
function ob(){
global $seo;
if($seo == 1){
$contents = ob_get_contents();
$contents = rewrite($contents);
ob_end_clean();
echo $contents;
}}

function rewrite($url){
global $seo;
if($seo == 1){
$url = str_replace('href="index.php', 'href="f.aspx', $url);
return $url;
}
}
?>