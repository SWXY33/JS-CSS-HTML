<?php
namespace common\models;

use Yii;
use common\components\Model;
use common\components\SException;

class DemoModel extends Model
{

    /**
     * 获取学校列表
     * @param $keytype
     * @param $keyword
     * @param $page
     * @param $pageSize
     * @return array
     */

    public function getDemoList($keytype='',$keyword='',$limit='0,20',$state="",$regionIdList=""){
        $orderby = ' demoId DESC ';
        $condition = '1';

        if (!empty($keyword)) {
            $condition .=" AND $keytype LIKE '%$keyword%' ";
        }

        $data = Demo::multiLoad($condition,$orderby,$limit);
        $list = array();
        foreach ($data as $d){
            $list['list'][] = $d -> getDataArray(["demoId","name","age","home","telphone","score"]);
        }
        $list['total'] = intval(Demo::getRecordCount($condition));
        return $list;

    }

}