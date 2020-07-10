<?php
/**
 * Class DeniedException
 */

namespace common\components;

class DeniedException extends SException{
    public function __construct($message='Access Denied!', array $params = array())
    {
        parent::__construct($message, '-9', $params);
    }
}
