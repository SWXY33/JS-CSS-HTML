package com.guet.entities;

import java.sql.Timestamp;
import java.util.List;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.OneToOne;
import javax.persistence.Table;
import javax.persistence.Transient;
import javax.xml.bind.annotation.adapters.XmlJavaTypeAdapter;

import org.hibernate.annotations.GenericGenerator;

import com.guet.spring.TimestampAdapter;

/**
 * 订单
 * @author lili
 *
 */
@Entity
@Table(name = "goods_order")
public class GoodsOrder extends com.guet.Entity {

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
	 * 消费者
	 */
	private SystemUser consumer;
	
	/**
	 * 收货地址
	 */
	private ReceiptAddress address;
	
	/**
	 * 店铺
	 */
	private Store store;
	
	/**
	 * 菜单
	 */
	private List<OrderMenu> menus;
	
	/**
	 * 给商家的留言
	 */
	private String guestBook;
	
	/**
	 * 总价
	 */
	private double totalPrice;
	
	/**
	 * 付款方式 0:货到付款 1:在线支付
	 */
	private int paymentMethod;
	
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
	@JoinColumn(name = "consumer_id")
	public SystemUser getConsumer() {
		return consumer;
	}

	public void setConsumer(SystemUser consumer) {
		this.consumer = consumer;
	}

	@OneToOne
	@JoinColumn(name = "address_id")
	public ReceiptAddress getAddress() {
		return address;
	}

	public void setAddress(ReceiptAddress address) {
		this.address = address;
	}

	@ManyToOne
	@JoinColumn(name = "store_id")
	public Store getStore() {
		return store;
	}

	public void setStore(Store store) {
		this.store = store;
	}

	@Transient
	public List<OrderMenu> getMenus() {
		return menus;
	}

	public void setMenus(List<OrderMenu> menus) {
		this.menus = menus;
	}
	
	public String getGuestBook() {
		return guestBook;
	}

	public void setGuestBook(String guestBook) {
		this.guestBook = guestBook;
	}

	public double getTotalPrice() {
		return totalPrice;
	}

	public void setTotalPrice(double totalPrice) {
		this.totalPrice = totalPrice;
	}

	public int getPaymentMethod() {
		return paymentMethod;
	}

	public void setPaymentMethod(int paymentMethod) {
		this.paymentMethod = paymentMethod;
	}
}
