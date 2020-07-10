<?php

namespace common\models;

use Yii;
use common\components\RecordModel;

/**
 *
 */
class Admin extends RecordModel
{


    public static function primaryColumn()
    {
        return 'adminId';
    }

    /**
     * 状态值与名称
     * @var array
     */
    public static $stateList = [
        ADMIN_STATE_ACTIVE => '正常',
        ADMIN_STATE_CLOSE => '已禁用',
        ADMIN_STATE_LOCKED => '未激活'
    ];

    public function getAdminName()
    {
        return $this->adminName;
    }

    public function getIsCollapse()
    {
        return $this->isCollapse;
    }

    public static function getByAdminName($adminName)
    {
        $Admins = self::multiLoad(array('adminName' => $adminName));
        return empty($Admins) ? null : current($Admins);
    }

    /**
     * 根据用户名和密码获得用户
     *
     * @param string $userName
     * @param string $userPassword
     * @return object User对象 找不到返回null
     */
    public static function getByAdminPwd($userName, $userPassword)
    {
        $admin = self::getByAdminName($userName);
        if (empty($admin)) {
            return null;
        }
        return $admin->checkPassword($userPassword) ? $admin : null;
    }

    /**
     * 检查输入密码是否正确
     *
     * @param string $password
     * @return Boolean
     */
    public function checkPassword($userPassword)
    {
        $hash = self::getHashString($userPassword, $this->salt);
        if ($this->password === $hash) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 生成存储的密码串
     *
     * @param mixed $password
     * @param string $salt
     * @return
     */
    public static function getHashString($password, $salt = '')
    {
        return md5(md5($password) . $salt);
    }

    /**
     * 获取管理员ID
     * @return mixed|null
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * 获取角色名称
     * @return mixed
     * @throws \common\components\CException
     */
    public function getRoleName()
    {
        if(!empty($this->roleId)){
            return $this->getRole()->getName();
        }
        return '';
    }

    /**
     * 获取角色对象
     * @return mixed
     * @throws \common\components\CException
     */
    public function getRole()
    {   
        return AdminRole::getInstance($this->roleId);
    }

    public function hasPriv($urlKey)
    {
        return $this->getRole()->hasPriv($urlKey);
    }

    public function hasTag($tagKey)
    {
        return $this->getRole()->hasTag($tagKey);
    }

    public function updatePassword($newPassword)
    {
        $this->salt = substr(md5(microtime()), 0, 6);
        $this->password = self::getHashString($newPassword, $this->salt);
        $this->saveAttributes(array('salt', 'password'));
        // 日志
        $this->log("更新密码", 'NewPassword:' . $newPassword);
    }

    /**
     * 激活管理员
     * @return bool
     */
    public function activeAdmin()
    {
        $this->state = ADMIN_STATE_ACTIVE;
        $this->log("激活管理员");
        return $this->saveAttributes(['state']);
    }

    /**
     * 禁用管理员
     * @return bool
     */
    public function closeAdmin()
    {
        $this->state = ADMIN_STATE_CLOSE;
        $this->log("禁用管理员");
        return $this->saveAttributes(['state']);
    }

    /**
     * 获取管理员状态名称
     * @return mixed|string
     */
    public function getAdminStateName()
    {
        if (array_key_exists($this->state, self::$stateList)) {
            return self::$stateList[$this->state];
        } else {
            return "未知状态";
        }
    }

    /**
     * 获取管理员管理区域ID列表
     * @return array
     */
    public function getAdminZoneList()
    {
        if (!empty($this->zoneIdList)) {
            return explode(',', $this->zoneIdList);
        } else {
            return [];
        }
    }

    public function getAdminZoneList1()
    {
        if (!empty($this->zoneId)) {
            return explode(',', $this->zoneId);
        } else {
            return [];
        }
    }

    /**
     * 新增管理员
     * @param $adminName
     * @param $mobile
     * @param $password
     * @param $roleId
     * @param $zoneIdList
     * @param $state
     * @param $content
     * @return mixed
     */
    public static function addAdmin($adminName, $adminTrueName, $password = DEFAULT_ADMIN_PASSWORD, $mobile = '', $roleId = 0, $zoneIdList = '', $content = '', $state = ADMIN_STATE_ACTIVE)
    {
        $salt = substr(md5(microtime()), 0, 6);
        $data = [
            'adminName' => $adminName,
            'adminTrueName' => $adminTrueName,
            'mobile' => $mobile,
            'salt' => $salt,
            'password' => md5(md5($password) . $salt),
            'roleId' => $roleId,
            'zoneId' => !empty($zoneIdList) ? (is_array($zoneIdList)?implode(',',$zoneIdList):$zoneIdList) : '',
            'state' => $state,
            'content' => $content,
        ];
        $admin = self::create($data);
        $admin->log('新增管理员');
        return $admin;
    }

    /**
     * 更新代理商管理区域
     * @param $zoneIdList
     * @return bool
     */
    public function updateAdminZoneId($zoneIdList)
    {
        if (!empty($zoneIdList)) {
            $this->zoneId = implode(',', $zoneIdList);
            $this->log("修改代理商管理区域");
            return $this->saveAttributes(['zoneId']);
        }
        return false;
    }

    /**
     * 获取管理员真实姓名
     * @return mixed|null
     */
    public function getAdminTrueName()
    {
        return $this->adminTrueName;
    }

    /**
     * 获取代理商区域名称列表
     * 主要用于编辑回显
     * @return array
     * @throws \common\components\CException
     */
    public function getZoneNameList(){
        $list = [];
        if(!empty($this->zoneId)){
            $idList = explode(',',$this->zoneId);
            foreach ($idList as $id){
                $list[] = Zone::getInstance($id)->getZoneName();
            }
        }
        return $list;
    }

    /**
     * 获取负责区域名称
     * @return string
     * @throws \common\components\CException
     */
    public function getZoneName()
    {
        if (!empty($this->zoneId)) {
            $list = [];
            $zoneIdList = explode(',', $this->zoneId);
            foreach ($zoneIdList as $z) {
                if (($zone = Zone::getInstance($z)) && ($zone->isExists())) {
                    $list[] = $zone->getZoneName();
                }
            }
        }
        return !empty($list) ? implode(',', $list) : '';
    }


}


?>
