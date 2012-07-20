<div class="authoriz">
	<form name="auth" method="post" action="javascript:call('core', 'authorization', getform('auth'));">
		<input name="login" type="text" />Логин<br /><br />
		<input name="password" type="password" />Пароль<br /><br />
		<input class="btn" type="image" src="{#basedir#}/images/button_enter.png" /><br /><br />
	</form>
	<div id="auth_stat">&nbsp;</div>
</div>