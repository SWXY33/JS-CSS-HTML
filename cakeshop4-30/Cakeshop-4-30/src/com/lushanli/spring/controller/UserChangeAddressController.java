package com.lushanli.spring.controller;

import java.io.IOException;
import java.lang.reflect.InvocationTargetException;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.beanutils.BeanUtils;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import model.User;
import service.UserService;

@Controller
public class UserChangeAddressController {
	 private UserService uService = new UserService();
	@RequestMapping(value="user_changeaddress")
	    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {

	        User loginUser = (User) request.getSession().getAttribute("user");
	        System.out.println(loginUser);
	        try {
	        	System.out.println("11"+request.getParameterMap());//request.getParameterMap()方法可以获取到从前端请求发送的参数Map。
	        	BeanUtils.populate(loginUser, request.getParameterMap());//封装请求参数
	        	System.out.println(loginUser.toString());
	        } catch (IllegalAccessException e) { 
	            // TODO Auto-generated catch block
	            e.printStackTrace();
	        } catch (InvocationTargetException e) {
	            // TODO Auto-generated catch block
	            e.printStackTrace();
	        }
	        
	        System.out.println(loginUser);
	        uService.updateUserAddress(loginUser);
	        request.setAttribute("msg", "收件信息更新成功！");
	        request.getRequestDispatcher("user_center").forward(request, response);
	    }

	    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {

	    }

	
	
	
	
	}


