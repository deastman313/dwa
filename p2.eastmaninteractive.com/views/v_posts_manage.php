<h2>Manage Your P!NGs</h2>

<? foreach($myposts as $mypost): ?>

    <div class="well">
    <h4>You posted on <?= Time::display($mypost['modified'],"","") ?>:</h4>
	<?=$mypost['content']?>
   	<br>
    <br>
   	<a href="/posts/delete/<?=$mypost['post_id']?>"><button class="btn btn-danger">Delete this post</button></a>
	</div>
	
<? endforeach; ?>


