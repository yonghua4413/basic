<?php use yii\widgets\ActiveForm;?>
<?php use yii\helpers\Url;?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>综合管理后台</title>

    <?php echo $this->render('/common/css');?>
    
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
                        'action'=>['role/doadd'],
                        'method'=>'get',
                        'options'=>['name'=>'form', 'class' => "form-horizontal"]
                    ])?>

                    <div class="form-group">
                    	<label class="col-lg-2 control-label">角色名</label>
                        <div class="col-lg-5">
                        	<input type="text" id ="role_name" name="role_name" placeholder="请输入角色名" class="form-control"> <span class="help-block m-b-none">添加</span>
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
        if($('#role_name').val() == "") {
            layer.alert('角色不能为空');
            return;
        }
		$.post("<?php echo Url::to(['role/doadd']);?>", $("form").serialize(), function(data){
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