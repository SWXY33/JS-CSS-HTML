<?='<?php'?>

namespace common\models;

use Yii;
use common\components\Model;
use common\components\SException;

class <?=ucfirst($name)?>Model extends Model
{

    public function get<?=ucfirst($name)?>List($keytype='',$keyword='',$limit='0,20',$state="",$regionIdList=""){
        $orderby = ' <?=$config['primaryKey']?> DESC ';
        $condition = '1';

        if (!empty($keyword)) {
            $condition .=" AND $keytype LIKE '%$keyword%' ";
        }

        $data = <?=ucfirst($name)?>::multiLoad($condition,$orderby,$limit);
        $list = array();
        foreach ($data as $d){
            $list['list'][] = $d -> getDataArray(<?=json_encode($config['showCols'])?>);
        }
        $list['total'] = intval(<?=ucfirst($name)?>::getRecordCount($condition));
        return $list;

    }

}