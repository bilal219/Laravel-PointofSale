@extends('layouts.master')
@section('content')

			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Areas</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="{{route('dashboard')}}">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Area</a>
							</li>
							
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Add New Area</h4>
										<button class="btn btn-primary btn-round ml-auto" id="addarea" data-toggle="modal" data-target="#addareaModal">
											<i class="fa fa-plus"></i>
											New Area
										</button>
									</div>
								</div>
								<div class="card-body">
									
									<div class="table-responsive" id="show_all_areas">	
									  <h1 class="text-center text-secondary my-5">Loading...</h1>
								    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Edit Area Modal -->
			<div class="modal fade bd-example-modal-lg" id="editareaModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="progress" style="height: 3px;">
							<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
						</div>
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit Area</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p class="small">Make sure you fill them all</p>
							<form method="POST" id="edit_area_form">
							@csrf
							<input type="hidden" name="area_id" id="area_id">
							<div class="row">
								<div class="col-lg">
								<label for="fname">Area Name</label>
								<input type="text" name="area_name" id="area_name" class="form-control" placeholder="Area Name" required>
								</div>
							</div>	
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success" id="edit_area_btn">Update Area</button>	
						</div>
						</form>
					</div>
				</div>
			</div>
	
		
@endsection
@section('Scripts')
   <script>
	   //modal open sound
	   $(document).on('click','#addarea',function(e){
      $('#modelopen').trigger('play')
	   });
     // fetch areas
       fetchallareas();
		function fetchallareas()
		{
			$.ajax({
				url:'{{route('fetchareas')}}',
				method:'get',
				success:function(res){
					$('#show_all_areas').html(res);
					$('#add-area').DataTable({
				       "pageLength": 5,
			        });
				}
			})
		}

		//edit area
		$(document).on('click','.editareaicon',function(e){
      $('#modelopen').trigger('play')
       e.preventDefault();
       let areaid=$(this).attr('id');
       $.ajax({
         method:'get',
         url:'{{route('editarea')}}',
         data:{
           id:areaid,
           _token:'{{csrf_token()}}'
         },
         success:function(res){
         $('#area_id').val(res.id);
         $('#area_name').val(res.area);
          
         }
       });
     })
	  //delete Area
	  $(document).on('click','.deleteareaicon',function(e){
       e.preventDefault();
     $('#warningsound').trigger('play');
       let areaid=$(this).attr('id');
       swal({
		icon : "info",
		title: 'Are you sure?',
		text: "You won't be able to revert this record!",
		type: 'warning',
		buttons:{
			cancel: {
				visible: true,
				className: 'btn btn-danger'
			},confirm: {
				text : 'Yes, delete it!',
				className : 'btn btn-success'
			}
		}
        }).then((Delete) => {
          if (Delete) {
           $.ajax({
             method:'post',
             url:'{{route('areadelete')}}',
             data:{
               id:areaid,
               _token:'{{csrf_token()}}'
             },
             success:function(res)
             {
               if(res.status===200)
               {
                 $('#successsound').trigger('play')
                 swal(
                 'Deleted!',
                 'Area has been deleted successfully.',
                 'success'
                 )
               fetchallareas();
               }
             }

           })
          }
        })
     })

	  //update Area data
	  $('#edit_area_form').submit(function(e){
       e.preventDefault();
       const fd=new FormData(this);
       $('#edit_area_btn').text('Updating...');
	   $("#edit_area_btn").prop('disabled', true);
       $.ajax({
        xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
         method:'post',
         url:'{{route('updatearea')}}',
         data:fd,
         cache:false,
         processData:false,
         contentType:false,
         beforeSend: function(){
          $(".progress-bar").width('0%');
         },
         success:function(res){
          $(".progress-bar").width('0%');
          if(res.status===200)
          {
              $('#successsound').trigger('play')
                swal(
                  'Updated!',
                  'Area has been Updated successfully',
                  'success'
                )
                fetchallareas();
                $('#edit_area_btn').text('Update Area'); 
				$("#edit_area_btn").prop('disabled', false);
              $('#edit_area_form')[0].reset();
              $('#editareaModal').modal('hide');
          }
                  
              
         }
       })
     })

		//add area
		$('#add_area_form').submit(function(e){
		e.preventDefault();
		const cd=new FormData(this);
		$('#add_area_btn').text('Adding...');
		$("#add_area_btn").prop('disabled', true);
		$.ajax({
				xhr: function() 
				{
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(evt) {
						if (evt.lengthComputable) {
							var percentComplete = ((evt.loaded / evt.total) * 100);
							$(".progress-bar").width(percentComplete + '%');
						}
					}, false);
					return xhr;
				},
			method:'POST',
			url:'{{route('addarea')}}',
			data:cd,
			cache:false,
			processData:false,
			contentType:false,
			beforeSend: function(){
			$(".progress-bar").width('0%');
			},
			success:function(res){
					$(".progress-bar").width('0%');
					if(res.status===200){
						$('#successsound').trigger('play')
						swal(
						'Added!',
						'Area has been added successfully',
						'success'
						)
						fetchallareas();
					$('#add_area_btn').text('Add Area');
					$("#add_area_btn").prop('disabled', false);
					$('#add_area_form')[0].reset();
					$('#addareaModal').modal('hide');
					}
					
					}

		})
		})
    </script>
@endsection



