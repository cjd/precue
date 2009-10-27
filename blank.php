<?PHP
    session_start();
    include("includes/main.inc");
    include("includes/sessionimport.inc");
    import_request_variables("GPC","");
    include ("includes/about.inc");
    include ("includes/welcome.inc");

    switch ($page) {
        case "about": about(); break;
        case "welcome": welcome(); break;
        case "blank": break;
    }

?>

