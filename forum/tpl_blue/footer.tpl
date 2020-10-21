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

</td>
</tr>
</table>