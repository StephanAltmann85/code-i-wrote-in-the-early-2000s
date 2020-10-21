<?php
			/*
			templatepackid: 0
			templatename: thread_attachments
			*/
			
			$this->templates['thread_attachments']="\".((\$attachmentbit != '') ? (\"
<br /><br />
<table align=\\\"center\\\" width=\\\"98%\\\" cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" class=\\\"tableinborder\\\">
 <tr>
  <td align=\\\"left\\\" class=\\\"tablecat\\\"><span class=\\\"smallfont\\\"><b>\$LANG_THREAD_ATTACHMENT</b></span></td>
 </tr>
 <tr class=\\\"normalfont\\\">
  <td class=\\\"inposttable\\\" align=\\\"left\\\">\$attachmentbit</td>
 </tr>
</table>\") : (\"\")).\"

\".((\$attachmentbit_img_thumbnails != '') ? (\"
<p><span class=\\\"normalfont\\\">\$LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL</span><br />
\$attachmentbit_img_thumbnails
</p>
\") : (\"\")).\"

\".((\$attachmentbit_img_small != '') ? (\"
<p><span class=\\\"normalfont\\\">\$LANG_THREAD_ATTACHMENT_IMAGE_SMALL</span><br />
\$attachmentbit_img_small
</p>
\") : (\"\")).\"

\".((\$attachmentbit_img != '') ? (\"
<p><span class=\\\"normalfont\\\">\$LANG_THREAD_ATTACHMENT_IMAGE</span><br />
\$attachmentbit_img
</p>
\") : (\"\")).\"";
			?>