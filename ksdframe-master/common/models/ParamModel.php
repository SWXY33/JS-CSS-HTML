<?php

namespace common\models;

use Yii;
use common\components\Model;
use common\components\SException;

class ParamModel extends Model {

    protected $dataKeys = [
        'id','name','parentId','code','type','value','sortOrder','desc',
    ];

    protected $parentDataKeys = ['id','code'];

    public function getParamList($limit,$keytype,$keyword){

        $condition = "1";

        if (!empty($keyword) && !empty($keytype)){
            $condition .= " AND $keytype like '%$keyword%' ";
        }

        $reportList = Param::multiLoad($condition,'',$limit);
        $lists = array();
        foreach($reportList as $list){
            $list->parentId = $this->getParentValue($list->id) ? $this->getParentValue($list->id) : '无';
            $lists[] = $list->getDataArray($this->dataKeys);
        }

        $data = array();
        $data['list'] = $lists;
        $data['count'] = intval(Param::getRecordCount());
        return $data;
    }

    public function getParamParentList($params=array()){
        $reportList = Param::multiLoad('parent_id = 0');
        $data = array();
        foreach($reportList as $list){
            $data[] = $list->getDataArray($this->parentDataKeys);
        }

        return $data;
    }

    public function getParamConfig($param){
        $paramArray = explode(",", $param);

        $list = array();
        foreach($paramArray as $key => $param){
            $list[$param] = current($this->getParamParentCode($param));
        }

        return $list;
    }

    public function getAll(){

        $paramArray = Param::multiLoad();
        $data = array();
        foreach($paramArray as $param){
            $data[$param->getCode()] = $param->getDataArray($this->dataKeys)['value'];
        }

        return $data;
    }

    public function getParamParentCode($code){
        $reportList = Param::multiLoad("code = '$code'");
        $data = array();
        foreach($reportList as $list){
            $data[] = $list->getDataArray($this->dataKeys);
        }

        return $data;
    }

    /*
     * 获取父级value
     */
    public function getParentValue($id){
        $sql = "select value from sysconfig where deleteFlag = 0 AND id = ".$id;

        $result = Yii::$app->db->createCommand($sql)->queryOne();
        return $result['value'];
    }

    public static function addParam($goods){

        $data = $goods['paramData'];
        $code = (new self())->getParamParentCode($data['code']);

        if(!empty($code)){
            $data = array(
                'state' => false,
                'msg' => '填写的代码已存在'
            );
            return $data;
        }

        $paramData = array(
            'parentId' => $data['parentId'],
            'name' => $data['name'],
            'code' => $data['code'],
            'type' => $data['type'],
            'value' => $data['value'],
            'sortOrder' => $data['sortOrder'],
            'desc' => $data['desc'],
            'createTime' => time(),
        );

        $param = Param::create($paramData);

        $data = array(
            'state' => true,
            'data' => $param
        );
        return $data;
    }

    public function getTopUpInfo($id){
        $paramUpInfo = Param::getInstance($id)->getDataArray($this->dataKeys);
        return $paramUpInfo;
    }

    public function changeParam($id,$code,$value){
        if(empty($id)||empty($code)||empty($value)) {
            throw new SException('参数不能为空');
        }

        $param = Param::getInstance($id)->updateParam($code,$value);

        return $param;
    }

    public function updateParam($data){
        $stateList = array();
        foreach ($data as $key => $value) {
             $paramList = Param::multiLoad(['code'=>$key]);
             $param = current($paramList);
             if (!empty($param) && $param->getValue() != $value) {

                if ($key == 'withdraw_fee' && ($value < 0 || $value >= 1 )) {
                     throw new SException('提现手续费填写错误');
                }

                if ($key == 'transfer_fee' && ($value < 0 || $value >= 1 )) {
                     throw new SException('转账手续费填写错误');
                }
                
                $stateList[$key] = $param->updateParamCode($value,$key);
             }
             continue;
        }
        return $stateList;
    }

}

