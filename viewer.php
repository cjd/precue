<?PHP
session_start();
$mediadb = mysql_pconnect("localhost","lyric");
mysql_select_db("mediaDb",$mediadb);

import_request_variables("gP","");
if ($format=="png") {
	header("Content-type: image/png");
} elseif ($format=="jpg") {
	header("Content-type: image/jpeg");
} elseif ($format=="gif") {
	header("Content-type: image/gif");
} else {
	echo "Media format not supported by Precue viewer!";
}

$result = mysql_query("SELECT data FROM media WHERE id=$imageid",$mediadb);
$row = mysql_fetch_row($result);
echo $row[0];
?>