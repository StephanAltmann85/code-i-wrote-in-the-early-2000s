// Title: Tigra Tree
// Description: See the demo at url
// URL: http://www.softcomplex.com/products/tigra_menu_tree/
// Version: 1.1
// Date: 11-12-2002 (mm-dd-yyyy)
// Contact: feedback@softcomplex.com (specify product title in the subject)
// Notes: This script is free. Visit official site for further details.

var board_nodes		= new Array();

function tree (a_items, a_template) {

	this.a_tpl      = a_template;
	this.a_config   = a_items;
	this.o_root     = this;
	this.a_index    = [];
	this.o_selected = null;
	this.n_depth    = -1;
	
	var o_icone = new Image(),
		o_iconl = new Image();
	o_icone.src = a_template['icon_e'];
	o_iconl.src = a_template['icon_l'];
	a_template['im_e'] = o_icone;
	a_template['im_l'] = o_iconl;
	for (var i = 0; i < 64; i++)
		if (a_template['icon_' + i]) {
			var o_icon = new Image();
			a_template['im_' + i] = o_icon;
			o_icon.src = a_template['icon_' + i];
		}
	
	this.toggle = function (n_id) {	var o_item = this.a_index[n_id]; o_item.open(o_item.b_opened) };
	this.select = function (n_id) { return this.a_index[n_id].select(); };
	
	this.a_children = [];
	for (var i = 0; i < a_items.length; i++)
		new tree_item(this, i);

	this.n_id = trees.length;
	trees[this.n_id] = this;
	
	for (var i = 0; i < this.a_children.length; i++) {
		document.write(this.a_children[i].init());
		this.a_children[i].open();
	}
	
	for(i = 0; i < board_nodes.length; i++) trees[0].toggle(board_nodes[i]);
	
	
}
function tree_item (o_parent, n_order) {

	this.n_depth  = o_parent.n_depth + 1;
	this.a_config = o_parent.a_config[n_order + (this.n_depth ? 2 : 0)];
	if (!this.a_config || !this.a_config[0]) return;

	this.o_root    = o_parent.o_root;
	this.o_parent  = o_parent;
	this.n_order   = n_order;
	this.b_opened  = !this.n_depth;

	this.n_id = this.o_root.a_index.length;
	this.o_root.a_index[this.n_id] = this;
	o_parent.a_children[n_order] = this;

	this.a_children = [];
	for (var i = 0; i < this.a_config.length - 2; i++)
		new tree_item(this, i);

	this.get_icon = item_get_icon;
	this.get_data = item_get_data;
	this.open     = item_open;
	this.select   = item_select;
	this.init     = item_init;
	this.is_last  = function () { return this.n_order == this.o_parent.a_children.length - 1 };
}

function item_open (b_close) {
	var o_idiv = get_element('i_div' + this.o_root.n_id + '_' + this.n_id);
	//if (!o_idiv) return;
	if(!this.n_depth && b_close) return;
	
	if (o_idiv && !o_idiv.innerHTML) {
		if(this.a_children.length)
		{
			var a_children = [];
			for (var i = 0; i < this.a_children.length; i++) {
				if(this.a_children[i]) a_children[i]= this.a_children[i].init();
			}
			o_idiv.innerHTML = a_children.join('');
		}
	}
	if(o_idiv) o_idiv.style.display = (b_close ? 'none' : 'block');
	
	this.b_opened = !b_close;
	var o_jicon = document.images['j_img' + this.o_root.n_id + '_' + this.n_id],
		o_iicon = document.images['i_img' + this.o_root.n_id + '_' + this.n_id];
	if (o_jicon) o_jicon.src = this.get_icon(true);
	if (o_iicon) o_iicon.src = this.get_icon();
}

function item_select (b_deselect) {
	if (!b_deselect) {
		var o_olditem = this.o_root.o_selected;
		this.o_root.o_selected = this;
		if (o_olditem) o_olditem.select(true);
	}
	var o_iicon = document.images['i_img' + this.o_root.n_id + '_' + this.n_id];
	if (o_iicon) o_iicon.src = this.get_icon();
	get_element('i_txt' + this.o_root.n_id + '_' + this.n_id).style.fontWeight = b_deselect ? 'normal' : 'bold';
	
	return Boolean(this.a_config[0]);
}

function item_init () {
	var a_offset = [],
		o_current_item = this.o_parent;
	for (var i = this.n_depth; i > 1; i--) {
		a_offset[i] = '<img src="' + this.o_root.a_tpl[o_current_item.is_last() ? 'icon_e' : 'icon_l'] + '" border="0" align="absbottom">';
		o_current_item = o_current_item.o_parent;
	}
	
	if(this.a_config.length < 2) return '';
		
	for(var j = 0; j < this.a_config.length; j++) if(this.a_config[j]=='|') return '';
	
	return '<table cellpadding="0" cellspacing="0" border="0"><tr><td nowrap>' + (this.n_depth ? a_offset.join('') + (this.a_children.length
		? '<a href="javascript: trees[' + this.o_root.n_id + '].toggle(' + this.n_id + ')"><img src="' + this.get_icon(true) + '" border="0" align="absbottom" name="j_img' + this.o_root.n_id + '_' + this.n_id + '"></a>'
		: '<img src="' + this.get_icon(true) + '" border="0" align="absbottom">') : '') 
		+ '' + this.get_data() + '</td></tr></table>' + (this.a_children.length ? '<div id="i_div' + this.o_root.n_id + '_' + this.n_id + '" style="display:none"></div>' : '');
}

function item_get_icon (b_junction) {
	// is root folder
	if(!this.n_depth) return this.o_root.a_tpl['icon_48'];
	
	// is "some other icon" :P
	if(b_junction)
	{
		// has children
		if(this.a_children.length)
		{
			// is open
			if(this.b_opened)
			{
				if(this.is_last()) return this.o_root.a_tpl['icon_27'];
				else return this.o_root.a_tpl['icon_26'];
			}
			// is closed
			{
				if(this.is_last()) return this.o_root.a_tpl['icon_19'];
				else return this.o_root.a_tpl['icon_18'];
			}
		}
		// has no children
		else
		{
			// is last
			if(this.is_last()) return this.o_root.a_tpl['icon_3'];
			// is closed
			else return this.o_root.a_tpl['icon_2'];
		}
	}
	
	// is folder or document
	else
	{
		// is document
		if(!this.a_children.length)
		{
			return this.o_root.a_tpl['icon_0'];
		}
		// is folder
		else
		{
			// opened
			if(this.b_opened) return this.o_root.a_tpl['icon_20'];
			else return this.o_root.a_tpl['icon_16'];
			
		}
	}
}


function item_get_data() {
 // top
 if(this.a_config[1]=='0') return get_img_tag("home") + this.a_config[0];
 
 // board
 else if(this.a_config[1]=='1') {
  node_data = this.a_config[2].split("|");
  
  if(node_data[3]==1) board_nodes[board_nodes.length] = this.n_id;
  
  options_code = "";
  
  for(i=1;i<=node_data[1];i++) {
   options_code += "<option value=\"" + i + "\"" + ((i==node_data[2]) ? (" selected=\"selected\"") : ("")) + ">" + i + "</option>";	
  }
 	
  return get_img_tag("forum") + "<select name=\"boardorder[" + node_data[0] + "]\">" + options_code + "</select> <b>" + this.a_config[0] + "</b> <span class=\"small\"><a href=\"board.php?action=edit&amp;boardid=" + node_data[0] + "&amp;sid=" + session_hash + "\">[" + lang_var_edit + "]</a> <a href=\"board.php?action=del&amp;boardid=" + node_data[0] + "&amp;sid=" + session_hash + "\">[" + lang_var_del + "]</a> <a href=\"board.php?action=empty&amp;boardid=" + node_data[0] + "&amp;sid=" + session_hash + "\">[" + lang_var_empty + "]</a> <a href=\"board.php?action=addmoderator&amp;boardid=" + node_data[0] + "&amp;sid=" + session_hash + "\">[" + lang_var_moderator_add + "]</a></span>";
 }
 	
 // moderators
 if(this.a_config[1]=='2') return get_img_tag("moderators") + "<i>" + this.a_config[0] + "</i>";
 
 // moderator
 if(this.a_config[1]=='3') {
  node_data = this.a_config[2].split("|");
  
  return get_img_tag("moderator") + this.a_config[0] + " <span class=\"small\"><a href=\"board.php?action=editmoderator&amp;boardid=" + node_data[0] + "&amp;userid=" + node_data[1] + "&amp;sid=" + session_hash + "\">[" + lang_var_edit + "]</a> <a href=\"board.php?action=delmoderator&amp;boardid=" + node_data[0] + "&amp;userid=" + node_data[1] + "&amp;sid=" + session_hash + "\">[" + lang_var_del + "]</a></span>";
 }
 
 // permissions
 if(this.a_config[1]=='4') return get_img_tag("permissions") + "<i>" + this.a_config[0] + "</i>";
  
 // usergroup
 if(this.a_config[1]=='5') {
  node_data = this.a_config[2].split("|");
  
  if(node_data[2]==0) color = "#ff0000";
  if(node_data[2]==1) color = "#0000ff";
  if(node_data[2]==2) color = "#999999";
  
  return get_img_tag("usergroup") + "<span style=\"color: " + color + "\">" + this.a_config[0] + "</span> <span class=\"small\"><a href=\"board.php?action=permissions&amp;boardid=" + node_data[0] + "&amp;groupid=" + node_data[1] + "&amp;sid=" + session_hash + "\">[" + lang_var_edit + "]</a></span>";
 }
 
 // permissions
 if(this.a_config[1]=='6') return get_img_tag("useraccess") + "<i>" + this.a_config[0] + "</i>";
  
 // user access
 if(this.a_config[1]=='7') {
  node_data = this.a_config[2].split("|");
  
  if(node_data[2]==0) color = "#ff0000";
  if(node_data[2]==1) color = "#0000ff";
  
  return get_img_tag("user") + "<span style=\"color: " + color + "\">" + this.a_config[0] + "</span> <span class=\"small\"><a href=\"users.php?action=access&amp;userids=" + node_data[1] + "&amp;boardid=" + node_data[0] + "&amp;sid=" + session_hash + "\">[" + lang_var_edit + "]</a></span>";
 }
}

function get_img_tag(icon) {
 return "<img src=\"images/tree/" + icon + ".gif\" alt=\"\" border=\"0\" align=\"absbottom\" />";	
}



var trees = [];
get_element = document.all ?
	function (s_id) { return document.all[s_id] } :
	function (s_id) { return document.getElementById(s_id) };









var tree_tpl = {
	'target'  : 'main',	// name of the frame links will be opened in
							// other possible values are: _blank, _parent, _search, _self and _top

	'icon_e'  : 'images/tree/empty.gif', // empty image
	'icon_l'  : 'images/tree/line.gif',  // vertical line
	
	'icon_2'  : 'images/tree/joinbottom.gif', // junction for leaf
	'icon_3'  : 'images/tree/join.gif',       // junction for last leaf
	'icon_18' : 'images/tree/plusbottom.gif', // junction for closed node
	'icon_19' : 'images/tree/plus.gif',       // junctioin for last closed node
	'icon_26' : 'images/tree/minusbottom.gif',// junction for opened node
	'icon_27' : 'images/tree/minus.gif'       // junctioin for last opended node
};