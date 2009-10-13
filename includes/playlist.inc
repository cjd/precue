<?PHP

// ----------------------------------
// playlist functions
// ----------------------------------


	function playlist($plfunc,$song,$playlistId) {	
	global $db;
	if ($plfunc==clear) {
		if (!$playlistId) {
			echo "<B>Please select the playlist you wish to clear:</B><BR>";
			echo "<FONT SIZE=3><I>Note: Clearing does not delete the playlist but only the items within it. For now this only clears basic playlists (2 level lists).</I><BR><BR>";
			$result = mysql_query("SELECT * FROM playlists LEFT JOIN playlist ON playlist.data=playlists.id AND playlist.data NOT LIKE '%-%' AND (type='play' OR type='sub') WHERE data IS NULL AND playlists.id > 0 ORDER BY id", $db);
			while ($thisrow = mysql_fetch_array($result)) {
				echo "<A HREF=lyricue.php?mode=playlist&action=plclear&playlistId=$thisrow[id]>$thisrow[title]</A><BR>";	
			}
		} else {
			//get playlist ids for the items in this playlist
			$result = mysql_query("SELECT data FROM playlist WHERE playlist=$playlistId", $db);
			echo "Deleted entries for....<BR><BR>";
			while ($thispid = mysql_fetch_array($result)) {
				//delete the page subentries (pages for songs)
				mysql_query("DELETE FROM playlist WHERE playlist=$thispid[data]",$db);
				//delete the playlist linking entries
				mysql_query("DELETE FROM playlist WHERE data=$thispid[data]",$db);
				$title = mysql_fetch_array(mysql_query("SELECT title FROM playlists where id=$thispid[data]",$db));

				//delete the main playlist entry for this song
				mysql_query("DELETE FROM playlists WHERE id=$thispid[data]",$db);
				echo "$title[title]<BR>";
			}
			echo "<BR><BR><B>The playlist has been cleared.</B>";
		}		
	}


	elseif ($plfunc==show) {

	//-----------------Show the Playlist------------------------------
		if (!$playlistId) {
			echo "<B>Please select the playlist you wish to display:<BR>";
			$result = mysql_query("SELECT * FROM playlists LEFT JOIN playlist ON playlist.data=playlists.id AND playlist.data NOT LIKE '%-%' AND (type='play' OR type='sub') WHERE data IS NULL AND playlists.id > 0 ORDER BY id", $db);
			while ($thisrow = mysql_fetch_array($result)) {
				echo "<A HREF=lyricue.php?mode=playlist&action=showpl&playlistId=$thisrow[id]>$thisrow[title]</A><BR>";	
			}
		} else {
		
	?>

	<TABLE class="songlist">

	<TR class="header"><TD WIDTH="75%"><B>Title</B></TD><TD WIDTH="25%"><B>Artist</B></TD></TR>

	<?PHP

	//get playlist ids of song in currently selected playlist
	$pids = mysql_query("SELECT data FROM playlist WHERE playlist=$playlistId AND type='play' ORDER BY playorder", $db);

	while ($thispid = mysql_fetch_array($pids)) {

		//get song id of this song
		$sid = mysql_query("SELECT ref FROM playlists WHERE id = $thispid[data]", $db);
		$thissid = mysql_fetch_array($sid);

		$plresult1 = mysql_query("SELECT id, title, artist FROM lyricMain WHERE id=\"$thissid[ref]\"", $db);

		while ($currentsong = mysql_fetch_array($plresult1)) {

	
		echo "\t<TR><TD class=\"title\"><A HREF=$PHP_SELF?mode=playlist&action=showsong&song=$currentsong[id]>$currentsong[title]</A></TD><TD class=\"artist\">$currentsong[artist]</TD></TR>\n";


		}
	}
		
	?></TABLE><?PHP
		}
	}

	elseif ($plfunc==Add) {

		if (!$playlistId) {
			echo "<B>Please select the playlist you wish to add the song to:<BR>";
			$result = mysql_query("SELECT * FROM playlists LEFT JOIN playlist ON playlist.data=playlists.id AND playlist.data NOT LIKE '%-%' AND (type='play' OR type='sub') WHERE data IS NULL AND playlists.id > 0 ORDER BY id", $db);
			while ($thisrow = mysql_fetch_array($result)) {
				echo "<A HREF=lyricue.php?mode=playlist&action=plcommit&playlistId=$thisrow[id]&song=$song>$thisrow[title]</A><BR>";	
			}
		} else {
			$result = mysql_query("select title from lyricMain where id=$song",$db);
			$title = mysql_fetch_array($result);

			# Insert main playlist item
			#--------------------------

			$result = mysql_query("select max(id) + 1 as next from playlists",$db);
			$nextid = mysql_fetch_array($result);
			$nextid = $nextid[next];
            $title[title] = mysql_real_escape_string($title[title]);
			mysql_query("insert into playlists (id, title, ref) values('$nextid', '$title[title]','$song')",$db);

			# Insert link to parent
			#----------------------

			$result = mysql_query("select max(playorder) + 1 as next from playlist",$db);
			$nextpo = mysql_fetch_array($result);
			$nextpo = $nextpo[next];
			mysql_query("insert into playlist (playorder, playlist, data, type, transition) values('$nextpo','$playlistId','$nextid','play','0')",$db);

			# Insert page playlist items
			#---------------------------

			$result = mysql_query("select pageid from page where songid=$song order by pagenum asc", $db);

			while ($thisrow = mysql_fetch_array($result)) {
				$poresult = mysql_query("select max(playorder) + 1 as next from playlist",$db);
				$nextpo = mysql_fetch_array($poresult);
				$nextpo = $nextpo[next];

				mysql_query("insert into playlist (playorder, playlist, data, type, transition) values('$nextpo','$nextid','$thisrow[pageid]','song', 0)",$db);
			}

			# Audit this addition
			#--------------------

			mysql_query("insert into audit (id, songid, playdate) values(0,$song,NOW())",$db);

			echo "The command to insert the song <I>\"$title[title]\"</I> into the playlist was successful.<BR>Click <A HREF=lyricue.php?mode=playlist&action=showpl&playlistId=$playlistId>here</A> to view the playlist.";
		}
	}

	elseif ($plfunc == addsong) {

	//-----------------Add song to the Playlist------------------------------
		echo "<FONT SIZE=4><B>Adding a song:</B><BR>To add a song to a playlist follow these steps:<BR> <UL><LI>Click <A HREF=$PHP_SELF?mode=playlist&action=showavail>here</A> to visit the available songs listing.</LI><BR><LI>Click the 'X' next to the song to add the song to a playlist.</LI></UL>";
	}

}

?>


<?PHP
// ----------------------------------
// addplaylist function
// created by Mark Clearwater
// mclearwater@gmail.com
// ----------------------------------


	function addplaylist() {

		?>
		<FONT SIZE=4><B>Adding a playlist:</B><BR>To add a playlist follow these steps:<BR> <p>Enter a title for your playlist into the text box below and press the create button.</p>

		<form method="post" action="lyricue.php?action=plcreateplaylist">

		Playlist Name: <input name="playlisttitle"><P>
		<input type="submit" value="create">
		<input type="hidden" name="mode" value="playlist">

		</form>

		<?PHP
	}
// ----------------------------------
// createaddplaylist function
// created by Mark Clearwater
// modified from existing code
// mclearwater@gmail.com
// ----------------------------------


	function createplaylist() {
	global $db;
      	# Insert main playlist a new playlist
	#--------------------------

	$result = mysql_query("select max(id) + 1 as next from playlists",$db);
	$nextid = mysql_fetch_array($result);
	$nextid = $nextid[next];
	$playlist = mysql_escape_string($_POST['playlisttitle']);
	mysql_query("insert into playlists (id, title, ref) values('$nextid', '$playlist','')",$db);

	echo "The command to create a new playlist <I>\"$playlist\"</I> was successful.<BR>Click <A HREF=lyricue.php?mode=playlist&action=showpl&playlistId=$nextid>here</A> to view the playlist.";


	}

?>
