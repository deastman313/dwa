<div class="span9">
	<div class="well">
		<h3 class="add">Tutoreo Groups</h3>
        <p>Click on a group name to view all of the videos in that group.
        <ul>
    	<? foreach($group_names as $group_name): ?>
        	<li><a href="/videos/groupvideos/<?=$group_name['group_name'] ?>" rel="tooltip" title="View all videos in this group"><?=$group_name['group_name'] ?></a></li>
        <? endforeach; ?>
        </ul>
    </div>
 </div>
   
