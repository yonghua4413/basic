<?php
/**
 * Created by PhpStorm.
 * User: yonghua
 * Date: 2018-07-23
 * Time: 10:58
 */

namespace app\core;


use yii\db\ActiveRecord;

class MyModel extends ActiveRecord
{
    private $_table = NULL;
    public function __construct($table = "")
    {
        parent::__construct();
        $this->_table = $table;
    }

    public function create($data){

    }
}