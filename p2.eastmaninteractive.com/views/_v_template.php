<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=@$title; ?></title>
	<meta charset="utf-8">
	<!-- CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Arvo:400,700|PT+Sans:400,400italic,700' rel='stylesheet' type='text/css'>
       <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>


	<!-- JS -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8/jquery.validate.min.js"></script>
    <script type="text/javascript"> $(document).ready(function(){ $("#subForm").validate(); }); </script>
				
	<!-- Controller Specific JS/CSS -->
	<?php echo @$client_files; ?>
</head>
<body>	

<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#">P!NG</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
            	<?=$nav;?> 
                <?=$links;?>
			</ul>                
          </div><!--/.nav-collapse -->
     	</div>
      </div>
    </div>
   

	 <div class="container">
	<?=$content;?> 

	

	<footer><p>&copy; P!NG 2012</p></footer>
  </div>  

</body>
</html>