
@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Bảng xếp hạng tháng {{ date("m") }}</h4>
@endsection
@section('content')     

<!-- Bảng hiển thị danh sách -->
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-striped custab">
            <thead>
                <tr>
                    <th>Số thứ tự</th>
                    <th>Vị thứ</th>
                    <th>Họ và tên</th>
                    <th>Số điểm</th>
                    <th>Ngày đạt điểm</th>

                </tr>
            </thead>
            <tbody>
                @foreach($listTops as $top)
                <tr>       
                    <td>{{ $top['rank'] }}</td>
                    <td>Thứ {{ $top['rank'] }}</td>
                    <td>{{ $top['nick_name'] }}</td>
                    <th>{{ $top['sum_total_right_answers'] }}</th>
                    <th>{{ $top['max_test_date'] }}</th>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Phân trang -->
       {{$listTops->setPath('topOfMonth')->render() }}
    <!-- /End Phân trang -->
    </div>
</div>
<!-- /End Bảng hiển thị danh sách bài test -->
@endsection