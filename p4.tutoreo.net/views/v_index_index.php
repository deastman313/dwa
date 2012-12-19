<? if($restricted):?>
<h1>Howdy, stranger!</h1>
	<div class="span8">
		<div class="alert alert-error"></div>
	</div>
</div>
<? else:?>
	<div class="span8">
    	<h1>Latest Tutorials</h1>
        <div id="page">
     		<ul id="slider">
            	<div id="whateverID">
                <iframe width="640" height="390" frameborder="0" title="YouTube video player" type="text/html" src="http://www.youtube.com/embed/<?=$latest_video['youtube_id']?>?enablejsapi=1">
                </iframe>
                <a href="javascript:void callPlayer(&quot;whateverID&quot;,&quot;stopVideo&quot;)">Stop</a>
                </div>
     		</ul>
        </div>
    </div>
    
    <div class="span4">
    	<h2>Sign Up</h2>
     		<?=$signup?>
	</div>        

<? endif;?>


<script type="text/javascript">

/*
 * @author       Rob W (http://stackoverflow.com/a/7513356/938089
 * @description  Executes function on a framed YouTube video (see previous link)
 *               For a full list of possible functions, see:
 *               http://code.google.com/apis/youtube/js_api_reference.html
 * @param String frame_id The id of (the div containing) the frame
 * @param String func     Desired function to call, eg. "playVideo"
 * @param Array  args     (optional) List of arguments to pass to function func*/
function callPlayer(frame_id, func, args) {
    if (window.jQuery && frame_id instanceof jQuery) frame_id = frame_id.get(0).id;
    var iframe = document.getElementById(frame_id);
    if (iframe && iframe.tagName.toUpperCase() != 'IFRAME') {
        iframe = iframe.getElementsByTagName('iframe')[0];
    }
    if (iframe) {
        // Frame exists, 
        iframe.contentWindow.postMessage(JSON.stringify({
            "event": "command",
            "func": func,
            "args": args || [],
            "id": frame_id
        }), "*");
    }
}
</script>






      

       
