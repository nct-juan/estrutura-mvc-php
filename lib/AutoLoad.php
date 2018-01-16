<?php

//define('PATH_ROOT', dirname(__FILE__));
//set_include_path( '.' . PATH_SEPARATOR . realpath( '../common' ) . DIRECTORY_SEPARATOR . PATH_SEPARATOR . get_include_path() );
set_include_path(ini_get("include_path").":/var/www/".URL_PATH."/estrutura-mvc-php");

spl_autoload_register(

   function( $classname )
   {
       require_once str_replace( '\\', DIRECTORY_SEPARATOR, $classname ) . '.php';
   }

);
?>