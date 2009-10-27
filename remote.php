<?PHP

import_request_variables("GPC","");
include("includes/config.inc");

$fp = fsockopen($frontend, 2346, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    fwrite($fp, $command."\n");
    echo "Sent command:".$command;
    fclose($fp);
}
?>
