package com.duben.springmvc.controller;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
@Controller
public class OperationLogController {

	
	@RequestMapping(value="/operationlog")
    public String OperationLog() {
		return "OperationLog";
}
}
