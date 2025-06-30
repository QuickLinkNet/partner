<?php

/**
 *
 * @author Manuel Kramm
 * @desc Send a MySql-Query to DB
 * @license Manuel Kramm
 * @copyright Manuel Kramm
 * @version 1.0b
 *
 */
class AjaxController
{
	/**
	 *
	 * Query variable
	 * @var string
	 */
	private $query = '';

	/**
	 *
	 * Enter description here ...
	 * @param unknown_type $application
	 */
  public function init($application)
  {
    $return = Array();
    $return['error'] = Array();
    
    $vars = $application->params->vars;
    
    if(isset($vars['query']) && $vars['query'] != '') {
      $this->query = $vars['query'];
    } else if(isset($_POST)) {
      $post = json_encode($_POST);
      
      if(json_decode($post) != NULL) {
        $post = json_decode($post, true);
      }
      
      if(isset($post->query)) {
        $this->query = $post->query;
      } else {
        $this->query = $post;
      }
    }
  }
  
	public function acceptOffer() {
    if(isset($_POST['aid']) && $_POST['aid'] != '') {
      echo json_encode(Drunken_Partner_Offer::acceptOffer($_POST['aid'], $_POST['comment']));
    }
  }
  
	public function rejectOffer() {
    if(isset($_POST['aid']) && $_POST['aid'] != '') {
      echo json_encode(Drunken_Partner_Offer::rejectOffer($_POST['aid'], $_POST['comment']));
    }
  }
    
  public static function getAcquisitionsNew() {
    $acquisitions = Drunken_Acquisition::getAcquisitionsNew($_POST);
    echo json_encode($acquisitions);
  }
    
    /**
     *
     * Enter description here ...
     * @param unknown_type $application
    */
  public function changeStatus($application) {
    $return = Array('data' => '', 'success' => true, 'success_msg' => Array(), 'error_msg' => Array());
    
    if(!isset($_POST['aid']) || !Drunken_Acquisition::acquisitionExist($_POST['aid'])) {
      $return['error_msg'][] = 'Keine Akquisitions-ID erhalten oder ung�ltig.';
      $return['success'] = false;
    }
     if(!isset($_POST['sid']) || $_POST['sid'] == '') {
      $return['error_msg'][] = 'Keine Status-ID erhalten oder ung�ltig.';
      $return['success'] = false;
    }
    
    isset($_POST['description']) ? $description = $_POST['description'] : $description = '';
    
		isset($_POST['period']) && $_POST['period'] != '' ? $period = substr($_POST['period'], 6, 4) . '-' . substr($_POST['period'], 3, 2) . '-' . substr($_POST['period'], 0, 2) . ' ' . substr($_POST['period'], 11, 2) . ':' . substr($_POST['period'], 14, 2)
    : $period = '';
    
    /**
     * Check status if period is needed
     */
    if(in_array($_POST['sid'], Array(10, 14))) {
      if($period == '') {
        $return['error_msg'][] = 'Dieser Status ben�tigt einen Termin.';
        $return['success'] = false;
      }
    }
    
    if($return['success'] == true) {
      $date = new DateTime();

      $status_course = new Drunken_StatusCourse();
      $status_course->__set('acquisition_id', $_POST['aid']);
      $status_course->__set('partner_contact_person_id', Drunken_User::getUserId());
      $status_course->__set('status_id', $_POST['sid']);
      $status_course->__set('datetime', $date->format('Y-m-d H:i:s'));
      $status_course->__set('description', $description);
      $status_course->__set('period', $period);
      
      if($status_course->setStatusCourse()) {
        $return['success_msg'][] = 'Status wurde erfolgreich ge�ndert.';
        $return['success'] = true;
      } else {
        $return['success_msg'][] = 'Status konnte leider nicht ge�ndert werden. Bitte kontaktieren Sie den Support.';
        $return['success'] = false;
      }
      echo json_encode($return);
    } else {
      echo json_encode($return);
    }
  }

  public function getUser() {
    echo json_encode(Drunken_Partner_ContactPerson::getContactPerson(Drunken_User::getUserId()));
  }
  
	public function getUserId() {
    echo json_encode(Drunken_User::getUserId());
  }
  
  public function deleteFile() {
    if(isset($_POST['file']) && $_POST['file'] != '') {
      if(unlink($_POST['file'])) {
        echo json_encode(true);
      } else {
        echo json_encode(false);
      }
    }
  }
  
  public function getSalutations() {
    echo json_encode(Drunken_Salutations::getSalutations());
  }
}

?>
