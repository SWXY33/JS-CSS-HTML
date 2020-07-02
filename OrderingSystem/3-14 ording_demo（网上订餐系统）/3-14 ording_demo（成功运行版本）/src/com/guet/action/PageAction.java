package com.guet.action;
import java.io.IOException;
import java.lang.reflect.Field;
import java.util.List;
import java.util.Set;

import javax.servlet.http.HttpServletResponse;

import net.sf.json.JSONArray;
import net.sf.json.JSONObject;

import org.apache.struts2.ServletActionContext;
import org.springframework.stereotype.Component;

import com.guet.page.StdPageInfo;
import com.guet.utils.StringUtils;

/**
 * 此Action对ActionSupport做了一个默认的继承，提供了分页处理，所有的Action可以继承此Action。
 * @author X
 *
 */
@Component(value = "pageAction")
public class PageAction extends CommonAction{
	
	private static final long serialVersionUID = 993167598057183886L;
	
	protected StdPageInfo pageInfo;
	
	//omui 分页
	private int start;
	
	private int limit;
	
	protected JSONObject jsonResult;
	
	public int getPageStart() {
		return start;
	}

	public void setStart(int start) {
		this.start = start;
	}

	public int getPageLimit() {
		return limit;
	}

	public void setLimit(int limit) {
		this.limit = limit;
	}

	public PageAction(){
		pageInfo = new StdPageInfo(10);
	}
	
	/**
	 * 输出前台grid组件需要的JSON数据
	 * @param pageInfo
	 * @param list
	 */
	public void printGridData(StdPageInfo pageInfo,List<?> list){
		//转JSON
		try{
			StringBuffer sb = new StringBuffer();
			String result = "0";
			if(list != null && list.size() > 0){
				JSONArray jo = net.sf.json.JSONArray.fromObject(list);
				result = jo.toString();
			}
			if(pageInfo!=null){
				sb.append("{\"total\":" + pageInfo.getTotalRow() + ", \"rows\":");
			}else{
				sb.append("{\"total\":" + "0" + ", \"rows\":");
			}
			sb.append(result);
			sb.append("}");
			//输出
			HttpServletResponse response =  ServletActionContext.getResponse();
			response.setContentType("application/x-json");
			response.getWriter().println(sb);
			//释放资源
			sb = null;
		}catch(Exception e){e.printStackTrace();}
	}
	
	/**
	 * 输出omui组件需要的JSON数据
	 */
	public void printOMUIJson(String jsonStr){
		if(!StringUtils.isInvalid(jsonStr)){
			HttpServletResponse response =  ServletActionContext.getResponse();
			response.setContentType("application/x-json");
			try {
				response.getWriter().println(jsonStr);
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
	}
	
	/**
	 * 将list里面元素的id转成以,分开的字符串
	 * @param list
	 * @return
	 */
	public String listToids(List list){
		String value="";
		Field fd;
		if(list==null||list.size()==0){
			return "";
		}
		
		try {
			for(Object obj:list){
					fd=obj.getClass().getDeclaredField("id");
					fd.setAccessible(true);
					value+=fd.get(obj)+",";
				}
		} catch (Exception e) {
			e.printStackTrace();
		}  
		value=value.substring(0,value.length()-1);
		return value;
	}
	
	/**
	 * 将list里面元素的id转成以,分开的字符串
	 * @param list
	 * @return
	 */
	public String setToids(Set list){
		String value="";
		Field fd;
		if(list==null||list.size()==0){
			return "";
		}
		
		try {
			for(Object obj:list){
					fd=obj.getClass().getDeclaredField("id");
					fd.setAccessible(true);
					value+=fd.get(obj)+",";
				}
		} catch (Exception e) {
			e.printStackTrace();
		}  
		value=value.substring(0,value.length()-1);
		return value;
	}
	/**
	 * 将ID字符串转成id带引号的字符串
	 * @param ids 1,2,3,4
	 * @return '1','2','3','4'
	 */
	public String dataArrayToItemSelectorValue(String ids){
		if (StringUtils.isInvalid(ids)) {
			return null;
		}
		String idarray[]=ids.split(",");
		String value="";
		for(String id:idarray){
			value+="'"+id+"',";
		}
		value=value.substring(0,value.length()-1);
		return value;
	}
	/**
	 * 左右移动控件，右边选中项值封装
	 * @param list
	 * @return
	 */
	public String listToItemSelectorValue(List list){
		String value="";
		Field fd;
		if(list==null||list.size()==0){
			return "";
		}
		
		try {
			for(Object obj:list){
					fd=obj.getClass().getDeclaredField("id");
					fd.setAccessible(true);
					value+="'"+fd.get(obj)+"',";
				}
		} catch (Exception e) {
			e.printStackTrace();
		}  
		value=value.substring(0,value.length()-1);
		return value;
	}
	
	/**
	 * 左右移动控件，右边选中项值封装
	 * @param list
	 * @return
	 */
	public String setToItemSelectorValue(Set list){
		String value="";
		Field fd;
		if(list==null||list.size()==0){
			return "";
		}
		
		try {
			for(Object obj:list){
					fd=obj.getClass().getDeclaredField("id");
					fd.setAccessible(true);
					value+="'"+fd.get(obj)+"',";
				}
		} catch (Exception e) {
			e.printStackTrace();
		}  
		value=value.substring(0,value.length()-1);
		return value;
	}
	
	@Override
	public void validate() {
		this.clearErrorsAndMessages();
	}
}
