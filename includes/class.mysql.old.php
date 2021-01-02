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

class DBOld{
	function query( $text, $file, $line, $display_error = true ){
		$this->set_details( $file, $line, $display_error );
		try{
			$sql = $this->conn->query($text);
			return $sql;
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $file, $line, $display_error );
		}
	}
	function queryArray( $text, $file = '', $line = '', $display_error = true ){
		$this->set_details( $file, $line, $display_error );
		try{
			$sql = $this->conn->query($text);
			$result = $sql->fetch(PDO::FETCH_BOTH);
			return $result;
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $file, $line, $display_error );
		}
	}
	function queryAssoc( $text, $file = '', $line = '', $display_error = true ){
		$this->set_details( $file, $line, $display_error );
		try{
			$sql = $this->conn->query($text);
			$result = $sql->fetch();
			return $result;
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $file, $line, $display_error );
		}
	}
	function queryRow( $text, $file = '', $line = '', $display_error = true ){
		$this->set_details( $file, $line, $display_error );
		try{
			$sql = $this->conn->query($text);
			$result = $sql->fetch(PDO::FETCH_NUM);
			return $result;
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $file, $line, $display_error );
		}
	}
	function insert( $text, $file = '', $line = '', $display_error = true ){
		$this->set_details( $file, $line, $display_error );
		try{
			return $this->conn->query("INSERT INTO ".$this->prefix."{$text}");
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $file, $line, $display_error );
		}
	}
	function update( $text, $file = '', $line = '', $display_error = true ){
		$this->set_details( $file, $line, $display_error );
		try{
			return $this->conn->query("UPDATE ".$this->prefix."{$text}");
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $file, $line, $display_error );
		}
	}
	function delete( $text, $file = '', $line = '', $display_error = true ){
		$this->set_details( $file, $line, $display_error );
		try{
			return $this->conn->query("DELETE FROM ".$this->prefix."{$text}");
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $file, $line, $display_error );
		}
	}
	function numRows( $sql ){
		try{
			return $sql->rowCount();
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $this->file, $this->line, $this->display_error );
		}
	}
	function fetchRow( $sql ){
		try{
			return $sql->fetch(PDO::FETCH_NUM);
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $this->file, $this->line, $this->display_error );
		}
	}
	function fetchAssoc( $sql ){
		try{
			return $sql->fetch();
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $this->file, $this->line, $this->display_error );
		}
	}
	function fetchArray( $sql ){
		try{
			return $sql->fetch(PDO::FETCH_BOTH);
		}
		catch( PDOException $e ){
			$this->error( $e->getMessage(), $this->file, $this->line, $this->display_error );
		}
	}
	function get($table, $field, $id, $where='id', $other=''){
		$sql=$this->query("SELECT $field FROM ".prefix."$table WHERE $where = '$id' $other", __FILE__, __LINE__);
		if($this->numRows($sql)>0){
			$rs=$this->fetchRow($sql);
			return $rs[0];
		}
	}
	function get_lastid(){
		$result = $this->queryRow("SELECT LAST_INSERT_ID()", $this->file, $this->line);
		return intval( $result[0] );
	}
	function get_id( $text, $file = '', $line = '', $display_error = true ){
		$this->set_details( $file, $line, $display_error );
		$result = $this->queryRow("SELECT id FROM {$this->prefix}{$text} LIMIT 1", $file, $line );
		return intval($result[0]);
	}
	function get_by_id( $fields, $table, $id, $file = '', $line = '', $display_error = true ){
		$this->set_details( $file, $line, $display_error );
		if( !is_array($fields) ){
			$fields = array($fields);
		}
		$result = $this->queryAssoc("SELECT ".implode(", ", $fields)." FROM {$this->prefix}{$table} WHERE id = {$id}", $file, $line );
		return $result;
	}
	function found_rows(){
		$result = $this->queryRow("SELECT FOUND_ROWS()", __FILE__, __LINE__);
		return intval( $result[0] );
	}
}
?>