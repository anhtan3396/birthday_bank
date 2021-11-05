
@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Chỉnh sửa dữ liệu</h4>
@endsection
@section('content') 
<div class="bg-form">
    <!-- Form danh sách -->
    <form class="form-horizontal" method="post">
        {{ csrf_field() }}
        <fieldset>
        <!-- key -->
        <div class="form-group">
            <label class="col-md-4 control-label">Từ khóa</label>
            <div class="col-md-6">
                <select name="s_key" class="form-control" disabled>
                    @foreach($array as $row)
                        <option value="{{$row}}" {{ $setting->s_key==$row? 'selected' : '' }}>{{$row}}</option>
                    @endforeach
                </select>
                @if ($errors->has('s_key'))
                <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('s_key') }}</strong>
                </span>
                @endif
            </div>                              
        </div>
        <hr>
        <!-- END key -->
        <!-- value -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="comparison">Giá trị</label>
            <div class="col-md-6">
                    <input name="s_value" type="text" class="form-control" value="{{ old('s_value',$setting->s_value) }}">
                @if ($errors->has('s_value'))
                <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('s_value') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <hr>
        <!-- value-->
        <!-- name -->
        <div class="form-group">
            <label class="col-md-4 control-label">Giá trị hiển thị</label>
            <div class="col-md-6">
                <input name="s_name" type="text" class="form-control" value="{{ old('s_name',$setting->s_name) }}">
                @if ($errors->has('s_name'))
                <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('s_name') }}</strong>
                </span>
                @endif
            </div>                              
        </div>
        <hr>
        </fieldset>
    <!-- /.box-body -->
        <!-- Button -->
        <div class="sidebar-footer hidden-small">
            <div class="form-group">
                <!-- Button -->
                <div class="control-button">
                    <a href="{{ asset('settings/list') }}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-arrow-left"></span>Quay lại
                    </a>
                    <button id="submitButton" name="submitButton" class="btn btn-success">
                    <span class="glyphicon glyphicon-floppy-disk"></span>Lưu</button>
                </div>
                <!-- /End Button -->
            </div>
        </div>   
        <!-- /End Button -->
</form>
<!-- End danh sách -->
</div>
@endsection
