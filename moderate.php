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

if(!defined('_df_script') or _df_script != 'svc' or this_svc != 'moderate' or ulv < 2){
	header("location: errorpages.php?e=404");
	exit();
}
if(type == ""){
	?>
	<script type="text/javascript">
	DF.moderate = {
		load: function(arr){
			if($T(arr) == 'array' && arr.length > 0){
				for(var x = 0; x < arr.length; x++){
					this.ajax(arr[x]);
				}
			}
		},
		ajax: function(f){
			$.ajax({
				type: 'POST',
				url: 'ajax.php?x='+Math.random(),
				data: 'type=getModerateContetns&id='+f,
				success: function(res){
					if(res != '' && res.indexOf('e') == -1){
						DF.moderate.set(f, res);
					}
				}
			});
		},
		set: function(f, res){
			var row = $I('#moRow'+f), arr = res.split('|'), cell,
			links = new Array(
				'forums.php?f='+f+'&option=mo',
				'forums.php?f='+f+'&option=ho',
				'forums.php?f='+f+'&option=rmo',
				'forums.php?f='+f+'&option=rho',
				'pm.php?mail=new&f=-'+f
			);
			if(row){
				row.deleteCell(1);
				for(var x = 0; x < arr.length; x++){
					cell = row.insertCell(x + 1);
					cell.className = (arr[x] > 0 ? 'asFirstB' : 'asNormalB')+' asCenter';
					cell.innerHTML = (arr[x] > 0) ? "<a href=\""+links[x]+"\"><b>"+arr[x]+"</b></a>" : "0";
				}
			}
		}
	};
	</script>
	<?php
	echo"
	<table cellspacing=\"1\" cellpadding=\"5\" align=\"center\">
		<tr>
			<td class=\"asHeader\" colspan=\"6\">إشرافك</td>
		</tr>
		<tr>
			<td class=\"asHiddenB asS12 asCenter\" colspan=\"6\">ملاحظة: لتصفح أي خيار إضغط على رقم الخيار</td>
		</tr>
		<tr>
			<td class=\"asDarkB\">المنتدى</td>
			<td class=\"asDarkB\">مواضيع تنتظر الموافقة</td>
			<td class=\"asDarkB\">مواضيع مجمدة</td>
			<td class=\"asDarkB\">ردود تنتظر الموافقة</td>
			<td class=\"asDarkB\">ردود مجمدة</td>
			<td class=\"asDarkB\">رسائل إشرافية جديدة</td>
		</tr>";
	$checkSqlTable = "";
	$checkSqlWhere = "";
	if(ulv < 4){
		$checkSqlWhere = " AND (
			(".ulv." > 1 AND NOT ISNULL(m.id)) OR
			(".submonitor." = 1 AND c.submonitor = ".uid.") OR
			(".ulv." = 3 AND c.monitor = ".uid.")
		)";
		$checkSqlTable = "LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")";
	}
	$sql = $mysql->query("SELECT f.id, f.subject
	FROM ".prefix."forum AS f {$checkSqlTable}
	LEFT JOIN ".prefix."category AS c ON(c.id = f.catid)
	WHERE 1 = 1 {$checkSqlWhere} GROUP BY f.id ORDER BY c.sort, f.sort", __FILE__, __LINE__);
	$count = 0;
	$forums_id = array();
	$ajaxLoad = "";
	while($rs = $mysql->fetchRow($sql)){
		$f = $rs[0];
		$forums_id[] = $f;
		echo"
		<tr id=\"moRow{$f}\">
			<td class=\"asHiddenB\"><nobr>{$Template->forumLink($f,$rs[1])}</nobr></td>
			<td class=\"asNormalB asCenter\" colspan=\"5\"><img src=\"{$DFImage->i['loading3']}\" border=\"0\"></td>
		</tr>";
		$count++;
	}
	if($count == 0){
		echo"
		<tr>
			<td class=\"asNormalB asCenter\" colspan=\"6\"><br>لا توجد أي منتدى تحت إشرافك<br><br></td>
		</td>";
	}
	echo"
	</table><br>";
	?>
	<script type="text/javascript">
	$(function(){
		DF.moderate.load([<?=implode(",", $forums_id)?>]);
	});
	</script>
	<?php
}
?>