<?PHP
include("includes/main.inc");
?>

<?PHP
// Show the header

if ($_REQUEST['page'] == "process") {
	$title = strtolower($_REQUEST['format']);

	$query = "";
	$date = "\"0000-00-00\" ";
	//construct duration limitation
	switch ($_REQUEST['duration']) {
		case "Date Range":
            $sdate = $_REQUEST['syear']."-".$_REQUEST['smonth']."-".$_REQUEST['sday'];
            $edate = $_REQUEST['eyear']."-".$_REQUEST['emonth']."-".$_REQUEST['eday'];
			$title = $title . " between " . $sdate . " and " . $edate;
            $query = "playdate>=\"".$sdate."\" and playdate <=\"".$edate."\"";
			break;
	}
	if ($_REQUEST['sunday'] == "true") {
        if ($query != "") $query .= " AND ";
		$query .= "WEEKDAY(playdate) = 6 " ;
		$title .= " on Sundays";
	}
	if ($_REQUEST['hour'] == "AM") {
        if ($query != "") $query .= " AND ";
		$query .= "HOUR(playdate) < 12 ";
		$title .= " (AM Only)";
	}
	else if ($_REQUEST['hour'] =="PM") {
        if ($query != "") $query .= " AND ";
		$query .= "HOUR(playdate) >= 12 ";
		$title .= " (PM Only)";
	}
    if ($query != "") $query = "WHERE ".$query;

	switch ($_REQUEST['format']) {

	case "Full statistics":	$query = "select count(songid) as count, songid from audit ". $query . " group by songid order by count desc, songid asc";
		break;
	case "Top 20 songs": $query = "select count(songid) as count, songid from audit " . $query . " group by songid order by count desc, songid desc limit 20";
		break;
	case "Top 50 songs": $query = "select count(songid) as count, songid from audit " . $query . " group by songid order by count desc, songid desc limit 50";
		break;
	case "20 least played songs": $query = "select count(songid) as count, songid from audit " . $query . " group by songid order by count asc, songid asc limit 20";
		break;
	case "50 least played songs": $query = "select count(songid) as count, songid from audit " . $query . " group by songid order by count asc, songid asc limit 50";
		break;
	case "New Songs": $query = "select id,title,artist,entered from lyricMain where entered >= \"".$sdate."\" and entered <= \"" .$edate."\" order by id asc";
		break;

	}
	echo "<FONT SIZE=4 FACE=ARIAL><B>$title</B></FONT><BR>";
	echo "<FONT SIZE=3 FACE=ARIAL><I>" . date('r') . "</I></FONT><FONT FACE=ARIAL>";
	if ($_REQUEST['showquery'] == "true") echo "<BR><BR>The query is: <BR><B>$query</B>";

	?>
	<HR>
	<TABLE WIDTH=85% ALIGN=CENTER BORDER=1>
		<TR>
			<?PHP if ($_REQUEST['format'] == "New Songs") { ?>
				<TH WIDTH=5%>Song Id</TH>
				<TH WIDTH=20%>Date Entered</TH>
				<TH WIDTH=20%>Song Artist</TH>
				<TH>Song Title</TH>
			<?PHP } else { ?>
				<TH WIDTH=8%>Rank</TH>
				<TH WIDTH=10%>Plays</TH>
				<TH WIDTH=7%>Id</TH>
				<TH>Song Title</TH>
				<TH WIDTH=10% ALIGN=CENTER>When?</TH>
			<?PHP } ?>
		</TR>
	<?PHP
		$result = mysqli_query($db, $query);
		$rank=1;
		while ($thisrow = mysqli_fetch_array($result)) {
			if ($_REQUEST['format'] == "New Songs") {
				echo "\n<TR><TD>".$thisrow['id']."</TD>";
				echo "\n\t<TD>".$thisrow['entered']."</TD>";
				echo "\n\t<TD>".$thisrow['artist']."</TD>";
				echo "\n\t<TD>".$thisrow['title']."</TD></TR>\n";
			} else {
				$query2 = "select title from lyricMain where id=" . $thisrow['songid'];
				$title = mysqli_fetch_array(mysqli_query($db,$query2));
				echo "\n<TR><TD>".$rank."</TD>";
				echo "\n\t<TD ALIGN=CENTER>".$thisrow['count']."</TD>";
				echo "\n<TD>".$thisrow['songid']."</TD>";
				echo "\n<TD><A onclick=\"jumpTo('song', 'showsong','song=".$thisrow['songid']."')\">";
				echo $title['title']."</A></TD>";
				echo "<TD><A onclick=\"jumpTo('audit','when','song=".$thisrow['songid']."')\">X</A>";
				echo "</TD></TR>\n";
				$rank++;
			}
		}
	?></TABLE>
	<?PHP
} else if ($_REQUEST['page']=="when") {
	$query = "select title from lyricMain where id=$song";
	$title = mysqli_fetch_array(mysqli_query($db,$query));
	echo "<FONT SIZE=4 FACE=ARIAL><B>When has <I>\"$title[title]\"</I> been used?:</B></FONT><BR><BR>";

	$result = mysqli_query($db,"select DATE_FORMAT(playdate,'%W %M %e, %Y at %T') from audit where songid=$song");
	while ($thisrow = mysqli_fetch_row($result)) {
		echo "$thisrow[0]<BR>";
	}
} else {
?>
<FONT SIZE=3 FACE=ARIAL><B>Select audit report options:</B></FONT><BR><BR>
<FONT SIZE=2>Please note: Limiting the number of results returned (ie Top 20 songs) may not yield completely accurate results as there may be a large number of songs played the same number of times. A "full statistics" report is the most accurate report.<BR><BR>
<FORM NAME="audit" action="javascript:jumpTo('audit','process','duration=' + document.audit.duration.value + '&sday=' + document.audit.sday.value + '&smonth=' + document.audit.smonth.value + '&syear=' + document.audit.syear.value + '&eday=' + document.audit.eday.value + '&emonth=' + document.audit.emonth.value + '&eyear=' + document.audit.eyear.value + '&sunday=' + document.audit.sunday.checked + '&hour=' + document.audit.hour.value + '&format=' + document.audit.format.value + '&showquery=' + document.audit.showquery.checked)">
<TABLE WIDTH="85%" BORDER=1>
<TR><TH>Steps</TH><TH>Options</TH></TR>
<TR><TD>
1. Select report duration:	</TD><TD>
			 		<SELECT NAME="duration">
						<OPTION>Complete History</OPTION>
						<OPTION>Date Range</OPTION>
					</SELECT>
					<BR/>
                    <B>Start Date:</B>
					<?PHP
                        $thisyear=date('Y');
						echo "Day<SELECT NAME=sday>\n";
						for ($i = 1; $i <= 31; $i++) {
							echo "<OPTION>$i</OPTION>\n";
						}
						echo "</SELECT>Month<SELECT NAME=smonth>\n";
						for ($i = 1; $i <= 12; $i++) {
							echo "<OPTION>$i</OPTION>\n";
						}
						echo "</SELECT>Year<SELECT NAME=syear>\n";
						for ($i = 2000; $i < $thisyear; $i++) {
							echo "<OPTION>$i</OPTION>\n";
						}
						echo "<OPTION SELECTED>$thisyear</OPTION>\n";
						echo "</SELECT>\n";
					?>
                    </BR>
                    <B>End Date:</B>
					<?PHP
						echo "Day<SELECT NAME=eday>\n";
						for ($i = 1; $i < 31; $i++) {
							echo "<OPTION>$i</OPTION>\n";
						}
                        echo "<OPTION SELECTED>31</OPTION>\n";
						echo "</SELECT>Month<SELECT NAME=emonth>\n";
						for ($i = 1; $i < 12; $i++) {
							echo "<OPTION>$i</OPTION>\n";
						}
                        echo "<OPTION SELECTED>12</OPTION>\n";
						echo "</SELECT>Year<SELECT NAME=eyear>\n";
						for ($i = 2000; $i < $thisyear; $i++) {
							echo "<OPTION>$i</OPTION>\n";
						}
						echo "<OPTION SELECTED>$thisyear</OPTION>\n";
						echo "</SELECT>\n";
					?>
				</TD</TR>
<TR><TD>
2. Select restricting options	</TD><TD>
					<INPUT TYPE=CHECKBOX NAME=sunday>Sunday only<BR>
					<INPUT TYPE=RADIO NAME=hour VALUE=AM>AM only
					<INPUT TYPE=RADIO NAME=hour VALUE=PM>PM only<BR>
				</TD></TR>
<TR><TD>
3. Select listing format:	</TD><TD>
			 		<SELECT NAME="format">
						<OPTION>Full statistics</OPTION>
						<OPTION>Top 20 songs</OPTION>
						<OPTION>Top 50 songs</OPTION>
						<OPTION>20 least played songs</OPTION>
						<OPTION>50 least played songs</OPTION>
						<OPTION>New Songs</OPTION>
					</SELECT>
				</TD</TR>

<TR><TD COLSPAN=2><CENTER>
	<INPUT TYPE="submit" VALUE="List all matches for above criteria" NAME="submit">
	<BR><INPUT TYPE=CHECKBOX NAME=showquery>Show query?
	</CENTER></TD></TR>
</TABLE>
</FORM>
<?PHP
}
?>
