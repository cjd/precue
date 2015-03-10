<?PHP

// playlist functions

    function clearplaylist() {
	global $db;
		if (!isset($_REQUEST['playlistId'])){
			echo "<B>Please select the playlist you wish to clear:</B><BR>";
			echo "<FONT SIZE=3><I>Note: Clearing does not delete the playlist but only the items within it. For now this only clears basic playlists (2 level lists).</I><BR><BR>";
			$result = mysqli_query($db, "SELECT * FROM playlists LEFT JOIN playlist ON playlist.data=playlists.id AND playlist.data NOT LIKE '%-%' AND (type='play' OR type='sub') WHERE data IS NULL AND playlists.id > 0 ORDER BY id");
			while ($thisrow = mysqli_fetch_array($result)) {
				echo "<A onclick=\"jumpTo('playlist','plclear','playlistId=".$thisrow['id']."')\">".$thisrow['title']."</A><BR>";	
			}
		} else {
            $playlistId = $_REQUEST['playlistId'];
			//get playlist ids for the items in this playlist
			$result = mysqli_query($db, "SELECT data FROM playlist WHERE playlist=$playlistId");
			echo "Deleted entries for....<BR><BR>";
			while ($thispid = mysqli_fetch_array($result)) {
				//delete the page subentries (pages for songs)
				mysqli_query($db, "DELETE FROM playlist WHERE playlist=".$thispid['data']);
				//delete the playlist linking entries
				mysqli_query($db, "DELETE FROM playlist WHERE data=".$thispid['data']);
				$title = mysqli_fetch_array(mysqli_query($db, "SELECT title FROM playlists where id=".$thispid['data']));

				//delete the main playlist entry for this song
				mysqli_query($db, "DELETE FROM playlists WHERE id=".$thispid['data']);
				echo $title['title']."<BR>";
			}
			echo "<BR><BR><B>The playlist has been cleared.</B>";
		}		
	}


	//-----------------Show the Playlist------------------------------
	function showplaylist() {
    global $db;
		if (!isset($_REQUEST['playlistId'])) {
			echo "<B>Please select the playlist you wish to display:<BR>";
			$result = mysqli_query($db, "SELECT * FROM playlists LEFT JOIN playlist ON playlist.data=playlists.id AND playlist.data NOT LIKE '%-%' AND (type='play' OR type='sub') WHERE data IS NULL AND playlists.id > 0 ORDER BY id");
			while ($thisrow = mysqli_fetch_array($result)) {
				echo "<A onclick=\"jumpTo('playlist','showpl','playlistId=$thisrow[id]')\">$thisrow[title]</A><BR>";	
			}
		} else {
		
	?>

	<TABLE class="songlist">

    <?PHP
    //get the playlist name
    $playlistId = $_REQUEST['playlistId'];
    $plname = mysqli_query($db, "SELECT title FROM playlists WHERE id=$playlistId");
    if ($nameret = mysqli_fetch_array($plname)) {
        echo "<H2>".$nameret['title']."<H2>";
    }
    ?>
	<TR class="header"><TD WIDTH="75%"><B>Title</B></TD><TD WIDTH="25%"><B>Artist</B></TD></TR>

	<?PHP

	//get playlist ids of song in currently selected playlist
	$pids = mysqli_query($db, "SELECT data FROM playlist WHERE playlist=$playlistId AND type='play' ORDER BY playorder");

	while ($thispid = mysqli_fetch_array($pids)) {

		//get song id of this song
		$sid = mysqli_query($db, "SELECT ref FROM playlists WHERE id = $thispid[data]");
		$thissid = mysqli_fetch_array($sid);

		$plresult1 = mysqli_query($db, "SELECT id, title, artist FROM lyricMain WHERE id=\"$thissid[ref]\"");

		while ($currentsong = mysqli_fetch_array($plresult1)) {

	
		echo "\t<TR><TD class=\"title\"><A onclick=\"jumpTo('playlist','showsong','song=$currentsong[id]')\">$currentsong[title]</A></TD><TD class=\"artist\">$currentsong[artist]</TD></TR>\n";


		}
	}
		
	?></TABLE><?PHP
		}
	}

	function addtoplaylist() {
    global $db;

		if (!isset($_REQUEST['playlistId'])) {
			echo "<B>Please select the playlist you wish to add the song to:<BR>";
			$result = mysqli_query($db, "SELECT * FROM playlists LEFT JOIN playlist ON playlist.data=playlists.id AND playlist.data NOT LIKE '%-%' AND (type='play' OR type='sub') WHERE data IS NULL AND playlists.id > 0 ORDER BY id");
			while ($thisrow = mysqli_fetch_array($result)) {
				echo "<A onclick=\"jumpTo('playlist','plcommit','playlistId=$thisrow[id]&song=".$_REQUEST['song']."')\">$thisrow[title]</A><BR>";	
			}
		} else {
            $playlistId = $_REQUEST['playlistId'];
			$result = mysqli_query($db, "select title from lyricMain where id=".$_REQUEST['song']);
			$title = mysqli_fetch_array($result);

			# Insert main playlist item
			#--------------------------

			$result = mysqli_query($db, "select max(id) + 1 as next from playlists");
			$nextid = mysqli_fetch_array($result);
			$nextid = $nextid['next'];
            $title['title'] = mysqli_real_escape_string($db, $title['title']);
			mysqli_query($db, "insert into playlists (id, title, ref) values('$nextid', '$title[title]','".$_REQUEST['song']."')");

			# Insert link to parent
			#----------------------

			$result = mysqli_query($db, "select max(playorder) + 1 as next from playlist");
			$nextpo = mysqli_fetch_array($result);
			$nextpo = $nextpo['next'];
			mysqli_query($db, "insert into playlist (playorder, playlist, data, type, transition) values('$nextpo','$playlistId','$nextid','play','0')");

			# Insert page playlist items
			#---------------------------

			$result = mysqli_query($db, "select pageid from page where songid=".$_REQUEST['song']." order by pagenum asc");

			while ($thisrow = mysqli_fetch_array($result)) {
				$poresult = mysqli_query($db, "select max(playorder) + 1 as next from playlist");
				$nextpo = mysqli_fetch_array($poresult);
				$nextpo = $nextpo['next'];

				mysqli_query($db, "insert into playlist (playorder, playlist, data, type, transition) values('$nextpo','$nextid','".$thisrow['pageid']."','song', 0)");
			}

			# Audit this addition
			#--------------------

			mysqli_query($db, "insert into audit (id, songid, playdate) values(0,".$_REQUEST['song'].",NOW())");

			echo "The command to insert the song <I>\"".$title['title']."\"</I> into the playlist was successful.<BR>Click <A onclick=\"jumpTo('playlist','showpl','playlistId=$playlistId')\">here</A> to view the playlist.";
		}
	}

    function addsongplaylist () {
	//-----------------Add song to the Playlist------------------------------
		echo "<FONT SIZE=4><B>Adding a song:</B><BR>To add a song to a playlist follow these steps:<BR> <UL><LI>Click <A onclick=\"jumpTo('playlist','showavail','width='+window.innerWidth)\">here</A> to visit the available songs listing.</LI><BR><LI>Click the 'X' next to the song to add the song to a playlist.</LI></UL>";
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

		<form name="pl" action="javascript:jumpTo('playlist','createplaylist','playlisttitle='+document.pl.playlisttitle.value)">

		Playlist Name: <input name="playlisttitle"><P>
		<input type="submit" value="create">
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
    $playlisttitle="";
    if (isset($_REQUEST['playlisttitle'] )) {
         $playlisttitle=$_REQUEST['playlisttitle'] ;
    } else {
        echo "No playlist name given";
        return;
    }
      	# Insert main playlist a new playlist
	#--------------------------

    $result = mysqli_query($db, "SELECT id FROM playlists WHERE title LIKE \"".$playlisttitle."\"");
    if ($thisrow = mysqli_fetch_array($result) ) {
	    echo "The command to create a new playlist <I>\"$playlisttitle\"</I> was successful.<BR>Click <A onclick=\"jumpTo('playlist','showpl','playlistId=".$thisrow['id']."')\">here</A> to view the playlist.";
    } else {
	    $result = mysqli_query($db, "select max(id) + 1 as next from playlists");
	    $nextid = mysqli_fetch_array($result);
	    $nextid = $nextid['next'];
	    mysqli_query($db, "insert into playlists (id, title, ref) values('$nextid', '$playlisttitle','')");

	    echo "The command to create a new playlist <I>\"$playlisttitle\"</I> was successful.<BR>Click <A onclick=\"jumpTo('playlist','showpl','playlistId=$nextid')\">here</A> to view the playlist";
    }


	}

?>
