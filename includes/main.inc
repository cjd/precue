<?PHP

header("content-type: text/html; charset=UTF-8");
include("config.inc");
$db = mysqli_connect("$db_host","$db_user","$db_pwd","lyricDb");
mysqli_set_charset($db,'utf8'); 

?>

