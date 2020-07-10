<?php
include  dirname(__FILE__).'/const.php';
include  dirname(__FILE__).'/functions.php';
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=git.kasday.cn;dbname=dev_ksdframe',
            'username' => 'ksdframe',
            'password' => 'secret2020',
            'charset' => 'utf8',
        ],
        // 'wechat' => [
        //     'class' => 'jianyan\easywechat\Wechat',
        //     'userOptions' => [],  // 用户身份类参数
        //     'sessionParam' => 'wechatUser', // 微信用户信息将存储在会话在这个密钥
        //     'returnUrlParam' => '_wechatReturnUrl', // returnUrl 存储在会话中
        //     'rebinds' => [ // 自定义服务模块 
        //         // 'cache' => 'common\components\Cache',
        //     ]
        // ],
        
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // 'cache' => [
        //     'class' => 'yii\caching\MemCache',
        //     'servers' => [
        //         [
        //             'host' => '192.168.1.2',
        //             'port' => 11211,
        //             'weight' => 60,
        //         ],
        //     ],
        // ],
        'objectLoader' => [
            'class' => 'common\components\SimpleObjectLoader',
        ],

        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'queue', // Queue channel key
            'deleteReleased' => false,
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
        ],

        /*
        'queue' => [ //beanstalk队列配置
            'class' => \yii\queue\beanstalk\Queue::class,
            'host' => 'localhost',
            'port' => 11300,
            'tube' => 'queue',
        ],
        
        'queue' => [//队列文件方式
            'class' => \yii\queue\file\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,//错误日志 默认为 console/runtime/logs/app.log
            'path' => '@console/runtime/queue',//这样控制台才能操作到
            //'path' => '@runtime/queue',
        ],*/
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,

            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => '587',
                'encryption' => 'tls',
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>[''=>'']
            ],
        ],
        'charset' => 'utf-8',
        'language' => 'zh-CN',
        'timeZone' => 'Asia/Shanghai',
    ],
];
