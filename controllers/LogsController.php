<?php
namespace app\controllers;

use Yii;
use app\core\MyController;
use app\models\Logs;
use app\models\Admin;
use yii\data\Pagination;

class LogsController extends MyController
{

    public function beforeaction($action){
        $this->data['pcode'] = "log_list";
        $this->data['code'] = "";
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
        $user_id = $this->input->get('user_id');
        if($user_id){
            $where['user_id'] = $data['user_id'] = $user_id;
        }
        $type = $this->input->get('type');
        if($type){
            $where['type'] = $data['type'] = $type;
        }
        $ip = trim($this->input->get('ip'));
        if($ip){
            $where['ip'] = $data['ip'] = $ip;
        }
        if(!$page) $page = 1;
        $order_by = ['create_time' => SORT_DESC];
        $list = Logs::getList($where, $order_by, ($page-1)*$size, $size, $group =[]);
        $count = $data['count'] = Logs::count($where);
        $pagination = new Pagination([
            'defaultPageSize' => $size,
            'totalCount' => $count
        ]);
        $data['list'] = [];
        if($list){
            //提取用户id
            $user_ids = array_column($list, 'user_id');
            if($user_ids){
                $user_ids = array_unique($user_ids);
            }
            $userList = Admin::getUserByIds($user_ids);
            $data['list'] = $list;
            if($userList){
                foreach ($list as $k => $v){
                    $data['list'][$k]['realname'] = '未知';
                    foreach ($userList as $key => $val){
                        if($v['user_id'] == $val['id']){
                            $data['list'][$k]['realname'] = $val['realname'];
                        }
                    }
                }
            }
            foreach ($list as $k => $v){
                if($v['type']){
                    switch ($v['type']){
                        case 1:
                            $data['list'][$k]['type'] = '增加';
                            break;
                        case 2:
                            $data['list'][$k]['type'] = '删除';
                            break;
                        case 3:
                            $data['list'][$k]['type'] = '更新';
                            break;
                        case 4:
                            $data['list'][$k]['type'] = '查询';
                            break;
                        default:
                            $data['list'][$k]['type'] = '未知';
                    }
                }
            }
        }
        //获取系统用户
        $data['adminList'] = Admin::getList("id, realname");
        
        $data['models'] = new Logs();
        $data['pagination'] = $pagination;
        return $this->render('index', $data);
    }
}
