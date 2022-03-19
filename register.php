<?php
include("register.html");
include("library/mails.php");
include("DBconfig.php");
if(isset($_POST["submit"])) {
    $alert = "";
    $first_name = htmlspecialchars($_POST['voornaam']);
    $surname = htmlspecialchars($_POST['achternaam']);
    $customer = $first_name . " " . $surname;
    $street = htmlspecialchars($_POST['straat']);
    $zipcode = htmlspecialchars($_POST['postcode']);
    $city = htmlspecialchars($_POST['woonplaats']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['wachtwoord']);
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Controleeer of e-mail al bestaat (geen dubbele adressen)
    $sql = "SELECT * FROM user_details WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($email));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result) {
        $alert = "Dit e-mailadres is al geregistreerd";
    } else {
        $sql = "INSERT INTO user_details (id, voornaam, achternaam, straat, postcode, woonplaats, email, wachtwoord, rol) values (null,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        try {
            $stmt->execute(array(
                $first_name,
                $surname,
                $street,
                $zipcode,
                $city,
                $email,
                $passwordHash,
            0)
        );
        $alert = "Nieuw account aangemaakt.";
        }catch(PDOException $e) {
            $alert = "Kon geen account aanmaken.";
            $e->getMessage();

        }
        echo "<div id='melding'>" .$alert, "</div>";
        // Bevestiging per e-mail
        $subject = "Nieuw account";
        $message = "Geachte $customer, uw account is aangemaakt.";
        mailing($email, $customer, $subject, $message);
    }
}
?>