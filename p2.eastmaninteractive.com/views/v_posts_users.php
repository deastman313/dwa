<h1>Find Some Users to Follow</h1>

<form method='POST' action='/posts/p_follow'>
		
	<? foreach($users as $user): ?>
		<div class="row">
        	<div class="span3">
            <!-- Print this user's name -->
            <?=$user['first_name']?> <?=$user['last_name']?>
            </div>
			<div class="span2">
            <!-- If there exists a connection with this user, show a unfollow link -->
            <? if(isset($connections[$user['user_id']])): ?>
                <a href='/posts/unfollow/<?=$user['user_id']?>'>Unfollow</a>
		
		<!-- Otherwise, show the follow link -->
				<? else: ?>
                    <a href='/posts/follow/<?=$user['user_id']?>'>Follow</a>
                <? endif; ?>
			</div>
		<br><br>
        </div>
	
	<? endforeach; ?>
	
</form>