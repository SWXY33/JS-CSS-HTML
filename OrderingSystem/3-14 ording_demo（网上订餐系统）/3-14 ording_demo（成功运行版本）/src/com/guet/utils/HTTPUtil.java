package com.guet.utils;

import java.io.BufferedInputStream;
import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Iterator;
import java.util.Map;

import javax.activation.MimetypesFileTypeMap;

/**
 * HTTP工具类
 * @author JW.XIN
 *
 */
public class HTTPUtil {
	/**
	 * 获得URL返回的字符串
	 * 
	 * @param url
	 * @return
	 */
	public static String loadURL(String url) {
		StringBuilder sb = new StringBuilder();
		try {
			URL urlObject = new URL(url);
			URLConnection uc = urlObject.openConnection();
			BufferedReader in = new BufferedReader(new InputStreamReader(
					uc.getInputStream()));
			String inputLine = null;
			while ((inputLine = in.readLine()) != null) {
				sb.append(inputLine);
			}
			in.close();
		} catch (MalformedURLException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		return sb.toString();
	}
	
	/**
	 * 获得URL返回的字符串
	 * @param url
	 * @param encode 编码
	 * @return
	 */
	public static String loadURL(String url,String encode) {
		String str = null;
		try {
			URL urlObject = new URL(url);
			URLConnection uc = urlObject.openConnection();
			str = changeInputStream(uc.getInputStream(), encode);
		} catch (MalformedURLException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		return str;
	}

	/**
	 * 从url下载多媒体文件
	 * 
	 * @param url
	 * @param targetPath
	 * @return
	 */
	public static byte[] downLoadMedia(String url, String targetPath) {
		FileOutputStream fos = null;
		BufferedInputStream stream = null;
		HttpURLConnection httpUrl = null;
		try {
			URL urlObject = new URL(url);
			httpUrl = (HttpURLConnection) urlObject.openConnection();
			httpUrl.connect();
			stream = new BufferedInputStream(httpUrl.getInputStream());
			fos = new FileOutputStream(targetPath);
			int size = 0;
			byte[] buf = new byte[1024];
			while ((size = stream.read(buf)) != -1) {
				fos.write(buf, 0, size);
			}
			fos.flush();
			return buf;
			// 下面的代码可以在android下把byte数组转化为bitmap
			// BitmapFactory.decodeByteArray(data, 0, data.length);
		} catch (MalformedURLException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		} finally {
			try {
				fos.close();
			} catch (IOException e) {
			}
			try {
				stream.close();
			} catch (IOException e) {
			}
			httpUrl.disconnect();
		}
		return null;
	}

	/**
	 * 向url发送数据并获得返回结果
	 * 
	 * @param url
	 * @param message
	 * @param encode
	 * @return
	 */
	public static String sendPostMsg(String url, String message, String encode) {
		try {
			URL urlObject = new URL(url);
			HttpURLConnection httpURLConnection = (HttpURLConnection) urlObject
					.openConnection();
			httpURLConnection.setConnectTimeout(3000);
			httpURLConnection.setDoInput(true);// 从服务器获取数据
			httpURLConnection.setDoOutput(true);// 向服务器写入数据

			// 获得上传信息的字节大小及长度
			byte[] mydata = message.getBytes();
			// 设置请求体的类型

			// 获得输出流，向服务器输出数据
			OutputStream outputStream = (OutputStream) httpURLConnection
					.getOutputStream();
			outputStream.write(mydata);

			// 获得服务器响应的结果和状态码
			int responseCode = httpURLConnection.getResponseCode();
			if (responseCode == 200) {

				// 获得输入流，从服务器端获得数据
				InputStream inputStream = (InputStream) httpURLConnection
						.getInputStream();
				return (changeInputStream(inputStream, encode));
			}
		} catch (MalformedURLException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		return null;
	}

	/**
	 * 发送多媒体数据并获得返回结果
	 * 
	 * @param url
	 * @param data
	 * @param encode
	 * @return
	 */
	public static String sendMedia(String url, byte[] data, String encode) {
		try {
			URL urlObject = new URL(url);
			HttpURLConnection httpURLConnection = (HttpURLConnection) urlObject
					.openConnection();
			httpURLConnection.setConnectTimeout(3000);
			httpURLConnection.setDoInput(true);// 从服务器获取数据
			httpURLConnection.setDoOutput(true);// 向服务器写入数据

			// 获得上传信息的字节大小及长度
			// 设置请求体的类型
			httpURLConnection.setRequestProperty("Content-Type",
					"application/x-www-form-urlencoded");
			httpURLConnection.setRequestProperty("Content-Lenth",
					String.valueOf(data.length));

			// 获得输出流，向服务器输出数据
			OutputStream outputStream = (OutputStream) httpURLConnection
					.getOutputStream();
			outputStream.write(data);

			// 获得服务器响应的结果和状态码
			int responseCode = httpURLConnection.getResponseCode();
			if (responseCode == 200) {

				// 获得输入流，从服务器端获得数据
				InputStream inputStream = (InputStream) httpURLConnection
						.getInputStream();
				return (changeInputStream(inputStream, encode));
			}
		} catch (MalformedURLException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		return null;
	}

	/**
	 * 把从输入流InputStream按指定编码格式encode变成字符串String
	 * 
	 * @param inputStream
	 * @param encode
	 * @return
	 */
	public static String changeInputStream(InputStream inputStream,
			String encode) {

		if (inputStream == null)
			return null;
		// ByteArrayOutputStream 一般叫做内存流
		ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
		byte[] data = new byte[1024];
		int len = 0;
		String result = null;
		if (inputStream != null) {
			try {
				while ((len = inputStream.read(data)) != -1) {
					byteArrayOutputStream.write(data, 0, len);
				}
				result = new String(byteArrayOutputStream.toByteArray(), encode);
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		return result;
	}

	@SuppressWarnings("rawtypes")
	public static String formUpload(String urlStr, Map<String, String> textMap,
			Map<String, String> fileMap) {
		String res = "";
		HttpURLConnection conn = null;
		String BOUNDARY = "---------------------------1200310125"; // boundary就是request头和上传文件内容的分隔符
		try {
			URL url = new URL(urlStr);
			conn = (HttpURLConnection) url.openConnection();
			conn.setConnectTimeout(5000);
			conn.setReadTimeout(30000);
			conn.setDoOutput(true);
			conn.setDoInput(true);
			conn.setUseCaches(false);
			conn.setRequestMethod("POST");
			// 协议头
			conn.setRequestProperty("Connection", "Keep-Alive");
			conn.setRequestProperty("User-Agent",
					"Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-CN; rv:1.9.2.6)");
			// User-Agent头域的内容包含发出请求的用户信息。

			conn.setRequestProperty("Content-Type",
					"multipart/form-data; boundary=" + BOUNDARY);
			// Content-Type实体头用于向接收方指示实体的介质类型,
			/**
			 * 如果要在客户端向服务器上传文件，我们就必须模拟一个POST
			 * multipart/form-data类型的请求，Content-Type必须是multipart/form-data。
			 * multipart/form-data需要首先在HTTP请求头设置一个分隔符，
			 * 例如ABCD：hc.setRequestProperty("Content-Type",
			 * "multipart/form-data; boundary=ABCD"); 然后一个“\r\n--分隔符--\r\n”表示结束。
			 */

			OutputStream out = new DataOutputStream(conn.getOutputStream());
			// text
			if (textMap != null) {
				StringBuffer strBuf = new StringBuffer();
				Iterator iter = textMap.entrySet().iterator();
				while (iter.hasNext()) {
					Map.Entry entry = (Map.Entry) iter.next();
					String inputName = (String) entry.getKey();
					String inputValue = (String) entry.getValue();
					if (inputValue == null) {
						continue;
					}
					strBuf.append("\r\n").append("--").append(BOUNDARY)
							.append("\r\n");
					strBuf.append("Content-Disposition: form-data; name=\""
							+ inputName + "\"\r\n\r\n");
					strBuf.append(inputValue);
				}
				out.write(strBuf.toString().getBytes());
			}

			// file
			if (fileMap != null) {
				Iterator iter = fileMap.entrySet().iterator();
				while (iter.hasNext()) {
					Map.Entry entry = (Map.Entry) iter.next();
					String inputName = (String) entry.getKey();
					String inputValue = (String) entry.getValue();
					if (inputValue == null) {
						continue;
					}
					File file = new File(inputValue);
					String filename = file.getName();
					String contentType = new MimetypesFileTypeMap()
							.getContentType(file);
					if (filename.endsWith(".png")) {
						contentType = "image/png";
					}
					if (contentType == null || contentType.equals("")) {
						contentType = "application/octet-stream";
					}

					StringBuffer strBuf = new StringBuffer();
					strBuf.append("\r\n").append("--").append(BOUNDARY)
							.append("\r\n");
					strBuf.append("Content-Disposition: form-data; name=\""
							+ inputName + "\"; filename=\"" + filename
							+ "\"\r\n");
					strBuf.append("Content-Type:" + contentType + "\r\n\r\n");

					out.write(strBuf.toString().getBytes());

					DataInputStream in = new DataInputStream(
							new FileInputStream(file));
					int bytes = 0;
					byte[] bufferOut = new byte[1024];
					while ((bytes = in.read(bufferOut)) != -1) {
						out.write(bufferOut, 0, bytes);
					}
					in.close();
				}
			}

			byte[] endData = ("\r\n--" + BOUNDARY + "--\r\n").getBytes();
			out.write(endData);
			out.flush();
			out.close();

			// 读取返回数据
			StringBuffer strBuf = new StringBuffer();
			BufferedReader reader = new BufferedReader(new InputStreamReader(
					conn.getInputStream()));
			String line = null;
			while ((line = reader.readLine()) != null) {
				strBuf.append(line).append("\n");
			}
			res = strBuf.toString();
			reader.close();
			reader = null;
		} catch (Exception e) {
			System.out.println("发送POST请求出错。" + urlStr);
			e.printStackTrace();
		} finally {
			if (conn != null) {
				conn.disconnect();
				conn = null;
			}
		}
		return res;
	}

	/**
	 * 将微信消息中的CreateTime转换成标准格式的时间（yyyy-MM-dd HH:mm:ss）
	 * @param createTime
	 *            消息创建时间
	 * @return
	 */
	public static String formatTime(String createTime) {
		// 将微信传入的CreateTime转换成long类型，再乘以1000
		long msgCreateTime = Long.parseLong(createTime) * 1000L;
		DateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		return format.format(new Date(msgCreateTime));
	}
}
