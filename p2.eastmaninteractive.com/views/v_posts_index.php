
<? foreach($posts as $post): ?>

    <div class="well">
    <h4><?=$post['first_name']?> <?=$post['last_name']?> posted <?=Time::time_ago ($post['modified'], $dateto=-1)?>:</h4>
	<?=$post['content']?>
	</div>
	
<? endforeach; ?>


