function MyFunction() {
    var modal = document.getElementById('myLOGIN');

    var nupp = document.getElementById("js_login");


    var span = document.getElementsByClassName("close_login")[0];

    nupp.onclick = function () {
        modal.style.display = "block";
    }


    span.onclick = function () {
        modal.style.display = "none";
    }


    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}


