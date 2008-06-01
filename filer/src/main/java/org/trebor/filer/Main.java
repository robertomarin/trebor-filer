package org.trebor.filer;

import java.awt.EventQueue;
import java.awt.SplashScreen;

import javax.swing.JFrame;

import org.apache.log4j.Logger;
import org.trebor.filer.helper.FilerSystemTray;

public class Main {

	private static Logger logger = Logger.getLogger(Main.class);

	private static final long MINIMUN_TIME = 3000;

	public static void main(String[] args) {

		Runnable runner = new Runnable() {

			private FileDemonstration fd;

			public void run() {
				long startTime = System.currentTimeMillis();
				SplashScreen splash = SplashScreen.getSplashScreen();

				fd = new FileDemonstration();
				fd.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

				new FilerSystemTray(fd).startSystemTray();

				if (splash != null && splash.isVisible()) {
					sleepIfNecessary(startTime);

					if (logger.isInfoEnabled()) {
						logger.info("fechando splash screen " + splash.getImageURL());
					}
					splash.close();
				}

			}

			private void sleepIfNecessary(long startTime) {
				long diferenceTime = System.currentTimeMillis() - startTime;

				if (diferenceTime < MINIMUN_TIME) {
					try {
						Thread.sleep(MINIMUN_TIME - diferenceTime);
					} catch (InterruptedException e) {
						throw new IllegalStateException(e);
					}
				}
			}

		};
		EventQueue.invokeLater(runner);
	}

}
