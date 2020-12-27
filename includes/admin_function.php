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

function changename_count($id){

  global $Prefix;
  $changename_count = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}CHANGENAME_PENDING WHERE CH_DONE = '0' AND UNDERDEMANDE = '$id' ", [], __FILE__, __LINE__);
  $Count = mysql_result($changename_count, 0, "count(*)");

  return($Count);
}

function notify_count($id){

  global $Prefix;
  $notify_count = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}NOTIFY WHERE STATUS = '$id' ", [], __FILE__, __LINE__);
  $Count = mysql_result($notify_count, 0, "count(*)");

  return($Count);
}

?>
