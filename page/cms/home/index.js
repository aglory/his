function btnblocktabsnavclick(sender, id) {
    if (sender.className.indexOf('active') >= 0)
        return;

    var lis = document.querySelectorAll('.blocktabs .nav ul li');
    for (var i = 0; i < lis.length; i++) {
        lis[i].className = lis[i].className.replace('active', '');
    }
    sender.className = sender.className + " active";

    var contentitems = document.querySelectorAll('.blocktabs .contentitem');
    for (var i = 0; i < contentitems.length; i++) {
        contentitems[i].className = contentitems[i].className.replace('active', '');
    }
    var currentcontentitem = document.getElementById('contentitem' + id);
    currentcontentitem.className = currentcontentitem.className + " active";
}

function imgslideanimates() {
    var slides = document.querySelectorAll(".blocktabs .slide .slides");
    for (var i = 0; i < slides.length; i++) {
        var slider = slides[i].querySelector(".slider");
        imgslideanimate(slider, slider.clientWidth, 0);
    }
}

function imgslideanimate(slide, width, index) {
    slide.style.marginLeft = "-" + index + "px";
    if (index >= width) {
        slide.style.marginLeft = "0px";
        var parentNode = slide.parentNode;
        //将当前隐藏元素排到最后
        parentNode.removeChild(slide);
        parentNode.appendChild(slide);
        slide = parentNode.querySelector(".slider");
        setTimeout(function() {
            imgslideanimate(slide, width, 0);
        }, 1000);
    } else {
        setTimeout(function() {
            imgslideanimate(slide, width, index + 1);
        }, 20);
    }
}

window.onload = function() {
    imgslideanimates();
};