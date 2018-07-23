<?php
namespace app\controllers;

use Yii;
use app\core\MyController;
use app\models\Auth;
use app\models\Logs;

class AuthController extends MyController
{

    public function beforeaction($action){
        $this->data['pcode'] = "sys_list";
        $this->data['code'] = "auth";
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
        $where = ['is_del' => 0];
        $orderBy = ['sort' => SORT_ASC];
        $list = Auth::getList($where, $orderBy);
        $data['list'] = [];
        if($list){
            $data['list'] = class_loop_list($list, 0);
        }
        return $this->render('index', $data);
    }

    
    /**
     * Displays.
     *
     * @return string
     */
    public function actionAdd()
    {
        $data = $this->data;
        $data['pid'] = $this->input->get('id');
        $where = ['is_del' => 0];
        $orderBy = ['sort' => SORT_ASC];
        $list = Auth::getList($where, $orderBy);
        $data['list'] = [];
        if($list){
            $data['list']= class_loop_list($list, 0);
        }
        return $this->renderPartial('add', $data);
    }
    
    /**
     * Displays.
     *
     * @return string
     */
    public function actionAddparent()
    {
        $data = $this->data;
        return $this->renderPartial('addParent', $data);
    }
    
    public function actionAddparentauth(){
        $data =$this->data;
        $post = $this->input->post();
        $auth = new Auth();
        if(empty($post['auth_name'])) $this->return_json(['code' => 0, 'msg' => '请填写权限名']);
        if(empty($post['auth'])) $this->return_json(['code' => 0, 'msg' => '请填写权限值']);
        $res = $auth::add($post);
        $log = new Logs();
        if(!$res) {
            $log->write_log($data['userInfo']['id'], 1, '添加权限失败'.$post['auth_name']);
            $this->return_json(['code' => 0, 'msg' => "操作失败"]);
        }
        //记录登录信息
        $log->write_log($data['userInfo']['id'], 1, '添加权限成功:'.$post['auth_name']);
        $this->return_json(['code' => 1, 'msg' => "添加成功"]);
    }
    
    /**
     * Displays.
     *
     * @return string
     */
    public function actionEdit()
    {
        $data = $this->data;
        $id = $this->input->get('id');
        $data['info'] = Auth::getOne(['id' => $id]);
        $where = ['is_del' => 0];
        $orderBy = ['sort' => SORT_ASC];
        $list = Auth::getList($where, $orderBy);
        $data['list'] = [];
        if($list){
            $data['list'] = $list;
        }
        return $this->renderPartial('edit', $data);
    }
    
    public function actionAddsonauth(){
        $data = $this->data;
        $post = $this->input->post();
        $auth = new Auth();
        if(empty($post['auth_name'])) $this->return_json(['code' => 0, 'msg' => '请填写权限名']);
        if(empty($post['auth'])) $this->return_json(['code' => 0, 'msg' => '请填写权限值']);
        $res = $auth::add($post);
        $log = new Logs();
        if(!$res) {
            $log->write_log($data['userInfo']['id'], 1, '添加子权限失败:'.$post['auth_name']);
            $this->return_json(['code' => 0, 'msg' => "操作失败"]);
        }
        $log->write_log($data['userInfo']['id'], 1, '添加子权限成功:'.$post['auth_name']);
        $this->return_json(['code' => 1, 'msg' => "添加成功"]);
    }
    
    public function actionEditauth(){
        $data = $this->data;
        $post = $this->input->post();
        $id = $post['id'];
        if(!$id) $this->return_json(['code' => 0, 'msg' => "操作失败"]);
        unset($post['id']);
        $auth = new Auth();
        if(empty($post['auth_name'])) $this->return_json(['code' => 0, 'msg' => '请填写权限名']);
        if(empty($post['auth'])) $this->return_json(['code' => 0, 'msg' => '请填写权限值']);
        $res = $auth::edit($id, $post);
        $log = new Logs();
        if(!$res) {
            $log->write_log($data['userInfo']['id'], 3, '编辑权限失败(id):'.$id);
            $this->return_json(['code' => 0, 'msg' => "操作失败"]);
        }
        $log->write_log($data['userInfo']['id'], 3, '编辑权限成功(id):'.$id);
        $this->return_json(['code' => 1, 'msg' => "编辑成功"]);
    }
    
    /**
     * 删除权限
     */
    public function actionDel(){
        $data = $this->data;
        $id  = $this->input->get('id');
        if(Auth::count(['pid' => $id])){
            $this->return_json(['code' => 0, 'msg' => "主权限模块下还有数据，禁止删除"]);
        }
        $res = Auth::del(['id' => $id]);
        $log = new Logs();
        if(!$res) {
            $log->write_log($data['userInfo']['id'], 2, '删除权限失败(id):'.$id);
            $this->return_json(['code' => 0, 'msg' => "操作失败"]);
        }
        $log->write_log($data['userInfo']['id'], 2, '删除权限成功(id):'.$id);
        $this->return_json(['code' => 1, 'msg' => "删除成功"]);
    }
    
    private function getTree($list = []){
        $data = [];
        foreach ($list as $k => $v){
            if($v['pid'] == 0){
                $v['son'] = [];
                array_push($data, $v);
                unset($list[$k]);
            }
        }
        if($data){
            foreach ($data as $k => $v){
                foreach ($list as $key => $val){
                    if($v['id'] == $val['pid']){
                        $data[$k]['son'][] = $val;
                        unset($list[$key]);
                    }
                }
            }
        }
        return $data;
    }
}