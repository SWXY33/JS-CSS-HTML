package com.duben.springmvc.controller;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;

import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
@Controller
public class SocketController {
		
			@RequestMapping(value="socket")
			public String Socket(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
				String divicetype="socket";
				// addAttribute()方法可以将服务器的值传递到jsp页面中
				model.addAttribute("deviceType", divicetype);
				System.out.println(divicetype);
				String switchUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByType?deviceType=socket";
				String switchjson=getdata(switchUrl);
				System.out.println(switchjson);//例如：{"status":200,"msg":"操作成功","data":[{"deviceId":"152319352309815","b1":"2"},{"a2":"3","b2":"4"}]}
				
				
				JSONObject object = (JSONObject) JSONObject.parse(switchjson);//从字符串中获取对象
				JSONArray jsonArray = object.getJSONArray("data");//从对象中获取数组
				String deviceId = jsonArray.getJSONObject(0).getString("deviceId");//从数组中获取第一个对象的"deviceId"值
				String deviceMac1 = jsonArray.getJSONObject(0).getString("deviceMac");
				//String deviceType = jsonArray.getJSONObject(0).getString("deviceType");
	            String connectionState = jsonArray.getJSONObject(0).getString("connectionState");
	            String phone = jsonArray.getJSONObject(0).getString("phone");
	            String brandMode1 = jsonArray.getJSONObject(0).getString("brandMode");
	            String electricityConsumption = jsonArray.getJSONObject(0).getString("electricityConsumption");
	            String[] ss = deviceMac1.split("");
	            int i = 0;
	            String deviceMac=ss[i]+ss[i+1]+":"+ss[i+2]+ss[i+3]+":"+ss[i+4]+ss[i+5]+":"+ss[i+6]+ss[i+7]+":"+ss[i+8]+ss[i+9]+":"+ss[i+10]+ss[i+11];
	            String brandMode=SwitchType(brandMode1);
	            String deviceType="插座";     
				model.addAttribute("deviceId", deviceId);
	            model.addAttribute("deviceMac", deviceMac);
	            model.addAttribute("deviceType", deviceType);
	            model.addAttribute("connectionState", connectionState);
	            model.addAttribute("phone", phone);
	            model.addAttribute("brandMode", brandMode);
	            model.addAttribute("electricityConsumption", electricityConsumption);
	            System.out.println(deviceId);
	            System.out.println(deviceMac);
	            System.out.println(deviceType);
	            System.out.println(connectionState);
	            System.out.println(phone);
	            System.out.println(brandMode);
	            System.out.println(electricityConsumption);
					
			return "Socket";
			}
			private static String getdata(String url){
				StringBuilder json = new StringBuilder();//缓冲区
				try {
				URL urlObject = new URL(url);//通过url获取连接
				URLConnection uc = urlObject.openConnection();
				// 设置为utf-8的编码 解决中文乱码
				BufferedReader in = new BufferedReader(new InputStreamReader(uc.getInputStream(), "utf-8"));//读取返回的数据
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
			public String SwitchType(String a) {
			    if("SOCKET_10A".toString().equals(a) ) {
			    	 a="10A";
			    }else  {a="16A";}
				return a;
			}
}
