<!DOCTYPE html>
<html>	
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="Robbie Smith">

	<link rel="shortcut icon" href="{{URL::to('images/robbie.ico')}}" type="image/x-icon" /> 

	<title>Drag and Drop</title>
	<!-- load bootstrap -->
    <link rel="stylesheet" href={{ asset('css/bootstrap.css') }}>
    <link rel="stylesheet" href={{ asset('css/bootstrap-custom.css') }}>
    <link rel="stylesheet" href={{ asset('css/draganddrop.css') }}>
</head>
<body>
	<div class="container">
		<div class="col-xs-12 col-sm-6 col-md-4">
			<div id="pavilion" name="Brighton Pavilion" class="pavilion-200px">
			</div>
			<div id="drop1" class="circle-200px">
			</div>
			<div id="bigben" name="Big Ben" class="bigben-200px">
			</div>
			<div id="drop2" class="circle-200px">
			</div>
			<div id="eiffel" name="Eiffel Tower" class="eiffel-200px">
			</div>
			<div id="drop3" class="circle-200px">
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<h2 style="margin-bottom:0px">Drag &amp; Drop</h2>
			<h4 style="margin-top:0px"><i>Drop an image into an empty circle</i></h4>
			<div id="dropbig" class="circle-300px" 
				style="background-color:#7fbfff;z-index:-1">
			</div>
			<h2><div id="buildingname">&nbsp;</div></h2>
		</div>	
		<div class="col-xs-12 col-sm-6 col-md-4">
			<div id="back-button">
			<a href="{{URL::to('/')}}" class="btn btn-success">back to robbieportfolio.me.uk</a>
			<div id="skills">
				Skills:
				<ul>
					<li>HTML 5</li>	
					<li>CSS</li>		
					<li>Bootstrap 3</li>
					<li>JQuery</li>
					<li>JQuery UI Draggables</li>
					<li>JQuery UI Droppables</li>
					<li>Javascript</li>
					<li>Linux / Apache</li>
				</ul>
			</div></div>
		</div>
	</div>
	
	<!-- load jquery and javascripts -->
    <script src="{{ asset('js/jquery-1.11.0.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('//code.jquery.com/ui/1.10.4/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.touch-punch.min.js') }}"></script>
	<script>
		$(function() {
			$("#pavilion").draggable({revert:"invalid"})
				.data("drop","#drop1").data("size","-200px");
			
			$("#bigben").draggable({revert:"invalid"})
				.data("drop","#drop2").data("size","-200px");

			$("#eiffel").draggable({revert:"invalid"})
				.data("drop","#drop3").data("size","-200px");

			$("#drop1").droppable({
				disabled: true,
				drop: function(event, ui) {dropImage(this,ui.draggable,'-200px');}
			});
			
			$("#drop2").droppable({
				disabled: true,
				drop: function(event, ui) {dropImage(this,ui.draggable,'-200px');}
			});
			
			$("#drop3").droppable({
				disabled: true,
				drop: function(event, ui) {dropImage(this,ui.draggable,'-200px');}
			});
			
			$("#dropbig").droppable({
				drop: function(event, ui) {
					dropImage(this,ui.draggable,'-300px');
					$('#buildingname').text(ui.draggable.attr('name'));	
				}
			});
		});
		
		function dropImage(drop,drag,size)
		{
			var building = drag.attr('id');
			var orig_drop = $(drag).data("drop");
			var orig_size = $(drag).data("size");
			$(drag).removeClass(building+orig_size);			
			$(drag).addClass(building+size);
			drag.position({of: $(drop),my: 'left top',at: 'left top'});
			$(orig_drop).droppable("option","disabled",false);	
			$(drop).droppable("option","disabled",true);
			$(drag).data("drop","#"+$(drop).attr('id'));
			$(drag).data("size",size);
			if(orig_drop=="#dropbig") $('#buildingname').html("&nbsp;");
		}
	</script>
</body>
</html>
