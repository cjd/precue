<?PHP
    session_start();
    include("includes/main.inc");
    include ("includes/welcome.inc");
    include ("includes/remote.inc");

    switch ($_GET['page']) {
        case "about": about(); break;
        case "welcome": welcome(); break;
        case "remote": remote(); break;
        case "blank": break;
    }

?>

