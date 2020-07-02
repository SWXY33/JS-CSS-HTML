package com.duben.springmvc.controller;



import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.text.DecimalFormat;
import java.text.NumberFormat;
import java.text.ParseException;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;

import com.alibaba.fastjson.JSONObject;
import com.duben.springmvc.entity.User;

/**
 * UserController 是一个基于注解的控制器
 * 可以同时处理多个请求动作
 */
@Controller
public class UserController {
    
    /**
    * RequestMapping 用来映射一个请求和请求的方法
                *               通过modelmap方式
     * @throws ParseException 
    */
	
	
	@RequestMapping(value="/vue")
    public String VueTest() {
		return "testVue";
	}
		@RequestMapping(value="/testPage")
	    public String PageTest() {
			return "testPage";
		
	}
    @RequestMapping(value="/login")
    public String Login(HttpServletRequest request,HttpServletResponse response,HttpSession session,@ModelAttribute("form") User user, Model model) throws ParseException {  
    	// user:视图层传给控制层的表单对象；model：控制层返回给视图层的对象
    	// 在 model 中添加一个名为 "user" 的 user 对象
        model.addAttribute("user",user);
    	//springmvc获取jsp页面的参数
    	
		//String Switchmac=request.getParameter("username");
		//model.addAttribute("username", Switchmac);
		//System.out.println(Switchmac);
        
        String switchUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceTypeCount?deviceType=switch";
        String curtainsUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceTypeCount?deviceType=curtains";
        String socketUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceTypeCount?deviceType=socket";
        String fresh_air_systemUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceTypeCount?deviceType=fresh_air_system";
        String diviceNum="http://dubeniot.com:8080/iot-manager/query/getArea?province=%E5%B9%BF%E4%B8%9C%E7%9C%81&city=%E6%B1%9F%E9%97%A8%E5%B8%82";
      
		String switchjson=getdata(switchUrl);
		String curtainsjson=getdata(curtainsUrl);
		String socketjson=getdata(socketUrl);
		String fresh_air_systemjson=getdata(fresh_air_systemUrl);
		String divicenumjson=getdata(diviceNum);
		
		JSONObject switchobject = (JSONObject) JSONObject.parse(switchjson);
		JSONObject curtainsobject = (JSONObject) JSONObject.parse(curtainsjson);
		JSONObject socketobject = (JSONObject) JSONObject.parse(socketjson);
		JSONObject fresh_air_systemobject = (JSONObject) JSONObject.parse(fresh_air_systemjson);
		JSONObject divicenumobject = (JSONObject) JSONObject.parse(divicenumjson);

		//得到数组和对象
		JSONObject switchdataObject  = switchobject.getJSONObject("data");
		JSONObject curtainsdataObject  = curtainsobject.getJSONObject("data");
		JSONObject socketdataObject  = socketobject.getJSONObject("data");
		JSONObject fresh_air_systemdataObject  = fresh_air_systemobject.getJSONObject("data");
		JSONObject divicenumobjectdataObject  = divicenumobject.getJSONObject("data");
       
        String switchcount = switchdataObject.getString("count");
        Integer switchCount=Integer.parseInt(switchcount);
        System.out.println(switchCount);
        String switchconnectCount=switchdataObject.getString("connectCount");
        String curtainscount = curtainsdataObject.getString("count");
        Integer curtainsCount=Integer.parseInt(curtainscount);
        String curtainsconnectCount=curtainsdataObject.getString("connectCount");
        String socketcount = socketdataObject.getString("count");
        Integer socketCount=Integer.parseInt(socketcount);
        String socketconnectCount=socketdataObject.getString("connectCount");
        String fresh_air_systemcount = fresh_air_systemdataObject.getString("count");
        Integer fresh_air_systemCount=Integer.parseInt(fresh_air_systemcount);
        String fresh_air_systemconnectCount=fresh_air_systemdataObject.getString("connectCount");
        Integer diviceCount=divicenumobjectdataObject.getInteger("count");  
        String  divicepercentage=divicenumobjectdataObject.getString("percentage");
        NumberFormat nf=NumberFormat.getPercentInstance();
        Number m;
		
			m = nf.parse(divicepercentage);//将百分数转换成Number类型
			System.out.println(m);
	        double dd=m.doubleValue();//通过调用nubmer类默认方法直接转换成double
	        Double diviceAllCount1 =diviceCount/dd;
	        System.out.println(diviceAllCount1);
	        Integer diviceAllCount2=(int) Math.round(diviceAllCount1); //四舍五入
	        System.out.println("设备总数："+diviceAllCount2);
	        double diviceAllCount=diviceAllCount2.doubleValue();
	        double switchpercentage1=switchCount/diviceAllCount;
	        double curtainspercentage1=curtainsCount/diviceAllCount;
	        double socketpercentage1=socketCount/diviceAllCount;
	        double fresh_air_systempercentage1=fresh_air_systemCount/diviceAllCount;
	        double otherpercentage1=1.00-switchpercentage1-curtainspercentage1-socketpercentage1-fresh_air_systempercentage1;
	        
	        NumberFormat num = NumberFormat.getPercentInstance(); //把double类型转化成百分比
	        String switchrates = num.format(switchpercentage1);
	        System.out.println("开关设备百分比："+switchrates);
	        String curtainsrates = num.format(curtainspercentage1);
	        System.out.println("窗帘设备百分比："+curtainsrates);
	        String socketrates = num.format(socketpercentage1);
	        System.out.println("插座设备百分比："+socketrates);
	        String fresh_air_systemrates = num.format(fresh_air_systempercentage1);
	        System.out.println("新风系统设备百分比："+fresh_air_systemrates);
	        String otherrates = num.format(otherpercentage1);
	        System.out.println("其他设备百分比："+otherrates);
	        model.addAttribute("switchrates",switchrates);
	        model.addAttribute("curtainsrates",curtainsrates);
	        model.addAttribute("socketrates",socketrates);
	        model.addAttribute("fresh_air_systemrates",fresh_air_systemrates);
	        model.addAttribute("otherrates",otherrates);
	        
	        DecimalFormat df = new DecimalFormat("0.00");//保留两位小数
	        String switchpercentage=df.format(switchpercentage1);
	        String curtainspercentage=df.format(curtainspercentage1);
	        String socketpercentage=df.format(socketpercentage1);
	        String fresh_air_systemppercentage=df.format(fresh_air_systempercentage1);
	        String otherpercentage=df.format(otherpercentage1);
	        
	     
	        
	        model.addAttribute("diviceAllCount2",diviceAllCount2);
	        model.addAttribute("switchpercentage",switchpercentage);
	        model.addAttribute("curtainspercentage",curtainspercentage);
	        model.addAttribute("socketpercentage",socketpercentage);
	        model.addAttribute("fresh_air_systemppercentage",fresh_air_systemppercentage);
	        model.addAttribute("otherpercentage",otherpercentage);
        
        
        System.out.println("开关设备总数："+switchcount);
        System.out.println("开关在线设备数量："+switchconnectCount);
        model.addAttribute("switchcount",switchcount);
        model.addAttribute("switchconnectCount",switchconnectCount);
        
        System.out.println("窗帘设备总数："+curtainscount);
        System.out.println("窗帘在线设备数量："+curtainsconnectCount);
        model.addAttribute("curtainscount",curtainscount);
        model.addAttribute("curtainsconnectCount",curtainsconnectCount);
        
        System.out.println("插座设备总数："+socketcount);
        System.out.println("插座在线设备数量："+socketconnectCount);
        model.addAttribute("socketcount",socketcount);
        model.addAttribute("socketconnectCount",socketconnectCount);
        
        System.out.println("新风系统设备总数："+fresh_air_systemcount);
        System.out.println("新风系统在线设备数量："+fresh_air_systemconnectCount);
        model.addAttribute("fresh_air_systemcount",fresh_air_systemcount);
        model.addAttribute("fresh_air_systemconnectCount",fresh_air_systemconnectCount);
        
        
        
        // 返回一个字符串 " Main" 作为视图名称
        return "Main";
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