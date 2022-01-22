<?php
    $showError = "false";
    $showAlert = false;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include "_dbconnect.php";
        $userName = $_POST['loginName'];
        $pass = $_POST['loginPassword'];

        $sql = "SELECT * FROM `users` WHERE `user_name`='$userName'";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);
        if($numRows == 1){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($pass, $row['user_pass'])){
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $row['user_name'];
                $_SESSION['userid'] = $row['sno'];
                $showAlert = true;
                header("Location: ../index.php?loginSuccess=true&loginAlert=$showAlert");
                exit();
            }
            else{
                $showError = "Please, enter right password";
            }
        }
        else{
            $showError = "Email not found; you have to signin first";
        }
        $showAlert = true;
        header("Location: ../index.php?loginSuccess=false&loginError=$showError&loginAlert=$showAlert");
    }
?>