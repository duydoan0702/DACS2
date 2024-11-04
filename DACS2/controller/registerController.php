<?php
    session_start();
    require_once '../model/connection.php';
    require_once 'sendController.php';
?>
<html lang="en">
<head>
    <link rel="stylesheet" href="../view/css/errorMessage.css">
</head>
<body>
    <?php

        if(isset($_POST['signUp'])){

            $userName = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
            $userEmail = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);  
            $userPassword = $_POST["password"];

            $errors = [];
            if(!checkDuplicateEmail($userEmail, $db)){
                $errors[] = "Email already exists. Please choose another one.";
            }

            if(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
                $errors[] = "Invalid email format!";    
            }

            checkPassword($userPassword, $errors);

            if (!empty($userName) && !empty($userEmail) && !empty($userPassword) && empty($errors)){

                $hashPassword = password_hash($userPassword, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (username, email, password) VALUES (:name, :email, :password)";
                $query = $db->prepare($sql);
                $query->execute(array(':name' => $userName, ':email' => $userEmail, ':password' => $hashPassword));

                $_SESSION['verification_code'] = rand(1000,9999);
                $_SESSION['verification_code_expiry'] = time() + 60;
                
                if (sendVerification($_SESSION['verification_code'], $userEmail)) {
                    header('Location: ../view/html/sendOTP.html');
                    exit();
                }
                
            }else{
                echo "<div class = 'message'>
                        <p>";
                            foreach($errors as $error){
                            echo $error . '<br>'; }
                            echo "<button onclick='history.back()' class='btn'>Go Back</button>";
                echo "</p>
                    </div>";
                
            }
        }

        function checkDuplicateEmail($userEmail, $db){
            $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $userEmail);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result == 0;
        }

        function checkPassword($userPassword, &$errors){
            $errors_init = $errors;
            if(strlen($userPassword) < 8){
                $errors[] = "Password too short!";
            }
            if(!preg_match("#[0-9]+#", $userPassword)){
                $errors[] = "Password must include at least one number!";
            }
            if(!preg_match("#[a-zA-Z]+#", $userPassword)){
                $errors[] = "Password must include at least one letter!";
            }
            return ($errors == $errors_init);
        }
        
    ?>
</body>
</html>


