<?PHP 
session_start();
$db = mysql_pconnect("localhost","lyric");
mysql_select_db("lyricDb",$db);
?>

<HEAD>

	<TITLE>Lyric Display System Frontend <?PHP echo "$fver for LDS $ldsver"; ?></TITLE>

<BASE TARGET="midline" REF="menu.php">
	<SCRIPT LANGUAGE="javascript">
	<!--
		function change_location(dest) {
			frames[1].location= "menu.php";
			frames[2].location= dest;
		}
	//-->
	</SCRIPT>
</HEAD>

<BODY BGCOLOR=<?PHP echo $bgcolor; ?> BACKGROUND=<?PHP echo $bgimage; ?> LINK=<?PHP echo $linkcolor; ?> VLINK=<?PHP echo $vlinkcolor; ?> TEXT=<?PHP echo $textcolor; ?>>

	<CENTER><!--<IMG SRC="images/logo.jpg"><BR>-->

	<IMG SRC="images/logo.jpg" BORDER=0><BR>
	<IMG SRC="images/menu.jpg" BORDER=0 usemap="#menu">
	
	<map name="menu">
		<area shape="rect" alt="Manage songs within the database" coords="42,8,109,32" 			href="menu.php?mode=song" title="Manage songs within the database">

		<area shape="rect" alt="Utilise the Bible databases" coords="128,8,191,32" 			href="menu.php?mode=verse" title="Utilise the Bible databases">

		<area shape="rect" alt="Manage the Lyricue playlists" coords="210,8,285,32" 			href="menu.php?mode=playlist" title="Manage the Lyricue playlists">

		<area shape="rect" alt="View the images in the media database" coords="305,8,385,32" href="menu.php?mode=images" title="View the images in the media database">

		
		<area shape="rect" alt="View song usage statistics" coords="405,8,550,32" 			href="menu.php?mode=direct&url=audit.php"
			title="View song usage statistics">

		<area shape="rect" alt="About the Lyricue and Precue projects" coords="565,8,720,32" 			href="menu.php?mode=direct&url=lds.php?action=about" 
			title="About the Lyricue and Precue projects">

		<area shape="default" nohref>
	</map>

	
	</CENTER>

</BODY>
</HTML>
