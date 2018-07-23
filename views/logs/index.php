<div class="panel panel-default">
	<div class="panel-body">
            <form method="get" role="form" id="form">
                <div class="form-group col-md-2 col-sm-6 col-xs-12">
                    <select class="form-control select2-init select2-hidden-accessible" name="user_id" id="user_id" tabindex="-1" aria-hidden="true">
                        <option value="">请选择操作用户</option>
                        <?php if($adminList):?>
                        <?php foreach ($adminList as $k => $v):?>
                        <option <?php if(isset($user_id) && $user_id == $v['id']){echo 'selected';}?> value="<?php echo $v['id']?>"><?php echo $v['realname']?></option>
                        <?php endforeach;?>
                        <?php endif;?>
                	</select>
                </div>
                <div class="form-group col-md-2 col-sm-6 col-xs-12">
                    <select class="form-control select2-init select2-hidden-accessible" name="type" id="type" tabindex="-1" aria-hidden="true">
                        <option value="">请选择日志类型</option>
                        <option <?php if(isset($type) && $type == 1){echo 'selected';}?> value="1">增加</option>
                        <option <?php if(isset($type) && $type == 2){echo 'selected';}?> value="2">删除</option>
                        <option <?php if(isset($type) && $type == 3){echo 'selected';}?> value="3">更新</option>
                        <option <?php if(isset($type) && $type == 4){echo 'selected';}?> value="3">查询</option>
                	</select>
                </div>
                <div class="form-group col-md-2 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" name="ip" placeholder="ip" value="<?php if(isset($ip)){echo $ip;}?>">
                </div>
                <div class="form-group col-md-2 col-sm-6 col-xs-12">
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-search"></span> 搜 索
                    </button>
                </div>
            </form>
        </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered" style="border-bottom: 1px solid #EBEBEB;">
        	<caption style="padding-left:5px;"><span>系统日志记录  - 本次查询总计：<?php echo $count;?> 条记录</span></caption>
        	<thead style="border-top: 1px solid #EBEBEB;">
        		<tr>
        			<th>id</th>
        			<th>用户id</th>
        			<th>用户姓名</th>
        			<th>类型</th>
        			<th>内容</th>
        			<th>sql</th>
        			<th>ip</th>
        			<th>时间</th>
        		</tr>
        	</thead>
        	<tbody>
        		<?php if($list):?>
        		<?php foreach ($list as $k => $v):?>
        		<tr>
        			<td><?php echo $v['id']?></td>
        			<td><?php echo $v['user_id']?></td>
        			<td><?php echo $v['realname']?></td>
        			<td><?php echo $v['type']?></td>
        			<td><?php echo $v['content']?></td>
        			<td><?php echo $v['sql']?></td>
        			<td><?php echo $v['ip']?></td>
        			<td><?php echo $v['create_time']?></td>
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