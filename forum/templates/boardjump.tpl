<script type="text/javascript">
<!--
function submitBoardJump(theForm) {
 	if(theForm.boardid.options[theForm.boardid.selectedIndex].value != -1) theForm.submit();
}
//-->
</script>
<form action="board.php" method="get" name="jumpform">
 <span class="smallfont"><b>{$lang->items['LANG_GLOBAL_BOARDJUMP']} </b></span><select name="boardid" onchange="submitBoardJump(this.form)">
  <option value="-1" selected="selected">{$lang->items['LANG_GLOBAL_PLEASE_SELECT']}</option>
  <option value="-1">--------------------</option>
   $boardoptions
  </select> <input src="{$style['imagefolder']}/go.gif" type="image" />
  <input type="hidden" name="sid" value="$session[hash]" />
</form>