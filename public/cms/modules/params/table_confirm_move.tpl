<div class="confirm_list">
	<div class="table_filter">
		<div class="filter_left">Категория <select id="category">{#tree#}</select></div>
	</div>
	<table class="ctable" cellspacing="1">
		<thead>
			<tr>
				<th>ID</th>
				<th class="title">Заголовок</th>
				<th>Файл</th>
				<th>Альбом</th>
			</tr>
		</thead>
		<tbody>
			{#items#}
		</tbody>
	</table>
	<div class="buttons">
		<input type="button" value="Да" onclick="call('{#name#}', '_move', [document.getElementById('category').value, getcheckbox('ctable_contents')])">
		<input type="button" value="Нет" onclick="modal.hide();">
	</div>
</div>
