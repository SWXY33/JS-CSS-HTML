package com.duben.springmvc.entity;

public class SwitchCount {

	private Integer connectCount  ;
	private Integer count ;
	
	@Override
    public String toString() {
        return "SwitchCount{" +
                "connectCount=" + connectCount +
                ", count=" + count +
                '}';
	
	}
	
	
	public Integer getConnectCount() {
		return connectCount;
	}
	public void setConnectCount(Integer connectCount) {
		this.connectCount = connectCount;
	}
	public Integer getCount() {
		return count;
	}
	public void setCount(Integer count) {
		this.count = count;
	}
	
	
}
