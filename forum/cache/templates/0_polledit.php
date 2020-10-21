<?php
			/*
			templatepackid: 0
			templatename: polledit
			*/
			
			$this->templates['polledit']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | \$board[title] | {\$lang->items['LANG_POLL_EDIT']}</title>
\$headinclude

</head>

<body>
 <form action=\\\"polledit.php\\\" method=\\\"post\\\">
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"polldelete\\\" />
 <input type=\\\"hidden\\\" name=\\\"pollid\\\" value=\\\"\$pollid\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"3\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POLL_EDIT_DELETE']}</b></span></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" name=\\\"deletepoll\\\" value=\\\"1\\\" /><label for=\\\"checkbox1\\\"> <b>{\$lang->items['LANG_POLL_EDIT_DELETE']}?</b></label></span></td>
   <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_POLL_EDIT_DELETE_DESC']}</span></td>
   <td class=\\\"tableb\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_POLL_EDIT_DELETE']}\\\" class=\\\"input\\\" /></td>
  </tr>
 </table></form><br /><form action=\\\"polledit.php\\\" method=\\\"post\\\" name=\\\"pform\\\">
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POLL_EDIT']}</b></span></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POLL_TOPIC']}</b></span></td>
   <td class=\\\"tableb\\\"><input type=\\\"text\\\" name=\\\"question\\\" value=\\\"\$question\\\" class=\\\"input\\\" size=\\\"50\\\" maxlength=\\\"100\\\" /></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tablea\\\" align=\\\"center\\\"><a href=\\\"javascript:FormSubmit('ShiftToTop');\\\"><img src=\\\"{\$style[imagefolder]}/polledit_uptop.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_POLL_UPTOP']}\\\" title=\\\"{\$lang->items['LANG_POLL_UPTOP']}\\\" /></a><br /><br />
   <a href=\\\"javascript:FormSubmit('ShiftUp');\\\"><img src=\\\"{\$style[imagefolder]}/polledit_up.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_POLL_UP']}\\\" title=\\\"{\$lang->items['LANG_POLL_UP']}\\\" /></a><br /><br />
   <a href=\\\"javascript:FormSubmit('ShiftDown');\\\"><img src=\\\"{\$style[imagefolder]}/polledit_down.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_POLL_DOWN']}\\\" title=\\\"{\$lang->items['LANG_POLL_DOWN']}\\\" /></a><br /><br />
   <a href=\\\"javascript:FormSubmit('ShiftToBottom');\\\"><img src=\\\"{\$style[imagefolder]}/polledit_downbottom.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_POLL_DOWNBOTTOM']}\\\" title=\\\"{\$lang->items['LANG_POLL_DOWNBOTTOM']}\\\" /></a></td>
   <td class=\\\"tablea\\\"><select name=\\\"polloptionid\\\" size=\\\"20\\\" style=\\\"width:500px\\\" onchange='setindex()'>
      \$polloptions
   </select></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POLL_OPTIONS']}</b></span></td>
   <td class=\\\"tableb\\\"><input type=\\\"text\\\" name=\\\"option\\\" value=\\\"\\\" class=\\\"input\\\" maxlength=\\\"100\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_POLL_DELETE']}\\\" class=\\\"input\\\" onclick=\\\"FormSubmit('delentry')\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_POLL_ADD']}\\\" class=\\\"input\\\" onclick=\\\"AddEntry()\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_POLL_SAVE']}\\\" class=\\\"input\\\" onclick=\\\"SaveEntry()\\\" /></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POLL_CHOICECOUNT']}</b></span></td>
   <td class=\\\"tablea\\\"><input type=\\\"text\\\" name=\\\"choicecount\\\" value=\\\"\$choicecount\\\" class=\\\"input\\\" size=\\\"10\\\" maxlength=\\\"2\\\" /><span class=\\\"smallfont\\\"> {\$lang->items['LANG_POLL_CHOICECOUNT_DESC']}</span></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POLL_TIMEOUT']}</b></span></td>
   <td class=\\\"tableb\\\"><input type=\\\"text\\\" name=\\\"timeout\\\" value=\\\"\$timeout\\\" class=\\\"input\\\" size=\\\"10\\\" maxlength=\\\"7\\\" /><span class=\\\"smallfont\\\"> {\$lang->items['LANG_POLL_TIMEOUT_DESC']}</span></td>
  </tr>
 </table>
 <p align=\\\"center\\\">
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\\\" />
  <input type=\\\"hidden\\\" name=\\\"boardid\\\" value=\\\"\$boardid\\\" />
  <input type=\\\"hidden\\\" name=\\\"pollid\\\" value=\\\"\$pollid\\\" />
  <input type=\\\"hidden\\\" name=\\\"idhash\\\" value=\\\"\$idhash\\\" />
  <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  <input class=\\\"input\\\" type=\\\"button\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_POLL_EDIT_SAVE']}\\\" onclick=\\\"verifyPoll();\\\" />
  <input class=\\\"input\\\" type=\\\"button\\\" accesskey=\\\"C\\\" value=\\\"{\$lang->items['LANG_POLL_CLOSE_WINDOW']}\\\" onclick=\\\"self.close();\\\" />
 </p></form>
<script type=\\\"text/javascript\\\">
<!--
 var polloptionid = document.pform.polloptionid;
 var option = document.pform.option;
 var maxpolloptions = \$maxpolloptions;
 var pform = document.pform;
 
 function trim(string) {
  string = string.replace(/^\\\\s*/,\\\"\\\");
  string = string.replace(/\\\\s*\$/,\\\"\\\");
  return string;
 }
 
 function setindex() {
  index=polloptionid.selectedIndex;
  if(index!=-1) option.value = polloptionid.options[index].text;
 }
 
 function FormSubmit(actionval) {
  document.pform.action.value=actionval;
  document.pform.submit();
 }
 
 function AddEntry() {
  option.value = trim(option.value);  
  if(option.value!=\\\"\\\") {
   count=polloptionid.length;
   if(count>=maxpolloptions) alert('{\$lang->items['LANG_POLL_MAXOPTIONS']}');
   else FormSubmit('addentry');
  } 
 }
 
 function SaveEntry() {
  index=polloptionid.selectedIndex;
  if(index!=-1) {
   option.value = trim(option.value);
   if(option.value!=\\\"\\\") FormSubmit('saveentry');
  }
  else AddEntry();
 }
 
 function verifyPoll() {
  pform.question.value=trim(pform.question.value);
  if(pform.question.value==\\\"\\\" || pform.choicecount.value==\\\"\\\") alert('{\$lang->items['LANG_POLL_ERROR1']}');
  else if(polloptionid.length<2) alert('{\$lang->items['LANG_POLL_ERROR2']}');
  else if(polloptionid.length<parseInt(pform.choicecount.value)) alert('{\$lang->items['LANG_POLL_ERROR3']}');
  else FormSubmit('savepoll');
 }
 
//-->
</script>
</body>
</html>";
			?>