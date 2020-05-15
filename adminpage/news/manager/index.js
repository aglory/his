$(function() {
    query();
});

function query() {
    loadMask();
    ajaxSubmit({
        url: "admin.php?model=news&action=manager&parital=indexpartial",
        success: function(e) {
            if (e && e.Success) {
                $("#manangercontent").html(e.Value);
            }
        },
        complete: function() {
            removeMask();
        }
    });
}