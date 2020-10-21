<?php
			/*
			templatepackid: 0
			templatename: usergroups_groupleaders
			*/
			
			$this->templates['usergroups_groupleaders']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_USERGROUPS_GROUPS_TITLE']}</title>
  \$headinclude

  <script type=\\\"text/javascript\\\">
 <!--
  function select_all(name,status) {
   for (i=0;i<document.bbform.length;i++) {
    temp=document.bbform.elements[i].name;
    pos=temp.lastIndexOf('[');
    fieldname=temp.substr(0,pos);
    if(fieldname==name) document.bbform.elements[i].checked = status;    
   }
  }
 //-->
</script>  
 </head>
 <body>
  \$header
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; {\$lang->items['LANG_USERGROUPS_GROUPS_TITLE']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />


  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" colspan=\\\"3\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_LEADERSHIPS']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_GROUPNAME']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_GROUPTYPE']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_MEMBERSCOUNT']}</b></span></td>
   </tr>
   \$groupbits
  </table><br />
  
  \".((\$applicationbits) 
  ? (\"
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" colspan=\\\"5\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_OPEN_APPLICATIONS']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">&nbsp;</span></td>
    <td class=\\\"tablea\\\" style=\\\"width:30%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_USERNAME']}</b></span></td>
    <td class=\\\"tablea\\\" style=\\\"width:30%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_GROUPNAME']}</b></span></td>
    <td class=\\\"tablea\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_APPLICATIONDATE']}</b></span></td>
    <td class=\\\"tablea\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_OPTIONS']}</b></span></td>
   </tr>
   \$applicationbits
  </table><br />
  \") : (\"\")
  ).\"

  \".((\$oldapplicationbits) 
  ? (\"
  <form method=\\\"post\\\" action=\\\"usergroups.php\\\" name=\\\"bbform\\\">
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" colspan=\\\"5\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_CLOSED_APPLICATIONS']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><input type=\\\"checkbox\\\" onclick=\\\"select_all('applicationids',this.checked);\\\" /></td>
    <td class=\\\"tablea\\\" style=\\\"width:30%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_USERNAME']}</b></span></td>
    <td class=\\\"tablea\\\" style=\\\"width:30%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_GROUPNAME']}</b></span></td>
    <td class=\\\"tablea\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_APPLICATIONDATE']}</b></span></td>
    <td class=\\\"tablea\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_OPTIONS']}</b></span></td>
   </tr>
   \$oldapplicationbits
   <tr>
    <td class=\\\"tablea\\\" colspan=\\\"5\\\" align=\\\"center\\\"><input type=\\\"submit\\\" class=\\\"input\\\" value=\\\"{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_DELETE_APPLICATIONS']}\\\" /></td>
   </tr>
  </table>
  <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"groupleaders_deleteapplications\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  </form>
  \") : (\"\")
  ).\"
  
  
  \$footer
 </body>
</html>";
			?>