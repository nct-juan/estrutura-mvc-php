<?php

namespace lib;

//CONSTANTES DO SISTEMA

$urlSystem = $_SERVER['HTTP_HOST'];
$urlAdmin  = strpos($urlSystem, 'app.');
$urlParts  = isset($_GET['url']) ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)) : Array(0=>"");

if($urlAdmin === 0)
{
    define('ADM_AREA', 1);
    $urlPath = substr($urlSystem,4);
    $urlPath = $urlPath;
}
else
{
    define('ADM_AREA', 0);
    $urlPath = $urlSystem;
}

define('URL_SYSTEM', $urlSystem);
define('URL_PATH', $urlPath);
define('URL_PARTS', $urlParts);
define('URL_HTTP', '//'.$urlSystem);
# ADM_AREA

?>