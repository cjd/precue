<?PHP 
session_start();
include("includes/sessionimport.inc");
import_request_variables("GPC","");

$db = mysql_pconnect("localhost","lyric");
mysql_select_db("lyricDb",$db);
?>

<HEAD>

	<TITLE>Precue - Lyricue Frontend <?PHP echo "$fver for Lyricue $lyricuever"; ?></TITLE>

<BASE TARGET="midline" REF="menu.php">
	<SCRIPT LANGUAGE="javascript">
	<!--
		function change_location(dest) {
			frames[1].location= "menu.php";
			frames[2].location= dest;
		}
	//-->
	</SCRIPT>

<link rel="StyleSheet" href="theme.css" type="text/css" title="Default">

</HEAD>

<BODY>

	<CENTER>
	<IMG SRC="images/precue.png" BORDER="0" WIDTH="500" HEIGHT="133" onclick="parent.main.location='lyricue.php?action=welcome'"><BR>
    <FONT SIZE=3" COLOR="red">
    <TABLE class="menu">
    <TR>
    <TD class="menuitem" onclick="parent.midline.location.href='menu.php?mode=song'">Songs</TD>
    <TD class="menuitem" onclick="parent.midline.location.href='menu.php?mode=verse'">Verse</TD>
    <TD class="menuitem" onclick="parent.midline.location.href='menu.php?mode=playlist'">Playlist</TD>
    <TD class="menuitem" onclick="parent.midline.location.href='menu.php?mode=images'">Images</TD>
    <TD class="menuitem" onclick="parent.midline.location.href='menu.php?mode=direct&url=audit.php'">Audit Reports</TD>
    <TD class="menuitem" onclick="parent.midline.location.href='menu.php?mode=direct&url=lyricue.php?action=about'">About Precue</TD>
    </TR>
    </TABLE>
    </FONT>
	
	</CENTER>

</BODY>
</HTML>
