<div class="editor_wrapper">
	<form name="{#name#}" method="post" action="#">
	<input type="hidden" name="db_id" value="{#id#}">
	<table class="editor" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td>
				<table class="e_left" width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td width="1%">Родитель</td>
						<td colspan="3"><select name="category" class="text">{#tree#}</select></td>
					</tr>
					<tr>
						<td class="a">Заголовок</td>
						<td colspan="3" class="b"><input type="text" class="text" name="title" value="{#title#}" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap">Псевдоним</td>
						<td colspan="3" class="b"><input type="text" class="text" name="title_alias" value="{#alias#}" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap">Ссылка</td>
						<td colspan="3" class="b"><input type="text" class="text" name="link" value="{#link#}" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap">Опубликовано</td>
						<td width="1%"><input type="checkbox" name="published" {#published#} /></td>
						<td width="1%">Навигация </td>
						<td><select name="browser_nav" class="text">{#browser_nav#}</select></td>
					</tr>
				</table>
			</td>
			<td width="350" style="padding:10px;">
				<table class="advanced" cellspacing="0" cellpadding="5">
					<tr>
						<td class="a1" nowrap="nowrap" rowspan="2"><img id="image" src="{#image#}" width="96" height="96" /></td>
						<td class="a3">Значок</td>
						<td class="a2"><input type="button" style="width:100%" value="Выбрать" onclick="call('core', '_upload', '{#name#}.image;image@&mode=square_fit&p1=96');" /></td>
					</tr>
					<tr>
						<td class="a2" colspan="2"><input type="text" class="text" name="image" value="{#imagepath#}" /></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</form>
</div>
<div class="clr"></div>
