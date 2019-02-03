function like_function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../like.php", false);
    xmlhttp.send();

    document.getElementById("likeimg").src = "includes/images/liked.png";
}

function liked_function() {
    var xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.open("GET", "../liked.php", false);
    xmlhttp2.send();

    document.getElementById("likeimg").src = "includes/images/like.png";
}