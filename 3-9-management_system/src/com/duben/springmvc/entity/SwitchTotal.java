package com.duben.springmvc.entity;

import java.util.ArrayList;
import java.util.List;

public class SwitchTotal {
 
	private List<SwitchCount> data=new ArrayList<SwitchCount>(); ;
	private String msg ;
	private Integer status ;
	
	public void addSwitchCount(SwitchCount switchcount) {
		data.add(switchcount);
    }

	@Override
    public String toString() {
        return "SwitchTotal{" +
                "status=" + status +
                ", msg=" + msg + 
                ", data=" + data +
                '}';
    }
	
	
	public List<SwitchCount> getData() {
		return data;
	}
	public void setData(List<SwitchCount> data) {
		this.data = data;
	}
	public String getMsg(String msg2) {
		return msg;
	}
	public void setMsg(String msg) {
		this.msg = msg;
	}
	public Integer getStatus() {
		return status;
	}
	public void setStatus(Integer status) {
		this.status = status;
	}




	
}
