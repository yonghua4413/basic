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
                        'action'=>['auth/editauth'],
                        'method'=>'post',
                        'options'=>['name'=>'form', 'class' => "form-horizontal"]
                    ])?>
                    <div class="form-group">
                    	<input type="hidden" name="id" value="<?php echo $info['id']?>">
                        <label class="col-lg-2 control-label">父级</label>
                        <div class="col-lg-5">
                            <select class="form-control m-b" name="pid">
                                <option value="0">请选择父级</option>
                                <?php if($list):?>
                                <?php foreach ($list as $k => $v):?>
                                <option <?php if($info['pid'] == $v['id']){echo 'selected';}?> value="<?php echo $v['id']?>"><?php echo $v['auth_name']?></option>
                                <?php endforeach;?>
                                <?php endif;?>
                            </select>   
                        </div>
                    </div>
                    <div class="form-group">
                    	<label class="col-lg-2 control-label">权限名</label>
                        <div class="col-lg-5">
                        	<input type="text" name="auth_name" value="<?php echo $info['auth_name']?>" placeholder="请输入权限名" class="form-control"> <span class="help-block m-b-none">添加</span>
                        </div>
                    </div>
                    <div class="form-group">
                    	<label class="col-lg-2 control-label">权限值</label>
                        <div class="col-lg-5">
                        	<input type="text" name="auth" value="<?php echo $info['auth']?>" placeholder="请输入权限值" class="form-control"> <span class="help-block m-b-none">auth/add</span>
                        </div>
                    </div>
                    <div class="form-group">
                    	<label class="col-lg-2 control-label">排序</label>
                        <div class="col-lg-5">
                        	<input type="number" name="sort" value="<?php echo $info['sort']?>" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin:0 auto;">
                        <button class="btn btn-info btn-detail submit" type="submit">保存</button>
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
		$.post("<?php echo Url::to(['auth/editauth']);?>", $("form").serialize(), function(data){
	    	if(data.code == 1){
		    	layer.msg("编辑成功", {'time':1000},  function(){
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