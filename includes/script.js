
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
        context.drawImage(video, 0, 0, 413, 400);
        context.drawImage(sup, 0, 0, 413, 400);
        var element = document.getElementById('picture');
        var img = canvas.toDataURL('image/jpeg');
        element.value = img;
        document.getElementById('capture-form').submit();
    })
})();

function merge(el) {
    var imageSrc = el.src;
    var sup = document.getElementById('superImage');
    sup.setAttribute('src', imageSrc);
    document.getElementById('capture').disabled = false;
}

var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');

function prepareImg() {
    var canvas = document.getElementById('canvas');
    document.getElementById('inp_img').value = canvas.toDataURL();
}

