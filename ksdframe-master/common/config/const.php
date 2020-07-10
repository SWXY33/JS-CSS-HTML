<?php
define('SYSTEM_MODE_DEBUG',true);
define('STATIC_URL','/static');
//define('BASE_URL','/frontend/web');
define('SYSTEM_ROOT',dirname(__FILE__).'/../..');

define('REQUEST_TYPE_NORMAL',0);
define('REQUEST_TYPE_AJAX',1);
define('REQUEST_TYPE_JSON',3);
define('REQUEST_TYPE_JSONP',4);
define('REQUEST_TYPE_WXAPP',5);

define('KEY_NOT_SET_VALUE','KEY_NOT_SET_VALUE');

define('SYSTEM_DATA_ID_BASE',0);
define('SYSTEM_DEFAULT_USER_ID',1);

define('SYSTEM_BOOL_TRUE',1);
define('SYSTEM_BOOL_FALSE',0);

//管理员状态
define('ADMIN_STATE_LOCKED',0);//未激活
define('ADMIN_STATE_ACTIVE',1);//正常
define('ADMIN_STATE_CLOSE',-1);//禁用

