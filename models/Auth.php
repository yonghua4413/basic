<?php

namespace app\models;

use app\core\MyModel;
use Yii;

/**
 * This is the model class for table "{{%t_auth}}".
 *
 * @property int $id
 * @property int $pid 父级id
 * @property string $auth 权限路由
 * @property string $auth_name 权限名称
 * @property int $is_del 是否删除
 * @property int $sort 排序
 */
class Auth extends MyModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%t_auth}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'is_del', 'sort'], 'integer'],
            [['auth', 'auth_name'], 'required'],
            [['auth', 'auth_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => '父级id',
            'auth' => '权限路由',
            'auth_name' => '权限名称',
            'is_del' => '是否删除',
            'sort' => '排序',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TAuthQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TAuthQuery(get_called_class());
    }
    
    /**
     * 返回系统权限
     * @return array|boolean
     */
    public static function getAuth($auth_ids = []){
        if(!count($auth_ids)) return false;
        $res = self::find()->where(['and', "is_del=:is_del", ['in', 'id', $auth_ids]], [':is_del' => 0])->select('auth')->asArray()->all();
        if($res){
            return array_column($res, 'auth');
        }
        return false;
    }
    
    /**
     * 查询权限列表
     * @param array $where
     * @param array $orderBy
     * @param array $group
     * @return NULL|unknown
     */
    public static function getList($where = [], $orderBy = []){
        $list = self::find()->where($where)
        ->orderBy($orderBy)
        ->asArray()
        ->all();
        if(!$list) return null;
        return $list;
    }
    
    /**
     * 统计
     */
    public static function count($where = []){
        $count = 0;
        $res = self::find()->where($where)->select('count(*) as num')->asArray()->all();
        if(!$res) return $count;
        return $res[0]['num'];
    }
    
    public static function getOne($where = []){
        if(empty($where)) return null;
        $info = self::find()->where($where)->one();
        if(!$info) return null;
        return $info->toArray();
    }
    
    /**
     * 删除
     */
    public static function del($where = []){
        $auth = self::findOne($where);
        $auth->is_del = 1;
        $res = $auth->save();
        if(!$res) return false;
        return true;
    }
    
    /**
     * 添加记录
     * @param array $data
     */
    public static function add($data = []){
        $auth = new self();
        $fields = $auth->attributeLabels();
        foreach ($fields as $k => $v){
            if(isset($data[$k]) && $data[$k]){
                $auth -> $k = $data[$k];
            }
        }
        $res = $auth->save();
        if(!$res) return false;
        return true;
    }
    
    public static function edit($id = 0, $data = []){
        if(!$id || !count($data)){
            return false;
        }
        $auth = self::findOne(['id' => $id]);
        $fields = $auth->attributeLabels();
        foreach ($fields as $k => $v){
            if(isset($data[$k]) && $data[$k]){
                $auth -> $k = $data[$k];
            }
        }
        $res = $auth->save();
        if(!$res) return false;
        return true;
    }
}
