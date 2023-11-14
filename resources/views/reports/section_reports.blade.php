@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    .header {
        margin-bottom: 20px;
    }

    .form-row {
        margin-bottom: 20px;
    }
</style>
@endsection
@section('page-header')
<h1 class="header">تقارير العملاء</h1>
@endsection
@section('content')

<form action="{{route("show_table")}}" method="POST">
    @csrf
    @method('GET')
    <div class="form-row">
        <div class="col">
            <label for="inputName" class="control-label">القسم</label>
            <select name="Section" class="form-control SlectBox" onclick="console.log($(this).val())"
                onchange="console.log('change is firing')" style="width: 100%;" data-live-search="true">
                <!--placeholder-->
                <option value="" selected disabled>حدد القسم</option>
                @foreach ($sections as $section)
                <option value="{{ $section->id }}"> {{ $section->section_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col">
            <label for="inputName" class="control-label">المنتج</label>

            <select id="product" name="product" class="form-control SlectBox">
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="startDate">Start Date:</label>
            <input type="date" name="date1" id="startDate" class="form-control">
        </div>

        <div class="form-group col-md-3">
            <label for="endDate">End Date:</label>
            <input type="date" name="date2" id="endDate" class="form-control">
        </div>
    </div>

    <input type="submit" value="بحث" class="btn btn-primary">

</form>

<div></div>
@if (isset($invoices))
<table id="myTable" class="table table-striped table-bordered">
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
        </tr>
    </thead>
    <tbody>
        <?php $id = 1; ?>
        @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $id++ }}</td>
                <td>{{ $invoice->invoice_number }}</td>
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
            </tr>
        @endforeach

    </tbody>
</table>
@endif



    <!-- row -->
    <div class="row">

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')

<script>
    $(document).ready(function() {
        $('select[name="Section"]').on('change', function() {
            var SectionId = $(this).val();
            if (SectionId) {
                $.ajax({
                    url: "{{ URL::to('section') }}/" + SectionId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="product"]').empty().append('<option value="1">' + "الكل" + '</option>');
                        $.each(data, function(key, value) {
                            $('select[name="product"]').append('<option value="' +
                                value + '">' + value + '</option>');
                        });
                    },
                });

            } else {
                console.log('AJAX load did not work');
            }
        });

    });

</script>
<script>
    function showInputs(option) {
        var selectInput = document.getElementById("selectInput");
        var dateInput1 = document.getElementById("dateInput1");
        var dateInput2 = document.getElementById("dateInput2");
        var Input3 = document.getElementById("Input3");
        var searchInput = document.getElementById("searchInput");

        if (option === "first") {
            selectInput.style.display = "block";
            dateInput1.style.display = "block";
            dateInput2.style.display = "block";
            Input3.style.display = "block";
            searchInput.style.display = "none";
        } else if (option === "second") {
            selectInput.style.display = "none";
            dateInput1.style.display = "none";
            dateInput2.style.display = "none";
            Input3.style.display = "none";
            searchInput.style.display = "block";
        }
    }
</script>
<script>
    function searchTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

<script>
    $(document).ready(function() {
        $('.SlectBox').select2();
    });
</script>



@endsection