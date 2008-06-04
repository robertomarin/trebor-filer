/*
 * Copyright (c) 2007, Sun Microsystems, Inc. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 
 * * Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * 
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * * Neither the name of Sun Microsystems, Inc. nor the names of its contributors
 *   may be used to endorse or promote products derived from this software without
 *   specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF
 * THE POSSIBILITY OF SUCH DAMAGE.
 */

package org.trebor.filer;

import java.awt.Color;
import java.io.File;
import java.util.HashMap;
import java.util.Map;

import javax.swing.JOptionPane;
import javax.swing.event.DocumentEvent;
import javax.swing.event.DocumentListener;

import org.trebor.filer.helper.FileHelper;

public class Antenna extends javax.swing.JFrame {

	private static final String[] COLUMN_NAMES = new String[] { "Atual Name", "New Name" };

	private static final long serialVersionUID = 654696448697579224L;

	/** Creates new form Antenna */
	public Antenna() {
		initComponents();
	}

	/**
	 * This method is called from within the constructor to initialize the form.
	 * WARNING: Do NOT modify this code. The content of this method is always
	 * regenerated by the Form Editor.
	 */
	// <editor-fold defaultstate="collapsed" desc="Generated Code">
	private void initComponents() {

		rootRenamingDirectoryPanel = new javax.swing.JPanel();
		selectRootDirectory = new javax.swing.JLabel();
		rootRenamingDirectory = new javax.swing.JTextField();
		preview = new javax.swing.JButton();
		browse = new javax.swing.JButton();
		jPanel2 = new javax.swing.JPanel();
		lowerCase = new javax.swing.JCheckBox();
		folders = new javax.swing.JCheckBox();
		filter = new javax.swing.JTextField();
		filterLabel = new javax.swing.JLabel();
		jPanel3 = new javax.swing.JPanel();
		jScrollPane1 = new javax.swing.JScrollPane();
		table = new javax.swing.JTable();
		rename = new javax.swing.JButton();
		jPanel4 = new javax.swing.JPanel();
		regexLabel = new javax.swing.JLabel();
		replacementLabel = new javax.swing.JLabel();
		regex = new javax.swing.JTextField();
		replacement = new javax.swing.JTextField();

		setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);
		setTitle("FileR");

		rootRenamingDirectoryPanel.setBorder(javax.swing.BorderFactory.createTitledBorder(" Root Renaming Directory "));

		selectRootDirectory.setText("Select root directory:");

		rootRenamingDirectory.addActionListener(new java.awt.event.ActionListener() {
			public void actionPerformed(java.awt.event.ActionEvent evt) {
				rootRenamingDirectoryActionPerformed(evt);
			}
		});

		preview.setText("Preview");
		preview.addActionListener(new java.awt.event.ActionListener() {
			public void actionPerformed(java.awt.event.ActionEvent evt) {
				previewActionPerformed(evt);
			}
		});

		browse.setText("Browse...");
		browse.addActionListener(new java.awt.event.ActionListener() {
			public void actionPerformed(java.awt.event.ActionEvent evt) {
				browseActionPerformed(evt);
			}
		});

		org.jdesktop.layout.GroupLayout rootRenamingDirectoryPanelLayout = new org.jdesktop.layout.GroupLayout(
				rootRenamingDirectoryPanel);
		rootRenamingDirectoryPanel.setLayout(rootRenamingDirectoryPanelLayout);
		rootRenamingDirectoryPanelLayout.setHorizontalGroup(rootRenamingDirectoryPanelLayout.createParallelGroup(
				org.jdesktop.layout.GroupLayout.LEADING).add(
				rootRenamingDirectoryPanelLayout.createSequentialGroup().addContainerGap().add(selectRootDirectory)
						.addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED).add(rootRenamingDirectory,
								org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, 423, Short.MAX_VALUE).addPreferredGap(
								org.jdesktop.layout.LayoutStyle.RELATED).add(browse).addPreferredGap(
								org.jdesktop.layout.LayoutStyle.RELATED).add(preview)));
		rootRenamingDirectoryPanelLayout.setVerticalGroup(rootRenamingDirectoryPanelLayout.createParallelGroup(
				org.jdesktop.layout.GroupLayout.LEADING).add(
				rootRenamingDirectoryPanelLayout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE).add(
						selectRootDirectory).add(preview).add(browse).add(rootRenamingDirectory,
						org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE,
						org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)));

		jPanel2.setBorder(javax.swing.BorderFactory.createTitledBorder(" Rename Options "));
		jPanel2.setAutoscrolls(true);

		lowerCase.setText("Lower Case");
		lowerCase.setBorder(javax.swing.BorderFactory.createEmptyBorder(0, 0, 0, 0));
		lowerCase.setMargin(new java.awt.Insets(0, 0, 0, 0));
		lowerCase.addActionListener(new java.awt.event.ActionListener() {
			public void actionPerformed(java.awt.event.ActionEvent evt) {
				lowerCaseActionPerformed(evt);
			}
		});

		folders.setText("Folders");
		folders.setBorder(javax.swing.BorderFactory.createEmptyBorder(0, 0, 0, 0));
		folders.setMargin(new java.awt.Insets(0, 0, 0, 0));
		folders.addActionListener(new java.awt.event.ActionListener() {
			public void actionPerformed(java.awt.event.ActionEvent evt) {
				foldersActionPerformed(evt);
			}
		});

		filter.addActionListener(new java.awt.event.ActionListener() {
			public void actionPerformed(java.awt.event.ActionEvent evt) {
				filterActionPerformed(evt);
			}
		});

		filterLabel.setText("File filter (comma separated)");

		org.jdesktop.layout.GroupLayout jPanel2Layout = new org.jdesktop.layout.GroupLayout(jPanel2);
		jPanel2.setLayout(jPanel2Layout);
		jPanel2Layout.setHorizontalGroup(jPanel2Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
				.add(
						jPanel2Layout.createSequentialGroup().addContainerGap().add(
								jPanel2Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING).add(
										lowerCase).add(folders)).add(25, 25, 25).add(
								jPanel2Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING, false).add(
										jPanel2Layout.createSequentialGroup().add(filterLabel).add(74, 74, 74)).add(
										jPanel2Layout.createSequentialGroup().add(filter).addContainerGap()))));
		jPanel2Layout.setVerticalGroup(jPanel2Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING).add(
				jPanel2Layout.createSequentialGroup().add(
						jPanel2Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE).add(lowerCase).add(
								filterLabel)).addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED).add(
						jPanel2Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE).add(folders).add(
								filter, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE,
								org.jdesktop.layout.GroupLayout.DEFAULT_SIZE,
								org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)).addContainerGap()));

		jPanel3.setBorder(javax.swing.BorderFactory.createTitledBorder(" Files "));

		model = new javax.swing.table.DefaultTableModel(new Object[][] {

		}, COLUMN_NAMES) {
			boolean[] canEdit = new boolean[] { false, true };

			public boolean isCellEditable(int rowIndex, int columnIndex) {
				return canEdit[columnIndex];
			}
		};
		table.setModel(model);
		jScrollPane1.setViewportView(table);

		rename.setText("Rename!");
		rename.addActionListener(new java.awt.event.ActionListener() {
			public void actionPerformed(java.awt.event.ActionEvent evt) {
				renameActionPerformed(evt);
			}
		});

		org.jdesktop.layout.GroupLayout jPanel3Layout = new org.jdesktop.layout.GroupLayout(jPanel3);
		jPanel3.setLayout(jPanel3Layout);
		jPanel3Layout.setHorizontalGroup(jPanel3Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
				.add(org.jdesktop.layout.GroupLayout.TRAILING,
						jPanel3Layout.createSequentialGroup().addContainerGap().add(rename)).add(
						org.jdesktop.layout.GroupLayout.TRAILING, jScrollPane1,
						org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, 701, Short.MAX_VALUE));
		jPanel3Layout.setVerticalGroup(jPanel3Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING).add(
				org.jdesktop.layout.GroupLayout.TRAILING,
				jPanel3Layout.createSequentialGroup().add(jScrollPane1, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE,
						261, Short.MAX_VALUE).addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED).add(rename)));

		jPanel4.setBorder(javax.swing.BorderFactory.createTitledBorder(" Rename Patterns "));
		jPanel4.setAutoscrolls(true);

		regexLabel.setText("Regex:");

		replacementLabel.setText("Replacement:");

		regex.addActionListener(new java.awt.event.ActionListener() {
			public void actionPerformed(java.awt.event.ActionEvent evt) {
				regexActionPerformed(evt);
			}
		});

		replacement.addActionListener(new java.awt.event.ActionListener() {
			public void actionPerformed(java.awt.event.ActionEvent evt) {
				replacementActionPerformed(evt);
			}
		});

		org.jdesktop.layout.GroupLayout jPanel4Layout = new org.jdesktop.layout.GroupLayout(jPanel4);
		jPanel4.setLayout(jPanel4Layout);
		jPanel4Layout.setHorizontalGroup(jPanel4Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
				.add(
						jPanel4Layout.createSequentialGroup().addContainerGap().add(
								jPanel4Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING).add(
										regexLabel).add(regex, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 171,
										org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)).addPreferredGap(
								org.jdesktop.layout.LayoutStyle.RELATED).add(
								jPanel4Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING).add(
										jPanel4Layout.createSequentialGroup().add(replacementLabel).addContainerGap(
												107, Short.MAX_VALUE)).add(replacement,
										org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, 173, Short.MAX_VALUE))));
		jPanel4Layout.setVerticalGroup(jPanel4Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING).add(
				jPanel4Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING).add(regexLabel).add(
						org.jdesktop.layout.GroupLayout.TRAILING,
						jPanel4Layout.createSequentialGroup().add(replacementLabel).addPreferredGap(
								org.jdesktop.layout.LayoutStyle.RELATED).add(
								jPanel4Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE).add(regex,
										org.jdesktop.layout.GroupLayout.PREFERRED_SIZE,
										org.jdesktop.layout.GroupLayout.DEFAULT_SIZE,
										org.jdesktop.layout.GroupLayout.PREFERRED_SIZE).add(replacement,
										org.jdesktop.layout.GroupLayout.PREFERRED_SIZE,
										org.jdesktop.layout.GroupLayout.DEFAULT_SIZE,
										org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)))));

		org.jdesktop.layout.GroupLayout layout = new org.jdesktop.layout.GroupLayout(getContentPane());
		getContentPane().setLayout(layout);
		layout.setHorizontalGroup(layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING).add(
				org.jdesktop.layout.GroupLayout.TRAILING,
				layout.createSequentialGroup().addContainerGap().add(
						layout.createParallelGroup(org.jdesktop.layout.GroupLayout.TRAILING).add(
								org.jdesktop.layout.GroupLayout.LEADING, jPanel3,
								org.jdesktop.layout.GroupLayout.DEFAULT_SIZE,
								org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE).add(
								org.jdesktop.layout.GroupLayout.LEADING, rootRenamingDirectoryPanel,
								org.jdesktop.layout.GroupLayout.DEFAULT_SIZE,
								org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE).add(
								org.jdesktop.layout.GroupLayout.LEADING,
								layout.createSequentialGroup().add(jPanel2,
										org.jdesktop.layout.GroupLayout.PREFERRED_SIZE,
										org.jdesktop.layout.GroupLayout.DEFAULT_SIZE,
										org.jdesktop.layout.GroupLayout.PREFERRED_SIZE).addPreferredGap(
										org.jdesktop.layout.LayoutStyle.RELATED).add(jPanel4,
										org.jdesktop.layout.GroupLayout.DEFAULT_SIZE,
										org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)))
						.addContainerGap()));
		layout.setVerticalGroup(layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING).add(
				layout.createSequentialGroup().addContainerGap().add(rootRenamingDirectoryPanel,
						org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE,
						org.jdesktop.layout.GroupLayout.PREFERRED_SIZE).addPreferredGap(
						org.jdesktop.layout.LayoutStyle.RELATED).add(
						layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING, false).add(jPanel2, 0, 70,
								Short.MAX_VALUE).add(jPanel4, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE,
								org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)).addPreferredGap(
						org.jdesktop.layout.LayoutStyle.RELATED).add(jPanel3,
						org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE,
						Short.MAX_VALUE).addContainerGap()));

		myStuff();
		pack();
	}// </editor-fold>

	private void myStuff() {
		rootRenamingDirectory.getDocument().addDocumentListener(new DocumentListener() {

			public void changedUpdate(DocumentEvent e) {
				verify();
			}

			public void insertUpdate(DocumentEvent e) {
				verify();
			}

			public void removeUpdate(DocumentEvent e) {
				verify();
			}
		});
		verify();
	}

	private void renameActionPerformed(java.awt.event.ActionEvent evt) {

		for (int i = 0; i < model.getRowCount(); i++) {
			Object valueAt = model.getValueAt(i, 1);
			System.out.println(valueAt + " " + valueAt.getClass());
		}

		if (fileHelper.rename(files)) {
			JOptionPane.showMessageDialog(null, "arquivos renomeados corretamente!\n Veja seu log aqui: "
			/* fileHelper.getLogFileName() */, "Rename Success", JOptionPane.INFORMATION_MESSAGE);
		} else {
			JOptionPane.showMessageDialog(null, "erro ao renomear arquivos!", "Rename Fail", JOptionPane.ERROR_MESSAGE);
		}

		files = null;

		eraseTableModel();
		verify();
	}

	private void eraseTableModel() {
		model.setDataVector(null, COLUMN_NAMES);
		table.update(table.getGraphics());
	}

	private void previewActionPerformed(java.awt.event.ActionEvent evt) {
		boolean filer = filer();
		rename.setEnabled(filer);
		preview.setEnabled(filer);
	}

	private void browseActionPerformed(java.awt.event.ActionEvent evt) {
		browse();
	}

	private void lowerCaseActionPerformed(java.awt.event.ActionEvent evt) {
		// TODO add your handling code here:
	}

	private void foldersActionPerformed(java.awt.event.ActionEvent evt) {
		// TODO add your handling code here:
	}

	private void filterActionPerformed(java.awt.event.ActionEvent evt) {
		// TODO add your handling code here:
	}

	private void regexActionPerformed(java.awt.event.ActionEvent evt) {
		// TODO add your handling code here:
	}

	private void replacementActionPerformed(java.awt.event.ActionEvent evt) {
		// TODO add your handling code here:
	}

	private void rootRenamingDirectoryActionPerformed(java.awt.event.ActionEvent evt) {
		browse();
	}

	/**
	 * @param args
	 *            the command line arguments
	 */
	public static void main(String args[]) {
		java.awt.EventQueue.invokeLater(new Runnable() {
			public void run() {
				new Antenna().setVisible(true);
			}
		});
	}

	// Variables declaration - do not modify
	private javax.swing.JButton browse;
	private javax.swing.JTextField filter;
	private javax.swing.JLabel filterLabel;
	private javax.swing.JCheckBox folders;
	private javax.swing.JPanel jPanel2;
	private javax.swing.JPanel jPanel3;
	private javax.swing.JPanel jPanel4;
	private javax.swing.JScrollPane jScrollPane1;
	private javax.swing.JCheckBox lowerCase;
	private javax.swing.JButton preview;
	private javax.swing.JTextField regex;
	private javax.swing.JLabel regexLabel;
	private javax.swing.JButton rename;
	private javax.swing.JTextField replacement;
	private javax.swing.JLabel replacementLabel;
	private javax.swing.JTextField rootRenamingDirectory;
	private javax.swing.JPanel rootRenamingDirectoryPanel;
	private javax.swing.JLabel selectRootDirectory;
	private javax.swing.JTable table;
	private javax.swing.table.DefaultTableModel model;
	// End of variables declaration

	private FileHelper fileHelper = new FileHelper();
	private Map<File, File> files = new HashMap<File, File>();

	private void verify() {
		Color foreground = null;

		if (fileHelper.isDir(rootRenamingDirectory.getText())) {
			foreground = Color.BLACK;
			preview.setEnabled(true);
			if (model.getRowCount() > 0)
				rename.setEnabled(true);
		} else {
			foreground = Color.RED;
			preview.setEnabled(false);
		}

		rename.setEnabled(false);
		rootRenamingDirectory.setForeground(foreground);
	}

	public boolean filer() {
		this.files = fileHelper.filer(rootRenamingDirectory.getText(), regex.getText(), replacement.getText(), filter
				.getText(), lowerCase.isSelected(), folders.isSelected());

		// TableModel model = new DefaultTableModel(new String[] { "Old Name",
		// "New Name" }, files.size());
		// int i = 0;
		eraseTableModel();
		for (File key : files.keySet()) {
			// model.setValueAt(key.getName(), i, 0);
			// model.insertRow(i++, new File[] {key, files.get(key)});
			model.addRow(new String[] { key.getName(), files.get(key).getName() });
		}

		// Object[] array = files.keySet().toArray();
		// Object[] array2 = files.values().toArray();
		// model.

		// table.setModel(model);
		return !files.isEmpty();
	}

	private void browse() {
		File dirRoot = fileHelper.getDirRoot(this);
		if (dirRoot != null) {
			rootRenamingDirectory.setText(dirRoot.getAbsolutePath());
		}
	}

}
