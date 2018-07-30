<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%t_logs}}".
 *
 * @property int $id
 * @property int $type 日志类型：1增加、2删除、3更新、4查询
 * @property int $user_id 用户id
 * @property string $create_time 创建日期
 * @property string $content 日志内容
 * @property string $sql 日志sql
 * @property string $ip ip地址
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%t_logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'user_id'], 'integer'],
            [['create_time'], 'safe'],
            [['content'], 'required'],
            [['content'], 'string'],
            [['sql'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '日志类型：1增加、2删除、3更新、4查询',
            'user_id' => '用户id',
            'create_time' => '创建日期',
            'content' => '日志内容',
            'sql' => '日志sql',
            'ip' => 'ip地址',
        ];
    }

    /**
     * {@inheritdoc}
     * @return LogsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogsQuery(get_called_class());
    }
    
    /**
     * 记录日志
     * @param number $user_id
     * @param string $type
     * @param string $content
     */
    public static function write_log($user_id = 0, $type = "0", $content = "", $sql =""){
        $log = new Logs();
        $log -> user_id = $user_id;
        $log -> type = $type;
        $log -> create_time = date('Y-m-d H:i:s');
        $log -> content = $content;
        $log -> sql = $sql;
        $log -> ip = Yii::$app->request->userIP;
        $log->save();
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
}
