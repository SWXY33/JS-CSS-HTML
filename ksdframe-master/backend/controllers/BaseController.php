<?php
/**
 *
 *
 *
 */
namespace backend\controllers;

use common\models\SchoolModel;
use common\models\Zone;
use Yii;
use \common\components\Controller;
use common\models\Region;
use common\components\Validate;
use common\models\AdminModel;
use common\models\Param;

class BaseController extends Controller {

    public $layout = 'base'; //不使用布局

    protected $userId;
    protected $loginUser;
    protected $page = 1;
    protected $pageSize=20;
    protected $searchData=[];
    protected $keytype='';
    protected $keyword='';

    private $_filter_list = array(
        'base',
        'index',
        'sys',
        'admin',
        'adminGrant',
    );

    public function init()
    {
        parent::init();
        $this->getView()->title = Param::getConfig('sys_title');

        if (!AdminModel::getInstance()->isLogin()) {
            //判断cookie中是否有保存的登录信息
            //解密并设置登录状态

            //跳转到登录页面
            $this->redirect( $this->createUrl('/login/index'),'jstop' );
        }

        $admin = AdminModel::getInstance()->getLoginAdmin();
        // var_dump($this->id);exit;
        // if( !in_array($this->id,$this->_filter_list)&&!$admin->hasPriv($this->id) ) {
        //     die('无权访问'.$this->id);
        //     exit;
        // }
        $this->page = max(1,intval($this->request->post("page")));
        $this->pageSize = max(20,intval($this->request->post("pageSize")));

        $this->searchData = $this->request->post('searchData');
        $this->keytype = $this->request->post("keytype");
        $this->keyword = trim($this->request->post('keyword'));

    }

    public function actionRegion(){
        //验证权限

        $request = Yii::$app->request;
        if($regionId=$request->post("region")){
            if(!Validate::posint($regionId,5)){
                $this->error("参数不符合规则");
            }
        }else{
            $regionId = 0;
        }
        $data = Region::getRegion($regionId);
        $this->displayData($data);
    }

    protected function getPageLimit($page=0,$pageSize=0){
        if( !empty($pageSize) ) {
            $pageSize = min(1000,intval($pageSize));
        } else {
            $pageSize = min(1000,$this->pageSize);
        }
        $page = !empty($page)?intval($page):$this->page;
        return (intval($page)-1)*$pageSize.','.$pageSize;
    }

    protected function getSearchData(){
        /*$searchData = $this->searchData;
        if (!empty($this->keyword)) {
           $searchData = [];
           $searchData[$this->keytype] = $this->keyword;
        }
        return $searchData;*/

        //增加代理商的判断
        $admin = AdminModel::getInstance()->getLoginAdmin();
        if ($admin->roleId == 1) {
            //管理员
            $searchData = $this->searchData;
            if (!empty($this->keyword)) {
                $searchData = [];
                $searchData[$this->keytype] = $this->keyword;
            }
            return $searchData;
        }else{
            //$zoneArr = $admin->getAdminZoneList1();
//            for ($i=0;$i<count($zoneArr);$i++) {
//               $schoolStr =  Zone::getInstance($zoneArr[$i])->getZoneSchoolListString();
//               var_dump($schoolStr);die;
//            }
            //非管理员，有区域限制
            //SchoolModel::getInstance()->getSchoolList($keytype,$keyword,$zoneId,$this->getPageLimit(),$state);
//            $zoneArr = $admin->getAdminZoneList();
//            var_dump($admin);
//            var_dump(111111111111);
//            var_dump($zoneArr);die;
//           $arr = SchoolModel::getInstance()->getSchoolList($this->keytype,$this->keyword,$admin->zoneId,$this->getPageLimit(),1);
//           var_dump($arr);die;
//
//           $schoolIdList = Zone::getInstance($zoneId[0])->getZoneSchoolListString();

            $searchData = $this->searchData;
            $searchData['selectZoneList'][] = $admin->zoneId;
            if (!empty($this->keyword)) {
                $searchData[$this->keytype] = $this->keyword;
            }
            //var_dump($searchData);die;
            return $searchData;
        }

    }


}

