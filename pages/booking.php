<?php
if(!isset($_SESSION["ID"])&&$_SESSION["STATUS"]!="ACTIEF"){
    echo "<script alert('U heeft geen toegang tot deze pagina.'); location.href='../index.php';</script>";
}
try {
    $sql = "SELECT * FROM user_details WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($_SESSION["E-MAIL"] ));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $alert = "";
}catch(PDOException $e) {
    echo $e->getMessage();
}

    // (A) PROCESS RESERVATION
    if (isset($_POST['date'])) {
      require "reserve.php";
      if ($_RSV->save(
        $_POST['date'], $_POST['slot'], $_POST['name'],
        $_POST['email'], $_POST['tel'], $_POST['notes'])) {
        $alert = 'Reservatie opgeslagen en mail is verstuurd';
      } else { $alert = 'Error'; }
    }
?>

    <!-- (B) RESERVATION FORM -->
    <div class="content">
        <form id="resForm" method="post" target="_self">
            <p id="page_title">Reserveren</p>
            <label for="res_name">Naam</label>
            <input type="text" required name="name" placeholder="naam"/>
            <label for="res_email">Email</label>
            <input type="email" required name="email" placeholder="bij@voorbeeld.com"/>
            <label for="res_tel">Telefoon nummer</label>
            <input type="text" required name="tel" placeholder="123456789"/>
            <label for="res_notes">Opmerkingen (optioneel)</label>
            <input type="text" name="notes" placeholder="plaats hier uw opmerking"/>
            <label>Reserveer datum</label>
            <input type="date" required id="res_date" name="date" value="<?=date("Y-m-d")?>">
            <label>Reserveer slot</label>
            <select name="slot">
                <option value="AM">AM</option>
                <option value="PM">PM</option>
            </select>
            <div class="icon_container">
                <input type="submit" class="icon" id="submit" name="submit" value="&rarr;"/>
            </div>
        </form>
    </div>