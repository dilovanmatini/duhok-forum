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

const _df_script = "rss";
const _df_filename = "rss.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

header("Content-type: text/xml");
echo"
<?xml version=\"1.0\" encoding=\"utf-8\"?><rss version=\"2.0\" xmlns:media=\"http://search.yahoo.com/mrss/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">
<channel>
<title><![CDATA[".forum_title."]]></title>
<link></link>
<description><![CDATA[".forum_title."]]></description>
<language>ar-iq</language>
<lastBuildDate>".date("Y-m-d H:i:s",(time()+(3600*5)))."</lastBuildDate>
<generator>".forum_title."</generator>
<ttl>60</ttl>";

$sql_where = "";
if( f != "" ){	
	$sql_where = "AND f.id = ".f." ";
}
		
$sql=$mysql->query("
SELECT t.id,t.subject,t.status,t.date,t.date ,t.author, tm.message,u.name AS aname
FROM ".prefix."topic AS t
LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
LEFT JOIN ".prefix."topicmessage AS tm ON(tm.id = t.id) 
LEFT JOIN ".prefix."user AS u ON(u.id = t.author)
WHERE t.hidden = 0 AND t.trash = 0 AND t.moderate = 0 AND (f.hidden = 0 AND f.level <= 1) $sql_where
ORDER BY t.date DESC LIMIT 20", __FILE__, __LINE__);
$count=0;
while($rs=$mysql->fetchAssoc($sql)){
	echo"
	<item>
		<title><![CDATA[".$rs['subject']."]]></title>
		<link>topics.php?t=$rs[id]</link>
		<description><![CDATA[".forum_title." - ".$rs['subject']."]]></description>
		<content:encoded><![CDATA[".($rs['message'])."]]></content:encoded>
		<dc:creator><![CDATA[".$rs['aname']."]]></dc:creator>
		<pubDate>".date("D",$rs['date'])." ,".date("d",$rs['date'])." ".date("M",$rs['date'])." ".date("Y",$rs['date'])." ".date("H:i:s",($rs['date']+(3600*5)))." +0000</pubDate>
	</item>";
	$count++;
}

echo"
</channel>
</rss>";
?>