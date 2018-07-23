<?php use yii\helpers\Url;?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>综合管理后台</title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/assets/css/animate.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    
	<!-- Mainly scripts -->
    <script src="/assets/js/jquery-3.1.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="/assets/layer/layer.js"></script>
</head>

<body>
    <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="/assets/img/profile_small.jpg" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> 
                                <span class="block m-t-xs"> <strong class="font-bold"><?php echo $this->context->data['userInfo']['realname'];?></strong>
                                </span>
                                <span class="text-muted text-xs block">管理员</span> 
                             </span> 
                        </a>
                        </div>
                        <div class="logo-element">
                            MD
                        </div>
                    </li>
                    <?php foreach ($this->context->menus as $k => $v):?>
                    <?php if($v['type'] == 'page'):?>
                    <li <?php if( isset($pcode) && ( $pcode == $v['pcode']) ){echo 'class="active"';}?>>
                        <a href="<?php echo Url::to([$v['url']]);?>">
                        	<i class="<?php echo $v['class'];?>"></i> 
                        	<span class="nav-label"><?php echo $v['name']?></span>
                        </a>
                    </li>
                    <?php else:?>
                    <li <?php if( isset($pcode) && ( $pcode == $v['pcode']) ){echo 'class="active"';}?>>
                        <a>
                        	<i class="<?php echo $v['class'];?>"></i> 
                        	<span class="nav-label"><?php echo $v['name']?></span>
                        	<span class="fa">&nbsp;+</span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <?php foreach ($v['list'] as $key => $val):?>
                            <li <?php if( isset($code) && ( $code == $v['code']) ){echo 'class="active"';}?>>
                            	<a href="<?php echo Url::to([$val['url']]);?>"><?php echo $val['name']?></a>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </li>
                    <?php endif;?>
                    <?php endforeach;?>
            </ul>

        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="请输入搜索内容" class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">欢迎来到苗都科技综合管理后台</span>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a7.jpg">
                                </a>
                                <div>
                                    <small class="pull-right">46小时前</small>
                                    <strong>小明</strong> 评论了 <strong>小红</strong>. <br>
                                    <small class="text-muted">2017.10.06 7:58</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a4.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right text-navy">5小时前</small>
                                    <strong>小红</strong> 打电话给了 <strong>小黑</strong>. <br>
                                    <small class="text-muted">2017.10.06 7:58</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/profile.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right">23小时前</small>
                                    <strong>小黑</strong> 点赞了 <strong>小红</strong>. <br>
                                    <small class="text-muted">2017.10.06 7:58</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>阅读所有消息</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> 你有16条消息
                                    <span class="pull-right text-muted small">4 分钟前</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 个新的关注者
                                    <span class="pull-right text-muted small">12 分钟前</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> 重启服务器
                                    <span class="pull-right text-muted small">4 分钟前</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>查看所有信息</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>


                <li>
                    <a id="login_out">
                        <i class="fa fa-sign-out"></i> 注销
                    </a>
                </li>
            </ul>

        </nav>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
        	<div class="middle-box text-center animated fadeInDown">
                <h1>sorry</h1>
                <h3 class="font-bold">对不起，您没有操作权限</h3>
            </div>
        </div>
        <div class="footer">
            <div class="pull-right">
                <strong>www.phpxueyuan.cn</strong>
            </div>
            <div>
                <strong>Copyright</strong> 苗都科技 &copy; 2017-<?php echo date("Y");?>
            </div>
        </div>
        </div>

    </div>


    <!-- Sparkline -->
    <script src="/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Peity -->
    <script src="/assets/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="/assets/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/assets/js/inspinia.js"></script>
    <script src="/assets/js/plugins/pace/pace.min.js"></script>
    
	<script>
		$('#login_out').on('click', function(){
			layer.alert("确认要退出登录吗？", function(){
				$.get("<?php echo Url::to(['login/out']);?>", {}, function(data){
					if(data.code){
						window.location.href="<?php echo Url::to(['login/index']);?>";
					}
			    });
			});
		});
	</script>
</body>
</html>