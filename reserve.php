<?php
class Reservation {
  // (A) PROPERTIES
  private $conn; // PDO object
  private $stmt; // SQL statement
  public $e; // Error message

  // (D) SAVE RESERVATION
  function save ($date, $slot, $name, $email, $tel, $notes="") {
    include("DBconfig.php");
    include("library/mails.php");
    $alert = "";

    // (D2) DATABASE ENTRY
    try {
      $sql = "INSERT INTO `reservations` (`res_date`, `res_slot`, `res_name`, `res_email`, `res_tel`, `res_notes`) VALUES (?,?,?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($date, $slot, $name, $email, $tel, $notes));
    } catch(PDOException $e) {
      $alert = "Kon geen reservatie maken.";
      $e->getMessage();

      }

    // (D3) EMAIL
    // @TODO - REMOVE IF YOU WANT TO MANUALLY CALL TO CONFIRM OR SOMETHING
    // OR EMAIL THIS TO A MANAGER OR SOMETHING
    $subject = "Reservatie ontvangen";
    $message = "Bedankt! We hebben uw verzoek ontvangen en we hopen u te zien op $date";
    try {
        mailing($email, "klant", $subject, $message);
        $alert = 'Mail is verstuurd.';
    } catch(PDOException $e) {
        $alert = 'Kon geen mail versturen - ' + $mail->ErrorInfo;
    }
  }
  
  // (E) GET RESERVATIONS FOR THE DAY
  function getDay ($day="") {
    // (E1) DEFAULT TO TODAY
    if ($day=="") { $day = date("Y-m-d"); }
    
    // (E2) GET ENTRIES
    $this->stmt = $this->conn->prepare(
      "SELECT * FROM `reservations` WHERE `res_date`=?"
    );
    $this->stmt->execute([$day]);
    return $this->stmt->fetchAll(PDO::FETCH_NAMED);
  }
}

// (F) DATABASE SETTINGS
// ! CHANGE THESE TO YOUR OWN !
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'test');
// define('DB_CHARSET', 'utf8');
// define('DB_USER', 'root');
// define('DB_PASSWORD', '');

// (G) NEW RESERVATION OBJECT
$_RSV = new Reservation();