<?php
/*
acp template
templatename: template_search_select
*/

$this->templates['acp_template_search_select']="<tr class=\\\"firstrow\\\">
    <td width=\\\"70%\\\">
     <select size=\\\"20\\\" name=\\\"templateid[]\\\" style=\\\"width:95%\\\" multiple>
	 \$template_options				
	</select>
    </td>
    <td width=\\\"30%\\\" valign=\\\"top\\\" style=\\\"text-align:justify\\\"><p>&nbsp;</p>
    <p>Auf der linken Seite können Sie einzelne Templates auswählen, in denen gesucht oder ersetzt werden soll.</p>
    <p>(Mehrfache Markierungen sind bei vielen Browsern durch gleichzeitiges Drücken von \\\"Ctrl/Strg\\\" möglich.)</p>
    <p><a href=\\\"javascript:select_all(true);\\\">alle Templates markieren</a></p>
    <p><a href=\\\"javascript:select_all(false);\\\">alle Templates demarkieren</a></p>
    </td>
   </tr>";
?>