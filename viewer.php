<?PHP
session_start();
if ($db_pwd=='') {
	$mediadb = mysql_pconnect("$db_host","$db_user");
} else {
	$mediadb = mysql_pconnect("$db_host","$db_user","$db_pwd");
}
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
