package com.guet.page;

import java.io.Serializable;
/**
 * 
 * @author X
 *
 */
public interface PageInfo extends Serializable {
	
	/**
	 * 获取页数
	 * @return
	 */
	public abstract int getPage();
	
	/**
	 * 获取起始数
	 * @return
	 */
	public abstract int getStart();

	/**
	 * 设置页数
	 * @param paramInt
	 */
	public abstract void setPage(int paramInt);

	/**
	 * 获取每页多少条
	 * @return
	 */
	public abstract int getPageSize();

	/**
	 * 设置每页多少条
	 * @param paramInt
	 */
	public abstract void setPageSize(int paramInt);

	/**
	 * 获取总行数
	 * @return
	 */
	public abstract int getTotalRow();

	/**
	 * 设置总行数
	 * @param paramInt
	 */
	public abstract void setTotalRow(int paramInt);

	/**
	 * 获取总页数
	 * @return
	 */
	public abstract int getTotalPage();
	
	/**
	 * 设置从多条开始
	 * @return
	 */
	public abstract void setStart(int start);

}
