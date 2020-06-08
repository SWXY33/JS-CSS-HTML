package com.lushanli.findcontroller;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;

import java.net.MalformedURLException;

import java.net.URL;
import java.net.URLConnection;
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
import java.util.Map;
import java.util.UUID;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.servlet.http.HttpServletRequest;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONException;
import com.alibaba.fastjson.JSONObject;
import com.mysql.jdbc.PreparedStatement;
import com.mysql.jdbc.Statement;

import oracle.sql.CLOB;
@Controller
public class Find {
	/**
	 * 获取城市信息
	 * 
	 * @param ip
	 * @return
	 * @throws JSONException
	 * @throws IOException
	 */
	@SuppressWarnings({ "unchecked", "rawtypes" })
	@RequestMapping(value="more")
	String More(Model model,HttpServletRequest request)  {
		String ip=request.getParameter("ip");
		String json=getdata("http://freeapi.ipip.net/"+ip); 

		
		Calendar c = Calendar.getInstance();  
        c.setTimeInMillis(new Date().getTime());  
        SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");  
        System.out.println(dateFormat.format(c.getTime())); 
        model.addAttribute("time",dateFormat.format(c.getTime()));
		System.out.println(json);
		JSONArray jsonArray =JSONObject.parseArray(json);
		Object country = jsonArray.get(0); 
	
		Object province = jsonArray.get(1); 
		Object city = jsonArray.get(2); 
		Object xian = jsonArray.get(3); 
		Object net = jsonArray.get(4); 
		String country1=country.toString();
		String province1=province.toString();
		String city1=city.toString();
		String net1=net.toString();
		//声明Connection对象
				Connection con;
			       //驱动程序名
				       String driver = "com.mysql.jdbc.Driver";
			        //URL指向要访问的数据库名
				        String url = "jdbc:mysql://localhost/find_you?useUnicode=true&characterEncoding=UTF-8";
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
				             PreparedStatement psql1;
				             
				             
				    		 String uuid = UUID.randomUUID().toString().replaceAll("-", "");//随机生成id
				               psql1 = (PreparedStatement) con.prepareStatement("insert into user_inf (tb_id,user_ip,create_time,country,province,city,net) "+ "values(?,?,?,?,?,?,?)");

				               psql1.setString(1, uuid);              //设置参数1，创建id数据
				               psql1.setString(2,ip );      //设置参数2，user_ip
				               psql1.setString(3, dateFormat.format(c.getTime()));
				               psql1.setString(4, country1);
				               psql1.setString(5, province1);
				               psql1.setString(6, city1);
				               psql1.setString(7, net1);
				            
				            
				               psql1.executeUpdate();           //执行更新
				           //要执行的SQL语句
				             String sql = "select * from user_inf";
				          //3.ResultSet类，用来存放获取的结果集！！
				         Statement statement1 = (Statement) con.createStatement();
				        ResultSet rs = statement1.executeQuery(sql);
				        ResultSetMetaData md = rs.getMetaData();//得到结果集(rs)的结构，比如字段数、字段名等。//获取键名
				        int num = rs.getMetaData().getColumnCount();//取得列数
				        ArrayList list = new ArrayList();
				     	Map rowData;
				         while(rs.next()){//判断是否存在下一个数据
				        
				                rowData = new HashMap(num);//声明Map
				     	    	for(int i = 1; i <= num; i++)   {	 	    		
				     	    		Object v = rs.getObject(i);
				     	    		//System.out.println("第"+i+"个字段是："+v);
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
				     	    		//System.out.println("rowData："+rowData);
				     	    	}
				     	    	list.add(rowData);	
				     	    	//System.out.println("list："+list);
				     	    	String json1= JSON.toJSONString(list);//转化成JSON数组
				        		//System.out.println("json1："+json1);
				     	    	model.addAttribute("Array",json1);
				         }
				       
				         
		model.addAttribute("net",net);
		model.addAttribute("country",country);
		model.addAttribute("province",province);
		model.addAttribute("city",city);
		model.addAttribute("xian",xian);
		System.out.println("country:"+country);
		System.out.println("province:"+province);
		System.out.println("city:"+city);
		System.out.println("xian:"+xian);
		System.out.println(ip);
		System.out.println("********************************************************************************************");
		

		String ua = request.getHeader("User-Agent").toLowerCase();
		String deviceType = this.check(ua) ? "mobile" : "pc";
		String deviceName = this.getDeviceName(ua);
		System.out.println("deviceType--------------------"+deviceType);
		System.out.println("deviceName--------------------"+deviceName);
		model.addAttribute("deviceName",deviceName);
	
	/**

        
        Sigar sigar = new Sigar();

        String ip1 = "";
           try {
               for (Enumeration<NetworkInterface> en = NetworkInterface.getNetworkInterfaces(); en.hasMoreElements();) {
                   NetworkInterface intf = en.nextElement();
                   String name = intf.getName();
                   if (!name.contains("docker") && !name.contains("lo")) {
                       for (Enumeration<InetAddress> enumIpAddr = intf.getInetAddresses(); enumIpAddr.hasMoreElements();) {
                           InetAddress inetAddress = enumIpAddr.nextElement();
                           if (!inetAddress.isLoopbackAddress()) {
                               String ipaddress = inetAddress.getHostAddress().toString();
                               if (!ipaddress.contains("::") && !ipaddress.contains("0:0:") && !ipaddress.contains("fe80")) {
                                   ip1 = ipaddress;
                               }
                           }
                       }
                   }
               }
           } catch (SocketException ex) {
               ip1 = "127.0.0.1";
               ex.printStackTrace();
           }
           
       String[] netInterfaceList = sigar.getNetInterfaceList();

       double rxBytes = 0;
       double txBytes = 0;
       String description = null;
       // 一些其它的信息
       for (int i = 0; i < netInterfaceList.length; i++) {
           String netInterface = netInterfaceList[i];// 网络接口
           NetInterfaceConfig netInterfaceConfig = sigar.getNetInterfaceConfig(netInterface);
           
            if (netInterfaceConfig.getAddress().equals(ip1)) {
                
                    description =  netInterfaceConfig.getDescription();
                    
                    System.out.println("网卡描述信息 ======="+description);
                    double start = System.currentTimeMillis();
                   NetInterfaceStat statStart = sigar.getNetInterfaceStat(netInterface);
                   double rxBytesStart = statStart.getRxBytes();
                   double txBytesStart = statStart.getTxBytes();
                   
                   Thread.sleep(1000);
                   double end = System.currentTimeMillis();
                   NetInterfaceStat statEnd = sigar.getNetInterfaceStat(netInterface);
                   double rxBytesEnd = statEnd.getRxBytes();
                   double txBytesEnd = statEnd.getTxBytes();

                   rxBytes = ((rxBytesEnd - rxBytesStart)*8/(end-start)*1000)/1024;
                   txBytes = ((txBytesEnd - txBytesStart)*8/(end-start)*1000)/1024;
                  
                   break;
               }
            
           // 判断网卡信息中是否包含VMware即虚拟机，不存在则设置为返回值
           //System.out.println("网卡MAC地址 ======="+netInterfaceConfig.getHwaddr());

       }
       // 接收字节
       String rxBytess;
       // 发送字节
       String txBytess;
       
        if(rxBytes>1024) { 
            rxBytess = String.format("%.1f", rxBytes/1024)+" Mbps";
       }else {
           rxBytess = String.format("%.0f", rxBytes)+" Kbps";
       }
       if(txBytes>1024) {
           txBytess = String.format("%.1f", txBytes/1024)+" Mbps" ;
       }else {
           txBytess=String.format("%.0f", txBytes)+" Kbps";
       }
       
       System.out.println("发送======="+rxBytess);
       System.out.println("接收======="+txBytess);
       System.out.println("IP======="+ip);
       
       // 关闭sigar
       sigar.close();**/

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
					             System.out.println("成功！！");
					         }
		return "more";
		
	}
	@RequestMapping(value="Findyou")
	String findyou(Model model)  {
String json1=getdata("http://pv.sohu.com/cityjson?ie=utf-8");
//JSONArray jsonArray1 =JSONObject.parseArray(json1);
System.out.println(json1);

model.addAttribute("inf",json1);
		
		
		return "welcome";
			
	}
	
	private static String getdata(String url){
		StringBuilder json = new StringBuilder();
		try {
		URL urlObject = new URL(url);
		URLConnection uc = urlObject.openConnection();
		BufferedReader in = new BufferedReader(new InputStreamReader(uc.getInputStream(), "utf-8"));
		String inputLine = null;
		while ((inputLine = in.readLine()) != null) {
		json.append(inputLine);
		}
		in.close();
		} catch (MalformedURLException e) {
		e.printStackTrace();
		} catch (IOException e) {
		e.printStackTrace();
		}
		
		return json.toString();
	}
	// \b 是单词边界(连着的两个(字母字符 与 非字母字符) 之间的逻辑上的间隔),
	// 字符串在编译时会被转码一次,所以是 "\\b"
	// \B 是单词内部逻辑间隔(连着的两个字母字符之间的逻辑上的间隔)
	static String phoneReg = "\\b(ip(hone|od)|android|opera m(ob|in)i" + "|windows (phone|ce)|blackberry" + "|s(ymbian|eries60|amsung)|p(laybook|alm|rofile/midp"
			+ "|laystation portable)|nokia|fennec|htc[-_]" + "|mobile|up.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\\b";
	static String tableReg = "\\b(ipad|tablet|(Nexus 7)|up.browser" + "|[1-4][0-9]{2}x[1-4][0-9]{2})\\b";
 
	// 移动设备正则匹配：手机端、平板
	static Pattern phonePat = Pattern.compile(phoneReg, Pattern.CASE_INSENSITIVE);
	static Pattern tablePat = Pattern.compile(tableReg, Pattern.CASE_INSENSITIVE);
 
	/**
	 * 检测是否是移动设备访问
	 * 
	 * @Title: check
	 * @Date : 2020-3-26
	 * @param userAgent
	 *            浏览器标识
	 * @return true:移动设备接入，false:pc端接入
	 */
	protected boolean check(String userAgent) {
		if (null == userAgent) {
			userAgent = "";
		}
		// 匹配
		Matcher matcherPhone = phonePat.matcher(userAgent);
		Matcher matcherTable = tablePat.matcher(userAgent);
		if (matcherPhone.find() || matcherTable.find()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取设备名称
	 * @param userAgent
	 * @return
	 */
	protected String getDeviceName(String userAgent) {
		if (null == userAgent) {
			userAgent = "";
		}
		// 匹配
		Matcher matcherPhone = phonePat.matcher(userAgent);
		Matcher matcherTable = tablePat.matcher(userAgent);
		if (matcherPhone.find()) {
			return matcherPhone.group();
		} else if (matcherTable.find()) {
			return matcherTable.group();
		} else {
			return "pc";
		}
	}
	
}
