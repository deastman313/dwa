<h1>Manage Your P!NGs</h1>

<? if(isset($noposts)):?>
	<div class="alert alert-block">
  		<p>Uh-oh... you have no P!NGs left! Return to your dashboard to compose a new P!NG?</p>
    </div>
        <a href="/users/dashboard"><button class="btn">Take me there</button></a>

<? else: ?>

	<? foreach($myposts as $mypost): ?>
        <div class="well">
        <h4>You posted on <?= Time::display($mypost['modified'],"","") ?>:</h4>
        <?=$mypost['content']?>
        <br>
        <br>
        <a href="/posts/delete/<?=$mypost['post_id']?>"><button class="btn btn-danger">Delete this post</button></a>
        </div> 
    <? endforeach; ?>

<? endif; ?>




