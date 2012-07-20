<?php 
	$this->bc = $this->items[0];
	
	$this->headTitle($this->bc['child_title']);
	$this->headTitle($this->bc['parent_title']);
?>
<div class="defaultContentItemContainer">
	<h1><?php echo $this->items[0]['child_title']; ?></h1>
	<div class="breadCumps">
		<a href="/">Главная</a> //
		<a href="<?php echo $this->url(array(), 'shopindex'); ?>"><?php echo $this->items[0]['parent_title']; ?></a>
	</div>
	<?php foreach ($this->items as $item) : ?>
		<a class="categoryItem" href="<?php echo $this->url(array('child' => $item['child_alias'], 'cat' => $item['cat_alias']), 'cataloguecat'); ?>" style="background-image:url('<?php echo $item['cat_image'];?>');">
			<span><?php echo $item['cat_title']; ?></span>
		</a>
	
	<?php endforeach; ?>
	<div class="clear"></div>
</div>
<div class="clear"></div>