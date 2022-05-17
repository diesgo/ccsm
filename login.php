<?php
 
include('config2.php');
session_start();
 
if (isset($_POST['login'])) {
 
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    $query = $connection->prepare("SELECT * FROM users WHERE username = :username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->execute();
 
    $result = $query->fetch(PDO::FETCH_ASSOC);
 
    if (!$result) {
        echo '<p class="error">Username password combination is wrong!</p>';
    } else {
        if (password_verify($password, $result['password'])) {
            $_SESSION['user_id'] = $result['id_user'];
            $_SESSION['username'] = $result['username'];
            echo '<p class="success">Congratulations, you are logged in!</p>';
            echo "<script>location.replace('select.php');</script>";
        } else {
            echo '<p class="error">Username password combination is wrong!</p>';
        }
    }
}
?>
