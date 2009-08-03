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

<style>
td {
    text-align: center;
    background-color: #FFFFFF;
    border-color: #ff0000;
    color: #ff0000;
    text-decoration: none;
    font-family: Arial, sans-serif;
    font-size: 20px;
}

td:hover {
    background-color: #8080FF;
}

</style> 
</HEAD>

<BODY BGCOLOR=<?PHP echo $bgcolor; ?> BACKGROUND=<?PHP echo $bgimage; ?> LINK=<?PHP echo $linkcolor; ?> VLINK=<?PHP echo $vlinkcolor; ?> TEXT=<?PHP echo $textcolor; ?>>

	<CENTER>
	<IMG SRC="images/precue.png" BORDER="0" WIDTH="601" HEIGHT="161" onclick="parent.main.location='lyricue.php?action=welcome'"><BR>
    <FONT SIZE=3" COLOR="red">
    <TABLE WIDTH="601" BORDER=1>
    <TR>
    <TD onclick="parent.midline.location.href='menu.php?mode=song'">Songs</TD>
    <TD onclick="parent.midline.location.href='menu.php?mode=verse'">Verse</TD>
    <TD onclick="parent.midline.location.href='menu.php?mode=playlist'">Playlist</TD>
    <TD onclick="parent.midline.location.href='menu.php?mode=images'">Images</TD>
    <TD onclick="parent.midline.location.href='menu.php?mode=direct&url=audit.php'">Audit Reports</TD>
    <TD onclick="parent.midline.location.href='menu.php?mode=direct&url=lyricue.php?action=about'">About Precue</TD>
    </TR>
    </TABLE>
    </FONT>
	
	</CENTER>

</BODY>
</HTML>
