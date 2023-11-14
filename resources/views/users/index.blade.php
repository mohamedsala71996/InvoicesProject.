@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    {{-- @extends('layouts.app') --}}
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>ادارة المستخدمين</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('users.create') }}"> اضافة مستخدم جديد</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>رقم التسلسل</th>
            <th>الاسم</th>
            <th>البريد الإلكتروني</th>
            <th>الأدوار</th>
            <th>الحالة</th>
            <th width="280px">التحكم</th>
        </tr>
        @foreach ($data as $key => $user)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $v)
                            <span class="badge rounded-pill bg-light">{{ $v }}</span>
                        @endforeach
                    @endif
                </td>
                <td>{{ $user->status }}</td>

                <td>
                    <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">عرض</a>
                    <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">تعديل</a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                    {!! Form::submit('حذف', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>
    {!! $data->render() !!}
    <p class="text-center text-primary"><small>Tutorial by LaravelTuts.com</small></p>
@endsection
@section('content')
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
@endsection
