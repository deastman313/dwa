<h1><?= $profile_contents[0]['first_name']?> <?= $profile_contents[0]['last_name']?>'s Profile </h1>

<? if($profile_contents[0]['user_id']!=$user->user_id): ?>

This is not your profile.

<? else: ?>

<h2>Update Your Profile</h2>

	<form method='POST' action='/users/p_profile'>
    
        <label class="control-label" for="inputLocation">Location</label>
        <input type="text" id="inputLocation" placeholder="<?= $profile_contents[0]['location']?>" name="location">
        
        <label class="control-label" for="inputInterests">Interests</label>
        <textarea rows="3" id="inputInterests" placeholder="<?= $profile_contents[0]['interests']?>" name="interests"></textarea>
                    
        <label class="control-label" for="inputGithub">Link to Your Github Repository</label>
        <input type="text" id="inputGithub" placeholder="<?= $profile_contents[0]['github']?>" name="github">
        
        
        <input type="hidden" value="0" name="visibility" />
		<label class="checkbox"> Allow other users to see my profile
        <input type="checkbox" value="1" name="visibility" />
        </label>
                    
         <br /><br />
        <button type='submit' class="btn">Submit</button>
    	</form>
    
    
	
	<strong>Visibility:</strong> <? if($profile_contents[0]['visibility']=1) :?>Public <? else:?>Private<? endif?>

<? endif;?>
             

