package com.guet.entities;

import java.sql.Timestamp;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.Table;
import javax.xml.bind.annotation.adapters.XmlJavaTypeAdapter;

import org.hibernate.annotations.GenericGenerator;

import com.guet.spring.TimestampAdapter;

/**
 * 文件表
 * @author lili
 *
 */
@Entity
@Table(name = "sys_files")
public class SystemFile extends com.guet.Entity {

	private static final long serialVersionUID = 1L;
	
	/**
	 * id
	 */
	private String id;

	/**
	 * 文件名
	 */
	private String fileName;
	
	/**
	 * 文件类型
	 */
	private String fileType;
	
	/**
	 * 文件上传时间
	 */
	private Timestamp uploadTime;
	
	/**
	 * 基本路径
	 */
	private String basePath;
	
	/**
	 * 相对路径
	 */
	private String relativePath;
	
	/**
	 * 数据状态 0正常 -1删除
	 */
	private int dbStatus;

	@Id
	@GenericGenerator(name = "paymentableGenerator", strategy = "uuid")
	@GeneratedValue(generator = "paymentableGenerator")
	@Column(length = 64)
	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	@Column
	public String getFileName() {
		return fileName;
	}

	public void setFileName(String fileName) {
		this.fileName = fileName;
	}

	@Column
	public String getFileType() {
		return fileType;
	}

	public void setFileType(String fileType) {
		this.fileType = fileType;
	}

	@XmlJavaTypeAdapter(TimestampAdapter.class)
	public Timestamp getUploadTime() {
		return uploadTime;
	}

	public void setUploadTime(@XmlJavaTypeAdapter(TimestampAdapter.class)Timestamp uploadTime) {
		this.uploadTime = uploadTime;
	}

	@Column
	public String getBasePath() {
		return basePath;
	}

	public void setBasePath(String basePath) {
		this.basePath = basePath;
	}

	@Column
	public String getRelativePath() {
		return relativePath;
	}

	public void setRelativePath(String relativePath) {
		this.relativePath = relativePath;
	}

	@Column
	public int getDbStatus() {
		return dbStatus;
	}

	public void setDbStatus(int dbStatus) {
		this.dbStatus = dbStatus;
	}
}
