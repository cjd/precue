<?PHP
// ----------------------------------
// song adding function
// ----------------------------------


	function addanewsong($addsong,$nopages,$songname,$artist,$songno,$songbook,$keywords,$pagesarray) {
	global $db;

		if ($addsong == "addnew" | $addsong == "Add a new song") {

			if ($nopages == "") {

				?>
					<FORM NAME="advsearch" ACTION="<?PHP echo $PHP_SELF; ?>" METHOD="POST">
					Please type number of pages the song shall occupy here. <BR>If uncertain, enter a large number (I.e. 10).<BR>Blank pages will be ingored.<BR><BR>
					<INPUT TYPE="text" SIZE="3" NAME="nopages">
					<INPUT TYPE="submit" NAME="addsong" VALUE="Add a new song"></FORM>
				<?PHP
			}
			//prevent the webserver being choked by a request to generate 1000000000's of textareas on one page!
			//NOTE: this number is determined by the pagesarray! Don't change...!

			elseif ($nopages > 20) {

				echo "LDSF limits the number of pages to 20! Please try again.";?><BR>
				<FORM NAME="advsearch" ACTION="<?PHP echo $PHP_SELF; ?>" METHOD="POST">
				<INPUT TYPE="text" SIZE="5" NAME="nopages">
				<INPUT TYPE="submit" NAME="addsong" VALUE="Add a new song"></FORM><?PHP
			}


			else {
				?>
				</CENTER>

				<FORM NAME="songdata" ACTION="<?PHP echo $PHP_SELF; ?>" METHOD="POST">
				<FONT SIZE="4"><B>Adding a new song:</B></FONT><BR>
				Song Name: <INPUT TYPE="text" SIZE="50" NAME="songname"><BR>
				Artist(s): <INPUT TYPE="text" SIZE="50" NAME="artist"><BR>
				Song book: <INPUT TYPE="text" SIZE="50" NAME="songbook"><BR>
				Keywords : <INPUT TYPE="text" SIZE="50" NAME="keywords"><BR>
				Song No. : <INPUT TYPE="text" SIZE="10" NAME="songno">


				<?PHP
					$pageno = 1;
					while ($pageno <= $nopages) {
						
						echo "<BR><BR><FONT COLOR=\"BLUE\">Page Number $pageno:<BR>";
						echo "<TEXTAREA ROWS=\"9\" COLS=50 NAME=\"pagedata$pageno\"></TEXTAREA>";

						$pageno++;
					}

				?>
				<BR><BR><INPUT TYPE="submit" NAME="action" VALUE="Save the Song">
				</FORM>

				<?PHP
				
			}

			

		}

		else {
			//commit the song to the database


			//get the next available song id
			$result = mysql_query("SELECT MAX(id)+1 FROM lyricMain WHERE id <2000000", $db);
			$thisrow = mysql_fetch_row($result);
			$songid = $thisrow[0];


			mysql_query("INSERT INTO lyricMain VALUES('$songid','$songname','$songno','$songbook','$artist',now(),
			'$keywords','','')", $db);

			$count=0;

			// for all non empty song pages
			
			while (count <=19 & $pagesarray[$count] != "") {

				$pagecount = $count + 1;

				//determine what pageid to give the current page
				$result = mysql_query("SELECT MAX(pageid)+1 FROM page WHERE pageid < 2000000", $db);
				$nextpageid = mysql_fetch_row($result);

				#ereg_replace($pagesarray[$count],'\r','');

				// insert pageid songid pagenum lyrics

				mysql_query("INSERT INTO page VALUES('$nextpageid[0]','$songid','$pagecount','$pagesarray[$count]')",$db);


				$count ++;

			} ?>

			<CENTER>
			
			<B> Your song has been added to the database, click on the link below to view your song:</B><BR>

			<A HREF="<? echo $PHP_SELF; ?>?action=showsong&song=<? echo $songid; ?>">Click here</A><BR>

			or choose another option from the menu. </CENTER><?

		}


	}
?>

