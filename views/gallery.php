
<div class="gallery group">

<?php foreach($items as $item) : ?>


	<div class="item span_1">
		<a href="/?action=viewItem&amp;itemId=<?php echo $item['ID']; ?>">
			<figure class="itemfigure">
                            <audio controls style="width:100%"><source src="<?php echo $item['Url']; ?>" alt="<?php echo $item['Name']; ?>"  title="<?php echo $item['Name']; ?>" /></audio>	
				<figcaption>
					<h2><?php echo $item['Name']; ?></h2>
				</figcaption>
		    </figure>
	    </a>
	</div>

<?php endforeach; ?>

</div>