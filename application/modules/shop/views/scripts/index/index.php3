<?php 
	$this->bc = $this->items[0];
	$this->headTitle($this->bc['parent_title']);
?>

<div class="defaultContentItemContainer">
	<h1><?php echo $this->items[0]['parent_title']; ?></h1>
	<?php foreach ($this->items as $item) : ?>
		<a class="childCategoryItem" href="<?php echo $this->url(array('child' => $item['child_alias']), 'cataloguechild'); ?>">
			<span class="img">
				<img src="<?php echo $item['child_image']; ?>">
			</span>
			<span class="text">
				<span class="title"><?php echo $item['child_title']; ?></span>
				<span><?php echo $item['child_description']; ?></span>
			</span>
			<div class="clear"></div>
		</a>
	
	<?php endforeach; ?>
	<div class="clear"></div>
</div>
<div class="clear"></div>