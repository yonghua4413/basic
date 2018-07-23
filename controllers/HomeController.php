<?php
namespace app\controllers;

use Yii;
use app\core\MyController;

class HomeController extends MyController
{

    /**
     * Displays.
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = $this->data;
        return $this->render('index', $data);
    }
}
