package com.duben.springmvc.entity;

import java.io.Serializable;
import java.sql.Timestamp;


	public class Divice implements Serializable {
		
		private static final long serialVersionUID = 1L;
		private String bindingmar;
		private String brandMode;
		private String controlmark;
		private String created;
		private Integer deviceid;
		private String deviceposition;
		private String deviceremark;
		private String deviceserialnumber;
		private String devicetype;
		private String identifying; 	
		private String percentage;
		private String picpath;
		private String reversing;
		private Integer sceneid;
		private User userid;
		
		public String getBindingmar() {
			return bindingmar;
		}
		public void setBindingmar(String bindingmar) {
			this.bindingmar = bindingmar;
		}
		public String getBrandMode() {
			return brandMode;
		}
		public void setBrandMode(String brandMode) {
			this.brandMode = brandMode;
		}
		public String getControlmark() {
			return controlmark;
		}
		public void setControlmark(String controlmark) {
			this.controlmark = controlmark;
		}
		public String getCreated() {
			return created;
		}
		public void setCreated(String created) {
			this.created = created;
		}
		public Integer getDeviceid() {
			return deviceid;
		}
		public void setDeviceid(Integer deviceid) {
			this.deviceid = deviceid;
		}
		public String getDeviceposition() {
			return deviceposition;
		}
		public void setDeviceposition(String deviceposition) {
			this.deviceposition = deviceposition;
		}
		public String getDeviceremark() {
			return deviceremark;
		}
		public void setDeviceremark(String deviceremark) {
			this.deviceremark = deviceremark;
		}
		public String getDeviceserialnumber() {
			return deviceserialnumber;
		}
		public void setDeviceserialnumber(String deviceserialnumber) {
			this.deviceserialnumber = deviceserialnumber;
		}
		public String getDevicetype() {
			return devicetype;
		}
		public void setDevicetype(String devicetype) {
			this.devicetype = devicetype;
		}
		public String getIdentifying() {
			return identifying;
		}
		public void setIdentifying(String identifying) {
			this.identifying = identifying;
		}
		public String getPercentage() {
			return percentage;
		}
		public void setPercentage(String percentage) {
			this.percentage = percentage;
		}
		public String getPicpath() {
			return picpath;
		}
		public void setPicpath(String picpath) {
			this.picpath = picpath;
		}
		public String getReversing() {
			return reversing;
		}
		public void setReversing(String reversing) {
			this.reversing = reversing;
		}
		public Integer getSceneid() {
			return sceneid;
		}
		public void setSceneid(Integer sceneid) {
			this.sceneid = sceneid;
		}
		public User getUserid() {
			return userid;
		}
		public void setUserid(User userid) {
			this.userid = userid;
		}
		
		
	   
	}

