<!DOCTYPE html>
<html>
<head>
	<title>{{ 'Home Page' }}</title>
</head>
<body>
		@for($i = 1; $i <= 10; $i++)
			{{ $i }}
		@endfor
		<br>	
		<br>	
		@php( $array = ["Ash","Classes","HTE Class"] )
		
		@foreach($array as $row)
			<li>{{ $row }}</li>
		@endforeach
</body>
</html>
