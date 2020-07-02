package com.guet.page;
/**
 * 
 * @author X
 *
 */
public class StdPageInfo implements PageInfo {
	private static final long serialVersionUID = -4282331591657001007L;
	
	/**
	 * 页码
	 */
	private int page;

	/**
	 * 每页多少条
	 */
	private int pageSize;
	
	/**
	 * 总共多少条
	 */
	private int totalRow;
	
	
	private int start;
	
	public StdPageInfo() {
		super();
	}

	/**
	 * 构造函数---同时设定每页多少条--如果需动态设定条数增加接口方法即可
	 * @param perPageResult
	 */
	public StdPageInfo(int pageSize) {
		this.pageSize = pageSize;
	}

	public int getPage() {
		return this.page;
	}

	public void setPage(int page) {
		this.page = page;
	}

	public int getPageSize() {
		return this.pageSize;
	}

	public int getStart() {
		return start;
	}

	/**
	 * 如果对每页多少条进行修改了，则从新计算 page值
	 */
	public void setPageSize(int PageSize) {
		if (this.pageSize!=PageSize) {
			this.pageSize = PageSize;
			if (this.start!=0) {
				setStart(this.start);
			}
		}
	}

	public int getTotalRow() {
		return this.totalRow;
	}

	public void setTotalRow(int totalResult) {
		this.totalRow = totalResult;
	}

	public int getTotalPage() {
		if (this.totalRow % this.pageSize == 0) {
			return (this.totalRow / this.pageSize);
		}
		return (this.totalRow / this.pageSize + 1);
	}

	@Override
	public void setStart(int start) {
		/*if ((start>0)&&(pageSize>0)) {
			page=(int) (start/pageSize+Math.signum(((double)start%pageSize)));
		}*/
		this.start = start;
	}

}
