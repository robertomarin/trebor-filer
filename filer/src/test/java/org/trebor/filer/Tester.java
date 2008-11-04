package org.trebor.filer;

import java.io.File;
import java.io.IOException;
import java.io.RandomAccessFile;

import org.jaudiotagger.audio.AudioFileIO;
import org.jaudiotagger.audio.exceptions.CannotReadException;
import org.jaudiotagger.audio.exceptions.InvalidAudioFrameException;
import org.jaudiotagger.audio.exceptions.ReadOnlyFileException;
import org.jaudiotagger.audio.mp3.MP3AudioHeader;
import org.jaudiotagger.audio.mp3.MP3File;
import org.jaudiotagger.tag.Tag;
import org.jaudiotagger.tag.TagException;
import org.junit.Test;

public class Tester {

	@Test
	public void test() throws CannotReadException, IOException, TagException, ReadOnlyFileException,
	InvalidAudioFrameException {

		final String s = "motörhead";

		System.out.println(s.replaceAll("(motörhead)", "$1sss"));

		final String a = "C:/Users/Roberto Marin/Music/Incomplete/lenine - labiata (2008)/05 - lá vem a cidade.mp3";
		final File testFile = new File(a);
		new RandomAccessFile(testFile, "rw");
		final MP3File f = (MP3File) AudioFileIO.read(testFile);
		final MP3AudioHeader audioHeader = f.getMP3AudioHeader();
		System.out.println(audioHeader.getTrackLength());
		System.out.println(audioHeader.getSampleRateAsNumber());
		System.out.println(audioHeader.getChannels());
		System.out.println(audioHeader.isVariableBitRate());

		final Tag tag = f.getTag();
		System.out.println(tag.getFirstArtist());
		System.out.println(tag.getFirstAlbum());
		System.out.println(tag.getFirstTrack());

	}

}
