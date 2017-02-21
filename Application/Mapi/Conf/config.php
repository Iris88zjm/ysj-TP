<?php
return array(
	//'配置项'=>'配置值'
    'SESSION_OPTIONS'        => array(
        'name'               => 'mapi',//设置session名
        'expire'             => 3600, //SESSION保存1天
        'use_trans_sid'      => 1,//跨页传递
        'use_only_cookies'   => 0,//是否只开启基于cookies的session的会话方式
    ),
);