package org.trebor.filer;

import java.io.Console;

public class Tester {

	public static void main(String[] args) {
	
		String s = "mot�rhead";
		
		System.out.println(s.replaceAll("(mot�rhead)", "$1sss"));

	}
}
