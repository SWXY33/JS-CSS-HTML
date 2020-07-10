<?php
namespace common\models;

use Yii;
use common\components\Model;
use common\components\SException;

class AppleModel extends Model
{

    /**
     * 获取学校列表
     * @param $keytype
     * @param $keyword
     * @param $page
     * @param $pageSize
     * @return array
     */

    public function getAppleList($keytype='',$keyword='',$limit='0,20',$state="",$regionIdList=""){
        $orderby = ' appleId DESC ';
        $condition = '1';

        if (!empty($keyword)) {
            $condition .=" AND $keytype LIKE '%$keyword%' ";
        }

        $data = Apple::multiLoad($condition,$orderby,$limit);
        $list = array();
        foreach ($data as $d){
            $list['list'][] = $d -> getDataArray(["appleId","name","color","price","weight"]);
        }
        $list['total'] = intval(Apple::getRecordCount($condition));
        return $list;

    }

}