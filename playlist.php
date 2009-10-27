<?PHP
    session_start();
    include("includes/main.inc");
    include("includes/sessionimport.inc");
    import_request_variables("GPC","");
    include("includes/playlist.inc");
    include("includes/addanewsong.inc");
    include("includes/showasong.inc");
    include("includes/availsong.inc");

    switch ($page) {
        case "showpl": showplaylist($playlistId); break;
        case "pladdplaylist": addplaylist(); break;
        case "pladdsong": addsongplaylist($song,$playlistId);break;
        case "plclear": clearplaylist($playlistId); break;
        case "showsong": showasong($song,"false"); break;
        case "createplaylist": createplaylist($playlisttitle); break;
        case "showavail": availablesongs("","","",$width); break;
        case "plcommit": addtoplaylist($playlistId,$song); break;
        case "": break;
    }

?>

