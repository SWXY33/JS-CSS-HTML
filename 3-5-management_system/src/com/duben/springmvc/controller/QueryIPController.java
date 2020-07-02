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
public class QueryIPController {
	@RequestMapping(value="/queryIP")
    public String queryIP(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
		String IpQuery=request.getParameter("queryip");
		String methodUrl="http://dubeniot.com:8080/iot-manager/query/getDeviceAddressVO?deviceMac=";
		String json=getdata(methodUrl+IpQuery);
		System.out.println("JSON�ַ�����" + json);
		
		JSONObject object = (JSONObject) JSONObject.parse(json);//���ַ����л�ȡ����
		JSONObject IPObj = (JSONObject)object.get("data");//�Ӷ����л�ȡ����
        System.out.println("IPdata��" + IPObj);
        
        model.addAttribute("IPData", IPObj);//�����鴫�ݵ�ǰ̨
		return "QueryIP";
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
