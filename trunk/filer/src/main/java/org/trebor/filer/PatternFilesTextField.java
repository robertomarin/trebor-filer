package org.trebor.filer;

import javax.swing.JTextField;
import javax.swing.text.Document;

/**
 * @author rmarin 21/09/2007 15:12:04
 */
public class PatternFilesTextField extends JTextField {

	private static final long serialVersionUID = 6965256166510991270L;

	public PatternFilesTextField() {
        super();
    }

    public PatternFilesTextField(Document doc, String text, int columns) {
        super(doc, text, columns);
    }

    public PatternFilesTextField(int columns) {
        super(columns);
    }

    public PatternFilesTextField(String text, int columns) {
        super(text, columns);
    }

    public PatternFilesTextField(String text) {
        super(text);
    }
    
    
//    add
    

}
