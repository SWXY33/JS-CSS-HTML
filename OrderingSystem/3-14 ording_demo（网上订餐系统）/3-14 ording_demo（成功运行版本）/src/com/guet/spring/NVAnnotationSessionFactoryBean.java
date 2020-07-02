package com.guet.spring;

import java.lang.reflect.Field;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import org.springframework.beans.BeansException;
import org.springframework.beans.factory.BeanFactory;
import org.springframework.beans.factory.BeanFactoryAware;
import org.springframework.beans.factory.ListableBeanFactory;
import org.springframework.orm.hibernate3.annotation.AnnotationSessionFactoryBean; 

/**
 * 对 AnnotationSessionFactoryBean 做了一些扩展。<br>
 * 把实体对象的注册分发到 AnnotatedConfig 中，<br>这样可以在bean工厂的任意位置对实体对象进行注册，可以把注册分发到实体对象所在的项目中。<br>
 * @author X
 */
@SuppressWarnings("unchecked")
public class NVAnnotationSessionFactoryBean extends AnnotationSessionFactoryBean implements BeanFactoryAware {

	public void setBeanFactory(BeanFactory beanFactory) throws BeansException {
		if (beanFactory instanceof ListableBeanFactory == false) {
			return;
		}
		ListableBeanFactory lf = (ListableBeanFactory) beanFactory;
		String[] names = lf.getBeanNamesForType(AnnotatedConfig.class);
		List<Class> clist = getAnnotatedClasses();
		List<String> plist = getAnnotatedPackages();
		for (int i = 0; i < names.length; i++) {
			AnnotatedConfig annotatedConfig = (AnnotatedConfig) lf.getBean(names[i]);
			if (annotatedConfig.getAnnotatedClasses() != null) {
				clist.addAll(annotatedConfig.getAnnotatedClasses());
			}
			if (annotatedConfig.getAnnotatedPackages() != null) {
				plist.addAll(annotatedConfig.getAnnotatedPackages());
			}
		}
		super.setAnnotatedClasses(clist.toArray(new Class[clist.size()]));
		super.setAnnotatedPackages(plist.toArray(new String[plist.size()]));
	}

	@Override
	public void setAnnotatedClasses(Class[] annotatedClasses) {
		List<Class> clist = getAnnotatedClasses();
		if (annotatedClasses != null) {
			clist.addAll(Arrays.asList(annotatedClasses));
		}
		super.setAnnotatedClasses(clist.toArray(new Class[clist.size()]));
	}

	@Override
	public void setAnnotatedPackages(String[] annotatedPackages) {
		List<String> plist = getAnnotatedPackages();
		if (annotatedPackages != null) {
			plist.addAll(Arrays.asList(annotatedPackages));
		}
		super.setAnnotatedPackages(plist.toArray(new String[plist.size()]));
	}

	private List<Class> getAnnotatedClasses() {
		try {
			Field f = AnnotationSessionFactoryBean.class.getDeclaredField("annotatedClasses"); //$NON-NLS-1$
			f.setAccessible(true);
			Class[] annotatedClasse = (Class[]) f.get(this);
			if (annotatedClasse == null) {
				return new ArrayList<Class>();
			} else {
				return new ArrayList<Class>(Arrays.asList(annotatedClasse));
			}
		} catch (Exception e) {
			throw new RuntimeException(e);
		}
	}

	private List<String> getAnnotatedPackages() {
		try {
			Field f = AnnotationSessionFactoryBean.class.getDeclaredField("annotatedPackages"); //$NON-NLS-1$
			f.setAccessible(true);
			String[] annotatedPackages = (String[]) f.get(this);
			if (annotatedPackages == null) {
				return new ArrayList<String>();
			} else {
				return new ArrayList<String>(Arrays.asList(annotatedPackages));
			}
		} catch (Exception e) {
			throw new RuntimeException(e);
		}
	}

}
