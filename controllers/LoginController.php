<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\doForm;
use app\models\Admin;
use app\models\AdminQuery;
use app\models\Logs;

class LoginController extends Controller
{
    public $session;
    public $input;
    
    public function init(){
        $this->session = Yii::$app->session;
        $this->input= Yii::$app->request;
    }
    /**
     * Displays login
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
    
    public function actionDo(){
        $post = $this->input->post();
        $admin = new Admin();
        $admin->load($post);
        $admin->scenario = "login";
        if(!$admin->validate()){
            $this->return_json(['code' => 0, 'msg' => "数据验证失败"]);
        }
        $log = new Logs();
        $res = $admin->doLogin($post['username'], $post['password']);
        if(!$res['code']) {
            $log->write_log(0, 4, '登录:'.$res['msg']);
            $this->return_json($res);
        }
        //记录登录信息
        $log->write_log($res['data']['id'], 4, '登录:'.$res['data']['realname']);
        $info = encrypt($res['data']);
        $this->session->set('userInfo', $info);
        $this->return_json(['code' => 1, 'success']);
    }
    
    public function actionOut(){
        $this->session->destroy();
        $this->return_json(['code' => 1, 'msg' => "ok"]);
    }
    
    /**
     * 转化为json字符串
     * @author 254274509@qq.com
     * @param unknown $arr
     * @ruturn return_type
     */
    private function return_json($arr) {
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: X-Requested-With');
        header('Content-Type: application/json');
        header('Cache-Control: no-cache');
        echo json_encode($arr);exit;
    }
}
