package org.trebor.filer.helper;

import java.io.File;

import javax.swing.JFileChooser;
import javax.swing.plaf.FileChooserUI;

public class FileHelper {
	
	public boolean itsADirPath(String path) {
		if (path == null)
			return false;

		File file = new File(path);
		return file.exists() && file.isDirectory();
	}

}
