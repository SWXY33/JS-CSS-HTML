package com.guet.listener;

import java.util.Collection;
import java.util.HashMap;
import java.util.Map;

import javax.servlet.http.HttpSession;

import org.directwebremoting.ScriptSession;
import org.directwebremoting.event.ScriptSessionEvent;
import org.directwebremoting.event.ScriptSessionListener;

import com.guet.entities.SystemUser;

import uk.ltd.getahead.dwr.WebContext;
import uk.ltd.getahead.dwr.WebContextFactory;

public class DWRScriptSessionListener implements ScriptSessionListener {

	// 维护一个Map key为session的Id， value为ScriptSession对象
	public static final Map<String, ScriptSession> scriptSessionMap = new HashMap<String, ScriptSession>();

	/**
	 * ScriptSession创建事件
	 */
	public void sessionCreated(ScriptSessionEvent event) {
		WebContext webContext = WebContextFactory.get();
		HttpSession session = webContext.getSession();
		ScriptSession scriptSession = event.getSession();
		scriptSessionMap.put(session.getId(), scriptSession); // 添加scriptSession
//		System.out.println("session: " + session.getId() + " scriptSession: "
//				+ scriptSession.getId() + "is created!");
	}

	/**
	 * ScriptSession销毁事件
	 */
	public void sessionDestroyed(ScriptSessionEvent event) {
		WebContext webContext = WebContextFactory.get();
		HttpSession session = webContext.getSession();
		ScriptSession scriptSession = scriptSessionMap.remove(session.getId()); // 移除scriptSession
//		System.out.println("session: " + session.getId() + " scriptSession: "
//				+ scriptSession.getId() + "is destroyed!");
	}

	/**
	 * 获取所有ScriptSession
	 */
	public static Collection<ScriptSession> getScriptSessions() {
		return scriptSessionMap.values();
	}
}