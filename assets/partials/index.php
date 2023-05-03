<?php

$error = $_GET["error"];

if (isset($error)) {
    switch($error) {
        case '1': 
            echo "<script>alert('Your credentials is incorrect'); window.location.href = '../../'</script>";
            break;
        default: 
            echo "<script>alert('Your credentials is incorrect'); window.location.href = '../../'</script>";
            break;
    }
}