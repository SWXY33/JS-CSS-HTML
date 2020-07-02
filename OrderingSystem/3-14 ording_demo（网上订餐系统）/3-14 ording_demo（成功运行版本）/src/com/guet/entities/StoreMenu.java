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
 * 菜单
 * @author lili
 *
 */
@Entity
@Table(name = "store_menu")
public class StoreMenu extends com.guet.Entity {

	private static final long serialVersionUID = 1L;

	/**
	 * 唯一标识
	 */
	private String id;
	
	/**
	 * 所属店铺
	 */
	private Store store;
	
	/**
	 * 菜色照片
	 */
	private SystemFile photo;
	
	/**
	 * 创建时间
	 */
	private Timestamp createTime;
	
	/**
	 * 菜名
	 */
	private String menuName;
	
	/**
	 * 分类
	 */
	private String menuType;
	
	/**
	 * 菜色价格
	 */
	private double menuPrice;
	
	/**
	 * 描述
	 */
	private String menuDescribe;
	
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
	@JoinColumn(name="store_id")
	public Store getStore() {
		return store;
	}

	public void setStore(Store store) {
		this.store = store;
	}

	@OneToOne
	@JoinColumn(name="photo_id")
	public SystemFile getPhoto() {
		return photo;
	}

	public void setPhoto(SystemFile photo) {
		this.photo = photo;
	}

	@XmlJavaTypeAdapter(TimestampAdapter.class)
	public Timestamp getCreateTime() {
		return createTime;
	}

	public void setCreateTime(@XmlJavaTypeAdapter(TimestampAdapter.class)Timestamp createTime) {
		this.createTime = createTime;
	}

	public String getMenuName() {
		return menuName;
	}

	public void setMenuName(String menuName) {
		this.menuName = menuName;
	}

	public String getMenuType() {
		return menuType;
	}

	public void setMenuType(String menuType) {
		this.menuType = menuType;
	}

	public double getMenuPrice() {
		return menuPrice;
	}

	public void setMenuPrice(double menuPrice) {
		this.menuPrice = menuPrice;
	}

	public String getMenuDescribe() {
		return menuDescribe;
	}

	public void setMenuDescribe(String menuDescribe) {
		this.menuDescribe = menuDescribe;
	}

	public int getDbStatus() {
		return dbStatus;
	}

	public void setDbStatus(int dbStatus) {
		this.dbStatus = dbStatus;
	}
}
