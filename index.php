<?PHP
session_start();
//begin session and register general use variables
include("includes/main.inc");

import_request_variables("GPC","");
session_register(themeset);

//set the general use variables
$bgimage = "images/bgtile.jpg";
$bible = "bibleDb";
$biblename = "King James Version (Default)";

//make lyricue persistent database connection
session_register($db);
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
	window.location= "lyricue.php";
</SCRIPT>
</BODY>
