package com.guet;

import java.util.ArrayList;
import java.util.List;

import javax.servlet.ServletContext;
import javax.servlet.http.HttpSession;
import javax.servlet.http.HttpSessionBindingEvent;
import javax.servlet.http.HttpSessionBindingListener;

import com.guet.entities.SystemUser;

/**
 * @author X
 * 在线用户监听
 */
public class OnlineUserBindingListener implements HttpSessionBindingListener {

	SystemUser user;

	public OnlineUserBindingListener(SystemUser user) {
		this.user = user;
	}

	@SuppressWarnings("unchecked")
	@Override
	public void valueBound(HttpSessionBindingEvent event) {
		HttpSession session = event.getSession();
		ServletContext application = session.getServletContext();
		//把用户放入在线列表
		List<SystemUser> onlineUserList = (List<SystemUser>) application.getAttribute("onlineUserList");
		// 第一次使用前，需要初始化
		if (onlineUserList == null) {
			onlineUserList = new ArrayList<SystemUser>();
			application.setAttribute("onlineUserList", onlineUserList);
		}
		onlineUserList.add(user);
		String name = this.user.getLoginName();
		if(name == null){
			name = this.user.getTel();
		}
		System.out.println(name + "登录。");
	}

	@SuppressWarnings("unchecked")
	@Override
	public void valueUnbound(HttpSessionBindingEvent event) {
		HttpSession session = event.getSession();
		ServletContext application = session.getServletContext();

		// 从在线列表中删除用户
		List<SystemUser> onlineUserList = (List<SystemUser>) application.getAttribute("onlineUserList");
		if (onlineUserList != null) {
			onlineUserList.remove(this.user);
		}
		System.out.println(this.user.getLoginName() + "退出。");
	}
}
