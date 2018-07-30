<div class="panel panel-default">
	<div class="panel-body">
        <div class="form-group col-md-1 col-sm-6 col-xs-12">
            <button type="submit" class="btn btn-primary add">
                <span class="glyphicon glyphicon-plus"></span> 添加
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered" style="border-bottom: 1px solid #EBEBEB;">
        	<caption style="padding-left:5px;"><span>角色列表  - 本次查询总计：<?php echo $count;?> 条记录</span></caption>
        	<thead style="border-top: 1px solid #EBEBEB;">
        		<tr>
        			<th>id</th>
        			<th>角色名</th>
        			<th>创建日期</th>
        			<th>创建人</th>
        			<th>更新时间</th>
        			<th>更新人</th>
        			<th>排序</th>
        			<th>操作</th>
        		</tr>
        	</thead>
        	<tbody>
        		<?php if($list):?>
        		<?php foreach ($list as $k => $v):?>
        		<tr id="tr_<?php echo $v['id']?>">
        			<td><?php echo $v['id']?></td>
        			<td><?php echo $v['role_name']?></td>
        			<td><?php echo $v['create_time']?></td>
        			<td><?php echo $v['create_name']?></td>
        			<td><?php echo $v['update_time']?></td>
        			<td><?php echo $v['update_name']?></td>
        			<td><?php echo $v['sort']?></td>
        			<td>
        			    <button type="submit" class="btn btn-info btn-detail edit" data-id="<?php echo $v['id']?>">
                            <span class="glyphicon glyphicon-edit"></span> 编辑
                        </button>
                        <button type="button" class="btn btn-warning btn-detail btn-del" data-id="<?php echo $v['id']?>">
                        	<span class="glyphicon glyphicon-remove"></span> 删除
                        </button>
        			</td>
        		</tr>
        		<?php endforeach;?>
        		<?php endif;?>
        	</tbody>
        </table>
        <nav style="float: right;margin-top:10px;margin-right:10px;">
            <?php 
                use yii\widgets\LinkPager;
                use yii\helpers\Html;
                use yii\helpers\Url;
                
                // 显示分页
                echo LinkPager::widget([
                'pagination' => $pagination,
                'firstPageLabel'=>"First",
                'prevPageLabel'=>'Prev',
                'nextPageLabel'=>'Next',
                'lastPageLabel'=>'Last',
            ]);
            ?>
        </nav>
 	</div>
</div>
<script>

    $(function(){
        $('.add').on("click", function(){
            var id = $(this).attr('data-id');
            layer.open({
                type: 2,
                title: '添加角色',
                shadeClose: true,
                shade: 0.8,
                area: ['50%', '70%'],
                content: "<?php echo Url::to(['role/add'])?>?id="+id
            });
        });

        $('.btn-del').on('click', function () {
            var id = $(this).attr('data-id');
            var index = layer.alert("确认要删除此角色吗？", function () {
                $.get("<?php echo Url::to(['role/del'])?>", {'id':id}, function (data) {
                    layer.close(index);
                    if(data.code == 0){
                        layer.alert(data.msg);
                        return;
                    }
                    layer.msg(data.msg, function () {
                        $("#tr"+id).remove();
                    });
                })
            });
        });
    });
</script>