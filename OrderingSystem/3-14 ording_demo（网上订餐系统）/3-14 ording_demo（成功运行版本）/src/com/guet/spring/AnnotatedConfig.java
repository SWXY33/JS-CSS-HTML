package com.guet.spring;

import java.util.ArrayList;
import java.util.List;

/**
 * 用于分发实体对象类型的配置。一个比较愉快的事情是它可以支持java config。<br>
 * 只需这样继承这个类，然后在构造函数中如下:<br>
 * addClass(entityClass1);<br>
 * addClass(entityClass2);<br>
 * ......<br>
 * 效果和直接在bean工厂中注册是完全一样的。
 * 
 * @author X
 */
public class AnnotatedConfig {
	private List<Class<?>> annotatedClasses;

	private List<String> annotatedPackages;

	public List<Class<?>> getAnnotatedClasses() {
		return annotatedClasses;
	}

	public void setAnnotatedClasses(List<Class<?>> annotatedClasses) {
		if (this.annotatedClasses == null) {
			this.annotatedClasses = new ArrayList<Class<?>>();
		}
		this.annotatedClasses.addAll(annotatedClasses);
	}

	public List<String> getAnnotatedPackages() {
		return annotatedPackages;
	}

	public void setAnnotatedPackages(List<String> annotatedPackages) {
		this.annotatedPackages = annotatedPackages;
	}

	/**
	 * 注册实体类
	 * 
	 * @param annotatedClass
	 * @return
	 */
	public AnnotatedConfig addClass(Class<?> annotatedClass) {
		if (annotatedClasses == null) {
			annotatedClasses = new ArrayList<Class<?>>();
		}
		if (annotatedClasses.contains(annotatedClass)) {
			throw new RuntimeException("重复注册实体类型:" + annotatedClass); //$NON-NLS-1$
		}
		this.annotatedClasses.add(new HibernateEntityChecker()
				.checkEntity(annotatedClass));
		return this;
	}

	/**
	 * 注册实体类
	 * 
	 * @param annotatedClass
	 * @return
	 */
	public AnnotatedConfig addClass(Class<?>... annotatedClasses) {
		for (int i = 0; i < annotatedClasses.length; i++) {
			addClass(annotatedClasses[i]);
		}
		return this;
	}
}
