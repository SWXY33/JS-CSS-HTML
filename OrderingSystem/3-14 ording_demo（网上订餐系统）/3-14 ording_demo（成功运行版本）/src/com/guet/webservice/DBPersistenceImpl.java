package com.guet.webservice;

import java.lang.reflect.Field;
import java.math.BigDecimal;
import java.math.BigInteger;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.util.Collections;
import java.util.List;

import javax.annotation.Resource;

import org.hibernate.Query;
import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.transaction.annotation.Propagation;
import org.springframework.transaction.annotation.Transactional;

import com.guet.Entity;
import com.guet.IDBPersistence;
import com.guet.constants.Constant;
import com.guet.page.PageInfo;
import com.guet.page.StdPageInfo;
import com.guet.utils.StringUtils;
import com.guet.utils.TimeUtil;

/**
 * @author H
 * 数据库操作
 */
@Transactional(readOnly = false)
public class DBPersistenceImpl implements IDBPersistence {
	public static final Logger logger = LoggerFactory
			.getLogger(DBPersistenceImpl.class);
	@Resource(name="resJdbcTemplate")
	protected JdbcTemplate jdbc;
	@Autowired(required = true)
	private SessionFactory sessionFactory;

	protected Session getSession() {
		return sessionFactory.getCurrentSession();
	}

	@Override
	@SuppressWarnings("unchecked")
	@Transactional(propagation = Propagation.SUPPORTS)
	public List<Object> findObjectByHQL(Object object, String hql) {
		return getSession().createQuery(
				"FROM " + object.getClass().getName() + " AS entity WHERE "
						+ hql).list();
	}

	@Override
	@Transactional(propagation = Propagation.SUPPORTS)
	public boolean saveObject(Object object) {
		try {
			getSession().save(object);
			getSession().flush();
		} catch (Exception e) {
			e.printStackTrace();
			logger.debug(e.toString());
			return false;
		}
		return true;
	}

	@Override
	@Transactional(propagation = Propagation.SUPPORTS)
	public boolean updateObject(Object object) {
		try {
			getSession().update(object);
			getSession().flush();
			return true;
		} catch (Exception e) {
			e.printStackTrace();
			logger.debug(e.toString());
			return false;
		}
	}
	
	/**
	  * 根据条件更新部分字段
	  * @param table  对象名称
	  * @param colums  更新的列
	  * @param where   条件
	  * @param params
	  * @return
	  */
		public boolean updateSomethingByHQL(String table,String colums, String where,
				Object[] params) {
			boolean flag = false;
			Session session = getSession();
			try{
				String hql = " update " +table +" set " +colums +" where " + where;	
				Query q = session.createQuery(hql);		
				if (params != null) {
					for (int i = 0; i < params.length; i++) {
						q.setParameter(i, params[i]);
					}
				}
				int ret = q.executeUpdate();		
				if(ret>0){
					flag = true;
				}
			}catch(Exception e){
				e.printStackTrace();
			}
			
			return flag;
		}
		
		/**
		 * 根据条件更新部分字段
		 * @param table  对象名称
		 * @param colums  更新的列
		 * @param where   条件
		 * @param params
		 * @return
		 */
		public boolean updateSomethingBySQL(String table,String colums, String where,
				Object[] params) {
			boolean flag = false;
			Session session = getSession();
			try{
				String sql = " update " +table +" set " +colums +" where " + where;	
				Query q = session.createSQLQuery(sql);		
				if (params != null) {
					for (int i = 0; i < params.length; i++) {
						q.setParameter(i, params[i]);
					}
				}
				
				int ret = q.executeUpdate();		
				if(ret>0){
					flag = true;
				}
			}catch(Exception e){
				e.printStackTrace();
			}
			
			return flag;
		}



	@Override
	@Transactional(propagation = Propagation.SUPPORTS)
	public boolean deleteObject(Object object, boolean isdelete) {
		try {
			if (isdelete) {
				getSession().delete(object);
			} else {
				Field fd = object.getClass().getDeclaredField("db_status");
				fd.setAccessible(true);
				fd.set(object, -1);
				getSession().update(object);
			}
			getSession().flush();
			return true;
		} catch (Exception e) {
			return false;
		}
	};

	@SuppressWarnings("unchecked")
	public <T extends Entity> T get(Class<? extends Entity> clazz, String id) {
		if (clazz != null && !StringUtils.isInvalid(id)) {
			return (T) getSession().get(clazz, id);
		}
		return null;
	}
	
	/**
	 * 分页条件查询--sql语句分页查询
	 * 
	 * @param columns
	 *            所要查询的指定数据项
	 * @param from
	 *            查询表
	 * @param where
	 *            筛选条件
	 * @param orderby
	 *            排序方式
	 * @param params
	 *            查询参数
	 * @param pageInfo
	 *            分页实体
	 * @return list数据集合
	 */
	@SuppressWarnings("unchecked")
	public List<Object[]> findBySQLPage(String columns, String from,String where,
			String orderby, Object[] params, StdPageInfo pageInfo) {
		// 总页数查询 拼接成 [select count(*) from xxxx where xxx and xxx] 排序方式不加入此语句中
		StringBuilder sb = new StringBuilder();
		sb.append(from).append(where);
		Session session = getSession();
		Query query = session.createSQLQuery("select count(1) from "
				+ from + where);
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		
		Number p = (Number) query.uniqueResult();// 获取总页数
		pageInfo.setTotalRow(p != null ? p.intValue() : 0);// 设置总页数
		if (p == null) {
			return Collections.EMPTY_LIST;// 如果没有获取页数信息返回空的集合
		}
		// 加上排序条件
		if (!StringUtils.isInvalid(orderby)) {
			sb.append(" " + orderby);
		}
		query = session.createSQLQuery("select " + columns + " from "
				+ sb.toString());
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		return query.setFirstResult(pageInfo.getStart()).setMaxResults(pageInfo.getPageSize()).list();
	}

	/**
	 * 分页条件查询--sql语句分页查询
	 * 
	 * @param columns
	 *            所要查询的指定数据项
	 * @param from
	 *            查询表
	 * @param where
	 *            筛选条件
	 * @param orderby
	 *            排序方式
	 * @param params
	 *            查询参数
	 * @param pageInfo
	 *            分页实体
	 * @return list数据集合
	 */
	@SuppressWarnings("unchecked")
	public List<Object[]> findBySQLPage2(String columns, String from,String where,
			String orderby, Object[] params, StdPageInfo pageInfo) {
		// 总页数查询 拼接成 [select count(*) from xxxx where xxx and xxx] 排序方式不加入此语句中
		StringBuilder sb = new StringBuilder();
		sb.append(from).append(where);
		Session session = getSession();
		Query query = session.createSQLQuery("select count(1) from  (select "+columns+"  from"
				+ from + where+") as a");
		
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		Number p = (Number) query.uniqueResult();// 获取总页数
		pageInfo.setTotalRow(p != null ? p.intValue() : 0);// 设置总页数
		if (p == null) {
			return Collections.EMPTY_LIST;// 如果没有获取页数信息返回空的集合
		}
		// 加上排序条件
		if (!StringUtils.isInvalid(orderby)) {
			sb.append(" " + orderby);
		}
		query = session.createSQLQuery("select " + columns + " from "
				+ sb.toString());
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		return query.setFirstResult(pageInfo.getStart()).setMaxResults(pageInfo.getPageSize()).list();
	}

	
	/**
	 * 当table为多表连接，并分组时用到
	 * 分页条件查询--sql语句分页查询
	 * 
	 * @param columns
	 *            所要查询的指定数据项
	 * @param from
	 *            查询表
	 * @param where
	 *            筛选条件
	 * @param orderby
	 *            排序方式
	 * @param params
	 *            查询参数
	 * @param pageInfo
	 *            分页实体
	 * @return list数据集合
	 */
	@SuppressWarnings("unchecked")
	public List<Object[]> findBySQLPage1(String columns, String from,String where,
			String orderby, Object[] params, StdPageInfo pageInfo) {
		// 总页数查询 拼接成 [select count(*) from xxxx where xxx and xxx] 排序方式不加入此语句中
		StringBuilder sb = new StringBuilder();
		sb.append(from).append(where);
		Session session = getSession();
		Query query = session.createSQLQuery("select count(1) from  (select *  from"
				+ from + where+")");
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		Number p = (Number) query.uniqueResult();// 获取总页数
		pageInfo.setTotalRow(p != null ? p.intValue() : 0);// 设置总页数
		if (p == null) {
			return Collections.EMPTY_LIST;// 如果没有获取页数信息返回空的集合
		}
		// 加上排序条件
		if (!StringUtils.isInvalid(orderby)) {
			sb.append(" " + orderby);
		}
		query = session.createSQLQuery("select " + columns + " from "
				+ sb.toString());
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		return query.setFirstResult(pageInfo.getStart()).setMaxResults(pageInfo.getPageSize()).list();
	}
	
	/**
	 * 分页条件查询--hql分页查询
	 * 
	 * @param clazz
	 *            所要查询的实体对象
	 * @param where
	 *            查询筛选条件
	 * @param parames
	 *            查询参数
	 * @param orderby
	 *            排序方式
	 * @param pageInfo
	 *            分页实体
	 * @return list 数据集合
	 */
	@SuppressWarnings("unchecked")
	public List<Object[]> findByHQLPage(Class<?> clazz, String where,
			Object[] parames, String orderby, StdPageInfo pageInfo) {
		Session session = getSession();
		// 拼接count语句
		String hql = "select count(1) from " + clazz.getName();
		if (where != null && !StringUtils.isInvalid(where)) {
			hql = hql + " where " + where;
		}
		Query query = session.createQuery(hql);
		if (parames != null) {
			for (int i = 0; i < parames.length; i++) {
				query.setParameter(i, parames[i]);
			}
		}
		pageInfo.setTotalRow(((Number) query.uniqueResult()).intValue());// 获取总页数
		hql = "FROM " + clazz.getName() + " AS entity ";
		if (where != null && !StringUtils.isInvalid(where)) {
			hql = hql + " where " + where;
		}
		if (orderby != null && !StringUtils.isInvalid(orderby)) {
			hql = hql + " " + orderby;
		}
		query = session.createQuery(hql);
		if (parames != null) {
			for (int i = 0; i < parames.length; i++) {
				query.setParameter(i, parames[i]);
			}
		}
		return query.setFirstResult(pageInfo.getStart()).setMaxResults(pageInfo.getPageSize()).list();
	}

	/**
	 * hql查询唯一数据记录 eg:一个实体的code=""
	 * 
	 * @param str
	 *            eg:from xxx where code=""
	 * @param parames
	 * @return
	 */
	public Object findByHQLUnique(String str, Object[] parames) {
		Query query = getSession().createQuery(str);
		if (parames != null)
			for (int i = 0; i < parames.length; ++i)
				query.setParameter(i, parames[i]);
		return query.uniqueResult();
	}

	/**
	 * hql查询所有数据记录 eg:一个实体的code=""
	 * 
	 * @param str
	 *            eg:from xxx where code=""
	 * @param parames
	 * @return
	 */
	@SuppressWarnings("unchecked")
	public List findByHQLAll(String str, Object[] parames) {
		Query query = getSession().createQuery(str);
		if (parames != null)
			for (int i = 0; i < parames.length; ++i)
				query.setParameter(i, parames[i]);
		return query.list();
	}
	
	@SuppressWarnings("unchecked")
	public List findBySQL(String sql) {
		Session session = getSession();
		Query query = session.createSQLQuery(sql);
		return query.list();
	}
	
	/**
	 * hql查询list列表
	 * 
	 * @param clazz
	 *            所要查询的实体对象
	 * @param where
	 *            查询筛选条件
	 * @param parames
	 *            查询参数
	 * @param orderby
	 *            排序方式
	 * @param start
	 *            开始查询记录数
	 * @param pageSize 记录条数
	 * @return list 数据集合
	 */
	@SuppressWarnings("unchecked")
	public List findByHQLList(Class<?> clazz, String where,
			Object[] parames, String orderby, int start,int pageSize) {
		Session session = getSession();
		Query query = null;
		// 拼接count语句
		String hql = "FROM " + clazz.getName() + " AS entity ";
		if (where != null && !StringUtils.isInvalid(where)) {
			hql = hql + " where " + where;
		}
		if (orderby != null && !StringUtils.isInvalid(orderby)) {
			hql = hql + " " + orderby;
		}
		query = session.createQuery(hql);
		if (parames != null) {
			for (int i = 0; i < parames.length; i++) {
				query.setParameter(i, parames[i]);
			}
		}
		return query.setFirstResult(start).setMaxResults(pageSize).list();
	}
	
	@SuppressWarnings("unchecked")
	public List<Object[]> findByHQLList(Class<?> clazz, String where,
			Object[] parames, String orderby) {
		Session session = getSession();
		Query query = null;
		// 拼接count语句
		String hql = "FROM " + clazz.getName() + " AS entity ";
		if (where != null && !StringUtils.isInvalid(where)) {
			hql = hql + " where " + where;
		}
		if (orderby != null && !StringUtils.isInvalid(orderby)) {
			hql = hql + " " + orderby;
		}
		query = session.createQuery(hql);
		if (parames != null) {
			for (int i = 0; i < parames.length; i++) {
				query.setParameter(i, parames[i]);
			}
		}
		return query.list();
	}

	/**
	 * sql语句查询唯一数据记录
	 * 
	 * @param columns
	 *            要查询的数据项
	 * @param from
	 *            表
	 * @param where
	 *            查询条件
	 * @param params
	 *            参数
	 * @return
	 */
	public Object findBySQLUnique(String columns, String from, String where,
			Object[] params) {
		
		StringBuilder sql = new StringBuilder();
		sql.append(from).append(where);
		Session session = getSession();
		Query query = session.createSQLQuery("select " + columns + " from "	+ sql.toString());
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		return query.uniqueResult();
	}

	/**
	 * sql语句查询所有数据记录
	 * 
	 * @param columns
	 *            要查询的数据项
	 * @param from
	 *            查询表
	 * @param where
	 *            筛选条件
	 * @param orderby
	 *            排序方式
	 * @param params
	 *            参数
	 * @return 结果集
	 */
	@SuppressWarnings("unchecked")
	public List findBySQLAll(String columns, String from, String where, String orderby,
			Object[] params) {
		StringBuffer sql = new StringBuffer();
		sql.append(from).append(where).append(orderby);
		Session session = getSession();
		
		Query query = session.createSQLQuery("select " + columns + " from "	+ sql.toString());
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		return query.list();
	}
	
	/**
	 * sql语句查询所有数据记录
	 * 
	 * @param columns
	 *            要查询的数据项
	 * @param from
	 *            查询表
	 * @param where
	 *            筛选条件
	 * @param orderby
	 *            排序方式
	 * @param params
	 *            参数
	 * @return 结果集
	 */
	@SuppressWarnings("unchecked")
	public List findBySQLAll(String sql,	Object[] params) {
		Session session = getSession();
		Query query = session.createSQLQuery(sql);
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		return query.list();
	}

	
	/**
	 * 修改表db_status状态为删除   应用维护
	 * @param ids
	 * @param table
	 * @return
	 */
	@SuppressWarnings("deprecation")
	public boolean deleteByIds_db_status(String[] ids,String table) {

		boolean result=true;
		Session session = getSession();
        Connection connection = session.connection();
        PreparedStatement cstmt =null;
        try{
        	connection.setAutoCommit(false);
            cstmt = connection.prepareStatement("update "+table+" set db_status=? where id=?") ;
      
			for(String id:ids){
				cstmt.setInt(1, Constant.DB_STATUS_);
				cstmt.setString(2, id.trim());
				cstmt.addBatch();
			}
			cstmt.executeBatch();
			connection.commit();
        }catch(Exception ex){
        	result=false;
        	try{
        	   connection.rollback();
        	}catch (Exception e) {
        		logger.error(e.toString());
			}
        	logger.error(ex.toString());
        }finally{
        	try{
        	   if(cstmt!=null){
        		   cstmt.close();
        	   }
        	   if(connection!=null){
        		   connection.close();
        	   }
        	   }catch(SQLException ex){
        		   logger.error(ex.toString());
        	   }
           }
		return result;
	}
	
	
	/**
	 * 物理删除
	 * @param ids ID数组
	 * @param table 表名
	 * @return
	 */
	@SuppressWarnings("deprecation")
	public boolean deleteAll(String[] ids,String table) {

		boolean result=true;
		Session session = getSession();
        Connection connection = session.connection();
        PreparedStatement cstmt =null;
        try{
        	connection.setAutoCommit(false);
            cstmt = connection.prepareStatement("DELETE FROM "+table+" where id=?") ;
      
			for(String id:ids){
				cstmt.setString(1, id.trim());
				cstmt.addBatch();
			}
			cstmt.executeBatch();
			connection.commit();
        }catch(Exception ex){
        	result=false;
        	try{
        	   connection.rollback();
        	}catch (Exception e) {
        		logger.error(e.toString());
			}
        	logger.error(ex.toString());
        }finally{
        	try{
        	   if(cstmt!=null){
        		   cstmt.close();
        	   }
        	   if(connection!=null){
        		   connection.close();
        	   }
        	   }catch(SQLException ex){
        		   logger.error(ex.toString());
        	   }
           }
		return result;
	}
	
	@Override
	public boolean delBySQL(String sql) {
		boolean result=true;
		Session session = getSession();
        Connection connection = session.connection();
        PreparedStatement cstmt =null;
        try{
        	connection.setAutoCommit(false);
            cstmt = connection.prepareStatement(sql) ;
            cstmt.execute();
			connection.commit();
        }catch(Exception ex){
        	result=false;
        	try{
        	   connection.rollback();
        	}catch (Exception e) {
        		logger.error(e.toString());
			}
        	logger.error(ex.toString());
        }finally{
        	try{
        	   if(cstmt!=null){
        		   cstmt.close();
        	   }
        	   if(connection!=null){
        		   connection.close();
        	   }
        	   }catch(SQLException ex){
        		   logger.error(ex.toString());
        	   }
           }
		return result;
	}
	
	/**
	 * 分页条件查询--sql语句分页查询
	 * 
	 * @param columns
	 *            所要查询的指定数据项
	 * @param fromAndWhere
	 * @param orderby
	 *            排序方式
	 * @param params
	 *            查询参数
	 * @param pageInfo
	 *            分页实体
	 * @return list数据集合
	 */
	@SuppressWarnings("unchecked")
	public List findBySQLPages(String columns, String fromAndWhere,
			String orderby, Object[] params, PageInfo pageInfo) {
		// 总页数查询 拼接成 [select count(*) from xxxx where xxx and xxx] 排序方式不加入此语句中
		StringBuilder sb = new StringBuilder();
		sb.append(fromAndWhere);
		Session session = getSession();
		Query query = session.createSQLQuery("select count(1) from "
				+ fromAndWhere);
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		Number p = (Number) query.uniqueResult();// 获取总页数
		pageInfo.setTotalRow(p != null ? p.intValue() : 0);// 设置总页数
		// 限定要显示的页数大于等于1 小于等于总页数
		int page = pageInfo.getPage();
		if (page > pageInfo.getTotalPage()) {
			page = pageInfo.getTotalPage();
		}
		if (page < 1) {
			page = 1;
		}
		pageInfo.setPage(page);// 更新计算后的当前页数
		if (p == null) {
			return Collections.EMPTY_LIST;// 如果没有获取页数信息返回空的集合
		}
		// 加上分页条件
		if (!StringUtils.isInvalid(orderby)) {
			sb.append(" " + orderby);
		}
		query = session.createSQLQuery("select " + columns + " from "
				+ sb.toString());
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		return query.setFirstResult((page - 1) * pageInfo.getPageSize())
				.setMaxResults(pageInfo.getPageSize()).list();
	}
	
	@SuppressWarnings("unchecked")
	@Override
	public List findBySQLTop(String columns, String fromAndWhere,
			String orderby, Object[] params, int top) {
		if (top <= 0) {
			return Collections.EMPTY_LIST;
		}
		// 总页数查询 拼接成 [select count(*) from xxxx where xxx and xxx] 排序方式不加入此语句中
		StringBuilder sb = new StringBuilder();
		sb.append(fromAndWhere);
		Session session = getSession();
		Query query = session.createSQLQuery("select count(1) from "
				+ sb.toString());
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		Number p = (Number) query.uniqueResult();// 获取总页数
		if (p == null) {
			return Collections.EMPTY_LIST;
		}
		if (top > p.intValue()) {
			top = p.intValue();
		}
		// 加上分页条件
		if (!StringUtils.isInvalid(orderby)) {
			sb.append(" " + orderby);
		}
		query = session.createSQLQuery("select " + columns + " from "
				+ sb.toString());
		if (params != null) {
			for (int i = 0; i < params.length; i++) {
				query.setParameter(i, params[i]);
			}
		}
		return query.setFirstResult(0).setMaxResults(top).list();
	}
	
	
	public List findByHQLOnPage(Class<?> clazz, String where, Object[] parames,
			String orderBy, StdPageInfo pageInfo) {
		Session session = getSession();
		// 拼接count语句
		String hql = "select count(*) from " + clazz.getName();
		if (where != null && !StringUtils.isInvalid(where)) {
			hql = hql + " where " + where;
		}
		Query query = session.createQuery(hql);
		if (parames != null) {
			for (int i = 0; i < parames.length; i++) {
				query.setParameter(i, parames[i]);
			}
		}

		pageInfo.setTotalRow(((Number) query.uniqueResult()).intValue());// 获取总页数
		int page = pageInfo.getPage();
		if (page > pageInfo.getTotalPage()) {
			page = pageInfo.getTotalPage();
		}
		if (page < 1) {
			page = 1;
		}
		pageInfo.setPage(page);// 设置分页信息
		hql = "FROM " + clazz.getName() + " AS entity ";
		if (where != null && !StringUtils.isInvalid(where)) {
			hql = hql + " where " + where;
		}
		if (orderBy != null && !StringUtils.isInvalid(orderBy)) {
			hql = hql + " " + orderBy;
		}
		query = session.createQuery(hql);
		if (parames != null) {
			for (int i = 0; i < parames.length; i++) {
				query.setParameter(i, parames[i]);
			}
		}
		return query.setFirstResult((page - 1) * pageInfo.getPageSize())
				.setMaxResults(pageInfo.getPageSize()).list();
	}
	
	public List findByHQLOnPage(Class<?> clazz,String columns,String where, Object[] parames,
			String orderBy, StdPageInfo pageInfo) {
		Session session = getSession();
		// 拼接count语句
		String hql = "select count(*) from " + clazz.getName();
		if (where != null && !StringUtils.isInvalid(where)) {
			hql = hql + " where " + where;
		}
		Query query = session.createQuery(hql);
		if (parames != null) {
			for (int i = 0; i < parames.length; i++) {
				query.setParameter(i, parames[i]);
			}
		}

		pageInfo.setTotalRow(((Number) query.uniqueResult()).intValue());// 获取总页数
		int page = pageInfo.getPage();
		if (page > pageInfo.getTotalPage()) {
			page = pageInfo.getTotalPage();
		}
		if (page < 1) {
			page = 1;
		}
		pageInfo.setPage(page);// 设置分页信息
		hql = "select "+columns+" FROM " + clazz.getName() + " AS entity ";
		if (where != null && !StringUtils.isInvalid(where)) {
			hql = hql + " where " + where;
		}
		if (orderBy != null && !StringUtils.isInvalid(orderBy)) {
			hql = hql + " " + orderBy;
		}
		query = session.createQuery(hql);
		if (parames != null) {
			for (int i = 0; i < parames.length; i++) {
				query.setParameter(i, parames[i]);
			}
		}
		return query.setFirstResult((page - 1) * pageInfo.getPageSize())
				.setMaxResults(pageInfo.getPageSize()).list();
	}
	
	
	
	protected int toint(Object obj) {
		if(obj instanceof Integer){
			return obj == null ? 0 : Integer.valueOf(obj.toString());
		}else if (obj instanceof BigDecimal){
			return obj == null ? 0 : ((BigDecimal) obj).intValue();
		}else if(obj instanceof BigInteger){
			return obj == null ? 0 : ((BigInteger) obj).intValue();
		}
		return 0;
	}

	protected Timestamp toTimestamp(Object obj) {
		return obj == null ? null : TimeUtil.parseTime(obj.toString());
	}
	
	protected double todouble(Object obj) {
		if(obj instanceof Double){
			return obj == null ? 0 : Double.valueOf(obj.toString());
		}else if (obj instanceof BigDecimal){
			return obj == null ? 0 : ((BigDecimal) obj).intValue();
		}
		return 0.0;
	}
	
	protected double objtodouble(Object obj) {
		if(obj instanceof Double){
			return obj == null ? 0 : Double.valueOf(obj.toString());
		}else if (obj instanceof BigDecimal){
			return obj == null ? 0 : ((BigDecimal) obj).doubleValue();
		}
		return 0.0;
	}
	
	protected boolean toboolean(Object obj) {
		if(obj instanceof Integer){
			return ((Integer) obj).intValue()==0?false:true;
		}else if (obj instanceof BigDecimal){
			return ((BigDecimal) obj).intValue()==0?false:true;
		}
		return false;
	}
	
	protected String toStringFromObj(Object obj){
		return obj != null ? obj.toString() : null;
	}
	
	/**
	 * 查询数据时候，查询对象转换成Timestamp
	 * @param obj 数据对象
	 * @return
	 */
	public Timestamp objToTimestamp(Object obj) {
		if(obj != null){
			if(obj instanceof Timestamp){
				return java.sql.Timestamp.valueOf(obj.toString());
			}else{
				return new Timestamp(java.sql.Date.valueOf(obj.toString()).getTime());
			}
		}else{
			return null;
		}
		
	}
}