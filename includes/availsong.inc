<?PHP
// ----------------------------------
// available songs function
// ----------------------------------

	function availablesongs($sortingmech,$searchrad,$searchtext) {
	global $db, $media, $media_path, $letter;
?>
	<CENTER>
	<FORM NAME="search" ACTION="lyricue.php?letter=<? echo $letter; ?>" METHOD="POST">

	<A HREF="lyricue.php?action=showavail&letter=ALL<? echo "&sortingmech=$sortingmech"; ?>">All</A>|
	<A HREF="lyricue.php?action=showavail&letter=A<? echo "&sortingmech=$sortingmech"; ?>">A</A>|
	<A HREF="lyricue.php?action=showavail&letter=B<? echo "&sortingmech=$sortingmech"; ?>">B</A>|
	<A HREF="lyricue.php?action=showavail&letter=C<? echo "&sortingmech=$sortingmech"; ?>">C</A>|
	<A HREF="lyricue.php?action=showavail&letter=D<? echo "&sortingmech=$sortingmech"; ?>">D</A>|
	<A HREF="lyricue.php?action=showavail&letter=E<? echo "&sortingmech=$sortingmech"; ?>">E</A>|
	<A HREF="lyricue.php?action=showavail&letter=F<? echo "&sortingmech=$sortingmech"; ?>">F</A>|
	<A HREF="lyricue.php?action=showavail&letter=G<? echo "&sortingmech=$sortingmech"; ?>">G</A>|
	<A HREF="lyricue.php?action=showavail&letter=H<? echo "&sortingmech=$sortingmech"; ?>">H</A>|
	<A HREF="lyricue.php?action=showavail&letter=I<? echo "&sortingmech=$sortingmech"; ?>">I</A>|
	<A HREF="lyricue.php?action=showavail&letter=J<? echo "&sortingmech=$sortingmech"; ?>">J</A>|
	<A HREF="lyricue.php?action=showavail&letter=K<? echo "&sortingmech=$sortingmech"; ?>">K</A>|
	<A HREF="lyricue.php?action=showavail&letter=L<? echo "&sortingmech=$sortingmech"; ?>">L</A>|
	<A HREF="lyricue.php?action=showavail&letter=M<? echo "&sortingmech=$sortingmech"; ?>">M</A>|
	<A HREF="lyricue.php?action=showavail&letter=N<? echo "&sortingmech=$sortingmech"; ?>">N</A>|
	<A HREF="lyricue.php?action=showavail&letter=O<? echo "&sortingmech=$sortingmech"; ?>">O</A>|
	<A HREF="lyricue.php?action=showavail&letter=P<? echo "&sortingmech=$sortingmech"; ?>">P</A>|
	<A HREF="lyricue.php?action=showavail&letter=Q<? echo "&sortingmech=$sortingmech"; ?>">Q</A>|
	<A HREF="lyricue.php?action=showavail&letter=R<? echo "&sortingmech=$sortingmech"; ?>">R</A>|
	<A HREF="lyricue.php?action=showavail&letter=S<? echo "&sortingmech=$sortingmech"; ?>">S</A>|
	<A HREF="lyricue.php?action=showavail&letter=T<? echo "&sortingmech=$sortingmech"; ?>">T</A>|
	<A HREF="lyricue.php?action=showavail&letter=U<? echo "&sortingmech=$sortingmech"; ?>">U</A>|
	<A HREF="lyricue.php?action=showavail&letter=V<? echo "&sortingmech=$sortingmech"; ?>">V</A>|
	<A HREF="lyricue.php?action=showavail&letter=W<? echo "&sortingmech=$sortingmech"; ?>">W</A>|
	<A HREF="lyricue.php?action=showavail&letter=X<? echo "&sortingmech=$sortingmech"; ?>">X</A>|
	<A HREF="lyricue.php?action=showavail&letter=Y<? echo "&sortingmech=$sortingmech"; ?>">Y</A>|
	<A HREF="lyricue.php?action=showavail&letter=Z<? echo "&sortingmech=$sortingmech"; ?>">Z</A>

	<BR><BR>
	
	<B>Sort list by: </B>
	<A HREF="lyricue.php?action=showavail&sortingmech=title&letter=<? echo $letter; ?>">Title</A>&nbsp;|&nbsp;
	<A HREF="lyricue.php?action=showavail&sortingmech=artist&letter=<? echo $letter; ?>">Artist</A>&nbsp;|&nbsp;
	<A HREF="lyricue.php?action=showavail&sortingmech=songnum&letter=<? echo $letter; ?>">Number</A>

	<B><U> OR</U> search by: </B>

	<U>Title</U> <INPUT TYPE="RADIO" NAME="searchrad" CHECKED=true VALUE="title">&nbsp;|&nbsp;
	<U>Artist</U> <INPUT TYPE="RADIO" NAME="searchrad" VALUE="artist">&nbsp;|&nbsp;
	<U>Number</U> <INPUT TYPE="RADIO" NAME="searchrad" VALUE="songnum">&nbsp;
	<INPUT TYPE="textarea" NAME="searchtext" WIDTH="45">
	<INPUT TYPE="submit" NAME="action" VALUE="Search">

	</FORM>
	</CENTER>

	<HR>

<?PHP
		
		if ($letter && $letter != "ALL") {
			echo "<FONT SIZE=4 FACE=Arial>Songs with first letter in title being '$letter'</FONT><BR>";
		}	
		
		if ($sortingmech == "") $sortingmech = "title";

		if ($letter !="ALL" & $letter !="") {
			$lettersearch = "title LIKE '" . $letter . "%' AND"; 
		} else {
			$lettersearch = "";
		} 

		if ($searchrad) {
			$result = mysql_query("SELECT id, title, artist, songnum FROM lyricMain WHERE $searchrad LIKE \"%$searchtext%\" ORDER BY $searchrad", $db);

		} else if ($sortingmech=="songnum") {
			$result = mysql_query("SELECT id, title, artist, songnum FROM lyricMain WHERE " . $lettersearch . " NOT songnum = '' ORDER BY $sortingmech", $db);
			echo "<B>Only showing results with song number entered!</B><BR>";
		} else {
			if ($lettersearch=="") {
				$result = mysql_query("SELECT id, title, artist, songnum FROM lyricMain ORDER BY $sortingmech", $db);
			} else {
				$result = mysql_query("SELECT id, title, artist, songnum FROM lyricMain WHERE title LIKE '" . $letter . "%' ORDER BY $sortingmech", $db);
			}
		}



		?>
		<TABLE BORDER=2>
			<TR>
				<TD WIDTH=10% ALIGN=CENTER><B>Edit Song:</B></TD>
				<TD WIDTH=40%><B>Title:</B></TD>
				<TD WIDTH=10%><B>Media:</B></TD>
				<TD WIDTH=10% ALIGN=CENTER><B>Add to PL:</B></TD>
				<TD WIDTH=30%><B>Artist:</B></TD>
				<TD WIDTH=10%><B>Number:</B></TD>
			</TR>
		<?PHP
		if ($result !="") {
			while ($thisrow = mysql_fetch_array($result)) {
			      	echo "<TR><TD ALIGN=CENTER><A HREF=lyricue.php?action=editsong&song=$thisrow[id]>X</A></TD>";

				echo "<TD><A HREF=lyricue.php?action=showsong&song=$thisrow[id]>";
				echo "$thisrow[title]</A></TD>";

				if ($media[$thisrow[id]] != "") {
					echo "<TD ALIGN=CENTER><A HREF=\"" .
						"lyricue.php?action=playsong&song=$thisrow[id]" .
						"\">Play</TD><TD ALIGN=CENTER>";

				} else {
					echo "<TD> </TD><TD ALIGN=CENTER>";
				}
				echo "<A HREF=lyricue.php?action=plcommit&song=$thisrow[id]>X</A>";
				echo "</TD><TD>$thisrow[artist]</TD>";
				echo "<TD>$thisrow[songnum]</TD></TR>\n";
	
			}
		}
		else { ?>
			<TR><TD COLSPAN=2>
				<FONT COLOR=FF0000><B>
					No results were found in the database....
				</B></FONT>
			</TD></TR>
		<?PHP }

		echo "</TABLE>";

	}

?>
