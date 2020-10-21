<?php
			/*
			templatepackid: 0
			templatename: pms
			*/
			
			$this->templates['pms']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_GLOBAL_PMS']} | \".((\$action==\"tracking\") ? (\"{\$lang->items['LANG_PMS_TRACKING']}\") : (\"\".((\$folderid!=\"outbox\") ? (\"\$folder[title]\") : (\"{\$lang->items['LANG_PMS_OUTBOX']}\")).\"\")).\"</title>
  \$headinclude
 <script type=\\\"text/javascript\\\">
  <!--
  function select_all(status,theform) {
   for (i=0;i<theform.length;i++) {
    if(theform.elements[i].name==\\\"pmid[]\\\") theform.elements[i].checked = status;    
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
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; <a href=\\\"pms.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_GLOBAL_PMS']}</a> &raquo; \".((\$action==\"tracking\") ? (\"{\$lang->items['LANG_PMS_TRACKING']}\") : (\"\".((\$folderid!=\"outbox\") ? (\"\$folder[title]\") : (\"{\$lang->items['LANG_PMS_OUTBOX']}\")).\"\")).\"</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
  <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:{\$style['tableinwidth']}\\\">
   <tr align=\\\"left\\\">
    <td style=\\\"width:250px\\\" valign=\\\"top\\\">
     <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:100%\\\">
      <tr>
       <td class=\\\"tabletitle\\\" colspan=\\\"\".((\$folder_bit) ? (\"4\") : (\"3\")).\"\\\" align=\\\"center\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_FOLDER']}</b></span></td>
      </tr>
      <tr align=\\\"left\\\">
       <td class=\\\"tablea\\\"><img src=\\\"{\$style['imagefolder']}/msg-folder.gif\\\" alt=\\\"\\\" title=\\\"\\\" border=\\\"0\\\" /></td>
       <td class=\\\"tableb\\\" style=\\\"width:100%\\\"\".((\$folder_bit) ? (\" colspan=\\\"2\\\"\") : (\"\")).\"><span class=\\\"normalfont\\\"><a href=\\\"pms.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_PMS_INBOX']}</a></span></td>
       <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">\$inbox_count</span></td>
      </tr>
      \$folder_bit
      <tr align=\\\"left\\\">
       <td class=\\\"tablea\\\"><img src=\\\"{\$style['imagefolder']}/msg-folder.gif\\\" alt=\\\"\\\" title=\\\"\\\" border=\\\"0\\\" /></td>
       <td class=\\\"tableb\\\" style=\\\"width:100%\\\"\".((\$folder_bit) ? (\" colspan=\\\"2\\\"\") : (\"\")).\"><span class=\\\"normalfont\\\"><a href=\\\"pms.php?folderid=outbox{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_PMS_OUTBOX']}</a></span></td>
       <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">\$outbox_count</span></td>
      </tr>
      <tr align=\\\"left\\\">
       <td class=\\\"tablea\\\"><img src=\\\"{\$style['imagefolder']}/msg-folder.gif\\\" alt=\\\"\\\" title=\\\"\\\" border=\\\"0\\\" /></td>
       <td class=\\\"tableb\\\" style=\\\"width:100%\\\"\".((\$folder_bit) ? (\" colspan=\\\"2\\\"\") : (\"\")).\"><span class=\\\"normalfont\\\"><a href=\\\"pms.php?action=tracking{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_PMS_TRACKING']}</a></span></td>
       <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">\$tracking_count</span></td>
      </tr>
     </table><br />
     \".((\$user_folder_count < \$wbbuserdata['max_pms_folders']) 
      ? (\"
       <form action=\\\"pms.php\\\" method=\\\"post\\\">
       <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:100%\\\">
        <tr>
         <td class=\\\"tabletitle\\\" colspan=\\\"2\\\" align=\\\"center\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_CREATE_FOLDER']}</b></span></td>
        </tr>
        <tr align=\\\"left\\\">
         <td class=\\\"tablea\\\"><img src=\\\"{\$style['imagefolder']}/msg-folder.gif\\\" alt=\\\"\\\" title=\\\"\\\" border=\\\"0\\\" /></td>
         <td class=\\\"tableb\\\" style=\\\"width:100%\\\"><input type=\\\"text\\\" name=\\\"foldertitle\\\" maxlength=\\\"100\\\" value=\\\"\\\" class=\\\"input\\\" />&nbsp;<input src=\\\"{\$style['imagefolder']}/go.gif\\\" type=\\\"image\\\" /></td>
        </tr>
       </table>
       <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
       <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"createfolder\\\" />
       <br /></form>
      \") : (\"\")
     ).\"
     \".((\$folderid!=\"outbox\" && \$folderid!=0) 
      ? (\"
       <form action=\\\"pms.php\\\" method=\\\"post\\\">
       <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:100%\\\">
        <tr>
         <td class=\\\"tabletitle\\\" colspan=\\\"2\\\" align=\\\"center\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_RENAME']}</b></span></td>
        </tr>
        <tr align=\\\"left\\\">
         <td class=\\\"tablea\\\"><img src=\\\"{\$style['imagefolder']}/msg-folder.gif\\\" alt=\\\"\\\" title=\\\"\\\" border=\\\"0\\\" /></td>
         <td class=\\\"tableb\\\" style=\\\"width:100%\\\"><input type=\\\"text\\\" name=\\\"foldertitle\\\" maxlength=\\\"100\\\" value=\\\"\$folder[title]\\\" class=\\\"input\\\" />&nbsp;<input src=\\\"{\$style['imagefolder']}/go.gif\\\" type=\\\"image\\\" /></td>
        </tr>
       </table>
       <input type=\\\"hidden\\\" name=\\\"folderid\\\" value=\\\"\$folderid\\\" />
       <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
       <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"renamefolder\\\" />
       <br /></form>
      \") : (\"\")
     ).\"
     
     <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:250px\\\">
      <tr>
       <td class=\\\"tabletitle\\\" colspan=\\\"3\\\" align=\\\"center\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_DATA_USAGE']}</b></span></td>
      </tr>
      <tr>
       <td align=\\\"left\\\" class=\\\"tablea\\\" colspan=\\\"3\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_PMS_FOLDER_USAGE']}</span></td>
      </tr>
      <tr>
       <td align=\\\"left\\\" class=\\\"tableb\\\" colspan=\\\"3\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\">
        <tr>
         <td align=\\\"left\\\" class=\\\"tablecat\\\"><img src=\\\"{\$style['imagefolder']}/spacer.gif\\\" border=\\\"0\\\" height=\\\"10\\\" width=\\\"\$x\\\" alt=\\\"\\\" /></td>
        </tr>
       </table></td>
      </tr>
      <tr align=\\\"left\\\">
       <td class=\\\"tablea\\\" style=\\\"width:33%\\\"><span class=\\\"smallfont\\\">0%</span></td>
       <td class=\\\"tablea\\\" style=\\\"width:33%\\\" align=\\\"center\\\"><span class=\\\"smallfont\\\">50%</span></td>
       <td class=\\\"tablea\\\" style=\\\"width:33%\\\" align=\\\"right\\\"><span class=\\\"smallfont\\\">100%</span></td>
      </tr>
     </table>
    </td>
    <td nowrap=\\\"nowrap\\\">&nbsp;&nbsp;&nbsp;</td>
   
   \".((\$action==\"tracking\") 
    ? (\"
    
     <td align=\\\"left\\\" style=\\\"width:100%\\\" valign=\\\"top\\\">
     \$unread
     \$read
     <table style=\\\"width:100%\\\">
      <tr align=\\\"left\\\">
       <td valign=\\\"top\\\"><a href=\\\"pms.php?action=newpm{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/newpm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_NEWPM']}\\\" title=\\\"{\$lang->items['LANG_PMS_NEWPM']}\\\" /></a></td>
       <td align=\\\"right\\\" nowrap=\\\"nowrap\\\"><form method=\\\"post\\\" action=\\\"pms.php\\\">
        <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"tracking\\\" />
        <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
        <select name=\\\"daysprune\\\">
        <option value=\\\"1000\\\">{\$lang->items['LANG_PMS_SHOWALL']}</option>
        <option value=\\\"1500\\\"\$d_select[1500]>{\$lang->items['LANG_PMS_LASTVISIT']}</option>
        <option value=\\\"1\\\"\$d_select[1]>{\$lang->items['LANG_PMS_NEWER_1']}</option>
        <option value=\\\"2\\\"\$d_select[2]>{\$lang->items['LANG_PMS_NEWER_2']}</option>
        <option value=\\\"5\\\"\$d_select[5]>{\$lang->items['LANG_PMS_NEWER_5']}</option>
        <option value=\\\"10\\\"\$d_select[10]>{\$lang->items['LANG_PMS_NEWER_10']}</option>
        <option value=\\\"20\\\"\$d_select[20]>{\$lang->items['LANG_PMS_NEWER_20']}</option>
        <option value=\\\"30\\\"\$d_select[30]>{\$lang->items['LANG_PMS_NEWER_30']}</option>
        <option value=\\\"45\\\"\$d_select[45]>{\$lang->items['LANG_PMS_NEWER_45']}</option>
        <option value=\\\"60\\\"\$d_select[60]>{\$lang->items['LANG_PMS_NEWER_60']}</option>
        <option value=\\\"75\\\"\$d_select[75]>{\$lang->items['LANG_PMS_NEWER_75']}</option>
        <option value=\\\"100\\\"\$d_select[100]>{\$lang->items['LANG_PMS_NEWER_100']}</option>
        <option value=\\\"365\\\"\$d_select[365]>{\$lang->items['LANG_PMS_NEWER_365']}</option>
      </select>&nbsp;<input src=\\\"{\$style['imagefolder']}/go.gif\\\" type=\\\"image\\\" /></form></td>
     </tr></table>
     </td>
    
    \") 
    : (\"
    
       <td style=\\\"width:100%\\\" valign=\\\"top\\\"><form action=\\\"pms.php\\\" method=\\\"post\\\">
        \".((\$pms_bit!=\"\") 
        ? (\"
        <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:100%\\\">
         <tr align=\\\"center\\\">
          <td class=\\\"tabletitle\\\" colspan=\\\"\".((\$folderid==\"outbox\") ? (\"2\") : (\"3\")).\"\\\" style=\\\"width:60%\\\"><span class=\\\"normalfont\\\"><b><a href=\\\"pms.php?folderid=\$folderid&amp;sortfield=subject&amp;sortorder=\".((\$sortfield == 'subject' && \$sortorder == 'ASC') ? (\"DESC\") : (\"ASC\")).\"{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_PMS_TITLE_SUBJECT']}</a></b> \".((\$sortfield == 'subject') ? (\"<a href=\\\"pms.php?folderid=\$folderid&amp;sortfield=\$sortfield&amp;sortorder=\".((\$sortorder == 'DESC') ? (\"ASC\") : (\"DESC\")).\"{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/\".((\$sortorder == 'DESC') ? (\"sortasc.gif\") : (\"sortdesc.gif\")).\"\\\" alt=\\\"\\\" border=\\\"0\\\" /></a>\") : (\"\")).\"</span></td>
          <td class=\\\"tabletitle\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\"><b>\".((\$folderid==\"outbox\") ? (\"{\$lang->items['LANG_PMS_TITLE_TO']}\") : (\"<a href=\\\"pms.php?folderid=\$folderid&amp;sortfield=username&amp;sortorder=\".((\$sortfield == 'username' && \$sortorder == 'ASC') ? (\"DESC\") : (\"ASC\")).\"{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_PMS_TITLE_BY']}</a>\")).\"</b>\".((\$folderid != 'outbox') ? (\" \".((\$sortfield == 'username') ? (\"<a href=\\\"pms.php?folderid=\$folderid&amp;sortfield=\$sortfield&amp;sortorder=\".((\$sortorder == 'DESC') ? (\"ASC\") : (\"DESC\")).\"{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/\".((\$sortorder == 'DESC') ? (\"sortasc.gif\") : (\"sortdesc.gif\")).\"\\\" alt=\\\"\\\" border=\\\"0\\\" /></a>\") : (\"\")).\"\") : (\"\")).\"</span></td>
          <td class=\\\"tabletitle\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\"><b><a href=\\\"pms.php?folderid=\$folderid&amp;sortfield=sendtime&amp;sortorder=\".((\$sortfield == 'sendtime' && \$sortorder == 'ASC') ? (\"DESC\") : (\"ASC\")).\"{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_PMS_TITLE_DATE']}</a></b> \".((\$sortfield == 'sendtime') ? (\"<a href=\\\"pms.php?folderid=\$folderid&amp;sortfield=\$sortfield&amp;sortorder=\".((\$sortorder == 'DESC') ? (\"ASC\") : (\"DESC\")).\"{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/\".((\$sortorder == 'DESC') ? (\"sortasc.gif\") : (\"sortdesc.gif\")).\"\\\" alt=\\\"\\\" border=\\\"0\\\" /></a>\") : (\"\")).\"</span></td>
          <td class=\\\"tabletitle\\\"><input type=\\\"checkbox\\\" name=\\\"all\\\" value=\\\"1\\\" onclick=\\\"select_all(this.checked,this.form)\\\" /></td>
         </tr>
         \$pms_bit
        </table>
        \") : (\"\")
        ).\"
        <table style=\\\"width:100%\\\">
         <tr align=\\\"left\\\">    
          <td><a href=\\\"pms.php?action=newpm{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/newpm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_CREATE_NEWPM']}\\\" title=\\\"{\$lang->items['LANG_PMS_CREATE_NEWPM']}\\\" /></a></td>
          <td style=\\\"width:100%\\\" nowrap=\\\"nowrap\\\"><select name=\\\"daysprune\\\">
           <option value=\\\"1000\\\">{\$lang->items['LANG_PMS_SHOWALL']}</option>
           <option value=\\\"1500\\\"\$d_select[1500]>{\$lang->items['LANG_PMS_LASTVISIT']}</option>
           <option value=\\\"1\\\"\$d_select[1]>{\$lang->items['LANG_PMS_NEWER_1']}</option>
           <option value=\\\"2\\\"\$d_select[2]>{\$lang->items['LANG_PMS_NEWER_2']}</option>
           <option value=\\\"5\\\"\$d_select[5]>{\$lang->items['LANG_PMS_NEWER_5']}</option>
           <option value=\\\"10\\\"\$d_select[10]>{\$lang->items['LANG_PMS_NEWER_10']}</option>
           <option value=\\\"20\\\"\$d_select[20]>{\$lang->items['LANG_PMS_NEWER_20']}</option>
           <option value=\\\"30\\\"\$d_select[30]>{\$lang->items['LANG_PMS_NEWER_30']}</option>
           <option value=\\\"45\\\"\$d_select[45]>{\$lang->items['LANG_PMS_NEWER_45']}</option>
           <option value=\\\"60\\\"\$d_select[60]>{\$lang->items['LANG_PMS_NEWER_60']}</option>
           <option value=\\\"75\\\"\$d_select[75]>{\$lang->items['LANG_PMS_NEWER_75']}</option>
           <option value=\\\"100\\\"\$d_select[100]>{\$lang->items['LANG_PMS_NEWER_100']}</option>
           <option value=\\\"365\\\"\$d_select[365]>{\$lang->items['LANG_PMS_NEWER_365']}</option>
          </select>&nbsp;<input src=\\\"{\$style['imagefolder']}/go.gif\\\" type=\\\"image\\\" /></td>
          <td align=\\\"right\\\" nowrap=\\\"nowrap\\\"><select name=\\\"action\\\">
           <option value=\\\"\\\">{\$lang->items['LANG_PMS_CHOSE']}</option>
           <option value=\\\"delmark\\\">{\$lang->items['LANG_PMS_DELETE']}</option>
           <option value=\\\"zipdownload\\\">{\$lang->items['LANG_PMS_ZIPDOWNLOAD']}</option>
           \$moveto_options
           <option value=\\\"\\\">----------------------------</option>
           <option value=\\\"delall\\\">{\$lang->items['LANG_PMS_DELETE_ALL']}</option>
          </select>&nbsp;<input src=\\\"{\$style['imagefolder']}/go.gif\\\" type=\\\"image\\\" /></td>
         </tr>
        </table>
        <input type=\\\"hidden\\\" name=\\\"folderid\\\" value=\\\"\$folderid\\\" />
        <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
        </form>
       </td>
       
    \")
   ).\"

   </tr>
  </table><br />
  \$footer

 </body>
</html>";
			?>