package com.guet.webservice;

import java.util.List;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;

import com.guet.entities.SystemFile;

@WebService
public interface IFileService {
	
	/**
	 * 保存文件信息
	 * @param files
	 * @return
	 */
	@WebMethod
	public boolean saveSystemFiles(
			@WebParam(name = "files") List<SystemFile> files);
	
	/**
	 * 根据id删除文件记录
	 * @param ids
	 * @return
	 */
	@WebMethod
	public boolean deleteSystemFiles(
			@WebParam(name = "ids") String[] ids);
	
	/**
	 * 查找失效的用户头像
	 * @return
	 */
	public List<SystemFile> findInvalidImages();
}
