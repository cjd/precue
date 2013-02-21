<?PHP
// ----------------------------------
// available songs function
// ----------------------------------

	function availablesongs() {
	global $db, $letter;
    $sortingmech="";
    $searchrad="";
    $searchtext="";
    $width=600;
    $letter="All";
    if (isset($_REQUEST['sortingmech'])) $sortingmech=$_REQUEST['sortingmech'];
    if (isset($_REQUEST['searchrad'])) $searchrad=$_REQUEST['searchrad'];
    if (isset($_REQUEST['searchtext'])) $searchtext=$_REQUEST['searchtext'];
    if (isset($_REQUEST['width'])) $width=$_REQUEST['width'];
    if (isset($_REQUEST['letter'])) $letter=$_REQUEST['letter'];
?>
	<FORM NAME="search" ACTION="javascript:jumpTo('song','showavail','sortingmech=<?PHP echo $sortingmech; ?>&searchrad='+document.search.searchrad.value+'&searchtext='+escape(document.search.searchtext.value)+'&width='+window.innerWidth)">

	<B>Sort list by: </B>
	<A onclick="jumpTo('song','showavail','sortingmech=title&letter=<? echo $letter; ?>&width='+window.innerWidth)">Title</A>&nbsp;|&nbsp;
	<A onclick="jumpTo('song','showavail','sortingmech=artist&letter=<? echo $letter; ?>&width='+window.innerWidth)">Artist</A>&nbsp;|&nbsp;
	<A onclick="jumpTo('song','showavail','sortingmech=songnum&letter=<? echo $letter; ?>&width='+window.innerWidth)">Number</A>

	<B><U> OR</U> search by: </B>

    <SELECT NAME="searchrad">
        <OPTION value="title">Title
        <OPTION value="artist">Artist
        <OPTION value="songnum">Number
    </SELECT>
	<INPUT TYPE="textarea" NAME="searchtext" WIDTH="45" on>
	<INPUT TYPE="button" NAME="search" VALUE="Search" onclick="jumpTo('song','showavail','sortingmech=<?PHP echo $sortingmech; ?>&searchrad='+document.search.searchrad.value+'&searchtext='+escape(document.search.searchtext.value)+'&width='+window.innerWidth)">
	<HR>

<?PHP
    $letters = array("All",'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0-9');
    if ($width > 500) {
        echo "<table>\n";
        echo "<tr>\n";
        foreach ($letters as $l) {
            echo '<TD class="menuitem">';
	        echo '<A class="menuitem" onclick="jumpTo(\'song\',\'showavail\',\'letter='.$l.'&sortingmech='.$sortingmech.'&width='.$width.'\')">'.$l.'</A>';
            echo '</TD>';
            echo "\n";
        }
        echo "</tr>\n";
        echo "</table>\n";
    } else {
        echo "<B>Select first letter of song:</B>";
        echo "<SELECT name=firstletter onchange=\"jumpTo('song','showavail','letter='+document.search.firstletter.value+'&sortingmech=".$sortingmech."&width=".$width."')\">\n";
        foreach ($letters as $l) {
            echo "<OPTION>".$l."</OPTION>\n";
        }
        echo "</SELECT>\n";
    }
?>


	</FORM>


<?PHP
		
		if ($letter && $letter != "All") {
			echo "<H2>Songs with first letter in title being '$letter'</h2>";
		}	
		
		if ($sortingmech == "") $sortingmech = "title";

		if ($letter !="All" & $letter !="") {
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
				$result = mysql_query("SELECT id, title, artist, songnum FROM lyricMain WHERE UCASE(title) REGEXP '^[" . $letter . "]' ORDER BY $sortingmech", $db);
			}
		}



		?>
		<TABLE class="songlist">
			<TR class="header">
				<TD WIDTH=auto ALIGN=CENTER class="menuitem">Edit</TD>
				<TD WIDTH=auto ALIGN=CENTER class="menuitem">Add to PL</TD>
				<TD WIDTH=50% class="menuitem" onclick="jumpTo('song','showavail','sortingmech=title&letter=<? echo $letter; ?>&width='+window.innerWidth)"><B>Title</B></td>
				<TD WIDTH=40% class="menuitem" onclick="jumpTo('song','showavail','sortingmech=artist&letter=<? echo $letter; ?>&width='+window.innerWidth)"><B>Artist</B></TD>
				<TD WIDTH=auto class="menuitem" onclick="jumpTo('song','showavail','sortingmech=songnum&letter=<? echo $letter; ?>&width='+window.innerWidth)"><B>No.</B></TD>
			</TR>
		<?PHP
		if ($result !="") {
			while ($thisrow = mysql_fetch_array($result)) {
		      	echo "<TR>";
                echo "<TD ALIGN=CENTER class=\"edit\" onclick=\"jumpTo('song','editsong','song=$thisrow[id]')\">X</TD>";
				echo "<TD ALIGN=CENTER class=\"edit\" onclick=\"jumpTo('playlist','plcommit','song=$thisrow[id]')\">X</TD>";
				echo "<TD class=\"title\"><A onclick=\"jumpTo('song','showsong','song=$thisrow[id]')\">$thisrow[title]</A></TD>";

				echo "<TD class=\"artist\">$thisrow[artist]</TD>";
				echo "<TD class=\"songnum\">$thisrow[songnum]</TD>";
                echo "</TR>\n";
	
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
