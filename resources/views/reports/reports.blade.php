@extends('layouts.master')
@section('css')
    <style>
        .input-container {
            margin-top: 20px;
        }
    </style>
@endsection
@section('page-header')
@endsection
@section('content')
    <input type="radio" class="input-container" name="option" value="first" onclick="showInputs('first')" checked> بحث بنوع
    الفاتورة<br>
    <input type="radio" name="option" value="second" onclick="showInputs('second')"> بحث برقم الفاتورة<br><br>

    <form action="{{ route('getInvoices') }}" method="post">
        @csrf
        @method('GET')
        <div id="selectInput" class="input-container">
            <label for="select">اختر:</label>
            <select name='value_status'id="select">
                <option  @if (isset($status) && $status==4) selected @endif value="4">الكل</option>
                <option  @if (isset($status) && $status==1) selected @endif value="1">المدفوعة</option>
                <option @if (isset($status) && $status==3) selected @endif value="3">المدفوعة جزئيا</option>
                <option  @if (isset($status) && $status==2) selected @endif value="2">الغير مدفوعة</option>
            </select>
        </div>

        <div id="dateInput1">
            <label for="date1">من تاريخ:</label>
            <input type="date" value='{{$date1 ?? ""}}' name='date1'id="date1">
        </div>

        <div id="dateInput2">
            <label for="date2">إلى تاريخ:</label>
            <input type="date" value='{{$date2 ?? ""}}' name='date2' id="date2">
        </div>
        <div id="Input3">
            <button type="submit" onclick="searchTable()">بحث</button>
        </div>
    </form>

    <form action="{{ route('getInvoiceNumber') }}" method="post">
        @csrf
        @method('GET')

        <div id="searchInput" class="input-container" style="display: none;">
            <input type="text" placeholder='بحث برقم الفاتورة' id="searchInput" name="search">
            <input type="submit" onclick="searchTable()" value="بحث" id="search">
        </div>

    </form>

    @if (isset($invoice))
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
            </tbody>
        </table>
    @endif
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
@endsection
