<?php
			/*
			templatepackid: 0
			templatename: bbcode_script
			*/
			
			$this->templates['bbcode_script']="
<script type=\\\"text/javascript\\\">
<!--
\".((\$wbbuserdata['usewysiwyg'] == 1) ? (\"
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
\") 
: (\"
tag_prompt = \\\"{\$lang->items['LANG_POSTINGS_JS_PROMPT']}\\\";
img_prompt = \\\"{\$lang->items['LANG_POSTINGS_JS_PROMPT_IMG']}\\\";
font_formatter_prompt = \\\"{\$lang->items['LANG_POSTINGS_JS_PROMPT_FONT']}\\\";
link_text_prompt = \\\"{\$lang->items['LANG_POSTINGS_JS_PROMPT_URL_TITLE']}\\\";
link_url_prompt = \\\"{\$lang->items['LANG_POSTINGS_JS_PROMPT_URL']}\\\";
link_email_prompt = \\\"{\$lang->items['LANG_POSTINGS_JS_PROMPT_EMAIL']}\\\";
list_type_prompt = \\\"{\$lang->items['LANG_POSTINGS_JS_PROMPT_LIST_TYPE']}\\\";
list_item_prompt = \\\"{\$lang->items['LANG_POSTINGS_JS_PROMPT_LIST_ITEM']}\\\";
\")
).\"


function getAppletText(theForm) {
\".((\$wbbuserdata['usewysiwyg'] == 1) ? (\"
	var appletObj = getAppletObject();
	if (appletObj != null) {	
		theForm.message.value = appletObj.getText();
	}
\") : (\"\")).\"
}

function resetAppletText() {
\".((\$wbbuserdata['usewysiwyg'] == 1) ? (\"
	getAppletObject().reset();
\") : (\"\")).\"
}

function getMessageLength(theform) {
\".((\$wbbuserdata['usewysiwyg'] == 1) ? (\"
	return getAppletObject().getTextLength();
\") 
: (\"
	return theform.message.value.length;
\")
).\"
}


\".((\$filename==\"addreply.php\" || \$filename==\"editpost.php\") 
? (\"
var postmaxchars = \$postmaxchars;
function validate(theform) {
 getAppletText(theform);
 if (theform.message.value==\\\"\\\") {
  alert(\\\"{\$lang->items['LANG_POSTINGS_JS_ERROR2']}\\\");
  return false;
 }
 return messagetolong(theform);
}
\") : (\"\")
).\"

\".((\$filename==\"calendar.php\") 
? (\"
var postmaxchars = \$eventmaxchars;
function validate(theform) {
 getAppletText(theform);
 if (theform.message.value==\\\"\\\" || theform.subject.value==\\\"\\\") {
  alert(\\\"{\$lang->items['LANG_CALENDAR_JS_ERROR3']}\\\");
  return false;
 }
 return messagetolong(theform);
}
\") : (\"\")
).\"

\".((\$filename==\"newthread.php\") 
? (\"
var postmaxchars = \$postmaxchars;
function validate(theform) {
 getAppletText(theform);
 if (theform.message.value==\\\"\\\" || theform.topic.value==\\\"\\\") {
  alert(\\\"{\$lang->items['LANG_POSTINGS_JS_ERROR1']}\\\");
  return false;
 }
 return messagetolong(theform);
}
\") : (\"\")
).\"

\".((\$filename==\"usercp.php\") 
? (\"
var postmaxchars = \$wbbuserdata[max_sig_length];
function validate(theform) {
 getAppletText(theform);
 return messagetolong(theform);
}
\") : (\"\")
).\"

\".((\$filename==\"pms.php\") 
? (\"
var postmaxchars = \$pmmaxchars;
function validate(theform) {
 getAppletText(theform);
 if ((theform.recipients.value==\\\"\\\" && theform.recipients_bcc.value==\\\"\\\") || theform.message.value==\\\"\\\" || theform.subject.value==\\\"\\\") {
  alert(\\\"{\$lang->items['LANG_POSTINGS_JS_ERROR3']}\\\");
  return false;
 }
 return messagetolong(theform);
}
\") : (\"\")
).\"

function checklength(theform) {
 if (postmaxchars != 0) message = \\\" {\$lang->items['LANG_POSTINGS_JS_MESSAGE_MAXLENGTH']}\\\";
 else message = \\\"\\\";
 
 var messageLength = getMessageLength(theform);
 alert(\\\"{\$lang->items['LANG_POSTINGS_JS_MESSAGE_CHECKLENGTH']}\\\" + message);
}

function messagetolong(theform) {
 	if (postmaxchars != 0) {
  		var messageLength = getMessageLength(theform);
  		if (messageLength > postmaxchars) {
   			alert(\\\"{\$lang->items['LANG_POSTINGS_JS_MESSAGE_TOLONG']}\\\");
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
				\".((\$wbbuserdata['usewysiwyg'] == 1) ? (\"
				posTop = getObjectPosTop(toggle) + toggle.offsetHeight + 10;
				\") : (\"
				posTop = getObjectPosTop(toggle) - element.offsetHeight - 10;
				\")).\"
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
	menuTimerRunning = setTimeout(\\\"toggleMenu();\\\", 500);
}

//-->
</script>

\".((\$wbbuserdata['usewysiwyg'] != 1) ? (\"
<script type=\\\"text/javascript\\\" src=\\\"js/bbcode.js\\\"></script>
\") : (\"\")).\"";
			?>