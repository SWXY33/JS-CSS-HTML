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
 * UserController ��һ������ע��Ŀ�����
 * ����ͬʱ������������
 */
@Controller
public class UserController {
    
    /**
    * RequestMapping ����ӳ��һ�����������ķ���
                *               ͨ��modelmap��ʽ
     * @throws ParseException 
    */
	@RequestMapping(value="/IP")
    public String QueryIP(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
		String json="{'ip':'','province':'','city':'','mac':''}";
		System.out.println("IPdata:" + json);
		model.addAttribute("IPData", json);//�����鴫�ݵ�ǰ̨
		return "QueryIP";
	}
	
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

        model.addAttribute("user",user);

    	
		//String Switchmac=request.getParameter("username");
		//model.addAttribute("username", Switchmac);
		//System.out.println(Switchmac);
        
        String switchUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceTypeCount?deviceType=switch";
        String curtainsUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceTypeCount?deviceType=curtains";
        String socketUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceTypeCount?deviceType=socket";
        String fresh_air_systemUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceTypeCount?deviceType=fresh_air_system";
//江门市的设备数量
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

	
		JSONObject switchdataObject  = switchobject.getJSONObject("data");
		JSONObject curtainsdataObject  = curtainsobject.getJSONObject("data");
		JSONObject socketdataObject  = socketobject.getJSONObject("data");
		JSONObject fresh_air_systemdataObject  = fresh_air_systemobject.getJSONObject("data");
		JSONObject divicenumobjectdataObject  = divicenumobject.getJSONObject("data");
       
        String switchcount = switchdataObject.getString("count");
        Integer switchCount=Integer.parseInt(switchcount);
        System.out.println("开关数量:"+switchCount);
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
        System.out.println("江门市的设备数量："+diviceCount);
        model.addAttribute("diviceCount",diviceCount);
        String  divicepercentage=divicenumobjectdataObject.getString("percentage");
        NumberFormat nf=NumberFormat.getPercentInstance();
        Number m;
		
			m = nf.parse(divicepercentage);//���ٷ���ת����Number����
			System.out.println("江门市的设备占比"+m);
	        double dd=m.doubleValue();//ͨ������nubmer��Ĭ�Ϸ���ֱ��ת����double
	        Double diviceAllCount1 =diviceCount/dd;
	        System.out.println(diviceAllCount1);
	        Integer diviceAllCount2=(int) Math.round(diviceAllCount1); //��������
	        System.out.println("设备总数："+diviceAllCount2);
	        double diviceAllCount=diviceAllCount2.doubleValue();
	        System.out.println("diviceAllCount："+diviceAllCount);
	        double switchpercentage1=switchCount/diviceAllCount;
	        System.out.println("switchpercentage1："+switchpercentage1);
	        double curtainspercentage1=curtainsCount/diviceAllCount;
	        System.out.println("curtainspercentage1："+curtainspercentage1);
	        double socketpercentage1=socketCount/diviceAllCount;
	        System.out.println("socketpercentage1："+socketpercentage1);
	        double fresh_air_systempercentage1=fresh_air_systemCount/diviceAllCount;
	        System.out.println("fresh_air_systempercentage1："+fresh_air_systempercentage1);
	        double otherpercentage1=1.00-switchpercentage1-curtainspercentage1-socketpercentage1-fresh_air_systempercentage1;
	        System.out.println("otherpercentage1："+otherpercentage1);
	        
	        int temp = (int)(switchpercentage1 * 1000);
	        switchpercentage1 = (double)temp / 10;
	        int temp1 = (int)(curtainspercentage1 * 1000);
	        curtainspercentage1 = (double)temp1 / 10;
	        int temp2 = (int)(socketpercentage1 * 1000);
	        socketpercentage1 = (double)temp2 / 10;
	        int temp3 = (int)(fresh_air_systempercentage1 * 1000);
	        fresh_air_systempercentage1 = (double)temp3/ 10;
	        int temp4 = (int)(otherpercentage1 * 1000);
	        otherpercentage1 = (double)temp4/ 10;
	        
	        System.out.println("switchpercentage1(double类型)："+switchpercentage1); 
	        String  switchrates = switchpercentage1+"%";
	        String  curtainsrates = curtainspercentage1+"%";
	        String  socketrates = socketpercentage1+"%";
	        String  fresh_air_systemrates = fresh_air_systempercentage1+"%";
	        String  otherrates = otherpercentage1+"%";
	       
	        System.out.println("开关占比："+switchrates);
	        System.out.println("窗帘占比："+curtainsrates);	 
	        System.out.println("插座占比："+socketrates);
	        System.out.println("新风系统占比："+fresh_air_systemrates);
	        System.out.println("其他占比："+otherrates);
	        model.addAttribute("switchrates",switchrates);
	        model.addAttribute("curtainsrates",curtainsrates);
	        model.addAttribute("socketrates",socketrates);
	        model.addAttribute("fresh_air_systemrates",fresh_air_systemrates);
	        model.addAttribute("otherrates",otherrates);
	        
	       // int tmp = (int)(switchpercentage1 * 10);
	        //switchpercentage1 = (double)tmp / 1000;
	        System.out.print("switchpercentage1(double类型):"+switchpercentage1);
	        int tmp = (int)(switchpercentage1 *10);
	         double switchpercentage11 = (double)tmp / 1000;
	         int tmp1 = (int)(curtainspercentage1 *10);
	         double curtainspercentage11 = (double)tmp1 / 1000;
	         int tmp2 = (int)(socketpercentage1 *10);
	         double socketpercentage11 = (double)tmp2 / 1000;
	         int tmp3 = (int)(fresh_air_systempercentage1 *10);
	         double fresh_air_systempercentage11 = (double)tmp3 / 1000;
	         int tmp4 = (int)(otherpercentage1 *10);
	         double otherpercentage11 = (double)tmp4 / 1000;
	         System.out.print("--------switchpercentage11---------"+switchpercentage11);	 
	        DecimalFormat df = new DecimalFormat("0.000");//������λС��
	        String switchpercentage=df.format(switchpercentage11);
	        System.out.print("-----------------"+switchpercentage);
	        String curtainspercentage=df.format(curtainspercentage11);
	        String socketpercentage=df.format(socketpercentage11);
	        String fresh_air_systemppercentage=df.format(fresh_air_systempercentage11);
	        String otherpercentage=df.format(otherpercentage11);
	        
	     
	        
	        model.addAttribute("diviceAllCount2",diviceAllCount2);
	        model.addAttribute("switchpercentage",switchpercentage);
	        model.addAttribute("curtainspercentage",curtainspercentage);
	        model.addAttribute("socketpercentage",socketpercentage);
	        model.addAttribute("fresh_air_systemppercentage",fresh_air_systemppercentage);
	        model.addAttribute("otherpercentage",otherpercentage);
        
        
        System.out.println("开关数量："+switchcount);
        System.out.println("开关在线数："+switchconnectCount);
        model.addAttribute("switchcount",switchcount);
        model.addAttribute("switchconnectCount",switchconnectCount);
        
        System.out.println("窗帘数量："+curtainscount);
        System.out.println("窗帘在线数："+curtainsconnectCount);
        model.addAttribute("curtainscount",curtainscount);
        model.addAttribute("curtainsconnectCount",curtainsconnectCount);
        
        System.out.println("插座数量："+socketcount);
        System.out.println("插座在线数量："+socketconnectCount);
        model.addAttribute("socketcount",socketcount);
        model.addAttribute("socketconnectCount",socketconnectCount);
        
        System.out.println("新风系统数量："+fresh_air_systemcount);
        System.out.println("新风系统在线数："+fresh_air_systemconnectCount);
        model.addAttribute("fresh_air_systemcount",fresh_air_systemcount);
        model.addAttribute("fresh_air_systemconnectCount",fresh_air_systemconnectCount);
        
        
        
        // ����һ���ַ��� " Main" ��Ϊ��ͼ����
        return "Main";
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