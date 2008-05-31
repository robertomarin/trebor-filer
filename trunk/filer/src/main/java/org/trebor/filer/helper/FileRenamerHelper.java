package org.trebor.filer.helper;

import java.io.File;
import java.io.FileFilter;
import java.util.HashMap;
import java.util.Map;

import org.trebor.filer.JustBox;


public class FileRenamerHelper {
	private Map<File, File> files;

	private boolean lowerCase;

	private String pattern;

	private String[] fileTypes;

	private final JustBox justBox;

	public FileRenamerHelper(String patternToRename, String fileTypesString, boolean lowerCase,
			JustBox justBox) {

		this.pattern = patternToRename;
		this.justBox = justBox;

		if (fileTypesString != null) {
			fileTypes = fileTypesString.split("[,]");
		}

		this.lowerCase = lowerCase;
		files = new HashMap<File, File>();
	}

	public Map<File, File> generateFileNames(File dirRoot) {
		File[] fileList = dirRoot.listFiles(new FileFilter() {
			public boolean accept(File pathname) {
				if (justBox == JustBox.FOLDERS) {
					return pathname.isDirectory();
				}
				return true;
			}
		});

		for (int i = 0; i < fileList.length; i++) {
			File file = fileList[i];

			if (file.isDirectory()) {
				generateFileNames(file);
			}

			File newFile = generateFileName(file);
			if (newFile == null)
				continue;

			if (files.containsValue(newFile)) {
				throw new IllegalStateException(
						"erro, não pode existir dois arquivos com mesmo nome: "
								+ newFile.getAbsolutePath());
			}

			files.put(file, newFile);
		}

		return files;
	}

	private File generateFileName(File file) {
		if (file == null) {
			throw new IllegalArgumentException("argument file cannot be null");
		}

		String fileName = file.getName();
		boolean ok = false;
		for (String fileType : fileTypes) {
			if (fileName.endsWith(fileType)) {
				ok = true;
				break;
			}
		}

		if (!ok)
			return null;

		if (lowerCase)
			fileName = fileName.toLowerCase();

		if (pattern != null && !"".equals(pattern)) {
			fileName = fileName.replaceAll(pattern, "");
		}

		fileName = replaceMultipleWhiteSpaces(fileName);

		return new File(file.getParentFile().getAbsolutePath(), fileName);
	}

	private String replaceMultipleWhiteSpaces(String str) {
		if (str == null)
			throw new IllegalArgumentException("argument str cannot be null");

		str = str.replaceAll("^[\\s]*|[\\s]*$", "");
		str = str.replaceAll("[\\s]{2,}", " ");

		return str;
	}

}
