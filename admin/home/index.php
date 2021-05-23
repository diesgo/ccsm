<?php
$titulo = "CCSM | Administración";
include '../templates/header.php';
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fa fa-dashboard"></i>Administración</b></h2>
    </div>
    <div class="w3-half">
        <!-- <a class="w3-right w3-button w3-theme w3-border w3-border-theme w3-round w3-hover-white w3-hover-text-theme" href="nuevoSocio.php">+ New socios</a> -->
    </div>
    <hr>
</div>
<div class="w3-container w3-padding-64 w3-responsive" style="min-height: 636px;">
    <!-- Header -->
    <header class="w3-container" style="padding-top:22px">
        <h5 class="w3-text-theme"><b><i class="fas fa-tachometer-alt"></i> Panel de control</b></h5>
    </header>

    <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-quarter">
            <div class="w3-container w3-theme w3-text-white w3-padding-16">
                <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <?php
                    require '../../config/conexion.php';
                    $sql = "SELECT id FROM socios";
                    $socios = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($socios) > 0) {
                        echo "<h3>" . mysqli_num_rows($socios) . "</h3>";
                    } else {
                        echo "0 results";
                    }
                    ?>
                </div>
                <div class="w3-clear"></div>
                <h4>SOCIOS</h4>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-container w3-theme-dark w3-padding-16">
                <div class="w3-left"><i class="fas fa-boxes w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <?php
                    $sql = "SELECT id FROM productos";
                    $productos = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($productos) > 0) {
                        // output data of each row
                            echo "<h3>" . mysqli_num_rows($productos) . "</h3>";
                    } else {
                        echo "0 results";
                    }
                    mysqli_close($conn);
                    ?>
                </div>
                <div class="w3-clear"></div>
                <h4>PRODUCTOS</h4>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-container w3-blue w3-padding-16">
                <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3>99</h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Views</h4>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-container w3-teal w3-padding-16">
                <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3>23</h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Shares</h4>
            </div>
        </div>

    </div>

    <div class="w3-panel">
        <div class="w3-row-padding" style="margin:0 -16px">
            <div class="w3-third">
                <h5>Regions</h5>
                <img src="../../img/ccms_logo_verde.png" style="width:100%" alt="Google Regional Map">
            </div>
            <div class="w3-twothird">
                <h5>Feeds</h5>
                <table class="w3-table w3-striped w3-white">
                    <tr>
                        <td><i class="fa fa-user w3-text-blue w3-large"></i></td>
                        <td>New record, over 90 views.</td>
                        <td><i>10 mins</i></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-bell w3-text-red w3-large"></i></td>
                        <td>Database error.</td>
                        <td><i>15 mins</i></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-users w3-text-yellow w3-large"></i></td>
                        <td>New record, over 40 users.</td>
                        <td><i>17 mins</i></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-comment w3-text-red w3-large"></i></td>
                        <td>New comments.</td>
                        <td><i>25 mins</i></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-bookmark w3-text-blue w3-large"></i></td>
                        <td>Check transactions.</td>
                        <td><i>28 mins</i></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-laptop w3-text-red w3-large"></i></td>
                        <td>CPU overload.</td>
                        <td><i>35 mins</i></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-share-alt w3-text-green w3-large"></i></td>
                        <td>New shares.</td>
                        <td><i>39 mins</i></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="w3-container">
        <h5>General Stats</h5>
        <p>New Visitors</p>
        <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-green" style="width:25%">+25%</div>
        </div>

        <p>New Users</p>
        <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-orange" style="width:50%">50%</div>
        </div>

        <p>Bounce Rate</p>
        <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-red" style="width:75%">75%</div>
        </div>
    </div>
    <hr>

    <div class="w3-container">
        <h5>Countries</h5>
        <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
            <tr>
                <td>United States</td>
                <td>65%</td>
            </tr>
            <tr>
                <td>UK</td>
                <td>15.7%</td>
            </tr>
            <tr>
                <td>Russia</td>
                <td>5.6%</td>
            </tr>
            <tr>
                <td>Spain</td>
                <td>2.1%</td>
            </tr>
            <tr>
                <td>India</td>
                <td>1.9%</td>
            </tr>
            <tr>
                <td>France</td>
                <td>1.5%</td>
            </tr>
        </table><br>
        <button class="w3-button w3-dark-grey">More Countries <i class="fa fa-arrow-right"></i></button>
    </div>
    <hr>
    <div class="w3-container">
        <h5>Recent Users</h5>
        <ul class="w3-ul w3-card-4 w3-white">
            <li class="w3-padding-16">
                <img src="../../img/s/3.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
                <span class="w3-xlarge">Mike</span><br>
            </li>
            <li class="w3-padding-16">
                <img src="../../img/s/4.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
                <span class="w3-xlarge">Jill</span><br>
            </li>
            <li class="w3-padding-16">
                <img src="../../img/s/5.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
                <span class="w3-xlarge">Jane</span><br>
            </li>
        </ul>
    </div>
    <hr>

    <div class="w3-container">
        <h5>Recent Comments</h5>
        <div class="w3-row">
            <div class="w3-col m2 text-center">
                <img class="w3-circle" src="../../img/s/2.png" style="width:96px;height:96px">
            </div>
            <div class="w3-col m10 w3-container">
                <h4>John <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
                <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
            </div>
        </div>

        <div class="w3-row">
            <div class="w3-col m2 text-center">
                <img class="w3-circle" src="../../img/s/0.png" style="width:96px;height:96px">
            </div>
            <div class="w3-col m10 w3-container">
                <h4>Bo <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
                <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
            </div>
        </div>
    </div>
    <br>
    <div class="w3-container w3-dark-grey w3-padding-32">
        <div class="w3-row">
            <div class="w3-container w3-third">
                <h5 class="w3-bottombar w3-border-green">Demographic</h5>
                <p>Language</p>
                <p>Country</p>
                <p>City</p>
            </div>
            <div class="w3-container w3-third">
                <h5 class="w3-bottombar w3-border-red">System</h5>
                <p>Browser</p>
                <p>OS</p>
                <p>More</p>
            </div>
            <div class="w3-container w3-third">
                <h5 class="w3-bottombar w3-border-orange">Target</h5>
                <p>Users</p>
                <p>Active</p>
                <p>Geo</p>
                <p>Interests</p>
            </div>
        </div>
    </div>

</div>

<?php
include '../templates/footer.php';
?>