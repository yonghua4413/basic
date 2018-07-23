<?php
namespace app\controllers;

use Yii;
use app\core\MyController;

class ErrorController extends MyController
{
    public $layout = false;
    /**
     * Displays 404.
     *
     * @return string
     */
    public function action404()
    {
        return $this->render('404');
    }
    
    public function actionNoauth(){
        return $this->render('no_auth');
    }
}
