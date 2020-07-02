package com.duben.springmvc.entity;

import java.io.Serializable;

public class Socket implements Serializable {

	 private static final long serialVersionUID = 1L;
	 
	    private String id;
	    private String deviceMac;
	    private String brandMode;
	    private String teldevicetype;
	    private String connectionState;
	    private String wifiMac;
	    private String deviceVersion;
	    private FourTimingDataLists fourTimingDataLists;
	    private String oldTimingList;
	    private int voltage;
	    private int power; 	
	    private int electricCurren;
	    private int electricityConsumption;
	    
	    public String getId() {
			return id;
		}
		public void setId(String id) {
			this.id = id;
		}
		public String getDeviceMac() {
			return deviceMac;
		}
		public void setDeviceMac(String deviceMac) {
			this.deviceMac = deviceMac;
		}
		public String getBrandMode() {
			return brandMode;
		}
		public void setBrandMode(String brandMode) {
			this.brandMode = brandMode;
		}
		public String getTeldevicetype() {
			return teldevicetype;
		}
		public void setTeldevicetype(String teldevicetype) {
			this.teldevicetype = teldevicetype;
		}
		public String getConnectionState() {
			return connectionState;
		}
		public void setConnectionState(String connectionState) {
			this.connectionState = connectionState;
		}
		public String getWifiMac() {
			return wifiMac;
		}
		public void setWifiMac(String wifiMac) {
			this.wifiMac = wifiMac;
		}
		public String getDeviceVersion() {
			return deviceVersion;
		}
		public void setDeviceVersion(String deviceVersion) {
			this.deviceVersion = deviceVersion;
		}
		
		public FourTimingDataLists getFourTimingDataLists() {
			return fourTimingDataLists;
		}
		public void setFourTimingDataLists(FourTimingDataLists fourTimingDataLists) {
			this.fourTimingDataLists = fourTimingDataLists;
		}
		public void setOldTimingList(String oldTimingList) {
			this.oldTimingList = oldTimingList;
		}
		public int getVoltage() {
			return voltage;
		}
		public void setVoltage(int voltage) {
			this.voltage = voltage;
		}
		public int getPower() {
			return power;
		}
		public void setPower(int power) {
			this.power = power;
		}
		public int getElectricCurren() {
			return electricCurren;
		}
		public void setElectricCurren(int electricCurren) {
			this.electricCurren = electricCurren;
		}
		public int getElectricityConsumption() {
			return electricityConsumption;
		}
		public void setElectricityConsumption(int electricityConsumption) {
			this.electricityConsumption = electricityConsumption;
		}
 
		
}
