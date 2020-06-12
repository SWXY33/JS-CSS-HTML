package com.lushanli.springmvc.controller;


import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.UUID;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;
import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import com.mysql.jdbc.PreparedStatement;
import com.mysql.jdbc.Statement;
import com.user.Allusers;
import com.user.User;

import net.sf.json.JSONSerializer;
import oracle.sql.CLOB;

@Controller
public class QueryUser {
	@RequestMapping(value="chaxun")
    public String Queryuser(HttpServletRequest request,HttpServletResponse response,HttpSession session,Model model) {
		Calendar c = Calendar.getInstance();  
        c.setTimeInMillis(new Date().getTime());  
        SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");  
        String uuid = UUID.randomUUID().toString().replaceAll("-", "");//随机生成id
        
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
		             //2.创建statement类对象，用来执行SQL语句！！
		             PreparedStatement psql1;
		             //预处理添加数据，其中有两个参数--“？”

		             psql1 = (PreparedStatement) con.prepareStatement("insert into oprate (oprate_id,user_id,oprate_time,state,user_name,user_pwd,user_job) "+ "values(?,?,?,?,?,?,?)");

		             psql1.setString(1, uuid);              //设置参数1，创建id数据
		             psql1.setString(2,"all" );      //设置参数2，Name 
		             psql1.setString(3, dateFormat.format(c.getTime()));
		             psql1.setString(4, "query");
		             psql1.setString(5, "all");
		             psql1.setString(6, "all");
		             psql1.setString(7, "all");
		          
		             psql1.executeUpdate();           //执行更新
		             
		             
		             
		             
	            Statement statement = (Statement) con.createStatement();
		            
	            //要执行的SQL语句
		            String sql = "select * from login";
	             //3.ResultSet类，用来存放获取的结果集！！
	           ResultSet rs = statement.executeQuery(sql);
	           ResultSetMetaData md = rs.getMetaData();//得到结果集(rs)的结构，比如字段数、字段名等。//获取键名
	         //使用rs.getMetaData().getTableName(1))就可以返回表名
	           int num = rs.getMetaData().getColumnCount();//取得列数
	           System.out.println("rs的地址是：-----------------"+rs);
	           System.out.println("num的值是：-----------------"+num);
		             System.out.println("-----------------");
		             System.out.println("执行结果如下所示:");  
		             System.out.println("-----------------");  
		            System.out.println("-----------------");  
		            
	             String job = null;
		         String id = null;
		         String name=null;
		         String pwd=null;
		         ArrayList list = new ArrayList();
		 		Map rowData;
	             while(rs.next()){//判断是否存在下一个数据
	            	 
	                 //获取job这列数据
		               job = rs.getString("job");
		                //获取id这列数据
		                id = rs.getString("id");
		                name= rs.getString("loginname");
		                pwd= rs.getString("password");
		                //输出结果
		                User u = new User();
		                u.setId(id);
		                u.setJob(job);
		                u.setLoginname(name);
		                u.setPassword(pwd);
		                
		                String json= JSON.toJSONString(u);
		                System.out.println("u的实体："+json);
		                
		                
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
		    	    	String json1= JSON.toJSONString(list);//转化成JSON数组
	    	    		System.out.println("json1："+json1);
		    	    	model.addAttribute("Array",json1);


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
		
		
		return "Main";		
	}

}
