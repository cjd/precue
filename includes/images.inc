<?PHP
// ----------------------------------
// show a song function
// ----------------------------------

	function images() {
	global $mediadb, $category, $db_host, $db_user, $db_pwd;
	
	if ($db_pwd=='') {
		$mediadb = mysql_pconnect("$db_host","$db_user");
	} else {
		$mediadb = mysql_pconnect("$db_host","$db_user","$db_pwd");
	}
	mysql_select_db("mediaDb",$mediadb);
		?>
			<B>Available images:</B><BR><BR>
			Background - For display behind text<BR>
			Image - For standalone display<BR><BR>
			<TABLE BORDER=2>
				<TR>
					<TH>Description</TH>
					<TH>Type</TH>
				</TR>
		<?
			$results = mysql_query("SELECT description, type, id, format FROM media WHERE category='$category' ORDER BY description",$mediadb);
			
			while ($row = mysql_fetch_row($results)) {
				echo "<TR><TD>$row[0]</TD>";
				if ($row[1] == "bg") {
					echo "<TD>Background</TD>";	
				} elseif ($row[1] == "img") {
					echo "<TD>Image</TD>";
				} else {
					echo "<TD>Unknown</TD>";
				}
				
				echo "<TD><A HREF=viewer.php?imageid=$row[2]&format=$row[3] TARGET=_new>Show</A></TD></TR>";
				
			}
		?>
			</TABLE>
		<?
	}

?>
