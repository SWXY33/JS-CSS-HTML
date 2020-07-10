<?php

namespace common\models;

use Yii;
use common\components\Model;
use common\components\RecordModel;
use common\models\Region;



class AdminGrantModel extends Model{


    public static $dataKeys = array(
        'adminGrantId','name','parentId','orderby',
        'tag','url','icon','type','parentIdName','typeName'
    );


    public static function getParentTag($parentId){
        return empty($parentId)?null:Yii::$app->objectLoader->load('\common\models\AdminGrant',$parentId)->getTag();
    }
    //获取指定的角色的权限名称
   public function getGrantName($tags){
    
        if(!empty($tags)){
          if(strpos($tags,',')){
            $tagsArr = array();
            $tagsArr = explode(',',$tags);

            foreach( $tagsArr as $v){
              $sql = "select name from adminGrant where tag = '$v' AND deleteFlag = 0";
              $name = yii::$app->db->createCommand($sql)->queryOne();
              $names[] = $name; 
            }
            return $names;

          } else{

            $sql = "select name from adminGrant where tag = '$tags' AND deleteFlag = 0";
            $name = yii::$app->db->createCommand($sql)->queryOne();
            $names[] = $name;
            return $names;
          }
      }
   }

    public  function addAdminGrant($data){
        $adminGrant = array();
        $adminGrant['name'] = $data['name'];
        $adminGrant['parentId'] = $data['parentId'];
        $adminGrant['orderby'] = $data['orderby'];
        $adminGrant['tag'] = $data['tag'];
        $adminGrant['type'] = $data['type']?$data['type']:1;
        $adminGrant['url'] = $data['url'];
        $adminGrant['icon'] = $data['icon'];
        $data = AdminGrant::add($data);

    }

    /**
     * 待優化。。。。。
     * @param $keytype
     * @param string $keyword
     * @param string $page
     * @param string $pageSize
     * @param string $orderby
     * @return array|false
     */
    public function getAdminGrantList($keytype,$keyword='',$grantType,$showType,$limit,$orderby=""){

        $condition = 1;
        if (!empty($keyword)) {
            if ($keytype == 'parentId') {
                $sql = "SELECT adminGrantId FROM adminGrant WHERE `name` = '$keyword'";
                $data = Yii::$app->db->createCommand($sql)->queryOne();
                $keytype = 'parentId';
                $keyword = $data['adminGrantId'];
                // var_dump($data['adminGrantId']);exit();
                $condition =" $keytype like '%$keyword%' ";
            }else{
                if( in_array($keytype,\common\models\AdminGrant::tableCols()) ){
                    $condition =" $keytype like '%$keyword%' ";
                }
                else {
                    $condition = '1';
                }
            }
        }
        if($grantType == NULL){
           
        }else{
            $condition .=" and type = '$grantType' " ;
        }
        if($showType == NULL){
           
        }else{
            $condition .=" and `show` = '$showType' " ;
        }
        $count = AdminGrant::getCount($condition);
        $adminGrantList = AdminGrant::MultiLoad($condition,$orderby,$limit);
        $data = array();
        foreach( $adminGrantList as $adminGrant ) {
            $data['adminGrantList'][] = $adminGrant->getDataArray(self::$dataKeys);
        }
        
        $data['total']=$count;

        return $data;
       
    }
    public function getAdminGrant($adminGrantId){
       if(!empty($adminGrantId)){
            $sql = "select * from adminGrant where adminGrantId = '$adminGrantId'"; 
            $data = yii::$app->db->createCommand($sql)->queryOne();
       }
       $datas['adminGrant'] = $data;
      
       return $datas;
    }

    public function getGrantTag($name){
        $name = str_replace('(字段权限)', '', $name);
        $grant = AdminGrant::multiLoadRow("name = '$name'");
        return !empty($grant)?$grant->getTag():'';
    }

    public function getTopList(){
        return AdminGrant::multiLoad(['parentId' =>'0'],'orderby asc');
    }


    public function getAdminGrantByRole($adminRole){
        $adminGrants = AdminGrant::multiLoad(['parentId' =>'0'],'orderby asc');
        $grantList = array();
        $i = 0;
        foreach( $adminGrants as $k=>$adminGrant ) {
            if(!$adminRole->hasTag($adminGrant->getTag())) {
                continue;
            }
            $grantList[$i] = $adminGrant->getDataArray(self::$dataKeys);
            $childrenGrants = $adminGrant->getChildren();
            foreach( $childrenGrants as $m=>$childGrant ) {
                if (!$adminRole->hasTag($childGrant->getTag())) {
                    continue;
                }
                $grantList[$i]['childGrant'][] = $childGrant->getDataArray(self::$dataKeys);
            }
            $i ++ ;
        }

        return $grantList;
    }

}

?>