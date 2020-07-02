package com.duben.springmvc.entity;

import java.util.List;




public class DeviceVo {
    //设备id
    private Long deviceId;
  //设备型号
    private String brandMode;
    //连接状态，1：在线，0：不在线
    private String connectionState;
    //设备mac
    private String deviceMac;
    //设备版本
    private String deviceVersion;
    //设备类型
    private String deviceType;
    //四个定时数据
    private List<FourTimingDataLists> fourTimingDataLists;
    private List<OldTiming > oldTiming;
    private List<OneTimingDataLists > oneTimingDataLists;
    private List<TwoTimingDataLists  > twoTimingDataLists;
    private List<ThreeTimingDataLists  > threeTimingDataLists;
    //设备wifiMac 
    private String wifiMac ;
    /**
     * 窗帘属性
     */
    //方向
    private String reversing;
    public Long getDeviceId() {
		return deviceId;
	}

	public void setDeviceId(Long deviceId) {
		this.deviceId = deviceId;
	}

	public String getBrandMode() {
		return brandMode;
	}

	public void setBrandMode(String brandMode) {
		this.brandMode = brandMode;
	}

	public String getConnectionState() {
		return connectionState;
	}

	public void setConnectionState(String connectionState) {
		this.connectionState = connectionState;
	}

	public String getDeviceMac() {
		return deviceMac;
	}

	public void setDeviceMac(String deviceMac) {
		this.deviceMac = deviceMac;
	}

	public String getDeviceVersion() {
		return deviceVersion;
	}

	public void setDeviceVersion(String deviceVersion) {
		this.deviceVersion = deviceVersion;
	}

	public String getDeviceType() {
		return deviceType;
	}

	public void setDeviceType(String deviceType) {
		this.deviceType = deviceType;
	}

	public List<FourTimingDataLists> getFourTimingDataLists() {
		return fourTimingDataLists;
	}

	public void setFourTimingDataLists(List<FourTimingDataLists> fourTimingDataLists) {
		this.fourTimingDataLists = fourTimingDataLists;
	}

	public List<OldTiming> getOldTiming() {
		return oldTiming;
	}

	public void setOldTiming(List<OldTiming> oldTiming) {
		this.oldTiming = oldTiming;
	}

	public List<OneTimingDataLists> getOneTimingDataLists() {
		return oneTimingDataLists;
	}

	public void setOneTimingDataLists(List<OneTimingDataLists> oneTimingDataLists) {
		this.oneTimingDataLists = oneTimingDataLists;
	}

	public List<TwoTimingDataLists> getTwoTimingDataLists() {
		return twoTimingDataLists;
	}

	public void setTwoTimingDataLists(List<TwoTimingDataLists> twoTimingDataLists) {
		this.twoTimingDataLists = twoTimingDataLists;
	}

	public List<ThreeTimingDataLists> getThreeTimingDataLists() {
		return threeTimingDataLists;
	}

	public void setThreeTimingDataLists(List<ThreeTimingDataLists> threeTimingDataLists) {
		this.threeTimingDataLists = threeTimingDataLists;
	}

	public String getWifiMac() {
		return wifiMac;
	}

	public void setWifiMac(String wifiMac) {
		this.wifiMac = wifiMac;
	}

	public String getReversing() {
		return reversing;
	}

	public void setReversing(String reversing) {
		this.reversing = reversing;
	}

	public String getPercentage() {
		return percentage;
	}

	public void setPercentage(String percentage) {
		this.percentage = percentage;
	}

	public String getElectricityConsumption() {
		return electricityConsumption;
	}

	public void setElectricityConsumption(String electricityConsumption) {
		this.electricityConsumption = electricityConsumption;
	}

	//百分比
    private String percentage;

    /**
     * 插座属性
     */
    //电量
    private String electricityConsumption;


}
