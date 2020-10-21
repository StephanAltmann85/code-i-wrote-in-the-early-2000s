<?php
			/*
			templatepackid: 0
			templatename: wiw_sortby
			*/
			
			$this->templates['wiw_sortby']="<select name=\\\"sortby\\\">
   <option value=\\\"username\\\"\$sel_sortby[username]>{\$lang->items['LANG_WIW_USERNAME']}</option>
   \".((\$wbbuserdata['a_can_use_acp']==1) 
   ? (\"
   <option value=\\\"ipaddress\\\"\$sel_sortby[ipaddress]>{\$lang->items['LANG_WIW_IPADDRESS']}</option>
   <option value=\\\"useragent\\\"\$sel_sortby[useragent]>{\$lang->items['LANG_WIW_USERAGENT']}</option>
   \") : (\"\")
   ).\"
   <option value=\\\"lastactivity\\\"\$sel_sortby[lastactivity]>{\$lang->items['LANG_WIW_LASTACTIVITY']}</option>
   <option value=\\\"request_uri\\\"\$sel_sortby[request_uri]>{\$lang->items['LANG_WIW_REQUEST_URI']}</option>
  </select>";
			?>