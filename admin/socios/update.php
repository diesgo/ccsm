               <?php
                    $titulo = "Editar socio";
                    include '../templates/header.php';
                    include '../../config/conexion.php';
                    $socio = getSociosById($_GET['id']);
                    if (isset($_POST['update'])) {
                        $id = $socio ['id_socio'];
                        $genero = $_POST['genero'];
                        $nombre = $_POST['nombre'];
                        $apellidos = $_POST['apellidos'];
                        $dni = $_POST['dni'];
                        $birth = $_POST['birth'];
                        $pais = $_POST['pais'];
                        $consumo = $_POST['consumo'];
                        $rol = $_POST['rol'];
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
                        echo "<script>location.replace('index.php');</script>";
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
                    }
                    $sql = "SELECT * FROM socios";
                    $result = mysqli_query($conex, $sql);
                ?>

                <!-- !PAGE CONTENT! -->

                <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">
                    <div class="w3-container">
                        <div style="width: 60%; margin: 0 auto;" class="w3-mobile">
                            <form accept-charset="utf-8" action="#" method="post" name="form" id="form" class="w3-theme-l2 w3-round-xlarge w3-padding">
                                <!-- FICHA SOCIO  -->
                                <div class="w3-content w3-padding">
                                    <!-- FILA 1: TRATAMIENTO -->
                                    <div class="w3-row w3-section">
                                        <div class="w3-col l3 m3 s12 w3-padding">
                                            <label for="genero">Tratamiento</label>
                                            <!-- SELECT GÉNERO -->
                                            <select name="genero" id="genero" class="w3-select w3-white">
                                                <option value=<?php echo $socio['genero_id'] ?>><?php echo $socio['signo'].' '.$socio['nombre_genero']?></option>
                                                <?php
                                                $generos = getGeneros();
                                                foreach ($generos as $genero) :
                                                ?>
                                                <option value=<?php echo $genero['id_genero'] ?>><?php echo $genero['signo'].' '.$genero['nombre_genero']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- FECHA DE NACIMIENTO -->
                                        <div class="w3-col m3 l3 s12 w3-padding nativeDatePicker">
                                            <label for="birth">Fecha de nacimiento:</label>
                                            <input class="w3-input w3-border w3-round" type="date" id="birth" name="birth" value="<?php echo $socio['birth']?>"]>
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
                                            <small id="info_birth"></small>
                                        </div>
                                    </div>
                                    <!-- FILA 2: NOMBRE Y APELLIDO -->
                                    <div class="w3-row w3-section">
                                        <!-- NOMBRE -->
                                        <div class="w3-col m3 l3 s12 w3-padding">
                                            <label for='nombre'>Nombre</label>
                                            <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value="<?php echo $socio['nombre_socio'] ?>">
                                            <small id="info_nombre"></small>
                                        </div>
                                        <!-- APELLIDOS -->
                                        <div class="w3-col m3 l3 s12 w3-padding">
                                            <label for="apellidos">Apellidos</label>
                                            <input class="w3-input w3-border w3-round" name="apellidos" id="apellidos" type="text" value="<?php echo $socio['apellidos_socio'] ?>">
                                            <small id="info_apellidos"></small>
                                        </div>
                                        <!-- DNI -->
                                        <div class="w3-col l3 m3 s12 w3-padding">
                                            <label for="dni">DNI / ID</label>
                                            <input class="w3-input w3-border w3-round" name="dni" id="dni" type="text" value="<?php echo $socio['card_id_socio'] ?>">
                                            <small id="info_dni"></small>
                                        </div>
                                        <!-- NACIONALIDAD -->
                                        <div class="w3-col l3 m3 s12 w3-padding">
                                            <label for="pais">Nacionalidad</label>
                                            <!-- SELECT PAISES -->
                                            <select name="pais" id="pais" class="w3-select w3-white">
                                                <option value=<?php echo $socio['pais_id'] ?>><?php echo $socio['bandera'].' '.$socio['pais']?></option>
                                                <?php
                                                $pais = getPaises();
                                                foreach ($pais as $pais) :
                                                ?>
                                                <option value=<?php echo $pais['id_pais'] ?>><?php echo $pais['bandera'].' '.$pais['pais']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- FILA 5: ROL, CUOTA, CONSUMO MENSUAL, SALDO -->
                                    <div class="w3-row w3-section">
                                        <!-- ROL -->
                                        <div class="w3-col m3 l3 s12 w3-padding">
                                            <label for="rol">Tipo de socio</label>
                                            <select name="rol" class="w3-select w3-white">
                                                <option value="<?php echo $socio['rol_id']; ?>"><?php echo $socio ['nombre_rol'] ?></option>
                                                <?php
                                                $roles = getRoles();
                                                foreach ($roles as $rol) :
                                                ?>
                                                    <option value="<?php echo $rol['id_rol']; ?>"><?php echo $rol['nombre_rol'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small id="info_rol"></small>
                                        </div>
                                        <!-- CUOTA -->
                                        <div class="w3-col m3 l3 s12 w3-padding">
                                            <label for="cuota">Cuota</label>
                                            <select name="cuota" id="cuota" class="w3-select w3-white">
                                                <option value="0">Seleccionar</option>
                                            </select>
                                            <small id="info_cuota"></small>
                                        </div>
                                        <!-- CONSUMO MENSUAL -->
                                        <div class="w3-col m3 l3 s12 w3-padding">
                                            <label for="consumo">Consumo mes</label>
                                            <input class="w3-input w3-border w3-round" name="consumo" id="consumo" type="text" value="0" placeholder="gr/mes">
                                            <small id="info_consumo"></small>
                                        </div>
                                        <!-- SALDO -->
                                        <div class="w3-col m3 l3 s12 w3-padding">
                                            <label for="saldo">Saldo</label>
                                            <input class="w3-input w3-border w3-round" name="saldo" id="saldo" type="text" value="0.00">
                                            <small id="info_saldo" /small>
                                        </div>
                                    </div>
                                    <!-- FILA 4; IMAGENES -->
                                    <div class="w3-row">
                                        <!-- FOTO SOCIO -->
                                        <div class="w3-col m4 l4 s12 w3-padding">
                                            <label for="foto">Foto socio</label>
                                            <input class="w3-input w3-border w3-round w3-white" name="foto" id="foto" type="file" accept="image/*">
                                            <small id="info_foto"></small>
                                            <div class="w3-container">
                                                <img src="" alt="Foto socio" class="w3-image" id="putFotoSocio" />
                                            </div>
                                        </div>
                                        <!-- ID FRONTAL -->
                                        <div class="w3-col m4 l4 s12 w3-padding">
                                            <label for="idFront">DNI / ID frontal</label>
                                            <input class="w3-input w3-border w3-round w3-white" name="idFront" id="idFront" type="file" accept="image/*">
                                            <small id="idFront"></small>
                                            <div class="w3-container">
                                                <img src="" alt="DNI / ID front" class="w3-image" id="putDniFrontSocio" />
                                            </div>
                                        </div>
                                        <!-- ID TRASERA -->
                                        <div class="w3-col m4 l4 s12 w3-padding">
                                            <label for="idBack">DNI / ID trasera</label>
                                            <input class="w3-input w3-border w3-round w3-white" name="idBack" id="idBack" type="file" accept="image/*">
                                            <div class="w3-container">
                                                <img src="" alt="DNI / ID back" class="w3-image" id="putDniBackSocio" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- BOTONES DE NAVEGACIÓN -->

                                <div class="w3-row w3-padding-32 w3-center">
                                    <div class="w3-col l6 m6 s12 w3-padding-large">
                                        <a href="index.php" class="w3-btn w3-theme w3-round w3-block w3-hover-green">Volver</a>
                                    </div>    
                                    <div class="w3-col l6 m6 s12 w3-padding-large">
                                        <input type="submit" value="Guardar" name="update" class="w3-btn w3-theme w3-round w3-block w3-hover-orange">
                                    </div>
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