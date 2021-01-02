<?php
/**
 * 
 * Duhok Forum 3.0
 * @author		Dilovan Matini (original founder)
 * @copyright	2007 - 2021 Dilovan Matini
 * @see			df.lelav.com
 * @see			https://github.com/dilovanmatini/duhok-forum
 * @license		http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note		This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY;
 * 
 */

const _df_script = "friends";
const _df_filename = "friends.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
if(ulv == 0){
	$DF->goTo();
	exit();
}

$uid = uid;
if(ulv == 4 and auth > 0 and auth != uid){
	$uname = $mysql->get("user", "name", auth);
	if(!empty($uname)){
		$uid = auth;
	}
}

/*
status = 0 // wait request
status = 1 // the friend is active
status = 2 // refuse request
*/
if(type == ''){
	$numPages = 20;
	$scopeArr = array('wait', 'inref', 'friends', 'request', 'outref', 'block');
	$scope = (in_array(scope, $scopeArr)) ? scope : 'friends';
	$auth = auth;
	$u = u;
	$linkArr = array(
		'scope' => $scope,
		'auth' 	=> $auth,
		'u' 	=> $u
	);
	
	$jsLinkArr = "";
	foreach($linkArr as $key => $val){
		$jsLinkArr .= ",'{$key}','{$val}'";
	}
	if(!empty($jsLinkArr)){
		$jsLinkArr = substr($jsLinkArr,1);
	}
	?>
	<script type="text/javascript">
	var linkArr=new Array(<?=$jsLinkArr?>);
	DF.goToLink=function(arr){
		document.location=DF.checkLink("friends.php",linkArr,arr);
	};
	DF.friends.check = function(t,id){
		var types=new Array();
		types['accept']=["موافقة على طلب الصداقة","تمت الموافقة بنجاح"];
		types['refuse']=["رفض طلب الصداقة","تم رفض بنجاح"];
		types['delete']=["حذف طلب الصداقة","تم حذف بنجاح"];
		types['deleteblock']=["إزالة منع","تمت إزالة منع بنجاح"];
		if(id&&id>0){
			DM.container.open({
				body:'<div class=\"asCenter\"><img src=\"images/icons/loading2.gif\" border=\"0\"></div>',
				header:types[t][0]
			});
			var obj=DF.ajax2.connect();
			DF.ajax2.play({
				send:'type=checkFriends&method='+t+'&auth=<?=$uid?>&id='+id,
				func:function(){
					if(obj.readyState==4){
						var text=DF.friends.error("حدث خطأ أثناء "+types[t][0]);
						if(obj.status==200){
							var rs=obj.responseText.split(DF.ajax2.ac);
							if(rs&&rs[1]==1){
								text="<nobr>"+types[t][1]+"</nobr>";
								$I('#friendCell'+id).innerHTML="<img src=\"images/icons/succeed.gif\" border=\"0\">";
							}
						}
						$(DM.container.body).html(text);
						DM.container.dimension();
					}
				}
			},obj);
		}
	};
	</script>
	<?php
	$friends = array(
		'wait' => array(
			'title'		=> 'طلبات المنتظرة للصداقة معك',
			'button'	=> 'طلبات منتظرة',
			'sqlField'	=> ", fb.date",
			'sqlON1'	=> "u1.id = fb.userid",
			'sqlON2'	=> "u2.id = 0",
			'sqlTable'	=> "friends",
			'sqlWhere'	=> "WHERE fb.status = 0 AND fb.friendid = {$uid}",
			'error'		=> 'لا توجد أي طلبات ينتظر موافقتك'
		),
		'inref' => array(
			'title'		=> 'طلبات التي أنت رفضت',
			'button'	=> 'طلبات المرفوضة',
			'sqlField'	=> ", fb.date",
			'sqlON1'	=> "u1.id = fb.userid",
			'sqlON2'	=> "u2.id = 0",
			'sqlTable'	=> "friends",
			'sqlWhere'	=> "WHERE fb.status = 2 AND fb.friendid = {$uid}",
			'error'		=> 'لا توجد أي طلبات انت رفضت'
		),
		'friends' => array(
			'title'		=> 'أصدقائك',
			'button'	=> 'الأصدقاء',
			'sqlField'	=> ", fb.userid AS fuserid",
			'sqlON1'	=> "u1.id = fb.userid AND fb.friendid = {$uid}",
			'sqlON2'	=> "u2.id = fb.friendid AND fb.userid = {$uid}",
			'sqlTable'	=> "friends",
			'sqlWhere'	=> "WHERE fb.status = 1 AND (fb.userid = {$uid} OR fb.friendid = {$uid})",
			'error'		=> 'لا توجد أي صديق لك'
		),
		'request' => array(
			'title'		=> 'طلباتك الصداقة الى الآخرين',
			'button'	=> 'طلباتك المنتظرة',
			'sqlField'	=> ", fb.date",
			'sqlON1'	=> "u1.id = fb.friendid",
			'sqlON2'	=> "u2.id = 0",
			'sqlTable'	=> "friends",
			'sqlWhere'	=> "WHERE fb.status = 0 AND fb.userid = {$uid}",
			'error'		=> 'لا توجد أي طلب منك الى الآخرين'
		),
		'outref' => array(
			'title'		=> 'طلباتك التي هم رفضوا',
			'button'	=> 'طلباتك المرفوضة',
			'sqlField'	=> ", fb.date",
			'sqlON1'	=> "u1.id = fb.friendid",
			'sqlON2'	=> "u2.id = 0",
			'sqlTable'	=> "friends",
			'sqlWhere'	=> "WHERE fb.status = 2 AND fb.userid = {$uid}",
			'error'		=> 'لا توجد أي طلباتك المرفوضة من قبل آخرين'
		),
		'block' => array(
			'title'		=> 'ممنوعين',
			'button'	=> 'ممنوعين',
			'sqlField'	=> ", fb.date",
			'sqlON1'	=> "u1.id = fb.blockid",
			'sqlON2'	=> "u2.id = 0",
			'sqlTable'	=> "blocks",
			'sqlWhere'	=> "WHERE fb.userid = {$uid}",
			'error'		=> 'لا توجد أي عضو ممنوع عندك'
		)
	);

	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">";
	if(ulv == 4 and $uid != uid){
		echo"
		<tr>
			<td class=\"asBody3 asC1 asCenter\" colspan=\"4\"><nobr>حالياً تظهر صفحة أصدقاء <span class=\"asC2\">{$uname}</span></nobr></td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asTopHeader asCenter\" colspan=\"4\"><nobr>
			<ul class=\"svcbar asAS12\">
				<li".(($scope == 'wait') ? ' class="selected"' : '')."><a href=\"{$DF->checkLink('friends.php', $linkArr, array('scope' => 'wait'))}\"><em>{$friends['wait']['button']}</em></a></li>
				<li".(($scope == 'inref') ? ' class="selected"' : '')."><a href=\"{$DF->checkLink('friends.php', $linkArr, array('scope' => 'inref'))}\"><em>{$friends['inref']['button']}</em></a></li>
				<li".(($scope == 'friends') ? ' class="selected"' : '')."><a href=\"{$DF->checkLink('friends.php', $linkArr, array('scope' => 'friends'))}\"><em>{$friends['friends']['button']}</em></a></li>
				<li".(($scope == 'request') ? ' class="selected"' : '')."><a href=\"{$DF->checkLink('friends.php', $linkArr, array('scope' => 'request'))}\"><em>{$friends['request']['button']}</em></a></li>
				<li".(($scope == 'outref') ? ' class="selected"' : '')."><a href=\"{$DF->checkLink('friends.php', $linkArr, array('scope' => 'outref'))}\"><em>{$friends['outref']['button']}</em></a></li>
				<li".(($scope == 'block') ? ' class="selected"' : '')."><a href=\"{$DF->checkLink('friends.php', $linkArr, array('scope' => 'block'))}\"><em>{$friends['block']['button']}</em></a></li>
			</ul></nobr>
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"4\">الأصدقاء - <span class=\"asC2\">{$friends[scope]['title']}</span></td>
		</tr>
		<tr>
			<td class=\"asDarkB\"><nobr>عضو</nobr></td>
			<td class=\"asDarkB\"><nobr>الدولة</nobr></td>";
		if($scope!='friends'){
			echo"
			<td class=\"asDarkB\"><nobr>تاريخ</nobr></td>";
		}
			echo"
			<td class=\"asDarkB\"><nobr>خيارات</nobr></td>
		</tr>";
	function nullid($name){
		return "IF(ISNULL(u1.id), u2.{$name}, u1.{$name})";
	}
	$pgLimit=$DF->pgLimit($numPages);
  	$sql=$mysql->query("SELECT fb.id, ".nullid('id')." AS userid, ".nullid('name')." AS uname, ".nullid('status')." AS ustatus, ".nullid('level')." AS ulevel,
		".nullid('submonitor')." AS usubmonitor,uf.picture, uf.posts, uf.title, uf.sex, uf.oldlevel,
		IF(ISNULL(c.name), '--', c.name) AS country {$friends[scope]['sqlField']}
	FROM ".prefix."{$friends[scope]['sqlTable']} AS fb
	LEFT JOIN ".prefix."user AS u1 ON({$friends[scope]['sqlON1']})
	LEFT JOIN ".prefix."user AS u2 ON({$friends[scope]['sqlON2']})
	LEFT JOIN ".prefix."userflag AS uf ON(uf.id = IF(ISNULL(u1.id), u2.id, u1.id))
	LEFT JOIN ".prefix."country AS c ON(c.code = IF(ISNULL(uf.id), '', uf.country))
	{$friends[scope]['sqlWhere']} GROUP BY fb.id ORDER BY fb.date DESC LIMIT {$pgLimit},{$numPages}", __FILE__, __LINE__);
	$count=0;
	while($rs = $mysql->fetchAssoc($sql)){
		$user = $Template->userColorLink($rs['userid'], array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor']));
		$userTitle = $DF->userTitle($rs['userid'], $rs['posts'], $rs['ulevel'], $rs['title'], $rs['sex'], $rs['oldlevel'], $rs['usubmonitor']);

		echo"
		<tr>
			<td class=\"asNormalB\" width=\"400\">
			<table>
				<tr>
					<td><div class=\"asBBlack\"><img src=\"{$DFPhotos->getsrc($rs['picture'], 48)}\"{$DF->picError(32)} width=\"32\" height=\"32\" border=\"0\"></div></td>
					<td><nobr>{$user}<br><span class=\"asC5 asS12\">{$userTitle}</span></nobr></td>
				</tr>
			</table>
			</td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['country']}</nobr></td>";
		if($scope != 'friends'){
			echo"
			<td class=\"asNormalB asDate asS12 asCenter\"><nobr>{$DF->date($rs['date'],'time')}<br>{$DF->date($rs['date'],'date')}</nobr></td>";
		}
			echo"
			<td class=\"asNormalB asCenter\" id=\"friendCell{$rs['id']}\"><nobr>";
			if($scope == 'wait'){
				echo $Template->button("موافق"," onClick=\"DF.friends.check('accept',{$rs['id']});\"")."&nbsp;";
				echo $Template->button("رفض"," onClick=\"DF.friends.check('refuse',{$rs['id']});\"")."&nbsp;";
			}
			elseif($scope == 'inref'){
				echo $Template->button("موافقة"," onClick=\"DF.friends.check('accept',{$rs['id']});\"")."&nbsp;";
			}
			elseif($scope == 'friends'){
				if($rs['fuserid'] == $uid){
					echo $Template->button("حذف"," onClick=\"DF.friends.check('delete',{$rs['id']});\"")."&nbsp;";
				}
				else{
					echo $Template->button("حذف"," onClick=\"DF.friends.check('refuse',{$rs['id']});\"")."&nbsp;";
				}
			}
			elseif($scope == 'request'){
				echo $Template->button("حذف"," onClick=\"DF.friends.check('delete',{$rs['id']});\"")."&nbsp;";
			}
			elseif($scope == 'outref'){
				echo "--";
			}
			elseif($scope == 'block'){
				echo $Template->button("حذف"," onClick=\"DF.friends.check('deleteblock',{$rs['id']});\"")."&nbsp;";
			}
			echo"</nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"4\"><br>-- {$friends[scope]['error']} --<br><br></td>
		</tr>";
	}
	$pageing = $Template->paging("{$friends[scope]['sqlTable']} AS fb LEFT JOIN ".prefix."user AS u1 ON({$friends[scope]['sqlON1']}) LEFT JOIN ".prefix."user AS u2 ON({$friends[scope]['sqlON2']}) {$friends[scope]['sqlWhere']}", "friends.php?scope={$scope}&auth={$uid}&", "fb.id", $numPages);
	if(!empty($pageing)){
		echo"
		<tr>
			<td class=\"asNormalB\" colspan=\"4\"><div align=\"center\">{$pageing}</div></td>
		</tr>";
	}
	echo"
	</table>";
}
elseif(type == 'friends'){
	/*
	showfriends = 1 // show for all users
	showfriends = 2 // show for all friends and up levels
	showfriends = 3 // just show for you and up levels
	*/
	$numPages = 20;//IF(ISNULL(f1.id) AND ISNULL(f2.id), 0, IF(ISNULL(f1.id), f1.id, f1.id))
 	$rs = $mysql->queryRow("SELECT u.id, u.name, u.status, u.level, IF(ISNULL(f1.id), 0, 1), IF(ISNULL(f2.id), 0, 1), up.showfriends
	FROM ".prefix."user AS u
	LEFT JOIN ".prefix."userperm AS up ON(up.id = u.id)
	LEFT JOIN ".prefix."friends AS f1 ON(f1.status = 1 AND f1.userid = u.id AND f1.friendid = ".uid.")
	LEFT JOIN ".prefix."friends AS f2 ON(f2.status = 1 AND f2.friendid = u.id AND f2.userid = ".uid.")
	WHERE u.id = ".u." GROUP BY u.id", __FILE__, __LINE__);
	$u = intval($rs[0]);
	$uname = $rs[1];
	$ustatus = intval($rs[2]);
	$ulevel = intval($rs[3]);
	$isfriend1 = intval($rs[4]);
	$isfriend2 = intval($rs[5]);
	$showfriends = intval($rs[6]);
	$showfriends = (uid == $u or $showfriends == 1 or $showfriends == 2 and ($isfriend1 == 1 or $isfriend2 == 1) or $showfriends == 3 and $ulevel < ulv) ? true : false;
	if($showfriends){
		echo"
		<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
			<tr>
				<td class=\"asHeader\" colspan=\"3\">أصدقاء العضو <span class=\"asC2\">{$uname}</span></td>
			</tr>
			<tr>
				<td class=\"asDarkB\"><nobr>عضو</nobr></td>
				<td class=\"asDarkB\"><nobr>الدولة</nobr></td>
				<td class=\"asDarkB\"><nobr>خيارات</nobr></td>
			</tr>";
		function nullid($name){
			return "IF(ISNULL(u1.id), u2.{$name}, u1.{$name})";
		}
		$pgLimit = $DF->pgLimit($numPages);
		$sql=$mysql->query("SELECT
			f.id, ".nullid('id')." AS userid, ".nullid('name')." AS uname, ".nullid('status')." AS ustatus, ".nullid('level')." AS ulevel,
			".nullid('submonitor')." AS usubmonitor, uf.picture, uf.posts, uf.title, uf.sex, uf.oldlevel,
			IF(ISNULL(c.name), '--' ,c.name) AS country, f.userid AS fuserid
		FROM ".prefix."friends AS f
		LEFT JOIN ".prefix."user AS u1 ON(u1.id = f.userid AND f.friendid = {$u})
		LEFT JOIN ".prefix."user AS u2 ON(u2.id = f.friendid AND f.userid = {$u})
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = IF(ISNULL(u1.id), u2.id, u1.id))
		LEFT JOIN ".prefix."country AS c ON(c.code = uf.country)
		WHERE f.status = 1 AND (f.userid = {$u} OR f.friendid = {$u}) GROUP BY f.id ORDER BY f.date DESC LIMIT {$pgLimit},{$numPages}", __FILE__, __LINE__);
		$count=0;
		while($rs=$mysql->fetchAssoc($sql)){
			$user=$Template->userColorLink($rs['userid'], array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor']));
			$userTitle=$DF->userTitle($rs['userid'], $rs['posts'], $rs['ulevel'], $rs['title'], $rs['sex'], $rs['oldlevel'], $rs['usubmonitor']);
			echo"
			<tr>
				<td class=\"asNormalB\" width=\"400\">
				<table>
					<tr>
						<td><div class=\"asBBlack\"><img src=\"{$DFPhotos->getsrc($rs['picture'], 48)}\"{$DF->picError(32)} border=\"0\"></div></td>
						<td><nobr>{$user}<br><span class=\"asC5 asS12\">{$userTitle}</span></nobr></td>
					</tr>
				</table>
				</td>
				<td class=\"asNormalB asS12 asCenter\"><nobr>{$rs['country']}</nobr></td>
				<td class=\"asNormalB asCenter\"><nobr><a class=\"asTooltip\" onclick=\"DF.friends.add({$rs['userid']});return false;\" href=\"#\"><img src=\"images/icons/add.gif\" border=\"0\">{$Template->tooltip('أضف عضو صديق لك')}</a></nobr></td>
			</tr>";
			$count++;
		}
		if($count==0){
			echo"
			<tr>
				<td class=\"asNormalB asCenter\" colspan=\"3\"><br>&nbsp;&nbsp;&nbsp;&nbsp;-- لا توجد أي صديق --&nbsp;&nbsp;&nbsp;&nbsp;<br><br></td>
			</tr>";
		}
		$pageing=$Template->paging("friends AS f LEFT JOIN ".prefix."user AS u ON((u.id = f.userid AND f.friendid = {$u}) OR (u.id = f.friendid AND f.userid = {$u})) WHERE f.status = 1 AND (f.userid = {$u} OR f.friendid = {$u})","friends.php?type=friends&u={$u}&","f.id",$numPages);
		if(!empty($pageing)){
			echo"
			<tr>
				<td class=\"asNormalB\" colspan=\"3\"><div align=\"center\">{$pageing}</div></td>
			</tr>";
		}
		echo"
		</table>";
	}
	else{
		$Template->errMsg("لا يمكنك مشاهدة صفحة أصدقاء العضو");
	}
}
else{
	$DF->goTo();
}

$Template->footer();
?>