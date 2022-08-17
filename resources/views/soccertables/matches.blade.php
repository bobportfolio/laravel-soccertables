@extends('soccertables.layouts.sidebar')

@section('favicon')
<link rel="shortcut icon" href="{{URL::to('images/soccertables.ico')}}" type="image/x-icon" /> 
@stop

@section('title')
@parent- {{ $leagueseason->league_name }} - {{ $dates['matchdate'] }}
@stop


@section('css')
@parent
<!-- load jquery ui smoothness style -->
<link rel="stylesheet" href={{ asset('css/jquery-ui.css') }}>
@stop


@section('left-sidebar')
    <div>
        <a href="{{URL::to('/soccertables')}}">
            <div>
                <h1>
                <img src="{{URL::to('/images/soccerball.png')}}" alt="Soccer Tables" 
                    style="width:64px;height:64px;margin-right:18px">Soccer Tables
                </h1>
            </div>
        </a>
    </div>
    <br>
    <div>
        <div class="dropdown">
          <button class="btn dropdown-toggle btn-lg" type="button" data-toggle="dropdown">
            {{ $leagueseason->league_name }}
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
            <li role="presentation" class="dropdown-header">Choose League</li>
            @foreach($leagues as $league)
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" 
                        href="{{URL::to('/matches'.'/'.$league->id.'/'.$league->end_date)}}" >{{ $league->league_name }}</a>
                </li>
            @endforeach
          </ul>
        </div>
    </div>
    <br><br>
    <div>
        season: 
        <a href="{{URL::to('/matches'.'/'.$leagueseason->id.'/'.$leagueseason->start_date)}}" 
            class="btn btn-info btn-xs">first day
        </a>
        <a href="{{URL::to('/matches'.'/'.$leagueseason->id.'/'.$leagueseason->end_date)}}" 
            class="btn btn-warning btn-xs">last day
        </a>
    </div>
    <br>
    <div>
        <div id="datepicker"></div>
    </div>
@stop



@section('content')
    <div style="width:560px;text-align:center;">
        <br>
        <h2>{{ $leagueseason->league_name }}</h3>
    </div>
	<table style="width:560px">
		<tr>
			<td style="width:80px">
				<a href="{{URL::to('/matches'.'/'.$leagueseason->id.'/'.$dates['prev'])}}" 
					class="btn btn-default btn-sm" @if($dates['prev']=="null")disabled @endif>
					<span class="glyphicon glyphicon-arrow-left"></span>
				</a>
			</td>
			<td style="width:400px;text-align:center">
				<h4>{{ date('l jS F Y',strtotime($dates['matchdate'])) }}</h4>
			</td>
			<td style="width:80px;text-align:right">
				<a href="{{URL::to('/matches'.'/'.$leagueseason->id.'/'.$dates['next'])}}" 
					class="btn btn-default btn-sm" @if($dates['next']=="null")disabled @endif/>
					<span class="glyphicon glyphicon-arrow-right"></span>
				</a>
			</td>
		</tr>
	</table>
	<table style="width:560px;font-size:14px" class="table table-striped table-bordered table-hover table-condensed">
		@foreach($matches as $match)
			<tr>
				<td style="width:240px">{{ $match->homeTeam->team_name }}</td>
				<td style="width:80px" align="center">{{ $match->home_score}} &nbsp;-&nbsp;&nbsp;{{ $match->away_score}}</td>
				<td style="width:240px">{{ $match->awayTeam->team_name }}</td>
			</tr>
		@endforeach
    </table>
	<table style="width:560px;font-size:14px" class="table table-striped table-bordered table-hover table-condensed">
		@foreach($directives as $directive)
			<tr>
				<td style="width:240px">  {{ $directive->team->team_name }}
                deducted {{ $directive->points_deduction }} points
                for {{ $directive->reason->description }} </td>
			</tr>
            <tr>
                <td style="font-size:12px">source: 
                <a href="{{ $directive->referenceUrl->url }}">
{{ $directive->referenceUrl->source_name }}</a>@if($directive->event_date != $directive->original_date), date: {{ $directive->original_date }} @endif
                </td>
            </tr>
		@endforeach
    </table>
@stop



@section('right-sidebar')
    <div>
        <br><br>
    </div>
    <div>
        <button onclick="tableButton('leaguetable')" class="btn btn-primary btn-xs">League Table</button>
        <button onclick="tableButton('formtable')" class="btn btn-danger btn-xs">Form</button>
    </div>
	<div id="league-table">
		@include('soccertables.league')
	</div>
@stop



@section('scripts')
@parent
<script src="{{ asset('js/jquery.ui.datepicker.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script type="text/JavaScript">
// jquery datepicker
$(function() 
{
	$("#datepicker").datepicker(
	{
		defaultDate: new Date({{ date('Y, n-1, j',strtotime($dates['matchdate'])) }}),
		minDate: new Date({{ date('Y, n-1, j',strtotime($leagueseason->start_date)) }}), 
		maxDate: new Date({{ date('Y, n-1, j',strtotime($leagueseason->end_date)) }}),
		dateFormat: 'yy-mm-dd',
		onSelect: function(date) 
		{
			window.location = "{{URL::to('/matches/'.$leagueseason->id)}}"+'/'+date;	
		}
	});
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

// league-table ajax request
function tableButton(table_type)
{
	$.ajax(
	{
        method: 'post',
	 	url: "{{URL::to('/').'/'}}"+table_type+"{{ '/'.$leagueseason->id.'/'.$dates['matchdate']}}",
	 	success:function(data)
	 	{
	 		$('#league-table').html(data);
	 	}
    });
}
</script>

@stop
