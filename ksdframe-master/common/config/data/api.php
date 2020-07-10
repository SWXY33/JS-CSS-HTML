<?php
$dataPath = dirname(__FILE__).'/api';
$dir = dir($dataPath);
$data = array();
while( $file=$dir->read() ) {
    if( strpos($file,'.php') ) {
        $key = str_replace('.php','',$file);
        $data[$key] = include($dataPath.'/'.$file);
    }
}
return $data;
