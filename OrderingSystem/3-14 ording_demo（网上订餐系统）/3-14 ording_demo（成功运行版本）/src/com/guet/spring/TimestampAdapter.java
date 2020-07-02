package com.guet.spring;

import java.sql.Timestamp;
import java.util.Date;

import javax.xml.bind.annotation.adapters.XmlAdapter;

public class TimestampAdapter extends XmlAdapter<Date, Timestamp>{
	@Override
	public Date marshal(Timestamp v) throws Exception {
		if (v != null) {
			return v;
		}
		return null;
	}

	@Override
	public Timestamp unmarshal(Date v) throws Exception {
		if (v != null) {
			return new Timestamp(v.getTime());
		}
		return null;
	}
}
