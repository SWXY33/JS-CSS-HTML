package com.guet.entities;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

import org.hibernate.annotations.GenericGenerator;

@Entity
@Table(name = "order_and_menu")
public class OrderAndMenu extends com.guet.Entity {
	
	private static final long serialVersionUID = 1L;
	
	/**
	 * 唯一标识
	 */
	private String id;
	
	private String orderId;
	
	private String menuId;
	
	private int count;

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

	public String getOrderId() {
		return orderId;
	}

	public void setOrderId(String orderId) {
		this.orderId = orderId;
	}

	public String getMenuId() {
		return menuId;
	}

	public void setMenuId(String menuId) {
		this.menuId = menuId;
	}

	public int getCount() {
		return count;
	}

	public void setCount(int count) {
		this.count = count;
	}
}
