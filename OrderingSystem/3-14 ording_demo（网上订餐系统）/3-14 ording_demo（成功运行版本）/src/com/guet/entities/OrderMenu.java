package com.guet.entities;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.OneToOne;
import javax.persistence.Table;

import org.hibernate.annotations.GenericGenerator;

/**
 * 订单菜单关系表
 * @author lili
 *
 */
@Entity
@Table(name = "order_menu")
public class OrderMenu extends com.guet.Entity {

	private static final long serialVersionUID = 1L;
	
	/**
	 * 唯一标识
	 */
	private String id;
	
	private GoodsOrder order;
	
	private StoreMenu menu;
	
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

	@OneToOne
	@JoinColumn(name="order_id")
	public GoodsOrder getOrder() {
		return order;
	}

	public void setOrder(GoodsOrder order) {
		this.order = order;
	}

	@OneToOne
	@JoinColumn(name="menu_id")
	public StoreMenu getMenu() {
		return menu;
	}

	public void setMenu(StoreMenu menu) {
		this.menu = menu;
	}

	public int getCount() {
		return count;
	}

	public void setCount(int count) {
		this.count = count;
	}
}
