package com.guet.webservice.impl;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;

import org.hibernate.Session;
import org.hibernate.Transaction;
import org.springframework.transaction.annotation.Transactional;

import com.guet.entities.PhoneAndCode;
import com.guet.webservice.DBPersistenceImpl;
import com.guet.webservice.IVerifyCodeSevice;

@Transactional(readOnly = false)
public class VerifyCodeSeviceImpl extends DBPersistenceImpl implements IVerifyCodeSevice {

	@SuppressWarnings("deprecation")
	@Override
	public boolean saveOrUpdate(PhoneAndCode entity) {
		if(entity == null)return false;
		boolean flag = false;
		Session session = getSession().getSessionFactory().openSession();
		Transaction tx = session.beginTransaction();
		Connection con = session.connection();
		PreparedStatement p = null;
		String sql = "replace into phone_and_code(phone,verify_code,create_time) values(?,?,?)";
		try {
			p = con.prepareStatement(sql);
			p.setString(1, entity.getPhone());
			p.setString(2, entity.getVerifyCode());
			p.setTimestamp(3, entity.getCreateTime());
			p.executeUpdate();
			tx.commit();
			p.close();
			flag = true;
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			if (con != null) {
				try {
					con.close();
				} catch (SQLException e) {
				}
			}
			if (session != null) {
				session.close();
			}
		}
		return flag;
	}

	@Override
	public PhoneAndCode findByPhone(String phone) {
		String columns = " pc.phone,pc.verify_code,date_format(pc.create_time,'%Y-%m-%d %H:%i:%s')";
		String from = " phone_and_code pc";
		String where = " where pc.phone = ?";
		Object[] obj = (Object[]) findBySQLUnique(columns, from, where,
				new String[] { phone });
		if (obj != null) {
			PhoneAndCode pc = new PhoneAndCode();
			pc.setPhone(toStringFromObj(obj[0]));
			pc.setVerifyCode(toStringFromObj(obj[1]));
			pc.setCreateTime(toTimestamp(obj[2]));
			return pc;
		}
		return null;
	}

	@Override
	public boolean deleteByPhone(String phone) {
		boolean flag = false;
		try {
			String sql = "delete from phone_and_code where phone='" + phone + "'";
			delBySQL(sql);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return flag;
	}

}
