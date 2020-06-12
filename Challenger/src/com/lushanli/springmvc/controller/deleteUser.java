package com.lushanli.springmvc.controller;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;

import com.mysql.jdbc.PreparedStatement;
import com.user.User;

@Controller
public class deleteUser {
	@RequestMapping(value="deleteUser")
    public String deleteuser(HttpServletRequest request,User u, HttpSession session,Model model) {
		String Id=request.getParameter("id");
		//声明Connection对象
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
		         try {
		            //加载驱动程序
		            Class.forName(driver);
		             //1.getConnection()方法，连接MySQL数据库！！
		             con = DriverManager.getConnection(url,user,password);
		             if(!con.isClosed())
		                 System.out.println("Succeeded connecting to the Database!");     
		
		
		PreparedStatement psql;

		//预处理删除数据

		psql = (PreparedStatement) con.prepareStatement("delete from login where id = ?");

		psql.setString(1, Id);

		psql.executeUpdate();

		psql.close();
		
		         }catch(ClassNotFoundException e) {   
			            //数据库驱动类异常处理
			             System.out.println("Sorry,can`t find the Driver!");   
			            e.printStackTrace();   
			             } catch(SQLException e) {
			            //数据库连接失败异常处理
			           e.printStackTrace();  
			             }catch (Exception e) {
			             // TODO: handle exception
			             e.printStackTrace();
			         }finally{
			             System.out.println("删除成功！！");
			         }
		         return "Main";
	}
	
}
