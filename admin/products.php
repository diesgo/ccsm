<?php
include 'templates/header.php';
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-light-grey">
    <div class="w3-half">
        <h2><b><i class="fa fa-dashboard"></i>Products</b></h2>
    </div>
    <hr>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-32">
    <a class="w3-right w3-button w3-theme-d3 w3-round-xxlarge w3-hover-theme" href="newproduct.html">+ New product</a>
</div>

<div class="w3-container w3-padding-64 w3-responsive">
    <table id="grid" class="w3-table w3-striped w3-bordered w3-centered" style="color: #555">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Coste</th>
                <th>Price</th>
                <th>Estate</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
<script src="js/products.js"></script>
<?php
include 'templates/footer.php';
?>