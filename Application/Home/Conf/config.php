<?php
return array(
    //'配置项'=>'配置值'
    'SESSION_OPTIONS'        => array(
        'name'               => 'mqttadmin',//设置session名
        'expire'             => 24*3600, //SESSION保存1天
        'use_trans_sid'      => 1,//跨页传递
        'use_only_cookies'   => 0,//是否只开启基于cookies的session的会话方式
    ),

    'URL_ROUTER_ON' => true,
    'URL_ROUTE_RULES' => array(
            array(),
        ),

    'AUTH_CONFIG'=>array(
            'AUTH_ON' => true, //认证开关
            'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
            'AUTH_GROUP' => 'yh_auth_group', //用户组数据表名
            'AUTH_GROUP_ACCESS' => 'yh_auth_group_access', //用户组明细表
            'AUTH_RULE' => 'yh_auth_rule', //权限规则表
            'AUTH_USER' => 'yh_admin'//用户信息表
        ),
);