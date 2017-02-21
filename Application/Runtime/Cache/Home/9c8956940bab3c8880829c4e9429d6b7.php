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
            
                    
    <div class="page-content edit-device">
        <h1>编辑设备(uuid: <?php echo ($device["uuid"]); ?>)</h1>

        <div class="new-message"></div>
        <form action="" method="post" role="form" data-toggle="validator">
            <div class="form-holder">
                <!-- <div class="entry form-group">
                    <label for="uuid">设备序列号(uuid)</label>
                    <input type="text" name="uuid" id="uuid" placeholder="" value="<?php echo ($device["uuid"]); ?>" required data-error="Uuid is invalid." />
                    <div class="help-block with-errors"></div>
                </div> -->
                <div class="entry form-group">
                    <label for="title">标题</label>
                    <input type="text" name="title" id="title" placeholder="" value="<?php echo ($device["title"]); ?>" />
                    <div class="help-block with-errors"></div>
                </div>
                <div class="entry form-group">
                    <label for="thumbnail">图片地址</label>
                    <input type="text" name="thumbnail" id="thumbnail" placeholder="http://..." required pattern="[a-zA-z]+://[^\s]*" data-error="Thumbnail is invalid." value="<?php echo ($device["thumbnail"]); ?>" />
                    <div class="help-block with-errors"></div>
                </div>
                <div class="entry form-group">
                    <label for="description">设备描述</label>
                    <textarea name="description" id="description"><?php echo ($device["description"]); ?></textarea>
                    <div class="help-block with-errors"></div>
                </div>
                <input type="hidden" name="id" value="<?php echo ($device["id"]); ?>" />
            </div>
            <div class="btn-set btn-right">
                <a href="#" class="btn btn-add">保存</a>
            </div>
        </form>


                    

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