$(function() {
    //分页相关元素操作绑定
    bindPageParmeter();

    //分页排序按钮绑定
    bindPageSort();

    query();

    //初始化Modal
    initModal();
});

//#region 列表查询

function query() {
    var data = {
        PageIndex: $("#hdfPageIndex").val(),
        PageSize: $("#hdfPageSize").val(),
        PageOrderBy: $("#hdfPageOrderBy").val(),
        MatchType: $("#ddlMatchType").val(),
        Type: $("#hdfType").val(),
        Status: $("#ddlStatus").val(),
        Title: $("#txtTitle").val(),
    };
    loadMask();
    ajaxSubmit({
        type: "post",
        url: "admin.php?model=content&action=manager&parital=indexpartial",
        data: data,
        success: function(ret) {
            if (ret && ret.Success) {
                $("#manangercontent").html(ret.Value);
                $("#manangerpage").pager({
                    pageIndex: $("#hdfPageIndex").val(),
                    pageSize: $("#hdfPageSize").val(),
                    recordCount: ret.Tag,
                    pageIndexChanged: function(pageIndex, pageSize) {
                        $("#hdfPageIndex").val(pageIndex);
                        $("#hdfPageSize").val(pageSize);
                        query();
                    }
                });
            }
        },
        complete: function() {
            removeMask();
        }
    });
}

//#endregion

//#region 修改状态

function btnChangeStatusClick(sender, id, status) {
    var funCallback = function() {
        if ($(sender).hasClass('disabled'))
            return;

        $(sender).addClass('disabled');
        loadMask();
        var data = {
            Id: id,
            Status: status
        };
        ajaxSubmit({
            type: "post",
            url: "admin.php?model=content&action=changestatus",
            data: data,
            success: function(ret) {
                if (ret.Success) {
                    $.sticky("操作成功", { type: "st-success" });
                    query();
                } else {
                    $.sticky(ret.Message, { type: "st-error" });
                }
            },
            complete: function() {
                removeMask();
                $(sender).removeClass('disabled');
            }
        });
    };
    if (status == 2) {
        showMessage("系统", "确定停用", funCallback);
    } else {
        funCallback();
    }
}

//#endregion

//#region 编辑

function btnEditorClick(sender, id) {
    if ($(sender).hasClass('disabled'))
        return;

    $(sender).addClass('disabled');
    loadMask();
    var data = {
        Id: id,
        Type: $("#hdfType").val()
    };
    ajaxSubmit({
        type: "post",
        url: "admin.php?model=content&action=editor",
        data: data,
        dataType: "text",
        success: function(ret) {
            showModal(ret);
        },
        complete: function() {
            removeMask();
            $(sender).removeClass('disabled');
        }
    });
}

function btnSaveClick(sender) {
    if ($(sender).hasClass('disabled'))
        return;

    $(sender).addClass('disabled');
    loadMask();
    var data = {
        Id: $("#htmlModal #formId").val(),
        Type: $("#htmlModal #formType").val(),
        Index: $("#htmlModal #formIndex").val(),
        Title: $("#htmlModal #formTitle").val(),
        Content: $("#htmlModal #formContent").val(),
        CreateDate: $("#htmlModal #formCreateDate").val()
    };
    ajaxSubmit({
        type: "post",
        url: "admin.php?model=content&action=editor&parital=indexpartial",
        data: data,
        success: function(ret) {
            if (ret.Success) {
                $("#htmlModal").modal('hide');
                $.sticky("保存成功", { type: "st-success" });
                query();
            } else {
                $.sticky(ret.Message, { type: "st-error" });
            }
        },
        complete: function() {
            removeMask();
            $(sender).removeClass('disabled');
        }
    });
}

//#endregion

//#region 上传文件 

function btnFileUploadClick(sender, id) {
    if ($(sender).hasClass('disabled'))
        return;

    $(sender).addClass('disabled');
    loadMask();
    var data = {
        Id: id
    };
    ajaxSubmit({
        type: "post",
        url: "admin.php?model=content&action=fileupload",
        data: data,
        dataType: "text",
        success: function(ret) {
            showModal(ret);
            formImages = $("#htmlModal #formFileContainer #formImages").val();
            var params = [];
            if (formImages && formImages.length) {
                var initImages = formImages.split(',');
                for (var i = 0; i < initImages.length; i++) {
                    if (initImages[i]) {
                        params.push({ name: initImages[i], src: '/upload/content/' + id + "/" + initImages[i] + "?_" + Math.random() });
                    }
                }
            }
            iniFileUpload("#htmlModal #formFileContainer", params);
        },
        complete: function() {
            removeMask();
            $(sender).removeClass('disabled');
        }
    });
}

function btnSaveFileClick(sender) {
    if ($(sender).hasClass('disabled'))
        return;

    $(sender).addClass('disabled');
    loadMask();
    var data = new FormData();
    data.append('Id', $("#htmlModal #formId").val());

    var hasEmptyImage = false;
    $("#htmlModal #formFileContainer .imagecell").filter(function() {
        //第一个元素未模板，最后一个元素始终为空
        if ($(this).hasClass("hidden") || $(this).is(":last-child"))
            return false;
        else
            return true;
    }).each(function(i, o) {
        if (hasEmptyImage)
            return;

        var files = $(o).find(".fromuploadfilefile").prop('files');
        var name = $(o).find(".fromuploadfilename").val();

        if (!name && !files.length) {
            hasEmptyImage = true;
            return;
        }

        if (name) {
            data.append("filename" + i, name);
        }

        if (files.length) {
            data.append("file" + i, files[0]);
        }
    });
    ajaxSubmit({
        type: "post",
        url: "admin.php?model=content&action=fileupload&parital=indexpartial",
        data: data,
        processData: false,
        contentType: false,
        success: function(ret) {
            if (ret.Success) {
                $("#htmlModal").modal('hide');
                $.sticky("保存成功", { type: "st-success" });
                query();
            } else {
                $.sticky(ret.Message, { type: "st-error" });
            }
        },
        complete: function() {
            removeMask();
            $(sender).removeClass('disabled');
        }
    });
}

//#endregion