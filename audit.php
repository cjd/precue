<?PHP
session_start();
if ($db_pwd=='') {
	$db = mysql_pconnect("$db_host","$db_user");
} else {
	$db = mysql_pconnect("$db_host","$db_user","$db_pwd");
}
mysql_select_db("lyricDb",$db);

echo "<BODY BGCOLOR=$bgcolor BACKGROUND=$bgimage LINK=$linkcolor VLINK=$vlinkcolor TEXT=$textcolor LINK=000000 ALINK=000000 VLINK=000000>";

if ($action == "process") {
	$title = "The " . strtolower($format) . " for the " . strtolower($duration);

	$query = "";
	$begin = false;
	//construct duration limitation
	switch ($duration) {
		case "Last Week": $query .= "where playdate >= NOW() - INTERVAL 7 DAY ";
			$begin = true;
			break;
		case "Last Month": $query .= "where playdate >= NOW() - INTERVAL 1 MONTH ";
			$begin = true;
			break;
		case "Last Quarter": $query .= "where playdate >= NOW() - INTERVAL 3 MONTH ";
			$begin = true;
			break;
		case "Last Year": $query .= "where playdate >= NOW() - INTERVAL 1 YEAR ";
			$begin = true;
			break;
	}
	if ($sunday == "on") {
		if ($begin == true) { 
			$query .= "and WEEKDAY(playdate) = 6 " ;
			$title .= " on Sundays";
		}
		else { 
			$query .= "where WEEKDAY(playdate) = 6 ";
			$begin = true;
			$title .= " on Sundays";
		}
	}
	if ($hour == "AM") {
		if ($begin == true) { 
			$query .= "and HOUR(playdate) < 12 ";
			$title .= " (AM Only)";
		} else { 
			$query .= "where HOUR(playdate) < 12 ";
			$begin = true;
			$title .= " (AM Only)";
		}
	}
	else if ($hour =="PM") {
		if ($begin == true) { 
			$query .= "and HOUR(playdate) >= 12 ";
			$title .= " (PM Only)";
		} else { 
			$query .= "where HOUR(playdate) >= 12 ";
			$begin = true;
			$title .= " (PM Only)";
		}
	}

	switch ($format) {


	case "Full statistics":	$query = "select count(songid) as count, songid from audit " . $query . " group by songid order by count desc, songid asc";
		break;
	case "Top 20 songs": $query = "select count(songid) as count, songid from audit " . $query . " group by songid order by count desc, songid desc limit 20";
		break;
	case "Top 50 songs": $query = "select count(songid) as count, songid from audit " . $query . " group by songid order by count desc, songid desc limit 20";
		break;
	case "20 least played songs": $query = "select count(songid) as count, songid from audit " . $query . " group by songid order by count asc, songid asc limit 20";
		break;
	case "50 least played songs": $query = "select count(songid) as count, songid from audit " . $query . " group by songid order by count asc, songid asc limit 50";
		break;

	}
	echo "<FONT SIZE=4 FACE=ARIAL><B>$title</B></FONT><BR>";
	echo "<FONT SIZE=3 FACE=ARIAL><I>" . date(r) . "</I></FONT><FONT FACE=ARIAL>";
	if ($showquery) echo "<BR><BR>The query is: <BR><B>$query</B>";

	?>
	<HR>
	<TABLE WIDTH=85% ALIGN=CENTER BORDER=1>
		<TR>
			<TH WIDTH=8%>Rank</TH>
			<TH WIDTH=10%>Plays</TH>
			<TH WIDTH=7%>Id</TH>
			<TH>Song Title</TH>
			<TH WIDTH=10% ALIGN=CENTER>When?</TH>
		</TR>
	<?PHP
		$result = mysql_query($query,$db);
		$rank=1;
		while ($thisrow = mysql_fetch_array($result)) {
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
					</SELECT>
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
