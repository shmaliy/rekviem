<div class="rightModuleContainer">
	<h1><?php echo $this->item['title']; ?></h1>
	<div class="text"><?php echo $this->item['introtext']; ?></div>
	<a href="#" class="jMoreLink" onclick="return seoMore();">rekviem.org</a>
	<div class="text" id="seoMore" style="display:none"><?php echo $this->item['fulltext']; ?></div>
</div>	

<script>
function seoMore()
{
	var container = $("seoMore");
	if (container.getStyle('display') == 'none') {
		container.show();
	} else {
		container.hide();
	}
	return false;
}
</script>