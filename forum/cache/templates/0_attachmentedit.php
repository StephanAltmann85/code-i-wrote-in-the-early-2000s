<?php
			/*
			templatepackid: 0
			templatename: attachmentedit
			*/
			
			$this->templates['attachmentedit']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_MISC_ATTACHMENTS_EDIT']}</title>
\$headinclude
<style type=\\\"text/css\\\">
 <!--
 #statusLayer {
 	display: none;
 	position: absolute;
 	
 	top: 0;
 	left: 10;
	width: 100%;
	height: 100%;
 	
 	padding: 10px;
 	padding-top: 40px;
 	
 	background-color: \".((\$style['pagebgcolor']!=\"\") ? (\"{\$style['pagebgcolor']};\") : (\"#ffffff;\")).\"
 	color: \".((\$style['fontcolor']!=\"\") ? (\"{\$style['fontcolor']};\") : (\" #000000;\")).\"
 	\".((\$style['fontfamily']!=\"\") ? (\"font-family: {\$style['fontfamily']};\") : (\"\")).\"
 }
 -->
</style>
<script type=\\\"text/javascript\\\">
<!--
if(!opener) self.close();

function giveparent() {
	opener.document.bbform.attachmentids.value = '\$attachmentids';
	self.close();
}

function toggle(id, show) {
	if(document.getElementById) {
		var element;
		element = document.getElementById(id);
		if (show == 1) {
			element.style.display = 'block';	
		}
		else {
			element.style.display = 'none';
		}
	}	
}
//-->
</script>
</head>

<body>

<div id=\\\"statusLayer\\\">
  <p align=\\\"center\\\"><img src=\\\"{\$style['imagefolder']}/uploading.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_MISC_ATTACHMENT_UPLOADING']}\\\" /> <span class=\\\"normalfont\\\">{\$lang->items['LANG_MISC_ATTACHMENT_UPLOADING']}</span></p>
</div>


\".((\$error != '') ? (\"
<table style=\\\"width:100%\\\" cellpadding=\\\"{\$style['tableoutcellpadding']}\\\" cellspacing=\\\"{\$style['tableoutcellspacing']}\\\" align=\\\"center\\\" border=\\\"{\$style['tableoutborder']}\\\" class=\\\"tableoutborder\\\">
 <tr><td class=\\\"mainpage\\\" align=\\\"center\\\">&nbsp;<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MISC_ATTACHMENT_ERROR']}</b></span></td>
  </tr>
  <tr>
   <td class=\\\"tableb\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\">
   <ul>\$error</ul>
   </span></td>
  </tr>
 </table><br /></td></tr>
</table><br />
\") : (\"\")).\"

\".((\$max_attachments == -1 || \$attachmentCounter < \$max_attachments) ? (\"
<form action=\\\"attachmentedit.php\\\" method=\\\"post\\\" enctype=\\\"multipart/form-data\\\">
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"add\\\" />
<input type=\\\"hidden\\\" name=\\\"boardid\\\" value=\\\"\$boardid\\\" />
<input type=\\\"hidden\\\" name=\\\"postid\\\" value=\\\"\$postid\\\" />
<input type=\\\"hidden\\\" name=\\\"attachmentids\\\" value=\\\"\$attachmentids\\\" />
<input type=\\\"hidden\\\" name=\\\"idhash\\\" value=\\\"\$idhash\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<table style=\\\"width:100%\\\" cellpadding=\\\"{\$style['tableoutcellpadding']}\\\" cellspacing=\\\"{\$style['tableoutcellspacing']}\\\" align=\\\"center\\\" border=\\\"{\$style['tableoutborder']}\\\" class=\\\"tableoutborder\\\">
 <tr><td class=\\\"mainpage\\\" align=\\\"center\\\">&nbsp;<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MISC_ATTACHMENT_ADD']}</b></span></td>
  </tr>
  <tr>
   <td class=\\\"tableb\\\" align=\\\"left\\\"><input type=\\\"hidden\\\" name=\\\"MAX_FILE_SIZE\\\" value=\\\"\$max_attachment_size\\\" /><input name=\\\"attachment_file\\\" type=\\\"file\\\" class=\\\"input\\\" />   <input class=\\\"input\\\" type=\\\"submit\\\" name=\\\"submit\\\" accesskey=\\\"S\\\" onclick=\\\"toggle('statusLayer', 1);\\\" value=\\\"{\$lang->items['LANG_MISC_SAVE']}\\\" /><br />
    <span class=\\\"smallfont\\\">
    \".((\$max_attachments != -1) ? (\"{\$lang->items['LANG_MISC_ATTACHMENT_MAX_ATTACHMENTS']} <b>\$max_attachments</b><br />\") : (\"\")).\"
    {\$lang->items['LANG_MISC_ATTACHMENT_MAXFILESIZE']} <b>\$max_attachment_size_readable</b><br />
    {\$lang->items['LANG_MISC_ATTACHMENT_EXTENSIONS']} <b>\$allowed_attachment_extensions</b><br />
    \".((\$LANG_MISC_ATTACHMENT_QUOTA) ? (\"\$LANG_MISC_ATTACHMENT_QUOTA<br />\") : (\"\")).\"
    \".((\$LANG_MISC_ATTACHMENT_QUOTA_FREE) ? (\"\$LANG_MISC_ATTACHMENT_QUOTA_FREE<br />\") : (\"\")).\"</span></td>
  </tr>
 </table><br />
</td></tr></table></form>
\") : (\"\")).\"

\".((\$attachmentbit != '') ? (\"
<br /><form action=\\\"attachmentedit.php\\\" method=\\\"post\\\">
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"del\\\" />
<input type=\\\"hidden\\\" name=\\\"boardid\\\" value=\\\"\$boardid\\\" />
<input type=\\\"hidden\\\" name=\\\"postid\\\" value=\\\"\$postid\\\" />
<input type=\\\"hidden\\\" name=\\\"attachmentids\\\" value=\\\"\$attachmentids\\\" />
<input type=\\\"hidden\\\" name=\\\"idhash\\\" value=\\\"\$idhash\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<table style=\\\"width:100%\\\" cellpadding=\\\"{\$style['tableoutcellpadding']}\\\" cellspacing=\\\"{\$style['tableoutcellspacing']}\\\" align=\\\"center\\\" border=\\\"{\$style['tableoutborder']}\\\" class=\\\"tableoutborder\\\">
 <tr><td class=\\\"mainpage\\\" align=\\\"center\\\">&nbsp;<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
   <td colspan=\\\"2\\\" class=\\\"tabletitle\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MISC_ATTACHMENTS_EDIT']}</b></span></td>
  </tr>
  \$attachmentbit
 </table><br />
</td></tr></table>
</form>
\") : (\"\")).\"

<p align=\\\"center\\\">
  <input class=\\\"input\\\" type=\\\"button\\\" value=\\\"{\$lang->items['LANG_MISC_CLOSE']}\\\" onclick=\\\"giveparent();\\\" />
</p>
<img src=\\\"{\$style['imagefolder']}/uploading.gif\\\" border=\\\"0\\\" width=\\\"0\\\" height=\\\"0\\\" />
</body>
</html>";
			?>