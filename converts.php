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

$http_host = $_SERVER['HTTP_HOST'];
$referer = $_SERVER['HTTP_REFERER'];
$mode = trim($_GET['mode']);
$step = trim($_GET['step']);
$type = trim($_GET['type']);
$method = trim($_GET['method']);
$mail = trim($_GET['mail']);
$msg = trim($_GET['msg']);
$svc = trim($_GET['svc']);
$sel = trim($_GET['sel']);
$show = trim($_GET['show']);
$app = trim($_GET['app']);
$days = trim($_GET['days']);
$scope = trim($_GET['scope']);
$sg = trim($_GET['sg']);
$ch = trim($_GET['ch']);
$tz = trim($_GET['tz']);
$c = trim($_GET['c']);
$f = trim($_GET['f']);
$t = trim($_GET['t']);
$r = trim($_GET['r']);
$m = trim($_GET['m']);
$err = trim($_GET['err']);
$id = trim($_GET['id']);
$pm = trim($_GET['pm']);
$n = trim($_GET['n']);
$pg = trim($_GET['pg']);
$active = trim($_GET['active']);
$aid = trim($_GET['aid']);
$mod_option = trim($_GET['mod_option']);
$quote = trim($_GET['quote']);
$author = trim($_GET['author']);
$tdate = trim($_GET['tdate']);
$rdate = trim($_GET['rdate']);
$src = trim($_GET['src']);
$pm_from = trim($_GET['from']);
$auth = trim($_GET['auth']);
$vote = trim($_GET['vote']);

define('http_host', trim($_SERVER['HTTP_HOST']));
define('referer', trim($_SERVER['HTTP_REFERER']));
define('mode', trim($_GET['mode']));
define('step', trim($_GET['step']));
define('type', trim($_GET['type']));
define('method', trim($_GET['method']));
define('mail', trim($_GET['mail']));
define('msg', trim($_GET['msg']));
define('svc', trim($_GET['svc']));
define('app', trim($_GET['app']));
define('days', trim($_GET['days']));
define('scope', trim($_GET['scope']));
define('c', trim($_GET['c']));
define('f', trim($_GET['f']));
define('t', trim($_GET['t']));
define('r', trim($_GET['r']));
define('m', trim($_GET['m']));
define('err', trim($_GET['err']));
define('id', trim($_GET['id']));
define('n', trim($_GET['n']));
define('pg', trim($_GET['pg']));

?>