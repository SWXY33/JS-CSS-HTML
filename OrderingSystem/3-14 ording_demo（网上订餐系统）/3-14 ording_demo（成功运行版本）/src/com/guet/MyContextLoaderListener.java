package com.guet;

import java.io.IOException;
import java.io.InputStream;
import java.util.Properties;

import javax.servlet.ServletContextEvent;

import org.springframework.web.context.ContextLoaderListener;
public class MyContextLoaderListener extends ContextLoaderListener{

	@Override
	public void contextInitialized(ServletContextEvent arg0) {
		super.contextInitialized(arg0);
		Properties props = new Properties(); 
        InputStream inputStream = null; 
        try { 
            inputStream = getClass().getResourceAsStream("/serverconfig.properties"); 
            props.load(inputStream); 
            String ip = props.get("images_server_ip").toString();
            String port = props.get("images_server_port").toString();
            arg0.getServletContext().setAttribute("images_server_ip", ip);
            arg0.getServletContext().setAttribute("images_server_port", port);
        } catch (IOException ex) { 
            ex.printStackTrace(); 
        }
	}

}
