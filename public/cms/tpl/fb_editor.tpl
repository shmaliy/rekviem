					<table class="advanced" cellspacing="0" cellpadding="5">
						<tr>
							<td class="a1" nowrap="nowrap" rowspan="2"><img id="image" src="{#image#}" width="64" height="64" /></td>
							<td class="a3">Значок</td>
							<td class="a2"><input type="button" style="width:100%" value="Выбрать" onclick="call('core', '_upload', '{#name#}.image;image@&mode=square_fit&p1=64');" /></td>
						</tr>
						<tr>
							<td class="a2" colspan="2"><input type="text" class="text" name="image" value="{#imagepath#}" /></td>
						</tr>
					</table>
					<table class="advanced" cellspacing="0" cellpadding="5">
						<tr>
							<td class="a1">Папка</td>
							<td class="a2"><select name="fb_path" class="text" onChange="call('core', '_fb_ed_setpath', ['{#name#}', this.value]);">{#path#}</select></td>
							<td class="a3"><input type="button" class="w_75" value="обновить" onclick="call('core', '_fb_ed_updfolders', '{#name#}');" /></td>
						</tr>
					</table>
					<table class="advanced" cellspacing="0" cellpadding="5">
						<tr>
							<td class="a2" style="width:49%;"><select name="fb_files" class="w_125" size="10" multiple="multiple" onChange="image_editor.view('{#name#}', 'gallery');">{#files#}</select></td>
							<td class="a3">
								<input type="button" class="w_50" value="&gt;&gt;" onClick="image_editor.add('{#name#}');" /><br />
								<input type="button" class="w_50" value="&lt;&lt;" onClick="image_editor.del('{#name#}');" />
							</td>
							<td class="a1" style="width:49%;"><select name="images" class="w_125" size="10" multiple="multiple" onChange="image_editor.view('{#name#}', 'content');">{#images#}</select></td>
						</tr>
						<tr>
							<td class="a1" colspan="3">
								<input type="button" style="width:60px" value="&uarr;&uarr;&uarr;" onClick="image_editor.move('{#name#}', 'up');" />
								<input type="button" style="width:60px" value="&darr;&darr;&darr;" onClick="image_editor.move('{#name#}', 'down');" />
							</td>
						</tr>
					</table>
					<table class="advanced" cellspacing="0" cellpadding="5">
						<tr>
							<td class="a2" style="width:49%; text-align:center;">Галерея</td>
							<td class="a3"></td>
							<td class="a1" style="width:49%; text-align:center;">Контент</td>
						</tr>
						<tr>
							<td class="a2" style="width:49%; text-align:center;"><img id="fb_file" src="/cms/images/blank.png" width="94" height="94" /></td>
							<td class="a3"></td>
							<td class="a1" style="width:49%; text-align:center;"><img id="fb_image" src="/cms/images/blank.png" width="94" height="94" /></td>
						</tr>
					</table>
