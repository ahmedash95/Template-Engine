<!DOCTYPE html>
<html>
<head>
	<title><?php echo  'Home Page' ; ?></title>
</head>
<body>
		<?php for($i = 1; $i <= 10; $i++) : ?>
			<?php echo  $i ; ?>
		<?php endfor; ?>
		<br>	
		<br>	
		<?php  $array = ["Ash","Classes","HTE Class"] ; ?>
		
		<?php foreach($array as $row) : ?>
			<li><?php echo  $row ; ?></li>
		<?php endforeach; ?>
</body>
</html>
