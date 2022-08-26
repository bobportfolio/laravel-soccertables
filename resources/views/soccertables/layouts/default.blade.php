<!DOCTYPE html>
<html>
<head>
@include('soccertables.includes.head')
</head>
<body>
<div class="container-fluid">
	
    @include('soccertables.includes.navbar')
    <div><br><br></div>

    <div class="row">
        <!-- left sidebar content -->
        <div id="left-sidebar" class="col-md-3">
            @yield('left-sidebar')
        </div>
        
        <!-- main content -->
        <div id="content" class="col-md-4">
            @yield('content')
        </div>
        
        <!-- right sidebar content -->
        <div id="right-sidebar" class="col-md-5">
            @yield('right-sidebar')
        </div>
    </div>
    <footer class="navbar text-center" id="footer">
        @if(!(is_array($cookie) and array_key_exists('closed',$cookie)))
            <div id="cookie-warning">
                @include('soccertables.includes.cookie-warn')
            </div>
        @endif
        
        @include('soccertables.includes.footer')
    </footer>

</div>
@include('soccertables.includes.scripts')
</body>
</html>
