package com.guet.utils;

import java.io.Serializable;

/**
 * 对框架提示框JSON数据封装
 * @author X
 *
 */
public class ResultJsonUtil  implements Serializable {
	private static final long serialVersionUID = 1L;
	/**
	 * 成功
	 */
	public static final String RESULT_OK = "ok";
	

	/**
	 * 失败
	 */
	public static final String RESULT_ERROR = "error";
	
	/**
	 * ok error
	 */
	private String info;
	/**
	 * 错误提示信息
	 */
	private String msg;
	
	private String result;
	
	public String getResult() {
		return result;
	}

	public void setResult(String result) {
		this.result = result;
	}

	public String getInfo() {
		return info;
	}

	public void setInfo(String info) {
		this.info = info;
	}

	public String getMsg() {
		return msg;
	}

	public void setMsg(String msg) {
		this.msg = msg;
	}
}
