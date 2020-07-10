<?php
namespace backend\controllers;

use common\components\SException;
use common\models\Demo;
use common\models\DemoModel;
use Yii;

class DemoController extends BaseController {

    public function actionDemoList()
    {
        $this->displayHtml('demoList');
    }

    public function actionAddDemoPage()
    {
        $this->displayHtml('addDemo');
    }

    public function actionEditDemoPage()
    {
        $this->displayHtml('editDemo');
    }


    public function actionAddDemo(){
        $data = Yii::$app->request->post('demo');
        $demo = Demo::addDemo($data);
        if ($demo) {
            $this->success('新增成功');
        }else{
            $this->error('新增失败');
        }


    }

    public function actionUpdateDemo(){
        try{
            $demoId = $this->request->post('demoId');
            $data = $this->request->post('demo');
            $demo = Demo::getInstance($demoId);
            $demo->update($data);
            $this->success();
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }

    public function actionDelDemo(){
        $demoId = Yii::$app->request->post('demoId');
        $data = Demo::getInstance($demoId)->delete();
        if ($data) {
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    public function actionGetDemoList(){
        $keytype = !empty(Yii::$app->request->post('keytype')) ? Yii::$app->request->post('keytype') : '';
        $keyword = trim(!empty(Yii::$app->request->post('keyword')) ? Yii::$app->request->post('keyword') : '');

        try{
            $data = DemoModel::getInstance()->getDemoList($keytype,$keyword,$this->getPageLimit());
            $this->displayData($data);
        } catch (SException $e) {
            $this->error($e->getMessage());
        }
    }


     public function actionGetDemoInfo(){
        $demoId = Yii::$app->request->post('demoId');
        try{
            $demo = Demo::getInstance($demoId);
            if(empty($demo)||!$demo->isExists()){
                $this->error();
            }
            $data = $demo->getDataArray(['name','age','home','telphone','showFlag']);
            $this->displayData($data);
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }

}
