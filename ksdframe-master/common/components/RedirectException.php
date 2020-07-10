<?php
/**
 * Class DeniedException
 */

namespace common\components;

class RedirectException extends SException{
    public function __construct($message='Redirect...',$url='',$time=0)
    {
        $params = array(
            'url' => $url,
            'time' => $time,
        );
        parent::__construct($message, '99', $params);
    }

    public function getUrl(){
        return $this->getParam('url');
    }
}
