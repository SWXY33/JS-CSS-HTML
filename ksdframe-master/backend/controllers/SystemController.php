<?php

namespace backend\controllers;

use Yii;
use \common\components\Controller;
use common\models\ShopModel; 
use common\models\Admin; 
use common\models\ParamModel; 
use common\models\Param; 

class SystemController extends BaseController {

    public function actionSetting(){
        return $this->render("setting");
    }

    public function actionParamList(){
        return $this->render("paramList");
    }

    public function actionGetShopConfig(){

        $param = !empty(Yii::$app->request->post('param'))?Yii::$app->request->post('param'):'';

        $ParamModel = ParamModel::getInstance();
        if (!empty($param)) {
           $shopConfigData = $ParamModel->getParamConfig($param);
        }else{
            $shopConfigData = $ParamModel->getAll();
        }
        
        $this->displayData($shopConfigData);
    }

    public function actionGetParamParentList(){
        $ParamModel = ParamModel::getInstance();

        $paramParentList = $ParamModel->getParamParentList();

        $this->displayData(['list'=>$paramParentList]);
    }

    public function actionGetParamList(){

        $keytype = !empty(Yii::$app->request->post('keytype'))?Yii::$app->request->post('keytype'):'';
        $keyword = trim(!empty(Yii::$app->request->post('keyword'))?Yii::$app->request->post('keyword'):'');
        $ParamModel = ParamModel::getInstance();

        $paramList = $ParamModel->getParamList($this->getPageLimit(),$keytype,$keyword);

        $this->displayData($paramList);
    }

    public function actionAddParam(){
        $data = Yii::$app->request->post();
        $goodsInfo = ParamModel::addParam($data);
        if ($goodsInfo['state']) {
            $this->displayData($goodsInfo['data']);
        }else{
            $this->error($goodsInfo['msg']);
        }
    }

    public function actionUpdateParam(){
        $data = Yii::$app->request->post();
        try{
            $paramState = ParamModel::getInstance()->updateParam($data['shopData']);
            $this->success('保存成功',$paramState);
        }
        catch (SException $e){
            $this->error($e->getMessage());
        }
    }

    public function actionEdit(){
        $id = Yii::$app->request->post('id');
        $paramInfo = ParamModel::getInstance()->getTopUpInfo($id);
        $this->echoJsonData($paramInfo);
    }

    public function actionEditSubmit(){
        $id = Yii::$app->request->post('id');
        $code = Yii::$app->request->post('code');
        $value = Yii::$app->request->post('value');

        $ParamModel = ParamModel::getInstance();

        $param = $ParamModel->changeParam($id,$code,$value);

        if(!empty($param) || $param == 0){//校验是否有数据
            $this->success();
        } else {
            $this->error();
        }
    }

    public function actionDelParam(){
        $id = Yii::$app->request->post('id');
        $Param = Param::getInstance($id);
        $status = $Param->delete();
        if ($status) {
            $this->success();
        }else{
            $this->error('删除失败');
        }

    }


}
