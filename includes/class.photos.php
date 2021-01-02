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

// denying calling this file without landing files.
defined('_df_script') or exit();

class DFPhotos{
	function __construct(){
		global $DF, $mysql;
		if( is_object($DF) ){
			$this->DF =& $DF;
			$this->mysql =& $mysql;
		}
		else{
			trigger_error("Error: [DF class in login]", E_USER_ERROR);
		}
	}
	function create( $file_title, $source_file, $options = [], $is_data = false ){
		
		$result = array(
			'id' => 0,
			'filename' => '',
			'filetype' => '',
			'filetitle' => '',
			'error' => 1,
			'errorname' => '',
			'vars' => []
		);
		
		if( $is_data === true ){
			if( empty($source_file) ){
				$result['errorname'] = 'invalid_source';
			}
			else{
				$source_image = @imagecreatefromstring($source_file);
				if( !$source_image ){
					$result['errorname'] = 'invalid_source';
					@imagedestroy($source_image);
				}
				else{
					$source_width = @imagesx($source_image);
					$source_width = intval($source_width);
					if( $source_width <= 0 ){
						$result['errorname'] = 'invalid_source';
						@imagedestroy($source_image);
					}
				}
			}
		}
		else{
			if( !is_file($source_file) ){
				$result['errorname'] = 'invalid_source';
				return $result;
			}
		}

		if( !is_array($options) ){
			$options = [];
		}

		$arabic_letters = "ءابتثپجحخچدذرڕزژسشصضطظعغفقڤكگلڵمنهەةوۆيئىیێ";
		$file_title = $this->DF->preg_except( "/([a-z0-9\s\_\-\.\(\)\[\]\{\}\+\=\;\@\#\$\!\~\%{$arabic_letters}]*)/i", $file_title );
		
		$extension = explode(".", $file_title);
		$extension = array_reverse($extension);
		$extension = strtolower($extension[0]);
		
		if( $extension == 'jpeg' ){
			$extension = 'jpg';
		}
		
		if( $is_data === true ){
			$file_size = strlen($source_file);
		}
		else{
			$file_size = filesize($source_file);
		}

		$status = isset($options['status']) ? intval($options['status']) : 1;
		$phototype = isset($options['phototype']) ? $this->DF->preg_except( '/([a-zA-Z0-9_\-\.]*)/', $options['phototype'] ) : '';
		$targettype = isset($options['targettype']) ? $this->DF->preg_except( '/([a-zA-Z0-9_\-\.]*)/', $options['targettype'] ) : '';
		$targetid = isset($options['targetid']) ? intval($options['targetid']) : 0;
		$description = isset($options['description']) ? $this->DF->cleanText( $options['description'] ) : '';
		$userid = isset($options['userid']) ? intval($options['userid']) : uid;
		$getsize = isset($options['getsize']) ? intval($options['getsize']) : 999;
		$sizes = ( isset($options['sizes']) && is_array($options['sizes']) ) ? $options['sizes'] : [];
		$allow_types = ( isset($options['allow_types']) && is_array($options['allow_types']) ) ? $options['allow_types'] : [];
		$allow_size = isset($options['allow_size']) ? intval($options['allow_size']) : 0;
		$delete_source = ( isset($options['delete_source']) && $options['delete_source'] == 1 ) ? true : false;
		
		/*
			// example for $sizes
			// allowed index of $sizes ( 1 to 998 )
			$sizes = array(
				256 // this mean the width will be 256 and the height set by aspect ratio
				810 => array(
					'width' => 810,
					'height' => 980,
					'x' => 304,
					'y' => 0,
					'src_width' => 992,
					'src_height' => 1200,
					'max_width' => 1200,
					'max_height' => 1200
				),
			);
		*/
		
		$error_name = '';
		if( !in_array( $extension, $allow_types ) ){
			$error_name = "not_allowed_type";
			$result['vars']['filetype'] = $extension;
			$result['vars']['allowtypes'] = implode(",", $allow_types);
		}
		elseif( $file_size > $allow_size ){
			$error_name = "not_allowed_size";
			$result['vars']['filesize'] = $file_size;
			$result['vars']['allowsize'] = $allow_size;
		}
		elseif( $userid == 0 ){
			$error_name = "userid";
		}
		
		if( !empty($error_name) ){
			$result['errorname'] = $error_name;
			return $result;
		}

		$year = _this_year;
		$month = _this_month;
		$normal_size = "0999";
		$rand = mt_rand(1000000, 9999999);
		
		$file_folder = "{$this->DF->config['photos']['folder']}/files/";
		@chmod($file_folder, 0777);
		$file_folder = "{$file_folder}{$userid}/";
		if( !is_dir($file_folder) ){
			@mkdir($file_folder);
			@chmod($file_folder, 0777);
		}
		$file_folder = "{$file_folder}{$year}/";
		if( !is_dir($file_folder) ){
			@mkdir($file_folder);
			@chmod($file_folder, 0777);
		}
		$file_folder = "{$file_folder}{$month}/";
		if( !is_dir($file_folder) ){
			@mkdir($file_folder);
			@chmod($file_folder, 0777);
		}

		$path_file = "{$file_folder}{$rand}.{$normal_size}.{$extension}";

		while( file_exists($path_file) ){
			$rand = mt_rand(1000000, 9999999);
			$path_file = "{$file_folder}{$rand}.{$normal_size}.{$extension}";
		}

		if( $is_data === true ){
			@imagejpeg($source_image, $path_file, 100);
			@imagedestroy($source_image);
		}
		if( $is_data === true && file_exists($path_file) || @copy($source_file, $path_file) ){
			$filename = $this->vars2name([
				'userid' => $userid,
				'year' => $year,
				'month' => $month,
				'size' => sprintf('%04d', $normal_size),
				'rand' => $rand,
				'extension' => $extension
			]);
			
			$this->mysql->execute_insert("photos", [
				'status' => $status,
				'filename' => $filename,
				'filetype' => $extension,
				'filesize' => $file_size,
				'filetitle' => $file_title,
				'phototype' => $phototype,
				'targettype' => $targettype,
				'targetid' => $targetid,
				'description' => $description,
				'sdescription' => $this->DF->search($description),
				'addby' => uid,
				'datetime' => _datetime,
			], __FILE__, __LINE__);
			$id = $this->mysql->get_lastid();

			$exif = @exif_read_data($path_file);
			$orientation = isset($exif['Orientation']) ? intval($exif['Orientation']) : 0;
			if( $orientation == 3 || $orientation == 6 || $orientation == 8 ){
				$image = imagecreatefromstring( file_get_contents($path_file) );
				
				if( $orientation == 3 ){
					$image = imagerotate( $image, 180, 0);
				}
				elseif( $orientation == 6 ){
					$image = imagerotate( $image, -90, 0);
				}
				elseif( $orientation == 8 ){
					$image = imagerotate( $image, 90, 0 );
				}
				
				imagejpeg( $image, $path_file );
				imagedestroy( $image );
			}

			foreach( $sizes as $size => $size_data ){
				$size = intval($size);
				if( is_array($size_data) && $size > 0 && $size <= $normal_size ){
					$new_path_file = "{$file_folder}{$rand}.".sprintf('%04d', $size).".{$extension}";
					$width = isset($size_data['width']) ? intval($size_data['width']) : null;
					$height = isset($size_data['height']) ? intval($size_data['height']) : null;
					$x = isset($size_data['x']) ? intval($size_data['x']) : null;
					$y = isset($size_data['y']) ? intval($size_data['y']) : null;
					$src_width = isset($size_data['src_width']) ? intval($size_data['src_width']) : null;
					$src_height = isset($size_data['src_height']) ? intval($size_data['src_height']) : null;
					$src_size = isset($size_data['src_size']) ? intval($size_data['src_size']) : 0;
					$max_width = isset($size_data['max_width']) ? intval($size_data['max_width']) : null;
					$max_height = isset($size_data['max_height']) ? intval($size_data['max_height']) : null;
					$src_path_file = ( $src_size > 0 ) ? "{$file_folder}{$rand}.".sprintf('%04d', $src_size).".{$extension}" : $path_file;
					$this->resize_image( $src_path_file, $new_path_file, $width, $height, $x, $y, $src_width, $src_height, $max_width, $max_height );
				}
				else{
					$size = intval($size_data);
					if( $size > 0 && $size < $normal_size ){
						$new_path_file = "{$file_folder}{$rand}.".sprintf('%04d', $size).".{$extension}";
						$this->resize_image( $path_file, $new_path_file, $size );
					}
				}
			}

			if( $delete_source ){
				@unlink($path_file);
			}
			
			$result['id'] = $id;
			$result['filename'] = ( $getsize != $normal_size ) ? $this->resize( $filename, $getsize ) : $filename;
			$result['filesize'] = $file_size;
			$result['filetype'] = $extension;
			$result['filetitle'] = $file_title;
			$result['error'] = 0;
			return $result;
		}
		else{
			$result['errorname'] = 'not_copied';
			return $result;
		}
	}
	
	function resize_image(
		$src,
		$new_src,
		$new_dst_width = null,
		$new_dst_height = null,
		$src_x = null,
		$src_y = null,
		$new_src_width = null,
		$new_src_height = null,
		$max_width = null,
		$max_height = null
	){
		$allow_extensions = array('gif', 'png', 'jpg');
		$get_extension = array(
			'image/gif'		=> 'gif',
			'image/x-png'	=> 'png',
			'image/png'		=> 'png',
			'image/pjpeg'	=> 'jpg',
			'image/jpeg'	=> 'jpg',
			'image/jpg'		=> 'jpg'
		);
		$extension = getimagesize($src);
		$extension = strtolower($get_extension["{$extension['mime']}"]);
		if( in_array($extension, $allow_extensions) ){
			if( $extension == 'jpg' ){
				$image_src = imagecreatefromjpeg($src);
			}
			if( $extension == 'png' ){
				$image_src = imagecreatefrompng($src);
			}
			if( $extension == 'gif' ){
				$image_src = imagecreatefromgif($src);
			}
			
			if( $new_dst_width == null ) $new_dst_width = 0;
			if( $new_dst_height == null ) $new_dst_height = 0;
			if( $src_x == null ) $src_x = 0;
			if( $src_y == null ) $src_y = 0;
			if( $new_src_width == null ) $new_src_width = 0;
			if( $new_src_height == null ) $new_src_height = 0;
			if( $max_width == null ) $max_width = 1200;
			if( $max_height == null ) $max_height = 1200;
			
			if( $new_dst_width == 0 && $new_dst_height == 0 ){
				return;
			}
			
			$src_width = imagesx($image_src);
			$src_height = imagesy($image_src);
			
			$dst_width = $new_dst_width;
			$dst_height = $new_dst_height;
			
			if( $new_dst_width > 0 || $new_dst_height > 0 ){
				if( $new_dst_width > 0 ){
					if( $new_dst_height == 0 ){
						$dst_height = ( $src_height * ($new_dst_width / $src_width) );
					}
				}
				if( $new_dst_height > 0 ){
					if( $new_dst_width == 0 ){
						$dst_width = ( $src_width * ($new_dst_height / $src_height) );
					}
				}
				$max_width = $dst_width;
				$max_height = $dst_height;
			}
			else{
				$dst_width = $src_width;
				$dst_height = $src_height;
			}
			
			$temp_width = 0;
			$temp_height = 0;
			if( $dst_width > $max_width || $dst_height > $max_height ){
				if( $dst_width > $max_width ){
					$temp_width = $max_width;
					$temp_height = ( $dst_height * ($max_width / $dst_width) );
				}
				if( $dst_height > $max_height ){
					if( $temp_width == 0 || $temp_height > $max_height ){
						$temp_height = $max_height;
						$temp_width = ( $dst_width * ($max_height / $dst_height) );
					}
				}
				$dst_width = $temp_width;
				$dst_height = $temp_height;
			}
			
			$dst_width = ceil($dst_width);
			$dst_height = ceil($dst_height);
			
			if( $new_src_width != null && $new_src_width > 0 ){
				$src_width = $new_src_width;
			}
			if( $new_src_height != null && $new_src_height > 0 ){
				$src_height = $new_src_height;
			}
			
			$new_image = imagecreatetruecolor( $dst_width, $dst_height );
			imagecopyresampled( $new_image, $image_src, 0, 0, $src_x, $src_y, $dst_width, $dst_height, $src_width, $src_height );
			$new_src = strtolower($new_src);
			if( $extension == 'jpg' ){
				imagejpeg( $new_image, $new_src );
			}
			if( $extension == 'png' ){
				imagepng( $new_image, $new_src );
			}
			if( $extension == 'gif' ){
				imagegif( $new_image, $new_src );
			}
			imagedestroy( $new_image );
			imagedestroy( $image_src );
		}
	}
	function getsrc( $filename, $size = 0 ){
		global $DF;

		if( $filename == '' ){
			return '';
		}

		if( $size > 0 ){
			$filename = $this->resize( $filename, $size );
		}
		return $DF->config['photos']['folder'].'/'.$filename;
	}
	function getname( $src, $size = 0 ){
		preg_match("/([0-9]+)\.([a-z]+)/i", $src, $matches);
		$filename = "{$matches[1]}.{$matches[2]}";
		if( $size > 0 ){
			$filename = $this->resize( $filename, $size );
		}
		return $filename;
	}
	function resize( $filename, $size ){
		$size = sprintf('%04d', intval($size) );
		$part1 = substr( $filename, 0, 13 );
		$part2 = substr( $filename, 17 );
		$filename = "{$part1}{$size}{$part2}";
		return $filename;
	}
	function filename2path( $filename ){
		$filename = strtolower($filename);

		if( strlen($filename) < 22 ){
			return $filename;
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
		if( $this->check_vars($vars) ){
			return "files/{$vars['userid']}/{$vars['year']}/{$vars['month']}/{$vars['rand']}.".sprintf('%04d', $vars['size'] ).".{$vars['extension']}";
		}
		return $filename;
	}
	function vars2name( $vars ){
		$vars = (array)$vars;
		if( $this->check_vars($vars) ){
			$vars['month'] = sprintf('%02d', $vars['month']);
			$vars['size'] = sprintf('%04d', intval($vars['size']));
			return "{$vars['rand']}{$vars['year']}{$vars['month']}{$vars['size']}{$vars['userid']}.{$vars['extension']}";
		}
		return '';
	}
	function check_vars( $vars ){
		$vars = (array)$vars;

		if(
			isset($vars['userid']) && $vars['userid'] >= 1 &&
			isset($vars['year']) && $vars['year'] >= 2000 && $vars['year'] <= ( _this_year + 1 ) &&
			isset($vars['month']) && $vars['month'] >= 1 && $vars['month'] <= 12 &&
			isset($vars['rand']) && $vars['rand'] >= 1000000 && $vars['rand'] <= 9999999 &&
			isset($vars['size']) && $vars['size'] >= 1 && $vars['size'] <= 9999 &&
			isset($vars['extension']) && strlen($vars['extension']) >= 2
		){
			return true;
		}
		return false;
	}
	function get_by_id( $id, $size = 0, $fields = [] ){
		$id = intval($id);
		if( $id > 0 ){
			$sql_fields = '';
			if( is_array($fields) && count($fields) > 0 ){
				$sql_fields = ', '.implode(",", $fields);
			}
			
			$result = $this->mysql->execute("SELECT filename {$sql_fields} FROM {$this->mysql->prefix}photos WHERE id = {$id}", __FILE__, __LINE__)->fetch();
			if( !empty($result['filename']) ){
				if( $size > 0 ){
					$result['filename'] = $this->resize( $result['filename'], $size );
				}
				return $result;
			}
		}
		return [];
	}
}
?>