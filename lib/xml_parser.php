<?php

class XML_Parser {
	
	private $connection;
	private $magic_quotes_active;
	private $real_escape_string_exists;
	private $xml_file_name; 
	public $xml_condition;
	public $xml;
	
	// initalise methods
	public function __construct() {
		$this->magic_quotes_active = get_magic_quotes_gpc ();
		$this->real_escape_string_exists = function_exists ( "mysql_real_escape_string" );
		$this->xml_file_name = $_SESSION['xmlfile'];
		$this->xml_connection ();
	}
	
	public function xml_connection() {
		if (is_writable($this->xml_file_name)) {
			//  Interprets an XML file into an object
			$this->xml = simplexml_load_file($this->xml_file_name);	
		} else {
			return "Fatal error XML File is not writeable";
		}
	}

	private function xml_error($message) {
		// not working yet
	//redirect_to('../public/error.php');
	}

	// read & list methods
	public function xml_count($xpath) {
		$xml_result = $this->xml->xpath ( $xpath );
		return count ( $xml_result );
	}
	
	public function list_elements($xpath) {
		if (! $xml_result = $this->xml->xpath ( $xpath )) {
			return ("Fatal error! XPATH not found");
		}
		foreach ( $xml_result as $element ) {
			$xml_array [] = ($element->getName ());
		}
		return ($xml_array);
	}
	
	public function get_attribute_value($xpath) {
		$attribute = $this->xml->xpath ( $xpath );
		return ( string ) $attribute [0];
	}
	
	public function simple_xpath($xpath) {
		// $xpath is an xml element with optional attribute
		$xml_result = $this->xml->xpath($xpath);
		return ($xml_result);
		// returns all matching elements & attributes
	}

	// returns an array
	public function multi_xpath($xpath) {
		foreach($this->xml->xpath($xpath) as $item) {
	    	$row = simplexml_load_string($item->asXML());
	    	// print_r($row);  
		}
		return $row;
	}
	public function list_attributes($xpath, $idx = 0) {
		$xml_result = $this->xml->xpath ( $xpath );
		return ($xml_result [$idx]->attributes ());
	}
	
	public function get_element_text($xpath, $idx = 0) {
		$xml_result = $this->xml->xpath ( $xpath );
		return $xml_result [0];
	}	
	
	// write methods
	public function change_attribute_value($xpath, $idx = 0, $attribute, $value) {
		// update_attribute ( '//eth1', 0, 'ipaddress', '1.2.3.4' );
		$xml_result = $this->xml->xpath ( $xpath );
		$xml_result [$idx] [$attribute] = $value;
		// should write a method for this next statement
		$this->xml->asXML ( $this->xml_file_name );
	}

	function update_element_text($xpath, $node, $string) {
        // $obj = $this->xml->xpath('//message[name="jim"]');
        $obj = $this->xml->xpath($xpath);
        $obj[0]->$node = $string;
        $this->xml->asXML($this->xml_file_name);
    }
	
	public function create_element($xpath, $element, $arrAttr, $idx = 0) {
		// this method fails in the adsl_accounts section prob because
		// there are multiple acct nodes so I use the add_node method
		/*
		* $attributes = array ('ipaddress' => '0.0.0.0', 
		* 						'netmask' => '255.255.255.255', 
		*                      'network' => '0.0.0.0', 
		*                      'broadcast' => '255.255.255.255' );
		* create_element('//lan', 'eth5', $attributes, 0);
		*/
		$nodes = $this->xml->xpath ( $xpath );
		$parent = $nodes [$idx];
		$parent->addChild ( $element );
		foreach ( $arrAttr as $attr => $val ) {
			$parent->$element->addAttribute ( $attr, $val );
		}
		// should write a method for this next statement
		$this->xml->asXML ( $this->xml_file_name );
	}
	
	public function add_node($xpath, $element, $idx = 0) {
		$nodes = $this->xml->xpath ( $xpath );
		$parent = $nodes [$idx];
		$parent->addChild ( $element );
		$this->xml->asXML ( $this->xml_file_name );
	}
	
	function remove_node($xpath, $multi = 'one') {
		/**
		 * Remove node/nodes xml with xpath
		 *
		 * @param SimpleXMLElement                 $xml
		 * @param string XPath                     $path
		 * @param string ('one'|'child'|'all')     $multi
		 * 
		 * Use:
		 * 
		 * Example xml file - http://www.php.net/manual/en/ref.simplexml.php
		 * 
		 * $xml = simplexml_load_file($xmlfile);
		 * 
		 * //1. remove only 1 node (without child nodes)
		 * //   $path must return only 1 (unique) node 
		 * ie. must not have any child nodes !!
		 * remove_node($xml, '//movie/rating[@type="thumbs"]');
		 * 
		 * //2. remove 1 node (with 1 child nodes)
		 * //    $path can return any nodes - will be removed only first node
		 * //   with all child nodes
		 * remove_node($xml, '//characters', 'child')
		 * or
		 * remove_node($xml, '//movie/rating[@type="thumbs"]', "child");
		 * 
		 * //3. remove all nodes (with child nodes)
		 * //   $path can return any nodes - will be removed all
		 * //   with child nodes
		 * remove_node($xml, '//rating', 'all')
		 * or
		 * remove_node($xml, '//movie/rating[@type="thumbs"]', "all");
		 * 
		 * $xml->asXML($xmlfile);
		 * 
		 */	
		$result = $this->xml->xpath ( $xpath );
		
		# for wrong $path
		if (! isset ( $result [0] ))
			return false;
		
		switch ($multi) {
			case 'all' :
				$errlevel = error_reporting ( E_ALL & ~ E_WARNING );
				foreach ( $result as $r ) unset ( $r [0] );
				error_reporting ( $errlevel );
				// return true;
				$this->xml->asXML ( $this->xml_file_name );
				break;
			case 'child' :
				unset ( $result [0] [0] );
				// return true;
				$this->xml->asXML ( $this->xml_file_name );
				return $errlevel;
				break;
			case 'one' :
				if (count ( $result [0]->children () ) == 0 && count ( $result ) == 1) {
					unset ( $result [0] [0] );
					// return true;
					$this->xml->asXML ( $this->xml_file_name );			}
					return $errlevel;
					break;
			default :
				return false;
		}
	}

} // end: Class XML_data


// $xml_data = new XML_Parser ();

?>