<?PHP

// ----------------------------------
// advancedsongsearch functions
// ----------------------------------

	function advancedsongsearch() {
	global $db;
    $searchtext="";
    if (isset($_REQUEST['searchtext'])) $searchtext=$_REQUEST['searchtext'];

	?> The Advanced song search allows you to search for songs in which the contents match what you search for.<BR>You may use partial words in your search.<BR><BR>

		<FORM NAME="advsearch" ACTION="javascript:jumpTo('song','advsearch','advanced=Search&searchtext='+escape(document.advsearch.searchtext.value))">
		Search text: <INPUT TYPE="text" NAME="searchtext" VALUE="<?PHP echo $searchtext; ?>">
		<INPUT TYPE="submit" NAME="action" VALUE="Execute Search">
		</FORM><HR>

	<?PHP

	if (isset($_REQUEST['advanced']) && $_REQUEST['advanced'] == "Search") {


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
		$result = mysqli_query($db,"SELECT DISTINCT songid FROM page WHERE lyrics LIKE \"%$searchtext%\"");
		
		while ($sid = mysqli_fetch_array($result)) {

			$titleresult = mysqli_query($db,"SELECT id, title, artist FROM lyricMain WHERE id=$sid[songid]");
			$titlefound = mysqli_fetch_array($titleresult);

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
