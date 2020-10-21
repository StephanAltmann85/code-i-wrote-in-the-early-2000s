var saveval="";
IE4 = (document.all) ? 1 : 0;
  
  function delTemplate() {
   if(document.tform.templateid.selectedIndex!=-1) window.location=('template.php?action=del&templateid='+document.tform.templateid.options[document.tform.templateid.selectedIndex].value+'&sid='+sessionhash);
  }
  
  function addTemplate() {
   window.location=('template.php?action=add&templatepackid='+document.tform.templatepackid.options[document.tform.templatepackid.selectedIndex].value+'&sid='+sessionhash);
  }
  
  function editTemplate() {
   if(document.tform.templateid.selectedIndex!=-1) window.location=('template.php?action=edit&templateid='+document.tform.templateid.options[document.tform.templateid.selectedIndex].value+'&sid='+sessionhash);
  }
  
  function copyTemplate() {
   if(document.tform.templateid.selectedIndex!=-1) window.location=('template.php?action=copy&templateid='+document.tform.templateid.options[document.tform.templateid.selectedIndex].value+'&sid='+sessionhash);
  }
  
  function quick_search(theform,search) {
   search = search.toLowerCase();
   if(IE4) keycode=window.event.keyCode;
   else keycode=0;
   if(search!='' && search!=saveval && keycode!=8 && keycode!=46) {
    save=Array();
    count=0;
    for(i=0;i<theform.templateid.options.length;i++) {
     if(theform.templateid.options[i].text.substr(0,search.length).toLowerCase()==search) {
      if(count==0) theform.templateid.options[i].selected=true;
      save[count]=theform.templateid.options[i].text.toLowerCase();
      count++;
     } 
    }
    saveval=search;
    if(IE4 && save.length!=0) shell(save);
   }
  }
  
function shell(save) {
	var temp = save[0];
	var z = temp.length;
	for (var i = 1; i < save.length; i++) {
		while (z > 0) {
			if (temp.substr(0, z) == save[i].substr(0, z)) break;
			else z--;
		}
		if (z <= 1) break;
	}
   	
   	
   	var oldlength = document.tform.quicksearch.value.length;
   	saveval = temp.substr(0, z);
   	
   	document.tform.quicksearch.value = saveval;
   	document.tform.quicksearch.select();
   	
   	if (document.selection != null) {
   		var objRange = document.selection.createRange();
   		objRange.moveStart("character", oldlength);
   		objRange.select();
   	}
}