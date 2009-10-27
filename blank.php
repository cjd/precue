<?PHP
    session_start();
    include("includes/main.inc");
    include("includes/sessionimport.inc");
    import_request_variables("GPC","");
    include ("includes/welcome.inc");
    include ("includes/remote.inc");

    switch ($page) {
        case "about": about(); break;
        case "welcome": welcome(); break;
        case "remote": remote(); break;
        case "blank": break;
    }

?>

