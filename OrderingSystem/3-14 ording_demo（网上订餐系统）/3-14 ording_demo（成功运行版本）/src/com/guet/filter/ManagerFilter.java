package com.guet.filter;

import java.io.IOException;

import javax.servlet.Filter;
import javax.servlet.FilterChain;
import javax.servlet.FilterConfig;
import javax.servlet.ServletException;
import javax.servlet.ServletRequest;
import javax.servlet.ServletResponse;
import javax.servlet.http.HttpServletResponse;

import org.apache.struts2.ServletActionContext;

public class ManagerFilter implements Filter {

	public void doFilter(ServletRequest request, ServletResponse response,
			FilterChain chain) throws IOException, ServletException {
		HttpServletResponse resp = ServletActionContext.getResponse();
		resp.setHeader("Pragma","No-cache");
		resp.setHeader("Cache-Control","no-cache");
		resp.setDateHeader("Expires", 0);
		chain.doFilter(request, response);
	}

	public void init(FilterConfig arg0) throws ServletException {
	}

	public void destroy() {
	}

}
