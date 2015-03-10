<?PHP
// ----------------------------------
// show a song function
// ----------------------------------

	function images($category) {
	global $mediadb, $db_host, $db_user, $db_pwd;
	
	$mediadb = mysqli_connect("$db_host","$db_user","$db_pwd","mediaDb");
    mysqli_set_charset($mediadb,'utf8'); 
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
			$results = mysqli_query($mediadb,"SELECT description, type, id, format FROM media WHERE category='$category' ORDER BY description");
			
			while ($row = mysqli_fetch_row($results)) {
				echo "<TR><TD>$row[0]</TD>";
				if ($row[1] == "bg") {
					echo "<TD>Background</TD>";	
				} elseif ($row[1] == "img") {
					echo "<TD>Image</TD>";
				} else {
					echo "<TD>Unknown</TD>";
				}
				
				echo "<TD><A HREF=\"viewer.php?imageid=$row[2]&format=$row[3]\" target=\"_new\">Show</A></TD></TR>";
				
			}
		?>
			</TABLE>
		<?
	}

?>
