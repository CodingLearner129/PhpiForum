<?php
    $showError = "false";
    $showAlert = false;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include "_dbconnect.php";
        $userName = $_POST['signupName'];
        $userEmail = $_POST['signupEmail'];
        $pass = $_POST['signupPassword'];
        $cpass = $_POST['signupcPassword'];

        // Check whether this username exists
        $existSqlUser = "SELECT * FROM `users` WHERE `user_name`='$userName'";
        $resultUser = mysqli_query($conn, $existSqlUser);
        $numRowsUser = mysqli_num_rows($resultUser);
        // Check whether this email exists
        $existSql = "SELECT * FROM `users` WHERE `user_email`='$userEmail'";
        $result = mysqli_query($conn, $existSql);
        $numRows = mysqli_num_rows($result);
        
        if($numRowsUser > 0){
            $showError = "Username already exist";
        }
        elseif($numRows > 0){
            $showError = "Email already exist";
        }
        else{
            if($pass == $cpass){
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users`(`user_name`, `user_email`, `user_pass`, `timestamp`) VALUES('$userName', '$userEmail', '$hash', current_timestamp())";
                $result = mysqli_query($conn, $sql);
                if($result){
                    $showAlert = true;
                    header("Location: ../index.php?signupSuccess=true&alert=$showAlert");
                    exit();
                }
            }
            else{
                $showError = "Pasword do not match";
            }
        }
        $showAlert = true;
        header("Location: ../index.php?signupSuccess=false&error=$showError&alert=$showAlert");
    }
?>