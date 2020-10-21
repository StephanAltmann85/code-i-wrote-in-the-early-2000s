<?php
			/*
			templatepackid: 0
			templatename: pms_tracking_unread
			*/
			
			$this->templates['pms_tracking_unread']="<form action=\\\"pms.php\\\" method=\\\"post\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:100%\\\">
 <tr>
  <td class=\\\"tablecat\\\" align=\\\"left\\\" colspan=\\\"6\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_UNREAD_MESSAGE']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_PMS_NOTREAD']}</span></td>
 </tr>
 <tr align=\\\"center\\\">
  <td class=\\\"tabletitle\\\" colspan=\\\"3\\\" style=\\\"width:60%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_TITLE_SUBJECT']}</b></span></td>
  <td class=\\\"tabletitle\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_TITLE_TO']}</b></span></td>
  <td class=\\\"tabletitle\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_TITLE_SEND_DATE']}</b></span></td>
  <td class=\\\"tabletitle\\\"><input type=\\\"checkbox\\\" name=\\\"all\\\" value=\\\"1\\\" onclick=\\\"select_all(this.checked,this.form)\\\" /></td>
 </tr>
 \$unreadbit
</table>
<table style=\\\"width:100%\\\">
 <tr>    
  <td align=\\\"right\\\"><select name=\\\"action\\\">
   <option value=\\\"tracking\\\">{\$lang->items['LANG_PMS_CHOSE']}</option>
   <option value=\\\"endtracking\\\">{\$lang->items['LANG_PMS_ENDTRACKING']}</option>
   <option value=\\\"cancel\\\">{\$lang->items['LANG_PMS_TRACKING_CANCEL']}</option>
  </select>&nbsp;<input src=\\\"{\$style['imagefolder']}/go.gif\\\" type=\\\"image\\\" /></td>
 </tr>
</table>
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
</form>";
			?>