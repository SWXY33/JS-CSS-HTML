<?php


namespace frontend\controllers;


use common\components\SException;
use common\models\Car;
use common\models\CarModel;
use common\models\Device;
use common\models\DeviceLoginLogModel;
use common\models\DeviceModel;
use common\models\Driver;
use common\models\DriverModel;
use common\models\IcCardModel;

class MyTestController extends BaseController
{
//    新增车辆信息
    public function actionAddCar(){
        $data = [
            'carSn' => '1000000000001',
            'carPlat' => '鲁A11117',
            'energyNumber' => 'jkfs0000001',
            'carColor' => '红色',
            'maxPeople' => '10',
            'state' => '1',
        ];

        try {
            $carSn = $data['carSn'];
            $carPlat = $data['carPlat'];
            $energyNumber = $data['energyNumber'];
            $carColor = $data['carColor'];
            $maxPeople = $data['maxPeople'];
            $state = $data['state'];

            $car = CarModel::getInstance()->addCar($carSn,$carPlat,$energyNumber,$carColor,$maxPeople,$state);
            $this->displayData($car);
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

//    修改车辆信息
    public function actionEditCar(){
        $data = [
            'carId' => 1,
            'carSn' => '1000000000003',
            'carPlat' => '鲁A11118',
            'carColor' => '白色',
            'state' => '2',
        ];

        try {
            $carId = $data['carId'];
            $carSn = $data['carSn'];
            $carPlat = $data['carPlat'];
            $carColor = $data['carColor'];
            $state = $data['state'];

            if(!empty($carId)&&Car::getInstance($carId)){
                $car = CarModel::getInstance()->editCar($carId,$carSn,$carPlat,$carColor,$state);
                $this->displayData($car);
            }else{
                $this->error('未知信息');
            }
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

//    删除车辆
    public function actionDeleteCar(){
        $data = [
            'carId' => 1
        ];
        try {
            $carId = $data['carId'];
            if(!empty($carId)&&Car::getInstance($carId)){
                $car = Car::getInstance($carId)->delete();
                $this->displayData($car);
            }else{
                $this->error('未知信息');
            }
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

//    新增驾驶员
    public function actionAddDriver(){
        $data = [
            'name' => '王五',
            'mobile' => '15966667777',
            'idCard' => '100001194910010001',
            'sex' => '1',
            'driveYears' => '70',
            'image' => '/images/zhangsan.png',
            'carId' => '1',
            'content' => '单手开车老司机',
        ];

        try {

            $name = $data['name'];
            $mobile = $data['mobile'];
            $idCard = $data['idCard'];
            $sex = $data['sex'];
            $driveYears = $data['driveYears'];
            $image = $data['image'];
            $carId = $data['carId'];
            $content = $data['content'];

            $driver = DriverModel::getInstance()->addDriver($name,$mobile,$idCard,$sex,$driveYears,$image,$carId,$content);
            $this->displayData($driver);
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

//    修改驾驶员信息
    public function actionEditDriver(){
        $data = [
            'driverId' => 3,
            'name' => '王五1',
            'mobile' => '15966667778',
            'idCard' => '100001194910010002',
            'sex' => '0',
            'driveYears' => '65',
            'image' => '/images/wangwu.png',
            'carId' => '2',
            'content' => '单手开车de老司机',
        ];

        try {
            $driverId = $data['driverId'];
            $name = $data['name'];
            $mobile = $data['mobile'];
            $idCard = $data['idCard'];
            $sex = $data['sex'];
            $driveYears = $data['driveYears'];
            $image = $data['image'];
            $carId = $data['carId'];
            $content = $data['content'];

            if(!empty($driverId)&&Driver::getInstance($driverId)){
                $driver = DriverModel::getInstance()->editDriver($driverId,$name,$mobile,$idCard,$sex,$driveYears,$image,$carId,$content);
                $this->displayData($driver);
            }else{
                $this->error('未知信息');
            }
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

//    删除驾驶员
    public function actionDeleteDriver(){
        $data = [
            'driverId' => 2
        ];
        try {
            $driverId = $data['driverId'];
            if(!empty($driverId)&&Driver::getInstance($driverId)){
                $driver = Driver::getInstance($driverId)->delete();
                $this->displayData($driver);
            }else{
                $this->error('未知信息');
            }
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }
//    新增设备
    public function actionAddDevice(){
        $data = [
            'deviceSn' => '9000000001',
            'simNumber' => '15966667777',
            'deviceType' => '2',
            'state' => '',
            'carId' => ''
        ];

        try {

            $deviceSn = $data['deviceSn'];
            $simNumber = $data['simNumber'];
            $deviceType = $data['deviceType'];
            $state = $data['state'];
            $carId = $data['carId'];

            $device = DeviceModel::getInstance()->addDevice($deviceSn,$simNumber,$deviceType,$carId,$state);
            $this->displayData($device);
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

//    注销设备
    public function actionCancelDevice(){
        $data = [
            'deviceId' => 1
        ];
        try {
            $deviceId = $data['deviceId'];
            if(!empty($deviceId)&&Device::getInstance($deviceId)){
                $device = DeviceModel::getInstance()->cancelDevice($deviceId);
                $this->displayData($device);
            }else{
                $this->error('未知信息');
            }
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

//    绑定车辆
    public function actionBindCar(){
        $data = [
            'deviceId' => 2,
            'carId' => 2
        ];
        try {
            $deviceId = $data['deviceId'];
            $carId = $data['carId'];
            if(!empty($deviceId)&&Device::getInstance($deviceId)){
                $device = DeviceModel::getInstance()->bindCar($deviceId,$carId);
                $this->displayData($device);
            }else{
                $this->error('未知信息');
            }
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

//    新增IC卡
    public function actionAddIcCard(){

        $data = [
            'cardSn' => '9000000001',
            'cardState' => '1',
            'bindState' => '2',
            'useTime' => '',
            'bindTime' =>''
        ];

        try {

            $cardSn = $data['cardSn'];
            $cardState = $data['cardState'];
            $bindState = $data['bindState'];
            $useTime = $data['useTime'];
            $bindTime = $data['bindTime'];

            $icCard = IcCardModel::getInstance()->addIcCard($cardSn,$cardState,$bindState,$useTime,$bindTime);
            $this->displayData($icCard);
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }

    }
//  注销ic卡
    public function actionCancelIcCard(){
        $data = [
            'icCardId' => 1
        ];
        try {
            $icCardId = $data['icCardId'];
            if(!empty($icCardId)&&Device::getInstance($icCardId)){
                $icCard = IcCardModel::getInstance()->cancelIcCard($icCardId);
                $this->displayData($icCard);
            }else{
                $this->error('未知信息');
            }
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

//    新增设备登录日志
	public function actionAddDeviceLoginLog(){
		$data = [
			'deviceId' => 5,
			'carId' => 10005,
			'deviceState' => 1
		];
		try {
			$deviceId = $data['deviceId'];
			$carId = $data['carId'];
			$deviceState = $data['deviceState'];
			if(!empty($deviceId)&&Device::getInstance($deviceId)){
				$deviceLoginLog = DeviceLoginLogModel::getInstance()->addDeviceLoginLog($deviceId,$carId,$deviceState);
				$this->displayData($deviceLoginLog);
			}else{
				$this->error('找不到该设备');
			}
		}
		catch (SException $e) {
			$this->error($e->getMessage());
		}
	}

}