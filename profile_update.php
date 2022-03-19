<?php
    if(!isset($_SESSION["ID"])&&($_SESSION["STATUS"]!="ACTIEF")){
        echo "<script> alert('U heeft geen toegang tot deze pagina.'); location.href='../index.php';</script>";
    }
    if(isset($_POST['submit'])) {
        $first_name = htmlspecialchars($_POST['voornaam']);
        $surname = htmlspecialchars($_POST['achternaam']);
        $street = htmlspecialchars($_POST['straat']);
        $zipcode = htmlspecialchars($_POST['postcode']);
        $city = htmlspecialchars($_POST['woonplaats']);
        $email = htmlspecialchars($_POST['email']);

        $query = "UPDATE user_details SET 'voornaam' = ?, 'achternaam' = ?. 'straat' = ?, 'postcode' = ?, 'woonplaats = ?, 'email' = ? WHERE 'email' = ?";
        $stmt = $conn->prepare($query);
        try {
            $stmt = $stmt->execute(array($first_name, $surname, $street, $zipcode, $city, $email, $email));
            if($stmt) {
                echo "<script>alert('Profiel is geüpdatet'); location.href='index.php?page=booking';</script>";
            }else{
                echo "<script>alert('Kon geen profiel updaten'); location.href='index.php?page=booking';</script>";
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
?>