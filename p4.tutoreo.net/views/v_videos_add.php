<? $content;?>
<h2>Add Your Video</h2>

<? if($add): ?>
    <div class="alert alert-success">
		Your video has been added.
	</div>
<? else: ?>

<form method='POST' action='/videos/p_add'>
	<label class="control-label" for="inputURL">Youtube or Vimeo URL:</label>
	<input type="text" id="inputURL" name="url" class="required">
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
	<input type="text" id="inputTag" name="tag" class="required"><br /><br />
	<button type='submit' class="btn">Submit</button>
</form>

<? endif; ?>