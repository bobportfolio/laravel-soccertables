<meta charset="utf-8">
<meta name="description" content="">
<meta name="author" content="Robbie Smith">
<meta name="csrf-token" content="{{ csrf_token() }}" />

@section('favicon')
@show

@section('title')
<title> Soccer Tables @show </title>

@section('css')
<!-- load bootstrap -->
<link rel="stylesheet" href={{ asset('css/bootstrap.css') }}>
<link rel="stylesheet" href={{ asset('css/bootstrap-custom.css') }}>
@show
