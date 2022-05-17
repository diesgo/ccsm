function dropAside(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    // x.previousElementSibling.className += " w3-green";
  } else {
    x.className = x.className.replace(" w3-show", "");
    // x.previousElementSibling.className =
    //     x.previousElementSibling.className.replace(" w3-green", "");
  }
}
function openCity(tabName) {
  var i;
  var x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  document.getElementById(tabName).style.display = "block";
}

function w3_open() {
  if (mySidebar.style.display === "block") {
    mySidebar.style.display = "none";
    // overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = "block";
    // overlayBg.style.display = "block";
  }
}

function w3_close() {
  mySidebar.style.display = "none";
  // overlayBg.style.display = "none";
}

function checkRetirada() {
  var cantidad = document.getElementById("quantity").value;
  var precio = document.getElementById("price").value;
  var regalo = document.getElementById("gift").value;
  console.log(cantidad);
  if ((cantidad = "")) {
    console.log("no se ha agregado cantidad");
  }
}
