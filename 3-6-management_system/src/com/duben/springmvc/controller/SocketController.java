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
				// addAttribute()�������Խ���������ֵ���ݵ�jspҳ����
				model.addAttribute("deviceType", divicetype);
				System.out.println(divicetype);
				String socketUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByType?deviceType=socket";
				String socketjson=getdata(socketUrl);
				System.out.println(socketjson);//���磺{"status":200,"msg":"�����ɹ�","data":[{"deviceId":"152319352309815","b1":"2"},{"a2":"3","b2":"4"}]}
				
				
				JSONObject object = (JSONObject) JSONObject.parse(socketjson);//���ַ����л�ȡ����
				JSONArray jsonArray = object.getJSONArray("data");//�Ӷ����л�ȡ����
				
				model.addAttribute("socketData", jsonArray);//��jsonArray���鴫�ݵ�ǰ̨�洢��socetData��
			    for(int i=0;i<jsonArray.size();i++){
					 //3��������Ķ���ת��ΪJSONObject
					  JSONObject job = jsonArray.getJSONObject(i); 
					  model.addAttribute("DataCount", i+1); 
					  System.out.println(i+1+"deviceId:"+job.getString("deviceId")+"deviceMac:"+job.getString("deviceMac")+"deviceType:"+job.getString("deviceType")
					  +"connectionState:"+job.getString("connectionState")+"phone:"+job.getString("phone")+"brandMode:"+job.getString("brandMode")
					  +"oneTimingDataLists:"+ job.getString("oneTimingDataLists")+"twoTimingDataLists:"+job.getString("twoTimingDataLists")
					  +"threeTimingDataLists:"+job.getString("threeTimingDataLists")+"fourTimingDataLists:"+job.getString("fourTimingDataLists")
					  +"reversing:"+job.getString("reversing")+"percentage:"+job.getString("percentage")+"electricityConsumption:"+job.getString("electricityConsumption")) ; 
			    }/**
				String deviceId = jsonArray.getJSONObject(0).getString("deviceId");//�������л�ȡ��һ�������"deviceId"ֵ
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
	            String deviceType="����";     
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
	            System.out.println(electricityConsumption);**/
					
			return "Socket";
			}
			@RequestMapping(value="querySocket")
			public String QuerySocket(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
				//springmvc��ȡjspҳ��Ĳ���
				String SocketQuery=request.getParameter("querysocket");
				
				System.out.println(SocketQuery);
				if(SocketQuery.equals("SOCKET_10A")||SocketQuery.equals("SOCKET_16A")) {
					System.out.println("������ǲ����ͺ�");
					//����ҵ��㣬���а����ͺŲ�ѯ	
					String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByBrandMode?brandMode=";
					String json=getdata(methodUrl+SocketQuery);               
			                System.out.println("JSON�ַ�����" + json);
			                
			                JSONObject object = (JSONObject) JSONObject.parse(json);//���ַ����л�ȡ����
			                JSONArray jsonArray = object.getJSONArray("data");//�Ӷ����л�ȡ����
			                model.addAttribute("socketData", jsonArray);//�����鴫�ݵ�ǰ̨
			                for(int i=0;i<jsonArray.size();i++){
			   				 //3��������Ķ���ת��ΪJSONObject
			   				  JSONObject job = jsonArray.getJSONObject(i); 
			   				  model.addAttribute("DataCount", i+1); 
			   				  System.out.println(i+1+"deviceId:"+job.getString("deviceId")+"deviceMac:"+job.getString("deviceMac")+"deviceType:"+job.getString("deviceType")
			   				  +"connectionState:"+job.getString("connectionState")+"phone:"+job.getString("phone")+"brandMode:"+job.getString("brandMode")
			   				  +"oneTimingDataLists:"+ job.getString("oneTimingDataLists")+"twoTimingDataLists:"+job.getString("twoTimingDataLists")
			   				  +"threeTimingDataLists:"+job.getString("threeTimingDataLists")+"fourTimingDataLists:"+job.getString("fourTimingDataLists")
			   				  +"reversing:"+job.getString("reversing")+"percentage:"+job.getString("percentage")+"electricityConsumption:"+job.getString("electricityConsumption")) ; 
			   		    }  
				}else if(queryById(SocketQuery).equals("0")&&queryBybrandMode(SocketQuery).equals("0")) {
					System.out.println("设备D/型号不存在！");
					model.addAttribute("socketData", 0);
					model.addAttribute("DataCount", 0);
				}else if(queryById(SocketQuery).equals("1")) {
				String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByDeviceId?deviceId=";
					String json=getdata(methodUrl+SocketQuery);           
			                System.out.println("JSON数组为" + json);

			                JSONObject object = (JSONObject) JSONObject.parse(json);//将字符串转化为对象
			                JSONArray jsonArray = object.getJSONArray("data");//获取data对象的数组
			                model.addAttribute("socketData", jsonArray);//将jsonArray数组存储在switchDta
			                for(int i=0;i<jsonArray.size();i++){
			   				 //3銆佹妸閲岄潰鐨勫璞¤浆鍖栦负JSONObject
			   				  JSONObject job = jsonArray.getJSONObject(i); 
			   				  model.addAttribute("DataCount", i+1); 
			   				  System.out.println(i+1+"deviceId:"+job.getString("deviceId")+"deviceMac:"+job.getString("deviceMac")+"deviceType:"+job.getString("deviceType")
			   				  +"connectionState:"+job.getString("connectionState")+"phone:"+job.getString("phone")+"brandMode:"+job.getString("brandMode")
			   				  +"oneTimingDataLists:"+ job.getString("oneTimingDataLists")+"twoTimingDataLists:"+job.getString("twoTimingDataLists")
			   				  +"threeTimingDataLists:"+job.getString("threeTimingDataLists")+"fourTimingDataLists:"+job.getString("fourTimingDataLists")
			   				  +"reversing:"+job.getString("reversing")+"percentage:"+job.getString("percentage")+"electricityConsumption:"+job.getString("electricityConsumption")) ; 
			   		    }
			            
				}else if(queryBybrandMode(SocketQuery).equals("1")) {
					String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByBrandMode?brandMode=";
					String json=getdata(methodUrl+SocketQuery);
					System.out.println("aaaaa"+json);
					JSONObject object = (JSONObject) JSONObject.parse(json);//把字符串转化为对象
					System.out.println("2222"+object);
			        JSONArray jsonArray = object.getJSONArray("data");
			       int num=jsonArray.size() ;
			       model.addAttribute("DataCount",num);
			        model.addAttribute("socketData", jsonArray);
				}else {			
						System.out.println("设备D/型号不存在！");
						model.addAttribute("socketData", 0);
						model.addAttribute("DataCount", 0);
				}
			return "Socket";	
			}
			private String queryById(String a)  {
				String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByDeviceId?deviceId=";
				String json=getdata(methodUrl+a);
				System.out.println("id"+json);
				JSONObject object = (JSONObject) JSONObject.parse(json);//把字符串转化为对象
				System.out.println("id"+object);
				System.out.println("object.getJSONArray(\"data\")=根据id查询：:"+object.getJSONArray("data"));
				if(object.getJSONArray("data")==null){
					return "0";
				}
				return "1";
			}
			private String queryBybrandMode(String a)  {
				String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByBrandMode?brandMode=";
				String json=getdata(methodUrl+a);
				System.out.println("1"+json);
				JSONObject object = (JSONObject) JSONObject.parse(json);//把字符串转化为对象
				System.out.println("2"+object);
				
				if(object.getJSONArray("data")==null){
					return "0";
				}else {
					System.out.println("object.getJSONArray(\"data\")=返回1:"+object.getJSONArray("data"));
				return "1";}
			}
			private static String getdata(String url){
				StringBuilder json = new StringBuilder();//������
				try {
				URL urlObject = new URL(url);//ͨ��url��ȡ����
				URLConnection uc = urlObject.openConnection();
				// ����Ϊutf-8�ı��� �����������
				BufferedReader in = new BufferedReader(new InputStreamReader(uc.getInputStream(), "utf-8"));//��ȡ���ص�����
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
