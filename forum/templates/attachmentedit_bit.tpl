  <tr>
   <td class="tablea" align="left" style="width: 100%;">
   <img src="{$style['imagefolder']}/filetypes/$extensionimage.gif" border="0" alt="$extensionimage" />
   <span class="normalfont">$row[attachmentname].$row[attachmentextension]</span> <span class="smallfont">$LANG_MISC_ATTACHMENT_INFO</span></td>
   <td class="tableb" align="right"><input type="submit" name="delid_{$row['attachmentid']}" class="input" value="{$lang->items['LANG_MISC_ATTACHMENT_DELETE']}" /></td>
  </tr>