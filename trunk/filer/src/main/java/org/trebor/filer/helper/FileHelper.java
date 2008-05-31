package org.trebor.filer.helper;

import java.io.File;

public class FileHelper {
	
	public boolean itsADirPath(String path) {
		if (path == null)
			return false;

		File file = new File(path);
		return file.exists() && file.isDirectory();
	}

}
