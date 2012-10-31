<h1><?=$user->first_name?>'s Dashboard</h1>

<div class="row">
	<div class="span4">
	<?=$subview?>
    <?=$compose?>
    </div>
	<div class="span8">
    <h2>Recent P!NGs</h2>
	<?=$feed?>
	</div>
</div>