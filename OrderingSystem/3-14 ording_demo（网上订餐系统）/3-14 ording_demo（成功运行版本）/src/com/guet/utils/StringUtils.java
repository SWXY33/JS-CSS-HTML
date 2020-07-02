package com.guet.utils;

import java.io.BufferedReader;
import java.io.Reader;
import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.net.URLEncoder;
import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import org.hibernate.id.IdentifierGenerator;
import org.hibernate.id.UUIDHexGenerator;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * 字符串工具
 * 
 */
public abstract class StringUtils {

	private static final Logger logger = LoggerFactory
			.getLogger(StringUtils.class);

	private static final String DEF_CHARSET = "utf-8";

	private static DecimalFormat decimalFormat = new DecimalFormat();

	/**
	 * 判断字符串是否有效
	 * 
	 * @param s
	 * @return
	 */
	public static boolean isInvalid(String s) {
		return s == null || s.trim().length() == 0;
	}

	/**
	 * Translates a string into application/x-www-form-urlencoded format using a
	 * specific encoding scheme. This method uses the supplied encoding scheme
	 * to obtain the bytes for unsafe characters.
	 * 
	 * @param str
	 * @param charset
	 * @return
	 */
	public static String encode(String str, String charset) {
		String s = null;
		if (!isInvalid(str) && !isInvalid(charset)) {
			try {
				s = URLEncoder.encode(str, charset);
			} catch (UnsupportedEncodingException e) {
				logger.error("字符转码错误" + e.toString());
			}
		}
		return s;
	}
	
	public static String formatNumberFloat(Float value) {
		decimalFormat.applyPattern("0.00");
		return decimalFormat.format(value);
	}

	public static String encode(String str) {
		return encode(str, DEF_CHARSET);

	}

	/**
	 * Decodes a application/x-www-form-urlencoded string using a specific
	 * encoding scheme. The supplied encoding is used to determine what
	 * characters are represented by any consecutive sequences of the form
	 * "%xy".
	 * 
	 * @param str
	 * @param charset
	 * @return
	 */
	public static String decoder(String str, String charset) {
		String s = null;
		if (!isInvalid(str) && !isInvalid(charset)) {
			try {
				s = URLDecoder.decode(str, charset);
			} catch (UnsupportedEncodingException e) {
				logger.error("字符解码错误");
			}
		}
		return s;
	}

	public static String decoder(String str) {
		return decoder(str, DEF_CHARSET);
	}

	/**
	 * 去掉回车空格换行等制表符
	 * 
	 * @param str
	 * @return
	 */
	public static String replaceBlank(String str) {
		Pattern p = Pattern.compile("\\s*|\t|\r|\n");
		Matcher m = p.matcher(str);
		String after = m.replaceAll("");
		return after;
	}

	/**
	 * 空格替换为|
	 * 
	 * @param str
	 * @return
	 */
	public static String replace(String str) {
		Pattern p = Pattern.compile("\\s+");
		Matcher m = p.matcher(str);
		String after = m.replaceAll("|");
		return after;
	}

	/**
	 * 正则表达示匹配
	 * 
	 * @param pattern
	 * @param s
	 * @return
	 */
	public static Boolean regexMatcher(String pattern, String s) {
		Pattern p = Pattern.compile(pattern, Pattern.CASE_INSENSITIVE);
		Matcher matcher = p.matcher(s);
		return matcher.matches();
	}

	/**
	 * 格式化double数据
	 * 
	 * @param value
	 * @return
	 */
	public static String formatNumber(Double value) {
		decimalFormat.applyPattern("#.00");
		return decimalFormat.format(value);
	}

	/**
	 * .后的字串并转为小写
	 * 
	 * @param s
	 * @return
	 */
	public static String parseExt(String s) {
		if (s == null || s.indexOf(".") == -1)
			return "";
		return s.substring(s.lastIndexOf(".") + 1).trim().toLowerCase();
	}

	/**
	 * 长度化字符串
	 * 
	 * @param str
	 * @param length
	 * @param addDot
	 * @return
	 */
	public static String byteSubstring(String str, int length, boolean addDot) {

		if (str == null || str.trim().equals("") || length < 0)
			return "";
		str = str.trim();
		int counterOfDoubleByte = 0;
		byte[] b = str.getBytes();

		// 加3个点的长度
		if (addDot)
			length -= 3;

		if (b.length <= length)
			return str;

		for (int i = 0; i < length; i++) {
			if (b[i] < 0)
				counterOfDoubleByte++;
		}
		if (counterOfDoubleByte % 2 == 0)
			return addDot ? new String(b, 0, length) + "..." : new String(b, 0,
					length);
		else
			return addDot ? new String(b, 0, length - 1) + "..." : new String(
					b, 0, length - 1);

	}

	/**
	 * 如果是空格返回null
	 * 
	 * @param s
	 * @return
	 */
	public static String blankToNull(String s) {
		return !isInvalid(s) ? s : null;
	}

	/**
	 * 判断字符串是否合法日期
	 * @param s
	 * @param pattern 样式
	 * @return
	 */
	public static boolean isDate(String s, String pattern) {
		if (!isInvalid(s)) {
			if (isInvalid(pattern)) {
				pattern = "yyyy-MM-dd";
			}
			SimpleDateFormat sdf = new SimpleDateFormat(pattern);
			try {
				sdf.parse(s);
				return true;
			} catch (ParseException e) {
				logger.error("字符串" + s + "用" + pattern + "解析失败");
			}
		}
		return false;
	}

	/**
	 * 判断字符串是否是合法日期
	 * @param s
	 * @return
	 */
	public static boolean isDate(String s) {
		return isDate(s, null);
	}

	/**
	 * Lob转字符串
	 * @param obj
	 * @return
	 */
	public static String lobToStr(Object obj){
		if(obj == null)
			return "";
		
		StringBuffer sb = new StringBuffer();
		java.sql.Clob clob = (java.sql.Clob)obj;
		try {
			Reader is = clob.getCharacterStream();
			BufferedReader br = new BufferedReader(is);
			String str = br.readLine();
			while(str != null){
				sb.append(str);
				str = br.readLine();
			}
			br.close();
			is.close();
		} catch (Exception e) {
			e.printStackTrace();
		}
		return sb.toString();
	}
	
	public static int length(String str)
	{
		if(isInvalid(str))
			return 0;
		return str.getBytes().length;
	}
	
	
	public static String floatToStr(float value){
		DecimalFormat formate = new DecimalFormat("0.##");
		return formate.format(value);
	}
	
	public static String substring(String src, int start_idx, int end_idx){   
        byte[] b = src.getBytes();   
        String tgt = "";   
        for(int i=start_idx; i<=end_idx; i++){   
            tgt +=(char)b[i];   
        }   
        return tgt;   
    }  
	
	public static String genUUID(){
		IdentifierGenerator gen = new UUIDHexGenerator();
		return (String) gen.generate(null, null);
	}
	
	public static void main(String[] args) {
		System.out.println(genUUID());
	}
}
