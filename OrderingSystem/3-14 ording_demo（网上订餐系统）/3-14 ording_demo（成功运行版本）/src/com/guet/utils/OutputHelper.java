package com.guet.utils;

import java.io.IOException;
import java.io.PrintStream;

import javax.servlet.http.HttpServletResponse;

import org.apache.struts2.ServletActionContext;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public abstract class OutputHelper {
	private static final Logger logger = LoggerFactory
			.getLogger(OutputHelper.class);

	/**
	 * 通过servletResponse输出数据
	 * 
	 * @param response
	 * @param content
	 */
	public static void outPut(String content) {
		if (StringUtils.isInvalid(content)) {
			return;
		}
		HttpServletResponse response=ServletActionContext.getResponse();
		response.reset();
		response.setContentType("application/x-json");
		response.setCharacterEncoding("utf-8");	//这句话并不能解决编码问题
		PrintStream out = null;
		try {
			out = new PrintStream(response.getOutputStream());
			out.write(content.getBytes("utf-8"));
		} catch (IOException e) {
			logger.error("输出数据失败");
		} finally {
			if (out != null) {
				out.close();
			}
		}
	}
	
	public static void outPutXml(String content) {
		if (StringUtils.isInvalid(content)) {
			return;
		}
		HttpServletResponse response=ServletActionContext.getResponse();
		response.reset();
		response.setContentType("text/xml;charset=UTF-8");
		PrintStream out = null;
		try {
			out = new PrintStream(response.getOutputStream());
			// 解决跨平台输出乱码问题
			out.write(content.getBytes("utf-8"));
		} catch (IOException e) {
			logger.error("输出数据失败");
		} finally {
			if (out != null) {
				out.close();
			}
		}
	}
	
	public static void outPutHtml(String content) {
		if (StringUtils.isInvalid(content)) {
			return;
		}
		HttpServletResponse response=ServletActionContext.getResponse();
		response.reset();
		response.setContentType("text/html;charset=UTF-8");
		PrintStream out = null;
		try {
			out = new PrintStream(response.getOutputStream());
			// 解决跨平台输出乱码问题
			out.write(content.getBytes("utf-8"));
		} catch (IOException e) {
			logger.error("输出数据失败");
		} finally {
			if (out != null) {
				out.close();
			}
		}
	}
}
