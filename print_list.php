<?PHP
// -----------------------------------
// printer friendly song \list function
// -----------------------------------

include("includes/main.inc");

$result= mysql_query("SELECT title, artist, songnum FROM lyricMain ORDER BY title", $db);
echo "<FONT FACE=ARIAL SIZE=5><B>Lyricue Songlist</B></FONT><BR>";
$now = date('r');
echo "<FONT FACE=ARIAL SIZE=4><I>Current as of $now</I></FONT><BR>";
?>
<TABLE BORDER=2>
<TR>
<TD WIDTH=65%><B>Song Title:</B></TD>
<TD WIDTH=25%><B>Artist:</B></TD>
<TD WIDTH=10%><B>Song Number:</B></TD>
</TR>
<?PHP

while ($thisrow = mysql_fetch_array($result)) {
    if ($thisrow['artist'] == "") {
        $thisrow['artist'] = "&nbsp;";
    }
    if ($thisrow['songnum'] == "0") {
        $thisrow['songnum'] = "&nbsp;";
    }
    echo "<TR><TD>".$thisrow['title']."</TD>";
    echo "<TD>".$thisrow['artist']."</TD>";
    echo "<TD>".$thisrow['songnum']."</TD></TR>";
}
echo "</TABLE>";

?>
