var fonts = ["abel", "acme", "aguafina-sgript", "alata", "alex-brush", "antonio", "clubz", "cookie", "kingthings-exeter", "kingthings-foundation", "lobster", "montserrat","permanent-marker","sweet-leaf"];

var numFonts = fonts.length;
var x = document.getElementById("body");

function cambioFuente() {
    let f = document.getElementById("fuentes").selectedIndex;
    let font = fonts[f];
    document.getElementById("muestra").className = "font-" + font;
    document.getElementById("fuente").innerHTML = font;
}
cambioFuente();