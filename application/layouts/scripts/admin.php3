<?php echo $this->doctype('XHTML1_TRANSITIONAL'); ?>
<html>
<head>
<?php $this->headTitle('Агротех Эксперт')->setSeparator(' | '); ?>
<?php $this->headScript()->appendFile("/js/prototype/prototype.js"); ?>
<?php $this->headScript()->appendFile("/js/scriptaculous/scriptaculous.js"); ?>
<?php $this->headScript()->appendFile("/cms/js/tiny_mce/tiny_mce.js"); ?>
<?php $this->headScript()->appendFile("/js/tiny_mce_init.js"); ?>
<?php $this->headScript()->appendFile("/js/JSCal2-1.9/src/js/jscal2.js"); ?>
<?php $this->headScript()->appendFile("/js/JSCal2-1.9/src/js/lang/ru2.js"); ?>
<?php $this->headScript()->appendFile("/js/project_js.js"); ?>
<?php $this->headScript()->appendFile("/js/lightbox2/js/lightbox.js"); ?>
<?php $this->headScript()->appendFile("/js/swfupload/swfupload.js"); ?>
<?php $this->headScript()->appendFile("/js/swfupload/js/swfupload.queue.js"); ?>
<?php $this->headScript()->appendFile("/js/swfupload/js/fileprogress.js"); ?>
<?php $this->headScript()->appendFile("/js/swfupload/js/handlers.js"); ?>
<?php $this->headLink()->appendStylesheet('/js/lightbox2/css/lightbox.css'); ?>
<?php $this->headLink()->appendStylesheet('/theme/css/admin.css'); ?>
<?php $this->headLink()->appendStylesheet('/js/JSCal2-1.9/src/css/light/light.css'); ?>
<?
	$this->headMeta()->appendName('keywords', 'OBS, optimal, shmaliy')
                     ->appendName('title', 'OBS')
                     ->appendName('description', 'OBS, description')
                     ->appendName('robots', 'index, follow')
                     ->appendName('revisit', 'after 1 days')
					 ->appendHttpEquiv('Content-Type', 'text/html; charset=windows-1251')
                     ->appendName('document-state', 'dynamic');					 					 					 		
?>
<?php echo $this->headMeta();?>
<?php echo $this->headTitle(); ?>
<?php echo $this->headScript(); ?>
<?php echo $this->headLink(); ?>
</head>
<body>
<?php if($_SESSION['cms']['authorized'] == 1): ?>	
	<div class="tooltips_container" id="tooltips" style="display:none;"></div>
	<div class="header">
	    <div class="header_resize">
	        <div class="logo"><a href="/"><img src="/theme/img/logo.png" /></a></div>
	        <div class="logo_text">продажа б/у сельхозтехники</div>
	        <div class="clear"></div>
	        <!--Главное меню new_menu.tpl -->
	        <div class="menu"><?php echo $this->action('index', 'admin', 'menu');?></div>
	        <div class="clear"></div>
	    </div>
	</div>
	<div class="body">
		<div class="push1"></div>
	    <?php echo $this->layout()->content;?>
	    <div class="push2"></div>    
	</div>
	
	<div class="footer">
		<div class="footer_resize">
	
	    </div>
	</div>
<?php else : ?>
	Вы не авторизованы.<br/>
	Авторизуйтесь в <a href="/cms" target="_blank">админпанели сайта</a>
<?php endif; ?>

</body>
</html>
<script>
		
	function tooltips(messages)
	{
		$("tooltips").update();
		$("tooltips").show();
		for (var i=0; i < messages.length; i++) {
			var message = 
				new Element('div', {'class':'tooltip'}).hide().insert(
					new Element('div', {'class':'text'}).insert(messages[i])
				);
			$("tooltips").insert(message.appear(1));
		}
		
	}

</script>