<?PHP
// ----------------------------------
// song editing function
// created by Mark Clearwater
// modified from existing new song code
// mclearwater@gmail.com
// ----------------------------------


	function editasong($editsong,$nopages,$songname,$artist,$songno,$songbook,$keywords,$pagesarray) {
	global $db;

		if ($editsong == "edit") {
		   $result = mysql_query("select * from lyricMain where id='$_GET[song]'",$db);
		   $thisSong = mysql_fetch_array($result);
		   $result = mysql_query("select * from page where songid='$thisSong[songnum]'",$db);
		   if(mysql_num_rows($result) == 0) {
		     $pagesarray = "";
		     $nopages = 0; 
		   } else {
		    $pagerow = mysql_fetch_array($result);
		    $nopages = mysql_num_rows($result);
		   }
				?>
				</CENTER>

				<FORM NAME="songdata" ACTION="<?PHP echo $PHP_SELF; ?>" METHOD="POST">
				<INPUT TYPE="hidden" NAME="songid" VALUE="<?PHP echo "$thisSong[id]"; ?>">
				<FONT SIZE="4"><B>Editing a song:</B></FONT><BR>
				Song Name: <INPUT TYPE="text" SIZE="50" NAME="songname" VALUE="<?PHP echo "$thisSong[title]"; ?>"><BR>
				Artist(s): <INPUT TYPE="text" SIZE="50" NAME="artist" VALUE="<?PHP echo "$thisSong[artist]"; ?>"><BR>
				Song book: <INPUT TYPE="text" SIZE="50" NAME="songbook" VALUE="<?PHP echo "$thisSong[book]"; ?>"><BR>
				Keywords : <INPUT TYPE="text" SIZE="50" NAME="keywords" VALUE="<?PHP echo "$thisSong[keywords]"; ?>"><BR>
				Song No. : <INPUT TYPE="text" SIZE="10" NAME="songno" VALUE="<?PHP echo "$thisSong[songnum]"; ?>">


				<?PHP
		$wordsresult = mysql_query("SELECT lyrics FROM page WHERE songid=$thisSong[id] ORDER BY pagenum" , $db);
		
		$curpage=1;

		while ($wordsdata = mysql_fetch_row($wordsresult)) {
			echo "<BR><BR><FONT COLOR=\"BLUE\">Page Number $curpage:<BR>";
			echo "<TEXTAREA ROWS=\"9\" COLS=50 NAME=\"pagedata$curpage\">$wordsdata[0]</TEXTAREA>";

			$curpage++;
		}

				?>
				<BR><BR><INPUT TYPE="submit" NAME="action" VALUE="Save the Edited Song">
				</FORM>

				<?PHP

		
		} else {
			//commit the song to the database

			$songid = $_POST[songid];
			

			mysql_query("UPDATE lyricMain SET title='$songname',songnum='$songno',book='$songbook',artist='$artist',written=now(),
			keywords='$keywords' WHERE id = '$songid'", $db);

			$count=0;

			$result = mysql_query("select count(*) AS count FROM page WHERE songid='$songid'",$db);
			$pagecount = mysql_fetch_array($result);
			$pagecount = $pagecount[count];
			while ($count < $pagecount) {
			      $lyrics = $pagesarray[$count];
				$count ++;
				mysql_query("UPDATE page SET lyrics='$lyrics' WHERE pagenum=$count AND songid='$songid'",$db);


			} ?>

			<CENTER>
			
			<B> Your song has been updated, click on the link below to view your song:</B><BR>

			<A HREF="<? echo $PHP_SELF; ?>?action=showsong&song=<? echo $songid; ?>">Click here</A><BR>

			or choose another option from the menu. </CENTER><?

		}


	}
?>
