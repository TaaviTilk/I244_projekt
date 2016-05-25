var modal = document.getElementById('myModal1');

var nupp = document.getElementById("kuva");


var span = document.getElementsByClassName("close1")[0];


nupp.onclick = function() {
    modal.style.display = "block";
}


span.onclick = function() {
    modal.style.display = "none";
}


window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


