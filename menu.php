<?PHP
session_start();
include("includes/sessionimport.inc");
import_request_variables("GPC","");
?>

<HEAD>
	<BASE TARGET="main">

<link rel="StyleSheet" href="theme.css" type="text/css" title="Default">

</HEAD>
<BODY>
<CENTER>
<?PHP
	if ($mode == "direct") {
		?><SCRIPT LANGUAGE="javascript"><!--
			parent.main.location.href = "<?PHP echo $url; ?>";
		//--></SCRIPT><?PHP
    } else if ($mode == "" ){
	} else {
		?><SCRIPT LANGUAGE="javascript"><!--
			parent.main.location.href = "lyricue.php?action=blank";
		//--></SCRIPT><?PHP
	}

	echo "<UL>";
	
	switch ($mode) {
		case "song": songmanage(); break;
		case "verse": versemanage(); break;
		case "playlist": plmanage(); break;
		case "images": mediamanage(); break;
		case "audit": echo "<LI><A HREF=audit.php>View audit reports</A></LI>"; break;
		case "about": echo "<LI><A HREF=lyricue.php?action=about>View Lyricue/Precue details</A></LI>"; break;
	}
	
	echo "</UL>";
	
	function songmanage() {
		?>
        <table class="menu">
        <tr>
        <td class="menuitem" onclick="parent.main.location.href='lyricue.php?action=showavail&letter=A'">Show available songs</td>
        </tr><tr>
		<td class="menuitem" onclick="parent.main.location.href='lyricue.php?action=advsearch'">Search by Lyrics</td>
        </tr><tr>
		<td class="menuitem" onclick="parent.main.location.href='lyricue.php?action=addsong'">Add a new song</td>
        </tr><tr>
		<td class="menuitem" onclick="window.open('lyricue.php?action=pflist')">Printer friendly list (new window)</td>
        </tr>
        </table>

		<?PHP
	}


	function versemanage() {
		?>
        <table class="menu">
        <tr>
        <td class="menuitem" onclick="parent.main.location.href='bible.php?action=disp&mode=selectbook'">Display a range of verses</td>
        </tr><tr>
		<td class="menuitem" onclick="parent.main.location.href='bible.php?action=change&mode=select'">Change bible database</td>
        </tr>
        </table>
		<?PHP
	}

	function plmanage() {
		?>
        <table class="menu">
        <tr>
		<td class="menuitem" onclick="parent.main.location.href='lyricue.php?action=showpl'">Display the playlist</td>
        </tr><tr>
		<?PHP
		//****************************
		// added by Mark Clearwater
		// mclearwater@gmail.com
		//****************************
		?>
		<td class="menuitem" onclick="parent.main.location.href='lyricue.php?action=pladdplaylist'">Add a playlist</td
		<?PHP //end added ?>
        </tr><tr>
		<td class="menuitem" onclick="parent.main.location.href='lyricue.php?action=pladdsong'">Add a song to playlist</td>
        </tr><tr>
		<td class="menuitem" onclick="parent.main.location.href='lyricue.php?action=plclear'">Clear the playlist</td>
        </tr>
        </table>
		
		<?PHP
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

</BODY></HTML>
