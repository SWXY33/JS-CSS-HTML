package com.guet.utils;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.security.MessageDigest;
import java.util.ArrayList;
import java.util.List;

public class MessageUtil {

	private static final String _uc = "5191";
	private static final String _pwd = "SZ1598"; // 帐号，密码
	private static final String _host = "http://kltx.sms10000.com.cn/sdk/SMS?";

	public static String get_pwd() {
		return MD5Encode(_pwd);
	}

	/**
	 * 发送短信
	 * 
	 * @param mobiles
	 *            String 接收号码
	 * @param cont
	 *            String 短信内容
	 * @param msgid
	 *            String 短信ID
	 * @return String
	 */
	public static String sendSMS(String mobiles, String cont, String msgid) {
		String re = "";
		try {
			cont = URLEncoder.encode(cont, "GBK"); // 短信内容需要编码
			String sendUrl = _host + "cmd=send&uid=" + _uc + "&psw=" + get_pwd() + "&mobiles=" + mobiles
					+ "&msgid=" + msgid + "&msg=" + cont + " ";
			re = submit(sendUrl);
		} catch (Exception ex) {
		}
		return re;
	}

	/**
	 * 接收短信
	 * 
	 * @return String
	 */
	public static String getMO() {
		String re = "";
		try {
			String moUrl = _host + "cmd=getmo&uid=" + _uc + "&psw=" + get_pwd() + "";
			re = submit(moUrl);
		} catch (Exception ex) {
		}
		return re;
	}

	/**
	 * 取发送状态
	 * 
	 * @return String
	 */
	public static String getStatus() {
		String re = "";
		String getstatusUrl = _host + "cmd=getstatus&uid=" + _uc + "&psw=" + get_pwd() + "";
		re = submit(getstatusUrl);
		return re;
	}

	/**
	 * GET提交
	 * 
	 * @param url
	 *            String
	 * @return String
	 */
	private static String submit(String urls) {
		String re = "";

		HttpURLConnection urlConn = null;
		InputStream in = null;
		List<String> list = new ArrayList<String>();
		try {
			URL url = new URL(urls);
			urlConn = (HttpURLConnection) url.openConnection();
			urlConn.setDoOutput(true);
			urlConn.setConnectTimeout(3000);
			urlConn.setRequestMethod("GET");
			urlConn.getOutputStream().flush();
			urlConn.getOutputStream().close();
			in = urlConn.getInputStream();
			BufferedReader rd = new BufferedReader(new InputStreamReader(in, "GBK"));
			String line = rd.readLine();

			while (line != null) {
				line = line.trim();
				if (!line.equals(""))
					list.add(line);
				line = rd.readLine();
			}

		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			if (in != null)
				try {
					in.close();
				} catch (IOException e) {
				}

			if (urlConn != null) {
				urlConn.disconnect();
			}
		}

		if (list != null) {
			if (list.size() == 1) {
				re += list.get(0);
			} else if (list.size() > 1) {
				for (int i = 0; i < list.size(); i++) {
					re += list.get(i);
				}
			}
		}

		return re.trim();
	}

	/**
	 * MD5加密
	 * 
	 * @param origin
	 * @return
	 */
	private static String MD5Encode(String origin) {
		String resultString = null;
		try {
			resultString = new String(origin);
			MessageDigest md = MessageDigest.getInstance("MD5");
			resultString = byteArrayToHexString(md.digest(resultString.getBytes()));
		} catch (Exception ex) {

		}
		return resultString;
	}

	private static String byteToHexString(byte b) {
		int n = b;
		if (n < 0) {
			n = 256 + n;
		}
		int d1 = n / 16;
		int d2 = n % 16;
		return hexDigits[d1] + hexDigits[d2];
	}

	public static String byteArrayToHexString(byte[] b) {
		StringBuffer resultSb = new StringBuffer();
		for (int i = 0; i < b.length; i++) {
			resultSb.append(byteToHexString(b[i]));
		}
		return resultSb.toString();
	}

	private final static String[] hexDigits = { "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d",
			"e", "f" };
	
	public static void main(String[] args) {
		//String s = new MessageUtil().sendSMS("185-7668-4471", "亲，您的外卖已送到^O^", "6");
		String cont = "【莉莉外卖】175649（动态登录验证码）。工作人员不会向您索要，请勿向任何人泄露。";
		String s = MessageUtil.sendSMS("15607732513", cont, "6");
		System.out.println(s);
	}

}
