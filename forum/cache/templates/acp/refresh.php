<?php
/*
acp template
templatename: refresh
*/

$this->templates['acp_refresh']="</textarea>
</form>
<form name=\\\"errorform\\\" method=\\\"get\\\" action=\\\"#\\\">
<input type=\\\"hidden\\\" name=\\\"noerror\\\" value=\\\"true\\\" />
</form>
<script type=\\\"text/javascript\\\">
 <!--
 function proceed()
 {
  parent.workingtop.location.href='misc.php?sid=\$session[hash]&action=workingtop&taskname=\$taskname&percent=\$percent';
  window.location.href='\$url';
 }
 //-->
</script>
</body>
</html>";
?>