@extends('layouts.master')
@section('title',"الاقسام")
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">


@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الاقسام</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
@if (session()->has('add'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('add') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session()->has('edit'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('edit') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session()->has('delete'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


					
						<!--/div-->
	
						<!--div-->
						<div class="col-xl-12">
							<div class="card mg-b-20">
	{{-- ---------------------------------------------------------------------------------- --}}
							<!-- Button trigger modal -->
<button type="button"  class="btn btn-success" data-toggle="modal" style="width: 100px; height:50px;" data-target="#exampleModal">
	اضافة قسم
  </button>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">اضافة قسم</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  {{-- --------------------------------- --}}
		  <form action="{{route("sections.store")}}" method="post" >
			{{-- @method('PUT') --}}

			<div class="form-group">
			  <label for="exampleFormControlInput1">اسم القسم</label>
			  <input type="text" name="section_name" class="form-control" id="exampleFormControlInput1" >
			</div>
		
			<div class="form-group">
			  <label for="exampleFormControlTextarea1">وصف وملاحظات</label>
			  <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
			</div>
		  {{-- --------------------------------- --}}
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
		  @csrf
			
		 <input type="submit"  type="button" class="btn btn-primary" value="اضافة">	
		  
		</div>

	</form>

	  </div>
	</div>
  </div>
{{-- -------------------------------------------------------------------------------- --}}
								<div class="card-body">
									<div class="table-responsive">
										<table id="example" class="table key-buttons text-md-nowrap">
											<thead>
												<tr>
													<th class="border-bottom-0">رقم التسلسل</th>
													<th class="border-bottom-0">اسم القسم</th>
													<th class="border-bottom-0">الوصف</th>
													<th class="border-bottom-0">التحكم</th>
													<th class="border-bottom-0">بواسطة</th>
												</tr>
											</thead>
											<tbody>
												<?php $a=0; ?>
												@foreach ($sections as $section)
												<tr>
													<td><?php echo $a=$a+1?></td>
													<td>{{$section->section_name}}</td>
													<td>{{$section->description}}</td>
													<td>
											
														<button class="btn btn-outline-success btn-sm"
															data-section_name="{{ $section->section_name }}" data-id="{{ $section->id }}"
															data-description="{{ $section->description }}" data-toggle="modal"
															data-target="#edit_Product">تعديل</button>
											
		
											
														<button class="btn btn-outline-danger btn-sm " data-id="{{ $section->id }}"
															data-section_name="{{ $section->section_name }}" data-toggle="modal"
															data-target="#modaldemo9">حذف</button>
												
	
													</td>
															
													<td>{{$section->Created_by}}</td>
												
												</tr>
												@endforeach
												


											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!--/div-->
	
						<!--div-->
					
					</div>

				</div>
				<!-- row closed -->

				  <!------------- edit ------------>
        <div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action='sections/update' method="post">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="title">اسم القسم :</label>

                                <input type="hidden" class="form-control" name="id" id="id" value="">

                                <input type="text" class="form-control" name="section_name" id="section_name">
                            </div>

                            <div class="form-group">
                                <label for="des">وصف وملاحظات :</label>
                                <textarea name="description" cols="20" rows="5" id='description'
                                    class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
  <!----------------------------------- delete------------------------------->
  <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
	  <div class="modal-content">
		  <div class="modal-header">
			  <h5 class="modal-title">حذف المنتج</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
			  </button>
		  </div>
		  <form action="sections/destroy" method="post">
			  {{ method_field('delete') }}
			  {{ csrf_field() }}
			  <div class="modal-body">
				  <p>هل انت متاكد من عملية الحذف ؟</p><br>
				  <input type="hidden" name="id" id="id" value="">
				  <input class="form-control" name="section_name" id="section_name" type="text" readonly>
			  </div>
			  <div class="modal-footer">
				  <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
				  <button type="submit" class="btn btn-danger">تاكيد</button>
			  </div>
		  </form>
	  </div>
  </div>
</div>



			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection

@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script>
	$('#edit_Product').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var section_name = button.data('section_name')
		var id = button.data('id')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #section_name').val(section_name);
		modal.find('.modal-body #description').val(description);
		modal.find('.modal-body #id').val(id);
	})


	$('#modaldemo9').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var section_name = button.data('section_name')
		var modal = $(this)

		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #section_name').val(section_name);
	})
</script>

@endsection
