<?php echo $this->doctype('XHTML1_TRANSITIONAL'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->headTitle('Служба ритуальных услуг «Реквием»')->setSeparator(' | '); ?>
<?php $this->headScript()->appendFile("/js/prototype/prototype.js"); ?>
<?php $this->headScript()->appendFile("/js/scriptaculous/scriptaculous.js"); ?>
<?php //$this->headScript()->appendFile("/cms/js/tiny_mce/tiny_mce.js"); ?>
<?php //$this->headScript()->appendFile("/js/tiny_mce_init.js"); ?>
<?php $this->headScript()->appendFile("/js/swfupload/swfupload.js"); ?>
<?php $this->headScript()->appendFile("/js/swfupload/js/swfupload.queue.js"); ?>
<?php $this->headScript()->appendFile("/js/swfupload/js/fileprogress.js"); ?>
<?php $this->headScript()->appendFile("/js/swfupload/js/handlers.js"); ?>
<?php $this->headScript()->appendFile("/js/script.js"); ?>
<?php $this->headScript()->appendFile("/js/imageFader.js"); ?>
<?php //$this->headScript()->appendFile("/js/swfobject/swfobject.js"); ?>
<?php $this->headScript()->appendFile("/js/lightbox2/js/lightbox.js"); ?>
<?php $this->headScript()->appendFile("/js/Prototype.UI.Accordion.js"); ?>
<?php $this->headLink()->appendStylesheet('/js/lightbox2/css/lightbox.css'); ?>
<?php $this->headLink()->appendStylesheet('/theme/css/style.css')
					   ->appendStylesheet('/theme/css/swf.css')
					   ->headLink(array('rel' => 'favicon', 'href' => '/favicon.ico'), 'PREPEND'); ?>
<?
	$this->headMeta()->appendName('keywords', 'ритуальные услуги, ритуальные услуги днепропетровск, кремация, оформление документов на кремацию, документы на захоронение, бригада, копачи, гроб, гробы, гробы деревянные, первая социальная ритуальная служба, ритуальное бюро, похоронное бюро, похоронка, ритуальное обслуживание, венки, катафалк, похороны, VIP похороны, VIP катафалк, VIP ритуальные услуги, памятники, гранит, мраморная крошка, мемориальные комплексы, лавочка, оградка, уход за могилами днепропетровск, озеленение могил, крест, крест временный,... катафалк, автобус, крест деревянный временный, доставка товара, доставка венков, доставка корзин, перевозка тела, перевозка умершего, перевозка усопшего, транспортировка усопшего, транспортировка трупа, транспортировка умершего, транспортировка за границу, транспортировка тела за границу, транспортировка трупа за границу, транспортировка тела зарубеж, груз 200, омовение, отпевание, батюшка, снос тела, перенос тела, услуги морга, перевозка в морг, морг, бальзамирование, бальзамация, кремирование, кремация')
                     ->appendName('description', '')
                     ->appendName('robots', 'index, follow')
                     ->appendName('revisit', 'after 1 days')
					 ->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8')
                     ->appendName('document-state', 'dynamic');					 					 					 		
?>
<?php echo $this->headMeta();?>
<?php echo $this->headTitle(); ?>
<?php echo $this->headScript(); ?>
<?php echo $this->headLink(); ?>

<script type="text/javascript">
 
	/*var flashvars = {};

	var params = {};
	params.menu = "false";
	params.wmode = "opaque";
	params.quality = "high";
	 
	var attributes = {};
	attributes.id = "logo";
	attributes.name = "logo";
	 
	swfobject.embedSWF("/theme/swf/logo.swf", "logo", "216", "184", "","/js/swfobject/expressInstall.swf", flashvars, params, attributes);
 */
</script>


</head>
<body>
<div class="header">
    <div class="header_resize">
    	<div class="fStyle">
    		<div class="newLogo">
    			<div id="logo" onmouseover="$('bgHover').appear();" onmouseout="$('bgHover').fade();">
	    			<?php /*echo $this->htmlFlash(
	    				'/theme/swf/logo.swf',
		    			array(
		    			        'wmode' => 'transparent',
		    			        'width' => '216',
		    			        'height'	=> '184',
		    			        'allowfullscreen' => 'false',
								'allowscriptaccess' => 'always',
								'allownetworking' => 'all'
		    			)
	    			); */?>
    			</div>
    			<div id="bgHover" style="display:none;"></div>
    			<div id="bgNoHover"></div>
    		</div>
    		<div class="topContacts">
				<?php echo $this->action('topcontacts', 'index', 'default'); ?>
       		</div>
       		<div class="clear"></div>
    	</div>
    	
        <div class="clear"></div>
        <div class="main_menu">
        	<div class="menuLevel2">
        		<div class="mainMenuContainer">
        			<?php echo $this->action('index', 'index', 'menu'); ?>
        			<div class="clear"></div>	
        		</div>
        	</div>
        </div>
    </div>
</div>
<div class="body">
	<div class="push1"></div>
	<div class="container">
		<div class="columns">
			<div class="leftColumn">
				<div class="topPalette">
					<div class="topPattern"></div>
					<div class="plashkaTop"></div>
					<div class="plashkaCenter">
						<?php echo $this->action('indexoffers', 'index', 'content'); ?>
						<?php echo $this->action('feedback', 'index', 'default'); ?>
					</div>
					<div class="plashkaBottom"></div>
					<div class="bottomPattern"></div>
				</div>
				<a class="benefits" href="/benefits.html"></a>
				<?php echo $this->action('menubanner', 'index', 'default'); ?>
			</div>
			<div class="rightColumn"><?php echo $this->layout()->content;?></div>
			<div class="clear"></div>
		</div>
	</div>
    <div class="push2"></div>    
</div>
<div class="footer">
	<div class="footerGradient"></div>
	<div class="footerContainer">
		<div class="footer_resize">
			<div class="copyright">
				<div class="copyright_text" style="display:none">&copy; 2011 ht.dp.ua</div>
				<a class="performer_logo2" target="_blank" href="http://ifish.com.ua">Поддержка сайта Студия iFish</a>
				<a class="performer_logo" target="_blank" href="http://obs.biz.ua">разработка</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<script type="text/javascript">

 var _gaq = _gaq || [];
 _gaq.push(['_setAccount', 'UA-24622894-1']);
 _gaq.push(['_trackPageview']);

 (function() {
 var ga = document.createElement('script'); ga.type = 
'text/javascript'; ga.async = true;
 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 
'http://www') + '.google-analytics.com/ga.js';
 var s = document.getElementsByTagName('script')[0]; 
s.parentNode.insertBefore(ga, s);
 })();

</script>
</body>
</html>