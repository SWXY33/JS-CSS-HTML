<?php
namespace common\models;

use Yii;
use common\components\Model;
use common\components\SException;

class MoudleModel extends Model
{

    /**
     * 获取学校列表
     * @param $keytype
     * @param $keyword
     * @param $page
     * @param $pageSize
     * @return array
     */

    public function getMoudleList($keytype='',$keyword='',$limit='0,20',$state="",$regionIdList=""){
        $orderby = ' moudleId DESC ';
        $condition = '1';

        if (!empty($keyword)) {
            $condition .=" AND $keytype LIKE '%$keyword%' ";
        }

        $data = Moudle::multiLoad($condition,$orderby,$limit);
        $list = array();
        foreach ($data as $d){
            $list['list'][] = $d -> getDataArray(["moudleId","moudleName","tableCols","showCols","primaryKey","colsNames","colsTypes"]);
        }
        $list['total'] = intval(Moudle::getRecordCount($condition));
        return $list;

    }

}