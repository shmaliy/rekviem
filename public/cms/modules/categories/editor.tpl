<div class="editor_wrapper">
	<form name="{#name#}" method="post" action="#">
	<input type="hidden" name="db_id" value="{#id#}">
	<table class="editor" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td>
				<table class="e_left" width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td width="1%">Категория</td>
						<td><select name="category" class="text">{#tree#}</select></td>
					</tr>
					<tr>
						<td class="a">Заголовок</td>
						<td class="b"><input type="text" class="text" name="title" value="{#title#}" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap">Псевдоним</td>
						<td class="b"><input type="text" class="text" name="title_alias" value="{#alias#}" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap">Опубликовано</td>
						<td><input type="checkbox" name="published" {#published#} /></td>
					</tr>
					<tr>
						<td colspan="2"><br />Описание [необязятельно]</td>
					</tr>
					<tr>
						<td colspan="2"><textarea name="description">{#desc#}</textarea>{#adv_bottom#}</td>
					</tr>
				</table>
			</td>
			<td width="400" style="padding:10px;">
				<div class="tabs_btn" id="tabs_btn">
					<a href="javascript:tabs('tabs', 0)" class="selected"><span>Картинки</span></a>
					<a href="javascript:tabs('tabs', 1)"><span>Дополнительно</span></a>
					<div class="clr"></div>
				</div>
				<div id="tabs">
					<div class="tab" style="display:block;">
						{#image_editor#}
					</div>
					<div class="tab">
						<table class="advanced" cellspacing="0" cellpadding="5">
							{#adv_right#}
						</table>
					</div>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>
<div class="clr"></div>
