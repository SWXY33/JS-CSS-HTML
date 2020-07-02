package com.guet.action;

import java.sql.Timestamp;
import java.util.List;
import java.util.Random;

import javax.servlet.http.HttpSession;

import org.apache.struts2.ServletActionContext;

import com.guet.entities.PhoneAndCode;
import com.guet.entities.SystemUser;
import com.guet.utils.MessageUtil;
import com.guet.utils.OutputHelper;
import com.guet.utils.SessionUserUtils;
import com.guet.utils.TimeUtil;
import com.guet.webservice.IUserService;
import com.guet.webservice.IVerifyCodeSevice;

public class LoginAction extends PageAction{
	private static final long serialVersionUID = 1L;

	private IUserService userService;
	
	private IVerifyCodeSevice verifyCodeSevice;
	
	private SystemUser user;
	
	/**
	 * 手机号码
	 */
	private String phone;
	/**
	 * 验证码
	 */
	private String code;
	
	public String login(){
		try {
			if(user == null || user.getLoginName() == null)return ERROR;
			SystemUser loginUser = userService.login(user.getLoginName());
			if(loginUser != null && loginUser.getLoginPwd().equals(user.getLoginPwd())){
				SessionUserUtils.setLoginUser(loginUser);
				user = null;
				return SUCCESS;
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return ERROR;
	}
	
	public String sendSms(){
		boolean flag = false;
		try {
			if(phone != null){
				Random rnd = new Random();
				int num = rnd.nextInt(899999) + 100000;
				PhoneAndCode entity = new PhoneAndCode();
				entity.setPhone(phone);
				entity.setVerifyCode(num + "");
				entity.setCreateTime(TimeUtil.now());
				verifyCodeSevice.saveOrUpdate(entity);
				String cont = "【莉莉外卖】" + num +
						"（动态登录验证码）。工作人员不会向您索要，请勿向任何人泄露。";
				MessageUtil.sendSMS(phone, cont, "6");
				flag = true;
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		OutputHelper.outPut("{\"success\":" + flag + "}");
		return null;
	}
	
	public String loginBySms(){
		boolean flag = false;
		String info = "";
		try {
			if(phone != null){
				PhoneAndCode pc = verifyCodeSevice.findByPhone(phone);
				if(pc != null && pc.getVerifyCode() != null
						&& pc.getCreateTime() != null){
					if(code.equals(pc.getVerifyCode())){
//						Timestamp tmp = TimeUtil.addseconds(pc.getCreateTime(), 300);//300秒过期
//						Timestamp tmp = TimeUtil.addFen(pc.getCreateTime(), 600);//600分钟过期
						Timestamp tmp = TimeUtil.addTian(pc.getCreateTime(), 30);//30天过期
						if(TimeUtil.beforeTime(TimeUtil.now(), tmp)){
							flag = true;
							SystemUser loginUser = userService.loginBusinessByPhone(phone);
							SessionUserUtils.setLoginUser(loginUser);
						} else {
							info = "验证码已过期";
						}
					} else {
						info = "验证码错误";
					}
				} else {
					info = "验证码错误";
				}
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		OutputHelper.outPut("{\"success\":" + flag + ",\"info\":\"" + info + "\"}");
		return null;
	}
	
	@SuppressWarnings("rawtypes")
	public String logout() {
		try {
			HttpSession session = ServletActionContext.getRequest().getSession();
			List onlineUserList = (List) session.getServletContext().getAttribute("onlineUserList");
			if (onlineUserList != null) {
				onlineUserList.remove(getSessionUser());
			}
		    //销毁session
			session.invalidate();
		} catch (Exception e) {
			e.printStackTrace();
		}
		return SUCCESS;
	}
	
	public String home(){
		return SUCCESS;
	}
	
	public void setUserService(IUserService userService) {
		this.userService = userService;
	}
	public void setVerifyCodeSevice(IVerifyCodeSevice verifyCodeSevice) {
		this.verifyCodeSevice = verifyCodeSevice;
	}

	public SystemUser getUser() {
		return user;
	}
	public void setUser(SystemUser user) {
		this.user = user;
	}

	public String getPhone() {
		return phone;
	}

	public void setPhone(String phone) {
		this.phone = phone;
	}

	public String getCode() {
		return code;
	}

	public void setCode(String code) {
		this.code = code;
	}
}
