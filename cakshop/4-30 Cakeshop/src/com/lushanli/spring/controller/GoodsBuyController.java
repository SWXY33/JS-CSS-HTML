package com.lushanli.spring.controller;

import java.io.IOException;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import model.Goods;
import model.Order;
import service.GoodsService;

@Controller
public class GoodsBuyController {
	private GoodsService gService = new GoodsService();
	@RequestMapping(value="goods_buy")
	public String goods_buy(HttpServletRequest request,HttpServletResponse response) throws IOException {
		Order o = null;
        if(request.getSession().getAttribute("order") != null) {
            o = (Order) request.getSession().getAttribute("order");
        }else {
            o = new Order();
            request.getSession().setAttribute("order", o);
        }
        int goodsid = Integer.parseInt(request.getParameter("goodsid"));
        Goods goods = gService.getGoodsById(goodsid);
        if(goods.getStock()>0) {
            o.addGoods(goods);
            response.getWriter().print("ok");
        }else {
            response.getWriter().print("fail");
        }
	return "goods_detail";
}
}