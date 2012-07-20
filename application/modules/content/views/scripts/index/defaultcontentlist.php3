<?php $this->headTitle($this->items[0]['cat_title']); ?>
<div class="defaultContentListContainer">
	<h1><?php echo $this->items[0]['cat_title']; ?></h1>
	<div class="defaultContentList">
	<?php foreach ($this->items as $item) : ?>
		<div class="item">
		<?php if (!empty($item['image'])) : ?>
			<img src="<?php echo $item['image']; ?>" class="image">
			<div class="textContainer">
		<?php else : ?>
			<div class="textContainerNoImage">
		<?php endif; ?>
			<a class="title" href="<?php echo $this->url(array('id' => $item['id']), $this->alias . 'Item'); ?>"><?php echo $item['title']; ?></a>
			<div class="introtext"><?php echo $item['introtext']; ?></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php endforeach; ?>
	</div>
</div>
<div class="clear"></div>
