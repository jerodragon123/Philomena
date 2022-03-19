<?php
    if(!isset($_SESSION["ID"])&&($_SESSION["STATUS"]!="ACTIEF")){
        echo "<script> alert('U heeft geen toegang tot deze pagina.'); location.href='../index.php';</script>";
    }
    try {
        $sql = "SELECT * FROM user_details WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($_SESSION["E-MAIL"] ));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $e) {
        echo $e->getMessage();
    }
?>

<div class="content">
    <form method="POST" action="index.php?page=profile_update">
        <p id="page_title">Profiel editen</p>
        <label for="voornaam">Voornaam</label>
        <input type="text" required name="voornaam" value="<?php echo $result['voornaam']; ?>"/>
        <label for="achternaam">Achternaam</label>
        <input type="text" required name="achternaam" value="<?php echo $result['achternaam']; ?>"/>
        <label for="straat">Straat</label>
        <input type="text" required name="straat" value="<?php echo $result['straat']; ?>"/>
        <label for="postcode">Postcode</label>
        <input type="text" required name="postcode" value="<?php echo $result['postcode']; ?>"/>
        <label for="woonplaats">Woonplaats</label>
        <input type="text" required name="woonplaats" value="<?php echo $result['woonplaats']; ?>"/>
        <label for="email">E-mail</label>
        <input type="email" required name="email" value="<?php echo $result['email']; ?>"/>
        <br/>
        <div class="icon_container">
            <input type="submit" class="icon" id="submit" name="submit" value="&rarr;"/>
        </div>
        <a href="index.php?page=booking">Terug</a>
    </form>
</div>