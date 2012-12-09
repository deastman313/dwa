<h1><?= $profile_contents['first_name']?> <?= $profile_contents['last_name']?>'s Profile </h1>

<? if($profile_contents['user_id']!=$user->user_id): ?>
<div class="row">
	<div class="span6">
    	<div class="well">
		<h4>Member since:</h4> <?= Time::display($profile_contents['account_created']),"",""?><br />
        <h4>Location:</h4> <?= $profile_contents['location']?><br />
        <h4>Interests:</h4> <?= $profile_contents['interests']?><br />
        <h4>Github Repository:</h4> <?= $profile_contents['github']?><br />
        </div>
   </div>
</div>
	
<? else:?>

<h2>Update Your Profile</h2>

	<form method='POST' action='/users/p_profile'>
    
        <label class="control-label" for="inputLocation"><strong>Location</strong></label>
        <input type="text" id="inputLocation" placeholder="<?= $profile_contents['location']?>" name="location">
        
        <label class="control-label" for="inputInterests"><strong>Interests</strong></label>
        <textarea rows="3" id="inputInterests" placeholder="<?= $profile_contents['interests']?>" name="interests"></textarea>
                    
        <label class="control-label" for="inputGithub"><strong>Link to Your Github Repository</strong></label>
        <input type="text" id="inputGithub" placeholder="<?= $profile_contents['github']?>" name="github">
  
         <br /><br />
        <button type='submit' class="btn">Update</button>
    	</form>
    

<? endif;?>
             

