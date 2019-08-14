<!DOCTYPE html>

<html>

<head>
	<title>Queue email</title>
</head>

<body>
	<p> This is your activation link: </p>
	<hr>
	<p>{{$activation_link}}</p>
	<p> Your activation link will only be valid for <strong>{{$email_ttl_minutes}}</strong> minutes from now</p>
	<hr>
	<strong>Thank you.</strong>
</body>

</html>