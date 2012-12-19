<div class="span9">
	<div class="well">
		<h2>Tutoreo Groups</h2>
    	<ul>
    	<? foreach($group_names as $group_name): ?>
    	 	<li><a href="/videos/groupvideos/<?=$group_name['group_name']?>"><?=$group_name['group_name']?></a></li>
    	<? endforeach; ?>
        </ul>
	</div>
</div>