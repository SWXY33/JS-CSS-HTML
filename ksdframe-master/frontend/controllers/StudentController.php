<?php

namespace frontend\controllers;

use common\components\Util;
use common\components\SException;
use common\components\CException;
use common\models\StudentModel;
use common\models\Student;
use common\models\Staff;
use common\models\StaffModel;
use common\models\StudentClassModel;
use common\models\AttendanceModel;
use common\models\RouteModel;
use common\models\StudentLogModel;
use common\models\StudentLog;
use common\components\WxAppPay;
use Yii;

class StudentController extends BaseController
{

    public function actionDataReport(){

        $rules = [
            'token' => ['notBlank'], 
            'icCardId' => ['notBlank'], 
            'studentId' => ['notBlank'], 
            'time' => ['notBlank'], 
            'state' => ['notBlank'], 
            'routeType' => ['notBlank'], 
        ];
        $data = $this->validateInput($rules);
        
        try {
            $data = StudentLogModel::getInstance()->addStudentLog($data['token'],$data['icCardId'],$data['studentId'],$data['time'],$data['state'],$data['routeType']);
            $this->displayData($data);
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }

    }

    public function actionCheckStudentState(){

        $rules = [
            'parentMobile' => ['notBlank'], 
        ];
        $data = $this->validateInput($rules);
        
        try {
            $data = StudentModel::getInstance()->checkStudentState($data['parentMobile']);
            $this->displayData($data);
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }

    }



}
