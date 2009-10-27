<?PHP
session_start();
include("includes/main.inc");
include("includes/sessionimport.inc");
import_request_variables("GPC","");
?>
<HTML>
<HEAD>
    <TITLE>Precue - Lyricue Frontend <?PHP echo "$fver for Lyricue $lyricuever"; ?></TITLE>
<link rel="StyleSheet" href="theme.css" type="text/css" title="Default">
<SCRIPT LANGUAGE="javascript">
    if (window.innerWidth)
        if (window.innerWidth < 500)
            document.write('<link rel="StyleSheet" href="mobile.css" type="text/css" title="Default">');
</SCRIPT>
</HEAD>
<BODY onload="jumpTo('blank','welcome')">
<CENTER>

<IMG CLASS="header" SRC="images/precue.png" BORDER="0" onclick="jumpTo('blank','welcome')"><BR>

<script type="text/javascript" src="json2007.js"></script>
<script type="text/javascript" src="unFocus-History-p.js"></script>

<script type="text/javascript">
function historyListener (historyHash) {
    stateVar = historyHash;
    var loc = historyHash.parseJSON();
    var msg = "<b>A history change has occured:</b> | newLocation=" + historyHash + " | side=" + loc[0] + " | main ="+loc[1] + " | options="+loc[2];
    //log(msg);
    ajaxFunction(loc[0], loc[1], loc[2]);
}

function log(msg) {
        var logNode = document.getElementById("logWin");
        var content = "<p>" + msg + "</p>" + logNode.innerHTML;
        logNode.innerHTML = content;
}

function clearLog(msg) {
        var logNode = document.getElementById("logWin");
        logNode.innerHTML = "";
}


window.onload = function() {
        unFocus.History.addEventListener('historyChange', historyListener);
        jumpTo('blank','welcome');
};

function jumpTo(side,main,options) {
    var currentLocation = [ side, main, options ];
    var currentLoc = currentLocation.toJSONString();
    //log("jumpTo:"+currentLoc);
    unFocus.History.addHistory(currentLoc);
}

function ajaxFunction(side,main,options) {
    var xmlhttpside;
    var xmlhttpmain;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttpmain=new XMLHttpRequest();
        xmlhttpside=new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttpmain=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttpside=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttpmain.onreadystatechange=function() {
        if(xmlhttpmain.readyState==4) {
            document.getElementById('main').innerHTML=xmlhttpmain.responseText;
        }
    }
    xmlhttpside.onreadystatechange=function() {
        if(xmlhttpside.readyState==4) {
            document.getElementById('menu').innerHTML=xmlhttpside.responseText;
        }
    }
    xmlhttpmain.open("GET",side+".php?page="+main+"&"+options,true);
    xmlhttpmain.send(null);
    xmlhttpside.open("GET","sidemenu.php?mode="+side,true);
    xmlhttpside.send(null);
}

function remoteControl(command) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if(xmlhttp.readyState==4) {
            document.getElementById('response').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","remote.php?command="+command,true);
    xmlhttp.send(null);
}

// Used by addanewsong.inc
var pageno = 0;

// Used by addanewsong.inc
var pageno = 0;
function addpage() {
    var pagenode = document.getElementById("pages");
    if (typeof document.songdata.pagedata2 == 'undefined') {
        pageno=1;
    }
    pageno++;
    pagenode.innerHTML = pagenode.innerHTML + "<I>Page "+pageno+"</I><BR>"+"<TEXTAREA ROWS=\"9\" COLS=50 NAME=\"pagedata"+pageno+"\"></TEXTAREA><BR>";
}

// Used by addanewsong.inc
function savesong() {
    var options = "songname="+escape(document.songdata.songname.value);
    options = options + "&artist="+escape(document.songdata.artist.value);
    options = options + "&songbook="+escape(document.songdata.songbook.value);
    options = options + "&keywords="+escape(document.songdata.keywords.value);
    options = options + "&songno="+escape(document.songdata.songno.value);
    var pages = 1;
    while (typeof eval("document.songdata.pagedata"+pages) != 'undefined') {
        options = options + "&pagedata"+pages+"="+escape(eval("document.songdata.pagedata"+pages).value);
        pages++;
    }
    pages--;
    options = options + "&nopages=" + pages;
    jumpTo("song","savesong",options);
}

// Used by editasong.inc
function updatesong () {
    var options = "songid="+document.songdata.songid.value;
    options = options + "&songname="+escape(document.songdata.songname.value);
    options = options + "&artist="+escape(document.songdata.artist.value);
    options = options + "&songbook="+escape(document.songdata.songbook.value);
    options = options + "&keywords="+escape(document.songdata.keywords.value);
    options = options + "&songno="+escape(document.songdata.songno.value);
    var pages = 1;
    while (typeof eval("document.songdata.pagedata"+pages) != 'undefined') {
        options = options + "&pagedata"+pages+"="+escape(eval("document.songdata.pagedata"+pages).value);
        pages++;
    }
    pages--;
    options = options + "&nopages=" + pages;
    jumpTo("song","updatesong",options);
}

</script>

<FONT SIZE=3" COLOR="red">
<TABLE class="menu">
<TR>
<TD class="menuitem" onclick="jumpTo('song','','')">Songs</TD>
<TD class="menuitem" onclick="jumpTo('bible','disp','mode=selectbook')">Verse</TD>
<TD class="menuitem" onclick="jumpTo('playlist','','')">Playlist</TD>
<TD class="menuitem" onclick="jumpTo('images','','')">Images</TD>
<TD class="menuitem" onclick="jumpTo('audit','','')">Audit</TD>
<TD class="menuitem" onclick="jumpTo('blank','remote','')">Remote</TD>
</TR>
</TABLE>
</FONT>

</CENTER>

<TABLE width=100%>
<TBODY>
<TR>
<TD valign=top>
<DIV CLASS="sidemenu" ID="menu">
</DIV>
</TD>
</TR><TR>
<TD>
<CENTER>
<DIV CLASS="main" ID="main">
</DIV>
</CENTER>
</TD>
</TR>
</TBODY>
</TABLE>
<div class="log" id="logWin"></div>
</BODY>
</HTML>
