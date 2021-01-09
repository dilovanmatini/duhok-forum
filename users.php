<?php
/***********************************************************\
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

const _df_script = "users";
const _df_filename = "users.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
//************************ Start Page ***************************

if(uhideusers == 1){
	$Template->errMsg("تم منعك من مشاهدة صفحة أعضاء من قبل الإدارة");
}

$search = urldecode(search);
$search = $DF->cleanText($search);
$search = stripslashes($search);

if(!empty($search)){
	$searchSql = "AND u.name REGEXP '^{$search}'";
	$searchLink = "search=".htmlspecialchars($search)."&";
}
else{
	$search = '';
	$searchSql = '';
	$searchLink = '';
}

if(users_sort_type == 'online'&&ulv > 0){
	$menuTitle="الأعضاء في المنتديات حاليا";
	$menuPaging="";
	$pagingLink="";
	$usersSortType='online';
}
elseif(users_sort_type == 'points'){
	$menuTitle="لائحة الشرف - <span class=\"asC2\">ترتيب الأعضاء حسب نقاط التميز</span>";
	$menuPaging=$Template->basicPaging("userflag AS uf LEFT JOIN ".prefix."user AS u ON(u.id = uf.id) WHERE uf.points > 0 AND u.level IN (1,2,3) AND u.status = 1","u.id",true,100);
	$pagingLink="users.php?";
	$usersSortType='points';
}
elseif(users_sort_type == 'posts'||users_sort_type == 'online'&&ulv == 0){
	$menuTitle="قائمة الأعضاء - <span class=\"asC2\">ترتيب الأعضاء حسب عدد مشاركات</span>";
	$menuPaging=$Template->basicPaging("user AS u WHERE u.level IN (1,2,3) AND u.status = 1 {$searchSql}","u.id",true);
	$pagingLink="users.php?{$searchLink}";
	$sortBy="uf.posts ".users_sort_by.",u.date ".users_sort_by."";
	$mainTable="userflag AS uf";
	$binaryTable="user AS u ON(u.id = uf.id)";
	$whereType="u.level IN (1,2,3) AND u.status = 1 {$searchSql}";
	$usersSortType='posts';
}
elseif(users_sort_type == 'name'){
	$menuTitle="قائمة الأعضاء - <span class=\"asC2\">ترتيب الأعضاء حسب اسم العضوية</span>";
	$menuPaging=$Template->basicPaging("user AS u WHERE u.level IN (1,2,3) AND u.status = 1 {$searchSql}","u.id",true);
	$pagingLink="users.php?{$searchLink}";
	if(!empty($search)){
		$sortBy = "binary u.name ASC";
	}
	else{
		$sortBy = "binary u.name ".users_sort_by."";
	}
	$mainTable="user AS u";
	$binaryTable="userflag AS uf ON(uf.id = u.id)";
	$whereType="u.level IN (1,2,3) AND u.status = 1 {$searchSql}";
	$usersSortType='name';
}
elseif(users_sort_type == 'country'){
	$menuTitle="قائمة الأعضاء - <span class=\"asC2\">ترتيب الأعضاء حسب دولة</span>";
	$menuPaging=$Template->basicPaging("user AS u WHERE u.level IN (1,2,3) AND u.status = 1 {$searchSql}","u.id",true);
	$pagingLink="users.php?{$searchLink}";
	$sortBy="uf.country ".users_sort_by.",u.date ".users_sort_by."";
	$mainTable="userflag AS uf";
	$binaryTable="user AS u ON(u.id = uf.id)";
	$whereType="u.level IN (1,2,3) AND u.status = 1 {$searchSql}";
	$usersSortType='country';
}
elseif(users_sort_type == 'lpdate'){
	$menuTitle="قائمة الأعضاء - <span class=\"asC2\">ترتيب الأعضاء حسب آخر مشاركة</span>";
	$menuPaging=$Template->basicPaging("user AS u WHERE u.level IN (1,2,3) AND u.status = 1 {$searchSql}","u.id",true);
	$pagingLink="users.php?{$searchLink}";
	$sortBy="uf.lpdate ".users_sort_by.",u.date ".users_sort_by."";
	$mainTable="userflag AS uf";
	$binaryTable="user AS u ON(u.id = uf.id)";
	$whereType="u.level IN (1,2,3) AND u.status = 1 {$searchSql}";
	$usersSortType='lpdate';
}
elseif(users_sort_type == 'lhdate'){
	$menuTitle="قائمة الأعضاء - <span class=\"asC2\">ترتيب الأعضاء حسب آخر زيارة</span>";
	$menuPaging=$Template->basicPaging("user AS u WHERE u.level IN (1,2,3) AND u.status = 1 {$searchSql}","u.id",true);
	$pagingLink="users.php?{$searchLink}";
	$sortBy="uf.lhdate ".users_sort_by.",u.date ".users_sort_by."";
	$mainTable="userflag AS uf";
	$binaryTable="user AS u ON(u.id = uf.id)";
	$whereType="u.level IN (1,2,3) AND u.status = 1 {$searchSql}";
	$usersSortType='lhdate';
}
elseif(users_sort_type == 'date'){
	$menuTitle="قائمة الأعضاء - <span class=\"asC2\">ترتيب الأعضاء حسب تاريخ التسجيل</span>";
	$menuPaging=$Template->basicPaging("user AS u WHERE u.level IN (1,2,3) AND u.status = 1 {$searchSql}","u.id",true);
	$pagingLink="users.php?{$searchLink}";
	$sortBy="u.date ".users_sort_by."";
	$mainTable="user AS u";
	$binaryTable="userflag AS uf ON(uf.id = u.id)";
	$whereType="u.level IN (1,2,3) AND u.status = 1 {$searchSql}";
	$usersSortType='date';
}
elseif(users_sort_type == 'mods'){
	$menuTitle="قائمة المشرفين";
	$menuPaging=$Template->basicPaging("user AS u WHERE u.level = 2 AND u.submonitor = 0 AND u.status = 1 {$searchSql}","u.id",true);
	$pagingLink="users.php?{$searchLink}";
	$sortBy="uf.posts ".users_sort_by.",u.date ".users_sort_by."";
	$mainTable="user AS u";
	$binaryTable="userflag AS uf ON(uf.id = u.id)";
	$whereType="u.level = 2 AND u.submonitor = 0 AND u.status = 1 {$searchSql}";
	$usersSortType='mods';
}
elseif(users_sort_type == 'submons'){
	$menuTitle = "قائمة نواب المراقبين";
	$menuPaging = $Template->basicPaging("user AS u WHERE u.level = 2 AND u.submonitor = 1 AND u.status = 1 {$searchSql}", "u.id", true);
	$pagingLink = "users.php?{$searchLink}";
	$sortBy = "uf.posts ".users_sort_by.",u.date ".users_sort_by."";
	$mainTable = "user AS u";
	$binaryTable = "userflag AS uf ON(uf.id = u.id)";
	$whereType = "u.level = 2 AND u.submonitor = 1 AND u.status = 1 {$searchSql}";
	$usersSortType = 'submons';
}
elseif(users_sort_type == 'mons'){
	$menuTitle="قائمة المراقبين";
	$menuPaging=$Template->basicPaging("user AS u WHERE u.level = 3 AND u.status = 1 {$searchSql}","u.id",true);
	$pagingLink="users.php?{$searchLink}";
	$sortBy="uf.posts ".users_sort_by.",u.date ".users_sort_by."";
	$mainTable="user AS u";
	$binaryTable="userflag AS uf ON(uf.id = u.id)";
	$whereType="u.level = 3 AND u.status = 1 {$searchSql}";
	$usersSortType='mons';
}
?>
<script type="text/javascript">
var link="<?=$pagingLink?>";
DF.doSearchByName = function(frm){
	if(frm.search.value.trim() == ''){
		alert("يجب عليك ان تكتب على الأقل حرف واحد ليتم البحث عليه");
	}
	else{
		frm.submit();
	}
};
</script>
<?php
echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
	<tr>
		<td class=\"asTopHeader2\">
		<table cellSpacing=\"3\" cellPadding=\"3\">
			<tr>
				<td><img src=\"{$DFImage->h['users']}\" style=\"display:block\" border=\"0\"></td>
				<td width=\"1200\"><a class=\"sec\" href=\"users.php\">الأعضاء</a></td>
				<form method=\"get\" action=\"users.php\">
				<input type=\"hidden\" name=\"type\" value=\"name\">
				<td class=\"asText asCenter asTop\"><nobr>إبحث عن عضو‌‌:<br><input class=\"asTextBox\" type=\"text\" style=\"width:150px\" name=\"search\" value=\"{$search}\">&nbsp;<input class=\"asButton\" type=\"button\" onClick=\"DF.doSearchByName(this.form);\" value=\"إبحث‌\"></nobr></td>
				</form>
				<form method=\"post\" action=\"users.php\">
				<td class=\"asText asCenter asTop\"><nobr>ترتيب حسب:</nobr>
				<select class=\"asGoTo asS12\" style=\"width:130px\" name=\"usersSortType\" onChange=\"submit();\">";
				if( ulv > 0 ){
					echo"
					<option value=\"online\"{$DF->choose($usersSortType,'online','s')}>في المنتديات الآن</option>";
				}
					echo"
					<option value=\"points\"{$DF->choose($usersSortType,'points','s')}>لائحة الشرف</option>
					<option value=\"posts\"{$DF->choose($usersSortType,'posts','s')}>عدد المشاركات</option>
					<option value=\"name\"{$DF->choose($usersSortType,'name','s')}>الاسم</option>
					<option value=\"country\"{$DF->choose($usersSortType,'country','s')}>الدولة</option>
					<option value=\"lpdate\"{$DF->choose($usersSortType,'lpdate','s')}>آخر مشاركة</option>
					<option value=\"lhdate\"{$DF->choose($usersSortType,'lhdate','s')}>آخر زيارة</option>
					<option value=\"date\"{$DF->choose($usersSortType,'date','s')}>تاريخ التسجيل</option>
					<option value=\"mods\"{$DF->choose($usersSortType,'mods','s')}>المشرفين فقط</option>
					<option value=\"submons\"{$DF->choose($usersSortType,'submons','s')}>نواب المراقبين فقط</option>
					<option value=\"mons\"{$DF->choose($usersSortType,'mons','s')}>المراقبين فقط</option>
				</select>
				</td>
				</form>
				<form method=\"post\" action=\"users.php\">
				<td class=\"asText asCenter asTop\"><nobr>ترتيب:</nobr>
				<select class=\"asGoTo asS12\" style=\"width:133px\" name=\"usersSortBy\" onChange=\"submit();\">
					<option value=\"asc\"{$DF->choose(users_sort_by,'asc','s')}>الأصغر للأكبر</option>
					<option value=\"desc\"{$DF->choose(users_sort_by,'desc','s')}>الأكبر للأصغر</option>
				</select>
				</td>
				</form>";
				echo $menuPaging;
				$Template->goToForum();
			echo"
			</tr>
		</table>
		</td>
	</tr>
</table>";

if(users_sort_type == 'online' and ulv > 0){
	$checkSqlWhere = "AND (uo.hidebrowse = 0 OR ".ulv." > 1 AND u.level < 3 OR ".ulv." > 2 AND u.level < 4 OR ".ulv." = 4)";
	$sql = $mysql->query("SELECT u.id,u.name,u.level,uo.hidebrowse,uo.date,uo.ip,u.submonitor
	FROM ".prefix."useronline AS uo
	LEFT JOIN ".prefix."user AS u ON(u.id = uo.userid)
	WHERE uo.level IN (1,2,3,4) {$checkSqlWhere} GROUP BY uo.userid ORDER BY uo.date DESC", __FILE__, __LINE__);
	$usersRows="";
	$usersTr=0;
	$usersCount=0;
	$modsRows="";
	$modsTr=0;
	$modsCount=0;
	$submonsRows="";
	$submonsTr=0;
	$submonsCount=0;
	$monsRows="";
	$monsTr=0;
	$monsCount=0;
	$adminRows="";
	$adminTr=0;
	$adminCount=0;
	$user_name_color = unserialize(user_name_color);
	while($rs = $mysql->fetchRow($sql)){
		$className=($rs[3] == 1 ? 'asFixedDot' : 'asNormalDot');
		if($rs[2] == 4&&ulv == 4){
			if($adminTr == 5){
				$adminRows.="</tr><tr>";
				$adminTr=0;
			}
			$userLink=$Template->userNormalLink($rs[0], $rs[1], $user_name_color[4][1]);
			$rowContent=(ulv == 4 ? "<table cellSpacing=\"0\" cellPadding=\"0\"><tr><td><nobr>$userLink</nobr></td><td><img src=\"{$DF->getCountryByIP(long2ip($rs[5]),'img')}\" width=\"18\" align=\"center\" hspace=\"4\" border=\"0\"></td><td class=\"asS12 asDate\"><nobr>({$DF->date($rs[4])})</nobr></td></tr></table>" : "<nobr>$userLink</nobr>");
 			$adminRows.="
			<td class=\"$className asCenter\" width=\"20%\">$rowContent</td>";
			$adminTr++;
			$adminCount++;
		}
		elseif($rs[2] == 3){
			if($monsTr == 5){
				$monsRows.="</tr><tr>";
				$monsTr=0;
			}
			$userLink=$Template->userNormalLink($rs[0], $rs[1], $user_name_color[3][1]);
			$rowContent=(ulv == 4 ? "<table cellSpacing=\"0\" cellPadding=\"0\"><tr><td><nobr>$userLink</nobr></td><td><img src=\"{$DF->getCountryByIP(long2ip($rs[5]),'img')}\" width=\"18\" align=\"center\" hspace=\"4\" border=\"0\"></td><td class=\"asS12 asDate\"><nobr>({$DF->date($rs[4])})</nobr></td></tr></table>" : "<nobr>$userLink</nobr>");
 			$monsRows.="
			<td class=\"$className asCenter\" width=\"20%\">$rowContent</td>";
			$monsTr++;
			$monsCount++;
		}
		elseif($rs[2] == 2 and $rs[6] == 1){
			if($submonsTr == 5){
				$submonsRows.="</tr><tr>";
				$submonsTr=0;
			}
			$userLink = $Template->userNormalLink($rs[0], $rs[1], $user_name_color[2][1]);
			$rowContent=(ulv == 4 ? "<table cellSpacing=\"0\" cellPadding=\"0\"><tr><td><nobr>$userLink</nobr></td><td><img src=\"{$DF->getCountryByIP(long2ip($rs[5]),'img')}\" width=\"18\" align=\"center\" hspace=\"4\" border=\"0\"></td><td class=\"asS12 asDate\"><nobr>({$DF->date($rs[4])})</nobr></td></tr></table>" : "<nobr>$userLink</nobr>");
 			$submonsRows.="
			<td class=\"$className asCenter\" width=\"20%\">$rowContent</td>";
			$submonsTr++;
			$submonsCount++;
		}
		elseif($rs[2] == 2 and $rs[6] == 0){
			if($modsTr == 5){
				$modsRows.="</tr><tr>";
				$modsTr=0;
			}
			$userLink=$Template->userNormalLink($rs[0], $rs[1], $user_name_color[2][0]);
			$rowContent=(ulv == 4 ? "<table cellSpacing=\"0\" cellPadding=\"0\"><tr><td><nobr>$userLink</nobr></td><td><img src=\"{$DF->getCountryByIP(long2ip($rs[5]),'img')}\" width=\"18\" align=\"center\" hspace=\"4\" border=\"0\"></td><td class=\"asS12 asDate\"><nobr>({$DF->date($rs[4])})</nobr></td></tr></table>" : "<nobr>$userLink</nobr>");
			$modsRows.="
			<td class=\"$className asCenter\" width=\"20%\">$rowContent</td>";
			$modsTr++;
			$modsCount++;
		}
		elseif($rs[2] == 1){
			if($usersTr == 5){
				$usersRows.="</tr><tr>";
				$usersTr=0;
			}
			$userLink=$Template->userNormalLink($rs[0], $rs[1], $user_name_color[1][1]);
			$rowContent=(ulv == 4 ? "<table cellSpacing=\"0\" cellPadding=\"0\"><tr><td><nobr>$userLink</nobr></td><td><img src=\"{$DF->getCountryByIP(long2ip($rs[5]),'img')}\" width=\"18\" align=\"center\" hspace=\"4\" border=\"0\"></td><td class=\"asS12 asDate\"><nobr>({$DF->date($rs[4])})</nobr></td></tr></table>" : "<nobr>$userLink</nobr>");
			$usersRows.="
			<td class=\"$className asCenter\" width=\"20%\">$rowContent</td>";
			$usersTr++;
			$usersCount++;
		}
	}
	if(ulv == 4){
		$sql=$mysql->query("SELECT ip,date FROM ".prefix."visitors ORDER BY date DESC", __FILE__, __LINE__);
		$visitorRows="";
		$visitorTr=0;
		$visitorCount=0;
		while($rs=$mysql->fetchRow($sql)){
			if($visitorTr == 5){
				$visitorRows.="</tr><tr>";
				$visitorTr=0;
			}
			$ip=long2ip($rs[0]);
 			$visitorRows.="
			<td class=\"asNormalDot asCenter\" width=\"20%\"><table cellSpacing=\"0\" cellPadding=\"0\"><tr><td><a href=\"https://whatismyipaddress.com/ip/$ip\">$ip</a></td><td><img src=\"{$DF->getCountryByIP($ip,'img')}\" width=\"18\" align=\"center\" hspace=\"4\" border=\"0\"></td><td class=\"asS12 asDate\"><nobr>({$DF->date($rs[1])})</nobr></td></tr></table></td>";
			$visitorTr++;
			$visitorCount++;
		}
	}
	echo"
	<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"4\">
 		<tr>
			<td class=\"asHeader\">{$menuTitle}</td>
		</tr>";
	if(ulv == 4){
		echo"
 		<tr>
			<td class=\"asDark\">المدراء ({$adminCount})</td>
		</tr>
		<tr>
			<td class=\"asBody\">
			<table width=\"100%\" cellspacing=\"2\" cellpadding=\"4\" border=\"0\">
				<tr>
				$adminRows";
				if($adminCount == 0){
					echo"
					<td class=\"asCenter asC1\" colSpan=\"5\"><nobr><br>لا توجد أي مدير موجود حالياً<br><br></nobr></td>";
				}
				if($adminTr<5&&$adminCount!=0){
					echo"
					<td></td>";
				}
				echo"
				</tr>
			</table>
			</td>
		</tr>";
	}
		echo"
 		<tr>
			<td class=\"asDark\">المراقبون ({$monsCount})</td>
		</tr>
		<tr>
			<td class=\"asBody\">
			<table width=\"100%\" cellspacing=\"2\" cellpadding=\"4\" border=\"0\">
				<tr>
				$monsRows";
				if($monsCount == 0){
					echo"
					<td class=\"asCenter asC1\" colSpan=\"5\"><nobr><br>يمكن لا توجد أي مراقب موجود حالياً أو تصفحهم مخفي للآخرين<br><br></nobr></td>";
				}
				if($monsTr<5&&$monsCount!=0){
					echo"
					<td></td>";
				}
				echo"
				</tr>
			</table>
			</td>
		</tr>
 		<tr>
			<td class=\"asDark\">نواب المراقبون ({$submonsCount})</td>
		</tr>
		<tr>
			<td class=\"asBody\">
			<table width=\"100%\" cellspacing=\"2\" cellpadding=\"4\" border=\"0\">
				<tr>
				{$submonsRows}";
				if($submonsCount == 0){
					echo"
					<td class=\"asCenter asC1\" colSpan=\"5\"><nobr><br>يمكن لا توجد أي نائب مراقب موجود حالياً أو تصفحهم مخفي للآخرين<br><br></nobr></td>";
				}
				if($submonsTr < 5 && $submonsCount != 0){
					echo"
					<td></td>";
				}
				echo"
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td class=\"asDark\" colSpan=\"5\">المشرفون ({$modsCount})</td>
		</tr>
		<tr>
			<td class=\"asBody\">
			<table width=\"100%\" cellspacing=\"2\" cellpadding=\"4\" border=\"0\">
				<tr>
				$modsRows";
				if($modsCount == 0){
					echo"
					<td class=\"asCenter asC1\" colSpan=\"5\"><nobr>يمكن لا توجد أي مشرف موجود حالياً أو تصفحهم مخفي للآخرين</nobr></td>";
				}
				if($modsTr<5&&$modsCount!=0){
					echo"
					<td></td>";
				}
				echo"
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td class=\"asDark\">الأعضاء ({$usersCount})</td>
		</tr>
		<tr>
			<td class=\"asBody\">
			<table width=\"100%\" cellspacing=\"2\" cellpadding=\"4\" border=\"0\">
				<tr>
				$usersRows";
				if($usersCount == 0){
					echo"
					<td class=\"asCenter asC1\" colSpan=\"5\"><nobr>يمكن لا توجد أي عضو موجود حالياً أو تصفحهم مخفي للآخرين</nobr></td>";
				}
				if($usersTr<5&&$usersCount!=0){
					echo"
					<td></td>";
				}
				echo"
				</tr>
			</table>
			</td>
		</tr>";
	if(ulv == 4){
		echo"
		<tr>
			<td class=\"asDark\">الزوار ({$visitorCount})</td>
		</tr>
		<tr>
			<td class=\"asBody\">
			<table width=\"100%\" cellspacing=\"2\" cellpadding=\"4\" border=\"0\">
				<tr>
				$visitorRows";
				if($visitorCount == 0){
					echo"
					<td class=\"asCenter asC1\" colSpan=\"5\"><nobr>لا توجد أي زوار موجود حالياً</nobr></td>";
				}
				if($visitorTr<5&&$visitorCount!=0){
					echo"
					<td></td>";
				}
				echo"
				</tr>
			</table>
			</td>
		</tr>";
	}
	if(ulv > 1){
		echo"
		<tr>
			<td class=\"asBody\">
			<table cellSpacing=\"2\" cellPadding=\"3\">
				<tr>
					<td class=\"asTitle\">ملاحظة</td>
					<td class=\"asText2\">الأعضاء الذي تصفحهم مخفي للأعضاء يظهر بلون</td>
					<td class=\"asFixedDot\"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></td>";
				if(ulv == 4){
					echo"
					<td class=\"asText2\">تاريخ الذي بجانب اسم العضوية هو تاريخ آخر زيارة للعضوية</td>";
				}					
				echo"
				</tr>
			</table>
			</td>
		</tr>";
	}
	echo"
	</table>";
}
elseif(users_sort_type == 'points'){
	echo"<br>
	<table width=\"30%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\">
		<tr>
			<td class=\"asHeader\" colspan=\"3\">$menuTitle</td>
		</tr>
		<tr>
			<td class=\"asDarkB\"><b>الرقم</b></td>
			<td class=\"asDarkB\"><b>اسم العضوية</b></td>
			<td class=\"asDarkB\"><b>النقاط</b></td>
		</tr>";
	$sql=$mysql->query("SELECT u.id,u.name,uf.points
	FROM ".prefix."userflag AS uf
	LEFT JOIN ".prefix."user AS u ON(u.id = uf.id)
	WHERE uf.points > 0 AND u.level IN (1,2,3) AND u.status = 1 GROUP BY u.id ORDER BY uf.points DESC LIMIT {$DF->pgLimit(100)},100", __FILE__, __LINE__);
	$count=0;
	$numaric=$pgLimit+1;
	while($rs=$mysql->fetchRow($sql)){
		if($numaric<6){
			$className="asFixedB";
		}
		elseif($numaric<11){
			$className="asHiddenB";
		}
		else{
			$className="asNormalB";
		}
		echo"
		<tr>
			<td class=\"$className asCenter\">$numaric</td>
			<td class=\"$className\">{$Template->userNormalLink($rs[0],$rs[1])}</td>
			<td class=\"$className asCenter\">$rs[2]</td>
		</tr>";
		$numaric++;
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"3\"><br>لا توجد أي عضو في هذه اللائحة<br><br></td>
		</tr>";
	}
	echo"
	</table>";
}
elseif(
	users_sort_type == 'posts' or users_sort_type == 'name' or users_sort_type == 'country' or users_sort_type == 'lpdate' or
	users_sort_type == 'lhdate' or users_sort_type == 'date' or users_sort_type == 'mods' or users_sort_type == 'submons' or
	users_sort_type == 'mons' or users_sort_type == 'online' and ulv == 0
){

	require_once _df_path."countries.php";
	echo"
	<table class=\"border\" width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
		<tr>
			<td class=\"asHeader\">$menuTitle</td>
		</tr>
		<tr>
			<td class=\"asBody\">
			<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"4\">
				<tr>
					<td class=\"asDark\">الرقم</td>
					<td class=\"asDark\"><nobr>اسم العضوية</nobr></td>
					<td class=\"asDark\">الدولة</td>
					<td class=\"asDark\">النقاط</td>
					<td class=\"asDark\">المشاركات</td>
					<td class=\"asDark\"><nobr>آخر مشاركة</nobr></td>
					<td class=\"asDark\"><nobr>آخر زيارة</nobr></td>
					<td class=\"asDark\"><nobr>تاريخ التسجيل</nobr></td>
				</tr>";
	$sql=$mysql->query("SELECT u.id,u.name,u.level,u.submonitor,uf.title,uf.sex,uf.country,uf.points,uf.posts,uf.lpdate,uf.picture,
		uf.lhdate,uf.oldlevel,u.date,IF(NOT ISNULL(uo.userid),1,0) AS isonline,
		IF(up.hidebrowse = 0 OR ".ulv." > 1 AND u.level < 3 OR ".ulv." > 2 AND u.level < 4 OR ".ulv." = 4,1,0) AS showbrowse
	FROM ".prefix."$mainTable
	LEFT JOIN ".prefix."$binaryTable
	LEFT JOIN ".prefix."userperm AS up ON(up.id = u.id)
	LEFT JOIN ".prefix."useronline AS uo ON(uo.userid = u.id AND (up.hidebrowse = 0 OR ".ulv." > 1 AND u.level < 3 OR ".ulv." > 2 AND u.level < 4 OR ".ulv." = 4))
	WHERE $whereType GROUP BY u.id ORDER BY $sortBy LIMIT {$DF->pgLimit(num_pages)},".num_pages, __FILE__, __LINE__);
	$count=0;
	while($rs=$mysql->fetchAssoc($sql)){
		$className=($count%2?"asFixed":"asNormal");
		if( ulv > 0 ){
			$isOnline=($rs['isonline'] == 1 ? "<br><img src=\"{$DFImage->i['online']}\" alt=\"متصل الآن\" border=\"0\">" : "");
		}
		$userTitle = $DF->userTitle($rs['id'], $rs['posts'], $rs['level'], $rs['title'], $rs['sex'], $rs['oldlevel'], $rs['submonitor']);
		$userStars = $DF->userStars($rs['posts'], $rs['level'], $rs['submonitor']);
		$countryName = ($cname = $country["{$rs['country']}"]['name']) ? $cname : '--';
		$dateType = (ulv > 1) ? '' : 'date';
		$lpdate = ($rs['lpdate'] > 0) ? $DF->date($rs['lpdate'], $dateType) : '--';
		$lhdate = ($rs['showbrowse'] == 1 and $rs['lhdate'] > 0) ? $DF->date($rs['lhdate'], $dateType) : '--';
		$date = ($rs['date'] > 0) ? $DF->date($rs['date'], $dateType) : '--';
		echo"
		<tr>
			<td class=\"$className asS12 asCenter\"><nobr><img src=\"{$DFPhotos->getsrc($rs['picture'], 48)}\"{$DF->picError(32)} width=\"32\" height=\"32\" border=\"0\">{$isOnline}</nobr></td>
			<td class=\"$className\"><nobr>{$Template->userNormalLink($rs['id'],$rs['name'])}<br><span class=\"asS12 asC3\">$userTitle</span></nobr></td>
			<td class=\"$className asS12 asCenter\">$countryName</td>
			<td class=\"$className asS12 asCenter\">{$rs['points']}</td>
			<td class=\"$className asS12 asCenter\">{$rs['posts']}<br>$userStars</td>
			<td class=\"$className asS12 asDate asCenter\"><nobr>$lpdate</nobr></td>
			<td class=\"$className asS12 asDate asCenter\"><nobr>$lhdate</nobr></td>
			<td class=\"$className asS12 asDate asCenter\"><nobr>$date</nobr></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		if($search == ''){
			$not_found_text = 'لا توجد أي عضوية';
		}
		else{
			$not_found_text = 'لم يتم إيجاد أية عضوية مطابقة لإسم الذي تبحث عنه';
		}
		echo"
		<tr>
			<td class=\"asNormal asCenter\" colspan=\"8\"><br>{$not_found_text}<br><br></td>
		</tr>";
	}
	echo"
	</table>
	</td>
	</tr>
	</table>";
}
else{
	$DF->goTo();
}

//************************  End Page  ****************************
$Template->footer();
?>