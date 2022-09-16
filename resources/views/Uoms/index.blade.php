@extends('layouts.master')
@section('content')

			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">UOM</h4>
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
								<a href="#">UOM</a>
							</li>
							
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Add New UOM</h4>
										<button class="btn btn-primary btn-round ml-auto" id="adduom" data-toggle="modal" data-target="#adduomModal">
											<i class="fa fa-plus"></i>
											New UOM
										</button>
									</div>
								</div>
								<div class="card-body">
									
									<div class="table-responsive" id="show_all_uoms">	
									  <h1 class="text-center text-secondary my-5">Loading...</h1>
								    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Edit Category Modal -->
			<div class="modal fade bd-example-modal-lg" id="edituomModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="progress" style="height: 3px;">
							<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
						</div>
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit UOM</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p class="small">Make sure you fill them all</p>
							<form method="POST" id="edit_uom_form">
							@csrf
							<input type="hidden" name="uom_id" id="uom_id">
							<div class="row">
								<div class="col-lg">
								<label for="fname">UOM Name</label>
								<input type="text" name="uom_name" id="uom_name" class="form-control form-control-sm" placeholder="UOM Name" required>
								</div>
							</div>	
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-sm btn-success" id="edit_uom_btn">Update UOM</button>	
						</div>
						</form>
					</div>
				</div>
			</div>
	
		
@endsection
@section('Scripts')
   <script>

	// //unique validation
	// $(document).ready(function(){
	// 	var input_id='#prod_uom_name';
	// 	var route='uniqueuom';
	// 	var div_id="#uom_name_div";
	// 	var message_id="#uom_name_message";
	// 	var form_btn_id="#add_uom_btn"
	// 	uniquevalidation(input_id,route,div_id,message_id,form_btn_id);
	// })

	   //modal open sound
	   $(document).on('click','#adduom',function(e){
      $('#modelopen').trigger('play')
	   });
     // fetchuoms
       fetchalluoms();
		function fetchalluoms()
		{
			$.ajax({
				url:'{{route('fetchuoms')}}',
				method:'get',
				success:function(res){
					$('#show_all_uoms').html(res);
					$('#add-uom').DataTable({
				       "pageLength": 5,
			        });
				}
			})
		}

		//editcategory
		$(document).on('click','.edituomicon',function(e){
      $('#modelopen').trigger('play')
       e.preventDefault();
       let uomid=$(this).attr('id');
       $.ajax({
         method:'get',
         url:'{{route('edituom')}}',
         data:{
           id:uomid,
           _token:'{{csrf_token()}}'
         },
         success:function(res){
		 $('#uom_id').val(res.id);
         $('#uom_name').val(res.uom_name);
          
         }
       });
     })
	  //delete uom
	  $(document).on('click','.deleteuomicon',function(e){
       e.preventDefault();
     $('#warningsound').trigger('play');
       let uomid=$(this).attr('id');
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
             url:'{{route('uomdelete')}}',
             data:{
               id:uomid,
               _token:'{{csrf_token()}}'
             },
             success:function(res)
             {
               if(res.status===200)
               {
                 $('#successsound').trigger('play')
                 swal(
                 'Deleted!',
                 'Category has been deleted successfully.',
                 'success'
                 )
               fetchalluoms();
               }
             }

           })
          }
        })
     })

	  //update uom data
	  $('#edit_uom_form').submit(function(e){
       e.preventDefault();
       const fd=new FormData(this);
       $('#edit_uom_btn').text('Updating...');
	   $("#edit_uom_btn").prop('disabled', true);
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
         url:'{{route('updateuom')}}',
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
                  'Category has been Updated successfully',
                  'success'
                )
                fetchalluoms();
                $('#edit_uom_btn').text('Update Category'); 
				$("#edit_uom_btn").prop('disabled', false);
              $('#edit_uom_form')[0].reset();
              $('#edituomModal').modal('hide');
          }
                  
              
         }
       })
     })

//add categories
$('#add_uom_form').submit(function(e){
	e.preventDefault();
	const cd=new FormData(this);
	if($('#prod_uom_name').val()!=="")
	{
		var input_data=$('#prod_uom_name').val();
		$.ajax({
			url:'{{route('uniqueuom')}}',
			method:'post',
			data:{
				input_data:input_data,
				_token:$('meta[name="csrf-token"]').attr('content'),
			},
			success:function(res)
			{
				// console.log($(input_id).val())
				if(res==400){
					$('#uom_name_message').removeClass('text-success');
					$('#uom_name_div').removeClass('has-success');
					$('#uom_name_message').addClass('text-danger');
					$('#uom_name_div').addClass('has-error');
					$('#uom_name_div').addClass('has-feedback');
					$('#uom_name_message').html("This input value already exists in the record .");
				}
				else
				{
					//   $(message_id).removeClass('text-danger');
					//   $(div_id).removeClass('has-error');
					//   $(div_id).removeClass('has-feedback');
					//   $(message_id).addClass('text-success');
					//   $(div_id).addClass('has-success');
					//   $(message_id).html("Validated input value .");
					//   $(form_btn_id).prop('disabled', false);
					$('#add_uom_btn').text('Adding...');
					$("#add_uom_btn").prop('disabled', true);
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
						url:'{{route('adduom')}}',
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
								'UOM has been added successfully',
								'success'
								)
								fetchalluoms();
								$('#add_uom_btn').text('Add Category');
								$("#add_uom_btn").prop('disabled', false);
								$('#add_uom_form')[0].reset();
								$('#adduomModal').modal('hide');
							}
								
						}

					})
				}
			}
		})
	}
})

</script>
@endsection



