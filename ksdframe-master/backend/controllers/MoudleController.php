<?php
namespace backend\controllers;

use common\components\SException;
use common\models\Moudle;
use common\models\MoudleModel;
use Yii;

class MoudleController extends BaseController {

    public function actionMoudleList()
    {
        $this->displayHtml('moudleList');
    }

    public function actionAddMoudlePage()
    {
        $this->displayHtml('addMoudle');
    }

    public function actionEditMoudlePage()
    {
        $this->displayHtml('editMoudle');
    }


    public function actionAddMoudle(){
        $data = Yii::$app->request->post('moudle');
        $data['colsNames'] = empty($data['colsNames'])?'{}':json_encode($data['colsNames'],JSON_UNESCAPED_UNICODE);
        $data['colsTypes'] = empty($data['colsTypes'])?'{}':json_encode($data['colsTypes'],JSON_UNESCAPED_UNICODE);
        $moudle = Moudle::addMoudle($data);
        if ($moudle) {
            $this->success('新增成功');
        }else{
            $this->error('新增失败');
        }


    }

    public function actionUpdateMoudle(){
        try{
            $moudleId = $this->request->post('moudleId');
            $data = $this->request->post('moudle');
            $data['colsNames'] = empty($data['colsNames'])?'{}':json_encode($data['colsNames'],JSON_UNESCAPED_UNICODE);
            $data['colsTypes'] = empty($data['colsTypes'])?'{}':json_encode($data['colsTypes'],JSON_UNESCAPED_UNICODE);
            $moudle = Moudle::getInstance($moudleId);
            $moudle->update($data);
            $this->success();
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }

    public function actionDelMoudle(){
        $moudleId = Yii::$app->request->post('moudleId');
        $data = Moudle::getInstance($moudleId)->delete();
        if ($data) {
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    public function actionGetMoudleList(){
        $keytype = !empty(Yii::$app->request->post('keytype')) ? Yii::$app->request->post('keytype') : '';
        $keyword = trim(!empty(Yii::$app->request->post('keyword')) ? Yii::$app->request->post('keyword') : '');

        try{
            $data = MoudleModel::getInstance()->getMoudleList($keytype,$keyword,$this->getPageLimit());
            $this->displayData($data);
        } catch (SException $e) {
            $this->error($e->getMessage());
        }
    }


     public function actionGetMoudleInfo(){
        $moudleId = Yii::$app->request->post('moudleId');
        try{
            $moudle = Moudle::getInstance($moudleId);
            if(empty($moudle)||!$moudle->isExists()){
                $this->error();
            }
            $data = $moudle->getDataArray(['moudleKey','moudleName','tableCols','showCols','primaryKey','colsNames','colsTypes']);
            $this->displayData($data);
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }

}
