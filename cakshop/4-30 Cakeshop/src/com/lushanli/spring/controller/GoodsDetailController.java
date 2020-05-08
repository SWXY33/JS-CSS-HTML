package com.lushanli.spring.controller;

import javax.servlet.http.HttpServletRequest;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import model.Goods;
import service.GoodsService;

@Controller

public class GoodsDetailController {
	private GoodsService gService = new GoodsService();
	@RequestMapping(value="goods_detail")
	public String goods_detail(HttpServletRequest request) {
		int id = Integer.parseInt(request.getParameter("id"));
        Goods g = gService.getGoodsById(id);
        request.setAttribute("g", g);
        System.out.println(g);
	return "goods_detail";
}
}