package org.trebor.filer.log;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.Map;
import java.util.Properties;

public class LogWriterHelper {

	private final Map<File, File> files;

	private final String fileName;

	public LogWriterHelper(Map<File, File> files) {
		if(files == null)
			throw new IllegalArgumentException("Argument files cannot be null.");
		
		this.files = files;
		this.fileName = "logs/log_" + System.currentTimeMillis() + ".xml";
	}

	public boolean storeToXML() {
		Properties properties = new Properties();
		for (File fileKey : files.keySet()) {
			properties.put(fileKey.getAbsolutePath(), files.get(fileKey).getAbsolutePath());
		}

		File propertiesFile = new File(fileName);

		try {
			properties.storeToXML(new FileOutputStream(propertiesFile), fileName);
		} catch (FileNotFoundException e) {
			throw new IllegalStateException("cannot find path to: " + fileName, e);
		} catch (IOException e) {
			throw new IllegalStateException("cannot find path to: " + fileName, e);
		}

		return true;
	}

	public String getLogFileName() {
		return fileName;
	}
}
