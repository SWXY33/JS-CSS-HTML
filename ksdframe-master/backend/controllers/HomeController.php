<?php

namespace backend\controllers;

use Codeception\PHPUnit\ResultPrinter\Report;
use common\models\ReportDay;
use common\models\UserModel;
use common\models\PaymentMethod;
use common\models\ReportDayModel;
use Yii;
use yii\imagine\Image;

class HomeController extends BaseController {

    public function actionGetCount(){
        //获取考勤率总和以及考勤天数
//        $sqlAttendanceTodayPer = "select sum(`attendanceTodayPer`) as `attendanceTodayPerSum`,count(`attendanceTodayPer`) as `attendanceDayCount` from reportday where deleteFlag = 0";
//        $attendance = Yii::$app->db->createCommand($sqlAttendanceTodayPer)->queryOne();

        //获取考勤路线总数
//        $sqlRouteCount = "select count(*) as routeCount from route where deleteFlag = 0 and state = 1";
//        $routeCount = Yii::$app->db->createCommand($sqlRouteCount)->queryOne();

        //获取车辆总数
//        $sqlCarCount = "select count(*) as carCount from car where deleteFlag = 0 and `carState` = 1";
//        $carCount = Yii::$app->db->createCommand($sqlCarCount)->queryOne();

//        $data[0]['attendanceDayCount'] = $attendance['attendanceDayCount'];
//        $data[0]['averageAttendancePer'] = number_format(floatval($attendance['attendanceTodayPerSum'])/intval($attendance['attendanceDayCount']),2);
//        $data[0]['routeCount'] = $routeCount['routeCount'];
//        $data[0]['carCount'] = $carCount['carCount'];

        $this->displayData([]);
    }

    public function actionGetReportDay(){
        if( empty($day) ) {
            $day = date('Y-m-d');
        }

        $beginTime = strtotime($day.' 00:00:00');
        $endTime = strtotime($day.' 23:59:59');

        //1.获取今日考勤学生总人数
//        $sqlStudentAttendance = "select count(*) as attendanceStudentToday from student where deleteFlag = 0 and flag = 1";
//        $attendanceStudentToday = Yii::$app->db->createCommand($sqlStudentAttendance)->queryOne();

        //2.今日学生实际出勤人数
//        $todayCount = "select count(distinct studentId) as attendanceStudentTodayCount from studentLog where time > $beginTime and time < $endTime and deleteFlag = 0";
//        $todayStudent = Yii::$app->db->createCommand($todayCount)->queryOne();
//		$attendanceToday = array(
//			'attendanceToday' => $todayStudent['attendanceStudentTodayCount']
//		);

        //3.今日出勤率
//		$attendancePerToday = array(
//			'attendancePerToday' => number_format(intval($attendanceToday['attendanceToday'])/floatval($attendanceStudentToday['attendanceStudentToday'])*100,2)
//		);

		//4.今日校车数量
//		$sqlCarCount =  "select count(*) as carCountToday from car where deleteFlag = 0 and carState = 1";
//		$carCount = Yii::$app->db->createCommand($sqlCarCount)->queryOne();

		//5.今日路线数量
//		$sqlRouteCount =  "select count(*) as routeCountToday from route where deleteFlag = 0 and state = 1";
//		$routeCount = Yii::$app->db->createCommand($sqlRouteCount)->queryOne();

//        $this->displayData(array_merge($attendanceStudentToday,$attendanceToday,$attendancePerToday,$carCount,$routeCount));
	    $this->displayData([]);
    }

}