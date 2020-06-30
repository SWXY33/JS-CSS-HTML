package com.lushanli.springmvc.controller;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.UUID;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;

import com.mysql.jdbc.PreparedStatement;

import com.user.User;

@Controller
public class Register {
	@RequestMapping(value="register")
    public String register() {
	
		return "register";
	}
	@RequestMapping(value="add")//注册用户
	public String Add(HttpServletRequest request,User u, HttpSession session,Model model) {
		
			String id = UUID.randomUUID().toString().replaceAll("-", "");//随机生成id
			//id = id.substring(0,8);//截取下标0-7的值
			System.out.println(id);

		String Name=request.getParameter("registername");
		String Pwd=request.getParameter("registerpwd");
		String Job=request.getParameter("registerjob");
		System.out.print(Name+Pwd+Job);
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
				            

				            //预处理添加数据，其中有两个参数--“？”

				            psql = (PreparedStatement) con.prepareStatement("insert into login (id,loginname,job,password) "+ "values(?,?,?,?)");

				            psql.setString(1, id);              //设置参数1，创建id数据
				            psql.setString(2,Name );      //设置参数2，Name 
				            psql.setString(3, Pwd);
				            psql.setString(4, Job);
                            model.addAttribute("id",id);
                            model.addAttribute("name",Name);
                            model.addAttribute("pwd",Pwd);
                            model.addAttribute("job",Job);
				            psql.executeUpdate();           //执行更新
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
					             System.out.println("数据库数据添加成功！！");
					         }
					 
							return "home";
	}
	
	@RequestMapping(value="updateUser")
    public String updateUser(HttpServletRequest request,User u, HttpSession session,Model model) {
		String Id=request.getParameter("user_id");
		String Name=request.getParameter("Name");
		String Pwd=request.getParameter("Pwd");
		String Job=request.getParameter("Job");
		System.out.print(Id+Name+Pwd+Job);
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

		           //预处理更新（修改）数据

		           psql = (PreparedStatement) con.prepareStatement("update login set loginname= ?, password= ?, job = ? where id = ? ");
		           psql.setString(1,Name );  
		           psql.setString(2,Pwd );      
		           psql.setString(3,Job);   
		           psql.setString(4,Id);  
		           
		           model.addAttribute("id",Id);
                   model.addAttribute("name",Name);
                   model.addAttribute("pwd",Pwd);
                   model.addAttribute("job",Job);
		           psql.executeUpdate();

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
		             System.out.println("修改成功！！");
		         }
		 
		return "home";
	}
}
	
