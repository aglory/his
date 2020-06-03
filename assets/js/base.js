///下部按钮点击
function btntabheaderclick(sender, id) {
    if (sender.className.indexOf('active') >= 0)
        return;

    var lis = document.querySelectorAll('.footlink ul.tabheader li');
    for (var i = 0; i < lis.length; i++) {
        lis[i].className = lis[i].className.replace('active', '');
    }

    sender.className = sender.className + " active";

}

///查询按钮
function btnsearchclick(sender) {
    window.location.href = "?action=list&model=cms&keyWord=" + window.encodeURIComponent(document.getElementById('txtKeyWord').value);
}