<?PHP
//begin session and register general use variables
session_start();
session_register(fver);
session_register(lyricuever);
session_register(bible);
session_register(biblename);
session_register(db_host);
session_register(db_user);
session_register(db_pwd);

//###########
//USER CONFIG
//###########
$db_host='localhost';
$db_user='lyric';
$db_pwd='';

//include the media array
include("media.inc");

//include the audit exclusions array
//include("auditexc.inc");

//##########
//END CONFIG
//##########

//set the general use variables
$fver="1.3";
$lyricuever="2.0";
$bgimage = "images/bgtile.jpg";
$bible = "bibleDb";
$biblename = "King James Version (Default)";

//make lyricue persistent database connection
session_register(db);
if ($db_pwd=='') {
	$db = mysql_pconnect("$db_host","$db_user");
} else {
	$db = mysql_pconnect("$db_host","$db_user","$db_pwd");
}
mysql_select_db("lyricDb",$db);

//make lyricue persistent bible database connection
session_register($bibledb);
if ($db_pwd=='') {
	$bibledb = mysql_pconnect("$db_host","$db_user");
} else {
	$bibledb = mysql_pconnect("$db_host","$db_user","$db_pwd");
}
mysql_select_db("$bible",$bibledb);

//make media database connection
session_register($mediadb);
if ($db_pwd=='') {
	$mediadb = mysql_pconnect("$db_host","$db_user");
} else {
	$mediadb = mysql_pconnect("$db_host","$db_user","$db_pwd");
}
mysql_select_db("mediaDb",$mediadb);


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
