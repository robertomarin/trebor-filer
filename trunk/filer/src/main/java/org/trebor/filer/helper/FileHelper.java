package org.trebor.filer.helper;

import java.io.File;
import java.util.Arrays;
import java.util.Map;

import org.trebor.filer.JustBox;
import org.trebor.filer.log.LogWriterHelper;

public class FileHelper {

	public static final String DEFAULT_FILTER = "filtro de arquivos";

	public boolean itsADirPath(String path) {
		if (path == null)
			return false;

		File file = new File(path);
		return file.exists() && file.isDirectory();
	}

	public boolean rename(Map<File, File> files) {
		LogWriterHelper helper = new LogWriterHelper(files);
		if (helper.storeToXML()) {
			for (File file : files.keySet()) {
				file.renameTo(files.get(file));
			}
			return true;
		} else {
			return false;
		}
	}

	public Map<File, File> filer(File dirRoot, String pattern, String filter, boolean lowerCase, JustBox justBox) {

		filter = !DEFAULT_FILTER.equals(filter) ? filter : "";

		FileRenamerHelper filer = new FileRenamerHelper(pattern, filter, lowerCase, justBox);

		return filer.generateFileNames(dirRoot);
	}

	public boolean isValidRootFile(File file) {
		return file != null && file.exists() && !Arrays.asList(File.listRoots()).contains(file);
	}

}
