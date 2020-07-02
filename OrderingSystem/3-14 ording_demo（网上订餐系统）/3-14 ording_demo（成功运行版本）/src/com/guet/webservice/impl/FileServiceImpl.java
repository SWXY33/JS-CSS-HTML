package com.guet.webservice.impl;

import java.util.ArrayList;
import java.util.List;

import org.hibernate.HibernateException;
import org.hibernate.Session;
import org.hibernate.Transaction;
import org.springframework.transaction.annotation.Transactional;

import com.guet.constants.Constant;
import com.guet.entities.SystemFile;
import com.guet.page.PageVO;
import com.guet.webservice.DBPersistenceImpl;
import com.guet.webservice.IFileService;

@Transactional(readOnly = false)
public class FileServiceImpl extends DBPersistenceImpl implements IFileService {

	@Override
	public boolean saveSystemFiles(List<SystemFile> files) {
		if(files == null || files.size() <= 0)return false;
		
		Session session = getSession().getSessionFactory().openSession();
		
		//事务
		Transaction tx = session.beginTransaction();
		
		boolean flag = false;
		try {
			for (SystemFile file : files) {
				session.save(file);
			}
			
			//提交事务
			tx.commit();
			flag = true;
		} catch (Exception e) {
			try {
				//回滚
				tx.rollback();
			} catch (HibernateException e2) {}
			e.printStackTrace();
			flag = false;
		} finally {
			try {
				if(session != null)session.close();
			} catch (Exception e2) {
			}
		}
		return flag;
	}

	@Override
	public boolean deleteSystemFiles(String[] ids) {
		return deleteByIds_db_status(ids, "sys_files");
	}

	@Override
	public List<SystemFile> findInvalidImages() {
		String columns = " file.id,file.file_name,file.file_type,"
				+ "date_format(file.upload_time,'%Y-%m-%d %H:%i:%s'),"
				+ "file.base_path,file.relative_path,file.db_status ";
		StringBuffer from = new StringBuffer();
		from.append(" sys_files file");
		StringBuffer where = new StringBuffer(" where 1=1 and file.db_status >= " + Constant.DB_STATUS_0);
		where.append(" and file.id not in (");
		where.append(" select usr.photo_id from sys_users usr where usr.photo_id != '' ");
		where.append(" and usr.photo_id is not null )");
		String order = "";
		PageVO<SystemFile> page = new PageVO<SystemFile>(0, 1000);
		List<Object[]> lg = findBySQLPage(columns, from.toString(),
				where.toString(), order, null, page);
		if (lg != null && lg.size() > 0) {
			List<SystemFile> list = new ArrayList<SystemFile>();
			SystemFile file = null;
			for (Object[] obj : lg) {
				file = new SystemFile();
				file.setId(toStringFromObj(obj[0]));
				file.setFileName(toStringFromObj(obj[1]));
				file.setFileType(toStringFromObj(obj[2]));
				file.setUploadTime(toTimestamp(obj[3]));
				file.setBasePath(toStringFromObj(obj[4]));
				file.setRelativePath(toStringFromObj(obj[5]));
				file.setDbStatus(toint(obj[6]));
				list.add(file);
			}
			return list;
		}
		return null;
	}

}
