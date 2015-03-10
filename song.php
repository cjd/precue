<?PHP
    session_start();
    include ("includes/main.inc");
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
        case "editsong": editasong($_REQUEST['song']); break;
        case "updatesong":
            $pagesarray = array();
            for ($pagenum = 1; $pagenum <= $_REQUEST['nopages']; $pagenum++) {
                $pagename="pagedata".$pagenum;
                $pagesarray[] = $_REQUEST[$pagename];
            }
            updateasong($_REQUEST['songid'], $_REQUEST['nopages'], $_REQUEST['songname'], $_REQUEST['artist'], $_REQUEST['songno'], $_REQUEST['songbook'], $_REQUEST['keywords'], $pagesarray);
            editasong($_REQUEST['songid']);
            break;
        case "": break;
    }

?>

