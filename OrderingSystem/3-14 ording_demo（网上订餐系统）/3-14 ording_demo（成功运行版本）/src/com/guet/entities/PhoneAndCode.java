package com.guet.entities;

import java.sql.Timestamp;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;
import javax.xml.bind.annotation.adapters.XmlJavaTypeAdapter;

import com.guet.spring.TimestampAdapter;

/**
 * 验证码表
 * @author lili
 *
 */
@Entity
@Table(name = "phone_and_code")
public class PhoneAndCode extends com.guet.Entity {

	private static final long serialVersionUID = 1L;
	
	/**
	 * 手机号码
	 */
	private String phone;
	
	/**
	 * 验证码
	 */
	private String verifyCode;
	
	/**
	 * 验证码生成时间,超过60秒则无效
	 */
	private Timestamp createTime;

	@Id
	@Column(length = 30)
	public String getPhone() {
		return phone;
	}

	public void setPhone(String phone) {
		this.phone = phone;
	}

	@Column(length = 20)
	public String getVerifyCode() {
		return verifyCode;
	}

	public void setVerifyCode(String verifyCode) {
		this.verifyCode = verifyCode;
	}

	@XmlJavaTypeAdapter(TimestampAdapter.class)
	public Timestamp getCreateTime() {
		return createTime;
	}

	public void setCreateTime(@XmlJavaTypeAdapter(TimestampAdapter.class)Timestamp createTime) {
		this.createTime = createTime;
	}
}
