<form name="{#name#}" method="post" action="#">
<tr>
	<td>{#refn#}<input name="{#name#}_db_id" type="hidden" value="{#id#}" /></td>
	<td><input name="{#name#}_title" type="text" value="{#title#}" /></td>
	<td><input name="{#name#}_in_list" type="checkbox" {#in_list#}/></td>
	<td><select name="{#name#}_type">{#type#}</select></td>
	<td><select name="{#name#}_src" onchange="call('params', 'srcv_upd', ['{#ni#}','{#nr#}',this.value]);">{#src#}</select></td>
	<td id="{#name#}_srcv"><select name="{#name#}_srcv">{#srcv#}</select></td>
	<td><a href="javascript:call('params','_save_p',[getform('{#name#}'),{#ni#},'{#nr#}']);"><img src="{#basedir#}/images/save.png" /></a></td>
</tr>
</form>