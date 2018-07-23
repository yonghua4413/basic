<?php use yii\helpers\Url;?>
<style>
   td{
	    vertical-align: middle!important;
    }
    #scrollTable{
	    height: 680px;
        overflow-x: scroll;
    	overflow:auto
    }
</style>
<div class="panel panel-default">
	<div class="panel-body">
    	<div class="form-group">
            <button type="submit" class="btn btn-primary parentadd">
                <span class="glyphicon glyphicon-plus"></span> 添加
            </button>
        </div>
    </div>
    <div id="scrollTable" class="table-responsive">
        <table class="table table-hover table-bordered" style="border-bottom: 1px solid #EBEBEB;">
        	<caption style="padding-left:5px;"><span>权限列表 </span></caption>
        	<thead style="border-top: 1px solid #EBEBEB;">
        		<tr>
        			<th>id</th>
        			<th>权限名</th>
        			<th>权限值</th>
        			<th>排序</th>
        			<th>操作</th>
        		</tr>
        	</thead>
        	<tbody>
        		<?php if($list):?>
        		<?php foreach ($list as $k => $v):?>
        		<tr>
        			<td><?php echo $v['id']?></td>
        			<td><?php echo $v['auth_name']?></td>
        			<td><?php echo $v['auth']?></td>
        			<td><?php echo $v['sort']?></td>
        			<td>
        				<button type="button" class="btn btn-success btn-detail add" data-id="<?php echo $v['id']?>">
                            <span class="glyphicon glyphicon-plus"></span> 添加
                        </button>
        				<button type="button" class="btn btn-info btn-detail edit" data-id="<?php echo $v['id']?>">
                            <span class="glyphicon glyphicon-edit"></span> 编辑
                        </button>
                        <button type="button" class="btn btn-warning btn-detail btn-del" data-id="<?php echo $v['id']?>">
                        	<span class="glyphicon glyphicon-remove"></span> 删除
                        </button>
        			</td>
        		</tr>
        		<?php if(isset($v['child']) && count($v['child'])):?>
        		<?php foreach ($v['child'] as $key => $val):?>
        		<tr>
        			<td><?php echo $val['id']?></td>
        			<td style="padding-left:50px;">
        				<?php echo $val['auth_name']?>
        			</td>
        			<td><?php echo $val['auth']?></td>
        			<td><?php echo $val['sort']?></td>
        			<td>
        				<button type="button" class="btn btn-success btn-detail add" data-id="<?php echo $val['id']?>">
                            <span class="glyphicon glyphicon-plus"></span> 添加
                        </button>
        				<button type="submit" class="btn btn-info btn-detail edit" data-id="<?php echo $val['id']?>">
                            <span class="glyphicon glyphicon-edit"></span> 编辑
                        </button>
                        <button type="button" class="btn btn-warning btn-detail btn-del" data-id="<?php echo $val['id']?>">
                        	<span class="glyphicon glyphicon-remove"></span> 删除
                        </button>
        			</td>
        		</tr>
        		<?php if(isset($val['child']) && count($val['child'])):?>
        		<?php foreach ($val['child'] as $key1 => $val1):?>
        		<tr>
        			<td><?php echo $val1['id']?></td>
        			<td style="padding-left:100px;">
        				<?php echo $val1['auth_name']?>
        			</td>
        			<td><?php echo $val1['auth']?></td>
        			<td><?php echo $val1['sort']?></td>
        			<td>
        				<button type="submit" class="btn btn-info btn-detail edit" data-id="<?php echo $val1['id']?>">
                            <span class="glyphicon glyphicon-edit"></span> 编辑
                        </button>
                        <button type="button" class="btn btn-warning btn-detail btn-del" data-id="<?php echo $val1['id']?>">
                        	<span class="glyphicon glyphicon-remove"></span> 删除
                        </button>
        			</td>
        		</tr>
        		<?php endforeach;?>
        		<?php endif;?>
        		<?php endforeach;?>
        		<?php endif;?>
        		<?php endforeach;?>
        		<?php endif;?>
        	</tbody>
        </table>
 	</div>
</div>
<script>
	$(function(){
		$('.btn-del').on('click', function(){
			var _this = $(this);
			var id = _this.attr('data-id');
			var index = layer.alert('确认要删除此权限吗？', function(){
				$.get("<?php echo Url::to(['auth/del']);?>", {'id':id}, function(data){
					layer.close(index);
					if(data.code == 0){
						layer.alert(data.msg);
						return;
					}
					layer.msg(data.msg);
					_this.parent().parent().hide();
				});
			});
			
		});

		$('.add').on("click", function(){
			var id = $(this).attr('data-id');
			layer.open({
			  type: 2,
			  title: '添加子权限',
			  shadeClose: true,
			  shade: 0.8,
			  area: ['50%', '70%'],
			  content: "<?php echo Url::to(['auth/add'])?>?id="+id
			});
		});

		$('.edit').on("click", function(){
			var id = $(this).attr('data-id');
			layer.open({
			  type: 2,
			  title: '编辑权限',
			  shadeClose: true,
			  shade: 0.8,
			  area: ['50%', '70%'],
			  content: "<?php echo Url::to(['auth/edit'])?>?id="+id
			});
		});

		$('.parentadd').on("click", function(){
			layer.open({
				  type: 2,
				  title: '添加父权限',
				  shadeClose: true,
				  shade: 0.8,
				  area: ['50%', '70%'],
				  content: "<?php echo Url::to(['auth/addparent'])?>"
				});
		});
	})
</script>