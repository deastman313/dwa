<div class="span9">
	<? if(isset($nogroups)): ?>
    	<div class="well">
        	<h3 class="add">No Tutorials</h3>
  				<p>You haven't added any tutorials yet. Once you do, they'll show up here!
       			<br />
    	</div>
    <? else:?>

	<? foreach($myvideos as $myvideo): ?>
    	<div class="well">
             	<h2><?=$myvideo['title']?></h2>
                    	Posted <?=Time::time_ago ($myvideo['modified'], $dateto=-1)?> in <?=$myvideo['tag']?>
					
                <iframe class="youtube-player" type="text/html" height="390" width="640" src="http://www.youtube.com/embed/<?=$myvideo['youtube_id']?>" frameborder="0"></iframe>
           		 	
  		</div><!--Close well-->
	<? endforeach; ?>
    <? endif;?>
</div><!--Close span9-->
