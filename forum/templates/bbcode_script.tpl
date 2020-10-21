
<script type="text/javascript">
<!--
<if($wbbuserdata['usewysiwyg'] == 1)><then>
function getAppletObject() {
	if(document.getElementById('embed_wysiwyg') == null || document.getElementById('embed_wysiwyg').getTextLength == null) return document.getElementById('wysiwyg');
	return document.getElementById('embed_wysiwyg');
}

function setAppletText(theForm) {
	getAppletObject().setText(theForm.message.value);
}

function getHiddenText() {
	return document.bbform.message.value;
}

function smilie(theSmilie) {
	getAppletObject().insertSmilie(theSmilie);
}

function submitForm() {
	if (validate(document.bbform)) document.bbform.submit();
}
</then>
<else>
tag_prompt = "{$lang->items['LANG_POSTINGS_JS_PROMPT']}";
img_prompt = "{$lang->items['LANG_POSTINGS_JS_PROMPT_IMG']}";
font_formatter_prompt = "{$lang->items['LANG_POSTINGS_JS_PROMPT_FONT']}";
link_text_prompt = "{$lang->items['LANG_POSTINGS_JS_PROMPT_URL_TITLE']}";
link_url_prompt = "{$lang->items['LANG_POSTINGS_JS_PROMPT_URL']}";
link_email_prompt = "{$lang->items['LANG_POSTINGS_JS_PROMPT_EMAIL']}";
list_type_prompt = "{$lang->items['LANG_POSTINGS_JS_PROMPT_LIST_TYPE']}";
list_item_prompt = "{$lang->items['LANG_POSTINGS_JS_PROMPT_LIST_ITEM']}";
</else>
</if>


function getAppletText(theForm) {
<if($wbbuserdata['usewysiwyg'] == 1)><then>
	var appletObj = getAppletObject();
	if (appletObj != null) {	
		theForm.message.value = appletObj.getText();
	}
</then></if>
}

function resetAppletText() {
<if($wbbuserdata['usewysiwyg'] == 1)><then>
	getAppletObject().reset();
</then></if>
}

function getMessageLength(theform) {
<if($wbbuserdata['usewysiwyg'] == 1)><then>
	return getAppletObject().getTextLength();
</then>
<else>
	return theform.message.value.length;
</else>
</if>
}


<if($filename=="addreply.php" || $filename=="editpost.php")>
<then>
var postmaxchars = $postmaxchars;
function validate(theform) {
 getAppletText(theform);
 if (theform.message.value=="") {
  alert("{$lang->items['LANG_POSTINGS_JS_ERROR2']}");
  return false;
 }
 return messagetolong(theform);
}
</then>
</if>

<if($filename=="calendar.php")>
<then>
var postmaxchars = $eventmaxchars;
function validate(theform) {
 getAppletText(theform);
 if (theform.message.value=="" || theform.subject.value=="") {
  alert("{$lang->items['LANG_CALENDAR_JS_ERROR3']}");
  return false;
 }
 return messagetolong(theform);
}
</then>
</if>

<if($filename=="newthread.php")>
<then>
var postmaxchars = $postmaxchars;
function validate(theform) {
 getAppletText(theform);
 if (theform.message.value=="" || theform.topic.value=="") {
  alert("{$lang->items['LANG_POSTINGS_JS_ERROR1']}");
  return false;
 }
 return messagetolong(theform);
}
</then>
</if>

<if($filename=="usercp.php")>
<then>
var postmaxchars = $wbbuserdata[max_sig_length];
function validate(theform) {
 getAppletText(theform);
 return messagetolong(theform);
}
</then>
</if>

<if($filename=="pms.php")>
<then>
var postmaxchars = $pmmaxchars;
function validate(theform) {
 getAppletText(theform);
 if ((theform.recipients.value=="" && theform.recipients_bcc.value=="") || theform.message.value=="" || theform.subject.value=="") {
  alert("{$lang->items['LANG_POSTINGS_JS_ERROR3']}");
  return false;
 }
 return messagetolong(theform);
}
</then>
</if>

function checklength(theform) {
 if (postmaxchars != 0) message = " {$lang->items['LANG_POSTINGS_JS_MESSAGE_MAXLENGTH']}";
 else message = "";
 
 var messageLength = getMessageLength(theform);
 alert("{$lang->items['LANG_POSTINGS_JS_MESSAGE_CHECKLENGTH']}" + message);
}

function messagetolong(theform) {
 	if (postmaxchars != 0) {
  		var messageLength = getMessageLength(theform);
  		if (messageLength > postmaxchars) {
   			alert("{$lang->items['LANG_POSTINGS_JS_MESSAGE_TOLONG']}");
   			return false;
  		}
  		else {
  			return true;
  		}
 	} 
 	else {
 		return true;
 	}
}

function changeEditor(theForm, editorID) {
	getAppletText(theForm);
	theForm.change_editor.value = editorID;
	theForm.submit();	
}


activeMenu = false;
menuTimerRunning = false;
function toggleMenu(id, toggle) {
	if(document.getElementById) {
		if(id && toggle) {
			element = document.getElementById(id);
			status = element.style.display;
			if (!status || status == 'undefined' || status == 'none') {
				posLeft = getObjectPosLeft(toggle) + 10;
				element.style.left = posLeft + 'px';
				element.style.top = '0px';
				element.style.display = 'block';
				<if($wbbuserdata['usewysiwyg'] == 1)><then>
				posTop = getObjectPosTop(toggle) + toggle.offsetHeight + 10;
				</then><else>
				posTop = getObjectPosTop(toggle) - element.offsetHeight - 10;
				</else></if>
				element.style.top = posTop + 'px';
				element.onmouseover = checkMenuTimer;
				element.onmouseout = startMenuTimer;
				activeMenu = id;
			}
			else {
				element.style.display = 'none';
				activeMenu = false;
			}
		}
		else if(activeMenu) {
			checkMenuTimer();
  			document.getElementById(activeMenu).style.display = 'none';
			activeMenu = false;
  		}
	}	
}

function getObjectPosLeft(element) {
	var left = element.offsetLeft;
	while((element = element.offsetParent) != null)	{
		left += element.offsetLeft;
	}
	return left;
}
function getObjectPosTop(element) {
	var top = element.offsetTop;
	while((element = element.offsetParent) != null)	{
		top += element.offsetTop;
	}
	return top;
}
function checkMenuTimer() {
	if(menuTimerRunning)  {
		clearTimeout(menuTimerRunning);
		menuTimerRunning = false;
	}
}
function startMenuTimer() {
	menuTimerRunning = setTimeout("toggleMenu();", 500);
}

//-->
</script>

<if($wbbuserdata['usewysiwyg'] != 1)><then>
<script type="text/javascript" src="js/bbcode.js"></script>
</then></if>