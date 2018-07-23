<?php use yii\widgets\ActiveForm;?>
<?php use yii\helpers\Url;?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>苗都科技综合管理后台 | 登录</title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/assets/css/animate.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">MD</h1>

            </div>
            <h3>苗都科技综合管理后台</h3>
            <p>
            </p>
            <p>前沿技术，专业服务</p>
                <?php $form=ActiveForm::begin([
                    'action'=>['login/do'],
                    'method'=>'post',
                    'options'=>['name'=>'form', 'class' => "m-t"]
                ])?>
                <div class="form-group">
                    <input type="text" id="username" name="username"  class="form-control" placeholder="用户名" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="密码" required>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">登录</button>

            <?php ActiveForm::end();?>
            <p class="m-t"> <small>Copyright</strong> 苗都科技 &copy; 2017-<?php echo date("Y")?></small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="/assets/js/jquery-3.1.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/layer/layer.js"></script>
	<script type="text/javascript">
		$('.btn-primary').on("click", function(e){
			//阻止默认浏览器动作(W3C)
	        if ( e && e.preventDefault ){
	            e.preventDefault();
	        	//IE中阻止函数器默认动作的方式
	        }else{
	            window.event.returnValue = false;
	        	return false;
	        }
	        var _csrf = $('#_csrf').val();
	        var username = $('#username').val();
	        if( username == ""){
		        var index = layer.alert("请输入登录账号", function(){
		        	$("#username").focus();
		        	layer.close(index);
				});
	    		return;
		    }
	        var password = $('#password').val();
	        if( password == ""){
		        var index = layer.alert("请输入登录账号密码", function(){
		        	$("#password").focus();
		        	layer.close(index);
			    });
		        return;
		    }
	        $.post("<?php echo Url::to(['login/do']);?>", $("form").serialize(), function(data){
				if(data.code == 1){
					window.location.href = "/";
					return;
				}
				layer.alert(data.msg);
		    });
		});
	</script>
</body>

</html>
