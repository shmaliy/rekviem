<div class="rightModuleContainer">
	<h2><?php echo $this->items[0]['cat_title']; ?></h2>
	<?php foreach ($this->items as $item) : ?>
	<div class="newItem">
		<div class="newsDate"><?php echo $item['created']; ?></div>
		<div class="newsText"><?php echo $item['introtext']; ?></div>
		<div class="clear"></div>
	</div>
	<?php endforeach;?>
</div>	