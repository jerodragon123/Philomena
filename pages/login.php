<div class="content">
    <form name="login" method="POST" enctype="multipart/form-data" action=" ">
        <p id="page_title">Inloggen</p>
        <input required type="email" name="e-mail" placeholder="bij@voorbeeld.com"/>
        <input required type="pasword" name="wachtwoord" placeholder="wachtwoord"/>
        <div class="icon_container">
            <input type="submit" class="icon" id="submit" name="submit" value="&rarr;"/>
        </div>
        <a href="register.php">Registreren</a><br>
        <a href="forgot_password.php">Wachtwoord vergeten</a>
    </form>
    </div>
    <?php
    if(isset($_POST["submit"])) {
        $alert = "";
        $email = htmlspecialchars($_POST["e-mail"]);
        $password = htmlspecialchars($_POST["wachtwoord"]);
        try {
            $sql = "SELECT * FROM user_details WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($email));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result) {
                $passwordInDatabase = $result["wachtwoord"];
                $rol = $result["rol"];
                if(password_verify($password,$passwordInDatabase)){
                    $_SESSION["ID"] = session_id();
                    $_SESSION["USER_ID"] = $result["ID"];
                    $_SESSION["USER_NAME"] = $result["voornaam"];
                    $_SESSION["E-MAIL"] = $result["email"];
                    $_SESSION["STATUS"] = "ACTIEF";
                    $_SESSION["ROL"] = $rol;

                    if($rol == 0){
                        echo "<script>location.href='index.php?page=booking'</script>";
                    } elseif($rol == 1){
                        echo "<script>location.href='index.php?page=albums';</script>";
                    } else {
                        $alert = "Toegang geweigerd<br>";
                    }
                } else {
                    $alert = "Probeer nogmaals in te loggen<br>";
                }
            } else {
                $alert = "Probeer nogmaals in te loggen<br>";
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
            echo "<div id='melding'>$alert</div>";
    }
?>