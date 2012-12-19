<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=@$title; ?></title>
	<meta charset="utf-8">
	<!-- CSS -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/css/styles.css" rel="stylesheet">
  	<link href='http://fonts.googleapis.com/css?family=Bree+Serif|Open+Sans:400,300,600' rel='stylesheet' type='text/css'>

	<!-- JS -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8/jquery.validate.min.js"></script>
    <script src="/assets/js/bootstrap.js"></script>
    <script src="/assets/js/video.js"></script>
    
				
	<!-- Controller Specific JS/CSS -->
	<?php echo @$client_files; ?>
</head>
<body>	

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
        <div class="container">
          	<a class="brand heading" href="/index">Tutoreo</a>
          	<div id="menu">
          		<div class="nav-collapse collapse">
						<ul class="nav">
                        	<li><a href="/index/about">About</a></li>
                        	<? if($user): ?>
                			<li><a href="/dashboard">Dashboard</a></li>
                			<li><a href="/videos">Browse Videos</a></li>
             			</ul>
                 
                    <div class="navbar-form pull-right">
                          <a href="/users/logout"><button class="btn">Log Out</button></a>
					</div><!--Close navbar-form pull-right-->
				</div><!--Close nav-collapse collapse-->
			</div><!--Close menu-->
		</div><!--Close container-->
	</div><!--Close navbar-inner-->
</div><!--Close navbar navbar-fixed-top-->                        
                   		<? else: ?>
                        </ul>
               	
    	      			<div class="navbar-form pull-right">
                        	<div class="holder" style="float: right;">
                            <form method='POST' action='/users/p_login'>
                            <input type="text" id="inputEmail" name="email" class="span2" placeholder="Email address">
                            <input type="password" id="inputPassword" name="password" class="span2" placeholder="Password">
                            <button type="submit" class="btn">Login</button>
                            </form>
      						</div><!--Close holder-->
					</div><!--Close navbar-form pull-right-->
            	</div><!--Close nav-collapse collapse-->
			</div><!--Close menu-->
		</div><!--Close container-->
	</div><!--Close navbar-inner-->
</div><!--Close navbar navbar-fixed-top-->    
        <? endif; ?>
<div class="wrapper">
	<div class="container content">
		<div class="row">
			<? if(isset($menu)) echo $menu; ?>
    		<?=$content;?> 
        </div>
        <div class="row">
			<footer><p>&copy; Tutoreo 2012</p></footer>
		</div>
 	</div>  
</div>
  <script type="text/javascript"> $(document).ready(function(){ 
	$("#subForm").validate();
   }); 
  </script>
  <script type='text/javascript'>
	$(function(){
		var url = window.location.pathname, 
        urlRegExp = new RegExp(url.replace(/\/$/,'') + "$"); 
        $('#menu a').each(function(){
            if(urlRegExp.test(this.href.replace(/\/$/,''))){
                $(this).addClass('active');
            }
        });

});
</script>
</body>
</html>