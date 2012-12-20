<div class="span9">
	<? if(isset($novideos)): ?>
        	<div class="alert alert-block">
        		<h3 class="add">No Tutorials</h3>
  					<p>You haven't added any tutorials yet. Once you do, they'll show up here!
       				<br /><br />
             </div>
    <? else:?>

	<? foreach($myvideos as $myvideo): ?>
    	<div class="well">
        	<div class="title">
             	<h2><?=$myvideo['title']?></h2>
                Posted <?=Time::time_ago ($myvideo['modified'], $dateto=-1)?> in <?=$myvideo['tag']?>
            </div>
					
            <iframe class="youtube-player" type="text/html" height="390" width="640" src="http://www.youtube.com/embed/<?=$myvideo['youtube_id']?>" frameborder="0"></iframe>
            
             <a href="/dashboard/delete/<?=$myvideo['video_id']?>"><button class="btn btn-danger">Delete this post</button></a>
           		 	
  		</div><!--Close well-->
	<? endforeach; ?>
    <? endif;?>
</div><!--Close span9-->
