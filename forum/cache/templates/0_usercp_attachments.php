<?php
			/*
			templatepackid: 0
			templatename: usercp_attachments
			*/
			
			$this->templates['usercp_attachments']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_USERCP_ATTACHMENTS']}</title>
  \$headinclude
  <script type=\\\"text/javascript\\\">
   <!--
   function select_all(status,theform) {
    for (i=0;i<theform.length;i++) {
     if(theform.elements[i].name==\\\"attachmentids[]\\\" && !theform.elements[i].disabled) theform.elements[i].checked = status;    
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
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; {\$lang->items['LANG_USERCP_ATTACHMENTS']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />




  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">  
   <tr>
    <td class=\\\"tabletitle\\\" colspan=\\\"3\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_ATTACHMENTS_STORAGEUSAGE']}</b></span></td>
   </tr>
   <tr>
    <td align=\\\"left\\\" class=\\\"tablea\\\" colspan=\\\"3\\\"><span class=\\\"smallfont\\\">\$LANG_USERCP_ATTACHMENTS_STORAGE_USED \$LANG_USERCP_ATTACHMENTS_STORAGE_FREE</span></td>
   </tr>
   \".((\$percent && \$percent2) ? (\"
   <tr>
    <td align=\\\"left\\\" class=\\\"tableb\\\" colspan=\\\"3\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width: 100%;\\\">
     <tr>
      <td align=\\\"left\\\" style=\\\"width: {\$percent}%;\\\" class=\\\"tablecat\\\">&nbsp;</td>
      <td align=\\\"left\\\" style=\\\"width: {\$percent2}%;\\\" class=\\\"tableb\\\">&nbsp;</td>
     </tr>
    </table></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\" style=\\\"width:33%\\\"><span class=\\\"smallfont\\\">0%</span></td>
    <td class=\\\"tablea\\\" style=\\\"width:33%\\\" align=\\\"center\\\"><span class=\\\"smallfont\\\">50%</span></td>
    <td class=\\\"tablea\\\" style=\\\"width:33%\\\" align=\\\"right\\\"><span class=\\\"smallfont\\\">100%</span></td>
   </tr>
   \") : (\"\")).\"
  </table><br />
  
  
  <form action=\\\"usercp.php\\\" method=\\\"post\\\">   
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"del_attachments\\\" />
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tablecat\\\" align=\\\"left\\\" colspan=\\\"4\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_ATTACHMENTS']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tabletitle\\\"><input type=\\\"checkbox\\\" name=\\\"all\\\" value=\\\"1\\\" onclick=\\\"select_all(this.checked,this.form)\\\" /></td>
    <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERCP_ATTACHMENTS_TITLE_NAME']}</b></span></td>
    <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERCP_ATTACHMENTS_TITLE_POST']}</b></span></td>
    <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERCP_ATTACHMENTS_TITLE_DATE']}</b></span></td>
   </tr>
   \$attachmentbit
   <tr>
    <td class=\\\"tablea\\\" colspan=\\\"4\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width: 100%;\\\">
     <tr>
      <td align=\\\"left\\\"><span class=\\\"smallfont\\\">\$pagelink</span></td>
      <td align=\\\"right\\\"><input type=\\\"submit\\\" accesskey=\\\"S\\\" class=\\\"input\\\" value=\\\"{\$lang->items['LANG_USERCP_ATTACHMENTS_DELETE']}\\\" /></td>
     </tr>
    </table></td>
   </tr>
  </table>
  </form>
  



  \$footer
 </body>
</html>";
			?>