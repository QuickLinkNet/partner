<?php

Drunken_Header::setDocumentReady('

$(\'#nbi li ul\').hide().removeClass(\'fallback\');
$(\'#nbi li\').hover(
    function () {
        $(\'ul\', this).stop().slideDown(100);
    },
    function () {
        $(\'ul\', this).stop().slideUp(100);
    }
);

');

Drunken_Header::setJs(array('/js/header.js'));

$content = array();

$content[] = '<div class="gradient-blue-white fl" id="navigation-wrapper">';
$content[] = '  <div id="navigation">';
$content[] = '    <div id="navigation-inner">';
$content[] = '      <div id="nb">';
$content[] = '      	<div id="nbi">';

$nav = new Drunken_Navigation();

$nav_sites['logout']['title'] = 'Logout';
$nav_sites['logout']['href'] = $this->config->domain . 'Logout';
$nav_sites['logout']['icon'] = 'logout_25';
$nav_sites['logout']['id'] = 'logout';

if(Drunken_User::getUserId() != 25) {
    $nav_sites['appointments']['title'] = '';
    $nav_sites['appointments']['icon'] = 'bell_25';
    $nav_sites['appointments']['id'] = 'bell_partner_offer';
}

$content[] = $nav->getNavigation($nav_sites);

$content[] = '      	</div>';
$content[] = '      </div>';
$content[] = '      <div class="cb"></div>';
$content[] = '    </div>';
$content[] = '  </div>';
$content[] = '</div>';
$content[] = '<div class="cb"></div>';

?>