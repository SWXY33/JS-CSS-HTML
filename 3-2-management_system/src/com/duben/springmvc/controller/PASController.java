package com.duben.springmvc.controller;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
public class PASController {
@RequestMapping(value="PAS")
	public String PAS() {
	return "PAS";
	}
}

