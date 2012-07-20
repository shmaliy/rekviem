<tr>
	<td class="a1" nowrap="nowrap">{#param_title#}</td>
	<td class="a2">
		<input type="hidden" name="{#param_name#}" value="{#param_val#}" /-->
		<input type="button" style="width:100%" value="Выбрать" onclick="call('params', 'popup', ['{#name#}','{#param_name#}',gethiddenparam(document.forms.{#name#}.{#param_name#}.value)]);" />
	</td>
</tr>
