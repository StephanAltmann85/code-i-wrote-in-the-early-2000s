<?php
/*
acp template
templatename: sync
*/

$this->templates['acp_sync']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />

<script type=\\\"text/javascript\\\">
 <!--
  function sync() {
   storage = parent.storage.document.sform.storage;
   for(i=0;i<storage.length;i++) {
    if(storage.options[i].selected) {
     if(document.bbform.userids.value!='') document.bbform.userids.value+=','+storage.options[i].value;
     else document.bbform.userids.value=storage.options[i].value;
    }
   }
   if(document.bbform.userids.value!='') document.bbform.submit();
   else alert('{\$lang->items['LANG_ACP_MISC_SYNC_NOTHING_SELECTED']}');
  }
 //-->
</script>

</head>

<body onload=\\\"sync();\\\">
<form method=\\\"post\\\" action=\\\"misc.php\\\" name=\\\"bbform\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"sync\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"userids\\\" value=\\\"\\\" />
</form>
</body>
</html>";
?>