<?PHP

header("content-type: text/html; charset=UTF-8");
include("config.inc");
if ($db_pwd=='') {
    $db = mysql_pconnect("$db_host","$db_user");
} else {
    $db = mysql_pconnect("$db_host","$db_user","$db_pwd");
}
mysql_select_db("lyricDb",$db);

?>

