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

$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TEMPLATES WHERE STYLE_NAME = '$id' ");

$source = '<?xml version="1.0" encoding="windows-1256"?>
<style>
<style_name>'.$id.'</style_name>';

while($r = mysql_fetch_array($sql)){
$source .= '<template>
<tmp_name>'.$r['NAME'].'</tmp_name>
<![CDATA[
'.$r['SOURCE'].'
]]>
</template>';
}
$source .= '</style>';

header("Content-length: " . strlen($source));
header('Content-Type: text/xml; charset=windows-1256'); 
header("Content-Disposition: attachment; filename=$id.xml");
echo $source;
exit;

?> 
