package com.guet;

import org.springframework.stereotype.Component;

import com.guet.entities.GoodsOrder;
import com.guet.entities.OrderMenu;
import com.guet.entities.PhoneAndCode;
import com.guet.entities.ReceiptAddress;
import com.guet.entities.Store;
import com.guet.entities.StoreMenu;
import com.guet.entities.SystemFile;
import com.guet.entities.SystemUser;
import com.guet.spring.AnnotatedConfig;

@Component
public class EntityConfig extends AnnotatedConfig{
	public EntityConfig() {
		addClass(SystemUser.class);
		addClass(SystemFile.class);
		addClass(PhoneAndCode.class);
		addClass(Store.class);
		addClass(StoreMenu.class);
		addClass(GoodsOrder.class);
		addClass(ReceiptAddress.class);
		addClass(OrderMenu.class);
	}
}
