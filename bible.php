<?PHP
session_start();
if ($db_pwd=='') {
	$bibledb = mysql_pconnect("$db_host","$db_user");
} else {
	$bibledb = mysql_pconnect("$db_host","$db_user","$db_pwd");
}
mysql_select_db("$bible",$bibledb);
session_unregister(biblesdata);
?>

<HEAD>
	<TITLE>Lyric Display System Frontend <?PHP echo "$fver for LDS $ldsver"; ?></TITLE>
</HEAD>


<BODY BGCOLOR=<?PHP echo $bgcolor; ?> BACKGROUND=<?PHP echo $bgimage; ?> LINK=<?PHP echo $linkcolor; ?> VLINK=<?PHP echo $vlinkcolor; ?> TEXT=<?PHP echo $textcolor; ?> >

<?PHP

switch ($action) {
	case "disp": displayfunctions($book,$chapter,$start,$end); break;
	case "change": changefunctions($newdb,$newbible); break;
	default: unknown();
}

function displayfunctions($book,$chapter,$start,$end) {
global $bibledb, $mode, $biblename;
	if ($mode == "selectbook") {
		$results = mysql_query("SELECT DISTINCT book FROM verse",$bibledb);

		echo "<FORM NAME=display ACTION=bible.php?action=disp&mode=selectchapter METHOD=POST>";
		echo "Please select the Book:<BR> <SELECT NAME=book>";

		while ($current = mysql_fetch_row($results)) {
			echo "<OPTION>$current[0]</OPTION>\n";
		}
		echo "</SELECT><INPUT TYPE=submit NAME=submit VALUE=Select></FORM>";
	}
	else if ($mode =="selectchapter") {
		echo "You selected <B>$book</B>.<BR> Now select the chapter:";

		$results = mysql_query("SELECT max(chapternum) FROM verse where book='$book'",$bibledb);

		echo "<FORM NAME=display ACTION=\"bible.php?action=disp&mode=selectverse&book=$book\" METHOD=POST>";
		echo "Chapter: <SELECT NAME=chapter>";

		while ($current = mysql_fetch_row($results)) {
			for ($i = 1; $i <= $current[0]; $i++) {
				echo "<OPTION>$i</OPTION>\n";
			}
		}
		echo "</SELECT><INPUT TYPE=submit NAME=submit VALUE=Select></FORM>";
	}
	else if ($mode =="selectverse") {

		echo "You selected <B>$book</B>, Chapter $chapter.<BR> Now select the start and end verses:";
		$results = mysql_query("SELECT max(versenum) FROM verse where book='$book' and chapternum='$chapter'",$bibledb);

		echo "<FORM NAME=display ACTION=\"bible.php?action=disp&mode=display&book=$book&chapter=$chapter\" METHOD=POST>";
		echo "</SELECT> Starting verse: <SELECT NAME=start>";

		while ($current = mysql_fetch_row($results)) {
			for ($i = 1; $i <= $current[0]; $i++) {
				echo "<OPTION>$i</OPTION>\n";
			}
		}

		$results = mysql_query("SELECT max(versenum) FROM verse where book='$book' and chapternum='$chapter'",$bibledb);

		echo "</SELECT> Ending verse: <SELECT NAME=end>";

		while ($current = mysql_fetch_row($results)) {
			for ($i = 1; $i <= $current[0]; $i++) {
				echo "<OPTION>$i</OPTION>\n";
			}
		}
		echo "</SELECT><INPUT TYPE=submit NAME=submit VALUE=Select></FORM>";
	}
	else if ($mode =="display") {
		echo "<FONT COLOR=0000FF SIZE=5 FACE=ARIAL><I>$biblename</I></FONT><BR>";
		echo "<B>$book</B>, Chapter $chapter, Verses $start - $end.<BR><BR>";


		$results = mysql_query("SELECT versenum, verse FROM verse where book='$book' 
					and chapternum='$chapter' and versenum >= '$start' and versenum <= '$end'",$bibledb);


		while ($current = mysql_fetch_row($results)) {
			echo "<FONT COLOR=0000FF><B>$current[0]</B>: </FONT>$current[1]<BR>";
		}

		
	}
	else {
		unknown("disp",$mode);
	}
}

function changefunctions($newdb,$newbible) {
global $mode, $bibledb, $bible, $biblename;
	if ($mode == "select") {
		echo "<B>Please select the new bible database to use:</B><BR>";

		$fd = fopen("/etc/lyricue/default.conf","r");
		 
		if (!$fd) {
		 	echo "<BR>Config file not found!";
		} else {
			while(!feof($fd)) {
				$line = fgets($fd, 4096);

				if (substr($line, 0, 5) == "Bible") {
					$line = substr($line, 6);
					$poseq = strpos($line,"=") + 1;
					$possem = strpos($line,";");
					$bname = substr($line,$poseq,$possem -1);
					$bname = ereg_replace("_","",$bname);
					$bdb = substr($line,$possem + 1);

					echo "<A HREF=\"bible.php?action=change&mode=commit&newdb=$bdb&newbible=$bname\">";
					echo "$bname</A><BR>";
				}
			}
		fclose($fd);
		}

	} else if ($mode =="commit") {
		$bible = $newdb;
		$biblename = $newbible;
		echo "Bible database changed to $newbible.<BR>";
	}
}
// ----------------------------------
// unknown function
// ----------------------------------


	function unknown($action,$mode) {
	global $action, $mode;
		?>
			<CENTER><B>The LDSF bible function failed!</B><BR>Please try again.<BR><BR>

		<?PHP

		echo "The exact error was:<BR> LDSF failed to run a bible function using the action ";
		echo "<I>$action</I> and the mode <I>$mode</I>.</CENTER>";
	}
		
?>
