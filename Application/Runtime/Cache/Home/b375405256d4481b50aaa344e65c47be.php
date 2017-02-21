<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>后台管理-<?php echo (CONTROLLER_NAME); ?>-<?php echo (ACTION_NAME); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/lib/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/lib/basic.min.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/lib/dropzone.min.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/main.css" />

    

    <script type="text/javascript" src="/Public/js/lib/jquery.js"></script>
    <script type="text/javascript" src="/Public/js/lib/utility.js"></script>
    <script type="text/javascript" src="/Public/js/lib/validator.js"></script>
    <script type="text/javascript" src="/Public/js/lib/dropzone.js"></script>


    
</head>
<body class="<?php echo (strtolower(MODULE_NAME)); ?>-<?php echo (strtolower(CONTROLLER_NAME)); ?>-<?php echo (strtolower(ACTION_NAME)); ?>">
    <div class="body-wrapper page-width">

        <div class="fl left-sidebar">
            
                    <div class="logo"><img src="/Public/images/logo.png" /></div>
                    <nav class="navbar navbar-default">
                        <ul>
                            <li class="item-admin level-0">
                                <a href="/admin/dashboard">
                                    <div class="icon">
                                        <i class="fa fa-tachometer fa-2x" aria-hidden="true"></i>
                                    </div>
                                    <span>仪表盘</span>
                                    <div class="clear"></div>
                                </a>
                            </li>
                            <li class="item-customer level-0">
                                <a href="/customer/index">
                                    <div class="icon">
                                        <i class="fa fa-user fa-2x" aria-hidden="true"></i>
                                    </div>
                                    <span>用户</span>
                                    <div class="clear"></div>
                                </a>
                            </li>
                            <li class="item-salse level-0">
                                <a href="/salse/index">
                                    <div class="icon">
                                        <i class="fa fa-money fa-2x" aria-hidden="true"></i>
                                    </div>
                                    <span>销售</span>
                                    <div class="clear"></div>
                                </a>
                            </li>
                            <li class="item-devices level-0">
                                <a href="/devices/index">
                                    <div class="icon">
                                        <i class="fa fa-list fa-2x" aria-hidden="true"></i>
                                    </div>
                                    <span>设备</span>
                                    <div class="clear"></div>
                                </a>
                            </li>
                            <li class="item-history level-0">
                                <a href="/history/index">
                                    <div class="icon">
                                        <i class="fa fa-history fa-2x" aria-hidden="true"></i>
                                    </div>
                                    <span>用户日志</span>
                                    <div class="clear"></div>
                                </a>
                            </li>
                        </ul>
                    </nav>
            
        </div>
        
            <div class="page-right-header">
                <div class="admin-user admin-action-dropdown-wrap">
                    <a class="admin-action-dropdown" href="#"><span><?php echo session('username'); ?></span><i class="fa fa-user" aria-hidden="true"></i></a>
                    <ul class="admin-action-dropdown-menu">
                        <li><a href="#">用户中心</a></li>
                        <li><a href="/admin/logout">退出</a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        
        <div class="fl right-column">
            
                    
    <div class="page-content">
        <h1>用户</h1>
        <!-- <div class="btn-set btn-right add-new-device"><a class="btn btn-add" href="#">Add Device</a></div> -->
        <div class="page">
            <?php echo ($page); ?>
        </div>
        <table class="grid-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>用户名</th>
                    <th>用户来源</th>
                    <th>编辑</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$customer): $mod = ($i % 2 );++$i;?><tr>
                        <td> <?php echo ($customer["uid"]); ?> </td>
                        <td> <?php echo ($customer["username"]); ?> </td>
                        <td>
                            <?php switch($customer["user_type"]): case "0": ?>注册用户<?php break;?>
                                <?php case "1": ?>微信用户<?php break;?>
                                <?php default: ?>注册用户<?php endswitch;?>
                        </td>
                        <td>
                            <?php if($customer["user_type"] == 0 ): ?><a href="/customer/edit/id/<?php echo ($customer["uid"]); ?>"><i class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i></a><?php endif; ?>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
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
    var group = "<?php echo ($_SESSION['group']); ?>";
    (function($) {
        $(function() {
            $('.left-sidebar nav ul li').removeClass('active');
            $('.left-sidebar nav ul li.item-<?php echo (strtolower(CONTROLLER_NAME)); ?>').addClass('active');
        });
    })(jQuery);
</script>
<script type="text/javascript" src="/Public/js/main.js"></script>
</html>