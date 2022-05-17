                <?php
                    $titulo = "Nuevo socio";
                    include '../templates/header.php';

                    if (isset($_POST['create'])) {  
                        $nombre = $_POST['nombre_socio'];
                        $apellidos = $_POST['apellidos'];
                        $dni = $_POST['dni'];
                        $birth = $_POST['birth'];
                        $pais = $_POST['pais'];
                        $genero = $_POST['genero'];
                        $consumo = $_POST['consumo'];
                        $saldo = $_POST['saldo'];
                        $rol = $_POST['rol'];
                        
                        // Create connection
                        
                        $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                        
                        // Check connection
                        
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "INSERT INTO socios (nombre_socio, apellidos_socio, card_id_socio, birth, pais_id, genero_id, consumo, saldo, rol_id) VALUES ('$nombre', '$apellidos', '$dni', '$birth', '$pais', '$genero', '$consumo', '$saldo', '$rol')";
                        
                        if ($conn->query($sql) === TRUE) {
                            echo "<h3 class='w3-text-green w3-animate-zoom'><i class='w3-xlarge fas fa-check'></i> Se ha creado un nuevo registro</h3>";
                            echo "<script>location.replace('index.php');</script>";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                        
                        $conn->close();
                    }
                ?>

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-content">
                    <h2 id="title" class="w3-center w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>

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
                                            <select name="genero" id="genero" class="w3-select w3-white" required>
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
                                            <input class="w3-input w3-border w3-round" type="date" id="birth" name="birth" required>
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
                                            <label for='nombre_socio'>Nombre</label>
                                            <input class='w3-input w3-border w3-round' name='nombre_socio' id='nombre_socio' type='text' pattern=[A-Z\sa-z]{2,20} placeholder='Nombre / Name' required>
                                            <small id="info_nombre"></small>
                                        </div>
                                        <!-- APELLIDOS -->
                                        <div class="w3-col m3 l3 s12 w3-padding">
                                            <label for="apellidos">Apellidos</label>
                                            <input class="w3-input w3-border w3-round" name="apellidos" id="apellidos" type="text" pattern=[A-Z\sa-z]{2,20} placeholder="Apellido / Surname">
                                            <small id="info_apellidos"></small>
                                        </div>
                                        <!-- DNI -->
                                        <div class="w3-col l3 m3 s12 w3-padding">
                                            <label for="dni">DNI / ID</label>
                                            <input class="w3-input w3-border w3-round" name="dni" id="dni" type="text" placeholder="DNI - NIE">
                                            <small id="info_dni"></small>
                                        </div>
                                        <!-- NACIONALIDAD -->
                                        <div class="w3-col l3 m3 s12 w3-padding">
                                            <label for="pais">Nacionalidad</label>
                                            <!-- SELECT PAISES -->
                                            <select name="pais" id="pais" class="w3-select w3-white" required>
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
                                            <select name="rol" class="w3-select w3-white" requiredd>
                                                <?php
                                                $roles = getRoles();
                                                foreach ($roles as $rol) :
                                                ?>
                                                    <option value=<?php echo $rol['id_rol']; ?>><?php echo $rol['nombre_rol'] ?></option>
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
                                        <input type="submit" value="Guardar" name="create" class="w3-btn w3-theme w3-round w3-block w3-hover-orange">
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