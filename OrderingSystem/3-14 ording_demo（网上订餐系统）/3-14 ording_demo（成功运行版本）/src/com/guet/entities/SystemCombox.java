package com.guet.entities;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;

import org.hibernate.annotations.GenericGenerator;

/**
 * 下拉框
 * @author lili
 *
 */
@Entity
@Table(name = "sys_combox")
public class SystemCombox extends com.guet.Entity {

	private static final long serialVersionUID = -4518481452046918491L;
	
	/**
	 * id 唯一标识
	 */
	private String id;
	
	/**
	 * 父节点id,没有置空
	 */
	private String parentId;
	
	/**
	 * 下拉框文本
	 */
	private String text;
	
	/**
	 * 下拉框级数
	 */
	private int level;

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
	public String getParentId() {
		return parentId;
	}

	public void setParentId(String parentId) {
		this.parentId = parentId;
	}

	public String getText() {
		return text;
	}

	public void setText(String text) {
		this.text = text;
	}

	public int getLevel() {
		return level;
	}

	public void setLevel(int level) {
		this.level = level;
	}
}
