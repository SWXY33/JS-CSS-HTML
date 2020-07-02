package com.duben.springmvc.entity;

import java.util.ArrayList;
import java.util.List;



public class AllSwitch {
	
	private long status ;
    private String msg ;
    private List<Switch> data = new ArrayList<Switch>();
    
	public long getStatus() {
		return status;
	}
	public void setStatus(long status) {
		this.status = status;
	}
	public String getMsg() {
		return msg;
	}
	public void setMsg(String msg) {
		this.msg = msg;
	}
	public List<Switch> getData() {
		return data;
	}
	public void setData(List<Switch> data) {
		this.data = data;
	}
	

}

