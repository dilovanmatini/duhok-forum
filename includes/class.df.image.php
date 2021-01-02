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

class DFImage{
	var $DF=null;
	var $i=array();
	var $f=array();
	var $h=array();
	var $icons=array(
		'approve','gif',
		'arrow_down','gif',
		'arrow_up','gif',
		'blank','gif',
		'camera','gif',
		'change','png',
		'complain','gif',
		'contract','gif',
		'delete','gif',
		'downopen','gif',
		'edit','gif',
		'error','gif',
		'expand','gif',
		'favorite','gif',
		'favorite_delete','gif',
		'go_down','gif',
		'go_left','gif',
		'go_right','gif',
		'go_up','gif',
		'hidden','gif',
		'hold','gif',
		'lock','gif',
		'load','gif',
		'loading','gif',
		'loading2','gif',
		'loading3','gif',
		'message','gif',
		'message_forum','gif',
		'moderate','gif',
		'online','gif',
		'option','gif',
		'paging','gif',
		'post','gif',
		'post_delete','gif',
		'post_down','gif',
		'post_edit','gif',
		'post_left','gif',
		'post_right','gif',
		'post_up','gif',
		'print','gif',
		'progress','gif',
		'question','gif',
		'reply','gif',
		'send','gif',
		'single','gif',
		'star_blue','gif',
		'star_bronze','gif',
		'star_cyan','gif',
		'star_gold','gif',
		'star_green','gif',
		'star_orange','gif',
		'star_purple','gif',
		'star_red','gif',
		'star_silver','gif',
		'stats','gif',
		'succeed','gif',
		'survey','gif',
		'survey_dark','gif',
		'survey_light','gif',
		'top','gif',
		'top_list','gif',
		'unlock','gif',
		'user_profile','gif',
		'user_profile_lock','gif',
		'users','gif',
		'visible','gif',
		'unknown_photo','gif',
		'close','gif',
		'nophoto','gif',
		'reupload','gif',
		'errorlogo','gif',
		'mon','gif',
		'user_posts','gif',
		'sitting','gif',
		'new_user','gif',
		'new_name','gif',
		'change_words','gif',
		'form_error','gif',
		'url_error','gif',
		'block_ip','gif',
		'check_ip','gif',
		'poll','gif',
		'info','gif',
		'alert','gif',
		'loading8','gif',
		'ball','gif',
		'disball','gif',
		'ycard','gif',
		'rcard','gif',
		'xhidden','gif',
		'xshow','gif',
		'restore','gif',
		'noimage','gif'
	);
	var $folders=array(
		'add_user','png',
		'approve','png',
		'delete','png',
		'edit','png',
		'folder','png',
		'held','png',
		'hidden','png',
		'hold','png',
		'hot','gif',
		'lock','png',
		'option','png',
		'order','png',
		'restore_delete','png',
		'sticky','png',
		'unlock','png',
		'unsticky','png',
		'visible','png',
		'moderate','png'

	);
	var $headers=array(
		'active','gif',
		'admin','gif',
		'archive','gif',
		'details','gif',
		'exit','gif',
		'help','gif',
		'home','gif',
		'messages','gif',
		'favorite','gif',
		'search','gif',
		'users','gif',
		'yourposts','gif',
		'yourtopics','gif',
		'sitting','gif',
		'changedetails','gif',
		'editsignature','gif',
		'userlists','gif',
		'hidetopics','gif',
		'loginbar','gif',
		'trylogin','gif',
		'changename','gif',
		'balance','gif',
		'activity','gif',
		'medal','gif',
		'changepicture','gif',
		'friends','gif',
		'loginsessions','png'
	);
	function image($DF){
		if(is_object($DF)){
			$this->DF=&$DF;
		}
		else{
			trigger_error("<strong>df</strong> class df is not an object",E_USER_ERROR);
		}
	}
	function setArrays(){
		$this->setVariable('icons');
		$this->setVariable('folders');
		$this->setVariable('headers');
	}
	function setVariable($name){
		$path=array(
			'icons'=>'images/icons/',
			'folders'=>'styles/folders/',
			'headers'=>'images/large-icons/'
		);
		$type=substr($name,0,1);
		eval('$images=$this->'.$name.';');
		for($x=0;$x<count($images);$x+=2){
			eval('$this->'.$type.'["'.$images[$x].'"]="'.$path["{$name}"].$images[$x].'.'.$images[$x+1].'";');
		}
	}
}
?>