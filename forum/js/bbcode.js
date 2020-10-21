var bbtags   = new Array();

// browser detection
var myAgent   = navigator.userAgent.toLowerCase();
var myVersion = parseInt(navigator.appVersion);
var is_ie   = ((myAgent.indexOf("msie") != -1)  && (myAgent.indexOf("opera") == -1));
var is_win   =  ((myAgent.indexOf("win")!=-1) || (myAgent.indexOf("16bit")!=-1));

function setmode(modeValue) {
 	document.cookie = "bbcodemode="+modeValue+"; path=/; expires=Wed, 1 Jan 2020 00:00:00 GMT;";
}

function normalMode(theForm) {
	if (theForm.mode[0].checked) {
		return true;
	}
	else {
		return false;
	}
}

function getArraySize(theArray) {
 	for (i = 0; i < theArray.length; i++) {
  		if ((theArray[i] == "undefined") || (theArray[i] == "") || (theArray[i] == null)) return i;
	}
 	
 	return theArray.length;
}

function pushArray(theArray, value) {
 	theArraySize = getArraySize(theArray);
 	theArray[theArraySize] = value;
}

function popArray(theArray) {
	theArraySize = getArraySize(theArray);
 	retVal = theArray[theArraySize - 1];
 	delete theArray[theArraySize - 1];
 	return retVal;
}


function smilie(theSmilie) {
	addText(" " + theSmilie, "", false, document.bbform);
}

function closetag(theForm) {
 	if (!normalMode(theForm)) {
  		if (bbtags[0]) addText("[/"+ popArray(bbtags) +"]", "", false, theForm);
  	}
 	
 	setFocus(theForm);
}

function closeall(theForm) {
 	if (!normalMode(theForm)) {
  		if (bbtags[0]) {
   			while (bbtags[0]) {
    				addText("[/"+ popArray(bbtags) +"]", "", false, theForm);
   			}
   		}
 	}
 	
 	setFocus(theForm);
}


function fontformat(theForm,theValue,theType) {
 	setFocus(theForm);
 
 	if (normalMode(theForm)) {
  		if (theValue != 0) {
   
   			var selectedText = getSelectedText(theForm);
   			var insertText = prompt(font_formatter_prompt+" "+theType, selectedText);
   			if ((insertText != null) && (insertText != "")) {
    				addText("["+theType+"="+theValue+"]"+insertText+"[/"+theType+"]", "", false, theForm);
    			}
  		}
 	}
 	else {
		if(addText("["+theType+"="+theValue+"]", "[/"+theType+"]", true, theForm)) {
			pushArray(bbtags, theType);	
		}
	}
 
 	theForm.sizeselect.selectedIndex = 0;
 	theForm.fontselect.selectedIndex = 0;
 	theForm.colorselect.selectedIndex = 0;
 	
 	setFocus(theForm);
}


function bbcode(theForm, theTag, promptText) {
	if ( normalMode(theForm) || (theTag=="IMG")) {
		var selectedText = getSelectedText(theForm);
		if (promptText == '' || selectedText != '') promptText = selectedText;
		
		inserttext = prompt(((theTag == "IMG") ? (img_prompt) : (tag_prompt)) + "\n[" + theTag + "]xxx[/" + theTag + "]", promptText);
		if ( (inserttext != null) && (inserttext != "") ) {
			addText("[" + theTag + "]" + inserttext + "[/" + theTag + "]", "", false, theForm);
		}
	}
	else {
		var donotinsert = false;
  		for (i = 0; i < bbtags.length; i++) {
   			if (bbtags[i] == theTag) donotinsert = true;
  		}
  		
  		if (!donotinsert) {
   			if(addText("[" + theTag + "]", "[/" + theTag + "]", true, theForm)){
				pushArray(bbtags, theTag);
			}
  		}
		else {
			var lastindex = 0;
			
			for (i = 0 ; i < bbtags.length; i++ ) {
				if ( bbtags[i] == theTag ) {
					lastindex = i;
				}
			}
			
			while (bbtags[lastindex]) {
				tagRemove = popArray(bbtags);
				addText("[/" + tagRemove + "]", "", false, theForm);
			}
		}
	}
}

function namedlink(theForm,theType) {
	var selected = getSelectedText(theForm);
 
	var linkText = prompt(link_text_prompt,selected);
	var prompttext;
 
	if (theType == "URL") {
 		prompt_text = link_url_prompt;
 		prompt_contents = "http://";
	}
	else {
		prompt_text = link_email_prompt;
		prompt_contents = "";
		}
 
	linkURL = prompt(prompt_text,prompt_contents);
 
 
	if ((linkURL != null) && (linkURL != "")) {
		var theText = '';
		
		if ((linkText != null) && (linkText != "")) {
   			theText = "["+theType+"="+linkURL+"]"+linkText+"[/"+theType+"]";
   		}
		else {
			theText = "["+theType+"]"+linkURL+"[/"+theType+"]";
		}
  		
  		addText(theText, "", false, theForm);
 	}
}


function dolist(theForm) {
 	listType = prompt(list_type_prompt, "");
 	if ((listType == "a") || (listType == "1")) {
  		theList = "[list="+listType+"]\n";
  		listEend = "[/list="+listType+"] ";
 	}
 	else {
  		theList = "[list]\n";
  		listEend = "[/list] ";
 	}
 	
 	listEntry = "initial";
 	while ((listEntry != "") && (listEntry != null)) {
  		listEntry = prompt(list_item_prompt, "");
  		if ((listEntry != "") && (listEntry != null)) theList = theList+"[*]"+listEntry+"\n";
 	}
 	
 	addText(theList + listEend, "", false, theForm);
}


function addText(theTag, theClsTag, isSingle, theForm)
{
	var isClose = false;
	var message = theForm.message;
	var set=false;
  	var old=false;
  	var selected="";
  	
  	if(message.textLength>=0 ) { // mozilla, firebird, netscape
  		if(theClsTag!="" && message.selectionStart!=message.selectionEnd) {
  			selected=message.value.substring(message.selectionStart,message.selectionEnd);
  			str=theTag + selected+ theClsTag;
  			old=true;
  			isClose = true;
  		}
		else {
			str=theTag;
		}
		
		message.focus();
		start=message.selectionStart;
		end=message.textLength;
		endtext=message.value.substring(message.selectionEnd,end);
		starttext=message.value.substring(0,start);
		message.value=starttext + str + endtext;
		message.selectionStart=start;
		message.selectionEnd=start;
		
		message.selectionStart = message.selectionStart + str.length;
		
		if(old) { return false; }
		
		set=true;
		
		if(isSingle) {
			isClose = false;
		}
	}
	if ( (myVersion >= 4) && is_ie && is_win) {  // Internet Explorer
		if(message.isTextEdit) {
			message.focus();
			var sel = document.selection;
			var rng = sel.createRange();
			rng.colapse;
			if((sel.type == "Text" || sel.type == "None") && rng != null){
				if(theClsTag != "" && rng.text.length > 0)
					theTag += rng.text + theClsTag;
				else if(isSingle)
					isClose = true;
	
				rng.text = theTag;
			}
		}
		else{
			if(isSingle) isClose = true;
	
			if(!set) {
      				message.value += theTag;
      			}
		}
	}
	else
	{
		if(isSingle) isClose = true;

		if(!set) {
      			message.value += theTag;
      		}
	}

	message.focus();
	
	return isClose;
}	


function getSelectedText(theForm) {
	var message = theForm.message;
	var selected = '';
	
	if(navigator.appName=="Netscape" &&  message.textLength>=0 && message.selectionStart!=message.selectionEnd ) 
  		selected=message.value.substring(message.selectionStart,message.selectionEnd);	
  	
	else if( (myVersion >= 4) && is_ie && is_win ) {
		if(message.isTextEdit){ 
			message.focus();
			var sel = document.selection;
			var rng = sel.createRange();
			rng.colapse;
			
			if((sel.type == "Text" || sel.type == "None") && rng != null){
				if(rng.text.length > 0) selected = rng.text;
			}
		}	
	}
		 
  	return selected;
}

function setFocus(theForm) {
 	theForm.message.focus();
}