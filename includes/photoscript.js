
(function(){
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d'),
        sup = document.getElementById('superImage'),

        vendorUrl = window.URL || window.webkitURL;

    navigator.getMedia = 	navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia;

    navigator.getMedia({
        video: true,
        audio: false
    }, function(stream) {
        video.src = vendorUrl.createObjectURL(stream);
        video.play();
    }, function(error) {
        //error code
    });

    document.getElementById('capture').addEventListener('click', function() {
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');

        context.drawImage(video, 0, 0, 390, 390);
        context.drawImage(sup, 0, 0, 390, 390);
        // var element = document.getElementById('picture');
        var img = canvas.toDataURL('image/jpeg');

        document.getElementById('canvas').style.display = "block";
        document.getElementById('photo').style.display = "none";
        document.getElementById('bt_upload').disabled = false;
    })
})();

function merge(el) {
    var imageSrc = el.src;
    var sup = document.getElementById('superImage');
    var supupload = document.getElementById('superUploadImage');
    sup.setAttribute('src', imageSrc);
    supupload.setAttribute('value', imageSrc);
    document.getElementById('capture').disabled = false;
    document.getElementById('upload_image').disabled = false;
    sup.style.display = "block";
}

var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');

function prepareImg() {
    var canvas = document.getElementById('canvas');
    document.getElementById('inp_img').value = canvas.toDataURL();
}

window.onload = function uploadImg() {
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    var uploadimg = document.getElementById('uploadimage');
    var uploadsupimg = document.getElementById('uploadSupimage');

    if (uploadimg != null) {
        context.drawImage(uploadimg, 0, 0, 390, 390);
        context.drawImage(uploadsupimg, 0, 0, 390, 390);
        var img = canvas.toDataURL('image/jpeg');

        document.getElementById('canvas').style.display = "block";
        document.getElementById('photo').style.display = "none";
        document.getElementById('uploadimage').style.display = "none";
        document.getElementById('uploadSupimage').style.display = "none";
    }
}

function able() {
    document.getElementById('bt_upload').disabled = false;
}