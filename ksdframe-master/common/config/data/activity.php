<?php
/**
 * 活动数据配置文件
 *
 * 参考样例
 */

return [
    1 => [
        'id' => 1,
        'key' => 'chargePresent',
        'name' => '充值送话费',
        'startTime' => '2020-01-01 10:00:00',
        'endTime' => '2020-03-01 18:00:00',
        'activityData' => [
            'minutes' => 10, //赠送10分钟通话
            'money' => 5, //赠送5元话费
        ],
    ],
    //其他数据配置样例
    /*2 => [
        'id' => 2,
        'key' => 'XXXXXX',
        'name' => 'XXXXXXXX',
        'startTime' => '2020-01-01 10:00:00',
        'endTime' => '2020-03-01 18:00:00',
        'activityData' => [
        ],
    ],
    3 => [
        'id' => 3,
        'key' => 'YYYYYYYYY',
        'name' => 'YYYYYYYYY',
        'startTime' => '2020-01-01 10:00:00',
        'endTime' => '2020-03-01 18:00:00',
        'activityData' => [
        ],
    ],*/
];

