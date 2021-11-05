<?php
use App\Models\MSetting;
use App\Repositories\SettingRepository;
$setting = new MSetting();
$settingRepository = new SettingRepository($setting);
function isChecked($now, $arrOld) {

    if ($now == $arrOld)
        return true;


    return false;
}

$types = array(
    0 => 'Luyện tập',
    1 => 'Bài thi'
);
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
    <h4>Danh sách từ vựng</h4>
@endsection
@section('content')
    <div class="bg-form">
        <form class="form-horizontal">
            <fieldset>
                <!-- Loại chữ viết -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Hiragana</label>
                    <div class="col-md-6">
                        <input class="form-control" name="hiragana" type="text" value="{{ old('hiragana', $hiragana) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Katakana</label>
                    <div class="col-md-6">
                        <input class="form-control" name="katakana" type="text" value="{{ old('katakana', $katakana) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Kanji</label>
                    <div class="col-md-6">
                        <input class="form-control" name="kanji" type="text" value="{{ old('kanji', $kanji) }}">
                    </div>
                </div>
                <!-- /End Loại chữ viết -->
                <!-- Nghĩa -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="appendUrlParams">Dịch nghĩa</label>
                    <div class="col-md-6">
                        <input class="form-control" name="meaning" type="text" value="{{ old('meaning', $meaning) }}">
                    </div>
                </div>
                <!-- /End Nghĩa -->
                <!-- Button -->

                <div class="form-group">
                    <label class="col-md-4 control-label" for="appendUrlParams">Loại</label>
                    <div class="col-md-5" name="practice">
                        <div class="ckbox">
                            <input type="checkbox"
                                   name="is_type_practice"
                                   id="is_type_practice"
                                   value="1"
                                   @if(isChecked($practice,1)) checked @endif
                            >

                            <label for="is_type_practice">
                                Luyện tập
                            </label>
                        </div>

                        <div class="ckbox">
                            <input type="checkbox"
                                   name="is_type_test"
                                   id="is_type_test"
                                   value="1"
                                   @if(isChecked($test,1)) checked @endif
                            >

                            <label for="is_type_test">
                                Bài thi
                            </label>
                        </div>
                    </div>

                </div>
                <!-- Trình độ -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="appendUrlParams">Cấp độ</label>
                    <div class="col-md-5" name = "levels">
                        <div class="ckbox">
                            <input type="checkbox"
                                   name="is_n1"
                                   id="is_n1"
                                   value="1"
                                   @if(isChecked($N1,1)) checked @endif
                            >
                            <label for="is_n1">
                                N1
                            </label>
                        </div>

                        <div class="ckbox">
                            <input type="checkbox"
                                   name="is_n2"
                                   id="is_n2"
                                   value="1"
                                   @if(isChecked($N2,1)) checked @endif
                            >
                            <label for="is_n2">
                                N2
                            </label>
                        </div>


                        <div class="ckbox">
                            <input type="checkbox"
                                   name="is_n3"
                                   id="is_n3"
                                   value="1"
                                   @if(isChecked($N3,1)) checked @endif
                            >
                            <label for="is_n3">
                                N3
                            </label>
                        </div>


                        <div class="ckbox">
                            <input type="checkbox"
                                   name="is_n4"
                                   id="is_n4"
                                   value="1"
                                   @if(isChecked($N4,1)) checked @endif
                            >
                            <label for="is_n4">
                                N4
                            </label>
                        </div>


                        <div class="ckbox">
                            <input type="checkbox"
                                   name="is_n5"
                                   id="is_n5"
                                   value="1"
                                   @if(isChecked($N5,1)) checked @endif
                            >
                            <label for="is_n5">
                                N5
                            </label>
                        </div>
                    </div>
                </div>
                <!-- /End Trình độ -->
                <!-- Button -->
                <div class="form-group">
                    <!-- Button -->
                    <div class="col-md-10 control-button">
                        <button id="searchButton" name="searchButton" class="btn btn-search">
                            <span class="glyphicon glyphicon-search"></span>Tìm kiếm
                        </button>
                        <a href="{{ asset('bunpos') }}" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>Reset</a>
                    </div>
                    <!-- /End Button -->
                </div>
                <!-- /End Button -->
    </div>
    <!-- /End Nhóm -->
    <hr>
    </fieldset>
    </form>
    <!--/End Form tìm kiếm -->
    </div>
    <!-- /End Info search -->
    <!-- Button -->
    <div class="col-md-4 btn-create">
        <a href="{{ asset ('bunpos/add') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>Tạo từ vựng mới</a>
    </div>
    <!-- /End Button -->
    <!-- Bảng hiển thị danh sách từ vựng -->
    <div class="container-fluid">
    <div class="table-responsive">
            <table class="table table-striped custab">
                <thead>
                <tr>
                    <th class="text-center">
                        <div class="ckbox">
                            <input id="cb_All" name="btSelectAll" type="checkbox">
                            <label for="cb_All"></label>
                        </div>
                    </th>
                    <th>ID</th>
                    <th>Hiragana</th>
                    <th>Katakana</th>
                    <th>Kanji</th>
                    <th>Nghĩa của từ</th>
                    <th>Loại</th>
                    <th>Cấp độ</th>
                    <th>Ngày tạo</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>

                @foreach($bunpos as $bunpo)
                    <?php
                    $bunpoType = '';
                    if($bunpo->is_type_practice == 1)
                    {
                        $bunpoType .= $types[0] . '';
                        $bunpoType .= $bunpo->is_type_test != 1 ? '' : ',';
                    }
                    if($bunpo->is_type_test == 1)
                    {
                        $bunpoType .= $types[1] . '';
                    }
                    $bunpoLevel1 = $bunpo->is_n1 == 1 ? 'N1' : '';
                    $bunpoLevel2 = $bunpo->is_n2 == 1 ? 'N2' : '';
                    $bunpoLevel3 = $bunpo->is_n3 == 1 ? 'N3' : '';
                    $bunpoLevel4 = $bunpo->is_n4 == 1 ? 'N4' : '';
                    $bunpoLevel5 = $bunpo->is_n5 == 1 ? 'N5' : '';

                    $arr = array($bunpoLevel1, $bunpoLevel2, $bunpoLevel3, $bunpoLevel4, $bunpoLevel5);
                    $bunpoLevels = '';
                    $count = 1;
                    $lenght = 0;

                    foreach($arr as $row) {
                        if($row != '') {
                            $lenght++;
                        }
                    }

                    foreach ($arr as $row) {
                        if($row != '') {
                            if($lenght == $count) {
                                $bunpoLevels .= $row;
                            } else {
                                $bunpoLevels .= $row . ', ';
                            }
                            $count++;
                        }
                    }
                    ?>
                    <tr bunpo-id="{{ $bunpo->bunpo_id }}" id="bunpo_{{ $bunpo->bunpo_id }}">
                        <td class="text-center">
                            <div class="ckbox">
                                <input id="{{ $bunpo->bunpo_id }}" class="check-box" name="ckb" type="checkbox">
                                <label for="{{ $bunpo->bunpo_id }}"></label>
                            </div>
                        </td>
                        <td>{{ $bunpo->bunpo_id }}</td>
                        <td>{{ $bunpo->hiragana }}</td>
                        <td>{{ $bunpo->katakana }}</td>
                        <td>{{ $bunpo->kanji }}</td>
                        <td>{{ $bunpo->meaning }}</td>
                        <td>{{$bunpoType}}</td>
                        <td>{{$bunpoLevels}}</td>
                        <td>{{ $bunpo->created_time }}</td>
                        <td class="text-center">
                            <div class="btn-edit-bunpo btn btn-info btn-xs glyphicon glyphicon-edit"></div>
                            <div class="btn-delete-bunpo btn btn-danger btn-xs glyphicon glyphicon-remove"></div>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="btn-remove">
                <button name="btn_delete_all" url="{{ asset('bunpos/deleteall') }}" class="btn btn-danger" id="delete_all_bunpo" content="{{ csrf_token() }}">Xóa lựa chọn
                </button>
                <input type="hidden" id="_token" value="{{ csrf_token() }}" />
            </div>
            <!-- /End Button -->
            <!-- Phân trang -->
        {{ $bunpos->links() }}
        <!-- /End Phân trang -->
        </div>
    </div>
    <!-- /End Bảng hiển thị danh sách từ vựng -->
@endsection