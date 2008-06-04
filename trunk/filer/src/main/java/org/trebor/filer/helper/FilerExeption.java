package org.trebor.filer.helper;

public class FilerExeption extends RuntimeException {

	private static final long serialVersionUID = 1L;

	public FilerExeption() {
		super();
	}

	public FilerExeption(String message, Throwable cause) {
		super(message, cause);
	}

	public FilerExeption(String message) {
		super(message);
	}

	public FilerExeption(Throwable cause) {
		super(cause);
	}

}
