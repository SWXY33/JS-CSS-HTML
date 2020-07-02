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
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;



@Controller
public class AddbindController {
	@RequestMapping(value = "addbind")
	public String addbind(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
		String Divicetype=request.getParameter("type");
		System.out.println(Divicetype);
		model.addAttribute("type",Divicetype);
		//if("switch".toString().equals(Divicetype) ) {
		//	return "Switch";
		//}else if("switch".toString().equals(Divicetype)) {
			
		//}
		
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
	public String Esc(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
		String Divicetype=request.getParameter("devicetype");
		System.out.println(Divicetype);
		if("switch".toString().equals(Divicetype)) {
			String divicetype="switch";
			model.addAttribute("deviceType", divicetype);
			String switchUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByType?deviceType=switch";
			JSONArray jsonArray = ((JSONObject) JSONObject.parse(getdata(switchUrl))).getJSONArray("data");
			System.out.println(jsonArray);
		    model.addAttribute("switchData", jsonArray);//鎶婃暟缁勪紶閫掑埌鍓嶅彴
		    int size=jsonArray.size();
		    for(int i=0;i<size;i++){
				 //鎶婇噷闈㈢殑瀵硅薄杞寲涓篔SONObject
				  JSONObject job = jsonArray.getJSONObject(i); 
				  model.addAttribute("DataCount", i+1); 
				  System.out.println(i+1+"deviceId:"+job.getString("deviceId")+"deviceMac:"+job.getString("deviceMac")+"deviceType:"+job.getString("deviceType")
				  +"connectionState:"+job.getString("connectionState")+"phone:"+job.getString("phone")+"brandMode:"+job.getString("brandMode")
				  +"oneTimingDataLists:"+ job.getString("oneTimingDataLists")+"twoTimingDataLists:"+job.getString("twoTimingDataLists")
				  +"threeTimingDataLists:"+job.getString("threeTimingDataLists")+"fourTimingDataLists:"+job.getString("fourTimingDataLists")
				  +"reversing:"+job.getString("reversing")+"percentage:"+job.getString("percentage")+"electricityConsumption:"+job.getString("electricityConsumption")) ; 
		    }	
		return "Switch";
		}else if("socket".toString().equals(Divicetype)){
			String divicetype="socket";
			// addAttribute()方法可以将服务器的值传递到jsp页面中
			model.addAttribute("deviceType", divicetype);
			System.out.println(divicetype);
			String socketUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByType?deviceType=socket";
			String socketjson=getdata(socketUrl);
			System.out.println(socketjson);//例如：{"status":200,"msg":"操作成功","data":[{"deviceId":"152319352309815","b1":"2"},{"a2":"3","b2":"4"}]}	
			JSONObject object = (JSONObject) JSONObject.parse(socketjson);//从字符串中获取对象
			JSONArray jsonArray = object.getJSONArray("data");//从对象中获取数组
			
			model.addAttribute("socketData", jsonArray);//把jsonArray数组传递到前台存储在socetData中
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
		   return "Socket";
		}
		else if("curtains".toString().equals(Divicetype)) {
			String divicetype="curtains";
			// addAttribute()方法可以将服务器的值传递到jsp页面中
			model.addAttribute("deviceType", divicetype);
			System.out.println(divicetype);
			String switchUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByType?deviceType=curtains";
			String switchjson=getdata(switchUrl);
			System.out.println(switchjson);//例如：{"status":200,"msg":"操作成功","data":[{"deviceId":"152319352309815","b1":"2"},{"a2":"3","b2":"4"}]}	
			JSONObject object = (JSONObject) JSONObject.parse(switchjson);//从字符串中获取对象
			JSONArray jsonArray = object.getJSONArray("data");//从对象中获取数组
			model.addAttribute("curtainData", jsonArray);//把数组传递到前台
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
			return "Curtain";
		}else if("fresh_air_system".toString().equals(Divicetype)) {
			String divicetype="fresh_air_system";
			// addAttribute()方法可以将服务器的值传递到jsp页面中
			model.addAttribute("deviceType", divicetype);
			System.out.println(divicetype);
			String switchUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByType?deviceType=fresh_air_system";
			String switchjson=getdata(switchUrl);
			System.out.println(switchjson);//例如：{"status":200,"msg":"操作成功","data":[{"deviceId":"152319352309815","b1":"2"},{"a2":"3","b2":"4"}]}
			
			JSONObject object = (JSONObject) JSONObject.parse(switchjson);//把字符串转化为对象对象
			JSONArray jsonArray = object.getJSONArray("data");//把对象中转化为数组
			System.out.println(jsonArray);
		    model.addAttribute("PASData", jsonArray);//把数组传递到前台
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
		   return "PAS";
	}else {
		return "Router";
	}
	
	}
	

	private static String getdata(String url) {
		StringBuilder json = new StringBuilder();// 缂撳啿鍖�
		try {
			URL urlObject = new URL(url);// 閫氳繃url鑾峰彇杩炴帴
			URLConnection uc = urlObject.openConnection();
			// 璁剧疆涓簎tf-8鐨勭紪鐮� 瑙ｅ喅涓枃涔辩爜
			BufferedReader in = new BufferedReader(new InputStreamReader(uc.getInputStream(), "utf-8"));// 璇诲彇杩斿洖鐨勬暟鎹�
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