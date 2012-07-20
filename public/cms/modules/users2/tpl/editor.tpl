<div class="editor_wrapper">
	<form name="{#name#}" method="post" action="#">
	<input type="hidden" name="db_id" value="{#id#}">
	<table class="editor" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td>
				<table class="e_left" width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td width="1%">Категория</td>
						<td><select name="usertype" class="text">{#usertype#}</select></td>
					</tr>
					<tr>
						<td class="a">Имя</td>
						<td class="b"><input name="username" type="text" class="text" value="{#username#}" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap">Логин</td>
						<td class="b"><input name="login" type="text" class="text" value="{#login#}" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap">E-mail</td>
						<td class="b"><input name="email" type="text" class="text" value="{#email#}" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap">Заблокирован</td>
						<td><input type="checkbox" name="block" {#block#}/></td>
					</tr>
					<tr>
						<td nowrap="nowrap">{#p#}ароль</td>
						<td class="b"><input name="password" type="password" class="text" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap">Повторите пароль</td>
						<td class="b"><input name="password2" type="password" class="text" /></td>
					</tr>
				</table>
			</td>
			<td width="400" style="padding:10px;">
				<div class="tabs_btn" id="tabs_btn">
					<a href="javascript:tabs('tabs', 0)" class="selected"><span>Фотография</span></a>
					<a href="javascript:tabs('tabs', 1)"><span>Дополнительно</span></a>
					<div class="clr"></div>
				</div>
				<div id="tabs">
					<div class="tab" style="display:block;">
						<table class="advanced" cellspacing="0" cellpadding="5">
							<tr>
								<td class="a1" nowrap="nowrap" rowspan="2"><img id="image" src="{#image#}" width="100" height="100" /></td>
								<td class="a2" colspan="2"><input type="button" style="width:100%" value="Выбрать" onclick="call('core', '_upload', '{#name#}.image;image@&mode=square_fit&p1=100');" /></td>
							</tr>
							<tr>
								<td class="a2" colspan="2"><input type="text" class="text" name="image" value="{#imagepath#}" /></td>
							</tr>
						</table>
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
