<?php

class AutoTemplate {

    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getCode($file,$params){
        extract($params);
        $file = dirname(__FILE__).'/views/'.$file.'.php';
        if(!is_file($file)) {
            throw new Exception('view file not exists.');
        }
        else {
            ob_start();
            include($file);
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }

    }

}