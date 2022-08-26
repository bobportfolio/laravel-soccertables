</head>
<head>
@include('soccertables.includes.head')
</head>
<body>
<div class="container-fluid">
	
    @include('soccertables.includes.navbar')
    <div><br><br></div>

    <h1>Sorry page not found</h1>
</div>
@include('soccertables.includes.scripts')
<script>
$(window).load(function() {
    window.setTimeout(function(){
        window.location.href = "http://laravel.bobportfolio.uk";
    }, 2000);
});
</script>
</body>
</html>
