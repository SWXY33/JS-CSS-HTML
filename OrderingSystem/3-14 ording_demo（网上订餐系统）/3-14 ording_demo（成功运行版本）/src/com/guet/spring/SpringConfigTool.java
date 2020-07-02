package com.guet.spring;

import org.springframework.beans.BeansException;
import org.springframework.context.ApplicationContext;
import org.springframework.context.ApplicationContextAware;

/**
 * @author H
 * 用于普通的java类获取spring的bean配置
 */
public class SpringConfigTool implements ApplicationContextAware {

	private static ApplicationContext context = null;
	private static SpringConfigTool stools = null;

	public synchronized static SpringConfigTool init() {
		if (stools == null) {
			stools = new SpringConfigTool();
		}
		return stools;
	}

	public void setApplicationContext(ApplicationContext applicationContext)
			throws BeansException {
		context = applicationContext;
	}

	public synchronized static Object getBean(String beanName) {
		return context.getBean(beanName);
	}
}
