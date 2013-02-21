<?PHP
    session_start();
    include("includes/main.inc");
    include ("includes/availsong.inc");
    include ("includes/advsearch.inc");
    include ("includes/addanewsong.inc");
    include ("includes/showasong.inc");
    include ("includes/editasong.inc");

    switch ($_REQUEST['page']) {
        case "showavail": availablesongs(); break;
        case "advsearch": advancedsongsearch(); break;
        case "showsong": showasong(); break;
        case "addsong": addanewsong();break;
        case "savesong": savesong(); break;
        case "editsong": editasong(); break;
        case "updatesong":
            $pagesarray = array();
            for ($pagenum = 1; $pagenum <= $nopages; $pagenum++) {
                $pagename="pagedata".$pagenum;
                $pagesarray[] = $$pagename;
            }
            updateasong();
            editasong();
            break;
        case "": break;
    }

?>

