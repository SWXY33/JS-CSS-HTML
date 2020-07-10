<?php
namespace backend\controllers;

use common\components\SException;
use common\models\Apple;
use common\models\AppleModel;
use Yii;

class AppleController extends BaseController {

    public function actionAppleList()
    {
        $this->displayHtml('appleList');
    }

    public function actionAddApplePage()
    {
        $this->displayHtml('addApple');
    }

    public function actionEditApplePage()
    {
        $this->displayHtml('editApple');
    }


    public function actionAddApple(){
        $data = Yii::$app->request->post('apple');
        $apple = Apple::addApple($data);
        if ($apple) {
            $this->success('新增成功');
        }else{
            $this->error('新增失败');
        }


    }

    public function actionUpdateApple(){
        try{
            $appleId = $this->request->post('appleId');
            $data = $this->request->post('apple');
            $apple = Apple::getInstance($appleId);
            $apple->update($data);
            $this->success();
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }

    public function actionDelApple(){
        $appleId = Yii::$app->request->post('appleId');
        $data = Apple::getInstance($appleId)->delete();
        if ($data) {
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    public function actionGetAppleList(){
        $keytype = !empty(Yii::$app->request->post('keytype')) ? Yii::$app->request->post('keytype') : '';
        $keyword = trim(!empty(Yii::$app->request->post('keyword')) ? Yii::$app->request->post('keyword') : '');

        try{
            $data = AppleModel::getInstance()->getAppleList($keytype,$keyword,$this->getPageLimit());
            $this->displayData($data);
        } catch (SException $e) {
            $this->error($e->getMessage());
        }
    }


     public function actionGetAppleInfo(){
        $appleId = Yii::$app->request->post('appleId');
        try{
            $apple = Apple::getInstance($appleId);
            if(empty($apple)||!$apple->isExists()){
                $this->error();
            }
            $data = $apple->getDataArray(['name','color','price','weight']);
            $this->displayData($data);
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }

}
