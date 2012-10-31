
<? foreach($posts as $post): ?>

    <div class="well">
    <h4><?=$post['first_name']?> <?=$post['last_name']?> posted on <?=$post['created']?>:</h4>
	<?=$post['content']?>
	</div>
	
<? endforeach; ?>