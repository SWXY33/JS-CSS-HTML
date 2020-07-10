<?php
function CONFIG($key) {
    static $data = array();
    if( !isset($data[$key]) ) {
        $data[$key] = \common\models\Param::getConfig($key);
    }
    return $data[$key];
}

