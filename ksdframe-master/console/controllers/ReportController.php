<?php

namespace console\controllers;

use common\models\ReportDayModel;
use Yii;

class ReportController extends BaseController {


    /**
     * 统计一天的数据
     * @param string $day 格式"YYYY-MM-DD"，留空为当天
     */
    public function actionDay($day=''){
        if( empty($day) ) $day = date('Y-m-d',time()-300);
        $this->message('check report day:'.$day);
        $sql = "select schoolId from school where deleteFlag=0";
        $result = Yii::$app->db->createCommand($sql)->queryAll();
        $this->message('check report school count:'.count($result));
        foreach( $result as $r ){
            $updateResult = ReportDayModel::getInstance()->setReportData( $r['schoolId'],$day );
            $this->message('check report set school ['.$r['schoolId'].']['.$day.']'.($updateResult?'success.':'failed!'));
        }
        $this->message('check report user finished:'.$day);
    }


    public function actionAll(){
        $this->message('check report all start.');
        for($time=strtotime('2019-12-01 10:00:00');$time<time();$time+=86400){
            $this->actionDay(date('Y-m-d',$time));
        }
        $this->message('check report all finished.');
    }


}
