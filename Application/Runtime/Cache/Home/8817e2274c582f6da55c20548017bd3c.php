<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo (CONTROLLER_NAME); ?>-<?php echo (ACTION_NAME); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/lib/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/main.css" />

    

    <script type="text/javascript" src="/Public/js/lib/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="/Public/js/lib/utility.js"></script>
    <script type="text/javascript" src="/Public/js/lib/validator.js"></script>
    <script type="text/javascript" src="/Public/js/main.js"></script>

    
</head>
<body class="<?php echo (strtolower(MODULE_NAME)); ?>-<?php echo (strtolower(CONTROLLER_NAME)); ?>-<?php echo (strtolower(ACTION_NAME)); ?>">
    <div class="body-wrapper page-width">

        <div class="fl left-sidebar">
            
                    <div class="logo"><img src="/Public/images/logo.png" /></div>
                    <nav class="navbar navbar-default">
                        <ul>
                            <li class="item-admin-dashboard level-0">
                                <a href="/admin/dashboard">
                                    <div class="icon">
                                        <i class="fa fa-tachometer fa-2x" aria-hidden="true"></i>
                                    </div>
                                    <span>Dashboard</span>
                                    <div class="clear"></div>
                                </a>
                            </li>
                            <li class="item-customer-index level-0">
                                <a href="/customer/index">
                                    <div class="icon">
                                        <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                                    </div>
                                    <span>Customer</span>
                                    <div class="clear"></div>
                                </a>
                            </li>
                            <li class="item-admin-salse level-0">
                                <a href="/admin/salse">
                                    <div class="icon">
                                        <i class="fa fa-money fa-2x" aria-hidden="true"></i>
                                    </div>
                                    <span>Salse</span>
                                    <div class="clear"></div>
                                </a>
                            </li>
                            <li class="item-devices-index level-0">
                                <a href="/devices/index">
                                    <div class="icon">
                                        <i class="fa fa-list fa-2x" aria-hidden="true"></i>
                                    </div>
                                    <span>Devices</span>
                                    <div class="clear"></div>
                                </a>
                            </li>
                        </ul>
                    </nav>
            
        </div>
        
            <div class="page-right-header">
                <div class="admin-user admin-action-dropdown-wrap">
                    <a class="admin-action-dropdown" href="#"><span>joe@example.com</span><i class="fa fa-user" aria-hidden="true"></i></a>
                    <ul class="admin-action-dropdown-menu">
                        <li><a href="#">Accout Setting</a></li>
                        <li><a href="#">Sign Out</a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        
        <div class="fl right-column">
            
                    
    <div class="page-content">
        <h1>Customers</h1>
        <table class="grid-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>System Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>6</td>
                    <td>Test</td>
                    <td>123456@qq.com</td>
                    <td>weixin</td>
                    <td>Ios</td>
                    <td><a href="#">Edit</a></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Test</td>
                    <td>weixin</td>
                    <td>app</td>
                    <td>Android</td>
                    <td><a href="#">Edit</a></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Test</td>
                    <td>123456@qq.com</td>
                    <td>app</td>
                    <td>Ios</td>
                    <td><a href="#">Edit</a></td>
                </tr>
            </tbody>
        </table>
    </div>


                    

                    <div class="page-width block-footer">
                        
                    </div>
            
        </div>
        <div class="clear"></div>
    </div>
</body>
<script type="text/javascript">
    (function($) {
        $(function() {
            $('.left-sidebar nav ul li').removeClass('active');
            $('.left-sidebar nav ul li.item-<?php echo (strtolower(CONTROLLER_NAME)); ?>-<?php echo (strtolower(ACTION_NAME)); ?>').addClass('active');
        });
    })(jQuery);
</script>
</html>