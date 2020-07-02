package com.guet.utils;

import org.springframework.beans.BeansException;
import org.springframework.beans.factory.BeanFactory;
import org.springframework.beans.factory.BeanFactoryAware;
import org.springframework.stereotype.Component;


/**
 * Spring bean工具
 * */
@Component
public class SpringBeanFactoryUtils implements BeanFactoryAware {

	private static BeanFactory beanFactory = null;
	private static SpringBeanFactoryUtils factoryUtils = null;

	@Override
	public void setBeanFactory(BeanFactory beanFactory) throws BeansException {
		System.out.println("Spring IOC Utils Set BeanFactory OK.");
		SpringBeanFactoryUtils.beanFactory = beanFactory;
	}

	public static BeanFactory getBeanFactory() {
		return beanFactory;
	}

	public static SpringBeanFactoryUtils getInstance() {
		if (factoryUtils == null) {
			factoryUtils = new SpringBeanFactoryUtils();
		}
		return factoryUtils;
	}

	public static Object getBean(String name) {
		return beanFactory.getBean(name);
	}

}
