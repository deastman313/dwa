<? if($restricted):?>
<h1>Howdy, stranger!</h1>
<div class="row">
	<div class="span8">
		<div class="alert alert-error">Sorry, you have to be a P!NG member to view this page. Sign up or log in below.</div>
	</div>
</div>
<? else:?>
<div class="hero-unit">
	<h1>P!NG</h1>
        <p>P!NG is a hub for the developer community to share snippets of code, links, and resources.<br />
           Did you just write the most elegant piece of code known to man? <br />
           P!NG it and share with your followers. </p>
         <p><a class="btn btn-inverse" href="/index/about">Learn more &raquo;</a></p>
</div>
<? endif;?>
<div class="row">
	<div class="span6">
     <?=$login?>
     </div>
     <div class="span6">
     <?=$signup?>
     </div>
</div>



      

       
