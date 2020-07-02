package com.guet.entities;

import java.sql.Timestamp;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.Table;
import javax.xml.bind.annotation.adapters.XmlJavaTypeAdapter;

import org.hibernate.annotations.GenericGenerator;

import com.guet.spring.TimestampAdapter;

/**
 * 收货地址
 * @author lili
 *
 */
@Entity
@Table(name = "rectipt_address")
public class ReceiptAddress extends com.guet.Entity {
	
	private static final long serialVersionUID = 1L;
	
	/**
	 * 唯一标识
	 */
	private String id;
	
	/**
	 * 创建时间
	 */
	private Timestamp createTime;
	
	/**
	 * 数据状态 0正常 -1删除
	 */
	private int dbStatus;
	
	/**
	 * 用户
	 */
	private SystemUser user;
	
	/**
	 * 收货人
	 */
	private String receiveName;
	
	/**
	 * 性别
	 */
	private String sex;
	
	/**
	 * 收货电话
	 */
	private String phone;
	
	/**
	 * 所在省份
	 */
	private String province;
	
	/**
	 * 所在城市
	 */
	private String city;
	
	/**
	 * 所在区,县
	 */
	private String county;
	
	/**
	 * 街道地址(详细地址)
	 */
	private String street;
	/**
	 * 给商家的留言
	 */
	private String guestBook;

	

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

	@XmlJavaTypeAdapter(TimestampAdapter.class)
	public Timestamp getCreateTime() {
		return createTime;
	}

	public void setCreateTime(@XmlJavaTypeAdapter(TimestampAdapter.class)Timestamp createTime) {
		this.createTime = createTime;
	}

	public int getDbStatus() {
		return dbStatus;
	}

	public void setDbStatus(int dbStatus) {
		this.dbStatus = dbStatus;
	}

	@ManyToOne
	@JoinColumn(name="user_id")
	public SystemUser getUser() {
		return user;
	}

	public void setUser(SystemUser user) {
		this.user = user;
	}

	public String getReceiveName() {
		return receiveName;
	}

	public void setReceiveName(String receiveName) {
		this.receiveName = receiveName;
	}

	public String getSex() {
		return sex;
	}

	public void setSex(String sex) {
		this.sex = sex;
	}

	public String getPhone() {
		return phone;
	}

	public void setPhone(String phone) {
		this.phone = phone;
	}

	public String getProvince() {
		return province;
	}

	public void setProvince(String province) {
		this.province = province;
	}

	public String getCity() {
		return city;
	}

	public void setCity(String city) {
		this.city = city;
	}

	public String getCounty() {
		return county;
	}

	public void setCounty(String county) {
		this.county = county;
	}

	public String getStreet() {
		return street;
	}

	public void setStreet(String street) {
		this.street = street;
	}
	public String getGuestBook() {
		return guestBook;
	}

	public void setGuestBook(String guestBook) {
		this.guestBook = guestBook;
	}
}
