<!DOCTYPE html>
<html>
<head>
@include('soccertables.includes.head')
</head>
<body>
<div class="container-fluid">
	
	@if(!(is_array($cookie) and array_key_exists('closed',$cookie)))
		<div id="cookie-warning">
			@include('soccertables.includes.cookie-warn')
		</div>
	@endif

    <div class="col-md-7">
        <div class="row">
            <div class="col-md-1"></div>
            
            <!-- left sidebar content -->
            <div id="left-sidebar" class="col-md-4">
                @yield('left-sidebar')
            </div>
            
            <!-- main content -->
            <div id="content" class="col-md-7">
                @yield('content')
            </div>
        </div>
        
        <div class="row">
        </div>
    </div>
    
    <!-- right sidebar content -->
    <div id="right-sidebar" class="col-md-4">
        @yield('right-sidebar')
    </div>

    <div class="col-md-1">
    </div>

    <footer class="navbar navbar-fixed-bottom text-center">
        @include('soccertables.includes.footer')
    </footer>

</div>
@include('soccertables.includes.scripts')
</body>
</html>
