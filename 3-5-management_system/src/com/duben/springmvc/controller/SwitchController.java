package com.duben.springmvc.controller;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;
import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import com.duben.springmvc.entity.AllSwitch;
import com.duben.springmvc.entity.Switch;


@SuppressWarnings("hiding")
@Controller
public class SwitchController<Switch> {
		@RequestMapping(value="switch")
		public String Switch(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
			String divicetype="switch";
			// addAttribute()方法可以将服务器的值传递到jsp页面中
			model.addAttribute("deviceType", divicetype);
			System.out.println(divicetype);
			String switchUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByType?deviceType=switch";
			JSONArray jsonArray = ((JSONObject) JSONObject.parse(getdata(switchUrl))).getJSONArray("data");
			System.out.println(jsonArray);
		    model.addAttribute("switchData", jsonArray);//把数组传递到前台
		    int size=jsonArray.size();
		    for(int i=0;i<size;i++){
				 //把里面的对象转化为JSONObject
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
		
		@RequestMapping(value="querySwitch")
		public String QuerySwitch(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
			//springmvc获取jsp页面的参数
			String SwitchQuery=request.getParameter("queryswitch");
			model.addAttribute("brandMode", SwitchQuery);
			System.out.println(SwitchQuery);
			if(SwitchQuery.equals("SWITCH_ONE")||SwitchQuery.equals("SWITCH_TWO")||SwitchQuery.equals("SWITCH_THREE")||SwitchQuery.equals("SWITCH_FOUR")) {
				System.out.println("输入的是开关型号");
				//调用业务层，进行按照型号查询	
				String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByBrandMode?brandMode=";
				String json=getdata(methodUrl+SwitchQuery);               
		                System.out.println("JSON字符串：" + json);
		                
		                JSONObject object = (JSONObject) JSONObject.parse(json);//从字符串中获取对象
		                JSONArray jsonArray = object.getJSONArray("data");//从对象中获取数组
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
			}else if(queryById(SwitchQuery).equals("0")) {
				System.out.println("设备ID/型号不存在");
				model.addAttribute("switchData", 0);
				model.addAttribute("DataCount", 0);
			}else if(queryById(SwitchQuery).equals("1")) {
			String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByDeviceId?deviceId=";
				String json=getdata(methodUrl+SwitchQuery);           
		                System.out.println("JSON字符串：" + json);

		                JSONObject object = (JSONObject) JSONObject.parse(json);//从字符串中获取对象
		                JSONArray jsonArray = object.getJSONArray("data");//从对象中获取数组
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
		            
			}
			
			
		                
			
		return "Switch";	
		}
		
		@RequestMapping(value="queryByMAC")
		public String getByDeviceMac(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
			//springmvc获取jsp页面的参数
			String Switchmac=request.getParameter("searchbymac");
			model.addAttribute("deviceMac", Switchmac);
			 System.out.println(Switchmac);
			//调用业务层，进行按照MAC查询	
			String methodUrl = "http://dubeniot.com:8080/iot-manager/query/getByDeviceMac?deviceMac=";
	        HttpURLConnection connection = null;
	        BufferedReader reader = null;
	        String line = null;
	        try {
	            URL url = new URL(methodUrl + Switchmac);
	            connection = (HttpURLConnection) url.openConnection();// 根据URL生成HttpURLConnection
	            connection.setRequestMethod("GET");// 默认GET请求
	            connection.connect();// 建立TCP连接
	            if (connection.getResponseCode() == HttpURLConnection.HTTP_OK) {
	                reader = new BufferedReader(new InputStreamReader(connection.getInputStream(), "UTF-8"));// 发送http请求
	                StringBuilder result = new StringBuilder();
	                // 循环读取流
	                while ((line = reader.readLine()) != null) {
	                    result.append(line).append(System.getProperty("line.separator"));// "\n"
	                }
	                System.out.println("1");
	                String json=result.toString();	               
	                System.out.println("JSON字符串：" + json);

	                // 转换为 对象BEAN
	                AllSwitch allswitch = JSON.parseObject(json, AllSwitch.class);
	                System.out.println("JavaBean对象：" + allswitch);
	               
	                
	            }
	        }catch (IOException e) {
	            e.printStackTrace();}
	        
			//将查询结果传到model层，将Switchmac信息传到deviceMac参数中，供jsp页面进行显示
	        //model模型：放入了返回给页面的数据
	        /*model底层就是用了request来传递数据。这样model.addAttribute("deviceMac", Switchmac)就相当于request.addAttribute("deviceMac",Switchmac)
	         * 但是我们还是选择使用model.addAttribute("deviceMac", Switchmac)，因为model对request域进行了扩展。*/
			//model.addAttribute("deviceMac", Switchmac);//传到model
			//跳转到jsp页面将Switchmac中的信息进行展示
	        //如果springMVC方法返回一个简单的字符串，那么SpringMvc就会认为这是一个页面的名称（在SpringMvc.xml中将前缀和后缀都已经配置了）	
		return "Switch";	//跳转到getAllSwitch.jsp页面
		}
		
		
		private String queryById(String a) {
			String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByDeviceId?deviceId=";
			String json=getdata(methodUrl+a);
			System.out.println(json);
			JSONObject object = (JSONObject) JSONObject.parse(json);//把字符串转化为对象
			System.out.println(object);
			if(object.getJSONArray("data").isEmpty()||object.getJSONArray("data").size()<1){
				return "0";
			}
			return "1";
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
		public String Online(String a) {
		    String online="在线";
		    String offline="不在线";
		    if("0".toString().equals(a) ) {
		    	 a=online;
		    	System.out.println(a);
		    }else {
		    	 a=offline;
		    	System.out.println(a);
		    }
			return a;
		}
		public String SwitchType(String a) {
		    if("SWITCH_ONE".toString().equals(a) ) {
		    	 a="一位开关";
		    }else if("SWITCH_TWO".toString().equals(a) ) {
		    	 a="二位开关";
		    }else if("SWITCH_THREE".toString().equals(a) ) {
		   	 a="三位开关";}else {a="四位开关";}
			return a;
		}
		
		//合并两个JSONArray数组
				private static JSONArray joinJSONArray(JSONArray array1, JSONArray array2) {
			        StringBuffer sbf = new StringBuffer();
			        JSONArray jSONArray = new JSONArray();
			        try {
			            int len = array1.size();
			            for (int i = 0; i < len; i++) {
			                JSONObject obj1 = (JSONObject) array1.get(i);
			                if (i == len - 1)
			                    sbf.append(obj1.toString());
			                else
			                    sbf.append(obj1.toString()).append(",");
			            }
			            len = array2.size();
			            if (len > 0)
			                sbf.append(",");
			            for (int i = 0; i < len; i++) {
			                JSONObject obj2 = (JSONObject) array2.get(i);
			                if (i == len - 1)
			                    sbf.append(obj2.toString());
			                else
			                    sbf.append(obj2.toString()).append(",");
			            }
			            
			            sbf.insert(0, "[").append("]");
			            jSONArray = JSON.parseArray(sbf.toString());
			            return jSONArray;
			        } catch (Exception e) {
			        }
			        return null;
			    }
}
