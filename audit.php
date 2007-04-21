<?PHP
session_start();
include("includes/sessionimport.inc");
import_request_variables("GPC","");

if ($db_pwd=='') {
	$db = mysql_pconnect("$db_host","$db_user");
} else {
	$db = mysql_pconnect("$db_host","$db_user","$db_pwd");
}
mysql_select_db("lyricDb",$db);

echo "<BODY BGCOLOR=$bgcolor BACKGROUND=$bgimage LINK=$linkcolor VLINK=$vlinkcolor TEXT=$textcolor LINK=000000 ALINK=000000 VLINK=000000>";

if ($action == "process") {
	$title = strtolower($format);

	$query = "";
	$date = "\"0000-00-00\" ";
	//construct duration limitation
	switch ($duration) {
		case "Last Week": $date = "NOW() - INTERVAL 7 DAY ";
			$title = $title . " for the " . strtolower($duration);
			break;
		case "Last Month": $date = "NOW() - INTERVAL 1 MONTH ";
			$title = $title . " for the " . strtolower($duration);
			break;
		case "Last Quarter": $date = "NOW() - INTERVAL 3 MONTH ";
			$title = $title . " for the " . strtolower($duration);
			break;
		case "Last Year": $date = "NOW() - INTERVAL 1 YEAR ";
			$title = $title . " for the " . strtolower($duration);
			break;
		case "Since certain date": $date = "\"". $year."-".$month."-".$day."\" ";
			$title = $title . " since " . $date;
			break;
	}
	if ($sunday == "on") {
		$query .= "and WEEKDAY(playdate) = 6 " ;
		$title .= " on Sundays";
	}
	if ($hour == "AM") {
		$query .= "and HOUR(playdate) < 12 ";
		$title .= " (AM Only)";
	}
	else if ($hour =="PM") {
		$query .= "and HOUR(playdate) >= 12 ";
		$title .= " (PM Only)";
	}

	switch ($format) {

	case "Full statistics":	$query = "select count(songid) as count, songid from audit where playdate >= " . $date. $query . " group by songid order by count desc, songid asc";
		break;
	case "Top 20 songs": $query = "select count(songid) as count, songid from audit where playdate >= " . $date. $query . " group by songid order by count desc, songid desc limit 20";
		break;
	case "Top 50 songs": $query = "select count(songid) as count, songid from audit where playdate >= " . $date. $query . " group by songid order by count desc, songid desc limit 50";
		break;
	case "20 least played songs": $query = "select count(songid) as count, songid from audit where playdate >= " . $date . $query . " group by songid order by count asc, songid asc limit 20";
		break;
	case "50 least played songs": $query = "select count(songid) as count, songid from audit where playdate >= " . $date . $query . " group by songid order by count asc, songid asc limit 50";
		break;
	case "New Songs": $query = "select id,title,artist,entered from lyricMain where entered > ".$date." order by id asc";
		break;

	}
	echo "<FONT SIZE=4 FACE=ARIAL><B>$title</B></FONT><BR>";
	echo "<FONT SIZE=3 FACE=ARIAL><I>" . date(r) . "</I></FONT><FONT FACE=ARIAL>";
	if ($showquery) echo "<BR><BR>The query is: <BR><B>$query</B>";

	?>
	<HR>
	<TABLE WIDTH=85% ALIGN=CENTER BORDER=1>
		<TR>
			<?PHP if ($format == "New Songs") { ?>
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
		$result = mysql_query($query,$db);
		$rank=1;
		while ($thisrow = mysql_fetch_array($result)) {
			if ($format == "New Songs") {
				echo "\n<TR><TD>$thisrow[id]</TD>";
				echo "\n\t<TD>$thisrow[entered]</TD>";
				echo "\n\t<TD>$thisrow[artist]</TD>";
				echo "\n\t<TD>$thisrow[title]</TD></TR>\n";
			} else {
				$query2 = "select title from lyricMain where id=" . $thisrow[songid];
				$title = mysql_fetch_array(mysql_query($query2,$db));
				echo "\n<TR><TD>$rank</TD>";
				echo "\n\t<TD ALIGN=CENTER>$thisrow[count]</TD>";
				echo "\n<TD>$thisrow[songid]</TD>";
				echo "\n<TD><A HREF=lds.php?action=showsong&song=$thisrow[songid]>";
				echo "$title[title]</A></TD>";
				echo "<TD><A HREF=audit.php?action=when&song=$thisrow[songid]>X</A>";
				echo "</TD></TR>\n";
				$rank++;
			}
		}
	?></TABLE>
	<?PHP
} else if ($action=="when") {
	$query = "select title from lyricMain where id=$song";
	$title = mysql_fetch_array(mysql_query($query,$db));
	echo "<FONT SIZE=4 FACE=ARIAL><B>When has <I>\"$title[title]\"</I> been used?:</B></FONT><BR><BR>";

	$result = mysql_query("select DATE_FORMAT(playdate,'%W %M %e, %Y at %T') from audit where songid=$song",$db);
	while ($thisrow = mysql_fetch_row($result)) {
		echo "$thisrow[0]<BR>";
	}
} else {
?>
<FONT SIZE=3 FACE=ARIAL><B>Select audit report options:</B></FONT><BR><BR>
<FONT SIZE=2>Please note: Limiting the number of results returned (ie Top 20 songs) may not yield completely accurate results as there may be a large number of songs played the same number of times. A "full statistics" report is the most accurate report.<BR><BR>
<TABLE WIDTH="85%" BORDER=1>
<FORM NAME="audit_option" action=audit.php?action=process method=post>
<TR><TH>Steps</TH><TH>Options</TH></TR>
<TR><TD>
1. Select report duration:	</TD><TD>
			 		<SELECT NAME="duration">
						<OPTION>Complete History</OPTION>
						<OPTION>Last Week</OPTION>
						<OPTION>Last Month</OPTION>
						<OPTION>Last Quarter</OPTION>
						<OPTION>Last Year</OPTION>
						<OPTION>Since certain date</OPTION>
					</SELECT>
					<BR/>
					<?PHP
						echo "Day<SELECT NAME=day>\n";
						for ($i = 1; $i <= 31; $i++) {
							echo "<OPTION>$i</OPTION>\n";
						}
						echo "</SELECT>Month<SELECT NAME=month>\n";
						for ($i = 1; $i <= 12; $i++) {
							echo "<OPTION>$i</OPTION>\n";
						}
						echo "</SELECT>Year<SELECT NAME=year>\n";
						for ($i = 2000; $i <= 2010; $i++) {
							echo "<OPTION>$i</OPTION>\n";
						}
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
</FORM>
</TABLE>
<?PHP
}
