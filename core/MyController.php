<?php
namespace app\core;

use Yii;
use yii\helpers\HtmlPurifier;
use yii\web\Controller;

class MyController extends Controller
{   
    public $session;
    public $input;
    public $data;
    public $menus;
    
    public function beforeAction($action){
        
        $this->session = Yii::$app->session;
        $this->input = HtmlPurifier::process(Yii::$app->request);
        //判断登录
        $this->checkLogin();
        //权限判断
        if(!$this->checkAuth()){
            //没有权限的操作,显示没有权限
            $this->redirect(["/error/noauth"]);
        }
        //获取菜单
        $this->getMenus();
        return parent::beforeAction($action);
    }
    
    /**
     * 判断登录
     */
    private function checkLogin(){
        $userInfo = $this->session->get('userInfo');
        if(!$userInfo){
            $this->redirect(["/login/index"]);
            Yii::$app->end();
        }else{
            $userInfo = decrypt($userInfo);
            $this->data['userInfo'] = $userInfo;
        }
    }
    
    /**
     * 权限限制
     */
    private function checkAuth(){
        if($this->data['userInfo']['id'] == 1){
            return TRUE;
        }else{
            //获取url控制器名和方法名
            $controller = '';
            if(!isset(Yii::$app->controller->id)){
                $controller = 'home';
            }else{
                $controller = Yii::$app->controller->id;
            }
            $action = "";
            if(!isset(Yii::$app->controller->action->id)){
                $action = "index";
            }else{
                $action = Yii::$app->controller->action->id;
            }
            //当前请求的url
            $authNow = $controller.'/'.$action;
            //排除默认的权限
            $defaualt = C('default_auth');
            if(in_array($authNow, $defaualt)) {
                return true;
            }
            //判断系统权限
            if(!in_array($authNow, $this->data['userInfo']['path'])){
                return FALSE;
            }
            return TRUE;
        }
    }
    
    private function getMenus(){
        if($this->data['userInfo']['id'] == 1){
            $this->menus =  C('menus');
        }else{
            //先去除没有得的权限
            $menus = C('menus');
            $user_path = $this->data['userInfo']['path'];
            if(!count($user_path)){
                $this->menus = [];
            }
            $canUseMenus = [];
            foreach ($menus as $k => $v){
                foreach ($user_path as $key => $val){
                    if($v['url'] == $val){
                        array_push($canUseMenus, $v);
                    }
                }
            }
            foreach ($canUseMenus as $k => $v){
                if($v['type'] == "list"){
                    foreach ($v['list'] as $key => $val){
                        if(!in_array($val['url'], $user_path)){
                            unset($canUseMenus[$k]['list'][$key]);
                        }
                    }
                }
            }
            $this->menus = $canUseMenus;
        }
    }
    
    /**
     * 转化为json字符串
     * @author 254274509@qq.com
     * @param unknown $arr
     * @ruturn return_type
     */
    public function return_json($arr) {
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: X-Requested-With');
        header('Content-Type: application/json');
        header('Cache-Control: no-cache');
        echo json_encode($arr);exit;
    }
}