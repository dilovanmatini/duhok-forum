<?php
/*//////////////////////////////////////////////////////////
// ######################################################///
// # DuhokForum 1.1                                     # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #   ========= Programming By Dilovan ==============  # //
// # Copyright © 2007-2009 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # If you want any support vist down address:-        # //
// # Email: df@duhoktimes.com                           # //
// # Site: http://df.duhoktimes.com/index.php           # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

class Template{
    var $variable = [];

	function display($code){
                   $code = $this->Get_Tmp($code);
                   echo $code;
                  }

	function G_TMP($code){
                   $code = $this->Get_Tmp($code);
                   return $code;
                  }

	function xml_exists($xml){
                      $xml = "styles/style.xml";
                      if(file_exists($xml )){
                       return true;
                       }else{
                       return false;
                       }
                  }

	function wrong_path($xml){
                      $xml = $xml.".xml";
                      $path = "styles/style".$xml;
                     echo '<b>Warning : </b> Template File '.$xml.' Not Exists in Path '.$path.'';
                     exit();
                  }

	function wrong_tmp($file,$style){
                     echo '<b>Warning : </b> Template Row '.$file.' Not Exists in Style '.$style.' , Wrong Query';
                     exit();
                  }

    function Get_Tmp($file){
        global $mysql, $choose_style,$dbhost,$dbuser,$dbpass,$dbname;

        // Check File XML
        if(!$this->xml_exists($choose_style)){
            $this->wrong_path($choose_style);
        }

        $result = $mysql->execute("select *  from {$mysql->prefix}TEMPLATES where NAME ='$file'  ", [], __FILE__, __LINE__)->fetch();
        if( count($result) == 0 ){
            $this->wrong_tmp($file,$choose_style);
        }
        else{
            $tpl_source = $result['SOURCE'];
        }

        $DesignCode = $this->Code_Html($tpl_source);
        return $DesignCode;
    }
	
	function Code_Html($html){
	    extract($GLOBALS);

        $content = stripslashes($html);

                                                    $content = preg_replace('#{\$(.*)\[(.*)]\[(.*)]}#i','<php> echo $this->variable[\'$1\'][\'$2\'][\'$3\'];</php>',$content); 

		$content = preg_replace("/{{/","<php> echo ", $content);
		$content = preg_replace("/}}/","; </php>", $content);


// if condition
			$content = $this->if_condition($content);
			$content =preg_replace("/\<else>/i","</code>\";} else {echo \"<code>",$content);



// loop
			$content = $this->html_loop($content);


// while and mysql_fetch

                                                      $content = $this->sql_com($content);

// Replace php by code for use in the realy php

		$content = preg_replace("/\<php>/i","</code>\";", $content);
		$content = preg_replace("/\<\/php>/i","echo \"<code>", $content);

// Config Simple

	                  $content = "echo \"<code>".$content."</code>\";";	

// Replace " with \" until I can echo html code with no prblem

		$content =  $this->Html_Quot($content);

// Delete code from template 

	                  $content = str_replace("<code>","",$content);
		$content = str_replace("</code>","",$content);

// Bye Bye

                                    $content.= "\nreturn true;";

// ShowTime !!!!
                                                                        ob_start();
				$content = eval($content);
				$content = ob_get_contents();
				ob_end_clean();
	
	return $content;
	}


	
	function if_condition($Html){
                   $Html = preg_replace('/\<if condition\=\"(.*)\">/','</code>"; if($1){ echo "<code>',$Html); 
                   $Html = preg_replace('/\<\/if\>/','</code>";} echo "<code>',$Html);
                   return $Html;
	}

                  function sql_com($Html){
/*
$Html = preg_replace('#<section name="(.*)" fetch="(.*)">(.*)</section>#i','<php>while($2 = mysql_fetch_array($1)){</php>$3<php>}</php>',$Html); 
*/
$Html = preg_replace('#<sql name="(.*)" fetch="(.*)">#','</code>";$i=1; while($2=@mysql_fetch_array($1)){ echo "<code>',$Html); 
$Html = preg_replace('/\<\/sql\>/','</code>"; $i++;} echo "<code>',$Html);
return $Html;
                  }

                  function html_loop($Html){

$Html = preg_replace('#<loop value="(.*)" star="(.*)" end="(.*)">(.*)</loop>#si','<php>for($1 = $2;$i < $3;$1++){</php>$4<php>}</php>',$Html); 
                   return $Html;

                  }

// Add Multipe Array like $lang

               function assign_array($string,$value){
                $this->variable["{$string}"] = $value;
                return true;
               }

              function array_fix($a,$b,$c){
              extract($GLOBALS);
              die($this->variable["{$a}"]["{$b}"]["{$c}"]);
              return true;
              }

               function assign($string,$value){
               $GLOBALS["{$string}"] = $value;
                return true;
               }

		function Html_Quot($String){
		    $Tablo=explode("<code>",$String);
		    $String="";
		    $String.=$Tablo[0];
		    foreach($Tablo as $Cle=>$Valeur){
		        if(preg_match("/<\/code>/i",$Valeur)){
		            $TabloOne=explode("</code>",$Valeur);
		            $TabloOne[0]=preg_replace("/\"/", '\"', $TabloOne[0]);
		            foreach($TabloOne as $CleOne=>$ValeurOne){
		                if($CleOne==0)
		                $ValeurOne="<code>".$ValeurOne."</code>";
		                $String.=$ValeurOne;
		            }
		        }     
		    }
		    return $String;
		} 

	
}
?>