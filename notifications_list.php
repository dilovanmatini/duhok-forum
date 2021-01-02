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

$notify_types = array(
	'acf' => array(
		'title' => 'وافقت على طلبك الصداقة معه',
		'url' 	=> 'profile.php?u={2}',
		'icon' 	=> 'images/icons/add.gif'
	),
	'ret' => array(
		'title' => 'قام بالرد على موضوع',
		'url' 	=> 'topics.php?t={1}&p={2}',
		'icon' 	=> 'images/icons/reply.gif'
	),
	'apt' => array(
		'title' => 'وافقت على موضوعك',
		'url'	=> 'topics.php?t={1}',
		'icon'	=> 'styles/folders/approve.png'
	),
	'hot' => array(
		'title' => 'قام بتجميد موضوعك',
		'url'	=> 'topics.php?t={1}',
		'icon'	=> 'styles/folders/hold.png'
	),
	'mot' => array(
		'title' => 'قام بنقل موضوعك',
		'url'	=> 'topics.php?t={1}',
		'icon'	=> 'styles/folders/order.png'
	),
	'hit' => array(
		'title' => 'قام بإخفاء موضوعك',
		'url'	=> 'topics.php?t={1}',
		'icon'	=> 'styles/folders/hidden.png'
	),
	'sht' => array(
		'title' => 'قام بإظهار موضوعك',
		'url'	=> 'topics.php?t={1}',
		'icon'	=> 'styles/folders/visible.png'
	),
	'lot' => array(
		'title' => 'قام بقفل موضوعك',
		'url'	=> 'topics.php?t={1}',
		'icon'	=> 'styles/folders/lock.png'
	),
	'opt' => array(
		'title' => 'قام بفتح موضوعك',
		'url'	=> 'topics.php?t={1}',
		'icon'	=> 'styles/folders/unlock.png'
	),
	'stt' => array(
		'title' => 'قام تثبيت موضوعك',
		'url'	=> 'topics.php?t={1}',
		'icon' 	=> 'styles/folders/sticky.png'
	),
	'ust' => array(
		'title' => 'قام إلغاء تثبيت موضوعك',
		'url' 	=> 'topics.php?t={1}',
		'icon' 	=> 'styles/folders/unsticky.png'
	),
	'srt' => array(
		'title' => 'قام بمنح نجمة لموضوعك',
		'url' 	=> 'topics.php?t={1}',
		'icon' 	=> 'images/icons/star_red.gif'
	),
	'met' => array(
		'title' => 'قام بمنح ميدالية لموضوعك',
		'url' 	=> 'topics.php?t={1}',
		'icon' 	=> 'images/icons/top.gif'
	),
	'apr' => array(
		'title' => 'وافقت على ردك في موضوع',
		'url' 	=> 'topics.php?t={1}&p={2}',
		'icon' 	=> 'images/icons/approve.gif'
	),
	'hor' => array(
		'title' => 'قام بتجميد ردك في موضوع',
		'url' 	=> 'topics.php?t={1}&p={2}',
		'icon' 	=> 'images/icons/hold.gif'
	),
	'hir' => array(
		'title' => 'قام بإخفاء ردك في موضوع',
		'url' 	=> 'topics.php?t={1}&p={2}',
		'icon' 	=> 'images/icons/hidden.gif'
	),
	'shr' => array(
		'title' => 'قام بإظهار ردك في موضوع',
		'url' 	=> 'topics.php?t={1}&p={2}',
		'icon' 	=> 'images/icons/visible.gif'
	)
);

?>