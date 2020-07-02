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
public class AllUserDeviceController {
	@RequestMapping(value="allUserDevice")
	public String QueryAllUserDevice(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
		String Url="http://dubeniot.com:8080/iot-manager/query/getAllUserDevice?pageNum=20&pageSize=2000";
		JSONArray jsonArray = ((JSONObject) JSONObject.parse(getdata(Url))).getJSONArray("data");
		System.out.println(jsonArray);
	    model.addAttribute("allData", jsonArray);//把数组传递到前台
	    int size=jsonArray.size();
	    for(int i=0;i<size;i++){
	    	//把里面的对象转化为JSONObject
			  JSONObject job = jsonArray.getJSONObject(i); 
			  model.addAttribute("DataCount", i+1); 
			  System.out.println(i+1+"deviceId:"+job.getString("deviceid")+"deviceMac:"+job.getString("devicemac")+"deviceType:"+job.getString("devicetype")
			  +"userid:"+job.getString("userid")+"deviceremark:"+job.getString("deviceremark")+"brandMode:"+job.getString("brandMode")
			  +"created:"+ job.getString("created")) ; 
	    }
		return "QueryAllUserDevice";
}
	@RequestMapping(value="queryuserid")
	public String QueryUserId(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
		String UserIdQuery=request.getParameter("queryuserid");
		model.addAttribute("brandMode", UserIdQuery);
		System.out.println(UserIdQuery);
		String Url="http://dubeniot.com:8080/iot-manager/query/getUserDeviceByUserId?userId="+UserIdQuery;
		JSONArray jsonArray = ((JSONObject) JSONObject.parse(getdata(Url))).getJSONArray("data");
		System.out.println(jsonArray);
	    model.addAttribute("allData", jsonArray);//把数组传递到前台
	    int size=jsonArray.size();
	    for(int i=0;i<size;i++){
	    	//把里面的对象转化为JSONObject
			  JSONObject job = jsonArray.getJSONObject(i); 
			  model.addAttribute("DataCount", i+1); 
			  System.out.println(i+1+"deviceId:"+job.getString("deviceid")+"deviceMac:"+job.getString("devicemac")+"deviceType:"+job.getString("devicetype")
			  +"userid:"+job.getString("userid")+"deviceremark:"+job.getString("deviceremark")+"brandMode:"+job.getString("brandMode")
			  +"created:"+ job.getString("created")) ; 
	    }
		return "QueryAllUserDevice";
}
	
	private static String getdata(String url){
		StringBuilder json = new StringBuilder();
		try {
		URL urlObject = new URL(url);
		URLConnection uc = urlObject.openConnection();
		BufferedReader in = new BufferedReader(new InputStreamReader(uc.getInputStream(), "utf-8"));
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




