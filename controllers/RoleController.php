<?php
namespace app\controllers;

use app\models\Logs;
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
        $order_by = ['sort' => SORT_ASC,'create_time' => SORT_ASC];
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

    public function actionEdit(){
        $data = $this->data;
        $id = $this->input->get('id');
        $data['info'] = Role::getOne(['id' => $id]);
        return $this->renderPartial('edit', $data);
    }

    public function actionDel(){
        $data = $this->data;
        $id = $this->input->get('id');
        if($id == 1) $this->return_json(['code' => 0, 'msg' => '不能删除管理员组']);
        $res = Role::del(['id' => $id]);
        if(!$res) {
            Logs::write_log($data['userInfo']['id'], 2, '未能删除角色id:'.$id);
            $this->return_json(['code' => 0, 'msg' => '删除失败']);
        }
        Logs::write_log($data['userInfo']['id'], 2, '删除角色id:'.$id);
        $this->return_json(['code' => 1, 'msg' => "操作成功"]);
    }

    public function actionDoadd(){
        $data = $this->data;
        $roleName = trim($this->input->get('role_name'));
        if(empty($roleName)) $this->return_json(['code' => 0, "msg" => "角色名不能为空"]);
        $sort = (int) $this->input->get('sort');
        $add = [
            'role_name' => $roleName,
            'sort' => $sort,
            'create_id' => $data['userInfo']['id'],
            'update_id' => $data['userInfo']['id'],
            'create_time' => date('Y-m-d H:i:s'),
            'update_time' => date('Y-m-d H:i:s')
        ];
        $res = Role::add($add);
        if(!$res) $this->return_json(['code' => 0, 'msg' => '添加失败']);
        $this->return_json(['code' => 1, 'msg' => "操作成功"]);
    }

    public function actionDoedit(){
        $data = $this->data;
        $roleName = trim($this->input->get('role_name'));
        $id = intval($this->input->get('id'));
        if(empty($roleName)) $this->return_json(['code' => 0, "msg" => "角色名不能为空"]);
        $sort = (int) $this->input->get('sort');
        $add = [
            'role_name' => $roleName,
            'sort' => $sort,
            'update_id' => $data['userInfo']['id'],
            'update_time' => date('Y-m-d H:i:s')
        ];
        $res = Role::edit($id, $data);
        if(!$res) $this->return_json(['code' => 0, 'msg' => '编辑失败']);
        $this->return_json(['code' => 1, 'msg' => "操作成功"]);
    }
}
