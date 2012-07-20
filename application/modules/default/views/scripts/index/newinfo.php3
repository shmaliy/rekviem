<div class="infoTitle"><?php echo $this->items[0]['cat_title']; ?></div>
<div class="infoItems">
	<?php foreach ($this->items as $item) : ?>
	<div class="item">
    	<div class="title">
    		<?php if (!empty($item['fulltext'])) : ?>
        	<a href="/info/<?php echo $item['id']; ?>"><?php echo $item['title']; ?></a>
            <?php else : ?>
            	<?php echo $item['title']; ?>
            <?php endif; ?>
        </div>
        <div class="text">
        	<?php if (!empty($item['image'])) : ?>
 	        <a href="/info/<?php echo $item['id']; ?>"><img src="<?php echo $item['image']; ?>" class="icon"></a>
            <?php endif; ?>
            <?php echo $item['introtext']; ?>
        </div>
        <div class="clear"></div>
    </div>
	<?php endforeach; ?>
</div>