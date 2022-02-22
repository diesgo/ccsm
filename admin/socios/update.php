<?php
$titulo = "Editar socio";
include '../templates/header.php';

$socios = getSociosById($_GET['id']);
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fas fa-edit"></i> Editar socio</b></h2>
    </div>
    <div class="w3-half">
        <?php
        if (isset($_POST['actualizar'])) {
            $id = $socios['id_socio'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $dni = $_POST['dni'];
            $birth = $_POST['birth'];
            $pais = $_POST['pais_id'];
            $genero = $_POST['genero_id'];
            $consumo = $_POST['consumo'];
            $rol = $_POST['rol_id'];
            $saldo = $_POST['saldo'];

            $sql = "UPDATE socios SET nombre_socio = '" . $nombre . "',
            apellidos_socio = '" . $apellidos . "',
            card_id_socio = '" . $dni . "',
            birth = '" . $birth . "',
            pais_id = '" . $pais . "', 
            rol_id = '" . $rol . "',
            genero_id = '" . $genero . "',
            consumo='" . $consumo . "', 
            saldo='" . $saldo . "'
            WHERE id_socio = " . $id . ";";
            echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";

            mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
        } else {
            if (!isset($_POST['id_socio'])) {
                $sql = "SELECT min(id_socio) FROM socios";
                $result = mysqli_query($conex, $sql);
                $row = mysqli_fetch_assoc($result);
                $id = $row['min(id_socio)'];
            } else {
                $id = $_POST["id_socio"];
            }
            $sql = "SELECT * FROM socios WHERE id_socio='$id'  ";
            $result = mysqli_query($conex, $sql);
            $row = mysqli_fetch_assoc($result);
            $nombre = $row['nombre_socio'];
            $apellidos = $row['apellidos_socio'];
            $dni = $row['card_id_socio'];
            $birth = $row['birth'];
            $pais = $row['pais_id'];
            $genero = $row['genero_id'];
            $consumo = $row['consumo'];
            $rol = $row['rol_id'];
            $saldo = $row['saldo'];
        }
        $sql = "SELECT * FROM socios";
        $result = mysqli_query($conex, $sql);
        ?>
    </div>
    <hr>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="formulario" id="formulario">

                <!-- FICHA SOCIO  -->
                <div class="w3-content w3-padding">

                    <!-- FILA 1: TRATAMIENTO -->
                    <div class="w3-container">
                        <h1><span class="w3-text-theme">Socio # <?php echo $socios['id_socio'] ?></span> <?php echo $socios['nombre_socio'] ?> <?php echo $socios['apellidos_socio'] ?></h1>
                    </div>
                    <div class="w3-row w3-section">
                        <div class="w3-col m2 l2 w3-padding">
                            <label for="genero_id" class="w3-text-theme">Tratamiento:</label>
                            <select name="genero_id" id="genero_id" class="w3-select w3-border w3-border-theme w3-round">
                                <option value=<?php echo $socios['genero_id'] ?>><?php echo $socios['genero'] ?></option>
                                <option value=1>Hombre</option>
                                <option value=2>Mujer</option>
                                <option value=3>Otro</option>
                            </select>
                        </div>
                    </div>

                    <!-- FILA 2: NOMBRE Y APELLIDO -->
                    <div class="w3-row">
                        <!-- NOMBRE -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="nombre" class="w3-text-theme">Nombre</label><br>
                            <input class="w3-input w3-border w3-border-theme w3-round" name="nombre" id="nombre" type="text" value="<?php echo $socios['nombre_socio'] ?>">
                            <small id="info_nombre"></small>
                        </div>
                        <!-- APELLIDOS -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="apellidos" class="w3-text-theme">Apellidos</label>
                            <input class="w3-input w3-border w3-border-theme w3-round" name="apellidos" id="apellidos" type="text" value="<?php echo $socios['apellidos_socio'] ?>">
                            <small id="info_apellidos"></small>
                        </div>
                    </div>

                    <!-- FILA 3: BIRTH, DNI, PAIS -->
                    <div class="w3-row">

                        <!-- FECHA DE NACIMIENTO -->
                        <div class="w3-col m4 l4 s12 w3-padding nativeDatePicker">
                            <label for="birth" class="w3-text-theme">Fecha de nacimiento:</label>
                            <input class="w3-input w3-border w3-border-theme w3-round" type="date" id="birth" name="birth" value=<?php echo $socios['birth'] ?>>
                            <span class="validity"></span>
                            <p class="fallbackLabel">Fecha de nacimiento:</p>
                            <div class="fallbackDatePicker">
                                <span>
                                    <label for="day">Día:</label>
                                    <select id="day" name="day"></select>
                                </span>
                                <span>
                                    <label for="month">Mes:</label>
                                    <!-- SELECT FECHA -->
                                    <select id="month" name="month">
                                        <option selected>Enero</option>
                                        <option>Febrero</option>
                                        <option>Marzo</option>
                                        <option>Abril</option>
                                        <option>Mayo</option>
                                        <option>Junio</option>
                                        <option>Julio</option>
                                        <option>Agosto</option>
                                        <option>Septiembre</option>
                                        <option>Octubre</option>
                                        <option>Noviembre</option>
                                        <option>Deciembre</option>
                                    </select>
                                </span>
                                <span>
                                    <label for="year">Año:</label>
                                    <select id="year" name="year"></select>
                                </span>
                            </div>
                            <small id="infoBday"></small>
                        </div>

                        <!-- DNI -->
                        <div class="w3-col l4 m4 s12 w3-padding">
                            <label for="dni" class="w3-text-theme">DNI / ID</label>
                            <input class="w3-input w3-border w3-border-theme w3-round" name="dni" id="dni" type="text" value=<?php echo $socios['card_id_socio']; ?>>
                            <small id="info_dni"></small>
                        </div>

                        <!-- NACIONALIDAD -->
                        <div class="w3-col l4 m4 s12 w3-padding">
                            <label for="pais_id" class="w3-text-theme">Nacionalidad</label>
                            <!-- SELECT PAISES -->
                            <select name="pais_id" id="pais_id" class="w3-select w3-border w3-border-theme w3-round">
                                <option value=<?php echo $socios['pais_id'] ?>><?php echo $socios['bandera'] . ' ' . $socios['pais'] ?></option>
                                <?php
                                $pais = getPaises();
                                foreach ($pais as $pais) :
                                ?>
                                    <option value=<?php echo $pais['id_pais'] ?>><?php echo $pais['bandera']. ' ' .$pais['pais'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- FILA 4 -->
                    <div class="w3-row">

                        <!-- ROL -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="rol_id" class="w3-text-theme">Tipo de socio</label>
                            <select name="rol_id" id="rol_id" class="w3-select w3-border w3-border-theme w3-round" value=<?php echo $socios['rol_id']; ?>>
                                <option value=<?php echo $socios['rol_id'] ?>><?php echo $socios['rol'] ?></option>
                                <?php
                                $roles = getRoles();
                                foreach ($roles as $rol) :
                                ?>
                                    <option value=<?php echo $rol['id_rol'] ?>><?php echo $rol['rol'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="info_rol"></small>
                        </div>

                        <!-- CUOTA -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="cuota" class="w3-text-theme">Cuota</label>
                            <select name="cuota" id="cuota" class="w3-select w3-border w3-border-theme w3-round">
                                <option value="">Seleccionar</option>
                            </select>
                            <small id="info_cuota"></small>
                        </div>

                        <!-- CONSUMO MENSUAL -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="consumo" class="w3-text-theme">Consumo mes</label>
                            <input class="w3-input w3-border w3-border-theme w3-round" name="consumo" id="consumo" type="text" value=<?php echo $socios['consumo'] ?>>
                            <small id="info_consumo"></small>
                        </div>

                        <!-- SALDO -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="saldo" class="w3-text-theme">Saldo</label>
                            <input class="w3-input w3-border w3-border-theme w3-round" name="saldo" id="saldo" type="text" value=<?php echo $socios['saldo'] ?>>
                            <small id="info_saldo" /small>
                        </div>
                    </div>

                    <!-- FILA 5: IMAGENES -->
                    <!-- FILA 4; IMAGENES -->
                    <div class="w3-row">
                        <!-- FOTO SOCIO -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <!-- <label for="foto" class="w3-text-theme">Foto socio</label>
                            <input class="w3-input w3-border w3-round w3-white" name="foto" id="foto" type="file" accept="image/*">
                            <small id="info_foto"></small> -->
                            <div class="w3-container">
                                <img src="" alt="Foto socio" class="w3-image" id="putFotoSocio" />
                            </div>
                        </div>
                        <!-- ID FRONTAL -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <!-- <label for="idFront" class="w3-text-theme">DNI / ID frontal</label>
                            <input class="w3-input w3-border w3-round w3-white" name="idFront" id="idFront" type="file" accept="image/*">
                            <small id="idFront"></small> -->
                            <div class="w3-container">
                                <img src="" alt="DNI / ID front" class="w3-image" id="putDniFrontSocio" />
                            </div>
                        </div>
                        <!-- ID TRASERA -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <!-- <label for="idBack" class="w3-text-theme">DNI / ID trasera</label>
                            <input class="w3-input w3-border w3-round w3-white" name="idBack" id="idBack" type="file" accept="image/*"> -->
                            <div class="w3-container">
                                <img src="" alt="DNI / ID back" class="w3-image" id="putDniBackSocio" />
                            </div>
                        </div>
                        <!-- Firma -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <!-- <label for="firma" class="w3-text-theme">firma</label>
                            <input class="w3-input w3-border w3-round w3-white" name="firma" id="firma" type="file" accept="image/*"> -->
                            <div class="w3-container">
                                <img src="" alt="firma" class="w3-image" id="putFirmaSocio" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w3-row w3-padding-32 w3-center">
                    <input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-theme w3-round">
                    <a class="w3-button w3-theme w3-round" href="index.php">Volver</a>
                    <!-- <button type="button" class="w3-button w3-theme w3-round" id="product_form_save_new_btn" data-toggle="pstooltip" title="Guardar y crear un nuevo producto: ALT+SHIFT+P">Añadir nuevo producto</button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../js/fecha.js"></script>
<!-- !End page content! -->
<?php
include '../templates/footer.php';
?>