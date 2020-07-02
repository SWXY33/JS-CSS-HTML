package com.guet.action;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import net.sf.json.JSONArray;

import com.guet.constants.Constant;
import com.guet.entities.SystemFile;
import com.guet.utils.StringUtils;
import com.guet.utils.TimeUtil;
import com.guet.webservice.IFileService;

public class UploadAction extends PageAction{

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	
	/**
	 * 上传文件列表,必须和jsp页面name属性对应
	 */
	private List<File> file;
	
	/**
	 * 对应文件名,命名规则，name属性的值加HTTP协议的属性
	 * 如,file + fileName 
	 * 必须用驼峰命名法
	 */
	private List<String> fileFileName;
	
	/**
	 * 命名规则同上
	 */
	private List<String> fileContentType;
	
	private IFileService fileService;
	
	public String preUpload(){
		return SUCCESS;
	}
	
	public String upload(){
		try {
			if(file != null){
				/**
				 * 文件上传路径
				 */
				String path = "E:/bishe/ording/images/";
				String path2 = TimeUtil.formatDate(new Date()) + "/";
				path2 = path2.replace("-","/");
				//path += path2;
				File tmp = new File(path + path2);
				if(!tmp.exists()){
					tmp.mkdirs();
				}
				
				List<SystemFile> sysFiles = new ArrayList<SystemFile>();
				for (int i = 0; i < file.size(); i++) {
					InputStream is = new FileInputStream(file.get(i));
					String randomName = StringUtils.genUUID();
					int index = fileFileName.get(i).lastIndexOf(".");
					String suffix = fileFileName.get(i).substring(index);
					OutputStream os = new FileOutputStream(
							new File(tmp.getPath(),randomName + suffix));
					
					byte[] buf = new byte[1024];
					@SuppressWarnings("unused")
					int length = 0;
					while((length = is.read(buf, 0, buf.length)) != -1){
						os.write(buf);
					}
					
					os.close();
					is.close();
					
					SystemFile sysFile = new SystemFile();
					sysFile.setFileName(fileFileName.get(i));
					sysFile.setFileType(fileContentType.get(i));
					sysFile.setUploadTime(TimeUtil.now());
					sysFile.setBasePath(path);
					sysFile.setRelativePath(path2 + randomName + suffix);
					sysFile.setDbStatus(Constant.DB_STATUS_0);
					
					sysFiles.add(sysFile);
				}
				fileService.saveSystemFiles(sysFiles);
				JSONArray json = JSONArray.fromObject(sysFiles);
				printOMUIJson(json.toString());
			}
		} catch (Exception e) {
			printOMUIJson("[]");
			e.printStackTrace();
		}
		return null;
	}

	public List<File> getFile() {
		return file;
	}

	public void setFile(List<File> file) {
		this.file = file;
	}

	public List<String> getFileFileName() {
		return fileFileName;
	}

	public void setFileFileName(List<String> fileFileName) {
		this.fileFileName = fileFileName;
	}

	public List<String> getFileContentType() {
		return fileContentType;
	}

	public void setFileContentType(List<String> fileContentType) {
		this.fileContentType = fileContentType;
	}

	public IFileService getFileService() {
		return fileService;
	}

	public void setFileService(IFileService fileService) {
		this.fileService = fileService;
	}
}
