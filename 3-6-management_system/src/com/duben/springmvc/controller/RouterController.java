package com.duben.springmvc.controller;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
public class RouterController {
@RequestMapping(value="router")
	public String Router() {
	return "Router";
	}
}

