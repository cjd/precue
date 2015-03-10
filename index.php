<?PHP
//begin session and register general use variables
include("includes/main.inc");

//set the general use variables
$bgimage = "images/bgtile.jpg";
$bible = "bibleDb";
$bible_type = "db";
$biblename = "King James Version (Default)";

//make lyricue persistent database connection TODO-make persist
$_SESSION['db'] = mysqli_connect("$db_host","$db_user","$db_pwd","lyricDb");
mysqli_set_charset($_SESSION['db'],'utf8'); 

//make lyricue persistent bible database connection TODO-make persist
$_SESSION['bibledb']= mysqli_connect("$db_host","$db_user","$db_pwd",$bible);
mysqli_set_charset($_SESSION['bibledb'],'utf8'); 

//make media database connection
$_SESSION['mediadb'] = mysqli_connect("$db_host","$db_user","$db_pwd","mediaDb");

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
