package com.lushanli.spring.controller;

import javax.servlet.http.HttpServletRequest;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
public class Goodsrecommend_listController {
	@RequestMapping(value="goodsrecommend_list")
	public String goodsrecommend_list(HttpServletRequest request) {
	return "goodsrecommend_list";
}
}
