<?PHP
session_start();
include("includes/main.inc");
include("includes/sessionimport.inc");
import_request_variables("GPC","");
include("includes/images.inc");
?>

<?PHP

switch ($page) {
	case "catselect": images($category); break;
	default: break;
}
		
?>
