<?PHP

// ----------------------------------
// advancedsongsearch functions
// ----------------------------------

	function advancedsongsearch($advanced,$searchtext) {
	global $db;

	?> The Advanced song search allows you to search for songs in which the contents match what you search for.<BR>You may use partial words in your search.<BR><BR>

		<FORM NAME="advsearch" ACTION="javascript:jumpTo('song','advsearch','advanced=Search&searchtext='+escape(document.advsearch.searchtext.value))">
		Search text: <INPUT TYPE="text" NAME="searchtext" VALUE="<?PHP echo $searchtext; ?>">
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

			 echo "<TR><TD class=\"title\"><A onclick=\"jumpTo('song','showsong','song=$titlefound[id]')\">";
			 echo "$titlefound[title]</A></TD>";
			 echo "<TD class=\"edit\"><A onclick=\"jumpTo('song','plcommit','song=$titlefound[id]')\">X</A>";
			 echo "</TD><TD class=\"artist\">$titlefound[artist]</TD></TR>\n";


		}

		//end drawing table
		?> </TABLE><?PHP


		
	}

	}

?>
