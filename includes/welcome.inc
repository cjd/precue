<?PHP
	function welcome() {
		global $fver, $lyricuever;
        print '
			<FONT SIZE="6"><B>W</B></FONT><FONT SIZE="4"><U>elcome to Precue!</FONT></U><BR><BR><FONT SIZE="3">

			Precue version <?PHP echo $fver; ?> for <a href="http://www.lyricue.org">Lyricue</a> version <?PHP echo $lyricuever; ?> gives
			you remote access to all of the Lyricue databases.<BR><BR>

			The remote lyric management functions provided by Precue give you the ability to perform the following tasks:
			<UL>
				<LI>Retrieve lyrics for songs</LI>
				<LI>Retrieve verse contents for a user specified bible verse range</LI>
				<LI>View and edit any Lyricue playlist</LI>
				<LI>Add new songs to the database</LI>
				<LI>Search through the lyrics of all available songs.</LI>
				<LI>View and analyse song usage statistics</LI>
				<LI>View all images and backgrounds in the media database</LI>
			</UL>
            For more infomation see the <a href="http://www.lyricue.org/precue">Precue website</a>
';
    }
?>
