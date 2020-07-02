package com.duben.springmvc.entity;

public class DeviceAddressVO {
	
	private static final long serialVersionUID = 1L;
	private String id;
    private String city;
    private String ip;
    private Divice mac;
    private String province;
    
	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
	}
	public String getCity() {
		return city;
	}
	public void setCity(String city) {
		this.city = city;
	}
	public String getIp() {
		return ip;
	}
	public void setIp(String ip) {
		this.ip = ip;
	}
	public Divice getMac() {
		return mac;
	}
	public void setMac(Divice mac) {
		this.mac = mac;
	}
	public String getProvince() {
		return province;
	}
	public void setProvince(String province) {
		this.province = province;
	}
    
    

}
