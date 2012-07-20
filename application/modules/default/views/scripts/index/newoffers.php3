<div class="offersTitle"><?php echo $this->items[0]['cat_title']; ?></div>
<div class="offersItems">
	<?php foreach ($this->items as $item) : ?>
    <div class="title">
    	<?php if (!empty($item['fulltext'])) : ?>
    	<a href="/offers/<?php echo $item['id']; ?>"><?php echo $item['title']; ?></a>
        <?php else : ?>
        	<?php echo $item['title']; ?>
        <?php endif; ?>
    </div>
    <?php if (!empty($item['image'])) : ?>
    <a href="/offers/<?php echo $item['id']; ?>"><img src="<?php echo $item['image']; ?>" class="icon"></a>
    <?php endif; ?>
    <div class="text"><?php echo $item['introtext']; ?></div>
    <div class="clear"></div>
    <?php endforeach; ?>
</div>