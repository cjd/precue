<?PHP
// ----------------------------------
// show a song function
// ----------------------------------

	function showasong($songtoshow) {
	global $db, $media, $media_path;

		$result = mysql_query("SELECT title, book, artist, songnum FROM lyricMain WHERE id=$songtoshow", $db);
		$thissong = mysql_fetch_array($result);
		echo "</CENTER><I><FONT SIZE=4>$thissong[title]</I><FONT SIZE=3><BR>";
		echo "<U>Songbook</U>: $thissong[book]<BR><U>Artist</U>: $thissong[artist]<BR><U>Song Number</U>: $thissong[songnum]<BR>\n";

		
		$wordsresult = mysql_query("SELECT lyrics FROM page WHERE songid=$songtoshow ORDER BY pagenum" , $db);
		
		$curpage=1;

		while ($wordsdata = mysql_fetch_row($wordsresult)) {

			echo "<BR>";		

			$wordsdata[0] = ereg_replace("\n","<BR>\n",$wordsdata[0]);

			echo "<FONT COLOR=\"0000FF\"><I>-----<B>Page $curpage</B>-----</I></FONT>";
            echo "<table border=1><tr><td>";
            echo "<DIV CLASS=songpage>";
			echo "$wordsdata[0]";
            echo "</DIV>";
            echo "</td></tr></table>";


			$curpage++;
		}
	}

?>
