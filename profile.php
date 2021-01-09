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

const _df_script = "profile";
const _df_filename = "profile.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
if(type == ""){
	function userTitles($uid, $ulv, $posts, $title, $sex, $oldlevel, $submonitor){
 		global $mysql, $DF, $Template;
		$all_titles = array();
		$titles = unserialize(($sex == 2) ? female_titles : male_titles);
				
		if($ulv > 1 or $oldlevel > 1){
			$all_titles[] = $DF->userTitle($uid, $posts, $ulv, $title, $sex, $oldlevel, $submonitor);
		}
		
		if($ulv == 2 && $submonitor == 0){
			$sql = $mysql->query("SELECT f.id, f.subject
			FROM ".prefix."moderator AS m
			LEFT JOIN ".prefix."forum AS f ON(f.id = m.forumid)
			WHERE m.userid = {$uid} ORDER BY m.id ASC", __FILE__, __LINE__);
			while($rs = $mysql->fetchRow($sql)){
				$all_titles[] = "{$titles[2][0][0]} - {$Template->forumLink($rs[0], $rs[1])}";
			}
		}
		
		if($ulv == 2 && $submonitor == 1){
			$sql = $mysql->query("SELECT subject FROM ".prefix."category WHERE submonitor = {$uid} ORDER BY sort ASC", __FILE__, __LINE__);
			while($rs = $mysql->fetchRow($sql)){
				$all_titles[] = "{$titles[2][1][0]} - {$rs[0]}";
			}
		}
		
		if($ulv == 3){
			$sql = $mysql->query("SELECT subject FROM ".prefix."category WHERE monitor = {$uid} ORDER BY sort ASC", __FILE__, __LINE__);
			while($rs = $mysql->fetchRow($sql)){
				$all_titles[] = "{$titles[3][0]} - {$rs[0]}";
			}
		}
		
		if($ulv < 4){
			$sql = $mysql->query("SELECT tl.subject, tl.forumid, f.subject AS fsubject, tl.global
			FROM ".prefix."title AS t
			LEFT JOIN ".prefix."titlelists AS tl ON(tl.id = t.listid)
			LEFT JOIN ".prefix."forum AS f ON(f.id = tl.forumid)
			WHERE t.userid = {$uid} AND t.status = 1 ORDER BY t.id ASC", __FILE__, __LINE__);
			$arr = array();
			while($rs = $mysql->fetchRow($sql)){
				$list_titles = ($rs[3] == 1) ? "<font color=\"blue\">{$rs[0]}</font>" : $rs[0];
				$all_titles[] = "{$list_titles} - {$Template->forumLink($rs[1], $rs[2])}";
			}
		}
		
		$all_titles = implode("<br>", $all_titles);
		return $all_titles;
	}
	$sql = $mysql->query("SELECT
		u.id,u.status,u.name,u.level,u.submonitor,u.date,uf.*,up.receiveemail,up.receivepm,up.hidephoto,
		up.hidesignature,up.hidebrowse,up.hideselfprofile,up.showbirthday,IF(NOT ISNULL(c.name),c.name,'--') AS ucountry
	FROM ".prefix."user AS u
	LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
	LEFT JOIN ".prefix."userperm AS up ON(up.id = u.id)
	LEFT JOIN ".prefix."country AS c ON(c.code = uf.country)
	WHERE u.id = '".u."'", __FILE__, __LINE__);
	$rs=$mysql->fetchAssoc($sql);
	$u=(int)$rs['id'];
	$hideusersprofile=$mysql->get("userperm","hideusersprofile",uid);
	if($u == 0){
		unset($rs);
		$Template->errMsg("لم يتم العثو على أي عضوية.");
		exit();
	}
	elseif(ulv == 0){
		unset($rs);
		$Template->errMsg("لا يمكنك مشاهدة بيانات العضويات لأن انت ليس مسجل عندنا<br>لتسجيل في منتديات <a href=\"register.php\">انقر هنا</a>");
		exit();
	}
	elseif($rs['status'] == 0&&ulv < 2){
		unset($rs);
		$Template->errMsg("لا يمكنك مشاهدة هذه العضوية<br>بسبب ان هذه العضوية هي مقفولة من قبل الإدارة.");
		exit();
	}
	elseif($rs['status']>1&&ulv != 4){
		unset($rs);
		$Template->errMsg("لا يمكنك مشاهدة هذه العضوية<br>بسبب لم يتم موافقة عليها من قبل الإدارة.");
		exit();
	}
	elseif($rs['hideselfprofile'] == 1&&$u!=uid&&ulv < 2){
		unset($rs);
		$Template->errMsg("لا يمكنك مشاهدة هذه العضوية<br>بسبب إخفاء بيانات هذه العضوية لأعضاء الآخرين من قبل الإدارة.");
		exit();
	}
	elseif($hideusersprofile == 1&&$u!=uid&&ulv < 2){
		unset($rs);
		$Template->errMsg("لا يمكنك مشاهدة هذه العضوية<br>بسبب تم منعك من مشاهدة بيانات الأعضاء من قبل الإدارة.");
		exit();
	}
	if($u!=uid){
		$mysql->update("userflag SET views = views + 1 WHERE id = '$u'", __FILE__, __LINE__);
	}

	if($rs['status'] == 0){
		$profileStatus="العضوية مقفولة";
	}
	elseif($rs['status'] == 2){
		$profileStatus="لم يتم الموافقة على العضوية حتى الآن";
	}
	elseif($rs['status'] == 3){
		$profileStatus="تم رفض هذه العضوية من قبل الإدارة";
	}
	$canViewLastVisit=($rs['hidebrowse'] == 0&&$rs['level']<2||$rs['level']<3&&ulv > 1||$rs['level'] == 3&&$u == uid||ulv == 4 ? true : false);
	if($canViewLastVisit){
		$sql=$mysql->query("SELECT COUNT(ip) FROM ".prefix."useronline WHERE userid = {$u}", __FILE__, __LINE__);
		$count=$mysql->fetchRow($sql);
		if($count[0]>0) $isOnline="<br><img src=\"{$DFImage->i['online']}\" border=\"0\"><br>متصل الآن";
	}
	?>
	<script type="text/javascript">
	$(function(){
		$.ajax({
			type: 'POST',
			url: 'ajax.php?x='+Math.floor(Math.random() * 999999999),
			data: 'type=set_data_to_database&method=setUserActivity_profileview&u=<?=$u?>'
		});
	});
	function chkSubmitOptions(s){
		var v=s.options[s.selectedIndex].value;
		if(v!='') document.location=v;
	}
	</script>
	<?php
	if($rs['hideselfprofile'] == 1){
		echo"
		<table width=\"100%\" cellSpacing=\"2\" cellPadding=\"4\">
			<tr>
				<td class=\"asError\">لا يمكن للأعضاء بمشاهدة تفاصيل هذه العضوية بسبب تم إخفائها من قبل الإدارة</td>
			</tr>
		</table>";
	}

	echo"
	<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\" align=\"center\">
		<tr>
			<td width=\"35%\" valign=\"top\">
			<table width=\"100%\" cellSpacing=\"1\" cellpadding=\"4\">";
				echo"
				<tr>
					<td class=\"asHeader\">صورة شخصية</td>
					<td class=\"asHeader\">خيارات العضوية</td>
				</tr>
				<tr>
					<td class=\"asFixedB asP4 asCenter\"><img src=\"{$DFPhotos->getsrc($rs['picture'], 200)}\"{$DF->picError(100)} width=\"100\" height=\"100\" class=\"asBBlack\"></td>
					<td class=\"asFixedB asP0\" rowspan=\"2\">
					<table width=\"100%\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\">";
					if($rs['receivepm'] == 1||ulv > 1){
						$msgUrl=($rs['level'] == 4 ? "profile.php?type=sendadmin" : "editor.php?type=sendpm");
						echo"
						<tr>
							<td class=\"asNormalB asLeftBorder asBottomBorder asCenter\" style=\"padding-top:1px\"><img src=\"images/icons/sendmsg.gif\" border=\"0\"></td>
							<td class=\"asNormalB asBottomBorder asAS12\"><a href=\"{$msgUrl}&u={$u}&src=".urlencode(self)."\"><nobr>ارسل رسالة خاصة للعضو</nobr></a></td>
						</tr>";
					}
						echo"
						<tr>
							<td class=\"asNormalB asLeftBorder asBottomBorder asCenter\" style=\"padding-top:0px\"><img src=\"images/icons/friends.gif\" border=\"0\"></td>
							<td class=\"asNormalB asBottomBorder asAS12\"><a href=\"friends.php?type=friends&u={$u}\"><nobr>أصدقاء العضو</nobr></a></td>
						</tr>";
					if($u!=uid){
						echo"
						<tr>
							<td class=\"asNormalB asLeftBorder asBottomBorder asCenter\" style=\"padding-top:0px\"><img src=\"images/icons/add.gif\" border=\"0\"></td>
							<td class=\"asNormalB asBottomBorder asAS12\"><a onclick=\"DF.friends.add({$u});return false;\" href=\"#\"><nobr>أضف عضو صديق لك</nobr></a></td>
						</tr>
						<tr>
							<td class=\"asNormalB asLeftBorder asBottomBorder asCenter\" style=\"padding-top:0px\"><img src=\"images/icons/block.gif\" border=\"0\"></td>
							<td class=\"asNormalB asBottomBorder asAS12\"><a onclick=\"DF.friends.block({$u});return false;\" href=\"#\"><nobr>منع عضو من اتصال بك</nobr></a></td>
						</tr>";
					}
						echo"
						<tr>
							<td class=\"asNormalB asLeftBorder asBottomBorder asCenter\" style=\"padding-top:0px\"><img src=\"images/icons/mutualmsg.gif\" border=\"0\"></td>
							<td class=\"asNormalB asBottomBorder asAS12\"><a href=\"pm.php?mail=u&u={$u}\"><nobr>مراسلاتك مع العضو</nobr></a></td>
						</tr>
						<tr>
							<td class=\"asNormalB asLeftBorder asBottomBorder asCenter\" style=\"padding-top:0px\"><img src=\"images/icons/posts.gif\" border=\"0\"></td>
							<td class=\"asNormalB asBottomBorder asAS12\"><a href=\"yourposts.php?auth={$u}\"><nobr>مشاركات العضو</nobr></a></td>
						</tr>
						<tr>
							<td class=\"asNormalB asLeftBorder asBottomBorder asCenter\" style=\"padding-top:0px\" width=\"5%\"><img src=\"styles/folders/folder.png\" border=\"0\"></td>
							<td class=\"asNormalB asBottomBorder asAS12\"><a href=\"yourtopics.php?auth={$u}\"><nobr>مواضيع العضو</nobr></a></td>
						</tr>";
					if(ulv > 2&&$rs['level'] == 2){
					$mod_bloc=$mysql->get("moderator","block",$u,"userid");
					if($mod_bloc == 0){
					echo"
						<tr>
							<td class=\"asNormalB asLeftBorder asBottomBorder asCenter\" style=\"padding-top:0px\"><img src=\"images/icons/remove.png\" border=\"0\"></td>
							<td class=\"asNormalB asBottomBorder asAS12\"><a href=\"svc.php?svc=modblock&type=user&u={$u}\"><nobr>تجميد إشراف العضوية</nobr></a></td>
						</tr>";
					}else{
					echo"
						<tr>
							<td class=\"asNormalB asLeftBorder asBottomBorder asCenter\" style=\"padding-top:0px\"><img src=\"images/icons/add.png\" border=\"0\"></td>
							<td class=\"asNormalB asBottomBorder asAS12\"><a href=\"svc.php?svc=modblock&type=user&u={$u}\"><nobr>إلغاء تجميد إشراف العضوية</nobr></a></td>
						</tr>";
					}
					}
				
					if(ulv > 1){
						echo"
						<tr>
							<td class=\"asNormalB asLeftBorder asBottomBorder asCenter\" style=\"padding-top:0px\" width=\"5%\"><img src=\"images/icons/sitting.gif\" border=\"0\"></td>
							<td class=\"asNormalB asBottomBorder\">
							<select class=\"asGoTo asS12\" style=\"width:100%\" name=\"options\" onChange=\"chkSubmitOptions(this)\">
								<option value=\"\">-- اختر خيار --</option>
								<option value=\"svc.php?svc=medals&type=awardforums&u={$u}\">أضف وسام التميز للعضو</option>
								<option value=\"svc.php?svc=medals&type=distribute&app=all&scope=all&days=-1&u={$u}\">تفاصيل أوسمة العضو</option>
								<option value=\"svc.php?svc=titles&type=awardforums&u={$u}\">أضف وصف للعضو</option>
								<option value=\"svc.php?svc=titles&type=usertitles&u={$u}\">تفاصيل أوصاف العضو</option>
								<option value=\"svc.php?svc=mons&type=addmon&u={$u}\">تطبيق عقوبة على العضو</option>
								<option value=\"svc.php?svc=mons&type=global&scope=all&app=all&days=-1&u={$u}\">تفاصيل عقوبات العضو</option>";
							if(ulv > 2){
									echo"
									<option value=\"\">-----------------------------------------------</option>
									<option value=\"profile.php?type=loginbar&u={$u}\">سجل دخول للعضوية</option>
									<option value=\"profile.php?type=trylogin&u={$u}\">محاولات دخول للعضوية</option>
									<option value=\"profile.php?type=loginsessions&u={$u}\">جلسات دخول للعضوية</option>";
								if(ulv == 3 && $rs['level'] < 3 || ulv == 4 && $rs['level'] < 4){
									echo"
									<option value=\"pm.php?mail=in&auth={$u}\">رسائل خاصة للعضو</option>
									<option value=\"pm.php?mail=lists&auth={$u}\">مجدات بريدية للعضو</option>";
								}
									echo"
									<option value=\"profile.php?type=hiddentopics&auth={$u}\">مواضيع مخفية ومفتوحة للعضو</option>
									<option value=\"editor.php?type=signature&u={$u}&src=".urlencode(self)."\">تعديل التوقيع</option>";
								if(ulv == 4){
									echo"
									<option value=\"admincp.php?type=users&method=edituser&u={$u}\">تعديل العضوية</option>
									<option value=\"admincp.php?type=users&method=userperm&u={$u}\">تعديل تصاريح</option>
									<option value=\"admincp.php?type=ip&method=ipchecking&u={$u}&id={$rs['ip']}\">مطابقة IP</option>
									<option value=\"profile.php?type=activity&auth={$u}\">نشاط العضوية</option>
									<option value=\"friends.php?scope=wait&auth={$u}\">أصدقاء العضوية</option>";
								}
							}
							echo"
							</select>
							</td>
						</tr>";
					}
					echo"
					</table>
					</td>
				</tr>
				<tr>
					<td class=\"asFixedB asCenter asS12\"><nobr><a href=\"profile.php?u={$u}\">{$rs['name']}</a>{$isOnline}</nobr></td>
				</tr>";
				echo"
				<tr>
					<td class=\"asHeader\" colspan=\"2\">معلومات الشخصية</td>
				</tr>";
			if($rs['sex']>0){
				$sexType=array('1'=>'ذكر','2'=>'انثى');
				echo"
				<tr>
					<td class=\"asFixedB asS12\"><nobr>الجنس</nobr></td>
					<td class=\"asNormalB asS12\">{$sexType[$rs['sex']]}</td>
				</tr>";
			}
			if($rs['showbirthday']>0||ulv>$rs['level']){
				$ex=explode("-",$rs['brithday']);
				$y=(int)$ex[0];
				$m=(int)$ex[1];
				$m=$Template->monthName["{$m}"];
				$d=(int)$ex[2];
				if($rs['showbirthday'] == 2||ulv>$rs['level']) $birthday="{$d} {$m} {$y}";
				elseif($rs['showbirthday'] == 1) $birthday="{$d} {$m}";
				else $birthday="";
				echo"
				<tr>
					<td class=\"asFixedB asS12\"><nobr>تاريخ الميلاد</nobr></td>
					<td class=\"asNormalB asS12\">{$birthday}</td>
				</tr>";
			}
				echo"
				<tr>
					<td class=\"asFixedB asS12\">العنوان</td>
					<td class=\"asNormalB asS12\">";
					$location=array($rs['ucountry']);
					$state=trim($rs['state']);
					$city=trim($rs['city']);
					if(!empty($state)) $location[]=$state;
					if(!empty($city)) $location[]=$city;
					$location=implode("<span class=\"asS15\">&nbsp;&nbsp;&#187;&nbsp;&nbsp;</span>",$location);
					echo"{$location}</td>
				</tr>";
			if(trim($rs['marstatus'])!=""){
				echo"
				<tr>
					<td class=\"asFixedB asS12\"><nobr>الحالة الإجتماعية</nobr></td>
					<td class=\"asNormalB asS12\">{$rs['marstatus']}</td>
				</tr>";
			}
			if(trim($rs['occupation'])!=""){
				echo"
				<tr>
					<td class=\"asFixedB asS12\"><nobr>المهنة</nobr></td>
					<td class=\"asNormalB asS12\">{$rs['occupation']}</td>
				</tr>";
			}
				echo"
				<tr>
					<td class=\"asHeader\" colspan=\"2\">إحصائيات</td>
				</tr>";
 			if(!empty($profileStatus)){
				echo"
				<tr>
					<td class=\"asFixedB asS12\"><nobr>حالة العضوية</nobr></td>
					<td class=\"asNormalB asS12\"><span class=\"asC4\">{$profileStatus}</span></td>
				</tr>";
			}
			if($rs['level']<4){
				echo"
				<tr>
					<td class=\"asFixedB asS12\"><nobr>عدد المشاركات</nobr></td>
					<td class=\"asNormalB asS12\">{$rs['posts']}</td>
				</tr>";
			}
			if($rs['points']>0&&$rs['level']<4){
				echo"
				<tr>
					<td class=\"asFixedB asS12\"><nobr>نقاط التميز</nobr></td>
					<td class=\"asNormalB asS12\">{$rs['points']}</td>
				</tr>";
			}
				echo"
				<tr>
					<td class=\"asFixedB asS12\" width=\"1%\"><nobr>المشاهدات</nobr></td>
					<td class=\"asNormalB asS12\">{$rs['views']}</td>
				</tr>
				<tr>
					<td class=\"asFixedB asS12\" width=\"1%\"><nobr>تاريخ التسجيل</nobr></td>
					<td class=\"asNormalB asDate asS12\">{$DF->date($rs['date'])}</td>
				</tr>";
			if($rs['level']<3||ulv == 4){
				echo"
				<tr>
					<td class=\"asFixedB asS12\"><nobr>آخر مشاركة</nobr></td>
					<td class=\"asNormalB asDate asS12\">{$DF->date($rs['lpdate'])}</td>
				</tr>";
			}
			if($canViewLastVisit){
				echo"
				<tr>
					<td class=\"asFixedB asS12\"><nobr>آخر زيارة</nobr></td>
					<td class=\"asNormalB asDate asS12\">{$DF->date($rs['lhdate'])}</td>
				</tr>";
			}
			if(trim($rs['biography'])!=""){
				echo"
				<tr>
					<td class=\"asHeader\" colspan=\"2\">السيرة الذاتية</td>
				</tr>
				<tr>
					<td class=\"asNormalB asS12\" colspan=\"2\">{$rs['biography']}</td>
				</tr>";
			}
			$userTitles = userTitles($u, $rs['level'], $rs['posts'], $rs['title'], $rs['sex'], $rs['oldlevel'], $rs['submonitor']);
			if(!empty($userTitles)){
				echo"
				<tr>
					<td class=\"asHeader\" colspan=\"2\">الأوصاف</td>
				</tr>
				<tr>
					<td class=\"asNormalB asAS12 asC5 asS12\" colspan=\"2\">{$userTitles}</td>
				</tr>";
			}
		$sql=$mysql->query("SELECT oldname,date FROM ".prefix."changename WHERE userid = {$u} AND status = 1 ORDER BY date ASC", __FILE__, __LINE__);
		if($mysql->numRows($sql)>0){
				echo"
				<tr>
					<td class=\"asHeader\" colspan=\"2\">الأسماء السابقة</td>
				</tr>";
			while($chname=$mysql->fetchRow($sql)){
				echo"
				<tr>
					<td class=\"asFixedB asS12\" width=\"1%\"><nobr>{$DF->date($chname[1],'date')}</nobr></td>
					<td class=\"asNormalB asS12\">{$chname[0]}</td>
				</tr>";
			}
		}
 		$sql=$mysql->query("SELECT m.date,ml.subject,ml.filename,f.subject AS fsubject
		FROM ".prefix."medal AS m
		LEFT JOIN ".prefix."medallists AS ml ON(ml.id = m.listid)
		LEFT JOIN ".prefix."forum AS f ON(f.id = ml.forumid)
		WHERE m.userid = {$u} AND m.status = 1 ORDER BY date DESC LIMIT 5", __FILE__, __LINE__);
		if($mysql->numRows($sql)>0){
				echo"
				<tr>
					<td class=\"asHeader\" colspan=\"2\">آخر أوسمة التمييز الممنوحة</td>
				</tr>";
			while($mrs=$mysql->fetchAssoc($sql)){
				echo"
				<tr>
					<td class=\"asNormalB asCenter\" width=\"5%\"><img src=\"{$DFPhotos->getsrc($mrs['filename'])}\" onError=\"this.src='{$DFImage->i['nophoto']}';\" width=\"60\" height=\"60\" border=0></td>
					<td class=\"asNormalB asCenter asAS12 asS12\"><span class=\"asC4\">{$mrs['fsubject']}</span><br>{$mrs['subject']}<br><span class=\"asC5\">{$DF->date($mrs['date'],'date',true)}</span></td>
				</tr>";
			}
		}
			echo"
			</table>
			</td>
			<td width=\"2%\"><nobr>&nbsp;&nbsp;</nobr></td>
			<td width=\"63%\" valign=\"top\">
			<table width=\"100%\" cellSpacing=\"1\" cellpadding=\"4\" border=\"0\">
				<tr>
					<td class=\"asHeader\" colspan=\"2\">آخر مواضيع</td>
				</tr>";
			$Template->goToForum(true);
			$fList=implode(",",array_keys($Template->forumsList));
 			$sql=$mysql->query("SELECT id,subject FROM ".prefix."topic
			WHERE author = {$u} AND forumid IN({$fList}) AND moderate = 0 AND hidden = 0 AND trash = 0
			ORDER BY date DESC LIMIT 10", __FILE__, __LINE__);
			$count=0;
			while($ltrs=$mysql->fetchRow($sql)){
				echo"
				<tr>
					<td class=\"asNormalB\" width=\"2%\"><img src=\"styles/folders/folder.png\" border=\"0\"></td>
					<td class=\"asNormalB asAS12\">{$Template->topicLink($ltrs[0],$ltrs[1])}</td>
				</tr>";
				$count++;
			}
			if($count == 0){
				echo"
				<tr>
					<td class=\"asNormalB asCenter asS12\" colspan=\"2\">لا توجد أي مواضيع للعضوية</td>
				</tr>";
			}
				echo"
				<tr>
					<td class=\"asHeader\" colspan=\"2\">آخر مشاركات</td>
				</tr>";
 			$sql=$mysql->query("SELECT t.id,t.subject,p.id
			FROM ".prefix."post AS p
			LEFT JOIN ".prefix."topic AS t ON(t.id = p.topicid)
			WHERE p.author = {$u} AND p.forumid IN({$fList}) AND p.moderate = 0 AND p.hidden = 0 AND p.trash = 0 AND t.moderate = 0 AND t.hidden = 0 AND t.trash = 0
			GROUP BY p.id ORDER BY p.date DESC LIMIT 10", __FILE__, __LINE__);
			$count=0;
			while($lprs=$mysql->fetchRow($sql)){
				echo"
				<tr>
					<td class=\"asNormalB\" width=\"2%\"><img src=\"images/icons/reply.gif\" border=\"0\"></td>
					<td class=\"asNormalB asAS12\"><a href=\"topics.php?t={$lprs[0]}&p={$lprs[2]}\">قام بالمشاركة في موضوع ({$lprs[1]})</a></td>
				</tr>";
				$count++;
			}
			if($count == 0){
				echo"
				<tr>
					<td class=\"asNormalB asCenter asS12\" colspan=\"2\">لا توجد أية مشاركات للعضوية</td>
				</tr>";
			}
				echo"
				<tr>
					<td class=\"asHeader\" colspan=\"2\">آخر طلبات الصداقة</td>
				</tr>";

 			$sql = $mysql->query("SELECT IF(NOT ISNULL(u1.id), u1.id, u2.id), IF(NOT ISNULL(u1.id), u1.name, u2.name),
			IF(NOT ISNULL(u1.id), u1.status, u2.status), IF(NOT ISNULL(u1.id), u1.level, u2.level), IF(NOT ISNULL(u1.id), u1.submonitor, u2.submonitor)
			FROM ".prefix."friends AS f
			LEFT JOIN ".prefix."user AS u1 ON(u1.id = f.userid AND f.friendid = {$u})
			LEFT JOIN ".prefix."user AS u2 ON(u2.id = f.friendid AND f.userid = {$u})
			WHERE f.status = 1 AND (f.userid = {$u} OR f.friendid = {$u}) GROUP BY f.id ORDER BY f.date DESC LIMIT 10", __FILE__, __LINE__);
			$thisUser = $Template->userColorLink($u, array($rs['name'], $rs['status'], $rs['level'], $rs['submonitor']));
			$count = 0;
			while($frs = $mysql->fetchRow($sql)){
				$thatUser = $Template->userColorLink($frs[0], array($frs[1], $frs[2], $frs[3], $frs[4]));
				echo"
				<tr>
					<td class=\"asNormalB\" width=\"2%\"><img src=\"images/icons/add.gif\" border=\"0\"></td>
					<td class=\"asNormalB asAS12 asS12\">{$thisUser} الآن صديق مع {$thatUser}</td>
				</tr>";
				$count++;
			}
			if($count == 0){
				echo"
				<tr>
					<td class=\"asNormalB asCenter asS12\" colspan=\"2\">لا توجد أية طلبات الصداقة للعضوية</td>
				</tr>";
			}
			echo"
			</table>
			</td>
		</tr>";
	if(trim($rs['signature'])!=''){
		echo"
		<tr>
			<td class=\"asVP2\" colspan=\"3\">
			<table width=\"100%\" cellSpacing=\"1\" cellpadding=\"4\" border=\"0\">
				<tr>
					<td class=\"asHeader\" colspan=\"3\">التوقيع</td>
				</tr>";
			if($rs['hidesignature'] == 1){
				echo"
				<tr>
					<td class=\"asErrorB\" colspan=\"3\">** تم إخفاء توقيع هذه العضوية بواسطة الإدارة **</td>
				</tr>";
			}
				echo"
				<tr>
					<td class=\"asNormalB asCenter\" colspan=\"3\">";
					if($rs['hidesignature'] == 0||$u == uid||ulv > 1) echo $rs['signature'];
					echo"
					</td>
				</tr>
			</table>
			</td>
		</tr>";
	}
	echo"
	</table>";
	unset($rs);
}
elseif(type == "details"){
	if(ulv == 0){
		$DF->goTo();
		exit();
	}
	$options=array(
		array(
			'status'=>true,
			'url'=>'profile.php?type=editpicture',
			'iconname'=>'changepicture',
			'subject'=>'صورة الشخصية',
			'disc'=>'لرفع او تغيير صورة الشخصية الخاصة بك'
		),
		array(
			'status'=>true,
			'url'=>'friends.php?scope=friends',
			'iconname'=>'friends',
			'subject'=>'الأصدقاء',
			'disc'=>'للموافقة أو رفض أو حذف طلبات الصداقة بينك وبين الأعضاء'
		),
		array(
			'status'=>true,
			'url'=>'profile.php?type=editpass',
			'iconname'=>'changedetails',
			'subject'=>'بريد الالكتروني وكلمة السرية',
			'disc'=>'لتغيير بريدك الالكتروني او كلمة السرية الخاصة لعضويتك'
		),
		array(
			'status'=>true,
			'url'=>'profile.php?type=editdetails',
			'iconname'=>'sitting',
			'subject'=>'خيارات العضوية وبيانات الشخصية',
			'disc'=>'لتغيير خيارات عضويتك او تغيير بيانات الشخصية خاصة لعضويتك'
		),
		array(
			'status'=>true,
			'url'=>'profile.php?type=activity',
			'iconname'=>'activity',
			'subject'=>'نشاطك في المنتدى',
			'disc'=>'لمعرفة نشاطك في المنتدى وعدد نقاط التي حصلت عليها'
		),
		array(
			'status'=>true,
			'url'=>'profile.php?type=medals',
			'iconname'=>'medal',
			'subject'=>'تفاصيل الأوسمة الممنوحة لك',
			'disc'=>'تفاصيل الأوسمة الممنوحة لك وتغيير وسامك الحالي بواحد آخر'
		),
		array(
			'status'=>true,
			'url'=>'profile.php?type=hiddentopics',
			'iconname'=>'hidetopics',
			'subject'=>'المواضيع المخفية المفتوحة لك',
			'disc'=>'لمشاهدة مواضيع المخفية عن الآخرين ومفتوحة لك'
		),
		array(
			'status'=>true,
			'url'=>'editor.php?type=signature&src='.urlencode(self),
			'iconname'=>'editsignature',
			'subject'=>'توقيعك الذي يظهر اسفل مشاركاتك',
			'disc'=>'لتغيير توقيعك الشخصي الذي يظهر في أسفل جميع مشاركاتك'
		),
		array(
			'status'=>true,
			'url'=>'profile.php?type=changename',
			'iconname'=>'changename',
			'subject'=>'طلب تغيير اسم العضوية',
			'disc'=>'لتقديم طلب تغيير اسم العضوية الخاصة بك الى اسم آخر'
		),
		array(
			'status'=>(ulv > 1),
			'url'=>'profile.php?type=loginbar',
			'iconname'=>'loginbar',
			'subject'=>'تفاصيل الاتصال لعضويتك',
			'disc'=>'لمعرفة جميع معلومات عن إتصال او دخول لعضويتك'
		),
		array(
			'status'=>(ulv > 1),
			'url'=>'profile.php?type=trylogin',
			'iconname'=>'trylogin',
			'subject'=>'محاولات الدخول لعضويتك',
			'disc'=>'لمعرفة تفاصيل جميع محاولات الدخول لعضويتك'
		),
		array(
			'status'	=> true,
			'url'		=> 'profile.php?type=loginsessions',
			'iconname'	=> 'loginsessions',
			'subject'	=> 'جلسات دخول لعضويتك <span class="asC4 asS12">(جديد)</span>',
			'disc'		=> 'لمعرفة جميع جلسات دخول لعضويتك'
		)
	);
	echo"<br>
	<table width=\"30%\" cellSpacing=\"0\" cellPadding=\"0\" align=\"center\">
		<tr>
			<td class=\"asHeader\">خيارات وبيانات عضويتك</td>
		</tr>
		<tr>
			<td class=\"asNormal\">
			<table width=\100%\" cellSpacing=\"5\" cellPadding=\"0\">
				<tr>";
		$count=0;
		for($x=0;$x<count($options);$x++){
			if($options[$x]['status']){
				echo"
				<td valign=\"top\">
				<table cellSpacing=\"2\" cellPadding=\"2\" align=\"center\" border=\"0\">
					<tr>
						<td class=\"asCenter\"><a href=\"{$options[$x]['url']}\"><img src=\"{$DFImage->h[$options[$x]['iconname']]}\" hspace=\"4\" border=\"0\"></a></td>
					</tr>
					<tr>
						<td class=\"asCenter asC5 asS12\"><a href=\"{$options[$x]['url']}\"><nobr>{$options[$x]['subject']}</nobr></a><br>{$options[$x]['disc']}</td>
					</tr>
				</table>
				</td>";
				$count++;
				if($count == 4){
					echo"
					</tr><tr>";
					$count=0;
				}
			}
		}
				echo"
				</tr>
			</table>
			</td>
		</tr>
	</table><br>";
}
elseif(type == 'editpicture' && ulv > 0){

	$pic_999 = $DFPhotos->getsrc(upicture, 999);
	$pic_100 = $DFPhotos->getsrc(upicture, 200);

	$allow_size = intval($DF->config['photos']['user_profile']['allow_size']);
	if( $allow_size == 0 ) $allow_size = 1;

	?>
	<link rel="stylesheet" type="text/css" href="build/resize/assets/skins/sam/resize.css" />
	<link rel="stylesheet" type="text/css" href="build/imagecropper/assets/skins/sam/imagecropper.css" />
	<script type="text/javascript" src="build/dragdrop/dragdrop-min.js"></script>
	<script type="text/javascript" src="build/resize/resize-min.js"></script>
	<script type="text/javascript" src="build/imagecropper/imagecropper-min.js"></script>
	<style type="text/css" media="screen">
    #previewPicture100 {
        border:1px solid black;
        height:100px;
        width:100px;
        position:relative;
        overflow:hidden;
		zoom:1;
    }
    #previewPicture100 img {
        position:absolute;
        top:0;
        left:0;
    }
	</style>
	<script type="text/javascript">
	DF.mainPicLoad = function(){
		if(DF.pictureCrop){
			DF.pictureCrop.destroy();
		}
		YAHOO.util.Event.onDOMReady(function(){
			var pic = $('#mainPictureEditable'), width = $(pic).width(), height = $(pic).height(),
			setPosition = function(){
				var preview = $('#previewPicture100 > img'), coords = DF.pictureCrop.getCropCoords(),
				newWidth = Math.ceil(width / coords.width * 100),
				newHeight = Math.ceil(height / coords.height * 100),
				newLeft = Math.ceil(newWidth / width * coords.left),
				newTop = Math.ceil(newHeight / height * coords.top);
				preview.css({
					'width' : newWidth+'px',
					'height' : newHeight+'px',
					'left' : '-'+newLeft+'px',
					'top' : '-'+newTop+'px'
				});
			};
			DF.pictureCrop = new YAHOO.widget.ImageCropper('mainPictureEditable', {
				initialXY: [1,1],
				minHeight: 50,
				minWidth: 50
			});
			setPosition();
			DF.pictureCrop.on('moveEvent', setPosition);
		});
	};
	$(function(){
		$('#up_pic_button').click(function(){
			$('#up_inp_button').click();
		});
		$('#up_inp_button').change(function(){
			var place = $('#up_messges_place'), ext = this.files[0].name.split('.').pop().toLowerCase(), file;
			if( !this.files || !this.files[0] ){
				place.html('<span style="color:red;">أنت لم حددت أي صورة من جهازك</span>');
			}
			else if( $.inArray( ext, ['jpg', 'jpeg', 'png', 'gif'] ) < 0 ){
				place.html('<span style="color:red;">أنت لم حددت أي صورة من جهازط:- GIF او JPG او PNG</span>');
			}
			else{
				file = new FileReader();
				file.onload = function(e){
					var src = e.target.result;
					$('#currentPicture100').attr('src', src);
					$('#hdPic32').attr('src', src);
					$('#mainPictureEditable').attr('src', src);
					$('#previewPicture100 > img').attr('src', src);
				}
				file.readAsDataURL( this.files[0] );
			}
		});
		$('#savePictureButton').click(function(){
			var coords = DF.pictureCrop.getCropCoords();
			$('#preview_messges_place').html('<img src="images/icons/loading3.gif" border="0">');
			$('input[name=coords]').val( coords.width+','+coords.height+','+coords.left+','+coords.top );
			$('#uploadPictureForm').submit();
		});
		$('#uploadPictureFrame').load(function(){
			var json = $(this.contentWindow.document.body).html(), errorText = '',
			place = $('#up_messges_place');

			json = $.parseJSON(json);
			
			if( $.type(json) !== 'object' || !json.status ){
				errorText = 'خطأ غير مفهوم, ارجوا ان تقوم بإعادة محاولة من جديد';
			}
			else if( json.status == 'file' || json.status == 'invalid_source' ){
				errorText = 'توجد خطا في ملف الذي اخترته، حاول مرة اخرى';
			}
			else if( json.status == 'not_allowed_type' ){
				errorText = 'يجب عليك ان تختار ملف بامتدادات التالية فقط:- GIF او JPG او PNG';
			}
			else if( json.status == 'not_allowed_size' ){
				errorText = 'حجم ملف الذي اخترت اكبر من حجم المسموح وهو: <?=floatval( round( $allow_size / 1024 / 1024 ) )?>MB';
			}
			else if( json.status == 'success' ){}
			else{
				errorText = 'خطأ غير مفهوم, ارجوا ان تقوم بإعادة محاولة من جديد';
			}

			if( errorText != '' ){
				place.html('<span style="color:red;">'+errorText+'</span>');
			}
			else{
				place.html('<span style="color:green;">تم رفع الملف بنجاح.</span>');
				$('#preview_messges_place').html('');
				setTimeout("$('#up_messges_place').html('');", 3000);
				$('#currentPicture100').attr('src', json.src);
				$('#hdPic32').attr('src', json.src);
				$('#mainPictureEditable').attr('src', json.src);
				$('#previewPicture100 > img').attr('src', json.src);
			}
		});
	});
	</script>
	<?php
	echo"
	<table width=\"950\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<iframe id=\"uploadPictureFrame\" name=\"uploadPictureFrame\" style=\"display:none;width:600px;height:200px;background-color:white;\"></iframe>
		<tr>
			<td class=\"asHeader\" colspan=\"2\">صورة الشخصية</td>
		</tr>
		<tr>
			<td class=\"asDarkB\">صورة الحالية</td>
			<td class=\"asDarkB\">رفع صورة من جهازك</td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter asP10\" width=\"120\"><img id=\"currentPicture100\" src=\"{$pic_100}\"{$DF->picError()} style=\"width:100px;height:100px;border:gray 1px solid\" border=\"0\"></td>
			<td class=\"asNormalB asCenter\" width=\"95%\">
				<form id=\"uploadPictureForm\" method=\"post\" action=\"ajax.php?type=doUploadPicture&x=".rand."\" target=\"uploadPictureFrame\" enctype=\"multipart/form-data\">
					<input type=\"hidden\" name=\"coords\">
					<div style=\"position:relative;padding:2px 2px 20px;width:800px;\">";
					$Browser = $DF->browse('type');
					if( $Browser == 'msie' ){
						echo "<input id=\"up_inp_button\" type=\"file\" name=\"picfile\" style=\"width:400px;margin:12px;\">";
					}
					else{
						echo"
						<img id=\"up_pic_button\" style=\"cursor:pointer;\" src=\"images/icons/upload.png\" border=\"0\">
						<div style=\"height:0;width:0;overflow:hidden;\"><input id=\"up_inp_button\" type=\"file\" name=\"picfile\"></div>";
					}
						echo"
						<div id=\"up_messges_place\" style=\"position:absolute;left:1px;top:60px;width:800px;text-align:center;\"></div>
					</div>
				</form>
			</td>
		</tr>
		<tr>
			<td class=\"asDarkB\">معاينة</td>
			<td class=\"asDarkB\">صورة بحجمها الحقيقي</td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter asS12 asP10\">
				<div id=\"previewPicture100\"><img src=\"{$pic_999}\" style=\"width:100px;height:100px\" border=\"0\"></div><br>
				{$Template->button("حفظ صورة"," id=\"savePictureButton\"")}<br><br>
				<div id=\"preview_messges_place\" style=\"height:100px;\"></div>
			</td>
			<td class=\"asNormalB asS12 asP10\" align=\"center\" dir=\"ltr\"><img id=\"mainPictureEditable\" src=\"{$pic_999}\" onload=\"DF.mainPicLoad();\" border=\"0\"></td>
		</tr>
		<tr>
			<td class=\"asBody asP0\" colspan=\"2\">
			<table cellSpacing=\"2\">
				<tr>
					<td class=\"asTitle\">ملاحظة</td>
					<td class=\"asText2\">اذا تغييرت صورتك الشخصية, سيتم حذف صورة القديمة بشكل تلقائي.</td>
					<td class=\"asTitle\">نوع الصور المتاحة</td>
					<td class=\"asText2\" dir=\"ltr\">GIF, JPG, PNG</td>
					<td class=\"asTitle\">حجم المسموح</td>
					<td class=\"asText2\" dir=\"ltr\">3 MB</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>";
}
elseif(type == 'editpass'&&ulv > 0){
	$rs=$mysql->queryRow("SELECT uf.email,u.password,u.code,u.entername
	FROM ".prefix."user AS u
	LEFT JOIN ".prefix."userflag AS uf ON(u.id = uf.id)
	WHERE u.id = ".uid."", __FILE__, __LINE__);
	?>
	<script type="text/javascript" src="js/md5.js"></script>
	<script type="text/javascript">
	var yourPass="<?=$rs[1]?>";
	var yourCode="<?=$rs[2]?>";
	DF.chkSubmitPass=function(frm){
		if(frm.proEmail.value.length == 0){
			alert("يجب عليك ان تكتب عنوان بريد الالكتروني");
		}
		else if(!this.checkEmail(frm.proEmail.value)){
			alert("عنوان بريد الالكتروني الذي دخلت هو خاطيء");
		}
		<?php if(ulv == 4){ ?>
		else if(frm.proEnterName.value.length == 0){
			alert("يجب عليك ان تكتب اسم دخولك في منتديات");
		}
		else if(frm.proEnterName.value.length<3){
			alert("لا يمكنك بكتابة اسم اقل من ثلاثة حروف");
		}
		else if(frm.proEnterName.value.length>30){
			alert("لا يمكنك بكتابة اسم اكبر من 30 حروف");
		}
		<?php } ?>
		else if(frm.proOldPass.value.length>0){
			var oldPass=hexMD5(yourCode+frm.proOldPass.value);
			if(oldPass!=yourPass){
				alert("كلمة السرية الذي دخلت غير مطابق لكلمة السرية الاصلية لك");
			}
			else if(frm.proNewPass1.value.length == 0){
				alert("يجب عليك ان تكتب كلمة السرية الجديدة");
			}
			else if(frm.proNewPass1.value.length<6){
				alert("لا يمكنك كتابة كلمة السرية اقل من 6 حروف");
			}
			else if(frm.proNewPass1.value.length>24){
				alert("لا يمكنك كتابة كلمة السرية اكثر من 24 حرف");
			}
			else if(frm.proNewPass2.value.length == 0){
				alert("يجب عليك ان تكتب تأكيد كلمة السرية");
			}
			else if(frm.proNewPass1.value!=frm.proNewPass2.value){
				alert("كلمة السرية للتأكد غير مطابق لكلمة السرية الجديدة");
			}
			else{
				frm.submit();
			}
		}
		else{
			frm.submit();
		}
	};
	</script>
	<?php
	echo"
	<table width=\"50%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form method=\"post\" action=\"profile.php?type=updatepass\">
		<tr>
			<td class=\"asHeader\" colspan=\"2\">بيانات دخول العضوية</td>
		</tr>
		<tr>
			<td class=\"asDarkB\" colspan=\"2\">الرجاء منك تحديث بياناتك من وقت لآخر</td>
		</tr>";
	if(ulv == 4){
		echo"
		<tr>
			<td class=\"asFixedB\" id=\"cellProEnterName\"><nobr>اسم دخولك الى المنتديات</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" class=\"input\" style=\"width:450px\" name=\"proEnterName\" value=\"{$rs[3]}\"></td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asFixedB\" id=\"cellProEmail\"><nobr>البريد الالكتروني</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" class=\"input\" style=\"width:450px\" name=\"proEmail\" value=\"{$rs[0]}\" dir=\"ltr\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\" id=\"cellProOldPass\"><nobr>الكلمة السرية الحالية</nobr></td>
			<td class=\"asNormalB\"><input type=\"password\" class=\"input\" style=\"width:450px\" name=\"proOldPass\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\" id=\"cellProNewPass1\"><nobr>الكلمة السرية الجديدة</nobr></td>
			<td class=\"asNormalB\"><input type=\"password\" class=\"input\" style=\"width:450px\" name=\"proNewPass1\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\" id=\"cellProNewPass2\"><nobr>تأكيدالكلمة السرية</nobr></td>
			<td class=\"asNormalB\"><input type=\"password\" class=\"input\" style=\"width:450px\" name=\"proNewPass2\"></td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"2\">{$Template->button("حفظ التغيرات"," onClick=\"DF.chkSubmitPass(this.form);\"")}</td>
		</tr>
	</form>
	</table>";
}
elseif(type == 'updatepass'&&ulv > 0){
	$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في تعديل كلمة مرور والبريد الالكتروني");
	$setSql=array();
	$proEmail=$DF->cleanText($_POST['proEmail']);
	$proEnterName=$DF->cleanText($_POST['proEnterName']);
	$proOldPass=$DF->cleanText($_POST['proOldPass']);
	$proNewPass1=$DF->cleanText($_POST['proNewPass1']);
	$proNewPass2=$DF->cleanText($_POST['proNewPass2']);
	$errMsg="";
	if(empty($proEmail)){
		$errMsg="يجب عليك ان تكتب عنوان بريد الالكتروني";
	}
	elseif(!preg_match("/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/",$proEmail)){
		$errMsg="عنوان بريد الالكتروني الذي دخلت هو خاطيء";
	}
	elseif(ulv == 4&&empty($proEnterName)){
		$errMsg="يجب عليك ان تكتب اسم دخولك في منتديات";
	}
	elseif(ulv == 4&&strlen($proEnterName)<3){
		$errMsg="لا يمكنك بكتابة اسم اقل من ثلاثة حروف";
	}
	elseif(ulv == 4&&strlen($proEnterName)>30){
		$errMsg="لا يمكنك بكتابة اسم اكبر من 30 حروف";
	}
	elseif(!empty($proOldPass)){
		$rs=$mysql->queryRow("SELECT password,code FROM ".prefix."user WHERE id = ".uid."", __FILE__, __LINE__);
		$userPass=$rs[0];
		$hashPass=md5("{$rs[1]}{$proOldPass}");
		if($userPass!=$hashPass){
			$errMsg="كلمة السرية الذي دخلت غير مطابق لكلمة السرية الاصلية لك";
		}
		elseif(empty($proNewPass1)){
			$errMsg="يجب عليك ان تكتب كلمة السرية الجديدة";
		}
		elseif(strlen($proNewPass1)<6){
			$errMsg="لا يمكنك كتابة كلمة السرية اقل من 6 حروف";
		}
		elseif(strlen($proNewPass1)>24){
			$errMsg="لا يمكنك كتابة كلمة السرية اكثر من 24 حرف";
		}
		elseif(empty($proNewPass2)){
			$errMsg="يجب عليك ان تكتب تأكيد كلمة السرية";
		}
		elseif($proNewPass1!=$proNewPass2){
			$errMsg="كلمة السرية للتأكد غير مطابق لكلمة السرية الجديدة";
		}
	}
	if(!empty($errMsg)){
		$Template->errMsg($errMsg);
	}
	else{
		if(!empty($proOldPass)){
			$newPass=md5("{$rs[1]}{$proNewPass1}");
			$setSql[]="password = '{$newPass}'";
		}
		if(ulv == 4) $setSql[]="entername = '{$proEnterName}'";
		if(count($setSql)>0) $mysql->update("user SET ".implode(",",$setSql)." WHERE id = ".uid."", __FILE__, __LINE__);
		$mysql->update("userflag SET email = '{$proEmail}' WHERE id = ".uid."", __FILE__, __LINE__);
		$Template->msg("تم حفظ التغيرات بنجاح");	
	}
}
elseif(type == 'editdetails'&&ulv > 0){
	$rs=$mysql->queryAssoc("SELECT uf.city,uf.state,uf.country,uf.occupation,uf.marstatus,uf.brithday,uf.sex,
		up.receivepm,up.hidebrowse,uf.title,uf.biography,up.allowfriendship,up.showbirthday,up.showfriends
	FROM ".prefix."userflag AS uf
	LEFT JOIN ".prefix."userperm AS up ON(uf.id = up.id)
	WHERE uf.id = ".uid."", __FILE__, __LINE__);
	?>
	<script type="text/javascript">
	DF.chkSubmitDetails=function(frm){
		frm.submit();
	};
	</script>
	<?php
	echo"
	<table width=\"65%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form method=\"post\" action=\"profile.php?type=updatedetails\">
		<tr>
			<td class=\"asHeader\" colspan=\"4\">بيانات العضوية والشخصية</td>
		</tr>
		<tr>
			<td class=\"asDarkB\" colspan=\"4\">الرجاء منك تحديث بياناتك من وقت لآخر</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>الدولة</nobr></td>
			<td class=\"asNormalB\">";
			$defCountry=strtolower($rs['country']);
			$cites=array();
			$countries=array();
			require_once _df_path."countries.php";
			foreach($country as $code=>$val){
				$countries["{$code}"]=$val['name'];
				if($defCountry == $code) $cites=$val['city'];
			}
			$Template->selectMenu(array(
				'name'=>'proCountry',
				'options'=>$countries,
				'default'=>$defCountry,
				'width'=>'200'
			));
			$brithday=explode("-",$rs['brithday']);
			echo"
			</td>
			<td class=\"asFixedB\"><nobr>رسائل خاصة</nobr></td>
			<td class=\"asNormalB\">";
			$receivePM=array(0=>'لا يسمح للأعضاء أن يرسلوا رسائل خاصة',1=>'يسمح بالأعضاء أن يرسلوا رسائل خاصة');
			$Template->selectMenu(array(
				'name'=>'proReceivePM',
				'options'=>$receivePM,
				'default'=>$rs['receivepm'],
				'width'=>'250'
			));
			echo"
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>المدينة</nobr></td>
			<td class=\"asNormalB\">";
			$Template->selectMenu(array(
				'name'=>'proCity',
				'options'=>$cites,
				'default'=>$rs['city'],
				'width'=>'200',
				'input'=>true,
				'single'=>true
			));
			echo"
			</td>
			<td class=\"asFixedB\"><nobr>تصفحك في المنتديات</nobr></td>
			<td class=\"asNormalB\">";
			$hideBrowse=array(0=>'تصفحك يظهر للأعضاء',1=>'تصفحك مخفي عن الأعضاء');
			$Template->selectMenu(array(
				'name'=>'proHideBrowse',
				'options'=>$hideBrowse,
				'default'=>$rs['hidebrowse'],
				'width'=>'250'
			));
			echo"
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>المنطقة</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" class=\"input\" style=\"width:194px\" name=\"proState\" value=\"{$rs['state']}\"></td>
			<td class=\"asFixedB\"><nobr>طلبات الصداقة</nobr></td>
			<td class=\"asNormalB\">";
			$allowFriendship=array(0=>'عدم إستقبال طلبات الصداقة',1=>'إستقبال طلبات الصداقة');
			$Template->selectMenu(array(
				'name'=>'proAllowFriendShip',
				'options'=>$allowFriendship,
				'default'=>$rs['allowfriendship'],
				'width'=>'250'
			));
			echo"
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>تاريخ الولادة</nobr></td>
			<td class=\"asNormalB\">
			<table cellpadding=\"0\" cellspacing=\"0\">
				<tr>
					<td class=\"asHP2\">";
					$days=array();
					for($x=1;$x<=31;$x++){
						$days[]=$x;
					}
					$Template->selectMenu(array(
						'name'=>'proBirthdayDay',
						'options'=>$days,
						'default'=>$brithday[2],
						'single'=>true,
						'width'=>'50'
					));
					echo"
					</td>
					<td class=\"asHP2\">";
					$months=array();
					for($x=1;$x<=12;$x++){
						$months[]=$x;
					}
					$Template->selectMenu(array(
						'name'=>'proBirthdayMonth',
						'options'=>$months,
						'default'=>$brithday[1],
						'single'=>true,
						'width'=>'50'
					));
					echo"
					</td>
					<td class=\"asHP2\">";
					$curY=(int)date("Y",time);
					$firstY=$curY-100;
					$lastY=$curY-12;
					$years=array();
					for($x=$firstY;$x<=$lastY;$x++){
						$years[]=$x;
					}
					$Template->selectMenu(array(
						'name'=>'proBirthdayYear',
						'options'=>$years,
						'default'=>$brithday[0],
						'single'=>true,
						'width'=>'90'
					));
					echo"
					</td>
				</tr>
			</table>
			</td>
			<td class=\"asFixedB\"><nobr>إظهاء قائمة أصدقاء</nobr></td>
			<td class=\"asNormalB\">";
			$showFriends=array(1=>'يظهر للجميع',2=>'فقط يظهر للأصدقاء',3=>'عدم إظهار لأي شخص');
			$Template->selectMenu(array(
				'name'=>'proShowFriends',
				'options'=>$showFriends,
				'default'=>$rs['showfriends'],
				'width'=>'250'
			));
			echo"
			</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>عرض تاريخ الولادة</nobr></td>
			<td class=\"asNormalB\">";
			$showBirthday=array(0=>'عدم إظهار',1=>'يظهر يوم وشهر فقط',2=>'يظهر تاريخ كامل');
			$Template->selectMenu(array(
				'name'=>'proShowBirthday',
				'options'=>$showBirthday,
				'default'=>$rs['showbirthday'],
				'width'=>'200'
			));
			echo"
			</td>
			<td class=\"asFixedB\"><nobr>الحالة الإجتماعية</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" class=\"input\" style=\"width:350px\" name=\"proMarstatus\" value=\"{$rs['marstatus']}\"></td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>الجنس</nobr></td>
			<td class=\"asNormalB\">";
			$sexes=array(1=>'ذكر',2=>'أنثى');
			$Template->selectMenu(array(
				'name'=>'proSex',
				'options'=>$sexes,
				'default'=>$rs['sex'],
				'width'=>'200'
			));
			echo"
			</td>
			<td class=\"asFixedB\"><nobr>المهنة</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" class=\"input\" style=\"width:350px\" name=\"proOccupation\" value=\"{$rs['occupation']}\"></td>
		</tr>";
	if(ulv > 1){
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>وصفك</nobr></td>
			<td class=\"asNormalB\" colspan=\"3\"><input type=\"text\" class=\"input\" style=\"width:99%\" name=\"proTitle\" value=\"{$rs['title']}\"></td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asFixedB\"><nobr>سيرتك الذاتية</nobr></td>
			<td class=\"asNormalB\" colspan=\"3\"><textarea style=\"width:99%;height:100px\" name=\"proBiography\">{$rs['biography']}</textarea></td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"4\">{$Template->button("حفظ التغيرات"," onClick=\"DF.chkSubmitDetails(this.form);\"")}</td>
		</tr>
	</form>
	</table>";
}
elseif( type == 'updatedetails' && ulv > 0 ){
	$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في تعديل خيارات العضوية");
	$proCountry=$DF->cleanText($_POST['proCountry']);
	$proReceivePM=(int)$_POST['proReceivePM'];
	$proCity=$DF->cleanText($_POST['proCity']);
	$proHideBrowse=(int)$_POST['proHideBrowse'];
	$proState=$DF->cleanText($_POST['proState']);
	$proAllowFriendShip=(int)$_POST['proAllowFriendShip'];
	$proBirthdayDay=(int)$_POST['proBirthdayDay'];
	$proBirthdayMonth=(int)$_POST['proBirthdayMonth'];
	$proBirthdayYear=(int)$_POST['proBirthdayYear'];
	$proBirthday = $DF->change_date("{$proBirthdayYear}-{$proBirthdayMonth}-{$proBirthdayDay}", "Y-m-d", "Y-m-d");
	$proShowFriends=(int)$_POST['proShowFriends'];
	$proShowBirthday=(int)$_POST['proShowBirthday'];
	$proMarstatus=$DF->cleanText($_POST['proMarstatus']);
	$proSex=(int)$_POST['proSex'];
	$proOccupation=$DF->cleanText($_POST['proOccupation']);
	$proTitle=$DF->cleanText($_POST['proTitle']);
	$proBiography=$DF->cleanText($_POST['proBiography']);
	$ufArr=array();
	$ufArr[]="country = '{$proCountry}'";
	$ufArr[]="city = '{$proCity}'";
	$ufArr[]="state = '{$proState}'";
	if( $DF->is_date( $proBirthday, 'Y-m-d' ) ) $ufArr[]="brithday = '{$proBirthday}'";
	$ufArr[]="marstatus = '{$proMarstatus}'";
	$ufArr[]="sex = {$proSex}";
	$ufArr[]="occupation = '{$proOccupation}'";
	if( ulv > 1 ) $ufArr[]="title = '{$proTitle}'";
	$ufArr[]="biography = '{$proBiography}'";
	$mysql->update("userflag SET ".implode( ", ", $ufArr )." WHERE id = ".uid."", __FILE__, __LINE__);
	$upArr=array();
	$upArr[]="receivepm = {$proReceivePM}";
	$upArr[]="hidebrowse = {$proHideBrowse}";
	$upArr[]="allowfriendship = {$proAllowFriendShip}";
	$upArr[]="showfriends = {$proShowFriends}";
	$upArr[]="showbirthday = {$proShowBirthday}";
	$mysql->update("userperm SET ".implode(",",$upArr)." WHERE id = ".uid."", __FILE__, __LINE__);
	$Template->msg("تم حفظ التغيرات بنجاح");
}
elseif(type == 'changename'&&ulv > 0){
	$rs=$mysql->queryAssoc("SELECT u.name,up.changename,COUNT(ch.id) AS chCount,ch.status,ch.date
	FROM ".prefix."user AS u
	LEFT JOIN ".prefix."userperm AS up ON(u.id = up.id)
	LEFT JOIN ".prefix."changename AS ch ON(u.id = ch.userid AND ch.status = 1)
	WHERE u.id = '".uid."' GROUP BY u.id ORDER BY ch.date DESC LIMIT 1", __FILE__, __LINE__);
	
	if($rs['changename'] == 0){
		$Template->errMsg("تم منعك من تغير اسم العضوية بواسطة الإدارة");
	}
	
	$unApproved=$DFOutput->count("changename WHERE userid = '".uid."' AND status = 0");
	$countChangeName=(int)$rs['chCount'];
	$maxChangeName=$DFOutput->getCnf('max_change_name');
	$maxDaysChangeName=$DFOutput->getCnf('max_days_change_name');
	$daysWait=($rs['date']+$DF->timezone)+(86400*$maxDaysChangeName);
	$daysWait=($daysWait-time)+$DF->checkZiroPointDate;
	$daysWait=date("بقى d يوم/أيام و H ساعة/ساعات و i دقيقة/دقائق لتغير اسم عضويتك من جديد",$daysWait);
	?>
	<link rel="stylesheet" type="text/css" href="build/datatable/assets/skins/sam/datatable.css">
	<link rel="stylesheet" type="text/css" href="build/container/assets/skins/sam/container.css">
	<script type="text/javascript" src="build/datasource/datasource-min.js"></script>
	<script type="text/javascript" src="build/datatable/datatable-min.js"></script>
	<script type="text/javascript" src="build/container/container-min.js"></script>
	<script type="text/javascript" src="build/dragdrop/dragdrop-min.js"></script>
	<script type="text/javascript">
	var nowUserName="<?=$rs['name']?>";
	var allowChangeName=<?=(int)$rs['changename']?>;
	var maxChangeName=<?=(int)$maxChangeName?>;
	var countChangeName=<?=$countChangeName?>;
	var nowDate=<?=time?>;
	var lastChanged=<?=(int)($rs['date']+(86400*$maxDaysChangeName))?>;
	var unApproved=<?=$unApproved?>;
	DF.getMsg=function(text){
		$I('#msgContent').innerHTML=text;
		alertMsg.show();
	};
	var handleOK=function(){
		this.cancel();
	};
	var alertMsg=new YAHOO.widget.SimpleDialog("panel1",{
		modal:true,
		icon:YAHOO.widget.SimpleDialog.ICON_INFO,
		visible:false,
		fixedcenter:true,
		constraintoviewport:true,
		width:"350px",
		role:"alertdialog",
		text:"<div id=\"msgContent\" style=\"color:red\"></div>"
	});
	alertMsg.setHeader("&nbsp;");
	alertMsg.render(document.body);

	DF.chkSubmitChangeName=function(frm){
		if(countChangeName>=maxChangeName){
			this.getMsg("لا يمكنك التغيير اسم عضويتك<br>لأن انتهت عدد مرات التغيير اسم عضويتك الذي يبلغ "+maxChangeName+" مرات");
		}
		else if(countChangeName>0&&lastChanged>nowDate){
			this.getMsg("لا يمكنك التغيير اسم عضويتك<br>لأن لازم يمضي <?=$maxDaysChangeName?> يوم بتاريخ آخر تغيير اسم عضويتك<br><?=$daysWait?>");
		}
		else if(unApproved>0){
			this.getMsg("لا يمكنك التغيير اسم عضويتك<br>لأن آخر طلب تغيير اسم عضويتك مازال تحت الانتظار القبول من طرف الادارة");
		}
		else if(frm.proName.value.length == 0){
			this.getMsg("يجب عليك أن تكتب اسم العضوية.");
		}
		else if(frm.proName.value.length<3){
			this.getMsg("يجب أن يكون الإسم مكون من 3 أحرف على الأقل.");
		}
		else if(frm.proName.value.length>30){
			this.getMsg("يجب أن يكون الإسم لا أكثر من 30 حرفاً.");
		}
		else if(frm.proName.value == parseInt(frm.proName.value)){
			this.getMsg("لا يمكن استخدام اسماء تحتوي على أرقام فقط.");
		}
		else if(this.checkSymbols(frm.proName.value)!=1){
			this.getMsg("لا يمكن استخدام هذا الرمز "+this.checkSymbols(frm.proName.value)+" في اسم العضوية.");
		}
		else if(frm.proName.value == nowUserName){
			this.getMsg("اسم الذي اخترت هو نفس الأسم الحالي لك<br>مرجو أن تختار اسم آخر.");
		}
		else{
			frm.submit();
		}
	};
	</script>
	<?php
	echo"
	<table width=\"60%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
	<form method=\"post\" action=\"profile.php?type=insertchangename&u=".uid."\">
	<input type=\"hidden\" name=\"proOldName\" value=\"{$rs['name']}\">
		<tr>
			<td class=\"asHeader\" colspan=\"2\">طلب تغيير إسم العضوية</td>
		</tr>
		<tr>
			<td class=\"asFixedB\"><nobr>اسم العضوية</nobr></td>
			<td class=\"asNormalB\"><input type=\"text\" style=\"width:400px\" name=\"proName\"></td>
		</tr>
		<tr>
			<td class=\"asNormalB asS12 asC5\">
				<nobr>
				* يجب ان يكون الاسم على الأقل مكون من 3 أحرف<br>
				* لا يسمح استخدام الرموز غير الأحرف والأرقام<br>
				* لا يسمح استخدام رمز التمديد ــــ<br>
				* يجب الا يكون الاسم مشابه جدا لاسم عضو حالي<br>
				* لا يسمح بالاسماء التي كلها ارقام
				</nobr>
			</td>
			<td class=\"asNormalB asS12 asC5\">
				<nobr>
				* لا يسمح بتكرار حرف عدة مرات<br>
				* لا يسمح بوضع الايميل كجزء من الاسم<br>
				* لا يسمح باستخدام اسم الموقع او جزء منه في الاسم<br>
				* لا يسمح باستخدام اسم يوحي بالاشراف او الادارة<br>
				* لا يسمح باستخدام اسم غير لائق بالآداب العامة<br>
				</nobr>
			</td>
		</tr>
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"2\">{$Template->button("إرسال"," onClick=\"DF.chkSubmitChangeName(this.form)\"")}</td>
		</tr>
	</form>
	</table><br><br><div id=\"changeNameStats\" align=\"center\"></div>";
	$sql=$mysql->query("SELECT * FROM ".prefix."changename WHERE userid = '".uid."' ORDER BY date ASC", __FILE__, __LINE__);
	$reqCount=0;
	while($rs=$mysql->fetchAssoc($sql)){
		if($rs['status'] == 1){
			$reqCount++;
			$number=$reqCount;
		}
		else{
			$number='-';
		}
		if($rs['status'] == 0){
			$status="<font color=\"#ff9900\">تتنظر الموافقة</font>";
		}
		elseif($rs['status'] == 1){
			$status="<font color=\"#009933\">تمت موافقة عليها</font>";
		}
		elseif($rs['status'] == 2){
			$status="<font color=\"#ff3300\">تم رفض الطلب</font>";
		}
		elseif($rs['status'] == 3){
			$status="تم إلغاء الطلب";
		}
		$options=($rs['status'] == 0?"<a href=\"profile.php?type=deletereqchangename&id={$rs['id']}\"><img src=\"{$DFImage->i['delete']}\" alt=\"انقر هنا لإلغاء هذا الطلب\" border=\"0\"></a>":"-");
		$jsContent.="{number:\"$number\",newname:\"{$rs['newname']}\",oldname:\"{$rs['oldname']}\",status:\"".addslashes($status)."\",date:\"".addslashes($DF->date($rs['date']))."\",options:\"".addslashes($options)."\"},\n\t\t";
	}
?>
<script type="text/javascript">
YAHOO.util.Event.addListener(window,"load",function(){
	var changeNameRows=new Array(
		<?=$jsContent?>""
	);
	changeNameRows.pop();
	var checkCells=function(elCell,oRecord,oColumn,sData){
		YAHOO.util.Dom.setStyle(elCell,"text-align","center");
		elCell.innerHTML=sData;
	};
	var changeNameHeaders=[
		{key:"number",label:"<nobr><b>سجل طلبات تغيير اسم عضويتك</b></nobr>",
			children:[
				{key:"number",label:"&nbsp;",formatter:checkCells,sortable:true},
				{key:"newname",label:"اسم الجديد",sortable:true},
				{key:"oldname",label:"اسم القديم",sortable:true},
				{key:"status",label:"الوضعية",formatter:checkCells,sortable:true},
				{key:"date",label:"تاريخ",formatter:checkCells,sortable:true},
				{key:"options",label:"خيارات",formatter:checkCells}
			]
		}
	];
	var changeNameSource=new YAHOO.util.DataSource(changeNameRows);
	changeNameSource.responseType=YAHOO.util.DataSource.TYPE_JSARRAY;
	changeNameSource.responseSchema={
		fields:[
			{key:"number"},
			{key:"newname"},
			{key:"oldname"},
			{key:"status"},
			{key:"date"},
			{key:"options"}
		]
	};
	var changeNameDataTable=new YAHOO.widget.DataTable("changeNameStats",changeNameHeaders,changeNameSource,{MSG_EMPTY:'<center><br>لا توجد أي طلبية تغير اسم العضوية<br><br></center>'});
});


</script>
<?php
	echo"
	<br><br>
	<div class=\"asCenter asC1\">عدد مرات تغيير اسم عضويتك حتى الآن: <span class=\"asC2\">$countChangeName</span><br>
	عدد مرات المسموح لك بتغيير اسم عضويتك: <span class=\"asC2\">$maxChangeName</span></div><br><br>";
}
elseif(type == 'deletereqchangename'){
	$sql=$mysql->query("SELECT status,userid FROM ".prefix."changename WHERE id = '".id."'", __FILE__, __LINE__);
	$rs=$mysql->fetchRow($sql);
	if($rs[1]!=uid||$rs[0]!=0){
		$DF->goTo();
		exit();
	}
	$mysql->update("changename SET status = 3 WHERE id = '".id."'", __FILE__, __LINE__);
	$Template->msg("تم إلغاء طلب تغير اسم العضوية بنجاح");
}
elseif(type == 'insertchangename'){
	if(ulv == 0||uid!=u){
		$DF->goTo();
		exit();
	}
	if(!$DF->isOurSite()){
		$DFOutput->setHackerDetails("عملية املاء الفورم بطريق غير شرعي في تغير اسم العضوية");
		$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية مرة اخرى سنقوم بإجراءات اللازمة أمامك.");
		exit();
	}
	$proName=trim($_POST['proName']);
	$proOldName=trim($_POST['proOldName']);
	$name=$DF->cleanText($proName);
	
	$findBadName=false;
	$badNames=trim($DFOutput->getCnf('bad_names'));
	$badNames=explode(",",$badNames);
	if(is_array($badNames)){
		if(in_array($name,$badNames)){
			$findBadName=true;
		}
	}
	
	if($name!=$proName||$findBadName){
		$Template->errMsg("اسم الذي اخترت ممنوع من قبل إدارة<br>مرجوا اختيار اسم آخر.");
		exit();
	}
	
	$findName=$DFOutput->count("user WHERE name = '$name'");
	if($findName>0){
		$Template->errMsg("اسم الذي اخترت موجود بلائحة الأعضاء<br>مرجوا اختيار اسم آخر.");
		exit();
	}
	
	$findRequest=$DFOutput->count("changename WHERE userid = '".uid."' AND status = 0");
	if($findRequest>0){
		$Template->errMsg("لا تستطيع إضافة أكثر من طلب لتغير اسم العضوية<br>مرجوا انتظار حتى يتم موافقة او رفض هذا الطلب من قبل إدارة<br>او قم بإلغاء هذا الطلب ثم قم بمحاولة إرسال طلب آخر.");
		exit();
	}
	$mysql->insert("changename (userid,newname,oldname,date) VALUES ('".uid."','$name','$proOldName','".time."')", __FILE__, __LINE__);
	$Template->msg("تم إرسال طلب تغير اسم العضوية بنجاح<br>مرجوا ان تنتظر ليتم الموافقة عليه من قبل الإدارة");
}
elseif(type == 'loginbar'){
	if(ulv < 2){
		$DF->goTo();
		exit();
	}
	$uid = (u > 0 and ulv > 2) ? u : uid;
	$user_name = ($uid == uid) ? "لعضويتك" : "لعضوية {$mysql->get("user", "name", $uid)}";
	$paging = $Template->paging("loginip WHERE userid = '{$uid}'", "profile.php?type=loginbar".(u>0 ? '&u='.u : '')."&");
	@require_once('countries.php');
	echo"
	<center><br>{$paging}
	<table width=\"40%\" cellpadding=\"4\" cellspacing=\"1\">
		<tr>
			<td class=\"asHeader\" colspan=\"3\">سجل اتصال {$user_name}</td>
		</tr>
		<tr>
			<td class=\"asDarkB\">IP</td>
			<td class=\"asDarkB\">الدولة</td>
			<td class=\"asDarkB\"><nobr>تاريخ آخر محاولة</nobr></td>
		</tr>";
	$sql = $mysql->query("SELECT ip, date FROM ".prefix."loginip WHERE userid = {$uid} ORDER BY date DESC LIMIT {$DF->pgLimit(num_pages)},".num_pages, __FILE__, __LINE__);
	$count = 0;
	while($rs = $mysql->fetchAssoc($sql)){
		$ip = long2ip($rs['ip']);
		$hashIP = (ulv == 4 || ulv == 3 && ($uid == uid || $uid < 3)) ? $ip : $DF->hashIP($ip);

		$get_users_by_ip = "";
		if(ulv == 4){
			$get_users_by_ip = "<img src=\"{$DFImage->i['expand']}\" onclick=\"DF.getUsersByIP({$rs['ip']}, {$count}, this, 3);\" style=\"float:right;cursor:pointer;\" alt=\"مطابقة IP\">";
		}

		$details = $DF->getCountryByIP( $ip, 'all' );
		$details_code = isset($details['code']) ? $details['code'] : '';
		$details_name = isset($details['name']) ? $details['name'] : '';
		$code = strtolower($details_code);
		if( isset($country["{$code}"]) ){
			$country_name = $country["{$code}"]['name'];
		}
		else{
			if( $code != '' ){
				$country_name = $details_name;
			}
			else{
				$country_name = "غير معروف";
			}
		}

		echo"
		<tr id=\"getIpRow{$count}\">
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$get_users_by_ip}{$hashIP}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><img src=\"{$DF->getFlagByCode($code)}\" width=\"18\" height=\"12\" hspace=\"3\" border=\"0\"> - {$country_name}</nobr></td>
			<td class=\"asNormalB asDate asS12 asCenter\"><nobr>{$DF->date($rs['date'], '', true, true)}</nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"3\"><br>لا توجد أي اتصال للعضوية<br><br></td>
		</tr>";
	}
	echo"
	</table>{$paging}
	</center><br>";
}
elseif(type == 'trylogin'){
	if(ulv < 2){
		$DF->goTo();
		exit();
	}
	$uid = (u > 0 and ulv > 2) ? u : uid;
	$user_name = ($uid == uid) ? "لعضويتك" : "لعضوية {$mysql->get("user", "name", $uid)}";
	$paging = $Template->paging("trylogin WHERE userid = {$uid}","profile.php?type=trylogin".((u > 0) ? '&u='.u : '')."&");
	@require_once('countries.php');
	echo"
	<center><br>{$paging}
	<table width=\"40%\" cellpadding=\"4\" cellspacing=\"1\">
		<tr>
			<td class=\"asHeader\" colspan=\"4\">سجل محاولات دخول {$user_name}</td>
		</tr>
		<tr>
			<td class=\"asDarkB\"><nobr>عدد محاولات</nobr></td>
			<td class=\"asDarkB\"><nobr>IP</nobr></td>
			<td class=\"asDarkB\">الدولة</td>
			<td class=\"asDarkB\"><nobr>تاريخ آخر محاولة</nobr></td>
		</tr>";
	$sql = $mysql->query("SELECT ip, count, date FROM ".prefix."trylogin WHERE userid = {$uid} ORDER BY date DESC LIMIT {$DF->pgLimit(num_pages)},".num_pages, __FILE__, __LINE__);
	$count = 0;
	while($rs = $mysql->fetchAssoc($sql)){
		$ip = long2ip($rs['ip']);
		$hashIP = (ulv == 4 || ulv == 3 && ($uid == uid || $uid < 3)) ? $ip : $DF->hashIP($ip);

		$get_users_by_ip = "";
		if(ulv == 4){
			$get_users_by_ip = "<img src=\"{$DFImage->i['expand']}\" onclick=\"DF.getUsersByIP({$rs['ip']}, {$count}, this, 4);\" style=\"float:right;cursor:pointer;\" alt=\"مطابقة IP\">";
		}

		$details = $DF->getCountryByIP( $ip, 'all' );
		$details_code = isset($details['code']) ? $details['code'] : '';
		$details_name = isset($details['name']) ? $details['name'] : '';
		$code = strtolower($details_code);
		if( isset($country["{$code}"]) ){
			$country_name = $country["{$code}"]['name'];
		}
		else{
			if( $code != '' ){
				$country_name = $details_name;
			}
			else{
				$country_name = "غير معروف";
			}
		}
		
		echo"
		<tr id=\"getIpRow{$count}\">
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$get_users_by_ip}{$rs[count]}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>{$hashIP}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><img src=\"{$DF->getFlagByCode($code)}\" width=\"18\" height=\"12\" hspace=\"3\" border=\"0\"> - {$country_name}</nobr></td>
			<td class=\"asNormalB asDate asS12 asCenter\"><nobr>{$DF->date($rs['date'], '', true, true)}</nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"4\"><br>لا توجد أي محاولة لدخول عضويتك<br><br></td>
		</tr>";
	}
	echo"
	</table>{$paging}
	</center><br>";
}
elseif(type == 'loginsessions' && ulv > 0){
	@require_once('countries.php');
	
	function browser_details($useragent){
		if(!is_array($useragent)){
			return;
		}
		
		$browsers = array(
			'msie6' => array('Internet Explorer', 'msie6.gif'),
			'msie7' => array('Internet Explorer', 'msie7.png'),
			'msie8' => array('Internet Explorer', 'msie8.png'),
			'msie9' => array('Internet Explorer', 'msie9.png'),
			'chrome' => array('Google Chrome', 'chrome.png'),
			'firefox' => array('Mozilla Firefox', 'firefox.png'),
			'opera' => array('Opera', 'opera.png'),
			'safari' => array('Safari', 'safari.png')
		);
		
		$normal_systems = array(
			'windows7' => array('Window 7', 'win7.gif'),
			'windowsvistaserver2008' => array('Windows Vista', 'winvista.png'),
			'windowsvistaforoperaid' => array('Windows Vista', 'winvista.png'),
			'windowsxp' => array('Windows XP', 'winxp.gif'),
			'windowsserver2003' => array('Windows XP', 'winxp.gif'),
			'windowsxpforoperaid' => array('Windows Server 2003', 'winxp.gif'),
			'windowsserver2003foroperaid' => array('Windows Server 2003', 'winxp.gif'),
			'macosx' => array('Macintosh', 'mac.png'),
			'macos' => array('Macintosh', 'mac.png'),
			'iphone' => array('iPhone', 'iphone.png'),
			'linux' => array('Linux', 'linux.png')
		);
		
		$device_type = array(
			'normalbrowser' => array('Computer', 'computer.png'),
			'mobile' => array('Mobile', 'phone.png')
		);

		if($useragent['name'] == 'msie'){
			if($useragent['version'] >= 9 && $useragent['version'] < 10){
				$browser_name = 'msie9';
			}
			elseif($useragent['version'] >= 8 && $useragent['version'] < 9){
				$browser_name = 'msie8';
			}
			elseif($useragent['version'] >= 7 && $useragent['version'] < 8){
				$browser_name = 'msie7';
			}
			elseif($useragent['version'] >= 6 && $useragent['version'] < 7){
				$browser_name = 'msie6';
			}
			else{
				$browser_name = 'msie';
			}
		}
		else{
			$browser_name = $useragent['name'];
		}
		
		if( in_array($browser_name, array_keys($browsers)) ){
			$browser_name = $browsers["{$browser_name}"];
			$browser_full_name = "<nobr><img class=\"asMiddle\" src=\"images/browser/{$browser_name[1]}\" border=\"0\"> {$browser_name[0]} {$useragent['version']}</nobr>";
		}
		else{
			$browser_full_name = "<nobr><img class=\"asMiddle\" src=\"images/browser/unknown.png\" border=\"0\"> {$useragent['name']} {$useragent['version']}</nobr>";
		}
		
		
		
		$browser_system = preg_replace('/(\s)/si', '', $useragent['os']['system']);
		$browser_system = str_replace(array('/', ','), '', $browser_system);
		$browser_full_system = "";
		foreach($normal_systems as $key => $val){
			if($key == $browser_system){
				$browser_full_system = "<nobr><img class=\"asMiddle\" src=\"images/browser/{$val[1]}\" border=\"0\"> {$val[0]}</nobr>";
				break;
			}
		}
		if(empty($browser_full_system)){
			$browser_full_system = "<nobr><img class=\"asMiddle\" src=\"images/browser/unknown.png\" border=\"0\"> {$useragent['os']['system']}</nobr>";
		}
		
		$browser_device = $useragent['device'];
		if( in_array($browser_device, array_keys($device_type)) ){
			$browser_device = $device_type["{$browser_device}"];
			$browser_full_device = "<nobr><img class=\"asMiddle\" src=\"images/browser/{$browser_device[1]}\" border=\"0\"> {$browser_device[0]}</nobr>";
		}
		else{
			$browser_full_device = "<nobr><img class=\"asMiddle\" src=\"images/browser/unknown.png\" border=\"0\"> {$useragent['device']}</nobr>";
		}
		
		$content = array(
			'name' => $browser_full_name,
			'system' => $browser_full_system,
			'device' => $browser_full_device
		);
		return $content;
	}
	
	$uid = (u > 0 and ulv == 4) ? u : uid;
	$user_name = ($uid == uid) ? "لعضويتك" : "لعضوية {$mysql->get("user", "name", $uid)}";
	$user_url = ($uid == uid) ? "" : "&u={$uid}";
	
	$session_type_defualt = 'active';
	$session_type_arr = array('active', 'logout', 'stopped');
	$session_type = $DF->cleanText(trim($_GET['sesstype']));
	$session_type = ( in_array($session_type, $session_type_arr) ) ? $session_type : $session_type_defualt;
	
	if($session_type == 'logout'){
		$sql_status = 1;
	}
	elseif($session_type == 'stopped'){
		$sql_status = 2;
	}
	else{
		$sql_status = 0;
	}
	
	$paging = $Template->paging("loginsession WHERE userid = {$uid} AND status = {$sql_status}", "profile.php?type=loginsessions&sesstype={$session_type}{$user_url}&");
	
	echo"
	<center><br>{$paging}
	<table width=\"80%\" cellpadding=\"4\" cellspacing=\"1\">
		<tr>
			<td class=\"asTopHeader asCenter\" colspan=\"6\">
			<ul class=\"svcbar asAS12\">
				<li".($session_type == 'active'?' class="selected"':'')."><a href=\"profile.php?type=loginsessions&sesstype=active{$user_url}\"><em>جلسات نشطة</em></a></li>
				<li".($session_type == 'logout'?' class="selected"':'')."><a href=\"profile.php?type=loginsessions&sesstype=logout{$user_url}\"><em>جلسات تمت  خروج منها</em></a></li>
				<li".($session_type == 'stopped'?' class="selected"':'')."><a href=\"profile.php?type=loginsessions&sesstype=stopped{$user_url}\"><em>جلسات تمت إيقافها</em></a></li>
			</ul>
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"6\">جلسات دخول {$user_name}</td>
		</tr>
		<tr>
			<td class=\"asDarkB\">IP</td>
			<td class=\"asDarkB\">إتصال</td>
			<td class=\"asDarkB\">تاريخ إنشاء الجلسة</td>
			<td class=\"asDarkB\">الدولة</td>
			<td class=\"asDarkB\"><nobr>تفاصيل الجلسة</nobr></td>
			<td class=\"asDarkB\">".($session_type == 'active' ? 'الخيارات' : 'الحالة')."</td>
		</tr>";
	$current_hash = addslashes($_COOKIE['login_user_hash']);
	$sql = $mysql->query("SELECT id, status, hash, ip, useragent, lastdate, date FROM ".prefix."loginsession WHERE userid = {$uid} AND status = {$sql_status} ORDER BY date DESC LIMIT {$DF->pgLimit(num_pages)},".num_pages, __FILE__, __LINE__);
	$count = 0;
	while($rs = $mysql->fetchAssoc($sql)){
		$id = $rs['id'];
		$status = $rs['status'];
		$longip = $rs['ip'];
		$ip = long2ip($longip);
		$hashIP = (ulv == 4 || ulv == 3 && ($uid == uid || $uid < 3)) ? $ip : $DF->hashIP($ip);
		$useragent = (!empty($rs['useragent'])) ? $Browser->get('full', $rs['useragent']) : "";//$rs['useragent']
		$lastdate = $rs['lastdate'];
		$date = $rs['date'];
		
		$class_name = ($rs['hash'] == $current_hash) ? 'asFirstB' : 'asNormalB';
		
		// ip to country
		$details = $DF->getCountryByIP( $ip, 'all' );
		$details_code = isset($details['code']) ? $details['code'] : '';
		$details_name = isset($details['name']) ? $details['name'] : '';
		$code = strtolower($details_code);
		if( isset($country["{$code}"]) ){
			$country_name = $country["{$code}"]['name'];
		}
		else{
			if( $code != '' ){
				$country_name = $details_name;
			}
			else{
				$country_name = "غير معروف";
			}
		}
		
		// online
		$online_now = ($status == 0 && ($lastdate + (60 * 5)) > time) ? "<img src=\"{$DFImage->i['online']}\" border=\"0\"><br>متصل الآن" : "غير متصل";
		
		// get users by ip
		$get_users_by_ip = (ulv == 4) ? "<img src=\"{$DFImage->i['expand']}\" onclick=\"DF.getUsersByIP({$longip}, {$count}, this, 6);\" style=\"float:right;cursor:pointer;\" alt=\"مطابقة IP\">" : "";
		
 		echo"
		<tr id=\"getIpRow{$count}\">
			<td class=\"{$class_name} asS12 asCenter\" width=\"150\"><nobr>{$get_users_by_ip}{$hashIP}</nobr></td>
			<td class=\"{$class_name} asS12 asCenter\"><nobr>{$online_now}</nobr></td>
			<td class=\"{$class_name} asS12 asCenter\"><nobr>{$DF->date($date, '', true, true)}</nobr></td>
			<td class=\"{$class_name} asS12 asCenter\"><nobr><img src=\"{$DF->getFlagByCode($code)}\" width=\"18\" height=\"12\" hspace=\"3\" border=\"0\"> - {$country_name}</nobr></td>
			<td class=\"{$class_name} asS12 asCenter\">";
			$browser_details = browser_details($useragent);
			if(is_array($browser_details)){
				echo"
				<table width=\"95%\" bgcolor=\"gray\" cellpadding=\"2\" cellspacing=\"1\" align=\"center\">
					<tr>
						<td class=\"asS11\" bgcolor=\"#cccccc\"><nobr>اسم متصفح</nobr></td>
						<td class=\"asS11\" bgcolor=\"#eeeeee\" dir=\"ltr\">{$browser_details['name']}</td>
					</tr>
					<tr>
						<td class=\"asS11\" bgcolor=\"#cccccc\"><nobr>نظام التشغيل</nobr></td>
						<td class=\"asS11\" bgcolor=\"#eeeeee\" dir=\"ltr\">{$browser_details['system']}</td>
					</tr>
					<tr>
						<td class=\"asS11\" bgcolor=\"#cccccc\"><nobr>نوع الجهاز</nobr></td>
						<td class=\"asS11\" bgcolor=\"#eeeeee\" dir=\"ltr\">{$browser_details['device']}</td>
					</tr>
				</table>";
			}
			else{
				echo"غير متاحة";
			}
			echo"
			</td>
			<td class=\"{$class_name} asAS12 asS12 asCenter\"><nobr>";
			if($session_type == 'logout'){
				echo "تم خروج من الجلسة<br>{$DF->date($lastdate, '', true, true)}";
			}
			elseif($session_type == 'stopped'){
				echo "تم إيقاف الجلسة<br>{$DF->date($lastdate, '', true, true)}";
			}
			else{
				echo"
				<a class=\"sess-status\" sessid=\"{$id}\" href=\"#\"><img src=\"images/browser/stop.png\" border=\"0\"><br>إيقاف جلسة</a>
				<span class=\"dis-none\"><img src=\"images/icons/progress.gif\" border=\"0\"></span>";
			}
			echo"</nobr>
			</td>
		</tr>";
		$count++;
	}
	if($count == 0){
		if($session_type == 'logout'){
			$empty_text = "لا توجد أية جلسات تمت خروج منها";
		}
		elseif($session_type == 'stopped'){
			$empty_text = "لا توجد أية جلسات تمت إيقافها";
		}
		else{
			$empty_text = "لا توجد أية جلسات نشطة";
		}
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"6\"><br>{$empty_text}<br><br></td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asBody\" style=\"padding:0px\" colspan=\"6\">
			<table cellSpacing=\"2\" cellPadding=\"3\">
				<tr>
					<td class=\"asTitle\">ملاحظة</td>
					<td class=\"asText2\"><nobr>الجلسة الحالية تظهر بلون: </nobr></td>
					<td class=\"asText2 asFirstB\"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;</nobr></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	</center><br>";
	?>
	<script type="text/javascript">
	$(function(){
		$('.sess-status').click(function(){
			var id = $(this).attr('sessid') || 0, cell = $(this).parents('td')[0];
			if(id == 0){
				return false;
			}
			$('a', cell).hide();
			$('span', cell).show();
			$.ajax({
				type: 'POST',
				url: 'ajax.php?x='+Math.random(),
				data: 'type=stopSession<?=$user_url?>&id='+id,
				success: function(res){
					res = $PI(res);
					if(res == 1){
						$('span > img', cell).attr('src', 'images/icons/succeed.gif');
						$($(cell).parents('tr')[0]).animate({'opacity': 0, 'height': 'toggle'}, 500);
					}
					else{
						$('span', cell).hide();
						$('a', cell).show();
					}
				}
			});
			return false;
		});
	});
	</script>
	<?php
}
elseif(type == 'medals'&&ulv > 0){
	?>
	<script type="text/javascript">
	var link="profile.php?type=medals&";
	DF.chooseMedal=function(mid){
		$I('#medals').mid.value=mid;
		$I('#medals').submit();
	}
	DF.removeMedal=function(){
		$I('#medals').mid.value=-1;
		$I('#medals').submit();
	}
	</script>
	<?php
	echo"
	<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
		<tr>
			<td class=\"asTopHeader2\">
			<table cellSpacing=\"3\" cellPadding=\"3\">
				<tr>
					<td class=\"asC1\" width=\"1200\">خدمات عضويتك</td>";
					$Template->basicPaging("medal WHERE userid = '".uid."' AND status = 1");
					$Template->goToForum();
				echo"
				</tr>
			</table>
			</td>
		</tr>
	</table><br>
	<form id=\"medals\" name=\"medals\" method=\"post\" action=\"".self."\"><input type=\"hidden\" name=\"mid\"></form>
	<table cellSpacing=\"1\" cellPadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader\" colSpan=\"7\">أوسمة التميز الممنوحة لك</td>
		</tr>
		<tr>
			<td class=\"asDarkB\"><nobr>التاريخ</nobr></td>
			<td class=\"asDarkB\"><nobr>يعرض حتى</nobr></td>
			<td class=\"asDarkB\"><nobr>الشعار الممنوح</nobr></td>
			<td class=\"asDarkB\"><nobr>مشاهدة<br>الصورة</nobr></td>
			<td class=\"asDarkB\"><nobr>المنتدى</nobr></td>";
		if(ulv > 1){
			echo"
			<td class=\"asDarkB\"><nobr>منح الشعار</nobr></td>";
		}
			echo"
			<td class=\"asDarkB\"><nobr>الخيارات</nobr></td>
		</tr>";
	$pgLimit=$DF->pgLimit(num_pages);
	$sql=$mysql->query("SELECT m.id,m.date,ml.forumid,ml.subject,ml.days,ml.filename,f.subject AS fsubject,
		m.added,u.name AS aname,u.status AS astatus,u.level AS alevel,u.submonitor AS asubmonitor
	FROM ".prefix."medal AS m
	LEFT JOIN ".prefix."medallists AS ml ON(ml.id = m.listid)
	LEFT JOIN ".prefix."forum AS f ON(f.id = ml.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = m.added)
	WHERE m.userid = '".uid."' AND m.status = 1 ORDER BY date DESC LIMIT $pgLimit,".num_pages, __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
	
		$added = $Template->userColorLink($rs['added'], array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor']));
	
		$expireDate=$rs['date']+($rs['days']*86400);
		$expire=($expireDate>time ? $DF->date($expireDate,'date',true) : 'إنتهى');
	
		echo"
		<tr>
			<td class=\"asNormalB asDate asS12 asCenter\"><nobr>{$DF->date($rs['date'],'date',true)}</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>$expire</nobr></td>
			<td class=\"asNormalB\"><nobr>{$rs['subject']}</nobr></td>
			<td class=\"asNormalB asCenter\"><img src=\"{$DFImage->i['camera']}\" onclick=\"DF.doPreviewImage('{$DFPhotos->getsrc($rs['filename'])}');\" border=\"0\"></td>
			<td class=\"asNormalB asAS12 asCenter\"><nobr>{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</nobr></td>";
		if(ulv > 1){
			echo"
			<td class=\"asNormalB asAS12 asCenter\"><nobr>$added</nobr></td>";
		}
			echo"
			<td class=\"asNormalB asCenter\">";
			if($expireDate>time){
				echo"
				<a href=\"javascript:DF.chooseMedal({$rs['id']});\"><img src=\"{$DFImage->i['user_profile']}\" alt=\"إستخدم هذا الوسام كوسامك الحالي\"  hspace=\"3\" border=\"0\"></a>";
			}
			echo"
			</td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colSpan=\"7\"><br>لا توجد أي أوسمة لك<br><br></td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asNormalB asAS12 asCenter\" colSpan=\"7\"><a href=\"javascript:DF.removeMedal();\">- إضغط هنا لإزالة وسامك الحالي من العرض تحت إسمك في مشاركاتك -</a></td>
		</tr>
	</table>";
}
elseif(type == 'hiddentopics'){
	if(ulv == 0){
		$DF->goTo();
		exit();
	}
	$uid=(auth>0&&ulv == 4?auth:uid);
	$ulv=($uid == uid ? ulv : $mysql->get("user","level",$uid));
	echo"
	<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
		<tr>
			<td class=\"asTopHeader2\">
			<table cellSpacing=\"3\" cellPadding=\"3\">
				<tr>
					<td class=\"asC1\" width=\"1200\">مواضيع مخفية ومفتوحة ".($uid == uid ? "لك" : "للعضو: <span class=\"asC2\">{$mysql->get("user","name",$uid)}</span>")."</td>";
					$Template->refreshPage();
					$Template->goToForum();
				echo"
				</tr>
			</table>
			</td>
		</tr>
	</table>
	<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
		<tr>
			<td class=\"asHeader\">قائمة مواضيع</td>
		</tr>
		<tr>
			<td class=\"asBody\">
			<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"4\">
				<tr>
					<td class=\"asDark\" width=\"18%\">منتدى</td>
					<td class=\"asDark\">&nbsp;</td>
					<td class=\"asDark\" width=\"45%\">المواضيع</td>
					<td class=\"asDark\" width=\"15%\">الكاتب</td>
					<td class=\"asDark\">الردود</td>
					<td class=\"asDark\">قرأت</td>
					<td class=\"asDark\" width=\"15%\">آخر رد</td>";
				if( ulv > 0 ){
					echo"
					<td class=\"asDark\" width=\"1%\">الخيارات</td>";
				}
				echo"
				</tr>";

	$topicFolderSql=",
	IF(
		t.moderate = 1,'{$DFImage->f['moderate']}|موضوع تنتظر الموافقة',
		IF(
			t.moderate = 2,'{$DFImage->f['held']}|موضوع مجمد',
			IF(
				t.trash = 1,'{$DFImage->f['delete']}|موضوع محذوف',
				IF(
					t.status = 0,'{$DFImage->f['lock']}|موضوع مقفل','{$DFImage->f['folder']}|موضوع مفتوح'
				)
			)
		)
	) AS topicfolder";

	$checkSqlField="";
	$checkSqlTable="";
	$checkSqlWhere="";
	if(ulv < 4){
		$checkSqlWhere="AND (f.hidden = 0 AND '$ulv' >= f.level OR NOT ISNULL(fu.id) OR ($ulv > 1 AND NOT ISNULL(m.id)) OR ($ulv = 3 AND NOT ISNULL(c.id)))";
		$checkSqlField="
			,IF(ISNULL(m.id),0,1) AS ismod
			,IF(ISNULL(c.id),0,1) AS ismon
		";
		$checkSqlTable="
			LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = '$uid')
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = '$uid')
			LEFT JOIN ".prefix."category AS c ON(c.id = f.catid AND c.monitor = '$uid')
		";
	}
	else{
		$checkSqlField="
			,IF(ISNULL(t.id),0,1) AS ismod
			,IF(ISNULL(t.id),0,1) AS ismon
		";
	}
		
	$sql = $mysql->query("SELECT t.id,t.subject,t.status,t.author,t.lpauthor,t.posts,t.views,t.lpdate,t.date,
		f.id AS forumid,f.subject AS fsubject,u.name AS aname,u.status AS astatus,u.level AS alevel,u.submonitor AS asubmonitor,
		uu.name AS lpname,uu.status AS lpstatus,uu.level AS lplevel,uu.submonitor AS lpsubmonitor {$topicFolderSql} {$checkSqlField}
	FROM ".prefix."topicusers AS tu
	LEFT JOIN ".prefix."topic AS t ON(t.id = tu.topicid)
	LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
	LEFT JOIN ".prefix."user AS u ON(u.id = t.author)
	LEFT JOIN ".prefix."user AS uu ON(uu.id = t.lpauthor) {$checkSqlTable}
	WHERE tu.userid = {$uid} AND t.trash = 0 AND t.moderate = 0 {$checkSqlWhere} ORDER BY t.lpdate DESC", __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		if($rs['ismon'] == 1){
			$is_moderator=true;
			$is_monitor=true;
		}
		elseif($rs['ismod'] == 1){
			$is_moderator=true;
		}
		$topicFolder=explode("|",$rs['topicfolder']);
		$author = $Template->userColorLink($rs['author'], array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor']));
		$lpauthor = $Template->userColorLink($rs['lpauthor'], array($rs['lpname'], $rs['lpstatus'], $rs['lplevel'], $rs['lpsubmonitor']));
		echo"
		<tr>
			<td class=\"asNormal asAS12 asCenter\">{$Template->forumLink($rs['forumid'],$rs['fsubject'])}</td>
			<td class=\"asNormal asCenter\"><img src=\"$topicFolder[0]\" alt=\"$topicFolder[1]\" border=\"0\"></td>
			<td class=\"asNormal\">
			<table cellPadding=\"0\" cellsapcing=\"0\">
				<tr>
					<td>{$Template->topicLink($rs['id'],$rs['subject'])}".($rs['posts']>0?$Template->topicPaging($rs['id'],$rs['posts']):"")."</td>
				</tr>
			</table>
			</td>
			<td class=\"asNormal asS12 asAS12 asDate asCenter\">{$DF->date($rs['date'])}<br>$author</td>
			<td class=\"asNormal asS12 asCenter\">{$rs['posts']}</td>
			<td class=\"asNormal asS12 asCenter\">{$rs['views']}</td>
			<td class=\"asNormal asS12 asAS12 asDate asCenter\">";
			if($rs['posts']>0){
				echo "{$DF->date($rs['lpdate'])}<br>$lpauthor";
			}
			else{echo"&nbsp;";}
			echo"</td>
			<td class=\"asNormal asCenter\"><nobr>";
			if($is_moderator||$rs['status'] == 1&&$rs['author'] == $uid){
				echo"
				<a href=\"editor.php?type=edittopic&t={$rs['id']}&src=".urlencode(self)."\"><img src=\"{$DFImage->f['edit']}\" alt=\"تعديل الموضوع\" hspace=\"2\" border=\"0\"></a>";
			}
			if($rs['status'] == 1||$is_moderator){
				echo"
				<a href=\"editor.php?type=newpost&t={$rs['id']}&src=".urlencode(self)."\"><img src=\"{$DFImage->i['reply']}\" alt=\"رد على الموضوع\" hspace=\"2\" border=\"0\"></a>";
			}
			echo"
			</nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormal asCenter\" colspan=\"8\"><br>لا توجد أي موضوع مخفي ومفتوح لك<br><br></td>
		</tr>";
	}
	echo"
	</table>
	</td>
	</tr>
	</table>";
}
elseif(type == 'sendadmin'){
	if(ulv == 0){
		$DF->goTo();
		exit();
	}
	echo"
	<table width=\"80%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
		<tr>
			<td class=\"asHeader\">مراسلة إدارة المنتديات</td>
		</tr>
		<tr>
			<td class=\"asNormalB asS12 asCenter\">";
			if( forum_logo != '' ){
				echo"<br>
				<img src=\"".forum_logo."\" alt=\"".forum_title."\" width=\"70\" border=\"0\">";
			}
			echo"
			<br><br><div style=\"font-size:16px;\">شكرا لك على رغبتك في مراسلة إدارة ".forum_title.".<br>نظرا للكم الهائل من الرسائل التي تستلمها الإدارة يوميا لا يمكننا الرد على جميع الرسائل.<br><br>التالي أجوبة على إستفسارات عامة تصلنا بشكل دائم:</div><br>
			<table cellspacing=\"1\" cellPadding=\"4\">
				<tr>
					<td class=\"asDarkB\" width=\"33%\"><b>كيف أصبح مشرفا؟</b></td>
					<td class=\"asDarkB\" width=\"33%\"><b>كيف أصبح مراقباً؟</b></td>
					<td class=\"asDarkB\" width=\"33%\"><b>كيف أحصل على أوسمة؟</b></td>
				</tr>
				<tr>
					<td class=\"asFixedB asS12\" vAlign=\"top\">الإدارة لا تقبل ترشيح للإشراف من أعضاء سواء تطوعا لأنفسهم أو لغيرهم. اختيار المشرفين يتم على أساس نشاطهم وتميز مشاركاتهم وتفاعلهم مع الاعضاء الآخرين ومع المشرفين. الامر راجع لك ان تثبت نفسك بهذا الاسلوب لدرجة تلفت انتباهنا اليك.</td>
					<td class=\"asFixedB asS12\" vAlign=\"top\">الأمر تعين مراقبين لمجموعة من منتديات يرجع للإدارة. الإدارة يقوم بتعين مراقبين نظراً للوجود الدائم للعضو وأيظاً لأخلاق العالي والمشاركات الفعال. لهذا أي عضو يطبق مع هذه المواصفات فأكيد سنقوم بتعينه كمراقب لمجموعة من المنتديات.</td>
					<td class=\"asFixedB asS12\" vAlign=\"top\">الأوسمة ونقاط التميز وغيرها من إختصاص مشرفي المنتديات و ليس الإدارة.</td>
				</tr>
				<tr>
					<td class=\"asDarkB\"><b>اريد برمجة منتدياتكم</b></td>
					<td class=\"asDarkB\"><b>كيف أغير أسم عضويتي؟</b></td>
					<td class=\"asDarkB\"><b>كيف أطلب إزالة الرقابة عني؟</b></td>
				</tr>
				<tr>
					<td class=\"asFixedB asS12\" vAlign=\"top\">برمجة نسخة ".forum_title." هي برمجتنا الخاصة ولا نستطيع نعطي هذه البرمجة لأحد وكل حقوق هذه البرمجة محفوظة ل".forum_title." وأيظاً هذه البرمجة ليس للبيع اطلاقاً.</td>
					<td class=\"asFixedB asS12\" vAlign=\"top\">عليك بإدخال طلب تغيير إسم العضوية من صفحة بياناتك. إذا تجاوزت تغييراتك لإسم عضويتك ".max_change_name." مرات لن يقبل النظام طلب آخر لتغيير إسمك ولن تقبل أية طلبات لتغيير الاسماء إلا في حالات خاصة.</td>
					<td class=\"asFixedB asS12\" vAlign=\"top\">الرقابة في منتدى معين من إختصاص مشرفي ذلك المنتدى. الرجاء منك مخاطبتهم بالإمر.</td>
				</tr>
				<tr>
					<td class=\"asDarkB\"><b>أريد نقل مشاركاتي أو نقاط تميزي لعضوية أخرى</b></td>
					<td class=\"asDarkB\"><b>دعوة للإدارة للمشاركة في موضوع معين</b></td>
					<td class=\"asDarkB\"><b>كيف أنظم مسابقة؟</b></td>
				</tr>
				<tr>
					<td class=\"asFixedB asS12\" vAlign=\"top\">لا يمكن نقل أية بيانات أو مشاركات أو نقاط بين العضويات.</td>
					<td class=\"asFixedB asS12\" vAlign=\"top\">نظرا للدعوات الكثيرة التي تصلنا للمشاركة في مواضيع معينة تعتذر الإدارة عن قبول مثل هذه الطلبات.</td>
					<td class=\"asFixedB asS12\" vAlign=\"top\">تنظيم المسابقات من إختصاص مشرفي المنتديات و ليس الإدارة. الرجاء بك الإتصال بمشرفي المنتدى الذي تريد أن تقيم مسابقة فيه.</td>
				</tr>
			</table>
			<br><br>إذا لم تجد إجابة على إستفسارك يمكن مراسلة الإدارة بالضغط على الوصلة أدناه.<br>الرجاء الملاحظة إذا كان إستفسارك إجابته أعلاه لن يتم الرد على رسالتك.<br>
			<br>{$Template->button("إضغط هنا لمراسلة الإدارة"," onClick=\"location.href='editor.php?type=sendpm&u=".u."&src=".urlencode(src)."';\"")}<br><br>
			</td>
		</tr>
	</table>";
}
elseif(type == 'activity'){
	if(ulv == 0){
		$DF->goTo();
		exit();
	}
	$uid=(auth>0&&ulv == 4 ? auth : uid);
	$ulv=($uid == uid ? ulv : $mysql->get("user","level",$uid));
	$uname=($uid == uid ? uname : $mysql->get("user","name",$uid));
	echo"
	<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
		<tr>
			<td class=\"asTopHeader2\">
			<table cellSpacing=\"3\" cellPadding=\"3\">
				<tr>
					<td><img src=\"{$DFImage->h['activity']}\" border=\"0\"></td>
					<td class=\"asC1\" width=\"1200\">".($uid == uid ? "نشاطك في المنتدى" : "نشاط عضوية <span class=\"asC2\">{$uname}</span> في المنتدى")."</td>";
					$Template->goToForum();
				echo"
				</tr>
			</table>
			</td>
		</tr>
	</table><br>";
	if($ulv < 4){
	// Do content
	define('startYear',2011);
	define('startMonth',1);
	$scopeArr=array('monthly','yearly');
	$scope=(in_array(scope,$scopeArr) ? scope : 'monthly');
	$d=explode("-",date("Y-m",gmttime));
	$thisYear=$d[0];
	$thisMonth=$d[1];
	// check year
	$xYear1=startYear;
	$xYear2=$thisYear;
	$year=($DF->between(y,$xYear1,$xYear2) ? y : $thisYear);
	// check month
	if($scope == 'monthly'){
		$xMonth1=($year == startYear ? startMonth : 1);
		$xMonth2=($year == $thisYear ? $thisMonth : 12);
		if($DF->between(m,$xMonth1,$xMonth2)){
			$month=m;
		}
		else{
			$month=($year == $thisYear ? $thisMonth : $xMonth1);
		}
	}
	$linkArr=array(
		'scope'=>$scope,
		'auth'=>auth,
		'y'=>$year,
		'm'=>$month
	);
	
	$jsLinkArr="";
	foreach($linkArr as $key=>$val) $jsLinkArr.=",'{$key}','{$val}'";
	if(!empty($jsLinkArr)) $jsLinkArr=substr($jsLinkArr,1);
	?>
	<script type="text/javascript">
	var linkArr=new Array(<?=$jsLinkArr?>);
	DF.goToLink=function(arr){
		document.location=DF.checkLink("profile.php?type=activity",linkArr,arr);
	};
	</script>
	<?php
	if($scope == 'yearly'){
		$scopeTitle="نشاط سنوي";
	}
	else{
		$scopeTitle="نشاط شهري";
	}
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asBody2 asCenter\" colspan=\"5\">
			<ul class=\"svcbar asAS12\">
				<li".($scope == 'monthly'?' class="selected"':'')."><a href=\"{$DF->checkLink('profile.php?type=activity',$linkArr,array('scope'=>'monthly','y'=>'','m'=>''))}\"><em>شهري</em></a></li>
				<li".($scope == 'yearly'?' class="selected"':'')."><a href=\"{$DF->checkLink('profile.php?type=activity',$linkArr,array('scope'=>'yearly','y'=>'','m'=>''))}\"><em>سنوي</em></a></li>
			</ul>
			<ul class=\"svcbar asAS12\">";
				if($scope == 'monthly'){
					echo"
					<li><em class=\"one\"><nobr>الشهر: 
					<select class=\"asGoTo\" onChange=\"DF.goToLink(['m',this.options[this.selectedIndex].value])\">";
					for($x=$xMonth1;$x<=$xMonth2;$x++){
						echo"
						<option value=\"$x\"{$DF->choose($x,$month,'s')}>$x</option>";
					}
					echo"
					</select></nobr>
					</em></li>";
				}
				echo"
				<li><em class=\"one\"><nobr>السنة: 
				<select class=\"asGoTo\" onChange=\"DF.goToLink(['y',this.options[this.selectedIndex].value,'m',''])\">";
				for($x=$xYear1;$x<=$xYear2;$x++){
					echo"
					<option value=\"$x\"{$DF->choose($x,$year,'s')}>$x</option>";
				}
				echo"
				</select></nobr>
				</em></li>
			</ul>
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"5\">عدد نقاط - <span class=\"asC2\">$scopeTitle</span></td>
		</tr>";
	if($scope == 'monthly'){
		$scopeName="هذا الشهر غير مكتمل";
		$timeWF=mktime(0,0,0,$month,1,$year);
		$timeWT=mktime(0,0,0,($month == 12 ? 1 : ($month+1)),1,$year)-1;
		$dateWF=explode("-",date("Y-m-d-w",$timeWF));
		$dateWT=explode("-",date("Y-m-d-w",$timeWT));
	}
	elseif($scope == 'yearly'){
		$scopeName="هذه السنة غير مكتملة";
		$timeWF=mktime(0,0,0,1,1,$year);
		$timeWT=mktime(0,0,0,1,1,$year+1)-1;
		$dateWF=explode("-",date("Y-m-d-w",$timeWF));
		$dateWT=explode("-",date("Y-m-d-w",$timeWT));
	}
		echo"
		<tr>
			<td class=\"asHiddenB asS12 asCenter\" colspan=\"5\">({$Template->weekName[$dateWF[3]]}) {$dateWF[2]} {$Template->monthName[(int)$dateWF[1]]} {$dateWF[0]} الى ({$Template->weekName[$dateWT[3]]}) {$dateWT[2]} {$Template->monthName[(int)$dateWT[1]]} {$dateWT[0]}</td>
		</tr>";
	if($timeWT>gmttime){
		echo"
		<tr>
			<td class=\"asErrorB asS12 asCenter\" colspan=\"5\">ملاحظة: {$scopeName}, سيكتمل بتاريخ ({$Template->weekName[$dateWT[3]]}) {$dateWT[2]} {$Template->monthName[(int)$dateWT[1]]} {$dateWT[0]} ساعة [".date("H:i:s",$timeWT)."] بتوقيت غرينتش</td>
		</tr>";
	}
 	$rs=$mysql->queryRow("SELECT SUM(points) FROM ".prefix."useractivity
	WHERE userid = $uid AND date > {$timeWF} AND date < {$timeWT}", __FILE__, __LINE__);
	$points=(int)$rs[0];
		echo"
		<tr>
			<td class=\"asBody2 asCenter asC1\" style=\"padding:10px;font-size:40px;font-weight:bold\" colspan=\"5\">{$points}</td>
		</tr>
	</table>";
	}
	else{
		echo"<br><div class=\"asCenter asS15 asC2\">هذه الخاصية غير متوفرة عند المدراء</div><br>";
	}
}
elseif(type == 'notifications' and ulv > 0){
	$limit = 100;
	?>
	<script type="text/javascript">
	DF.readNotify = function(id, ajaxTry){
		if(id && id > 0){
			var icon = $I('#notifyIcon'+id), row = $I('#notifyRow'+id), cell = $I('#notifyCell'+id),
			doError = function(){
				$(icon).attr('src', $(icon).attr('def'));
				DM.container.open({
					error: true,
					header: 'حدث خطأ',
					body: 'حدث خطأ أثناء تنفيذ العملية, يبدوا أن الخادم لم يستجاب هذه العملية<br>أرجوا أن تقوم بتكرار العملية مرة اخرى, نتأسف لهذا.'
				});
			};
			$(icon).attr('src', 'images/icons/progress.gif');
 			$.ajax({
				type: 'POST',
				url: 'ajax.php',
				data: 'type=read_notification&id='+id,
				timeout: 3000,
				success: function(res){
					if($PI(res) == 1){
						$(icon).attr('src', $(icon).attr('def'));
						if(row){
							for(var x = 0; x<row.cells.length; x++){
								row.cells[x].className = row.cells[x].className.replace('Hidden','Normal');
							}
						}
						$(cell).html('<img src="images/icons/xshow.gif">');
					}
					else{
						doError();
					}
				},
				error: function(e, request){
					if(request == 'timeout' && $PI(ajaxTry) < 2){
						DF.readNotify(id , $PI(ajaxTry) + 1);
					}
					else{
						doError();
					}
				}
			});
		}
	};
	</script>
	<?php
	$allNotifications = $DFOutput->count("notification WHERE author = ".uid."");
	if($allNotifications > 100){
		$allNotifications = 100;
	}
	$unReadNotifications = intval($DF->catch['newNT']);
	$readNotifications = ($allNotifications - $unReadNotifications);
	if($readNotifications < 0){
		$readNotifications = 0;
	}
	echo"
	<table width=\"75%\" cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader\" colspan=\"4\">الإشعارات</td>
		</tr>
		<tr>
			<td class=\"asBody3 asP0\" colspan=\"4\">
			<table cellSpacing=\"2\" cellPadding=\"3\">
				<tr>
					<td class=\"asTitle\">إشعارات غير مقروءة</td>
					<td class=\"asText2\" id=\"unrNo\">{$unReadNotifications}</td>
					<td class=\"asTitle\">إشعارات مقروءة</td>
					<td class=\"asText2\" id=\"inrNo\">{$readNotifications}</td>
					<td class=\"asTitle\">مجموع إشعارات</td>
					<td class=\"asText2\">{$allNotifications}</td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td class=\"asDarkB\"><nobr>&nbsp;</nobr></td>
			<td class=\"asDarkB\"><nobr>عنوان</nobr></td>
			<td class=\"asDarkB\"><nobr>تاريخ</nobr></td>
			<td class=\"asDarkB\"><nobr>قراءة</nobr></td>
		</tr>";
	require_once 'notifications_list.php';
 	$sql = $mysql->query("SELECT n.*,u.name AS uname,u.status AS ustatus,u.level AS ulevel,u.submonitor AS usubmonitor,IF(NOT ISNULL(t.id),t.subject,'') AS tsubject
	FROM ".prefix."notification AS n
	LEFT JOIN ".prefix."user AS u ON(u.id = n.userid)
	LEFT JOIN ".prefix."topic AS t ON(t.id = n.topicid)
	WHERE n.author = ".uid." GROUP BY n.id ORDER BY n.date DESC LIMIT {$limit}", __FILE__, __LINE__);
	$lastDate = 0;
	$count = 0;
	while($rs = $mysql->fetchAssoc($sql)){
		$user = $Template->userColorLink(
			$rs['userid'],
			array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor'])
		);
		$type = $rs['type'];
		$tid = intval($rs['topicid']);
		$pid = intval($rs['postid']);
		$title = $notify_types["{$type}"]['title'].(!empty($rs['tsubject']) ? " ({$rs['tsubject']})" : "");
		$url = $notify_types["{$type}"]['url'];
		if($tid > 0){
			$url = str_replace("{1}", $tid, $url);
		}
		if($pid > 0){
			$url = str_replace("{2}", $pid, $url);
		}
		$icon = $notify_types["{$type}"]['icon'];
		$className = ($rs['status'] == 0) ? 'asHiddenB' : 'asNormalB';
		echo"
		<tr id=\"notifyRow{$rs['id']}\">
			<td class=\"{$className} asCenter\"><img id=\"notifyIcon{$rs['id']}\" src=\"{$icon}\" def=\"{$icon}\" border=\"0\"></td>
			<td class=\"{$className}\"><nobr>{$user} <a href=\"{$url}\">{$title}</a></nobr></td>
			<td class=\"{$className} asDate asS12 asCenter\"><nobr>{$DF->date($rs['date'])}</nobr></td>
			<td class=\"{$className} asCenter\" id=\"notifyCell{$rs['id']}\">";
			if($rs['status'] == 0){
				echo"<a class=\"asTooltip\" onclick=\"DF.readNotify({$rs['id']});return false;\" href=\"#\"><img src=\"images/icons/xhidden.gif\">{$Template->tooltip('جعل الإشعار مقروء')}</a>";
			}
			else{
				echo"<img src=\"images/icons/xshow.gif\">";
			}
			echo"</td>
		</tr>";
		$count++;
		if($count == 100){
			$lastDate = intval($rs['date']);
		}
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"4\"><br>-- لا توجد أية إشعارات لك --<br><br></td>
		</tr>";
	}
		echo"
		<tr>
			<td class=\"asBody asP0\" colspan=\"4\">
			<table cellSpacing=\"2\" cellPadding=\"3\">
				<tr>
					<td class=\"asTitle\">ملاحظة</td>
					<td class=\"asText2\">فقط تظهر لك آخر 100 إشعارات, إما الباقي سيحذف بشكل تلقائي.</td>
					<td class=\"asText2\">الإشعارات الغير مقروءة تظهر بلون</td>
					<td class=\"asHidden asBGray asS11\"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>";
	if($lastDate > 0){
		$mysql->delete("notification WHERE author = ".uid." AND date < {$lastDate}", __FILE__, __LINE__);
	}
}
else{
	$DF->goTo();
}
$Template->footer();
?>