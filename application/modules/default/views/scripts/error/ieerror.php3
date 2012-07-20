<?php echo $this->doctype('XHTML1_TRANSITIONAL'); ?>
<html>
<head>
<?php echo $this->headLink()->appendStylesheet('/theme/css/iestop.css'); ?>
</head>
<body>
<div class="iestopper">
	<div class="container">
		<h1>Ваш браузер не может отобразить этот сайт!</h1>
		<div class="text">На сайте <?php echo $this->sitetitle; ?> используются современные веб-технологии, которые не могут быть корректно обработаны вашим устаревшим браузером. 
Пожалуйста, обновите его или выберете другой:
		</div>
		<div class="links">
			<a class="mozilla" href="http://mozilla.ru/" title="Самый популярный браузер в мире"><span>Mozilla Firefox</span></a>
			<a class="crome" href="http://www.google.ru/chrome/intl/ru/features.html" title="Самый быстрый и удобный браузер"><span>Google Ghrome</span></a>
			<a class="ie" href="http://www.microsoft.com/windows/Internet-explorer/default.aspx" title="Новая версия самого медленного браузера в мире"><span>Internet Explorer 8</span></a>
			<a class="opera" href="http://www.opera.com/" title="Самый популярный браузер в России"><span>Opera</span></a>
			<div class="clear"></div>
		</div>
	</div>
</div>
</body>
</html>