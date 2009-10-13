<?PHP
session_start();
include("includes/sessionimport.inc");
import_request_variables("GPC","");

if ($db_pwd=='') {
	$db = mysql_pconnect("$db_host","$db_user");
} else {
	$db = mysql_pconnect("$db_host","$db_user","$db_pwd");
}
mysql_select_db("lyricDb",$db);

import_request_variables("gP","");

$pagesarray = array($pagedata1,$pagedata2,$pagedata3,$pagedata4,$pagedata5,$pagedata6,$pagedata7,$pagedata8, $pagedata9,$pagedata10,$pagedata11, $pagedata12,$pagedata13,$pagedata14,$pagedata15, $pagedata16,$pagedata17,$pagedata18, $pagedata19,$pagedata20);

// Show the header
include("includes/header.inc");

//include the pflist function
include("includes/pfl.inc");

//include the showasong function
include("includes/showasong.inc");

//include the playlist function
include("includes/playlist.inc");

//include the advanced song search function
include("includes/advsearch.inc");

//include the song adding function
include("includes/addanewsong.inc");

//include the song editing function
include("includes/editasong.inc");

//include the available songs function
include("includes/availsong.inc");

//include the image function
include("includes/images.inc");

?>

<TABLE width=100%>
<TBODY>
<TR>
<TD valign=top>

<?PHP
include("includes/menu.inc");

if ($themeset=="mobile") {
    echo "</TD></TR>\n<TR><TD>\n";
} else {
    echo "</TD><TD>\n";
}
?>

<DIV CLASS="main">

<?PHP

if ($action) {
switch ($action) {
	case "pflist": showprintfriend(); break;
	case "advsearch": advancedsongsearch($advanced,$searchtext); break;
	case "Execute Search": advancedsongsearch("Search",$searchtext); break;
	case "showsong": showasong($song, "false"); break;
	case "playsong": showasong($song, "true"); break;
	case "about": about(); break;
	case "showpl": playlist("show",$song,$playlistId); break;
	case "pladdsong": playlist("addsong",$son,$playlistId); break;
	case "pladdplaylist": addplaylist(); break;
	case "plcreateplaylist": createplaylist(); break;
	case "plclear": playlist("clear",$song,$playlistId); break;
	case "plcommit": playlist("Add",$song,$playlistId); break;
	case "Add to playlist": playlist("Add",$titlefield); break;
	case "showavail": availablesongs($sortingmech,$searchrad,$searchtext); break;
	case "Search": availablesongs($sortingmech,$searchrad,$searchtext); break;
	case "addsong":  addanewsong("addnew",$nopages,$songname,$artist,$songno,$songbook,$keywords,$pagesarray); break;
	case "Save the Song": addanewsong("",$nopages,$songname,$artist,$songno,$songbook,$keywords,$pagesarray); break;
	case "editsong": editasong("edit",$nopages,$songname,$artist,$songno,$songbook,$keywords,$pagesarray); break;
	case "Save the Edited Song": editasong("",$nopages,$songname,$artist,$songno,$songbook,$keywords,$pagesarray); break;
	case "images": images();
	case "about": about();
	case "blank": break;
	default: welcome();
}
}else{
welcome();
}
?>
</DIV>
</TD>
</TR>
</TBODY>
</TABLE>

<?PHP

// ----------------------------------
// welcome function
// ----------------------------------


	function welcome() {
		global $fver, $lyricuever;
		?>
			<FONT SIZE="6"><B>W</B></FONT><FONT SIZE="4"><U>elcome to Precue!</FONT></U><BR><BR><FONT SIZE="3">

			Precue version <?PHP echo $fver; ?> for <a href="http://www.lyricue.org">Lyricue</a> version <?PHP echo $lyricuever; ?> gives
			you remote access to all of the Lyricue databases.<BR><BR>

			The remote lyric management functions provided by Precue give you the ability to perform the following tasks:
			<UL>
				<LI>Retrieve lyrics for songs</LI>
				<LI>Retrieve verse contents for a user specified bible verse range</LI>
				<LI>View and edit any Lyricue playlist</LI>
				<LI>Add new songs to the database</LI>
				<LI>Search through the lyrics of all available songs.</LI>
				<LI>View and analyse song usage statistics</LI>
				<LI>View all images and backgrounds in the media database</LI>
			</UL>
            For more infomation see the <a href="http://www.lyricue.org/precue">Precue website</a>
		<?PHP
	}
		
?>
