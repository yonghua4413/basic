<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%t_role}}".
 *
 * @property int $id
 * @property string $role_name 角色名
 * @property string $auth_ids 权限值
 * @property string $create_time 创建日期
 * @property int $create_id 创建人
 * @property int $update_id 更新人
 * @property string $update_time 更新时间
 * @property int $is_del 是否删除
 * @property int $sort 排序
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%t_role}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auth_ids'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['create_id', 'update_id', 'is_del', 'sort'], 'integer'],
            [['role_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => '角色名',
            'auth_ids' => '权限值',
            'create_time' => '创建日期',
            'create_id' => '创建人',
            'update_id' => '更新人',
            'update_time' => '更新时间',
            'is_del' => '是否删除',
            'sort' => '排序',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TRoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TRoleQuery(get_called_class());
    }

    public static function getOne($where = []){
        $res = self::find()->where($where)->select('id, role_name, sort')->asArray()->one();
        if(!$res) return null;
        return$res;
    }

    public static function edit($id = 0, $data = []){
        if(!$id || !count($data)){
            return false;
        }
        $_this = self::findOne(['id' => $id]);
        $fields = $_this->attributeLabels();
        foreach ($fields as $k => $v){
            if(isset($data[$k]) && $data[$k]){
                $_this -> $k = $data[$k];
            }
        }
        $res = $_this->save();
        if(!$res) return false;
        return true;
    }
    
    /**
     * 查询日志列表
     * @return NULL|array
     */
    public static function getList($where =[], $order_by=[], $offset = 0, $limit = 0, $group =[]){
        $res = self::find()
        -> where($where)
        -> orderBy($order_by)
        -> offset($offset)
        -> limit($limit)
        -> asArray()
        ->all();
        if(!$res) return null;
        return $res;
    }
    
    /**
     * 统计条数
     * @return number|unknown
     */
    public static function count($where = []){
        $count = 0;
        $res = self::find()->where($where)->select('count(*) as num')->asArray()->all();
        if(!$res) return $count;
        return $res[0]['num'];
    }

    /**
     * 添加记录
     * @param array $data
     * @return bool
     */
    public static function add($data = []){
        $role = new self();
        $fields = $role->attributeLabels();
        foreach ($fields as $k => $v){
            if(isset($data[$k])){
                $role -> $k = $data[$k];
            }
        }
        $res = $role->save();
        if(!$res) return false;
        return true;
    }

    /**
     * 删除
     * @param array $where
     * @return bool
     */
    public static function del($where = []){
        $role = new self();
        $res = $role->findOne($where)->delete();
        if(!$res) return false;
        return true;
    }
}
