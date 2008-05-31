package org.trebor.filer;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.GridLayout;
import java.awt.LayoutManager;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.FocusEvent;
import java.awt.event.FocusListener;
import java.io.File;
import java.util.Arrays;
import java.util.List;
import java.util.Map;

import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JComboBox;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.event.DocumentEvent;
import javax.swing.event.DocumentListener;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.TableModel;

import org.apache.commons.validator.GenericValidator;
import org.trebor.filer.helper.FileHelper;
import org.trebor.filer.helper.FileRenamerHelper;
import org.trebor.filer.log.LogWriterHelper;


public class FileDemonstration extends JFrame {

	private static final long serialVersionUID = 1L;

	private JTable table;

	private TableModel model;

	private LayoutManager layout;

	private File dirRoot;

	private JTextField dirRootPath;

	private JButton previewButton;

	private Map<File, File> files;

	private JCheckBox lowerCase;

	private JTextField patternReplace;

	private JTextField patternFiles;

	private JComboBox justBox;

	private JButton rename;

	private final JPanel north;

	private final JPanel south;

	private final JPanel center;

	private static final String patternMessage = "filtro de arquivos";
	
	private FileHelper fileHelper;

	public FileDemonstration() {

		super("FileR");
		
		fileHelper = new FileHelper();
		
		initialize();

		layout = new BorderLayout(10, 10);
		setLayout(layout);

		JLabel label = new JLabel("Select root directory:");

		dirRootPath = new JTextField("h:/testes", 28);

		dirRootPath.getDocument().addDocumentListener(new DocumentListener() {

			public void changedUpdate(DocumentEvent e) {
				hidePreviewButton();
			}

			public void insertUpdate(DocumentEvent e) {
				hidePreviewButton();
			}

			public void removeUpdate(DocumentEvent e) {
				hidePreviewButton();
			}
		});

		JButton button = new JButton("Browse...");

		button.addActionListener(new ActionListener() {

			public void actionPerformed(ActionEvent e) {
				File dirRoot = getDirRoot();
				if (dirRoot != null)
					dirRootPath.setText(dirRoot.getAbsolutePath());
			}
		});

		previewButton = new JButton("Preview");
		previewButton.addActionListener(new ActionListener() {

			public void actionPerformed(ActionEvent e) {
				search();
			}
		});

		north = new JPanel();
		north.add(label);
		north.add(dirRootPath);
		north.add(button);
		north.add(previewButton);
		add(north, BorderLayout.NORTH);

		lowerCase = new JCheckBox("lower case");

		patternReplace = new JTextField(10);
		patternFiles = new JTextField(10);

		patternFiles.setText(patternMessage);
		patternFiles.setForeground(Color.gray);

		patternFiles.addFocusListener(new FocusListener() {

			public void focusGained(FocusEvent e) {
				patternFiles.setText("");
				patternFiles.setForeground(Color.black);
			}

			public void focusLost(FocusEvent e) {
				if (GenericValidator.isBlankOrNull(patternFiles.getText())) {
					patternFiles.setText("filtro de arquivos");
					patternFiles.setForeground(Color.gray);
				}
			}

		});

		justBox = new JComboBox(new JustBox[] { JustBox.FILES, JustBox.FOLDERS });
		justBox.addActionListener(new ActionListener() {

			public void actionPerformed(ActionEvent e) {
				search();
			}

		});

		center = new JPanel(new GridLayout(1, 5));
		this.add(center, BorderLayout.CENTER);

		south = new JPanel(new GridLayout(1, 4));
		south.add(lowerCase);
		south.add(justBox);
		south.add(patternReplace);
		south.add(patternFiles);
		
		this.add(south, BorderLayout.SOUTH);
		south.add(this.getRenameButton());

		table = new JTable(model);

		JScrollPane pane = new JScrollPane(table, JScrollPane.VERTICAL_SCROLLBAR_ALWAYS,
				JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);
		center.add(pane);
		center.setEnabled(false);

		this.setSize(700, 550);
		this.setResizable(true);
		this.hidePreviewButton();
	}

	private JButton getRenameButton() {
		this.rename = new JButton("rename!");
		this.rename.setMaximumSize(new Dimension(5, 4));
		this.rename.setEnabled(false);
		
		this.rename.addActionListener(new ActionListener() {
			
			public void actionPerformed(ActionEvent e) {

				LogWriterHelper helper = new LogWriterHelper(files);
				if (helper.storeToXML()) {
					for (File file : files.keySet()) {
						file.renameTo(files.get(file));
					}

					JOptionPane.showMessageDialog(center, "arquivos renomeados corretamente!\n Veja seu log aqui: "
							+ helper.getLogFileName(), "Rename Success", JOptionPane.INFORMATION_MESSAGE);
				} else {
					JOptionPane.showMessageDialog(center, "erro ao renomear arquivos!", "Rename Fail", JOptionPane.ERROR_MESSAGE);
				}

				rename.setEnabled(false);
				files = null;
				table.setModel(new DefaultTableModel(new String[] { "Old Name", "New Name" }, 0));
			}
		});
		
		return this.rename;
	}

	private void initialize() {
		this.setSize(new Dimension(400, 400));
		this.setTitle("FileR");
	}

	private void hidePreviewButton() {
		boolean itsADirPath = fileHelper.itsADirPath(dirRootPath.getText());

		Color foreground = null;
		if (itsADirPath) {
			foreground = Color.BLACK;
		} else {
			foreground = Color.RED;
		}

		dirRootPath.setForeground(foreground);
	}

	private File getDirRoot() {
		JFileChooser fileChooser = new JFileChooser();
		fileChooser.setFileSelectionMode(JFileChooser.DIRECTORIES_ONLY);

		if (JFileChooser.CANCEL_OPTION == fileChooser.showOpenDialog(this)) {
			return null;
		}

		File dirRoot;
		dirRoot = fileChooser.getSelectedFile();

		return dirRoot;
	}

	private boolean isValidDirRoot(File dirRoot) {
		return dirRoot != null && isValidRootFile(dirRoot) && dirRoot.exists();

	}

	private boolean isValidRootFile(File file) {
		List<File> l = Arrays.asList(File.listRoots());
		return !l.contains(file);
	}

	private void invalidDirRootMessage() {
		JOptionPane.showMessageDialog(this, "Invalid dir-root: " + dirRoot, "Invalid Dir", JOptionPane.ERROR_MESSAGE);
	}

	private void filer() {
		
		String filter = !patternMessage.equals(patternFiles.getText()) ? patternFiles.getText() : "";
		
		FileRenamerHelper filer = new FileRenamerHelper(patternReplace.getText(), filter, lowerCase.isSelected(),
				JustBox.class.cast(justBox.getSelectedItem()));

		files = filer.generateFileNames(dirRoot);

		model = new DefaultTableModel(new String[] { "Old Name", "New Name" }, files.size());

		int i = 0;
		for (File key : files.keySet()) {
			model.setValueAt(key.getName(), i, 0);
			model.setValueAt(files.get(key).getName(), i, 1);
			i++;
		}

		table.setModel(model);

	}

	private void search() {

		dirRoot = new File(dirRootPath.getText());
		if (isValidDirRoot(dirRoot)) {
			filer();
		} else {
			invalidDirRootMessage();
		}

		rename.setEnabled(true);
		center.setEnabled(true);
	}

}
