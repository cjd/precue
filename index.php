<?PHP
//begin session and register general use variables
include("includes/main.inc");

//set the general use variables
$bgimage = "images/bgtile.jpg";
$bible = "bibleDb";
$bible_type = "db";
$biblename = "King James Version (Default)";

//make lyricue persistent database connection
if ($db_pwd=='') {
	$_SESSION['db'] = mysql_pconnect("$db_host","$db_user");
} else {
	$_SESSION['db'] = mysql_pconnect("$db_host","$db_user","$db_pwd");
}
mysql_select_db("lyricDb",$db);
mysql_set_charset('utf8',$db); 

//make lyricue persistent bible database connection
if ($db_pwd=='') {
    $_SESSION['bibledb'] = mysql_pconnect("$db_host","$db_user");
} else {
	$_SESSION['bibledb']= mysql_pconnect("$db_host","$db_user","$db_pwd");
}
mysql_select_db("$bible",$bibledb);

//make media database connection
if ($db_pwd=='') {
	$_SESSION['mediadb'] = mysql_pconnect("$db_host","$db_user");
} else {
	$_SESSION['mediadb'] = mysql_pconnect("$db_host","$db_user","$db_pwd");
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
