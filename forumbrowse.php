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

if(_df_script == 'svc'&&this_svc == 'forumbrowse'&&ulv > 1){
// ************ start page ****************

$forums=$DF->getAllowForumId();
if(ulv < 4&&!in_array(f,$forums)){
	$DF->goTo();
	exit();
}

if(type == ''){
	$daysAllowed=array(-2,-1,0,7,30);
	$days=(in_array(days,$daysAllowed) ? days : 0);
	if($days == -2){
		$daysTitle="أنشط أيام";
	}
	elseif($days == -1){
		$daysTitle="تصفح يومي";
	}
	elseif($days == 7){
		$daysTitle="آخر اسبوع";
	}
	elseif($days == 30){
		$daysTitle="آخر شهر";
	}
	else{
		$daysTitle="تصفح شهري";
	}
	$ndate=explode("-",date("Y-m-d",gmttime));
	$ndateW=explode("-",date("Y-m-d",gmttime-(60*60*24*7)));
	$ndateM=explode("-",date("Y-m-d",gmttime-(60*60*24*30)));
	echo"
	<table cellspacing=\"1\" cellpadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asTopHeader asCenter\" colspan=\"11\">
			<ul class=\"svcbar asAS12\">
				<li".($days == -2?' class="selected"':'')."><a href=\"svc.php?svc=forumbrowse&f=".f."&days=-2\"><em>أنشط أيام</em></a></li>
				<li".($days == -1?' class="selected"':'')."><a href=\"svc.php?svc=forumbrowse&f=".f."&days=-1\"><em>تصفح يومي</em></a></li>
				<li".($days == 7?' class="selected"':'')."><a href=\"svc.php?svc=forumbrowse&f=".f."&days=7\"><em>آخر اسبوع</em></a></li>
				<li".($days == 30?' class="selected"':'')."><a href=\"svc.php?svc=forumbrowse&f=".f."&days=30\"><em>آخر شهر</em></a></li>
				<li".($days == 0?' class="selected"':'')."><a href=\"svc.php?svc=forumbrowse&f=".f."&days=0\"><em>تصفح شهري</em></a></li>
			</ul>
			</td>
		</tr>
		<tr>
			<td class=\"asHeader asAC2\" colspan=\"5\">$daysTitle - {$Template->forumLink(f)}</td>
		</tr>";
	if($days == -1){
		$time=mktime(0,0,0,$ndate[1],$ndate[2],$ndate[0]);
		$week=date("w",$time);
		echo"
		<tr>
			<td class=\"asHiddenB asS12 asCenter\" colspan=\"5\">{$Template->weekName[$week]} $ndate[2] {$Template->monthName[(int)$ndate[1]]} $ndate[0] بتوقيت GMT</td>
		</tr>";
	}
	elseif($days == 7){
		echo"
		<tr>
			<td class=\"asHiddenB asS12 asCenter\" colspan=\"5\">من $ndateW[2] {$Template->monthName[(int)$ndateW[1]]} $ndateM[0] الى $ndate[2] {$Template->monthName[(int)$ndate[1]]} $ndate[0]</td>
		</tr>";
	}
	elseif($days == 30){
		echo"
		<tr>
			<td class=\"asHiddenB asS12 asCenter\" colspan=\"5\">من $ndateM[2] {$Template->monthName[(int)$ndateM[1]]} $ndateM[0] الى $ndate[2] {$Template->monthName[(int)$ndate[1]]} $ndate[0]</td>
		</tr>";
	}
		echo"
		<tr>";
		if($days == -2||$days == 7||$days == 30){
			echo"
			<td class=\"asDarkB\" colspan=\"2\"><nobr>الشهر</nobr></td>";
		}
		elseif($days == -1){
			echo"
			<td class=\"asDarkB\"><nobr>الساعة</nobr></td>";
		}
		else{
			echo"
			<td class=\"asDarkB\"><nobr>الشهر</nobr></td>";
		}
			echo"
			<td class=\"asDarkB\" colspan=\"".(ulv == 4 ? 3 : 2)."\"><nobr>نسبة التصفح</nobr></td>
		</tr>";
	$sqlFields="";
	$sqlWhere="";
	$sqlGroup="";
	$sqlOrder="";
	if($days == -2){
		$sqlFields="SUM(fb.visit) AS visit,fb.year,fb.month,fb.day";
		$sqlGroup="GROUP BY CONCAT(fb.year,fb.month,fb.day)";
		$sqlOrder="ORDER BY SUM(fb.visit) DESC LIMIT 30";
	}
	elseif($days == -1){
		$sqlFields="SUM(fb.visit) AS visit,fb.hour";
		$sqlWhere="AND fb.year = '$ndate[0]' AND fb.month = '$ndate[1]' AND fb.day = '$ndate[2]'";
		$sqlGroup="GROUP BY fb.hour";
		$sqlOrder="ORDER BY fb.hour DESC";
	}
	elseif($days == 7){
		$sqlFields="SUM(fb.visit) AS visit,fb.year,fb.month,fb.day";
		$sqlGroup="GROUP BY CONCAT(fb.year,fb.month,fb.day)";
		$sqlOrder="ORDER BY fb.year DESC,fb.month DESC,fb.day DESC LIMIT 7";
	}
	elseif($days == 30){
		$sqlFields="SUM(fb.visit) AS visit,fb.year,fb.month,fb.day";
		$sqlGroup="GROUP BY CONCAT(fb.year,fb.month,fb.day)";
		$sqlOrder="ORDER BY fb.year DESC,fb.month DESC,fb.day DESC LIMIT 30";
	}
	else{
		$sqlFields="SUM(fb.visit) AS visit,fb.year,fb.month";
		$sqlGroup="GROUP BY CONCAT(fb.year,fb.month)";
		$sqlOrder="ORDER BY fb.year DESC,fb.month DESC";
	}
	$sql=$mysql->query("SELECT $sqlFields FROM ".prefix."forumbrowse AS fb
	WHERE fb.forumid = ".f." $sqlWhere $sqlGroup $sqlOrder", __FILE__, __LINE__);
	$browsing=array();
	while($rs=$mysql->fetchAssoc($sql)){
		$fb=array('visit'=>$rs['visit']);
		if($days == -2||$days == 7||$days == 30){
			$fb['year']=$rs['year'];
			$fb['month']=$rs['month'];
			$fb['day']=$rs['day'];
		}
		elseif($days == -1){
			$fb['hour']=$rs['hour'];
		}
		else{
			$fb['year']=$rs['year'];
			$fb['month']=$rs['month'];
		}
		$browsing[]=$fb;
	}
	$max=$DF->sort($browsing,array(array('visit','desc')));
	$max=(int)$max[0]['visit'];
	$max=(($max>0 ? $max : 1)/100);
	$count=0;
	foreach($browsing AS $fb){
		$visit=(int)$fb['visit'];
		$percent1=round($visit/$max,3);
		$percent2=round(100-$percent1,3);
		if($days == -2||$days == 7||$days == 30){
			$time=mktime(0,0,0,$fb['month'],$fb['day'],$fb['year']);
			$week=date("w",$time);
			$dayname="<td class=\"asNormalB asCenter\"><nobr>{$Template->weekName[$week]}</nobr></td>";
			$text="{$fb['day']} {$Template->monthName[(int)$fb['month']]} {$fb['year']}";
		}
		elseif($days == -1){
			$text="{$fb['hour']}";
		}
		else{
			$text="{$Template->monthName[(int)$fb['month']]} {$fb['year']}";
		}
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
		<tr>$dayname
			<td class=\"asNormalB asCenter\"><nobr>$text</nobr></td>
			<td class=\"asNormalB asS12 asCenter\"><nobr>%$percent1</nobr></td>";
		if(ulv == 4){
			echo"
			<td class=\"asNormalB asS12 asCenter\"><nobr>$visit</nobr></td>";
		}
			echo"
			<td class=\"asNormalB asCenter\"><nobr><img src=\"$perImage\" height=\"12\" width=\"$percent1\"><img src=\"{$DFImage->i['survey_light']}\" height=\"12\" width=\"$percent2\"></nobr></td>
		</tr>";
		$count++;
	}
 	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"5\"><br>-- لا توجد أي تصفح في توقيت التي اخترت --<br><br></td>
		</tr>";
	}
	echo"
		<tr>
			<td class=\"asBody\" style=\"padding:0px\" colspan=\"5\">
			<table cellSpacing=\"2\" cellPadding=\"3\">
				<tr>
					<td class=\"asTitle\">ملاحظة</td>
					<td class=\"asText2\">الإحصائيات متوفرة فقط من تاريخ 10 أكتوبر 2010</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	</center><br>";
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