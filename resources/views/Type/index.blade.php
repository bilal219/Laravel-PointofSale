@extends('layouts.master')
@section('content')

			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Types</h4>
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
								<a href="#">Type</a>
							</li>
							
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Add New Type</h4>
										<button class="btn btn-primary btn-round ml-auto" id="addtype" data-toggle="modal" data-target="#addtypeModal">
											<i class="fa fa-plus"></i>
											New Type
										</button>
									</div>
								</div>
								<div class="card-body">
									
									<div class="table-responsive" id="show_all_types">	
									  <h1 class="text-center text-secondary my-5">Loading...</h1>
								    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Edit Type Modal -->
			<div class="modal fade bd-example-modal-lg" id="edittypeModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="progress" style="height: 3px;">
							<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
						</div>
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit Type</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p class="small">Make sure you fill them all</p>
							<form method="POST" id="edit_type_form">
							@csrf
							<input type="hidden" name="type_id" id="type_id">
							<div class="row">
								<div class="col-lg">
								<label for="fname">Area Name</label>
								<input type="text" name="type_name" id="type_name" class="form-control" placeholder="Type" required>
								</div>
							</div>	
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success" id="edit_type_btn">Update Type</button>	
						</div>
						</form>
					</div>
				</div>
			</div>
	
		
@endsection
@section('Scripts')
   <script>
	   //modal open sound
	   $(document).on('click','#addtype',function(e){
      $('#modelopen').trigger('play')
	   });
     // fetch typess
       fetchalltypes();
		function fetchalltypes()
		{
			$.ajax({
				url:'{{route('fetchtypes')}}',
				method:'get',
				success:function(res){
					$('#show_all_types').html(res);
					$('#add-type').DataTable({
				       "pageLength": 5,
			        });
				}
			})
		}

		//edit type
		$(document).on('click','.edittypeicon',function(e){
      $('#modelopen').trigger('play')
       e.preventDefault();
       let typeid=$(this).attr('id');
       $.ajax({
         method:'get',
         url:'{{route('edittype')}}',
         data:{
           id:typeid,
           _token:'{{csrf_token()}}'
         },
         success:function(res){
         $('#type_id').val(res.id);
         $('#type_name').val(res.type);
          
         }
       });
     })
	  //delete type
	  $(document).on('click','.deletetypeicon',function(e){
       e.preventDefault();
     $('#warningsound').trigger('play');
       let typeid=$(this).attr('id');
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
             url:'{{route('typedelete')}}',
             data:{
               id:typeid,
               _token:'{{csrf_token()}}'
             },
             success:function(res)
             {
               if(res.status===200)
               {
                 $('#successsound').trigger('play')
                 swal(
                 'Deleted!',
                 'Type has been deleted successfully.',
                 'success'
                 )
               fetchalltypes();
               }
             }

           })
          }
        })
     })

	  //update Type data
	  $('#edit_type_form').submit(function(e){
       e.preventDefault();
       const fd=new FormData(this);
       $('#edit_type_btn').text('Updating...');
	   $("#edit_type_btn").prop('disabled', true);
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
         url:'{{route('updatetype')}}',
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
                  'Type has been Updated successfully',
                  'success'
                )
                fetchalltypes();
                $('#edit_type_btn').text('Update Type'); 
				$("#edit_type_btn").prop('disabled', false);
              $('#edit_type_form')[0].reset();
              $('#edittypeModal').modal('hide');
          }
                  
              
         }
       })
     })

		//add Type
		$('#add_type_form').submit(function(e){
		e.preventDefault();
		const cd=new FormData(this);
		$('#add_Type_btn').text('Adding...');
		$("#add_Type_btn").prop('disabled', true);
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
			url:'{{route('addtype')}}',
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
						fetchalltypes();
					$('#add_type_btn').text('Add Type');
					$("#add_type_btn").prop('disabled', false);
					$('#add_type_form')[0].reset();
					$('#addtypeModal').modal('hide');
					}
					
					}

		})
		})
    </script>
@endsection



