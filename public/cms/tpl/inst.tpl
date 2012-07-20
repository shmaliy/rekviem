<div class="install">
	<form name="inst" method="post" action="javascript:call('core', 'installation', getform('inst'));">
		<input name="dbhost" type="text" />Хост<br /><br />
		<input name="dbuser" type="text" />Пользователь БД<br /><br />
		<input name="dbpassword" type="password" />Пароль БД<br /><br />
		<input name="dbname" type="text" />Имя БД<br /><br />
		<input name="dbprefix" type="text" />Префикс таблиц<br /><br />
		<input name="login" type="text" />Логин администратора<br /><br />
		<input name="password" type="password" />Пароль администратора<br /><br />
		<input name="email" type="text" />E-mail администратора<br /><br />
		<input class="btn" type="image" src="{#basedir#}/images/button_install.png" /><br /><br />
	</form>
	<div id="inst_stat">&nbsp;</div>
</div>