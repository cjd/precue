<?PHP
session_start();
include("includes/main.inc");
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

switch ($page) {
	case "disp": displayfunctions($book,$chapter,$start,$end); break;
	case "change": changefunctions($newdb,$newbible); break;
	default: unknown("","");
}

function displayfunctions($book,$chapter,$start,$end) {
global $bibledb, $mode, $bible_name, $bible_type;
	if ($mode == "selectbook") {
		echo "<FORM NAME=display ACTION=\"javascript:jumpTo('bible','disp','mode=selectchapter&book='+escape(document.display.book.value))\">";
echo "$bible_type : $bible : $bible_name<br>";
		echo "Please select the Book:<BR> <SELECT NAME=book>";
        if ($bible_type == "db") {
		    $results = mysql_query("SELECT DISTINCT book FROM verse",$bibledb);
		    while ($current = mysql_fetch_row($results)) {
			    echo "<OPTION>$current[0]</OPTION>\n";
		    }
        } else {
            $books = array (
            'Genesis',      'Exodus',        'Leviticus', 'Numbers',
            'Deuteronomy',  'Joshua',        'Judges',    'Ruth',
            '1 Samuel',     '2 Samuel',      '1 Kings',   '2 Kings',
            '1 Chronicles', '2 Chronicles',  'Ezra',      'Nehemiah',
            'Esther',       'Job',           'Psalms',    'Proverbs',
            'Ecclesiastes', 'Song of Songs', 'Isaiah',    'Jeremiah',
            'Lamentations', 'Ezekiel',       'Daniel',    'Hosea',
            'Joel',         'Amos',          'Obadiah',   'Jonah',
            'Micah',        'Nahum',         'Habakkuk',  'Zephaniah',
            'Haggai',       'Zechariah',     'Malachi', 
            'Matthew',      'Mark',          'Luke',      'John',
            'Acts',         'Romans',        '1 Corinthians', '2 Corinthians',
            'Galatians',    'Ephesians',     'Philippians','Colossians',
            '1 Thessalonians', '2 Thessalonians', '1 Timothy', '2 Timothy',
            'Titus',        'Philemon',      'Hebrews',   'James',
            '1 Peter',      '2 Peter',       '1 John',    '2 John',
            '3 John',       'Jude',          'Revelation'
            );
            foreach ($books as $book) {
			    echo "<OPTION>$book</OPTION>\n";
            }

        }
		echo "</SELECT><INPUT TYPE=submit NAME=submit VALUE=Select></FORM>";
	}
	else if ($mode =="selectchapter") {
		echo "You selected <B>$book</B>.<BR> Now select the chapter:";
		echo "<FORM NAME=display ACTION=\"javascript:jumpTo('bible','disp','mode=selectverse&book=".$book."&chapter='+escape(document.display.chapter.value))\">";
		echo "Chapter: <SELECT NAME=chapter>";
        if ($bible_type == "db") {
		    $results = mysql_query("SELECT max(chapternum) FROM verse where book='$book'",$bibledb);
	        while ($current = mysql_fetch_row($results)) {
		        for ($i = 1; $i <= $current[0]; $i++) {
			        echo "<OPTION>$i</OPTION>\n";
		        }
		    }
        } else {
                #"/usr/bin/diatheke -b %s -e UTF8 -k '%s' | grep '^%s'| tail -2 | head -1",
            $command = sprintf(
                "/usr/bin/diatheke -b %s -e UTF8 -k '%s' ",
                $bible_name, $book
                );
            exec("$command",$ret);
            $maxchap=1;
            #$maxchap = ereg_replace("^".$book ."([0-9]*):[0-9].*$","$1",$ret);
		    for ($i = 1; $i <= $maxchap; $i++) {
			    echo "<OPTION>$i</OPTION>\n";
		    }
        }
		echo "</SELECT><INPUT TYPE=submit NAME=submit VALUE=Select></FORM>";
            echo $command.":".$maxchap.":".$ret."<br>";
echo ":".  $ret[0]."<BR>\n";
	}
	else if ($mode =="selectverse") {

		echo "You selected <B>$book</B>, Chapter $chapter.<BR> Now select the start and end verses:";
		$results = mysql_query("SELECT max(versenum) FROM verse where book='$book' and chapternum='$chapter'",$bibledb);

		echo "<FORM NAME=display ACTION=\"javascript:jumpTo('bible','disp','mode=display&book=".$book."&chapter=".$chapter."&start='+document.display.start.value+'&end='+document.display.end.value)\">";
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
                $esctitle= str_replace("'","\'", $title);
			    echo "<A onclick=\"jumpTo('bible','change','mode=commit&newdb=db;$dbname&newbible=$esctitle')\">$title</A><BR>\n";
            }
        }


        $command = "HOME=/var/www diatheke -b system -k modulelist";
        $output = shell_exec($command);
        foreach (split("\n",$output) as $row) {
            list ($sword, $title) = split(" : ", $row);
            if (!is_null($title)) {
                $esctitle= str_replace("'","\'", $title);
			    echo "<A onclick=\"jumpTo('bible','change','mode=commit&newdb=sword;$sword&newbible=$esctitle')\">$title</A><BR>\n";
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
