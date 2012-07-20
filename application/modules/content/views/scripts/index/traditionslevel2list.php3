<?php $this->headTitle($this->items[0]['child_title']); ?>
<?php $this->headTitle($this->items[0]['parent_title']); ?>
<div class="defaultContentListContainer">
	<h1><?php echo $this->items[0]['child_title']; ?></h1>
	<div class="breadCumps">
		<a href="/">Главная</a> // 
		<a href="<?php echo $this->url(array(), $this->items[0]['parent_alias']); ?>"><?php echo $this->items[0]['parent_title']; ?></a>
	</div>
	<div class="defaultContentList">
	<?php foreach ($this->items as $item) : ?>
		<div class="item">
		<?php if (!empty($item['image'])) : ?>
			<img src="<?php echo $item['image']; ?>" class="image">
			<div class="textContainer">
		<?php else : ?>
			<div class="textContainerNoImage">
		<?php endif; ?>
			<a class="title" href="<?php echo $this->url(array('id' => $item['id'], 'subcat' => $item['child_alias']), 'traditionslevel2item'); ?>"><?php echo $item['title']; ?></a>
			<div class="introtext"><?php echo $item['introtext']; ?></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php endforeach; ?>
	</div>
</div>
<div class="clear"></div>