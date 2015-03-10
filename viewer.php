<?PHP
session_start();
import_request_variables("GPC","");
include("includes/main.inc");
include("includes/sessionimport.inc");

$mediadb = mysqli_connect("$db_host","$db_user","$db_pwd","mediaDb");
mysqli_set_charset($mediadb,'utf8'); 

if ($format=="png") {
	header("Content-type: image/png");
} elseif ($format=="jpg") {
	header("Content-type: image/jpeg");
} elseif ($format=="gif") {
	header("Content-type: image/gif");
} elseif ($format=="bg") {
	echo "This is a solid colour and not an image as such.<BR>An approximation of the colour is:<BR><BR>";
} else {
	echo "Media format not supported by Precue viewer!";
}

if ($format == "bg") {
	$result = mysqli_query($mediadb,"SELECT description FROM media WHERE id=$imageid");
	$row = mysqli_fetch_row($result);
	echo "<FONT SIZE=5><B>";
	if ($row[0] == "white") {
		echo "<FONT COLOR=\"000000\">Background colour (White)</FONT>";
	} else {
		echo "<FONT COLOR=\"$row[0]\">$row[0]</FONT>";
	}
} else {
$result = mysqli_query($mediadb,"SELECT data FROM media WHERE id=$imageid");
$row = mysqli_fetch_row($result);
echo $row[0];
}
?>
