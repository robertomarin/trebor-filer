package org.trebor.filer.helper;

import java.io.File;
import java.io.FileFilter;
import java.util.HashMap;
import java.util.Map;

import org.apache.commons.validator.GenericValidator;

public class FileRenamerHelper {
	private Map<File, File> files;

	private boolean lowerCase;

	private String regex;

	private String[] fileTypes;

	private final boolean justDirectory;

	private final String replacement;

	public FileRenamerHelper(String regex, String replacement, String fileTypesString, boolean lowerCase,
			boolean justDirectory) {

		this.regex = regex;
		this.replacement = !GenericValidator.isBlankOrNull(replacement) ? replacement : "";
		this.justDirectory = justDirectory;

		if (fileTypesString != null) {
			fileTypes = fileTypesString.split("[,]");
		}

		this.lowerCase = lowerCase;
		files = new HashMap<File, File>();
	}

	public Map<File, File> generateFileNames(File dirRoot) {
		File[] fileList = dirRoot.listFiles(new FileFilter() {
			public boolean accept(File pathname) {
				if (justDirectory) {
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
				throw new IllegalStateException("erro, não pode existir dois arquivos com mesmo nome: "
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

		if (regex != null && !"".equals(regex)) {
			fileName = fileName.replaceAll(regex, replacement);
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
