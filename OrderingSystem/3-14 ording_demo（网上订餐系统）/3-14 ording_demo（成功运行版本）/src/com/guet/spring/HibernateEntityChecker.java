package com.guet.spring;

import javax.persistence.Entity;

/**
 * 检查是否注解Entity
 * 
 * @author X
 */
public class HibernateEntityChecker {
	public Class<?> checkEntity(Class<?> entity) {
		Entity entity2 = entity.getAnnotation(Entity.class);
		if (entity2 == null) {
			throw new RuntimeException(
					"没有为"	+ entity.getCanonicalName() + "打上" + Entity.class.getName() + "注解。 "); //$NON-NLS-1$ //$NON-NLS-2$ //$NON-NLS-3$
		}
		return entity;
	}
}
