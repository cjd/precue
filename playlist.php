<?PHP
    include("includes/main.inc");
    include("includes/playlist.inc");
    include("includes/addanewsong.inc");
    include("includes/showasong.inc");
    include("includes/availsong.inc");

    switch ($_REQUEST['page']) {
        case "showpl": showplaylist(); break;
        case "pladdplaylist": addplaylist(); break;
        case "pladdsong": addsongplaylist();break;
        case "plclear": clearplaylist(); break;
        case "showsong": showasong(); break;
        case "createplaylist": createplaylist(); break;
        case "showavail": availablesongs(); break;
        case "plcommit": addtoplaylist(); break;
        case "": break;
    }

?>

