package com.guet.utils;

import javax.servlet.ServletContext;

import org.apache.cxf.frontend.ClientProxy;
import org.apache.cxf.transport.Conduit;
import org.apache.cxf.transport.http.HTTPConduit;
import org.apache.cxf.transports.http.configuration.HTTPClientPolicy;
import org.springframework.context.ApplicationContext;
import org.springframework.web.context.WebApplicationContext;
import org.springframework.web.context.support.WebApplicationContextUtils;

/**
 * @author X
 * webservice 工具类
 */
public class WebserviceUtils {

	/**
	 * 设置webservice接口的超时时限
	 * 该方法主要用于对某些耗时超过60秒的接口超时时限进行重设置
	 * @param beanName 服务名
	 * @param receiveTimeout 数据接收超时时限  单位：秒
	 * @param connectionTimeout 接口连接超时时限  单位：秒
	 * @return
	 */
	public static Object recieveTimeOutWrapper(String beanName,int receiveTimeout,int connectionTimeout){
		if(StringUtils.isInvalid(beanName)){
			return null;
		}
		if(receiveTimeout <= 0){
			receiveTimeout = 60;
		}
		if(connectionTimeout <= 0){
			connectionTimeout = 5;
		}
		ApplicationContext appContext = WebApplicationContextUtils.getWebApplicationContext(XWorkUtil.getServletContext());
		Object obj = appContext.getBean(beanName);
        Conduit conduit = (ClientProxy.getClient(obj).getConduit());  
        HTTPConduit hc = (HTTPConduit)conduit;  
        HTTPClientPolicy client = new HTTPClientPolicy();  
        client.setReceiveTimeout(1000 * receiveTimeout); // 该时间为响应超时。  
        client.setConnectionTimeout(1000 * connectionTimeout); // 5秒的连接超时。  
        hc.setClient(client);  
        return obj;
    } 
	
	/**
	 * 获取webservice接口
	 * 该方法主要用于对某些耗时超过60秒的接口超时时限进行重设置
	 * @param beanName 服务名
	 * @return
	 */
	public static Object getBean(String beanName){
		if(StringUtils.isInvalid(beanName)){
			return null;
		}
		ApplicationContext appContext = WebApplicationContextUtils.getWebApplicationContext(XWorkUtil.getServletContext());
		Object obj = appContext.getBean(beanName);
        return obj;
    }
	
	/**
	 * servlet中获取webservice接口
	 * 该方法主要用于对某些耗时超过60秒的接口超时时限进行重设置
	 * @param beanName 服务名
	 * @return
	 */
	public static Object getBeanForServlet(String beanName,ServletContext servletContext){
		if(StringUtils.isInvalid(beanName)){
			return null;
		}
		WebApplicationContext appContext = WebApplicationContextUtils.getWebApplicationContext(servletContext);
		Object obj = appContext.getBean(beanName);
        return obj;
    }
}
