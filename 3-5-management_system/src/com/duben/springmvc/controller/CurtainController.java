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
public class CurtainController {
@RequestMapping(value="curtain")
public String Curtain(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
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
    /**String[] ss = deviceMac1.split("");
    int i = 0;
    String deviceMac=ss[i]+ss[i+1]+":"+ss[i+2]+ss[i+3]+":"+ss[i+4]+ss[i+5]+":"+ss[i+6]+ss[i+7]+":"+ss[i+8]+ss[i+9]+":"+ss[i+10]+ss[i+11];      
    String connectionState= Online(connectionState1);
    String brandMode=SwitchType(brandMode1);
    String reversing=direction(reversing1);
    
    String deviceType="窗帘"; 
	model.addAttribute("deviceId", deviceId);
    model.addAttribute("deviceMac", deviceMac);
    model.addAttribute("deviceType", deviceType);
    model.addAttribute("connectionState", connectionState);
    model.addAttribute("phone", phone);
    model.addAttribute("brandMode", brandMode);
    model.addAttribute("reversing", reversing);
    model.addAttribute("percentage", percentage);**/

return "Curtain";
}
@RequestMapping(value="queryCurtain")
public String QuerySocket(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
	//springmvc获取jsp页面的参数
	String CurtainQuery=request.getParameter("querycurtain");
	model.addAttribute("brandMode", CurtainQuery);
	System.out.println(CurtainQuery);
	if(CurtainQuery.equals("CURTAIN_ONE")||CurtainQuery.equals("CURTAIN_TWO")||CurtainQuery.equals("CURTAIN_THREE")) {
		System.out.println("输入的是窗帘型号");
		//调用业务层，进行按照型号查询	
		String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByBrandMode?brandMode=";
		String json=getdata(methodUrl+CurtainQuery);               
                System.out.println("JSON字符串：" + json);
                
                JSONObject object = (JSONObject) JSONObject.parse(json);//从字符串中获取对象
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
	}else if(queryById(CurtainQuery).equals("0")) {
		System.out.println("设备ID/型号不存在");
		model.addAttribute("switchData", 0);
		model.addAttribute("DataCount", 0);
	}else if(queryById(CurtainQuery).equals("1")) {
	String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByDeviceId?deviceId=";
		String json=getdata(methodUrl+CurtainQuery);           
                System.out.println("JSON字符串：" + json);

                JSONObject object = (JSONObject) JSONObject.parse(json);//从字符串中获取对象
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
            
	}
	
	
                
	
return "Curtain";	
}
private String queryById(String a) {
	String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceBindedByDeviceId?deviceId=";
	String json=getdata(methodUrl+a);
	System.out.println(json);
	JSONObject object = (JSONObject) JSONObject.parse(json);//把字符串转化为对象对象
	JSONArray jsonArray = object.getJSONArray("data");//把对象转化为数组
	String data=jsonArray.toString();
	System.out.println(data);
	if(data.equals("[]")) {
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
    if("0".toString().equals(a) ) {
    	 a="在线";
    }else {
    	 a="不在线";
    }
	return a;
}
public String SwitchType(String a) {
    if("CURTAIN_ONE".toString().equals(a) ) {
    	 a="单向";
    }else if("CURTAIN_TWO".toString().equals(a) ) {
    	 a="双向";
    }else  {a="卷轴";}
	return a;
}
public String direction(String a) {
    if("0".toString().equals(a) ) {
    	 a="负";
    }else {
    	 a="正";
    }
	return a;
}

}

