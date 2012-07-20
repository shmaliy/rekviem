<?php if (!empty($this->menu_result) && is_array($this->menu_result)): ?>
<div class="menu">
	<ul>
		<?php foreach ($this->menu_result as $item) : ?>
	        <li onmouseover="this.className='hover';" onmouseout="this.className='nohover';">	
	            <?php if ($item.current == 1) : ?>
	                <a href="<?php echo $item['link']; ?>" class="active"><span><?php echo $item['title']; ?></span></a>
	            <?php else : ?>
	                <a href="<?php echo $item['link']; ?>"><span><?php echo $item['title']; ?></span></a>
	            <?php endif; ?>
	            <?php if (isset($item['childs'])) : ?>
	                <ul>
	                    <?php foreach ($item['childs'] as $sub) : ?>
	                        <li><a href="<?php echo $sub['link']; ?>"><span><?php echo $sub['title']; ?></span></a></li>   
	                    <?php endforeach; ?> 
	                </ul>
	            <?php endif; ?>
	         </li>   
	     <?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>