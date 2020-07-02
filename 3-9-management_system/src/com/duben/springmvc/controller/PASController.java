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
public class PASController {
@RequestMapping(value="PAS")
	public String PAS(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
		String divicetype="fresh_air_system";
		// addAttribute()�������Խ���������ֵ���ݵ�jspҳ����
		model.addAttribute("deviceType", divicetype);
		System.out.println(divicetype);
		String switchUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByType?deviceType=fresh_air_system";
		String switchjson=getdata(switchUrl);
		System.out.println(switchjson);//���磺{"status":200,"msg":"�����ɹ�","data":[{"deviceId":"152319352309815","b1":"2"},{"a2":"3","b2":"4"}]}
		
		JSONObject object = (JSONObject) JSONObject.parse(switchjson);//���ַ���ת��Ϊ�������
		JSONArray jsonArray = object.getJSONArray("data");//�Ѷ�����ת��Ϊ����
		System.out.println(jsonArray);
	    model.addAttribute("PASData", jsonArray);//�����鴫�ݵ�ǰ̨
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
	     
	return "PAS";
	}

@RequestMapping(value="queryPAS")
public String geByBrandMode(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
	//springmvc��ȡjspҳ��Ĳ���
	String PASQuery=request.getParameter("querypas");
	model.addAttribute("brandMode", PASQuery);
	System.out.println(PASQuery);
	if(PASQuery.equals("FRESHAIR_ONE")) {
		System.out.println("��������·�ϵͳ���ͺ�");
		//����ҵ��㣬���а����ͺŲ�ѯ	
		String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByBrandMode?brandMode=";
		String json=getdata(methodUrl+PASQuery);               
                System.out.println("JSON�ַ�����" + json);
                
                JSONObject object = (JSONObject) JSONObject.parse(json);//���ַ����л�ȡ����
                JSONArray jsonArray = object.getJSONArray("data");//�Ӷ����л�ȡ����
                model.addAttribute("PASData", jsonArray);//�����鴫�ݵ�ǰ̨
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
	}else if(queryById(PASQuery).equals("0")&&queryBybrandMode(PASQuery).equals("0")) {
		System.out.println("设备D/型号不存在！");
		model.addAttribute("PASData", 0);
		model.addAttribute("DataCount", 0);
	}else if(queryById(PASQuery).equals("1")) {
	String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByDeviceId?deviceId=";
		String json=getdata(methodUrl+PASQuery);           
                System.out.println("JSON数组为" + json);

                JSONObject object = (JSONObject) JSONObject.parse(json);//将字符串转化为对象
                JSONArray jsonArray = object.getJSONArray("data");//获取data对象的数组
                model.addAttribute("PASData", jsonArray);//将jsonArray数组存储在switchDta
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
            
	}else if(queryBybrandMode(PASQuery).equals("1")) {
		String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByBrandMode?brandMode=";
		String json=getdata(methodUrl+PASQuery);
		System.out.println("通过型号可查询到数据"+json);
		JSONObject object = (JSONObject) JSONObject.parse(json);//把字符串转化为对象
		System.out.println("通过型号可查询到"+object);
        JSONArray jsonArray = object.getJSONArray("data");
       int num=jsonArray.size() ;
       model.addAttribute("DataCount",num);
        model.addAttribute("PASData", jsonArray);
	}else {			
			System.out.println("设备D/型号不存在！");
			model.addAttribute("PASData", 0);
			model.addAttribute("DataCount", 0);
	}
	
return "PAS";	
}
private String queryById(String a)  {
	String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByDeviceId?deviceId=";
	String json=getdata(methodUrl+a);
	System.out.println("id"+json);
	JSONObject object = (JSONObject) JSONObject.parse(json);//把字符串转化为对象
	System.out.println("id"+object);
	System.out.println("根据id查询：object.getJSONArray(\"data\")=:"+object.getJSONArray("data"));
	if(object.getJSONArray("data")==null){
		return "0";
	}
	return "1";
}
private String queryBybrandMode(String a)  {
	String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByBrandMode?brandMode=";
	String json=getdata(methodUrl+a);
	System.out.println("查询型号"+json);
	JSONObject object = (JSONObject) JSONObject.parse(json);//把字符串转化为对象
	System.out.println("查询型号"+object);
	
	if(object.getJSONArray("data")==null||object.getJSONArray("data").isEmpty()){
		System.out.println("根据型号查询不到数据：object.getJSONArray(\"data\")=返回0:"+object.getJSONArray("data"));
		return "0";
	}else {
		System.out.println("根据queryBybrandMode查询：object.getJSONArray(\"data\")=返回1:"+object.getJSONArray("data"));
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
}

