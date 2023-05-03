<?php
    require '_functions.php';
    $conn = db_connect();

    if(!$conn)
        die("Oh Shoot!! Connection Failed");

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `administrators` WHERE username='$username';";
        $result = mysqli_query($conn, $sql);

        if($row = mysqli_fetch_assoc($result)){
            $hash = $row['password'];
            if(password_verify($password, $hash))
            {
                // Login Sucessfull
                session_start();
                $_SESSION["loggedIn"] = true;
                $_SESSION["user_id"] = $row["id"];

                header("location: ../../admin/dashboard.php");
                exit;
            }
            
            // Login failure
            $error = true;
            header("location: index.php?error=$error");
        }
    }
?>