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

const _df_script = "search";
const _df_filename = "search.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();

echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
	<tr>
		<td class=\"asTopHeader\">
			<table cellSpacing=\"3\" cellPadding=\"3\">
				<tr>
					<td><img src=\"{$DFImage->h['search']}\" border=\"0\"></td>
					<td width=\"1200\"><a class=\"sec\" href=\"search.php.php\">محرك البحث</a></td>";
					$Template->goToForum();
				echo"
				</tr>
			</table>
		</td>
	</tr>
</table>";

$forum_id = isset($_GET['forum_id'])  ? intval($_GET['forum_id']) : '';
$search_text = isset($_GET['search_text']) ? $DF->cleanText($_GET['search_text']) : '';
$search_in = isset($_GET['search_in']) ? $DF->cleanText($_GET['search_in']) : 'title';

echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
	<tr>
		<td class=\"asHeader\">محرك البحث</td>
	</tr>
	<tr>
		<td class=\"asBody\">
			<form method=\"get\" action=\"search.php\">
				<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\">
					<tr>
						<td class=\"asFixedB\">نص الذي تبحث عنه</td>
						<td class=\"asNormalB\"><input type=\"text\" name=\"search_text\" style=\"width:600px\" value=\"{$search_text}\"></td>
					</tr>
					<tr>
						<td class=\"asFixedB\">بحث في</td>
						<td class=\"asNormalB\">
							<input type=\"radio\" name=\"search_in\" value=\"title\" {$DF->choose( 'title', $search_in, 'c' )}>&nbsp;عنوان الموضوع&nbsp;&nbsp;&nbsp;&nbsp;
							<input type=\"radio\" name=\"search_in\" value=\"message\" {$DF->choose( 'message', $search_in, 'c' )}>&nbsp;محتوي الموضوع
						</td>
					</tr>
					<tr>
						<td class=\"asFixedB\">في منتدى</td>
						<td class=\"asNormalB\">
							<select name=\"forum_id\">
								<option value=\"0\">-- جميع منتديات --</option>";
							foreach( $Template->forumsList as $f => $subject ){
								echo"
								<option value=\"{$f}\" {$DF->choose( $f, $forum_id, 's' )}>$subject</option>";
							}	
							echo"
							</select>
						</td>
					</tr>
					<tr>
						<td class=\"asNormalB asCenter\" colspan=\"2\">{$Template->button( "إبحث", " tabindex=\"3\" onClick=\"this.form.submit();\"" )}</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td class=\"asHeader\">نتائج البحث عن: <span class=\"asC2\">{$search_text}</span></td>
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
			if( !empty($search_text) ){

				$sql_fields = "";
				$sql_join = "";
				$sql_where = "";
				$sql_params = [];

				if( $search_in == 'title' ){
					$sql_where .= " AND t.subject LIKE :text";
				}
				else{
					$sql_where .= " AND tm.message LIKE :text";
				}
				$sql_params['text'] = "%{$search_text}%";

				if( $forum_id > 0 ){
					$sql_where .= " AND f.id = :forum_id";
					$sql_params['forum_id'] = $forum_id;
				}

				if( ulv < 4 ){
					$sql_fields .= ", IF( m.id IS NULL, 0, 1 ) AS ismod";
					$sql_join .= "
					LEFT JOIN ".prefix."moderator AS m ON( m.forumid = f.id AND m.userid = ".uid." )
					LEFT JOIN ".prefix."forumusers AS fu ON( fu.forumid = f.id AND fu.userid = ".uid." )";

					if( ulv == 3 ){
						$sql_fields .= ", IF( c.id IS NULL, 0, 1 ) AS ismon";
						$sql_join .= "
						LEFT JOIN ".prefix."category AS c ON( c.id = f.catid AND c.monitor = ".uid." )";
					}
					$sql_where .= " AND ( f.hidden = 0 AND f.level <= ".ulv." OR fu.id IS NOT NULL )";
				}
				else{
					$sql_fields .= ",
					IF( t.id IS NULL, 0, 1 ) AS ismod,
					IF( t.id IS NULL, 0, 1 ) AS ismon";
				}
					
				$sql = $mysql->execute("
				SELECT t.id, t.subject, t.status, t.author, t.lpauthor, t.posts, t.views, t.lpdate, t.date,
					f.id AS forumid, f.subject AS fsubject, u.name AS aname, u.status AS astatus, u.level AS alevel,
					u.submonitor AS asubmonitor, uu.name AS lpname, uu.status AS lpstatus, uu.level AS lplevel,
					uu.submonitor AS lpsubmonitor,
					IF(
						t.moderate = 1, '{$DFImage->f['moderate']}|موضوع تنتظر الموافقة',
						IF(
							t.moderate = 2, '{$DFImage->f['held']}|موضوع مجمد',
							IF(
								t.trash = 1, '{$DFImage->f['delete']}|موضوع محذوف',
								IF(
									t.status = 0, '{$DFImage->f['lock']}|موضوع مقفل','{$DFImage->f['folder']}|موضوع مفتوح'
								)
							)
						)
					) AS topicfolder {$sql_fields}
				FROM ".prefix."topic AS t
				LEFT JOIN ".prefix."forum AS f ON( f.id = t.forumid )
				LEFT JOIN ".prefix."topicmessage AS tm ON( tm.id = t.id )
				LEFT JOIN ".prefix."user AS u ON( u.id = t.author )
				LEFT JOIN ".prefix."user AS uu ON( uu.id = t.lpauthor ) {$sql_join}
				WHERE t.hidden = 0 AND t.trash = 0 AND t.moderate = 0 {$sql_where}
				ORDER BY t.lpdate DESC
				LIMIT 50", $sql_params, __FILE__, __LINE__);
				$count = 0;
				while( $rs = $sql->fetch() ){
					$topicFolder = explode("|",$rs['topicfolder']);
					$author = $Template->userColorLink( $rs['author'], [ $rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor'] ] );
					$lpauthor = $Template->userColorLink( $rs['lpauthor'], [ $rs['lpname'], $rs['lpstatus'], $rs['lplevel'], $rs['lpsubmonitor'] ] );
					echo"
					<tr>
						<td class=\"asNormal asAS12 asCenter\">{$Template->forumLink( $rs['forumid'], $rs['fsubject'] )}</td>
						<td class=\"asNormal asCenter\"><img src=\"{$topicFolder[0]}\" alt=\"{$topicFolder[1]}\" border=\"0\"></td>
						<td class=\"asNormal\">
							<table cellPadding=\"0\" cellsapcing=\"0\">
								<tr>
									<td>{$Template->topicLink( $rs['id'], $rs['subject'] )}".( $rs['posts'] > 0 ? $Template->topicPaging( $rs['id'], $rs['posts'] ):"" )."</td>
								</tr>
							</table>
						</td>
						<td class=\"asNormal asS12 asAS12 asDate asCenter\">{$DF->date($rs['date'])}<br>$author</td>
						<td class=\"asNormal asS12 asCenter\">{$rs['posts']}</td>
						<td class=\"asNormal asS12 asCenter\">{$rs['views']}</td>
						<td class=\"asNormal asS12 asAS12 asDate asCenter\">";
						if( $rs['posts'] > 0 ){
							echo "{$DF->date($rs['lpdate'])}<br>$lpauthor";
						}
						else{
							echo"&nbsp;";
						}
						echo"</td>";
					if( ulv > 0 ){
						echo"
						<td class=\"asNormal asCenter\">";
						if( $rs['status'] == 1 || $rs['ismod'] == 1 || $rs['ismon'] == 1 ){
							echo"<a href=\"editor.php?type=newpost&t={$rs['id']}&src=".urlencode(self)."\"><img src=\"{$DFImage->i['reply']}\" alt=\"رد على الموضوع\" hspace=\"2\" border=\"0\"></a>";
						}
						echo"</td>";
					}
					echo"
					</tr>";
					$count++;
				}
				if( $count == 0 ){
					echo"
					<tr>
						<td class=\"asNormal asCenter\" colspan=\"20\"><br>لا توجد أي نتيجة.<br><br></td>
					</tr>";
				}
			}
			else{
				echo"
				<tr>
					<td class=\"asNormal asCenter\" colspan=\"20\"><br>يجب عليك كتابة نص المراد بحث عنه.<br><br></td>
				</tr>";
			}
			echo"
			</table>
		</td>
	</tr>
</table>";
$Template->footer();
?>