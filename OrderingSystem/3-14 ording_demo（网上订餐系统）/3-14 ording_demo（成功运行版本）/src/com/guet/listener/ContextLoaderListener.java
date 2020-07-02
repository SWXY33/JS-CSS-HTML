package com.guet.listener;

import javax.servlet.ServletContextEvent;

import com.guet.utils.SysConfigUtil;

public class ContextLoaderListener extends org.springframework.web.context.ContextLoaderListener {
	@Override
	public void contextInitialized(ServletContextEvent event) {
		String path=event.getServletContext().getContextPath();
		System.out.println(path);
		String imgServer = SysConfigUtil.readPoperties("images_server");
		System.out.println(imgServer);
		event.getServletContext().setAttribute("basePath", path);
		event.getServletContext().setAttribute("images_server", imgServer);
		super.contextInitialized(event);
	}
}
