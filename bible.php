<?PHP
session_start();
include("includes/sessionimport.inc");
import_request_variables("GPC","");

list ($bible_type,$bible_name) = split(";", $bible);
if (strcmp($bible_type, "db") == 0) {
    if ($db_pwd=='') {
	    $bibledb = mysql_pconnect("$db_host","$db_user");
    } else {
	    $bibledb = mysql_pconnect("$db_host","$db_user","$db_pwd");
    }
    mysql_select_db("$bible_name",$bibledb);
}
session_unregister(biblesdata);
?>

<?PHP

include("includes/header.inc");

switch ($action) {
	case "disp": displayfunctions($book,$chapter,$start,$end); break;
	case "change": changefunctions($newdb,$newbible); break;
	default: unknown();
}

function displayfunctions($book,$chapter,$start,$end) {
global $bibledb, $mode, $biblename, $bible_type;
	if ($mode == "selectbook") {
		echo "<FORM NAME=display ACTION=bible.php?action=disp&mode=selectchapter METHOD=POST>";
		echo "Please select the Book:<BR> <SELECT NAME=book>";
        if ($bible_type == "db") {
		$results = mysql_query("SELECT DISTINCT book FROM verse",$bibledb);


		while ($current = mysql_fetch_row($results)) {
			echo "<OPTION>$current[0]</OPTION>\n";
		}
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
global $db, $db_pass, $db_host, $db_user;
	if ($mode == "select") {
		echo "<B>Please select the new bible database to use:</B><BR>";
        if ($db_pwd=='') {
                $db = mysql_pconnect("$db_host","$db_user");
        } else {
                $db = mysql_pconnect("$db_host","$db_user","$db_pwd");
        }

        $db_list = mysql_list_dbs($db);
        while ($row = mysql_fetch_object($db_list)) {
            $query = "SELECT * FROM verse WHERE book=\"Bible\";";
            $dbname = $row->Database;
            mysql_select_db($dbname);
            $result = mysql_query($query, $db);
            if ($result) {
                $row = mysql_fetch_assoc($result);
                $title=$row['verse'];
			    echo "<A HREF=\"bible.php?action=change&mode=commit&newdb=db;$dbname&newbible=$title\">$title</A><BR>";
            }
        }


        $command = "HOME=/var/www diatheke -b system -k modulelist";
        $output = shell_exec($command);
        foreach (split("\n",$output) as $row) {
            list ($sword, $title) = split(" : ", $row);
            if (!is_null($title)) {
			    echo "<A HREF=\"bible.php?action=change&mode=commit&newdb=sword;$sword&newbible=$title\">$title</A><BR>";
            }
        }

	} else if ($mode =="commit") {
		$bible = $newdb;
        $_SESSION['bible'] = $newdb;
		$_SESSION['biblename'] = $newbible;
		echo "Bible database changed to $newbible.<BR>";
	}
}
// ----------------------------------
// unknown function
// ----------------------------------


	function unknown($action,$mode) {
	global $action, $mode;
		?>
			<CENTER><B>The Precue bible function failed!</B><BR>Please try again.<BR><BR>

		<?PHP

		echo "The exact error was:<BR> Precue failed to run a bible function using the action ";
		echo "<I>$action</I> and the mode <I>$mode</I>.</CENTER>";
	}
		
?>
