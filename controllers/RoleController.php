<?php
namespace app\controllers;

use Yii;
use app\core\MyController;
use app\models\Role;
use yii\data\Pagination;
use app\models\Admin;

class RoleController extends MyController
{

    public function beforeaction($action){
        $this->data['pcode'] = "sys_list";
        $this->data['code'] = "role";
        return parent::beforeAction($action);
    }
    
    /**
     * Displays.
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = $this->data;
        $where = [];
        $size = 15;
        $page = (int) $this->input->get('page');
        if(!$page) $page = 1;
        $order_by = ['create_time' => SORT_DESC];
        $list = Role::getList($where, $order_by, ($page-1)*$size, $size);
        $data['count'] = $count =  Role::count($where);
        $data['pagination'] = $pagination = new Pagination([
            'defaultPageSize' => $size,
            'totalCount' => $count
        ]);
        $data['list'] = [];
        if($list){
            $data['list'] = $list;
            //提取ids
            $admin_ids1 = array_column($list, 'create_id');
            $admin_ids2 = array_column($list, 'update_id');
            $ids = array_merge($admin_ids1, $admin_ids2);
            $ids = array_unique($ids);
            $admin = Admin::getList('id,realname', ['in', 'id', $ids]);
            if($admin){
                foreach ($list as $k => $v){
                    $data['list'][$k]['create_name'] = '';
                    $data['list'][$k]['update_name'] = '';
                    foreach ($admin as $key => $val){
                        if($v['create_id'] == $val['id']){
                            $data['list'][$k]['create_name'] = $val['realname'];
                        }
                        if($v['update_id'] == $val['id']){
                            $data['list'][$k]['update_name'] = $val['realname'];
                        }
                    }
                }
            }
        }
        
        return $this->render('index', $data);
    }

    public function actionAdd(){
        $data = $this->data;
        return $this->renderPartial('add', $data);
    }
}
