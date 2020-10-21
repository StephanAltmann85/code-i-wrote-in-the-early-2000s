<?php
/*
acp template
templatename: refresh_start
*/

$this->templates['acp_refresh_start']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title></title>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<meta http-equiv=\\\"refresh\\\" content=\\\"\$time; url=\$url\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/other.css\\\" />
<script type=\\\"text/javascript\\\">
<!--
function showErrorMsg(errormsg)
{
	if(errormsg!='')
	{
		errormsg=errormsg.replace(/<[^>]+>/g,'');
		alert(errormsg);
	}
	else alert('{\$lang->items['LANG_ACP_OTHERSTUFF_REFRESH_ERROR']}');
}

function checkForError()
{
	if(!document.errorform || !document.errorform.noerror || !document.errorform.noerror.value || document.errorform.noerror.value!='true')
	{
		if(!document.phperror || !document.phperror.phperror || !document.phperror.phperror.value) var errormsg='';
		else var errormsg=document.phperror.phperror.value;
		if(!errormsg)
		{
			if(!document.errormsg || !document.errormsg.errormsg || !document.errormsg.errormsg.value) var errormsg='';
			else var errormsg=document.errormsg.errormsg.value;
		}
		showErrorMsg(errormsg);
	}
	else
	{
		proceed();
	}
}
//-->
</script>
</head>
<body onload=\\\"checkForError();\\\">
<form name=\\\"phperror\\\" method=\\\"get\\\" action=\\\"#\\\">
<textarea name=\\\"phperror\\\" rows=\\\"0\\\" cols=\\\"0\\\">";
?>