<?php

namespace app\models;

use app\core\MyModel;
use Yii;

/**
 * This is the model class for table "{{%t_admin}}".
 *
 * @property int $id
 * @property string $username 登录名
 * @property string $realname 真实名
 * @property int $role_id 角色id
 * @property string $password 密码
 * @property string $email 邮件
 * @property string $tel 电话
 * @property string $auth_ids 权限列表
 * @property int $create_id 创建人
 * @property int $update_id 更新人
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @property int $is_del 是否删除
 * @property int $is_limit 是否限制登录
 */
class Admin extends MyModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%t_admin}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'create_id', 'update_id', 'is_del', 'is_limit'], 'integer'],
            [['auth_ids'], 'required'],
            [['auth_ids'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['username', 'email'], 'string', 'max' => 20],
            [['realname'], 'string', 'max' => 12],
            [['password'], 'string', 'max' => 32],
            [['tel'], 'string', 'max' => 11],
        ];
    }
    
    /**
     * 登录场景
     * @return string[][]
     */
    public function scenarios() {
        return [
            'login' => ['username', 'password']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '登录名',
            'realname' => '真实名',
            'role_id' => '角色id',
            'password' => '密码',
            'email' => '邮件',
            'tel' => '电话',
            'auth_ids' => '权限列表',
            'create_id' => '创建人',
            'update_id' => '更新人',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'is_del' => '是否删除',
            'is_limit' => '是否限制登录',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AdminQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminQuery(get_called_class());
    }
    
    /**
     * 登录操作
     * @param unknown $username
     * @param unknown $password
     */
    public function doLogin($username, $password){

        $where = ['username' => $username, 'is_del' => 0];
        $info = self::find()->where($where)->one();
        if(!$info) {
            return ['code' => 0, 'msg' => "用户名:{$username}不存在"];
        }
        $info = $info->toArray();
        if(md5(encrypt($password)) != $info['password']) {
            return ['code' => 0, 'msg' => "用户名:{$username}或密码不正确"];
        }
        if($info['is_limit'] == 1) {
            return ['code' => 0, 'msg' => "用户:{$username}已结被限制登录"];
        }
        $info['path'] = [];
        $auth = new Auth();
        //提取用户的权限
        $auth_ids = [];
        if($info['auth_ids']){
            $auth_ids = explode(',', $info['auth_ids']);
        }
        
        $res = $auth -> getAuth($auth_ids);
        if($res){
            $info['path'] = $res;
        }
        unset($info['password']);
        return ['code' => 1, 'data' => $info];
        
    }
    
    public static function getUserByIds($ids = []){
        if(!count($ids)) return null;
        $userList = self::find()->where(['in', 'id', $ids])->select('id, realname')->asArray()->all();
        if(!$userList) return null;
        return $userList;
    }
    
    /**
     * 查询用户列表
     * @param string $fields
     * @param array $where
     * @return NULL|unknown
     */
    public static function getList($fields = "*", $where = []){
        $userList = self::find()->where($where)->select($fields)->asArray()->all();
        if(!$userList) return null;
        return $userList;
    }
}
