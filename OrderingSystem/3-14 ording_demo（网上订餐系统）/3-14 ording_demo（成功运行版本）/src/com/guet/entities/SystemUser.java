package com.guet.entities;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.OneToOne;
import javax.persistence.Table;

import org.hibernate.annotations.GenericGenerator;

@Entity
@Table(name = "sys_users")
public class SystemUser extends com.guet.Entity {
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	
	/**
	 * id
	 */
	private String id;
	
	/**
	 * 登录名
	 */
	private String loginName;
	
	/**
	 * 密码
	 */
	private String loginPwd;
	
	/**
	 * 真实姓名
	 */
	private String realName;
	
	/**
	 * 电话
	 */
	private String tel;
	
	/**
	 * 用户头像
	 */
	private SystemFile photo;
	
	/**
	 * 邮箱
	 */
	private String email;
	
	/**
	 * 用户类型 默认0:用户  1:商家  2:管理员
	 */
	private int userType;
	
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

	@Column(length = 64)
	public String getLoginName() {
		return loginName;
	}

	public void setLoginName(String loginName) {
		this.loginName = loginName;
	}

	@Column(length = 64)
	public String getLoginPwd() {
		return loginPwd;
	}

	public void setLoginPwd(String loginPwd) {
		this.loginPwd = loginPwd;
	}

	@Column(length = 64)
	public String getRealName() {
		return realName;
	}

	public void setRealName(String realName) {
		this.realName = realName;
	}
	
	@Column(length = 64)
	public String getTel() {
		return tel;
	}

	public void setTel(String tel) {
		this.tel = tel;
	}
	
	@OneToOne
	@JoinColumn(name="photo_id")
	public SystemFile getPhoto() {
		return photo;
	}

	public void setPhoto(SystemFile photo) {
		this.photo = photo;
	}
	
	@Column(length = 64)
	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	@Column
	public int getUserType() {
		return userType;
	}

	public void setUserType(int userType) {
		this.userType = userType;
	}

	@Column
	public int getDbStatus() {
		return dbStatus;
	}

	public void setDbStatus(int dbStatus) {
		this.dbStatus = dbStatus;
	}
}
