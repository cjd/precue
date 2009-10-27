<?PHP

import_request_variables("GPC","");

$fp = fsockopen("localhost", 2346, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    fwrite($fp, $command."\n");
    echo "Sent command:".$command;
    fclose($fp);
}
?>
