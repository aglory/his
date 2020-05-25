function btnLoginClick(sender) {
    sender.disabled = true;
    var data = {
        name: $("#inputName").val(),
        password: $("#inputPassword").val(),
        verifyCode: $("#inputVerifyCode").val()
    };
    loadMask();
    ajaxSubmit({
        url: 'admin.php?model=login&action=checklogin',
        data: data,
        type: 'post',
        success: function(ret) {
            if (ret.Success) {
                window.location.href = 'admin.php?model=home&action=index';
            } else {
                removeMask();
                sender.disabled = false;
                showMessage('系统', ret.Message);
                var img = document.getElementById('verifyCodeImage');
                btnChangeVerifyCodeClick(img);
            }
        },
        error: function() {
            removeMask();
            sender.disabled = false;
        }
    });
}

/**
 * 刷新验证码
 */
function btnChangeVerifyCodeClick(sender) {
    sender.src = "admin.php?model=login&action=verifycode&_" + Math.random();
}