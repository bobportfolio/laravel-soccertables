<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="Robbie Smith">

	<link rel="shortcut icon" href="{{URL::to('images/robbie.ico')}}" type="image/x-icon" /> 

	<title>Thank You</title>

	<!-- load bootstrap -->
    <link rel="stylesheet" href={{ asset('css/bootstrap.css') }}>
    <link rel="stylesheet" href={{ asset('css/bootstrap-custom.css') }}>
</head>
<body id="robbieportfolio">
	<div class="container">
		<h1>Thankyou for contacting me</h1>
		<div>
			I have sent you an email notification and will get back to you as soon as possible.
		</div>
		<div style="margin-top:20px">
			<a href="{{URL::to('/')}}" class="btn btn-success">Home Page</a>
		</div>
	</div>
</body>
</html>
