package com.lushanli.springmvc.controller;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;

import javax.servlet.http.HttpSession;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import com.mysql.jdbc.PreparedStatement;
import com.mysql.jdbc.Statement;
import com.user.User;

import oracle.sql.CLOB;

@Controller
public final class Login {
	@RequestMapping(value="Login")
    public String login(HttpServletRequest request,User u, HttpSession session,Model model) throws ClassNotFoundException, SQLException {
		String Loginname=request.getParameter("loginname");
		String Pwd=request.getParameter("pwd");
		System.out.println(Loginname+Pwd);
		QueryName_Pwd(Loginname,Pwd);
		System.out.println(QueryName_Pwd(Loginname,Pwd));
		//QueryByName(Loginname);
		System.out.println(QueryByName(Loginname));
		if(Loginname==null||Pwd==null) {
			System.out.println("用户名或密码为空，请重新输入！");
			model.addAttribute("msg","用户名或密码为空，请重新输入！");
			model.addAttribute("Array",0);
			return "index";
		}else if(QueryByName(Loginname).equals("0")){
			System.out.println("用户名不存在！");
			model.addAttribute("msg","用户名不存在！");
			model.addAttribute("Array",0);
			return "index";
		}else if(QueryByName(Loginname).equals("1")&&QueryName_Pwd(Loginname,Pwd).equals("0")) {
			System.out.println("密码错误，请重新输入！");
			model.addAttribute("msg","密码错误，请重新输入！");
			model.addAttribute("Array",0);
			return "index";
		}else if(QueryByName(Loginname).equals("1")&&QueryName_Pwd(Loginname,Pwd).equals("1")) {
			Connection con;
		       //驱动程序名
			       String driver = "com.mysql.jdbc.Driver";
		        //URL指向要访问的数据库名
			        String url = "jdbc:mysql://localhost/test?useUnicode=true&characterEncoding=UTF-8";
			        //MySQL配置时的用户名
			         String user = "root";
			         //MySQL配置时的密码
		         String password = "root";
		       //遍历查询结果集
			         
			            //加载驱动程序
			            Class.forName(driver);
			             //1.getConnection()方法，连接MySQL数据库！！
			             con = DriverManager.getConnection(url,user,password);
			             if(!con.isClosed())
			                 System.out.println("Succeeded connecting to the Database!");
			             String sql = "select * from login where loginname='"+Loginname+"'";
			             //3.ResultSet类，用来存放获取的结果集！！
			            Statement statement1 = (Statement) con.createStatement();
			           ResultSet rs = statement1.executeQuery(sql);
			           ResultSetMetaData md = rs.getMetaData();//得到结果集(rs)的结构，比如字段数、字段名等。//获取键名
			           int num = rs.getMetaData().getColumnCount();//取得列数
			           String pwd1=null;
			           ArrayList list = new ArrayList();
			        	Map rowData;
			         if(rs.next()) {
			        	 rowData = new HashMap(num);//声明Map
			 	    	for(int i = 1; i <= num; i++)   {	 	    		
			 	    		Object v = rs.getObject(i);
			 	    		System.out.println("第"+i+"个字段是："+v);
			 	    		//System.out.print("v.getClass()---------1:"+v.getClass());
			 	    		//System.out.print("...........................java.util.Date.class-----------2:"+java.util.Date.class+"***************");
			 	    		if(v != null && (v.getClass() == java.util.Date.class || v.getClass() == java.sql.Date.class)){//java.util.Date类用于描述日期信息：年月日时分秒，可以精确到毫秒。getClass(）返回Class类型的对象。
			 	    			Timestamp ts= rs.getTimestamp(i);
			 	    			System.out.println("ts："+ts);
			 	    			v = new java.util.Date(ts.getTime());
			 	    			System.out.println("v："+v);
			 	    		}else if(v != null && v.getClass() == CLOB.class){
			 	    			v = "v != null && v.getClass() == CLOB.class";
			 	    		}
			 	    		rowData.put(md.getColumnName(i),v);//获取键名及值
			 	    		System.out.println("rowData："+rowData);
			 	    	}
			 	    	list.add(rowData);	
			 	    	System.out.println("list："+list);
			 	    	String json1= JSON.toJSONString(list);//转化成JSON
			 	    	System.out.println("json1："+json1);
			 	    	model.addAttribute("Array",json1);
			         }
		System.out.println("验证通过！");
		model.addAttribute("msg","succese");
		return "Main";
		}else {
			System.out.println("用户名或密码有误，请重新输入！");
			model.addAttribute("msg","用户名或密码有误，请重新输入！");
			return "index";
		}
		

	}
	
	
	String QueryByName(String a) throws ClassNotFoundException, SQLException {
		Connection con;
	       //驱动程序名
		       String driver = "com.mysql.jdbc.Driver";
	        //URL指向要访问的数据库名
		        String url = "jdbc:mysql://localhost/test?useUnicode=true&characterEncoding=UTF-8";
		        //MySQL配置时的用户名
		         String user = "root";
		         //MySQL配置时的密码
	         String password = "root";
	       //遍历查询结果集
		         
		            //加载驱动程序
		            Class.forName(driver);
		             //1.getConnection()方法，连接MySQL数据库！！
		             con = DriverManager.getConnection(url,user,password);
		             if(!con.isClosed())
		                 System.out.println("Succeeded connecting to the Database!");
		             String sql = "select * from login where loginname='"+a+"'";
		             //3.ResultSet类，用来存放获取的结果集！！
		            Statement statement1 = (Statement) con.createStatement();
		           ResultSet rs = statement1.executeQuery(sql);
		         if(rs.next()) {
		        	 System.out.println(rs.next());
		        	 return "1";
		         }   
		         System.out.println(rs.next());
		return "0";
	}
	String QueryName_Pwd(String name,String pwd) throws ClassNotFoundException, SQLException{
		Connection con;
	       //驱动程序名
		       String driver = "com.mysql.jdbc.Driver";
	        //URL指向要访问的数据库名
		        String url = "jdbc:mysql://localhost/test?useUnicode=true&characterEncoding=UTF-8";
		        //MySQL配置时的用户名
		         String user = "root";
		         //MySQL配置时的密码
	         String password = "root";
	       //遍历查询结果集
		         
		            //加载驱动程序
		            Class.forName(driver);
		             //1.getConnection()方法，连接MySQL数据库！！
		             con = DriverManager.getConnection(url,user,password);
		             if(!con.isClosed())
		                 System.out.println("Succeeded connecting to the Database!");
		             String sql = "select * from login where loginname='"+name+"'";
		             //3.ResultSet类，用来存放获取的结果集！！
		            Statement statement1 = (Statement) con.createStatement();
		            System.out.println("statement1-------"+statement1);
		           ResultSet rs = statement1.executeQuery(sql);
		           System.out.println("rs********"+rs);
		           ResultSetMetaData md = rs.getMetaData();//得到结果集(rs)的结构，比如字段数、字段名等。//获取键名
		           System.out.println("md............."+md);
		           int num = rs.getMetaData().getColumnCount();//取得列数
		           System.out.println("num-----------"+num);
		           String pwd1=null;
		           ArrayList list = new ArrayList();
		        	Map rowData;
		         if(rs.next()) {
		        	 rowData = new HashMap(num);//声明Map
		 	    	for(int i = 1; i <= num; i++)   {	 	    		
		 	    		Object v = rs.getObject(i);
		 	    		System.out.println("第"+i+"个字段是："+v);
		 	    		//System.out.print("v.getClass()---------1:"+v.getClass());
		 	    		//System.out.print("...........................java.util.Date.class-----------2:"+java.util.Date.class+"***************");
		 	    		if(v != null && (v.getClass() == java.util.Date.class || v.getClass() == java.sql.Date.class)){//java.util.Date类用于描述日期信息：年月日时分秒，可以精确到毫秒。getClass(）返回Class类型的对象。
		 	    			Timestamp ts= rs.getTimestamp(i);
		 	    			System.out.println("ts："+ts);
		 	    			v = new java.util.Date(ts.getTime());
		 	    			System.out.println("v："+v);
		 	    		}else if(v != null && v.getClass() == CLOB.class){
		 	    			v = "v != null && v.getClass() == CLOB.class";
		 	    		}
		 	    		rowData.put(md.getColumnName(i),v);//获取键名及值
		 	    		System.out.println("rowData："+rowData);
		 	    	}
		 	    	list.add(rowData);	
		 	    	System.out.println("list："+list);
		 	    	String json1= JSON.toJSONString(list);//转化成JSON
		 	    	JSONArray array=(JSONArray) JSONObject.parse(json1);
		 	    	 
		    		System.out.println("array："+array);
		    		 pwd1 = array.getJSONObject(0).getString("password");
		    		System.out.println("pwd1："+pwd1);
		    		if(pwd1.equals(pwd)) {
		    			return "1";
		    		}
		    		else {
		    			return "0";
		    		}

		         }
		 

		return "0";
		
	}
			

}
