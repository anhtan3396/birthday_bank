<?php
    use App\Models\MSetting;
    $setting = new MSetting();
    $levels = MSetting::where('s_key','LEVEL')->get();
    $types  = MSetting::where('s_key','QUIZ_TYPE')->get();
    $groups  = MSetting::where('s_key','QUIZ_KBN')->get();
    $status  = MSetting::where('s_key','PUBLIC_STT')->get();
    $testPrice  = MSetting::where('s_key','DEFAULT_TEST_PRICE')->first();
    
?>
@extends('Backend.masterpage.masterpage')
@section('content')
  {{ csrf_field() }}
@section('titleForm')
    <h4>Tạo bài Test</h4>
@endsection
@section('content') 
<div class="bg-form">
    <!-- form start -->
    <div class="form-horizontal">
        <fieldset>
            <div class="form-group">
                <label class="col-md-2 control-label" for="testName">Tên bài Test</label>
                <div class="col-md-10">
                    <input id="testId" name="testId" type="hidden">
                    <input id="testName" name="testName" type="text" placeholder="Tên bài Test" class="form-control">
                    <span class="help-block alert alert-danger" >
                        <strong class="error testName"></strong>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="testName">Hình ảnh</label>
                <div class="col-md-10">
                    <div class="input-group image-preview">
                        <input type="text" class="form-control image-preview-filename" disabled="disabled">
                        <span class="input-group-btn">
                            <!-- image-preview-clear button -->
                            <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                <span class="glyphicon glyphicon-remove"></span>Xóa
                            </button>
                            <!-- file-input -->
                            <div class="btn btn-default file-input">
                                <span class="glyphicon glyphicon-folder-open"></span>
                                <span class="file-input-title">Chọn hình</span>
                                <input type="file" accept="image/png, image/jpeg, image/gif" id="testImageIcon" name="input-file-preview"/> 
                            </div>
                        </span>
                    </div>
                    <span class="help-block alert alert-danger" >
                        <strong class="error testImageIcon"></strong>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="levelId">Trình độ</label>
                <div class="col-md-3">
                    <select id="levelId" name="levelId" class="form-control">
                        @foreach($levels as $level)
                            <option data-s_name="{{ $level->s_name}}" value="{{ $level->s_value }}" >{{ $level->s_name }}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-md-2 control-label" for="testType">Loại</label>
                <div class="col-md-3">
                    <select id="testType" name="testType" class="form-control">
                    @foreach($types as $type)
                        <option data-s_name="{{ $type->s_name}}" value="{{ $type->s_value }}">{{ $type->s_name }}</option>
                    @endforeach  
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="publicDate">Ngày đăng</label>
                <div class="col-md-3">
                    <input id="publicDate" name="publicDate" type="date" class="form-control">
                </div>
                <label class="col-md-2 control-label" for="publicStatus">Trạng thái</label>
                <div class="col-md-3">
                    <select id="publicStatus" name="publicStatus" class="form-control">
                    @foreach($status as $st)
                        <option data-s_name="{{ $st->s_name}}" value="{{ $st->s_value }}">{{ $st->s_name }}</option>
                    @endforeach  
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="testPrice">Giá xu</label>
                <div class="col-md-3">
                    <input id="testPrice" name="testPrice" type="text" value="{{$testPrice->s_name}}" class="form-control">
                    <span class="help-block alert alert-danger" >
                            <strong class="error testPrice"></strong>
                    </span>
                </div>
                
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="testDescription">Mô tả</label>
                <div class="col-md-10">
                    <textarea id="testDescription" name="testDescription" rows="5" placeholder="Mô tả..." class="fullname form-control"></textarea>
                    <span class="help-block alert alert-danger" >
                        <strong class="error testDescription"></strong>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Nội dung câu hỏi</label>
                <div class="col-md-10" id="listQuestion">
                    @foreach($groups as $group)
                        <div class="box test-group" data-id="{{ $group->s_value }}" data-name="{{ $group->s_name }}" id="group_{{ $group->s_value }}">
                            <div class="box-header with-border">
                                <div class="pull-left col-md-10">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h4 class="group-name">{{ $group->s_name }}</h4>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="col-md-5 control-label" for="limit-time">Thời gian làm bài</label>
                                                <div class="col-md-4">
                                                    <select name="limit-time" class="form-control limit-time">
                                                        <option value="30">30 phút</option>
                                                        <option value="45">45 phút</option>
                                                        <option value="60">60 phút</option>
                                                        <option value="75">75 phút</option>
                                                        <option value="90">90 phút</option>
                                                        <option value="120">120 phút</option>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="box-tools pull-right">
                                    <div data-toggle="collapse" data-target=".group_body_{{ $group->s_value }}" aria-expanded="false" aria-controls=".group_body_{{ $group->s_value }}" class="btn btn-default btn-xs glyphicon glyphicon-minus"></div>
                                </div>
                            </div>
                            <div class="box-body mondai-group collapse in group_body_{{ $group->s_value }}">
                                <span class="help-block alert alert-danger" >
                                    <strong data-control-collapse=".group_body_{{ $group->s_value }}" class="error group_{{ $group->s_value }}"></strong>
                                </span>
                            </div>
                            <div class="box-footer collapse in group_body_{{ $group->s_value }}">
                                <button onclick="showModalMondai({{$group->s_value}});" data-toggle="modal" data-target="#modalMondai" type="button" class="btn btn-info btn-sm" >Thêm mondai</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="sidebar-footer hidden-small">
                <div class="form-group">
                    <div class="control-button">
                        <a href="{{ asset('test') }}" class="btn btn-primary">
                            <span class="glyphicon glyphicon-arrow-left"></span>Quay lại
                        </a>
                        <button class="btn btn-success" onclick="save();">
                            <span class="glyphicon glyphicon-floppy-disk"></span>Lưu bài Test
                        </button>
                        <button id="btnUploadFile" class="btn btn-info">
                            <span class="fa fa-cloud-upload"></span>Import bài Test
                        </button>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
<div class="modal fade" id="modalQuestion">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
					Thêm câu hỏi <span class="quiz-group"></span>
				</h4>
            </div>
            <div class="box-body form-horizontal collapse in" id="search-condition">
                <fieldset>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="searchQuizLevel">Trình độ</label>
                        <div class="col-md-9">
                        @foreach($levels as $level)
                            <div class="ckbox">
                                <input type="checkbox"
                                    class="searchQuizLevel" 
                                    id="searchQuizLevel{{ $level->s_value }}"
                                    value="{{ $level->s_value }}"
                                >
                                <label for="searchQuizLevel{{ $level->s_value }}"><span></span>{{ $level->s_name }}</label>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="searchQuizType">Loại</label>
                        <div class="col-md-9">
                            @foreach($types as $type)
                            <div class="ckbox">
                                <input type="checkbox" 
                                    class="searchQuizType"  
                                    id="searchQuizType{{ $type->s_value }}"  
                                    value="{{ $type->s_value }}"
                                >
                                <label for="searchQuizType{{ $type->s_value }}"><span></span>{{ $type->s_name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="searchQuizGroup">Nhóm</label>
                        <div class="col-md-9">
                            @foreach($groups as $group)
                            <div class="ckbox">
                                <input type="checkbox" 
                                    class="searchQuizGroup"  
                                    id="searchQuizGroup{{ $group->s_value }}"  
                                    value="{{ $group->s_value }}"
                                >
                                <label for="searchQuizGroup{{ $group->s_value }}"><span></span>{{ $group->s_name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>   
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="searchQuizContent">Nội dung câu hỏi</label>
                        <div class="col-md-9">
                            <input class="form-control col-md-10" id="searchQuizContent" type="text" placeholder="Nhập từ khóa cần tìm kiếm">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="searchQuizFromDate">Ngày đăng(Từ)</label>
                        <div class="col-md-4">
                            <input class="form-control" id="searchQuizFromDate" type="date">
                        </div>
                        <label class="col-md-1 control-label" for="searchQuizToDate">Đến</label>
                        <div class="col-md-4">
                            <input class="form-control" id="searchQuizToDate" type="date">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="pull-right">
                            <button onclick="return searchQuest();" class="btn btn-primary">
                                <i class="fa fa-search-plus"></i> Tìm kiếm
                            </button>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="box box-header with-border list-quiz">
                <h4>Danh sách câu hỏi</h4>
                <div class="box-tools pull-right">
                    <div data-toggle="collapse" data-target="#search-condition"  class="btn btn-default btn-xs glyphicon glyphicon-circle-arrow-up"></div>
                </div>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button onclick="addQuestToMondai();" data-dismiss="modal" type="button" 
				class="btn btn-primary">
					Xác nhận
				</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMondai">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Thêm Mondai cho nhóm <span class="group-name"></span></h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <span class="help-block alert alert-danger">
                    </span>
                </div>
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="mondaiName">Tên</label>
                        <div class="col-md-10">
                            <input id="mondaiName" name="mondaiName" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="mondaiDescription">Mô tả</label>
                        <div class="col-md-10">
                            <textarea rows="5" id="mondaiDescription" name="mondaiDescription" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button onclick="addMondaiToGroupFromModal();" type="button" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>
<input style="display:none" type="file" accept=".xlsx" id="testFileImport"/> 
<div class="overlay">
    <div class="loading">
    </div>
</div>
<script>
    function showModalMondai(groupId, mondai) {
        var $mondal = $("#modalMondai");
        $mondal.find(".help-block").hide();
        $mondal.find('.group-name').text($("#group_" + groupId + " .group-name").text());
        $mondal[0].groupId = groupId;
        if(mondai) {
            $mondal[0].editFlag = true;
            $mondal[0].mondaiId = mondai.id;
            $("#modalMondai #mondaiName").val(mondai.name);
            $("#modalMondai #mondaiDescription").val(mondai.description);
        } else {
            $("#mondaiName").val('');
            $("#mondaiDescription").val('');
            $mondal[0].editFlag = false;
            if(!$mondal[0].currentMondaiId) {
                $mondal[0].currentMondaiId = 1;
            }
            $mondal[0].mondaiId = $mondal[0].currentMondaiId;
            $mondal[0].currentMondaiId++;
        }
    }

    function checkValidationMondai(callback) {
        ajaxPost(
            "{{ asset('/test/checkValidationMondai')}}"
            , {name:$("#mondaiName").val(), description:$("#mondaiDescription").val()}
            , function(result) {
                var $mondal = $("#modalMondai");
                var $message = $mondal.find(".help-block.alert");
                $message.html("");
                if(result.resultCode == 0) {
                    callback();
                } else {
                    $message.css("display", "block");
                    $.each(result.messages, function(id, messages){
                        var message = null;
                        if(typeof messages == 'object') {
                            message = messages[0];
                        } else {
                            message = messages;
                        }
                        $message.append("<li>" + message + "</li>");
                    });
                    $message.show();
                }
            }
            ,  function(data) {
                alert("Đã xảy ra lỗi trong quá trình tải kết nối đến server!")
            }
        );
    }
    
    function addMondaiToGroupFromModal() {
        checkValidationMondai(function(){
            var $mondal = $("#modalMondai");
            var groupId = $mondal[0].groupId;
            var mondaiId = $mondal[0].mondaiId;
            var $mondai = null;
            var name = $("#mondaiName").val();
            var description = $("#mondaiDescription").val();
            $mondai = null;
            if($mondal[0].editFlag) {
                $mondai = $('#mondai_' + groupId + '_' + mondaiId);
                $mondai.find(".box-header h4.mondai-name").text($("#mondaiName").val());
                $mondai.find(".box-header div.mondai-description").text($("#mondaiDescription").val());
                var thiz = $mondai[0];
                thiz.data = {
                    groupId: groupId,
                    id: mondaiId,
                    name: name,
                    description: description
                };
            } else {
                $mondai = addMondaiToGroup(groupId, mondaiId, name, description);
            }
            var $mondaiDescription = $mondai.find(".box-header div.mondai-description");
            if(description.length <= 0) {
                $mondaiDescription.hide();
            } else {
                $mondaiDescription.show();
            }
            $mondal.modal("toggle");
            $(window).scrollTop($mondai.offset().top - 90);
        });
    }

    function addMondaiToGroup(groupId, mondaiId, name, description) {
        var $mondai = $(
            '<div class="box mondai" id = "mondai_' + groupId + '_' + mondaiId + '">'
            + '<div class="box-header with-border">'
            + '    <h4 class="mondai-name">'+name+'</h4>'
            + '    <div class="mondai-description">'+description+'</div>'
            + '    <div class="box-tools pull-right">'
            + '        <div class="btn edit btn-default btn-xs glyphicon glyphicon-edit"></div>'
            + '        <div class="btn delete-mondai btn-default btn-xs glyphicon glyphicon-remove"></div>'
            + '        <div data-toggle="collapse" data-target=".mondai_collapse_' + groupId + '_' + mondaiId + '" aria-expanded="false" aria-controls=".mondai_collapse_' + groupId + '_' + mondaiId + '" class="btn btn-default btn-xs glyphicon glyphicon-minus"></div>'
            + '    </div>'
            + '</div>'
            + '<div class="box-body collapse in mondai_collapse_' + groupId + '_' + mondaiId + '">'
            + '<span class="help-block alert alert-danger" >'
            + '    <strong data-control-collapse=".group_body_' + groupId + ',.mondai_collapse_' + groupId + '_' + mondaiId + '" class="error mondai_' + groupId + '_' + mondaiId + '"></strong>'
            + '</span>'
            + '</div>'
            + '<div class="box-footer collapse in mondai_collapse_' + groupId + '_' + mondaiId + '">'
            + '    <button onclick="showModalQuiz('+groupId+','+mondaiId+')" type="button" class="btn btn-primary btn-xs" >Thêm câu hỏi</button>'
            + '</div>'
        + '</div>');
        var $group = $("#group_" + groupId + " .box-body.mondai-group");
        $group.find(".help-block").hide();
        var $mondaiDescription = $mondai.find(".box-header div.mondai-description");
        if(description.length <= 0) {
            $mondaiDescription.hide();
        } else {
            $mondaiDescription.show();
        }
        $group.append($mondai);
        var thiz = $mondai[0];
        thiz.data = {
            groupId: groupId,
            id: mondaiId,
            name: name,
            description: description
        };
        return $mondai;
    }

    function initDefaultMondaiOfGroup() {
        var $mondal = $("#modalMondai")[0];
        if(!$mondal.currentMondaiId) {
            $mondal.currentMondaiId = 1;
        }
        $(".test-group").each(function(){
            var groupId = $(this).attr("data-id");
            var defaultNames = ['I', 'II'];
            for (var i = 0; i < defaultNames.length; i++) {
                addMondaiToGroup(groupId, $mondal.currentMondaiId, defaultNames[i], '');
                $mondal.currentMondaiId++;
            }
        });
        
    }

    function showModalQuiz(groupId, mondaiId) {
        $mondai = $('#mondai_' + groupId + '_' + mondaiId);
        var groupName = $mondai.parents(".test-group").find(".group-name").text();
        var mondaiName = $mondai.find(".mondai-name").text();
        var $modal = $("#modalQuestion");
        $modal.find(".modal-title").text("Thêm câu hỏi cho mondai " + mondaiName + " của nhóm " + groupName);
        var searchQuizLevel = $('#levelId').val();         
        var searchQuizType  = $('#testType').val();         
        $modal[0].groupId   = groupId;
        $modal[0].mondaiId  = mondaiId;
		$("#searchQuizLevel").val(searchQuizLevel);
		$("#searchQuizType").val(searchQuizType);
        $(".searchQuizGroup").each(function(){
            this.checked = (this.value == groupId);
        });
        $(".searchQuizLevel").each(function(){
            this.checked = (this.value == searchQuizLevel);
        });
        $(".searchQuizType").each(function(){
            this.checked = (this.value == searchQuizType);
        });
        var $questArea = $("#modalQuestion .modal-body");
        $questArea[0].pageInfos = {};
        loadQuest({
            groupId             : groupId,
            searchQuizLevel     : searchQuizLevel,
            searchQuizType      : searchQuizType,
        });
    }

    function loadQuest(conditions) {
        var $questArea = $("#modalQuestion .modal-body");
        if(!$questArea[0].pageInfos) {
            $questArea[0].pageInfos = {};
        }
        var url = conditions.url || "{{ asset('/test/loadQuizs')}}?page=1";
        if($questArea[0].pageInfos[url]) {
            $questArea.html("");
            // load from the cache data
            $questArea.append($questArea[0].pageInfos[url]);
            return;
        }
        var $modal      = $("#modalQuestion");
        var existQuizIds = [];
        $(".test-group .quest.item").each(function(){
            existQuizIds.push(this.data.quiz_id);
        });

        conditions.existQuizIds = existQuizIds.join(',');
        var $questArea = $("#modalQuestion .modal-body");
        ajaxPost(
            url
            , conditions
            , function(result) {
                 $questArea.html('');
                console.log(result);
                if(result.resultCode == 0) {
                    var data = result.data.data;
                    $questArea.append(result.pagination);
                    for (var i = 0; i < data.length; i++) {
                        var quest 	= data[i];
                        var $quest 	= $(createHtmlFromQuest(quest));
                        $quest[0].data = quest;
						$questArea.append($quest);
                    }
                    $questArea.append(result.pagination);
                    // save cache data
                    $questArea[0].pageInfos[url] = $questArea.children();
                } else {
                    $questArea[0].pageInfos[url] = null;
                    $questArea.html(result.message);
                }
                $('#modalQuestion').modal("show");
            }
            , function(data) {
                alert("Đã xảy ra lỗi trong quá trình tải câu hỏi, vui lòng thử lại lần nữa!")
            }
        );
    }
	
	function searchQuest(url) 
	{
        var $modal      = $("#modalQuestion");
        var getChecked  = function(selector) {
            var selected = [];
            $(selector).each(function(){
                if(this.checked) {
                    selected.push(this.value);
                }
            });
            return selected.join(",");
        }
        var groupId             = getChecked(".searchQuizGroup");
        var searchQuizLevel     = getChecked(".searchQuizLevel");
        var searchQuizType      = getChecked(".searchQuizType");
        var searchQuizContent	= $("#searchQuizContent").val();
		var searchQuizFromDate	= $("#searchQuizFromDate").val();
		var searchQuizToDate	= $("#searchQuizToDate").val();
        if(!url) {
            // reset cache data
            var $questArea = $("#modalQuestion .modal-body");
            $questArea[0].pageInfos = {};
        }
		loadQuest({
            groupId             : groupId,
            searchQuizLevel     : searchQuizLevel,
            searchQuizType      : searchQuizType,
            searchQuizContent   : searchQuizContent,
            searchQuizFromDate  : searchQuizFromDate,
            searchQuizToDate    : searchQuizToDate,
            url                 : url
        });
    }

    function createHtmlFromQuest(quest) {
        var htmlContent = '<div class="quest item">';
        htmlContent += '<div class="action">';
        htmlContent += '<div class="ckbox"><input type="checkbox" id="quizchk_'+quest.quiz_id+'" value="'+quest.quiz_id+'"><label for="quizchk_'+quest.quiz_id+'"><span></span></label></div>';
        htmlContent += '<div data-toggle="collapse" data-target="#quiz_'+quest.quiz_id+'" aria-expanded="false" aria-controls="quiz_'+quest.quiz_id+'" class="detail btn btn-default btn-xs glyphicon glyphicon-plus"></div>';
        htmlContent += '</div>';
        htmlContent += generateQuizDetail(quest);
        htmlContent += '<div class="quest-content">';
        htmlContent += '<div class="row">';
        htmlContent += quest.content;
        htmlContent += '</div>';
        if(quest.image) {
            htmlContent+= '<div class="row img"><img src="{{ URL::asset('upload/image/quiz')}}/'+quest.image+'" alt="image" width="100%"></div>';
        }
        if(quest.sound) {
            htmlContent+= '<div class="row audio"><audio controls><source src="{{ URL::asset('upload/audio/quiz')}}/'+quest.sound+'" type="audio/mp3" width="100%" ></audio></div>'
        }
        htmlContent += '<div class="row">';
        var ansCnt = 0;
        if(quest.ans1) {
            ansCnt++;
        }
        if(quest.ans2) {
            ansCnt++;
        }
        if(quest.ans3) {
            ansCnt++;
        }
        if(quest.ans4) {
            ansCnt++;
        }
        var colPart = Math.floor(12/ansCnt);
        if(quest.ans1) {
            htmlContent += '<div class="col col-xs-12 col-md-'+colPart+'">1) '+quest.ans1+'</div>';
        }
        if(quest.ans2) {
            htmlContent += '<div class="col col-xs-12 col-md-'+colPart+'">2) '+quest.ans2+'</div>';
        }
        if(quest.ans3) {
            htmlContent += '<div class="col col-xs-12 col-md-'+colPart+'">3) '+quest.ans3+'</div>';
        }
        if(quest.ans4) {
            htmlContent += '<div class="col col-xs-12 col-md-'+colPart+'">4) '+quest.ans4+'</div>';
        }
        htmlContent += '</div>';
        htmlContent += '</div>';
        htmlContent += '</div>';
        htmlContent += '</div>';
        return htmlContent;
    }
    function generateQuizDetail(quiz) {
        var html = '<div class="form-horizontal quiz-detail collapse" id="quiz_'+quiz.quiz_id+'">';
        html += '   <div class="form-group">';
        html += '        <label class="col-md-2 control-label">Trình độ</label>';
        html += '        <label id="detailLevel" class="col-md-2 control-label detail-view">'+quiz.level.s_name+'</label>';
        html += '    </div>';
        html += '    <div class="form-group">';
        html += '        <label class="col-md-2 control-label">Loại</label>';
        html += '        <label id="detailType" class="col-md-2 control-label detail-view">'+quiz.type.s_name+'</label>';
        html += '    </div>';
        html += '    <div class="form-group">';
        html += '        <label class="col-md-2 control-label">Nhóm</label>';
        html += '        <label id="detailGroup" class="col-md-2 control-label detail-view">'+quiz.group.s_name+'</label>';
        html += '    </div>';
        html += '    <div class="form-group">';
        html += '        <label class="col-md-2 control-label">Đáp án đúng</label>';
        html += '        <label id="detailQuestRightAns" class="col-md-10 control-label detail-view">'+quiz['ans' + quiz.right_ans]+'</label>';
        html += '    </div>';
        html += '    <div class="form-group">';
        html += '        <label class="col-md-2 control-label">Giải thích</label>';
        html += '        <label id="detailQuestDescription" class="col-md-10 control-label detail-view">'+(quiz.right_ans_exp ? quiz.right_ans_exp : '-')+'</label>';
        html += '    </div>';
        html += '</div>';
        return html;
    }
    function ajaxPost(url, params, callbackSuccess, callbackError, type = 'POST') {
        $(".overlay").show();
        $.ajax({
            type: type,
            url: url,
            data: params,
            ContentType: 'application/json',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $("input[name='_token'").val()
            },
            success: function (data) {
                $(".overlay").hide();
                if(callbackSuccess) {
                    callbackSuccess(data);
                }
            },
            error: function (data) {
                $(".overlay").hide();
                if(callbackError) {
                    callbackError(data);
                }
            }
        });
    }

    function repaireQuizInGroup($quiz, sortOrder) {
        var data = $quiz[0].data;
        var $questContent = $quiz.find('.quest-content');
        $questContent.addClass("in-mondai");
        var updownHtml = '<div class="sortup btn btn-default btn-xs glyphicon glyphicon-circle-arrow-up"></div><div class="sortdown btn btn-default btn-xs glyphicon glyphicon-circle-arrow-down"></div>';
        $questContent.before('<div class="order"><button type="button" class="btn btn-default btn-circle">'+sortOrder+'</button>' + updownHtml + '</div>');
        var $action = $quiz.find("div.action");
        $action.append('<div class="delete-quiz btn btn-default btn-xs glyphicon glyphicon-remove"></div>');
        $action.find("div.ckbox").remove();
    }

    function addQuestToMondai() {
        var $modal = $("#modalQuestion");
        var groupId = $modal[0].groupId;
        var mondaiId = $modal[0].mondaiId;
        var $mondai = $("#mondai_" + groupId + "_" + mondaiId + " .box-body");
        $mondai.find(".help-block").hide();
        var questCnt = $mondai.find('.quest.item').length || 0;
        var $questArea = $("#modalQuestion .modal-body");
        $.each($questArea[0].pageInfos, function(url, $page){
            $page.find(".action input").each(function(){
                if(this.checked) {
                    var $quest = $(this).parent().parent().parent();
                    $mondai.append($quest);
                    var sortOrder = ++questCnt;
                    repaireQuizInGroup($quest, sortOrder);
                }
            });
        });
        resetSortOrder($mondai);
    }
    
    var saveProcessingFlag = false;
    function save() {
        if(saveProcessingFlag) {
            return;
        }
        saveProcessingFlag = true;
        var test = {};
        test.id = $('#testId').val();
        test.name = $('#testName').val();
        test.testImageIconFileName = $('.image-preview-filename').val();
        test.testImageIconBase64 = $("#testImageIcon")[0].imageBase64;
        test.originalImageName = $('.image-preview-filename')[0].originalImageName;
        test.price = $('#testPrice').val();
        test.levelId = $('#levelId').val();         
        test.type = $('#testType').val();
        test.description = $('#testDescription').val();       
        var $eLimitTimes = $(".limit-time");
        test.limitTimeGoi = $eLimitTimes[0].value;            
        test.limitTimeChoukai = $eLimitTimes[1].value;
        test.limitTimeGokai = $eLimitTimes[2].value;
        test.publicDate = $('#publicDate').val();
        test.publicStatus = $('#publicStatus').val();
        test.groups = [];
        var groups = test.groups;
        $(".test-group").each(function(){
            var group = {
                id: $(this).attr("data-id"),
                mondais: []
            };
            var mondais = group.mondais;          
            $(this).find(".mondai").each(function(){
                var mondai = this.data;
                mondai.originalId = $(this).attr("data-id");
                mondai.quests = [];
                $(this).find(".quest.item").each(function(index) {
                    if(this.data.importFlag) {
                        mondai.quests.push(this.data);
                    } else {
                        mondai.quests.push({
                            id: this.data.quiz_id,
                            sortOrder: index + 1
                        });
                    }
                });
                mondais.push(mondai);
            });
            groups.push(group);
        });

        $(".help-block").hide();
        ajaxPost(
            "{{ asset('/test/add')}}"
            , {jsonData: JSON.stringify(test)}
            , function(result) { // return on success
                saveProcessingFlag = false;
                if(result.resultCode == 0) {
                    $(".overlay").show();
                    window.location = "{{ asset('/test')}}";
                } else {
                    if(result.messages) {
                        if(result.messages.system_error) {
                            alert(result.system_error);                        
                        } else {
                            $.each(result.messages, function(id, messages){
                                var message = null;
                                if(typeof messages == 'object') {
                                    message = messages[0];
                                } else {
                                    message = messages;
                                }
                                $(".error."+id).parents(".help-block:first").css("display", "block").show();
                                $(".error."+id).text(message);
                                var controlCollapse = $(".error."+id).attr("data-control-collapse");
                                if(controlCollapse) {
                                    var arrControlCollapse = controlCollapse.split(',');
                                    for(var i=0; i<arrControlCollapse.length; i++) {
                                        if($(arrControlCollapse[i] + ":not(.in)").length > 0) {
                                            $('[data-target="' + arrControlCollapse[i] + '"]').click();
                                        }
                                    }
                                }
                            });
                            $(window).scrollTop($(".error:visible:first").parents(".help-block:first").offset().top - 90);
                        }
                    }
                }
            }
            ,  function(data) { // return on failed/error/500....
                saveProcessingFlag = false;
                alert("Đã xảy ra lỗi trong quá trình lưu bài Test, vui lòng thử lại lần nữa!")
            }
        );
        return false;
    }

    function resetSortOrder($mondai) {
        var $orders = $mondai.find(".quest.item .order");
        var len = $orders.length;
        $orders.each(function(index){
            var $sortOrder = $(this).find("button");
            var $sortUp = $(this).find(".sortup");
            var $sortDown = $(this).find(".sortdown");
            if(len > 1) {
                if(index == 0) {
                    $sortUp.hide();    
                    $sortDown.show();    
                } else if(index == len - 1) {
                    $sortUp.show();    
                    $sortDown.hide();    
                } else {
                    $sortUp.show();    
                    $sortDown.show();   
                }
            } else {
                $sortUp.hide();    
                $sortDown.hide();  
            }
            $sortOrder.text(index + 1);
        });
    }

    function loadTest(conditions) {
        ajaxPost(
            "{{ asset('/test/loadTest')}}"
            , conditions
            , function(result) {
                if(result.resultCode == 0) {
                    var test = result.data;
                    test.id = $('#testId').val(conditions.id);
                    $('#testName').val(test.test_name);
                    $('#testPrice').val(test.test_price); 
                    $('.image-preview-filename').val(test.test_image_icon);
                    $('.image-preview-filename')[0].originalImageName = test.test_image_icon;
                    createPreviewImageTag("{{ URL::asset('upload/image/test')}}/" + test.test_id + "_" + test.test_image_icon);
                    $('#levelId').val(test.test_level_id);         
                    $('#testType').val(test.test_type_id);
                    $('#testDescription').val(test.test_description);
                    var $eLimitTimes = $(".limit-time");
                    $eLimitTimes[0].value = test.test_limit_time_goi;            
                    $eLimitTimes[1].value = test.test_limit_time_choukai;
                    $eLimitTimes[2].value = test.test_limit_time_gokai;
                    $('#publicDate').val(test.public_date);
                    $('#publicStatus').val(test.public_status);
                    var groups = test.groups;
                    for (var i = 0; i < groups.length; i++) {
                        var group 	= groups[i];
                        var maxModaiId = 1;
                        for (var j = 0; j < group.mondais.length; j++) {
                            var mondai 	= group.mondais[j];
                            $mondai = addMondaiToGroup(group.id,  mondai.id, mondai.name, mondai.description);
                            $mondai.attr("data-id", mondai.id);
                            if(mondai.id > maxModaiId) {
                                maxModaiId = maxModaiId;
                            }
                            $questArea = $mondai.find(".box-body");
                            for (var k = 0; k < mondai.quests.length; k++) {
                                var quest 	= mondai.quests[k];
                                var $quest 	= $(createHtmlFromQuest(quest));
                                $quest[0].data = quest;
                                repaireQuizInGroup($quest, quest.sortOrder);
                                $questArea.append($quest);
                            }
                            resetSortOrder($mondai);
                        }
                    }
                    $("#modalMondai")[0].currentMondaiId = maxModaiId;
                } else {
                    $questArea.html(result.message);
                }
            }
            ,  function(data) {
                alert("Đã xảy ra lỗi trong quá trình tải bài Test, vui lòng thử lại lần nữa!")
            }
        );
    }

	function createPreviewImageTag(src) {
        var $img = $('<img/>', {
                id: 'dynamic',
                width:250,
                height:200
        });
        if(src) {
            $img.attr("src", src);
            $(".image-preview .file-input-title").text("Thay đổi");
            $(".image-preview-clear").show();
            $(".image-preview").attr("data-content",$img[0].outerHTML);
        }
        return $img;
    }

    function initScreen() {
        var url = window.location.href;
        var index = url.lastIndexOf("/");
        var id = null;
        if(index > 0) {
            id = url.substr(index + 1);
        }
        if(id && !isNaN(id)) {
            $("#btnUploadFile").hide();
            loadTest({id:id});
        } else {
            $("#btnUploadFile").show();
            initDefaultMondaiOfGroup();
        }
    }
    
    $(document).ready(function(){
        
        $(document).on("click",".quest .order .sortup", function(){
            var $curQuest = $(this).parents(".quest.item:first");
            var $prevQuest = $curQuest.prev(".quest.item");
            $prevQuest.before($curQuest);
            $(window).scrollTop($curQuest.offset().top - 90);
            var $mondai = $(this).parents(".box:first");
            resetSortOrder($mondai);
        });
        
        $(document).on("click",".quest .order .sortdown", function(){
            var $curQuest = $(this).parents(".quest.item:first");
            var $nextQuest = $curQuest.next(".quest.item");
            $nextQuest.after($curQuest);
            $(window).scrollTop($curQuest.offset().top - 90);
            var $mondai = $(this).parents(".box:first");
            resetSortOrder($mondai);
        });

        $(document).on("click",".quest .action .delete-quiz", function(){
            var $mondai = $(this).parents(".box:first");
            var groupName = $mondai.parents(".test-group").find(".group-name").text();
            var mondaiName = $mondai.find(".mondai-name").text();
            if(confirm("Bạn muốn xóa câu hỏi khỏi mondai "+ mondaiName  +" của nhóm " + groupName + "?")) {
                $(this).parent().parent().remove();
                resetSortOrder($mondai);
            }
        });

        $(document).on("click",".glyphicon-plus,.glyphicon-minus", function(){
            var $thiz = $(this);
            if($thiz.hasClass("glyphicon-plus")) {
                $thiz.removeClass("glyphicon-plus");
                $thiz.addClass("glyphicon-minus");
            } else {
                $thiz.removeClass("glyphicon-minus");
                $thiz.addClass("glyphicon-plus");
            }
        });

        $(document).on("click",".list-quiz .glyphicon-circle-arrow-down,.list-quiz .glyphicon-circle-arrow-up", function(){
            var $thiz = $(this);
            if($thiz.hasClass("glyphicon-circle-arrow-down")) {
                $thiz.removeClass("glyphicon-circle-arrow-down");
                $thiz.addClass("glyphicon-circle-arrow-up");
            } else {
                $thiz.removeClass("glyphicon-circle-arrow-up");
                $thiz.addClass("glyphicon-circle-arrow-down");
            }
        });

        $(document).on("click",".mondai .delete-mondai", function(){
            var $mondai = $(this).parents(".box:first");
            var groupName = $mondai.parents(".test-group").find(".group-name").text();
            var mondaiName = $mondai.find(".mondai-name").text();
            if(confirm("Bạn muốn xóa mondai "+ mondaiName  +" của nhóm " + groupName + "?")) {
                $mondai.remove();
            }
        });
        $(document).on("click",".mondai .edit", function(){
            var mondai = $(this).parents(".box:first")[0];
            showModalMondai(mondai.data.groupId, mondai.data);
            $("#modalMondai").modal("toggle");
        });
        $(document).on("click","ul.pagination li a", function(){
            var href = $(this).attr("href");
            searchQuest(href);
            return false;
        });
        
        $("#testName").change(function(){
            if(this.value != '') {
                $(this).parent().find(".help-block").hide();
            }
        });
        
        $(document).on('click', '#close-preview', function(){ 
            $('.image-preview').popover('hide'); 
        });
        // Hover befor close the preview
        $('.image-preview').hover(
            function () {
                $('.image-preview').popover('show');
            }, 
            function () {
                $('.image-preview').popover('hide');
            }
        );   
        // Create the close button
        var closebtn = $('<button/>', {
            type:"button",
            text: 'x',
            id: 'close-preview',
            style: 'font-size: initial;',
        });
        closebtn.attr("class","close pull-right");
        // Set the popover default content
        $('.image-preview').popover({
            trigger:'manual',
            html:true,
            title: "<strong>Hình ảnh</strong>"+$(closebtn)[0].outerHTML,
            content: "Chưa chọn hình ảnh",
            placement:'bottom'
        });
        // Clear event
        $('.image-preview-clear').click(function(){
            $('.image-preview').attr("data-content","").popover('hide');
            $('.image-preview-filename').val("");
            $('.image-preview-clear').hide();
            $('.image-preview .file-input input:file').val("");
            $('.image-preview .file-input input:file')[0].imageBase64 = null;
            $(".image-preview .file-input-title").text("Chọn hình"); 
        });
        
        // Create the preview image
        $(".image-preview .file-input input:file").change(function (){
            var thiz = this;
            var $img = createPreviewImageTag();      
            var file = this.files[0];
            var reader = new FileReader();
            // Set preview image into the popover data-content
            reader.onload = function (e) {
                $(".image-preview .file-input-title").text("Thay đổi");
                $(".image-preview-clear").show();
                $(".image-preview-filename").val(file.name);     
                thiz.imageBase64 = e.target.result;       
                $img.attr('src', e.target.result);
                $(".image-preview").parent().find(".help-block").hide();
                $(".image-preview").attr("data-content",$img[0].outerHTML).popover("show");
            }        
            reader.readAsDataURL(file);
        });

        initScreen();
    });
    $("#btnUploadFile").click(function(){
        $("#testFileImport").val("");
        $("#testFileImport").click();
    });
    $("#testFileImport").change(function (){
        $(".overlay").show();
        var thiz = this;
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $("#testFileNameImport").val(file.name);
            try {
                var data = e.target.result;
                var wb = XLSX.read(data, {type: 'binary'});
                loadTestFromWb(wb);   
            } catch (error) {
                alert("Không thể import bài Test, vui lòng kiểm tra lại định dạng bài Test và thử lại lần nữa.");            
            }
            $(".overlay").hide();
        }        
        reader.readAsBinaryString(file);
    });

    function loadTestFromWb(workbook) {
        var result = {};
        workbook.SheetNames.forEach(function(sheetName) {
            var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
            if(roa.length > 0){
                result[sheetName] = roa;
            }
        });
        var getValue = function(item, key) {
            if(item && item[key]) {
                return item[key];
            }
            return null;
        };
        var getObject = function(selector, value) {
            var opt = $(selector).find("[value='"+value+"']");
            return {s_value:value, s_name: opt.text()};
        };
        var type = null;
        var level = null;
        if(result["Test"] && result["Test"][0]) {
            var testInfo = result["Test"];
            var valueColum = "Giá trị";
            var testName = testInfo[0][valueColum];
            var testImage = testInfo[1][valueColum];
            var testLevel = testInfo[2][valueColum];
            var testType = testInfo[3][valueColum];
            var testPublicDate = testInfo[4][valueColum];
            var testPublicStatus = testInfo[5][valueColum];
            var testPrice = testInfo[6][valueColum];
            var testDescription = testInfo[7][valueColum];
            var timeLimitGoi = testInfo[8][valueColum];
            var timeLimitBunpou = testInfo[9][valueColum];
            var timeLimitChoikai = testInfo[10][valueColum];
            var $eLimitTimes = $(".limit-time");

            if(timeLimitGoi) {
                $eLimitTimes[0].value = timeLimitGoi;            
            }
            if(timeLimitBunpou) {
                $eLimitTimes[1].value = timeLimitBunpou;
            }
            if(timeLimitChoikai) {       
                $eLimitTimes[2].value = timeLimitChoikai;
            }
            level = getObject("#levelId", testLevel);
            type  = getObject("#testType", testType);
            var publicStatus  = getObject("#publicStatus", testPublicStatus);
            if(testName) {
                $("#testName").val(testName);
            }
            if(testLevel) {
                $("#levelId").val(level.s_value);
            }
            if(testType) {
                $("#testType").val(type.s_value);
            }
            if(testPublicDate) {
                var dates = testPublicDate.split("/");  
                $("#publicDate").val(dates[2] + '-' + dates[1] + '-' + dates[0]);
            }
            if(testPublicStatus) {
                $("#publicStatus").val(testPublicStatus);
            }
            if(testPrice) {
                $("#testPrice").val(testPrice);
            }
            if(testDescription) {
                $("#testDescription").val(testDescription);
            }
            
        }
        var quiz_id = -1;
        $(".test-group").each(function(){
            var $mondal = $("#modalMondai")[0];
            if(!$mondal.currentMondaiId) {
                $mondal.currentMondaiId = 1;
            }
            $(this).find(".box.mondai").remove();
            var groupId = $(this).attr("data-id");
            var sheetName = $(this).attr("data-name");
            var sortOrder = 1;
            var currentMondai = {};
            var $mondai = null;
            if(result[sheetName]) {
                var group = {s_value: groupId, s_name: sheetName};
                result[sheetName].forEach(function(item) {
                    if(item.Mondai) {
                        var mondaiName = item.Mondai;
                        var mondaiDescription = item.Question || "";
                        $mondai = addMondaiToGroup(groupId,  $mondal.currentMondaiId, item.Mondai, mondaiDescription);
                        $mondal.currentMondaiId++;
                    } else {
                        var quiz = {
                            quiz_id         : --quiz_id,
                            level_id        : level.s_value,
                            quiz_type       : type.s_value,
                            quiz_group      : group.s_value,
                            content         : getValue(item,'Question'),
                            ans1            : getValue(item, '1'),
                            ans2            : getValue(item, '2'),
                            ans3            : getValue(item,'3'),
                            ans4            : getValue(item,'4'),
                            right_ans       : getValue(item,'Answer'),
                            sortOrder       : sortOrder++,
                            right_ans_exp   : getValue(item,'Explaination'),
                            group           : group,
                            level           : level,
                            type            : type,
                            importFlag      : true
                        };
                        var $quizArea = $mondai.find(".box-body");
                        var $quiz 	= $(createHtmlFromQuest(quiz));
                        $quiz[0].data = quiz;
                        repaireQuizInGroup($quiz, quiz.sortOrder);
                        $quizArea.append($quiz);
                        resetSortOrder($mondai);
                    }
                });
            }
            
        });

        return result;
    }
    
</script>

<style>
    #modalQuestion .modal-dialog{
        width:80%;
        max-width:850px;
    }
    @media (max-width: 780px) {
        #modalQuestion .modal-dialog{
            width:auto;
        }
    }

    
    .quest{
        border-bottom: 2px dotted rgba(214, 206, 208, 0.77);
        display: inline-block;
        width: 100%;
        position: relative;
    }
    .quest:last-child {
        border-bottom: none;        
    } 
    .quest-content{
        margin-right: 39px;
        padding: 10px 15px 15px 15px;
        text-align: justify;
        min-height: 100px;
    }
    .quest-content .row.img,.quest-content .row.audio {
        text-align: center;
    }
    .quest-content .row.audio audio{
        max-width:100%;
    }
    .quest-content.in-mondai{
        margin-left: 40px;
    }
    .quest .order{
        margin-top: 10px;
        width: 34px;
        text-align: center;
        position: absolute;
        left: 0;
    }
    .quest .order button{
        margin-left:0px;
    }
    .quest .action{
        width: 29px;
        float: right;
        position: absolute;
        right: 0;
        top: 6px;
    }
    .quest .action div{
        margin-top:3px !important;
    }
    .quest .action .detail {
        margin-top: 3px;
    }
    .quiz-detail{
        background: #fff;
        border: 2px dotted rgba(214, 206, 208, 0.77);
        margin-right: 30px;
        margin-top: 10px;
        margin-left: 4px;
    }

    .mondai-name {
        padding: 0;
        margin: 0;   
    }
    .mondai-description {
        font-style: italic;
        font-size: 10;
        padding: 2px;
        border-top: 1px dotted rgba(214, 206, 208, 0.77);;
    }

    .btn-circle {
        border-radius: 50%;
        width: 34px;
        height: 34px;
        padding: 0;
        border: 1px solid rgba(214, 206, 208, 0.77);
    }
    .modal-header {
        background: #ffA1ba;
        border-bottom: 1px solid #ea5e97;
        color: #fff;
    }
    .modal .form-horizontal {
        background: #ffffff;
    }
    .help-block{
        display:none;
    }

    .pagination {
        margin: 0;
    }
    .help-block li {
        list-style:none;
    }

    .list-quiz{
        padding: 1px 10px;
    }
    .list-quiz h4 {
        margin-top: 0;
        margin-bottom: 0;
    }
    .overlay{
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        z-index: 99999;
        background: rgba(216, 210, 210, 0.74);
        display:none;
    }
    .overlay .loading{
        border: 5px solid #f3f3f3;
        -webkit-animation: spin 1s linear infinite;
        animation: spin 1s linear infinite;
        border-top: 5px solid #555;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        position: absolute;
        left: 50%;
        top: 40%;
        margin-top: -25px;
        margin-left: -25px;
        
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .file-input {
        position: relative;
        overflow: hidden;
        margin: 0px;    
        color: #333;
        background-color: #fff;
        border-color: #ccc;    
    }
    .file-input input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }
    .file-input-title {
        margin-left:2px;
    }
    .detail-view {
        text-align: left !important;
        font-weight: normal;
    }
    #btnUploadFile{
        position: absolute;
        right: 245px;
        top: 5px;
    }
    /*
    * Component: Box
    * --------------
    */
    .box {
        position: relative;
        border-radius: 3px;
        background: #ffffff;
        border-top: 2px solid rgba(214, 206, 208, 0.77);
        margin-bottom: 20px;
        width: 100%;
        box-shadow: 0 1px 1px rgba(214, 206, 208, 0.77);
    }
    .box.box-default {
        border-top-color: #d2d6de;
    }

    .box-header:before,
    .box-body:before,
    .box-footer:before,
    .box-header:after,
    .box-body:after,
    .box-footer:after {
        content: " ";
        display: table;
    }
    .box-header:after,
    .box-body:after,
    .box-footer:after {
        clear: both;
    }
    .box-header {
        color: #444;
        display: block;
        padding: 10px;
        position: relative;
    }
    .test-group >.box-header {
        padding: 2px 10px;
    }
    .box-header.with-border {
        border-bottom: 1px solid rgba(214, 206, 208, 0.77);
    }
    .box-header > .box-tools {
        position: absolute;
        right: 10px;
        top: 5px;
    }
    
    .box-body {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        padding: 5px;
        padding-left: 7px;
    }
    .box-footer {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        padding: 5px;
        padding-left: 7px;
        background-color: #ffffff;
    }
</style>
@endsection