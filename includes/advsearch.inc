<?PHP

// ----------------------------------
// advancedsongsearch functions
// ----------------------------------

	function advancedsongsearch($advanced,$searchtext) {
	global $db;

	?> The Advanced song search allows you to search for songs in which the <I>lyrics text</I> matches what you search for.<BR>You may use partial words in your search.<BR><BR>

		<FORM NAME="advsearch" ACTION="<?PHP echo $PHP_SELF; ?>">
		Search text: <INPUT TYPE="text" NAME="searchtext">
		<INPUT TYPE="submit" NAME="action" VALUE="Execute Search">
		</FORM><HR>

	<?PHP

	if ($advanced == "Search") {


		echo "<FONT SIZE=4>Your search for <I>\"$searchtext\"</I> returned the following results:</FONT><BR>";

		// draw table
		?>
			<TABLE class="songlist"><TR>
				<TD WIDTH="70%" class="menuitem"><B>Title</B></TD>

				<TD WIDTH="10%" class="menuitem"><B>Add to PL</B></TD>
				<TD WIDTH="20%" class="menuitem"><B>Artist</B></TD>
			</TR>

		<?PHP

		// insert 'wildcards' into search text
		$searchtext = ereg_replace(" ","%",$searchtext);

		// get songid for all lyric pages containing the search text
		$result = mysql_query("SELECT DISTINCT songid FROM page WHERE lyrics LIKE \"%$searchtext%\"", $db);
		
		while ($sid = mysql_fetch_array($result)) {

			$titleresult = mysql_query("SELECT id, title, artist FROM lyricMain WHERE id=$sid[songid]", $db);
			$titlefound = mysql_fetch_array($titleresult);

			 echo "<TR><TD class=\"title\"><A HREF=lyricue.php?action=showsong&song=$titlefound[id]>";
			 echo "$titlefound[title]</A></TD>";
			 echo "<TD class=\"edit\"><A HREF=lyricue.php?action=plcommit&song=$titlefound[id]>X</A>";
			 echo "</TD><TD class=\"artist\">$titlefound[artist]</TD></TR>\n";


		}

		//end drawing table
		?> </TABLE><?PHP


		
	}

	}

?>
