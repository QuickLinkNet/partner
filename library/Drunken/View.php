<?php

/**
 * 
 * @desc TODO
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @copyright Manuel Kramm
 * @version 1.0
 */
class Drunken_View
{
	protected $html_head = array();
	
	protected $html_footer = array();
	
	protected $header = array();
	
	protected $navigation = array();
	
	protected $sidebar = array();
	
	protected $content = array();
	
	//Eingef�gt
	protected $searchform = array();
	
	/**
	 * 
	 * @TODO
	 * @param unknown_type $input
	 */
	public function setNavigation($input) {
		if(is_array($input)) {
			foreach($input as $line) {
				$this->navigation[] = $line;
			}
		} else {
			$file = strtolower($input);
			
			if(file_exists($file)) {
				require_once $file;
				
				if(isset($content) && isset($content) != '') {
					foreach($content as $line) {
						$this->navigation[] = $line;
					}
				}
			}
		}
	}
	
	/**
	 * 
	 * @TODO
	 * @param unknown_type $input
	 */
	public function setSidebar($input) {
		if(is_array($input)) {
			foreach($input as $line) {
				$this->sidebar[] = $line;
			}
		} else {
			$file = strtolower($input);
			
			if(file_exists($file)) {
				require_once $file;
				
				if(isset($content) && isset($content) != '') {
					foreach($content as $line) {
						$this->sidebar[] = $line;
					}
				}
			}
		}
	}
	
	/**
	 * 
	 * @TODO
	 * @param unknown_type $input
	 */
	public function setHeader($input) {
		if(is_array($input)) {
			foreach($input as $line) {
				$this->header[] = $line;
			}
		} else {
			$file = strtolower($input);
			
			if(file_exists($file)) {
				require_once $file;
				
				if(isset($content) && isset($content) != '') {
					foreach($content as $line) {
						$this->header[] = $line;
					}
				}
			}
		}
	}
	
	/**
	 * 
	 * @TODO
	 * @param unknown_type $input
	 */
	public function setHtmlHead($input) {
		if(is_array($input)) {
			foreach($input as $line) {
				$this->html_head[] = $line;
			}
		} else {
			$file = strtolower($input);
			
			if(file_exists($file)) {
				require_once $file;
				
				if(isset($content) && isset($content) != '') {
					foreach($content as $line) {
						$this->html_head[] = $line;
					}
				}
			}
		}
	}
	
	/**
	 * 
	 * @TODO
	 * @param unknown_type $input
	 */
	public function setContent($input) {
		if(is_array($input)) {
			foreach($input as $line) {
				$this->content[] = $line;
			}
		} else {
			$file = strtolower($input);
			
			if(file_exists($file)) {
				
				require_once $file;
				
				if(isset($content) && isset($content) != '') {
					foreach($content as $line) {
						$this->content[] = $line;
					}
				}
			}
		}
	}
	
	/**
	 * 
	 * @desc Set footer html
	 * @param string $html
	 */
	public function setHtmlFooter($html) {
		if(is_array($html)) {
			foreach($html as $line) {
				$this->html_footer[] = $line;
			}
		} else {
			$file = strtolower($html);
			
			if(file_exists($html)) {
				require_once $html;
				
				if(isset($content) && isset($content) != '') {
					foreach($content as $line) {
						$this->html_foot[] = $line;
					}
				}
			}
		}
	}	
	
	/**
	 * 
	 * @TODO
	 */
	public function render() {
		$con = array($this->html_head, $this->header, $this->navigation, $this->sidebar, $this->content, $this->html_footer);
		
		foreach($con as $arr) {
			foreach($arr as $i) {
				if(is_array($i)) {
					foreach($i as $j) {
						echo $j . "\n";
					}
				} else {
					echo $i . "\n";
				}
			}
		}
	}
}

?>