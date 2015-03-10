<?PHP
// ----------------------------------
// song editing function
// created by Mark Clearwater
// modified from existing new song code
// mclearwater@gmail.com
// ----------------------------------

function editasong($song) {
    global $db;
    $result = mysqli_query($db,"select * from lyricMain where id='$song'");
    $thisSong = mysqli_fetch_array($result);
    $result = mysqli_query($db,"select * from page where songid='$thisSong[songnum]'");
    if(mysqli_num_rows($result) == 0) {
        $pagesarray = "";
        $nopages = 0; 
    } else {
        $pagerow = mysqli_fetch_array($result);
        $nopages = mysqli_num_rows($result);
    }
    ?>

	<FORM NAME="songdata" ACTION="javascript:updatesong()" METHOD="POST" accept-charset="utf-8">
	<INPUT TYPE="hidden" NAME="songid" VALUE="<?PHP echo "$thisSong[id]"; ?>">
	<FONT SIZE="4"><B>Editing a song:</B></FONT><BR>
	Song Name: <INPUT TYPE="text" SIZE="50" NAME="songname" VALUE="<?PHP echo "$thisSong[title]"; ?>"><BR>
	Artist(s): <INPUT TYPE="text" SIZE="50" NAME="artist" VALUE="<?PHP echo "$thisSong[artist]"; ?>"><BR>
	Song book: <INPUT TYPE="text" SIZE="50" NAME="songbook" VALUE="<?PHP echo "$thisSong[book]"; ?>"><BR>
	Keywords : <INPUT TYPE="text" SIZE="50" NAME="keywords" VALUE="<?PHP echo "$thisSong[keywords]"; ?>"><BR>
	Song No. : <INPUT TYPE="text" SIZE="10" NAME="songno" VALUE="<?PHP echo "$thisSong[songnum]"; ?>">

	<?PHP
	$wordsresult = mysqli_query($db,"SELECT lyrics FROM page WHERE songid=$thisSong[id] ORDER BY pagenum" );
		
	$curpage=1;

	while ($wordsdata = mysqli_fetch_row($wordsresult)) {
		echo "<BR><BR><FONT COLOR=\"BLUE\">Page $curpage:<BR>";
		echo "<TEXTAREA ROWS=\"9\" COLS=50 NAME=\"pagedata$curpage\">$wordsdata[0]</TEXTAREA>";

		$curpage++;
	}

				?>
	<BR><BR><INPUT TYPE="submit" NAME="action" VALUE="Save the Edited Song">
	</FORM>
				<?PHP
}

	function updateasong($songid, $nopages,$songname,$artist,$songno,$songbook,$keywords,$pagesarray) {
    global $db;
			//commit the song to the database

			$songid = $songid;
			

			mysqli_query($db, "UPDATE lyricMain SET title='$songname',songnum='$songno',book='$songbook',artist='$artist',written=now(), keywords='$keywords' WHERE id = '$songid'");

			$count=0;

			$result = mysqli_query($db, "select count(*) AS count FROM page WHERE songid='$songid'");
			$pagecount = mysqli_fetch_array($result);
			$pagecount = $pagecount['count'];
			while ($count < $pagecount) {
			      $lyrics = $pagesarray[$count];
				$count ++;
                $lyrics = mysqli_real_escape_string($db,utf8_urldecode($lyrics));
				mysqli_query($db, "UPDATE page SET lyrics='$lyrics' WHERE pagenum=$count AND songid='$songid'");


			} ?>

			<B> Your song has been updated</B><BR>

<?PHP
		}
?>
