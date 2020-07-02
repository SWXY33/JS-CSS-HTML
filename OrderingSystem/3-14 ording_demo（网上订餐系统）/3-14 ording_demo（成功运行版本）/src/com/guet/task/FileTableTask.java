package com.guet.task;

import java.io.File;
import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;

import com.guet.entities.SystemFile;
import com.guet.webservice.DBPersistenceImpl;
import com.guet.webservice.IFileService;

public class FileTableTask extends DBPersistenceImpl implements Runnable {
	
	@Autowired
	private IFileService fileService;

	@Override
	public void run() {
		List<SystemFile> list = fileService.findInvalidImages();
		if(list != null){
			for (SystemFile systemFile : list) {
				String path = systemFile.getBasePath() + systemFile.getRelativePath();
				try {
					File file = new File(path);
					if(file.exists()){
						System.out.println("删除无效文件: " + path);
						file.delete();
					}
					deleteObject(systemFile, true);
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
		}
	}
}
