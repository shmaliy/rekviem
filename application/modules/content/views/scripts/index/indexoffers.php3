<div class="leftModuleContainer">
	<h2><?php echo $this->items[0]['cat_title']; ?></h2>
	<?php foreach ($this->items as $item) : ?>
	<div class="offersItem">
		<a class="offerImg" href="<?php echo $this->url(array('id' => $item['id']), 'akcii_item');?>">
			<img src="/<?php echo $item['image']; ?>">
		</a>
		<div class="offerText">
			<a class="title" href="<?php echo $this->url(array('id' => $item['id']), 'akcii_item');?>">
				<?php echo $item['title']; ?>
			</a>		
			<?php echo $item['introtext']; ?>
		</div>
		<div class="clear"></div>
	</div>
	<?php endforeach;?>
</div>	
