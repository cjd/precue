<?PHP
// ----------------------------------
// song adding function
// ----------------------------------


	function addanewsong(){
	global $db;

			?>
			</CENTER>

			<FORM NAME="songdata" ACTION="javascript:savesong()" METHOD="POST">
			<FONT SIZE="4"><B>Adding a new song:</B></FONT><BR>
			Song Name: <INPUT TYPE="text" SIZE="50" NAME="songname"><BR>
			Artist(s): <INPUT TYPE="text" SIZE="50" NAME="artist"><BR>
			Song book: <INPUT TYPE="text" SIZE="50" NAME="songbook"><BR>
			Keywords : <INPUT TYPE="text" SIZE="50" NAME="keywords"><BR>
			Song No. : <INPUT TYPE="text" SIZE="10" NAME="songno">


			<BR><BR><B>Pages</B><BR>
            <DIV ID="pages">
            <I>Page 1</I><BR>
            <TEXTAREA ROWS="9" COLS=50 NAME="pagedata1"></TEXTAREA><BR>
            </DIV>
            <INPUT TYPE="button" VALUE="Add new page" onclick="addpage()">
			<BR><BR><INPUT TYPE="submit" NAME="action" VALUE="Save the Song">
			</FORM>

			<?PHP
		}

    function savesong ($nopages,$songname,$artist,$songno,$songbook,$keywords,$pagesarray) {
        global $db;
			//commit the song to the database


			//get the next available song id
			$result = mysql_query("SELECT MAX(id)+1 FROM lyricMain WHERE id <2000000", $db);
			$thisrow = mysql_fetch_row($result);
			$songid = $thisrow[0];


            $result = mysql_query("INSERT INTO lyricMain (id, title, songnum, book, artist,written, keywords, entered, copyright) VALUES('$songid','$songname','$songno','$songbook','$artist',now(), '$keywords','','')", $db);
			$count=0;

			// for all non empty song pages
			
			while (count <=19 & $pagesarray[$count] != "") {

				$pagecount = $count + 1;

				//determine what pageid to give the current page
				$result = mysql_query("SELECT MAX(pageid)+1 FROM page WHERE pageid < 2000000", $db);
				$nextpageid = mysql_fetch_row($result);

				#ereg_replace($pagesarray[$count],'\r','');

				// insert pageid songid pagenum lyrics
				mysql_query("INSERT INTO page (pageid, songid, pagenum, lyrics)VALUES('$nextpageid[0]','$songid','$pagecount','$pagesarray[$count]')",$db);

				$count ++;

			} ?>

			<CENTER>
			
			<B> Your song has been added to the database, click on the link below to view your song:</B><BR>

			<A onclick="jumpTo('song','showsong','song=<? echo $songid; ?>')">Click here</A><BR>

			or choose another option from the menu. </CENTER><?

		}
?>

