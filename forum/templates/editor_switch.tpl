<if($wbbuserdata['usewysiwyg'] == 1)><then>
<input type="button" value="{$lang->items['LANG_POSTINGS_CHANGE_EDITOR_NORMAL']}" class="input" onclick="changeEditor(document.bbform, -1);" />
</then><else>
<input type="button" value="{$lang->items['LANG_POSTINGS_CHANGE_EDITOR_WYSIWYG']}" class="input" onclick="changeEditor(document.bbform, 1);" />
</else></if>