<html lang="en">
<head>
    <link rel="stylesheet" href="../view/style.css">
</head>
<body>
    <?php
        require_once '../model/connection.php';
        // verification nick to email
        // when user enter error withhold information
        // use session

        if(isset($_POST['signUp'])){

            $userName = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
            $userEmail = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);  
            $userPassword = $_POST["password"];

            $errors = [];
            if(!checkDuplicateEmail($userEmail, $db)){
                $errors[] = "Email already exists. Please choose another one.";
            }

            if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                $errors[] = "Invalid email format!";
            }

            checkPassword($userPassword, $errors);

            if (!empty($userName) && !empty($userEmail) && !empty($userPassword) && empty($errors)){

                $hashPassword = password_hash($userPassword, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (username, email, password) VALUES (:name, :email, :password)";
                $query = $db->prepare($sql);
                $query->execute(array(':name' => $userName, ':email' => $userEmail, ':password' => $hashPassword));

                echo "<div class='message'>
                        <p>Registration successfully!</p>
                    </div> <br>";
                echo "<a href='../index.php'><button class ='btn'>Login Now</button></a>";

                exit();
            }else{
                echo "<div class = 'message'>
                        <p>";
                            foreach($errors as $error){
                            echo $error . '<br>'; } 
                echo "</p>
                    </div>";
                echo "<a href='../index.php'><button class='btn'>Login Now</button>";
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


