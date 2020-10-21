<?php
			/*
			templatepackid: 0
			templatename: calendar_daybits
			*/
			
			$this->templates['calendar_daybits']="<td align=\\\"left\\\" width=\\\"14%\\\" height=\\\"100\\\" valign=\\\"top\\\" \".((\$month==\$today_month && \$year==\$today_year && \$day==\$today_day) ? (\"style=\\\"border:2px;border-style:outset\\\" class=\\\"tableb\\\"\") : (\"class=\\\"tablea\\\"\")).\"><span class=\\\"normalfont\\\"><b>\$day</b>\".((\$daynumber==0) ? (\"&nbsp;(\$weeknumber. {\$lang->items['LANG_CALENDAR_WEEK']})\") : (\"\")).\" </span>\".((\$events) ? (\"<br /><br />\$events\") : (\"\")).\"</td>";
			?>