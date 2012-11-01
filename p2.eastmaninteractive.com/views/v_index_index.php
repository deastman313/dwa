<div class="hero-unit">
        <h1>P!NG</h1>
        <p>P!NG is a hub for the developer community to share snippets of code, links, and resources. </p>
        <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
      </div>
      
      <? if($user): ?>
      <div class="row">
      	<div class="span8">
      <h2>Howdy <?=$user->first_name?>!</h2>
      	</div>
      </div>
      
      <? else: ?>
      
      <div class="row">
       <div class="span6">
         <?=$login?>
        </div>
      	<div class="span6">
         <?=$signup?>
        </div>
      
      <? endif; ?>
       
	</div>