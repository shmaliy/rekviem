<?php 
$this->headTitle($this->bc['title']);

if(isset($this->bc['subcat_alias'])) {
	$this->headTitle($this->bc['subcat_title']);
}

$this->headTitle($this->bc['cat_title']);
$this->headTitle($this->bc['child_title']);
$this->headTitle($this->bc['parent_title']);
?>

<div class="defaultContentItemContainer">
	<h1><?php echo $this->bc['title']; ?></h1>
	<div class="breadCumps">
		<a href="/">Главная</a> //
		<a href="<?php echo $this->url(array(), 'shopindex'); ?>"><?php echo $this->bc['parent_title']; ?></a> // 
		<a href="<?php echo $this->url(array('child' => $this->bc['child_alias']), 'cataloguechild'); ?>"><?php echo $this->bc['child_title']; ?></a> // 
		<a href="<?php echo $this->url(array('child' => $this->bc['child_alias'], 'cat' => $this->bc['cat_alias']), 'cataloguecat'); ?>"><?php echo $this->bc['cat_title']; ?></a> 
		<?php if(isset($this->bc['subcat_alias'])) : ?>
		 // <a href="<?php echo $this->url(array('child' => $this->bc['child_alias'], 'cat' => $this->bc['cat_alias'], 'subcat' => $this->bc['subcat_alias']), 'cataloguesubcat'); ?>"><?php echo $this->bc['subcat_title']; ?></a>
		<?php endif; ?>
	</div>
	
	<div class="goodContainer">
		<a href="/<?php echo $this->item['image_big']?>" rel="lightbox[]" class="goodImage">
			<img src="/<?php echo str_replace('/^\/\/', '/', $this->item['image_small']); ?>">
		</a>
		<div class="description">
			<?php echo $this->item['introtext']; ?>
			<br />
			<?php echo $this->item['fulltext']; ?>
			<?php if(!empty($this->item['price']) && $this->item['price'] != 0 && preg_match('/^[0-9]+$/', $this->item['price'])) : ?>
				<div class="price">Цена: <span><?php echo $this->item['price']; ?> грн</span></div>
				<div class="clear"></div>
			<?php endif; ?>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>
