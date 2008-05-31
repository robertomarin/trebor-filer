package org.trebor.filer;

import java.awt.AWTException;
import java.awt.Image;
import java.awt.MenuItem;
import java.awt.PopupMenu;
import java.awt.SystemTray;
import java.awt.Toolkit;
import java.awt.TrayIcon;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.JOptionPane;

public class Exemplo1 {

	public static void main(String[] args) throws AWTException {
		//Obtem o SystemTray da plataforma
		SystemTray tray = SystemTray.getSystemTray();

		//Cria um menu Popup para o trayIcon
		PopupMenu popupMenu = new PopupMenu();
		MenuItem menuItem = new MenuItem("Sobre");
		menuItem.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				JOptionPane.showMessageDialog(null,"Exemplo de um SystemTray no Java 6\n Por Alexandro D. Almeida (http://www.xandrix.com.br)", "Sobre", JOptionPane.INFORMATION_MESSAGE);
			}});
		
		popupMenu.add(menuItem);
		popupMenu.add(new MenuItem("-"));

		menuItem = new MenuItem("Exit");
		menuItem.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				int opt = JOptionPane.showConfirmDialog(null, "Confirma sair ?", "Sair", JOptionPane.YES_NO_OPTION);
				if (opt == JOptionPane.OK_OPTION) {
					System.exit(0);
				}
			}});
		popupMenu.add(menuItem);
		

		//Cria o tryIcon
		Image imageIcon = Toolkit.getDefaultToolkit().getImage(Exemplo1.class.getClassLoader().getResource("tray.jpg"));
		TrayIcon trayIcon = new TrayIcon(imageIcon, "TryIcon Java 6", popupMenu);
		
		tray.add(trayIcon);	
	}
}
