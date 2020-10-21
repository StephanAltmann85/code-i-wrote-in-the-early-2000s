<br />

<if($imprint_url != '')>
	<then>
		<p align="center" class="normalfont"><a href="{$imprint_url}">{$lang->items['LANG_GLOBAL_IMPRINT']}</a></p>
	</then>
	<else>
		<if($imprint_text != '')>
			<then>
				<p align="center" class="normalfont"><a href="misc.php?action=imprint{$SID_ARG_2ND}">{$lang->items['LANG_GLOBAL_IMPRINT']}</a></p>
			</then>
		</if>
	</else>
</if>

<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" class="tableinborder" align="center">
 <tr>
  <td class="tablea"><span class="smallfont"><a href="http://www.woltlab.de" target="_blank" style="text-decoration: none">{$lang->items['LANG_GLOBAL_COPYRIGHT']}</a></span></td>
 </tr>
</table><br />
</td>
</tr>
</table>