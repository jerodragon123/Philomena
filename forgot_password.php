<!DOCTYPE html>
<html lang="en">
<head>
    <title>Philomena</title>
    <link rel="stylesheet" href="css/philomena.css"/>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
    <div class="content">
        <form name="Wachtwoord vergeten" method="POST" enctype="multipart/form-data" action="">
            <p id="page_title"> Nieuw wachtwoord aanvragen</p>
            <input type="email" required name="email" placeholder="email"/>
            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div><br>
            <div class="icon_container">
                <input type="submit" class="icon" id="submit" name="submit" value="&rarr;"/>
            </div>
            <a href="/index.php?page=login">Terug</a>
        </form>
    </div>
</body>
</html>

<?php
if(isset($_POST["submit"])) {
    $alert = "";
    $email = htmlspecialchars($_POST['email']);

    // Hier genereren we een token en een timestamp
    $token = bin2hex(random_bytes(32));
    $timestamp = new DateTime("now");
    $timestamp = $timestamp->getTimestamp();
    // Hier slaan we het token voor de klant in de database op
    include('DBconfig.php');
    try {
        $sql = "UPDATE user_details SET token = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt = $stmt->execute(array($token, $email));
        if(!$stmt) {
            echo "<script>alert('Kon niet opslaan in database.'); location.href='/index.php?page=login';</script>";
        }
    }catch(PDOException $e) {
        echo $e->getMessage();
    }

    // Hier configureren we de URL van de wachtwoord resetten-pagina
    $url = sprintf("%s://%s",isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='of-f'?'https':'http',$_SERVER['HTTP_HOST']. dirname($_SERVER['PHP_SELF'])."/reset_password.php");

    // Hier voegen we het token en de timestamp aan de URL toe
    $url = $url. "?token=".$token."&timestamp=".$timestamp;

    // Hier mailen we de URL naar de klant
    include("library/mails.php");
    $subject = "Wachtwoord resetten";
    $message = "<p>Als je je wachtwoord wilt resetten klik <a href=".$url.">hier</a></p>";
    try {
        mailing($email, "klant", $subject, $message);
        $alert = 'Open je mail om verder te gaan.';
    } catch(Exception $e) {
        $alert = 'Kon geen mail versturen - ' + $mail->ErrorInfo;
    }
    echo "<div id='melding'>".$alert."</div>";
}
?>