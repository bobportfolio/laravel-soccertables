<!DOCTYPE html>
<html>	
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="Robbie Smith">

	<link rel="shortcut icon" href="{{URL::to('images/robbie.ico')}}" type="image/x-icon" /> 

	<title>robbieportfolio.me.uk</title>

	<!-- load bootstrap -->
    <link rel="stylesheet" href={{ asset('css/bootstrap.css') }}>
    <link rel="stylesheet" href={{ asset('css/bootstrap-custom.css') }}>
</head>
<body id="robbieportfolio">
    <div>
        Laravel version: <?php echo app()->version(); ?>
    </div>
	<div class="container">
		<div style="margin-bottom:48px">
			<h2 style="margin-bottom:0px">robbieportfolio.me.uk</h2>
			The web development portfolio of Robert Smith
		</div>

		<div class="col-xs-12 col-sm-6 col-md-4" style="height:360px">
			<div id="portfolio-url">
				<a href="{{URL::to('/soccertables')}}">
						<img src="{{asset('/images/soccerball.png')}}" alt="Soccer Tables" >
						<div style="text-align:center"><h3>Soccer Tables</h4></div>
				</a>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4" style="height:360px">		
			<div id="portfolio-url" style="align:center">
				<a href="{{URL::to('/draganddrop')}}">
						<div class="pavilion-200px" style="margin-top:12px;margin-left:6px"></div>
						<div style="text-align:center"><h3>Drag &amp; Drop</h4></div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<div style="margin-left:48px">@include('skills')</div>
			<div style="margin-left:72px;margin-top:20px">
				<a href="{{URL::to('/contact')}}" class="btn btn-success">Contact me</a>
			</div>
		</div>
	</div>
	
	<!-- load jquery and javascripts -->
    <script src="{{ asset('js/jquery-1.11.0.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script type="text/javascript">
		$('.tip').tooltip();
	</script>
</body>
</html>
