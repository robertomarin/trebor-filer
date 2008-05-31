package org.trebor.filer;

import java.util.Properties;
import java.util.Set;

import org.junit.Test;

public class SystemProperties {

	@Test
	public void test() {
		Properties properties = System.getProperties();
		
		Set<Object> keys = properties.keySet();
		for (Object key : keys) {
			Object value = properties.get(key);
			System.out.println(key +  " " + value);
		}
		
	}
	
}
