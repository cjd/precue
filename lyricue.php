<?PHP
session_start();
include("includes/main.inc");
include("includes/sessionimport.inc");
import_request_variables("GPC","");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Precue</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<link rel="StyleSheet" href="theme.css" type="text/css" title="Default">
<script language="javascript" type="text/javascript">
    if (window.innerWidth)
        if (window.innerWidth < 500)
            document.write('<link rel="StyleSheet" href="mobile.css" type="text/css" title="Default">');
</script>
</head>
<body>
<center>

<img class="header" src="images/precue.png" border="0" onclick="jumpTo('blank','welcome')" ALT="Precue logo"><br>

<script type="text/javascript" src="json2007.js"></script>
<script type="text/javascript" src="rsh.compressed.js"></script>

<script type="text/javascript">

window.dhtmlHistory.create();

function rshlisten (newLocation,historyData) {
    newLocation = unescape(newLocation);
    var loc = newLocation.parseJSON();
    var msg = "<b>A history change has occured:<\/b> | newLocation=" + newLocation + " | side=" + loc[0] + " | main ="+loc[1] + " | options="+loc[2];
    //log(msg);
    ajaxFunction(loc[0], loc[1], loc[2]);
    
}

window.onload = function() {
    dhtmlHistory.initialize();
    dhtmlHistory.addListener(rshlisten);
    jumpTo('blank','welcome');
}

function log(msg) {
    var logNode = document.getElementById("logWin");
    var content = "<p>" + msg + "<\/p>" + logNode.innerHTML;
    logNode.innerHTML = content;
}

function clearLog(msg) {
    var logNode = document.getElementById("logWin");
    logNode.innerHTML = "";
}


function jumpTo(side,main,options) {
    var currentLocation = [ side, main, options ];
    var currentLoc = currentLocation.toJSONString();
    currentLoc = escape(currentLoc);
    //log (currentLoc);
    dhtmlHistory.add(currentLoc);
    rshlisten(currentLoc);
}

function ajaxFunction(side,main,options) {
    var xmlhttpside;
    var xmlhttpmain;
    //alert(main);
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
    pagenode.innerHTML = pagenode.innerHTML + "<i>Page "+pageno+"<\/i><br>"+"<textarea rows=\"9\" cols=50 name=\"pagedata"+pageno+"\"><\/textarea><br>";
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

<table class="menu">
<tr>
<td class="menuitem" onclick="jumpTo('song','','')">Songs</td>
<td class="menuitem" onclick="jumpTo('bible','disp','mode=selectbook')">Verse</td>
<td class="menuitem" onclick="jumpTo('playlist','','')">Playlist</td>
<td class="menuitem" onclick="jumpTo('images','','')">Images</td>
<td class="menuitem" onclick="jumpTo('audit','','')">Audit</td>
<td class="menuitem" onclick="jumpTo('blank','remote','')">Remote</td>
</tr>
</table>

</center>

<table Width="100%">
<tbody>
<tr>
<td valign=top>
<div class="sidemenu" id="menu">
</div>
</td>
</tr><tr>
<td>
<center>
<div class="main" id="main">
</div>
</center>
</td>
</tr>
</tbody>
</table>
<div class="log" id="logWin"></div>
</body>
</html>
