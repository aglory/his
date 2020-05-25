function ajaxSubmit(params) {
    var objParams = { dataType: "json", beforeSend: function(XMLHttpRequest) { XMLHttpRequest.setRequestHeader("isAjax", "true"); } };
    objParams = $.extend(objParams, params, {
        success: function(d, s, jqXHR) {
            //401 Unauthorized
            if (d.StatusCode == 401) {
                gotoLogin();
            } else {
                if (params.success)
                    params.success.apply(this, [d, s, jqXHR]);
            }
        }
    });
    $.ajax(objParams);
}

function loadMask() {
    $("<div id='divMask'></div>").appendTo($("body"));
}

function removeMask() {
    $("#divMask").remove();
}

function showMessage(title, message, callback) {
    $("#messageModal .modal-title").html(title);
    $("#messageModal .modal-body").html(message);
    $("#messageModal .btn-primary").unbind("click");
    if (callback) {
        $("#messageModal .btn-primary").bind("click", function() {
            if (!callback.call(this)) {
                $("#messageModal").modal('hide');
            }
        });
    }
    $("#messageModal").modal({ backdrop: false, keyboard: true, show: true });
}

function showModal(html) {
    $("#htmlModal").html(html);
    $("#htmlModal .modal-dialog").draggable({ handle: ".modal-title" });
    $("#htmlModal").modal({ backdrop: false, keyboard: true, show: true });
}

function gotoLogin() {
    window.top.location.href = 'admin.php?model=login&action=login';
}

function notify() {
    ajaxSubmit({
        url: 'admin.php?model=login&action=notify',
        type: 'post',
        data: { r: Math.random() },
        success: function(ret) {
            if (ret && ret.Success) {
                setTimeout(function() {
                    notify();
                }, 1000 * 30);
            } else {
                gotoLogin();
            }
        },
        error: function() {
            gotoLogin();
        }
    });
}

//分页相关元素操作绑定
function bindPageParmeter() {
    $("#manangertoolbar select").change(function() {
        $("#hdfPageIndex").val("1");
        query();
    });
    $("#manangertoolbar input[type='text']").keyup(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if ((code == 13) && (typeof(query) == 'function')) {
            $("#hdfPageIndex").val("1");
            query();
        }
    });
    $("#manangertoolbar .btnquery").click(function() {
        $("#hdfPageIndex").val("1");
        query();
    });
}

//分页排序按钮绑定
function bindPageSort() {
    $("#manangerbody").on("click", ".mainTable-head .btn-sort-order", function(e) {
        var lis = ($("#hdfPageOrderBy").val().length == 0) ? (new Array()) : $("#hdfPageOrderBy").val().split(",");
        var liv = new Array();
        var key = $(this).attr('sort-expression');
        var f = false;
        for (var i = lis.length; i > 0; i--) {
            var s = lis[i - 1];
            var p = s.split(" ");
            var k = p[0];
            var v = p[1];
            if (k !== key) {
                liv.unshift(s);
                continue;
            }
            f = true;
            if (v == 'asc') {
                $(this).parent().find(".column-sort a").removeClass("active");
                continue;
            }
            if (v == 'desc') {
                $(this).parent().find(".column-sort a").removeClass("active").filter(".sort-up").addClass('active');
                liv.unshift(key + " asc");
                continue;
            }
        }
        if (!f) {
            $(this).parent().find(".column-sort a").removeClass("active").filter(".sort-down").addClass('active');
            liv.push(key + " desc");
        }
        $("#hdfPageOrderBy").val(liv.join(','));
        query();
    });
}

//初始化Modal
function initModal() {
    $("#messageModal .modal-dialog").draggable({ handle: ".modal-title" });
}

//上传文件初始化 params:[{name:"",src:""},{name:"",src:""}]
function iniFileUpload(container, params) {
    formImages = $("#htmlModal #formImages").val();
    //"#htmlModal #formFileContainer"
    $(container).on("click", ".imagecell .fromuploadfiledelete", null, function() {
        $(this).parent().remove();
    });

    $(container).on("change", ".imagecell .fromuploadfilefile", null, function() {
        if (this.files.length) {
            var that = this;
            if ($(this).parents(".imagecell").is(":last-child")) {
                $(container).append($(container + " .imagecell.hidden").clone().removeClass("hidden"));
            }
            var reader = new FileReader();
            reader.onload = function() {
                $(that).parents(".imagecell").find(".fromuploadfileimg").prop("src", this.result);
            };
            var file = this.files[0];
            reader.readAsDataURL(file);
        }
    });
    if (params && params.length) {
        for (var i = 0; i < params.length; i++) {
            var clone = $(container + " .imagecell.hidden").clone().removeClass("hidden");
            clone.find(".fromuploadfileimg").prop("src", params[i].src);
            clone.find(".fromuploadfilename").val(params[i].name);
            $(container).append(clone);
        }
    }

    $(container).append($(container + " .imagecell.hidden").clone().removeClass("hidden"));
}

$(function() {
    //notify();
})