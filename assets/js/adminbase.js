function ajaxSubmit(params) {
    var objParams = { dataType: "json", beforeSend: function(XMLHttpRequest) { XMLHttpRequest.setRequestHeader("isAjax", "true"); } };
    if (typeof params == 'function')
        params = { success: params };
    else if (typeof params != 'object')
        params = { success: params };

    if (!params.success)
        params.success = function() {}

    objParams = $.extend(objParams, params, {
        success: function(d, s, jqXHR) {
            //401 Unauthorized
            if (d.StatusCode == 401) {
                //alert("登录超时，请重新登录");
                window.top.location.href = 'admin.php?model=login&action=login';
            } else {
                params.success.apply(this, [d, s, jqXHR]);
            }
        }
    });
    $.ajax(objParams);
}

function loadMask() {

}

function removeMask() {

}

function notify() {
    ajaxSubmit({
        url: 'admin.php?model=login&action=notify',
        type: 'post',
        data: { r: Math.random() }
    });
    setTimeout(function() {
        notify();
    }, 1000 * 30);
}

notify();