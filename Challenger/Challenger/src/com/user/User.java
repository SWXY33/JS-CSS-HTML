package com.user;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;


import com.mysql.jdbc.Statement;

public class User {

	public static void main(String[] args) {
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
		             //2.创建statement类对象，用来执行SQL语句！！
	            Statement statement = (Statement) con.createStatement();
		            
	            //要执行的SQL语句
		            String sql = "select * from login";
	             //3.ResultSet类，用来存放获取的结果集！！
	           ResultSet rs = statement.executeQuery(sql);
		             System.out.println("-----------------");
		             System.out.println("执行结果如下所示:");  
		             System.out.println("-----------------");  
		            System.out.println("-----------------");  
		            System.out.println("id"+ "----" + "用户名" + "-----" + "密码" + "-----" + "职务");
	             String job = null;
		         String id = null;
		         String name=null;
		         String pwd=null;
		         
	             while(rs.next()){
	                 //获取job这列数据
		                job = rs.getString("job");
		                //获取id这列数据
		                id = rs.getString("id");
		                name= rs.getString("loginname");
		                pwd= rs.getString("password");
		                //输出结果
		                
		                System.out.println(id + "\t" + name+ "\t" +pwd+ "\t" +job);
		             }
		            rs.close();
		            con.close();
		            

		         } catch(ClassNotFoundException e) {   
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
		             System.out.println("数据库数据成功获取！！");
		         }
		     }
}


