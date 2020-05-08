package com.lushanli.spring.controller;



import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import service.GoodsService;




@Controller
public class IndexController {
	 private GoodsService gService=new GoodsService();
	@RequestMapping(value="index")
		public String index(HttpServletRequest request) {
		Map<String,Object> ScrollGood=gService.getScrollGood();
        request.setAttribute("scroll",ScrollGood);

        List<Map<String,Object>>newList=gService.getGoodsList(3);
        request.setAttribute("newList",newList);

        List<Map<String,Object>>hotList=gService.getGoodsList(2);
        request.setAttribute("hotList",hotList);
		return "index";
	}
}
