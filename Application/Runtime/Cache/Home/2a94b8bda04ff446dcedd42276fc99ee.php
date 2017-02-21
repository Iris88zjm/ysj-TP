<?php if (!defined('THINK_PATH')) exit();?> <!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/login.css" />

    <script type="text/javascript" src="/Public/js/lib/jquery.js"></script>
    <script type="text/javascript" src="/Public/js/lib/utility.js"></script>
    <script type="text/javascript" src="/Public/js/lib/validator.js"></script>
    <script type="text/javascript" src="/Public/js/login.js"></script>
</head>
<body class="<?php echo (strtolower(MODULE_NAME)); ?>-<?php echo (strtolower(CONTROLLER_NAME)); ?>-<?php echo (strtolower(ACTION_NAME)); ?>">
        <div class="login-container">
            <form action="" method="post" role="form" data-toggle="validator" >
                <div class="form-holder">
                	<div class="logo"><img src="/Public/images/logo.png" /></div>
                    <h1>Sign in to Admin Panel</h1>
                    <div class="entry form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email: joe@example.com" required pattern="[\w!#$%&'*+/=?^_`{|}~-]+(?:\.[\w!#$%&'*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?" data-error="邮箱不能为空" />
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="entry form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password: 6-30 characters" required pattern="^[0-9a-zA-Z\s]{6,30}$" data-error="密码必须为6到30位" />
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="btn-set">
                        <a href="#" class="btn btn-login btn-default">Sign in</a>
                    </div>
                </div>
            </form>
        </div>
</body>
</html>