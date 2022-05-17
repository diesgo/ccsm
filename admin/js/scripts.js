var mySidebar = document.getElementById("mySidebar");

var overlayBg = document.getElementById("myOverlay");

function drop(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.classList.add("w3-show");
        x.classList.add("w3-animate-opacity");
    } else {
        x.classList.remove("w3-show");
        x.classList.remove("w3-animate-opacity");
    }
}

function closeAllSelect(elmnt) {
    /*a function that will close all select boxes in the document,
    except the current select box:*/
    var x, y, i, xl, yl, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    xl = x.length;
    yl = y.length;
    for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
            arrNo.push(i)
        } else {
            y[i].classList.remove("select-arrow-active");
        }
    }
    for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
        }
    }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);

function validateChip(chipId){
     return socios === chipId;
    

    function result() {
        document.getElementById("demo").innerHTML = ages.find(validateChip);
    }
}