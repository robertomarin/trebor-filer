package org.trebor.filer;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.InvalidPropertiesFormatException;
import java.util.Properties;
import java.util.Set;

import org.junit.Test;

public class PropertiesTest {

	@Test
	public void test() {

		Properties properties = new Properties();
		properties.put("teste1", "teste1");
		properties.put("teste2", "teste2");
		properties.put("teste3", "teste3");
		properties.put("teste4", "teste4");

		String fileName = "logs/log_" + System.currentTimeMillis() + ".xml";
		File propertiesFile = new File(fileName);
//		try {
//			propertiesFile.createNewFile();
//		} catch (IOException e1) {
//			// TODO Auto-generated catch block
//			e1.printStackTrace();
//		}

		try {
			properties.storeToXML(new FileOutputStream(propertiesFile), null);
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		

		Properties properties2 = new Properties();
		try {
			properties2.loadFromXML(new FileInputStream(fileName));
		} catch (InvalidPropertiesFormatException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		
		Set<Object> keys = properties2.keySet();
		for (Object key : keys) {
			System.out.println(key + " " + properties2.getProperty(key.toString()));
		}
	}
}
