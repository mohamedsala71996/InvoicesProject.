@extends('layouts.master')

@section('title', 'الفواتير المدفوعة')

<!-- Internal Data table css -->
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الفواتير المدفوعة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')


    <!-- row -->
    <div class="row">
        @if (session()->has('update'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('update') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session()->has('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('status') }}</strong>
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

        <!--/div-->

        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                        اضافة فاتورة
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-bottom-0">رقم التسلسل</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="border-bottom-0">المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">مبلغ التحصيل</th>
                                    <th class="border-bottom-0">مبلغ العمولة</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">معدل الضريبة</th>
                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                    <th class="border-bottom-0">الاجمالي</th>
                                    <th class="border-bottom-0">الحالة</th>
                                    {{-- <th class="border-bottom-0">قيمة الحالة</th> --}}
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">التحكم</th>
                                    <th class="border-bottom-0">المستخدم</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $id = 1; ?>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $id++ }}</td>
                                        <td>
                                            <a href="{{ route('details.show', $invoice->id) }}">{{ $invoice->invoice_number }}</a>
                                        </td>
                                        <td>{{ $invoice->invoice_Date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>{{ $invoice->sections->section_name }}</a>
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
                                        <td>
                                            {{-- <div class="dropdown">
															<button class="btn btn-sm btn-primary">خيارات</button>
															<div class="dropdown-content">
																<a href="{{route("invoices.edit",$invoice->id)}}" onclick="editItem()">تعديل</a>
															</div>
															<div class="dropdown-content">
																<a href="{{route("invoices.edit",$invoice->id)}}" onclick="editItem()">حذف</a>
															</div>
														</div> --}}

                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    اختيار العملية
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a href="{{ route('invoices.edit', $invoice->id) }}"
                                                        class="dropdown-item">تعديل</a>
                                                    <div class="dropdown-divider"></div>
                                                    <button type="button" class="dropdown-item" data-toggle="modal"
                                                        data-target="#deleteModal">حذف</button>
                                                    <a href="{{ route('details.edit', $invoice->id) }}"
                                                        class="dropdown-item">تغيير حالة الدفع</a>
                                                </div>
                                            </div>
                    </div>


                    </td>
                    <td>{{ $invoice->created_by }}</td>
                    </tr>
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="deleteForm" action="{{ route('invoices.destroy', $invoice->id) }}"
                                        method="POST">
										@method("DELETE")
                                        {{ csrf_field() }}
                                        <input type="hidden" name="itemId" value="123">
                                        <!-- Replace with the actual item ID -->
                                        <p>هل انت متأكد من حذف الفاتورة؟</p>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                    <button type="submit" form="deleteForm" class="btn btn-danger">حذف</button>
                                </div>
                            </div>
                        </div>
                    </div>
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

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
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
    <script>
        function editItem() {
            // Add your edit logic here
        }
    </script>
@endsection
