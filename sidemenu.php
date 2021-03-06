<?PHP
    session_start();
    include("includes/main.inc");

    echo "<CENTER>\n";
	switch ($_GET['mode']) {
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
		$mediadb = mysqli_connect("$db_host","$db_user","$db_pwd","mediaDb");
        mysqli_set_charset($mediadb,'utf8'); 
	
		$query = "SELECT DISTINCT category FROM media WHERE type = 'bg' OR type='img' ORDER BY Category";
		$results = mysqli_query($mediadb,$query);
        echo "<table class=\"menu\"><tr>";
		while ($row = mysqli_fetch_row($results)) {
		    echo "<td class=\"menuitem\" onclick=\"jumpTo('images','catselect','category=$row[0]')\">$row[0]</td>";
		}
        echo "</tr></table>";
	
	}
?>
