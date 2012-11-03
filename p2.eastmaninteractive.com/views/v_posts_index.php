
<? foreach($posts as $post): ?>

    <div class="well">
    <h4><a href="/users/profile/<?=$post['user_id']?>"><?=$post['first_name']?> <?=$post['last_name']?></a> posted <?=Time::time_ago ($post['modified'], $dateto=-1)?>:</h4>
	<?=$post['content']?>
	</div>
	
<? endforeach; ?>


