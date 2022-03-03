<?php
$titulo="Borrar categoria";
// include "../templates/header.php";
require "../../config/functions.php";
// require "../../config/conexion.php";

$categorias = getCategoriasById($_GET['id_categoria']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if ($_POST['validation'] == 'si') {
			if ($_POST['id_producto'] != '') {
				echo 'Hola ' . $_POST['id_producto'];
				$id_producto = $_POST['id_producto'];
			}else{
				echo 'Has olvidado poner tu nombre';
			}
		}
	}else{
		echo 'Ha ocurrido un error';
	}

if(isset($_POST['bajaButton'])){
	$id_categoria = $categoria['id_categoria'];
	$sql = "DELETE FROM categorias WHERE id_categoria='$id_categoria'";
	mysqli_query($conex, $sql);
    echo "<script>location.replace('index.php');</script>";
}

?>

<!DOCTYPE html>

 <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $titulo ?> | CCSM</title>
        <link rel="icon" href="../../../img/ccms.ico" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="../../../webfonts/stylesheet.css">
        <link rel="stylesheet" href="../../../fontawesome5/css/all.css">
        <link rel="stylesheet" href="../../../css/w3.css">
        <link rel="stylesheet" href="../../../css/themes/w3-theme-<?php echo $settings['color']; ?>.css">
        <link rel="stylesheet" href="../../../css/style.css">
    </head>
    <style>
        .panel {
            box-shadow: 0 1px 2px rgba(0, 0, 0, .3);
        }

        label,
        legend,
        th,
        button,
        input[type="submit"],
        input[type="button"],
        a,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: <?php echo $settings['titulos'] ?>;
        }
    </style>

    <body class="w3-theme-light font-<?php echo $settings['fuente'] ?>">

        <!-- Top container -->

        <div class="w3-container w3-top w3-theme-dark w3-large" style="z-index:4; padding: 8px 8px">
            <div class="w3-bar w3-padding">
                <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-theme" onclick="w3_open();"><i class="fa fa-bars"></i> Menu</button>
                <span class="w3-bar-item w3-white" style="padding: 8px; border-radius: 50%;"><img class="w3-image" src="../../img/ccms_logo.png" alt="logo" style="max-width:30px"></span>
                <span class="w3-bar-item w3-center">Cannabis Club System Management</span>
                <a class="w3-bar-item w3-button w3-border w3-border-theme w3-round w3-theme-d3 w3-hover-white w3-hover-text-theme w3-right" href="../../dispensario/index.php">Dispensario</a>
            </div>
        </div>

        <!-- Sidebar/menu -->

        <nav class="w3-sidebar w3-collapse w3-theme" style="z-index:3; top:58px; width:300px;" id="mySidebar"><br>

            <div class="w3-container w3-theme">
                <h5 class="w3-text-white"><i class="fas fa-tachometer-alt"></i> Panel de control</h5>
            </div>

            <div class="w3-bar-block">
                <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-theme" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i> Close Menu</a>
               
                <a href="../home/index.php" class="w3-bar-item w3-button w3-padding w3-theme-l1 w3-hover-theme  w3-card-4"><i class="fas fa-home"></i> Home</a>
               
                <button class="w3-button w3-block w3-left-align w3-theme-l1 w3-card-4 w3-hover-theme" onclick="dropAside('catalogo')"><i class="fas fa-book"></i> Catálogo <i class="w3-right fa fa-caret-down"></i></button>
                <div id="catalogo" class="w3-hide w3-white w3-theme-l2">
                    <a href="../productos/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme">Productos</a>
                    <a href="../servicio/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme">Servicio</a>
                    <a href="../categorias/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme">Categorias</a>
                    <a href="../variedades/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme">Variedades</a>
                    <a href="../proveedores/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme">Proveedores</a>
                </div>
               
                <button class="w3-button w3-block w3-left-align w3-theme-l1 w3-hover-theme w3-card-4" onclick="dropAside('categorias')"><i class="fas fa-boxes"></i> Categorías <i class="w3-right fa fa-caret-down"></i></button>
                <div id="categorias" class="w3-hide w3-white w3-theme-l2">
                    <?php
                        $categorias = getCategorias();
                        foreach ($categorias as $categoria) :
                        ?>
                        <a href="../categorias/show.php?id=<?php echo $categoria['id_categoria'] ?>" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme"><i class="<?php echo $categoria['icono']; ?>"></i> <?php echo $categoria['nombre_categoria']; ?></a>
                    <?php endforeach; ?>
                    <a href="../productos/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme">Todas</a>
                </div>
               
                <button class="w3-button w3-block w3-left-align w3-theme-l1 w3-card-4 w3-hover-theme" onclick="dropAside('configuracion')"><i class="fa fa-cog fa-fw"></i> Configuración <i class="w3-right fa fa-caret-down"></i></button>
                <div id="configuracion" class="w3-hide w3-white w3-theme-l2">
                    <a href="../categorias/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme">Categorias</a>
                    <a href="../roles/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme">Roles</a>
                    <a href="#" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme">Tarifas</a>
                </div>
                
                <button class="w3-button w3-block w3-left-align w3-theme-l1 w3-card-4 w3-hover-theme" onclick="dropAside('personalizar')"><i class="fas fa-paint-roller"></i> Personalizar <i class="w3-right fa fa-caret-down"></i></button>
                <div id="personalizar" class="w3-hide w3-white w3-theme-l2">
                    <a href="../setings/color.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme"><i class="fas fa-palette"></i> Esquemas de color</a>
                    <a href="../setings/fuente.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme"><i class="fas fa-font"></i> Fuentes</a>
                </div>
                
                <button class="w3-button w3-block w3-left-align w3-theme-l1 w3-card-4 w3-hover-theme" onclick="dropAside('socios')"><i class="fa fa-users a-fw"></i> Socios <i class="w3-right fa fa-caret-down"></i></button>
                <div id="socios" class="w3-hide w3-white w3-theme-l2">
                    <a href="../generos/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme"><i class="fas fa-users"></i> Géneros</a>
                    <a href="../roles/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme"><i class="fas fa-users"></i> Roles</a>
                    <a href="../socios/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme"><i class="fas fa-users"></i> Socios</a>
                    <a href="../socios/create.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme"><i class="fas fa-user-plus"></i> Nuevo socio</a>
                </div>
                
                <div class="w3-bar-block">
                    <a href="#" class="w3-bar-item w3-button w3-padding w3-theme-l1 w3-card-4 w3-hover-theme"><i class="fas fa-chart-line"></i> Statistics</a>
                    <a href="../setings/index.php" class="w3-bar-item w3-button w3-padding w3-theme-l1 w3-card w3-hover-theme"><i class="fas fa-sliders-h"></i> Apariencia</a>
                </div>
            </div>
        </nav>

        <!-- Overlay effect when opening sidebar on small screens -->

        <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

        <script src="../js/header.js"></script>

        <div class="w3-main" style="margin-left:300px;margin-top:52px; min-height: max-content;">




<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fas fa-edit"></i></i><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">

    </div>
</div>
<div class="w3-container w3-padding-64 w3-responsive" style="min-height: 636px;">
    <h1 class='bg w3-center w3-round'>Eliminar categoria</h1>
    <form class="w3-content" method="post" action="<?php $PHP_SELF ?>">
        <div class="w3-cell-row w3-padding">
            <div class="w3-col l6 m6 s12">
                <label for="nombre_categoria">¿Confirmas que quieres eliminar este registro?</label>
                <input class="w3-input w3-border " type="text" name="nombre_categoria" placeholder="<?php echo $categoria['nombre_categoria']; ?>" value="<?php echo $categoria['nombre_categoria']; ?>">
            </div>
        </div>
        <div class="w3-row w3-padding">
            <div class="w3-card">
                <input class="w3-right w3-btn w3-red w3-round" type="submit" value="Eliminar" name="bajaButton">
                <a href="index.php" class="w3-button w3-right w3-theme w3-round">Volver</a>
            </div>
        </div>
    </form>
</div>
<!-- !End page content! -->
<?php
include '../templates/footer.php';
?>