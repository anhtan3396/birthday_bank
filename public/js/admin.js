$(document).ready(function() {
    $(".btn-edit").click(function() {
        var userId = $(this)
            .parent()
            .parent()
            .attr("user-id");
        var url = window.location.pathname + "/edit/" + userId;
        window.open(url, "_self");
    });

    $(".btn-delete").click(function() {
        var userId = $(this)
            .parent()
            .parent()
            .attr("user-id");
        $.confirm({
            title: "Xóa người dùng",
            content: "Bạn muốn xóa chứ?",
            columnClass: "small",
            buttons: {
                Xóa: function() {
                    var url = window.location.pathname + "/delete/" + userId;
                    window.open(url, "_self");
                },
                Không: function() {}
            }
        });
    });

    $(".btn-delete-quiz").click(function() {
        var id = $(this)
            .parent()
            .parent()
            .attr("quiz-id");
        $.confirm({
            title: "Xóa câu hỏi",
            content: "Bạn muốn xóa chứ?",
            columnClass: "small",
            buttons: {
                Xóa: function() {
                    var url = window.location.pathname + "/delete/" + id;
                    window.open(url, "_self");
                },
                Không: function() {}
            }
        });
    });

    $(".btn-edit-quiz").click(function() {
        var id = $(this)
            .parent()
            .parent()
            .attr("quiz-id");
        var url = window.location.pathname + "/edit/" + id;
        window.open(url, "_self");
    });

    //cần chỉnh sửa view chi tiết câu hỏi
    $(".btn-detail-quiz").click(function() {
        var id = $(this)
            .parent()
            .parent()
            .attr("quiz-id");
        var url = window.location.pathname + "/detail/" + id;
        //var url = "#";
        window.open(url, "_self");
    });
    //check all checkbox
    $("#cb_All").click(function() {
        $(".check-box").prop("checked", $(this).prop("checked"));
    });

    //submit delete all checked quiz
    // code inside this function will run when #delete_all_quiz on click
    $("#delete_all_quiz").on("click", function() {
        //define list of quiz id when click on checkbox
        var list_id = [];
        $('input[name="ckb"]:checked').each(function() {
            var $this = $(this);
            //push quiz id into list
            list_id.push($this.attr("id"));
        });

        var token = $("#_token").val();

        $.confirm({
            title: "Xóa câu hỏi",
            content: "Bạn muốn xóa chứ?",
            columnClass: "small",
            buttons: {
                Xóa: function() {
                    $.post(
                        "/admin/quizs/deleteall",
                        { list_id: list_id, _token: token },
                        function(id) {
                            for (var i = 0; i < list_id.length; i++) {
                                $("#quiz_" + list_id[i]).remove();
                            }
                        }
                    );
                },
                Không: function() {}
            }
        });
    });

    //setting
    $(".btn-edit-setting").click(function() {
        var setting_id = $(this)
            .parent()
            .parent()
            .attr("setting-id");
        var url = window.location.pathname + "/edit/" + setting_id;
        window.open(url, "_self");
    });

    $(".btn-delete-setting").click(function() {
        var setting_id = $(this)
            .parent()
            .parent()
            .attr("setting-id");
        $.confirm({
            title: "Xóa dữ liệu",
            content: "Bạn muốn xóa chứ?",
            columnClass: "small",
            buttons: {
                Xóa: function() {
                    var url =
                        window.location.pathname + "/delete/" + setting_id;
                    window.open(url, "_self");
                },
                Không: function() {}
            }
        });
    });

    $("#delete_all_setting").on("click", function() {
        //define list of quiz id when click on checkbox
        var list_id = new Array();
        $('input[name="ckb"]:checked').each(function() {
            var $this = $(this);
            //push quiz id into list
            list_id.push($this.attr("id"));
        });

        var token = $("#_token").val();

        $.confirm({
            title: "Xóa dữ liệu",
            content: "Bạn muốn xóa chứ?",
            columnClass: "small",
            buttons: {
                Xóa: function() {
                    $.post(
                        "/settings/deleteall",
                        { list_id: list_id, _token: token },
                        function(id) {
                            for (var i = 0; i < list_id.length; i++) {
                                $("#setting_" + list_id[i]).remove();
                            }
                        }
                    );
                },
                Không: function() {}
            }
        });
    });
});
