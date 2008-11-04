package org.trebor.filer;

import java.awt.Component;
import java.awt.EventQueue;
import java.awt.SplashScreen;

import javax.swing.JFrame;
import javax.swing.JOptionPane;
import javax.swing.SwingUtilities;
import javax.swing.UIManager;

import org.apache.log4j.Logger;
import org.trebor.filer.helper.FilerSystemTray;

public class Main {

	private static Logger logger = Logger.getLogger(Main.class);

	private static final long MINIMUN_TIME = 3000;

	public static void main(final String[] args) {

		final Runnable runner = new Runnable() {

			private Antenna fd;

			public void run() {
				final long startTime = System.currentTimeMillis();
				final SplashScreen splash = SplashScreen.getSplashScreen();

				fd = new Antenna();
				fd.setVisible(true);
				fd.setDefaultCloseOperation(JFrame.HIDE_ON_CLOSE);

				new FilerSystemTray(fd).startSystemTray();
				setLookAndFeel(fd);

				if (splash != null && splash.isVisible()) {
					sleepIfNecessary(startTime);

					if (logger.isInfoEnabled()) {
						logger.info("fechando splash screen " + splash.getImageURL());
					}
					splash.close();
				}

			}

			private void sleepIfNecessary(final long startTime) {
				final long diferenceTime = System.currentTimeMillis() - startTime;

				if (diferenceTime < MINIMUN_TIME) {
					try {
						Thread.sleep(MINIMUN_TIME - diferenceTime);
					} catch (final InterruptedException e) {
						throw new IllegalStateException(e);
					}
				}
			}

		};
		EventQueue.invokeLater(runner);
	}

	private static void setLookAndFeel(final Component fd) {
		final String lookAndFeelClassName = UIManager.getSystemLookAndFeelClassName();
		try {
			UIManager.setLookAndFeel(lookAndFeelClassName);
			SwingUtilities.updateComponentTreeUI(fd);
		} catch (final Exception e) {
			JOptionPane.showMessageDialog(fd, "Can't change look and feel:" + lookAndFeelClassName, "Invalid PLAF",
					JOptionPane.ERROR_MESSAGE);
		}
	}
}
