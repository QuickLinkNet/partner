<?php
ini_set('memory_limit','512M');
ini_set('max_execution_time', 300);

/**
 * Load Autoloader
 */
require_once '../library/Drunken/Autoloader.php';
$autoloader = autoloader::getInstance();
spl_autoload_register(array('Autoloader', 'autoload'));

set_include_path('../library/' . PATH_SEPARATOR . get_include_path());
set_include_path('../library/mpdf60/' . PATH_SEPARATOR . get_include_path());

defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__) . '/../public/'));
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
defined('PUBLIC_CSS_PATH') || define('PUBLIC_CSS_PATH', realpath(dirname(__FILE__) . './css'));
defined('PUBLIC_IMAGE_PATH') || define('PUBLIC_IMAGE_PATH', realpath(dirname(__FILE__) . '/images'));

Drunken_Config_Ini::setConfig(APPLICATION_PATH . '/configs/application.ini');


$db = new Drunken_Database();


if(isset($_GET['test']) && $_GET['test'] == 1) {

    $row = 1;
    if (($handle = fopen("obi_at.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $num = count($data);
//            echo "<p> $num Felder in Zeile $row: <br /></p>\n";
            $row++;

//            $address = utf8_encode($data[0]);
            $latitude = utf8_encode($data[1]);
            $longitude = utf8_encode($data[2]);
            $zip_code = utf8_encode($data[3]);
            $city = utf8_encode($data[4]);
            $address = utf8_encode($data[5]);

            $sql = 'INSERT INTO owner (salutation, company, address, zip_code, city)';
            $sql .= ' VALUES ("contact", "OBI - AT", "'.$address.'", "'.$zip_code.'", "'.$city.'")';

            if(Drunken_Database::query($sql)) {
                $ownerId = (Drunken_Database::getAutoIncrement('owner')['auto_increment'] - 1);

                $sql = 'INSERT INTO acquisition (owner_id, user_id, companies_id, job_types_id, owner_types_id, okz_id, manufacturer_id, status_course_id, address, contract_duration, rent_offer, quantity, frequency)';
                $sql .= ' VALUES ("'.$ownerId.'", "3", "1", "7", "2", "1", "2", "1", "'.$address.'", "0", "0", "1", "2")';

                if(Drunken_Database::query($sql)) {
                    $aqId = (Drunken_Database::getAutoIncrement('acquisition')['auto_increment'] - 1);
                    $date = new DateTime();
                    $sc = new Drunken_StatusCourse();
                    $sc->__set('acquisition_id', $aqId);
                    $sc->__set('user_id', 3);
                    $sc->__set('status_id', 120);
                    $sc->__set('datetime', $date->format('Y-m-d H:i:s'));
                    $sc->__set('description', 'OBI - AT');
                    if($sc->setStatusCourse()) {
                        $po = new Drunken_Partner_Offer();
                        $po->__set('acquisition_id', $aqId);
                        $po->__set('partner_id', 29);
                        $po->__set('visible', 1);
                        $po->__set('offer', 0);
                        $po->__set('returned', 0);
                        $po->__set('accepted', 0);
                        $po->__set('seen', 1);
                        $po->__set('comment', "OBI - AT");
                        $po->__set('datetime', $date->format('Y-m-d H:i:s'));

                        if($po->setPartnerOffer()) {

                            $sql = 'INSERT INTO acquisition_geo (acquisition_id, longitude, latitude, datetime)';
                            $sql .= ' VALUES ("'.$aqId.'", "'.str_replace(',', '.', $longitude).'", "'.str_replace(',', '.', $latitude).'", "'.$date->format('Y-m-d H:i:s').'")';

                            if(Drunken_Database::query($sql)) {
//                                echo 'Die -> First :)';
//                                die();
                            } else {
                                echo 'Geo Error...';
                                die();
                            }
                        } else {
                            echo 'PartnerOffer Error...';
                            die();
                        }
                    } else {
                        echo 'StatusCourse Error...';
                        die();
                    }
                } else {
                    echo 'Acquisition Error...';
                    die();
                }

            } else {
                echo 'Owner_error...';
                die();
            }

//            die('First without error?!');
        }
        fclose($handle);
    }

    die('Ende...');
}




$application = new Drunken_Application();

?>