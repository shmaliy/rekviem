<?php $this->headTitle($this->item['title']); ?>
<?php $this->headTitle($this->item['child_title']); ?>
<?php $this->headTitle($this->item['parent_title']); ?>
<div class="defaultContentItemContainer">
	<h1><?php echo $this->item['title']; ?></h1>
	<div class="breadCumps">
		<a href="/">Главная</a> // 
		<a href="<?php echo $this->url(array(), $this->item['parent_alias']); ?>"><?php echo $this->item['parent_title']; ?></a> // 
		<a href="<?php echo $this->url(array('alias' => $this->item['child_alias']), 'traditions_subcat_list'); ?>"><?php echo $this->item['child_title']; ?></a>
	</div>
	<div class="text">
		<?php echo $this->item['introtext']; ?><br />
		<?php echo $this->item['fulltext']; ?>
	</div>
</div>
<div class="clear"></div>
