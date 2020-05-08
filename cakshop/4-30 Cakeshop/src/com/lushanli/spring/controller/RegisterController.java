package com.lushanli.spring.controller;

import javax.servlet.http.HttpServletRequest;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
public class RegisterController {
	@RequestMapping(value="user_register")
		public String register(HttpServletRequest request) {
		return "user_register";
	}
}
