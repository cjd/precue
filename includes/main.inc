<?PHP
$fver="1.5";
$lyricuever="2.0";

include("config.inc");
if ($db_pwd=='') {
    $db = mysql_pconnect("$db_host","$db_user");
} else {
    $db = mysql_pconnect("$db_host","$db_user","$db_pwd");
}
mysql_select_db("lyricDb",$db);


?>

