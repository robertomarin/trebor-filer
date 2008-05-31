package org.trebor.filer;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.EventQueue;
import java.awt.Graphics2D;
import java.awt.SplashScreen;
import java.io.File;

import javax.swing.JFrame;
import javax.swing.JLabel;

public class SplashScreenTest {
	
	public static void main(String args[]) {
		Runnable runner = new Runnable() {
			public void run() {
				SplashScreen splash = SplashScreen.getSplashScreen();
				System.out.println(new File(".").getAbsolutePath());
				System.out.println(splash);
				Graphics2D g = splash.createGraphics();
				Dimension dim = splash.getSize();
				Color colors[] = { Color.RED, Color.ORANGE, Color.YELLOW, Color.GREEN, Color.BLUE,
						Color.MAGENTA };
				for (int i = 0; i < 10; i++) {
					g.setColor(colors[i % colors.length]);
					g.fillRect(50, 50, dim.width - 100, dim.height - 100);
					splash.update();
					try {
						Thread.sleep(250);
					} catch (InterruptedException ignored) {
					}
				}
				JFrame frame = new JFrame("Splash Me2");
				frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
				JLabel label = new JLabel("Hello, Splash", JLabel.CENTER);
				frame.add(label, BorderLayout.CENTER);
				frame.setSize(300, 95);
				frame.setVisible(true);
			}
		};
		EventQueue.invokeLater(runner);
	}
}
