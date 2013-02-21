<?PHP

include("includes/config.inc");

$fp = fsockopen($frontend, 2346, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    fwrite($fp, $_REQUEST['command']."\n");
    echo "Sent command:".$_REQUEST['command'];
    fclose($fp);
}
?>
