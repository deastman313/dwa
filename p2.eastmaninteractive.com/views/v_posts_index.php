
<? foreach($posts as $post): ?>
	

	<h3><?=$post['first_name']?> <?=$post['last_name']?> posted:</h3>
    <div class="well">
	<?=$post['content']?>
	</div>
	
<? endforeach; ?>