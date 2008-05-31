package org.trebor.filer.helper;

import java.awt.AWTException;
import java.awt.Image;
import java.awt.MenuItem;
import java.awt.MenuShortcut;
import java.awt.PopupMenu;
import java.awt.SystemTray;
import java.awt.Toolkit;
import java.awt.TrayIcon;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.KeyEvent;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.net.URL;

import javax.swing.JOptionPane;

import org.apache.log4j.Logger;
import org.trebor.filer.FileDemonstration;


public class FilerSystemTray {

    private static final Logger logger = Logger.getLogger(FilerSystemTray.class);
    
    private final FileDemonstration fd;

    private TrayIcon icon;

    private SystemTray tray;
    
    private final String iconURL = "filer-logo.png";

    public FilerSystemTray(FileDemonstration fd) {
        this.fd = fd;

    }

    public void startSystemTray() {
        if (logger.isInfoEnabled()) {
            logger.info("iniciando system tray");
            logger.info("tray icon " + iconURL);
        }
        
        tray = SystemTray.getSystemTray();
        URL imageURL = this.getClass().getClassLoader().getResource(iconURL);
        Image image = Toolkit.getDefaultToolkit().getImage(imageURL);

        icon = new TrayIcon(image, "FileR - Easy rename your files", getPopupMenu());
        icon.setImageAutoSize(true);

        try {
            tray.add(icon);
        } catch (AWTException e) {
            throw new IllegalStateException(e);
        }

        icon.addMouseListener(new MouseListener() {

            public void mouseClicked(MouseEvent e) {
            }

            public void mouseEntered(MouseEvent e) {
            }

            public void mouseExited(MouseEvent e) {
            }

            public void mousePressed(MouseEvent e) {
                if (e.getButton() == MouseEvent.BUTTON3)
                    return;

                fd.requestFocus();
                System.out.println("fd.isActive: " + fd.isActive());
                if (fd.isVisible()) {
                    fd.toBack();
                    fd.setVisible(false);
                } else {
                    fd.setVisible(true);
                    fd.toFront();
                }
            }

            public void mouseReleased(MouseEvent e) {
            }

        });
    }

    private PopupMenu getPopupMenu() {

        PopupMenu popupMenu = new PopupMenu();
        MenuItem menuItem = new MenuItem("Sobre");
        menuItem.addActionListener(new ActionListener() {

            public void actionPerformed(ActionEvent e) {
                JOptionPane.showMessageDialog(fd, "FileR - A simple way to File Renaming", "Sobre", JOptionPane.INFORMATION_MESSAGE);
            }
        });

        popupMenu.add(menuItem);
        popupMenu.add(new MenuItem("-"));

        menuItem = new MenuItem("Exit", new MenuShortcut(KeyEvent.VK_E, false));

        menuItem.addActionListener(new ActionListener() {

            public void actionPerformed(ActionEvent e) {
                System.exit(0);
            }
        });

        popupMenu.add(menuItem);
        return popupMenu;
    }

    public TrayIcon getIcon() {
        return icon;
    }

    public SystemTray getTray() {
        return tray;
    }

}
