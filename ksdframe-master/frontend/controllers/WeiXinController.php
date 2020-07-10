<?php


namespace frontend\controllers;


use common\components\SException;
use common\models\StudentModel;
use Yii;

class WeiXinController extends BaseController
{

    public function actionCheck(){
        return $this->displayHtml('check');
    }

    public function actionAttendance(){
        return $this->displayHtml('attendance');
    }

    public function actionRoute(){
        return $this->displayHtml('route');
    }

	public function actionCheckStudentState(){

		try {
			$parentMobile = Yii::$app->request->get('parentMobile');
			if(!empty($parentMobile)){
				$data = StudentModel::getInstance()->checkStudentState($parentMobile);
				$this->displayData($data);
			}else{
				$this->error("无法获取信息");
			}
		}
		catch (SException $e) {
			$this->error($e->getMessage());
		}

	}

}