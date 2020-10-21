<?php
			/*
			templatepackid: 0
			templatename: polladd
			*/
			
			$this->templates['polladd']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | \$thread[topic] | {\$lang->items['LANG_MODCP_ADD_POLL']}</title>
\$headinclude
</head>

<body>
 \$header
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a>\$navbar &raquo; </b>\".((\$thread['prefix']!=\"\") ? (\"<span class=\\\"prefix\\\">\$thread[prefix]</span> \") : (\"\")).\"<b> <a href=\\\"thread.php?threadid=\$threadid{\$SID_ARG_2ND}\\\">\$thread[topic]</a> &raquo; {\$lang->items['LANG_MODCP_ADD_POLL']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
 <form action=\\\"modcp.php\\\" method=\\\"post\\\" name=\\\"pform\\\">
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MODCP_ADD_POLL']}</b></span></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POLL_TOPIC']}</b></span></td>
   <td class=\\\"tableb\\\"><input type=\\\"text\\\" name=\\\"question\\\" value=\\\"\\\" class=\\\"input\\\" size=\\\"50\\\" maxlength=\\\"100\\\" /></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tablea\\\" align=\\\"center\\\"><a href=\\\"javascript:ShiftToTop();\\\"><img src=\\\"{\$style['imagefolder']}/polledit_uptop.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_POLL_UPTOP']}\\\" title=\\\"{\$lang->items['LANG_POLL_UPTOP']}\\\" /></a><br /><br />
   <a href=\\\"javascript:ShiftUp();\\\"><img src=\\\"{\$style['imagefolder']}/polledit_up.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_POLL_UP']}\\\" title=\\\"{\$lang->items['LANG_POLL_UP']}\\\" /></a><br /><br />
   <a href=\\\"javascript:ShiftDown();\\\"><img src=\\\"{\$style['imagefolder']}/polledit_down.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_POLL_DOWN']}\\\" title=\\\"{\$lang->items['LANG_POLL_DOWN']}\\\" /></a><br /><br />
   <a href=\\\"javascript:ShiftToBottom();\\\"><img src=\\\"{\$style['imagefolder']}/polledit_downbottom.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_POLL_DOWNBOTTOM']}\\\" title=\\\"{\$lang->items['LANG_POLL_DOWNBOTTOM']}\\\" /></a></td>
   <td class=\\\"tablea\\\"><select name=\\\"optionlist\\\" size=\\\"20\\\" style=\\\"width:500px\\\" onchange='setindex()'>
    <option selected=\\\"selected\\\"></option>
   </select></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POLL_OPTIONS']}</b></span></td>
   <td class=\\\"tableb\\\"><input type=\\\"text\\\" name=\\\"option\\\" value=\\\"\\\" class=\\\"input\\\" maxlength=\\\"100\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_POLL_DELETE']}\\\" class=\\\"input\\\" onclick=\\\"DeleteEntry()\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_POLL_ADD']}\\\" class=\\\"input\\\" onclick=\\\"AddEntry()\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_POLL_SAVE']}\\\" class=\\\"input\\\" onclick=\\\"SaveEntry()\\\" /></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POLL_CHOICECOUNT']}</b></span></td>
   <td class=\\\"tablea\\\"><input type=\\\"text\\\" name=\\\"choicecount\\\" value=\\\"1\\\" class=\\\"input\\\" size=\\\"10\\\" maxlength=\\\"2\\\" /><span class=\\\"smallfont\\\"> {\$lang->items['LANG_POLL_CHOICECOUNT_DESC']}</span></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POLL_TIMEOUT']}</b></span></td>
   <td class=\\\"tableb\\\"><input type=\\\"text\\\" name=\\\"timeout\\\" value=\\\"0\\\" class=\\\"input\\\" size=\\\"10\\\" maxlength=\\\"7\\\" /><span class=\\\"smallfont\\\"> {\$lang->items['LANG_POLL_TIMEOUT_DESC']}</span></td>
  </tr>
 </table>
 <p align=\\\"center\\\">
  <input type=\\\"hidden\\\" name=\\\"polloptions\\\" value=\\\"\\\" />
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"polladd\\\" />
  <input type=\\\"hidden\\\" name=\\\"threadid\\\" value=\\\"\$threadid\\\" />
  <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  <input class=\\\"input\\\" type=\\\"button\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_MODCP_ADD_POLL']}\\\" onclick=\\\"FormSubmit();\\\" />
 </p></form>


\$footer

<script type=\\\"text/javascript\\\">
<!--
 var optionlist = document.pform.optionlist;
 var option = document.pform.option;
 var maxpolloptions = \$maxpolloptions;
 var pform = document.pform;
 
 function trim(string) {
  string = string.replace(/^\\\\s*/,\\\"\\\");
  string = string.replace(/\\\\s*\$/,\\\"\\\");
  return string;
 }
  
 function AddEntry() {
  optionvalue = trim(option.value);  
  if(optionvalue!=\\\"\\\") {
   count=optionlist.length;
   if(count>=maxpolloptions) alert('{\$lang->items['LANG_POLL_MAXOPTIONS']}');
   else {
    newoption = new Option(optionvalue);
    optionlist.options[count] = newoption;
    option.value=\\\"\\\";
    optionlist.selectedIndex=-1;
    option.focus();
   }
  } 
 }
 
 function setindex() {
  index=optionlist.selectedIndex;
  if(index!=-1) option.value = optionlist.options[index].text;
 }
 
 function DeleteEntry() {
  index=optionlist.selectedIndex;
  if(index!=-1) {
   optionlist.options[index] = null;
   option.value=\\\"\\\";
   option.focus();
  }
 }
 
 function SaveEntry() {
  index=optionlist.selectedIndex;
  optionvalue = trim(option.value);
  if(index!=-1) {
   if(optionvalue!=\\\"\\\") {
    optionlist.options[index].text = optionvalue;
    option.value=\\\"\\\";
    optionlist.selectedIndex=-1;
    option.focus();
   }
  }
  else AddEntry();
 }
 
 function ShiftUp() {
  index=optionlist.selectedIndex;
  if(index!=-1 && index!=0) {
   temp = optionlist.options[index-1].text;
   optionlist.options[index-1].text = optionlist.options[index].text;
   optionlist.options[index].text = temp;
   optionlist.selectedIndex = index-1;
  }
 }
 
 function ShiftDown() {
  index=optionlist.selectedIndex;
  count=optionlist.length;
  if(index!=-1 && index!=count-1) {
   temp = optionlist.options[index+1].text;
   optionlist.options[index+1].text = optionlist.options[index].text;
   optionlist.options[index].text = temp;
   optionlist.selectedIndex = index+1;
  }
 }
 
 function ShiftToTop() {
  doindex=optionlist.selectedIndex;
  if(doindex!=-1 && doindex!=0) {
   for(i=0;i<doindex;i++) {
    ShiftUp();
   }
  }
 }
 
 function ShiftToBottom() {
  doindex=optionlist.selectedIndex;
  docount=optionlist.length;
  if(doindex!=-1 && doindex!=docount-1) {
   for(i=0;i<(docount-1-doindex);i++) ShiftDown();
  }
 }
 
 function FormSubmit() {
   pform.question.value=trim(pform.question.value);
   if(pform.question.value==\\\"\\\" || pform.choicecount.value==\\\"\\\") alert('{\$lang->items['LANG_POLL_ERROR1']}');
   else if(optionlist.length<2) alert('{\$lang->items['LANG_POLL_ERROR2']}');
   else if(optionlist.length<parseInt(pform.choicecount.value)) alert('{\$lang->items['LANG_POLL_ERROR3']}');
   else {
    for(i=0;i<optionlist.length;i++) {
     text = optionlist.options[i].text;
     pform.polloptions.value+=text+'\\\\n';
    }
    pform.submit();
  }
 }
 
 DeleteEntry();
 
//-->
</script>
</body>
</html>";
			?>