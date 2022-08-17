<!DOCTYPE html>
<html>
<head>
	@include('soccertables.includes.head')
</head>
<body>
<div class="container">

	<header class="row">
		@include('soccertables.includes.header')
	</header>

	<div id="main" class="row">
		@yield('content')
	</div>

	<footer class="row">
		@include('soccertables.includes.footer')
	</footer>

</div>
	@include('soccertables.includes.scripts')
</body>
</html>
