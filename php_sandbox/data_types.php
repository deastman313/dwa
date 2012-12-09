<html>
	<head>
		<title>Strings, Numbers, and Floats</title>
	</head>
	<body>
	<?php
		echo "Hello World<br>";
		$my_variable = "Hello World!";
		echo $my_variable;
	?>
	
	<?php
		echo "$my_variable Again. <br>";
		echo "{$my_variable} Again. <br>";
	?>
	

	<?php
		$firstString= "The quick brown fox";
		$secondString= " jumped over the lazy dog.";
	?>
	
	<?php
		$thirdString=$firstString;
		$thirdString .=  $secondString;
		echo $thirdString;
	?>
	
	<br><br>
	<strong>A few of the many functions you can apply to strings:</strong> <br>
	Length: <?php echo strlen($thirdString);?><br>
	Trim:   <?php echo $fourthString = $firstString . trim($secondString);?><br>
	Find:   <?php echo strstr($thirdString, "brown"); ?><br>
	Replace by string: <?php echo str_replace("quick", "super-fast", $thirdString); ?><br>
	
	<br><br>
	<strong>What manipulations can we do to numbers?</strong><br>
	<?php
		$var1 = 3;
		$var2 = 4;
	?>
	
	Basic math: <?php echo ((1+2+$var1)* $var2) /2-5;?>
	<br>
	+= <?php $var2 +=4; echo $var2;?><br>
	-= <?php $var2 -=4; echo $var2;?><br>
	*= <?php $var2 *=4; echo $var2;?><br>
	/= <?php $var2 /=4; echo $var2;?><br>
	<br>
	Increment: <?php $var2++; echo $var2; ?><br>
	Decrement: <?php $var2--; echo $var2; ?><br>
	<br>
	
	<strong>Working with Floating Point Numbers</strong><br>
	<?php $var3 = 3.14; ?>
	
	Floating point: <?php echo $myFloat=3.14; ?><br>
	Round the number to one decimal point: <?php echo round($myFloat,1);?><br>
	Ceiling (force to round up): <?php echo ceil($myFloat); ?><br>
	Floor (force to round down): <?php echo floor($myFloat);?><br>
	<br>
	Absolute value: abs (0-300) -- Returns the absolute value of zero minus three hundred<br>
	Exponential: pow(2,8) -- Returns two to the eighth power<br>
	Square root: sqrt(100) -- Returns the square root of one hundred<br> 
	Modulo: fmod(20,7) -- The remainder of twenty divided by 7, i.e., six<br>
	Random(any): rand() -- Returns any random number<br>
	Random (min, max): rand(1,10) -- Returns a random number based on a specified minimum and maximum value<br> 

	</body>
</html>
		