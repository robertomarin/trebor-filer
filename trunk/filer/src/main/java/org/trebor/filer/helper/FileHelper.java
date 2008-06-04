package org.trebor.filer.helper;

import java.awt.Component;
import java.io.File;
import java.util.Arrays;
import java.util.Map;

import javax.swing.JFileChooser;

import org.apache.commons.validator.GenericValidator;
import org.trebor.filer.log.LogWriterHelper;

public class FileHelper {

	public boolean isDir(String path) {
		if (GenericValidator.isBlankOrNull(path))
			return false;

		File file = new File(path);
		return file.exists() && file.isDirectory();
	}

	public boolean rename(Map<File, File> files) {
		return rename(files, false);
	}

	private boolean rename(Map<File, File> files, boolean dirs) {
		if(files == null)
			return true;
		
		LogWriterHelper helper = new LogWriterHelper(files);
		if (helper.storeToXML()) {
			for (File oldFile : files.keySet()) {
				if (!dirs && oldFile.isDirectory()) {
					continue;
				}

				File newFile = files.get(oldFile);
				if (newFile.getAbsolutePath().equals(oldFile.getAbsolutePath())) {
					continue;
				}

				boolean rename = oldFile.renameTo(newFile);
				Thread.yield();
				boolean exists = newFile.exists();
				if (!rename && !exists && oldFile.exists()) {
					throw new IllegalStateException("Erro ao renomear de: " + oldFile.getAbsolutePath() + " para "
							+ newFile.getAbsolutePath() + ". Rename: " + rename + " Exists: " + exists + " OldExists: "
							+ oldFile.exists());
				}
			}
			if (!dirs)
				rename(files, true);
			return true;
		} else {
			return false;
		}
	}

	public Map<File, File> filer(String rootRenamingDirectory, String regex, String replacement, String filter,
			boolean lowerCase, boolean justDirectory) {

		FileRenamerHelper filer = new FileRenamerHelper(regex, replacement, filter, lowerCase, justDirectory);

		return filer.generateFileNames(new File(rootRenamingDirectory));
	}

	public boolean isValidRootFile(File file) {
		return file != null && file.exists() && !Arrays.asList(File.listRoots()).contains(file);
	}

	public File getDirRoot(Component c) {
		JFileChooser fileChooser = new JFileChooser();
		fileChooser.setFileSelectionMode(JFileChooser.DIRECTORIES_ONLY);

		if (JFileChooser.CANCEL_OPTION == fileChooser.showOpenDialog(c)) {
			return null;
		}

		return fileChooser.getSelectedFile();
	}

}
