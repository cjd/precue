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
?>

<HEAD>
	<TITLE>Lyric Display System Frontend <?PHP echo "$fver for LDS $ldsver"; ?></TITLE>
</HEAD>

<?PHP 
if ($action=="pflist") {
	echo "<BODY BGCOLOR=FFFFFF LINK=000000 VLINK=000000 TEXT=000000>";
} else {
	echo "<BODY BGCOLOR=$bgcolor BACKGROUND=$bgimage LINK=$linkcolor VLINK=$vlinkcolor TEXT=$textcolor>";
}


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

//include the available songs function
include("includes/availsong.inc");

//include the image function
include("includes/images.inc");

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
	case "plclear": playlist("clear",$song,$playlistId); break;
	case "plcommit": playlist("Add",$song,$playlistId); break;
	case "Add to playlist": playlist("Add",$titlefield); break;
	case "showavail": availablesongs($sortingmech,$searchrad,$searchtext); break;
	case "Search": availablesongs($sortingmech,$searchrad,$searchtext); break;
	case "addsong":  addanewsong("addnew",$nopages,$songname,$artist,$songno,$songbook,$keywords,$pagesarray); break;
	case "Save the Song": addanewsong("",$nopages,$songname,$artist,$songno,$songbook,$keywords,$pagesarray); break;
	case "images": images();
	case "blank": break;
	default: welcome();
}
}else{
welcome();
}


// ----------------------------------
// about function
// ----------------------------------


	function about() {

		?>
		<B>Lyricue:</B><BR>
		is a GTK Perl program that interacts with MySQL databases to provide a fast and powerful lyrics display system. LDS responds quickly and, best of all, is free. LDS is licensed under the GNU GPL and, as a result, undergoes considerable change from week to week and month to month so check the website for the newest version.<BR><BR>

		Lyricue was written for Gosford City Baptist Church by Chris Debenham.<BR>
		Email: <A HREF=mailto:chris@adebenham.com>chris@adebenham.com</A>. 
		WWW: <A HREF=http://www.adebenham.com/lyricue>Lyricue website</A>

		<BR><BR>
		<B>Precue:</B><BR>
		Lyricue enables remote access to the lyrics and bible databases which Lyricue uses. It facilitates the modification of any Lyricue playlist, the viewing of available songs and the generation of song usage profiles. For security reasons, no provision for deleting songs is made in this version. Precue is implemented in as a group of PHP4 webpages suitable for use with any PHP enabled server.</B><BR><BR>

		Lyricue was written for Gosford City Baptist Church by Clint Turner.<BR>
		Email: <A HREF=mailto:ldsf@clintturner.com>ldsf@clintturner.com</A>. 
		

		<?PHP
	}


// ----------------------------------
// welcome function
// ----------------------------------


	function welcome() {
		global $fver, $ldsver;
		?>
			<FONT SIZE="6"><B>W</B></FONT><FONT SIZE="4"><U>elcome to LDSF!</FONT></U><BR><BR><FONT SIZE="3">

			Precue version <?PHP echo $fver; ?> for Lyricue version <?PHP echo $ldsver; ?> gives
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
		<?PHP
	}
		
?>
