<?PHP
session_start();
?>

<HEAD>
	<BASE TARGET="main">

</HEAD>
<BODY BGCOLOR=<?PHP echo $bgcolor; ?> BACKGROUND=<?PHP echo $bgimage; ?> LINK=<?PHP echo $linkcolor; ?> VLINK=<?PHP echo $vlinkcolor;?>>
<CENTER>
<?PHP
	if ($mode == "direct") {
		?><SCRIPT LANGUAGE="javascript"><!--
			parent.main.location.href = "<?PHP echo $url; ?>";
		//--></SCRIPT><?PHP
	} else {
		?><SCRIPT LANGUAGE="javascript"><!--
			parent.main.location.href = "lds.php?action=blank";
		//--></SCRIPT><?PHP
	}

	echo "<UL>";
	
	switch ($mode) {
		case "song": songmanage(); break;
		case "verse": versemanage(); break;
		case "playlist": plmanage(); break;
		case "images": mediamanage(); break;
		case "audit": echo "<LI><A HREF=audit.php>View audit reports</A></LI>"; break;
		case "about": echo "<LI><A HREF=lds.php?action=about>View Lyricue/Precue details</A></LI>"; break;
	}
	
	echo "</UL>";
	
	function songmanage() {
		?>
		<LI><A HREF="lds.php?action=showavail&letter=A">Show available songs</A></LI><BR>
		<LI><A HREF="lds.php?action=advsearch">Search by Lyrics</A></LI><BR>
		<LI><A HREF="lds.php?action=addsong">Add a new song</A></LI><BR>
		<LI><A HREF="lds.php?action=pflist" TARGET="_new">Printer friendly list (new window)</A>

		<?PHP
	}


	function versemanage() {
		?>
		<LI><A HREF="bible.php?action=disp&mode=selectbook">Display a range of verses</A></LI><BR>
		<LI><A HREF="bible.php?action=change&mode=select">Change bible database</A></LI>
		<?PHP
	}

	function plmanage() {
		?>
		<LI><A HREF="lds.php?action=showpl">Display the playlist</A></LI><BR>
		<LI><A HREF="lds.php?action=pladdsong">Add a song to playlist</A></LI><BR>
		<LI><A HREF="lds.php?action=plclear">Clear the playlist</A></LI>
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
	
		$query = "SELECT DISTINCT category FROM media WHERE type = 'bg' OR type='img'";
		$results = mysql_query($query,$mediadb);
		while ($row = mysql_fetch_row($results)) {
			echo "<LI><A HREF=\"lds.php?action=images&mode=catselect&category=$row[0]\">$row[0]</A></LI><BR>";
		}
	
	}
?>

</BODY></HTML>
