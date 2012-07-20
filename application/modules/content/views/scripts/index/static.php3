<?php $this->headTitle($this->item['title']); ?>
<div class="rightModuleContainer">
	<h1><?php echo $this->item['title']; ?></h1>
	<div class="text"><?php echo $this->item['fulltext']; ?></div>
	<?php if (!empty($this->imgarray)) : ?>
	<div class="gallery">	
		<?php $i=0; ?>
		<?php foreach ($this->imgarray as $img) : ?>
		<a href="/<?php echo $img['fullsize']; ?>" rel="lightbox[]">
			<img src="/<?php echo $img['thumb']; ?>">
		</a>
		<?php 
			$i++;
			if ($i==4) :
				$i=0; 
		?>
		<div class="clear"></div>
			<?php endif; ?>
		<?php endforeach; ?>
		<div class="clear"></div>
	</div>
	<?php endif; ?>
</div>	
