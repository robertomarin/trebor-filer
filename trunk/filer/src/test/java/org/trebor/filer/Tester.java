package org.trebor.filer;

import java.io.Console;

public class Tester {

	public static void main(String[] args) {
		Console console = System.console();
	
		if (console != null) {
			String readLine = console.readLine();
			
			System.out.println("linha: " + readLine);
		}
		

	}
}
