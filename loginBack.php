<?php
  session_start();
   
  // Obtengo los datos cargados en el formulario de login.
  $user = $_POST['username'];
  $password = $_POST['password'];
   
  // Datos para conectar a la base de datos.
  $nombreServidor = "localhost";
  $nombreUsuario = "root";
  $passwordBaseDeDatos = "";
  $nombreBaseDeDatos = "greenpower";
  
  // Crear conexión con la base de datos.
  $conn = new mysqli($nombreServidor, $nombreUsuario, $passwordBaseDeDatos, $nombreBaseDeDatos);
   
  // Validar la conexión de base de datos.
  if ($conn ->connect_error) {
    die("Connection failed: " . $conn ->connect_error);
  }
   
  // Consulta segura para evitar inyecciones SQL.
  $sql = sprintf("SELECT * FROM users WHERE username='%s' AND password = '%s'", mysqli_real_escape_string($user), mysqli_real_escape_string($password));
  $resultado = $conn->query($sql);
   
  // Verificando si el usuario existe en la base de datos.
  if($resultado){
    // Guardo en la sesión el email del usuario.
    $_SESSION['user'] = $user;
     
    // Redirecciono al usuario a la página principal del sitio.
    header("HTTP/1.1 302 Moved Temporarily"); 
    header("Location: select.php"); 
  }else{
    echo 'El email o password es incorrecto, <a href="index.php">vuelva a intenarlo</a>.<br/>';
  }
 
?>
<script>location.replace('index.php');</script>