package com.guet.page;

import java.io.Serializable;
import java.util.List;

public class PageVO<E> extends StdPageInfo implements Serializable, PageInfo {

	private static final long serialVersionUID = 5065217124087990451L;

	/**
	 * 数据集合
	 */
	private List<E> list;

	public PageVO(int start,int pageSize) {
		this.setPage(start);
		this.setStart(start);
		this.setPageSize(pageSize);
	}

	public PageVO() {
	}

	public List<E> getList() {
		return list;
	}

	public void setList(List<E> list) {
		this.list = list;
	}
}