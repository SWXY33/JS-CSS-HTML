package com.guet.dwr;

import java.util.Collection;

import org.directwebremoting.Browser;
import org.directwebremoting.ScriptBuffer;
import org.directwebremoting.ScriptSession;
import org.directwebremoting.ScriptSessionFilter;

import uk.ltd.getahead.dwr.WebContextFactory;

import com.guet.listener.DWRScriptSessionListener;

public class DwrMessagePush {
	public void sendAll(final String content) {
		Runnable run = new Runnable() {
			private ScriptBuffer script = new ScriptBuffer();

			@Override
			public void run() {
				// 设置要调用的 js及参数
				script.appendCall("showOrderTip", content);
				// 得到所有ScriptSession
				Collection<ScriptSession> sessions = Browser
						.getTargetSessions();
				for (ScriptSession scriptSession : sessions) {
					scriptSession.addScript(script);
				}
			}
		};
		// 执行推送所有
		Browser.withAllSessions(run);
	}

	public void sendByCondition(final String content) {
		// 过滤器
		ScriptSessionFilter filter = new ScriptSessionFilter() {

			@Override
			public boolean match(ScriptSession scriptSession) {
				String tag = (String) scriptSession.getAttribute("tag");
				if (tag == null)
					return false;
				boolean flag = content.equals(tag);
				return flag;
			}

		};
		Runnable run = new Runnable() {
			private ScriptBuffer script = new ScriptBuffer();

			@Override
			public void run() {
				// 设置要调用的 js及参数
				script.appendCall("showOrderTip", content);
				// 得到所有ScriptSession
				Collection<ScriptSession> sessions = DWRScriptSessionListener
						.getScriptSessions();
				for (ScriptSession scriptSession : sessions) {
					scriptSession.addScript(script);
				}
			}
		};
		// 执行推送
		Browser.withAllSessionsFiltered(filter, run);// 调用了有filter功能的方法
	}

	/**
	 * 通知顾客商家已接单
	 */
	public void sendAceptOrderToClient(final String content) {
		// 过滤器
		ScriptSessionFilter filter = new ScriptSessionFilter() {

			@Override
			public boolean match(ScriptSession scriptSession) {
				String tag = (String) scriptSession.getAttribute("tag");
				if (tag == null)
					return false;
				boolean flag = content.equals(tag);
				return flag;
			}

		};
		Runnable run = new Runnable() {
			private ScriptBuffer script = new ScriptBuffer();

			@Override
			public void run() {
				// 设置要调用的 js及参数
				script.appendCall("businessAceptOrder", content);
				// 得到所有ScriptSession
				Collection<ScriptSession> sessions = DWRScriptSessionListener
						.getScriptSessions();
				for (ScriptSession scriptSession : sessions) {
					scriptSession.addScript(script);
				}
			}
		};
		// 执行推送
		Browser.withAllSessionsFiltered(filter, run);// 调用了有filter功能的方法
	}

	public void onPageLoad(final String tag) {
		// 获取当前的ScriptSession
		ScriptSession scriptSession = WebContextFactory.get()
				.getScriptSession();
		scriptSession.setAttribute("tag", tag);
	}
}
