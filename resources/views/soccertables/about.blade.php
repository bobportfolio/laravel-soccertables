@extends('soccertables.layouts.default')

@section('title')
@parent- About
@stop

@section('content')
	<h2>About this Site</h2>
	<p>This site is written with and exhibits the following programming skills:
		<ul>
			<li>PHP</li>
			<li>Laravel 4 web framework</li>
			<li>MySQL</li>
			<li>HTML 5</li>			
			<li>Bootstrap 3 Responsive CSS</li>
			<li>JQuery</li>
			<li>JQuery Ajax</li>
			<li>JQuery UI Datepicker</li>
			<li>JSON</li>
			<li>Encrypted Cookies</li>
			<li>Linux / Apache</li>
		</ul>
		The football matches are stored in the MySQL database
		but the league tables are calculated on the fly.<br>
		Please note that points deductions are stored on the day the team were penalised 
		to accurately reflect the tables at the time before and after.<br>
		In fact I am unaware of any website that accurately displays footbal league tables 
		for any day of a season.
	</p>
	<p>The site took between 40 and 80 hours to build. This includes time to learn new skills.</p>
@stop
