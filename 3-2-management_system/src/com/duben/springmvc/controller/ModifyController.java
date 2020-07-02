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
public class ModifyController {
	@RequestMapping(value = "/switchmodify")
	public String SwitchModify() {
		return "SwitchModify";
	}

	@RequestMapping(value = "/escswitch")
	public String Escswitch(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
		String switchUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByType?deviceType=switch";
		String switchjson=getdata(switchUrl);
		System.out.println(switchjson);//例如：{"status":200,"msg":"操作成功","data":[{"deviceId":"152319352309815","b1":"2"},{"a2":"3","b2":"4"}]}
		
		JSONObject object = (JSONObject) JSONObject.parse(switchjson);//把字符串转化为对象对象
		JSONArray jsonArray = object.getJSONArray("data");//把对象中转化为数组
		System.out.println(jsonArray);
	    model.addAttribute("switchData", jsonArray);//把数组传递到前台
	    for(int i=0;i<jsonArray.size();i++){
			 //3、把里面的对象转化为JSONObject
			  JSONObject job = jsonArray.getJSONObject(i); 
			  model.addAttribute("DataCount", i+1); 
			  System.out.println(i+1+"deviceId:"+job.getString("deviceId")+"deviceMac:"+job.getString("deviceMac")+"deviceType:"+job.getString("deviceType")
			  +"connectionState:"+job.getString("connectionState")+"phone:"+job.getString("phone")+"brandMode:"+job.getString("brandMode")
			  +"oneTimingDataLists:"+ job.getString("oneTimingDataLists")+"twoTimingDataLists:"+job.getString("twoTimingDataLists")
			  +"threeTimingDataLists:"+job.getString("threeTimingDataLists")+"fourTimingDataLists:"+job.getString("fourTimingDataLists")
			  +"reversing:"+job.getString("reversing")+"percentage:"+job.getString("percentage")+"electricityConsumption:"+job.getString("electricityConsumption")) ; 
	    }
		return "Switch";
	}

	@RequestMapping(value = "/socketmodify")
	public String SocketModify() {
		return "SocketModify";
	}

	@RequestMapping(value = "/escsocket")
	public String Escsocket() {
		return "getDeviceBindedByBrandMode";
	}

	@RequestMapping(value = "/curtainmodify")
	public String CurtainModify() {
		return "CurtainModify";
	}

	@RequestMapping(value = "/esccurtain")
	public String Esccurtain() {
		return "getDeviceBindedByBrandMode";
	}

	@RequestMapping(value = "/pasmodify")
	public String PASModify() {
		return "PASModify";
	}

	@RequestMapping(value = "/escPAS")
	public String EscPAS() {
		return "getDeviceBindedByBrandMode";
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
}