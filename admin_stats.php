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

const _df_script = "admin_stats";
const _df_filename = "admin_stats.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
if(ulv == 4){
//*********** start page ****************************************

if(type == ""){
echo'
	
	<table class="border" width="80%" cellSpacing="1" cellPadding="4" align="center" border="0">
		<tr>
			<td class="menuOptions" colSpan="7">خيارات ادارية</td>
		</tr>
			<form method="post" action="admin_stats.php?type=show">
			<input name="step" value="forums" type="hidden">

			<tr>
			<td class="asFixedB"><nobr><b>إحصائيات منتدى معين :</b></nobr></td>
			<td class="asNormalB">رقم المنتدى :&nbsp;&nbsp;<input type="text" name="frm" size="7">&nbsp;&nbsp;</td>
			<td class="asNormalB">النوع : 
			<select name="type">
			<option value="posts">الردود</option>
			</select>
			</td>
			<td class="asNormalB">عدد النتائج :
			<select name="max">
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="40">40</option>
			<option value="50">50</option>
			<option value="60">60</option>
			<option value="70">70</option>
			<option value="80">80</option>
			<option value="90">90</option>
			<option value="100">100</option>
			<option value="125">125</option>
			<option value="150">150</option>
			<option value="175">175</option>
			<option value="200">200</option>
			</select>&nbsp;&nbsp;</td>
			<td class="asNormalB">الإحصائيات :
			<select name="time">
			<option value="day">يومية</option>
			<option value="week">أسبوعية</option>
			<option value="mounth">شهرية</option>
			<option value="year">سنوية</option>
			</select>&nbsp;&nbsp;</td>
			<td class="asNormalB">
			<input class="button" type="submit" value="إظهار الإحصائيات"></td>
		</tr>
				</form>

				
				
			<form method="post" action="admin_stats.php?type=show">
			<input name="step" value="all" type="hidden">
			<tr>
			<td class="asFixedB" colSpan="2"><nobr><b>إحصائيات المنتدى بأسره :</b></nobr></td>
			<td class="asNormalB">النوع : 
			<select name="type">
			<option value="posts">الردود</option>
			</select>
			</td>
			<td class="asNormalB">عدد النتائج :
			<select name="max">
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="40">40</option>
			<option value="50">50</option>
			<option value="60">60</option>
			<option value="70">70</option>
			<option value="80">80</option>
			<option value="90">90</option>
			<option value="100">100</option>
			<option value="125">125</option>
			<option value="150">150</option>
			<option value="175">175</option>
			<option value="200">200</option>
			</select>&nbsp;&nbsp;</td>
			<td class="asNormalB">الإحصائيات :
			<select name="time">
			<option value="day">يومية</option>
			<option value="week">أسبوعية</option>
			<option value="mounth">شهرية</option>
			<option value="year">سنوية</option>
			</select>&nbsp;&nbsp;</td>
			<td class="asNormalB">
			<input class="button" type="submit" value="إظهار الإحصائيات"></td>
		</tr>
				</form>

		</table>';

}
elseif(type == "show"){
	$step=$_POST['step'];
	$frm= intval($_POST['frm']);
	$types=$_POST['type'];
	$max=$_POST['max'];
	$time=$_POST['time'];

	if($time == "day"){
	$thetime = time()." - ".(60 * 60 * 24);
	$add_title = "اليومية";
	}elseif($time == "week"){
	$thetime = time()." - ".(60 * 60 * 24 * 7);
	$add_title = "الأسبوعية";
	}elseif($time == "mounth"){
	$thetime = time()." - ".(60 * 60 * 24 * 30);
	$add_title = "الشهرية";
	}elseif($time == "year"){
	$thetime = time()." - ".(60 * 60 * 24 * 356);
	$add_title = "السنوية";
	}
	
	
	if($step == "forums"){
	if($frm <= 0){
	$Template->errMsg("يجب أن تدخل رقما صحيحا للمنتدى");
	}
	$title_first = "إحصائيات المنتدى رقم : $frm";	
	if($types == "posts"){
	$type_show = "الردود";
	$sql =$mysql->query("SELECT COUNT(post.id) AS counts, member.name,member.id FROM ".prefix."user AS member LEFT JOIN ".prefix."post  AS post ON (post.author = member.id)  WHERE post.forumid = '".$frm."'  and  post.date > $thetime  GROUP BY post.author ORDER BY counts DESC LIMIT $max", __FILE__, __LINE__);	
	}elseif($types == "topics"){
	$type_show = "المواضيع";
	$sql =$mysql->query("SELECT COUNT(post.id) AS counts, member.name,member.id FROM ".prefix."user AS member LEFT JOIN ".prefix."topicusers   AS post ON (post.userid  = member.id)  WHERE post.forumid = '".$frm."'  and  post.adddate > $thetime  GROUP BY post.userid ORDER BY counts DESC LIMIT $max", __FILE__, __LINE__);	
	}
	}
	
	
		if($step == "all"){
	$title_first = "إحصائيات المنتدى";	
	$type_show = "الردود";
	$sql =$mysql->query("SELECT COUNT(post.id) AS counts, member.name,member.id FROM ".prefix."user AS member LEFT JOIN ".prefix."post  AS post ON (post.author = member.id)  WHERE  post.date > $thetime  GROUP BY post.author ORDER BY counts DESC LIMIT $max", __FILE__, __LINE__);	

		}
	
	echo"
	<input type=\"hidden\" name=\"type\">
	<table id=\"myTable\" width=\"40%\" cellpadding=\"4\" cellspacing=\"2\" align=\"center\" border=\"0\">
		<tr>
			<td class=\"asHeader\" colspan=\"7\">$title_first - ($add_title) - <font color=\"red\">$type_show</td>
		</tr>
		<tr>
			<td class=\"asDarkB\" width=\"10%\" ><nobr>&nbsp;</nobr></td>
			<td class=\"asDarkB\"><nobr><b>اسم العضوية</b></nobr></td>
			<td class=\"asDarkB\" width=\"10%\" ><nobr><b>المشاركات</b></nobr></td>
		</tr>";
	$i=1;					
	while($r = $mysql->fetchArray($sql)){
		echo"
		<tr>
			<td class=\"asNormalB\">".$i."</td>
			<td class=\"asNormalB\" align=\"center\">".$r['name']."</td>
			<td class=\"asNormalB\">".$r['counts']."</td>
		</tr>";
		$i++;
	}
		echo"
		</tr>
	</table>";
}

//*********** end page ****************************************
}
else{
	$DF->goTo();
}
$Template->footer();
?>