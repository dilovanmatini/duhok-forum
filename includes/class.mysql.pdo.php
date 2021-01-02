<?php

/*//////////////////////////////////////////////////////////
// ######################################################///
// # Duhok Forum 2.0                                    # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #  === Programmed & developed by Dilovan Matini ===  # //
// # Copyright © 2007-2020 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # Website: github.com/dilovanmatini/duhok-forum      # //
// # Email: df@lelav.com                                # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

// denying calling this file without landing files.
defined('_df_script') or exit();

class MySQL extends DBOld{
	var $line = '';
	var $file = '';
	var $display_error = true;
	var $conn = null;
	function __construct( $DF ){
		try{
			if( is_object($DF) ){
				$this->DF =& $DF;
				$DF->mysql =& $this;
	
				$config = $DF->config['database'];
	
				$this->host = $config['host'];
				$this->port = $config['port'];
				$this->name = $config['name'];
				$this->prefix = $config['prefix'];
				$this->user = $config['user'];
				$this->pass = $config['pass'];
			}
			else{
				throw new Exception("DF class is undefined in MySQL");
			}
		}
		catch( Exception $e ){
			die("DM Error: {$e->getMessage}");
		}
	}
	function connect(){
		// Data Source Name
		$dsn = "mysql:host={$this->host};dbname={$this->name};port={$this->port};charset=utf8;";
		try{
			$this->conn = new PDO( $dsn, $this->user, $this->pass );
		}
		catch( PDOException $e ){
			die ( $this->error( $e->getMessage() ) );
		}
		$this->query("SET NAMES 'utf8'", __FILE__, __LINE__);
		$this->conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
		$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	function execute( $text, $params = [], $file = '', $line = '', $display_error = true ){
		$this->set_details( $file, $line, $display_error );
		try{
			$sql = $this->conn->prepare($text);
			$sql->execute($params);
			return $sql;
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $file, $line, $display_error );
		}
	}
	function execute_insert( $table, $params, $file = '', $line = '', $display_error = true ){
		if( !is_array($params) ) return;
		$fields = [];
		$values = [];
		$arr = [];
		foreach( $params as $field => $value ){
			if( !empty($field) ){
				$allow = true;
				if( is_array($value) ){
					$allow = ( isset($value[1]) && $value[1] === false ) ? false : true;
					$value = isset($value[0]) ? $value[0] : '';
				}
				if( $allow ){
					$fields[] = $field;
					$values[] = ":{$field}";
					$arr["{$field}"] = ( $value === false ) ? null : $value;
				}
			}
		}
		if( count($fields) == 0 ) return false;

		$this->set_details( $file, $line, $display_error );
		try{
			$sql = $this->conn->prepare("INSERT INTO ".$this->prefix."{$table} (".implode(",", $fields).") VALUES (".implode(",", $values).")");
			$sql->execute( $arr );
			return $sql;
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $file, $line, $display_error );
		}
	}
	function get_lastid(){
		$result = $this->execute("SELECT LAST_INSERT_ID()", [], $this->file, $this->line)->fetch(PDO::FETCH_NUM);
		return intval( $result[0] );
	}
	function get_config( $keyword ){
		try{
			$sql = $this->conn->prepare("SELECT text FROM {$this->prefix}config WHERE keyword = :keyword");
			$sql->execute([
				'keyword' => $keyword
			]);
			$result = $sql->fetch(PDO::FETCH_NUM);
			return $result[0];
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), __FILE__, __LINE__, $this->display_error );
		}
	}
	function update_config( $keyword, $text, $status = 2 ){
		try{
			$params = [];
			$params['keyword'] = $keyword;
			$params['text'] = $text;

			$status = intval($status);
			$status_text = "";
			if( $status == 0 || $status == 1 ){
				$params['status'] = $status;
				$status_text = ", status = :status";
			}

			$sql = $this->conn->prepare("UPDATE {$this->prefix}config SET text = :text {$status_text} WHERE keyword = :keyword");
			$sql->execute($params);
			return $sql;
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), __FILE__, __LINE__, $this->display_error );
		}
	}
	function insert_config( $keyword, $text ){
		try{
			$sql = $this->conn->prepare("INSERT INTO {$this->prefix}config ( keyword, text ) VALUES ( :keyword, :text )");
			$sql->execute([
                'keyword' => $keyword,
				'text' => $text
			]);
			return $sql;
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), __FILE__, __LINE__, $this->display_error );
		}
	}
	function set_details( $file = '', $line = '', $display_error = true ){
		$this->file = $file;
		$this->line = $line;
		$this->display_error = $display_error;
	}
	function error( $error = '', $file = '', $line = '', $display_error = true ){
		$this->DF->error( 'MySQL Error',  $error, $file, $line, $display_error );
	}
	function close(){
		$this->conn = null;
	}
}

?>