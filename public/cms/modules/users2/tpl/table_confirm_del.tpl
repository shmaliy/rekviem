<div class="confirm_list">
	<table class="ctable" cellspacing="1">
		<thead>
			<tr>
				<th>ID</th>
				<th class="title">Заголовок</th>
			</tr>
		</thead>
		<tbody>
			{#items#}
		</tbody>
	</table>
	<div class="buttons">
		<input type="button" value="Да" onclick="call('{#name#}', '_delete', ['del', getcheckbox('ctable_contents')])">
		<input type="button" value="Нет" onclick="modal.hide();">
	</div>
</div>
