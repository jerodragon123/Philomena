<?php
// Deze dependencies laden we handmatig in
    use PHPMailer\PHPMailer\PHPMailer;
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';
// Deze function stuurt e-mails via Gmail
function mailing($recipientStreet, $recipientName, $subject, $message){

    $mail = new PHPMailer();

    // Verbinden met Gmail
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;

    // Identificeer jezelf bij Gmail
    $mail->Username = "test@test.com";
    $mail->Password = "test";

    // E-mail opstellen
    $mail->isHTML(true);
    $mail->SetFrom("aardappelrasper@gmail.com", "Jeroen");
    $mail->Subject = $subject;
    $mail->CharSet = 'UTF-8';
    $message = "<body style=\ 'font-family: Verdana, Verdana, Genevam, sans-serif; font-size: 14px; color: #000;\'>" . $message . "</body></html>";
    $mail->AddAddress($recipientStreet, $recipientName);
    $mail->Body = $message;

    //Stuur mail
    if($mail->Send()) {
        echo"<script>alert('Mail is verstuurd' );</script>";
    }else{
        echo"<script>alert('Kon geen mail versturen');</script>";
    }
}
?>