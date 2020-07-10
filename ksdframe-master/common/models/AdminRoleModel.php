<?php


namespace common\models;


use Yii;
use common\models\AdminRole;
use common\components\Model;

class AdminRoleModel extends Model{

    public static $dataKeys = array(

        'adminRoleId','name','grantTagList','content','orderby','tagListName'

    );

    public function addAdminRole($name,$grantTagList,$content,$orderby){
        return AdminRole::add($name,$grantTagList,$content,$orderby);
    }

    public function getRoleList($keytype,$keyword,$limit){

        $orderby = ' adminRoleId DESC ';

        $condition = '1';

        if (!empty($keyword)) {
            $condition .=" AND $keytype LIKE '%$keyword%' ";
        }

        $data = AdminRole::multiLoad($condition,$orderby,$limit);
        $list = array();
        foreach ($data as $d){
            $list['list'][] = $d -> getDataArray(self::$dataKeys);
        }
        $list['total'] = intval(AdminRole::getRecordCount($condition));
        return $list;

    }



}