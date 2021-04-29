function validarSocio_2() {
  // Declare variables
  var filter, i;
  var test = parseInt(document.getElementById("socio_id").value);
  // Loop through all list items, and hide those who don't match the search query
  for (i = 0; i < $socios.length; i++) {
    filter=$socios[i].socio_id
    if (!filter === test || isNaN(test) || test > i) {
      document.getElementById('socio_id').focus();
      document.getElementById('ficha_socio').classList.add('w3-hide');
    } else {
      document.getElementById('ficha_socio').classList.remove('w3-hide');
      document.getElementById('foto_socio').setAttribute('src', socios[test].foto_socio);
      document.getElementById('numero_socio').innerHTML = socios[test].id_socio;
      document.getElementById('nombre_socio').innerHTML = socios[test].nombre_socio + " " + socios[test].primer_apellido_socio;
      document.getElementById('dbirth_socio').innerHTML = socios[test].fecha_de_nacimiento;
      var d = new Date();
      var today = d.getDate();
      var month = d.getMonth() + 1;
      var year = d.getFullYear();
      var day_birth = parseInt(socios[test].fecha_de_nacimiento.slice(0, 2));
      var month_birth = parseInt(socios[test].fecha_de_nacimiento.slice(3, 5));
      var yeaar_birth = parseInt(socios[test].fecha_de_nacimiento.slice(6, 10));
      var old = year-yeaar_birth;
      if (today === day_birth && month === month_birth) {
        document.getElementById('dbirth_socio').innerHTML += "<br>&#127873; " + old + " años. Felicidades.";
      }
      document.getElementById('sex_socio').innerHTML = socios[test].sexo;
      document.getElementById('saldo_socio').innerHTML = socios[test].credito;
      document.getElementById("id_socio").value="";
    }
  }
};

function validarSocio(value) {
  let str = value;
  var xhttp;
  socio_id = parseInt(value);
  console.log(socio_id);
  if (str == "") {
    document.getElementById("ficha_socio").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("ficha_socio").innerHTML = this.responseText;
      return;
    }
  };
  console.log("valor de la variable str: " + str);
  xhttp.open("GET", "templates/fichaSocioHome.php?q=" + str, true);
  xhttp.send();
}