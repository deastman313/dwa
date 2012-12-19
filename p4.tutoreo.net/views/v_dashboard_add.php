<div class="span9">
	<h2>Add a Tutorial</h2>

    <form method='POST' action='/dashboard/p_add'>
        <label class="control-label" for="inputURL">Paste the Youtube URL:</label>
        <input type="text" id="inputURL" name="url" class="required">
        
        <label class="control-label" for="inputTitle">Title Your Tutorial:</label>
        <input type="text" id="inputTitle" name="title" class="required">
        
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
         
         <? if(isset($groups)): ?>
        <label class"control-label" for="inputNewGroup">Add to an Existing Group:</label>   
        <select name="group_name">
        		<? foreach($groups as $group): ?>
                <option type="text" name="<?=$group['group_name']?>" id="<?=$group['group_name']?>" value="<?=$group['group_name']?>"><?=$group['group_name']?></option>
                <? endforeach; ?> 	
        </select>	
        <? else:?>
        <label class="control-label" for="inputGroup">Create a New Group:</label>
         <input type="text" id="inputGroup" name="group_name" class="required">
		<? endif; ?>
        <br /><br />
        <button type='submit' class="btn">Submit</button>
    </form>
</div>


