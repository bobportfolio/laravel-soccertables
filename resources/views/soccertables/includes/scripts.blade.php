@section('scripts')
<!-- load jquery and javascripts -->
<script src="{{ asset('js/jquery-1.11.0.js') }}"></script>

<script type="text/javascript">
    $('#cookie-accept, .close').click(function(event)
    {
		$.ajax(
		{
			type: 'post',
			url: '{{URL::to('/cookie-accept')}}',
			success:function(data)
			{
				$('#cookie-warning').text(data);
			}
		});
   });
</script>

@show
