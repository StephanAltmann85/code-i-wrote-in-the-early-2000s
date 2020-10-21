<?php
			/*
			templatepackid: 0
			templatename: usergroups_memberslist
			*/
			
			$this->templates['usergroups_memberslist']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_USERGROUPS_GROUPS_TITLE']} | {\$lang->items['LANG_GLOBAL_MEMBERSLIST']}</title>
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
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; <a href=\\\"usergroups.php?action=groupleaders{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERGROUPS_GROUPS_TITLE']}</a> &raquo; {\$lang->items['LANG_GLOBAL_MEMBERSLIST']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />

  <form method=\\\"post\\\" action=\\\"usergroups.php\\\" name=\\\"bbform\\\">
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" colspan=\\\"2\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_USERSINGROUP']}</b></span></td>
   </tr>
   
   \".((\$userbits!=\"\") 
   ? (\"
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><input type=\\\"checkbox\\\" onclick=\\\"select_all('userids',this.checked);\\\" /></td>
    <td class=\\\"tablea\\\" style=\\\"width:100%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_USERNAME']}</b></span></td>
   </tr>
   \$userbits
   <tr align=\\\"center\\\">
    <td class=\\\"tablea\\\" colspan=\\\"2\\\"><input type=\\\"submit\\\" class=\\\"input\\\" value=\\\"{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_REMOVE_USERS']}\\\" /></td>
   </tr>
   \") 
   : (\"
   <tr>
    <td class=\\\"tablea\\\" colspan=\\\"2\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_NO_USERS']}</b></span></td>
   </tr>
   \")
   ).\"
  </table>
  <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"groupleaders_removeusers\\\" />
  <input type=\\\"hidden\\\" name=\\\"groupid\\\" value=\\\"\$groupid\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  </form>  
  <table align=\\\"center\\\">
   <tr>
    <td><span class=\\\"smallfont\\\">\$pagelink</span></td>
   </tr>
  </table>
  \$footer
 </body>
</html>";
			?>