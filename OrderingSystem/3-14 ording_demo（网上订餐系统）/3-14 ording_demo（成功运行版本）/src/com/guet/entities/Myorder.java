package com.guet.entities;

import java.sql.Timestamp;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.OneToOne;
import javax.persistence.Table;
import javax.xml.bind.annotation.adapters.XmlJavaTypeAdapter;

import org.hibernate.annotations.GenericGenerator;

import com.guet.spring.TimestampAdapter;

/**
 * 我的外卖
 * @author lili
 *
 */
@Entity
@Table(name = "my_order")
public class Myorder extends com.guet.Entity {

	private static final long serialVersionUID = 1L;
	
	/**
	 * 唯一标识
	 */
	private String id;
	
	/**
	 * 关联的消费者
	 */
	private SystemUser customer;
	/**
	 * 下单时间
	 */
	private Timestamp orderTime;
	
	/**
	 *用户名
	 */
	private String customerName;
	
	/**
	 * 
	 */
	private String storeDescribe;
	
	/**
	 * 所在省份
	 */
	private String storeProvince;
	
	/**
	 * 所在城市
	 */
	private String storeCity;
	
	/**
	 * 所在区,县
	 */
	private String storeCounty;
	
	/**
	 * 街道地址(详细地址)
	 */
	private String street;
	
	/**
	 * 经度
	 */
	private double longitude;
	
	/**
	 * 纬度
	 */
	private double latitude;
	
	/**
	 * 数据状态 0正常 -1删除
	 */
	private int dbStatus;

	@Id
	@GenericGenerator(name = "paymentableGenerator", strategy = "uuid")
	@GeneratedValue(generator = "paymentableGenerator")
	@Column(length = 64)
	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	@OneToOne
	@JoinColumn(name="business_id")
	public SystemUser getBusiness() {
		return customer;
	}

	public void setBusiness(SystemUser business) {
		this.customer = business;
	}

	@XmlJavaTypeAdapter(TimestampAdapter.class)
	public Timestamp getCreateTime() {
		return orderTime;
	}

	public void setCreateTime(@XmlJavaTypeAdapter(TimestampAdapter.class)Timestamp createTime) {
		this.orderTime = createTime;
	}

	public String getStoreName() {
		return customerName;
	}

	public void setStoreName(String storeName) {
		this.customerName = storeName;
	}

	public String getStoreDescribe() {
		return storeDescribe;
	}

	public void setStoreDescribe(String storeDescribe) {
		this.storeDescribe = storeDescribe;
	}

	public String getStoreProvince() {
		return storeProvince;
	}

	public void setStoreProvince(String storeProvince) {
		this.storeProvince = storeProvince;
	}

	public String getStoreCity() {
		return storeCity;
	}

	public void setStoreCity(String storeCity) {
		this.storeCity = storeCity;
	}

	public String getStoreCounty() {
		return storeCounty;
	}

	public void setStoreCounty(String storeCounty) {
		this.storeCounty = storeCounty;
	}

	public String getStreet() {
		return street;
	}

	public void setStreet(String street) {
		this.street = street;
	}

	public double getLongitude() {
		return longitude;
	}

	public void setLongitude(double longitude) {
		this.longitude = longitude;
	}

	public double getLatitude() {
		return latitude;
	}

	public void setLatitude(double latitude) {
		this.latitude = latitude;
	}

	public int getDbStatus() {
		return dbStatus;
	}

	public void setDbStatus(int dbStatus) {
		this.dbStatus = dbStatus;
	}
}
