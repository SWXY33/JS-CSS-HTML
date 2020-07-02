package com.guet.utils;

import java.io.InputStream;
import java.util.Properties;

/**
 * @author H 系统设置读取
 */
public class SysConfigUtil {

	// 根据key读取value
	public static String readPoperties(String key) {
		Properties props = new Properties();
		try {
			InputStream in = SysConfigUtil.class.getResourceAsStream("/serverconfig.properties");
			props.load(in);
			String value = props.getProperty(key);
			return value;
		} catch (Exception e) {
			e.printStackTrace();
			return null;
		}
	}
}
