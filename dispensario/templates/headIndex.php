<!DOCTYPE html>
<html lang="es">
    <head>
        <?php
        require '../../config.php';
        require '../../config/functions.php';
        $settings = getSetingsById(1);
        ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $titulo ?> | CCSM</title>
        <link rel="icon" href="../../img/ccms.ico" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="../../webfonts/stylesheet.css">
        <link rel="stylesheet" href="../../fontawesome5/css/all.css">
        <link rel="stylesheet" href="../../css/w3.css">
        <link rel="stylesheet" href="../../css/themes/w3-theme-<?php echo $settings['color']; ?>.css">
        <link rel="stylesheet" href="../../css/style.css">
    </head>
    <style>
        label, legend,
        th, button,
        input[type="submit"], input[type="button"],
        a, h1, h2, h3, h4, h5, h6 {
            font-family: <?php echo $settings['titulos'] ?>;
        }
    </style>
    <body class="w3-theme-light font-<?php echo $settings['fuente'] ?>">

        <!-- Top container -->

        <div class="w3-container w3-top w3-theme-dark w3-large" style="z-index:4; padding: 8px 8px">
                <div class="w3-bar w3-padding">
                    <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-theme" onclick="w3_open();"><i class="fa fa-bars"></i> Menu</button>
                    <a href="../home/index.php">
                        <span class="w3-bar-item w3-white" style="padding: 8px; border-radius: 50%;"><img class="w3-image" src="../../img/ccms_logo.png" alt="logo" style="max-width:30px"></span>
                        <span class="w3-hide-small w3-bar-item w3-center">Cannabis Club System Management</span>
                    </a>
                    <a class="w3-hide-small w3-bar-item w3-button w3-border w3-border-theme w3-round w3-theme-d3 w3-hover-white w3-hover-text-theme w3-right" href="../../admin/home/index.php">Administrar</a>
                </div>
        </div>

        <!-- Sidebar/menu -->

        <nav class="w3-sidebar w3-collapse w3-theme" style="z-index:3; top:58px; width:250px;" id="mySidebar"><br>
            <div class="w3-container w3-theme">
                <h5 class="w3-text-white"><i class="fas fa-tachometer-alt"></i> Panel de control</h5>
            </div>
            <div class="w3-bar-block">

                <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-theme" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i> Close Menu</a>
                <a href="../home/index.php" class="w3-bar-item w3-button w3-padding w3-theme-l1 w3-hover-theme  w3-card-4"><i class="fas fa-home"></i> Home</a>

                <button class="w3-button w3-block w3-left-align w3-theme-l1 w3-card-4 w3-hover-theme" onclick="dropAside('catalogo')"><i class="fas fa-book"></i> Catálogo <i class="w3-right fa fa-caret-down"></i></button>
                <div id="catalogo" class="w3-hide w3-white w3-theme-l2">
                    <a href="../variedades/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-hover-theme w3-medium w3-margin-left w3-padding">Variedades</a>
                    <a href="../servicios/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-hover-theme w3-medium w3-margin-left w3-padding">Servicio</a>
                    <a href="../categorias/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-hover-theme w3-medium w3-margin-left w3-padding">Categorias</a>
                    <a href="../proveedores/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-hover-theme w3-medium w3-margin-left w3-padding">Proveedores</a>
                    <a href="../productos/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-hover-theme w3-medium w3-margin-left w3-padding">Productos</a>
                    <a href="../emojis/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-hover-theme w3-medium w3-margin-left w3-padding">Emojis</a>
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
                    <a href="../usuarios/index.php" class="w3-bar-item w3-button w3-text-theme-dark w3-card-4 w3-hover-theme">Usuarios</a>
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

        <div class="w3-main" style="margin-left:250px; margin-top:78px; min-height: max-content;">            

            <!-- Header -->

            <div class="w3-container w3-padding">
                <div class="w3-content">
                    <h2 class="w3-text-theme w3-center"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>

            <!-- !PAGE CONTENT! -->

            <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 638px;">