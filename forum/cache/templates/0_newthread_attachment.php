<?php
			/*
			templatepackid: 0
			templatename: newthread_attachment
			*/
			
			$this->templates['newthread_attachment']="<script type=\\\"text/javascript\\\">
document.write('<input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_POST_ATTACHMENTS']}\\\" onclick=\\\"window.open(\\\\'attachmentedit.php?boardid=\$boardid\".((\$filename == 'editpost.php') ? (\"&postid=\$postid\") : (\"\")).\"&idhash=\$idhash&attachmentids=\\\\'+document.bbform.attachmentids.value+\\\\'{\$SID_ARG_2ND_UN}\\\\', \\\\'moo\\\\', \\\\'toolbar=no,scrollbars=yes,resizable=yes,width=450,height=400\\\\')\\\" class=\\\"input\\\"  />');
</script>
<noscript>
<span class=\\\"normalfont\\\"><a href=\\\"attachmentedit.php?boardid=\$boardid\".((\$filename == 'editpost.php') ? (\"&amp;postid=\$postid\") : (\"\")).\"&amp;idhash=\$idhash{\$SID_ARG_2ND}\\\" target=\\\"_blank\\\">{\$lang->items['LANG_POST_ATTACHMENTS']}</a></span>
</noscript>";
			?>