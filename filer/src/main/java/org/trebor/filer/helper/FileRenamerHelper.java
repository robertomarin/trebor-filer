package org.trebor.filer.helper;

import java.io.File;
import java.io.FileFilter;
import java.util.Map;
import java.util.TreeMap;

public class FileRenamerHelper {
	private final Map<File, File> files;

	private final boolean lowerCase;

	private final String regex;

	private String[] fileTypes;

	private final boolean justDirectory;

	private final String replacement;

	public FileRenamerHelper(final String regex, final String replacement, final String fileTypesString,
			final boolean lowerCase, final boolean justDirectory) {

		this.regex = regex;
		this.replacement = replacement != null ? replacement : "";
		this.justDirectory = justDirectory;

		if (fileTypesString != null) {
			fileTypes = fileTypesString.split("[,]");
		}

		this.lowerCase = lowerCase;
		files = new TreeMap<File, File>();
	}

	public Map<File, File> generateFileNames(final File dirRoot) {
		final File[] fileList = dirRoot.listFiles(new FileFilter() {
			public boolean accept(final File pathname) {
				if (justDirectory) {
					return pathname.isDirectory();
				}
				return true;
			}
		});

		for (final File file : fileList) {
			System.out.println(file);
		}

		for (int i = 0; i < fileList.length; i++) {
			final File file = fileList[i];

			if (file.isDirectory()) {
				generateFileNames(file);
			}

			final File newFile = generateFileName(file);
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

	private File generateFileName(final File file) {
		if (file == null) {
			throw new IllegalArgumentException("argument file cannot be null");
		}

		String fileName = file.getName();
		boolean ok = false;
		for (final String fileType : fileTypes) {
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
