<div class="span9">
	<div class="well">
    	<h2 class="add">Add a Tutorial</h2>
    		<form method='POST' action='/dashboard/p_add' id="addVideo">
        	<label class="control-label" for="inputURL">Paste the Youtube URL:</label>
        	<input type="text" id="inputURL" name="url" class="required">
        
        	<!--Rudimentary alert message indicating that the URL isn't a valid Youtube URL; hidden by default-->
        	<div class="ghost">
            	<div class="alert alert-error">Sorry, this doesn't look like a valid Youtube URL. We only support Youtube videos at this time, but hope to add more formats soon!
        		</div>
        	</div>
            <!--End alert-->
        
        	<label class="control-label" for="inputTitle">Title Your Tutorial:</label>
        	<input type="text" id="inputTitle" name="title" class="required" value="Required">
        
       		<label class="control-label" for="inputTag">Tag Your Tutorial:</label>
       		<select name="tag">
              <option type="text" name="art" id="art" value="art">Art</option>
              <option type="text" name="cooking" id="cooking" value="cooking">Cooking</option>
              <option type="text" name="design" id="design" value="design">Design</option>
              <option type="text" name="language" id="language" value="language">Language</option>
              <option type="text" name="math" id="math" value="math">Math</option>
              <option type="text" name="music" id="music" value="music">Music</option>
              <option type="text" name="photography" id="photography" value="photography">Photography</option>
              <option type="text" name="programming" id="programming" value="programming">Programming</option>
              <option type="text" name="other" id="other" value="other">Other</option>
			  <option type="text" name="other" id="other" value="other">Uncategorized</option>
        	</select>
         
     		<!--If there are no groups set in the system, the user must add this tutorial to a new group-->
         	<? if(isset($nogroups)): ?>
            <label class="control-label" for="inputGroupNew" id="groupNew">Create a New Group:</label>
        	<input type="text" id="groupNew" name="group_name" class="required" value="group_name">
            
            <!--If there are any groups set in the system, the user can add the tutorial to one of these groups. If no groups set, we hide this-->
            <? else:?>
        	<label class"control-label" for="inputNewGroup">Add to a Group:</label>   
        	
            	<select name="group_name" id="group_names" class="addGroup">
        			<? foreach($groups as $group): ?>
                	<option type="text" name="<?=$group['group_name']?>" id="<?=$group['group_name']?>" value="<?=$group['group_name']?>"><?=$group['group_name']?></option>
                	<? endforeach; ?> 	
                	<option type="text" name="group_name" id="group_name" value="new">Create a New Group...</option>
        		</select>	
            
            <!--This div is hidden unless the user selects to Create a New Group from the select menu-->
            <div id="new_group">
        		<label for="inputNewGroup" id="groupNew">New Group Name:</label>
    			<input type="text" class="text" name="group_name" id="groupNew"/>
        	</div>
            <!--end New Group-->
        
			<? endif; ?>
        	
            <br /><br />
        <button type='submit' class="btn">Submit</button>
    </form>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
 	$('#new_group').hide();
 	
	$('#group_names').bind('change', function (e) { 
    
	if( $('#group_names').val() == 'new') {
      $('#new_group').show();
    }
    else{
      $('#new_group').hide();
    }         
  });
	
$("#addVideo").validate();
	
function ytVidId(url) {
    var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
    return (url.match(p)) ? RegExp.$1 : false;
}

$('.ghost').hide();
$('#inputURL').bind("change keyup input", function() {

    var url = $(this).val();
    if (ytVidId(url) == false) {
        $('.ghost').show();
		$(this).val('');
    } 
	else {
	$('.ghost').hide();
	}
});


});
</script>
