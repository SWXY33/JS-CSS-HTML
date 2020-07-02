package com.duben.springmvc.controller;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.util.List;

import javax.servlet.http.HttpSession;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import com.duben.springmvc.entity.Divice;

@Controller
public class AddbindController {
	@RequestMapping(value = "addbind")
	public String addbind() {
		return "Addbind";
	}

	@RequestMapping(value = "addNew")
	public String addNew() {
		String pinpointUrl = "http://dubeniot.com:8080/iot-manager/query/addbind";
		String json = getdata(pinpointUrl);
		System.out.println(json);
		return "Switch";

	}
	@RequestMapping(value = "esc")
	public String Esc() {
		return "getDeviceBindedByBrandMode";

	}

	

	private static String getdata(String url) {
		StringBuilder json = new StringBuilder();// 缓冲区
		try {
			URL urlObject = new URL(url);// 通过url获取连接
			URLConnection uc = urlObject.openConnection();
			// 设置为utf-8的编码 解决中文乱码
			BufferedReader in = new BufferedReader(new InputStreamReader(uc.getInputStream(), "utf-8"));// 读取返回的数据
			String inputLine = null;
			while ((inputLine = in.readLine()) != null) {
				json.append(inputLine);
			}
			in.close();
		} catch (MalformedURLException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}

		return json.toString();
	}

}