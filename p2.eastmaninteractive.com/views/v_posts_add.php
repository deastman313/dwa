<? if($add): ?>
    <div class="alert alert-success">
		Your post has been added.
	</div>
    <a href="/users/dashboard"><button type="button" class="btn">Add Another Post</button></a>
	<br>
    
<? else: ?>
<form method='POST' action='/posts/p_add'>
	<h2>What's up?</h2><br>
	<textarea name='content' id="inputPost" placeholder="Compose a P!NG..."></textarea>
	<br><br>
	<button type='submit' class="btn">Submit</button>
</form>
<? endif; ?>