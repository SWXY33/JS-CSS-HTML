package com.guet.servlet;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.Iterator;
import java.util.List;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import net.sf.json.JSONArray;

import org.apache.commons.fileupload.FileItem;
import org.apache.commons.fileupload.FileUploadException;
import org.apache.commons.fileupload.disk.DiskFileItem;
import org.apache.commons.fileupload.disk.DiskFileItemFactory;
import org.apache.commons.fileupload.servlet.ServletFileUpload;
import org.apache.commons.fileupload.util.Streams;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import com.guet.constants.Constant;
import com.guet.entities.SystemFile;
import com.guet.utils.StringUtils;
import com.guet.utils.TimeUtil;
import com.guet.webservice.IFileService;

/**
 * JqueryUploadify文件上传Servlet调用类
 * 
 * @author X
 * @Description
 */
@Component("jqueryUploadify")
public class JqueryUploadifyServlet extends HttpServlet {
	private static final long serialVersionUID = -5729233470824150048L;

	@Autowired
	private IFileService fileService;

	@Override
	protected void doPost(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		// 获取客户端回调函数名
		request.setCharacterEncoding("utf-8");
		response.setContentType("text/html;charset=UTF-8");
		test(request, response);
		if ("onerror".equals(request.getParameter("testcase"))) {
			throw new IOException();
		}
	}

	@Override
	protected void doGet(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		doPost(request, response);
	}

	@SuppressWarnings({ "unchecked", "rawtypes" })
	protected void defaultProcessFileUpload(HttpServletRequest request,
			HttpServletResponse response) throws IOException {

		DiskFileItemFactory fac = new DiskFileItemFactory();
		ServletFileUpload upload = new ServletFileUpload(fac);
		upload.setHeaderEncoding("UTF-8");
		List fileList = null;
		List<SystemFile> sysFileList = new ArrayList<SystemFile>();

		try {
			if (ServletFileUpload.isMultipartContent(request)) {
				fileList = upload.parseRequest(request);
				Iterator<FileItem> iter = fileList.iterator();
				String fileName = "";
				String extName = "";
				SystemFile file = null;

				while (iter.hasNext()) {
					FileItem item = iter.next();
					if (!item.isFormField()) {
						// 文件名
						fileName = item.getName();
						// 得到文件的扩展名(无扩展名时将得到全名)
						extName = item.getName().substring(
								item.getName().lastIndexOf(".") + 1);
						// 保存文件
						file = new SystemFile();
						file.setFileName(fileName);
						file.setFileType(extName);
						file.setUploadTime(TimeUtil.now());
						// 组装上传文件信息，返回前台
						sysFileList.add(file);
					}
				}
				fileService.saveSystemFiles(sysFileList);

			}
		} catch (FileUploadException e) {
			e.printStackTrace();
		} finally {
			JSONArray json = JSONArray.fromObject(sysFileList);
			response.getWriter().write(json.toString());
		}
	}

	@SuppressWarnings({ "rawtypes" })
	private void test(HttpServletRequest request, HttpServletResponse response)
			throws IOException {
		String fileRealPath = "";// 文件存放真实地址
		String firstFileName = "";
		String savePath = "E:/bishe/ording/images/";
		String path2 = TimeUtil.formatDate(new Date()) + "/";
		path2 = path2.replace("-", "/");
		File tmp = new File(savePath + path2);
		if (!tmp.exists()) {
			tmp.mkdirs();
		}

		List<SystemFile> sysFileList = new ArrayList<SystemFile>();
		try {
			DiskFileItemFactory fac = new DiskFileItemFactory();
			ServletFileUpload upload = new ServletFileUpload(fac);
			upload.setHeaderEncoding("UTF-8");
			// 获取多个上传文件
			List fileList = upload.parseRequest(request);
			// 遍历上传文件写入磁盘
			Iterator it = fileList.iterator();
			while (it.hasNext()) {
				Object obit = it.next();
				if (obit instanceof DiskFileItem) {
					DiskFileItem item = (DiskFileItem) obit;

					// 如果item是文件上传表单域
					// 获得文件名及路径
					String fileName = item.getName();
					if (fileName != null) {
						String newfileName = StringUtils.genUUID();// 文件名称
						firstFileName = fileName.substring(fileName
								.lastIndexOf("\\") + 1);
						String formatName = firstFileName
								.substring(firstFileName.lastIndexOf("."));// 获取文件后缀名
						fileRealPath = savePath + path2 + newfileName + formatName;// 文件存放真实地址

						BufferedInputStream in = new BufferedInputStream(
								item.getInputStream());// 获得文件输入流
						BufferedOutputStream outStream = new BufferedOutputStream(
								new FileOutputStream(new File(fileRealPath)));// 获得文件输出流
						Streams.copy(in, outStream, true);// 开始把文件写到你指定的上传文件夹
						if (new File(fileRealPath).exists()) {
							SystemFile sysFile = new SystemFile();
							sysFile.setFileName(firstFileName);
							sysFile.setFileType(formatName);
							sysFile.setUploadTime(TimeUtil.now());
							sysFile.setBasePath(savePath);
							sysFile.setRelativePath(path2 + newfileName
									+ formatName);
							sysFile.setDbStatus(Constant.DB_STATUS_0);

							sysFileList.add(sysFile);
						}

					}
				}
			}
			fileService.saveSystemFiles(sysFileList);
		} catch (Exception ex) {
			ex.printStackTrace();
			return;
		} finally {
			JSONArray json = JSONArray.fromObject(sysFileList);
			response.getWriter().write(json.toString());
		}
	}

	public void setFileService(IFileService fileService) {
		this.fileService = fileService;
	}
}
