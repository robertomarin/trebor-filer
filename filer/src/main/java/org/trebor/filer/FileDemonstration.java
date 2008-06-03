package org.trebor.filer;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.FlowLayout;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.FocusEvent;
import java.awt.event.FocusListener;
import java.io.File;
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
import javax.swing.plaf.metal.MetalIconFactory.FolderIcon16;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.TableModel;

import org.trebor.filer.helper.FileHelper;

public class FileDemonstration extends JFrame {

	private static final long serialVersionUID = 1L;

	private JTable table;

	private JTextField rootRenamingDirectory;

	private JButton preview;

	private Map<File, File> files;

	private JCheckBox lowerCase;

	private JTextField filter;

	private JTextField pattern;

	private JComboBox justBox;

	private JButton rename;

	private FileHelper fileHelper;

	public FileDemonstration() {

		super("FileR");

		fileHelper = new FileHelper();
		setLayout(new BorderLayout(10, 10));

		montaCentro();
		montaSul();
		montaNorte();

		this.setSize(700, 500);
		this.setResizable(true);
		this.verify();
	}

	private void montaNorte() {
		// final JPanel north = new JPanel(new GridLayout(1, 6, 10, 10));
		final JPanel north = new JPanel(new FlowLayout(FlowLayout.LEFT));
		north.add(new JLabel("Select root directory:"));

		rootRenamingDirectory = new JTextField("d:/testes", 20);
		// rootRenamingDirectory.getDocument().addDocumentListener(new
		// DocumentListener() {
		//
		// public void changedUpdate(DocumentEvent e) {
		// verify();
		// }
		//
		// public void insertUpdate(DocumentEvent e) {
		// verify();
		// }
		//
		// public void removeUpdate(DocumentEvent e) {
		// verify();
		// }
		// });

		north.add(rootRenamingDirectory);

		JButton browseButton = new JButton("Browse...");
		browseButton.addActionListener(new ActionListener() {

			public void actionPerformed(ActionEvent e) {
				// File dirRoot = getDirRoot();
				// if (dirRoot != null)
				// rootRenamingDirectory.setText(dirRoot.getAbsolutePath());
			}
		});

		north.add(browseButton);

		preview = new JButton("Preview");
		preview.setMaximumSize(new Dimension(20, 5));
		preview.addActionListener(new ActionListener() {

			public void actionPerformed(ActionEvent e) {
				// search();
			}
		});
		north.add(preview);

		add(north, BorderLayout.NORTH);
	}

	private void montaCentro() {
		final JPanel center = new JPanel(new GridLayout(1, 1, 10, 10));
		table = new JTable();
		JScrollPane pane = new JScrollPane(table, JScrollPane.VERTICAL_SCROLLBAR_ALWAYS,
				JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);
		center.add(pane);
		center.setEnabled(true);
		this.add(center, BorderLayout.CENTER);
	}

	private void montaSul() {
		// final JPanel south = new JPanel(new GridLayout(6, 1, 10, 10));
		final JPanel south = new JPanel(new FlowLayout(FlowLayout.LEFT));
		lowerCase = new JCheckBox("lower case");

		justBox = new JComboBox(new JustBox[] { JustBox.FILES, JustBox.FOLDERS });
		justBox.addActionListener(new ActionListener() {

			public void actionPerformed(ActionEvent e) {
				// search();
			}

		});

		filter = new JTextField(10);

		pattern = new JTextField(10);
		pattern.setText(FileHelper.DEFAULT_FILTER);
		pattern.setForeground(Color.gray);
		pattern.addFocusListener(new FocusListener() {

			public void focusGained(FocusEvent e) {
				// pattern.setText("");
				// pattern.setForeground(Color.BLACK);
			}

			public void focusLost(FocusEvent e) {
				// if (GenericValidator.isBlankOrNull(pattern.getText())) {
				// pattern.setText("filtro de arquivos");
				// pattern.setForeground(Color.GRAY);
				// }
			}

		});

		south.add(lowerCase);
		south.add(justBox);
		south.add(filter);
		south.add(pattern);
		south.add(this.getRenameButton());

		this.add(south, BorderLayout.WEST);
	}

	private JButton getRenameButton() {
		this.rename = new JButton("rename!");
		this.rename.setSize(10, 10);
		this.rename.setMaximumSize(new Dimension(30, 4));
		this.rename.setEnabled(false);

		this.rename.addActionListener(new ActionListener() {

			public void actionPerformed(ActionEvent e) {

				// if (fileHelper.rename(files)) {
				// JOptionPane.showMessageDialog(null, "arquivos renomeados
				// corretamente!\n Veja seu log aqui: "
				// /* fileHelper.getLogFileName() */, "Rename Success",
				// JOptionPane.INFORMATION_MESSAGE);
				// } else {
				// JOptionPane.showMessageDialog(null, "erro ao renomear
				// arquivos!", "Rename Fail",
				// JOptionPane.ERROR_MESSAGE);
				// }
				//
				// files = null;
				// table.setModel(new DefaultTableModel(new String[] { "Old
				// Name", "New Name" }, 0));
			}

		});

		rename.setEnabled(false);
		return this.rename;
	}

	private void verify() {
		boolean itsADirPath = fileHelper.itsADirPath(rootRenamingDirectory.getText());

		Color foreground = null;
		if (itsADirPath) {
			foreground = Color.BLACK;
			if (files != null && !files.isEmpty())
				rename.setEnabled(true);
		} else {
			foreground = Color.RED;
			rename.setEnabled(false);
		}

		rootRenamingDirectory.setForeground(foreground);
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

	private boolean filer(File dirRoot) {
//		this.files = fileHelper.filer(dirRoot, pattern.getText(), filter.getText(), lowerCase.isSelected(), folders);

		TableModel model = new DefaultTableModel(new String[] { "Old Name", "New Name" }, files.size());
		int i = 0;
		for (File key : files.keySet()) {
			model.setValueAt(key.getName(), i, 0);
			model.setValueAt(files.get(key).getName(), i, 1);
			i++;
		}

		table.setModel(model);
		return !files.isEmpty();
	}

	private File getRaiz() {
		File dirRoot = new File(rootRenamingDirectory.getText());
		if (!fileHelper.isValidRootFile(dirRoot)) {
			JOptionPane.showMessageDialog(this, "Invalid dir-root: " + dirRoot, "Invalid Dir",
					JOptionPane.ERROR_MESSAGE);
		}

		return dirRoot;
	}

	private void search() {
		rename.setEnabled(filer(getRaiz()));
	}
}
