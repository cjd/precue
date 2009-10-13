<HTML>
<HEAD>
    <TITLE>Precue - Lyricue Frontend <?PHP echo "$fver for Lyricue $lyricuever"; ?></TITLE>
</HEAD>
<?PHP
if ($theme=="print") {
    echo "<BODY BGCOLOR=FFFFFF LINK=000000 VLINK=000000 TEXT=000000>\n";
} else {
    if ($themeset=="mobile") {
        echo "<link rel=\"StyleSheet\" href=\"mobile.css\" type=\"text/css\" title=\"Default\">\n";
        echo "<body>\n";
        echo "<CENTER>\n";
	    echo "<IMG SRC=\"images/precue.png\" BORDER=\"0\" WIDTH=\"100%\" onclick=\"window.location.href='lyricue.php?action=welcome'\"><BR>\n";
    } else {
        echo "<link rel=\"StyleSheet\" href=\"theme.css\" type=\"text/css\" title=\"Default\">\n";
        echo "<body>\n";
        echo "<CENTER>\n";
	    echo "<IMG SRC=\"images/precue.png\" BORDER=\"0\" WIDTH=\"500\" HEIGHT=\"133\" onclick=\"window.location.href='lyricue.php?action=welcome'\"><BR>\n";
    }

?>
    <FONT SIZE=3" COLOR="red">
    <TABLE class="menu">
    <TR>
    <TD class="menuitem" onclick="window.location.href='lyricue.php?mode=song'">Songs</TD>
    <TD class="menuitem" onclick="window.location.href='lyricue.php?mode=verse'">Verse</TD>
    <TD class="menuitem" onclick="window.location.href='lyricue.php?mode=playlist'">Playlist</TD>
    <TD class="menuitem" onclick="window.location.href='lyricue.php?mode=images'">Images</TD>
    <TD class="menuitem" onclick="window.location.href='audit.php'">Audit</TD>
    <TD class="menuitem" onclick="window.location.href='lyricue.php?mode=blank&action=about'">About</TD>
    </TR>
    </TABLE>
    </FONT>
	
	</CENTER>
<?PHP
    }
?>
