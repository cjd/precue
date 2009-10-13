<DIV CLASS="sidebar">

<?PHP
	
    $menubreak="</TR><TR>\n";
    if ($themeset=="mobile") { $menubreak=""; }
	switch ($mode) {
		case "song": songmanage($menubreak); break;
		case "verse": versemanage($menubreak); break;
		case "playlist": plmanage($menubreak); break;
		case "images": mediamanage($menubreak); break;
		case "blank": break;
	}
	
    function about() {

        ?>
        <B>Lyricue:</B><BR>
        is a GTK Perl program that interacts with MySQL databases to provide a fast and powerful lyrics display system. lyricue responds quickly and, best of all, is free. lyricue is licensed under the GNU GPL and, as a result, undergoes considerable change from week to week and month to month so check the website for the newest version.<BR><BR>

        Lyricue was written for Erina Community Church by Chris Debenham.<BR>
        Email: <A HREF=mailto:chris@adebenham.com>chris@adebenham.com</A>. 
        WWW: <A HREF=http://www.lyricue.org/>Lyricue website</A>

        <BR><BR>
        <B>Precue:</B><BR>
        Lyricue enables remote access to the lyrics and bible databases which Lyricue uses. It facilitates the modification of any Lyricue playlist, the viewing of available songs and the generation of song usage profiles. For security reasons, no provision for deleting songs is made in this version. Precue is implemented in as a group of PHP4 webpages suitable for use with any PHP enabled server.</B><BR><BR>

Lyricue was written for Erina Community Baptist Church by Clint Turner.<BR>
        Email: <A HREF=mailto:ldsf@clintturner.com>ldsf@clintturner.com</A>. 
        

        <?PHP
    }

	function songmanage($menubreak) {
        echo '<table class="menu">';
        echo '<tr>';
        echo '<td class="menuitem" onclick="window.location.href=\'lyricue.php?mode=song&action=showavail&letter=A\'">Show available songs</td>';
        echo $menubreak;
		echo '<td class="menuitem" onclick="window.location.href=\'lyricue.php?mode=song&action=advsearch\'">Search by Lyrics</td>';
        echo $menubreak;
		echo '<td class="menuitem" onclick="window.location.href=\'lyricue.php?mode=song&action=addsong\'">Add a new song</td>';
        echo $menubreak;
        if ($menubreak != "") {
		    echo '<td class="menuitem" onclick="window.open(\'lyricue.php?action=pflist&theme=print\')">Printer friendly list (new window)</td>';
        }
        echo '</tr>';
        echo '</table>';
	}


	function versemanage($menubreak) {
        echo '<table class="menu">';
        echo '<tr>';
        echo '<td class="menuitem" onclick="window.location.href=\'bible.php?action=disp&mode=selectbook\'">Display a range of verses</td>';
        echo $menubreak;
		echo '<td class="menuitem" onclick="window.location.href=\'bible.php?action=change&mode=select\'">Change bible database</td>';
        echo '</tr>';
        echo '</table>';
	}

	function plmanage($menubreak) {
        echo '<table class="menu">';
        echo '<tr>';
		echo '<td class="menuitem" onclick="window.location.href=\'lyricue.php?mode=playlist&action=showpl\'">Display the playlist</td>';
        echo $menubreak;
		echo '<td class="menuitem" onclick="window.location.href=\'lyricue.php?mode=playlist&action=pladdplaylist\'">Add a playlist</td>';
        echo $menubreak;
		echo '<td class="menuitem" onclick="window.location.href=\'lyricue.php?mode=playlist&action=pladdsong\'">Add a song to playlist</td>';
        echo $menubreak;
		echo '<td class="menuitem" onclick="window.location.href=\'lyricue.php?mode=playlist&action=plclear\'">Clear the playlist</td>';
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
        echo "<table class=\"menu\">";
		while ($row = mysql_fetch_row($results)) {
		    echo "<tr><td class=\"menuitem\" onclick=\"parent.main.location.href='lyricue.php?action=images&mode=catselect&category=$row[0]'\">$row[0]</td></tr>";
		}
        echo "</table>";
	
	}
?>

</DIV>
