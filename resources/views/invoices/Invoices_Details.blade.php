@extends('layouts.master')

@section('title', 'قائمة الفواتير')

<!-- Internal Data table css -->
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير</span>
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

            <div class="panel panel-primary tabs-style-2">
                <div class=" tab-menu-heading">
                    <div class="tabs-menu1">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs main-nav-line">
                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">الفاتورة</a></li>
                            <li><a href="#tab5" class="nav-link" data-toggle="tab">التفاصيل</a></li>
                            <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body main-content-body-right border">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab4">
                            <div style="overflow-x:auto;">

                                <table class="table table-striped table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">رقم التسلسل</th>
                                            <th scope="col">رقم الفاتورة</th>
                                            <th scope="col">تاريخ الفاتورة</th>
                                            <th scope="col">تاريخ الاستحقاق</th>
                                            <th scope="col">المنتج</th>
                                            <th scope="col">القسم</th>
                                            <th scope="col">مبلغ التحصيل</th>
                                            <th scope="col">مبلغ العمولة</th>
                                            <th scope="col">الخصم</th>
                                            <th scope="col">معدل الضريبة</th>
                                            <th scope="col">قيمة الضريبة</th>
                                            <th scope="col">الاجمالي</th>
                                            <th scope="col">الحالة</th>
                                            {{-- <th scope="col">قيمة الحالة</th> --}}
                                            <th scope="col">ملاحظات</th>
                                            <th scope="col">المستخدم</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td>{{ $invoice->id }}</td>
                                        <td>
                                            <a href="{{ route('details.show', $invoice->id) }}"> {{ $invoice->invoice_number }}</a>
                                           
                                        </td>
                                        <td>{{ $invoice->invoice_Date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>
                                            {{ $invoice->sections->section_name }}
                                        </td>
                                        <td>{{ $invoice->Amount_collection }}</td>
                                        <td>{{ $invoice->Amount_Commission }}</td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->tax_rate }}</td>
                                        <td>{{ $invoice->tax_value }}</td>
                                        <td>{{ $invoice->Total }}</td>
                                        <td
                                            class="{{ $invoice->value_status == 2 ? 'text-danger' : ($invoice->value_status == 1 ? 'text-success' : 'text-warning') }}">
                                            {{ $invoice->Status }}
                                        </td>
                                        {{-- <td>{{$invoice->value_status}}</td> --}}
                                        <td>{{ $invoice->note }}</td>
                                        <td>{{ $invoice->created_by }}</td>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                        <div class="tab-pane" id="tab5">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">رقم التسلسل</th>
                                        <th scope="col">رقم الفاتورة</th>
                                        <th scope="col">المنتج</th>
                                        <th scope="col">الحالة</th>
                                        <th scope="col">تاريخ الدفع</th>
                                        <th scope="col">تاريخ الاضافة</th>
                                        <th scope="col">ملاحظات</th>
                                        <th scope="col">المستخدم</th>
                                    </tr>
                                </thead>
                                @php
                                    $id = 1;
                                @endphp
                                @foreach ($invoices_details as $invoices_details)
                                    <tbody>
                                        <td>{{ $id++ }}</td>
                                        <td>{{ $invoices_details->invoice_number }}</td>
                                        <td>{{ $invoices_details->product }}</td>
                                        <td
                                            class="{{ $invoices_details->Value_Status == 2 ? 'text-danger' : ($invoices_details->Value_Status == 1 ? 'text-success' : 'text-warning') }}">
                                            {{ $invoices_details->Status }}
                                        </td>
                                        <td>{{ $invoices_details->Payment_Date }}</td>
                                        <td>{{ $invoices_details->created_at }}</td>
                                        <td>{{ $invoices_details->note }}</td>
                                        <td>{{ $invoices_details->created_by }}</td>
                                    </tbody>
                                @endforeach

                            </table>

                        </div>
                        <div class="tab-pane" id="tab6">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">رقم التسلسل</th>
                                        <th scope="col">الملف المرفق</th>
                                        <th scope="col">رقم الفاتورة</th>
                                        <th scope="col">المستخدم</th>
                                    </tr>
                                </thead>
                                @php
                                    $id = 1;
                                @endphp
                                @foreach ($invoices_attachments as $invoices_attachments)
                                    <tbody>
                                        <td>{{ $id++ }}</td>
                                        <td>
                                            <a href="{{ url("perview/$invoices_attachments->invoice_number/$invoices_attachments->file_name") }}"
                                                class="btn btn-primary btn-sm" target='_blank'>عرض</a>
                                            <a href="{{ url("download/$invoices_attachments->invoice_number/$invoices_attachments->file_name") }}"
                                                class="btn btn-success btn-sm">تحميل</a>
                                            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteModal"
                                                data-id="{{ $invoices_attachments->id }}">حذف</a>

                                        </td>
                                        <td>{{ $invoices_attachments->invoice_number }}</td>
                                        <td>{{ $invoices_attachments->Created_by }}</td>

                                    </tbody>
                                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">تحذير</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل أنت متأكد من حذف المرفق ؟</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">إالغاء</button>
                                                    <form
                                                        action="{{ route('attachments.destroy', $invoices_attachments->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">حذف</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </table>

                            <form action="{{ route('attachments.update', $invoice->id) }}" method="post"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @method('PUT')
                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                <h5 class="card-title">اضافة مرفق</h5>

                                <div class="col-sm-12 col-md-12">
                                    <input type="file" name="pic" class="dropify my-dropify"
                                        accept=".pdf,.jpg, .png, image/jpeg, image/png" />
                                </div><br>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">حفظ المرفق</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!--/div-->

        <!--div-->

    </div>

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var form = $(this).find('form');
                var action = form.attr('action');
                form.attr('action', action.replace('__ID__', id));
            });
        });
    </script>

@endsection
