<?php 
$this->headTitle($this->bc['cat_title']);
$this->headTitle($this->bc['child_title']);
$this->headTitle($this->bc['parent_title']);
?>

<div class="defaultContentItemContainer">
	<h1><?php echo $this->bc['cat_title']; ?></h1>
	<div class="breadCumps">
		<a href="/">Главная</a> //
		<a href="<?php echo $this->url(array(), 'shopindex'); ?>"><?php echo $this->bc['parent_title']; ?></a> // 
		<a href="<?php echo $this->url(array('child' => $this->bc['child_alias']), 'cataloguechild'); ?>"><?php echo $this->bc['child_title']; ?></a> 
	</div>
	
	<?php if (!empty($this->bc['cat_description'])) : ?>
	<div class="catText">
		<?php echo $this->bc['cat_description']; ?>
	</div>
	<?php endif; ?>
	
	<?php if (!empty($this->subcats)) : ?>
	<ul class="subcatsMenu">
		<li>Подкатегории:</li>
		<?php foreach($this->subcats as $subcat) : ?>
			<li><a href="<?php echo $this->url(array('child' => $subcat['child_alias'], 'cat' => $subcat['cat_alias'], 'subcat' => $subcat['subcat_alias']), 'cataloguesubcat'); ?>"><?php echo $subcat['subcat_title']; ?></a></li>
		<?php endforeach;?>
		<div class="clear"></div>
	</ul>
	<div class="clear"></div>
	<?php endif; ?>
		
	<?php if (!empty($this->goods)) : ?>
		<?php $i=0; ?>
		<?php foreach ($this->goods as $good) : 
			$i++;
		?>
		<div class="goodItem">
			<a href="/<?php echo $good['image_big']; ?>" rel="lightbox[]">
				<img src="/<?php echo $good['image']; ?>">
			</a>
			<?php if (!empty($good['introtext'])) : ?>
			<a class="descLink" href="<?php echo $this->url(array('child' => $good['child_alias'], 'cat' => $good['cat_alias'], 'id' => $good['id']), 'goodcat'); ?>">
				Описание
			</a>
			<?php endif; ?>
		</div>
		<?php if ($i == 3) : ?>
		<div class="clear"></div>
		<?php 
			$i=0;
			endif;
		?>
		<?php endforeach; ?>
		<div class="clear"></div>
		<?php endif; ?>
</div>
<div class="clear"></div>
