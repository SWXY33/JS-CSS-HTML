package com.lushanli.spring.controller;

import javax.servlet.http.HttpServletRequest;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
public class GoodsSearchController {
	@RequestMapping(value="goods_search")
	public String goods_search(HttpServletRequest request) {
	return "goods_search";
}
}