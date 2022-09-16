<!--   Core JS Files   -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{asset('assets/js/core/popper.min.js')}}"></script>
	<script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>


	<!-- Chart JS -->
	<script src="{{asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>

	<!-- jQuery Sparkline -->
	<script src="{{asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

	<!-- Chart Circle -->
	<script src="{{asset('assets/js/plugin/chart-circle/circles.min.js')}}"></script>

	<!-- Datatables -->
	<script src="{{asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{asset('assets/js/plugin/jqvmap/jquery.vmap.min.js')}}"></script>
	<script src="{{asset('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js')}}"></script>

	<!-- Sweet Alert -->
	<script src="{{asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
	<script src="{{asset('assets/js/select2.min.js')}}" type='text/javascript'></script>
	<!-- Atlantis JS -->
	<script src="{{asset('assets/js/atlantis.min.js')}}"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{asset('assets/js/setting-demo.js')}}"></script>
<!-- 	<script src="{{asset('assets/js/demo.js')}}"></script> -->
	<script src="{{asset('assets/js/printThis.js')}}"></script>
	<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<!-- datatable -->
	<script >
	    $(":input").inputmask();	
	</script>
	<!-- cahs register check -->
	<script>
		$(".cashclose").on('click',function(){
			$.ajax({
				url:'{{route('chkclose')}}',
				method:'get',
				success:function(res)
				{
					if(res.status===200)
					{
                      window.location.href="cashclose";
					}else if(res.status===404)
					{
						swal
						(
							'Warning!',
							'Cash register has not been open yet',
							'error'
						)
					}
				}
			})
		})		
	</script>
	<!-- //ajax calls -->
	<script src="{{asset('ajax/pos.js')}}"></script>
	<script src="{{asset('ajax/reports.js')}}"></script>

<!-- Select2 JS --> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function(){
 
 // Initialize select2
 $("#selUser").select2();

 // Read selected option
 $('#but_read').click(function(){
   var username = $('#selUser option:selected').text();
   var userid = $('#selUser').val();

   $('#result').html("id : " + userid + ", name : " + username);

 });
});
</script>
<!-- printing -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js" integrity="sha512-d5Jr3NflEZmFDdFHZtxeJtBzk0eB+kkRXWFQqEc1EKmolXjHm2IKCA7kTvXBNjIYzjXfD5XzIjaaErpkZHCkBg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>  

<script>
    $(document).ready(function () {
       //searchable dropdown
	   $(".search-dropdown").select2();
    });

</script>
@yield('Scripts')