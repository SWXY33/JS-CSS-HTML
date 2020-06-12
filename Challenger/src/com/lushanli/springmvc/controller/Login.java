package com.lushanli.springmvc.controller;

import javax.servlet.http.HttpServletRequest;

import javax.servlet.http.HttpSession;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

import com.user.User;

@Controller
public final class Login {
	@RequestMapping(value="Login",method= RequestMethod.POST)
    public String login(HttpServletRequest request,User u, HttpSession session,Model model) {
		String Loginname=request.getParameter("loginname");
		String Pwd=request.getParameter("pwd");
		
		if(Loginname!=null&&Loginname.equals("admin")&&Pwd!=null&&Pwd.equals("admin")) {
			System.out.println(Loginname+Pwd);
		}
		model.addAttribute("msg","用户名或密码错误，请重新登录！");
	
		

		
		
		
		return "Main";
		
	}
}
