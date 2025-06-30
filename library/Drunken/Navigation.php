<?php

/**
 * 
 * @desc Get the Navigation by User-type
 * (admin / user)
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @copyright Manuel Kramm
 *
 */
class Drunken_Navigation
{
	/**
	 * 
	 * @desc Site-Type (admin / user)
	 * @var string
	 */
	public $site_type = '';
	
	/**
	 * 
	 * @desc Get out the sidebar navigation
	 * (admin / user)
	 */
	public function getSideNavigation($sites)
	{
		$return = '';
		
		if(count($sites) > 0) {
			$i = 0;
			
			$params = new Drunken_Parameter();
			
			foreach($sites as $site) {
				$class = '';
				$subvis = false;
				
				if(isset($params->controller) && strtolower($params->controller) == strtolower($site['title'])) {
					$class .= 'current-nbutton ';
					$subvis = true;
				}
				else {
					$class .= 'nbutton ';
				}
				
				if($i == 0) { $class .= 'first '; }
				if($i == (count($sites) - 1)) { $class .= 'last '; }
				
				if(isset($site['href'])) {
					$jhref = 'window.location.href = \''.$site['href'].'\';';
				}
				else { 
					$jhref = '';
				}
				
				$return .= '          <div id="'.$site['id'].'" class="'.$class.'" onclick="javascript:if($(this).next().next().attr(\'class\') == \'subnav\') { $(this).next().next().slideToggle(); }; '.$jhref.'">' . "\n";
				$return .= '      	    <div class="fl icon '.$site['icon'].'_'.$site['icon-size'].'">' . "\n";
				$return .= '      	    </div>' . "\n";
				$return .= '      	    <div class="nav-title fl">' . $site['title'] . '</div>' . "\n";
				
				if(isset($site['sub'])) {
					$return .= '          <div class="fr count count_dark_25">'.count($site['sub']).'</div>' . "\n";
				}
				
				$return .= '      	  </div>' . "\n";
				$return .= '      	    <div class="cb"></div>' . "\n";
				
				$i++;
				
				if(isset($site['sub'])) {
					if($subvis == false) {
						$return .= '          <div class="subnav" style="display:none;">' . "\n";
					} else {
						$return .= '          <div class="subnav" style="display:block;">' . "\n";
					}
					
					
					foreach($site['sub'] as $sub) {
						$subnav_class = '';
						
						$return .= '          <div class="sub">' . "\n";
						$return .= '            <div class="sub-a fl">' . "\n";
						$return .= '          	  <a href="'.$sub['href'].'" title="'.$sub['title'].'">' . $sub['title'] . '</a>' . "\n";
						$return .= '            </div>' . "\n";
						
						if(isset($params->action) && $params->action == Drunken_Slug::getSlug($sub['title'])) {
							$return .= '          	    <div class="fr sub-current"></div>' . "\n";
						}
						$return .= '          </div>' . "\n";
					}
					
					$return .= '          </div>' . "\n";
				}
			}
		}
		else
		{
			if(isset($this->site_type))
			{
				$sql = 'SELECT * FROM ' . $this->site_type;
				$query = Drunken_Database::query($sql);
				$sites = Drunken_Database::fetchObject($query);
				
				foreach($sites as $site)
				{
					
				}
			}
		}
		
		return $return;
	}
	
	
	/**
	 * 
	 * @desc Get out the sidebar navigation
	 * (admin / user)
	 */
	public function getNavigation($sites)
	{
		$return = '';
		
		if(count($sites) > 0) {
			$i = 0;
			
			$params = new Drunken_Parameter();
			
			$return .= '          <ul class="nav">' . "\n";
			
			foreach($sites as $site) {
				$class = '';
				$subvis = false;
				
				if(isset($params->controller) && strtolower($params->controller) == strtolower($site['title'])) {
					$class .= 'current-nbutton ';
					$subvis = true;
				} else {
					$class .= 'nbutton ';
				}
				
				if($i == 0) { $class .= 'first '; }
				if($i == (count($sites) - 1)) { $class .= 'last '; }
				
				if(isset($site['href'])) {
					$jhref = 'window.location.href = \''.$site['href'].'\';';
				} else { 
					$jhref = '';
				}
				
				$return .= '            <li id="'.$site['id'].'" class="'.$class.'" onclick="javascript:if($(this).next().next().attr(\'class\') == \'subnav\') { $(this).next().next().slideToggle(); }; '.$jhref.'">' . "\n";
				$return .= '      	      <div class="element_holder">' . "\n";
				$return .= '      	        <div class="fl icon '.$site['icon'].'">' . "\n";
				$return .= '      	        </div>' . "\n";
				$return .= '      	        <div class="nav-title fl">' . $site['title'] . '</div>' . "\n";
				$return .= '      	        <div class="cb"></div>' . "\n";
				$return .= '              </div>' . "\n";
				
				$i++;
				
				if(isset($site['sub'])) {
					$return .= '              <ul class="nav-drop">' . "\n";
					
					foreach($site['sub'] as $sub) {
						$subnav_class = '';
						
						$return .= '                <li>' . "\n";
						$return .= '                  <a href="'.$sub['href'].'" title="'.$sub['title'].'">' . $sub['title'] . '</a>' . "\n";
						$return .= '                </li>' . "\n";
					}
					$return .= '              </ul>' . "\n";
				}
				$return .= '      	    </li>' . "\n";
			}
			$return .= '          </ul>';
		} else {
			if(isset($this->site_type))
			{
				$sql = 'SELECT * FROM ' . $this->site_type;
				$query = Drunken_Database::query($sql);
				$sites = Drunken_Database::fetchObject($query);
				
				foreach($sites as $site)
				{
					
				}
			}
		}
		return $return;
	}
}

?>