$(document).ready(function () {

    $('.btn-edit').click(function() {
        var userId = $(this).parent().parent().attr('user-id');
        var url = window.location.pathname + '/edit/' + userId;
        window.open(url, "_self");
    });
    
    $('.btn-delete').click(function() {   
        var userId = $(this).parent().parent().attr('user-id'); 
        $.confirm({
            title: 'Xóa người dùng',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    var url = window.location.pathname + '/delete/' + userId;
                    window.open(url, "_self");
                },
                Không: function () {
                    
                }
            }
        });
    });

    $('.btn-delete-quiz').click(function() {
        var quiz_id = $(this).parent().parent().attr('quiz-id');
        $.confirm({
            title: 'Xóa câu hỏi',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    var url = window.location.pathname + '/delete/' + quiz_id;
                    window.open(url, "_self");
                },
                Không: function () {
                    
                }
            }
        });
        
    });

    
    $('.btn-edit-quiz').click(function() {   
        var quiz_id = $(this).parent().parent().attr('quiz-id');
        var url = window.location.pathname + '/edit/' + quiz_id;
        window.open(url, "_self");
    });

    //cần chỉnh sửa view chi tiết câu hỏi
    $('.btn-detail-quiz').click(function() {
        var quiz_id = $(this).parent().parent().attr('quiz-id');
        var url = window.location.pathname + '/detail/' + quiz_id;
        //var url = "#";
        window.open(url, "_self");
    });
    //check all checkbox
    $("#cb_All").click(function () {
        $(".check-box").prop('checked', $(this).prop('checked'));
    });
    

    //submit delete all checked quiz
    // code inside this function will run when #delete_all_quiz on click
    $("#delete_all_quiz").on('click', function () { 
        //define list of quiz id when click on checkbox
        var list_id = [];
        $('input[name="ckb"]:checked').each(function(){
            var $this = $(this);
            //push quiz id into list
            list_id.push($this.attr('id'));
        });
        
        var token = $("#_token").val();

        $.confirm({
            title: 'Xóa câu hỏi',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    $.post("/quizs/deleteall", {'list_id': list_id, '_token': token}, function(id) {
                        for (var i = 0; i < list_id.length; i++) {
                            $("#quiz_" + list_id[i]).remove();               
                        }
                    })
                },
                Không: function () {
                    
                }
            }
        });
 
    });

    //test
     $('.btn-delete-test').click(function() {
        var test_id = $(this).parent().parent().attr('test-id');
        $.confirm({
            title: 'Xóa quiz',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    var url = window.location.pathname + '/delete/' + test_id;
                    window.open(url, "_self");
                },
                Không: function () {
                    
                }
            }
        });
        
    });

    $('.btn-edit-test').click(function() {   
        var test_id = $(this).parent().parent().attr('test-id');
        var url = window.location.pathname + '/edit/' + test_id;
        window.open(url, "_self");
    });

    $('.btn-detail-test').click(function() {
        var test_id = $(this).parent().parent().attr('test-id');
        var url = window.location.pathname + '/detail/' + test_id;
        window.open(url, "_self");
    });
    
    $("#delete_all_test").on('click', function () { 
        //define list of quiz id when click on checkbox
        var list_id = new Array();
        $('input[name="ckb"]:checked').each(function(){
            var $this = $(this);
            //push quiz id into list
            list_id.push($this.attr('id'));
        });
        
        var token = $("#_token").val();

        $.confirm({
            title: 'Xóa bài kiểm tra',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    $.post("/test/deleteall", {'list_id': list_id, '_token': token}, function(id) {
                        for (var i = 0; i < list_id.length; i++) {
                            $("#test_" + list_id[i]).remove();               
                        }
                    })
                },
                Không: function () {
                   
                }
            }
        });
 
    });
    //bunpo
    $('.btn-edit-bunpo').click(function() {   
        var bunpo_id = $(this).parent().parent().attr('bunpo-id');
        var url = window.location.pathname + '/edit/' + bunpo_id;
        window.open(url, "_self");
    });
    //delete bunpo
    $('.btn-delete-bunpo').click(function() {
        var bunpo_id = $(this).parent().parent().attr('bunpo-id');
        $.confirm({
            title: 'Xóa từ vựng',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    var url = window.location.pathname + '/delete/' + bunpo_id;
                    window.open(url, "_self");
                },
                Không: function () {
                    
                }
            }
        });
        
    });

    //delete multi
     $("#delete_all_bunpo").on('click', function () { 
        //define list of quiz id when click on checkbox
        var list_id = new Array();
        $('input[name="ckb"]:checked').each(function(){
            var $this = $(this);
            //push quiz id into list
            list_id.push($this.attr('id'));
        });
        
        var token = $("#_token").val();

        $.confirm({
            title: 'Xóa từ vựng',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    $.post("/bunpos/deleteall", {'list_id': list_id, '_token': token}, function(id) {
                        for (var i = 0; i < list_id.length; i++) {
                            $("#bunpo_" + list_id[i]).remove();               
                        }
                    })
                },
                Không: function () {
                    
                }
            }
        });
 
    });
    
    //video
    $('.btn-edit-video').click(function() {   
        var video_id = $(this).parent().parent().attr('video-id');
        var url = window.location.pathname + '/edit/' + video_id;
        window.open(url, "_self");
    });
    
    $('.btn-delete-video').click(function() {
        var video_id = $(this).parent().parent().attr('video-id');
        $.confirm({
            title: 'Xóa video',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    var url = window.location.pathname + '/delete/' + video_id;
                    window.open(url, "_self");
                },
                Không: function () {
                    
                }
            }
        });
        
    });

    $("#delete_all_video").on('click', function () { 
        //define list of quiz id when click on checkbox
        var list_id = new Array();
        $('input[name="ckb"]:checked').each(function(){
            var $this = $(this);
            //push quiz id into list
            list_id.push($this.attr('id'));
        });
        
        var token = $("#_token").val();

        $.confirm({
            title: 'Xóa video',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    $.post("/videos/deleteall", {'list_id': list_id, '_token': token}, function(id) {
                        for (var i = 0; i < list_id.length; i++) {
                            $("#video_" + list_id[i]).remove();               
                        }
                    })
                },
                Không: function () {
                    
                }
            }
        });
 
    });
    

    //feedback
    $('.btn-detail-feedback').click(function() {   
        var feedback_id = $(this).parent().parent().attr('feedback-id');
        var url = window.location.pathname + '/detail/' + feedback_id;
        window.open(url, "_self");
    });

    $('.btn-reply-feedback').click(function() {
        var feedback_id = $(this).parent().parent().attr('feedback-id');
        var url = window.location.pathname + '/reply/' + feedback_id;
        window.open(url, "_self");
    });
    $('.btn-delete-feedback').click(function() {
        var feedback_id = $(this).parent().parent().attr('feedback-id');
        $.confirm({
            title: 'Xóa phản hồi',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    var url = window.location.pathname + '/delete/' + feedback_id;
                    window.open(url, "_self");
                },
                Không: function () {
                    
                }
            }
        });
        
    });
    
    $("#delete_all_feedback").on('click', function () { 
        //define list of quiz id when click on checkbox
        var list_id = new Array();
        $('input[name="ckb"]:checked').each(function(){
            var $this = $(this);
            //push quiz id into list
            list_id.push($this.attr('id'));
        });
        
        var token = $("#_token").val();

        $.confirm({
            title: 'Xóa phản hồi',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    $.post("/feedbacks/deleteall", {'list_id': list_id, '_token': token}, function(id) {
                        for (var i = 0; i < list_id.length; i++) {
                            $("#feedback_" + list_id[i]).remove();               
                        }
                    })
                },
                Không: function () {
                    
                }
            }
        });
 
    });

    //rechage
    $('.btn-delete-recharge').click(function() {
        var recharge_id = $(this).parent().parent().attr('recharge-id');
        $.confirm({
            title: 'Xóa lịch sử thanh toán',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    var url = window.location.pathname + '/delete/' + recharge_id;
                    window.open(url, "_self");
                },
                Không: function () {
                    
                }
            }
        });
        
    });

    $("#delete_all_recharges").on('click', function () { 
        //define list of quiz id when click on checkbox
        var list_id = new Array();
        $('input[name="ckb"]:checked').each(function(){
            var $this = $(this);
            //push quiz id into list
            list_id.push($this.attr('id'));
        });
        
        var token = $("#_token").val();

        $.confirm({
            title: 'Xóa lịch sử thanh toán',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    $.post("/histories/recharge/deleteall", {'list_id': list_id, '_token': token}, function(id) {
                        for (var i = 0; i < list_id.length; i++) {
                            $("#recharge_" + list_id[i]).remove();               
                        }
                    })
                },
                Không: function () {
                    
                }
            }
        });
 
    });
    $('.btn-detail-recharge').click(function() {
        var id = $(this).parent().parent().attr('recharge-id');
        var url = window.location.pathname + '/detail/' + id;
        //var url = "#";
        window.open(url, "_self");
    });

    //purchase
    $('.btn-delete-purchase').click(function() {
        var id = $(this).parent().parent().attr('purchase-id');
        $.confirm({
            title: 'Xóa lịch sử mua',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    var url = window.location.pathname + '/delete/' + id;
                    window.open(url, "_self");
                },
                Không: function () {
                    
                }
            }
        });
        
    });

    $("#delete_all_purchase").on('click', function () { 
        //define list of quiz id when click on checkbox
        var list_id = new Array();
        $('input[name="ckb"]:checked').each(function(){
            var $this = $(this);
            //push quiz id into list
            list_id.push($this.attr('id'));
        });
        
        var token = $("#_token").val();

        $.confirm({
            title: 'Xóa lịch sử mua',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    $.post("/histories/purchase/deleteall", {'list_id': list_id, '_token': token}, function(id) {
                        for (var i = 0; i < list_id.length; i++) {
                            $("#purchase_" + list_id[i]).remove();               
                        }
                    })
                },
                Không: function () {
                    
                }
            }
        });
 
    });
    $('.btn-detail-purchase').click(function() {
        var id = $(this).parent().parent().attr('purchase-id');
        var url = window.location.pathname + '/detail/' + id;
        //var url = "#";
        window.open(url, "_self");
    });
    //setting
    $('.btn-edit-setting').click(function() {   
        var setting_id = $(this).parent().parent().attr('setting-id');
        var url = window.location.pathname + '/edit/' + setting_id;
        window.open(url, "_self");
    });
    
    $('.btn-delete-setting').click(function() {
        var setting_id = $(this).parent().parent().attr('setting-id');
        $.confirm({
            title: 'Xóa dữ liệu',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    var url = window.location.pathname + '/delete/' + setting_id;
                    window.open(url, "_self");
                },
                Không: function () {
                    
                }
            }
        });
        
    });

    $("#delete_all_setting").on('click', function () { 
        //define list of quiz id when click on checkbox
        var list_id = new Array();
        $('input[name="ckb"]:checked').each(function(){
            var $this = $(this);
            //push quiz id into list
            list_id.push($this.attr('id'));
        });
        
        var token = $("#_token").val();

        $.confirm({
            title: 'Xóa dữ liệu',
            content: 'Bạn muốn xóa chứ?',
            columnClass: 'small',
            buttons: {
                Xóa: function () {
                    $.post("/settings/deleteall", {'list_id': list_id, '_token': token}, function(id) {
                        for (var i = 0; i < list_id.length; i++) {
                            $("#setting_" + list_id[i]).remove();               
                        }
                    })
                },
                Không: function () {
                    
                }
            }
        });
 
    });

});
