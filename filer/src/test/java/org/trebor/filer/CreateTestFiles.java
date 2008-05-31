package org.trebor.filer;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;

import org.apache.commons.validator.GenericValidator;
import org.junit.Test;

/**
 * @author rmarin 09/08/2007 15:59:31
 */
public class CreateTestFiles {

	private final String baseDir = "d:/testes/";

	@Test
	public void createFiles() throws IOException {
		File namesFile = new File(this.getClass().getResource("/teste.txt")
				.getFile());

		BufferedReader bf = new BufferedReader(new FileReader(namesFile));
		while (bf.ready()) {
			String line = bf.readLine();

			if (!GenericValidator.isBlankOrNull(line)) {
				line = baseDir + line;
				File file = new File(line);
				if (!file.isDirectory() && !file.getParentFile().exists()) {
					createSubFolders(file.getParentFile());
				}

				System.out.println(file);
				boolean createNewFile = file.createNewFile();
				System.out.println(createNewFile + " " + line);
			}
		}
	}

	private void createSubFolders(File parent) {
		// if(parent.exe) {
		// throw new IllegalArgumentException("argument parent must be a
		// directory: " + parent);
		// }

		verifyFilesNotDir(parent);

		boolean mkdirs = parent.mkdirs();
		if (mkdirs) {
			System.out.println("Diretorio Criado Com Sucesso: " + parent);
		} else {
			throw new IllegalStateException("Impossível criar diretório "
					+ parent);
		}
	}

	private void verifyFilesNotDir(File parent) {
		if (parent == null)
			throw new IllegalArgumentException("argument parent cannot be null");

		File parentFile = parent.getParentFile();

		if (parentFile != null) {
			return;
		} else if (parentFile.isDirectory()) {
			verifyFilesNotDir(parentFile);
		} else {
			throw new IllegalStateException(
					"parent must be a directory, not a simple file: "
							+ parentFile);
		}
	}

}
