<div class="defaultContentItemContainer">
	<h2><?php echo $this->title; ?></h2>
	<?php foreach ($this->items as $item) : ?>
		<a class="categoryItem" href="<?php echo $this->url(array('child' => $item['child'], 'cat' => $item['alias']), 'cataloguecat'); ?>" style="background-image:url('<?php echo $item['image'];?>');">
			<span><?php echo $item['title']; ?></span>
		</a>
	
	<?php endforeach; ?>
	<div class="clear"></div>
</div>
<div class="clear"></div>
