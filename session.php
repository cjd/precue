<?PHP
//begin session and register general use variables
session_start();
session_register(fver);
session_register(ldsver);
session_register(bgcolor);
session_register(linkcolor);
session_register(vlinkcolor);
session_register(textcolor);
session_register(bgimage);
session_register(bible);
session_register(biblename);

//set the general use variables
$fver="0.5";
$ldsver="1.2";
$bgcolor="#DDDDFF";
$linkcolor="#0000FF";
$vlinkcolor="#0000FF";
$textcolor="#000000";
$bgimage = "images/bgtile.jpg";
$bible = "bibleDb";
$biblename = "King James Version (Default)";

//make lyricue persistent database connection
session_register(db);
$db = mysql_pconnect("localhost","lyric");
mysql_select_db("lyricDb",$db);

//make lyricue persistent bible database connection
session_register($bibledb);
$bibledb = mysql_pconnect("localhost","lyric");
mysql_select_db("$bible",$bibledb);

//make media database connection
session_register($mediadb);
$mediadb = mysql_pconnect("localhost","lyric");
mysql_select_db("mediaDb",$mediadb);

//include the media array
include("media.inc");
//include the audit exclusions array
//include("auditexc.inc");

//jump out of php and redirect to main frameset
?>
<HEAD>
	<TITLE>Session established!</TITLE>
</HEAD>
<BODY BGCOLOR="FFFFFF">
<SCRIPT LANGUAGE="javascript">
	window.location= "frames.php";
</SCRIPT>
</BODY>
