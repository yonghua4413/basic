<?php use yii\widgets\ActiveForm;?>
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

<body style="background-color: #fff;">
<div class="row">
    <div class="col-lg-5">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                    <?php $form=ActiveForm::begin([
                        'action'=>['auth/addparentauth'],
                        'method'=>'post',
                        'options'=>['name'=>'form', 'class' => "form-horizontal"]
                    ])?>
                    
                    <div class="form-group">
                    	<label class="col-lg-2 control-label">权限名</label>
                        <div class="col-lg-5">
                        	<input type="text" id ="auth_name" name="auth_name" placeholder="请输入权限名" class="form-control"> <span class="help-block m-b-none">添加</span>
                        </div>
                    </div>
                    <div class="form-group">
                    	<label class="col-lg-2 control-label">权限值</label>
                        <div class="col-lg-5">
                        	<input type="text" id ="auth" name="auth" placeholder="请输入权限值" class="form-control"> <span class="help-block m-b-none">auth/add</span>
                        </div>
                    </div>
                    <div class="form-group">
                    	<label class="col-lg-2 control-label">排序</label>
                        <div class="col-lg-5">
                        	<input type="number" name="sort" value="1" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin:0 auto;">
                        <button class="btn btn-info btn-detail submit" type="submit">添加</button>
                    </div>
                <?php ActiveForm::end();?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$('.submit').on('click', function(e){
		//阻止默认浏览器动作(W3C)
        if ( e && e.preventDefault ){
            e.preventDefault();
        	//IE中阻止函数器默认动作的方式
        }else{
            window.event.returnValue = false;
        	return false;
        }
        if($('#auth_name').val() == "") {
            layer.alert('权限名不能为空');
            return;
        }
        if($('#auth').val() == "") {
            layer.alert('权限值不能为空');
            return;
        }
		$.post("<?php echo Url::to(['auth/addparentauth']);?>", $("form").serialize(), function(data){
	    	if(data.code == 1){
		    	layer.msg("添加成功", {'time':1000},  function(){
		    		window.parent.location.reload(); //刷新父页面
			    });
			    return;
	    	}
	    	layer.alert(data.msg);
	    });
	});
    
</script>
</body>
</html>