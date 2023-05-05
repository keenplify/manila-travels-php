<?php

require '../assets/partials/_functions.php';
$conn = db_connect();    

if (isset($_GET['id']) && isset($_GET['is_verified'])) {
    $sql = 'UPDATE passengers SET is_verified = ' . $_GET['is_verified'] . ' WHERE id = ' . $_GET['id'];

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: ../admin/passenger-validation.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}