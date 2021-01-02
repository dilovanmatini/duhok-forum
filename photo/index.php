<?php

/*//////////////////////////////////////////////////////////////////////////////
// ##########################################################################///
// # DM System 1.0                                                          # //
// ########################################################################## //
// #                                                                        # //
// #               --  DM SYSTEM IS NOT FREE SOFTWARE  --                   # //
// #                                                                        # //
// #  ============ Programming & Designing By Dilovan Matini =============  # //
// #          Copyright © 2018 Dilovan Matini. All Rights Reserved.         # //
// #------------------------------------------------------------------------# //
// #------------------------------------------------------------------------# //
// # Website: www.qkurd.com                                                 # //
// # Contact us: dilovan@lelav.com                                          # //
// ########################################################################## //
//////////////////////////////////////////////////////////////////////////////*/

date_default_timezone_set('GMT');

function get_picture_content( $vars ){
	$path = "files/{$vars['userid']}/{$vars['year']}/{$vars['month']}/{$vars['rand']}.".sprintf('%04d', $vars['size'] ).".{$vars['extension']}";
	
	$result = array(
		'valid' => 0,
		'mime' => '',
		'size' => 0,
		'content' => ''
	);

	if( file_exists($path) ){
		$type = @getimagesize($path);
		$mime = $type['mime'];
		$size = filesize($path);
		
		$fp = fopen($path, 'r');
		$content = fread($fp, $size);
		fclose($fp);
		
		$result = array(
			'valid' => 1,
			'mime' => $mime,
			'size' => $size,
			'content' => $content
		);
	}
	return $result;
}
function get_picture_vars( $filename ){
	$filename = strtolower($filename);
	$vars = array(
		'userid' => 0,
		'year' => 0,
		'month' => 0,
		'rand' => 0,
		'size' => 0,
		'extension' => ''
	);
	if( strlen($filename) < 22 ){
		return $vars;
	}

	$parts = explode(".", $filename);
	$part1 = isset($parts[0]) ? $parts[0] : '';
	$part2 = isset($parts[1]) ? $parts[1] : '';

	$vars = [];
	$vars['userid'] = 		intval( substr( $part1, 17 ) );
	$vars['year'] = 		intval( substr( $part1, 7, 4 ) );
	$vars['month'] = 		intval( substr( $part1, 11, 2 ) );
	$vars['rand'] = 		intval( substr( $part1, 0, 7 ) );
	$vars['size'] = 		intval( substr( $part1, 13, 4 ) );
	$vars['extension'] = 	$part2;
	
	return $vars;
}
function found_error( $text = '' ){
	header("HTTP/1.0 404 Not Found");
	echo $text;
	exit();
}

/**
 * (rand:7) (year:4) (month:2) (size:4) (userid:>=1).jpg
 * 7777777 2021 01 0640 1036 png
 * 777777720210106401036.png
*/

$this_year = intval( date('Y', time()) );
$url = isset($_GET['f']) ? trim($_GET['f']) : '';
$vars = get_picture_vars( $url );

if(
	isset($vars['userid']) && $vars['userid'] >= 1 &&
	isset($vars['year']) && $vars['year'] >= 2000 && $vars['year'] <= ( $this_year + 1 ) &&
	isset($vars['month']) && $vars['month'] >= 1 && $vars['month'] <= 12 &&
	isset($vars['rand']) && $vars['rand'] >= 1000000 && $vars['rand'] <= 9999999 &&
	isset($vars['size']) && $vars['size'] >= 1 && $vars['size'] <= 9999 &&
	isset($vars['extension']) && strlen($vars['extension']) >= 2
){
	$file = get_picture_content( $vars );
	if( $file['valid'] == 1 && !empty($file['content']) && $file['size'] > 0 ){
		header("Content-type: {$file['mime']}");
		header("Content-Disposition: inline; filename={$url}");
		header('Expires: '.gmdate('D, d M Y H:i:s', time() + (60*60*24*5)).' GMT');
		header("Content-Length: {$file['size']}");
		echo $file['content'];
	}
	else{
		found_error();
		//echo $file['valid'];
	}
}
else{
	found_error();
}
?>
