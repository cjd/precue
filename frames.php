<?PHP
session_start();
?>
<html>
<head>
<title>Lyric Display System Frontend</title>
</head>
<frameset rows=200,* FRAMEBORDER=0 FRAMESPACING=0 BORDER=0>
	<FRAME SRC=header.php NAME=header SCROLLING=no>
	<frameset cols=200,* FRAMEBORDER=0 FRAMESPACING=0 BORDER=0>
		<FRAME SRC=menu.php NAME=midline SCROLLING=no>
		<FRAME SRC=lds.php NAME=main SCROLLING=auto>
	</frameset>
</frameset>
</html>
