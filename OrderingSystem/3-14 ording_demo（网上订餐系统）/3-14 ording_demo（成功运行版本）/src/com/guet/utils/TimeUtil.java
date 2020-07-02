package com.guet.utils;

import java.sql.Timestamp;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * 时间工具类
 * 
 * @author X
 * 
 */
public abstract class TimeUtil {
	private static Calendar cal = Calendar.getInstance();

	private static SimpleDateFormat dateFormat = new SimpleDateFormat(
			"yyyy-MM-dd");
	private static final Logger logger = LoggerFactory
			.getLogger(TimeUtil.class);

	private static Date tempDate = new Date();

	/**
	 * 得到当前时间
	 * 
	 * @return
	 */
	public static Timestamp now() {
		return new Timestamp(Calendar.getInstance().getTimeInMillis());
	}

	public static Timestamp addNow() {
		return new Timestamp(Calendar.getInstance().getTimeInMillis() + 1000);
	}

	public static Timestamp dateToTimestamp(Date date) {
		return new Timestamp(date.getTime());
	}

	public static Timestamp today() {
		Timestamp t = now();
		getDate(t);
		return t;
	}

	public static void convertCal(Date t, int f, int ci) {
		cal.setTime(t);
		cal.set(f, cal.get(f) + ci);
		t.setTime(cal.getTimeInMillis());
	}

	public static void setFiled(Date t, int f, int si) {
		cal.setTime(t);
		cal.set(f, si);
		t.setTime(cal.getTimeInMillis());
	}
	
	public static Date fromDateString(String dateString, String patten) {

		Date d = null;
		try {
			d = new SimpleDateFormat(patten).parse(dateString);
		} catch (ParseException e) {
		}
		return  d != null ? d : new Date();
	}

	/**
	 * 格式化时间字符串
	 * 
	 * @param str
	 * @return
	 */
	public static String format(String str) {
		Date d = null;
		try {
			d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(str);
		} catch (ParseException e) {
		}
		return formatDate(d != null ? d : new Date());
	}

	public static String formatDate(Date date) {
		dateFormat.applyPattern("yyyy-MM-dd");
		return dateFormat.format(date);
	}

	public static String formatMD(Date date) {
		dateFormat.applyPattern("MM-dd");
		return dateFormat.format(date);
	}
	
	
	public static String formatDateTime(Date date) {
		if (date != null) {
			dateFormat.applyPattern("yyyy-MM-dd HH:mm:ss");
			return dateFormat.format(date);
		}
		return null;

	}

	public static String formatDate(Date date, String pattern) {
		dateFormat.applyPattern(pattern);
		return dateFormat.format(date);
	}

	public static String formatDate(long d) {
		tempDate.setTime(d);
		return formatDate(tempDate);
	}

	public static String formatDateTime(long t) {
		tempDate.setTime(t);
		return formatDateTime(tempDate);
	}

	public static String formatDate(long t, String pattern) {
		tempDate.setTime(t);
		return formatDate(tempDate, pattern);
	}

	public static DateFormat getDateFormat() {
		return dateFormat;
	}

	public static Date parse(String date) {
		Date d = null;
		try {
			dateFormat.applyPattern("yyyy-MM-dd");
			d = getDateFormat().parse(date);
		} catch (ParseException e) {
			e.printStackTrace();
		}
		return d == null ? new Date() : d;
	}

	public static String formatDateYYYYMMDD(Date date) {
		dateFormat.applyPattern("yyyyMMdd");
		return dateFormat.format(date);
	}

	
	/**
	 * 判断是否为同一天
	 * 
	 * @param date1
	 * @param date2
	 * @return
	 */
	public static boolean isSameDay(Date date1, Date date2) {
		if ((date1 == null) || (date2 == null)) {
			throw new IllegalArgumentException("The date must not be null");
		}
		Calendar cal1 = Calendar.getInstance();
		cal1.setTime(date1);
		Calendar cal2 = Calendar.getInstance();
		cal2.setTime(date2);
		return isSameDay(cal1, cal2);
	}

	/**
	 * 根据cal1判断是否为同一天
	 * 
	 * @param cal1
	 * @param cal2
	 * @return
	 */
	public static boolean isSameDay(Calendar cal1, Calendar cal2) {
		if ((cal1 == null) || (cal2 == null)) {
			throw new IllegalArgumentException("The date must not be null");
		}
		return ((cal1.get(0) == cal2.get(0)) && (cal1.get(1) == cal2.get(1)) && (cal1
				.get(6) == cal2.get(6)));
	}

	public static boolean isSameInstant(Date date1, Date date2) {
		if ((date1 == null) || (date2 == null)) {
			throw new IllegalArgumentException("The date must not be null");
		}
		return (date1.getTime() == date2.getTime());
	}

	private static void getDate(Timestamp t) {
		setFiled(t, 11, 0);
		setFiled(t, 12, 0);
		setFiled(t, 13, 0);
		setFiled(t, 14, 0);
	}

	/**
	 * 取得当天日期，以00:00:00结尾
	 * 
	 * @param d
	 * @return
	 */
	public static Date getFilterDate(Date d) {		
		Calendar c = Calendar.getInstance();
		if(d==null){
			d =new Date();
		}else{
			c.setTime(d);			
		}
		c.set(Calendar.HOUR_OF_DAY, 0);
		c.set(Calendar.MINUTE, 0);
		c.set(Calendar.SECOND, 0);
		c.set(Calendar.MILLISECOND, 0);
		return c.getTime();
	}

	/**
	 * /** 判断系统当前时间是否在某一个时间段内
	 * 
	 * @param nowDate
	 * @param startTime
	 *            (00:00:00)
	 * @param endTime
	 *            (00:00:00)
	 * @return
	 */
	public static int withInNowTime(Date nowDate, String startTime,
			String endTime) {
		if (nowDate != null && startTime != null && endTime != null) {
		//	Calendar cal = Calendar.getInstance();
			//cal.setTime(nowDate);
			int nowSecond = nowDate.getHours() * 3600 + nowDate.getMinutes() * 60 + nowDate.getSeconds();
			int startSecond = 0;
			int endSecond = 0;
			String[] startTimeArray = startTime.split(":");
			String[] endTimeArray = endTime.split(":");
			if (startTimeArray.length == 3 && endTimeArray.length == 3) {
				startSecond = Integer.parseInt(startTimeArray[0]) * 3600
						+ Integer.parseInt(startTimeArray[1]) * 60
						+ Integer.parseInt(startTimeArray[2]);
				endSecond = Integer.parseInt(endTimeArray[0]) * 3600
						+ Integer.parseInt(endTimeArray[1]) * 60
						+ Integer.parseInt(endTimeArray[2]);
				if (nowSecond >= startSecond && startSecond <= endSecond) {
					return 1;
				} else {
					return 0;
				}
			}
		}
		return -1;
	}

	public static boolean isWithInTime(String startTime, String endTime, Date d)
			throws ParseException {
		String str = formatDate(getFilterDate(now()));
		Date d1 = null;
		Date d2 = null;
		SimpleDateFormat dateFormat = new SimpleDateFormat(
				"yyyy-MM-dd HH:mm:ss");
		d1 = dateFormat.parse(str + " " + startTime);
		d2 = dateFormat.parse(str + " " + endTime);
		if (d1 == null || d2 == null || d == null) {
			return false;
		}
		return d.getTime() >= d1.getTime() && d.getTime() <= d2.getTime();
	}

	public static Timestamp getTimeStamp(String time) {
		if (time == null || time == "")
			return null;
		SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		Date date = null;
		try {
			date = sdf.parse(time);
		} catch (ParseException e) {
			e.printStackTrace();
		}

		return new Timestamp(date.getTime());
	}

	public static Timestamp parseTime(String s) {
		if (!StringUtils.isInvalid(s)) {
			if(s.length()==10){
				s += " 00:00:00";
			}
			SimpleDateFormat format = new SimpleDateFormat(
					"yyyy-MM-dd HH:mm:ss");
			try {
				return new Timestamp(format.parse(s).getTime());

			} catch (ParseException e) {
				logger.error(e.toString());
			}
		}
		return null;
	}

	/**
	 * 得到一天的开始时间
	 * 
	 * @param d
	 * @return
	 */
	public static Timestamp getDayStart(Date d) {
		Calendar c = Calendar.getInstance();
		c.setTime(d);
		c.set(Calendar.HOUR_OF_DAY, 0);
		c.set(Calendar.MINUTE, 0);
		c.set(Calendar.SECOND, 0);
		// c.set(Calendar.MILLISECOND, 0);
		return new Timestamp(c.getTimeInMillis());
	}

	public static Timestamp getDayEnd(Date d) {
		Calendar c = Calendar.getInstance();
		c.setTime(d);
		c.set(Calendar.HOUR_OF_DAY, 23);
		c.set(Calendar.MINUTE, 59);
		c.set(Calendar.SECOND, 59);
		// c.set(Calendar.MILLISECOND, 0);
		return new Timestamp(c.getTimeInMillis());

	}
	
	/**
	 * 给定时间加给定秒数
	 * @param tamp
	 * @param seconds
	 * @return
	 */
	public static Timestamp addseconds(Timestamp tamp,int seconds) {
		return new Timestamp(tamp.getTime()+seconds*1000);
	}
	
	/**
	 * 给定时间减给定秒数
	 * @param tamp
	 * @param seconds
	 * @return
	 */
	public static Timestamp minusseconds(Timestamp tamp,int seconds) {
		return new Timestamp(tamp.getTime()-seconds*1000);
	}
	
	/**
	 * 给定时间加给定分钟
	 * @param tamp
	 * @param fen
	 * @return
	 */
	public static Timestamp addFen(Timestamp tamp,int fen) {
		return new Timestamp(tamp.getTime()+fen*1000*60);
	}
	
	/**
	 * 给定时间加给定天
	 * @param tamp
	 * @param fen
	 * @return
	 */
	public static Timestamp addTian(Timestamp tamp,int tian) {
		return new Timestamp((long)tamp.getTime()+(long)tian*24*60*1000*60);
	}
	/**
	 * 获得上个月月份
	 * */
	
	public static String getLastMouth(){
		SimpleDateFormat sdf=new SimpleDateFormat("yyyyMM"); 
        Calendar   calendar=Calendar.getInstance(); 
        //calendar.set(2010,5,0); 
        calendar.setTime(new Date());
        //calendar.add(Calendar.MONTH, -1);
       //取得上一个月时间
        calendar.set(Calendar.MONTH,calendar.get(Calendar.MONTH)-1); 
        String lastMonth= sdf.format(calendar.getTime());
        return lastMonth;

	}
	public static int getCycleByMouth(int mouth){
		int cycle = 0;
		switch (mouth) {
		case 1:
			cycle =1;
			break;
		case 2:
			cycle =1;
			break;
		case 3:
			cycle =1;
			break;
		case 4:
			cycle =2;
			break;
		case 5:
			cycle =2;
			break;
		case 6:
			cycle =2;
			break;
		case 7:
			cycle =3;
			break;
		case 8:
			cycle =3;
			break;
		case 9:
			cycle =3;
			break;
		case 10:
			cycle =4;
			break;
		case 11:
			cycle =4;
			break;
		case 12:
			cycle =4;
			break;
		default:
			break;
		}
		return cycle;
		
	}
	/**
	 * 根据字符串格式化成yyy-mm-dd
	 * */
	public static Date formatDateYYYY_MM_DD(String str){
		SimpleDateFormat format = new SimpleDateFormat(
				"yyyy-MM-dd");
		Date date = null;
		try {
			date = format.parse(str);
		} catch (ParseException e) {
			e.printStackTrace();
		}
		return date;
		
	}
	public static int getYearNow(){
		int year = 0;
		SimpleDateFormat sdf=new SimpleDateFormat("yyyyMM"); 
        Calendar   calendar=Calendar.getInstance(); 
        //calendar.set(2010,5,0); 
        calendar.setTime(new Date());
        year= Integer.parseInt(sdf.format(calendar.getTime()).substring(0,4));
		return year;
	}
	
	/**
	 * 取得当前年
	 * @return
	 */
	public static int getCurrentYear()
	{
		Calendar rightNow = Calendar.getInstance();  
		return rightNow.get(Calendar.YEAR);
	}
	
	public static Date getDateOption(Date date ,int field, int amount) {
		SimpleDateFormat df = new SimpleDateFormat("yyyy-MM-dd");
		GregorianCalendar gc = new GregorianCalendar();
		gc.setTime(date);
		gc.add(field, amount);
		gc.set(gc.get(gc.YEAR), gc.get(gc.MONTH), gc.get(gc.DATE));
		String result = df.format(gc.getTime());
		return formatDateYYYY_MM_DD(result);
	}
	/**
	 * 根据long值返回字符串时间
	 * */
	
	public static String getTimeStrByLong(long l){
		if(l!=0){
			//天
			long day = l/(24*60*60*1000);
			//时
			long hour = (l/(60*60*1000)-day*24);
			//分
			long min = ((l/(60*1000))-day*24*60-hour*60);
			//秒
			long second = (l/1000-day*24*60*60-hour*60*60-min*60);
			
			StringBuffer str = new StringBuffer();
			if(day > 0){
				str.append(day).append("天");
			}
			if(hour > 0){
				str.append(hour).append("时");
			}
			if(min > 0){
				str.append(min).append("分");
			}
			if(second > 0){
				str.append(second).append("秒");
			}
			return str.toString();
		} return "0天0时0分0秒";
	}
	
	public static Date getDateYYYY_MM_DD_HH_MM_SS(String s){
		Date date = null;
		SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		if(!StringUtils.isInvalid(s)){
			try {
				date = format.parse(s);
			} catch (ParseException e) {
				e.printStackTrace();
			}
		}
		return date;
	}
	public static boolean beforeTime(Timestamp t1,Timestamp t2){
		if(t1.after(t2)){
			return false;
		}return true;
	}
	
	/**
	 * 前x天
	 * 
	 * @param d
	 * @param squence
	 * @return
	 */
	public static Date before(Date d, int squence) {
		cal.setTime(d);
		cal.set(Calendar.HOUR_OF_DAY, cal.get(Calendar.HOUR_OF_DAY) - squence
				* 24);
		return new Date(cal.getTimeInMillis());
	}
	
	
}