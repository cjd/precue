<?PHP
	function remote() {
?>
<table class=menu width=100%>
<tr height=64>
<td width=50% class="menuitem" onclick="remoteControl('display:prev_page:')">Prev Page</td>
<td width=50% class="menuitem" onclick="remoteControl('display:next_page:')">Next Page</td>
</tr><tr height=64>
<td class="menuitem" onclick="remoteControl('display:prev_song:')">Prev Song</td>
<td class="menuitem" onclick="remoteControl('display:next_song:')">Next Song</td>
</tr><tr height=64>
<td class="menuitem" onclick="remoteControl('blank::')">Blank</td>
<td class="menuitem" onclick="remoteControl('display:current:')">Refresh screen</td>
</tr>
</table>
<DIV ID="response"></DIV>
<?PHP
    }
?>
