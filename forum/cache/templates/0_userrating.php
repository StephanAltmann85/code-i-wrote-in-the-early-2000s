<?php
			/*
			templatepackid: 0
			templatename: userrating
			*/
			
			$this->templates['userrating']="<br />\".((\$count==0) 
 ? (\"<br /><span class=\\\"smallfont\\\"><a href=\\\"javascript:rating('\$userid')\\\">{\$lang->items['LANG_MEMBERS_RATING_RATE_MEMBER']}</a></span><br />\") 
 : (\"<span class=\\\"smallfont\\\"><a href=\\\"javascript:rating('\$userid')\\\">{\$lang->items['LANG_MEMBERS_RATING_RATING']}</a>:</span><span class=\\\"normalfont\\\">&nbsp;</span>
 <br />

 <table cellpadding=\\\"1\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tableinborder\\\" style=\\\"width:100px\\\">
   <tr>
    <td align=\\\"left\\\" class=\\\"inposttable\\\"><span class=\\\"smallfont\\\"><img src=\\\"{\$style['imagefolder']}/userrating_\".((\$temp>6.6) ? (\"green\") : (\"\".((\$temp>3.3) ? (\"yellow\") : (\"red\")).\"\")).\".gif\\\" width=\\\"\$width\\\" height=\\\"9\\\" alt=\\\"{\$LANG_MEMBERS_RATING_RATINGS}\\\" title=\\\"{\$LANG_MEMBERS_RATING_RATINGS}\\\" /></span></td>
   </tr>
  </table>\")).\"";
			?>