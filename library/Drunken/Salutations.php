<?php

/**
 * @desc Salutations
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @version 1.0;
 */


class Drunken_Salutations
{
    private static $salutations = Array('female' => 'Frau', 'male' => 'Herr', 'family' => 'Familie', 'contact' => 'Kontakt');
    
    public static function translateSalutation($salutation) {
        if(@self::$salutations[$salutation]) {
          return self::$salutations[$salutation];
        }
    }
    
    public static function getSalutations() {
      return self::$salutations;
    }
}
?>