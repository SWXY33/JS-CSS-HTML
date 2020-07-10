<?php

namespace common\models;

use Yii;
use common\components\Model;


class AdminModel extends Model
{

    public static $dataKeys = array(

        'adminId', 'adminName','roleId','roleName' ,'lastLogin', 'lastIp', 'mobile', 'adminTrueName', 'rank', 'isCollapse'

    );

    /**
     * 是否已经登录
     *
     * @return Boolean
     */
    public function isLogin()
    {
        return $this->getLoginUid() > 0 ? true : false;
    }

    /**
     * 获得当前用户的ID
     *
     * @return int 当前登录的用户ID userId
     */
    public function getLoginUid()
    {
        $adminId = Yii::$app->session->get('adminId');
        return isset($adminId) ? $adminId : 0;
    }

    /**
     * 获取当前登录管理员对象
     * @return mixed
     * @throws \common\components\CException
     */
    public function getLoginAdmin()
    {
        return Admin::getInstance($this->getLoginUid());
    }

    /**
     * 通过用户名和密码登录
     *
     * @param string $userName
     * @param string $userPassword
     * @return boolean 登录成功true/失败false
     */
    public function setLoginByAdminPwd($userName, $userPassword)
    {
        $admin = Admin::getByAdminPwd($userName, $userPassword);
        if (!empty($admin)) {
            $this->setLogin($admin);
            return true;
        } else {
            return false;
        }
    }


    public function setLogin($admin)
    {
        Yii::$app->session->set('adminId', $admin->getAdminId());
        Yii::$app->session->set('adminName', $admin->getAdminName());
        Yii::$app->session->set('adminTrueName', $admin->getAdminTrueName());
        Yii::$app->session->set('adminRole', $admin->getRoleId());
        Yii::$app->session->set('userId', $admin->getAdminId());
    }

    /**
     * 更新密码
     * @param $newPassword
     * @return mixed
     * @throws \common\components\CException
     */
    public function updatePassword($newPassword,$adminId=0)
    {
        $admin = Admin::getInstance($adminId>0?$adminId:$this->getLoginUid());
        return $admin->updatePassword($newPassword);
    }

    /**
     * 退出当前登录的用户
     *
     * @return void
     */
    public static function setLogout()
    {
        Yii::$app->session->set('adminId', '');
        Yii::$app->session->set('adminName', '');
        Yii::$app->session->set('adminTrueName', '');
        Yii::$app->session->set('adminRole', '');
    }

    /**
     * 获取管理员列表
     * @param $keytype
     * @param $keyword
     * @param $page
     * @param $pageSize
     * @param $zoneId
     * @return array
     */
    public function getAdminList($keytype, $keyword, $limit, $zoneId='')
    {
        $orderby = ' adminId DESC ';

        $condition = '1';
        if (!empty($keyword)&&!empty($keytype)) {
            $condition .= " AND $keytype LIKE '%$keyword%' ";
        }
        if (!empty($zoneId)) {
            $condition .= " AND zoneId LIKE '%$zoneId%' ";
        }
        return Admin::multiLoad($condition, $orderby, $limit);

    }

    /**
     * 获取当前条件下管理员数量
     * @param $keytype
     * @param $keyword
     * @return int
     */
    public function getAdminCount($keytype, $keyword, $zoneId=''){
        $condition = '1';
        if (!empty($keyword)&&!empty($keytype)) {
            $condition .= " AND $keytype LIKE '%$keyword%' ";
        }
        if (!empty($zoneId)) {
            $condition .= " AND zoneId LIKE '%$zoneId%' ";
        }
        return intval(Admin::getRecordCount($condition));
    }

}

?>