<?php

/**
 * 
 * @desc TODO
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @copyright Manuel Kramm
 * @version 1.0
 */
class DashboardController
{
	/**
	 * 
	 * @desc TODO
	 * @param object $application
	 */
    public function init($application) {

    }
		
    /**
     * 
     * @desc TODO
     * @param object $application
     */
    public function indexAction($application) {
    	$params = new Drunken_Parameter();
    	
    	if(isset($params->vars['id']) && $params->vars['id'] != '') {
				self::getPartnerDashboardDetails($application);
			} else {
      	self::getPartnerDashboard($application);
			}
    }
    
    public function getPartnerDashboard($application) {
      Drunken_Header::setJs(Array('/js/dashboard/partner_list.js'));
      Drunken_Header::setJs(Array('/js/jquery.table2excel.js'));

      //	Get new Viewer Set the File-Path
      $view = new Drunken_View();
      $view->config = $application->config;
      $view_path = $view->config->resources->view->path;

      $view->iUserId = Drunken_User::getUserId();

      if(!$_SESSION['type']) {
        header('Location: ' . $view->config->domain . '/Logout');
      }

      if(isset($_SESSION['type']) && $_SESSION['type'] == 'user') {
      	$view->user_id = Drunken_User::getUserId();
      }
      
      //	Get new Viewer Set the File-Path
      $view->setHeader($view->config->components->path . 'header.php');
      $view->setNavigation($view->config->components->path . 'navigation.php');
      $view->setContent($view_path . $application->params->controller . '/' . 'partner_list.phtml');
      $view->setHtmlHead(Drunken_Header::getHeader());
      $view->render();
    }
    
    public function getPartnerDashboardDetails($application) {
      Drunken_Header::setCss(Array('/css/jquery.fancybox-1.3.4.css'));
      Drunken_Header::setJs(Array('/js/jquery.fancybox-1.3.4.pack.js'));
      
      Drunken_Header::setJs(Array('/js/dashboard/partner_details.js'));
      Drunken_Header::setJs(array('https://maps.googleapis.com/maps/api/js?key=AIzaSyDJ74cjZBM65nCGQ0AB1ZDiha_YpMZN_mw'));

      //	Get new Viewer Set the File-Path
      $view = new Drunken_View();
      $view->config = $application->config;
      $view_path = $view->config->resources->view->path;

      $view->iPartnerId = Drunken_User::getUserId();

      $params = new Drunken_Parameter();

      if(!Drunken_Partner_Offer::checkOffer($view->iPartnerId, $params->vars['id'])) {
          header('Location: ' . $view->config->domain . 'Logout');
      }

      if(isset($params->vars['id'])) {
      	$acquisition = Drunken_Acquisition::getAcquisitionById($params->vars['id']);
      	
      	$sql = "SELECT * FROM acquisition_geo WHERE acquisition_id = " . $params->vars['id'] . " LIMIT 1";
      	$query = Drunken_Database::query($sql);
	      
      	
      	if(mysqli_num_rows($query) > '0') {
      		$geo = Drunken_Database::fetchObject($query);
      		$acquisition->longitude = $geo->longitude;
	        $acquisition->latitude = $geo->latitude;
        }
      	
        $view->aq = $acquisition;
        
        $view->partner_offer = Drunken_Partner_Offer::getLastOfferByAcquisitionId($view->aq->id);
        $view->original_image = Drunken_Acquisition::getOriginalAcquisitionPhotobyId($view->aq->id);
        $view->offer_image = Drunken_Acquisition::getRetouchedAcquisitionPhotobyId($view->aq->id);
        $view->status_course = Drunken_StatusCourse::getStatCourse($view->aq->id);
      }


        /*****************************************************************************/
        /********************************** OBI **************************************/
        /*****************************************************************************/

        if(strpos($_SERVER['HTTP_HOST'], 'dev') !== false) {
            $sBase = './data/';
        } else {
            $sBase = './data/';
        }

        $sObiIsDir = $sBase . 'obi_is/' . $view->aq->id . '/';
        $sObiShouldDir = $sBase . 'obi_should/' . $view->aq->id . '/';
        $sObiOtherDir = $sBase . 'obi_other/' . $view->aq->id . '/';

        $sBaseLinkDir = strpos($_SERVER['HTTP_HOST'], 'dev') ? 'partner.crm-standortfabrik-dev.de/data/' : 'api.crm-standortfabrik.de/data/';

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        if(is_dir($sObiIsDir)) {
            $view->obi_is_attachments = ['images' => array(), 'data' => array()];

            $aObiIsFiles = scandir($sObiIsDir);

            foreach($aObiIsFiles as $key => $file) {
                if($file != '.' && $file != '..') {
                    if(strpos($file, 'thumb_') === false) {
                        $sTime = substr($file, 0, 14);
                        $sTime = substr($sTime, 6, 2) . '.' . substr($sTime, 4, 2) . '.' . substr($sTime, 0, 4) . ' ' . substr($sTime, 8, 2) . ':' . substr($sTime, 10, 2);

                        $f = [
                            'name' => explode('_', $file)[1],
                            'time' => $sTime,
                            'url' => $protocol . $sBaseLinkDir . 'obi_is/' . $params->vars['id'] . '/' . $file,
                            'thumb' => null,
                        ];

                        if(is_file($sObiIsDir . '/' . 'thumb_' . $file)) {
                            $f['thumb'] = $protocol . $sBaseLinkDir . 'obi_is/' . $params->vars['id'] . '/thumb_' . $file;
                        }

                        if(@is_array(getimagesize($sObiIsDir . '/' . $file))) {
                            array_push($view->obi_is_attachments['images'], $f);
                        } else {
                            array_push($view->obi_is_attachments['data'], $f);
                        }
                    }
                }
            }
            $view->obi_is_attachments['images'] = Drunken_Functions::obiSorting($view->obi_is_attachments['images']);
        }

//        echo '<pre>';
//        print_r($view->obi_is_attachments);
//        echo '</pre>';
//
//        die();

        if(is_dir($sObiShouldDir)) {

            $view->obi_should_attachments = ['images' => array(), 'data' => array()];;

            $aObiShouldFiles = scandir($sObiShouldDir);
            foreach($aObiShouldFiles as $key => $file) {
                if($file != '.' && $file != '..') {
                    if(strpos($file, 'thumb_') === false) {
                        $sTime = substr($file, 0, 14);
                        $sTime = substr($sTime, 6, 2) . '.' . substr($sTime, 4, 2) . '.' . substr($sTime, 0, 4) . ' ' . substr($sTime, 8, 2) . ':' . substr($sTime, 10, 2);

                        $f = [
                            'name' => explode('_', $file)[1],
                            'time' => $sTime,
                            'url' => $protocol . $sBaseLinkDir . 'obi_should/' . $params->vars['id'] . '/' . $file,
                            'thumb' => null,
                        ];

                        if(is_file($sObiShouldDir . '/' . 'thumb_' . $file)) {
                            $f['thumb'] = $protocol . $sBaseLinkDir . 'obi_should/' . $params->vars['id'] . '/' . $file;
                        }

                        if(@is_array(getimagesize($sObiShouldDir . '/' . $file))) {
                            array_push($view->obi_should_attachments['images'], $f);
                        } else {
                            array_push($view->obi_should_attachments['data'], $f);
                        }
                    }
                }
            }
            $view->obi_should_attachments['images'] = Drunken_Functions::obiSorting($view->obi_should_attachments['images']);
        }

        if(is_dir($sObiOtherDir)) {

            $view->obi_other_attachments = ['images' => array(), 'data' => array()];;

            $aObiOtherFiles = scandir($sObiOtherDir);
            foreach($aObiOtherFiles as $key => $file) {
                if($file != '.' && $file != '..') {
                    if(strpos($file, 'thumb_') === false) {
                        $sTime = substr($file, 0, 14);
                        $sTime = substr($sTime, 6, 2) . '.' . substr($sTime, 4, 2) . '.' . substr($sTime, 0, 4) . ' ' . substr($sTime, 8, 2) . ':' . substr($sTime, 10, 2);

                        $f = [
                            'name' => explode('_', $file)[1],
                            'time' => $sTime,
                            'url' => $protocol . $sBaseLinkDir . 'obi_other/' . $params->vars['id'] . '/' . $file,
                            'thumb' => null,
                        ];

                        if(is_file($sObiOtherDir . '/' . 'thumb_' . $file)) {
                            $f['thumb'] = $protocol . $sBaseLinkDir . 'obi_other/' . $params->vars['id'] . '/' . $file;
                        }

                        if(@is_array(getimagesize($sObiOtherDir . '/' . $file))) {
                            array_push($view->obi_other_attachments['images'], $f);
                        } else {
                            array_push($view->obi_other_attachments['data'], $f);
                        }
                    }
                }
            }
            $view->obi_other_attachments['images'] = Drunken_Functions::obiSorting($view->obi_other_attachments['images']);
        }

    	$search = Array('�', '�', '�', '�', '�', '�', '�');
        $replace = Array('ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss');
        
        
        /**
         * Fileupload client attachments
         */
        
        $user_upload_dir = $view->config->user_upload_dir;
        
        $uploaddir = '/client_attachments/';
        $dir = $view->aq->id;
        
        if(!file_exists($user_upload_dir . $uploaddir . $dir)) {
          mkdir($user_upload_dir . $uploaddir . $dir, 0777, true);
        }
        
        if(isset($_FILES) && isset($_FILES['client-attachment-upload']) && count($_FILES['client-attachment-upload']) > 0) {
          $date = new DateTime();
          $date = $date->format('YmdHis');
          
          $uploadfile = $uploaddir . $dir . '/' . $date . '_' . basename($_FILES['client-attachment-upload']['name']);
          $uploadfile = str_replace($search, $replace, $uploadfile);
          
          if(pathinfo($_FILES['client-attachment-upload']['name'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($_FILES['client-attachment-upload']['name'], PATHINFO_EXTENSION) == 'jpeg') {
            $image = imagecreatefromjpeg($_FILES['client-attachment-upload']['tmp_name']);
            $size = getimagesize($_FILES['client-attachment-upload']['tmp_name']);
            $src_w = $size[0];
            $src_h = $size[1];
            
            $dst_w = '1200';
            $dst_h = '900';
            
            $thumb = imagecreatetruecolor($dst_w, $dst_h);
            imagecopyresampled($thumb, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
            
            if(imagejpeg($thumb, $uploadfile, 85)) {
              
            } else {
              /**
               * TODO
               * ERROR
               */
            }
          } else {
            move_uploaded_file($_FILES['client-attachment-upload']['tmp_name'], $user_upload_dir . $uploadfile);
          }
        }
        
        
    		/**
         * Client attachments
         */
        $view->client_attachments = Array();
        
        $scan = scandir($user_upload_dir . '/client_attachments/' . $dir);
        $attachment_link = '';
        
        foreach($scan as $key => $file) {
          if($file != '.' && $file != '..' && strpos($file, 'svn') === false) {
            array_push($view->client_attachments, $file);
          }
        }
        
        
        /**
         * Fileupload land registry
         */
        $uploaddir = '/land_registry_attachments/';
        $dir = $view->aq->id;
        if(!file_exists($user_upload_dir . $uploaddir . $dir)) {
          mkdir($user_upload_dir . $uploaddir . $dir, 0777, true);
        }
        
        if(isset($_FILES) && isset($_FILES['land-registry-attachment-upload']) && count($_FILES['land-registry-attachment-upload']) > 0) {
          $date = new DateTime();
          $date = $date->format('YmdHis');
          
          $uploadfile = $uploaddir . $dir . '/' . $date . '_' . basename($_FILES['land-registry-attachment-upload']['name']);
          $uploadfile = str_replace($search, $replace, $uploadfile);
          
          
          if(pathinfo($_FILES['land-registry-attachment-upload']['name'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($_FILES['land-registry-attachment-upload']['name'], PATHINFO_EXTENSION) == 'jpeg') {
            $image = imagecreatefromjpeg($_FILES['land-registry-attachment-upload']['tmp_name']);
            $size = getimagesize($_FILES['land-registry-attachment-upload']['tmp_name']);
            $src_w = $size[0];
            $src_h = $size[1];
            
            $dst_w = '1200';
            $dst_h = '900';
            
            $thumb = imagecreatetruecolor($dst_w, $dst_h);
            imagecopyresampled($thumb, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
            
            if(imagejpeg($thumb, $uploadfile, 85)) {
              
            } else {
              /**
               * TODO
               * ERROR
               */
            }
          } else {
            move_uploaded_file($_FILES['land-registry-attachment-upload']['tmp_name'], $user_upload_dir . $uploadfile);
          }
        }
        
    		/**
         * Land registry attachments
         */
        $view->land_registry_attachments = Array();
        
        $scan = scandir($user_upload_dir . $uploaddir . $dir);
        $attachment_link = '';
        
        foreach($scan as $key => $file) {
          if($file != '.' && $file != '..' && strpos($file, 'svn') === false) {
            array_push($view->land_registry_attachments, $file);
          }
        }
        
        
     		/**
         * Fileupload court
         */
        $uploaddir = '/court_attachments/';
        $dir = $view->aq->id;
        if(!file_exists($user_upload_dir . $uploaddir . $dir)) {
          mkdir($user_upload_dir . $uploaddir . $dir, 0777, true);
        }
        
        if(isset($_FILES) && isset($_FILES['court-attachment-upload']) && count($_FILES['court-attachment-upload']) > 0) {
          $date = new DateTime();
          $date = $date->format('YmdHis');
          
          $uploadfile = $uploaddir . $dir . '/' . $date . '_' . basename($_FILES['court-attachment-upload']['name']);
          $uploadfile = str_replace($search, $replace, $uploadfile);
          
          if(pathinfo($_FILES['court-attachment-upload']['name'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($_FILES['court-attachment-upload']['name'], PATHINFO_EXTENSION) == 'jpeg') {
            $image = imagecreatefromjpeg($_FILES['court-attachment-upload']['tmp_name']);
            $size = getimagesize($_FILES['court-attachment-upload']['tmp_name']);
            $src_w = $size[0];
            $src_h = $size[1];
            
            $dst_w = '1200';
            $dst_h = '900';
            
            $thumb = imagecreatetruecolor($dst_w, $dst_h);
            imagecopyresampled($thumb, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
            
            if(imagejpeg($thumb, $uploadfile, 85)) {
              
            } else {
              /**
               * TODO
               * ERROR
               */
            }
          } else {
            move_uploaded_file($_FILES['court-attachment-upload']['tmp_name'], $user_upload_dir . $uploadfile);
          }
        }
        
    		/**
         * Land registry attachments
         */
        $view->court_attachments = Array();
        
        $scan = scandir($user_upload_dir . $uploaddir . $dir);
        $attachment_link = '';
        
        foreach($scan as $key => $file) {
          if($file != '.' && $file != '..' && strpos($file, 'svn') === false) {
            array_push($view->court_attachments, $file);
          }
        }
        
        
    		/**
         * Fileupload land registry
         */
        $uploaddir = '/lawyer_attachment/';
        $dir = $view->aq->id;
        if(!file_exists($user_upload_dir . $uploaddir . $dir)) {
          mkdir($user_upload_dir . $uploaddir . $dir, 0777, true);
        }
        
        if(isset($_FILES) && isset($_FILES['lawyer-attachment-upload']) && count($_FILES['lawyer-attachment-upload']) > 0) {
          $date = new DateTime();
          $date = $date->format('YmdHis');
          
          $uploadfile = $uploaddir . $dir . '/' . $date . '_' . basename($_FILES['lawyer-attachment-upload']['name']);
          $uploadfile = str_replace($search, $replace, $uploadfile);
          
          if(pathinfo($_FILES['lawyer-attachment-upload']['name'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($_FILES['lawyer-attachment-upload']['name'], PATHINFO_EXTENSION) == 'jpeg') {
            $image = imagecreatefromjpeg($_FILES['lawyer-attachment-upload']['tmp_name']);
            $size = getimagesize($_FILES['lawyer-attachment-upload']['tmp_name']);
            $src_w = $size[0];
            $src_h = $size[1];
            
            $dst_w = '1200';
            $dst_h = '900';
            
            $thumb = imagecreatetruecolor($dst_w, $dst_h);
            imagecopyresampled($thumb, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
            
            if(imagejpeg($thumb, $uploadfile, 85)) {
              
            } else {
              /**
               * TODO
               * ERROR
               */
            }
          } else {
            move_uploaded_file($_FILES['lawyer-attachment-upload']['tmp_name'], $uploadfile);
          }
        }
        
    		/**
         * Land registry attachments
         */
        $view->lawyer_attachments = Array();
        
        $scan = scandir($user_upload_dir . $uploaddir . $dir);
        $attachment_link = '';
        
        foreach($scan as $key => $file) {
          if($file != '.' && $file != '..' && strpos($file, 'svn') === false) {
            array_push($view->lawyer_attachments, $file);
          }
        }
      
      
      //	Get new Viewer Set the File-Path
      $view->setHeader($view->config->components->path . 'header.php');
      $view->setNavigation($view->config->components->path . 'navigation.php');
      $view->setContent($view_path . $application->params->controller . '/' . 'partner_details.phtml');
      $view->setHtmlHead(Drunken_Header::getHeader());
      $view->render();
    }
    
}

?>