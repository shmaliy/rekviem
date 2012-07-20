<div class="list">
	<div class="table_filter">
		<div class="filter_left">Меню <select id="category" onchange="call('{#name#}', '_setf', this.value)">{#tree#}</select></div>
	</div>
	<table class="ctable" cellspacing="1">
		<thead>
			<tr>
				<th>ID</th>
				<th>&nbsp;</th>
				<th class="title">Заголовок</th>
				<th>Родитель</th>
				<th>Ссылка</th>
				<th>Опубликовано</th>
				<th>Порядок</th>
				<th><img src="{#basedir#}/images/adm/filesave.png" onclick="call('{#name#}', '_reorder', ['total', getorder('ctable_contents')])" style="cursor:pointer;" /></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th colspan="20"><span id="navigator">{#navigator#}</span></th>
			</tr>
		</tfoot>
		<tbody id="ctable_contents">
			{#items#}
		</tbody>
	</table>
</div>
