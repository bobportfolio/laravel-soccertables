<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="Robbie Smith">

	<link rel="shortcut icon" href="{{URL::to('images/robbie.ico')}}" type="image/x-icon" /> 

	<title>Contact Me</title>

	<!-- load bootstrap -->
    <link rel="stylesheet" href={{ asset('css/bootstrap.css') }}>
    <link rel="stylesheet" href={{ asset('css/bootstrap-custom.css') }}>
</head>
<body id="robbieportfolio">
	<div class="container">
		<h1>Contact me:</h1>

		{{ Form:: open(array('url' => '/contact_request')) }}
		<div style="border:solid gray 1px;width:600px">
		<table class="table table-no-border">
			
			<tr>
				<td width="64px">{{ Form::label ('name', 'Name*' )}}</td>
				<td>
					@if(isset($messages) and $messages->first('name'))
						<span style="color:red">{{ $messages->first('name') }}</span><br>
					@endif
					{{ Form::text ('name', 
						isset($old_input)?$old_input['name']: '',  
						array('style' => 'width:240px'))}}
				</td>
			</tr>

			<tr>
				<td>{{ Form::label ('email', 'Email*') }}</td>
				<td>
					@if(isset($messages) and $messages->first('email'))
						<span style="color:red">{{ $messages->first('email') }}</span><br>
					@endif
					{{ Form::email ('email', 
						isset($old_input)?$old_input['email']: '',  
						array('placeholder' => 'me@example.com', 'style' => 'width:240px')) }}
				</td>
			</tr>

			<tr>
				<td>{{ Form::label ('subject', 'Subject*') }}</td>
				<td>
					@if(isset($messages) and $messages->first('subject'))
						<span style="color:red">{{ $messages->first('subject') }}</span><br>
					@endif
					{{ Form::text ('subject',
						isset($old_input)?$old_input['subject']: '', 
						array('style' => 'width:428px')) }}
				</td>
			</tr>

			<tr>
				<td>{{ Form::label ('message', 'Message*' )}}</td>
				<td>
					@if(isset($messages) and $messages->first('message'))
						<span style="color:red">{{ $messages->first('message') }}</span><br>
					@endif
					{{ Form::textarea ('message', 
						isset($old_input)?$old_input['message']: '') }}
				</td>
			</tr>

			<tr>
				<td></td>
				<td><a href="{{URL::to('/contact')}}" class="btn btn-primary">Clear</a>
				{{ Form::submit('Send', array('class' => 'btn btn-success')) }}</td>
			</tr>
		</table>
		</div>
		{{ Form:: close() }}
		<div style="margin-top:20px">
			<a href="{{URL::to('/')}}" class="btn btn-default">Home Page</a>
		</div>
	</div>
</body>
</html>
