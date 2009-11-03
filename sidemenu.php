<?PHP
    session_start();
    include("includes/sessionimport.inc");
    include("includes/main.inc");
    import_request_variables("GPC","");

    echo "<CENTER>\n";
	switch ($mode) {
		case "song": songmanage(); break;
		case "bible": biblemanage(); break;
		case "playlist": plmanage(); break;
		case "images": mediamanage(); break;
		case "blank": break;
	}
    echo "</CENTER>\n";
	
	function songmanage() {
        echo '<table class="menu">';
        echo '<tr>';
        echo '<td class="menuitem" onclick="jumpTo(\'song\',\'showavail\',\'letter=A&width=\'+window.innerWidth)">Show available songs</td>';
		echo '<td class="menuitem" onclick="jumpTo(\'song\',\'advsearch\',\'\')">Search by Lyrics</td>';
		echo '<td class="menuitem" onclick="jumpTo(\'song\',\'addsong\',\'\')">Add a new song</td>';
		echo '<td class="menuitem" onclick="window.open(\'print_list.php\')">Printer friendly list (new window)</td>';
        echo '</tr>';
        echo '</table>';
	}


	function biblemanage() {
        echo '<table class="menu">';
        echo '<tr>';
        echo '<td class="menuitem" onclick="jumpTo(\'bible\',\'disp\',\'mode=selectbook\')">Display a range of verses</td>';
		echo '<td class="menuitem" onclick="jumpTo(\'bible\',\'change\',\'mode=select\')">Change Bible translation</td>';
        echo '</tr>';
        echo '</table>';
	}

	function plmanage() {
        echo '<table class="menu">';
        echo '<tr>';
		echo '<td class="menuitem" onclick="jumpTo(\'playlist\',\'showpl\',\'\')">Display the playlist</td>';
		echo '<td class="menuitem" onclick="jumpTo(\'playlist\',\'pladdplaylist\',\'\')">Create a playlist</td>';
		echo '<td class="menuitem" onclick="jumpTo(\'playlist\',\'pladdsong\',\'\')">Add a song to playlist</td>';
		echo '<td class="menuitem" onclick="jumpTo(\'playlist\',\'plclear\',\'\')">Clear the playlist</td>';
        echo '</tr>';
        echo '</table>';
	}
	
	function mediamanage() {
		global $mediadb,$db_pwd, $db_user, $db_host;
		if ($db_pwd=='') {
			$mediadb = mysql_pconnect("$db_host","$db_user");
		} else {
			$mediadb = mysql_pconnect("$db_host","$db_user","$db_pwd");
		}
		mysql_select_db("mediaDb",$mediadb);
	
		$query = "SELECT DISTINCT category FROM media WHERE type = 'bg' OR type='img' ORDER BY Category";
		$results = mysql_query($query,$mediadb);
        echo "<table class=\"menu\"><tr>";
		while ($row = mysql_fetch_row($results)) {
		    echo "<td class=\"menuitem\" onclick=\"jumpTo('images','catselect','category=$row[0]')\">$row[0]</td>";
		}
        echo "</tr></table>";
	
	}
?>
