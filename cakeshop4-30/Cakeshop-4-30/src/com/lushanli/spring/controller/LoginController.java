package com.lushanli.spring.controller;



import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import model.User;
import service.UserService;

@Controller
public class LoginController {
	@RequestMapping(value="user_login")
		public String login() {
		return "user_login";
	}
	private UserService uService = new UserService();
	@RequestMapping(value="login")
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		
        String ue = request.getParameter("ue");
        String password = request.getParameter("password");
        User user = uService.login(ue, password);
        if(user==null) {
            request.setAttribute("failMsg", "用户名、邮箱或者密码错误，请重新登录！");
            request.getRequestDispatcher("user_login").forward(request, response);
        }else {
            request.getSession().setAttribute("user", user);
            request.getRequestDispatcher("user_center").forward(request, response);
        }
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {

    }
    @RequestMapping(value="user_center")
	public String user_center() {
	return "user_center";
}  

}
