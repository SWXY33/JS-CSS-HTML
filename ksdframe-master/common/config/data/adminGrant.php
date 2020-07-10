<?php
return [

    15 => [
            'adminGrantId' => 15,
            'name' => '运营', 'parentId' => 0,
            'nodePath' => 15,
            'orderby' => 10,
            'tag' => 'card', 'url' => 'card',
            'icon' => 'fa fa-phone', 'show' => 1, 'type' => 0
        ],
        151 => [
                'adminGrantId' => 151,
                'name' => '电话卡管理', 'parentId' => 15,
                'tag' => 'card', 'url' => 'card/cardList',
                'icon' => '', 'show' => 1, 'type' => 0
            ],
        152 => [
                'adminGrantId' => 152,
                'name' => '资费管理', 'parentId' => 15,
                'tag' => 'baseFee', 'url' => 'baseFee/baseFeeList',
                'icon' => '', 'show' => 1, 'type' => 0
            ],
        153 => [
                'adminGrantId' => 153,
                'name' => '话机管理', 'parentId' => 15,
                'tag' => 'device', 'url' => 'device/deviceList',
                'icon' => '', 'show' => 1, 'type' => 0
            ],
        154 => [
            'adminGrantId' => 154,
            'name' => '套餐管理', 'parentId' => 15,
            'tag' => 'planList', 'url' => 'plan/planList',
            'icon' => '', 'show' => 1, 'type' => 0
        ],

    16 => [
            'adminGrantId' => 16,
            'name' => '业务', 'parentId' => 0,
            'nodePath' => 15,
            'orderby' => 10,
            'tag' => 'plan', 'url' => 'plan',
            'icon' => 'fa fa-calendar-o', 'show' => 1, 'type' => 0
        ],
        161 => [
                'adminGrantId' => 161,
                'name' => '代理商管理', 'parentId' => 16,
                'tag' => 'agent', 'url' => 'agent/agentList',
                'icon' => '', 'show' => 1, 'type' => 0
            ],
        162 => [
                'adminGrantId' => 162,
                'name' => '区域管理', 'parentId' => 16,
                'tag' => 'zone', 'url' => 'zone/zoneList',
                'icon' => '', 'show' => 1, 'type' => 0
            ],
        163 => [
                'adminGrantId' => 163,
                'name' => '学校管理', 'parentId' => 16,
                'tag' => 'schoolList', 'url' => 'school/schoolList',
                'icon' => '', 'show' => 1, 'type' => 0
            ],
        164 => [
                'adminGrantId' => 164,
                'name' => '用户管理', 'parentId' => 16,
                'tag' => 'user', 'url' => 'user/userList',
                'icon' => '', 'show' => 1, 'type' => 0
            ],

    70 => [
        'adminGrantId' => 70,
        'name' => '审核', 'parentId' => 0,
        'nodePath' => 70,
        'orderby' => 20,
        'tag' => 'student', 'url' => 'student',
        'icon' => 'fa fa-paper-plane-o', 'show' => 1, 'type' => 0
    ],
        701 => [
            'adminGrantId' => 701,
            'name' => '审核管理', 'parentId' => 70,
            'nodePath' => 701,
            'orderby' => 20,
            'tag' => 'student', 'url' => 'student/list',
            'icon' => '', 'show' => 1, 'type' => 0
        ],

	50 => [
		'adminGrantId' => 50,
		'name' => '报表', 'parentId' => 0,
		'nodePath' => 50,
		'orderby' => 20,
		'tag' => 'device', 'url' => 'device',
		'icon' => 'fa fa-line-chart', 'show' => 1, 'type' => 0
	],
		501 => [
			'adminGrantId' => 501,
			'name' => '基础数据报表', 'parentId' => 50,
			'nodePath' => 501,
			'orderby' => 20,
			'tag' => 'report', 'url' => 'report/reportDay',
			'icon' => '', 'show' => 1, 'type' => 0
		],
		502 => [
			'adminGrantId' => 502,
			'name' => '学校数据报表', 'parentId' => 50,
			'nodePath' => 502,
			'orderby' => 20,
			'tag' => 'agent', 'url' => 'agent/list',
			'icon' => '', 'show' => 1, 'type' => 0
		],
		503 => [
			'adminGrantId' => 503,
			'name' => '话机数据报表', 'parentId' => 50,
			'nodePath' => 503,
			'orderby' => 20,
			'tag' => 'agent', 'url' => 'agent/list',
			'icon' => '', 'show' => 1, 'type' => 0
		],
		504 => [
			'adminGrantId' => 504,
			'name' => '基础数据分析', 'parentId' => 50,
			'nodePath' => 504,
			'orderby' => 20,
			'tag' => 'agent', 'url' => 'agent/list',
			'icon' => '', 'show' => 1, 'type' => 0
		],
		505 => [
			'adminGrantId' => 505,
			'name' => '电话卡数据分析', 'parentId' => 50,
			'nodePath' => 505,
			'orderby' => 20,
			'tag' => 'agent', 'url' => 'agent/list',
			'icon' => '', 'show' => 1, 'type' => 0
		],
		506 => [
			'adminGrantId' => 506,
			'name' => '学生数据统计', 'parentId' => 50,
			'nodePath' => 506,
			'orderby' => 20,
			'tag' => 'agent', 'url' => 'agent/list',
			'icon' => '', 'show' => 1, 'type' => 0
		],
		507 => [
			'adminGrantId' => 507,
			'name' => '话费套餐统计', 'parentId' => 50,
			'nodePath' => 507,
			'orderby' => 20,
			'tag' => 'agent', 'url' => 'agent/list',
			'icon' => '', 'show' => 1, 'type' => 0
		],
		508 => [
			'adminGrantId' => 508,
			'name' => '其他数据分析', 'parentId' => 50,
			'nodePath' => 508,
			'orderby' => 20,
			'tag' => 'agent', 'url' => 'agent/list',
			'icon' => '', 'show' => 1, 'type' => 0
		],
    8 => [
            'adminGrantId' => 8,
            'name' => '维护', 'parentId' => 0,
            'nodePath' => 15,
            'orderby' => 10,
            'tag' => 'card', 'url' => 'card',
            'icon' => 'fa fa-wrench', 'show' => 1, 'type' => 0
        ],
        801 => [
                'adminGrantId' => 801,
                'name' => '线路管理', 'parentId' => 8,
                'tag' => 'line', 'url' => 'line/lineList',
                'icon' => '', 'show' => 1, 'type' => 0
            ],
        802 => [
                'adminGrantId' => 802,
                'name' => '路由管理', 'parentId' => 8,
                'tag' => 'route', 'url' => 'route/routeList',
                'icon' => '', 'show' => 1, 'type' => 0
            ],

    9 => [
            'adminGrantId' => 9,
            'name' => '系统', 'parentId' => 0,
            'tag' => 'sys', 'url' => 'sys',
            'icon' => 'fa fa-cogs', 'show' => 1, 'type' => 0
        ],
        29 => [
                'adminGrantId' => 29,
                'name' => '通用设置', 'parentId' => 9,
                'tag' => 'sohpSetting', 'url' => 'shop/setting',
                'icon' => '', 'show' => 1, 'type' => 0
            ],
        30 => [
                'adminGrantId' => 30,
                'name' => '个人设置', 'parentId' => 9,
                'tag' => 'adminSetting', 'url' => 'admin/setting',
                'icon' => '', 'show' => 1, 'type' => 0
            ],

        26 => [
                'adminGrantId' => 26,
                'name' => '角色管理', 'parentId' => 9,
                'tag' => 'adminRole', 'url' => 'adminRole/role',
                'icon' => '', 'show' => 1, 'type' => 0
            ],

        27 => [
                'adminGrantId' => 27,
                'name' => '管理员管理', 'parentId' => 9,
                'tag' => 'admin', 'url' => 'admin/adminList',
                'icon' => '', 'show' => 1, 'type' => 0
            ],
        31 => [
                'adminGrantId' => 31,
                'name' => '班级设置', 'parentId' => 9,
                'tag' => 'studentClass', 'url' => 'studentClass/studentClassList',
                'icon' => '', 'show' => 1, 'type' => 0
            ],
        28 => [
                'adminGrantId' => 28,
                'name' => '参数设置', 'parentId' => 9,
                'tag' => 'adminParamList', 'url' => 'shop/paramList',
                'icon' => '', 'show' => 1, 'type' => 0
            ],

];
