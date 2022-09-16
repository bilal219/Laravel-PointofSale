@extends('layouts.master')
@section('content')

<div class="content">
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Categories</h4>
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
					<a href="#">Product Category</a>
				</li>
				
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<div class="d-flex align-items-center">
							<h4 class="card-title">Add New Category</h4>
							<button class="btn btn-primary btn-round ml-auto" id="addcat" data-toggle="modal" data-target="#addCategoryModal">
								<i class="fa fa-plus"></i>
								New Category
							</button>
						</div>
					</div>
					<div class="card-body">
						
						<div class="table-responsive" id="show_all_categories">	
							<h1 class="text-center text-secondary my-5">Loading...</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Edit Category Modal -->
<div class="modal fade bd-example-modal-lg" id="editCategoriesModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="progress" style="height: 3px;">
				<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
			</div>
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="small">Make sure you fill them all</p>
				<form method="POST" id="edit_category_form">
				@csrf
				<input type="hidden" name="cat_id" id="cat_id">
				<div class="row">
					<div class="col-lg">
					<label for="fname">Category Name</label>
					<input type="text" name="cat_name" id="cat_name" class="form-control form-control-sm" placeholder="Category Name" required>
					</div>
				</div>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-sm btn-success" id="edit_category_btn">Update Category</button>	
			</div>
			</form>
		</div>
	</div>
</div>
	
		
@endsection
@section('Scripts')
   <script>
	   //modal open sound
	   $(document).on('click','#addcat',function(e){
      $('#modelopen').trigger('play')
	   });
     // fetchcategories
       fetchallcategories();
		function fetchallcategories()
		{
			$.ajax({
				url:'{{route('fetchcategories')}}',
				method:'get',
				success:function(res){
					$('#show_all_categories').html(res);
					$('#add-row').DataTable({
				       "pageLength": 5,
			        });
				}
			})
		}

		//editcategory
		$(document).on('click','.editcategoryicon',function(e){
      $('#modelopen').trigger('play')
       e.preventDefault();
       let catid=$(this).attr('id');
       $.ajax({
         method:'get',
         url:'{{route('editcategory')}}',
         data:{
           id:catid,
           _token:'{{csrf_token()}}'
         },
         success:function(res){
         $('#cat_id').val(res.id);
         $('#cat_name').val(res.cat_name);
          
         }
       });
     })
	  //delete employee
	  $(document).on('click','.deletecategoryicon',function(e){
       e.preventDefault();
     $('#warningsound').trigger('play');
       let catid=$(this).attr('id');
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
             url:'{{route('catdelete')}}',
             data:{
               id:catid,
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
               fetchallcategories();
               }
             }

           })
          }
        })
     })

	  //update employee data
	  $('#edit_category_form').submit(function(e){
       e.preventDefault();
       const fd=new FormData(this);
       $('#edit_category_btn').text('Updating...');
	   $("#edit_category_btn").prop('disabled', true);
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
         url:'{{route('updatecategory')}}',
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
                fetchallcategories();
                $('#edit_category_btn').text('Update Category'); 
				$("#edit_category_btn").prop('disabled', false);
              $('#edit_category_form')[0].reset();
              $('#editCategoriesModal').modal('hide');
          }
                  
              
         }
       })
     })

		//add categories
		$('#add_category_form').submit(function(e){
		e.preventDefault();
		const cd=new FormData(this);
		if($('#prod_category_name').val()!=="")
      	{
			var input_data=$('#prod_category_name').val();
			$.ajax({
				url:'{{route('uniquecat')}}',
				method:'post',
				data:{
					input_data:input_data,
					_token:$('meta[name="csrf-token"]').attr('content'),
				},
				success:function(res)
				{
					// console.log($(input_id).val())
					if(res==400){
					$(message_id).removeClass('text-success');
					$(div_id).removeClass('has-success');
					$(message_id).addClass('text-danger');
					$(div_id).addClass('has-error');
					$(div_id).addClass('has-feedback');
					$(message_id).html("This input value already exists in the record .");
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
						$('#add_category_btn').text('Adding...');
						$("#add_category_btn").prop('disabled', true);
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
							url:'{{route('addcategory')}}',
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
									'Category has been added successfully',
									'success'
									)
									fetchallcategories();
									$('#add_category_btn').text('Add Category');
									$("#add_category_btn").prop('disabled', false);
									$('#add_category_form')[0].reset();
									$('#addCategoryModal').modal('hide');
								}
								
							}

						})
				
					}
				}
			})
		}
      else{
        $(message_id).removeClass('text-danger');
        $(div_id).removeClass('has-error');
        $(div_id).removeClass('has-feedback');
        $(message_id).removeClass('text-success');
        $(div_id).removeClass('has-success');
        $(message_id).addClass('text-danger');
        $(message_id).html("");
        $(form_btn_id).prop('disabled', false);
      }
    })
		
		//unique validation
		$(document).ready(function(){
			var input_id='#prod_category_name';
			var route='uniquecat';
			var div_id="#cat_name_div";
			var message_id="#cat_name_message";
			var form_btn_id="#add_category_btn"
			keyupuniquevalidation(input_id,route,div_id,message_id,form_btn_id);
		})

    </script>
@endsection



