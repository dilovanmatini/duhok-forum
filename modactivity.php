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

if(_df_script == 'svc'&&this_svc == 'modactivity'&&ulv > 2){
// ************ start page ****************

if(type == ''){
	define('startYear',2010);
	define('startMonth',10);
	define('startWeek',44);
	$scopeArr=array('weekly','monthly','yearly');
	$nUsersArr=array(5,10,15,20,30,40,50,100,200);
	$catid=c;
	$forumid=f;
	$scope=(in_array(scope,$scopeArr) ? scope : 'weekly');
	$nuser=(in_array(u,$nUsersArr) ? u : 30);
	$d=explode("-",date("Y-m",gmttime));
	$thisYear=$d[0];
	$thisMonth=$d[1];
	$thisWeek=$DF->getThisWeek(gmttime);
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
	// check week
	if($scope == 'weekly'){
		$xWeek1=($year == startYear ? startWeek : 1);
		$xWeek2=($year == $thisYear ? $thisWeek : $DF->getYearWeeks($year));
		if($DF->between(w,$xWeek1,$xWeek2)){
			$week=w;
		}
		else{
			$week=($year == $thisYear ? $thisWeek : $xWeek1);
		}
	}
	$linkArr=array(
		'c'=>$catid,
		'f'=>$forumid,
		'scope'=>$scope,
		'u'=>$nuser,
		'y'=>$year,
		'm'=>$month,
		'w'=>$week
	);
	
	$jsLinkArr="";
	foreach($linkArr as $key=>$val) $jsLinkArr.=",'{$key}','{$val}'";
	if(!empty($jsLinkArr)) $jsLinkArr=substr($jsLinkArr,1);
	
	?>
	<script type="text/javascript">
	var linkArr=new Array(<?=$jsLinkArr?>);
	DF.goToLink=function(arr){
		document.location=DF.checkLink("svc.php?svc=modactivity",linkArr,arr);
	};
	</script>
	<?php
	
	if($scope == 'monthly'){
		$scopeTitle="نشرة شهرية";
	}
	elseif($scope == 'yearly'){
		$scopeTitle="نشرة سنوية";
	}
	else{
		$scopeTitle="نشرة اسبوعية";
	}
	
	$sqlWhere=(ulv == 4 ? "" : "WHERE monitor = ".uid."");
	$sql=$mysql->query("SELECT id,subject FROM ".prefix."category $sqlWhere ORDER BY sort ASC", __FILE__, __LINE__);
	$cats=array();
	while($rs=$mysql->fetchRow($sql)){
		$cats[$rs[0]]=$rs[1];
	}
	
	$sqlWhere=($catid>0 ? "AND catid = $catid" : "");
	$sql=$mysql->query("SELECT id,subject FROM ".prefix."forum WHERE catid IN(".implode(",",array_keys($cats)).") $sqlWhere ORDER BY sort ASC", __FILE__, __LINE__);
	$forums=array();
	while($rs=$mysql->fetchRow($sql)){
		$forums[$rs[0]]=$rs[1];
	}

	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asTopHeader asCenter\" colspan=\"5\">
			<ul class=\"svcbar asAS12\">
				<li><em class=\"one\"><nobr>الفئة: 
				<select class=\"asGoTo\" style=\"width:160px\" onChange=\"DF.goToLink(['c',this.options[this.selectedIndex].value,'f',''])\">";
				if(count($cats)>1){
					echo"
					<option value=\"0\">&nbsp;&nbsp;&nbsp;-- جميع فئات --</option>";
				}
				foreach(@$cats as $cid=>$csubject){
					if(count($cats) == 1){
						$catid=$cid;
					}
					echo"
					<option value=\"$cid\"{$DF->choose($catid,$cid,'s')}>$csubject</option>";
				}
				echo"
				</select></nobr>
				</em></li>
				<li><em class=\"one\"><nobr>المنتدى:
				<select class=\"asGoTo\" style=\"width:160px\" onChange=\"DF.goToLink(['f',this.options[this.selectedIndex].value])\">
					<option value=\"0\">&nbsp;&nbsp;&nbsp;-- جميع منتديات --</option>";
				foreach(@$forums as $fid=>$fsubject){
					echo"
					<option value=\"$fid\"{$DF->choose($forumid,$fid,'s')}>$fsubject</option>";
				}
				echo"
				</select></nobr>
				</em></li>
			</ul>
			<ul class=\"svcbar asAS12\">
				<li".($scope == 'weekly'?' class="selected"':'')."><a href=\"{$DF->checkLink('svc.php?svc=modactivity',$linkArr,array('scope'=>'weekly','y'=>'','m'=>'','w'=>''))}\"><em>نشرة اسبوعية</em></a></li>
				<li".($scope == 'monthly'?' class="selected"':'')."><a href=\"{$DF->checkLink('svc.php?svc=modactivity',$linkArr,array('scope'=>'monthly','y'=>'','m'=>'','w'=>''))}\"><em>نشرة شهرية</em></a></li>
				<li".($scope == 'yearly'?' class="selected"':'')."><a href=\"{$DF->checkLink('svc.php?svc=modactivity',$linkArr,array('scope'=>'yearly','y'=>'','m'=>'','w'=>''))}\"><em>نشرة سنوية</em></a></li>
			</ul>
			<ul class=\"svcbar asAS12\">";
				if($scope == 'weekly'){
					echo"
					<li><em class=\"one\"><nobr>اسبوع رقم:
					<select class=\"asGoTo\" onChange=\"DF.goToLink(['w',this.options[this.selectedIndex].value])\">";
					for($x=$xWeek1;$x<=$xWeek2;$x++){
						echo"
						<option value=\"$x\"{$DF->choose($x,$week,'s')}>$x</option>";
					}
					echo"
					</select></nobr>
					</em></li>";
				}
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
				<select class=\"asGoTo\" onChange=\"DF.goToLink(['y',this.options[this.selectedIndex].value,'m','','w',''])\">";
				for($x=$xYear1;$x<=$xYear2;$x++){
					echo"
					<option value=\"$x\"{$DF->choose($x,$year,'s')}>$x</option>";
				}
				echo"
				</select></nobr>
				</em></li>
			</ul>
			<ul class=\"svcbar asAS12\">
				<li><em class=\"one\"><nobr>عدد مشرفين بالصفحة: 
				<select class=\"asGoTo\" onChange=\"DF.goToLink(['u',this.options[this.selectedIndex].value])\">";
				foreach($nUsersArr as $val){
					echo"
					<option value=\"$val\"{$DF->choose($val,$nuser,'s')}>$val</option>";
				}
				echo"
				</select></nobr>
				</em></li>
			</ul>
			</td>
		</tr>
		<tr>
			<td class=\"asHeader\" colspan=\"5\">نشاط مشرفين - <span class=\"asC2\">$scopeTitle</span>".($catid>0 ? " ($cats[$catid])" : "")."</td>
		</tr>";
	if($scope == 'weekly'){
		$scopeName="هذا الاسبوع غير مكتمل";
		$timeWF=$DF->getTimeOfWeek($year,$week);
		$timeWT=$timeWF+(60*60*24*7)-1;
		$dateWF=explode("-",date("Y-m-d-w",$timeWF));
		$dateWT=explode("-",date("Y-m-d-w",$timeWT));
	}
	elseif($scope == 'monthly'){
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
		echo"
		<tr>
			<td class=\"asDarkB\"><nobr>ت</nobr></td>
			<td class=\"asDarkB\"><nobr>الاسم</nobr></td>
			<td class=\"asDarkB\"><nobr>النقاط</nobr></td>
			<td class=\"asDarkB\" colspan=\"2\"><nobr>نسبة النشاط</nobr></td>
		</tr>";
	$sqlWhere="";
	if($forumid>0){
		$sqlWhere=" AND ma.forumid = $forumid";
	}
	if($catid>0){
		$sqlWhere.=" AND ma.catid = $catid";
	}
	else{
		if(ulv < 4){
			$sqlWhere.=" AND ma.catid IN(".implode(",",array_keys($cats)).")";
		}
	}
 	$sql=$mysql->query("SELECT SUM(ma.points) AS points,ma.userid,u.name AS uname,u.status AS ustatus,u.level AS ulevel,u.submonitor AS usubmonitor
	FROM ".prefix."modactivity AS ma
	LEFT JOIN ".prefix."user AS u ON(u.id = ma.userid)
	WHERE ma.date > {$timeWF} AND ma.date < {$timeWT} AND u.level = 2 {$sqlWhere} GROUP BY ma.userid ORDER BY points DESC LIMIT $nuser", __FILE__, __LINE__);
	$max=0;
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		$user=$Template->userColorLink($rs['userid'], array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor']));
		$points=(int)$rs['points'];
		if($count == 0){
			$max=$points;
			$max=(($max>0 ? $max : 1)/100);
		}
		$percent1=round($points/$max,3);
		$percent2=round(100-$percent1,3);
		if($percent1>=75){
			$perImage="styles/globals/pergreen.gif";
		}
		elseif($percent1>=50){
			$perImage="styles/globals/peryellow.gif";
		}
		elseif($percent1>=25){
			$perImage="styles/globals/perorange.gif";
		}
		else{
			$perImage="styles/globals/perred.gif";
		}
		echo"
		<tr>
			<td class=\"asNormalB asCenter\"><nobr>".($count+1)."</nobr></td>
			<td class=\"asNormalB asCenter\"><nobr>$user</nobr></td>
			<td class=\"asNormalB asC5 asCenter\"><nobr>$points</nobr></td>
			<td class=\"asNormalB asC5 asCenter\"><nobr>%$percent1</nobr></td>
			<td class=\"asNormalB asCenter\"><nobr><img src=\"$perImage\" height=\"12\" width=\"$percent1\"><img src=\"{$DFImage->i['survey_light']}\" height=\"12\" width=\"$percent2\"></nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"5\"><br>-- لا توجد أي مشرف نشيط بتاريخ الذي اخترت --<br><br></td>
		</tr>";
	}
		echo"
	</table><br>";
}
else{
	$DF->goTo();
}

// ************ end page ****************
}
else{
	header("HTTP/1.0 404 Not Found");
}
?>