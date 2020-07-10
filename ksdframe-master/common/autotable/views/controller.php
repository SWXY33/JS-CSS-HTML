<?='<?php'?>

namespace backend\controllers;

use common\components\SException;
use common\models\<?=ucfirst($name)?>;
use common\models\<?=ucfirst($name)?>Model;
use Yii;

class <?=ucfirst($name)?>Controller extends BaseController {

    public function action<?=ucfirst($name)?>List()
    {
        $this->displayHtml('<?=$name?>List');
    }

    public function actionAdd<?=ucfirst($name)?>Page()
    {
        $this->displayHtml('add<?=ucfirst($name)?>');
    }

    public function actionEdit<?=ucfirst($name)?>Page()
    {
        $this->displayHtml('edit<?=ucfirst($name)?>');
    }


    public function actionAdd<?=ucfirst($name)?>(){
        $data = Yii::$app->request->post('<?=$name?>');
        $<?=$name?> = <?=ucfirst($name)?>::add<?=ucfirst($name)?>($data);
        if ($<?=$name?>) {
            $this->success('新增成功');
        }else{
            $this->error('新增失败');
        }


    }

    public function actionUpdate<?=ucfirst($name)?>(){
        try{
            $<?=$config['primaryKey']?> = $this->request->post('<?=$config['primaryKey']?>');
            $data = $this->request->post('<?=$name?>');
            $<?=$name?> = <?=ucfirst($name)?>::getInstance($<?=$config['primaryKey']?>);
            $<?=$name?>->update($data);
            $this->success();
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }

    public function actionDel<?=ucfirst($name)?>(){
        $<?=$config['primaryKey']?> = Yii::$app->request->post('<?=$config['primaryKey']?>');
        $data = <?=ucfirst($name)?>::getInstance($<?=$config['primaryKey']?>)->delete();
        if ($data) {
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    public function actionGet<?=ucfirst($name)?>List(){
        $keytype = !empty(Yii::$app->request->post('keytype')) ? Yii::$app->request->post('keytype') : '';
        $keyword = trim(!empty(Yii::$app->request->post('keyword')) ? Yii::$app->request->post('keyword') : '');

        try{
            $data = <?=ucfirst($name)?>Model::getInstance()->get<?=ucfirst($name)?>List($keytype,$keyword,$this->getPageLimit());
            $this->displayData($data);
        } catch (SException $e) {
            $this->error($e->getMessage());
        }
    }


     public function actionGet<?=ucfirst($name)?>Info(){
        $<?=$config['primaryKey']?> = Yii::$app->request->post('<?=$config['primaryKey']?>');
        try{
            $<?=$name?> = <?=ucfirst($name)?>::getInstance($<?=$config['primaryKey']?>);
            if(empty($<?=$name?>)||!$<?=$name?>->isExists()){
                $this->error();
            }
            $data = $<?=$name?>->getDataArray(['<?=implode("','",$config['tableCols'])?>']);
            $this->displayData($data);
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }

}
