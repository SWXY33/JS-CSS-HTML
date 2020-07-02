package com.guet;

import java.util.List;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;

/**
 * 
 * @author
 */
@WebService
public interface IDBPersistence {
	
	/**
	 * 查询数据，高级查询接口，必须熟悉实体才好使用。
	 * 
	 * @param object
	 * @param hql where子句，如 'entity.id =?'
	 * @return
	 */
	@WebMethod
	List<Object> findObjectByHQL(@WebParam(name = "object") Object object,@WebParam(name = "hql") String hql);
	
	/**
	 * 保存数据
	 * 
	 * @param object
	 * @return
	 */
	@WebMethod
	boolean saveObject(@WebParam(name = "object") Object object);

	/**
	 * 更新数据
	 * 
	 * @param object
	 * @return
	 */
	@WebMethod
	boolean updateObject(@WebParam(name = "object") Object object);

	/**
	 * 删除数据
	 * 
	 * @param object 删除对象
	 * @param isdelete 是否物理删除，true；false 只改变数据状态为 -1
	 * @return
	 */
	@WebMethod
	boolean deleteObject(@WebParam(name = "object") Object object,@WebParam(name = "isdelete") boolean isdelete);
	
	/**
	 * 执行删除
	 * @param sql
	 * @return
	 */
	@WebMethod
	public boolean delBySQL(
			@WebParam(name = "sql") String sql);
	
	/**
	 * 获取实体
	 * @param <T>
	 * @param clazz 
	 * @param id
	 * @return 返回实体
	 */
	@WebMethod
	public <T extends Entity> T get(
			@WebParam(name = "clazz") Class<? extends Entity> clazz, 
			@WebParam(name = "id") String id);
	
	/**
	 * sql语句查询前xxx条数据记录
	 * 
	 * @param columns
	 *            要查询的数据项
	 * @param fromAndWhere
	 *            表+条件
	 * @param orderby
	 *            排序方式
	 * @param params
	 *            参数
	 * @param top
	 *            返回x条，如果x>总数 返回总数条
	 * @return 结果集
	 */
	@SuppressWarnings("rawtypes")
	@WebMethod
	public List findBySQLTop(@WebParam(name = "columns") String columns,
			@WebParam(name = "fromAndWhere") String fromAndWhere,
			@WebParam(name = "orderby") String orderby,
			@WebParam(name = "params") Object[] params,
			@WebParam(name = "page") int top);

}
