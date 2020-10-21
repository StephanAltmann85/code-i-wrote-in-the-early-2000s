<?php
/*
acp template
templatename: memberslist
*/

$this->templates['acp_memberslist']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>

<form method=\\\"post\\\" action=\\\"memberslist.php\\\" name=\\\"mform\\\" onsubmit=\\\"FormSubmit();\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"hidden_show\\\" />

 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_MEMBERSLIST']}</td>
  </tr>
  <tr>
   <td colspan=\\\"2\\\" class=\\\"firstrow\\\">
    <table width=\\\"100%\\\" cellpadding=\\\"4\\\">
     <tr align=\\\"center\\\">
      <td><a href=\\\"javascript:ShiftToTop()\\\"><img src=\\\"../images/polledit_uptop.gif\\\" border=\\\"0\\\" alt=\\\"\\\" /></a></td>
      <td rowspan=\\\"4\\\" align=\\\"left\\\"><b>{\$lang->items['LANG_ACP_MEMBERSLIST_FIELDS_SHOW']}</b><br />
       <select name=\\\"fields_show\\\" size=\\\"15\\\" style=\\\"width:200px\\\">
        \$options_show
       </select>
      </td>
      <td rowspan=\\\"2\\\" align=\\\"center\\\" width=\\\"100%\\\"><a href=\\\"javascript:ShiftLeft()\\\"><img src=\\\"../images/arrow_left.gif\\\" border=\\\"0\\\" alt=\\\"\\\" /></a></td>
      <td rowspan=\\\"4\\\" align=\\\"left\\\"><b>{\$lang->items['LANG_ACP_MEMBERSLIST_FIELDS_ALL']}</b><br />
       <select name=\\\"fields_all\\\" size=\\\"15\\\" style=\\\"width:200px\\\">
        \$options_all
       </select>
      
      
      </td>
     </tr>
     <tr align=\\\"center\\\">
      <td><a href=\\\"javascript:ShiftUp()\\\"><img src=\\\"../images/polledit_up.gif\\\" border=\\\"0\\\" alt=\\\"\\\" /></a></td>
     </tr>
     <tr align=\\\"center\\\">
      <td><a href=\\\"javascript:ShiftDown()\\\"><img src=\\\"../images/polledit_down.gif\\\" border=\\\"0\\\" alt=\\\"\\\" /></a></td>
      <td rowspan=\\\"2\\\" align=\\\"center\\\" width=\\\"100%\\\"><a href=\\\"javascript:ShiftRight()\\\"><img src=\\\"../images/arrow_right.gif\\\" border=\\\"0\\\" alt=\\\"\\\" /></a></td>
     </tr>
     <tr align=\\\"center\\\">
      <td><a href=\\\"javascript:ShiftToBottom()\\\"><img src=\\\"../images/polledit_downbottom.gif\\\" border=\\\"0\\\" alt=\\\"\\\" /></a></td>
     </tr>
    </table>
   </td>
  </tr>
  
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_MEMBERSLIST_SORTFIELD']}</td>
   <td><select name=\\\"sortfield\\\">
    \$sortfield_options
   </select></td>
  </tr>
  
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_MEMBERSLIST_SORTORDER']}</td>
   <td><select name=\\\"sortorder\\\">
    <option value=\\\"ASC\\\"\$s_sortorder[ASC]>{\$lang->items['LANG_ACP_MEMBERSLIST_SORTORDER_ASC']}</option>
    <option value=\\\"DESC\\\"\$s_sortorder[DESC]>{\$lang->items['LANG_ACP_MEMBERSLIST_SORTORDER_DESC']}</option>
   </select></td>
  </tr>
  
  <tr class=\\\"secondrow\\\" align=\\\"center\\\">
   <td colspan=\\\"2\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /></td>
  </tr>
  
 </table>
</form>

<script type=\\\"text/javascript\\\">
<!--
 var fields_show = document.mform.fields_show;
 var fields_all = document.mform.fields_all;
 
 function ShiftLeft() {
  if(fields_all.selectedIndex!=-1) {
   count=fields_show.length;
   
   newoption = new Option(fields_all.options[fields_all.selectedIndex].text,fields_all.options[fields_all.selectedIndex].value);
   fields_show.options[count] = newoption;
   
   fields_all.options[fields_all.selectedIndex] = null;
  
   if(fields_show.selectedIndex!=-1) {
    j = count-fields_show.selectedIndex;
    fields_show.selectedIndex=count;
    for(i=0;i<j;i++) ShiftUp();
   }
  
  }
 }
 
 function ShiftRight() {
  if(fields_show.selectedIndex!=-1) {
   count=fields_all.length;
   
   newoption = new Option(fields_show.options[fields_show.selectedIndex].text,fields_show.options[fields_show.selectedIndex].value);
   fields_all.options[count] = newoption;
   fields_show.options[fields_show.selectedIndex] = null;
  }
 }
 
 function ShiftUp() {
  index=fields_show.selectedIndex;
  if(index!=-1 && index!=0) {
   temp = fields_show.options[index-1].text;
   fields_show.options[index-1].text = fields_show.options[index].text;
   fields_show.options[index].text = temp;
   
   temp = fields_show.options[index-1].value;
   fields_show.options[index-1].value = fields_show.options[index].value;
   fields_show.options[index].value = temp;
   
   fields_show.selectedIndex = index-1;
  }
 }
 
 function ShiftDown() {
  index=fields_show.selectedIndex;
  count=fields_show.length;
  if(index!=-1 && index!=count-1) {
   temp = fields_show.options[index+1].text;
   fields_show.options[index+1].text = fields_show.options[index].text;
   fields_show.options[index].text = temp;
   
   temp = fields_show.options[index+1].value;
   fields_show.options[index+1].value = fields_show.options[index].value;
   fields_show.options[index].value = temp;
   
   fields_show.selectedIndex = index+1;
  }
 }
 
 function ShiftToTop() {
  doindex=fields_show.selectedIndex;
  if(doindex!=-1 && doindex!=0) {
   for(i=0;i<doindex;i++) {
    ShiftUp();
   }
  }
 }
 
 function ShiftToBottom() {
  doindex=fields_show.selectedIndex;
  docount=fields_show.length;
  if(doindex!=-1 && doindex!=docount-1) {
   for(i=0;i<(docount-1-doindex);i++) ShiftDown();
  }
 }
 
 function FormSubmit() {
  text=\\\"\\\";
  
  for(i=0;i<fields_show.length;i++) {
   if(text!=\\\"\\\") text += '|' + fields_show.options[i].value;
   else text = fields_show.options[i].value;
  }
  
  document.mform.hidden_show.value=text;
 } 
 
//-->
</script>
</body>
</html>";
?>