<?php 
if(isset($this->bc['subcat_alias'])) {
	$this->headTitle($this->bc['subcat_title']);
}

$this->headTitle($this->bc['cat_title']);
$this->headTitle($this->bc['child_title']);
$this->headTitle($this->bc['parent_title']);
?>

<div class="defaultContentItemContainer">
	<h1><?php echo $this->bc['cat_title']; ?></h1>
	<div class="breadCumps">
		<a href="/">Главная</a> //
		<a href="<?php echo $this->url(array(), 'shopindex'); ?>"><?php echo $this->bc['parent_title']; ?></a> // 
		<a href="<?php echo $this->url(array('child' => $this->bc['child_alias']), 'cataloguechild'); ?>"><?php echo $this->bc['child_title']; ?></a> // 
		<a href="<?php echo $this->url(array('child' => $this->bc['child_alias'], 'cat' => $this->bc['cat_alias']), 'cataloguecat'); ?>"><?php echo $this->bc['cat_title']; ?></a> 
	</div>
	<?php if (!empty($this->goods)) : ?>
		<?php foreach ($this->goods as $good) : ?>
		<div class="goodItem">
		<a href="/<?php echo $good['image_big']; ?>" rel="lightbox[]">
			<img src="/<?php echo $good['image']; ?>">
		</a>
		<?php if (!empty($good['introtext'])) : ?>
		<a class="descLink" href="<?php echo $this->url(array('child' => $good['child_alias'], 'cat' => $good['cat_alias'], 'subcat' => $good['subcat_alias'], 'id' => $good['id']), 'goodsubcat'); ?>">
			Описание
		</a>
		<?php endif; ?>
		</div>
		<?php endforeach; ?>
		<div class="clear"></div>
	<?php endif; ?>
</div>
<div class="clear"></div>
