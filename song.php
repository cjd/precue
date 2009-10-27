<?PHP
    session_start();
    include("includes/main.inc");
    include("includes/sessionimport.inc");
    import_request_variables("GPC","");
    include ("includes/availsong.inc");
    include ("includes/advsearch.inc");
    include ("includes/addanewsong.inc");
    include ("includes/showasong.inc");
    include ("includes/editasong.inc");

    switch ($page) {
        case "showavail": availablesongs($sortingmech,$searchrad,$searchtext,$width); break;
        case "advsearch": advancedsongsearch($advanced,$searchtext); break;
        case "showsong": showasong($song); break;
        case "addsong": addanewsong();break;
        case "savesong": 
            $pagesarray = array();
            for ($pagenum = 1; $pagenum <= $nopages; $pagenum++) {
                $pagename="pagedata".$pagenum;
                $pagesarray[] = $$pagename;
            }
            savesong($nopages,$songname,$artist,$songno,$songbook,$keywords,$pagesarray);
            break;
        case "editsong": editasong($song); break;
        case "updatesong":
            $pagesarray = array();
            for ($pagenum = 1; $pagenum <= $nopages; $pagenum++) {
                $pagename="pagedata".$pagenum;
                $pagesarray[] = $$pagename;
            }
            updateasong($songid, $nopages,$songname,$artist,$songno,$songbook,$keywords,$pagesarray);
            editasong($songid);
            break;
        case "": break;
    }

?>

