package com.lushanli.spring.controller;

import javax.servlet.http.HttpServletRequest;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
public class GoodsCartController {
	@RequestMapping(value="goods_cart")
	public String goods_cart(HttpServletRequest request) {
	return "goods_cart";
}
}

