<?php

 /**
  * #bb_makeGuid
  * @return string a guid for database storage
  */
  function makeGuid(){

    if (function_exists('com_create_guid')){

        return com_create_guid();

    }
    else {
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);

        return $uuid;
    }
}


/**
 * Check that a guid is the right format
 * @param string $guid
 */
function isGuid($guid){

    if(preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/', $guid)) {
        return true ;
    }

    return false ;

}