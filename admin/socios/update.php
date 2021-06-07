<?php
$titulo = "Editar categorias | CCSM";
include '../templates/header.php';
?>
<?php
// require '../../config/functions.php';
$socios = getSociosById($_GET['id']);
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fas fa-edit"></i> Editar socio</b></h2>
    </div>
    <div class="w3-half">
        <?php
        require "../../config/conexion.php";

        if (isset($_POST['actualizar'])) {
            $id = $socios['id'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $dni = $_POST['dni'];
            $birth = $_POST['birth'];
            $pais = $_POST['pais'];
            $genero = $_POST['genero'];
            $consumo = $_POST['consumo'];
            $rol = $_POST['rol'];
            $saldo = $_POST['saldo'];

            $sql = "UPDATE socios SET nombre ='" . $nombre . "', apellidos='" . $apellidos . "', dni='" . $dni . "', birth='" . $birth . "', pais='" . $pais . "', rol='" . $rol . "', genero='" . $genero . "', consumo='" . $consumo . "',  saldo='" . $saldo . "' WHERE id=" . $id . ";";
            echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";

            mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
        } else {
            if (!isset($_POST['id'])) {
                $sql = "SELECT min(id) FROM socios";
                $result = mysqli_query($conex, $sql);
                $row = mysqli_fetch_assoc($result);
                $id = $row['min(id)'];
            } else {
                $id = $_POST["id"];
            }
            $sql = "SELECT * FROM socios WHERE id='$id'";
            $result = mysqli_query($conex, $sql);
            $row = mysqli_fetch_assoc($result);
            $nombre = $row['nombre'];
            $apellidos = $row['apellidos'];
            $dni = $row['dni'];
            $birth = $row['birth'];
            $pais = $row['pais'];
            $genero = $row['genero'];
            $consumo = $row['consumo'];
            $rol = $row['rol'];
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
                        <h1><span class="w3-text-theme"># <?php echo $socios['id'] ?></span> <?php echo $socios['nombre'] ?> <?php echo $socios['apellidos'] ?></h1>
                    </div>
                    <div class="w3-row w3-section">
                        <div class="w3-col m12 l12 w3-padding">
                            <label for="genero" class="w3-text-theme">Tratamiento:</label>
                            <select name="genero" id="genero">
                                <option value=<?php echo $socios['genero'] ?>><?php echo $socios['genero'] ?></option>
                                <option value="Hombre">Hombre</option>
                                <option value="Mujer">Mujer</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>

                    <!-- FILA 2: NOMBRE Y APELLIDO -->
                    <div class="w3-row">
                        <!-- NOMBRE -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="nombre" class="w3-text-theme">Nombre</label><br>
                            <input class="w3-input w3-border w3-round" name="nombre" id="nombre" type="text" value="<?php echo $socios['nombre'] ?>">
                            <small id="info_nombre"></small>
                        </div>
                        <!-- APELLIDOS -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="apellidos" class="w3-text-theme">Apellidos</label>
                            <input class="w3-input w3-border w3-round" name="apellidos" id="apellidos" type="text" value="<?php echo $socios['apellidos'] ?>">
                            <small id="info_apellidos"></small>
                        </div>
                    </div>

                    <!-- FILA 3: BIRTH, DNI, PAIS -->
                    <div class="w3-row">

                        <!-- FECHA DE NACIMIENTO -->
                        <div class="w3-col m4 l4 s12 w3-padding nativeDatePicker">
                            <label for="birth" class="w3-text-theme">Fecha de nacimiento:</label>
                            <input class="w3-input w3-border w3-round" type="date" id="birth" name="birth" value=<?php echo $socios['birth'] ?>>
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
                            <input class="w3-input w3-border w3-round" name="dni" id="dni" type="text" value=<?php echo $socios['dni']; ?>>
                            <small id="info_dni"></small>
                        </div>

                        <!-- NACIONALIDAD -->
                        <div class="w3-col l4 m4 s12 w3-padding">
                            <label for="pais" class="w3-text-theme">Nacionalidad</label>
                            <!-- SELECT PAISES -->
                            <select name="pais" id="pais" class="w3-select w3-white">
                                <option value=<?php echo $socios['pais'] ?>><?php echo $socios['pais'] ?></option>
                                <?php
                                require_once '../../config/functions.php';
                                $pais = getPaises();
                                foreach ($pais as $pais) :
                                ?>
                                    <option value=<?php echo $pais['bandera'] ?>><?php echo $pais['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- <select name="pais" class="w3-select w3-border w3-round w3-white">
                                <option value=<?php echo $socios['pais'] ?>><?php echo $socios['pais'] ?></option>
                                <option value="Afganistán" id="AF">Afganistán</option>
                                <option value="Albania" id="AL">Albania</option>
                                <option value="Alemania" id="DE">Alemania</option>
                                <option value="Andorra" id="AD">Andorra</option>
                                <option value="Angola" id="AO">Angola</option>
                                <option value="Anguila" id="AI">Anguila</option>
                                <option value="Antártida" id="AQ">Antártida</option>
                                <option value="Antigua y Barbuda" id="AG">Antigua y Barbuda</option>
                                <option value="Antillas holandesas" id="AN">Antillas holandesas</option>
                                <option value="Arabia Saudí" id="SA">Arabia Saudí</option>
                                <option value="Argelia" id="DZ">Argelia</option>
                                <option value="Argentina" id="AR">Argentina</option>
                                <option value="Armenia" id="AM">Armenia</option>
                                <option value="Aruba" id="AW">Aruba</option>
                                <option value="Australia" id="AU">Australia</option>
                                <option value="Austria" id="AT">Austria</option>
                                <option value="Azerbaiyán" id="AZ">Azerbaiyán</option>
                                <option value="Bahamas" id="BS">Bahamas</option>
                                <option value="Bahrein" id="BH">Bahrein</option>
                                <option value="Bangladesh" id="BD">Bangladesh</option>
                                <option value="Barbados" id="BB">Barbados</option>
                                <option value="Bélgica" id="BE">Bélgica</option>
                                <option value="Belice" id="BZ">Belice</option>
                                <option value="Benín" id="BJ">Benín</option>
                                <option value="Bermudas" id="BM">Bermudas</option>
                                <option value="Bhután" id="BT">Bhután</option>
                                <option value="Bielorrusia" id="BY">Bielorrusia</option>
                                <option value="Birmania" id="MM">Birmania</option>
                                <option value="Bolivia" id="BO">Bolivia</option>
                                <option value="Bosnia y Herzegovina" id="BA">Bosnia y Herzegovina</option>
                                <option value="Botsuana" id="BW">Botsuana</option>
                                <option value="Brasil" id="BR">Brasil</option>
                                <option value="Brunei" id="BN">Brunei</option>
                                <option value="Bulgaria" id="BG">Bulgaria</option>
                                <option value="Burkina Faso" id="BF">Burkina Faso</option>
                                <option value="Burundi" id="BI">Burundi</option>
                                <option value="Cabo Verde" id="CV">Cabo Verde</option>
                                <option value="Camboya" id="KH">Camboya</option>
                                <option value="Camerún" id="CM">Camerún</option>
                                <option value="Canadá" id="CA">Canadá</option>
                                <option value="Chad" id="TD">Chad</option>
                                <option value="Chile" id="CL">Chile</option>
                                <option value="China" id="CN">China</option>
                                <option value="Chipre" id="CY">Chipre</option>
                                <option value="Ciudad estado del Vaticano" id="VA">Ciudad estado del Vaticano</option>
                                <option value="Colombia" id="CO">Colombia</option>
                                <option value="Comores" id="KM">Comores</option>
                                <option value="Congo" id="CG">Congo</option>
                                <option value="Corea" id="KR">Corea</option>
                                <option value="Corea del Norte" id="KP">Corea del Norte</option>
                                <option value="Costa del Marfíl" id="CI">Costa del Marfíl</option>
                                <option value="Costa Rica" id="CR">Costa Rica</option>
                                <option value="Croacia" id="HR">Croacia</option>
                                <option value="Cuba" id="CU">Cuba</option>
                                <option value="Dinamarca" id="DK">Dinamarca</option>
                                <option value="Djibouri" id="DJ">Djibouri</option>
                                <option value="Dominica" id="DM">Dominica</option>
                                <option value="Ecuador" id="EC">Ecuador</option>
                                <option value="Egipto" id="EG">Egipto</option>
                                <option value="El Salvador" id="SV">El Salvador</option>
                                <option value="Emiratos Arabes Unidos" id="AE">Emiratos Arabes Unidos</option>
                                <option value="Eritrea" id="ER">Eritrea</option>
                                <option value="Eslovaquia" id="SK">Eslovaquia</option>
                                <option value="Eslovenia" id="SI">Eslovenia</option>
                                <option value="España" id="ES">España</option>
                                <option value="Estados Unidos" id="US">Estados Unidos</option>
                                <option value="Estonia" id="EE">Estonia</option>
                                <option value="c" id="ET">Etiopía</option>
                                <option value="Ex-República Yugoslava de Macedonia" id="MK">Ex-República Yugoslava de Macedonia</option>
                                <option value="Filipinas" id="PH">Filipinas</option>
                                <option value="Finlandia" id="FI">Finlandia</option>
                                <option value="Francia" id="FR">Francia</option>
                                <option value="Gabón" id="GA">Gabón</option>
                                <option value="Gambia" id="GM">Gambia</option>
                                <option value="Georgia" id="GE">Georgia</option>
                                <option value="Georgia del Sur y las islas Sandwich del Sur" id="GS">Georgia del Sur y las islas Sandwich del Sur</option>
                                <option value="Ghana" id="GH">Ghana</option>
                                <option value="Gibraltar" id="GI">Gibraltar</option>
                                <option value="Granada" id="GD">Granada</option>
                                <option value="Grecia" id="GR">Grecia</option>
                                <option value="Groenlandia" id="GL">Groenlandia</option>
                                <option value="Guadalupe" id="GP">Guadalupe</option>
                                <option value="Guam" id="GU">Guam</option>
                                <option value="Guatemala" id="GT">Guatemala</option>
                                <option value="Guayana" id="GY">Guayana</option>
                                <option value="Guayana francesa" id="GF">Guayana francesa</option>
                                <option value="Guinea" id="GN">Guinea</option>
                                <option value="Guinea Ecuatorial" id="GQ">Guinea Ecuatorial</option>
                                <option value="Guinea-Bissau" id="GW">Guinea-Bissau</option>
                                <option value="Haití" id="HT">Haití</option>
                                <option value="Holanda" id="NL">Holanda</option>
                                <option value="Honduras" id="HN">Honduras</option>
                                <option value="Hong Kong R. A. E" id="HK">Hong Kong R. A. E</option>
                                <option value="Hungría" id="HU">Hungría</option>
                                <option value="India" id="IN">India</option>
                                <option value="Indonesia" id="ID">Indonesia</option>
                                <option value="Irak" id="IQ">Irak</option>
                                <option value="Irán" id="IR">Irán</option>
                                <option value="Irlanda" id="IE">Irlanda</option>
                                <option value="Isla Bouvet" id="BV">Isla Bouvet</option>
                                <option value="Isla Christmas" id="CX">Isla Christmas</option>
                                <option value="Isla Heard e Islas McDonald" id="HM">Isla Heard e Islas McDonald</option>
                                <option value="Islandia" id="IS">Islandia</option>
                                <option value="Islas Caimán" id="KY">Islas Caimán</option>
                                <option value="Islas Cook" id="CK">Islas Cook</option>
                                <option value="Islas de Cocos o Keeling" id="CC">Islas de Cocos o Keeling</option>
                                <option value="Islas Faroe" id="FO">Islas Faroe</option>
                                <option value="Islas Fiyi" id="FJ">Islas Fiyi</option>
                                <option value="Islas Malvinas Islas Falkland" id="FK">Islas Malvinas Islas Falkland</option>
                                <option value="Islas Marianas del norte" id="MP">Islas Marianas del norte</option>
                                <option value="Islas Marshall" id="MH">Islas Marshall</option>
                                <option value="Islas menores de Estados Unidos" id="UM">Islas menores de Estados Unidos</option>
                                <option value="Islas Palau" id="PW">Islas Palau</option>
                                <option value="Islas Salomón" d="SB">Islas Salomón</option>
                                <option value="Islas Tokelau" id="TK">Islas Tokelau</option>
                                <option value="Islas Turks y Caicos" id="TC">Islas Turks y Caicos</option>
                                <option value="Islas Vírgenes EE.UU." id="VI">Islas Vírgenes EE.UU.</option>
                                <option value="Islas Vírgenes Reino Unido" id="VG">Islas Vírgenes Reino Unido</option>
                                <option value="Israel" id="IL">Israel</option>
                                <option value="Italia" id="IT">Italia</option>
                                <option value="Jamaica" id="JM">Jamaica</option>
                                <option value="Japón" id="JP">Japón</option>
                                <option value="Jordania" id="JO">Jordania</option>
                                <option value="Kazajistán" id="KZ">Kazajistán</option>
                                <option value="Kenia" id="KE">Kenia</option>
                                <option value="Kirguizistán" id="KG">Kirguizistán</option>
                                <option value="Kiribati" id="KI">Kiribati</option>
                                <option value="Kuwait" id="KW">Kuwait</option>
                                <option value="Laos" id="LA">Laos</option>
                                <option value="Lesoto" id="LS">Lesoto</option>
                                <option value="Letonia" id="LV">Letonia</option>
                                <option value="Líbano" id="LB">Líbano</option>
                                <option value="Liberia" id="LR">Liberia</option>
                                <option value="Libia" id="LY">Libia</option>
                                <option value="Liechtenstein" id="LI">Liechtenstein</option>
                                <option value="Lituania" id="LT">Lituania</option>
                                <option value="Luxemburgo" id="LU">Luxemburgo</option>
                                <option value="Macao R. A. E" id="MO">Macao R. A. E</option>
                                <option value="Madagascar" id="MG">Madagascar</option>
                                <option value="Malasia" id="MY">Malasia</option>
                                <option value="Malawi" id="MW">Malawi</option>
                                <option value="Maldivas" id="MV">Maldivas</option>
                                <option value="Malí" id="ML">Malí</option>
                                <option value="Malta" id="MT">Malta</option>
                                <option value="Marruecos" id="MA">Marruecos</option>
                                <option value="Martinica" id="MQ">Martinica</option>
                                <option value="Mauricio" id="MU">Mauricio</option>
                                <option value="Mauritania" id="MR">Mauritania</option>
                                <option value="Mayotte" id="YT">Mayotte</option>
                                <option value="México" id="MX">México</option>
                                <option value="Micronesia" id="FM">Micronesia</option>
                                <option value="Moldavia" id="MD">Moldavia</option>
                                <option value="Mónaco" id="MC">Mónaco</option>
                                <option value="Mongolia" id="MN">Mongolia</option>
                                <option value="Montserrat" id="MS">Montserrat</option>
                                <option value="Mozambique" id="MZ">Mozambique</option>
                                <option value="Namibia" id="NA">Namibia</option>
                                <option value="Nauru" id="NR">Nauru</option>
                                <option value="Nepal" id="NP">Nepal</option>
                                <option value="Nicaragua" id="NI">Nicaragua</option>
                                <option value="Níger" id="NE">Níger</option>
                                <option value="Nigeria" id="NG">Nigeria</option>
                                <option value="Niue" id="NU">Niue</option>
                                <option value="Norfolk" id="NF">Norfolk</option>
                                <option value="Noruega" id="NO">Noruega</option>
                                <option value="Nueva Caledonia" id="NC">Nueva Caledonia</option>
                                <option value="Nueva Zelanda" id="NZ">Nueva Zelanda</option>
                                <option value="Omán" id="OM">Omán</option>
                                <option value="Panamá" id="PA">Panamá</option>
                                <option value="Papua Nueva Guinea" id="PG">Papua Nueva Guinea</option>
                                <option value="Paquistán" id="PK">Paquistán</option>
                                <option value="Paraguay" id="PY">Paraguay</option>
                                <option value="Perú" id="PE">Perú</option>
                                <option value="Pitcairn" id="PN">Pitcairn</option>
                                <option value="Polinesia francesa" id="PF">Polinesia francesa</option>
                                <option value="Polonia" id="PL">Polonia</option>
                                <option value="Portugal" id="PT">Portugal</option>
                                <option value="Puerto Rico" id="PR">Puerto Rico</option>
                                <option value="Qatar" id="QA">Qatar</option>
                                <option value="Reino Unido" id="UK">Reino Unido</option>
                                <option value="República Centroafricana" id="CF">República Centroafricana</option>
                                <option value="República Checa" id="CZ">República Checa</option>
                                <option value="República de Sudáfrica" id="ZA">República de Sudáfrica</option>
                                <option value="República Democrática del Congo Zaire" id="CD">República Democrática del Congo Zaire</option>
                                <option value="República Dominicana" id="DO">República Dominicana</option>
                                <option value="Reunión" id="RE">Reunión</option>
                                <option value="Ruanda" id="RW">Ruanda</option>
                                <option value="Rumania" id="RO">Rumania</option>
                                <option value="Rusia" id="RU">Rusia</option>
                                <option value="Samoa" id="WS">Samoa</option>
                                <option value="Samoa occidental" id="AS">Samoa occidental</option>
                                <option value="San Kitts y Nevis" id="KN">San Kitts y Nevis</option>
                                <option value="San Marino" id="SM">San Marino</option>
                                <option value="San Pierre y Miquelon" id="PM">San Pierre y Miquelon</option>
                                <option value="San Vicente e Islas Granadinas" id="VC">San Vicente e Islas Granadinas</option>
                                <option value="Santa Helena" id="SH">Santa Helena</option>
                                <option value="Santa Lucía" id="LC">Santa Lucía</option>
                                <option value="Santo Tomé y Príncipe" id="ST">Santo Tomé y Príncipe</option>
                                <option value="Senegal" id="SN">Senegal</option>
                                <option value="Serbia y Montenegro" id="YU">Serbia y Montenegro</option>
                                <option value="Sychelles" id="SC">Seychelles</option>
                                <option value="Sierra Leona" id="SL">Sierra Leona</option>
                                <option value="Singapur" id="SG">Singapur</option>
                                <option value="Siria" id="SY">Siria</option>
                                <option value="Somalia" id="SO">Somalia</option>
                                <option value="Sri Lanka" id="LK">Sri Lanka</option>
                                <option value="Suazilandia" id="SZ">Suazilandia</option>
                                <option value="Sudán" id="SD">Sudán</option>
                                <option value="Suecia" id="SE">Suecia</option>
                                <option value="Suiza" id="CH">Suiza</option>
                                <option value="Surinam" id="SR">Surinam</option>
                                <option value="Svalbard" id="SJ">Svalbard</option>
                                <option value="Tailandia" id="TH">Tailandia</option>
                                <option value="Taiwán" id="TW">Taiwán</option>
                                <option value="Tanzania" id="TZ">Tanzania</option>
                                <option value="Tayikistán" id="TJ">Tayikistán</option>
                                <option value="Territorios británicos del océano Indico" id="IO">Territorios británicos del océano Indico</option>
                                <option value="Territorios franceses del sur" id="TF">Territorios franceses del sur</option>
                                <option value="Timor Oriental" id="TP">Timor Oriental</option>
                                <option value="Togo" id="TG">Togo</option>
                                <option value="Tonga" id="TO">Tonga</option>
                                <option value="Trinidad y Tobago" id="TT">Trinidad y Tobago</option>
                                <option value="Túnez" id="TN">Túnez</option>
                                <option value="Turkmenistán" id="TM">Turkmenistán</option>
                                <option value="Turquía" id="TR">Turquía</option>
                                <option value="Tuvalu" id="TV">Tuvalu</option>
                                <option value="Ucrania" id="UA">Ucrania</option>
                                <option value="Uganda" id="UG">Uganda</option>
                                <option value="Uruguay" id="UY">Uruguay</option>
                                <option value="Uzbekistán" id="UZ">Uzbekistán</option>
                                <option value="Vanuatu" id="VU">Vanuatu</option>
                                <option value="Venezuela" id="VE">Venezuela</option>
                                <option value="Vietnam" id="VN">Vietnam</option>
                                <option value="Wallis y Futuna" id="WF">Wallis y Futuna</option>
                                <option value="Yemen" id="YE">Yemen</option>
                                <option value="Zambia" id="ZM">Zambia</option>
                                <option value="Zimbabue" id="ZW">Zimbabue</option>
                            </select> -->
                        </div>
                    </div>

                    <!-- FILA 4 -->
                    <div class="w3-row">

                        <!-- ROL -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="rol" class="w3-text-theme">Tipo de socio</label>
                            <select name="rol" id="rol" class="w3-select w3-white" value=<?php echo $socios['rol']; ?>>
                                <option value=<?php echo $socios['rol'] ?>><?php echo $socios['rol'] ?></option>
                                <?php
                                require_once '../../config/functions.php';
                                $roles = getRoles();
                                foreach ($roles as $rol) :
                                ?>
                                    <option value=<?php echo $rol['nombre'] ?>><?php echo $rol['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="info_rol"></small>
                        </div>

                        <!-- CUOTA -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="cuota" class="w3-text-theme">Cuota</label>
                            <select name="cuota" id="cuota" class="w3-select w3-white">
                                <option value="">Seleccionar</option>
                            </select>
                            <small id="info_cuota"></small>
                        </div>

                        <!-- CONSUMO MENSUAL -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="consumo" class="w3-text-theme">Consumo mes</label>
                            <input class="w3-input w3-border w3-round" name="consumo" id="consumo" type="text" value=<?php echo $socios['consumo'] ?>>
                            <small id="info_consumo"></small>
                        </div>

                        <!-- SALDO -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="saldo" class="w3-text-theme">Saldo</label>
                            <input class="w3-input w3-border w3-round" name="saldo" id="saldo" type="text" value=<?php echo $socios['saldo'] ?>>
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